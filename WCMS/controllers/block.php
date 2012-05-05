<?php
class Block extends IController
{
	public $layout='';
	protected $checkRight  = array('list_controller','list_action');

	/**
	 * @brief 图片上传的方法
	 */
		function img_upload()
	{
		//获取图片来源栏目的类型
		$column_type = intval(IReq::get('column_type'));
		
		//获得配置文件中的数据
		$config      = new Config("site_config");
		$config_info = $config->getInfo();

		$list_thumb_width  = isset($config_info['list_thumb_width'])  ? $config_info['list_thumb_width']  : 175;
	 	$list_thumb_height = isset($config_info['list_thumb_height']) ? $config_info['list_thumb_height'] : 175;
	 	$show_thumb_width  = isset($config_info['show_thumb_width'])  ? $config_info['show_thumb_width']  : 85;
		$show_thumb_height = isset($config_info['show_thumb_height']) ? $config_info['show_thumb_height'] : 85;

	 	//调用文件上传类
		$photoObj = new PhotoUpload();
		if(empty($column_type))//一般栏目上传图片
		{
			$photoObj->setThumb($show_thumb_width,$show_thumb_height,'show');
			$photoObj->setThumb($list_thumb_width,$list_thumb_height,'list');
		}
		else {//图片类型栏目上传图片
			$photoObj->setThumb(126,75,'thumb_show');
			$photoObj->setThumb(500,300,'thumb_list');
		}
		$photo    = $photoObj->run();
		//判断上传是否成功，如果float=1则成功
		if($photo['Filedata']['flag']==1)
		{
			if(empty($column_type))
			{
				$list = $photo['Filedata']['thumb']['list'];
				$list = strrchr($list,'/');
				$id = substr($list,1,strpos($list,'_')-1);
				$show = $photo['Filedata']['thumb']['show'];
			}
			else{
				$list = $photo['Filedata']['thumb']['thumb_list'];
				$list = strrchr($list,'/');
				$id = substr($list,1,strpos($list,'_')-1);
				$show = $photo['Filedata']['thumb']['thumb_show'];
			}
			$img = $photo['Filedata']['img'];
			echo IUrl::creatUrl().$show.'|'.$show.'|'.$img.'|'.$id.'|'.$photo['Filedata']['thumb']['list'].'|'.$photo['Filedata']['source_id'];
		}
		else
		{
			echo '0';
		}
	}
    function file_upload()
	{
	 	//调用文件上传类
		$fileObj = new FileUpload();
		$file = $fileObj->run();
		//判断上传是否成功，如果float=1则成功
		if($file['Filedata']['flag']==1)
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	/**
	 * @brief 文件上传的方法
	 */
	function download_file_upload()
	{
	
	 	//调用文件上传类
		$fileObj = new FileUpload();
		$file    = $fileObj->run();
		//判断上传是否成功，如果float=1则成功
		if($file['Filedata']['flag']==1)
		{
			/*
			$lit = $file['Filedata']['thumb']['list'];
			$list = strrchr($list,'/');
			$id = substr($list,1,strpos($list,'_')-1);
			$show = $photo['Filedata']['thumb']['show'];
			$img = $photo['Filedata']['img'];
			*/
			echo IUrl::creatUrl().$show.'|'.$show.'|'.$img.'|'.$id.'|'.$photo['Filedata']['thumb']['list'];
		}
		else
		{
			echo '0';
		}
	}
	
 	/**
	 * @brief Ajax获取规格值
	 */
	function spec_value_list()
	{
		// 获取POST数据
		$spec_id = intval( IReq::get('id') );

		//初始化spec商品模型规格表类对象
		$specObj = new IModel('spec');
		//根据规格编号 获取规格详细信息
		$spec_value = $specObj->getObj("id = $spec_id",array('value','type','note','name'));
		if($spec_value['value'])
		{
			//返回Josn数据
			$json_data = array('value' => unserialize($spec_value['value']),'type'=>$spec_value['type'],'note' => $spec_value['note'],'name' => $spec_value['name']);
			echo JSON::encode($json_data);
		}
		else
		{
			//返回失败标志
			echo 0;
		}
	}

	/**
	 * @brief Ajax获取规格列表
	 */
	function ajax_spec_list()
	{
		//初始化spec商品模型规格表类对象
		$specObj = new IModel('spec');
		//根据规格编号 获取规格详细信息
		$spec_list = $specObj->query(false,array('id','name','note'));
		if($spec_list)
		{
			//返回Josn数据
			echo JSON::encode($spec_list);
		}
		else
		{
			//返回失败标志
			echo 0;
		}
	}

	//规格添加页面
	//修改页面
	function spec_edit()
	{
		if($id = intval( IReq::get('id')) )
		{
			$where = 'id = '.$id;
			$obj = new IModel('spec');
			$dataRow = $obj->getObj($where);
		}
		else
		{
			$dataRow = array(
				'id'   => null,
				'name' => null,
				'type' => null,
				'value'=> null,
				'note' => null,
			);
		}
		$this->setRenderData($dataRow);
		$this->redirect('spec_edit');
	}

	//列出筛选商品
	function goods_list()
	{
		//商品检索条件
		$show_num  = intval( IReq::get('show_num','post'));
		$keywords  = IFilter::act( IReq::get('keywords','post') );
		$cat_id    = intval( IReq::get('category_id','post') );
		$min_price = IFilter::act( IReq::get('min_price','post'),'float' );
		$max_price = IFilter::act( IReq::get('max_price','post'),'float' );

		//查询条件
		$where = 'is_del = 0';
		$where.= $keywords  ? ' and name like "%'.$keywords.'%"': '';
		$where.= $cat_id    ? ' and category_id =  '.$cat_id    : '';
		$where.= $min_price ? ' and sell_price  >= '.$cat_id    : '';
		$where.= $max_price ? ' and sell_price  <= '.$cat_id    : '';

		$obj        = new IModel('goods');
		$this->data = $obj->query($where,'id,name,list_img','id','desc',$show_num);
		$this->type = IReq::get('type','get');
		$this->redirect('goods_list');
	}
	//获得商品货号
	public function goods_no($goods_id)
	{
		//获得配置文件中的数据
		$config = new Config("site_config");
	 	$goods_no_pre = $config->goods_no_pre;
		if(!empty($goods_no_pre))
	 	{
	 		if(strlen($goods_no_pre)>2)
	 		{
	 			$goods_no_pre = substr($goods_no_pre,0,2);
	 		}
	 		else if(strlen($goods_no_pre)==1)
	 		{
	 			$goods_no_pre = $goods_no_pre."0";
	 		}
	 	}
	 	else
	 	{
	 		$goods_no_pre = 'SD';
	 	}
	 	//判断加0的个数
		if((16-2-strlen($goods_id))>0)
		{
			$j = 16-2-strlen($goods_id);
			for ($i = 0; $i < $j; $i++) {
				$goods_no_pre = $goods_no_pre."0";
			}
		}
	 	//组合货号
	 	$goods_no_pre = $goods_no_pre.$goods_id;
	 	return $goods_no_pre;
	}
	//提取已经选定的商品
	function goods_select()
	{
		$id_str = IReq::get('id_str');
		if(!empty($id_str))
		{
			$id_str = explode(",",$id_str);
			$id_str = Util::intval_value($id_str);
			$id_str = implode(",",$id_str);
			$goodsObj = new IModel('goods');
			$where    = 'id in ('.$id_str.')';
			$data     = $goodsObj->query($where);

			$result = array(
				'isError' => false,
				'data'    => $data,
				'id_str'  => $id_str,
			);
		}
		else
		{
			$result = array(
				'isError' => true,
				'message' => '请选择要关联的商品',
			);
		}
		echo JSON::encode($result);
	}

	//[用户头像]上传
	function user_ico_upload()
	{

		$user_id = ISafe::get('user_id');
		if($user_id == '')
		{
			$this->redirect('/simple/login');
			die();
		}

		$result = array(
			'isError' => true,
		);

		if(isset($_FILES['user_ico']['name']) && $_FILES['user_ico']['name'] != '')
		{
			$photoObj = new PhotoUpload();
			$photoObj->setThumb(100,100,'user_ico');
			$photo    = $photoObj->run();

			if(!empty($photo['user_ico']['thumb']['user_ico']))
			{
				$user_id   = ISafe::get('user_id');

				$user_obj  = new IModel('user');
				$dataArray = array(
					'head_ico' => $photo['user_ico']['thumb']['user_ico'],
				);
				$user_obj->setData($dataArray);
				$where  = 'id = '.$user_id;
				$isSuss = $user_obj->update($where);

				if($isSuss !== false)
				{
					$result['isError'] = false;
					$result['data'] = IUrl::creatUrl().$photo['user_ico']['thumb']['user_ico'];
					ISafe::set('head_ico',$dataArray['head_ico']);
				}
				else
				{
					$result['message'] = '上传失败(2)';
				}
			}
			else
			{
				$result['message'] = '上传失败(1)';
			}
		}
		else
		{
			$result['message'] = '请选择图片';
		}
		echo '<script type="text/javascript">parent.callback_user_ico('.JSON::encode($result).');</script>';
	}

	/**
	 * @brief 商品添加后图片的链接地址
	 */
	function goods_photo_link()
	{
		$img = IReq::get('img');
		$img = substr($img,1);
		$foot = substr($img,strpos($img,'.'));//图片扩展名
		$head = substr($img,0,strpos($img,'.'));
		//获得配置文件中的数据
		$config = new Config("site_config");
		$config_info = $config->getInfo();

		$list_thumb_width  = isset($config_info['list_thumb_width'])  ? $config_info['list_thumb_width']  : 175;
	 	$list_thumb_height = isset($config_info['list_thumb_height']) ? $config_info['list_thumb_height'] : 175;
	 	$show_thumb_width  = isset($config_info['show_thumb_width'])  ? $config_info['show_thumb_width']  : 85;
		$show_thumb_height = isset($config_info['show_thumb_height']) ? $config_info['show_thumb_height'] : 85;

		$data['img'] = IUrl::creatUrl().$img;
		$data['list_img'] = IUrl::creatUrl().$head.'_'.$list_thumb_width.'_'.$list_thumb_height.$foot;
		$data['small_img'] = IUrl::creatUrl().$head.'_'.$show_thumb_width.'_'.$show_thumb_height.$foot;
		$this->setRenderData($data);
		$this->redirect('goods_photo_link');
	}

	//列出控制器
	function list_controller()
	{
		$planPath = $this->module->config['basePath'].'controllers';
		$planList = array();
		$dirRes   = opendir($planPath);

		while($dir = readdir($dirRes))
		{
			if(!in_array($dir,array('.','..','.svn')))
			{
				$planList[] = basename($dir,'.php');
			}
		}
		echo JSON::encode($planList);
	}

	//列出某个控制器的action动作和视图
	function list_action()
	{
		$ctrlId     = IReq::get('ctrlId');
		if($ctrlId != '')
		{
			$baseContrl = get_class_methods('IController');
			$advContrl  = get_class_methods($ctrlId);
			$diffArray  = array_diff($advContrl,$baseContrl);
			echo JSON::encode($diffArray);
		}
	}

	/**
	 * @brief 获取地区
	 */
	function area_child()
	{
		$aid = intval(IReq::get("aid"));
		$tb_areas = new IModel('areas');
		$areas = $tb_areas->query("parent_id=$aid",'*','sort','asc');

		echo JSON::encode($areas);
	}

    //[公共方法]通过序列化数据查询展示规格 key:规格名称;value:规格值
    function show_spec($specSerialize)
    {
    	$specValArray = array();
    	$specArray    = unserialize($specSerialize);

    	foreach($specArray as $val)
    	{
    		$specValArray[$val['id']] = $val['value'];
    	}
    	$specIds   = join(',',array_keys($specValArray));
    	$specObj   = new IModel('spec');
    	$where     = 'id in ('.$specIds.')';
    	$specData  = $specObj->query($where,'id,name,type');

    	$spec      = array();

    	foreach($specData as $val)
    	{
    		if($val['type'] == 1)
    		{
    			$spec[$val['name']] = $specValArray[$val['id']];
    		}
    		else
    		{
    			$spec[$val['name']] = '<img src="'.IUrl::creatUrl().$specValArray[$val['id']].'" class="img_border" style="width:15px;height:15px;" />';
    		}
    	}
    	return $spec;
    }

	//商品分类,等级共分为3级
	function goods_category()
	{
		$catResult = array();

		$catObj   = new IModel('category');
		$catFirst = $catObj->query('parent_id = 0','id,name,parent_id,visibility','sort','asc');
		$catOther = $catObj->query('parent_id != 0','id,name,parent_id,visibility','sort','asc');

		foreach($catFirst as $first_key => $first)
		{
			foreach($catOther as $other_key => $other_val)
			{
				if($first['id'] == $other_val['parent_id'])
				{
					//拼接二级分类
					$first['second'][$other_key] = $other_val;

					//拼接二级以下所有分类
					$catMore = array();
					self::recursion_goods_category($other_val,$catOther,$catObj,$catMore);
					$first['second'][$other_key]['more'] = $catMore;
				}
			}

			$catResult[] = $first;
		}
		return $catResult;
	}

	//递归获取分类
	function recursion_goods_category($data,$catOther,$catObj,&$catMore = '')
	{
		if(!empty($data) && !empty($catOther))
		{
			foreach($catOther as $okey => $oval)
			{
				if($data['id'] == $oval['parent_id'])
				{
					unset($catOther[$okey]);
					$catMore[] = $oval;
					self::recursion_goods_category($oval,$catOther,$catObj,$catMore);
				}
			}
		}
	}

	//根据总分类查找所需分类的树结构
	function getCatTree($catList,$catId = '')
	{
		if(intval($catId) != 0)
		{
			foreach($catList as $firstKey => $firstVal)
			{
				if($firstVal['id'] == $catId)
				{
					return $catList[$firstKey];
				}
				else
				{
					if(!empty($firstVal['second']))
					{
						foreach($firstVal['second'] as $secondKey => $secondVal)
						{
							if($secondVal['id'] == $catId)
							{
								return $catList[$firstKey];
							}
							else
							{
								if(!empty($secondVal['more']))
								{
									foreach($secondVal['more'] as $moreKey => $moreVal)
									{
										if($moreVal['id'] == $catId)
										{
											return $catList[$firstKey];
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return array();
	}

	//[条件检索url处理]对于query url中已经存在的数据进行删除;没有的参数进行添加
	function searchUrl($queryKey,$queryVal = '')
	{
		if(is_array($queryKey))
		{
			$concatStr = '';
			$fromStr   = array();
			$toStr     = array();

			foreach($queryKey as $k => $v)
			{
				$urlVal  = IReq::get($v);
				$tempVal = isset($queryVal[$k]) ? $queryVal[$k] : $queryVal;

				if($urlVal === null)
				{
					$concatStr.='&'.$v.'='.$tempVal;
				}
				else
				{
					$fromStr[] = '&'.$v.'='.$urlVal;
					$toStr[]   = '&'.$v.'='.$tempVal;
				}
			}
			return str_replace($fromStr,$toStr,'?'.$_SERVER['QUERY_STRING']).$concatStr;
		}
		else
		{
			/*URL变量 arg[key] 格式支持
			 *由于在 URL get方式传参时系统会把变量 arg[key] 直接判定为数组
			 *所以这里需要对此类参数进行特殊处理;
			 */
			preg_match('|(\w+)\[(\d+)\]|',$queryKey,$match);
			$urlVal = null;

			if(isset($match[2]))
			{
				$urlArray = IReq::get($match[1]);
				if(isset($urlArray[$match[2]]))
				{
					$urlVal = $urlArray[$match[2]];
				}
			}
			//考虑列表排序按钮的效果
			else
			{
				$urlVal = IReq::get($queryKey);
			}

			if($urlVal === null && $queryVal !== '')
			{
				return '?'.$_SERVER['QUERY_STRING'].'&'.$queryKey.'='.urlencode($queryVal);
			}
			else
			{
				$fromStr = '&'.$queryKey.'='.urlencode($urlVal);
				if($queryVal === '')
				{
					$toStr   = '';
				}
				else
				{
					$toStr   = '&'.$queryKey.'='.urlencode($queryVal);
				}
				return str_replace($fromStr,$toStr,'?'.$_SERVER['QUERY_STRING']);
			}
		}
	}
	/**
	 * @brief 获得配送方式ajax
	 */
	public function order_delivery()
    {
    	$data = array();
    	//获取post的值
    	$province = IReq::get("province");
    	//$province = '2182';
    	$weight = (int)IReq::get('weight');
    	//$weight = 2500;
    	//初始化配送方式类
    	$delivery = new Delivery();
    	//调入数据，获得配送方式结果
    	$data = $delivery->getDelivery($province,$weight);
		echo JSON::encode($data);
    }
	/**
    * @brief 支付方法
    */
	public function doPay()
	{
		//获得payment_id 获得相关参数
		$payment_id  = intval(IReq::get('id'));
		$order_id    = intval(IReq::get('order_id'));
		$recharge    = IReq::get('recharge');

		//检查支付方式可用性
		$paymentObj = new Payment();
		$paymentRow = $paymentObj->getPaymentById($payment_id);
		if(empty($paymentRow))
		{
			IError::show(403,'支付方式不存在');
		}

		//载入支付接口文件
		$payObj  = $paymentObj->loadMethod($paymentRow['file_path']);

		if($payObj->head_charset)
		{
			header("Content-Type: text/html;charset=" . $payObj->head_charset);
		}

		$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n                <html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\" dir=\"ltr\">\n                <head>\n</header><body><div>Redirecting...</div>";

		$payObj->_payment = $payment_id;

		//在线充值
		if($recharge !== null)
		{
			$reData   = array('account' => $recharge , 'payment_type' => $paymentRow['name']);
			$toSubmit = $payObj->toSubmit($paymentObj->getPaymentInfo($payment_id,'recharge',$reData));
		}
		//订单支付
		else if($order_id != 0)
		{
			$toSubmit = $payObj->toSubmit($paymentObj->getPaymentInfo($payment_id,'order',$order_id));
		}
		else
		{
			IError::show(403,'发生支付错误');
		}

		//兼容站外站内的支付方式
		if(strtolower(substr($payObj->submitUrl,0,4)) != 'http')
		{
			$payObj->submitUrl = IUrl::creatUrl($payObj->submitUrl);
		}

		$html .= "<form id=\"payment\" action=\"" . $payObj->submitUrl . "\" method=\"" . $payObj->method . "\">";
		$buffer = "";
		foreach ($toSubmit as $k => $v)
		{
			if ($k != "ikey")
			{
				$html .= "<input  type=\"hidden\" name=\"" . urldecode($k) . "\" value=\"" . htmlspecialchars ( $v ) . "\" />";
				$buffer .= $k . "=" . urlencode($v) . "&";
			}
		}
		$html .= "\n</form>\n<script language=\"javascript\">\ndocument.getElementById('payment').submit();\n</script>\n</html>";
		echo $html;
		exit ();
	}

	/**
    * @brief 支付回调测试[同步]
	* define ( "PAY_FAILED", - 1);支付失败
	* define ( "PAY_TIMEOUT", 0);支付超时
	* define ( "PAY_SUCCESS", 1);支付成功
	* define ( "PAY_CANCEL", 2);支付取消
	* define ( "PAY_ERROR", 3);支付错误
	* define ( "PAY_PROGRESS", 4);支付进行
	* define ( "PAY_INVALID", 5);支付无效
	* define ( "PAY_MANUAL", 0);手工支付
	*/
	public function callback()
	{
		$payment_name = is_array($payment_name = IReq::get('payment_name')) ? IFilter::act($payment_name[0]) : IFilter::act(IReq::get('payment_name'));

		//初始化参数
		$money   = null;
		$message = null;
		$tradeno = null;

		//获取支付payment的id值
		$pObj       = new IModel('payment as a,pay_plugin as b');
		$paymentRow = $pObj->getObj('b.file_path = "'.$payment_name.'" and a.plugin_id = b.id','a.id');

		//载入支付接口文件
		$paymentObj = new Payment();
		$payObj     = $paymentObj->loadMethod($payment_name);

		if(!is_object($payObj))
		{
			IError::show(403,'支付方式不存在');
		}

		//执行接口回调函数
		$return  = $payObj->callback(array_merge($_POST,$_GET),$paymentRow['id'],$money,$message,$tradeno);

		//判断返回状态
		if($return == 1)
		{
			if(stripos($tradeno,'recharge_') !== false)
			{
				$tradenoArray = explode('_',$tradeno);
				$recharge_no  = isset($tradenoArray[1]) ? $tradenoArray[1] : 0;
				if($this->updateRecharge($recharge_no))
				{
					$this->redirect('/site/success/message/'.urlencode(urlencode("充值成功")).'/?callback=/ucenter/account_log');
				}
				else
				{
					IError::show(403,'充值失败');
				}
			}
			else
			{
				$order_id = $this->updateOrder($tradeno);
				if($order_id != '')
				{
					$url  = '/site/success/message/'.urlencode(urlencode("支付成功"));
					$url .= ISafe::get('user_id') ? '/?callback=/ucenter/order_detail/id/'.$order_id : '';
					$this->redirect($url);
				}
				else
				{
					IError::show(403,'订单修改失败');
				}
			}
		}
		else
		{
			IError::show(403,'支付失败');
		}
	}

	//支付回调[异步]
	function server_callback()
	{
		$payment_name = is_array($payment_name = IReq::get('payment_name')) ? IFilter::act($payment_name[0]) : IFilter::act(IReq::get('payment_name'));

		//初始化参数
		$money   = null;
		$message = null;
		$tradeno = null;

		//获取支付payment的id值
		$pObj       = new IModel('payment as a,pay_plugin as b');
		$paymentRow = $pObj->getObj('b.file_path = "'.$payment_name.'" and a.plugin_id = b.id','a.id');

		//载入支付接口文件
		$paymentObj = new Payment();
		$payObj     = $paymentObj->loadMethod($payment_name);

		if(!is_object($payObj))
		{
			echo 'fail';
			exit;
		}

		//执行接口回调函数
		$return  = $payObj->callback(array_merge($_POST,$_GET),$paymentRow['id'],$money,$message,$tradeno);

		//判断返回状态
		if($return == 1)
		{
			if(stripos($tradeno,'recharge_') !== false)
			{
				$tradenoArray = explode('_',$tradeno);
				$recharge_no  = isset($tradenoArray[1]) ? $tradenoArray[1] : 0;
				if($this->updateRecharge($recharge_no))
				{
					echo 'success';exit;
				}
				else
				{
					echo 'fail';
				}
			}
			else
			{
				if($this->updateOrder($tradeno))
				{
					echo 'success';exit;
				}
				else
				{
					echo 'fail';
				}
			}
		}
		else
		{
			echo 'fail';
		}
	}
	//支付成功,在线充值更新
	function updateRecharge($recharge_no)
	{
		$rechargeObj = new IModel('online_recharge');
		$rechargeRow = $rechargeObj->getObj('recharge_no = "'.$recharge_no.'"');
		if(empty($rechargeRow))
		{
			return false;
		}

		if($rechargeRow['status'] == 1)
		{
			return true;
		}

		$dataArray = array(
			'status' => 1
		);

		$rechargeObj->setData($dataArray);
		$result = $rechargeObj->update('recharge_no = "'.$recharge_no.'"');

		if($result == '')
		{
			return false;
		}

		$money   = $rechargeRow['account'];
		$user_id = $rechargeRow['user_id'];

		$memberObj = new IModel('member');
		$dataArray = array(
			'balance' => 'balance + '.$money
		);
		$memberObj->setData($dataArray);
		$is_success = $memberObj->update('user_id = '.$user_id,'balance');

		if($is_success)
		{
			$log = new AccountLog();
			$config=array(
				'user_id'  => $user_id,
				'event'    => 'recharge',
				'note'     => '在线充值',
				'num'      => $money,
			);
			$re = $log->write($config);
		}
		return $is_success;
	}

	//支付成功,订单更新
	function updateOrder($tradeno)
	{
		//获取订单信息
		$orderObj  = new IModel('order');
		$orderRow  = $orderObj->getObj('order_no = "'.$tradeno.'"');

		if(empty($orderRow))
		{
			return false;
		}

		if($orderRow['pay_status'] == 1)
		{
			return $orderRow['id'];
		}

		else if($orderRow['pay_status'] == 0)
		{
			$dataArray = array(
				'status'     => 2,
				'pay_time'   => ITime::getDateTime(),
				'pay_status' => 1,
			);
			$orderObj->setData($dataArray);
			$is_success = $orderObj->update('order_no = "'.$tradeno.'"');
			if($is_success == '')
			{
				return false;
			}

			//删除订单中使用的道具
			$ticket_id = trim($orderRow['prop']);
			if($ticket_id != '')
			{
				$propObj  = new IModel('prop');
				$propData = array('is_userd' => 1);
				$propObj->setData($propData);
				$propObj->update('id = '.$ticket_id);
			}

			if($orderRow['user_id'] != '')
			{
				$user_id = $orderRow['user_id'];

				//获取用户信息
				$memberObj  = new IModel('member');
				$memberRow  = $memberObj->getObj('user_id = '.$user_id,'prop,group_id');

				//(1)删除订单中使用的道具
				if($ticket_id != '')
				{
					$finnalTicket = str_replace(','.$ticket_id.',',',',','.trim($memberRow['prop'],',').',');
					$memberData   = array('prop' => $finnalTicket);
					$memberObj->setData($memberData);
					$memberObj->update('user_id = '.$user_id);
				}

				//(2)进行促销活动奖励
		    	$proObj = new ProRule($orderRow['order_amount']);
		    	$proObj->setUserGroup($memberRow['group_id']);
		    	$proObj->setAward($user_id);

		    	//(3)增加积分和经验值
		    	$memberData = array(
		    		'exp'   => 'exp + '.$orderRow['exp'],
		    		'point' => 'point + '.$orderRow['point'],
		    	);
				$memberObj->setData($memberData);
				$memberObj->update('user_id = '.$user_id,array('exp','point'));
			}

			return $orderRow['id'];
		}
		else
		{
			return false;
		}
	}

	/**
    * @brief 根据省份名称查询相应的privice
    */
	public function searchPrivice()
	{
		$city = IReq::get('area_name');
		$tb_areas = new IQuery('areas');
		$tb_areas->where = 'parent_id=0';
		$areas_info = $tb_areas->find();
		$privice = 0;
		foreach ($areas_info as $value) {
			if(strpos('|'.$city,$value['area_name']))
			{
				$privice = $value['area_id'].','.$value['area_name'];
			}
		}
		echo $privice;
	}

	//产生订单ID
	public function createOrderNum()
	{
		return date('YmdHis').rand(100000,999999);
	}

	//订单商品数量更新操作[公共]
	public function updateStore($order_id,$type = 'add')
	{
		$sign = '+';
		if($type == 'reduce')
		{
			$sign = '-';
		}
		$updateGoodsId = array();
		$orderGoodsObj = new IModel('order_goods');
		$goodsObj      = new IModel('goods');
		$productObj    = new IModel('products');
		$goodsList     = $orderGoodsObj->query('order_id = '.$order_id,'goods_id,product_id,goods_nums');

		foreach($goodsList as $key => $val)
		{
			$dataArray = array('store_nums' => 'store_nums'.$sign.$val['goods_nums']);
			if($val['product_id'] != 0)
			{
				$productObj->setData($dataArray);
				$productObj->update('id = '.$val['product_id'],'store_nums');
				$updateGoodsId[] = $val['goods_id'];
			}
			else
			{
				$goodsObj->setData($dataArray);
				$goodsObj->update('id = '.$val['goods_id'],'store_nums');
			}
		}

		//更新统计goods的库存
		if(!empty($updateGoodsId))
		{
			foreach($updateGoodsId as $val)
			{
				$totalRow = $productObj->getObj('goods_id = '.$val,'SUM(store_nums) as store');
				$goodsObj->setData(array('store_nums' => $totalRow['store']));
				$goodsObj->update('id = '.$val);
			}
		}
	}

	//检查email配置信息
	function checkEmailConf()
	{
		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();

		if(isset($site_config['email_type']) && isset($site_config['mail_address']))
		{
			if($site_config['email_type'] == 1)
			{
				$mustConfig = array('smtp','smtp_user','smtp_pwd','smtp_port');
				foreach($mustConfig as $val)
				{
					if(!isset($site_config[$val]) || $site_config[$val] == '')
					{
						return false;
					}
				}
				return true;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * 用户在编辑器里上传图片
	 */
	public function upload_img_from_editor()
	{
		$photoUpload = new PhotoUpload();
		$photoUpload->setIterance(false);
		$re = $photoUpload->run();
		if(isset($re['imgFile']['flag']) && $re['imgFile']['flag']==1 )
		{
			$filePath = IUrl::creatUrl().$re['imgFile']['dir'].$re['imgFile']['name'];
			echo JSON::encode(array('error' => 0, 'url' => $filePath));
			exit;
		}
		else
		{
			$this->alert("上传失败");
		}
	}

    //添加实体代金券
    function add_download_ticket()
    {
    	$isError = true;

    	$ticket_num = IFilter::act(IReq::get('ticket_num'));
    	$ticket_pwd = IFilter::act(IReq::get('ticket_pwd'));

    	$propObj = new IModel('prop');
    	$propRow = $propObj->getObj('card_name = "'.$ticket_num.'" and card_pwd = "'.$ticket_pwd.'" and type = 0 and is_userd = 0 and is_send = 1 and is_close = 0 and NOW() between start_time and end_time');

    	if(empty($propRow))
    	{
    		$message = '代金券不可用，请确认代金券的卡号密码并且此代金券从未被使用过';
    	}
    	else
    	{
    		//登录用户
    		if($this->user['user_id'])
    		{
	    		$memberObj = new IModel('member');
	    		$memberRow = $memberObj->getObj('user_id = '.$this->user['user_id'],'prop');
	    		if(stripos($memberRow['prop'],','.$propRow['id'].',') !== false)
	    		{
	    			$message = '代金券已经存在，不能重复添加';
	    		}
	    		else
	    		{
		    		$isError = false;
		    		$message = '添加成功';

		    		if($memberRow['prop'] == '')
		    		{
		    			$propUpdate = ','.$propRow['id'].',';
		    		}
		    		else
		    		{
		    			$propUpdate = $memberRow['prop'].$propRow['id'].',';
		    		}

		    		$dataArray = array('prop' => $propUpdate);
		    		$memberObj->setData($dataArray);
		    		$memberObj->update('user_id = '.$this->user['user_id']);
	    		}
    		}
    		//游客方式
    		else
    		{
				$isError = false;
				$message = '添加成功';
    			ISafe::set("ticket_".$propRow['id'],$propRow['id']);
    		}
    	}

    	$result = array(
    		'isError' => $isError,
    		'data'    => $propRow,
    		'message' => $message,
    	);

    	echo JSON::encode($result);
    }

	private function alert($msg)
	{
		header('Content-type: text/html; charset=UTF-8');
		echo JSON::encode(array('error' => 1, 'message' => $msg));
		exit;
	}

	//后台管理员权限校验
	public static function checkAdminRights($object)
	{
		$admin                    = array();
		$admin['admin_id']        = ISafe::get('admin_id');
		$admin['admin_name']      = ISafe::get('admin_name');
		$admin['admin_pwd']       = ISafe::get('admin_pwd');
		$admin['admin_role_name'] = ISafe::get('admin_role_name');

		if($admin['admin_name'] == null || $admin['admin_pwd'] == null)
		{
			$object->redirect('/systemadmin/index');
			exit;
		}

		$adminObj = new IModel('admin');
		$adminRow = $adminObj->getObj("admin_name = '{$admin['admin_name']}'");
		if(!empty($adminRow) && ($adminRow['password'] == $admin['admin_pwd']) && ($adminRow['is_del'] == 0))
		{
			//非超管角色
			if($adminRow['role_id'] != 0)
			{
				$roleObj = new IModel('admin_role');
				$where   = 'id = '.$adminRow["role_id"].' and is_del = 0';
				$roleRow = $roleObj->getObj($where);

				//角色权限校验
				if($object->checkRight($roleRow['rights']) == false)
				{
					IError::show('503','no permission to access');
					exit;
				}
			}
			$object->admin = $admin;
		}
		else
		{
			IError::show('503','no permission to access');
			exit;
		}
	}
}
?>
