<?php
/**
 * @copyright (c) 2011 panfeng
 * @file service.php
 * @brief 服务类
 * @author chen xufeng
 * @date 2011-12-25
 * @version 0.6
 */

class Service extends IController
{
	public $layout='admin';
	protected $checkRight = 'all';
	private $member_data = array();
	private $data = array();
	function init()
	{
		$admin = array();
		$admin['admin_id']        = ISafe::get('admin_id');
		$admin['admin_name']      = ISafe::get('admin_name');
		$admin['admin_right']     = ISafe::get('admin_right');
		$admin['admin_role_name'] = ISafe::get('admin_role_name');
		if(!$admin['admin_id'] || !$admin['admin_right'])
		{
			$this->redirect('/systemadmin/index');
		}
		$this->admin = $admin;
	}
	
	
	//[服务项目管理] 服务类别列表
	function service_cat_list()
	{
		$this->redirect('service_cat_list');
	}
	//[服务项目管理] 增加修改服务类别
	function service_cat_edit()
	{
		$data = array();
		$id = intval( IReq::get('id') );
		$type = IFilter::act( IReq::get('type','get'),'string');

		if($id)
		{
			$catObj = new IModel('service_cat');
			$where  = 'id = '.$id;
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$this->catRow = $data;
				$this->redirect('service_cat_edit',false);
			}
		}else{
			$this->catRow = array('type'=>$type);
			$this->redirect('service_cat_edit');
		}


	}

	//[服务项目管理] 增加和修改动作
	function service_cat_edit_act()
	{
		$id        = intval( IReq::get('id','post') );
		$parent_id = intval( IReq::get('parent_id','post') ) ;

		$catObj    = new IModel('service_cat');
		$DataArray = array(
			'parent_id' => $parent_id,
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'issys'     => intval( IReq::get('issys','post') ),
			'sort'      => intval( IReq::get('sort','post') ),
			'type'      => IFilter::act( IReq::get('service_cat_type_id','post'),'string'),
		);

		/*开始--获取path信息*/
		//1,修改操作
		if($id)
		{
			$where  = 'id = '.$id;
			$catRow = $catObj->getObj($where);
			if($catRow['parent_id']==$parent_id)
			{
				$isMoveNode = false;
				$DataArray['path'] = $catRow['path'];
			}
			else
				$isMoveNode = true;

			$localId = $id;
		}
		//2,新增操作
		else
		{
			$max_id  = $catObj->getObj('','max(id) as max_id');
			$localId = $max_id['max_id'] ? $max_id['max_id']+1 : 1;
		}

		//如果不存在path数据时,计算path数据
		if(!isset($DataArray['path']))
		{
			//获取父节点的path路径
			if($parent_id==0)
				$DataArray['path'] = ','.$localId.',';
			else
			{
				$where     = 'id = '.$parent_id;
				$parentRow = $catObj->getObj($where);
				$DataArray['path'] = $parentRow['path'].$localId.',';
			}
		}
		/*结束--获取path信息*/
		//设置数据值
		$DataArray['id']=$localId;
		$catObj->setData($DataArray);

		//1,修改操作
		if($id)
		{
			//节点移动
			if($isMoveNode == true)
			{
				if($parentRow['path']!=null && strpos($parentRow['path'],','.$id.',')!==false)
				{
					$this->catRow = array(
						'parent_id' => $DataArray['parent_id'],
						'name'      => $DataArray['name'],
						'issys'     => $DataArray['issys'],
						'sort'      => $DataArray['sort'],
						'id'        => $id,
						'type'		=> $DataArray['type'],
					);
					$this->redirect('article_cat_edit',false);
					Util::showMessage('不能该节点移动到其子节点的位置上');
				}
				else
				{
					//其子节点批量移动
					$childObj = new IModel('service_cat');
					$oldPath  = $catRow['path'];
					$newPath  = $DataArray['path'];

					$where = 'path like "'.$oldPath.'%"';
					$updateData = array(
						'path' => "replace(path,'".$oldPath."','".$newPath."')",
					);
					$childObj->setData($updateData);
					$childObj->update($where,array('path'));
				}
			}
			$where = 'id = '.$id;
			$catObj->update($where);
		}
		//2,新增操作
		else{
			$catObj->add();
			$a = mysql_insert_id();
			$b = IFilter::act( IReq::get('service_cat_type_id','post'),'string');
			$findObj = new IModel("service_cat_type");
			$where = "code = ".$b;
			$findRow = $findObj->getObj($where);
			if($findRow['name'] == '内容')
			{
				$addData = array(
					"service_cat_id" => $a,
					'content'=>'',
				);
				$addObj = new IModel('content');
				$addObj->setData($addData);
				$addObj->add();
			}
		}
		$this->redirect('service_cat_list');
	}

	//[服务项目管理] 删除
	function service_cat_del()
	{
		$id = intval( IReq::get('id') );
		$catObj = new IModel('service_cat');
		$catObj1 = new IModel('content');

		//是否执行删除检测值
		$isCheck=true;

		//检测是否有parent_id 为 $id
		$where   = 'parent_id = '.$id;
		$catData = $catObj->getObj($where);
		if(!empty($catData))
		{
			$isCheck=false;
			$message='此分类下还有子分类';
		}

		//检测是否有服务项目的category_id 为 $id
		else
		{
			$articleObj = new IModel('article');
			$where = 'category_id = '.$id;
			$catData = $articleObj->getObj($where);

			if(!empty($catData))
			{
				$isCheck=false;
				$message='此分类下还有服务项目';
			}
		}

		//开始删除
		$where  = 'id = '.$id;
		$result = $catObj->del($where);
		if($result==true && $isCheck==true)
		{
			$where1  = 'service_cat_id = '.$id;
			$result1 = $catObj1->del($where1);
			$this->redirect('service_cat_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('service_cat_list',false);
			Util::showMessage($message);
		}
	}

	
	//专家排班列表
	function paiban_list()
	{
		$orderObj = new IModel('pro_worktime');
		$orderData = $orderObj->query();
		$this->len = count($orderData);
		$this->orderRow = $orderData;
		//print(var_dump($this->orderRow));
		//print($len);
		$this->redirect('paiban_list');
	}
	
	//修改专家排班
	function paiban_edit()
	{
		$date = IFilter::act(IReq::get('date'),string);
		$id = IFilter::act(IReq::get('id'),int);
		//die($date);
		$this->orderData = array();
		if(!empty($date))
		{
			$this->orderData = array('time' => $date);
	
			$this->redirect('paiban_edit');
		}
		else
		{	if(!empty($id))
			{
				$orderObj = new IModel('pro_worktime');
				$where = 'id = '.$id;
				$orderRow = $orderObj->getObj($where);
				if(!empty($orderRow))
				{
					$this->orderData = $orderRow;
				}
			}
			$this->redirect('paiban_edit');
		}
	}
	
	
	//修改专家排班表动作
	function paiban_edit_act()
	{
		$id = IFilter::act(IReq::get('id','post'),int);
		
		$pid = IFilter::act(IReq::get('name','post'),int);
		//die(var_dump($id));
		$time = IReq::get('time','post');
		//die($id.'-'.$pid.'-'.$time);
		if(!empty($pid) && !empty($time))
		{
			$orderObj = new IModel('pro_worktime');
			$proObj = new IModel('professional');
			
			$pwhere = 'id = '.$pid;
			
			$proInfo = $proObj->getObj($pwhere);
			
			$dataArray = array(
				'name' => $proInfo['name'],
				'pro_id' => $proInfo['id'],
				'time' => $time,
				);
			$orderObj->setData($dataArray);
			$count = 0;
			
			if($id!=0)
			{	
				$where = 'id = '.$id;
				$result = $orderObj->update($where);
			}
			else 
			{
				//更新记录
				$orderObj->add();
			}
			
			$this->redirect('paiban_list');
		}

		else{
			$message = '专家和值班日期都不能为空，请重新选择！';
			$this->redirect('paiban_edit',false);
			Util::showMessage($message);
		}
			
		
			
	}
	
	function paiban_del()
	{
		$id = IReq::get('id','get');
		$orderObj = new IModel('pro_worktime');
		if($id)
		{
			$where = 'id = '.$id;
			$result = $orderObj->del($where);
		}
		$this->redirect('paiban_list');
	}
	
	//课表搜索
	function paiban_search()
	{
		$flag = IFilter::act(IReq::get('flag'), 'int');
		$title = IReq::get('title');
		$query = new IQuery('pro_worktime');
		
		if($title && $flag === 1)
		{
			$query->where = "name like '%".$title."%'";
		}
		$query->fields = "*";
		$query->order = "time desc";
		$query->page = isset($_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$paibanSearch = $query->find();
		
		for($i = 0; $i < count($paibanSearch); $i++)
		{
			$paibanSearch[$i]['name'] = $this->SubCN4(strip_tags($paibanSearch[$i]['name']),70);
		}
		
		$this->searchData = $paibanSearch;
		//die(var_dump($this->searchData));
		$this->title = $title;
		$this->redirect('paiban_search');
	}
	
	/**************************************************************/
	//课表列表
	function kebiao_list()
	{
		$scheduleObj = new IModel('schedule');
		$scheduleData = $scheduleObj->query();
		$this->len = count($scheduleData);
		$this->scheduleRow = $scheduleData;
		$this->redirect('kebiao_list');
	}
	
	
	//修改课程表
	function kebiao_edit()
	{
		$id = IFilter::act(IReq::get('id'),int);
		$date = IFilter::act(IReq::get('date'),string);
		$this->scheduleData = array();
		//更新记录
		if(!empty($id))
		{
			$scheduleObj = new IModel('schedule');
			$where = 'id = '.$id;
			$scheduleRow = $scheduleObj->getObj($where);
			if(!empty($scheduleRow))
			{
				$this->scheduleData = $scheduleRow;
			}

			$this->redirect('kebiao_edit');
		}
		elseif(!empty($date))
		{
			$this->scheduleData = array('start_date' => $date,'end_date' => $date);
			$this->redirect('kebiao_edit');
		}
		else
		{	
			$this->redirect('kebiao_edit');
		}
	}
	
	//修改课程表-动作
	function kebiao_edit_act()
	{
		$id = IReq::get('id','post');
		$sid = IReq::get('name','post');
		$start_date = IReq::get('start_date','post');
		$end_date = IReq::get('end_date','post');
		$start_time = IReq::get('start_time','post');
		$end_time = IReq::get('end_time','post');
		//die($sid."<br />".$start_date."<br />".$start_time."<br />".$end_date."<br />".$end_time."<br />");
		if(!empty($sid) && !empty($start_time) && !empty($start_date) && !empty($end_date) && !empty($end_time))
		{
			$scheduleObj = new IModel('schedule');
			$serviceObj = new IModel('service');
			
			//格式化时间
			$arr_start = explode(':', $start_time);
			$arr_end = explode(':', $end_time);
			if(count($arr_start)<3)
			{
				$start_time = $start_time.':00';
			}
			if(count($arr_end) < 3)
			{
				$end_time = $end_time.":00";
			}
			
			$swhere = 'id = '.$sid;
			
			$serviceInfo = $serviceObj->getObj($swhere);
			$dataArray = array(
				'sname' => $serviceInfo['name'],
				'sid' => $sid,
				'start_date' => $start_date,
				'start_time' => $start_time,
				'end_date' => $end_date,
				'end_time' => $end_time,
				);
			$scheduleObj->setData($dataArray);
			//die(var_dump($dataArray));	
			if($id)
			{
				//更新记录
				$where = 'id = '.$id;
				$result = $scheduleObj->update($where);
				
			}
			else {
				$scheduleObj->add();
			
			}
			$this->redirect('kebiao_list');
		
		}
		else{
			$message = '选项都不能为空，请重新选择！';
			$this->redirect('kebiao_edit',false);
			Util::showMessage($message);
		}
	}
	
	//删除课程表
	function kebiao_del()
	{
		$id = IReq::get('id','get');
		//die($id);
		$scheduleObj = new IModel('schedule');
		if(!empty($id))
		{
			$where = 'id = '.$id;
			$result = $scheduleObj->del($where);
		}
		$this->redirect('kebiao_list');
	}
	
	
	//课表搜索
	function kebiao_search()
	{
		$flag = IFilter::act(IReq::get('flag'), 'int');
		$title = IReq::get('title');
		$query = new IQuery('schedule');
		
		if($title && $flag === 1)
		{
			$query->where = "sname like '%".$title."%'";
		}
		$query->fields = "*";
		$query->order = "end_date desc";
		$query->page = isset($_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$scheduleSearch = $query->find();
		
		for($i = 0; $i < count($scheduleSearch); $i++)
		{
			$scheduleSearch[$i]['sname'] = $this->SubCN4(strip_tags($scheduleSearch[$i]['sname']),70);
		}
		
		$this->searchData = $scheduleSearch;
		//die(var_dump($this->searchData));
		$this->title = $title;
		$this->redirect('kebiao_search');
	}
	//截取中文字符串 
	function SubCN4($str,$len)
	{
		 if($str=='' || strlen($str)<=$len)
		 	return $str;
		 else{
		 	 return trim(iconv_substr($str,0,$len,'utf-8')."......");    // 中英文无差别显示用iconv_substr();
		 }
	}
	/*****************服务，套餐******************/
	//服务项目列表
	function service_list()
	{
			$this->redirect('service_list');
	}
		//添加修改服务
	function service_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		//更新操作
		if($id)
		{
			//查询数据
			$serviceObj = new IModel('service');
			$where = 'id = '.$id;
			$serviceData = $serviceObj->getObj($where);
			if(count($serviceData) > 0)
			{
				$this->serviceRow = $serviceData;
				$this->redirect('service_edit',false);
			}	
		}
		//新增操作
		else 
		{
			$this->serviceRow = array();
			$this->redirect('service_edit');
		}
	}
	//添加或修改服务
	function service_edit_act()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		$serviceObj    = new IModel('service');
		
		$picture = substr(IFilter::act(IReq::get('photo_name')),0,strpos(IFilter::act(IReq::get('photo_name')),','));
		
		if(!$picture)
		{
			$picture= "views/".$this->theme."/skin/".$this->skin."/images/front/service_ico.jpg";
		}	
		
		$DataArray = array(
			'parent_id' => intval( IReq::get('parent_id','post')),
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'definition'=> IFilter::act( IReq::get('def','post'),'string'),
			'describe'  => IFilter::act( IReq::get('content','post'),'text'),
			'sort'      => intval( IReq::get('sort','post') ),
			'price'     => intval( IReq::get('price','post')),
			'state'    =>  IFilter::act(IReq::get('state','post'),'int'),
			'num'      =>  IFilter::act(IReq::get('num','post'),'int'),
			'picture'   => $picture,
		);
		if($DataArray['parent_id'] == 0)
		{
			$this->serviceRow = $DataArray;
			$this->redirect('service_edit',false);
			Util::showMessage('请选择分类');
		}
		if($id)
		{
			$where = 'id = '.$id;
			$serviceObj->setData($DataArray);
			$serviceObj->update($where);
		}
		else
		{
			$serviceObj->setData($DataArray);
			$is_success = $serviceObj->add();
		
			if($is_success)
			{
				$this->redirect('service_list');
			}
			else
			{
				$this->serviceRow = $DataArray;
				$this->redirect('service_edit',false);
				Util::showMessage('插入数据时发生错误');
			}
		}

		$this->redirect('service_list');
	}
	//删除服务
    function service_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		$serviceObj = new IModel('service');

		//开始删除
		if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$result = $serviceObj->del($where);               //删除商品
	
		}
		else
		{
			$this->redirect('service_list',false);
			Util::showMessage('请选择要删除的新闻');
		}
	    if($result==true )
		{
			$this->redirect('service_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('service_list',false);
			Util::showMessage($message);
		}
	}
	
	// 服务套餐列表
	function service_package_list()
	{
	 	$this->redirect('service_package_list');
	}
    //编辑服务套餐
	function service_package_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		//更新操作
		if($id)
		{
			//查询数据
			$serviceObj = new IModel('service_package');
			$where = 'id = '.$id;
			$serviceData = $serviceObj->getObj($where);
			if(count($serviceData) > 0)
			{
				$this->spRow = $serviceData;
				$this->redirect('service_package_edit',false);
			}	
		}
		//新增操作
		else 
		{
			$this->spRow = array();
			$this->redirect('service_package_edit');
		}
	}
	//添加或修改套餐
	function service_package_edit_act()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		$serviceObj    = new IModel('service_package');
		
		$picture = substr(IFilter::act(IReq::get('photo_name')),0,strpos(IFilter::act(IReq::get('photo_name')),','));
		
		if(!$picture)
		{
			$picture= "views/".$this->theme."/skin/".$this->skin."/images/front/service_ico.jpg";
		}
		
		$DataArray = array(
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'definition'=> IFilter::act( IReq::get('def','post'),'string'),
			'describe'  => IFilter::act( IReq::get('content','post'),'text'),
			'sort'      => intval( IReq::get('sort','post') ),
			'pre_price' => IFilter::act(IReq::get('all'),'int'),
			'price'     => intval( IReq::get('price','post')),
			'services'  => IFilter::act( IReq::get('s_id','post'),'string'),
			'state'     =>  IFilter::act(IReq::get('state','post'),'int'),
			'num'       =>  IFilter::act(IReq::get('num','post'),'int'),
			'picture'   => $picture,
		);
		/*if(empty($DataArray['services']))
		{
			$this->spRow = $DataArray;
			$this->redirect('service_package_edit',false);
			Util::showMessage('请选择服务');
		}*/
		if($id)
		{
			$where = 'id = '.$id;
			$serviceObj->setData($DataArray);
		    $serviceObj->update($where);
		}
		else
		{
			$serviceObj->setData($DataArray);
			$is_success = $serviceObj->add();
		
			if($is_success)
			{
				$this->redirect('service_package_list');
			}
			else
			{
				$this->spRow = $DataArray;
				$this->redirect('service_package_edit',false);
				Util::showMessage('插入数据时发生错误');
			}
		}
		$this->redirect('service_package_list');
	}
    function service_package_del()
	{
		
	    $id = IFilter::act( IReq::get('id') ,'int' );
		$serviceObj = new IModel('service_package');

		//开始删除
		if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$result = $serviceObj->del($where);               //删除商品
	
		}
		else
		{
			$this->redirect('service_package_list',false);
			Util::showMessage('请选择要删除的套餐');
		}
	    if($result==true )
		{
			$this->redirect('service_package_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('service_package_list',false);
			Util::showMessage($message);
		}
	}
	/***************************************************************/
		//[营养套餐管理] 服务类别列表
	function dish_type_list()
	{
		$this->redirect('dish_type_list');
	}
	//[服务项目管理] 增加修改服务类别
	function dish_type_edit()
	{
		$data = array();
		$id = intval( IReq::get('id') );
		//$type = IFilter::act( IReq::get('type','get'),'string');

		if($id)
		{
			$catObj = new IModel('dish_type');
			$where  = 'id = '.$id;
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$this->catRow = $data;
				$this->redirect('dish_type_edit',false);
			}
		}else{
			$this->redirect('dish_type_edit');
		}


	}

	//增加和修改动作
	function dish_type_edit_act()
	{
		$id        = intval( IReq::get('id','post') );
		//$parent_id = intval( IReq::get('parent_id','post') ) ;

		$catObj    = new IModel('dish_type');
		$DataArray = array(
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'sort'      => intval( IReq::get('sort','post') ),
		);

		$catObj->setData($DataArray);
        $where = 'id = '.$id;
		$flag = 1;
		//1,修改操作
		if($id)
		{
			$flag = $catObj->update($where);
		}
		//2,新增操作
		else{
			$flag = $catObj->add($where);
		}
		if($flag)
		$this->redirect('dish_type_list');
		else{
		$this->redirect('dish_type_edit',false);
		}
	}
	//删除分类
    function dish_type_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		$Obj = new IModel('dish_type');

		//开始删除
		if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$result = $Obj->del($where);               //删除商品
	
		}
		else
		{
			$this->redirect('dish_type_list',false);
			Util::showMessage('请选择要删除的分类');
		}
	    if($result==true )
		{
			$this->redirect('dish_type_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('dish_type_list',false);
			Util::showMessage($message);
		}
	}
	
/*****************************************************************************/	
	
	//菜谱列表
	function dish_list()
	{
			$this->redirect('dish_list');
	}
	//添加
	function dish_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		//更新操作
		if($id)
		{
			//查询数据
			$Obj = new IModel('dish');
			$where = 'id = '.$id;
			$Data = $Obj->getObj($where);
			if(count($Data) > 0)
			{
				$this->dishRow = $Data;
				$this->redirect('dish_edit',false);
			}	
		}
		//新增操作
		else 
		{
			$this->dishRow = array();
			$this->redirect('dish_edit');
		}
	}
	//添加或修改
	function dish_edit_act()
	{
		$id = IFilter::act(IReq::get('id'),'int');

		$Obj    = new IModel('dish');
		
		$picture = substr(IFilter::act(IReq::get('photo_name')),0,strpos(IFilter::act(IReq::get('photo_name')),','));
		
		if(!$picture)
		{
			$picture= "views/".$this->theme."/skin/".$this->skin."/images/front/service_ico.jpg";
		}	
		
		$DataArray = array(
			'type_id' => intval( IReq::get('type_id','post')),
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'content'  => IFilter::act( IReq::get('content','post'),'text'),
			'sort'      => intval( IReq::get('sort','post') ),
			'pic'   => $picture,
		);
		if($DataArray['type_id'] == 0)
		{
			$this->dishRow = $DataArray;
			$this->redirect('dish_edit',false);
			Util::showMessage('请选择分类');
		}
		if($id)
		{
			$where = 'id = '.$id;
			$Obj->setData($DataArray);
			$Obj->update($where);
		}
		else
		{
			$Obj->setData($DataArray);
			$is_success = $Obj->add();
		
			if($is_success)
			{
				$this->redirect('dish_list');
			}
			else
			{
				$this->dishRow = $DataArray;
				$this->redirect('dish_edit',false);
				Util::showMessage('插入数据时发生错误');
			}
		}

		$this->redirect('dish_list');
	}
	//删除
    function dish_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		$Obj = new IModel('dish');

		//开始删除
		if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$result = $Obj->del($where);               //删除商品
	
		}
		else
		{
			$this->redirect('dish_list',false);
			Util::showMessage('请选择要删除的内容');
		}
	    if($result==true )
		{
			$this->redirect('dish_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('dish_list',false);
			Util::showMessage($message);
		}
	}
	/****************************************************************************
 * 	
 * 温馨提示
 */	
	function reminder_edit($message = NULL)
	{
		//用户组
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query();
		$data_group = is_array($data_group) ? $data_group : array();
		$group      = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->data['group'] = $group;
		//显示提醒
		$rem_id = IFilter::act(IReq::get('id'));
		$rem_id = empty($rem_id)?0:$rem_id;
		if($rem_id)
		{
			$reminder = new IModel('reminder');
			$rem_data = $reminder->getObj("id=".$rem_id);
			$selected_ids = explode(',', $rem_data['user_ids']);//用户id
			//用户
			$mem_Obj = new IModel('user as u ,member as m');
			
			$user_data = array(array());
			foreach($selected_ids as $key=>$val)
			{
				$user_data[$key] = $mem_Obj->getObj("u.id=".$val." and u.id=m.user_id","m.*,u.username");
			}
			$this->data['users'] = $user_data;//选择的用户信息
			$this->data['reminder']=$rem_data;
		}
		$this->setRenderData($this->data);
		$this->redirect('reminder_edit',false);
		if($message != NULL)
		Util::showMessage($message);
	}
	function reminder_list($message = NULL)
	{
		$tb_reminder = new IQuery('reminder');
		$tb_reminder->order = "create_time desc"; 
		$data_reminders = $tb_reminder->find();
		$data_reminders = count($data_reminders)!=0 ? $data_reminders : array();
		
		if(!empty($data_reminders))
		{
			$this->data['reminder'] = $data_reminders;
			$this->query = $tb_reminder;
		}
		$this->setRenderData($this->data);
		$this->redirect('reminder_list',false);
		if($message != NULL)
		Util::showMessage($message);
	}
	function reminder_edit_act()
	{
		$title = IFilter::act(IReq::get('title'));
		$rem_content = IFilter::act(IReq::get('rem_content'));
		$user_ids = IReq::get('user_ids');
		$data = array(
		'title' =>$title,
		'content'=>$rem_content,
		'create_time'=>date('Y-m-d H:i:s')
		);
		if(empty($user_ids))//没有选择用户
		{
			$this->data['reminder']=$data;
			$this->reminder_edit("请选择用户");
		}
		else $user_ids = substr($user_ids,0,strlen($user_ids)-1);
		$ids_str = $user_ids;
		$user_ids  = explode(',', $user_ids);
		$data['user_ids'] = $ids_str;
		
		$reminders = new IModel('reminder');
		$reminders->setData($data);
		$id = $reminders->add();//成功添加提示
		if($id)
		{
			$mem_reminder= new IModel('member');
			foreach($user_ids as $val)
			{
				$reminder_ids = $mem_reminder->query('user_id='.$val);
				if(empty($reminder_ids[0]['reminder_ids'])) 
				$select_ids = ','.$id.',';
				else $select_ids = $reminder_ids[0]['reminder_ids'].$id.',';
				$mem_reminder->setData(array('reminder_ids'=>$select_ids));//更新用户表,保存提示的id值
				$mem_reminder->update('user_id ='.$val);	
			}
			$this->reminder_list("发送成功");
		}
		else {
			$this->data['reminder']=$data;
			$this->reminder_edit("创建失败，请重试");	
		}
	}
	function member_filter()
	{
		$and = ' and ';
		$where = 'm.status="1"'.$and;
		
		$group_key = IFilter::string(IReq::get('group_key'));
		$group_v = IFilter::act((IReq::get('group_value')),'int') ;
		if($group_key && $group_v)
		{
			if($group_key=='eq')
			{
				$where .= "m.group_id='{$group_v}' {$and}";
			}else
			{
				$where .= "m.group_id!='{$group_v}' {$and} ";
			}
		}
		$username_key = IFilter::string(IReq::get('username_key'));
		$username_v = IFilter::act(IReq::get('username_value'),'string');
		if($username_key && $username_v)
		{
			if($username_key=='eq')
			{
				$where .= "u.username='{$username_v}' {$and}";
			}else
			{
				$where .= 'u.username like "%'.$username_v.'%"'.$and;
			}
		}
		$truename_key = IFilter::string(IReq::get('truename_key'));
		$truename_v = IFilter::act(IReq::get('truename_value'),'string');
		if($truename_key && $truename_v)
		{
			if($truename_key=='eq')
			{
				$where .= "m.true_name='{$truename_v}' {$and}";
			}else
			{
				$where .= 'm.true_name like "%'.$truename_v.'%"'.$and;
			}
		}
		$mobile_key = IFilter::string(IReq::get('mobile_key'));
		$mobile_v = IFilter::act(IReq::get('mobile_value'),'string');
		if($mobile_key && $mobile_v)
		{
			if($mobile_key=='eq')
			{
				$where .= "m.mobile='{$mobile_v}' {$and} ";
			}else
			{
				$where .= 'm.mobile like "%'.$mobile_v.'%"'.$and;
			}
		}
		$telephone_key = IFilter::string(IReq::get('telephone_key'));
		$telephone_v = IFilter::act(IReq::get('telephone_value'),'string');
		if($telephone_key && $telephone_v)
		{
			if($telephone_key=='eq')
			{
				$where .= "m.telephone='{$telephone_v}' {$and} ";
			}else
			{
				$where .= 'm.telephone like "%'.$telephone_v.'%"'.$and;
			}
		}
		$email_key = IFilter::string(IReq::get('email_key'));
		$email_v = IFilter::act(IReq::get('email_value'),'string');
		if($email_key && $email_v)
		{
			if($email_key=='eq')
			{
				$where .= "u.email='{$email_v}' {$and} ";
			}else
			{
				$where .= 'u.email like "%'.$email_v.'%"'.$and;
			}
		}
		$address_key = IFilter::string(IReq::get('address_key'));
		$address_v = IFilter::act(IReq::get('address_value'),'string');
		if($address_key && $address_v)
		{
			if($address_key=='eq')
			{
				$where .= "u.email='{$address_v}' {$and} ";
			}else
			{
				$where .= 'u.email like "%'.$address_v.'%"'.$and;
			}
		}
		$sex = intval(IReq::get('sex'));
		if($sex && $sex!='-1')
		{
			$where .= 'm.sex='.$sex.$and;
		}
		$regtimeBegin = IFilter::string(IReq::get('regtimeBegin'));
		if($regtimeBegin)
		{
			$where .= 'm.time > "'.$regtimeBegin.'"'.$and;
		}
		$regtimeEnd = IFilter::string(IReq::get('regtimeEnd'));
		if($regtimeEnd)
		{
			$where .= 'm.time < "'.$regtimeEnd.'"'.$and;
		}
		$where .= ' 1 ';

		$query = new IQuery("member as m");
		$query->join = "left join user as u on m.user_id = u.id left join user_group as gp on m.group_id = gp.id";
		$query->fields = "m.*,u.username,u.email,gp.group_name";
		$query->where = $where;
		$result = $query->find();
		echo JSON::encode($result);
	}
	/***********************************************************************************************************************/
	
}//end the service calss