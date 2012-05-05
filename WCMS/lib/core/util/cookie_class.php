<?php
/**
 * @copyright (c) 2009-2011 jooyea.net
 * @file cookie_class.php
 * @brief 处理 Cookie
 * @author Ben
 * @date 2010-12-2
 * @version 0.6
 */

/**
 * @class ICookie
 * @brief ICookie的相关操作
 */
class ICookie
{
	//cookie前缀
	private static $pre        = 'iweb_';

	//默认cookie密钥
	private static $defaultKey = 'jooyea';

    /**
     * @brief 设置cookie的方法
     * @param string $name 字段名
     * @param string $value 对应的值
     * @param string $time 有效时间
     * @param string $path 工作路径
     * @param string $domain 作用域
     */
	public static function set($name,$value='',$time='3600',$path='/',$domain=null)
	{
		if($time <= 0) $time = -100;
		else $time = time() + $time;
		setCookie('safecode',self::cookieId(),$time,$path,$domain);
		if(is_array($value) || is_object($value)) $value=serialize($value);
		$value = ICrypt::encode($value,self::getKey());
		setCookie(self::$pre.$name,$value,$time,$path,$domain);
	}

    /**
     * @brief 取得cookie字段值的方法
     * @param string $name 字段名
     * @return mixed 对应的值
     */
	public static function get($name)
	{
		if(self::checkSafe()==1)
		{
			if(isset($_COOKIE[self::$pre.$name]))
			{
				$cookie= ICrypt::decode($_COOKIE[self::$pre.$name],self::getKey());
				$tem = substr($cookie,0,10);
				if(preg_match('/^[Oa]:\d+:.*/',$tem)) return unserialize($cookie);
				else return $cookie;
			}
			return null;
		}
		if(self::checkSafe()==0)
		{
			self::clear('safecode');
			IError::show(403);
		}
		else return null;
	}

    /**
     * @brief 清除cookie值的方法
     * @param string $name 字段名
     */
	public static function clear($name)
	{
		self::set($name,'',0);
	}

    /**
     * @brief 为了兼容Session
     */
	public static function clearAll()
	{
	}

    /**
     * @brief 安全检测函数
     * @return int 1:表示通过，0：表示未通过
     */
	private static function checkSafe()
	{
		if(isset($_COOKIE['safecode']))
		{
			if($_COOKIE['safecode']==self::cookieId())
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return -1;
		}
	}

	/**
	 * @brief 取得密钥
	 * @return string 返回密钥值
	 */
	private static function getKey()
	{
		$encryptKey = isset(IWeb::$app->config['encryptKey']) ? IWeb::$app->config['encryptKey'] : self::$defaultKey;
		return $encryptKey;
	}

    /**
     * @brief 取得cookie的安全码
     * @return String cookie的安全码
     */
	private static function cookieId()
	{
		return md5(IClient::getIP().$_SERVER["HTTP_USER_AGENT"]);
	}
}
?>
