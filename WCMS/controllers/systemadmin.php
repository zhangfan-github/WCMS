<?php
/**
 * @class SystemAdmin
 * @brief 后台登陆处理
 */
class SystemAdmin extends IController
{
	public $layout='';

	
	/****************************************************
	 * Author:Qiulin
	 * 2011-12-06
	 * IP过滤
	 **************************************************/
	function init()
	{
		$cur_ip = IClient::getIp();

		$enableIPObj = new IModel('ipaccess');
		$where ='';
		$startIpRow = $enableIPObj->query($where,'start_ip','id','asc');
		$endIpRow = $enableIPObj->query($where,'end_ip','id','asc');
		$result = false;

		if(count($startIpRow)>0)
		{
			

			for($i=0;$i<count($startIpRow);$i++)
			{
				$network = $startIpRow[$i]['start_ip'].'-'.$endIpRow[$i]['end_ip'];
				if($this->netMatch($network, $cur_ip) === true)
				{
					$result = true;
				}
					
			}
		}
		else 
		{
			$result = true;
		}
		if($result === false)
		{
			die('Access Error!');
		}
		
	}
	/***************** E  N  D *********************/
	//后台登陆
	function login_act()
	{
		$admin_name = IFilter::act(IReq::get('admin_name'));
		$password   = IReq::get('password');
		$message    = '';

		if($admin_name == '')
		{
			$message = '登录名不能为空';
		}
		else if($password == '')
		{
			$message = '密码不能为空';
		}
		else
		{
			$adminObj = new IModel('admin');
			$adminRow = $adminObj->getObj('admin_name = "'.$admin_name.'"');
			if(!empty($adminRow) && ($adminRow['password'] == md5($password)) && ($adminRow['is_del'] == 0))
			{
				$dataArray = array(
					'last_ip'   => IClient::getIp(),
					'last_time' => ITime::getDateTime(),
				);
				$adminObj->setData($dataArray);
				$where = 'id = '.$adminRow["id"];
				$adminObj->update($where);

				//根据角色分配权限
				if($adminRow['role_id'] == 0)
				{
					ISafe::set('admin_right','administrator');
					ISafe::set('admin_role_name','超级管理员');
				}
				else
				{
					$roleObj = new IModel('admin_role');
					$where   = 'id = '.$adminRow["role_id"].' and is_del = 0';
					$roleRow = $roleObj->getObj($where);
					ISafe::set('admin_right',$roleRow['rights']);
					ISafe::set('admin_role_name',$roleRow['name']);
				}
				ISafe::set('admin_id',$adminRow['id']);
				ISafe::set('admin_name',$adminRow['admin_name']);
				$this->redirect('/tools/article_list');
			}
			else
			{
				$message = '用户名与密码不匹配';
			}
		}

		if($message != '')
		{
			$this->admin_name = $admin_name;
			$this->redirect('index',false);
			Util::showMessage($message);
		}
	}

	//后台登出
	function logout()
	{
    	ISafe::clear('admin_id');
    	ISafe::clear('admin_right');
    	ISafe::clearAll();
    	$this->redirect('index');
	}
	
/*********************************************
	 * 2011-12-06
	 *********************************************/
	/**
	 * PHP 中检查或过滤 IP 地址
	 *
	 * 支持 IP 区间、CIDR（Classless Inter-Domain Routing）及单个 IP 格式
	 * 整理：http://www.CodeBit.cn
	 * 参考：
	 *   - {@link http://us2.php.net/manual/zh/function.ip2long.php#70055}
	 *   - {@link http://us2.php.net/manual/zh/function.ip2long.php#82397}
	 *
	 * @param string $network 网段，支持 IP 区间、CIDR及单个 IP 格式
	 * @param string $ip 要检查的 IP 地址
	 * @return boolean true:ip在该ip段内
	 */
	function netMatch($network, $ip) {
	 
	    $network = trim($network);
	    $ip = trim($ip);
	 
	    $result = false;
	 
	    // IP range : 174.129.0.0 - 174.129.255.255
	    if (false !== ($pos = strpos($network, "-"))) {
	        $from = ip2long(trim(substr($network, 0, $pos)));
	        $to = ip2long(trim(substr($network, $pos+1)));
	 
	        $ip = ip2long($ip);
	 
	        $result = ($ip >= $from and $ip <= $to);
	 
	    // CIDR : 174.129.0.0/16
	    } else if (false !== strpos($network,"/")) {
	        list ($net, $mask) = explode ('/', $network);
	        $result = (ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($net); 
	 
	    // single IP
	    } else {
	        $result = $network === $ip;
	 
	    }
	 
	    return $result;
	}
}
?>
