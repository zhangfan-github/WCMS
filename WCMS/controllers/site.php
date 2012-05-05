<?php
/*2011_12_8
 * 曹俊
 * 主要内容页面
 * 2011-12-19
 * Chen Xufeng ,重构 column方法
 */
class  Site extends  IController
{
	 public $layout='site';
	 public $pwkey = "1234567890"; //这里换成你discuz论坛后台管理 通行证设置的passportkey
	 public $bbsurl = "/bbs/"; //这里换成你的论坛地址
	 public $forward_url = "/";
	//获取用户需修改
	function   init()
	{
		$user = array();
		$user['user_id']  = ISafe::get('user_id');
		$user['username'] = ISafe::get('username');
		$user['head_ico'] = ISafe::get('head_ico');
		$user ['pro_id'] = ISafe::get ( 'pro_id' );
		$user ['proname'] = ISafe::get ( 'proname' );
		$this->user = $user;
	}
	
	function index()
	{
        $video_Obj = new IQuery('upload_videos');
        $video_Obj->order = "sort asc";
        $video_Obj->limit = 1;
		$this->data = $video_Obj->find();
		//分割path路径
		$base = explode(':', $this->data[0]['path']);
		//如果路径中间有http 则是普通视频
		if ($base[0]== 'http')
		{
			$this->flag = 1;
		}
		//如果路径是以upload开始
		else 
		{
			$siteConfigObj = new Config("site_config");
			$site_config   = $siteConfigObj->getInfo();
			//添加http头信息
			$this->url = $site_config['url'].$this->data[0]['path'];
			$this->flag = 0;
		}
		$this->layout = 'index';
		$this->redirect('index');
	}
	//用户登录
	function login_act()
    {
    	$login_info = IFilter::act(IReq::get('login_info','post'));
    	$password   = IFilter::act(IReq::get('password','post'));
    	$callback   = IReq::get('callback');
		$message    = '';

    	if($login_info == '')
    	{
    		$message = '请填写用户名或者邮箱';
    	}
		else if(!preg_match('|\S{6,32}|',$password))
    	{
    		$message = '密码格式不正确,请输入6-32个字符';
    	}
    	else
    	{
    		$userObj = new IModel('user as u,member as m');
    		$where   = 'u.username = "'.$login_info.'" and m.status = 1 and u.id = m.user_id';
    		$userRow = $userObj->getObj($where);
	
    		if(empty($userRow))
    		{
    			
	    		$where   = 'email = "'.$login_info.'" and m.status = 1 and u.id = m.user_id';
	    		$userRow = $userObj->getObj($where);
    		}

    		//die('#1'.var_dump($userRow).'<br />'.$password.'+'.md5($password));
    		if(empty($userRow))
    		{
    			$message = '对不起，用户不存在';
    		}
    		else
    		{
    			if($userRow['password'] != md5($password))
    			{
    				
    				$message = '密码不正确';
    			}
    			else
    			{
    				//用户私密数据
    				ISafe::set('user_id',$userRow['id']);
    				ISafe::set('username',$userRow['username']);
    				ISafe::set('head_ico',$userRow['head_ico']);

    				//更新最后一次登录时间
    				$memberObj = new IModel('member');
    				$dataArray = array(
    					'last_login' => ITime::getDateTime(),
    				);
    				$memberObj->setData($dataArray);
    				$where     = 'user_id = '.$userRow["id"];
    				$memberObj->update($where);
    				$memberRow = $memberObj->getObj($where,'exp');

    				//根据经验值分会员组
    				$groupObj = new IModel('user_group');
    				$groupRow = $groupObj->getObj($memberRow['exp'].' between minexp and maxexp ','id','discount','desc');
    				if(!empty($groupRow))
    				{
    					$dataArray = array('group_id' => $groupRow['id']);
    					$memberObj->setData($dataArray);
    					$memberObj->update('user_id = '.$userRow["id"]);
    				}

    				//==============================================================================
					//============================discuz login 整合=================================
					//==============================================================================
					//==============header到bbs=====================================================
					$passportkey = $this->pwkey;
					$discuzbbsurl = $this->bbsurl;
					$forward = $this->forward_url;
	    			//die(var_dump($forward));
	    			$cktime = 3600;
					$member = array
					(
						'cookietime'		=> $cktime,
						'time'			=> time(),
						'username'		=> $userRow['username'],
						'password'		=> $userRow['password'],
						'email'			=> $userRow['email']
					);
					$txt = $this->passport_encode($member);
					$a = $txt;
					$auth = $this->passport_encrypt($txt, $passportkey);
					ICookie::set("auth",$auth,$cktime);
									
					$verify = md5('login'.$auth.$forward.$passportkey);
					$auth=rawurlencode($auth);
					$forward=rawurlencode($forward);
					header("Location: ".$discuzbbsurl."api/passport.php?action=login&auth=$auth&forward=$forward&verify=$verify");
					//==============================================================================
    			}
    		}
    	}

    	//错误信息
    	if($message != '')
    	{
    		$this->message = $message;
    		$_GET['callback'] = $callback;
    		$this->redirect('index',false);
    	}
    }
//=============================================================
//=============以下为拷贝过来的函数=============================


	/**
	* Passport 加密函数
	*
	* @param		string		等待加密的原字串
	* @param		string		私有密匙(用于解密和加密)
	*
	* @return	string		原字串经过私有密匙加密后的结果
	*/
	function passport_encrypt($txt, $key) {
	
		// 使用随机数发生器产生 0~32000 的值并 MD5()
		srand((double)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
	
		// 变量初始化
		$ctr = 0;
		$tmp = '';
	
		// for 循环，$i 为从 0 开始，到小于 $txt 字串长度的整数
		for($i = 0; $i < strlen($txt); $i++) {
			// 如果 $ctr = $encrypt_key 的长度，则 $ctr 清零
			$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
			// $tmp 字串在末尾增加两位，其第一位内容为 $encrypt_key 的第 $ctr 位，
			// 第二位内容为 $txt 的第 $i 位与 $encrypt_key 的 $ctr 位取异或。然后 $ctr = $ctr + 1
			$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
		}
	
		// 返回结果，结果为 passport_key() 函数返回值的 base65 编码结果
		$tp = $this->passport_key($tmp, $key);
		return base64_encode($tp);
	
	}
	
	/**
	* Passport 解密函数
	*
	* @param		string		加密后的字串
	* @param		string		私有密匙(用于解密和加密)
	*
	* @return	string		字串经过私有密匙解密后的结果
	*/
	function passport_decrypt($txt, $key) {
	
		// $txt 的结果为加密后的字串经过 base64 解码，然后与私有密匙一起，
		// 经过 passport_key() 函数处理后的返回值
		$txt = passport_key(base64_decode($txt), $key);
	
		// 变量初始化
		$tmp = '';
	
		// for 循环，$i 为从 0 开始，到小于 $txt 字串长度的整数
		for ($i = 0; $i < strlen($txt); $i++) {
			// $tmp 字串在末尾增加一位，其内容为 $txt 的第 $i 位，
			// 与 $txt 的第 $i + 1 位取异或。然后 $i = $i + 1
			$tmp .= $txt[$i] ^ $txt[++$i];
		}
	
		// 返回 $tmp 的值作为结果
		return $tmp;
	
	}
	
	/**
	* Passport 密匙处理函数
	*
	* @param		string		待加密或待解密的字串
	* @param		string		私有密匙(用于解密和加密)
	*
	* @return	string		处理后的密匙
	*/
	function passport_key($txt, $encrypt_key) {
	
		// 将 $encrypt_key 赋为 $encrypt_key 经 md5() 后的值
		$encrypt_key = md5($encrypt_key);
	
		// 变量初始化
		$ctr = 0;
		$tmp = '';
	
		// for 循环，$i 为从 0 开始，到小于 $txt 字串长度的整数
		for($i = 0; $i < strlen($txt); $i++) {
			// 如果 $ctr = $encrypt_key 的长度，则 $ctr 清零
			$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
			// $tmp 字串在末尾增加一位，其内容为 $txt 的第 $i 位，
			// 与 $encrypt_key 的第 $ctr + 1 位取异或。然后 $ctr = $ctr + 1
			$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
		}
	
		// 返回 $tmp 的值作为结果
		return $tmp;
	
	}
	
	/**
	* Passport 信息(数组)编码函数
	*
	* @param		array		待编码的数组
	*
	* @return	string		数组经编码后的字串
	*/
	function passport_encode($array) {
	
		// 数组变量初始化
		$arrayenc = array();
	
		// 遍历数组 $array，其中 $key 为当前元素的下标，$val 为其对应的值
		foreach($array as $key => $val) {
			// $arrayenc 数组增加一个元素，其内容为 "$key=经过 urlencode() 后的 $val 值"
			$arrayenc[] = $key.'='.urlencode($val);
		}
	
		// 返回以 "&" 连接的 $arrayenc 的值(implode)，例如 $arrayenc = array('aa', 'bb', 'cc', 'dd')，
		// 则 implode('&', $arrayenc) 后的结果为 ”aa&bb&cc&dd"
		return implode('&', $arrayenc);
	
	}


//======================================================================
//===========================拷贝结束===================================
    //退出登录
    function logout()
    {
    	//=========================================================================
		//============================discuz logout 整合===========================
		//=========================================================================
		//$FROMURL=$_SERVER["HTTP_REFERER"]?$_SERVER["HTTP_REFERER"]:$HTTP_SERVER_VARS["HTTP_REFERER"];
		$passportkey = $this->pwkey;
		$discuzbbsurl = $this->bbsurl;
		$forward = $this->forward_url;
		$auth = ICookie::get('auth'); //这里是login完成时设置的cookie auth
		ICookie::set( "auth", "", time () - 3600 );
		$verify = md5 ( 'logout' . $auth . $forward . $passportkey );
		$auth = rawurlencode ( $auth );
		$forward = rawurlencode ( $forward );
		
		//清除登录信息
		ISafe::clear('user_id');
		ISafe::clear('username');
		ISafe::clear('head_ico');
    	ISafe::clearAll();
		ISafe::clearAll ();
		
		header ( "Location: " . $discuzbbsurl . "api/passport.php?action=logout&auth=$auth&forward=$forward&verify=$verify" );
		//=========================================================================
		//============================discuz logout 整合结束=======================
		//=========================================================================
    }

  //处理/site/column 
  //url类型： 
  // 栏目导航：site/column/id/[id value]
  // 新闻内容：site/column/id/[id value]/news_id/[news_id]
	function column()
	{		
		//栏目参数ID接口处理
		if(isset($this->col_id))//新闻页面传值$this_col_id
			$id = $this->col_id;
		else 
			$id = intval(IReq::get("id"));	
		
		if($id==999) //友情链接
		{
				$this->link();
				return;
		}

		//查询当前栏目ID号
		$tb_help = new IModel("column");
		$select_column = $tb_help->getObj("id={$id}");
		//如果id存在
		if (!empty($select_column))
		{
			//获取当前需要显示的栏目信息
			//如果当前栏目下有子栏目，则直接显示其子栏目；否则，如果当前栏目有父栏目，则显示其兄弟栏目；否则，只显示当前栏目。
			$this->columns   = Column::getSubColumn($select_column);
				
				//获取经过该栏目结点到叶子栏目的所有路径,获取其中一条路径作为新的栏目
			$where=  ' path like \'%,'.$select_column['id'].',%\'';
			$columns   = $tb_help->query($where,'id,name,path,parent_id,type,sort','path','asc');
			$min_sort = 9999;
			foreach($columns as $val) //逐个判断栏目是否存在页面内容,或是否为叶子栏目,找到一个存在页面内容的栏目后终止循环
			{
				if(Column::isLeaf($val['id'])|| Column::hasContentPage($val['id']))
				{
					
					//设置当前栏目
					if ($min_sort > $val['sort'])
					{
						$this->column = $val;
						$min_sort = $val['sort'];
					}
				}
		  }
		  
	   	//获取栏目导航，
	   	$this->naviColumn = Column::getColumn2Root($this->column);
	   	//var_dump($this->naviColumn);
	 
	   	//根据栏目类型type和其他参数，进行页面重定向，终端页面优先
	   	//参数列表
	 		$news_id = intval(IReq::get("news_id"));//新闻内容页面
			if (!empty($news_id))
			{
				$this->news_id = $news_id;
				//根据栏目类型type转发：type为 1.栏目  2.内容页面 3.列表(标题)   5.链接  6.下载 7.图片内容 8.列表（图片）
				$type = intval($this->column['type']);
				switch ($type){
					case 103: //列表类容-新闻
					case 109: //列表类容-文章
						$this->showNewsContent();
						break;
	  			case 111: //活动类型，有报名按钮
						$this->showHuodongContent();
						break;								
					default:$this->redirect('error');
						//报错
				}
			}
			else 
			{
				//根据栏目类型type转发：type为 1.栏目  2.内容页面 3.列表(标题)   5.链接  6.下载 7.图片内容 8.列表（图片）
				$type = intval($this->column['type']);
				switch ($type){
					case 102: //页面内容
					case 100: //页面内容-其他
						$this->getColumnContent();
						break;
					case 103: //列表类容-新闻
					case 109: //列表类容-文章
						$this->news_list();
						break;
					case 110: //视频
						$this->video_list();
						break;
					case 105: //栏目为链接跳转
						$this->link_redirect();
						break;
					case 106: //下载类型
					    $this->download();
						break;
					case 107: //图片类型
						$this->content_pic();
						break;
					case 108: //列表类型-图片
						$this->pic_list_content();
						break;
					case 111: //活动类型，有报名按钮
						$this->huodong_list();
						break;					
					case 104:	///产品，服务类型，包括套餐列表,详情界面
						$this->service_list();		
						break;
					case 113:	//人员类型，包括专家团队
						$this->professional();
						break;
					default:$this->redirect('error');
						//报错
				}
			}
			
		}
		else 		//报错
		{
			//重定向到error页面
			$this->redirect('error');
		}
	}

  //栏目链接URL重定向
  function link_redirect()
  {
   	
  	$content_news = new IModel('column_links');
		$where = "column_id=".$this->column['id'];
		$this->data = $content_news->getObj($where);
		//获得数据
		//页面URL重定向	
		//$this->redirect($this->data['linkurl'],false);
		//重定向浏览器
		header("Location: ".$this->data['linkurl']);
		//确保重定向后，后续代码不会被执行
		exit;
  }
    //author:caojun:2012-03-22 获取指定日期所在星期的开始时间与结束时间  
 	function getWeekRange($date)
 	{  
     $ret=array();  
     $timestamp=strtotime($date);  
     $w=strftime('%u',$timestamp);  
     $ret['sdate']=date('Y-m-d',$timestamp-($w-1)*86400);  
     $ret['edate']=date('Y-m-d',$timestamp+(7-$w)*86400);  
     return $ret;  
 	} 
	function get_pre_nex($date)
	{
		$ret=array();  
		$timestamp=strtotime($date);  
		$w=strftime('%u',$timestamp);  
		$ret['s']=date('Y-m-d',$timestamp-($w)*86400);  
		$ret['e']=date('Y-m-d',$timestamp+(8-$w)*86400);  
		return $ret;  
	}
  	function getWeekDate($date)
	{
		$time = strtotime($date);
		$w=strftime('%u',$time); 
		return (int)$w;
	}
   /*文章内容*/
	function getColumnContent()
	{	
		if($this->column['name']=="在线咨询")
		{
			//caojun:2012-03-22
			$getdate= IFilter::act(IReq::get('date'));
			if($getdate == null ||empty($getdate))
			{
				date_default_timezone_set("PRC");
				$time = date("Y-m-d");
			}
			else
			{
				$time =strval($getdate);
			}
			$timearry =$this-> getWeekRange($time);
			$newQuery = new IQuery('professional as a');
			$newQuery->fields = "professional_group.name as group_name,a.name,c.time,a.id";
			$newQuery->join = "inner join professional_group as professional_group on a.group = professional_group.id inner join pro_worktime as c on a.id = c.pro_id";
			$newQuery->order = "a.group,a.name,c.time";
			$newQuery->where = "c.time between '" . $timearry['sdate'] ."' and '" .$timearry['edate']."'";
			
			$showdata =$newQuery->find();
			
			foreach($showdata as $key => $temp)
			{
				$showdata[$key]['time']= $this->getWeekDate($showdata[$key]['time']);	
			}
			$this->showdata= $showdata ;
			
			$count = array();
			//对数量进行查询,初始化
			if(!empty($this->showdata))
			{
				$all_num = 1;
				$old_group =$this->showdata[0]['group_name'];
				$old_name =$this->showdata[0]['name'];		
				foreach($this->showdata as $key => $temp)
				{
					if($temp['group_name'] != $old_group )
					{
						$count[] = $all_num;
						$all_num = 1;
						$old_group = $temp['group_name'];
						$old_name = $temp['name'];
					}
					else
					{
						if($temp['name']!= $old_name)
						{
							$all_num = $all_num+1;
							$old_name = $temp['name'];
						}
					}
				}
				
				if($all_num != 0)
				{
					$count[] = $all_num;
				}
			}
			$this->count_num =$count;
			$this->date=$this->get_pre_nex($time);
			//////////////////////////////////////
			
		    $proObj = new IQuery('pro_worktime');
			$today = strval(date("Y-m-d"));
			$proObj->where = "time='".$today."'";
			$this->pro_workdata = $proObj->find();
			$this->redirect('online_qa',false);
		}
		else if($this->column['name']=='合作机构')
		{
			$query = new IQuery('operator_links');
			$query->fields = "*";
			$query->pagesize=5;
			$query->page = isset ( $_GET['page'])?$_GET['page']:1;
			$this->query = $query;
			$this->showdata= $query->find();
			$this->redirect('operator_list',false);

		}
		else 
		{
			$content_news = new IModel('content');
			$where = "column_id=".$this->column['id'];
			$this->showdata = $content_news->getObj($where);
			//获得数据
			$this->redirect('content_news',false);
		}

	}
	
	/*图片类型栏目*/
	/************2012.04.16***************
	Author:zhangfan
	************************************/
	function content_pic() {
		//相册id
		$pg_id = intval(IReq::get('pg_id'));
		if(empty($pg_id))//相册列表
		{
			//指定栏目下的相册
			$pgObj = new IQuery('pic_group');
			$pgObj->page = isset ( $_GET['page'])?$_GET['page']:1;
			$pgObj->pagesize = 6;
			$pgObj->where = 'column_id ='.$this->column['id'];
			$pgObj->order = 'sort asc';
			$contentRow = $pgObj->find();
			//分页
			$this->query = $pgObj;
			$tempRow= array();
			
			//计算各个相册中的照片数量
			$pObj = new IQuery('source');
			foreach ($contentRow as $val)
			{
				$pObj->where = 'img_group_id='.$val['id'];
				$pObj->fields = 'count(*) as count';
				$count = $pObj->find();
				if($count[0]['count'] > 0)
				{
					$val['count'] = $count[0]['count'];
					$tempRow[] = $val ;
				}
			}
			if(!isset($this->contentRow))
			{
				$this->contentRow= $tempRow;
				$this->redirect('pic_groups',false);
			}
			else $this->redirect('error');	
		}
		else{//相册详情
			$pObj = new IQuery('source');
			$pObj->where = 'img_group_id='.$pg_id;
			if(!isset($this->contentRow))
			{
				$this->contentRow= $pObj->find();
				$this->redirect('pictures',false);
			}
			else $this->redirect('error');	
		}
	}
	//专家判断
	function isProfessionalType($column_name)
	{
	  $professional_type = 0;
		$userObj = new IModel('professional_group');
    $where   = " name ='".$column_name."' ";
    $userRow = $userObj->getObj($where);
		if(!empty($userRow))
		{
			$professional_type = $userRow['id'];
		}
	  return $professional_type;
	}
	
	/*标题列表类型*/
  function getListContent()
	{
		switch($this->column['name'])
		{	
			case '新闻报道':
			case '媒体扫描': 
				$this->news_list();
			    break;
			case '新闻视频':	
				$this->video_list();
				break;
			default: 
				$this->news_list();
			    break;
		}
	}
	
	/*友情链接*/
	function link()
	{
		$query1 = new IQuery ( "links" );
		$query1->where = "photo is not null and photo <> ''";	
		$query1->fields = "*";
		$query1->order = "`order` asc";
		$query1->page = isset ( $_GET['page'])?$_GET['page']:1;
		$Row1 =  $query1->find();
		
		$query2 = new IQuery ( "links" );
		$query2->where = "photo is null or photo = ''";	
		$query2->fields = "*";
		$query2->order = "`order` asc";
		$query2->page = isset ( $_GET['page'])?$_GET['page']:1;
		$Row2 =  $query2->find();
		
		$this->pic_Row = $Row1;
		$this->txt_Row = $Row2;
		$this->layout = 'site_mini';
		$this->redirect('link');
	}
	
	/*图片列表类型*/
    function pic_list_content()
	{
		switch($this->column['name'])
		{
			case '新闻报道':
			case '视频新闻':	
			case '媒体扫描':	
				 $this->news_pic_list();
			     break;
			default:break;
		}
	}
	/*专家详情*/
	 function professional_content()
	{
		$zhuanjia_id= intval(IReq::get('prof_id'));
		if (!empty($zhuanjia_id))
		{
			$pro_Obj = new IModel('professional');
			$where = 'id ='.$zhuanjia_id;
			$this->pro_data = $pro_Obj->getObj($where);
			$this->redirect('professional_content',false);
		}
	}
	/*新闻内容*/
	function showNewsContent()
	{
		$this->column_id = IFilter::act(IReq::get('id'),'int');
	  $this->article_id = IFilter::act(IReq::get('news_id'),'int');
		if($this->article_id == '')
		{
			$this->redirect('error');
		}
		else
		{
			$articleObj = new IModel('article');
			$this->articleRow = $articleObj->getObj('id = '.$this->article_id);
			if(empty($this->articleRow))
			{
				$this->redirect('error');
			}
			$this->redirect('news_content',false);
		}
	}

	/*活动内容*/
	function showHuodongContent()
	{
		$this->column_id = IFilter::act(IReq::get('id'),'int');
	  $this->huodong_id = IFilter::act(IReq::get('news_id'),'int');
		if($this->huodong_id == '')
		{
			$this->redirect('error');
		}
		else
		{
			$huodongObj = new IModel('huodong');
			$this->huodongRow = $huodongObj->getObj('id = '.$this->huodong_id);
			if(empty($this->huodongRow))
			{
				$this->redirect('error');
			}
			$this->redirect('huodong_content',false);
		}
	}	
	
	function new_search()
	{
		$this->words =IFilter::act( IReq::get('textfield'));
		$this->column();
	}
	/*新闻列表(标题)*/
    function news_list()
	{
		if(!empty($this->words))
		{
			$words = $this->words;	
		}
		$query = new IQuery ( "article" );
		if ($words) {
			$query->where = "visiblity = 1  and (title like '%" . $words . "%' or content like '%" . $words . "%')";
		}
		else 
		{
			$query->where = "visiblity = 1 and category_id = ".$this->column['id'];
			
		}
		$query->fields = "*";
		$query->order = "create_time desc";
		$query->page = isset ( $_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$artSearchRow =  $query->find();
		$this->artSearchRow = $artSearchRow;
		$this->redirect('news_list',false);
		
	}
	
	  //活动列表页
	function huodong_list()
	  {	
		$huodong_id = intval(IReq::get('huodong_id'));
		if(empty($huodong_id))
		{
			$query = new IQuery ( "huodong" );
			$query->where = "category_id = ".$this->column['id'];
			$query->fields = "*";
			$query->order = "publish_time desc";
			$query->page = isset ( $_GET['page'])?$_GET['page']:1;
			$this->query = $query;
			$artSearchRow =  $query->find();
			$this->artSearchRow = $artSearchRow;
			$this->redirect('huodong_list',false);
		}
		else
		{
			$this->huodong_id = $huodong_id;
			if($this->huodong_id == '')
			{
				$this->redirect('error');
			}
			else
			{
				$huodongObj = new IModel('huodong');
				$huodongRow = $huodongObj->getObj('id = '.$this->huodong_id);

				if(empty($huodongRow))
				{
					$this->redirect('error');
				}
				//根据时间与人数判断是否结束报名
				if($huodongRow['huodong_status']=='0')
				{
					//计算时间
					if (strtotime($huodongRow['end_time'])+86400 < time())
					{
						$huodongRow['huodong_status']='1';
					}
					else 
					{	//计算人数
						$activ_Obj = new IModel('activity_reg');
						$sql_where = "activity_id = ". $huodong_id ." and state = 1";
						$num = $activ_Obj->query($sql_where,"*");
						 if (count($num) >= intval($huodongRow['huodong_num'] ))
						 {
							$huodongRow['huodong_status'] = '1';
						 }			 
					}

				}
				$this->huodongRow=$huodongRow;
				$this->redirect('huodong_content',false);
			}
		}
	  }
  
	/*新闻列表（图片)*/
    function news_pic_list(){
		$query = new IQuery ( "article" );
		$query->where = "visiblity = 1 and category_id = ".$this->column['id'];	
		$query->fields = "*";
		$query->order = "create_time desc";
		$query->page = isset ( $_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$Row =  $query->find();
		$this->Row = $Row;
		$this->redirect('news_pic_list',false);
	}
	/*下载列表*/
	function download(){
		$download = new IQuery('download');
		$download->fields = "*";
		$download->where = "category_id=".$this->column['id'];
		$download->order = "create_time desc";
		$download->page = isset ( $_GET['page'])?$_GET['page']:1;
		$this->query = $download;
	    $downloadRow =  $download->find();
	    $this->Row = $downloadRow;
		$this->redirect('download',false);		
	}
	/*博士后文章列表*/
	function  bsh_list()
	{
		$query = new IQuery('bsh');
		$query->fields = "*";
		$query->order = "time desc";
		$query->page = isset ( $_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$Row =  $query->find();
		$this->bsh_Row = $Row;
		$this->redirect('bsh_list',false); 
	}
	/*博士后文章内容*/
    function bsh_content()
	{
		$this->column_id = IFilter::act(IReq::get('id'),'int');
	    $this->content_id = IFilter::act(IReq::get('content_id'),'int');
		if($this->content_id == '')
		{
			$this->redirect('error');
		}
		else
		{
			$articleObj       = new IModel('bsh');
			$this->bsh_Row = $articleObj->getObj('id = '.$this->content_id);
			if(empty($this->bsh_Row))
			{
				$this->redirect('error');
			}
			$this->redirect('bsh_content',false);
		}
	}
	/*博士后工作站附件下载*/
	 function bsh_download()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
    	$fileObj = new IModel('bsh');
    	$where = 'id = '.$id;
    	if(empty($id))
    	{
    		die('<h1 align="center">Access Error!</h1>');
    	}
    	else 
    	{
    		$file_row = $fileObj->getObj($where);
    		//print(var_dump($file_row));
    		if(!empty($file_row))
    		{
    			
    			if($file_row['access'] == 0)
    			{
	    			if(!empty($file_row['linkurl']))
	    			{	
	    				die('<script language="javascript">location.replace("'.$file_row['linkurl'].
	    				'");</script>');
	    			}
	    			else 
	    			{
	    					$file_path = $file_row['file'];
	    					$file = fopen($file_path,'r') or exit("Unable to find file!>><a href=''>Back>></a>");
	    					Header("Content-type:application/octet-stream");
	    					Header("Accept-Ranges:bytes");
	    					Header("Accept-Length:".filesize($file_path));
	    					Header("Content-Disposition:attachment;filename=".basename($file_path));
	    					echo fread($file,filesize($file_path));
	    					fclose($file);
	    			}
    			}
    			else 
	    		{
    					$user_id = ISafe::get('user_id');
    					$user_name = ISafe::get('username');
    					if(empty($user_id) || empty($user_name))
    					{
    						$message = "该文件只有注册用户才能下载，请登录！";
    						$this->redirect('/simple/login',false);
    						Util::showMessage($message);
    					}
    					else 
    					{
    						if(!empty($file_row['linkurl']))
			    			{	
			    				die('<script language="javascript">location.replace("'.$file_row['linkurl'].
			    				'");</script>');
			    			}
			    			else 
			    			{
			    					$file_path = $file_row['file'];
		    						//print($file_path);
			    					$file = fopen($file_path,'r') or exit("Unable to find file!>><a href=''>Back>></a>");
			    					Header("Content-type:application/octet-stream");
			    					Header("Accept-Ranges:bytes");
			    					Header("Accept-Length:".filesize($file_path));
			    					Header("Content-Disposition:attachment;filename=".basename($file_path));
			    					echo fread($file,filesize($file_path));
			    					fclose($file);
			    			
			    			
			    			}
    					}
    				}
    		}
    		else 
    		{
    			die("Unable to find file!>><a href=''>Back>></a>");
    		}
    	}
    }
	/******************************************************************************/
	/**********曹俊***********/
	//人才招聘
	function position_list()
	{
		$poss_id = intval(IReq::get("poss_id"));
		$pose_id = intval(IReq::get("pose_id"));
		//存在poss_id
		//指向position_show
		if (!empty($poss_id))
		{
			$this->poss_id = $poss_id;
			$this->position_show();
		}
		//pose_id
		//指向position_edit
		else if (!empty($pose_id))
		{
			$this->pose_id =$pose_id;
			$this->position_edit();	
		}
		//都不存在pos_id
		//显示列表
		else 
		{
			$this->redirect("position_list",false);
		}
	}
	
	//招聘详细信息页面
	function position_show()
	{
		//查询要显示的信息
		$position_show= new IModel('position');
		$this->showdata = $position_show->getObj("id=".$this->poss_id);
		extract($this->showdata);
		//替换对应的数据
		switch ($this->showdata['need_sex'])
		{
			case '0':
			
				$this->showdata_sex="男";
				break;
			case '1':

				$this->showdata_sex='女';
				break;
			case '2':

				$this->showdata_sex='不限';
				break;
		}
		$select = new IModel('select');

		$select_data0 = $select->getObj("id= ".$this->showdata['department']);
		$this->department = $select_data0['name'];
		$select_data1 = $select->getObj("id= ".$this->showdata['position_type']);
		$this->position_type = $select_data1['name'];
		$select_data3 = $select->getObj("id= ".$this->showdata['education']);
		$this->education = $select_data3['name'];

		
		//对照数据库选项表
		$this->redirect('position_show',false);
	}
	function position_edit()
	{

		$position_edit = new IModel('position');
		$where = 'id = '.$this->pose_id;
		$this->data = $position_edit->getObj($where);
		$this->redirect('position_edit',false);
		
	}
	
	function  position_add()
	{
		$positionObj=new IModel('position_apply');
		$file = null; //文件地址
		//图片上传
		if(isset($_FILES['positionfile']['name']) && $_FILES['positionfile']['name']!='')
		{
			$fileObj = new FileUpload();
			$file    = $fileObj->run();
		}
		$dataArray = array(
			'NAME'    => IFilter::act( IReq::get('name','post') ,'string' ),
			'GENDER'    => IFilter::act( IReq::get('sex','post') ,'int' ),
			'POSITION_ID'    => IFilter::act(IReq::get('id'),'int'),
			'OTHER_POSITION'    => IFilter::act( IReq::get('otherjob','post') ,'string' ),
			'PHONENO'    => IFilter::act( IReq::get('phone','post') ,'string' ),
			'TELEPHONE'    => IFilter::act( IReq::get('telephone','post') ,'string' ),
		  	'EMAIL' => IFilter::act(IReq::get('eamil','post'),'string'),
			'REMARK' => IFilter::act( IReq::get('remark','post') ,'string' ),
		);
		if($file!=null) $dataArray['POSITION_FILE'] = $file['positionfile']['fileSrc'];
		$dataArray['APPLY_TIME'] = date("Y-m-d");
		$positionObj->setData($dataArray);
		$positionObj->add();
		$this->col_id  = IReq::get('col_id','post');
		$this->column();
	}
	
	/************end***************/
	
	/****************曹俊*******************/
	function  video_list()
	{
		$video_id = intval(IReq::get("video_id"));
		$category_id = $this->column['id'];
		if(empty($video_id))
		{
			$video_Obj = new IQuery('upload_videos');
			$video_Obj->fields="*";
			$video_Obj->where = " category_id =".$category_id;
			$video_Obj->page= isset ( $_GET['page'])?$_GET['page']:1;
			$video_Obj->order='sort asc';
			$this->query = $video_Obj;
			$this->video_SearchRow =  $video_Obj->find();
			$this->redirect('video_list',false);
		}
		else 
		{
			$video_Obj = new IModel('upload_videos');
			$where = 'id ='.$video_id;
			$this->data = $video_Obj->getObj($where);
			//分割path路径
			$base = explode(':', $this->data['path']);
			//如果路径中间有http 则是普通视频
			if ($base[0]== 'http')
			{
				$this->flag = 1;
				$this->redirect('video_content',false);
			}
			//如果路径是以upload开始
			else 
			{
				$siteConfigObj = new Config("site_config");
				$site_config   = $siteConfigObj->getInfo();
				//添加http头信息
				$this->url = $site_config['url'].$this->data['path'];
				$this->flag = 0;
				$this->redirect('video_content',false);
			}
		}
	}

	/***************************************/
	//商品内容详细页
	function goods_content()
	{
		$goods_id= intval(IReq::get('pro_id'));
		if (!empty($goods_id))
		{
			$goods_Obj = new IModel('goods');
			$where = 'id ='.$goods_id;
			$this->data = $goods_Obj->getObj($where);
			$this->redirect('goods_content',false);
		}
	}
	
	
	//服务型列表页
	function  service_list()
	{
		if ($this->column['id']=='83')
		{	
			//根据serv_id判断
			$serv_id = intval(IReq::get('serv_id'));
			if(!empty($serv_id))
			{

				$service_Obj=new IModel('service');
				$where = 'id ='.$serv_id;
				$showdata= $service_Obj->getObj($where);
				if($showdata['state']=='1')
				{
					$activ_Obj = new IModel('activity_reg');
					$sql_where = "services_id =".$showdata['id']." and state = 1";
					$num = $activ_Obj->query($sql_where,"*");
					if (count($num) >= $showdata['num'] )
					{
						$showdata['state']='0';
					}	
				}
				$this->showdata =$showdata;
				$this->redirect('service_info',false);
			}
			else 
			{
				$query = new IQuery ( "service_cat" );
				$query->fields = "*";
				$query->order = "sort asc";
				$query->page = isset ( $_GET['page'])?$_GET['page']:1;
				$query->pagesize = 6;
				$this->query = $query;
				$servicecatRow =  $query->find();
				$this->servicecatRow = $servicecatRow;
				$this->redirect('service_list',false);
			}
		}
		else if($this->column['id']=='86')
		{
			//根据servpack_id
			$servpack_id = intval(IReq::get('servpack_id'));
			if(!empty($servpack_id))
			{
				$service_Obj=new IModel('service_package');
				$where = 'id ='.$servpack_id;
				$showdata= $service_Obj->getObj($where);
				if($showdata['state']=='1')
				{
					$activ_Obj = new IModel('activity_reg');
					$sql_where = "service_package_id =".$showdata['id']." and state = 1";
					$num = $activ_Obj->query($sql_where,"*");
					if (count($num) >= $showdata['num'] )
					{
						$showdata['state']='0';
					}	
				}
				$this->showdata = $showdata;
				
				//套餐详细列表
				$temp_Obj = new IModel("service");
				$tempstr=substr($showdata['services'], 0,strlen($showdata['services'])-1);
				$sql_where = "id in (".$tempstr.")";
				$seviceRow = $temp_Obj->query($sql_where,"*");			
				$this->seviceRow = $seviceRow;
				$this->redirect('servicepack_info',false);
			}
			else 
			{
				$temp_Obj = new IModel("service");
				$query = new IQuery ( "service_package" );
				$query->fields = "*";
				$query->order = "sort asc";
				$query->page = isset ( $_GET['page'])?$_GET['page']:1;
				$query->pagesize = 5;
				$this->query = $query;
				$seviceRow =  $query->find();
				$this->seviceRow = $seviceRow;
				$showdata =array();
				foreach ($this->seviceRow as $value)
				{
					if($value['state']=='1')
					{
						$activ_Obj = new IModel('activity_reg');
						$sql_where = "service_package_id =".$value['id']." and state = 1";
						$num = $activ_Obj->query($sql_where,"*");
						if (count($num) >= $value['num'] )
						{
							$value['state']='0';
						}	
					}
				}
				foreach ($seviceRow as $value)
				{
					$tempstr=substr($value['services'], 0,strlen($value['services'])-1);
					$sql_where = "id in (".$tempstr.")";
					$temp = $temp_Obj->query($sql_where,"*");
					$showdata[]=$temp;				
				}
				$this->showdataRow = $showdata;
				$this->redirect('servicepackage_list',false);
			}

		}
		else if($this->column['id']=='72')
		{//商品介绍
			$pro_id = intval(IReq::get('pro_id'));
			$cat_id = intval(IReq::get('cat_id'));
			//如果没有商品名id
			if(empty($pro_id))
			{
				if(!empty($cat_id))
				{
					$query = new IQuery ( "goods" );
					$query->fields = "*";
					$query->page = isset ( $_GET['page'])?$_GET['page']:1;
					$query->pagesize = 6;
					$query->where = 'cat_id='.$cat_id;
					$this->query = $query;
					$productRow =  $query->find();
					$this->productRow = $productRow;
					$this->redirect("goods_list",false);
				}
				else{
					$query = new IQuery ( "goods_cat" );
					$query->fields = "*";
					//$query->page = isset ( $_GET['page'])?$_GET['page']:1;
					//$query->pagesize = 3;
					$this->query = $query;
					$catRow =  $query->find();
					$this->catRow = $catRow;
					$this->redirect("content_pic",false);
				}
			}
			else 
			{
				//商品详细页
				$this->goods_content();
			}
		}
		else if($this->column['id']=='94')
		{
			//根据serv_id判断
			$dish_id = intval(IReq::get('dish_id'));
			if(!empty($dish_id))
			{

				$dish_Obj=new IModel('dish');
				$where = 'id ='.$dish_id;
				$showdata= $dish_Obj->getObj($where);
				$this->showdata =$showdata;
				$this->redirect('dish_info',false);
			}
			else 
			{
				$query = new IQuery ( "dish_type" );
				$query->fields = "*";
				$query->order = "sort asc";
				$query->page = isset ( $_GET['page'])?$_GET['page']:1;
				$query->pagesize = 6;
				$this->query = $query;
				$DishTypeRow =  $query->find();
				$this->DishTypeRow = $DishTypeRow;
				$this->redirect('dish_list',false);
			}
		}
	}
	function  free_reg()
	{
		$u_id = ISafe::get('user_id');
		if($u_id != "")
		{
			$obj1 = new IModel('user');
			$obj2 = new IModel('member');
			$where1= "id=".$u_id;
			$where2= "user_id=".$u_id;
			$_mail = $obj1->getObj($where1,"email");
			$this->email = $_mail['email'];
			$_mobile = $obj2->getObj($where2,"mobile");
			$this->mobile = $_mobile['mobile'];
		}
		$id = intval(IReq::get("id"));
		switch($id)
		{
			case 83:
				$item_id = intval(IReq::get("serv_id"));
				$itemObj = new IModel('service');
				$where = "id=".$item_id;
				$tl = $itemObj->getObj($where,"name");
				$title = $tl['name'];
				break;
			case 86:
				$item_id = intval(IReq::get("servpack_id"));
				$itemObj = new IModel('service_package');
				$where = "id=".$item_id;
				$tl = $itemObj->getObj($where,"name");
				$title = $tl['name'];
				break;
			case 76:
				$item_id = intval(IReq::get("huodong_id"));
				$itemObj = new IModel('huodong');
				$where = "id=".$item_id;
				$tl = $itemObj->getObj($where,"huodong");
				$title = $tl['huodong'];
				break;
			default: 
				$item_id = -1;break;
		}
		
		if($item_id != -1)
		{
			$this->p_id = $id;
			$this->s_id = $item_id;
			$this->title = $title;
			$this->layout = 'site_mini';
			$this->redirect('free_reg');
		}
		else $this->redirect('error');
	}
	function  free_reg_act()
	{
		$this->p_id = intval(IReq::get("it_pid"));
		$this->s_id = intval(IReq::get("it_sid"));
		$item_name = IFilter::act(IReq::get("it_name"));
		$this->title = $item_name;
		$user_id = IFilter::act( IReq::get('it_uid'));
	    switch($this->p_id)
		{
			case 83:
				$act_ser = 'services_id';
				break;
			case 86:
				$act_ser = 'service_package_id';
				break;
			case 76:
				$act_ser = 'activity_id';
				break;
		}
	    
		if(!empty($user_id))
		$data = array(
				'name'             => IFilter::act( IReq::get('it_uname'),'string'),
				'user_id'		   => $user_id,
				'activity_name'    => $item_name,
				'yun_zhou'         => IFilter::act( IReq::get('it_yunzhou') ),
				'phone'            => IReq::get('it_tel'),
				'email'            => IFilter::act( IReq::get('it_email') ),
				'form_time'		   => date("Y-m-d H:i:s"),
				$act_ser           => $this->s_id
		);
		else 
		$data = array(
				'name'             => IFilter::act( IReq::get('it_uname'),'string'),
				'activity_name'    => $item_name,
				'yun_zhou'         => IFilter::act( IReq::get('it_yunzhou') ),
				'phone'            => IReq::get('it_tel'),
				'email'            => IFilter::act( IReq::get('it_email') ),
				'form_time'		   => date("Y-m-d H:i:s"),
				$act_ser           => $this->s_id
		);
		if($data['name']=="" || $data['yun_zhou']=="" || $data['phone']=="" || $data['email']=="")
		{
			echo "请输入完整信息";
		}
		else if(IValidate::mobi($data['phone'])==false && IValidate::phone($data['phone'])==false)
		{
			echo "手机号码格式错误";
		}
		else if(IValidate::email($data['email'])==false){
			echo "邮箱格式错误";
		}
		else {
	    	$obj = new IModel('activity_reg');
	    	$obj->setData($data);
	    	$is_success = $obj->add();
	    	
		    if($is_success)
		    {
		    	echo "1";
		    }
			else {
				echo "0";
			}
		}
	}
	function  yuding()
	{
		$u_id = ISafe::get('user_id');
		if($u_id != "")
		{
			$obj1 = new IModel('user');
			$obj2 = new IModel('member');
			$where1= "id=".$u_id;
			$where2= "user_id=".$u_id;
			$_mail = $obj1->getObj($where1,"email");
			$this->email = $_mail['email'];
			$_mobile = $obj2->getObj($where2,"mobile");
			$this->mobile = $_mobile['mobile'];
		}
		$id = intval(IReq::get("id"));
		switch($id)
		{
			case 83:
				$item_id = intval(IReq::get("serv_id"));
				$itemObj = new IModel('service');
				$where = "id=".$item_id;
				$tl = $itemObj->getObj($where,"name");
				$title = $tl['name'];
				break;
			case 86:
				$item_id = intval(IReq::get("servpack_id"));
				$itemObj = new IModel('service_package');
				$where = "id=".$item_id;
				$tl = $itemObj->getObj($where,"name");
				$title = $tl['name'];
				break;
			default: 
				$item_id = -1;break;
		}
		
		if($item_id != -1)
		{
			$this->p_id = $id;
			$this->s_id = $item_id;
			$this->title = $title;
			$this->layout = 'site_mini';
			$this->redirect('yuding');
		}
		else $this->redirect('error');
	}
	function  yuding_act()
	{
		$this->p_id = intval(IReq::get("it_pid"));
		$this->s_id = intval(IReq::get("it_sid"));
		$item_name = IFilter::act(IReq::get("it_name"));
		$this->title = $item_name;
		$user_id = IFilter::act( IReq::get('it_uid'));
		
	    switch($this->p_id)
		{
			case 83:
				$act_ser = 'service_id';
				break;
			case 86:
				$act_ser = 'service_package_id';
				break;
		}
	    if(!empty($user_id))
		$data = array(
				'name'             => IFilter::act( IReq::get('it_uname'),'string'),
				'user_id'		   => $user_id,
				'service_name'     => $item_name,
				'yun_zhou'         => IFilter::act( IReq::get('it_yunzhou') ),
				'phone'            => IReq::get('it_tel'),
				'email'            => IFilter::act( IReq::get('it_email') ),
				'form_time'		   => date("Y-m-d H:i:s"),
				$act_ser           => $this->s_id
		);
		else 
		$data = array(
				'name'             => IFilter::act( IReq::get('it_uname'),'string'),
				'service_name'     => $item_name,
				'yun_zhou'         => IFilter::act( IReq::get('it_yunzhou') ),
				'phone'            => IReq::get('it_tel'),
				'email'            => IFilter::act( IReq::get('it_email') ),
				'form_time'		   => date("Y-m-d H:i:s"),
				$act_ser           => $this->s_id
		);
		if($data['name']=="" || $data['yun_zhou']=="" || $data['phone']=="" || $data['email']=="")
		{
			echo "请输入完整信息";
		}
		else if(IValidate::mobi($data['phone'])==false && IValidate::phone($data['phone'])==false)	
		{
			echo "手机号码格式错误";
		}
		else if(IValidate::email($data['email'])==false){
			echo "邮箱格式错误";
		}
		else {
			$obj = new IModel('yuding');
			$obj->setData($data);
			$is_success = $obj->add();
			
			if($is_success)
			{
				echo "1";
			}
			else {
				echo "0";
			}
		}
	}
	function professional()
	{
		$professional_type = $this->isProfessionalType($this->column['name']);
		if($professional_type > 0 )
		{//专家介绍
			$prof_id = intval(IReq::get('prof_id'));
		  if(empty($prof_id))
			{
				$exper_group = new IModel('exp_group');
				$pro_ids = $exper_group->query("group_id=".$professional_type);
				$group="";
				foreach($pro_ids as $key=>$val)
				{
					$group = $group.$val['exper_id'].',';
				}
				$group=substr($group, 0,strlen($group)-1);
				if(!empty($group))
				{
					$query = new IQuery ( "professional" );
					$query->fields = "*";
					$query->where = " `id` in(".$group.") and `state` = 1";
					$query->order = 'sort asc';
					$query->page = isset ( $_GET['page'])?$_GET['page']:1;
					$query->pagesize=5;
					$this->query = $query;
					$pictureRow =  $query->find();
					$this->proRow = $pictureRow;
					$this->c_id = $this->column['id'];
					$this->redirect("professional_list",false);
				}
				else
				echo "该组下没有专家！";
			}
			else 
			{
				//专家详细介绍
				$this->professional_content();
			}
		}
	}
}