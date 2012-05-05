<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file util.php
 * @brief 公共函数类
 * @author kane
 * @date 2011-01-13
 * @version 0.6
 * @note
 */

 /**
 * @class Util
 * @brief 公共函数类
 */
class Util
{
	/**
	 * @brief 移除分隔符
	 * @param string $str 		待处理字符串 	格式,如 '1,2,3,4,'
	 * @param string $separator 分隔符 			格式,如 ',','|'
	 * @param int 	 $position  位置 			0：移除开始位置分隔符；1：移除最后位置分隔符
	 * @return string 返回处理过的字符串
	 */
	public static function  removeSeparator($str,$separator,$position = -1)
	{
		if($position == -1)
		{
			if(substr($str,-1) == $separator)
			{
				$str= substr($str,0,strlen($str)-1);
			}
		}
		else
		{
			if(substr($str,0,1) == $separator)
			{
				$str = substr($str,1);
			}
		}
		return $str;
	}

	/**
	 * @brief 显示错误信息（dialog框）
	 * @param string $message	错误提示字符串
	 */
	public static function showMessage($message)
	{
		echo '<script type="text/javascript">art.dialog.alert("'.$message.'")</script>';
		exit;
	}

	/**
	 * 处理二维数组
	 *
	 * 根据第二维某个索引的值来设置相应的第一维数组的key
	 * 如原来是
	 * array(array('id'=>'a','data'=>'') ,array('id'=>1000,'data'=>'')  )
	 * 按照id索引处理后：
	 * array('a'=>array('id'=>'a','data'=>'') ,1000=>array('id'=>1000,'data'=>'')  )
	 *
	 * @author walu
	 * @param array $arr	待处理的二维数组
	 * @param array $key	获取第二维值的索引
	 * @return array
	 */
	public static function array_rekey($arr,$key='id')
	{
		$fun_re=array();
		foreach($arr as $value)
		{
			$fun_re[$value[$key]]=$value;
		}
		return $fun_re;
	}


	/**
	 * 将参数[可以为数组]的值进行intval
	 *
	 * 如果是不是数组，直接intval，如果是array，则将这个array所有的值转为整形
	 *
	 * @param mixed $arr
	 * @return mixed
	 * @author walu
	 */
	public static function intval_value($arr)
	{
		if(is_array($arr))
		{
			foreach($arr as $key=>$value)
			{
				$arr[$key] = self::intval_value($value);
			}
			return $arr;
		}
		else
		{
			return intval($arr);
		}
	}

	/**
	 * 检测是否为合法的用户名
	 *
	 * 合法的用户名：英文字母、数组、下划线、短横线、中文
	 * @param string $username
	 * @return bool
	 * @author walu
	 */
	 public static function is_username($username)
	 {
	 	return preg_match("!^[_a-zA-Z0-9\\x{4e00}-\\x{9fa5}]{2,20}$!u",$username);
	 }

	/**
	 * 把二维数组转成CSV格式的字符串
	 *
	 * @param array $array
	 * @param string $delimiter
	 * @param string $enclosure
	 * @return string
	 * @author walu
	 */
	public static function array2csv($array,$delimiter=",",$enclosure='"')
	{
		$string = array();
		foreach($array as $row)
		{
			$row_string=array();
			foreach($row as $value)
			{
				$value = str_replace('"','""',$value);
				$value = '"'.$value.'"';
				$row_string[] = $value;
			}

			$string[] = implode(",",$row_string);
		}
		$string = implode("\n",$string);
		return $string;
	}


}
?>
