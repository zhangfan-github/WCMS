<?php
class Special_topic
{
//展示指定分类 select框
	static function showTopicCat($selectName='spetop_id',$selectedValue=null,$defaultValue=array())
	{
		//取得分类信息
		$catObj = new IModel('special_topic_cat');
		//$data   = $catObj->query('','topic_id,cat_name','topic_id','asc');

		//取得专题信息
		$topicObj = new IModel('special_topic');
		$data   = $topicObj->query('','id,title','id','asc');
		$str = '<select class="auto" id="'.$selectName.'" name="'.$selectName.'" pattern="required" alt="请选择栏目值">';

		//默认option值
		if(!empty($defaultValue))
			$str.='<option value="'.current($defaultValue).'">'.key($defaultValue).'</option>';

		//拼接栏目信息
		foreach($data as $val)
		{
			$str.='<optgroup label='.'└'.$val['title']. '>';
			$where  = ' topic_id= '.$val['id'].'';
			$catdata = $catObj->query($where,'cat_name,topic_id,id','topic_id','asc');
			foreach($catdata as $catval)
			{
				$isSelect = ($catval['id']==$selectedValue) ? 'selected=selected':null;
				$str.='<option value="'.$catval['id'].'" '.$isSelect.'>'."&nbsp;&nbsp".'└'.$catval['cat_name'].'</option>';
			}
			$str.='</optgroup>';
		}
		
		$str.='</select>';
		return $str;
	}
}