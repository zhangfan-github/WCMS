<?php
/**
 * @copyright (c) 2009-2011 jooyea.net
 * @file action.php
 * @brief action 基类文件
 * @author Ben
 * @date 2010-12-16
 * @version 0.6
 */

/**
 * @class IAction
 * @brief action 基类文件
 */
class IAction
{
	protected $id;
	protected $controller;

	/**
	 * @param obj 控制器
	 * @param string $id action id
	 */
	function __construct($controller, $id)
	{
		$this->controller = $controller;
		$this->id = $id;
	}

	/**
	 * @return controller
	 * @brief 获取当前动作的controller
	 */
	function getController()
	{
		return $this->controller;
	}

	/**
	 * @return action id
	 * @brief 获取当前动作Id
	 */
	function getId()
	{
		return $this->id;
	}
}
?>
