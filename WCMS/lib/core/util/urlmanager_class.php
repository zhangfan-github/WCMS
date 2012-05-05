<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file urlmanager_class.php
 * @brief URL处理类
 * @author RogueWolf
 * @date 2010-12-02
 * @version 0.6
 * @note
 */

/**
 * @class IUrl
 * @brief IUrl URL处理类
 * @note
 */
class IUrl
{
	/**
	 * @brief  创建一个Iweb格式的url
	 * @param  String $url      传入的url
	 * @return String $finalUrl url地址
	 */
	public static function creatUrl($url='')
	{
		$rewriteRule = isset(IWeb::$app->config['rewriteRule'])?IWeb::$app->config['rewriteRule']:'path';
		$baseUrl =self::getPhpSelf();
		//判断是否需要返回绝对路径的url
		if ($url=='')
		{
			return self::getScriptDir();
		}
		if ($url=='/')
		{
			return  self::getScriptDir().$baseUrl;
		}
		$baseUrl = self::getScriptDir().$baseUrl;
		//解析url
		$urlParam = explode('/',$url);
		if (empty($urlParam[0]))
		{
			array_shift($urlParam);
		}

		//解析出module，controller，action
		$mandc = explode('-',$urlParam[0]);
		if(isset($mandc[1])&&!empty($mandc[1]))
		{
			$moudule = $mandc[0];
			$controller = $mandc[1];
		}
		else
		{
			$controller = $mandc[0];
		}
		if (isset($urlParam[1])&&!empty($urlParam[1]))
		{
			$action = $urlParam[1];
		}

		$finalUrl = '';
		$finalUrl .= isset($moudule)?$moudule.'-':'';
		$finalUrl .= isset($controller)?$controller.'/':'';
		$finalUrl .= isset($action)?$action.'/':'';

		//把module,controller,action从数组中移除
		array_shift($urlParam);
		array_shift($urlParam);

		//循环参数，拼接url
		for ($i=0;$i<count($urlParam);$i++)
		{
			if ($i%2==0&&$urlParam[$i]!='')
			{
				$finalUrl .= $urlParam[$i].'/'.(isset($urlParam[$i+1])?$urlParam[$i+1]:'').'/';
			}
		}
		$finalUrl = substr($finalUrl,0,-1);
		if (strpos($url,'/')==0)
		{
			if ($rewriteRule=='path')
			{
				$baseUrl = dirname($baseUrl);
			}
			$finalUrl= rtrim($baseUrl,"/\\") . '/' . ltrim($finalUrl,"/\\"); 
		}
		return $finalUrl;
	}
	/**
	 * @brief 获取网站根路径
	 * @param  string $protocol 协议  默认为http协议，不需要带'://'
	 * @return String $baseUrl  网站根路径
	 *
	 */
	public static function getHost($protocol='http')
	{
		$baseUrl = $protocol.'://'.strtolower($_SERVER['SERVER_NAME']?$_SERVER['SERVER_NAME']:$_SERVER['HTTP_HOST']);
		return $baseUrl;
	}
	/**
	 * @brief 获取当前执行文件名
	 * @return String 文件名
	 */
	public static function getPhpSelf()
	{
		return end(explode('/',$_SERVER['SCRIPT_NAME']));
	}
	/**
	 * @brief 返回入口文件URl地址
	 * @return string 返回入口文件URl地址
	 */
	public static function getEntryUrl()
	{
		return self::getHost().$_SERVER['SCRIPT_NAME'];
	}
	/**
	 * @brief 返回页面的前一页路由地址
	 * @return string 返回页面的前一页路由地址
	 */
	public static function getRefRoute()
	{
		if(isset($_SERVER['HTTP_REFERER']) && (self::getEntryUrl() & $_SERVER['HTTP_REFERER']) == self::getEntryUrl())
		{
			return substr($_SERVER['HTTP_REFERER'],strlen(self::getEntryUrl()));
		}
		else
			return '';
	}
	/**
	 * @brief  获取当前脚本所在文件夹
	 * @return 脚本所在文件夹
	 */
	public static function getScriptDir()
	{
		$re=trim(dirname($_SERVER['SCRIPT_NAME']),'\\');
		if($re!='/')
		{
			$re = $re."/";
		}
		return $re;
	}

	/**
	 * @brief 获取当前url地址
	 * @return String 当前url地址
	 */
	public static function getUrl()
	{
		$formart_array = explode('/',$_SERVER['SERVER_PROTOCOL']);
		$formart = $formart_array[0];
		$formart = !empty($formart)?$formart:"http";
		$url = "";
				
		if(isset($_SERVER['DOCUMENT_URI']))
		{
			$url=$_SERVER['DOCUMENT_URI'];
		}
		elseif( isset($_SERVER['SCRIPT_NAME']) && isset($_SERVER['PATH_INFO']) )
		{
			$url = $_SERVER['SCRIPT_NAME'].$_SERVER['PATH_INFO'];
		}
		elseif(isset($_SERVER['ORIG_PATH_INFO']))
		{
			$url = $_SERVER['ORIG_PATH_INFO'];
		}
		
		return self::getHost().$url;
	}
	
	/**
	 * @brief 获取当前URI地址
	 * @return String 当前URI地址
	 */
	public static function getUri()
	{
		if( !isset($_SERVER['REQUEST_URI']) ||  $_SERVER['REQUEST_URI'] == "" )
		{
			// IIS 的两种重写
			if (isset($_SERVER['HTTP_X_ORIGINAL_URL']))
			{
				$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
			}				
			else if (isset($_SERVER['HTTP_X_REWRITE_URL']))
			{
				$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
			} 
			else
			{
				//修正pathinfo
				if ( !isset($_SERVER['PATH_INFO']) && isset($_SERVER['ORIG_PATH_INFO']) )
					$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
			
				
				if ( isset($_SERVER['PATH_INFO']) ) {
					if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
						$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
					else
						$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
				}
					
			//修正query
				if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
				{
					$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
				}
				
			}
 		}
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * @brief 获取url参数
	 * @param String url 需要分析的url，默认为当前url
	 */
	public static function beginUrl($url='')
	{
		$url  = !empty($url)?$url:self::getUrl();
		preg_match('/\.php(.*)/',$url,$phpurl);
		if ( isset( $phpurl[1] ) && $phpurl[1])
		{
			$param_array = explode('/',$phpurl[1]);
			array_shift($param_array);
			$mandc = explode('-',$param_array[0]);
			if (isset($mandc[1]))
			{
				IReq::set('module',$mandc[0]);
				if($mandc[1]!='')IReq::set('controller',$mandc[1]);
			}else{
				if($mandc[0]!='')IReq::set('controller',$mandc[0]);
			}
			if (isset($param_array[1])&&!empty($param_array[1]))
			{
				IReq::set('action',$param_array[1]);
			}
			if (isset($_GET['c']))
			{
				IReq::set('controller',$_GET['c']);
			}
			if (isset($_GET['m']))
			{
				IReq::set('module',$_GET['m']);
			}
			if (isset($_GET['a']))
			{
				IReq::set('action',$_GET['a']);
			}
			if(IReq::get('action')=='run')IReq::set('action',null);
			array_shift($param_array);
			array_shift($param_array);
			if (is_array($param_array)&&count($param_array)>0)
			{
				for ($i=0;$i<count($param_array);$i++)
				{
					if ($i%2==0&&$param_array[$i]!='')
					{
						IReq::set($param_array[$i],isset($param_array[$i+1])?$param_array[$i+1]:null);
					}
				}
			}
		}
	}
	/**
	 * @brief  获取拼接两个地址
	 * @param  String $path_a
	 * @param  String $path_b
	 * @return string 处理后的URL地址
	 */
	public static function getRelative($path_a,$path_b)
	{
		$path_a = strtolower(str_replace('\\','/',$path_a));
		$path_b = strtolower(str_replace('\\','/',$path_b));
		$arr_a = explode("/" , $path_a) ;
		$arr_b = explode("/" , $path_b) ;
		$i = 0 ;
		while (true)
		{
			if($arr_a[$i] == $arr_b[$i]) $i++ ;
			else break ;
		}
		$len_b = count($arr_b) ;
		$len_a = count($arr_a) ;
		if(!$arr_b[$len_b-1])$len_b = $len_b - 1;
		if(!$len_a[$len_a-1])$len_a = $len_a - 1;
		$len = ($len_b>$len_a)?$len_b:$len_a ;
		$str_a = '' ;
		$str_b = '' ;
		for ($j = $i ;$j<$len ;$j++)
		{
			if(isset($arr_a[$j]))
			{
				$str_a .= $arr_a[$j].'/' ;
			}
			if(isset($arr_b[$j])) $str_b .= "../" ;
		}
		return $str_b . $str_a ;
	}
}
?>
