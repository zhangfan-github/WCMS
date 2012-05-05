<?php
/**
 * @copyright (c) 2011 panfeng
 * @file topic.php
 * @brief 专题类
 * @author caojun
 * @date 2011-11-24
 * @version 1.0
 */

class  Topic extends IController
{
	public  $layout="topic";
	public  $topic_id;
	public  $topic_array=array();
	//从url中获得具体是哪一个topic
	function init()
	{
		$topic_id = IReq::get("id");
		//分割id号 获取topic_id的值
		$id = explode("_", $topic_id);
		if (isset($id[0]))
		{
			$topic_id = $id[0];
		}
		
		//如果topic_id不为空
		if(!empty($topic_id))
		{
			$this->topic_id = $topic_id;
			
			//数据库里查询对应id的数据
			$where = "id=".$topic_id;
			$Obj = new IModel("special_topic");
			$topic_array = $Obj->getObj($where);
			if (!empty($topic_array))
			{
				$this->topic_array = $topic_array;
			}
			else
			{
				IError::show(404,"您查找的页面已经不存在了");
			}
		}
		else 
		{
			IError::show(404,"您查找的页面已经不存在了");
		}
	}
	function colum()
	{
		$id = IReq::get("id");
		//分割id
		$id_all = explode("_", $id);
		if (isset($id_all[1]))
		{
			$colum_id = $id_all[1];
		}	
		if (empty($colum_id))//默认显示第一个的内容
		{
			$tb_help = new IModel("special_topic_cat");		
			$help_row = $tb_help->query("topic_id={$this->topic_id}");
			if(!$help_row || !is_array($help_row)||$help_row[0]['topic_id']!=$this->topic_id)
			{
			IError::show(404,"您查找的页面已经不存在了");
			}
			$this->topic_colum =  $help_row[0];
		}
		else 
		{
			//查询当前主题下所有的colum内容
			$tb_help = new IModel("special_topic_cat");
			$help_row = $tb_help->query("id={$colum_id}");
			if(!$help_row || !is_array($help_row)||$help_row[0]['topic_id']!=$this->topic_id)
			{
				IError::show(404,"您查找的页面已经不存在了");
			}
			$this->topic_colum =  $help_row[0];
		}
		$this->redirect("colum");
	}
	//通过colum_id跟type类型查询所需的内容
	//type为1是文章，为2为是图片，为3是视频
	function  getContent($colum_id,$type)
	{
		if(empty($colum_id)||empty($type))
		{
			return  array();
		}
		else
		{
			switch ($type)
			{
				case 1:
					$tb_help = new IModel("article");
					$help_row = $tb_help->query("topic_cat_id={$colum_id}");
					break;
				/*case 2:
					$tn_help = new IModel("article");
					$help_row = $tb_help->query("topic_cat_id={$colum_id}");
					*/
			}
			return $help_row;
		}
	}
	//显示文章内容
	
	function article_detail()
	{
		$id = IReq::get("id");
		//分割id
		$id_all = explode("_", $id);
		$this->article_id = $id_all[1];
		if($this->article_id == '')
		{
			IError::show(403,'缺少咨询ID参数');
		}
		else
		{
			$articleObj       = new IModel('article');
			$this->articleRow = $articleObj->getObj('id = '.$this->article_id);
			if(empty($this->articleRow))
			{
				IError::show(403,'资讯文章不存在');
				exit;
			}
			$this->redirect('article_detail');
		}
	}
}
?>