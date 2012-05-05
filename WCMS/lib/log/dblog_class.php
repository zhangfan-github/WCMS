<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file dblog_class.php
 * @brief 数据库格式日志
 * @author chendeshan
 * @date 2010-12-3
 * @version 0.6
 */

/**
 * @class IDBLog
 * @brief 数据库格式日志
 */
class IDBLog implements ILog
{
	/**
	 * @brief 向数据库写入log
	 * @param string log类型
	 * @param array log数据
	 */
	public function write($type,$logs=array())
	{
		//按照类型拼装数据
		switch($type)
		{
			case "operator":
			$logs['author']  = isset($logs['author'])  ? $logs['author']  : $logs[0];
			$logs['action']  = isset($logs['action'])  ? $logs['action']  : $logs[1];
			$logs['content'] = isset($logs['content']) ? $logs['content'] : $logs[2];
			$tableName       = 'log_operator';
			break;

			case "error":
			$logs['file']    = isset($logs['file'])   ? $logs['file']    : $logs[0];
			$logs['line']    = isset($logs['line'])   ? $logs['line']    : $logs[1];
			$logs['content'] = isset($logs['content'])? $logs['content'] : $logs[2];
			$tableName       = 'log_error';
			break;

			case "sql":
			$logs['content'] = isset($logs['content']) ? $logs['content'] : $logs[0];
			$logs['runtime'] = isset($logs['runtime']) ? $logs['runtime'] : $logs[1];
			$tableName = 'log_sql';
			break;
		}
		//运行时间
		$logs['datetime']  = ITime::getDateTime();

		//开始写入
		$logObj = new IModel($tableName);
		$logObj->setData($logs);
		$logObj->add();
	}
}

?>