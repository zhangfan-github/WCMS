<?php
/**
 * @copyright (c) 2009-2011 jooyea.net
 * @file member.php
 * @brief 会员类控制器
 * @author Ben
 * @date 2011-1-18
 */

class Member extends IController
{
	protected $checkRight  = array('member_edit','member_list','group_edit','group_list','withdraw_list','tpl_list','notify_list');
    public $layout='admin';
	private $data = array();

	/**
	 * @brief 构造函数，调用父类构造函数、声明语言包对象
	 */
	function __construct()
	{
		parent::__construct(IWeb::$app,strtolower(__CLASS__));
		$this->lang = new ILanguage();
	}

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
	/**
	 * 2012.04.26
	 * author:zhangfan
	 * @brief 添加_编辑vip会员
	 */
	 function vip_member_list()
	{
		$search = IFilter::string(IReq::get('search'));
		$keywords = IFilter::string(IReq::get('keywords'));
		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search like '%{$keywords}%' ";
		}
		$this->data['search'] = $search;
		$this->data['keywords'] = $keywords;
		$this->data['where'] = $where;
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query("group_name not like '%VIP%'");
		$data_group = is_array($data_group) ? $data_group : array();
		$group      = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->data['group'] = $group;
		$this->setRenderData($this->data);
		$this->redirect('vip_member_list');
	}
	function vip_member_edit($userid = NULL,$message = NULL,$form_id = NULL)
	{
		
		
		$uid = intval(IReq::get('uid'));
		if($userid != NULL)
			$uid = $userid;
		$tb_user_group = new IModel('user_group');
		$group_info = $tb_user_group->query();
		$this->data['group'] = $group_info;
		$this->data['province'] = '';
		$this->data['city'] = '';
		$this->data['area'] = '';
		//编辑会员信息 读取会员信息
		if($uid)
		{
			$tb_user = new IModel('user');
			$tb_member = new IModel('member');
			$tb_member_info = new IModel('member_info');
			$tb_member_attribute = new IModel('member_attribute');
			
			$user_info = $tb_user->query("id=".$uid);
			$base_info = $tb_member->query("user_id=".$uid);
			
			$adv_info = $tb_member_info->query("user_id=".$uid);
			$ainfo= empty($adv_info)?array():$adv_info[0];
			
			$attribute_info = $tb_member_attribute->query("user_id=".$uid);
            $attribute_info = empty($attribute_info)?array():$attribute_info;
            
			$this->data['attribute'] = array();
			foreach($attribute_info as $key=>$val)
			{
				$this->data['attribute'][$val['attribute_id']] = $val['value'];
			}

			if(is_array($user_info) && ($uinfo=$user_info[0]) && is_array($base_info) && ($binfo=$base_info[0]))
			{
				$newarray = array_merge($uinfo,$binfo,$ainfo);
				$this->data['member'] = $newarray;
			}
			else
			{
				$this->member_list();
				Util::showMessage("没有找到相关记录！");
				return;
			}
		}
		$advice_page = IReq::get('page');
    	$form_id = empty($advice_page)?$form_id:2;//专家建议页
    	$this->form_id = ($form_id==NULL)?0:$form_id;//选择标签号
    	
    	$div_id = IReq::get('div_id');
    	$this->div_id = empty($div_id)?NULL:$div_id;
		
		$this->setRenderData($this->data);
		$this->redirect('vip_member_edit',false);
		if($message != NULL)
		Util::showMessage($message);
	}
	//保存会员基本信息
	function member_baseinfo_save()
	{
		//基本信息
		$user_id = intval(IReq::get('user_id'));
		$user_id = $user_id==''?NULL:$user_id;
		$memberObj = new IModel('member');
		$userObj   = new IModel('user');
		
		//拼接出生日期
		$year = IFilter::act(IReq::get('year'));
		$month = IFilter::act(IReq::get('month'));
		$day = IFilter::act(IReq::get('day'));
		$birthday = $year.'-'.$month.'-'.$day;
		//手机号码
		$mobile_a = IFilter::act(IReq::get('mobile_a'));
		$mobile_b = IFilter::act(IReq::get('mobile_b'));
		$mobile_c = IFilter::act(IReq::get('mobile_c'));
		//登录信息
		$truename= IFilter::act(IReq::get('true_name'));
		$email = IFilter::act(IReq::get('email'));
		$pw = IFilter::act(IReq::get('password'));
		$member_data = array(
				'vip_id'         => IFilter::act(IReq::get('vip_id')),
				'true_name'      => IFilter::act(IReq::get('true_name')),
				'sex'            => IReq::get('sex'),
				'job'            => IFilter::act(IReq::get('job')),
				'nation'         => IFilter::act(IReq::get('nation')),
				'birthday'       => $birthday,
				'birth_place'    => IFilter::act(IReq::get('birth_place')),
				'qq'             => IFilter::act(IReq::get('qq')),
				'mobile_a'       => $mobile_a,
				'mobile_b'       => $mobile_b,
				'mobile_c'       => $mobile_c,
				'connecter'      => IFilter::act(IReq::get('connecter')),
				'telephone'      => IFilter::act(IReq::get('telephone')),
				'contact_addr'   => IFilter::act(IReq::get('contact_addr')),
				'yuchanqi'       => IFilter::act(IReq::get('yuchanqi')),
				'first_hospital' => IFilter::act(IReq::get('first_hospital'))
		);
		
		
		$user_data = array(
			'vip_id'         => IFilter::act(IReq::get('vip_id')),
			'username'       => IFilter::act(IReq::get('vip_id')),
			'email'          => $email,
			);
		
		
		//正确性验证
		$message = '';//错误信息
		
		if(empty($pw)&& empty($user_id))
			$message = "请填写初始密码";
		if(empty($truename))
			$message = "请填写真实姓名";
		if(!empty($email))
		{
			if(!IValidate::email($email))
			{
				unset($user_data['email']);
				$message = "Email格式错误";
			}
			
			$same_email = $userObj->query("email ='".$email."'");
			if(count($same_email)>0 && $user_id == NULL)
			{
				unset($user_data['email']);
				$message = "Email地址已被使用,请更换";
			}
		}
		else {
			$message = "请填写Email";
		}

		
		if( $mobile_a !='' && !IValidate::mobi($mobile_a) )
		{
			$message = "请输入正确的本人手机号码";
			
		}
		if( $mobile_b !='' && !IValidate::mobi($mobile_b))
		{
			$message = "请输入正确的配偶手机号码";
			
		}
		if( $mobile_c !='' && !IValidate::mobi($mobile_c))
		{
			$message = "请输入正确的联系人手机号码";
			
		}
		$telephone = IFilter::act(IReq::get('telephone'));
		if( ($telephone !='' && !IValidate::phone($telephone)) )
		{
			$message = "请输入正确的固定电话";
			unset($member_data['telephone']);
		}
		//记录已填写的正确信息
		$this->data['member'] = array_merge($user_data,$member_data);
		if($message =='')
		{
			//基本属性
			if($user_id)//更新用户
			{
				unset($member_data['vip_id']);
				unset($user_data['vip_id']);
				unset($user_data['username']);
				$memberObj->setData($member_data);
				$userObj->setData($user_data);
				
				$rs1 = $memberObj->update("user_id=".$user_id);
				$rs2 = $userObj->update("id=".$user_id);
				$rs3 = $this->attribute_save($user_id,1);//更新附加属性
				if($rs1!== false&&rs2!== false&&rs3!== false)
				{
				    $this->vip_member_edit($user_id,"更新成功");
				}
				else 
				{
					$this->vip_member_edit($user_id,"更新失败");
				}
					
			}
			else //新建用户
			{
				
				
				$password = IFilter::act(IReq::get('password'));
				$user_data['password'] = md5($password);
				$userObj->setData($user_data);
				$new_user_id = $userObj->add();//在user表添加
				
				if($new_user_id)
				{
					$user_id = $new_user_id;
					
					$member_infoObj = new IModel('member_info');
					$member_infoObj->setData(array('user_id'=>$user_id));
					
					$member_data['user_id'] = $user_id;
					$member_data['group_id'] = 3;
					$member_data['time'] = date('Y-m-d H:i:s');
					$memberObj->setData($member_data);
					
				  	$rs1 = $memberObj->add();//在member表添加
				  	$rs2 = $member_infoObj->add();//在member_info表添加
				    $rs3 = $this->attribute_save($user_id,1);//更新附加属性
				    
					if($rs1 !== false && $rs2!== false && $rs3 !== false)
						$this->vip_member_edit($user_id,"添加成功");
					else 
						$this->vip_member_edit($user_id,"添加失败,请重试");
				}
				else {
					$this->vip_member_edit(NULL,"添加失败,请重试");
				}
			}
		}
		else{
			//返回错误信息
			$this->setRenderData($this->data);
			$this->vip_member_edit($user_id,$message);
		}
	}
	//保存会员专业信息
	function member_advinfo_save()
	{
		//基本信息
		$user_id = intval(IReq::get('user_id'));
		$user_id = $user_id==''?NULL:$user_id;
		//正确性验证
		$message = '';//错误信息
		
		
		if($message =='')
		{

			$member_infoObj = new IModel('member_info');

			$member_info_data = array(
					'height'         => IFilter::act(IReq::get('height')),
					'weight'         => IFilter::act(IReq::get('weight')),
					'pre_weight'     => IFilter::act(IReq::get('pre_weight')),
					'yaowei'		 => IFilter::act(IReq::get('yaowei')),
					'fuwei'			 => IFilter::act(IReq::get('fuwei')),
					'tunwei'         => IFilter::act(IReq::get('tunwei')),
					'WHR'			 => IFilter::act(IReq::get('WHR')),
					'BMI'			 => IFilter::act(IReq::get('BMI')),
					'blood_pressure' => IFilter::act(IReq::get('blood_pressure')),
					'xhdb'			 => IFilter::act(IReq::get('xhdb')),
					'gsthick'		 => IFilter::act(IReq::get('gsthick')),
					'jxthick'		 => IFilter::act(IReq::get('jxthick')),
					'qjthick'		 => IFilter::act(IReq::get('qjthick')),
					'fbthick'		 => IFilter::act(IReq::get('fbthick')),
					'buru'		 	 => IFilter::act(IReq::get('buru')),
					'work_hardness'	 => IFilter::act(IReq::get('work_hardness')),
					'disease_history'=> IFilter::act(IReq::get('disease_history')),
					'allergy_history'=> IFilter::act(IReq::get('allergy_history')),
					'family_history' => IFilter::act(IReq::get('family_history')),
			);
			$member_infoObj->setData($member_info_data);
			
			
			//基本属性
			if($user_id)//更新用户
			{
				$rs1 = $member_infoObj->update("user_id =".$user_id);
				$rs2 = $this->attribute_save($user_id,2);//更新附加属性
				if($rs1!== false&&rs2!== false)
				{
				    $this->vip_member_edit($user_id,"更新成功",1);
				}
				else 
				{
					$this->vip_member_edit($user_id,"更新失败",1);
				}	
			}
			else //新建用户
			{
				$this->vip_member_edit(NULL,"未创建用户");
			}
		}
		else{
			//返回错误信息
			$this->vip_member_edit($user_id,$message,1);
		}
	}
	/**修改附加属性
	 * 用户id，table_id：表号
	 */
	function attribute_save($user_id,$talbe_id)
	{
		$flag = true;
		$ext = new IModel('attribute');
		$base_ext = new IModel('member_attribute');
		
		$ext_info = $ext->query("table_id = ".$talbe_id);
		foreach($ext_info as $key=>$val)
		{
			//获取填入的数据
			$tagname = 'attr'.$val['id'];
			$tagvalue = IFilter::act(IReq::get($tagname));
			//判断之前是否添加过该属性
			$ext_info = $base_ext->query("user_id =".$user_id." and attribute_id = ".$val['id']);
			if($tagvalue != '')//有填入数据
			{
				$base_ext->setData(array('user_id'=>$user_id,'attribute_id'=>$val['id'],'value'=>$tagvalue));
				if(count($ext_info)>0)//之前添加过该属性
				{
					$flag = $base_ext->update("user_id =".$user_id." and attribute_id = ".$val['id']);
				} 
				else 
					$flag = $base_ext->add();
			}
			else 
				$flag = $base_ext->del("user_id =".$user_id." and attribute_id = ".$val['id']);
		}
		if($flag !== false)
		return true;
		else 
		return false;
	}
	function attribute_edit($message = NULL)
    {
		$attr = new IModel('attribute');
		$this->data['attr1'] = $attr->query("table_id = 1","*","sort","ASC");
		$this->data['attr2'] = $attr->query("table_id = 2","*","sort","ASC");
		$this->setRenderData($this->data);
		$this->redirect('attribute_edit',false);
		if($message != NULL)
		Util::showMessage($message);
    }
	function attribute_update()
    {
    	// 获取POST数据
    	$attr = array(array());
    	$attr = IReq::get("attr",'post');
    	//标记值
    	$flag1 = 1;
    	$flag2 = 1;
    	$flag3 = 1;
    	//要删除的属性
    	$delete_item = IReq::get("delete_item",'post');
    	
    	$attribute = new IModel('attribute');
    	if(!empty($delete_item))
    	{
    		$delete_item = substr($delete_item, 0,strlen($delete_item)-1);
    		if($attribute->del('id in('.$delete_item.')') !== false)
    		$flag3 = 1;
    		else
    		{ 
    			$flag3 = 0;
    			$this->attribute_edit("删除失败,请重试");
    		}
    	}
    	for($i = 0; $i < count($attr['id']); $i++)
    	{
    		$data = array(
    			'name' =>$attr['name'][$i],
    			'type' =>$attr['type'][$i],
    			'value'=>$attr['value'][$i],
    			'table_id'=>$attr['table_id'][$i],
    		    'sort'=>$attr['sort'][$i],
    		);
    		$attribute->setData($data);
	    	if($attr['id'][$i] == 0)
	    	{
	    		if($attribute->add() !== false)
	    		$flag1 = 1;
	    		else 
	    		{
	    			$flag1 = 0;
	    			break;
	    		}
	    	}
	    	else
	    	{
	    		if($attribute->update("id = ".$attr['id'][$i]) !== false)
	    		$flag2 = 1;
	    		else 
    			{
	    			$flag2 = 0;
	    			break;
	    		}
	    	}	    		
    	}
    	if($flag1 != 0 && $flag2 != 0 && $flag3 != 0)
    	$this->attribute_edit("保存成功");
    	else
    	$this->attribute_edit("保存失败,请重试");
    	
    }
	/**
	 * @brief 添加会员
	 */
	function member_edit()
	{
		$uid = intval(IReq::get('uid'));
		$tb_user_group = new IModel('user_group');
		$group_info = $tb_user_group->query();
		$this->data['group'] = $group_info;
		$this->data['province'] = '';
		$this->data['city'] = '';
		$this->data['area'] = '';
		//编辑会员信息 读取会员信息
		if($uid)
		{
			$tb_user = new IModel('user');
			$tb_member = new IModel('member');

			$user_info = $tb_user->query("id=".$uid);
			$member_info = $tb_member->query("user_id=".$uid);

			if(is_array($user_info) && ($uinfo=$user_info[0]) && is_array($member_info) && ($minfo=$member_info[0]))
			{
				$this->data['member'] = array(
					'user_id'		=>	$uinfo['id'],
					'user_name'		=>	$uinfo['username'],
					'email'			=>	$uinfo['email'],
					'user_group'	=>	$minfo['group_id'],
					'truename'		=>	$minfo['true_name'],
					'sex'			=>	$minfo['sex'],
					'telephone'		=>	$minfo['telephone'],
					'mobile_a'		=>	$minfo['mobile'],
					'address'		=>	$minfo['contact_addr'],
					'zip'			=>	$minfo['zip'],
					'qq'			=>	$minfo['qq'],
					'msn'			=>	$minfo['msn']
				);
				/*if($minfo['area'])
				{
					$area = substr($minfo['area'],1,-1);
					$arr = explode(',',$area);
					$this->data['province'] = $arr[0];
					$this->data['city'] = $arr[1];
					$this->data['area'] = $arr[2];
				}*/
			}
			else
			{
				$this->member_list();
				Util::showMessage("没有找到相关记录！");
				return;
			}
		}
		$this->setRenderData($this->data);
		$this->redirect('member_edit');
	}

	//保存会员信息
	function member_save()
	{
		$user_id = IFilter::act(IReq::get('user_id'),'int');
		$user_name = IFilter::act(IReq::get('user_name'));
		$email = IFilter::act(IReq::get('email'));
		$password = IFilter::act(IReq::get('password'));
		$repassword = IFilter::act(IReq::get('repassword'));

		$user_group = IFilter::act(IReq::get('user_group'),'int');
		$vip_id = IFilter::act(IReq::get('vip_id'));
		$truename = IFilter::act(IReq::get('truename'));
		$sex = IFilter::act(IReq::get('sex'),'int');
		$telephone = IFilter::act(IReq::get('telephone'));
		$mobile = IFilter::act(IReq::get('mobile_a'));
		/*$province = IFilter::act(IReq::get('province'),'int');
		$city = IFilter::act(IReq::get('city'),'int');
		$area = IFilter::act(IReq::get('area'),'int');*/
		$address = IFilter::act(IReq::get('address'));
		$zip = IFilter::act(IReq::get('zip'));
		$qq = IFilter::act(IReq::get('qq'));
		$msn = IFilter::act(IReq::get('msn'));
		/*$exp = IFilter::act(IReq::get('exp'),'int');
		$point = IFilter::act(IReq::get('point'),'int');*/
		$data['member'] = array(
				'user_id'		=>	$user_id,
				'user_name'		=>	$user_name,
				'email'			=>	$email,
				'user_group'    =>	$user_group,
				'truename'		=>	$truename,
				'sex'			=>	$sex,
				'telephone'		=>	$telephone,
				'mobile_a'		=>	$mobile,
				'address'		=>	$address,
				'zip'			=>	$zip,
				'qq'			=>	$qq,
				'msn'			=>	$msn,
			);
		//$count = '';
		/*if($province)
		{
			$count = ','.$province.','.$city.','.$area.',';
		}*/
		if(empty($user_id))		//添加新会员
		{
				if($password=='')
				{
					$errorMsg = '请输入密码！';
					$tb_user_group = new IModel('user_group');
					$group_info = $tb_user_group->query();
					$data['group'] = $group_info;
					$this->setRenderData($data);
					$this->redirect('member_edit',false);
					Util::showMessage($errorMsg);
				}
				if($password != $repassword)
				{
					$errorMsg = '两次输入的密码不一致！';
					$tb_user_group = new IModel('user_group');
					$group_info = $tb_user_group->query();
					$data['group'] = $group_info;
					$this->setRenderData($data);
					$this->redirect('member_edit',false);
					Util::showMessage($errorMsg);
				}

				$tb_user = new IModel("user");
				$user = array(
					'vip_id' =>$vip_id,
					'username'=>$user_name,
					'password'=>md5($password),
					'email'=>$email
				);
				$tb_user->setData($user);
				$uid = $tb_user->add();

				if($uid)
				{
					$tb_member = new IModel("member");
					$member = array(
						'vip_id' =>$vip_id,
						'user_id'=>$uid,
						'true_name' =>$truename,
						'telephone' =>$telephone,
						'mobile_a' => $mobile,
						'contact_addr' =>$address,
						'qq' =>$qq,
						'msn'=>$msn,
						'sex'=>$sex,
						'zip'=>$zip,
						'group_id'=>$user_group,
						'time'=>date('Y-m-d H:i:s')
					);
					$tb_member->setData($member);
					$tb_member->add();
					
					$tb_member_info = new IModel("member_info");
					$tb_member_info->setData(array('user_id'=>$uid));
					$tb_member_info->add();
					
					$this->redirect('member_list');
					Util::showMessage('添加用户成功！');
				}
				else
				{
					$this->redirect('member_list');
					Util::showMessage('添加用户失败！');
				}
		}
		else		//编辑会员
		{
				$tb_user = new IModel("user");
				$user = array(
						'email'=>$email,
						'vip_id' =>$vip_id	
				);
				if($password!='')
				{
					if($password != $repassword)
					{
						$errorMsg = '两次输入的密码不一致！';
						$tb_user_group = new IModel('user_group');
						$group_info = $tb_user_group->query();
						$data['group'] = $group_info;
						$this->setRenderData($data);
						$this->redirect('member_edit',false);
						Util::showMessage($errorMsg);
					}
					$user['password'] = md5($password);
				}
				$tb_user->setData($user);
				$tb_user->update("id=".$user_id);

				$tb_member = new IModel("member");
				$member = array(
					'vip_id' =>$vip_id,
					'true_name' =>$truename,
					'telephone' =>$telephone,
					'mobile_a' => $mobile,
					'contact_addr' =>$address,
					'qq' =>$qq,
					'msn'=>$msn,
					'sex'=>$sex,
					'zip'=>$zip,
					'group_id'=>$user_group,
					'time'=>date('Y-m-d H:i:s')
				);
				$tb_member->setData($member);
				$affected_rows = $tb_member->update("user_id=".$user_id);
				if($affected_rows)
				{
					$this->redirect('member_list');
					Util::showMessage('更新用户成功！');
				}
				else
				{
					$this->redirect('member_list');
					Util::showMessage('更新用户失败！');
				}
		}
	}

	/**
	 * @brief 会员列表
	 */
	function member_list()
	{
		$search = IFilter::string(IReq::get('search'));
		$keywords = IFilter::string(IReq::get('keywords'));
		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search like '%{$keywords}%' ";
		}
		$this->data['search'] = $search;
		$this->data['keywords'] = $keywords;
		$this->data['where'] = $where;
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query();
		$data_group = is_array($data_group) ? $data_group : array();
		$group      = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->data['group'] = $group;
		$this->setRenderData($this->data);
		$this->redirect('member_list');
	}
	/**
	 * @brief 用户筛选
	 */
	function member_filter()
	{
		$search = IFilter::string(IReq::get('search'));
		$keywords = IFilter::string(IReq::get('keywords'));
		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search like '%{$keywords}%' ";
		}
		$this->data['search'] = $search;
		$this->data['keywords'] = $keywords;
		$this->data['where'] = $where;
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query();
		$data_group = is_array($data_group) ? $data_group : array();
		$group      = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->data['group'] = $group;

		$page = IReq::get('page');
		$page = intval($page) ? intval($page) : 1;
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
		$zip_key = IFilter::string(IReq::get('zip_key'));
		$zip_v = IFilter::act((IReq::get('zip_value')),'string');
		if($zip_key && $zip_v)
		{
			if($zip_key=='eq')
			{
				$where .= "m.zip='{$zip_v}' {$and} ";
			}else
			{
				$where .= 'm.zip like "%'.$zip_v.'%"'.$and;
			}
		}
		$sex = intval(IReq::get('sex'));
		if($sex && $sex!='-1')
		{
			$where .= 'm.sex='.$sex.$and;
		}
		$point_key = IFilter::string(IReq::get('point_key'));
		$point_v = intval(IReq::get('point_value'));
		if($point_key && $point_v)
		{
			if($point_key=='eq')
			{
				$where .= 'm.point= "'.$point_v.'"'.$and;
			}
			elseif($point_key=='gt')
			{
				$where .= 'm.point > "'.$point_v.'"'.$and;
			}
			else
			{
				$where .= 'm.point < "'.$point_v.'"'.$and;
			}
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
		$query->page = $page;
		$query->pagesize = "20";
		$this->data['member_list'] = $query->find();
		$this->data['pageBar'] = $query->getPageBar('/member/member_filter/');
		$this->setRenderData($this->data);
		$this->redirect('member_filter');
	}

	/**
	 * @brief 删除至回收站
	 */
	function member_reclaim()
	{
		$user_ids = IReq::get('check');
		$user_ids = is_array($user_ids) ? $user_ids : array($user_ids);
		$user_ids = IFilter::act($user_ids,'int');
		if($user_ids)
		{
			$ids = implode(',',$user_ids);
			if($ids)
			{
				$tb_member = new IModel('member');
				$members = $tb_member->query("user_id in (".$ids.")");//决定跳转到哪里
				$tb_member->setData(array('status'=>'2'));
				$where = "user_id in (".$ids.")";
				$tb_member->update($where);
			}
		}
		if(empty($members[0]['vip_id']))
		$this->member_list();
		else
		$this->vip_member_list();
	}

	/**
	 * @brief 移动会员，修改会员等级
	 */
	function member_remove()
	{
		$user_ids = IFilter::act(IReq::get('check','post'),'int');
		$group_id = IFilter::act(IReq::get('move_group','post'),'int');
		//$point = intval(IReq::get('move_point','post'));
		if($user_ids && is_array($user_ids))
		{
			$ids = implode(',',$user_ids);
			if($ids)
			{
				$tb_member = new IModel('member');
				$updatearray = array();
				/*if($point)
				{
					$updatearray['point'] = $point;
				}*/
				$updatearray['group_id'] = $group_id;
				$updatearray['vip_id'] = "";
				$tb_member->setData($updatearray);
				$where = "user_id in (".$ids.")";
				$tb_member->update($where);
				
				$tb_user = new IModel('user');
				$data = array(
				'vip_id'  => '',
				'is_ready'=> 0
				);
				$tb_user->setData($data);
				$where = "id in (".$ids.")";
				$tb_user->update($where);
			}
		}
		$this->vip_member_list();
	}
	//批量用户充值
    function member_recharge()
    {
    	$id = IReq::get('check');
    	$balance = IReq::get('balance');
    	$type = IReq::get('type');
    	$order_no = IFilter::act( IReq::get('order_no') );
    	$even = '';
    	if($type=='3')
    	{
    		$balance = '-'.abs($balance);
    		$even = 'withdraw';
    	}
    	else
    	{
    		$balance = abs($balance);
    		if($type=='1')
    		{
    			$even = 'recharge';
    		}else
    		{
    			$even = 'drawback';
    			if(is_array($id) && count($id)>1)
    			{
    				$this->setRenderData(array('where'=>1,'search'=>'','group'=>array()));
    				$this->redirect('member_list',false);
					Util::showMessage('订单退款功能不能批量处理');
					return;
    			}
    			if(is_array($id))
    			{
    				$id = end($id);
    			}
    			$id = intval($id);
    			//检测这个订单是不是这个用户的，且是否申请退款了
    			$obj = new IModel("order");
    			$row = $obj->query("user_id={$id} AND order_no = '{$order_no}' and (pay_status = 1 or pay_status = 3)");
    			if(!$row)
    			{
    				$this->setRenderData(array('where'=>1,'search'=>'','group'=>array()));
    				$this->redirect('member_list',false);
					Util::showMessage('不存在这个订单或付款状态不正确');
					return;
    			}
    		}
    	}
		if(!empty($id))
		{
			$obj = new IModel('member');
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				//按用户id数组查询出用户余额，然后进行充值
				$member_info = $obj->query(' user_id in ('.$id_str.')');
				if(count($member_info)>0)
				{
					foreach ($member_info as $value)
					{
						$balance_bak = $balance;
						$balance = $value['balance']+$balance;
						if($balance>=0)
						{
							$obj->setData(array('balance'=>$balance));
							$obj->update(' user_id = '.$value['user_id']);
						}
						//用户余额进行的操作记入account_log表
						$log = new AccountLog();
						$config=array(
							'user_id'=>$value['user_id'],
						 	'admin_id'=>$this->admin['admin_id'], //如果需要的话
						 	'event'=>$even, //withdraw:提现,pay:余额支付,recharge:充值,drawback:退款到余额
						 	//'note'=>$even,//如果不设置的话则根据event类型自动生成，如果设置了则不再对数据完整性进行检测，比如是否设置了管理员id、订单信息等
						 	'num'=> $balance_bak, //整形或者浮点，正为增加，负为减少
						 	'order_no' =>$order_no // drawback类型的log需要这个值
						 );
						 $re = $log->write($config);
					}
				}
			}
			else
			{
				//按用户id数组查询出用户余额，然后进行充值
				$member_info = $obj->query(' user_id = '.$id);
				if(count($member_info)>0)
				{
					$balance_bak = $balance;
					$balance = $member_info[0]['balance']+$balance;
					if($balance>=0)
					{
						$obj->setData(array('balance'=>$balance));
						$obj->update(' user_id = '.$id);
					}
					//用户余额进行的操作记入account_log表
					$log = new AccountLog();
					$config=array(
						'user_id'=>$id,
					 	'admin_id'=>$this->admin['admin_id'], //如果需要的话
					 	'event'=>$even, //withdraw:提现,pay:余额支付,recharge:充值,drawback:退款到余额
					 	//'note'=>$even,//如果不设置的话则根据event类型自动生成，如果设置了则不再对数据完整性进行检测，比如是否设置了管理员id、订单信息等
					 	'num'=> $balance_bak, //整形或者浮点，正为增加，负为减少
					 	'order_no' =>$order_no // drawback类型的log需要这个值
					 );
					 $re = $log->write($config);
				}
			}
			$this->setRenderData(array('where'=>1,'search'=>'','group'=>array()));
			$this->redirect('member_list',false);
			Util::showMessage('操作成功');
			return;
		}
		else
		{
			$this->setRenderData(array('where'=>1,'search'=>'','group'=>array()));
			$this->redirect('member_list',false);
			Util::showMessage('请选择要充值的会员');
			return;
		}
    }
    
  //会员组列表
  function group_list()
  {
    $this->redirect('group_list');	
  }  
	/**
	 * @brief 用户组添加
	 */
	function group_edit()
	{
		$gid = (int)IReq::get('gid');
		//编辑会员等级信息 读取会员等级信息
		if($gid)
		{
			$tb_user_group = new IModel('user_group');
			$group_info = $tb_user_group->query("id=".$gid);

			if(is_array($group_info) && ($info=$group_info[0]))
			{
				$this->data['group'] = array(
					'group_id'	=>	$info['id'],
					'group_name'=>	$info['group_name'],
					'discount'	=>	$info['discount'],
					'minexp'	=>	$info['minexp'],
					'maxexp'	=>	$info['maxexp']
				);
			}
			else
			{
				$this->redirect('group_list',false);
				Util::showMessage("没有找到相关记录！");
				return;
			}
		}
		$this->setRenderData($this->data);
		$this->redirect('group_edit');
	}

	/**
	 * @brief 保存用户组修改
	 */
	function group_save()
	{
		$maxexp   = IReq::get('maxexp');
		$minexp   = IReq::get('minexp');
		if($maxexp <= $minexp)
		{
			$errorMsg = '最大经验值必须大于最小经验值';
		}

		$group_id = (int)IReq::get('group_id','post');
		$form_array = array(
			'user_group'=>	array(
				array('name'=>'group_name', 'field'=>'group_name','rules'=>'required'),
				array('name'=>'discount', 'field'=>'discount'),
				array('name'=>'minexp', 'field'=>'minexp'),
				array('name'=>'maxexp', 'field'=>'maxexp'),
			),
		);
		//验证表单
		$validationObj = new Formvalidation($form_array);
		$form_data = $validationObj->run();
		foreach($form_data as $key => $value)
		{
			foreach($value as $v)
			{
				$group[$v['name']] = $v['postdate'];
				$tb_model[$v['field']] = $v['postdate'];
			}
		}
		if($validationObj->isError() || isset($errorMsg))
		{
			//验证失败
			$this->data['group'] = $group;
			$this->setRenderData($this->data);
			//加载视图
			$this->redirect('group_edit',false);
			$errorMsg = isset($errorMsg) ? $errorMsg : $validationObj->getError();
			Util::showMessage($errorMsg);
		}
		else
		{
			//验证成功
			$tb_user_group = new IModel("user_group");
			$tb_user_group->setData($tb_model);
			if($group_id)
			{
				$affected_rows = $tb_user_group->update("id=".$group_id);
				if($affected_rows)
				{
					$this->redirect('group_list',false);
					Util::showMessage('更新用户组成功！');
					return;
				}
				$this->redirect('group_list',false);
			}
			else
			{
				$gid = $tb_user_group->add();
				$this->redirect('group_list',false);
				if($gid)
				{
					Util::showMessage('添加用户组成功！');
				}
				else
				{
					Util::showMessage('添加用户组失败！');
				}
			}
		}
	}

	/**
	 * @brief 删除会员组
	 */
	function group_del()
	{
		$group_ids = IReq::get('check');
		$group_ids = is_array($group_ids) ? $group_ids : array($group_ids);
		$group_ids = IFilter::act($group_ids,'int');
		if($group_ids)
		{
			$ids = implode(',',$group_ids);
			if($ids)
			{
				$tb_user_group = new IModel('user_group');
				$where = "id in (".$ids.")";
				$tb_user_group->del($where);
			}
		}
		$this->redirect('group_list');
	}

	/**
	 * @brief 回收站
	 */
	function recycling()
	{
		$search = IReq::get('search');
		$keywords = IReq::get('keywords');
		$search_sql = IFilter::act($search,'string');
		$keywords = IFilter::act($keywords,'string');

		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search_sql like '%{$keywords_sql}%' ";
		}
		$this->data['search'] = $search;
		$this->data['keywords'] = $keywords;
		$this->data['where'] = $where;
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query();
		$data_group = is_array($data_group) ? $data_group : array();
		$group = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->data['group'] = $group;
		$this->setRenderData($this->data);
		$this->redirect('recycling');
	}

	/**
	 * @brief 彻底删除会员
	 */
	function member_del()
	{

		$user_ids = IReq::get('check');
		$user_ids = is_array($user_ids) ? $user_ids : array($user_ids);
		$user_ids = IFilter::act($user_ids,'int');
		if($user_ids)
		{
			$ids = implode(',',$user_ids);

			if($ids)
			{
				$tb_member = new IModel('member');
				$where = "user_id in (".$ids.")";
				$tb_member->del($where);

				$tb_user = new IModel('user');
				$where = "id in (".$ids.")";
				$tb_user->del($where);
				
				$tb_user = new IModel('member_info');
				$where = "user_id in (".$ids.")";
				$tb_user->del($where);
				
				$tb_user = new IModel('member_attribute');
				$where = "user_id in (".$ids.")";
				$tb_user->del($where);
			}
		}
		$this->redirect('member_list');
	}

	/**
	 * @brief 从回收站还原会员
	 */
	function member_restore()
	{
		$user_ids = IReq::get('check');
		$user_ids = is_array($user_ids) ? $user_ids : array($user_ids);
		if($user_ids)
		{
			$user_ids = IFilter::act($user_ids,'int');
			$ids = implode(',',$user_ids);
			if($ids)
			{
				$tb_member = new IModel('member');
				$tb_member->setData(array('status'=>'1'));
				$where = "user_id in (".$ids.")";
				$tb_member->update($where);
			}
		}
		$this->redirect('recycling');
	}

	//[提现管理] 删除
	function withdraw_del()
	{
		$id   = IReq::get('id');

		if(!empty($id))
		{
			$id = IFilter::act($id,'int');
			$withdrawObj = new IModel('withdraw');

			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
			}
			else
			{
				$where = 'id = '.$id;
			}

			$withdrawObj->del($where);
			$this->redirect('withdraw_recycle');
		}
		else
		{
			$this->redirect('withdraw_recycle',false);
			Util::showMessage('请选择要删除的数据');
		}
	}

	//[提现管理] 回收站 删除,恢复
	function withdraw_update()
	{
		$id   = IFilter::act( IReq::get('id') , 'int' );
		$type = IReq::get('type') ;

		if(!empty($id))
		{
			$withdrawObj = new IModel('withdraw');

			$is_del = ($type == 'res') ? '0' : '1';
			$dataArray = array(
				'is_del' => $is_del
			);

			if(is_array($id))
			{
				$idStr = join(',',$id);
				$where = ' id in ('.$idStr.')';
			}
			else
			{
				$where = 'id = '.$id;
			}

			$dataArray = array(
				'is_del' => $is_del,
			);

			$withdrawObj->setData($dataArray);
			$withdrawObj->update($where);
			$this->redirect('withdraw_list');
		}
		else
		{
			if($type == 'del')
			{
				$this->redirect('withdraw_list',false);
			}
			else
			{
				$this->redirect('withdraw_recycle',false);
			}
			Util::showMessage('请选择要删除的数据');
		}
	}

	//[提现管理] 详情展示
	function withdraw_detail()
	{
		$id = intval( IReq::get('id') );

		if($id)
		{
			$withdrawObj = new IModel('withdraw');
			$where       = 'id = '.$id;
			$this->withdrawRow = $withdrawObj->getObj($where);
			$this->redirect('withdraw_detail',false);
		}
		else
		{
			$this->redirect('withdraw_list');
		}
	}

	//[提现管理] 修改提现申请的状态
	function withdraw_status()
	{
		$id      = intval( IReq::get('id') );
		$status  = intval( IReq::get('status') );
		$re_note = IFilter::act( IReq::get('re_note'),'string' );

		if($id)
		{
			$withdrawObj = new IModel('withdraw');
			$dataArray = array(
				'status' => $status,
				're_note'=> $re_note,
			);
			$withdrawObj->setData($dataArray);
			$where = 'id = '.$id;
			$withdrawObj->update($where);
			$this->withdraw_detail(true);
			Util::showMessage("更新成功");
		}
		else
		{
			$this->redirect('withdraw_list');
		}
	}
	/********************************************************/
	/*
	 * 专家信息编辑与修改
	 *@曹俊 2012-01-08
	 * */
	//专家组列表
	function  expert_cat_list()
	{
		$this->redirect('expert_cat_list');	
	}
	function expert_cat_edit_show()
	{
		$id     = intval(IReq::get('id') );
		if ($id)
		{
			$expert_source= new IModel('professional_group');
			$where = 'id ='.$id;
			$this->showdata = $expert_source->getObj($where);
			$this->redirect('expert_cat_edit_show');	
		}
		else 
		{
			$this->redirect('expert_cat_edit_show');
		}
	}
	function expert_cat_edit()
	{
		$id = intval(IReq::get('id'));
		$expert_source = new IModel('professional_group');
		if($id)
		{
			$sql_where = 'id ='.$id;
			$dataArray = array(
			'id' => $id,
			'name' => $name = IReq::get('name')
			);
			$expert_source->setData($dataArray);
			$expert_source->update($sql_where);
		}
		else 
		{
			$dataArray = array(
			'name' => $name = IReq::get('name')
			);	
			$expert_source->setData($dataArray);
			$expert_source->add();
		}
		$this->redirect('expert_cat_list');
	}
	function expert_cat_del()
	{
		$id = intval(IReq::get('id'));
		if($id)
		{
			$expert_source = new IModel('professional_group');
			$sql_where = 'id ='.$id;
			$expert_source->del($sql_where);	
		}
		$this->redirect('expert_cat_list');
	}
	//专家信息列表
	function  expert_list()
	{
		$this->redirect('expert_list');
	}
		//专家信息编辑
	function  expert_edit()
	{
		$id     = intval(IReq::get('id') );
		if ($id)
		{
			$expert_source= new IModel('professional');
			$where = 'id ='.$id;
			
			//分组查询
			$expert_group_source = new IModel('exp_group');
			$group_where = 'exper_id = '.$id;
			$group_all = $expert_group_source->query($group_where);
			$group_id= array();	
			foreach ($group_all as $temp_array)
			{
				$group_id[]= $temp_array['group_id'];
				
			}
			$this->group = $group_id;
			//分组查询结束
			
			$this->showdata = $expert_source->getObj($where);
			$this->redirect('expert_edit');	
		}
		else 
		{
			$this->showdata= array(
			'head_ico' => "views/".$this->theme."/skin/".$this->skin."/images/front/expert_ico.gif");
			$this->redirect('expert_edit');
		}
	}
	//专家信息保存函数
	function  expert_edit_act()
	{	
		$id     = intval(IReq::get('id') );
		$expert_source = new IModel('professional');
		$exp_group_source =new IModel('exp_group');	

		$focus_photo = IFilter::act(IReq::get('focus_photo'));
		$group_id =  IReq::get('group');
		
		var_dump($group_id);
		
		if(!$focus_photo)
		{
			$focus_photo= "views/".$this->theme."/skin/".$this->skin."/images/front/expert_ico.gif";
		}	
		if(!empty($id))
		{
			//删除专家分组表中已有的记录
			$sql_group_where = 'exper_id = '.$id;
			$exp_group_source->del($sql_group_where);
			
			
			//循环插入新的数据
			foreach ($group_id as $group_id_new)
			{
				$array = array(
				'exper_id' => $id,
				'group_id' =>$group_id_new
				);
				$exp_group_source->setData($array);
				$exp_group_source->add();
			}
			
			//更新专家信息表
			$sql_where = 'id ='.$id;
			$dataArray = array(
			'id' => $id,
			'name' =>   IReq::get('name'),
			'position' =>  IReq::get('position'),
			'introduce' => IReq::get('description'),
			'head_ico' =>$focus_photo,
			'state' => intval( IReq::get('visiblity')),
			'work_place' =>IReq::get('work_place'),
			'email' =>IReq::get('email'),
			'sort' => IReq::get('sort')
			);
			$expert_source->setData($dataArray);
			$is_success=$expert_source->update($sql_where);		
		}
		else 
		{
			//插入专家信息表
			$dataArray = array(
			'login_id' => IReq::get('login_id'),
			'password' =>md5(IReq::get('password')),
			'name' =>   IReq::get('name'),
			'position' =>  IReq::get('position'),
			'group' => intval( IReq::get('group')),
			'introduce' => IReq::get('description'),
			'head_ico' =>$focus_photo,
			'state' => intval( IReq::get('visiblity')),
			'work_place' =>IReq::get('work_place'),
			'email' =>IReq::get('email'),
			'sort' => IReq::get('sort')
			);	
			$expert_source->setData($dataArray);
			$temp=$expert_source->add();
			
			//循环插入新的数据
			foreach ($group_id as $group_id_new)
			{
				$array = array(
				'exper_id' => $temp,
				'group_id' =>$group_id_new
				);
				$exp_group_source->setData($array);
				$exp_group_source->add();
			}	
			
			$$is_success = $temp ? true : false;
		}
		$this->redirect('expert_list');
	}
	
	//专家信息删除函数
	function  expert_del()
	{
		$id = intval(IReq::get('id'));
		if($id)
		{
			$expert_source = new IModel('professional');
			$sql_where = 'id ='.$id;
			$expert_source->del($sql_where);	
			$exp_group = new IModel('exp_group');
			$sql_group_where = 'exper_id ='.$id;
			$exp_group->del($sql_group_where);	
		}
		$this->redirect('expert_list');	
	}
	
	//检验专家登陆id是否存在
    function check_id()
	{
		 $login_id=IFilter::act(IReq::get('login_id'));
         $check = new IQuery("professional");
         $check-> where = "login_id = '$login_id'";
         $num= $check->find();
		 if(count($num)!=0){
			 echo '1';
		 }
		 else
		 {
		 	echo '0';
		 }
	}
	//专家密码重置
	function expert_repass()
	{
		if(!(ISafe::get('admin_id'))|| !(ISafe::get('admin_right')))
		{
			$this->redirect('/systemadmin/index');
		}
		else 
		{
			 $id=IFilter::act(IReq::get('user_id'));
	         $check = new IQuery("professional");
	         $check-> where = "id = '$id'";
	         $num= $check->find();
	         if (count($num)!=0 )
	         {
	         	$newpw = IHash::md5( microtime(true)  );	
				$newpw = substr($newpw,10,8);//和上一行一起随机生成新密码
	
				$tb_user = new IModel("professional"); //重新生成
				$tb_user->setData( array( 
				'password'=>IHash::md5($newpw)  ) );
				if($tb_user->update("id='$id'") )
				{
					 echo "新密码为：".$newpw;
				}		
	         }
		}
	}
	/********************************************************/
	/*
	 * 管理vip用户
	 *Author:zhangfan 2012.04
	 * */
	//随机生成8位自然数作为vip_id
	/*function get_vip_id()
	{
		$vip_id = '';
		$get = 0;
		while(!$get)
		{
			 $random_id = IHash::random(8,'int');
		     $check = new IQuery("user");
	         $check-> where = "vip_id = '$random_id'";
	         $num= $check->find();
	         if (count($num)==0 )
	         {
	         	$get = 1;
	         	echo $random_id;
	         }
		}
	}*/
	//顺序生成8位自然数作为vip_id
	function get_vip_id()
	{
		$vip_id = '';
	    $check = new IQuery("user");
        $check-> fields = "max(vip_id) ";
        $num= $check->find();
       	$temp_id = intval($num[0]['max(vip_id)']+1);
        $next_id = '';
        $i = 0;
        while($temp_id != 0)
        {
        	$temp_val = intval($temp_id%10);
        	$temp_id =  intval($temp_id/10);
        	$next_id = $temp_val.$next_id;
        	$i++;
        }
        while(8-$i)
        {
        	$i++;
        	$next_id = '0'.$next_id;
        }
        echo $next_id;
	}
	//检查管理员分配的vip_id是否已存在
	function check_vip_id()
	{
		 
		 $vip_id  = IReq::get('vip_id','post');
 		 
	     $check = new IQuery("user");
         $check-> where = "vip_id = '".$vip_id."'";
         $num= $check->find();
         
         if (count($num)!=0 )
         echo "0";
         else 
         echo "1";
	}
	//生成VIP信息表，并导出
	function output_users()
	{
		$columns = new IQuery('INFORMATION_SCHEMA.COLUMNS',True);
		$columns->fields = 'COLUMN_NAME, COLUMN_COMMENT';
		$columns->where = 'table_name =  \'gtwebsite_member\' AND  `TABLE_SCHEMA` =  \'xmlyclub\'';
		$this->member_data = $columns->find();
		$this->redirect('output_users');
	}
	//打印预览页面
	function print_page()
	{
		$select=IReq::get('select');
		$select_name=IReq::get('select_name');
		
		$select = substr($select,0,strlen($select)-1);//导出字段
		$select_name = substr($select_name,0,strlen($select_name)-1);
		
		$start_time=IReq::get('start_time');
		$end_time=IReq::get('end_time');
		
		$start_id=IReq::get('start_id','post');
		$end_id=IReq::get('end_id','post');
		

		$user_table = new IQuery('member');
		if(empty($start_id))
		{
			$user_table->where = "vip_id != '' and time between '".$start_time."' and '".$end_time."'"; 
		}
		else if(empty($start_time))
			{
				$user_table->where = "vip_id between ".$start_id." and ".$end_id; 
			}
			else{
				$user_table->where = "(vip_id between ".$start_id." and ".$end_id.") and (time between '".$start_time."' and '".$end_time."')"; 
			}
		$user_table->fields = $select;
		$this->showdata = $user_table->find();
		
		$this->column_name = explode(",",$select_name);//列名
		$this->layout ='print';
		$this->redirect('print_page');
	}
	//导出excel文档
	function get_excel()
	{
		$table = IReq::get('data');
		$gb_table = iconv("utf-8", "gb2312", $table);
		header("Content-Type: application/vnd.ms-excel; charset=GBK");
        header ( "Content-Disposition:filename=vip_data.xls" );
        echo $gb_table;
	}
	/********************************************************/
}
