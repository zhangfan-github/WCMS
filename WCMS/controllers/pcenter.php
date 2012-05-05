<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file
 * @brief
 * @author webning
 * @date 2011-03-08
 * @version 0.6
 * @note
 */
/**
 * @brief Ucenter
 * @class Ucenter
 * @note
 */
class Pcenter extends IController {
	public $layout = 'pcenter';
	function init() {
		$user = array ();
		$user ['pro_id'] = ISafe::get ( 'pro_id' );
		if ($user ['pro_id'] == '') {
			$this->redirect ( '/simple/login' );
		}
		$user ['proname'] = ISafe::get ( 'proname' );
		$user ['head_ico'] = ISafe::get ( 'head_ico' );
		$this->user = $user;
	}
	public function index() {
		$this->redirect ( 'info' );
	
	}
	
	/**
	 * @brief 删除消息
	 * @param int $id 消息ID
	 */
	public function message_del() {
		$id = IFilter::act ( IReq::get ( 'id' ), 'int' );
		$msg = new Mess ( $this->user ['pro_id'] );
		$msg->delMessage ( $id );
		$this->redirect ( 'message' );
	}
	public function message_read() {
		$id = intval ( IReq::get ( 'id' ) );
		$msg = new Mess ( $this->user ['pro_id'] );
		echo $msg->writeMessage ( $id, 1 );
	}
	
	//[修改密码]修改动作
	function password_edit() {
		$user_id = $this->user ['pro_id'];
		
		$fpassword = IReq::get ( 'fpassword' );
		$password = IReq::get ( 'password' );
		$repassword = IReq::get ( 'repassword' );
		
		$userObj = new IModel ( 'professional' );
		$where = 'id = ' . $user_id;
		$userRow = $userObj->getObj ( $where );
		
		if (! preg_match ( '|\w{6,32}|', $password )) {
			$message = '密码格式不正确，请重新输入';
		} else if ($password != $repassword) {
			$message = '二次密码输入的不一致，请重新输入';
		} else if (md5 ( $fpassword ) != $userRow ['password']) {
			$message = '原始密码输入错误';
		} else {
			$dataArray = array ('password' => md5 ( $password ) );
			
			$userObj->setData ( $dataArray );
			$result = $userObj->update ( $where );
			$message = ($result === false) ? '密码修改失败' : '密码修改成功';
		}
		
		$this->redirect ( 'password', false );
		Util::showMessage ( $message );
	}
	
	//[个人资料]展示 单页
	function info() {
		$user_id = $this->user ['pro_id'];
		
		$userObj = new IModel ( 'professional' );
		$where = 'id = ' . $user_id;
		$this->userRow = $userObj->getObj ( $where );
	
		$this->redirect ( 'info' );
	}
	
	//值班表
	function schedule()
	{
		$this->redirect('schedule');
	}
	
	
	//在线留言列表
	function online_qa()
	{
		$this->redirect("online_qa",false);
	}
	
	/**
	 * @brief 显示咨询信息
	 */
	function online_qa_edit()
	{
		$id = intval(IReq::get('id'));
		if(!$id)
		{
			$this->online_qa();
			return false;
		}
		$query = new IQuery("suggestion as a");
		$query->join = "left join user AS b ON a.user_id=b.id";
		$query->where = "a.id={$id}";
		$query->fields = "a.*,b.username";
		$items = $query->find();

		if(is_array($items) && $items)
		{
			$this->suggestion = $items[0];
			$this->redirect('online_qa_edit');
		}
		else
		{
			$this->online_qa();
		}
	}

	/**
	 * @brief 回复咨询
	 */
	function online_qa_edit_act()
	{
		$id = intval(IReq::get('id','post'));
		$re_content = IFilter::act( IReq::get('re_content','post') ,'string');
		$tb = new IModel("suggestion");
		$data = array('pro_id'=>$this->user['pro_id'],'re_content'=>$re_content,'re_time'=>date('Y-m-d H:i:s'));
		$tb->setData($data);
		$tb->update("id={$id}");
		$this->redirect("online_qa");
	}


	/**
	 * @brief 删除要删除的建议
	 */
	function online_qa_del()
	{
		$suggestion_ids = IReq::get('check');
		$suggestion_ids = is_array($suggestion_ids) ? $suggestion_ids : array($suggestion_ids);
		if($suggestion_ids)
		{
			$suggestion_ids =  Util::intval_value($suggestion_ids);

			$ids = implode(',',$suggestion_ids);
			if($ids)
			{
				$tb_suggestion = new IModel('suggestion');
				$where = "id in (".$ids.")";
				$tb_suggestion->del($where);
			}
		}
		$this->online_qa();
	}
	/**
	 * @brief 给vip用户的建议
	 */
	function advice_for_vip($message = NULL,$form_id = NULL)
	{
		$user_id = IReq::get('user_id');
		$vip_id = IReq::get('vip_id');
		$user_id = empty($user_id)?false:$user_id;
		$vip_id = empty($vip_id)?false:$vip_id;
		if($user_id && $vip_id)
		{

			$tb_member_info = new IModel('member_info');
			$tb_member_attribute = new IModel('member_attribute');
					
			$adv_info = $tb_member_info->query("user_id=".$user_id);
			$ainfo= empty($adv_info)?array():$adv_info[0];
			$ainfo['vip_id'] = $vip_id;
			$this->data['member'] = $ainfo;
			
			$attribute_info = $tb_member_attribute->query("user_id=".$user_id);
	        $attribute_info = empty($attribute_info)?array():$attribute_info;
	            
			$this->data['attribute'] = array();
			foreach($attribute_info as $key=>$val)
			{
				$this->data['attribute'][$val['attribute_id']] = $val['value'];
			}
		}
		
		$advice_page = IReq::get('page');
    	$form_id = empty($advice_page)?$form_id:1;//专家建议页
    	$this->form_id = ($form_id==NULL)?0:$form_id;//选择标签号
    	
    	$div_id = IReq::get('div_id');
    	$this->div_id = empty($div_id)?'':$div_id;
		
		
		$this->setRenderData($this->data);
		$this->redirect('advice_for_vip',false);
		if($message != NULL)
		Util::showMessage($message);	
	}
	/**
	 * @brief 保存建议
	 */
	function save_advice()
	{
		$type = IReq::get('type');
		$vip_id = IReq::get('vip_id');
		$advice = IReq::get('advice');
		
		$pro = new IModel('professional');
		$proinfo = $pro->query("id=".$this->user['pro_id']);
		
		$pro_group = new IModel('exp_group');
		$groupinfo = $pro_group->query("exper_id=".$proinfo[0]['id']." and group_id=".$type);
		//检验该专家是否是选定分组下的专家
		if(count($groupinfo)==0)
			$this->advice_for_vip("您不是该组下的专家，请重新选择分类");
		else {
			$pro_advice = new IModel('pro_advice');
			$data = array(
			'vip_id' 	  => $vip_id,
			'type' 		  => $type,
			'advice'	  => $advice,
			'pro_name'	  => $proinfo[0]['name'],
			'create_time' =>date("Y-m-d H:i:s")
			);
			$pro_advice->setData($data);
			$rs = $pro_advice->add();
			if($rs)
			$this->advice_for_vip("提交成功");
			else
			$this->advice_for_vip("提交失败，请重试");
		}	
	}	
}
?>
