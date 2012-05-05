<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file paymentplugin.php
 * @brief 支付插件基类
 * @author kane
 * @date 2011-01-19
 * @version 0.6
 * @note
 */

 /**
 * @class PaymentPlugin
 * @brief 支付插件基类
 */
class paymentPlugin
{
	//form提交模式
	public $method = "post";
	//字符集
	public $charset = "utf8";
	//支付插件名称
	public $name = null;
	//支付插件logo
	public $logo = null;
	//版本
	public $version = null;
	//应用地址
	public $applyUrl = null;
	//详细内容
	public $intro = null;
	//支付完成后，回调地址
	public $callbackUrl = null;
	//支付顺序
	public $orderby = null;
	//支付插件配置信息
	public $_config = array( );
	//支付配置编号
	public $_payment = 0;

	/**
	* @brief 构造函数
	*/
	public function __construct()
	{
		$payName = str_replace('pay_','',get_class($this));

		//获取域名地址
		$sUrl =  IUrl::getHost().IUrl::creatUrl();
		$sUrl = str_replace( 'plugins/', '', $sUrl);
		//回调函数地址
		$this->callbackUrl = $sUrl."index.php/block/callback/payment_name/".$payName;

		//回调业务处理地址
		$this->serverCallbackUrl = $sUrl."index.php/block/server_callback/payment_name/".$payName;
	}

	/**
	* @brief 提交事件
	*/
	public function toSubmit()
	{
		return false;
	}

	/**
	* @brief 回调函数事件
	*/
	public function callback()
	{
		return false;
	}

	/**
	* @brief 获取支付插件配置详细信息
	*/
	public function getConf($paymentid,$key,$value = null)
	{
		if(count($this->_config) == 0)
		{
			$payment = new Payment();
			if (!$this->_payment)
			{
				$this->_payment = $paymentid;
			}
			$payment_cfg = $payment->getPaymentById($this->_payment);
			$this->_config = unserialize($payment_cfg['config']);
		}
		return $this->_config[$key];
	}
}
?>