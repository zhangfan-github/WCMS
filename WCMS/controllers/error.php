<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file error.php
 * @brief 错误处理类
 * @author chendeshan
 * @date 2010-12-16
 * @version 0.6
 */
class Error extends IController
{
	function error404()
	{
		$this->redirect('/site/error');
	}

	function error403($data)
	{
		if(is_array($data))
		{
			$data = isset($data['message']) ? urlencode(urlencode($data['message'])) : '';
		}
		else
		{
			$data = urlencode(urlencode($data));
		}

		$this->redirect('/site/error/msg/'.$data);
	}
}


?>
