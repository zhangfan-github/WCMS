<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file fileupload.php
 * @brief 图片上传防止重复类
 * @author chen xufeng
 * @date 2011-09-14
 * @version 0.8
 */

/**
 * @class FileUpload
 * @brief 文件上传防止重复类
 */
class FileUpload
{
	private $dir         = 'upload'; //文件存储的目录名称
	private $iterance    = false;     //防止重复提交开关

	//构造函数
	function __construct($dir = '')
	{
		//设置默认路径地址
		if($dir == '')
		{
			$dir  = isset(IWeb::$app->config['upload']) ? IWeb::$app->config['upload'] : $this->dir;
			$dir .= '/'.date('Y/m/d');
		}

		$this->setDir($dir);
	}

	/**
	 * @brief 防止文件重复提交
	 * @param bool $bool true:开启;false:关闭
	 */
	function setIterance($bool)
	{
		$this->iterance = $bool;
	}

	/**
	 * @brief 设置上传的目录
	 * @param string $dir
	 */
	function setDir($dir)
	{
		$this->dir = $dir;
	}

	//防止文件重复提交机制
	//返回值：null 表示不重复, 非空表示重复
	private function checkIterance($file,$fileObj)
	{
		//如果关闭了重复提交机制
		if($this->iterance == false)
			return null;
  
		$fileMD5  = null;    //上传文件的md5值(默认)
		$photoRow = array(); //文件库里文件信息(默认)
		$result   = array(); //判断结果

		if(file_exists($file))
		{
			//生成文件md5码
			$fileMD5 = md5_file($file);
		}

		if($fileMD5 !== null)
		{
    		//根据md5值取得文件数据
    		$where = "md5 = '".$fileMD5."'";
    		$fileRow = $fileObj->getObj($where); //一条记录
		}

		//文件库中存在相同文件判断
		if(isset($fileRow['file']))
		{
			if(is_file($fileRow['img'])) //数据文件存在
			{
				$result['file'] = $fileRow['file'];
				$result['flag']= 1;

				return $result;
			}
			else //数据文件不存在，从文件库记录表中删除
			{
				$fileObj->del('md5 = "'.$fileRow['md5'].'"');
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	/**
	 * @brief 文件信息入库
	 * @param array $insertData 要插入数据
	 		  object $fileObj  文件库库对象
	 */
	private function insert($insertData,$fileObj)
	{
		if($this->iterance == true)
		{
			$fileObj->setData($insertData);
			$fileObj->add();
		}
	}


	/**
	 * @brief 执行文件上传
	 * @return array key:控件名; val:文件路径名;
	 */
	function run()
	{
		//创建文件模型对象
		$fileObj = new IModel('source');

		//已经存在的文件数据，初始设置为空
		$fileArray = array();

		//过滤文件库中已经存在的文件
		foreach($_FILES as $key => $val)
		{
			//上传的所有临时文件
			$tmpFile  = isset($_FILES[$key]['tmp_name']) ? $_FILES[$key]['tmp_name'] : null;

			//没有找到匹配的控件
			if($tmpFile == null)
				continue;

			if(is_array($tmpFile))
			{
				foreach($tmpFile as $tmpKey => $tmpVal)
				{
					$result = $this->checkIterance($tmpVal,$fileObj);
					if($result != null)
					{
						$fileArray[$key][$tmpKey] = $result;
						unset($_FILES[$key]['name'][$tmpKey]);
					}
				}
			}
			else
			{
				$result = $this->checkIterance($tmpFile,$fileObj);
				if($result!=null)
				{
					$fileArray[$key] = $result;
					unset($_FILES[$key]);
				}
			}
		}

		//文件上传
		$upObj = new IUpload();
		$upObj->setDir($this->dir);
		$upState = $upObj->execute();
//		var_dump($upState);
		//检查上传状态
		foreach($upState as $key => $rs)
		{
			if(count($_FILES[$key]['name']) > 1)
				$isArray = true;
			else
				$isArray = false;

			foreach($rs as $innerKey => $val)
			{
				if($val['flag']==1)
				{
					//上传成功后文件信息
					$fileName   = $val['dir'].$val['name'];
					$fileMD5    = md5_file($fileName);

					$rs[$innerKey]['img']  = $fileName;

					$insertData = array(
						'id'        => $fileMD5,
					    'type'      => 2,
						'path'       => $fileName,
					);

					//将文件信息入库
					$this->insert($insertData,$fileObj);
				}

				if($isArray == true)
				{
					$fileArray[$key] = $rs;
				}
				else
				{
					$fileArray[$key] = $rs[0];
				}
			}
		}
		return $fileArray;
	}
}