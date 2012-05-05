<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file Simple.php
 * @brief
 * @author webning
 * @date 2011-03-22
 * @version 0.6
 * @note
 */
/**
 * @brief Simple
 * @class Simple
 * @note
 */
class simple extends IController
{
  public $layout='site_mini';
	public $pwkey = "1234567890"; //这里换成你discuz论坛后台管理 通行证设置的passportkey
	public $bbsurl = "/bbs/"; //这里换成你的论坛地址
	public $forward_url = '/index.php/ucenter/';
	public $pro_forward_url = '/index.php/pcenter/'; //专家用户中心
	public $logout_forward_url = '/index.php'; //退出后跳到首页
	function init()
	{
		$user = array();
		$user['user_id']  = ISafe::get('user_id');
		$user['username'] = ISafe::get('username');
		$user['head_ico'] = ISafe::get('head_ico');
		$user['pro_id'] = ISafe::get('pro_id');
		$user['proname'] = ISafe::get('proname');
		$this->user = $user;
	}

	//退出登录
    function logout()
    {
    	//=========================================================================
		//============================discuz logout 整合===========================
		//=========================================================================
		//$FROMURL=$_SERVER["HTTP_REFERER"]?$_SERVER["HTTP_REFERER"]:$HTTP_SERVER_VARS["HTTP_REFERER"];
		$passportkey = $this->pwkey;
		$discuzbbsurl = $this->bbsurl;
		$forward = $this->logout_forward_url;
		$auth = ICookie::get('auth'); //这里是login完成时设置的cookie auth
		ICookie::set( "auth", "", time () - 3600 );
		$verify = md5 ( 'logout' . $auth . $forward . $passportkey );
		$auth = rawurlencode ( $auth );
		$forward = rawurlencode ( $forward );
		
		//清除登录信息
		ISafe::clear('user_id');
		ISafe::clear('pro_id');
		ISafe::clear('proname');
		ISafe::clear('username');
		ISafe::clear('head_ico');
    	ISafe::clearAll();
		ISafe::clearAll ();
		
		header ( "Location: " . $discuzbbsurl . "api/passport.php?action=logout&auth=$auth&forward=$forward&verify=$verify" );
		//=========================================================================
		//============================discuz logout 整合结束=======================
		//=========================================================================
    }

    //用户注册
    function reg_act()
    {
    	$email      = IFilter::act(IReq::get('email','post'));
    	$username   = IFilter::act(IReq::get('username','post'));
    	$password   = IFilter::act(IReq::get('password','post'));
    	$repassword = IFilter::act(IReq::get('repassword','post'));
    	$captcha    = IReq::get('captcha','post');
		$mobile     = IReq::get('mobile','post');
		$realname   = IReq::get('true_name','post');
		$sex		= IReq::get('sex','post');
		
    	$message    = '';
		$userObj = new IModel('user');
		/*注册信息校验*/
    	if(IValidate::email($email) == false)
    	{
    		$message = '邮箱格式不正确';
    	}
    	else if(!Util::is_username($username))
    	{
    		$message = '用户名必须是由2-20个字符，可以为字数，数字下划线和中文';
    	}
    	else if(!preg_match('|\S{6,32}|',$password))
    	{
    		$message = '密码必须是字母，数字，下划线组成的6-32个字符';
    	}
    	else if($password != $repassword)
    	{
    		$message = '2次密码输入不一致';
    	}
    	else
    	{
    		$where   = 'email = "'.$email.'" or username = "'.$email.'" or username = "'.$username.'"';
    		$userRow = $userObj->getObj($where);

    		if(!empty($userRow))
    		{
    			if($email == $userRow['email'])
    			{
    				$message = '此邮箱已经被注册过，请重新更换';
    			}
    			else
    			{
    				$message = "此用户名已经被注册过，请重新更换";
    			}
    		}
    	}

		//校验通过
    	if($message == '')
    	{
    		//user表
    		$userArray = array(
    			'username' => $username,
    			'password' => md5($password),
    			'email'    => $email,
    		);
    		$userObj->setData($userArray);
    		$user_id = $userObj->add();

    		if($user_id)
    		{
				//member表
	    		$memberArray = array(
	    			'user_id' => $user_id,
	    			'time'    => ITime::getDateTime(),
					'mobile_a'  => $mobile,
					'true_name'=> $realname,
					'sex'     => $sex,
	    		);
				
	    		$memberObj = new IModel('member');
	    		$memberObj->setData($memberArray);
	    		$memberObj->add();
				
				$infoObj = new IModel('member_info');
	    		$infoObj->setData(array('user_id'=>$user_id));
	    		$infoObj->add();

	    		//用户私密数据
	    		ISafe::set('username',$username);
	    		ISafe::set('user_id',$user_id);
				
				//==============================================================================
				//============================discuz login 整合=================================
				//==============================================================================
				//==============header到bbs=====================================================
				$passportkey = $this->pwkey;
				$discuzbbsurl = $this->bbsurl;
				$forward = $this->forward_url;
    			$cktime = 3600;
				$member = array
				(
					'cookietime'	=> $cktime,
					'time'			=> time(),
					'username'		=> $username,
					'password'		=> $password,
					'email'			=> $email
				);
				
				$auth = passport_encrypt(passport_encode($member), $passportkey);
				ICookie::set("auth",$auth,$cktime);
				
				$verify = md5('login'.$auth.$forward.$passportkey);
				$auth=rawurlencode($auth);
				$forward=rawurlencode($forward);
				header("Location: ".$discuzbbsurl."api/passport.php?action=login&auth=$auth&forward=$forward&verify=$verify");
				//==============================================================================	
    		}
    		else
    		{
    			$message = '注册失败';
    		}
    	}

		//出错信息展示
    	if($message != '')
    	{
    		$this->email    = $email;
    		$this->username = $username;

    		$this->redirect('reg',false);
    		Util::showMessage($message);
    	}
    }
	//vip注册,在激活之后
	function reg_for_vip()
    {
    	$vip_id   = IFilter::act(IReq::get('vip_id'));
    	$this->vip = $vip_id;
    	$this->redirect('reg_for_vip');
    }
	function reg_for_vip_act()
	{
		$vip        = IFilter::act(IReq::get('vip','post'));
    	$username   = IFilter::act(IReq::get('username','post'));
    	$password   = IFilter::act(IReq::get('password','post'));
    	$repassword = IFilter::act(IReq::get('repassword','post'));
    	$message    = '';
		$userObj = new IModel('user');
		/*注册信息校验*/
    	
    	if($password != $repassword)
    	{
    		$message = '2次密码输入不一致';
    	}

		//校验通过
    	if($message == '')
    	{
    		
    		if(!empty($vip))
    		{
	    		//user表
	    		$userArray = array(
	    			'username' => $username,
	    			'password' => md5($password),
	    		);
	    		
	    		$userinfo = $userObj->getObj("vip_id=".$vip);
    		
				if(!empty($userinfo)&&($userinfo['username']==$userinfo['vip_id']))
				{
					$userObj->setData($userArray);
		    		$userObj->update("vip_id=".$vip);
				

		    		//用户私密数据
		    		ISafe::set('username',$username);
		    		ISafe::set('user_id',$userinfo['id']);
					
					//==============================================================================
					//============================discuz login 整合=================================
					//==============================================================================
					//==============header到bbs=====================================================
					$passportkey = $this->pwkey;
					$discuzbbsurl = $this->bbsurl;
					$forward = $this->forward_url;
	    			$cktime = 3600;
					$member = array
					(
						'cookietime'	=> $cktime,
						'time'			=> time(),
						'username'		=> $username,
						'password'		=> $password,
						'email'			=> $userinfo['email']
					);
					
					$auth = passport_encrypt(passport_encode($member), $passportkey);
					ICookie::set("auth",$auth,$cktime);
					
					$verify = md5('login'.$auth.$forward.$passportkey);
					$auth=rawurlencode($auth);
					$forward=rawurlencode($forward);
					header("Location: ".$discuzbbsurl."api/passport.php?action=login&auth=$auth&forward=$forward&verify=$verify");
					//==============================================================================	
				}
				else $message = '注册失败';
    		}
    		else
    		{
    			$message = '您不是vip用户，请注册vip用户或重新激活';
    		}
    	}
		//出错信息展示
    	if($message != '')
    	{
			$this->vip = $vip ;
    		$this->redirect('reg_for_vip',false);
    		Util::showMessage($message);
    	}
	}
	//vip客户注册（激活）
 	function vip_reg_act()
 	{
 		
 		$mobile     = IReq::get('mobile','post');
    	$vip_id     = IReq::get('vip_id','post');
    	
 		$userObj = new IModel('user');
 		$memObj  = new IModel ('member');

    	$where   = "vip_id = '".$vip_id."'";
    	$userRow = $userObj->getObj($where);
    	
    	$message="";
    	if(empty($userRow))//不存在该 vip id 
    	{	
    		echo "8位自然数构成的ID是VIP会员专用号码，您目前不是禧妈拉伢网的VIP会员，欢迎您更改用户名后继续注册！";
    	}
    	else{
    		
    		
	    		$where   = 'user_id = '.$userRow['id'].' and (mobile_a = "'.$mobile.'" or mobile_b = "'.$mobile.'" or mobile_c = "'.$mobile.'")' ;
	    	    $memRow = $memObj->getObj($where);//查找注册手机号
	    	    
		    	if(!empty($memRow))//该vip用户存在，手机号匹配成功
		    	{	
					if($userRow['is_ready'] == 1)//已激活过
    				echo "该VIP ID 已可以使用，无须再次激活";
    				else {//未激活
				    	if($userRow['username']==$userRow['vip_id'])//网站新用户
			    		{
			    			echo 1;//填写完毕登录信息后完成激活
			    		}
			    		else//网站老用户，成为vip用户
			    		{
			    			$data = array('is_ready'=>1);
			    			$userObj->setData($data);
			    			if($userObj->update("vip_id=".$vip_id))//完成激活
			    			echo 2;
			    			else echo "激活失败，请重试";
			    		}
    				}
		    	}
		    	else{
		    		echo "您填写的手机号码有误，请查询后重新填写！";
		    	}
    	}
 	}
    //普通会员登录
    function user_login_act()
    {
    	$login_info = IFilter::act(IReq::get('login_info','post'));
    	$password   = IFilter::act(IReq::get('password','post'));
    	$callback   = IReq::get('callback');
    	$discuz_forward = IReq::get('forward');
		$message    = '';
		$flag1 = 1;
		$flag2 = 1;
		$flag3 = 0;
		
		
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
    		$where   = 'u.username = "'.$login_info.'" and u.vip_id != "'.$login_info.'" and  m.status = 1 and u.id = m.user_id';
    		$userRow = $userObj->getObj($where);
	
    		if(empty($userRow))
    		{
				$flag1 = 0;//与用户名不匹配
	    		$where   = 'email = "'.$login_info.'" and m.status = 1 and u.id = m.user_id';
	    		$userRow = $userObj->getObj($where);
    		}
			if(empty($userRow))
			{
				$flag2 = 0;//与邮箱不匹配
				$flag3 = preg_match("/\d{8}$/",$login_info);
				if($flag3)
				{
					$where = 'u.vip_id = "'.$login_info.'" and m.status = 1 and u.is_ready = 1 and u.id = m.user_id';
					$userRow = $userObj->getObj($where);
				}
			}
    		//die('#1'.var_dump($userRow).'<br />'.$password.'+'.md5($password));
    		if(empty($userRow) && $flag3)
    		{
				$message = '对不起，该VIP用户未激活';
    			
    		}
			else if($flag1==0 && $flag2==0 && $flag3==0)
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
    				//$memberRow = $memberObj->getObj($where,'exp');
    				

    				//根据经验值分会员组
    				/*$groupObj = new IModel('user_group');
    				$groupRow = $groupObj->getObj($memberRow['exp'].' between minexp and maxexp ','id','discount','desc');
    				if(!empty($groupRow))
    				{
    					$dataArray = array('group_id' => $groupRow['id']);
    					$memberObj->setData($dataArray);
    					$memberObj->update('user_id = '.$userRow["id"]);
    				}*/

    				//==============================================================================
					//============================discuz login 整合=================================
					//==============================================================================
					//==============header到bbs=====================================================
					$passportkey = $this->pwkey;
					$discuzbbsurl = $this->bbsurl;
					
					if(isset($discuz_forward) && $discuz_forward!='')
					{
						$forward = $discuz_forward;
					}
					elseif(isset($callback) && $callback!='') 
					{
						$forward = $callback;
												
					}
					else
					{
						$forward = $this->forward_url;
					}

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
					
					$auth = passport_encrypt(passport_encode($member), $passportkey);
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
    		$this->redirect('login',false);
    	}
    }
    
    
    
    //专家用户登录
    function pro_login_act()
    {
    	$login_info = IFilter::act(IReq::get('pname','post'));
    	$password   = IFilter::act(IReq::get('ppassword','post'));
    	$callback = IReq::get('callback');
    	$discuz_forward = IReq::get('forward');
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
    		$userObj = new IModel('professional');
    		$where   = 'login_id = "'.$login_info.'" and state = 1 ';
    		$userRow = $userObj->getObj($where);
	
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
    				ISafe::set('pro_id',$userRow['id']);
    				ISafe::set('proname',$userRow['login_id']);
    				ISafe::set('head_ico',$userRow['head_ico']);
    				
    				//==============================================================================
					//============================discuz login 整合=================================
					//==============================================================================
					//==============header到bbs=====================================================
					$passportkey = $this->pwkey;
					$discuzbbsurl = $this->bbsurl;
					
    				if(isset($discuz_forward) && $discuz_forward!='')
					{
						$forward = $discuz_forward;
					}
					elseif(isset($callback) && $callback!='') 
					{
						$forward = $callback;
												
					}
					else
					{
						$forward = $this->pro_forward_url;
					}
					
	    			
	    			$cktime = 3600;
					$member = array
					(
						'cookietime'		=> $cktime,
						'time'			=> time(),
						'username'		=> $userRow['login_id'],
						'password'		=> $userRow['password'],
						'email'			=> $userRow['email']
					);
					
					$auth = passport_encrypt(passport_encode($member), $passportkey);
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
    		$this->pmessage = $message;
    		
    		$this->redirect('login',false);
    	}
    }

    //商品加入购物车[ajax]
    function joinCart()
    {
    	$link       = IReq::get('link');
    	$goods_id   = intval(IReq::get('goods_id'));
    	$goods_num  = intval(IReq::get('goods_num')) == 0 ? 1 : intval(IReq::get('goods_num'));
    	$type       = IFilter::act(IReq::get('type'));

		//加入购物车
    	$cartObj   = new Cart();
    	$addResult = $cartObj->add($goods_id,$goods_num,$type);

    	if($link != '')
    	{
    		$this->redirect($link);
    	}
    	else
    	{
	    	if($addResult === false)
	    	{
		    	$result = array(
		    		'isError' => true,
		    		'message' => '添加购物车失败，此商品的库存不足',
		    	);
	    	}
	    	else
	    	{
		    	$cartInfo = $cartObj->getMyCart();
		    	$result = array(
		    		'isError' => false,
		    		'data'    => $cartInfo,
		    		'message' => '添加成功',
		    	);
	    	}
	    	echo JSON::encode($result);
    	}
    }

    //根据goods_id获取货品
    function getProducts()
    {
    	$id = intval(IReq::get('id'));
    	$productObj   = new IModel('products');
    	$productsList = $productObj->query('goods_id = '.$id,'sell_price,id,spec_array,goods_id','store_nums','desc',7);
		if(!empty($productsList))
		{
			$data = array('mod' => 'selectProduct','productList' => $productsList);
			$this->redirect('/block/site',false,$data);
		}
		else
		{
			echo '';
		}
    }

    //删除购物车
    function removeCart()
    {
    	$link      = IReq::get('link');
    	$goods_id  = intval(IReq::get('goods_id'));
    	$type      = IReq::get('type');

    	$cartObj   = new Cart();
    	$cartInfo  = $cartObj->getMyCart();
    	$delResult = $cartObj->del($goods_id,$type);

    	if($link != '')
    	{
    		$this->redirect($link);
    	}
    	else
    	{
	    	if($delResult === false)
	    	{
	    		$result = array(
		    		'isError' => true,
		    		'message' => '删除商品失败',
	    		);
	    	}
	    	else
	    	{
		    	$goodsRow = $cartInfo[$type]['data'][$goods_id];
		    	$cartInfo['sum']   -= $goodsRow['sell_price'] * $goodsRow['count'];
		    	$cartInfo['count'] -= $goodsRow['count'];

		    	$result = array(
		    		'isError' => false,
		    		'data'    => $cartInfo,
		    	);
	    	}

	    	echo JSON::encode($result);
    	}
    }

    //清空购物车
    function clearCart()
    {
    	$cartObj = new Cart();
    	$cartObj->clear();
    	$this->redirect('cart');
    }

    //购物车div展示
    function showCart()
    {
    	$cartObj  = new Cart();
    	$cartList = $cartObj->getMyCart();
		$data['mod']  = 'mycart';
    	$data['data'] = array_merge($cartList['goods']['data'],$cartList['product']['data']);
    	$data['count']= $cartList['count'];
    	$data['sum']  = $cartList['sum'];
    	$this->redirect('/block/site',false,$data);
    }

    //购物车页面及商品价格计算[复杂]
    function cart($redirect = false)
    {
    	//防止页面刷新
    	header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);

		//开始计算购物车中的商品价格
    	$countObj = new CountSum();
    	$result   = $countObj->cart_count();

    	//返回值
    	$this->final_sum = $result['final_sum'];
    	$this->promotion = $result['promotion'];
    	$this->proReduce = $result['proReduce'];
    	$this->sum       = $result['sum'];
    	$this->goodsList = $result['goodsList'];
    	$this->productList = $result['productList'];
    	$this->count       = $result['count'];
    	$this->reduce      = $result['reduce'];
    	$this->weight      = $result['weight'];

		//渲染视图
    	$this->redirect('cart',$redirect);
    }

    //计算促销规则[ajax]
    function promotionRuleAjax()
    {
    	$promotion = array();
    	$proReduce = 0;

    	//总金额满足的促销规则
    	if($this->user['user_id'])
    	{
    		$final_sum = intval(IReq::get('final_sum'));

    		//获取 user_group
	    	$groupObj = new IModel('member as m,user_group as g');
			$groupRow = $groupObj->getObj('m.user_id = '.$this->user['user_id'].' and m.group_id = g.id','g.*');
			$groupRow['id'] = empty($groupRow) ? 0 : $groupRow['id'];

	    	$proObj = new ProRule($final_sum);
	    	$proObj->setUserGroup($groupRow['id']);

	    	$promotion = $proObj->getInfo();
	    	$proReduce = $final_sum - $proObj->getSum();
    	}

		$result = array(
    		'promotion' => $promotion,
    		'proReduce' => $proReduce,
		);

    	echo JSON::encode($result);
    }

    //购物车寄存功能[写入]
    function deposit_cart_set()
    {
    	$is_ajax = IReq::get('is_ajax');

    	//必须为登录用户
    	if($this->user['user_id'] == null)
    	{
    		$this->redirect('/simple/login?callback=/simple/cart');
    	}

    	//获取购物车中的信息
    	$cartObj    = new Cart();
    	$myCartInfo = $cartObj->getMyCart();

		/*寄存的数据
		格式：goods => array (id => count);
		*/
    	$depositArray = array();

    	if(isset($myCartInfo['goods']['id']) && !empty($myCartInfo['goods']['id']))
    	{
    		foreach($myCartInfo['goods']['id'] as $id)
    		{
    			$depositArray['goods'][$id]   = $myCartInfo['goods']['data'][$id]['count'];
    		}
    	}

    	if(isset($myCartInfo['product']['id']) && !empty($myCartInfo['product']['id']))
    	{
    		foreach($myCartInfo['product']['id'] as $id)
    		{
    			$depositArray['product'][$id] = $myCartInfo['product']['data'][$id]['count'];
    		}
    	}

    	if(empty($depositArray))
    	{
    		$isError = true;
    		$message = '您的购物车中没有商品';
    	}
    	else
    	{
     		$isError = false;
	    	$dataArray   = array(
	    		'user_id'     => $this->user['user_id'],
	    		'content'     => serialize($depositArray),
	    		'create_time' => ITime::getDateTime(),
	    	);

	    	$goodsCarObj = new IModel('goods_car');
	    	$goodsCarRow = $goodsCarObj->getObj('user_id = '.$this->user['user_id']);
	    	$goodsCarObj->setData($dataArray);

	    	if(empty($goodsCarRow))
	    	{
	    		$goodsCarObj->add();
	    	}
	    	else
	    	{
	    		$goodsCarObj->update('user_id = '.$this->user['user_id']);
	    	}
	    	$message = '寄存成功';
    	}

		//ajax方式
    	if($is_ajax == 1)
    	{
    		$result = array(
    			'isError' => $isError,
    			'message' => $message,
    		);

    		echo JSON::encode($result);
    	}

    	//传统跳转方式
    	else
    	{
			//页面跳转
			$this->cart();
	    	if(isset($message))
	    	{
	    		Util::showMessage($message);
	    	}
    	}
    }

    //购物车寄存功能[读取]
    function deposit_cart_get()
    {
    	//必须为登录用户
    	if($this->user['user_id'] == null)
    	{
    		$this->redirect('/simple/login?callback=/simple/cart');
    	}

    	$goodsCatObj = new IModel('goods_car');
    	$goodsCarRow = $goodsCatObj->getObj('user_id = '.$this->user['user_id']);

    	if(isset($goodsCarRow['content']))
    	{
    		$depositContent = unserialize($goodsCarRow['content']);

	    	//获取购物车中的信息
	    	$cartObj    = new Cart();
	    	$myCartInfo = $cartObj->getMyCart();

	    	if(isset($depositContent['goods']))
	    	{
		    	foreach($depositContent['goods'] as $id => $count)
		    	{
		    		if(!in_array($id,$myCartInfo['goods']['id']))
		    		{
		    			$cartObj->add($id,$count,'goods');
		    		}
		    	}
	    	}

	    	if(isset($depositContent['product']))
	    	{
		    	foreach($depositContent['product'] as $id => $count)
		    	{
		    		if(!in_array($id,$myCartInfo['product']['id']))
		    		{
		    			$cartObj->add($id,$count,'product');
		    		}
		    	}
	    	}
    	}
    	else
    	{
    		$message = '您没有寄存任何商品';
    	}

		//页面跳转
    	if(isset($message))
    	{
    		$this->cart(false);
    		Util::showMessage($message);
    	}
    	else
    	{
    		$this->cart(true);
    	}
    }

    //清空寄存购物车
    function deposit_cart_clear()
    {
    	//必须为登录用户
    	if($this->user['user_id'] == null)
    	{
    		$this->redirect('/simple/login?callback=/simple/cart');
    	}

    	$goodsCarObj = new IModel('goods_car');
    	$goodsCarObj->del('user_id = '.$this->user['user_id']);
    	$this->cart();
    	Util::showMessage('操作成功');
    }

    //填写订单信息cart2
    function cart2()
    {
		$id        = intval(IReq::get('id'));
		$type      = IFilter::act(IReq::get('type'));
		$buy_num   = IReq::get('num') ? intval(IReq::get('num')) : 1;
		$promo     = IFilter::act(IReq::get('promo'));
		$active_id = intval(IReq::get('active_id'));
		$tourist   = IReq::get('tourist');//游客方式购物

    	//必须为登录用户
    	if($tourist === null && $this->user['user_id'] == null)
    	{
    		if($id == 0 || $type == '')
    		{
    			$this->redirect('/simple/login?tourist&callback=/simple/cart2');
    		}
    		else
    		{
    			$url  = '/simple/login?tourist&callback=/simple/cart2/id/'.$id.'/type/'.$type.'/num/'.$buy_num;
    			$url .= $promo     ? '/promo/'.$promo         : '';
    			$url .= $active_id ? '/active_id/'.$active_id : '';
    			$this->redirect($url);
    		}
    	}

		//游客的user_id默认为0
    	$user_id = ($this->user['user_id'] == null) ? 0 : $this->user['user_id'];

    	//获取收货地址
    	$addressObj  = new IModel('address');
    	$addressList = $addressObj->query('user_id = '.$user_id);

		$addressRow  = array();
		$areaArray   = array();
    	foreach($addressList as $val)
    	{
    		$areaArray[$val['province']] = $val['province'];
    		$areaArray[$val['city']]     = $val['city'];
    		$areaArray[$val['area']]     = $val['area'];
    	}

		if(!empty($areaArray))
		{
			//拼接area_id对应的名字
	    	$areaIdStr = join(',',$areaArray);
	    	$areaObj   = new IModel('areas');
	    	$areaList  = $areaObj->query('area_id in ('.$areaIdStr.')','area_name,area_id');
	    	foreach($areaList as $val)
	    	{
	    		$areaArray[$val['area_id']] = $val['area_name'];
	    	}

			//更新$addressList数据
	    	foreach($addressList as $key => $val)
	    	{
	    		$addressList[$key]['province_val'] = $areaArray[$val['province']];
	    		$addressList[$key]['city_val']     = $areaArray[$val['city']];
	    		$addressList[$key]['area_val']     = $areaArray[$val['area']];
	    		if($val['default'] == 1)
	    		{
	    			$addressRow = $addressList[$key];
	    		}
	    	}
		}

		//获取用户的道具红包和用户的习惯方式
		$this->prop = array();
		$memberObj = new IModel('member');
		$memberRow = $memberObj->getObj('user_id = '.$user_id,'prop,custom');

		if(isset($memberRow['prop']) && ($propId = trim($memberRow['prop'],',')))
		{
			$porpObj = new IModel('prop');
			$this->prop = $porpObj->query('id in ('.$propId.') and NOW() between start_time and end_time and type = 0 and is_close = 0 and is_userd = 0 and is_send = 1','id,name,value,card_name');
		}

		if(isset($memberRow['custom']) && $memberRow['custom'] != '')
		{
			$this->custom = unserialize($memberRow['custom']);
		}
		else
		{
			$this->custom = array(
				'payment'     => '',
				'delivery'    => '',
			);
		}

		//计算商品
		$countSumObj = new CountSum();

		//判断是特定活动还是购物车
		if($id != 0 && $type != '')
		{
			$result = $countSumObj->direct_count($id,$type,$buy_num,$promo,$active_id);
			$this->gid       = $id;
			$this->type      = $type;
			$this->num       = $buy_num;
			$this->promo     = $promo;
			$this->active_id = $active_id;
		}
		else
		{
			//计算购物车中的商品价格
			$result = $countSumObj->cart_count();
		}

		if($result['count'] == 0)
		{
			$this->redirect('/simple/cart');
			exit;
		}

    	//返回值
    	$this->final_sum = $result['final_sum'];
    	$this->promotion = $result['promotion'];
    	$this->proReduce = $result['proReduce'];
    	$this->sum       = $result['sum'];
    	$this->goodsList = $result['goodsList'];
    	$this->productList = $result['productList'];
    	$this->count       = $result['count'];
    	$this->reduce      = $result['reduce'];
    	$this->weight      = $result['weight'];
    	$this->freeFreight = $result['freeFreight'];

		//收货地址列表
		$this->addressList = $addressList;

		//默认收货地址
		$this->addressRow = $addressRow;

    	//获取税率
		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();
		$this->tax_per = isset($site_config['tax']) ? $site_config['tax'] : 0;
		$this->tax     = $this->final_sum * ($this->tax_per/100);

    	//渲染页面
    	$this->redirect('cart2');
    }

    function cart3()
    {
    	$accept_name       = IFilter::act(IReq::get('accept_name'));
    	$province          = IFilter::act(IReq::get('province'),'int');
    	$city              = IFilter::act(IReq::get('city'),'int');
    	$area              = IFilter::act(IReq::get('area'),'int');
    	$address           = IFilter::act(IReq::get('address'));
    	$mobile            = IFilter::act(IReq::get('mobile'));
    	$telphone          = IFilter::act(IReq::get('telphone'));
    	$zip               = IFilter::act(IReq::get('zip'));
    	$delivery_id       = IFilter::act(IReq::get('delivery_id'),'int');
    	$accept_time_radio = IFilter::act(IReq::get('accept_time_radio'),'int');
    	$accept_time       = IFilter::act(IReq::get('accept_time'));
    	$payment           = IFilter::act(IReq::get('payment'),'int');
    	$order_message     = IFilter::act(IReq::get('message'),'text');
    	$ticket_id         = IFilter::act(IReq::get('ticket_id'),'int');
    	$is_tax            = IFilter::act(IReq::get('is_tax'),'int');
    	$tax_title         = IFilter::act(IReq::get('tax_title'),'text');

    	$gid               = intval(IReq::get('direct_gid'));
    	$num               = intval(IReq::get('direct_num'));
    	$type              = IFilter::act(IReq::get('direct_type'));//商品或者货品
    	$promo             = IFilter::act(IReq::get('direct_promo'));
    	$active_id         = intval(IReq::get('direct_active_id'));
    	$tourist           = IReq::get('tourist');//游客方式购物

    	$dataArray         = array();

		//防止表单重复提交
    	if(IReq::get('timeKey') != null)
    	{
    		if(ISafe::get('timeKey') == IReq::get('timeKey'))
    		{
	    		IError::show(403,'订单数据不能被重复提交');
	    		exit;
    		}
    		else
    		{
    			ISafe::set('timeKey',IReq::get('timeKey'));
    		}
    	}

    	if($province == 0 || $city == 0 || $area == 0)
    	{
    		IError::show(403,'请填写收货地址的省市地区');
    	}

    	if($delivery_id == 0)
    	{
    		IError::show(403,'请选择配送方式');
    	}

    	$user_id = ($this->user['user_id'] == null) ? 0 : $this->user['user_id'];

		//付款方式,判断是否为货到付款
		$deliveryObj = new IModel('delivery');
		$deliveryRow = $deliveryObj->getObj('id = '.$delivery_id,'type');

		if($deliveryRow['type'] == 0 && $payment == 0)
		{
			IError::show(403,'请选择支付方式');
		}
		else if($deliveryRow['type'] == 1)
		{
			$payment = 0;
		}

    	$countSumObj = new CountSum();

    	//直接购买商品方式
    	if($type !='' && $gid != 0)
    	{
    		//计算$gid商品
    		$goodsResult = $countSumObj->direct_count($gid,$type,$num,$promo,$active_id);
    	}
    	else
    	{
			//计算购物车中的商品价格$goodsResult
			$goodsResult = $countSumObj->cart_count();

			//清空购物车
	    	$cartObj = new Cart();
	    	$cartObj->clear();
    	}

    	//判断商品商品是否存在
    	if(empty($goodsResult['goodsList']) && empty($goodsResult['productList']))
    	{
    		IError::show(403,'商品数据不存在');
    		exit;
    	}

		$sum_r         = $goodsResult['sum'];
		$proReduce_r   = $goodsResult['proReduce'];
		$reduce_r      = $goodsResult['reduce'];
		$final_sum_r   = $goodsResult['final_sum'];
		$freeFreight_r = $goodsResult['freeFreight'];
		$point_r       = $goodsResult['point'];
		$exp_r         = $goodsResult['exp'];

		//计算运费$deliveryPrice
    	$deliveryList  = Delivery::getDelivery($province,$goodsResult['weight']);
    	$deliveryPrice = $deliveryList[$delivery_id]['price'];

		if($freeFreight_r == true)
		{
			$deliveryPrice_r = 0;
		}
		else
		{
			$deliveryPrice_r = $deliveryPrice;
		}

    	//获取税率$tax
    	if($is_tax == 1)
    	{
			$siteConfigObj = new Config("site_config");
			$site_config   = $siteConfigObj->getInfo();
			$tax_per       = isset($site_config['tax']) ? $site_config['tax'] : 0;
			$tax           = $final_sum_r * ($tax_per/100);
    	}
    	else
    	{
    		$tax = 0;
    	}

		//货到付款的方式
		if($payment == 0)
		{
			$paymentName = '货到付款';
			$payment_fee = 0;
			$paymentType = 0;
		}
		else
		{
			//计算支付手续费
			$paymentObj = new IModel('payment');
			$paymentRow = $paymentObj->getObj('id = '.$payment,'type,poundage,poundage_type,name');
			$paymentName= $paymentRow['name'];
			$paymentType= $paymentRow['type'];

			if($paymentRow['poundage_type'] == 1)
			{
				$payment_fee = ($final_sum_r + $tax + $deliveryPrice_r) * ($paymentRow['poundage']/100);
			}
			else
			{
				$payment_fee = $paymentRow['poundage'];
			}
		}

		//获取红包减免金额
		if($ticket_id != '')
		{

			$memberObj = new IModel('member');
			$memberRow = $memberObj->getObj('user_id = '.$user_id,'prop,custom');

			if(stripos(','.trim($memberRow['prop'],',').',',','.$ticket_id.',') !== false || ISafe::get('ticket_'.$ticket_id) == $ticket_id)
			{
				$propObj   = new IModel('prop');
				$ticketRow = $propObj->getObj('id = '.$ticket_id.' and NOW() between start_time and end_time and type = 0 and is_close = 0 and is_userd = 0 and is_send = 1');
				if(!empty($ticketRow))
				{
					$ticket_value = $ticketRow['value'];
					$reduce_r    += $ticket_value;
					$final_sum_r -= $ticket_value;
					$dataArray['prop'] = $ticket_id;
				}

				//锁定红包状态
				$propObj->setData(array('is_close' => 2));
				$propObj->update('id = '.$ticket_id);
			}
		}

		//最终订单金额计算
		$order_amount = $final_sum_r + $deliveryPrice_r + $payment_fee + $tax;
		$order_amount = $order_amount <= 0 ? 0 : $order_amount;

		//生成的订单数据
		$dataArray = array(
			'order_no'            => block::createOrderNum(),
			'user_id'             => $user_id,
			'accept_name'         => $accept_name,
			'pay_type'            => $payment,
			'distribution'        => $delivery_id,
			'status'              => 1,
			'pay_status'          => 0,
			'distribution_status' => 0,
			'postcode'            => $zip,
			'telphone'            => $telphone,
			'province'            => $province,
			'city'                => $city,
			'area'                => $area,
			'address'             => $address,
			'mobile'              => $mobile,
			'create_time'         => ITime::getDateTime(),
			'invoice'             => $is_tax,
			'postscript'          => $order_message,
			'invoice_title'       => $tax_title,
			'accept_time'         => $accept_time,
			'exp'                 => $exp_r,
			'point'               => $point_r,

			//红包道具
			'prop'                => isset($dataArray['prop']) ? $dataArray['prop'] : null,

			//商品价格
			'payable_amount'      => $goodsResult['sum'],
			'real_amount'         => $goodsResult['final_sum'],

			//运费价格
			'payable_freight'     => $deliveryPrice,
			'real_freight'        => $deliveryPrice_r,

			//手续费
			'pay_fee'             => $payment_fee,

			//税金
			'taxes'               => $tax,

			//优惠价格
			'promotions'          => $proReduce_r + $reduce_r,

			//订单应付总额
			'order_amount'        => $order_amount,
		);

		$orderObj  = new IModel('order');
		$orderObj->setData($dataArray);

		$this->order_id = $orderObj->add();

		if($this->order_id == false)
		{
			IError::show(403,'订单生成错误');
		}

		/*将订单中的商品插入到order_goods表*/
		$orderGoodsObj = new IModel('order_goods');
		$goodsArray = array(
			'order_id' => $this->order_id
		);

		$findType = array('goods'=>'goodsList','product'=>'productList');

		foreach($findType as $key => $list)
		{
			if(isset($goodsResult[$list]) && count($goodsResult[$list]) > 0)
			{
				foreach($goodsResult[$list] as $k => $val)
				{
					//拼接商品名称和规格数据
					$specArray = array('name' => $val['name'],'value' => '');
					if($key == 'product')
					{
						$goodsArray['product_id']  = $val['id'];
						$goodsArray['goods_id']    = $val['goods_id'];

						$spec = block::show_spec($val['spec_array']);
						foreach($spec as $skey => $svalue)
						{
							$specArray['value'] .= $skey.':'.$svalue.' , ';
						}
					}
					else
					{
						$goodsArray['goods_id']  = $val['id'];
						$goodsArray['product_id']= 0;
					}
					$specArray = serialize($specArray);
					$goodsArray['goods_price'] = $val['sell_price'];
					$goodsArray['real_price']  = $val['sell_price'] - $val['reduce'];
					$goodsArray['goods_nums']  = $val['count'];
					$goodsArray['goods_weight']= $val['weight'];
					$goodsArray['goods_array'] = $specArray;
					$orderGoodsObj->setData($goodsArray);
					$orderGoodsObj->add();
				}
			}
		}

		//活动特殊处理
		if($promo != '' && $active_id != '')
		{
			//团购
			if($promo == 'groupon')
			{
				$regimentRelationObj = new IModel('regiment_user_relation');
				$regimentRelationObj->setData(array('order_no' => $dataArray['order_no']));
				$is_success = '';

				/* 检查团购报名状态
				 * 1,未登录用户以hash报名
				 * 2,登录用户以user_id报名
				 */
				if(($reg_hash = ICookie::get("regiment_{$active_id}")) != '')
				{
					$is_success = $regimentRelationObj->update('hash = "'.$reg_hash.'" and regiment_id = '.$active_id);
				}
				if($is_success == '' && $user_id != '')
				{
					$is_success = $regimentRelationObj->update('user_id = '.$user_id.' and regiment_id = '.$active_id);
				}

				if($is_success != '')
				{
					$orderObj->setData(array('type' => 1));
					$orderObj->update('id = '.$this->order_id);
				}
				else
				{
					IError::show(403,'你没有参加本商品的团购活动');
				}
			}
			//限时抢购
			else if($promo == 'time')
			{
				$orderObj->setData(array('type' => 2));
				$orderObj->update('id = '.$this->order_id);
			}
		}

		//更改购买商品的库存数量
		Block::updateStore($this->order_id , 'reduce');

		//记录用户默认习惯的数据
		if(!isset($memberRow['custom']))
		{
			$memberObj = new IModel('member');
			$memberRow = $memberObj->getObj('user_id = '.$user_id,'custom');
		}
		$memberData = array(
			'custom' => serialize(
				array(
					'payment'  => $payment,
					'delivery' => $delivery_id,
				)
			),
		);
		$memberObj->setData($memberData);
		$memberObj->update('user_id = '.$user_id);

		//如果用户没有默认的收货地址则修改此地址为默认地址
		$radio_address = intval(IReq::get('radio_address'));
		if($radio_address != 0)
		{
			$addressObj = new IModel('address');
			$addressRow = $addressObj->getObj('user_id = '.$user_id.' and `default` = 1');
			if(empty($addressRow))
			{
				$addressData = array('default' => 1);
				$addressObj->setData($addressData);
				$addressObj->update('user_id = '.$user_id.' and id = '.$radio_address);
			}
		}

		//获取备货时间
		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();
		$this->stockup_time = isset($site_config['stockup_time'])?$site_config['stockup_time']:2;

		//数据渲染
		$this->order_num   = $dataArray['order_no'];
		$this->final_sum   = $dataArray['order_amount'];
		$this->payment_fee = $payment_fee;
		$this->payment     = $paymentName;
		$this->delivery    = $deliveryList[$delivery_id]['name'];
		$this->tax_title   = $tax_title;
		$this->deliveryType= $deliveryRow['type'];
		$this->paymentType = $paymentType;

		//订单金额为0时，订单自动完成
		if($this->final_sum <= 0)
		{
			$order_id = Block::updateOrder($dataArray['order_no']);
			if($order_id != '')
			{
				if($user_id)
				{
					$this->redirect('/site/success/message/'.urlencode(urlencode("订单确认成功，等待发货")).'/?callback=ucenter/order_detail/id/'.$order_id);
				}
				else
				{
					$this->redirect('/site/success/message/'.urlencode(urlencode("订单确认成功，等待发货")));
				}
			}
			else
			{
				IError::show(403,'订单修改失败');
			}
		}
		else
		{
			$this->redirect('cart3');
		}
    }

    //cart3支付按钮操作
    function do_pay()
    {
    	$id       = intval(IReq::get('order_id'));
    	$payment  = intval(IReq::get('payment'));//更新的支付方式

    	$orderObj = new IModel('order');
    	$orderRow = $orderObj->getObj('id = '.$id);
    	if(empty($orderRow))
    	{
    		IError::show(403,'订单不存在');
    	}

		//更换了支付方式，更新手续费
    	if($payment != 0 && $orderRow['pay_type'] != $payment)
    	{
    		$paymentObj = new IModel('payment');
    		$payRow     = $paymentObj->getObj('id = '.$payment,'poundage_type,poundage');

    		if($payRow['poundage_type'] == 1)
    		{
    			$pay_fee = ($orderRow['order_amount'] - $orderRow['pay_fee']) * ($payRow['poundage']/100);
    		}
    		else
    		{
    			$pay_fee = $payRow['poundage'];
    		}

    		$dataArray = array(
    			'pay_type'     => $payment,
    			'order_amount' => $orderRow['order_amount'] - $orderRow['pay_fee'] + $pay_fee,
    			'pay_fee'      => $pay_fee,
    		);
    		$orderObj->setData($dataArray);
    		$orderObj->update('id = '.$id);
    	}
    	else
    	{
    		$payment = $orderRow['pay_type'];
    	}

		//拼接query字符串
		$query_str = '?order_id='.$id.'&id='.$payment;

    	$this->redirect('/block/doPay/'.$query_str);
    }

    //到货通知处理动作
	function arrival_notice()
	{
		$user_id = ISafe::get('user_id');
		if(!$user_id)
		{
			$user_id = 0;
		}
		/*
		未登录的时候也能弄到货通知
		if($user_id == '')
		{
			$this->redirect('/simple/login?callback='.urlencode('/simple/arrival'));
		}
		*/
		$email = IFilter::act( IReq::get('email') );
		$mobile = IFilter::act( IReq::get('mobile'));
		$goods_id = intval( IReq::get('goods_id') );
		$register_time = date('Y-m-d H:i:s');
		$model = new IModel('notify_registry');

		$obj = $model->getObj("email = '{$email}' and user_id = '{$user_id}' and goods_id = '$goods_id'");
		if(empty($obj))
		{
			$model->setData(array('email'=>$email,'user_id'=>$user_id,'mobile'=>$mobile,'goods_id'=>$goods_id,'register_time'=>$register_time));
			$model->add();
		}
		else
		{
			$model->setData(array('email'=>$email,'user_id'=>$user_id,'mobile'=>$mobile,'goods_id'=>$goods_id,'register_time'=>$register_time,'notify_status'=>0));
			$model->update('id = '.$obj['id']);
		}
		$this->redirect('arrival_result');
	}
    //到货通知登记页面
    function arrival()
    {
    	/*
        $user_id = ISafe::get('user_id');
		if($user_id == '')
		{
			$this->redirect('/simple/login?callback='.urlencode('/simple/arrival'));
		}
		*/
        $this->redirect('arrival');
    }
	//找回密码
    function do_find_password()
	{
		$username = IReq::get('username');
		if($username === null || !Util::is_username($username)  )
		{
			die("请输入正确的用户名");
		}

		$useremail = IReq::get("useremail");
		if($useremail ===null || !IValidate::email($useremail ))
		{
			die("请输入正确的邮箱地址");
		}
		
		$captcha = IReq::get("captcha");
		if($captcha != ISafe::get('Captcha'))
		{
			die('验证码输入不正确');
		}
		
		$tb_user = new IModel("user");
		$username = IFilter::act($username);
		$useremail = IFilter::act($useremail);
		$user = $tb_user->query("username='{$username}' AND email='{$useremail}'");
		if(!$user)
		{
			die("没有这个用户");
		}
		$user=end($user);

		$oldpw = $user['password'];
		$newpw = IHash::md5( microtime(true)  );
		$newpw = substr($newpw,10,8);//和上一行一起随机生成新密码

		$tb_user = new IModel("user"); //重新生成
		$tb_user->setData( array( 'password'=>IHash::md5($newpw)  ) );

		if( $tb_user->update("id={$user['id']} ")  )
		{
			$content = "Your new password：{$newpw}";

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

			$re = $smtp->send($user['email'],$from,"Your new password",$content );

			if($re===false )
			{
				$tb_user->setData( array('password'=>$oldpw ) );
				$tb_user->setData("id={$user['id']}");
				die("发信失败");
			}
			die("success");
		}
		die("找回密码失败");
	}

    //添加收藏夹
    function favorite_add()
    {
    	$goods_id = intval(IReq::get('goods_id'));
    	$cat_id   = intval(IReq::get('cat_id'));
    	$message  = '';

    	if($goods_id == 0)
    	{
    		$message = '商品id值不能为空';
    	}
    	else if(ISafe::get('user_id') == null)
    	{
    		$message = '请先登录';
    	}
    	else
    	{
    		$favoriteObj = new IModel('favorite');
    		$goodsRow    = $favoriteObj->getObj('user_id = '.$this->user['user_id'].' and rid = '.$goods_id);
    		if(!empty($goodsRow))
    		{
    			$message = '您已经收藏过次商品';
    		}
    		else
    		{
	    		$dataArray   = array(
	    			'user_id' => $this->user['user_id'],
	    			'rid'     => $goods_id,
	    			'time'    => ITime::getDateTime(),
	    			'cat_id'  => $cat_id,
	    		);
	    		$favoriteObj->setData($dataArray);
	    		$favoriteObj->add();
    		}
    	}

    	if($message == '')
    	{
    		$result = array(
    			'isError' => false,
    			'message' => '收藏成功',
    		);
    	}
    	else
    	{
    		$result = array(
    			'isError' => true,
    			'message' => $message,
    		);
    	}

    	echo JSON::encode($result);
    }
    
    
    /***********************************
     * 2011-12-10
     * Author:Qiulin
     * 下载模块
     * ********************************/
    function download()
    {
    	$id = IFilter::act(IReq::get('id'),'int');
    	$fileObj = new IModel('download');
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
    						$this->redirect('login',false);
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
    
    /****************** E N D **************/
	
    
    //服务课程表
    function schedule()
    {
    	$scheduleObj = new IModel('schedule');
		$scheduleData = $scheduleObj->query();
		$this->len = count($scheduleData);
		$this->scheduleRow = $scheduleData;
		$this->redirect('schedule');
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
	return base64_encode(passport_key($tmp, $key));

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