<?php
/**
 * @copyright Copyright(c) 2012 Panfeng Studio
 * @file
 * @brief
 * @author Qiulin
 * @date 2012-01-13
 * @version 0.7
 * @note
 */
/**
 * @brief Ucenter
 * @class Ucenter
 * @note
 */
class Ucenter extends IController
{
	public $layout = 'ucenter';
	private $data = array();
	function init()
	{
		$user = array();
		$user['user_id'] = ISafe::get('user_id');
		if($user['user_id'] == '')
		{
			$this->redirect('/simple/login');
		}
		$user['username'] = ISafe::get('username');
		$user['head_ico'] = ISafe::get('head_ico');
		$this->user = $user;
	}
    public function index()
    {
        $this->redirect('info');

    }
   
   
	//[会员中心]站内邮件
	function webmail_list()
	{
		$this->redirect('webmail_list');
	}
    
	//[会员中心]站内邮件（详情页）
	function webmail_detail()
	{
		$id = intval(IReq::get('id'));
		$webmailObj = new IModel('announcement');
		$where = 'id = '.$id;
		$this->webmail_data = $webmailObj->getObj($where);
		$this->redirect('webmail_detail');
	}
    //[修改密码]修改动作
    function password_edit()
    {
    	$user_id    = $this->user['user_id'];

    	$fpassword  = IReq::get('fpassword');
    	$password   = IReq::get('password');
    	$repassword = IReq::get('repassword');

    	$userObj    = new IModel('user');
    	$where      = 'id = '.$user_id;
    	$userRow    = $userObj->getObj($where);

		if(!preg_match('|\w{6,32}|',$password))
		{
			$message = '密码格式不正确，请重新输入';
		}
    	else if($password != $repassword)
    	{
    		$message  = '二次密码输入的不一致，请重新输入';
    	}
    	else if(md5($fpassword) != $userRow['password'])
    	{
    		$message  = '原始密码输入错误';
    	}
    	else
    	{
	    	$dataArray = array(
	    		'password' => md5($password),
	    	);

	    	$userObj->setData($dataArray);
	    	$result  = $userObj->update($where);
	    	$message = ($result === false) ? '密码修改失败' : '密码修改成功';
		}

    	$this->redirect('password',false);
    	Util::showMessage($message);
    }
	//[个人资料]展示 单页
    function info($message = NULL,$form_id = NULL)
    {
    	$uid = $this->user['user_id'];
    	//用于vip第一次登陆
    	$this->vip_id = IReq::get('vip_id');
    	
    	$advice_page = IReq::get('page');
    	$form_id = empty($advice_page)?$form_id:2;//专家建议页
    	$div_id = IReq::get('div_id');
    	$this->div_id = empty($div_id)?0:$div_id;
		$this->form_id = ($form_id==NULL)?0:$form_id;//选择标签号
		
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

    	/*$userGroupObj       = new IModel('user_group');
    	$where              = 'id = '.$this->memberRow['group_id'];
    	$this->userGroupRow = $userGroupObj->getObj($where);*/
		$this->setRenderData($this->data);
		
    	$this->redirect('info',false);
    	if($message != NULL)
    	Util::showMessage($message);
    }
	//保存会员基本信息
	function ucenter_baseinfo_save()
	{
		//基本信息
		$uid = $this->user['user_id'];
		$user_id = empty($uid)?NULL:$uid;
		
		$memberObj = new IModel('member');
		
		//拼接出生日期
		$year = IFilter::act(IReq::get('year'));
		$month = IFilter::act(IReq::get('month'));
		$day = IFilter::act(IReq::get('day'));
		$birthday = $year.'-'.$month.'-'.$day;
		
		$member_data = array(
				'job'            => IFilter::act(IReq::get('job')),
				'nation'         => IFilter::act(IReq::get('nation')),
				'birthday'       => $birthday,
				'birth_place'    => IFilter::act(IReq::get('birth_place')),
				'qq'             => IFilter::act(IReq::get('qq')),	
				'telephone'      => $telephone,
				'contact_addr'   => IFilter::act(IReq::get('contact_addr')),
				'yuchanqi'       => IFilter::act(IReq::get('yuchanqi')),
				'first_hospital' => IFilter::act(IReq::get('first_hospital')),
				'birth_plan' 	 => IFilter::act(IReq::get('birth_plan'))
		);
		//记录已填写的正确信息
		$this->data['member'] = $member_data;
		//基本属性
		if($user_id)//更新用户
		{
			$memberObj->setData($member_data);
	
			$rs1 = $memberObj->update("user_id=".$user_id);
			$rs2 = $this->attribute_save($user_id,1);//更新附加属性
			if($rs1!== false&&rs2!== false)
			{
			    $this->info("更新成功",0);
			}
			else 
			{
				$this->info("更新失败,请重试",0);
			}
		}
		else{
			$this->redirect('/simple/login');
		}
	}
	//保存会员专业信息
	function ucenter_advinfo_save()
	{
		//基本信息
		$uid = $this->user['user_id'];
		$user_id = empty($uid)?NULL:$uid;
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
				$rs1 = $member_infoObj->update("user_id =".$uid);
				$rs2 = $this->attribute_save($uid,2);//更新附加属性
				if($rs1!== false&&rs2!== false)
				{
				    $this->info("更新成功",1);
				}
				else 
				{
					$this->info("更新失败，请重试",1);
				}	
			}
			else 
			{
				$this->redirect('/simple/login');
			}
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
	/*function warm_advice()
	{
		$uid = $this->user['user_id'];

    	
    	$div_id = IReq::get('div_id');
    	$this->div_id = empty($div_id)?0:$div_id;
		
    	$tb_user = new IModel('user');
		$tb_member = new IModel('member');
			
		$user_info = $tb_user->query("id=".$uid);
		$base_info = $tb_member->query("user_id=".$uid);
		
		if(is_array($user_info) && ($uinfo=$user_info[0]) && is_array($base_info) && ($binfo=$base_info[0]))
		{
			$newarray = array_merge($uinfo,$binfo);
			$this->data['member'] = $newarray;
		}

		$this->setRenderData($this->data);	
    	$this->redirect('warm_advice',false);
	}*/
	function warm_advice()
	{
		$uid = $this->user['user_id'];
		$memObj = new IModel('member');
		$member_data = $memObj->query("user_id=".$uid);
		$member_data = empty($member_data)?array():$member_data[0];
		if(!empty($member_data))
		{
			$ids = explode(',', $member_data['reminder_ids']);
			$this->data['member'] = $member_data;
		}
		$remObj = new IModel('reminder');
		$reminders =array(array());
		$i = 0;
		foreach($ids as $key=>$val)
		{
			if($val !='')
			{
				$reminders[$i] = $remObj->getObj("id=".$val);
				$i++;
			}
		}
		$this->data['reminder'] = empty($reminders[0])?array():$reminders;
		
		$advice_page = IReq::get('page');
    	$this->form_id = empty($advice_page)?0:1;//专家建议页
    	$div_id = IReq::get('div_id');
    	$this->div_id = empty($div_id)?0:$div_id;//选择标签号
		
		$this->setRenderData($this->data);
		$this->redirect('warm_advice');
	}
	function del_reminder()
	{
		$r_id = IReq::get('r_id');
		$user_id = IReq::get('user_id');
		$memberObj = new IModel('member');
		$mem_data = $memberObj->getObj("user_id=".$user_id);
		$id_arr = explode(',',$mem_data['reminder_ids'] );
		foreach ($id_arr as $key=>$val)
		{
			if($val == $r_id)
			unset($id_arr[$key]);
		}
		if(count($id_arr)==2)
		$id_str ='';
		else
		$id_str = implode(',', $id_arr);
		$memberObj->setData(array('reminder_ids'=>$id_str));
		$memberObj->update("user_id=".$user_id);
	}
    //[个人资料]展示 单页
    /*function info()
    {
    	$user_id = $this->user['user_id'];

    	$userObj       = new IModel('user');
    	$where         = 'id = '.$user_id;
    	$this->userRow = $userObj->getObj($where);

    	$memberObj       = new IModel('member');
    	$where           = 'user_id = '.$user_id;
    	$this->memberRow = $memberObj->getObj($where);

    	$userGroupObj       = new IModel('user_group');
    	$where              = 'id = '.$this->memberRow['group_id'];
    	$this->userGroupRow = $userGroupObj->getObj($where);

    	$this->redirect('info');
    }

    //[个人资料] 修改 [动作]
    function info_edit_act()
    {
    	$user_id   = $this->user['user_id'];

    	$memberObj = new IModel('member');
    	$where     = 'user_id = '.$user_id;

		//出生年月
    	$year  = intval( IReq::get('year','post') );
    	$month = intval( IReq::get('month','post') );
    	$day   = intval( IReq::get('day','post') );
    	$birthday = $year.'-'.$month.'-'.$day;

    	//地区
    	$province = IFilter::act( IReq::get('province','post') ,'string');
    	$city     = IFilter::act( IReq::get('city','post') ,'string' );
    	$area     = IFilter::act( IReq::get('area','post') ,'string' );
    	$areaStr  = ','.$province.','.$city.','.$area.',';

    	$dataArray       = array(
    		'true_name'    => IFilter::act( IReq::get('true_name') ,'string'),
    		'sex'          => intval( IReq::get('sex') ),
    		'birthday'     => $birthday,
    		'zip'          => IFilter::act( IReq::get('zip') ,'string' ),
    		'msn'          => IFilter::act( IReq::get('msn') ,'string' ),
    		'qq'           => IFilter::act( IReq::get('qq') , 'string' ),
    		'contact_addr' => IFilter::act( IReq::get('contact_addr'), 'string'),
    		'mobile'       => IFilter::act( IReq::get('mobile'), 'string'),
    		'telephone'    => IFilter::act( IReq::get('telephone'),'string'),
    		'area'         => $areaStr,
    	);

    	$memberObj->setData($dataArray);
    	$memberObj->update($where);
    	$this->info();
    }*/
    
    //个人免费体验报名信息
    function activity_list()
    {
    	
    	$this->redirect('activity_list');
    	
    }
    
    //个人在线预定服务列表
    function service_list()
    {
		$this->redirect('service_list');    	
    }
    
    
	//在线咨询留言
	function online_qa()
	{
		$this->pid = intval(IReq::get('pid'));
		
		$this->redirect('online_qa');
	}
	
	//在线咨询留言（编辑）
	public function online_qa_edit()
    {
    	$pid = intval(IReq::get('pid'));
        $id = IFilter::act( IReq::get('id'),'int' );
        $title = IFilter::act(IReq::get('title'),'string');
        $content = IFilter::act(IReq::get('content'),'string' );
        $user_id = $this->user['user_id'];
        $model = new IModel('suggestion');
        $pro_model = new IModel('professional');
        $pro_name = $pro_model->getObj('id = '.$pid);
        $model->setData(array(
        'user_id'=>$user_id,
        'pro_id'=>$pid,
        'title'=>$title,
        'content'=>$content,
        'time'=>date('Y-m-d H:i:s'),
        'pro_name' => $pro_name['name'],
        'status' => '0',
        ));
        if($id =='')
        {
            $model->add();
        }
        else
        {
            $model->update('id = '.$id);
        }
        $this->redirect('online_qa');
    }
   
}
?>
