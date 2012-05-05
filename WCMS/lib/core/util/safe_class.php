<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file safe_class.php
 * @brief 安全机制session或者cookie数据操作
 * @author chendeshan
 * @date 2011-02-24
 * @version 0.6
 */

/**
 * @class ISafe
 * @brief ISafe 安全机制session或者cookie数据操作
 */
class ISafe
{
	/**
	 * @brief 设置数据
	 * @param string $key 键名;
	 * @param mixed  $val 值;
	 */
	public static function set($key,$val)
	{
		$className = self::getSafeClass();
		call_user_func(array($className, 'set'),$key,$val);
	}

	/**
	 * @brief 获取数据
	 * @param string $key 要获取数据的键名
	 * @return mixed 键名为$key的值;
	 */
	public static function get($key)
	{
		$className = self::getSafeClass();
		$value = call_user_func(array($className, 'get'),$key);

		if($value != null && $className == 'ICookie')
		{
			self::set($key,$value);
		}

		return $value;
	}

	/**
	 * @brief 清除safe数据
	 * @param string $name 要删除的键值
	 */
	public static function clear($name = null)
	{
		$className = self::getSafeClass();
		call_user_func(array($className, 'clear'),$name);
	}

	/**
	 * @brief 清除所有的cookie或者session数据
	 */
	public static function clearAll()
	{
		$className = self::getSafeClass();
		call_user_func(array($className, 'clearAll'));
	}

	/**
	 * @brief 获取cookie或者session对象
	 * @return object cookie或者session操作对象
	 */
	public static function getSafeClass()
	{
		$mappingConf = array('cookie'=>'ICookie','session'=>'ISession');

		if(isset(IWeb::$app->config['safe']) && IWeb::$app->config['safe'] == 'session')
		{
			return $mappingConf['session'];
		}
		else
		{
			return $mappingConf['cookie'];
		}
	}
}
?>
