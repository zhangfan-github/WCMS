<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file session_class.php
 * @brief session机制处理类
 * @author webning
 * @date 2011-02-24
 * @version 0.6
 */

 //开户session
session_start();
/**
 * @brief ISession 处理类
 * @class ISession
 * @note
 */
class ISession
{
	//session前缀
	private static $pre='iweb_';
	/**
	 * @brief 设置session数据
	 * @param string $name 字段名
	 * @param mixed $value 对应字段值
	 */
	public static function set($name,$value='')
	{
		if(self::checkSafe()==-1) $_SESSION['safecode']=self::sessionId();
		$_SESSION[self::$pre.$name]=$value;
	}
    /**
     * @brief 获取session数据
     * @param string $name 字段名
     * @return mixed 对应字段值
     */
	public static function get($name)
	{
		if(self::checkSafe()==1) return isset($_SESSION[self::$pre.$name])?$_SESSION[self::$pre.$name]:null;
		if(self::checkSafe()==0) IError::show(403,array('message'=>'非法窃取SESSION，系统将终止工作！'));
		else return null;
	}
    /**
     * @brief 清空某一个Session
     * @param mixed $name 字段名
     */
	public static function clear($name)
	{
		unset($_SESSION[self::$pre.$name]);
	}
    /**
     * @brief 清空所有Session
     */
	public static function clearAll()
	{
		return session_destroy();
	}
    /**
     * @brief Session的安全验证
     * @return int 1:通过验证,0:未通过验证
     */
	private static function checkSafe()
	{
		if(isset($_SESSION['safecode']))
		{
			if($_SESSION['safecode']==self::sessionId())
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
     * @brief 得到session安全码
     * @return String  session安全码
     */
	private static function sessionId()
	{
		return md5(IClient::getIP().$_SERVER["HTTP_USER_AGENT"]);
	}
}
?>
