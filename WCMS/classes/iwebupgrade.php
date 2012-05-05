<?php
set_time_limit(0); 
/**
 * IWeb产品的自动升级类
 * @author walu<imcnan@gmail.com>
 */
class IWebUpgrade
{
	const URL = "http://product.jooyea.net/";	
		
	private $name = null;
	private $version = null;	
	
	private $name_arr = array('shop','sns','mall');
	public function __construct($name,$version = null)
	{
		if( ! in_array($name,$this->name_arr) )
		{
			trigger_error("Wrong product name when upgrading",E_USER_ERROR);
		}
		
		$this->name = $name;
		$this->version = $version;
	}
	
	/**
	 * 获取最新的版本数据
	 * return array 空数组或者 array('version'=>2.022 , 'download_url'=>"http://www.jooyea.net/abc.zip")
	 */	
	public function check_latest_version()
	{
		$url = self::URL."version.php?name={$this->name}";
		$info = file_get_contents($url);
		if( trim($info) == ''  )
		{
			return array();
		}
		return JSON::decode($info);
	}
	
	/**
	 * 获取要升级文件的 md5 hash
	 */
	public function get_files_info($from_version,$to_version=null)
	{
		if($to_version == null)
		{
			$to_version = $this->version;
		}
		$url = self::URL."file.php?name={$this->name}&from={$from_version}&to={$to_version}";
		$fileinfo = file_get_contents($url);
		if( trim($fileinfo) == '' )
		{
			return array();
		}
		return JSON::decode($fileinfo);
	}
	
	/**
	 * 下载文件
	 * @param string|array $file_name 文件名，可以为数组
	 */
	 public function download($from_version,$to_version=null)
	 {
	 	if($to_version == null)
		{
			$to_version = $this->version;
		}
		$url = self::URL."file.php?name={$this->name}&from={$from_version}&to={$to_version}";
		$fileinfo = file_get_contents($url);
		if( trim($fileinfo) == "" )
		{
			return false;
		}
		$fileinfo = JSON::decode($fileinfo);
		//当前工作目录是在index.php的目录下
		foreach($fileinfo as $key=>$value)
		{
			$url = self::URL."download.php?name={$this->name}&from={$from_version}&to={$to_version}&filename={$value['path']}";
			$content = file_get_contents($url);
			$value['path'] = ltrim($value['path'],"./\\");
			$this->copy_and_write($value['path'],$content);
		}
		return true;
	 }
	 
	 public function copy_and_write($path,$content)
	 {
	 	$dir = dirname($path);
	 	clearstatcache();
	 	if(file_exists($path))
	 	{
	 		$bak = IWeb::$app->getBasePath()."backup/upgrade/{$this->version}/{$path}";
	 		$bak_dir = dirname($bak);
	 		if( !file_exists( $bak_dir ) )
	 		{
	 			mkdir($bak_dir,0777,true);
	 		}
	 		copy($path,$bak);
	 	}
	 	
	 	if(!file_exists($dir))
	 	{
	 		mkdir($dir,0777,true);
	 	}
	 	file_put_contents($path,$content);
	 }
	 
	 /**
	  * 执行根目录下的iweb_upgrade.php，生成新版本号
	  */
	 public function upgrade()
	 {
	 	$version = $this->version;
	 	$current_version = include( IWeb::$app->getBasePath()."docs/version.php" );
	 	
	 	//
	 	$list = glob("iweb_{$this->name}_*.php");
	 	
	 	$file_list = array();
	 	foreach( $list as $filename )
	 	{
	 		preg_match("!iweb_[a-z]+_([\\.0-9]+)!",$filename,$m);
			$num = str_replace(".","",$m[1]);
			$file_list[$num] = $filename;
    	}
    	ksort($file_list);
    	foreach($file_list as $filename)
    	{
	 		$path = IWeb::$app->getBasePath().$filename;
	 		if(file_exists($path))
    		{
    			include($path);
    			unlink($path);
    		}
    	}
    	
    	$code = "<?php return '{$version}';";
    	file_put_contents( IWeb::$app->getBasePath()."docs/version.php",$code);
	 }
	 
	 public static function can_write($path)
	 {
	 	if(file_exists($path))
	 	{
	 		return is_writable($path);
	 	}
	 	else
	 	{
	 		$dir = dirname($path);
	 		if($dir)
	 		{
	 			return self::can_write( dirname( $path ) );
	 		}
	 		else
	 		{
	 			return false;
	 		}
	 		
	 	}
	 }
}
