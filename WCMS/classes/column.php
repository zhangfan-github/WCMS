<?php
/**
 * @copyright (c) 2011 Panfeng Studio
 * @file article.php
 * @brief 关于栏目管理
 * @author CHen Xufeng 
 * @date 2011-12-04
 * @version 0.6
 */

 /**
 * @class article
 * @brief 栏目管理模块
 */
class Column
{
	//展示select框分类
	static function showColumn($selectName='column_id',$selectedValue=null,$defaultValue=array())
	{
		//取得分类信息
		$catObj = new IModel('column');
		$data   = $catObj->query('','id,name,path','path','asc');

		$str = '<select class="auto" name="'.$selectName.'" pattern="required" alt="请选择栏目值">';

		//默认option值
		if(!empty($defaultValue))
			$str.='<option value="'.current($defaultValue).'">'.key($defaultValue).'</option>';

		//拼接栏目信息
		foreach($data as $val)
		{
			$isSelect = ($val['id']==$selectedValue) ? 'selected=selected':null;
			$str.='<option value="'.$val['id'].'" '.$isSelect.'>'.str_repeat("&nbsp;&nbsp;",substr_count($val['path'],",")-2).'└'.$val['name'].'</option>';
		}
		$str.='</select>';
		return $str;
	}

	//展示select框栏目类型
	static function showColumnType($selectName='column_type_id',$selectedValue=null,$defaultValue=array())
	{
		//取得栏目分类信息
		$catObj = new IModel('column_type');
		$data   = $catObj->query('status=1','id,name,code','id','asc');

		$str = '<select class="auto" name="'.$selectName.'" pattern="required" alt="请选择类型值">';

		//默认option值
		if(!empty($defaultValue))
			$str.='<option value="'.current($defaultValue).'">'.key($defaultValue).'</option>';

		//拼接分类信息
		foreach($data as $val)
		{
			$isSelect = ($val['code']==$selectedValue) ? 'selected=selected':null;
			$str.='<option value="'.$val['code'].'" '.$isSelect.'>'.$val['name'].'</option>';
		}


		$str.='</select>';
		return $str;
	}

	//显示栏目类型名称
	static function showColumnTypeName($typeCode=null)
	{
		//取得栏目分类信息
		$catObj = new IModel('column_type');
		$where  = 'code = \''.$typeCode.'\'';
		$catRow = $catObj->getObj($where);

		return $catRow['name'];
	}

	//显示栏目名称
	static function showColumnName($id=null)
	{
		//取得栏目分类信息
		$catObj = new IModel('column');
		$where  = 'id = '.$id;
		$catRow = $catObj->getObj($where);

		return $catRow['name'];
	}

	//是否为叶子栏目
	function isLeaf($columnID=null)
	{
		//取得栏目分类信息
		$catObj = new IModel('column');
		$where  = ' parent_id ='.$columnID;
		$data = $catObj->getObj($where);
		if(count($data)>0)
		{
			return false;
		}
		return true;
	}

	//是否为列表栏目
	static function inListTree($columnID=null,$columnType=null)
	{
		//取得栏目分类信息
		$catObj = new IModel('column');
		$where  = ' type=\''.$columnType.'\' and path like \'%,'.$columnID.',%\'';
		$data = $catObj->getObj($where);
		if(count($data)>0)
		{
			return true;
		}
		return false;
	}
	
	//是否为 下载
	static function inListTree1($columnID=null,$columnType=null)
	{
		//取得栏目分类信息
		$catObj = new IModel('column');
		$where  = ' type=\''.$columnType.'\' and id = '.$columnID.'';
		$data = $catObj->getObj($where);
		if(count($data)>0)
		{
			return true;
		}
		return false;
	}

	//展示指定分类 select框
	static function showSpecColumn($columnType=null,$selectName='column_id',$selectedValue=null,$defaultValue=array())
	{
		//取得分类信息
		$catObj = new IModel('column');
		$data   = $catObj->query('','id,name,path','path','asc');

		$str = '<select class="auto" name="'.$selectName.'" pattern="required" alt="请选择栏目值">';

		//默认option值
		if(!empty($defaultValue))
			$str.='<option value="'.current($defaultValue).'">'.key($defaultValue).'</option>';

		//拼接栏目信息
		foreach($data as $val)
		{
			$where  = ' type=\''.$columnType.'\' and path like \'%,'.$val['id'].',%\'';
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$isSelect = ($val['id']==$selectedValue) ? 'selected=selected':null;
				$str.='<option value="'.$val['id'].'" '.$isSelect.'>'.str_repeat("&nbsp;&nbsp;",substr_count($val['path'],",")-2).'└'.$val['name'].'</option>';
			}
		}
		$str.='</select>';
		return $str;
	}
	
	//展示指定分类 select框
	static function showSpecColumn1($columnType=null,$selectName='column_id',$selectedValue=null,$defaultValue=array())
	{
		//取得分类信息
		$catObj = new IModel('column');
		$data   = $catObj->query('','id,name,path','path','asc');

		$str = '<select class="auto" name="'.$selectName.'" pattern="required" alt="请选择栏目值">';

		//默认option值
		if(!empty($defaultValue))
			$str.='<option value="'.current($defaultValue).'">'.key($defaultValue).'</option>';

		//拼接栏目信息
		foreach($data as $val)
		{
			$where  = ' type=\''.$columnType.'\' and id = '.$val['id'].'';
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$isSelect = ($val['id']==$selectedValue) ? 'selected=selected':null;
				$str.='<option value="'.$val['id'].'" '.$isSelect.'>'.str_repeat("&nbsp;&nbsp;",substr_count($val['path'],",")-2).'└'.$val['name'].'</option>';
			}
		}
		$str.='</select>';
		return $str;
	}

	//是否为栏目内容页面
  static function hasContentPage($columnID=null)
	{
		//取得栏目分类信息
		$catObj = new IModel('content');
		$where  = ' column_id ='.$columnID;
		$data = $catObj->getObj($where);
		if(count($data)>0)
		{
			return true;
		}
		return false;
	}

//如果当前栏目下有子栏目，则直接显示其子栏目；否则，如果当前栏目有父栏目，则显示其兄弟栏目；否则，只显示当前栏目。
	static function getSubColumn($column)
	{
		
		$catObj = new IModel('column');
		if(!(Column::isLeaf($column['id']))) //有子栏目，显示子栏目
		{
			$where = 	' parent_id ='.$column['id'];
		}else if($column['parent_id'] == 0) //无子栏目，且无父栏目，显示当前栏目
		{
			$where = ' id = '.$column['id'];	
		}else //无子栏目，但有父栏目，显示兄弟栏目
		{
			$where = ' parent_id = '.$column['parent_id'];
		}
		
		return $catObj->query($where,'id,name,path,parent_id,type,sort','sort','asc');
	
	}
	
	//获取根栏目到指定栏目的路径
	static function getColumn2Root($column)
	{
			$column_path=array();
		
			$column_path[] = $column;
			
			$catObj = new IModel('column');
			$column_data = $column;
			while($column_data['parent_id'] !=0)
			{
					$where  = ' id ='.$column_data['parent_id'];
					$column_data = $catObj->getObj($where);
					$column_path[] = $column_data;
			}
			
			return $column_path;
	}
	
	//显示标题
	static function showTitle($title,$color=null,$fontStyle=null)
	{
		$str='<span style="';
		if($color!=null) $str.='color:'.$color.';';
		if($fontStyle!=null)
		{
			switch($fontStyle)
			{
				case "1":
				$str.='font-weight:bold;';
				break;

				case "2":
				$str.='font-style:oblique;';
				break;
			}
		}
		$str.='">'.$title.'</span>';
		return $str;
	}

		//展示服务分类select框分类
	static function showServiceCat($selectName='column_id',$selectedValue=null,$defaultValue=array())
	{
		//取得分类信息
		$catObj = new IModel('service_cat');
		$data   = $catObj->query('','id,name,path','path','asc');

		$str = '<select class="auto" name="'.$selectName.'" pattern="required" alt="请选择分类">';

		//默认option值
		if(!empty($defaultValue))
			$str.='<option value="'.current($defaultValue).'">'.key($defaultValue).'</option>';

		//拼接分类信息
		foreach($data as $val)
		{
			$isSelect = ($val['id']==$selectedValue) ? 'selected=selected':null;
			$str.='<option value="'.$val['id'].'" '.$isSelect.'>'.str_repeat("&nbsp;&nbsp;",substr_count($val['path'],",")-2).'└'.$val['name'].'</option>';
		}
		$str.='</select>';
		return $str;
	}
	
}
?>
