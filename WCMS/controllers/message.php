<?php
/**
 * @copyright (c) 2009-2011 jooyea.net
 * @file member.php
 * @brief 邮件短消息控制器
 * @author Ben
 * @date 2011-1-25
 */
class Message extends IController
{
	protected $checkRight  = 'all';
	public $layout='admin';
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

	/**
	 * @brief 构造函数，调用父类构造函数、声明语言包对象
	 */
	function __construct()
	{
		parent::__construct(IWeb::$app,strtolower(__CLASS__));
		$this->lang = new ILanguage();
	}

	/**
	 * @brief 模板列表
	 */
	function tpl_list()
	{
		$tb_msg_template = new IModel('msg_template');
		$tpls = $tb_msg_template->query();
		$this->data['tpl'] = $tpls;
		$this->setRenderData($this->data);
		$this->redirect('tpl_list');
	}

	/**
	 * @brief 编辑模板
	 */
	function tpl_edit()
	{
		$tid = intval(IReq::get('tid'));
		if($tid)
		{
			$tb_msg_template = new IModel('msg_template');
			$data_tpl = $tb_msg_template->query('id='.$tid);
			if($data_tpl && is_array($data_tpl) && $info=$data_tpl[0])
			{
				$this->data['tpl'] = $info;
				$this->setRenderData($this->data);
				$this->redirect('tpl_edit');
			}
			else
			{
				$this->redirect('tpl_list');
			}

		}
		else
		{
			$this->redirect('tpl_list');
		}
	}

	/**
	 * @brief 保存模板修改
	 */
	function tpl_save()
	{
		$tid = intval(IReq::get('tpl_id','post'));
		if($tid)
		{
			$title = IFilter::act(IReq::get('title'),'string');
			$content = IFilter::act(IReq::get('content'),'text');
			$tb_msg_template = new IModel('msg_template');
			$tb_msg_template->setData(array('title'=>$title,'content'=>$content));
			$tb_msg_template->update('id='.$tid);
		}
		$this->redirect('tpl_list');
	}

	/**
	 * @brief 到货通知
	 */
	function notify_list()
	{
		$search = IReq::get('search');
		$keywords = IReq::get('keywords');

		$search_sql = IFilter::act($search);
		$keywords_sql = IFilter::act($keywords);

		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search_sql like '%{$keywords_sql}%' ";
		}
		$this->data['search'] = $search;
		$this->data['keywords'] = $keywords;
		$this->data['where'] = $where;
		$this->setRenderData($this->data);
		$this->redirect('notify_list');
	}

	/**
	 * @brief 删除登记的到货通知邮件
	 */
	function notify_del()
	{
		$notify_ids = IReq::get('check','post');
		if($notify_ids && is_array($notify_ids))
		{
			$notify_ids = Util::intval_value($notify_ids);
			$ids = implode(',',$notify_ids);
			if($ids)
			{
				$tb_notify = new IModel('notify_registry');
				$where = "id in (".$ids.")";
				$tb_notify->del($where);
			}
		}
		$this->redirect('notify_list');
	}

	/**
	 * @brief 发送到货通知邮件
	 */
	function notify_send()
	{
		if(Block::checkEmailConf() ==  false)
		{
			$return = array(
				'isError' => true,
				'message' => 'email配置信息不正确',
			);
			echo JSON::encode($return);
			exit;
		}

		$notify_ids = IReq::get('notifyid');
		$message    = '';
		if($notify_ids && is_array($notify_ids))
		{
			$notify_ids = Util::intval_value($notify_ids);

			$ids = implode(',',$notify_ids);
			$query = new IQuery("notify_registry as notify");
			$query->join = "right join goods as goods on notify.goods_id=goods.id left join user as u on notify.user_id = u.id";
			$query->fields = "notify.*,u.username,goods.name as goods_name,goods.store_nums";
			$query->where = "notify.id in(".$ids.")";
			$items = $query->find();

			$tb_msg_template = new IModel('msg_template');
			$tpl = $tb_msg_template->query("id=1");
			$title = $tpl[0]['title'] ? $tpl[0]['title'] :$tpl[0]['name'];
			$content = $tpl[0]['content'];

			$siteConfigObj = new Config("site_config");
			$site_config   = $siteConfigObj->getInfo();

			//使用系统mail函数发送
			if($site_config['email_type']=='2')
			{
				$smtp = new ISmtp();
				$from = $site_config['mail_address'];
			}
			else
			{
				//使用外部SMTP服务器发送
				$server   = $site_config['smtp'];
				$port     = $site_config['smtp_port'];
				$account  = $site_config['smtp_user'];
				$password = $site_config['smtp_pwd'];
				$smtp     = new ISmtp($server,$port,$account,$password);
				$from     = $site_config['mail_address'];
			}

			//库存大于0，且处于未发送状态的 发送通知
			$succeed = 0;
			$failed = 0;
			$tb_notify_registry = new IModel('notify_registry');

			foreach($items as $value)
			{
				$subject = str_replace(array('{$user_name}','{$goods_name}'),array($value['username'],$value['goods_name']),$title);
				$body    = str_replace(array('{$user_name}','{$goods_name}'),array($value['username'],$value['goods_name']),$content);
				$status  = $smtp->send($value['email'],$from,$subject,$body);

				if($status)
				{
					//发送成功
					$succeed++;
					$data = array('notify_time'=>date('Y-m-d H:i:s'),'notify_status'=>'1');
					$tb_notify_registry->setData($data);
					$tb_notify_registry->update('id='.$value['id']);
				}
				else
				{
					//发送失败
					$failed++;
				}
			}
		}
		$return = array(
			'isError' => false,
			'count'   => count($items),
			'succeed' => $succeed,
			'failed'  => $failed,
		);
		echo JSON::encode($return);
	}
	/**
	 * @brief 到货通知筛选
	 */
	function notify_filter()
	{
		$search = IReq::get('search');
		$keywords = IReq::get('keywords');
		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search like '%{$keywords}%' ";
		}
		$this->data['search'] = $search;
		$this->data['keywords'] = $keywords;
		$this->data['where'] = $where;

		$page = IReq::get('page');
		$page = intval($page) ? intval($page) : 1;
		$and = ' and ';
		$where = '';
		$goodsname_k = IFilter::string(IReq::get('goodsname_k'));
		$goodsname_v = IFilter::string(IReq::get('goodsname_v'));
		if($goodsname_k && $goodsname_v)
		{
			if($goodsname_k=='eq')
			{
				$where .= 'goods.name="'.$goodsname_v.'"'.$and;
			}else
			{
				$where .= 'goods.name like "%'.$goodsname_v.'%"'.$and;
			}
		}
		$username_k = IFilter::string(IReq::get('username_k'));
		$username_v = IFilter::string(IReq::get('username_v'));
		if($username_k && $username_v)
		{
			if($username_k=='eq')
			{
				$where .= 'u.username="'.$username_v.'"'.$and;
			}else
			{
				$where .= 'u.username like "%'.$username_v.'%"'.$and;
			}
		}
		$store_nums_k = IFilter::string(IReq::get('store_nums_k'));
		$stror_nums_v = intval(IReq::get('store_nums_v')) ? intval(IReq::get('store_nums_v')) : 0;
		if($store_nums_k)
		{
			if($store_nums_k=='gt')
			{
				$where .= 'goods.store_nums > "'.$stror_nums_v.'"'.$and;
			}elseif($store_nums_k=='eq')
			{
				$where .= 'goods.store_nums = "'.$stror_nums_v.'"'.$and;
			}else
			{
				$where .= 'goods.store_nums < "'.$stror_nums_v.'"'.$and;
			}
		}
		$email_k = IFilter::string(IReq::get('email_k'));
		$email_v = IFilter::string(IReq::get('email_v'));
		if($email_k && $email_v)
		{
			if($email_k=='gt')
			{
				$where .= 'notify.email = "'.$email_v.'"'.$and;
			}else
			{
				$where .= 'notify.email like "%'.$email_v.'%"'.$and;
			}
		}
		$regtimeBegin = IFilter::string(IReq::get('regtimeBegin'));
		if($regtimeBegin)
		{
			$where .= 'notify.register_time > "'.$regtimeBegin.'"'.$and;
		}
		$regtimeEnd = IFilter::string(IReq::get('regtimeEnd'));
		if($regtimeEnd)
		{
			$where .= 'notify.register_time < "'.$regtimeEnd.'"'.$and;
		}
		$status = intval(IReq::get('status'));
		if($status && $status!='-1')
		{
			$where .= 'notify.notify_status = "'.$status.'"'.$and;
		}

		$where .= ' 1 ';
		$query = new IQuery("notify_registry as notify");
		$query->join = "join goods as goods on notify.goods_id = goods.id left join user as u on notify.user_id = u.id";
		$query->fields = "notify.*,u.username,goods.name as goods_name,goods.store_nums";
		$query->page = $page;
		$query->where = $where;
		$this->data['list_items'] = $query->find();

		//debug($this->data['items']);

		$this->data['pageBar'] = $query->getPageBar('/message/notify_filter/');
		$this->setRenderData($this->data);
		$this->redirect('notify_filter');
	}

	/**
	 * 导出到货通知为CSV格式
	 */
	function notify_export()
	{
		$ids = IReq::get("ids");
		if($ids===null)
		{
			die();
		}
		$ids = explode(",",$ids);
		$ids = IFilter::act($ids,'int');
		if(!$ids)
		{
			die();
		}
		$ids = implode(',',$ids);

		$field = IReq::get("csv_field");
		if($field===null)
		{
			die();
		}
		$field = IFilter::act($field,'string');

		$list=array();
		$tb_notify = new IModel("notify_registry");
		$list = $tb_notify->query("id IN ({$ids})");

		if(!$list)
		{
			die();
		}


		//获取商品名称、库存、用户名
		$user_info = $goods_info = $user_ids = $goods_ids = array();
		foreach($list as $value)
		{
			$user_ids[] = $value['user_id'];
			$goods_ids[] = $value['goods_id'];
		}

		$goods_ids = implode(",",$goods_ids);
		$user_ids = implode(",",$user_ids);

		$tb_user = new IModel("user");
		$tb_goods = new IModel("goods");

		$goods_info = $tb_goods->query("id IN ({$goods_ids})");
		$user_info = $tb_user->query("id IN ({$user_ids})");
		$goods_info = Util::array_rekey($goods_info,'id');
		$user_info = Util::array_rekey($user_info,'id');

		$valid_field = array('id','goods_id','user_id','username','goods_name','email','register_time','content','store_nums');
		$new_list = array();

		$tb_msg_template = new IModel('msg_template');
		$tpl = $tb_msg_template->query("id=1");
		$title_tpl = $tpl[0]['title'] ? $tpl[0]['title'] :$tpl[0]['name'];
		$content_tpl = $tpl[0]['content'];


		foreach($list as $key=>$value)
		{
			$new_value=array();
			$username = isset($user_info[$value['user_id']])?$user_info[$value['user_id']]['username']:"";
			$goods_name = isset($goods_info[$value['goods_id']])?$goods_info[$value['goods_id']]['name']:"";

			foreach($field as $v)
			{
				if(!in_array($v,$valid_field))
				{
					continue;
				}
				switch($v)
				{
					case 'id':
					case 'goods_id':
					case 'user_id':
					case 'email':
					case 'register_time':
						$new_value[$v] = $value[$v];
						break;

					case 'username':
						$new_value[$v] = $username;
						break;

					case 'goods_name':
						$new_value[$v] = $goods_name;
						break;

					case 'store_nums':
						$new_value[$v] = isset($goods_info[$value['goods_id']])?$goods_info[$value['goods_id']]['store_nums']:"";
						break;
					case 'title':
						$new_value[$v] = str_replace(array('{$user_name}','{$goods_name}'),array($username,$goods_name),$title_tpl);
						break;
					case 'content':
						$new_value[$v] = str_replace(array('{$user_name}','{$goods_name}'),array($username,$goods_name),$content_tpl);
						break;
				}
			}
			$new_list[] = $new_value;
		}

		$now = date("Y-m-d_H:i");
		//开始生成csv
		header("Content-type:text/csv");
		header("Content-Disposition: attachment; filename=export_{$now}.csv");
		$string = Util::array2csv($new_list);
		die($string);


	}
	/**
	 * 2010-01-10 by caojun
	 * 在线报名
	 * */
	//报名列表
	function online_baoming()
	{
		$this->act_id = intval(IReq::get('act_id'));
		$this->redirect('online_baoming');
	}
	//报名修改
	function online_edit()
	{

		$id     = intval(IReq::get('id') );
		if ($id)
		{
			$online_baoming_source= new IModel('activity_reg');
			$where = 'id ='.$id;
			$this->showdata = $online_baoming_source->getObj($where);
			$this->redirect('online_edit');	
		}
		else 
		{
			$this->redirect('online_edit');
		}
	}
	//报名更新
	function online_edit_act()
	{
		$id   = intval(IReq::get('id') );
		if ($id)
		{
			$online_baoming_source= new IModel('activity_reg');
			$dataArray=array(
			'state' => intval(IReq::get('style'))
			);
			$online_baoming_source->setData($dataArray);
			$where= 'id='.$id;
			$online_baoming_source->update($where);
			$data = $online_baoming_source->getObj($where);
		}
		if (!empty($data['activity_id']))
		{
			$this->redirect('online_baoming');	
		}
		else if(!empty($data['services_id']))
		{
			$this->redirect('online_service_baoming');	
		}
		else 
		{
			$this->redirect('online_servicepack_baoming');	
		}
	}
	//报名删除
	function online_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int' );
		if($id)
		{
			$expert_source = new IModel('activity_reg');
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$data=$expert_source->getObj($where);
			$expert_source->del($where);	
		}
		if (!empty($data['activity_id']))
		{
			$this->redirect('online_baoming');	
		}
		else if(!empty($data['services_id']))
		{
			$this->redirect('online_service_baoming');	
		}
		else 
		{
			$this->redirect('online_servicepack_baoming');	
		}
	}
	function online_baoming_print()
	{

		$act_id = intval(IReq::get('act_id'));
		if ($act_id ==0||empty($act_id))
		{
			$online_baoming_source= new IModel('activity_reg');
			$where='activity_id is not null';
			$this->showdata1=$online_baoming_source->query($where);
		}
		else
		{
			$online_baoming_source= new IModel('activity_reg');	
			$where='activity_id ='.$act_id;
			$this->showdata1=$online_baoming_source->query($where);	
		}
		if(empty($this->showdata1[0]))
		{
			$this->online_baoming();
		}
		else 
		{
			$this->layout='excel';
			$this->redirect('online_baoming_print');
		}
	}
/**
	 * 2010-01-10 by caojun
	 * 在线预定
	 * */
	//预定列表
	function online_yuding()
	{
		$this->redirect('online_yuding');
	}
	
	//预定修改
	function online_yuding_edit()
	{

		$id     = intval(IReq::get('id') );
		if ($id)
		{
			$online_baoming_source= new IModel('yuding');
			$where = 'id ='.$id;
			$this->showdata = $online_baoming_source->getObj($where);
			$this->redirect('online_yuding_edit');	
		}
		else 
		{
			$this->redirect('online_yuding_edit');
		}
	}
	//预定更新
	function online_yuding_edit_act()
	{
		$id   = intval(IReq::get('id') );
		if ($id)
		{
			$online_baoming_source= new IModel('yuding');
			$dataArray=array(
			'state' => intval(IReq::get('style'))
			);
			$online_baoming_source->setData($dataArray);
			$where= 'id='.$id;
			$online_baoming_source->update($where);
			$data = $online_baoming_source->getObj($where);
		}
		$this->redirect('online_yuding');
	}
	//预定删除
	function online_yuding_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int' );
		if($id)
		{
			$expert_source = new IModel('yuding');
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$expert_source->del($where);	
		}
		$this->redirect('online_yuding');	
	}
	function  online_yuding_print()
	{
		$expert_source = new IModel('yuding');
		$this->showdata1=$expert_source->query();
		if(empty($this->showdata1[0]))
		{
			$this->online_service_baoming();
		}
		else 
		{
			$this->layout='excel';
			$this->redirect('online_yuding_print');
		}
	}
	
	//服务报名
	function online_service_baoming()
	{
		$this->act_id = intval(IReq::get('act_id'));
		$this->redirect('online_service_baoming');
	}
	
	function online_service_baoming_print()
	{
		$act_id = intval(IReq::get('act_id'));
		if ($act_id ==0||empty($act_id))
		{
			$online_baoming_source= new IModel('activity_reg');
			$where='services_id is not null';
			$this->showdata1=$online_baoming_source->query($where);
		}
		else
		{
			$online_baoming_source= new IModel('activity_reg');	
			$where='services_id ='.$act_id;
			$this->showdata1=$online_baoming_source->query($where);	 
		}
		if(empty($this->showdata1[0]))
		{
			$this->online_service_baoming();
		}
		else 
		{
			$this->layout='excel';
			$this->redirect('online_service_baoming_print');
		}
	}
	
	
	//套餐报名
	function online_servicepack_baoming()
	{
		$this->act_id = intval(IReq::get('act_id'));
		$this->redirect('online_servicepack_baoming');
	}
	function online_servicepack_baoming_print()
	{

		$act_id = intval(IReq::get('act_id'));
		if ($act_id ==0||empty($act_id))
		{
			$online_baoming_source= new IModel('activity_reg');
			$where='service_package_id is not null';
			$this->showdata1=$online_baoming_source->query($where);
		}
		else
		{
			$online_baoming_source= new IModel('activity_reg');	
			$where='service_package_id ='.$act_id;
			$this->showdata1=$online_baoming_source->query($where);	
		}
		if(empty($this->showdata1[0]))
		{
			$this->online_servicepack_baoming();
		}
		else 
		{
			$this->layout='excel';
			$this->redirect('online_servicepack_baoming_print');
		}
	}
	
}

