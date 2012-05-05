<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file filelog_class.php
 * @brief 文本格式日志
 * @author RogueWolf
 * @date 2010-12-09
 * @version 0.6
 * @note
 */

/**
 * @class IFileLog
 * @brief 文本格式日志处理类
 */
class IFileLog implements ILog
{
	private $path;
	function __construct($path)
	{
		if (!file_exists($path))
		{
			IFile::mkdir($path.'/'.ITime::getDateTime('Y/m'));
		}
		$this->path = $path.'/'.ITime::getDateTime('Y/m');
	}
	/**
	 * @param $type String log类型
	 * @param  $content array loginfo数组
	 * @return bool 操作结果
	 * @brief  写日志
	 */
	public function write($type,$logs=array())
	{
		if (!is_array($logs))
		{
			return false;
		}
		$fileName = $this->path.'/'.$type.'_'.ITime::getDateTime('d').'.log';
		switch ($type)
		{
			case 'operator':
				$logs['author']=isset($logs['author'])?$logs['author']:$logs[0];
				$logs['action']=isset($logs['action'])?$logs['action']:$logs[1];
				$logs['content']=isset($logs['content'])?$logs['content']:$logs[2];
				$content = ITime::getDateTime()."\t".$logs['author']."\t".$logs['action']."\t".$logs['content']."\t\r\n";
				break;
			case 'error':
				$logs['file']=isset($logs['file'])?$logs['file']:$logs[0];
				$logs['line']=isset($logs['line'])?$logs['line']:$logs[1];
				$logs['content']=isset($logs['content'])?$logs['content']:$logs[2];
				$content = ITime::getDateTime()."\t".$logs['file']."\t".$logs['line']."\t".$logs['content']."\t\r\n";
				break;
			case 'sql':

				$logs['content']=isset($logs['content'])?$logs['content']:$logs[0];
				$logs['runtime']=isset($logs['runtime'])?$logs['runtime']:$logs[1];
				$content =  ITime::getDateTime()."\t".$logs['content']."\t".$logs['runtime']."\t\r\n";
				break;
			default:
				$content = ITime::getDateTime()."\t".$logs['file']."\t".$logs['line']."\t".'引用了错误的log类型'."\t\r\n";
				$fileName = $this->path.'/error_'.ITime::getDateTime('d').'.log';
		}
		$file = new IFile($fileName,'a');
		$result = $file->write($content);
		$file->save();
		if ($result)
		{
			return true;
		}else{
			return false;
		}
	}
}
?>