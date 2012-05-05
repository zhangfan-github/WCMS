<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file controllerbase_class.php
 * @brief 控制器基础类
 * @author chendeshan
 * @date 2010-12-3
 * @version 0.6
 */

/**
 * @class IControllerBase
 * @brief 控制器基础类
 */
class IControllerBase extends IObject
{
	/**
	 * @brief 渲染layout
	 * @param string $viewContent view代码
	 * @return string 解释后的view和layout代码
	 */
	public function renderLayout($layoutFile,$viewContent)
	{
		if(file_exists($layoutFile))
		{
			//在layout中替换view
			$layoutContent = file_get_contents($layoutFile);
			$content = str_replace('{viewcontent}',$viewContent,$layoutContent);
			return $content;
		}
		else
			return $viewContent;
	}

	/**
	 * @brief 渲染处理
	 * @param string $viewFile 要渲染的页面
	 * @param string or array $rdata 要渲染的数据
	 * @param bool 渲染的方式 值: true:缓冲区; false:直接渲染;
	 */
	public function renderView($viewFile,$rdata=null)
	{
		//渲染的数据
		if(is_array($rdata))
			extract($rdata,EXTR_OVERWRITE);
		else
			$data=$rdata;

		//渲染控制器数据
		extract($this->getRenderData(),EXTR_OVERWRITE);

		//渲染module数据
		extract($this->module->getRenderData(),EXTR_OVERWRITE);

		//要渲染的视图
		$renderFile = $viewFile.$this->extend;

		//检查视图文件是否存在
		if(file_exists($renderFile))
		{
			//控制器的视图(需要进行编译编译并且生成可以执行的php文件)
			if(stripos($renderFile,IWEB_PATH.'web/view/')===false)
			{
				//生成文件路径
				$runtimeFile = str_replace($this->getViewPath(),$this->module->getRuntimePath(),$viewFile.'.php');

				//layout文件
				$layoutFile = $this->getLayoutFile().$this->extend;

				if(!file_exists($runtimeFile) || (filemtime($renderFile) > filemtime($runtimeFile)) || (file_exists($layoutFile) && (filemtime($layoutFile) > filemtime($runtimeFile))))
				{
					//获取view内容
					$viewContent = file_get_contents($renderFile);

					//处理layout
					$__viewContent = $this->renderLayout($layoutFile,$viewContent);

					//标签编译
					$inputContent = $this->tagResolve($__viewContent);

					//创建文件
					$fileObj  = new IFile($runtimeFile,'w+');
					$fileObj->write($inputContent);
					$fileObj->save();
				}
			}
			else
				$runtimeFile = $renderFile;

			//文件编码头信息
			$charset = $this->module->getCharset();
			header("content-type:text/html;charset=".$charset);
			require($runtimeFile);
		}
		else
		{
			return false;
		}
	}

	/**
	 * @brief 编译标签
	 * @param string $content 要编译的标签
	 * @return string 编译后的标签
	 */
	public function tagResolve($content)
	{
		$tagObj = new ITag;
		return $tagObj->resolve($content);
	}

}
?>