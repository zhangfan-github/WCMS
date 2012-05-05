<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file dbfactory.php
 * @brief 数据库工厂类
 * @author chendeshan
 * @date 2010-12-3
 * @version 0.6
 */

/**
* @class IDBFactory
* @brief 数据库工厂
*/
class IDBFactory
{
	//数据库对象
	public static $_instance = NULL;

	/**
	 * @brief 创建对象
	 * @return object 数据库对象
	 */
	public static function getDB()
	{

		//单例模式
		if(self::$_instance != NULL && is_object(self::$_instance))
		{
			return self::$_instance;
		}

		//获取数据库配置信息
		$dbinfo = IWeb::$app->config['DB'];

		//数据库类型
		$dbType = isset($dbinfo['type']) ? $dbinfo['type'] : $dbinfo[0];

		switch($dbType)
		{
			default:
			return self::$_instance = new IMysql();
			break;
		}
	}
}


?>