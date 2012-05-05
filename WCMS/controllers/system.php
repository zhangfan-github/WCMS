<?php

class System extends IController
{
	protected $checkRight  = array('index','upgrade_1','upgrade_2','upgrade_3','upgrade_4','upgrade_5','payment_list','delivery','area','conf_base','conf_ui','admin_list','admin_update','admin_edit','admin_recycle','role_list','role_edit','role_recycle','right_list','right_edit','right_update','right_recycle','res_act');
	public $layout      = 'admin';
	public $except      = array('.','..','.svn');
	public $defaultConf = 'config.php';
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
	
    function index()
	{
		$this->conf_base();
	}
	
	function login(){
		$this->redirect('/systemadmin/index');
	}
	
	/**
	 * @brief 已配置的支付方式列表
	 */
    public function payment_list()
    {
    	//初始化支付插件类
     	$payment = new Payment();
     	//获取已配置支付列表
     	$list = $payment->paymentList();
     	$this->setRenderData(array("payment_list"=>$list));
     	$this->redirect('payment_list');
    }
    public function delivery_edit()
	{
		$data = array();
        $id = IFilter::act(IReq::get('id'),'int');

        if(!empty($id))
        {
            $delivery = new IModel('delivery');
            $data = $delivery->query('id = '.$id);
			if(count($data)>0)
			{
				$this->data_info = $data;
				$this->redirect('delivery_edit');
			}
        }
        if(count($data)==0)
        {
        	$this->redirect('delivery_edit');
        }
	}
	public function delivery_operate()
	{
		$id = IReq::get('id');
		$op = IReq::get('op');
        if(is_array($id)) $id = implode(',',$id);

        if(empty($id))
        {
        	if($op == 'del' || $op == 'recover')
        	{
        		$this->redirect('delivery_recycle',false);
        	}
        	else
        	{
        		$this->redirect('delivery',false);
        	}
        	Util::showMessage('请选择要操作的选项');
        	exit;
        }

		$delivery =  new IModel('delivery');
		//物理删除
		if($op=='del')
		{
			$delivery->del('id in('.$id.')');
			$this->redirect('delivery_recycle');
		}
		else if($op =='recover')//还原
		{
			$delivery->setData(array('is_delete'=>0));
			$delivery->update('id in('.$id.')');
			$this->redirect('delivery_recycle');
		}
		else//逻辑删除
		{
			$delivery->setData(array('is_delete'=>1));
			$delivery->update('id in('.$id.')');
			$this->redirect('delivery');
		}
	}
    public function delivery_update()
    {
        $delivery =  new IModel('delivery');
		//配送方式名称
		$name = IReq::get('name');
		//类型
		$type = IReq::get('type');
        //首重重量
        $first_weight = IReq::get('first_weight');
        //续重重量
        $second_weight = IReq::get('second_weight');
        //首重价格
        $first_price = IReq::get('first_price');
        //续重价格
        $second_price = IReq::get('second_price');
        //是否支持物流保价
        $is_save_price = IReq::get('is_save_price');
        //地区费用类型
        $price_type = IReq::get('price_type');
        //启用默认费用
        $open_default = IReq::get('open_default');
        //支持的配送地区
        $area = serialize(IReq::get('area'));
        //支持的配送地区ID
        $area_groupid = serialize(IReq::get('area_groupid'));
        //配送地址对应的首重价格
        $firstprice = serialize(IReq::get('firstprice'));
        //配送地区对应的续重价格
        $secondprice = serialize(IReq::get('secondprice'));
        //排序
        $sort = IReq::get('sort');
        //状态
        $status = IReq::get('status');
        //描述
        $description = IReq::get('description');
        //保价费率
        $save_rate = IReq::get('save_rate');
        //最低保价
        $low_price = IReq::get('low_price');
		//ID
		$id = IReq::get('id');
        $data = array('name'=>$name,'type'=>$type,'first_weight'=>$first_weight,'second_weight'=>$second_weight,'first_price'=>$first_price,'second_price'=>$second_price,'is_save_price'=>$is_save_price,'price_type'=>$price_type,'open_default'=>$open_default,'area'=>$area,'area_groupid'=>$area_groupid,'firstprice'=>$firstprice,'secondprice'=>$secondprice,'sort'=>$sort,'status'=>$status,'description'=>$description,'save_rate'=>$save_rate,'low_price'=>$low_price);
        $delivery->setData($data);
		if($id=="") $delivery->add();
		else $delivery->update('id = '.$id);
		$this->redirect('delivery');
    }

   /**
    * 添加/修改支付方式插件
    */
    function payment_edit()
    {
        //支付方式插件编号
        $pluginId = IReq::get("id");
        //支付方式配置编号
        $payId = IReq::get("payid");
        //初始化支付插件类
        $payment = new Payment();
        $pay_info = array('type'=>1,'poundage_rate'=>0,'poundage_fix'=>0,'poundage_type'=>1,'config'=>'','description'=>' ');
        //如果支付配置编号已存在，查找支付方式配置表
        if($payId!=null)
        {
            $paymentObj = new IModel('payment');
        	$pay_info = $paymentObj->getObj("id = ".$payId);
        	$pluginId = $pay_info['plugin_id'];
        	if($pay_info['poundage_type']==1)
        	{
        		$pay_info['poundage_rate'] = $pay_info['poundage'];
        		$pay_info['poundage_fix'] = 0;
        	}
        	else
        	{
        		$pay_info['poundage_fix'] = $pay_info['poundage'];
        		$pay_info['poundage_rate'] = 0;
        	}
        }
		//初始化支付插件表
        $pay_pluginObj = new IModel('pay_plugin');
        //根据支付插件编号 获取该插件的详细信息
        $plugin_info = $pay_pluginObj->getObj("id = ".$pluginId);
        //根据支付插件file_path路径获取该支付插件的类
        $payObj = $payment->loadMethod($plugin_info['file_path']);
        if(!isset($pay_info['name']))
        	$pay_info['name'] = $plugin_info['name'];
        if($pay_info)
        	$config = unserialize($pay_info['config']);
         //获取支付插件字段
	    $aField = $payObj->getfields();
	    //支持货币
	    $pay_info['SupportCurrency'] = $payment->getSupportCurrency($payObj->supportCurrency);

	    if($aField)
	    {
		    //处理支付插件扩展属性
		    if(isset($config['ConnectType']))
		    {
		    	foreach($aField['ConnectType']['extendcontent'] as $key=>$val)
		    	{
				    foreach($val['value'] as $ekey => $eval)
				    {
				    	if(isset($config['bankId']))
				    	{
							foreach($config['bankId'] as $eitem)
							{
								if($eval['value']==$eitem)
								{
									$aField['ConnectType']['extendcontent'][$key]['value'][$ekey]['checked'] = 'checked';
									break;
								}
								else
								{
									$aField['ConnectType']['extendcontent'][$key]['value'][$ekey]['checked'] = '';
								}
							}
				    	}
				    }
		    	}

		    }
	    }

	    //插件类型
	    $pay_info['file_path'] = $plugin_info['file_path'];
        $pay_info['config'] = $config;
        $pay_info['attr_list'] = $aField;
        $pay_info['plugin_id'] = $pluginId;
        $pay_info['pay_id'] = $payId;
        //把数据渲染到视图
        $this->setRenderData($pay_info);
        $this->redirect('payment_edit');
    }

	/**
    * 删除已配置的支付插件
    */
    function payment_del()
    {
        //支付方式配置编号
        $payId = IReq::get("payid");
        //支付方式配置表
        $paymentObj = new IModel('payment');
		$paymentObj->del('id = '.$payId);
		//初始化支付方式类
		$payment = new Payment();
		//获取已配置支付列表
		$list = $payment->paymentList();
		//渲染数据到视图
     	$this->setRenderData(array("payment_list"=>$list));
		$this->redirect('payment_list');
    }

	/**
    * 启用/禁用支付插件
    *
    * @access public
    * @return void
    */
    function payment_enable()
    {
        //支付方式配置编号
        $payId = IReq::get("payid");
        //获取支付状态
        $status = IReq::get("status");
        //初始化支付插件配置表
        $paymentObj = new IModel('payment');
        //设置更新字段
        $fields['status'] = $status;
        $paymentObj->setData($fields);
        //更新数据
		$paymentObj->update('id = '.$payId);
		//渲染数据到视图
		$payment = new Payment();
		$list = $payment->paymentList();
     	$this->setRenderData(array("payment_list"=>$list));
		$this->redirect('payment_list');
    }

 	/**
    * @brief 更新支付方式插件
    */
    function payment_update()
    {
    	//获取Post数据
    	$payId = IReq::get("pay_id");
    	$field['name'] = IReq::get("name");
    	$field['type'] = IReq::get("type");
    	$field['description'] = IReq::get("description");
    	$field['poundage_type'] = IReq::get("poundage_type");
    	$poundage_rate = IReq::get("poundage_rate");
    	$poundage_fix = IReq::get("poundage_fix");
    	if($field['poundage_type']==1)
    		$field['poundage'] = $poundage_rate;
    	else
    		$field['poundage'] = $poundage_fix;
        $field['plugin_id'] = IReq::get("id");
        $field['order'] = IReq::get("order");

        $pay_type = IReq::get("pay_type");
        $setting = IReq::get("setting");
        $field['note'] = IReq::get('note');

        //上传文件处理
    	if($_FILES)
    	{//是否有文件上传
            $extend = array('key','crt','pem','cer');
            $upload = new IUpload(1024,$extend);
            $upload->setDir(IWEB::$app->config['upload'].'/payment/'.$pay_type);
            $file = $upload->execute();
            foreach($file['config'] as $key => $item)
            {
            	$setting[$key] = $item['dir'].$item['name'];
            }
        }
        $field['config'] = serialize($setting);
		//添加、修改已配置的支付插件
		$payment = new Payment();
		$result = $payment->Update($field,$payId);
		//
    	if($result===false)
		{
			if($payId)
				$url = 'payment_edit/payid/'.$payId;
			else
				$url = 'payment_edit/id/'.$field['plugin_id'];
			$this->redirect($url);
		}
		else
		{
			$list = $payment->paymentList();
     		$this->setRenderData(array("payment_list"=>$list));
			$this->redirect('payment_list');
		}
    }

	/**
	 * @brief 地区管理
	 */
	function area()
	{
		//加载地区
		$tb_areas = new IModel('areas');
		$this->data['area'] = $tb_areas->query('parent_id=0','*','sort','asc');
		$this->setRenderData($this->data);
		$this->redirect('area');
	}

	/**
	 * @brief 获取地区名称
	 */
	function area_name_child()
	{
		$aid = IFilter::string( IReq::get("aid") );
		$tb_areas = new IModel('areas');
		$areas = $tb_areas->query("parent_id=$aid",'*','sort','asc');
		echo JSON::encode($areas);
	}
	/**
	 * @brief 获取部分地区
	 */
	function area_sub_child()
	{
		$aid = IFilter::string( IReq::get("aid") );
		$tb_areas = new IModel('areas');
		$areas = $tb_areas->query("area_id in ($aid)",'*');
		echo JSON::encode($areas);
	}
	/**
	 * @brief 保存地区排序
	 */
	function area_sort()
	{
		$sort = IFilter::act( IReq::get("sort") ,'int' );
		$tb_category = new IModel("areas");
		foreach($sort as $key => $value)
		{
			if($id = (int)$key)
			{
				$tb_category->setData(array("sort"=>(int)$value));
				$tb_category->update("area_id=".$id);
			}
		}
		$this->redirect('area');
	}

	/**
	 * @brief 添加、修改地区
	 */
	function area_edit()
	{
		$area_id = IFilter::string(IReq::get('aid'));
		$parent_id = IFilter::string(IReq::get('pid'));
		$parent_id = intval($parent_id) ? intval($parent_id) : null;
		if($area_id)
		{
			$tb_area = new IQuery('areas as a1');
			$tb_area->join = 'left join areas as b1 on a1.parent_id = b1.area_id';
			$tb_area->where = 'a1.area_id='.$area_id;
			$tb_area->fields = 'a1.area_id,a1.area_name,a1.parent_id,b1.area_name as parent_name,a1.sort';
			$area_info = $tb_area->find();
			if($area_info && is_array($area_info) && $info=$area_info[0])
			{
				$this->data['area'] = array('area_id'=>$info['area_id'],'area_name'=>$info['area_name'],'parent_id'=>$info['parent_id'],'parent_name'=>$info['parent_name'],'sort'=>$info['sort']);
				$this->setRenderData($this->data);
			}
			else
			{
				$this->redirect('area');
			}
		}
		elseif($parent_id!==null)
		{
			$tb_areas = new IModel('areas');
			$area_info = $tb_areas->query('area_id='.$parent_id);
			if($area_info && is_array($area_info) && $info=$area_info[0])
			{
				$this->data['area'] = array('parent_id'=>$info['area_id'],'parent_name'=>$info['area_name']);
				$this->setRenderData($this->data);
			}
			else
			{
				$this->redirect('area');
			}
		}
		$this->redirect('area_edit');
	}

	/**
	 * @brief 保存添加、修改地区
	 */
	function area_save()
	{
		$area_id = IFilter::string(IReq::get('area_id'));
		$area_name = IFilter::string(IReq::get('area_name'));
		$parent_id = IFilter::string(IReq::get('parent_id'));
		$sort = IFilter::string(IReq::get('sort'));
		$parent_id = $parent_id ? $parent_id : 0;
		$sort = intval($sort) ? intval($sort) : 50;
		if($area_name)
		{
			$tb_areas = new IModel('areas');
			$tb_areas->setData(array('parent_id'=>$parent_id, 'area_name'=>$area_name, 'sort'=>$sort));
			if($area_id)	//update
			{
				$tb_areas->update('area_id='.$area_id);
			}
			else			//add
			{
				$tb_areas->add();
			}
		}
		$this->redirect('area');
	}

	/**
	 * @brief 删除地区
	 */
	function area_del()
	{
		$aid = IFilter::string(IReq::get('aid'));
		$tb_areas = new IModel('areas');
		$areas_info = $tb_areas->query('parent_id='.$aid);
		if($areas_info)
		{
			echo '-1';
		}
		else
		{
			$tb_areas->del('area_id='.$aid);
			echo '1';
		}
	}

	//[网站管理][站点设置]保存
	function save_conf()
	{
		//错误信息
		$message = null;
		$form_index = IReq::get('form_index');
		switch($form_index)
		{
			case "base_conf":
			{
				if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
				{
					$uploadObj = new PhotoUpload('image');
					$uploadObj->setIterance(false);
					$photoInfo = $uploadObj->run();

					if(!isset($photoInfo['logo']['img']) || !file_exists($photoInfo['logo']['img']))
					{
						$message = 'logo图片上传失败';
					}
					else
					{
						unlink('image/logo.gif');
						rename($photoInfo['logo']['img'],'image/logo.gif');
					}
				}
			}
			break;
			case "site_footer_conf":
				$_POST['site_footer_code']=preg_replace('![\\r\\n]+!',"",$_POST['site_footer_code']);
				break;


			case "index_slide":

				$config_slide = array();
				foreach($_POST['slide_name'] as $key=>$value)
				{
					$config_slide[$key]['name']=$value;
					$config_slide[$key]['url']=$_POST['slide_url'][$key];
					$config_slide[$key]['img']=$_POST['slide_img'][$key];
				}

				if( isset($_FILES['slide_pic'])  )
				{
					$uploadObj = new PhotoUpload();
					$uploadObj->setIterance(false);
					$slideInfo = $uploadObj->run();

					if( isset($slideInfo['slide_pic']['flag']) )
					{
						$slideInfo['slide_pic'] = array($slideInfo['slide_pic']);
					}

					if(isset($slideInfo['slide_pic']))
					{
						foreach($slideInfo['slide_pic'] as $key=>$value)
						{

							if($value['flag']==1)
							{
								$config_slide[$key]['img']=$value['img'];
							}
						}
					}

				}

				$_POST = array('index_slide' => serialize( $config_slide ));
				break;

			case "guide_conf":
			{
				$guideName = IFilter::act(IReq::get('guide_name'));
				$guideLink = IFilter::act(IReq::get('guide_link'));
				$data      = array();

				$guideObj = new IModel('guide');

				if(!empty($guideName))
				{
					foreach($guideName as $key => $val)
					{
						if(!empty($val) && !empty($guideLink[$key]))
						{
							$data[$key]['name'] = $val;
							$data[$key]['link'] = $guideLink[$key];
						}
					}
				}

				//清空导航栏
				$guideObj->del('all');

				if(!empty($data))
				{
					//插入数据
					foreach($data as $order => $rs)
					{
						$dataArray = array(
							'order' => $order,
							'name'  => $rs['name'],
							'link'  => $rs['link'],
						);
						$guideObj->setData($dataArray);
						$guideObj->add();
					}

					//跳转方法
					$this->conf_base($form_index);
				}
			}
			break;
			case "shopping_conf":
			break;
			case "show_conf":
				if( isset($_POST['auto_finish']) && $_POST['auto_finish']=="" )
				{
					$_POST['auto_finish']=="0";
				}
			break;

			case "image_conf":
			{
				$photoUrlArray = array();

				$uploadObj = new PhotoUpload('image');
				$uploadObj->setIterance(false);
				$photoInfo = $uploadObj->run();

				foreach($_FILES as $key => $val)
				{
					if($val['name'] != null)
					{
						if(!isset($photoInfo[$key]['img']) || !file_exists($photoInfo[$key]['img']))
						{
							$message = $key.'图片上传失败';
						}
						else
							$photoUrlArray[$key] = $photoInfo[$key]['img'];
					}
				}

				//存储图片
				if($message == null)
				{
					foreach($photoUrlArray as $k => $rs)
					{
						unlink('image/'.$k.'.gif');
						rename($rs,'image/'.$k.'.gif');
					}
				}
			}
			break;
			case "mail_conf":
			break;
			case "system_conf":
			break;
			case "weibo_conf":
			break;
		}

		//获取输入的数据
		$inputArray = $_POST;
		if($message == null)
		{
			if($form_index == 'system_conf')
			{
				//写入的配置文件
				$configFile = IWeb::$app->config['basePath'].'config/config.php';
				config::edit($configFile,$inputArray);
			}
			else
			{
				$siteObj = new Config('site_config');
				$siteObj->write($inputArray);
			}

			//跳转方法
			$this->conf_base($form_index);
		}
		else
		{
			$inputArray['form_index'] = $form_index;
			$this->confRow = $inputArray;
			$this->redirect('conf_base',false);
			Util::showMessage($message);
		}
	}

	//[网站管理]展示站点管理配置信息[单页]
	function conf_base($form_index = null)
	{
		//配置信息
		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();
		$main_config   = include(IWeb::$app->config['basePath'].'config/config.php');

		$configArray   = array_merge($main_config,$site_config);

		$configArray['form_index'] = $form_index;

		$this->confRow = $configArray;

		$this->redirect('conf_base',false);

		if($form_index != null)
		{
			Util::showMessage('保存成功');
		}
	}

	//[权限管理][管理员]管理员添加，修改[单页]
	function admin_edit()
	{
		$id =intval( IReq::get('id') );
		if($id)
		{
			$adminObj = new IModel('admin');
			$where = 'id = '.$id;
			$this->adminRow = $adminObj->getObj($where);
		}
		$this->redirect('admin_edit');
	}

	//[权限管理][管理员]检查admin_user唯一性
	function check_admin($name = null,$id = null)
	{
		//php校验$name!=null , ajax校验 $name == null
		$admin_name = ($name==null) ? IReq::get('admin_name','post') : $name;
		$admin_id   = ($id==null)   ? IReq::get('admin_id','post')   : $id;
		$admin_name = IFilter::act($admin_name);
		$admin_id = intval($id);


		$adminObj = new IModel('admin');
		if($admin_id)
		{
			$where = 'admin_name = "'.$admin_name.'" and id != '.$admin_id;
		}
		else
		{
			$where = 'admin_name = "'.$admin_name.'"';
		}

		$adminRow = $adminObj->getObj($where);

		if(!empty($adminRow))
		{
			if($name != null)
			{
				return false;
			}
			else
			{
				echo '-1';
			}
		}
		else
		{
			if($name != null)
			{
				return true;
			}
			else
			{
				echo '1';
			}
		}
	}

	//[权限管理][管理员]管理员添加，修改[动作]
	function admin_edit_act()
	{
		$id = intval( IReq::get('id','post') );
		$adminObj = new IModel('admin');

		//错误信息
		$message = null;

		$dataArray = array(
			'id'         => $id,
			'admin_name' => IFilter::string( IReq::get('admin_name','post') ),
			'role_id'    => intval( IReq::get('role_id','post') ),
			'email'      => IFilter::string( IReq::get('email','post') ),
		);

		//检查管理员name唯一性
		$isPass = $this->check_admin($dataArray['admin_name'],$id);
		if($isPass == false)
		{
			$message = $dataArray['admin_name'].'管理员已经存在,请更改名字';
		}

		//提取密码 [ 密码设置 ]
		$password   = IReq::get('password','post');
		$repassword = IReq::get('repassword','post');

		//修改操作
		if($id)
		{
			if($password != null || $repassword != null)
			{
				if($password == null || $repassword == null || $password != $repassword)
				{
					$message = '密码不能为空,并且二次输入的必须一致';
				}
				else
					$dataArray['password'] = md5($password);
			}

			//有错误
			if($message != null)
			{
				$this->adminRow = $dataArray;
				$this->redirect('admin_edit',false);
				Util::showMessage($message);
			}
			else
			{
				$where = 'id = '.$id;
				$adminObj->setData($dataArray);
				$adminObj->update($where);
			}
		}
		//添加操作
		else
		{
			if($password == null || $repassword == null || $password != $repassword)
			{
				$message = '密码不能为空,并且二次输入的必须一致';
			}
			else
				$dataArray['password'] = md5($password);

			if($message != null)
			{
				$this->adminRow = $dataArray;
				$this->redirect('admin_edit',false);
				Util::showMessage($message);
			}
			else
			{
				$dataArray['create_time'] = ITime::getDateTime();
				$adminObj->setData($dataArray);
				$adminObj->add();
			}
		}
		$this->redirect('admin_list');
	}

	//拼接更新条件
	function getUpdateWhere($id)
	{
		if(is_array($id) && isset($id[0]) && $id[0]!='')
		{
			$id_str = join(',',$id);
			$where = ' id in ('.$id_str.')';
		}
		else
			$where = 'id = '.$id;

		return $where;
	}

	//[权限管理][管理员]管理员更新操作[回收站操作][物理删除]
	function admin_update()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );

		if($id == 1 || (is_array($id) && in_array(1,$id)))
		{
			$this->redirect('admin_list',false);
			Util::showMessage('不允许删除系统初始化管理员');
		}

		//是否为回收站操作
		$isRecycle = IReq::get('recycle');

		if(!empty($id))
		{
			$obj   = new IModel('admin');
			$where = $this->getUpdateWhere($id);

			if($isRecycle === null)
			{
				$obj->del($where);
				$this->redirect('admin_recycle');
			}
			else
			{
				//回收站操作类型
				$is_del = ($isRecycle == 'del') ? 1 : 0;
				$obj->setData(array('is_del' => $is_del));
				$obj->update($where);
				$this->redirect('admin_list');
			}
		}
		else
		{
			if($isRecycle == 'del')
				$this->redirect('admin_list',false);
			else
				$this->redirect('admin_recycle',false);

			Util::showMessage('请选择要操作的管理员ID');
		}
	}

	//[权限管理][角色] 角色更新操作[回收站操作][物理删除]
	function role_update()
	{
		$id = intval( IReq::get('id') );

		//是否为回收站操作
		$isRecycle = IReq::get('recycle');

		if(!empty($id))
		{
			$obj   = new IModel('admin_role');
			$where = $this->getUpdateWhere($id);

			if($isRecycle === null)
			{
				$obj->del($where);
				$this->redirect('role_recycle');
			}
			else
			{
				//回收站操作类型
				$is_del    = ($isRecycle == 'del') ? 1 : 0;
				$obj->setData(array('is_del' => $is_del));
				$obj->update($where);
				$this->redirect('role_list');
			}
		}
		else
		{
			if($isRecycle == 'del')
				$this->redirect('role_list',false);
			else
				$this->redirect('role_recycle',false);

			Util::showMessage('请选择要操作的角色ID');
		}
	}

	//[权限管理][角色] 角色修改,添加 [单页]
	function role_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$adminObj = new IModel('admin_role');
			$where = 'id = '.$id;
			$this->roleRow = $adminObj->getObj($where);
		}
		$this->redirect('role_edit');
	}

	//[权限管理][角色] 角色修改,添加 [动作]
	function role_edit_act()
	{
		$id = intval( IReq::get('id','post') );
		$roleObj = new IModel('admin_role');

		//要入库的数据
		$dataArray = array(
			'id'     => $id,
			'name'   => IFilter::string( IReq::get('name','post') ),
			'rights' => null,
		);

		//检查权限码是否为空
		$rights = IFilter::act( IReq::get('right','post') );
		if(empty($rights) || $rights[0]=='')
		{
			$this->roleRow = $dataArray;
			$this->redirect('role_edit',false);
			Util::showMessage('请选择要分配的权限');
		}

		//拼接权限码
		$rightsStr = join(',',$rights);
		$rightsStr = ','.$rightsStr.',';
		$dataArray['rights'] = $rightsStr;

		$roleObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$roleObj->update($where);
		}
		else
		{
			$roleObj->add();
		}
		$this->redirect('role_list');
	}

	//[权限管理][权限] 权限修改，添加[单页]
	function right_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$adminObj = new IModel('right');
			$where = 'id = '.$id;
			$this->rightRow = $adminObj->getObj($where);
		}

		$this->redirect('right_edit');
	}

	//[权限管理][权限] 权限修改，添加[动作]
	function right_edit_act()
	{
		$id = intval( IReq::get('id','post') );
		$input_type = IReq::get('input_type','post');

		//权限码输入方式
		if($input_type == 1)
		{
			$ctrl   = IFilter::string( IReq::get('ctrl','post') );
			$action = IFilter::string( IReq::get('action','post') );
			$right  = $ctrl.'@'.$action;
		}
		else
		{
			$right  = IFilter::act(IReq::get('right'));
		}

		$dataArray = array(
			'id'    => $id,
			'name'  => IFilter::act( IReq::get('name','post') ),
			'right' => $right,
		);

		$rightObj = new IModel('right');
		$rightObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$rightObj->update($where);
		}
		else
		{
			$rightObj->add();
		}
		$this->redirect('right_list');
	}

	//[权限管理][权限] 权限更新操作 [回收站操作][物理删除]
	function right_update()
	{
		$id = intval( IReq::get('id') );

		//是否为回收站操作
		$isRecycle = IReq::get('recycle');

		if(!empty($id))
		{
			$obj   = new IModel('right');
			$where = $this->getUpdateWhere($id);

			if($isRecycle === null)
			{
				$obj->del($where);
				$this->redirect('right_recycle');
			}
			else
			{
				//回收站操作类型
				$is_del    = ($isRecycle == 'del') ? 1 : 0;
				$obj->setData(array('is_del' => $is_del));
				$obj->update($where);
				$this->redirect('right_list');
			}
		}
		else
		{
			if($isRecycle == 'del')
				$this->redirect('right_list',false);
			else
				$this->redirect('right_recycle',false);

			Util::showMessage('请选择要操作的权限ID');
		}
	}
	//[备份还原]数据库备份展示页面
	function db_bak()
	{
	$renderData = $this->get_table();
	$renderData = $this->prefixMatch($renderData);
	$this->setRenderData($renderData);
	$this->redirect('db_bak');
	}

	//[备份还原]数据库前缀匹配
	function prefixMatch($tableInfo)
	{
	$tablePre = 'gtwebsite_';
	$len = count($tableInfo['tableInfo']);
	for($i = 0; $i < $len; $i++)
	{
	//print($tableInfo['tableInfo'][$i]['Name']);
	if(stristr($tableInfo['tableInfo'][$i]['Name'], $tablePre) == false)
	{
	unset($tableInfo['tableInfo'][$i]);
	}
	}
	return $tableInfo;

	}

	//[备份还原]获取表结构
	function get_table()
	{
		//数据表信息
		$dbObj     = IDBFactory::getDB();
		$tableInfo = $dbObj->query('show table status');

		//要渲染的数据
		$renderData = array(
			'tableInfo' => $tableInfo,
		);
		return $renderData;
	}

	//[备份还原]数据备份动作(ajax操作)
	function db_act_bak()
	{
		//要备份的数据表
		$tableName = IReq::get('name','post');
		$tableName = IFilter::act($tableName,"string");

		//分卷大小限制(KB)
		$partSize = 4000;

		if(is_array($tableName) && isset($tableName[0]) && $tableName[0]!='')
		{
			$backupObj = new DBBackup($tableName);
			$backupObj->setPartSize($partSize);   //设置分卷大小
			$backupObj->runBak();                 //开始执行
			$result = array(
				'isError' => false,
				'redirect'=> 'db_res',
			);
		}
		else
		{
			$result = array(
				'isError' => true,
				'message' => '请选择要备份的数据表',
			);
		}
		echo JSON::encode($result);
	}

	//[备份还原]数据库恢复
	function db_res()
	{
		$backupObj = new DBBackup;
		$resList = $backupObj->getList();
		$this->setRenderData($resList);
		$this->redirect('db_res',false);
	}

	//[备份还原]下载数据库
	function download()
	{
		$file = IReq::get('file');
		$backupObj = new DBBackup;
		$backupObj->download($file);
	}

	//[备份还原]删除备份
	function backup_del()
	{
		$name = IReq::get('name');
		$name = IFilter::act($name,'string');
		if(!empty($name) && !is_array($name))
			$name = array($name);

		if(is_array($name) && isset($name[0]) && $name[0]!='')
		{
			$backupObj = new DBBackup($name);
			$backupObj->del();
			$this->redirect('db_res');
		}
		else
		{
			$backupObj = new DBBackup;
			$resList = $backupObj->getList();
			$this->setRenderData($resList);
			$this->redirect('db_res',false);
			Util::showMessage('请选择要删除的备份文件');
		}
	}

	//[备份还原]导入数据(ajax)
	function res_act()
	{
		$name = IFilter::act(IReq::get('name'));
		if(is_array($name) && isset($name[0]) && $name[0]!='')
		{
			$backupObj = new DBBackup($name);
			$backupObj->runRes();
			$result = array(
				'isError' => false,
				'redirect'=> 'db_bak',
			);
		}
		else
		{
			$result = array(
				'isError' => true,
				'message' => '请选择要导入的SQL文件',
			);
		}
		echo JSON::encode($result);
	}

	//[备份还原]打包下载(ajax)
	function download_pack()
	{
		$name = IReq::get('name');
		$name = IFilter::act($name,'string');
		if(is_array($name) && isset($name[0]) && $name[0]!='')
		{
			$backupObj = new DBBackup($name);
			$fileName  = $backupObj->packDownload();
			if($fileName!==null)
				$result = array('isError' => false,'redirect'=> 'download/file/'.$fileName);
			else
				$result = array('isError' => true,'message'=> '打包失败');
		}
		else
			$result = array('isError' => true,'message' => '请选择要打包的文件');

		echo JSON::encode($result);
	}

	/**
	 * @brief 获取语言包,主题,皮肤的方案
	 * @param string $type  方案类型: theme:主题; skin:皮肤; lang:语言包;
	 * @param string $theme 此参数只有$type为skin时才有用，获取任意theme下的skin方案;
	 * @return string 方案的路径
	 */
	function getSitePlan($type,$theme = null)
	{
		$planPath  = null;    //资源方案的路径
		$planList  = array(); //方案列表
		$configKey = array('name','version','author','time','thumb','info');

		//根据不同的类型设置方案路径
		switch($type)
		{
			case "theme":
			$planPath = self::getViewPath().'../';
			break;

			case "skin":
			{
				if($theme == null)
					$planPath = self::getSkinPath().'../';
				else
				{
					$skinStr  = basename(dirname(self::getSkinPath()));
					$planPath = dirname(self::getViewPath()).'/'.$theme.'/'.$skinStr;
				}
			}

			break;

			case "lang":
			$planPath = self::getLangPath().'../';
			break;
		}

		if($planPath != null)
		{
			$planList = array();
			$dirRes   = opendir($planPath);

			while($dir = readdir($dirRes))
			{
				if(!in_array($dir,$this->except))
				{
					$fileName = $planPath.'/'.$dir.'/'.$this->defaultConf;
					$tempData = file_exists($fileName) ? include($fileName) : array();
					if(!empty($tempData))
					{
						//拼接系统所需数据
						foreach($configKey as $val)
						{
							if(!isset($tempData[$val]))
							{
								$tempData[$val] = null;
							}
						}
						$planList[$dir] = $tempData;
					}
				}
			}
		}
		return $planList;
	}

	//皮肤管理页面
	function conf_skin()
	{
		$theme = IFilter::string( IReq::get('theme') );
		if($theme == null)
		{
			$this->redirect('conf_ui');
		}
		else
		{
			$isLocal = ($this->theme == $theme) ? true : false;
			$dataArray = array(
				'theme'   => $theme,
				'isLocal' => $isLocal,
			);

			$this->setRenderData($dataArray);
			$this->redirect('conf_skin');
		}
	}

	//清理缓存
	function clearCache()
	{
		$runtimePath = $this->module->getRuntimePath();
		$result      = IFile::clearDir($runtimePath);

		if($result == true)
			echo 1;
		else
			echo -1;
	}

	//启用主题
	function applyTheme()
	{
		$theme = IFilter::string(IReq::get('theme'));
		$skin  = null;
		if($theme != '')
		{
			//获取$theme主题下皮肤方案
			$skinList = array_keys($this->getSitePlan('skin',$theme));

			if(!empty($skinList))
			{
				$skin = $skinList[0];
			}

			$data  = array(
				'theme' => $theme,
				'skin'  => $skin,
			);
			Config::edit('config/config.php',$data);
			$this->clearCache();
		}
		$this->redirect('conf_ui');
	}
	//启用皮肤
	function applySkin()
	{
		$skin  = IFilter::string( IReq::get('skin') );
		if($skin != null)
		{
			$data  = array(
				'skin'  => $skin,
			);
			Config::edit('config/config.php',$data);
		}
		$this->clearCache();
		$this->redirect('conf_ui');
	}
	//管理员快速导航
	function navigation()
	{
		$data = array();
		$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
		$this->redirect('navigation');
	}
	//管理员添加快速导航
	function navigation_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$navigationObj = new IModel('quick_naviga');
			$where = 'id = '.$id;
			$this->navigationRow = $navigationObj->getObj($where);
		}
		$this->redirect('navigation_edit');
	}
	//保存管理员添加快速导航
	function navigation_update()
	{
		$id = IFilter::act(IReq::get('id','post'),'int');
		$navigationObj = new IModel('quick_naviga');
		$navigationObj->setData(array(
			'adminid'=>$this->admin['admin_id'],
			'naviga_name'=>IFilter::act(IReq::get('naviga_name')),
			'url'=>IFilter::act(IReq::get('url')),
		));
		if($id)
		{
			$navigationObj->update('id='.$id);
		}
		else
		{
			$navigationObj->add();
		}
		$this->redirect('navigation');
	}
	/**
	 * @brief 删除管理员快速导航到回收站
	 */
	function navigation_del()
	{
		$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
		//post数据
    	$id = IFilter::act(IReq::get('id'),'int');
    	//生成order对象
    	$tb_order = new IModel('quick_naviga');
    	$tb_order->setData(array('is_del'=>1));
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
			$tb_order->update($where);
			$this->redirect('navigation');
		}
		else
		{
			$this->redirect('navigation',false);
			Util::showMessage('请选择要删除的数据');
		}
	}
	//管理员快速导航_回收站
	function navigation_recycle()
	{
		$data = array();
		$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
		$this->redirect('navigation_recycle');
	}
	//彻底删除快速导航
	function navigation_recycle_del()
    {
    	$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
    	//post数据
    	$id = IFilter::act(IReq::get('id'),'int');
    	//生成order对象
    	$tb_order = new IModel('quick_naviga');
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
			$tb_order->del($where);
			$this->redirect('navigation_recycle');
		}
		else
		{
			$this->redirect('navigation_recycle',false);
			Util::showMessage('请选择要删除的数据');
		}
    }
    //恢复快速导航
	 function navigation_recycle_restore()
    {
    	$ad_id = $this->admin['admin_id'];
		$data['ad_id'] = $ad_id;
		$this->setRenderData($data);
    	//post数据
    	$id = IFilter::act(IReq::get('id'),'int');
    	//生成order对象
    	$tb_order = new IModel('quick_naviga');
    	$tb_order->setData(array('is_del'=>0));
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
			$tb_order->update($where);
			$this->redirect('navigation_recycle');
		}
		else
		{
			$this->redirect('navigation_recycle',false);
			Util::showMessage('请选择要还原的数据');
		}
    }

     /******************************************************
     * 2011-12-06
     * Author:Qiulin
     * ip访问控制
     ******************************************************/
    //ip访问控制
    function ip_access()
    {
    	$ip_data = array();
  		$ipObj = new IModel('ipaccess');
   		$where = '';
   		$ip_data = $ipObj->getObj($where);
   		if(count($ip_data)>0)
   		{
   			$this->ipRow = $ip_data;
   			$this->redirect('ip_access',false);
   		}
   		else
   		{
   			$this->redirect('ip_access');
   		}
    }
    
    //ip访问控制操作
    function ip_access_act()
    {
    	$id = intval(IReq::get('id','get'));
    	$re_start_ip = IFilter::act(IReq::get('start_ip_'.$id,'post'),'string');
    	$re_end_ip = IFilter::act(IReq::get('end_ip_'.$id,'post'),'string');
    	$start_ip = IFilter::act(IReq::get('input_start_ip','post'),'string');
    	$end_ip = IFilter::act(IReq::get('input_end_ip','post'),'string');
    	
    	$ipObj = new IModel('ipaccess');

    	
    	if(count($id)>0)
    	{
    		if(!empty($re_start_ip) && !empty($re_end_ip))
    		{
	    		$where = 'id = '.$id;
	    		$reData = array(
	    			'start_ip' => $re_start_ip,
	    			'end_ip' => $re_end_ip,
	    		);
	    		$ipObj->setData($reData);
	    		$ipObj->update($where);
    		}
    	}
    	if(!empty($start_ip)&&!empty($end_ip))
    	{
    		$addData = array(
    			'start_ip' => $start_ip,
    			'end_ip' => $end_ip,
    		);
    		$ipObj->setData($addData);
    		$ipObj->add();
    	}
    	
    	$this->redirect('ip_access');

    	
    }
    //删除ip记录
    function ip_access_del()
    {
    	$id = intval(IReq::get('id','get'));
    	$ipObj = new IModel('ipaccess');
    	$where = 'id = '.$id;
    	if(!empty($id))
    	{
    		$ipObj->del($where);
    	}
    	
    	$this->redirect('ip_access');
    }
    /********************* E  N  D *******************/
    
    /*系统升级，一共三步*/
    public function upgrade_1()
    {
    	//检测新版本
    	$upgrade = new IWebUpgrade('shop');
    	$version = $upgrade->check_latest_version();

    	$path = IWeb::$app->getBasePath()."docs/version.php";
    	if(file_exists($path))
    	{
    		$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
    		$num = explode(".",$current_version);
    		$num = intval($num[2]);
    		if($version['version_num'] > $num)
    		{
    			$this->version = $version;
    		}
    	}
    	$this->redirect('upgrade_1');
    }

    public function upgrade_2()
    {
    	$version = IReq::get('version');
    	if($version === null)
    	{
    		die();
    	}

    	$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
    	if($current_version == $version)
    	{
    		$this->redirect('/system/upgrade_1');
    	}

    	$upgrade = new IWebUpgrade('shop',$version);
    	$file_list = $upgrade->get_files_info($current_version);
    	$changed = false;
    	$chmod_file_list = array();
    	//对各个文件进行比对，注意当前工作目录是index.php所在目录
    	foreach($file_list as $key => $value)
    	{
    		$path = $value['path'];
    		if( file_exists($path) && strtolower(md5_file($path)) != $value['hash'] )
    		{
    			$file_list[$key]['changed'] = true;
    			$changed = true;
    		}
    		else
    		{
    			$file_list[$key]['changed'] = false;
    		}
    		$chmod_file_list[]=$value['path'];
    	}

    	//必要的文件权限检测
    	//docs/version.php、根目录是否可写、要替换的文件、backup/upgrade/文件夹
    	$chmod_file_list[]="docs/version.php";
    	$chmod_file_list[]="./";
    	$chmod_file_list[]="backup/upgrade";
    	$chmod_flag = true;
    	foreach($chmod_file_list as $key=>$value)
    	{
    		$flag = IWebUpgrade::can_write($value);
    		$chmod_flag = $chmod_flag && $flag;
    		$chmod_file_list[$key] = array('path'=>$value,'flag'=>$flag);
    	}
    	$this->chmod_flag = $chmod_flag;
    	$this->chmod_file_list = $chmod_file_list;


    	$this->file_list = $file_list;
    	$this->changed = $changed;
    	$this->version = $version;
    	$this->redirect('upgrade_2');
    }

    public function upgrade_3()
    {
    	$version = IReq::get('version');
    	if($version == null)
    	{
    		die();
    	}
    	$this->version=$version;

    	$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
    	if($current_version == $version)
    	{
    		$this->redirect('/system/upgrade_1');
    	}

    	$this->redirect('upgrade_3');
    }

    public function upgrade_4()
    {
    	$version = IReq::get('version');
    	if($version == null)
    	{
    		die();
    	}

    	$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
    	if($current_version == $version)
    	{
    		$this->redirect('/system/upgrade_1');
    	}
    	$upgrade = new IWebUpgrade('shop',$version);
    	$re = $upgrade->download($current_version);
    	echo $re?"success":"";
    	ISafe::set("upgrade_version",$version);
    	exit;
    }

    public function upgrade_5()
    {
    	//执行sql等清理
    	$version = ISafe::get("upgrade_version");
    	if($version == null)
    	{
    		die();
    	}
    	$upgrade = new IWebUpgrade('shop',$version);
    	$upgrade->upgrade();
    	echo "success";
    	exit;
    }
    
    //[栏目管理] 网站栏目列表
	function column_list()
	{
		$this->redirect('column_list');
	}
	//[栏目管理] 增加修改单页
	function column_edit()
	{
		$data = array();
		$id = intval( IReq::get('id') );
		$type = IFilter::act( IReq::get('type','get'),'string');

		if($id)
		{
			$catObj = new IModel('column');
			$where  = 'id = '.$id;
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$this->catRow = $data;
				$this->redirect('column_edit',false);
			}
		}else{
			$this->catRow = array('type'=>$type);
			$this->redirect('column_edit');
		}


	}

	//[栏目管理] 增加和修改动作
	function column_edit_act()
	{
		$id        = intval( IReq::get('id','post') );
		$parent_id = intval( IReq::get('parent_id','post') ) ;

		$catObj    = new IModel('column');
		$DataArray = array(
			'parent_id' => $parent_id,
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'issys'     => intval( IReq::get('issys','post') ),
			'sort'      => intval( IReq::get('sort','post') ),
			'type'      => IFilter::act( IReq::get('column_type_id','post'),'string'),
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
					$childObj = new IModel('column');
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
			$b = IFilter::act( IReq::get('column_type_id','post'),'string');
			$findObj = new IModel("column_type");
			$where = "code = ".$b;
			$findRow = $findObj->getObj($where);
			if($findRow['name'] == '内容')
			{
				$addData = array(
					"column_id" => $a,
					'content'=>'',
				);
				$addObj = new IModel('content');
				$addObj->setData($addData);
				$addObj->add();
			}
		}
		$this->redirect('column_list');
	}

	//[栏目管理] 删除
	function column_del()
	{
		$id = intval( IReq::get('id') );
		$catObj = new IModel('column');
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

		//检测是否有article的category_id 为 $id
		else
		{
			$articleObj = new IModel('article');
			$where = 'category_id = '.$id;
			$catData = $articleObj->getObj($where);

			if(!empty($catData))
			{
				$isCheck=false;
				$message='此分类下还有文章';
			}
		}

		//开始删除
		$where  = 'id = '.$id;
		$result = $catObj->del($where);
		if($result==true && $isCheck==true)
		{
			$where1  = 'column_id = '.$id;
			$result1 = $catObj1->del($where1);
			$this->redirect('column_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('column_list',false);
			Util::showMessage($message);
		}
	}

}
