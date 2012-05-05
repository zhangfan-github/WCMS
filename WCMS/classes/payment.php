<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file payment.php
 * @brief 支付方式 操作类
 * @author kane
 * @date 2011-01-20
 * @version 0.6
 * @note
 */

/**
 * @class Payment
 * @brief 支付方式 操作类
 */
//支付状态：支付失败
define ( "PAY_FAILED", - 1);
//支付状态：支付超时
define ( "PAY_TIMEOUT", 0);
//支付状态：支付成功
define ( "PAY_SUCCESS", 1);
//支付状态：支付取消
define ( "PAY_CANCEL", 2);
//支付状态：支付错误
define ( "PAY_ERROR", 3);
//支付状态：支付进行
define ( "PAY_PROGRESS", 4);
//支付状态：支付无效
define ( "PAY_INVALID", 5);
//支付状态：手工支付
define ( "PAY_MANUAL", 0);

class Payment
{
	/**
	 * @brief 加载支付方式插件类
	 * @param string $payPlugin 		支付方式插件名称
	 * @return 返回支付插件类对象
	 */
	public function loadMethod($payPlugin)
	{
		$_plugin_path = IWeb::$app->getBasePath ().'plugins/payments/'.'pay_'.$payPlugin.'/';
		$path = $_plugin_path . 'pay_' . $payPlugin . '.php';
		if (file_exists ($path))
		{
			require_once ($path);
			$className = "pay_" . $payPlugin;
			$method = new $className;
			return $method;
		}
	}

	/**
	 * @brief 获取所有已添加的支付插件
	 * @return array 返回支付插件
	 */
	public function paymentList()
	{
		$query = new IQuery('payment as a');
     	$query->join = " join pay_plugin as b on a.plugin_id = b.id";
     	$query->fields = " a.id,a.plugin_id,a.name,a.status,b.description,b.logo ";
     	$list = $query->find();
     	return $list;
	}

	/**
	 * @brief 获取系统支付插件支持货币单位
	 * @return array 返回支付插件货币单位
	 */
	public function getSysCur( )
	{
		$CON_CURRENCY['CNY'] = ("人民币");
		$CON_CURRENCY['USD'] = ("美元");
		$CON_CURRENCY['EUR'] = ("欧元");
		$CON_CURRENCY['GBP'] = ("英磅");
		$CON_CURRENCY['CAD'] = ("加拿大元");
		$CON_CURRENCY['AUD'] = ("澳元");
		$CON_CURRENCY['RUB'] = ("卢布");
		$CON_CURRENCY['HKD'] = ("港币");
		$CON_CURRENCY['TWD'] = ("新台币 ");
		$CON_CURRENCY['KRW'] = ("韩元");
		$CON_CURRENCY['SGD'] = ("新加坡元");
		$CON_CURRENCY['NZD'] = ("新西兰元");
		$CON_CURRENCY['JPY'] = ("日元");
		$CON_CURRENCY['MYR'] = ("马元");
		$CON_CURRENCY['CHF'] = ("瑞士法郎");
		$CON_CURRENCY['SEK'] = ("瑞典克朗");
		$CON_CURRENCY['DKK'] = ("丹麦克朗");
		$CON_CURRENCY['PLZ'] = ("兹罗提");
		$CON_CURRENCY['NOK'] = ("挪威克朗");
		$CON_CURRENCY['HUF'] = ("福林");
		$CON_CURRENCY['CSK'] = ("捷克克朗");
		$CON_CURRENCY['MOP'] = ("葡币");
		return $CON_CURRENCY;
	}

	/**
	 * @brief 根据支付插件  获取该支付插件所支持的货币单位
	 * @return string 返回支付插件支持货币单位
	 */
	function getSupportCurrency($aThisPayCur)
	{
		$curName = "";
    	if(isset($aThisPayCur['DEFAULT']))
        {
        	$curName = ('商店默认货币');
        }
        else
        {
            $aCurLang = $this->getSysCur();
            if(isset($aThisPayCur['ALL']))
            {
            	$aThisPayCur = $aCurLang;
            }
           foreach($aThisPayCur as $k=>$v)
           {
           		$curName .= $aCurLang[$k].",&nbsp;";
           }
           $curName=$curName?rtrim($curName,',&nbsp;'):'';
        }
        return $curName;
    }

	/**
	 * @brief 更新支付方式插件
	 * @param array  		支付方式插件名称
	 * @return 返回支付插件类对象
	 */
	public function Update($data,$pay_id)
	{
		//初始化payment支付插件类
		$paymentObj = new IModel('payment');

		$paymentObj->setData($data);
		if($pay_id)
		{
			return $paymentObj->update(" id = ".$pay_id);
		}
		else
		{
			return $paymentObj->add();
		}
	}

	/**
	 * @brief 根据支付方式配置编号  获取该插件的详细配置信息
	 * @param int	支付方式配置编号
	 * @return 返回支付插件类对象
	 */
	public function getPaymentById($id)
	{
		$paymentObj = new IModel('payment as a,pay_plugin as b');
		return $paymentObj->getObj('a.id = '.$id.' and a.plugin_id = b.id');
	}

	/**
	 * @brief 设置支付状态
	 * @param int   $paymentId	支付编号
	 * @param int   $status		支付状态
	 * @param array $payInfo	支付详细内容
	 * @return bool	true：成功；false：失败
	 */
	public function setPayStatus($paymentId, $status, &$payInfo)
	{
		if (!$paymentId)
		{
			$this->setError (10001);
			trigger_error (("单据号传递出错"),E_USER_ERROR);
			return false;
			exit();
		}
		$paymentObj = new IModel('payment');
		$aPayInfo = $paymentObj->getObj('id='.$paymentId);
		if (!$aPayInfo)
		{
			$this->setError (10001);
			trigger_error (("支付记录不存在，可能参数传递出错"), E_USER_ERROR);
			return false;
			exit();
		}
		if ($aPayInfo ['status'] == "succ")
		{
			return true;
		}
		if ($aPayInfo ['status'] == "progress" && $status == PAY_PROGRESS)
		{
			return true;
		}
		if ($aPayInfo ['pay_type'] == "recharge" && $aPayInfo ['bank'] == "deposit")
		{
			$payInfo ['memo'] .=( "#不能用预存款支付来充值预存款！" );
			$status = PAY_FAILED;
		}
		if ($payInfo ['cur_money'] && $aPayInfo ['cur_money'] != $payInfo ['money'])
		{
			$status = PAY_ERROR;
			$payInfo ['memo'] .= ( "#实际支付金额与支付单中的金额不一致！" );
		}
		switch ($status)
		{
			case PAY_IGNORE :
				return false;
			case PAY_FAILED :
				$payInfo ['status'] = "failed";
				break;
			case PAY_TIMEOUT :
				$payInfo ['status'] = "timeout";
				break;
			case PAY_PROGRESS :
				$aPayInfo ['pay_assure'] = true;
				$aPayInfo ['pay_progress'] = "PAY_PROGRESS";
				$payInfo ['status'] = "progress";
				break;
			case PAY_SUCCESS :
				$payInfo ['status'] = "succ";
				break;
			case PAY_CANCEL :
				$payInfo ['status'] = "cancel";
				break;
			case PAY_ERROR :
				$payInfo ['status'] = "error";
				break;
			case PAY_REFUND_SUCCESS :
				return true;
		}

		return true;
	}

	/**
	 * @brief 支付完处理事件
	 * @param int   $paymentId	支付编号
	 * @param int   $status		支付状态
	 * @param array $payInfo	支付详细内容
	 */
	public function progress($paymentId, $status, $info)
	{
		$sendPay ['payment'] = $paymentId;
		$sendPay ['amount'] = $info ['money'];
		$sendPay ['order_id'] = $info ['trade_no'];
		$sendPay ['pay_status'] = $status;
		$base_url = substr(substr($base_url,0,strrpos( $base_url, "/" )),0,strrpos(substr($base_url,0,strrpos($base_url,"/")),"/"))."/";
		$payStatus = $this->setPayStatus ( $paymentId, $status, $info );
		$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
				<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-US\" lang=\"en-US\" dir=\"ltr\">
					<head></header>
				<body>Redirecting...";
		$html .= "订单编号:".$info ['trade_no']."支付金额：".$info ['money']." <br/></body></html>";
		echo $html;
	}

	/**
	 * @brief 获取订单中的支付信息
	 * @payment_id   支付方式信息
	 * @type         信息获取方式 order:订单支付;recharge:在线充值;
	 * @argument     参数
	 * @return array 支付提交信息
	 * R表示店铺 ; P表示用户;
	 */
	public function getPaymentInfo($payment_id,$type,$argument)
	{
		if($type == 'order')
		{
			$order_id = $argument;
			//获取订单信息
			$orderObj = new IModel('order');
			$orderRow = $orderObj->getObj('id = '.$order_id.' and status = 1');
			if(empty($orderRow))
			{
				IError::show(403,'订单信息不正确，不能进行支付');
			}

			//团购
			if($orderRow['type'] == 1)
			{
				$regimentRelationObj = new IModel('regiment_user_relation');
				$relationRow         = $regimentRelationObj->getObj('order_no = "'.$orderRow['order_no'].'"');

				if(empty($relationRow))
				{
					IError::show(403,'团购订单已经失效');
					exit;
				}
				else
				{
					if(abs(ITime::getDiffSec($relationRow['join_time'])) > regiment::time_limit() * 60)
					{
						IError::show(403,'支付时间已经过期');
						exit;
					}
				}
			}
			$payment ['M_Remark']    = $orderRow['postscript'];
			$payment ['M_OrderId']   = $orderRow['id'];
			$payment ['M_OrderNO']   = $orderRow['order_no'];
			$payment ['M_Amount']    = $orderRow['order_amount'];

			//用户信息
			$payment ['P_Mobile']    = $orderRow['mobile'];
			$payment ['P_Name']      = $orderRow['accept_name'];
			$payment ['P_PostCode']  = $orderRow['postcode'];
			$payment ['P_Telephone'] = $orderRow['telphone'];
			$payment ['P_Address']   = $orderRow['address'];
			$payment ['P_Email']     = '';
		}
		else if($type == 'recharge')
		{
			if(ISafe::get('user_id') == null)
			{
				IError::show(403,'请登录系统');
			}

			if(!isset($argument['account']) || $argument['account'] <= 0)
			{
				IError::show(403,'请填入正确的充值金额');
			}
			$rechargeObj = new IModel('online_recharge');
			$reData      = array(
				'user_id'     => ISafe::get('user_id'),
				'recharge_no' => Block::createOrderNum(),
				'account'     => $argument['account'],
				'time'        => ITime::getDateTime(),
				'payment_name'=> $argument['payment_type'],
				'status'      => 0,
			);
			$rechargeObj->setData($reData);
			$r_id = $rechargeObj->add();

			//充值时用户id跟随交易号一起发送,以"_"分割
			$payment ['M_OrderNO']   = 'recharge_'.$reData['recharge_no'];
			$payment ['M_OrderId']   = $r_id;
			$payment ['M_Amount']    = $reData['account'];
		}

		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();

		//交易信息
		$payment ['M_Def_Amount']= 0.01;
		$payment ['M_Currency']  = 'CNY';
		$payment ['M_Time']      = time ();
		$payment ['M_Goods']     = '';
		$payment ['M_Language']  = "zh_CN";
		$payment ['M_Paymentid'] = $payment_id;

		//店铺信息
		$payment ['R_Address']   = isset($site_config['address']) ? $site_config['address'] : '';
		$payment ['R_Name']      = isset($site_config['name'])    ? $site_config['name'] : '';
		$payment ['R_Mobile']    = isset($site_config['mobile'])  ? $site_config['mobile'] : '';
		$payment ['R_Telephone'] = isset($site_config['phone'])   ? $site_config['phone'] : '';
		$payment ['R_Postcode']  = '';
		$payment ['R_Email']     = '';

		$configinfo = $this->getPaymentById($payment_id);
		$pma        = $this->getPaymentFileName($configinfo['config'],$configinfo['file_path']);

		if(is_array($pma))
		{
			foreach ($pma as $key=>$val )
			{
				$payment [$key] = $val;
			}
		}
		return $payment;
	}

	/**
	 * @brief 获取支付插件中密钥文件
	 * @return array	支付插件中密钥文件
	 */
	public function getPaymentFileName($config, $ptype)
	{
		$payment = array();
		if (!empty($config))
		{
			$pmt = $this->loadMethod($ptype);

			$field = $pmt->getfields();
			$config = unserialize($config);
			if (is_array($config))
			{
				foreach($field as $k => $v )
				{
					if (strtoupper ( $v ['type'] ) == "FILE" || $k == "keyPass")
					{
						$payment [$k] = $config [$k];
					}
				}
			}
		}
		return $payment;
	}
}
?>
