<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file tools.php
 * @brief 工具类
 * @author chendeshan
 * @date 2010-12-16
 * @version 0.6
 */

class Tools extends IController
{
	public $layout='admin';
	protected $checkRight = 'all';
	private $member_data = array();
	function init()
	{
		$admin = array();
		$admin['admin_id']        = ISafe::get('admin_id');
		$admin['admin_name']      = ISafe::get('admin_name');
		$admin['admin_right']     = ISafe::get('admin_right');
		$admin['admin_role_name'] = ISafe::get('admin_role_name');
		if(!$admin['admin_id'] || !$admin['admin_right'])
		{
			$this->redirect('/systemadmin/index');
		}
		$this->admin = $admin;
	}

	public function seo_sitemaps()
	{
		$siteMaps =  new SiteMaps();
		$url = IUrl::getHost().IUrl::creatUrl("");
		$date = date('Y-m-d').'T'.date('H:i:s').'+00:00';
		$maps = array(
			array('loc'=>$url.'sitemap_goods.xml','lastmod'=>$date),
			array('loc'=>$url.'sitemap_article.xml','lastmod'=>$date)
			);
		$siteMaps->create($maps,$url.'sitemaps.xsl');
		$this->seo_items('goods');
		$this->seo_items('article');
		$this->redirect('seo_sitemaps');
	}
	public function seo_items($item)
	{
		$weburl = IUrl::getHost().IUrl::creatUrl("");
		switch($item)
		{
			case 'goods':
			{
				$query = new IQuery('goods');
				$url = IUrl::getHost().IUrl::creatUrl('/site/products/id/');
				$query->fields="concat('$url',id) as loc,create_time as lastmod";
				$items = $query->find();
				SiteMaps::create_map($items,'sitemap_goods.xml',$weburl.'sitemaps.xsl');
				break;
			}
			case 'article':
			{
				$query = new IQuery('article');
				$url = IUrl::getHost().IUrl::creatUrl('/site/article_detail/id/');
				$query->fields="concat('$url',id) as loc,create_time as lastmod";
				$items = $query->find();
				SiteMaps::create_map($items,'sitemap_article.xml',$weburl.'sitemaps.xsl');
			}
		}

	}
//[友情链接]列表
	function link_list()
	{
		$this->redirect('link_list');
	}
	//[友情链接]增加或者修改
	function link_edit_act()
	{
		$type  = 1;    //上传方式(默认为文字)
		$photo = null; //图片地址

		//图片上传
		if(isset($_FILES['attach']['name']) && $_FILES['attach']['name']!='')
		{
			$photoObj = new PhotoUpload();
			$photo    = $photoObj->run();
			$type     = 2; //上传方式设置为
		}

		$id = IReq::get('id');
		$id = intval($id);
		$obj = new IModel('links');

		//修改信息
		if($id)
		{
			$update = array(
				'name'    => IFilter::act( IReq::get('name','post'),'string' ),
				'type'    => $type,
				'linkurl' => IFilter::act( IReq::get('linkurl','post') ),
				'order'   => intval( IReq::get('order','post') ),
			);

			if($photo!=null) $update['photo'] = $photo['attach']['img'];

			$obj->setData($update);
			$where = 'id = '.$id;
			$obj->update($where);
		}
		//新增信息
		else
		{
			$insertdata = array(
				'name'    => IFilter::act( IReq::get('name','post'),'string' ),
				'type'    => $type,
				'linkurl' => IFilter::act( IReq::get('linkurl','post') ),
				'photo'   => $photo['attach']['img'],
				'order'   => intval( IReq::get('order','post') ),
			);
			$obj->setData($insertdata);
			$obj->add();
		}
		$this->redirect('link_list');
	}

	//[栏目链接]link单页
	function link_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$obj = new IModel('links');
			$where = 'id = '.$id;
			$data = $obj->getObj($where);
		}
		else
		{
			$data = array(
				'id'     => null,
				'name'   => null,
				'linkurl'=> null,
				'photo'  => null,
				'order'  => null,
			);
		}
		$this->setRenderData($data);
		$this->redirect('link_edit');
	}
	
	//图库管理
	function image_ctrl(){
		$this->redirect('image_ctrl');
	}
	
	//栏目链接列表
	function colum_link_list()
	{
		$this->redirect('colum_link_list');
	}
	
	//栏目链接编辑
	function colum_link_edit_act()
	{
		$id = IReq::get('id');
		$id = intval($id);
		$obj = new IModel('column_links');

		//修改信息
		if($id)
		{
			$update = array(
				'linkurl' => IFilter::act( IReq::get('linkurl','post') )
			);
			$obj->setData($update);
			$where = 'id = '.$id;
			$obj->update($where);
		}
		//新增信息
		else
		{
			$insert = array(
				'linkurl' => IFilter::act( IReq::get('linkurl','post') ),
				'column_id'   => intval( IReq::get('column_id','post') ),
			);
			$obj->setData($insert);
			$obj->add();
		}
		$this->redirect('colum_link_list');
	}
	
	//栏目链接查看
	function colum_link_edit()
	{
			$id = intval( IReq::get('id'));		
			$obj = new IModel('column_links');
			$where = 'column_id = '.$id;
			$data = $obj->getObj($where);
			$column = new IModel('column');
			$where = 'id = '.$id;
			$columndata = $column->getObj($where);
			$this->column=$columndata;
	  if($data==null)
		{
			$data = array(
				'id'     => null,
				'linkurl'=> null,
				'column_id'=> $id,
			);
		}
		$this->setRenderData($data);
		$this->redirect('colum_link_edit');
	}

	//[友情链接]删除
	function link_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int' );
		$obj = new IModel('links');
		if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);
			$this->redirect('link_list');
		}
		else
		{
			$this->redirect('link_list',false);
			Util::showMessage('请选择要删除的链接');
		}
	}
	
	//[体验产品]删除
	function tyzx_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('tyzx');


			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);               //删除商品
			$this->redirect('tyzx_list');
		}
		else
		{
			$this->redirect('tyzx_list',false);
			Util::showMessage('请选择要删除的DIY');
		}
	}
	
	//[体验产品]单页
	function tyzx_edit_show()
	{
		$id = IReq::get('id');
		$data=array();
		if($id)
		{
			$id = intval($id);

			//获取体验产品信息
			$noticeObj = new IModel('tyzx');
			$where      = 'id = '.$id;
			$this->productRow = $noticeObj->getObj($where);
			if(count($this->productRow)>0){
				$data['id']=$id;
				$data['form']=array(
					'name'         => $this->productRow['name'],
					'pro_model'    => $this->productRow['pro_model'],
					'color'        => $this->productRow['color'],
					'pro_length'   => $this->productRow['pro_length'],
					'pro_width'   => $this->productRow['pro_width'],
					'pro_height'   => $this->productRow['pro_height'],
					'pro_left'   => $this->productRow['pro_left'],
					'pro_right'   => $this->productRow['pro_right'],
					'photo_name'   => $this->productRow['photo_name']
				);
				$data['photo_name'] .= $this->productRow['photo_name'].',';
				//获得配置文件中的数据
				$config = new Config("site_config");
				$config_info = $config->getInfo();
				$show_thumb_width  = isset($config_info['show_thumb_width'])  ? $config_info['show_thumb_width']  : 85;
				$show_thumb_height = isset($config_info['show_thumb_height']) ? $config_info['show_thumb_height'] : 85;
				$data['show_attr'] = '_'.$show_thumb_width.'_'.$show_thumb_height;
				//$this->data = $data;
				$this->setRenderData($data);
				//var_dump($this->show_attr111);
			}else{
				$this->redirect('tyzx_list');
				Util::showMessage("没有找到相关商品！");
				return;
			}
		}
		//图片
		
//
		$this->redirect('tyzx_edit',false);
	}
	
	//[体验产品] 修改动作
	function tyzx_edit()
	{
		$id = IReq::get('id');
		$obj = new IModel('tyzx');
		$where      = 'id = '.$id;
		$dataArray = array(
		'name'    => IFilter::act( IReq::get('name','post') ,'string' ),
		'pro_model'   => IFilter::act( IReq::get('pro_model','post') ,'string' ),
		'color'   => IFilter::act( IReq::get('color','post') ,'string' ),
		'pro_width'   => intval( IReq::get('pro_width','post') ),
		'pro_height'  => intval( IReq::get('pro_height','post') ),
		'pro_length'    => intval( IReq::get('pro_length','post') ),
		'pro_left' => intval( IReq::get('pro_left','post') ),
		'pro_right'  => intval( IReq::get('pro_right','post') ),
		'photo_name' => IFilter::act( IReq::get('focus_photo','post') ,'string' ),
		'time'  => date("Y-m-d H:i:s"),
		);
		$obj->setData($dataArray);
		$result = $obj->update($where);
		$this->redirect('tyzx_list');
	}
	
	//[体验产品] 添加动作
	function tyzx_edit_act()
	{
		$id = intval( IReq::get('id') );

		$obj = new IModel('tyzx');

		$dataArray = array(
			'name'    => IFilter::act( IReq::get('name','post') ,'string' ),
			'pro_model'   => IFilter::act( IReq::get('pro_model','post') ,'string' ),
			'color'   => IFilter::act( IReq::get('color','post') ,'string' ),
			'pro_width'   => intval( IReq::get('pro_width','post') ),
			'pro_height'  => intval( IReq::get('pro_height','post') ),
			'pro_length'    => intval( IReq::get('pro_length','post') ),
			'pro_left' => intval( IReq::get('pro_left','post') ),
			'pro_right'  => intval( IReq::get('pro_right','post') ),
			'photo_name' => IFilter::act( IReq::get('focus_photo','post') ,'string' ),
			'time'  => date("Y-m-d H:i:s"),
		);
		$obj->setData($dataArray);
		$result = $obj->add();
		$this->redirect('tyzx_list');
	}
	
	//[留言]删除
	function message_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('newmessage');

			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);               //删除商品
			$this->redirect('message_list');
		}
		else
		{
			$this->redirect('message_list',false);
			Util::showMessage('请选择要删除的留言');
		}
	}
	
	//[投诉]删除
	function opinion_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('newmessage');

			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);               //删除商品
			$this->redirect('opinion_list');
		}
		else
		{
			$this->redirect('opinion_list',false);
			Util::showMessage('请选择要删除的投诉');
		}
	}

//[文章]列表
	function article_list()
	{
		$this->redirect('article_list');
	}
	
	//[文章]删除
	function article_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('article');
			//$relationObj = new IModel('relation');


			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where1 = ' id in ('.$id_str.')';
				$where2 = ' article_id in ('.$id_str.')';
			}
			else
			{
				$where1 = 'id = '.$id;
				$where2 = 'article_id = '.$id;
			}
			$obj->del($where1);               //删除商品
			//$relationObj->del($where2);       //删除关联商品表
			$this->redirect('article_list');
		}
		else
		{
			$this->redirect('article_list',false);
			Util::showMessage('请选择要删除的文章');
		}
	}

	//[文章]单页
	function article_edit()
	{
		$data = array();
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$id = intval($id);

			//获取文章信息
			$articleObj = new IModel('article');
			$where      = 'id = '.$id;
			$data = $articleObj->getObj($where);
			if(count($data)>0)
			{
				//获取文章关联商品ID值
				/*$relationObj   = new IModel('relation');
				$where         = 'article_id = '.$id;
				$relationGoods = $relationObj->query($where);
				$this->relationStr = null;
				foreach($relationGoods as $rs)
				{
					if($this->relationStr != '') $this->relationStr.=',';
					$this->relationStr.=$rs['goods_id'];
				}

				//根据商品ID获取商品信息
				if($this->relationStr != null)
				{
					$goodsObj        = new IModel('goods');
					$where           = 'id in ('.$this->relationStr.')';
					$this->goodsList = $goodsObj->query($where,'list_img,name');
				}*/
 
				$this->articleRow = $data;
				$this->redirect('article_edit',false);
			}
		}
		if(count($data)==0)
		{
			$this->redirect('article_edit');
		}

	}

	//[文章]增加修改
	function article_edit_act()
	{
		$id = intval(IReq::get('id','post'));

		//图片处理
		$focus_photo = IFilter::act(IReq::get('focus_photo'));
		//大图片
		$show_img = $focus_photo;
		$list_img = $focus_photo;
		if($focus_photo)
		{
			$foot = substr($focus_photo,strpos($focus_photo,'.'));//图片扩展名
			$head = substr($focus_photo,0,strpos($focus_photo,'.'));

			//获得配置文件中的数据
			$config = new Config("site_config");
			$config_info = $config->getInfo();
			$list_thumb_width  = isset($config_info['list_thumb_width'])  ? $config_info['list_thumb_width']  : 175;
	 		$list_thumb_height = isset($config_info['list_thumb_height']) ? $config_info['list_thumb_height'] : 175;
	 		$show_thumb_width  = isset($config_info['show_thumb_width'])  ? $config_info['show_thumb_width']  : 85;
			$show_thumb_height = isset($config_info['show_thumb_height']) ? $config_info['show_thumb_height'] : 85;
			//list
		 	$list_img = $head.'_'.$list_thumb_width.'_'.$list_thumb_height.$foot;
		 	//show
		 	$show_img = $head.'_'.$show_thumb_width.'_'.$show_thumb_height.$foot;
		}

		$articleObj = new IModel('article');
		$DataArray  = array(
			'title'       => IFilter::act(IReq::get('title','post')),
			'content'     => IFilter::act(IReq::get('content','post'),'text'),
			'category_id' => IFilter::act(IReq::get('category_id','post'),'int'),
		    'topic_cat_id'=> IFilter::act(IReq::get('Topcat_name','post'),'int'),
			'create_time' => ITime::getDateTime(),
			'keywords'    => IFilter::act(IReq::get('keywords','post')),
			'description' => IFilter::act(IReq::get('description','post'),'text'),
			'visiblity'   => IFilter::act(IReq::get('visiblity','post'),'int'),
			'top'         => IFilter::act(IReq::get('top','post'),'int'),
			'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
			'style'       => IFilter::act(IReq::get('style','post')),
			'color'       => IFilter::act(IReq::get('color','post')),
			'small_img'	  => $show_img,
			'img'         => $focus_photo,
			'list_img'    => $list_img

		);

		//检查catid是否为空
		if($DataArray['category_id'] == 0)
		{
			$this->articleRow = $DataArray;
			$this->redirect('article_edit',false);
			Util::showMessage('请选择分类');
		}

		$articleObj->setData($DataArray);

		if($id)
		{
			//开始更新操作
			$where = 'id = '.$id;
			$is_success = $articleObj->update($where);
		}
		else
		{
			$id = $articleObj->add();
			$is_success = $id ? true : false;
		}

		if($is_success)
		{
			/*article关联产品操作*/
			//获取新 article关联goods ID
			/*
			$newGoodsIdArray = array();
			$goodsIdStr = IFilter::act(IReq::get('relation_goods','post'));

			if($goodsIdStr != null)
				$newGoodsIdArray = explode(',',$goodsIdStr);

			$ralationObj = new IModel('relation');
			$where = 'article_id = '.$id;
			$ralationObj->del($where);

			if(!empty($newGoodsIdArray))
			{
				foreach($newGoodsIdArray as $rs)
				{
					$reData = array(
						'goods_id'   => $rs,
						'article_id' => $id,
					);
					$ralationObj->setData($reData);
					$ralationObj->add();
				}
			}
			*/
		}
		else
		{
			$this->articleRow = $DataArray;
			$this->redirect('article_edit',false);
			Util::showMessage('插入数据时发生错误');
		}

		$this->redirect('article_list');
	}
	
  //[新闻]列表
	function news_list()
	{
		$this->redirect('news_list');
	}
	
	//[新闻]删除
	function news_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('article');
			$relationObj = new IModel('relation');


			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where1 = ' id in ('.$id_str.')';
				$where2 = ' article_id in ('.$id_str.')';
			}
			else
			{
				$where1 = 'id = '.$id;
				$where2 = 'article_id = '.$id;
			}
			$obj->del($where1);               //删除商品
			$relationObj->del($where2);       //删除关联商品表
			$this->redirect('news_list');
		}
		else
		{
			$this->redirect('news_list',false);
			Util::showMessage('请选择要删除的新闻');
		}
	}

	//[新闻]编辑
	function news_edit()
	{
		$data = array();
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$id = intval($id);

			//获取新闻信息
			$articleObj = new IModel('article');
			$where      = 'id = '.$id;
			$data = $articleObj->getObj($where);
			if(count($data)>0)
			{
				//获取新闻关联商品ID值
				/*$relationObj   = new IModel('relation');
				$where         = 'article_id = '.$id;
				$relationGoods = $relationObj->query($where);
				$this->relationStr = null;
				foreach($relationGoods as $rs)
				{
					if($this->relationStr != '') $this->relationStr.=',';
					$this->relationStr.=$rs['goods_id'];
				}

				//根据商品ID获取商品信息
				if($this->relationStr != null)
				{
					$goodsObj        = new IModel('goods');
					$where           = 'id in ('.$this->relationStr.')';
					$this->goodsList = $goodsObj->query($where,'list_img,name');
				}*/
 
				$this->articleRow = $data;
				$this->redirect('news_edit',false);
			}
		}
		if(count($data)==0)
		{
			$this->redirect('news_edit');
		}

	}
	//[新闻]保存
	function news_edit_act()
	{
		$id = intval(IReq::get('id','post'));

		//图片处理
		$focus_photo = IFilter::act(IReq::get('focus_photo'));
		//大图片
		$show_img = $focus_photo;
		$list_img = $focus_photo;
		if($focus_photo)
		{
			$foot = substr($focus_photo,strpos($focus_photo,'.'));//图片扩展名
			$head = substr($focus_photo,0,strpos($focus_photo,'.'));

			//获得配置文件中的数据
			$config = new Config("site_config");
			$config_info = $config->getInfo();
			$list_thumb_width  = isset($config_info['list_thumb_width'])  ? $config_info['list_thumb_width']  : 175;
	 		$list_thumb_height = isset($config_info['list_thumb_height']) ? $config_info['list_thumb_height'] : 175;
	 		$show_thumb_width  = isset($config_info['show_thumb_width'])  ? $config_info['show_thumb_width']  : 85;
			$show_thumb_height = isset($config_info['show_thumb_height']) ? $config_info['show_thumb_height'] : 85;
			//list
		 	$list_img = $head.'_'.$list_thumb_width.'_'.$list_thumb_height.$foot;
		 	//show
		 	$show_img = $head.'_'.$show_thumb_width.'_'.$show_thumb_height.$foot;
		}

		$articleObj = new IModel('article');
		$DataArray  = array(
			'title'       => IFilter::act(IReq::get('title','post')),
			'content'     => IFilter::act(IReq::get('content','post'),'text'),
			'category_id' => IFilter::act(IReq::get('category_id','post'),'int'),
		    'topic_cat_id'=> IFilter::act(IReq::get('Topcat_name','post'),'int'),
			'create_time' => ITime::getDateTime(),
			'keywords'    => IFilter::act(IReq::get('keywords','post')),
			'description' => IFilter::act(IReq::get('description','post'),'text'),
			'visiblity'   => IFilter::act(IReq::get('visiblity','post'),'int'),
			'top'         => IFilter::act(IReq::get('top','post'),'int'),
			'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
			'style'       => IFilter::act(IReq::get('style','post')),
			'color'       => IFilter::act(IReq::get('color','post')),
			'small_img'	  => $show_img,
			'img'         => $focus_photo,
			'list_img'    => $list_img

		);

		//检查catid是否为空
		if($DataArray['category_id'] == 0)
		{
			$this->articleRow = $DataArray;
			$this->redirect('news_edit',false);
			Util::showMessage('请选择分类');
		}

		$articleObj->setData($DataArray);

		if($id)
		{
			//开始更新操作
			$where = 'id = '.$id;
			$is_success = $articleObj->update($where);
		}
		else
		{
			$id = $articleObj->add();
			$is_success = $id ? true : false;
		}

		if($is_success)
		{
			/*article关联产品操作*/
			//获取新 article关联goods ID
			$newGoodsIdArray = array();
			$goodsIdStr = IFilter::act(IReq::get('relation_goods','post'));

			if($goodsIdStr != null)
				$newGoodsIdArray = explode(',',$goodsIdStr);

			$ralationObj = new IModel('relation');
			$where = 'article_id = '.$id;
			$ralationObj->del($where);

			if(!empty($newGoodsIdArray))
			{
				foreach($newGoodsIdArray as $rs)
				{
					$reData = array(
						'goods_id'   => $rs,
						'article_id' => $id,
					);
					$ralationObj->setData($reData);
					$ralationObj->add();
				}
			}
		}
		else
		{
			$this->articleRow = $DataArray;
			$this->redirect('news_edit',false);
			Util::showMessage('插入数据时发生错误');
		}

		$this->redirect('news_list');
	}
	
	//[专题]删除
	function special_topic_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('special_topic');
			$relationObj = new IModel('special_topic_cat');


			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where1 = ' id in ('.$id_str.')';
				$where2 = ' article_id in ('.$id_str.')';
			}
			else
			{
				$where1 = 'id = '.$id;
				$where2 = 'article_id = '.$id;
			}
			$obj->del($where1);               //删除商品
			$relationObj->del($where2);       //删除关联商品表
			$this->redirect('special_topic_list');
		}
		else
		{
			$this->redirect('special_topic_list',false);
			Util::showMessage('请选择要删除的文章');
		}
	}
	
	//[专题]单页
	function special_topic_edit()
	{
		$data = array();
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$id = intval($id);

			//获取专题信息
			$articleObj = new IModel('special_topic');
			$where      = 'id = '.$id;
			$data = $articleObj->getObj($where);
			if(count($data)>0)
			{
				//获取文章关联商品ID值
				$relationObj   = new IModel('special_topic_cat');
				$where         = 'topic_id = '.$id;
				$relationGoods = $relationObj->query($where);
				$this->relationStr = null;
				foreach($relationGoods as $rs)
				{
					if($this->relationStr != '') $this->relationStr.=',';
					$this->relationStr.=$rs['goods_id'];
				}

				//根据商品ID获取商品信息
				if($this->relationStr != null)
				{
					$goodsObj        = new IModel('goods');
					$where           = 'id in ('.$this->relationStr.')';
					$this->goodsList = $goodsObj->query($where,'list_img,name');
				}

				$this->articleRow = $data;
				$this->redirect('special_topic_edit',false);
			}
		}
		if(count($data)==0)
		{
			$this->redirect('special_topic_edit');
		}

	}
		
	//[专题]增加修改
	function special_topic_edit_act()
	{
		$id = intval(IReq::get('id','post'));
		//图片处理
		$focus_photo = IFilter::act(IReq::get('focus_photo'));
		//大图片
		$show_img = $focus_photo;
		$list_img = $focus_photo;
		if($focus_photo)
		{
			$foot = substr($focus_photo,strpos($focus_photo,'.'));//图片扩展名
			$head = substr($focus_photo,0,strpos($focus_photo,'.'));

			//获得配置文件中的数据
			$config = new Config("site_config");
			$config_info = $config->getInfo();
			$list_thumb_width  = isset($config_info['list_thumb_width'])  ? $config_info['list_thumb_width']  : 175;
	 		$list_thumb_height = isset($config_info['list_thumb_height']) ? $config_info['list_thumb_height'] : 175;
	 		$show_thumb_width  = isset($config_info['show_thumb_width'])  ? $config_info['show_thumb_width']  : 85;
			$show_thumb_height = isset($config_info['show_thumb_height']) ? $config_info['show_thumb_height'] : 85;
			//list
		 	$list_img = $head.'_'.$list_thumb_width.'_'.$list_thumb_height.$foot;
		 	//show
		 	$show_img = $head.'_'.$show_thumb_width.'_'.$show_thumb_height.$foot;
		}

		$articleObj = new IModel('special_topic');
		$DataArray  = array(
			'title'       => IFilter::act(IReq::get('title','post')),
			'description'     => IFilter::act(IReq::get('description','post'),'text'),
			'create_time' => ITime::getDateTime(),
			'keywords'    => IFilter::act(IReq::get('keywords','post')),
			'visiblity'   => IFilter::act(IReq::get('visiblity','post'),'int'),
			'top'         => IFilter::act(IReq::get('top','post'),'int'),
			'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
			'style'       => IFilter::act(IReq::get('style','post'),'int'),
			'color'       => IFilter::act(IReq::get('color','post')),
			'small_img'	  => $show_img,
			'img'       => $focus_photo,
			'list_img'    => $list_img

		);

//		//检查catid是否为空
//		if($DataArray['category_id'] == 0)
//		{
//			$this->articleRow = $DataArray;
//			$this->redirect('special_topic_add',false);
//			//Util::showMessage('请选择分类');
//		}
//
		$articleObj->setData($DataArray);

		if($id)
		{
			//开始更新操作
			$where = 'id = '.$id;
			$is_success = $articleObj->update($where);
		}
		else
		{
			$id = $articleObj->add();
			$is_success = $id ? true : false;
		}

		if($is_success)
		{
			/*article关联产品操作*/
			//获取新 article关联goods ID
			$newGoodsIdArray = IFilter::act(IReq::get('topic_cat','post'));

			$ralationObj = new IModel('special_topic_cat');
			$where = 'topic_id = '.$id;
			$ralationObj->del($where);

			if(!empty($newGoodsIdArray))
			{
				foreach($newGoodsIdArray as $rs)
				{
					$reData = array(
						'cat_name'   => $rs,
						'topic_id' => $id,
					);
					$ralationObj->setData($reData);
					$ralationObj->add();
				}
			}
		}
		else
		{
			$this->articleRow = $DataArray;
			$this->redirect('special_topic_edit',false);
			Util::showMessage('插入数据时发生错误');
		}

		$this->redirect('special_topic_list');
	}
	
    //[专题信息]删除专题信息（图片或文章）
	function topic_info_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('special_topic_info');
			$artobj = new IModel('article');
			$imgobj = new IModel('picture_group');
			$scrobj = new IModel('source');
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				foreach($id as $idval)
				{
					$where = 'id='.$idval;
					$column = 'type,info_id';
			        $temp = $obj->getObj($where);
			        if($temp['type']==0)
			        {
			        	$place = 'id='.$temp['info_id'];
			        	$artobj->del($place);
			        }
			        else {
			        	$place = 'id='.$temp['info_id'];
			        	$imgobj->del($place);
			        	$scr = 'img_group_id='.$temp['info_id'];
			        	$scrobj->del($scr);
			        } 
				}
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				    $where = 'id='.$id;
					$column = 'type,info_id';
			        $temp = $obj->getObj($where);
			        if($temp['type']==0)
			        {
			        	$place = 'id='.$temp['info_id'];
			        	$artobj->del($place);
			        }
			        else {
			        	$place = 'id='.$temp['info_id'];
			        	$imgobj->del($place);
			        	$scr = 'img_group_id='.$temp['info_id'];
			        	$scrobj->del($scr);
			        } 
			        
				    $where = 'id = '.$id;
			}
			$obj->del($where);               //删除专题信息
			$this->redirect('special_topic_info');
		}
		else
		{
			$this->redirect('article_list',false);
			Util::showMessage('请选择要删除的信息');
		}
	}
	//[文章专题]
    function special_topic_article_edit()
	{
		$data = array();
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$id = intval($id);
            $infoObj = new IModel('special_topic_info');
            $where      = 'id = '.$id;
            $column     = 'info_id';
            $info_id = $infoObj->getObj($where,$column);
			//获取文章信息
			$articleObj = new IModel('article');
			$where      = 'id = '.$info_id['info_id'];
			$data = $articleObj->getObj($where);
			if(count($data)>0)
			{
				$data['id'] = $id;
				$this->articleRow = $data;
				$this->redirect('special_topic_article_edit',false);
			}
		}
		if(count($data)==0)
		{
			$this->redirect('special_topic_article_edit');
		}
	}
	//[图片专题]
    function special_topic_image_edit()
	{
		$data = array();
		$info = array();
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$id = intval($id);
			//获取图片专题的信息
            $infoObj = new IModel('special_topic_info');
            $where   = 'id = '.$id;
            $info    = $infoObj->getObj($where);
            //获取图片专题的简介
            $imgObj  = new IModel('picture_group');
            $img_where = 'id ='.$info['info_id'];
            $introduce = $imgObj->getObj($img_where);
            $info['introduce'] = $introduce['introduce'];
			//获取图片信息
			$imgObj = new IQuery('source');
			$imgObj->where  = 'img_group_id = '.$info['info_id'];
			$imgObj->fields = 'id,path,`describe`';  
			$data = $imgObj->find();
			if(count($data)>0)
			{
				$this->articleRow = $info;
				
				//图片路径和描述
				$this->Image_group = $data;
				//图片路径传到前台photo_name标签下
				foreach($data as $val)
				$this->Images .= $val['path'].',' ;
				$this->redirect('special_topic_image_edit',false);
			}
		}
		if(count($data)==0)
		{
			$this->articleRow = $info;
			$this->Image_group = '';
			$this->Images = '';
			$this->redirect('special_topic_image_edit');
		}
	}
    //[专题文章]添加文章，修改文章
	function special_topic_article_edit_act()
	{
		$id = IFilter::act(IReq::get('id','post'),'int');//信息id
		//图片处理
	    $focus_photo = IFilter::act(IReq::get('focus_photo'));
		//大图片
		$show_img = $focus_photo;
		$list_img = $focus_photo;
		if($focus_photo)
		{
			$foot = substr($focus_photo,strpos($focus_photo,'.'));//图片扩展名
			$head = substr($focus_photo,0,strpos($focus_photo,'.'));

			//获得配置文件中的数据
			$config = new Config("site_config");
			$config_info = $config->getInfo();
			$list_thumb_width  = isset($config_info['list_thumb_width'])  ? $config_info['list_thumb_width']  : 175;
	 		$list_thumb_height = isset($config_info['list_thumb_height']) ? $config_info['list_thumb_height'] : 175;
	 		$show_thumb_width  = isset($config_info['show_thumb_width'])  ? $config_info['show_thumb_width']  : 85;
			$show_thumb_height = isset($config_info['show_thumb_height']) ? $config_info['show_thumb_height'] : 85;
			//list
		 	$list_img = $head.'_'.$list_thumb_width.'_'.$list_thumb_height.$foot;
		 	//show
		 	$show_img = $head.'_'.$show_thumb_width.'_'.$show_thumb_height.$foot;
		}
		$infoObj    = new IModel('special_topic_info');
		$articleObj = new IModel('article');
		$DataArray  = array(
			'title'       => IFilter::act(IReq::get('title','post')),
			'content'     => IFilter::act(IReq::get('content','post'),'text'),
			'category_id' => '10',//专题栏目的id
		    'topic_cat_id'=> IFilter::act(IReq::get('Topcat_name','post'),'int'),
			'create_time' => ITime::getDateTime(),
			'keywords'    => IFilter::act(IReq::get('keywords','post')),
			'description' => '',
			'visiblity'   => '0',
			'top'         => '0',
			'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
			'style'       => IFilter::act(IReq::get('style','post')),
			'color'       => IFilter::act(IReq::get('color','post')),
		    'small_img'	  => $show_img,
			'img'         => $focus_photo,
			'list_img'    => $list_img
		);
		$InfoArray = array(
		    'title'       => IFilter::act(IReq::get('title','post')),
		    'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
		    'topic_cat_id'=> IFilter::act(IReq::get('Topcat_name','post'),'int'),
		    'type'        =>'0',
		);
		
	    //检查专题分类是否为空
		if($DataArray['topic_cat_id'] == 0)
		{
			$this->articleRow = $DataArray;
			$this->redirect('special_topic_info_edit',false);
			Util::showMessage('请选择专题分类');
		}
		
		$articleObj->setData($DataArray);
		
		if($id)
		{
            $where      = 'id = '.$id;
            $infoObj->setData($InfoArray);
            $infoObj->update($where);
            
            $column     = 'info_id';
            $info_id = $infoObj->getObj($where,$column);
			//开始更新文章操作
			$article_id = 'id = '.$info_id['info_id'];
			$is_success = $articleObj->update($article_id);
		    if(!$is_success)
		    {
				$this->articleRow = $DataArray;
				$this->redirect('special_topic_info_edit',false);
		    }
		    else {
		    	$this->redirect('special_topic_info');
		    }
		}
		else
		{
			//文章表添加文章	
			$article_id = $articleObj->add();
			//专题表添加信息
			$InfoArray['info_id'] = $article_id;    
			$infoObj->setData($InfoArray);
		    $is_success = $infoObj->add();
		    if(!$is_success)
			{
				$this->articleRow = $DataArray;
			    $this->redirect('special_topic_info_edit',false);
			}
			else{
				$this->redirect('special_topic_info');
				Util::showMessage('添加文章成功');
			}
		}
	}
	 //[专题文章]添加图片，修改图片	
	function special_topic_image_edit_act()	
	{
		$id = IFilter::act(IReq::get('id'),'int');//信息id
		$infoObj    = new IModel('special_topic_info');
		$imgObj = new IModel('picture_group');
		$srcObj = new IModel('source');
	    $intr = IReq::get('intr','post');//图片说明数组
		$imagepath = IFilter::act(IReq::get('photo_name','post'));//图片路径
		$imagepath_arr = explode(',', $imagepath);//Array
		$InfoArray = array(
		    'title'       => IFilter::act(IReq::get('title','post')),
		    'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
		    'topic_cat_id'=> IFilter::act(IReq::get('Topcat_name','post'),'int'),
		    'type'        =>'1',
		);
		$ImgArray = array(
		    'topic_cat_id'  => IFilter::act(IReq::get('Topcat_name','post'),'int'),
		    'introduce'     =>IFilter::act(IReq::get('content','post')),
		);
		$sourceArray = array(
		    'img_group_id'  => '0',
		);
		if($id)
		{
			$where = 'id ='.$id;
			$infoObj->setData($InfoArray);
			$infoObj->update($where);
			$column = 'info_id';
			$info_id = $infoObj->getObj($where,$column);
			$image = 'id ='.$info_id['info_id'];
			$imgObj->setData($ImgArray);
			$imgObj->update($image);
			//将图片的上级id归零
			$src  = 'img_group_id = '.$info_id['info_id'];
			$srcObj->setData($sourceArray);
			$srcObj->update($src);
		}
		else {
			$imgObj->setData($ImgArray);
			$info_id = $imgObj->add();
			$InfoArray['info_id'] = $info_id;
			$infoObj->setData($InfoArray);
			$infoObj->add();
		}
		//改变图片的上级id
	    foreach($imagepath_arr as $key => $val)
		{
			if($val!='')
			{
				$srcArray = array(
				    'describe' => $intr[$key],
				    'img_group_id' => $info_id['info_id'],
				);
				$where = 'path=\''.$val.'\'';
				$srcObj->setData($srcArray);
				$srcObj->update($where);
			}
		}
		$this->redirect('special_topic_info');
	}
	//博士后工作站：内容编辑
	function bsh_edit()
	{
	    $data = array();
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$id = intval($id);
			//获取文章信息
			$articleObj = new IModel('bsh');
			$where      = 'id = '.$id;
			$data = $articleObj->getObj($where);
			if(count($data)>0)
			{
				$this->bsh_data = $data;
				$this->redirect('bsh_edit',false);
			}
		}
		if(count($data)==0)
		{
			$this->redirect('bsh_edit');
		}
	}
	//博士后工作站：内容修改
    function bsh_edit_act()
	{
	    $id = intval(IReq::get('id','post'));
	   
		$bshObj = new IModel('bsh');
		$DataArray  = array(
			'title'       => IFilter::act(IReq::get('title','post')),
			'content'     => IFilter::act(IReq::get('content','post'),'text'),
		    'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
			'access'      => IFilter::act(IReq::get('access','post'),'int'),
			'time'		  => ITime::getDateTime(),
		);
		if(isset($_FILES['att_file']['name']) && $_FILES['att_file']['name']!='')
		{
			$fileObj = new FileUpload();
			$file    = $fileObj->run();
		}
        if($file!=null) 
        {
        	$DataArray['file'] = $file['att_file']['fileSrc'];
        	$DataArray['file_name'] = $file['att_file']['ininame'];
        }
        
		$bshObj->setData($DataArray);
		
		if($id)
		{
			//开始更新操作
			$where = 'id = '.$id;
			$is_success = $bshObj->update($where);
		}
		else
		{
			$id = $bshObj->add();
			$is_success = $id ? true : false;
		}
		if($is_success)
		{
		   $this->redirect('bsh_list');
		}
		else
		{
			$this->bsh_data = $DataArray;
			$this->redirect('bsh_list',FALSE);
		}
	}
    //博士后工作站内容删除
	function bsh_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$obj = new IModel('bsh');
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);               //删除
			$this->redirect('bsh_list');
		}
		else
		{
			$this->redirect('bsh_list',false);
			Util::showMessage('请选择要删除的内容');
		}
	}
     //视频上传：内容编辑
	function upload_video()
	{
	  $data = array();
		$id = IFilter::act(IReq::get('id'),'int');
		if($id)
		{
			$id = intval($id);
			//获取视频信息
			$Obj = new IModel('upload_videos');
			$where      = 'id = '.$id;
			$data = $Obj->getObj($where);
			if(count($data)>0)
			{
				$this->data = $data;
				$this->redirect('upload_video');
			}
		}
		if(count($data)==0)
		{
			$this->redirect('upload_video');
		}
	}
	
	//视频上传：保存数据
    function upload_act()
	{
	    $id = intval(IReq::get('id','post'));
	   
		$Obj = new IModel('upload_videos');
		$DataArray  = array(
			  'title'       => IFilter::act(IReq::get('title','post')),
		    'sort'        => IFilter::act(IReq::get('sort','post'),'int'),
		    'path'        => IFilter::act(IReq::get('path','post')),
		    'category_id' => IFilter::act(IReq::get('category_id','post'))
		);
		
		$temp_form =strrchr($DataArray['path'],'.');	
		$format = substr($temp_form,1);
		if($format != "mp4" && $format != "flv" &&$format !="f4v" &&$format !="swf")
		{
			  $this->data = $DataArray;
				$this->redirect('upload_video',false);
			  Util::showMessage("视频格式错误！");
		}
		$Obj->setData($DataArray);
		if($id)
		{
			//开始更新操作
			$where = 'id = '.$id;
			$is_success = $Obj->update($where);
		}
		else
		{
			$id = $Obj->add();
			$is_success = $id ? true : false;
		}
		if($is_success)
		{
		   $this->redirect('video_list');
		}
		else
		{
			$this->data = $DataArray;
			$this->redirect('video_list',false);
		}
	}
	//[公告]列表
	function notice_list()
	{
		$this->redirect('notice_list');	
	}
	//[公告]增加修改
	function notice_edit_act()
	{
		$id = intval(IReq::get('id','post'));

		$noticeObj = new IModel('announcement');
		$dataArray  = array(
			'title'       => IFilter::act(IReq::get('title','post')),
			'content'     => IFilter::act(IReq::get('content','post'),'text')
		);
		$dataArray['time'] = date("Y-m-d H:i:s");
		$noticeObj->setData($dataArray);

		if($id)
		{
			$is_success = $noticeObj->update( "id={$id}" );
		}
		else
		{
			$noticeObj->add();
		}
		$this->redirect('notice_list');
	}

	//[公告]删除
	function notice_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int'  );
		if(!is_array($id))
		{
			$id = array($id);
		}
		$id = implode(",",$id);

		$noticeObj = new IModel('announcement');
		$noticeObj->del( "id IN ({$id})" );
		$this->redirect('notice_list');
	}

	//[公告]单页
	function notice_edit()
	{
		$id = IReq::get('id');
		if($id)
		{
			$id = intval($id);

			//获取文章信息
			$noticeObj = new IModel('announcement ');
			$where      = 'id = '.$id;
			$this->noticeRow = $noticeObj->getObj($where);
		}

		$this->redirect('notice_edit',false);
	}


 //文章分类列表
 function article_cat_list()
 {
 	$this->redirect('article_cat_list');
 }
 	
	//[文章分类] 增加和修改动作
	function cat_edit_act()
	{
		$id        = intval( IReq::get('id','post') );
		$parent_id = intval( IReq::get('parent_id','post') ) ;

		$catObj    = new IModel('article_category');
		$DataArray = array(
			'parent_id' => $parent_id,
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'issys'     => intval( IReq::get('issys','post') ),
			'sort'      => intval( IReq::get('sort','post') ),
			'type'      => IFilter::act( IReq::get('category_type_id','post'),'string'),
		);

		/*开始--获取path信息*/
		//1,修改操作
		if($id)
		{
			$where  = 'id = '.$id;
			$catRow = $catObj->getObj($where);
			if($catRow['parent_id']==$parent_id)
			{
				$isMoveNode = false;
				$DataArray['path'] = $catRow['path'];
			}
			else
				$isMoveNode = true;

			$localId = $id;
		}
		//2,新增操作
		else
		{
			$max_id  = $catObj->getObj('','max(id) as max_id');
			$localId = $max_id['max_id'] ? $max_id['max_id']+1 : 1;
		}

		//如果不存在path数据时,计算path数据
		if(!isset($DataArray['path']))
		{
			//获取父节点的path路径
			if($parent_id==0)
				$DataArray['path'] = ','.$localId.',';
			else
			{
				$where     = 'id = '.$parent_id;
				$parentRow = $catObj->getObj($where);
				$DataArray['path'] = $parentRow['path'].$localId.',';
			}
		}
		/*结束--获取path信息*/
		//设置数据值
		$catObj->setData($DataArray);

		//1,修改操作
		if($id)
		{
			//节点移动
			if($isMoveNode == true)
			{
				if($parentRow['path']!=null && strpos($parentRow['path'],','.$id.',')!==false)
				{
					$this->catRow = array(
						'parent_id' => $DataArray['parent_id'],
						'name'      => $DataArray['name'],
						'issys'     => $DataArray['issys'],
						'sort'      => $DataArray['sort'],
						'id'        => $id,
						'type'		=> $DataArray['type'],
					);
					$this->redirect('article_cat_edit',false);
					Util::showMessage('不能该节点移动到其子节点的位置上');
				}
				else
				{
					//其子节点批量移动
					$childObj = new IModel('article_category');
					$oldPath  = $catRow['path'];
					$newPath  = $DataArray['path'];

					$where = 'path like "'.$oldPath.'%"';
					$updateData = array(
						'path' => "replace(path,'".$oldPath."','".$newPath."')",
					);
					$childObj->setData($updateData);
					$childObj->update($where,array('path'));
				}
			}
			$where = 'id = '.$id;
			$catObj->update($where);
		}
		//2,新增操作
		else
			$catObj->add();

		$this->redirect('article_cat_list');
	}

	//[文章分类] 增加修改单页
	function cat_edit()
	{
		$data = array();
		$id = intval( IReq::get('id') );

		if($id)
		{
			$catObj = new IModel('article_category');
			$where  = 'id = '.$id;
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$this->catRow = $data;
				$this->redirect('article_cat_edit',false);
			}
		}
		if(count($data)==0)
		{
			$this->redirect('article_cat_list');
		}
	}

	//[文章分类] 删除
	function cat_del()
	{
		$id = intval( IReq::get('id') );
		$catObj = new IModel('article_category');

		//是否执行删除检测值
		$isCheck=true;

		//检测是否有parent_id 为 $id
		$where   = 'parent_id = '.$id;
		$catData = $catObj->getObj($where);
		if(!empty($catData))
		{
			$isCheck=false;
			$message='此分类下还有子分类';
		}

		//检测是否有article的category_id 为 $id
		else
		{
			$articleObj = new IModel('article');
			$where = 'category_id = '.$id;
			$catData = $articleObj->getObj($where);

			if(!empty($catData))
			{
				$isCheck=false;
				$message='此分类下还有文章';
			}
		}

		//开始删除
		$where  = 'id = '.$id;
		$result = $catObj->del($where);
		if($result==true && $isCheck==true)
		{
			$this->redirect('article_cat_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('article_cat_list',false);
			Util::showMessage($message);
		}
	}

	//[广告位] 删除
	function ad_Position_del()
	{
		$id = IFilter::act( IReq::get('id') , 'act' );
		if(!empty($id))
		{
			$obj = new IModel('ad_position');
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);
			$this->redirect('ad_position_list');
		}
		else
		{
			$this->redirect('ad_position_list',false);
			Util::showMessage('请选择要删除的广告位');
		}
	}

	//[广告位] 添加修改 (单页)
	function ad_position_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$obj = new IModel('ad_position');
			$where = 'id = '.$id;
			$this->positionRow = $obj->getObj($where);
		}
		$this->redirect('ad_position_edit',false);
	}

	//[广告位] 添加和修改动作
	function ad_position_edit_act()
	{
		$id = intval( IReq::get('id') );

		$obj = new IModel('ad_position');

		$dataArray = array(
			'name'    => IFilter::act( IReq::get('name','post') ,'string' ),
			'width'   => intval( IReq::get('width','post') ),
			'height'  => intval( IReq::get('height','post') ),
			'type'    => intval( IReq::get('type','post') ),
			'fashion' => intval( IReq::get('fashion','post') ),
			'status'  => intval( IReq::get('status','post') ),
			'ad_nums' => intval( IReq::get('ad_nums','post') ),
		);
		$obj->setData($dataArray);

		if($id)
		{
			$where = 'id = '.$id;
			$result = $obj->update($where);
		}
		else
			$result = $obj->add();

		$this->redirect('ad_position_list');
	}

	//[广告] 删除
	function ad_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int' );
		if(!empty($id))
		{
			$obj = new IModel('ad_manage');
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);
			$this->redirect('ad_list');
		}
		else
		{
			$this->redirect('ad_list',false);
			Util::showMessage('请选择要删除的广告');
		}
	}

	//[广告] 添加修改 (单页)
	function ad_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$obj = new IModel('ad_manage');
			$where = 'id = '.$id;
			$this->adRow = $obj->getObj($where);
		}
		$this->redirect('ad_edit',false);
	}

	//[广告] 添加和修改动作
	function ad_edit_act()
	{
		$id  = intval( IReq::get('id') );
		$adObj = new IModel('ad_manage');
		$error_message = null;

		//获取content数据
		$type    = IReq::get('type','post');
		$content = IReq::get('content','post');
		$upObj   = null;

		switch($type)
		{
			case "1":
			//图片上传
			$upObj  = new IUpload();
			$attach = 'img';
			break;
			case "2":
			//flash上传
			$upObj  = new IUpload('2048',array('flv','swf'));
			$attach = 'flash';
			break;
			case "3":
			//文字
			$content = IReq::get('text','post');
			break;

			case "4":
			//代码
			$content = IReq::get('code','post');
			break;
		}
		if($upObj != null)
		{
			//目录散列
			$dir = IWeb::$app->config['upload'].'/'.date('Y')."/".date('m')."/".date('d');
			$upObj->setDir($dir);
			$upState = $upObj->execute();
			if(!isset($upState[$attach]))
			{
				if($content == '')
				{
					$error_message = '没有上传文件';
				}
			}
			else
			{
				if($upState[$attach][0]['flag']==-1)
				{
					$error_message = '上传的文件类型不符合';
				}
				else if($upState[$attach][0]['flag']==-2)
				{
					$error_message = '大小超过限度';
				}
				else if($upState[$attach][0]['flag']==1)
					$content = $dir.'/'.$upState[$attach][0]['name'];
			}
		}
		else
		{
			if($content == '')
			{
				$error_message = '请填写广告展示类型的内容';
			}
		}

		$dataArray = array(
			'content' => $content,
			'name' => IReq::get('name','post'),
			'position_id' => IReq::get('position_id','post'),
			'width' => IReq::get('width','post'),
			'height' => IReq::get('height','post'),
			'type' => IReq::get('type','post'),
			'link' => IReq::get('link','post'),
			'start_time' => IReq::get('start_time','post'),
			'end_time' => IReq::get('end_time','post'),
			'description' => IReq::get('description','post'),
			'order' => IReq::get('order','post'),
		);

		//上传错误
		if($error_message != null)
		{
			if($id)
			{
				$dataArray['id'] = $id;
			}
			$this->adRow = $dataArray;
			$this->redirect('ad_edit',false);
			Util::showMessage($error_message);
		}

		$adObj->setData($dataArray);

		if($id)
		{
			$where = 'id = '.$id;
			$adObj->update($where);
		}
		else
		{
			$adObj->add();
		}

		$this->redirect("ad_list",true);
	}

	function content_list()
	{
		$query = new IQuery("column AS col");
		$query->join = "left join content as con on (col.id = con.column_id)";
		$query->where = "col.type = 102";
		$query->fields = "col.id,col.name,con.id as con_id,con.content,con.column_id";
		$query->order = "col.id asc";
		$query->page = isset($_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$this->list =  $query->find();
		$this->redirect("content_list");
	}
	
	function content_edit_act()
	{
		$id = intval(IReq::get('id','post'));
		$obj = new IModel('content');
		$where      = 'column_id = '.$id;
		$this->contentRow = $obj->getObj($where);
		$content= IFilter::act( IReq::get('content','post') ,'text');
		//$content=iconv("UTF-8", "GBK", $content);
		if(count($this->contentRow)>0){
			$dataArray = array(
			'content'=> $content,
			);
			$obj->setData($dataArray);
			$result = $obj->update($where);
		}
		else 
		{
			$dataArray = array(
			'id' => $id,
			'content'=> $content,
			'column_id'=> $id,
			);
			$obj->setData($dataArray);
			$result = $obj->add();
		}
		//var_dump($content);
		$this->redirect('content_list');
	}
	
	function content_edit()
	{
		$id = intval(IReq::get("id"));
		$arr = array();
		if($id){
			$contentObj = new IModel('content');
			$contentObj1 = new IModel('column');
			$where = 'column_id = '.$id;
			$this->contentRow = $contentObj->getObj($where);
			$where1 = 'id = '.$id;
			$this->contentRow1 = $contentObj1->getObj($where1);
			$arr['title']=$this->contentRow1['name'];
			//var_dump($this->contentRow);
			if(count($this->contentRow)>0){
				$arr['content']=$this->contentRow['content'];
				$arr['cid']=$this->contentRow['column_id'];
			}
			$this->setRenderData($arr);
			$this->redirect("content_edit");
		}
	}
	
	
	function help_list()
	{
		$query = new IQuery("help AS help");
		$query->join = "LEFT JOIN help_category AS cat ON help.cat_id=cat.id";
		if(IReq::get('cat_id')!==null)
		{
			$query->where = "help.cat_id = ".intval(IReq::get('cat_id'));
		}
		$query->fields = "help.*,cat.name AS cat_name";
		$query->order = "help.`sort` ASC,help.id DESC";
		$query->page = isset($_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$this->list = $query->find();
		$this->redirect("help_list");
	}

	function help_edit()
	{
		$id = intval(IReq::get("id"));
		$this->help_row=array('id'=>$id,'name'=>'','cat_id'=>0,'content'=>"",'sort'=>0);
		if($id)
		{
			$this->help_row=SiteHelp::get_help_by_id($id);
			if(!isset($this->help_row[$id]))
			{
				$this->redirect("help_list",true);
				Util::showMessage( "没有这条记录" );
			}
			$this->help_row=$this->help_row[$id];
		}
		$this->redirect("help_edit");
	}

	function help_edit_act()
	{
		//数据在Sitemap里过滤了
		$data['id'] = IReq::get("id");
		$data['cat_id'] = IReq::get('cat_id') ;
		$data['name'] = IReq::get('name');
		$data['sort'] = IReq::get("sort");
		$data['content'] = IReq::get("content");

		$re = SiteHelp::help_edit($data);
		if($re['flag']===true)
		{
			$this->redirect("help_list");
		}
		else
		{
			$this->redirect("help_edit",false);
			Util::showMessage($re['data']);
		}
	}

	function help_del()
	{
		$id = IReq::get("id");


		if($id===null)
		{
			$this->redirect('/tools/help_list');
		}
		$re = SiteHelp::help_del($id);

		if($re['flag']===true)
		{
			$this->redirect('/tools/help_list');
		}
		else
		{
			$this->redirect('/tools/help_list');
		}
	}

	function help_cat_list()
	{
		$this->redirect("help_cat_list");
	}

	function help_cat_edit()
	{
		$id=IReq::get("id");
		$this->cat_row=array('name'=>'','position_left'=>0,'position_foot'=>0,'sort'=>'');
		if($id!==null)
		{
			$this->cat_row=SiteHelp::get_cat_by_id($id);
			if(!isset($this->cat_row[$id]))
				Util::showMessage( "没有这条记录" );
			$this->cat_row=$this->cat_row[$id];
		}
		$this->redirect("help_cat_edit");
	}

	function help_cat_edit_act()
	{
		$data["id"] = IReq::get("id","post");
		$data["name"] = IReq::get("name","post");
		$data["position_left"] = IReq::get("position_left","post");
		$data["position_foot"] = IReq::get("position_foot","foot");
		$data["sort"] = IReq::get("sort");

		$re=SiteHelp::cat_edit($data);
		if($re['flag']!==true)
		{
			Util::showMessage($re['data']);
			die();
		}
		$this->redirect('help_cat_list');
	}

	function help_cat_position()
	{
		$id = IReq::get("id");
		$position = IReq::get("position");
		$value = IReq::get("value");
		if($id===null || $position===null || $value===null)
			die("错误的参数");

		$re=SiteHelp::mod_cat_position($id,$position,$value);
		if($re['flag']===false)
			die($re['data']);
		die("设置成功");
	}

	function help_cat_del()
	{
		$id = IReq::get('id');
		if($id===null)
			die("错误的参数");
		$re = SiteHelp::del_cat($id);
		if($re['flag']===false)
			die($re['data']);
		die("success");
	}

	//[关键词管理]添加
	function keyword_add()
	{
		$word  = IFilter::act(IReq::get('word'));
		$hot   = intval(IReq::get('hot'));
		$order = IReq::get('order') ? intval(IReq::get('order')) : 99;

		if($word != '')
		{
			$keywordObj  = new IModel('keyword');
			$wordArray   = explode(',',$word);

			//获取各个关键词的管理商品数量
			$resultCount = $this->keyword_count($wordArray);

			foreach($wordArray as $word)
			{
				$is_exists = $keywordObj->getObj('word = "'.$word.'"','hot');
				if(empty($is_exists))
				{
					$dataArray = array(
						'hot'        => $hot,
						'word'       => $word,
						'goods_nums' => $resultCount[$word],
						'order'      => $order,
					);
					$keywordObj->setData($dataArray);
					$keywordObj->add();
				}
			}

			$this->redirect('keyword_list');
		}
		else
		{
			$this->redirect('keyword_edit');
			Util::showMessage('请填写关键词');
		}
	}

	//[关键词管理]删除
	function keyword_del()
	{
		$id = IFilter::act(IReq::get('id'));
		if(!empty($id))
		{
			$keywordObj = new IModel('keyword');
			if(is_array($id))
			{
				$ids = '"'.join('","',$id).'"';
				$keywordObj->del('word in ('.$ids.')');
			}
			else
			{
				$keywordObj->del('word = "'.$id.'"');
			}
		}
		else
		{
			$message = '请选择要删除的关键词';
		}

		if(isset($message))
		{
			$this->redirect('keyword_list',false);
			Util::showMessage($message);
		}
		else
		{
			$this->redirect('keyword_list');
		}
	}

	//[关键词管理]设置hot
	function keyword_hot()
	{
		$id  = IFilter::act(IReq::get('id'));

		$keywordObj = new IModel('keyword');
		$dataArray  = array('hot' => 'abs(hot - 1)');
		$keywordObj->setData($dataArray);
		$is_result  = $keywordObj->update('word = "'.$id.'"','hot');

		$keywordRow = $keywordObj->getObj('word = "'.$id.'"');
		if($is_result!==false)
		{
			echo JSON::encode(array('isError' => false,'hot' => $keywordRow['hot']));
		}
		else
		{
			echo JSON::encode(array('isError'=>true,'message'=>'设置失败'));
		}
	}

	//[关键词管理]统计商品数量
	function keyword_account()
	{
		$word   = IFilter::act(IReq::get('id'));
		$result = $this->keyword_count($word);
		if($result === false)
		{
			$this->redirect('keyword_list',false);
			Util::showMessage('请选择要同步的关键词');
		}
		else
		{
			$keywordObj = new IModel('keyword');
			foreach($result as $word => $num)
			{
				$dataArray = array(
					'goods_nums' => $num,
				);
				$keywordObj->setData($dataArray);
				$keywordObj->update('word = "'.$word.'"');
			}
			$this->redirect('keyword_list');
		}
	}

	/*计算关键词所关联的商品数量
	$result = array( 关键词 => 管理商品的数量 );
	*/
	function keyword_count($word)
	{
		if(empty($word))
		{
			return false;
		}
		else
		{
			if(is_array($word))
			{
				$wordArray  = $word;
			}
			else
			{
				$wordArray  = explode(',',$word);
			}

			$keywordObj = new IModel('keyword');
			$goodsObj   = new IModel('goods');
			$result     = array();

			foreach($wordArray as $val)
			{
				$val_sql = IFilter::act($val);

				$countNum = $goodsObj->getObj('name like "%'.$val_sql.'%" AND is_del=0 ','count(*) as num');
				$result[$val] = $countNum['num'];
			}
			return $result;
		}
	}

	//关键词排序
	function keyword_order()
	{
		$word  = IFilter::act(IReq::get('id'));
		$order = IReq::get('order') ? intval(IReq::get('order')) : 99;

		$keywordObj = new IModel('keyword');
		$dataArray = array('order' => $order);
		$keywordObj->setData($dataArray);
		$is_success = $keywordObj->update('word = "'.$word.'"');

		if($is_success == true)
		{
			$result = array(
				'isError' => false,
			);
		}
		else
		{
			$result = array(
				'isError' => true,
				'message' => '更新排序失败',
			);
		}

		echo JSON::encode($result);
	}

//下载类别列表
function download_cat_list()
{
	$this->redirect('download_cat_list');
}

//下载列表
function download_list()
{
	$this->redirect('download_list');
}

//下载内容编辑
function download_edit_act()
	{
		$photo = IFilter::act( IReq::get('focus_photo','post'),'string' ); //图片地址
	
		$file = null; //文件地址

		//图片上传
		if(isset($_FILES['attach']['name']) && $_FILES['attach']['name']!='')
		{
			$fileObj = new FileUpload();
			$file    = $fileObj->run();
		}

		$id = IReq::get('id');
		$id = intval($id);
		$obj = new IModel('download');

		//修改信息
		$linkurl = IFilter::act( IReq::get('linkurl','post') );
		if(trim($linkurl)!=""){
			$http = "http://";
			$http1 = substr(trim($linkurl),0,7);
			if($http!=$http1){$linkurl = $http.$linkurl;}
		}
		
		$access = IFilter::act(IReq::get('access','post'),'int');
		
		if($id)
		{
			$update = array(
				'name'    => IFilter::act( IReq::get('name','post'),'string' ),
				
				'access'  => $access,
				'linkurl' => $linkurl,
				'order'   => intval( IReq::get('order','post') ),
				'category_id'    => IFilter::act( IReq::get('category_id','post'),'string' ),
	
			);
    
			if($file!=null) $update['file'] = $file['attach']['fileSrc'];

			$obj->setData($update);
			$where = 'id = '.$id;
			$obj->update($where);
		}

		//新增信息
		else
		{
			$insert = array(
				'name'    => IFilter::act( IReq::get('name','post'),'string' ),
				'create_time' => ITime::getDateTime(),
				'access'  => $access,
				'linkurl' => $linkurl,
   			'order'   => intval( IReq::get('order','post') ),
				'category_id'    => IFilter::act( IReq::get('category_id','post'),'string' ),
	
			);
			if($file!=null) $insert['file'] = $file['attach']['fileSrc'];
			$obj->setData($insert);
			$obj->add();
		}
		$this->redirect('download_list');
	}

	//[下载管理]download单页
	function download_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$obj = new IModel('download');
			$where = 'id = '.$id;
			$data = $obj->getObj($where);
		}
		else
		{
			$data = array(
				'id'     => null,
				'name'   => null,
				'linkurl'=> null,
	
				'order'  => null,
				'file'	=>null,
				'category_id'=>null,
				'access' => '0',
			);
		}
		$this->setRenderData($data);
		$this->redirect('download_edit');
	}

	//[下载管理]删除
	function download_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int' );
		$obj = new IModel('download');
		if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);
			$this->redirect('download_list');
		}
		else
		{
			$this->redirect('download_list',false);
			Util::showMessage('请选择要删除的下载文件');
		}
	}
	

 //[页面管理] 编辑
	function page_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$obj = new IModel('page');
			$where = 'category_id = '.$id;
			$data = $obj->getObj($where);
		}
		else
		{
			$data = array(
				'id'     => null,
				'name'   => null,
				'content'=> null,
				'keywords'  => null,
				'description'  => null,
			);
		}
		$this->setRenderData($data);
		$this->redirect('page_edit');
	}
 //[页面管理] 页面编辑操作
	function page_edit_act()
	{
    $id = intval( IReq::get('category_id') );
    
		$obj = new IModel('page');

		$dataArray = array(
		  'category_id'=> intval( IReq::get('category_id','post') ),
			'name'    => IFilter::act( IReq::get('name','post') ,'string' ),
			'content'    => IFilter::act( IReq::get('content','post') ,'string' ),
			'keywords'    => IFilter::act( IReq::get('keywords','post') ,'string' ),
			'description'    => IFilter::act( IReq::get('description','post') ,'string' ),
		);
		$obj->setData($dataArray);

		if($id)
		{
			$where = 'category_id = '.$id;
			$result = $obj->update($where);
			if(!$result)
			{
				$result = $obj->add();
			}
		}

		$this->redirect('page_list');

	}
//[页面管理]删除页面
	function page_del()
	{
	
		$id = intval( IReq::get('id') );
		$catObj = new IModel('column');

		//是否执行删除检测值
		$isCheck=true;

		//检测是否有parent_id 为 $id
		$where   = 'parent_id = '.$id;
		$catData = $catObj->getObj($where);
		if(!empty($catData))
		{
			$isCheck=false;
			$message='此分类下还有子分类';
		}
/*
		//检测是否有page的category_id 为 $id
		else
		{
			$articleObj = new IModel('page');
			$where = 'category_id = '.$id;
			$catData = $articleObj->getObj($where);

			if(!empty($catData))
			{
				$isCheck=false;
				$message='此分类下还有文章';
			}
		}
*/
		//开始删除
		$where  = 'id = '.$id;
		$result = $catObj->del($where);
		if($result==true && $isCheck==true)
		{
			$this->redirect('page_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect(page_list,false);
			Util::showMessage($message);
		}

	}

	
//[社会招聘]增加或者修改
	function position_edit_act() {
		$id=intval(IReq::get('id','post'));
		$positionObj=new IModel('position');
		$dataArray = array(
			'position'    => IFilter::act( IReq::get('position','post') ,'string' ),
			'position_num'    => IFilter::act( IReq::get('position_num','post') ,'int' ),
			'need_sex'    => IFilter::act( IReq::get('need_sex','post') ,'int' ),
			'department'    => IFilter::act( IReq::get('department','post') ,'int' ),
			'position_type'    => IFilter::act( IReq::get('position_type','post') ,'int' ),
			'need_age'    => IFilter::act( IReq::get('need_age','post') ,'string' ),
		  	'education' => IFilter::act(IReq::get('education','post'),'int'),
			'work_experience'    => IFilter::act( IReq::get('work_experience','post') ,'string' ),
			'end_time' => IReq::get('end_time','post'),
			'operational_area'    => IFilter::act( IReq::get('operational_area','post') ,'string' ),
			'position_status'    => IFilter::act( IReq::get('position_status','post') ,'int' ),
			'description'    => IFilter::act( IReq::get('description','post') ,'text' ),
		);
		$dataArray['publish_time'] = date("Y-m-d");
		$positionObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$result = $positionObj->update($where);
		}else
		{
			$positionObj->add();
		}
		$this->redirect('position_list');
	}

//[社会招聘]招聘岗位列表
	function position_list()
	{
		$this->redirect('position_list');
	}
	
//[社会招聘]删除
	function position_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int'  );
		if(!is_array($id))
		{
			$id = array($id);
		}
		$id = implode(",",$id);

		$positionObj = new IModel('position');
		$positionObj->del( "id IN ({$id})" );
		$this->redirect('position_list');
	}

//[社会招聘]单页
	function position_edit()
	{
		$id = IReq::get('id');
		if($id)
		{
			$id = intval($id);

			//获取文章信息
			$positionObj = new IModel('position ');
			$where      = 'id = '.$id;
			$this->positionRow = $positionObj->getObj($where);
		}
		$selectObj = new IModel('select');
		$where ='name = "招聘部门"';
		$this->depart = $selectObj ->getObj($where);
		$this->department = $this->depart['id'];
		$where ='name = "职位类型"';
		$this->type = $selectObj ->getObj($where);
		$this->position_type= $this->type[id];
		$where ='name = "学历要求"';
		$this->education = $selectObj ->getObj($where);
		$this->education_type =$this->education['id'];
		$this->redirect('position_edit',false);
	}

//[岗位申请]列表
	function position_apply_list()
	{
		$this->redirect('position_apply_list');
	}
	
//[岗位申请]删除
	function position_applydel()
	{
		$id = IFilter::act( IReq::get('id') , 'int'  );
		if(!is_array($id))
		{
			$id = array($id);
		}
		$id = implode(",",$id);

		$positionObj = new IModel('position_apply');
		$positionObj->del( "id IN ({$id})" );
		$this->redirect('position_apply_list');
	}
//[岗位申请]查看
	function position_applydetail()
	{
		$id = IReq::get('id');
		if($id)
		{
			$id = intval($id);

			//获取文章信息
			$positionapplyObj = new IModel('position_apply ');
			$where      = 'ID = '.$id;
			$this->positionApplyRow = $positionapplyObj->getObj($where);
			$positionObj = new IModel('position ');
			$where      = 'id = '.$this->positionApplyRow['POSITION_ID'];
			$this->positionRow = $positionObj->getObj($where);
			$position=$this->positionApplyRow['POSITION_ID'];
			if($position!=null){
					$this->position=$this->positionRow['position'];
			}
		}

		$this->redirect('position_applydetail',false);
	}
	//[岗位申请]审查编辑
	function position_applydetail_act()
	{
		$id = IReq::get('id');
		$id = intval($id);
		//获取审查
		$positionapplyObj = new IModel('position_apply ');
		$where      = 'ID = '.$id;
		$dataArray = array(
		'STATE'    =>  IFilter::act(IReq::get('state','post'),'int'),
		'NOTE'     =>  IFilter::act(IReq::get('note','post'),'string'),
	    );
	    $positionapplyObj->setData($dataArray);
	    if($positionapplyObj->update($where))
	         $message="处理成功！";
	    else 
	         $message="处理失败！";
		$this->redirect('position_apply_list',false);
		Util::showMessage($message);
	}
//[岗位申请]下载简历
	function position_applydownload()
	{
		$id = IReq::get('id');
		if($id)
		{
			$id = intval($id);

			//获取文章信息
			$positionapplyObj = new IModel('position_apply ');
			$where      = 'ID = '.$id;
			$this->positionApplyRow = $positionapplyObj->getObj($where);
			$positionObj = new IModel('position ');
			$where      = 'id = '.$this->positionApplyRow['POSITION_ID'];
			$this->positionRow = $positionObj->getObj($where);
			$position=$this->positionApplyRow['POSITION_ID'];
			if($position!=null){
					$this->position=$this->positionRow['position'];
			}
		}
		$this->redirect('position_applydetail',false);
	}
	
	// 专题信息搜索
	function special_topic_info(){
		$title = IReq::get('title');
	    $tablePre = isset(IWeb::$app->config['DB']['tablePre'])?IWeb::$app->config['DB']['tablePre']:'';
	    $topic = $tablePre.special_topic;
	    $topic_cat = $tablePre.special_topic_cat;
		$query = new IQuery("special_topic_info as s");
		$query->join =  "INNER JOIN ($topic_cat b INNER JOIN $topic c ON c.id = b.topic_id) ON s.topic_cat_id = b.id";
		if($title != '')
		{
		   $query->where = "s.title like '%".$title."%' or b.cat_name like '%".$title."%'  or c.title like '%".$title."%'";
		}
		$query->fields = "s.id,s.title,s.type,b.cat_name,c.title as topic";
		$query->order = "c.id desc,s.id desc";
		$query->page = isset($_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$SearchRow =  $query->find();
		$this->SearchRow = $SearchRow;
		$this->title = $title;
		$this->redirect('special_topic_info');
	}
	/*********************************
	 * 2011-12-04
	 * Author:Qiulin
	 * 文章专题搜索
	 ***********************************/
	// 新闻专题搜索
	function article_search(){
		$flag  = IFilter::act(IReq::get('flag'), 'int');
		$title = IReq::get('title');		
		$query = new IQuery ( "article" );
		if ($title && $flag === 1) {
			$query->where = "title like '%" . $title . "%' or content like '%" . $title . "%'";
		}
		$query->fields = "*";
		$query->order = "sort asc,id desc";
		$query->page = isset ( $_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$artSearchRow =  $query->find();
		for($i = 0; $i < count($artSearchRow); $i++){
			$artSearchRow[$i]['content'] = $this->SubCN4(strip_tags($artSearchRow[$i]['content']),70);					
		}
		$this->artSearchRow = $artSearchRow;
		$this->title = $title;
		
		$this->redirect('article_search');
	}
	/*************E  N  D*****************/
	//截取中文字符串 
	function SubCN4($str,$len)
	{
		 if($str=='' || strlen($str)<=$len)
		 	return $str;
		 else{
		 	 return trim(iconv_substr($str,0,$len,'utf-8')."......");    // 中英文无差别显示用iconv_substr();
		 }
	}
	//检验专题title是否存在
    function check_title()
	{
		 $title=IFilter::act(IReq::get('title'));
         $check = new IQuery("special_topic");
         $check-> where = "title = '$title'";
         $num= $check->find();
		 if(count($num)!=0){
			  echo "该标题已被使用";	
		 }
	}
	
	/**********************************************
	* 2011-12-04
	* Author:Qiulin
	* 用户管理
	**********************************************/
	//用户列表
	function member_list()
	{
		$search = IFilter::string(IReq::get('search'));
		$keywords = IFilter::string(IReq::get('keywords'));
		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search like '%{$keywords}%' ";
		}
		$this->member_data['search'] = $search;
		$this->member_data['keywords'] = $keywords;
		$this->member_data['where'] = $where;
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query();
		$data_group = is_array($data_group) ? $data_group : array();
		$group      = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->member_data['group'] = $group;
		$this->setRenderData($this->member_data);
		$this->redirect('member_list');
	}
	/**
	 * @brief 用户筛选
	 */
	function member_filter()
	{
		$search = IFilter::string(IReq::get('search'));
		$keywords = IFilter::string(IReq::get('keywords'));
		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search like '%{$keywords}%' ";
		}
		$this->member_data['search'] = $search;
		$this->member_data['keywords'] = $keywords;
		$this->member_data['where'] = $where;
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query();
		$data_group = is_array($data_group) ? $data_group : array();
		$group      = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->member_data['group'] = $group;

		$page = IReq::get('page');
		$page = intval($page) ? intval($page) : 1;
		$and = ' and ';
		$where = 'm.status="1"'.$and;
		$group_key = IFilter::string(IReq::get('group_key'));
		$group_v = IFilter::act((IReq::get('group_value')),'int') ;
		if($group_key && $group_v)
		{
			if($group_key=='eq')
			{
				$where .= "m.group_id='{$group_v}' {$and}";
			}else
			{
				$where .= "m.group_id!='{$group_v}' {$and} ";
			}
		}
		$username_key = IFilter::string(IReq::get('username_key'));
		$username_v = IFilter::act(IReq::get('username_value'),'string');
		if($username_key && $username_v)
		{
			if($username_key=='eq')
			{
				$where .= "u.username='{$username_v}' {$and}";
			}else
			{
				$where .= 'u.username like "%'.$username_v.'%"'.$and;
			}
		}
		$truename_key = IFilter::string(IReq::get('truename_key'));
		$truename_v = IFilter::act(IReq::get('truename_value'),'string');
		if($truename_key && $truename_v)
		{
			if($truename_key=='eq')
			{
				$where .= "m.true_name='{$truename_v}' {$and}";
			}else
			{
				$where .= 'm.true_name like "%'.$truename_v.'%"'.$and;
			}
		}
		$mobile_key = IFilter::string(IReq::get('mobile_key'));
		$mobile_v = IFilter::act(IReq::get('mobile_value'),'string');
		if($mobile_key && $mobile_v)
		{
			if($mobile_key=='eq')
			{
				$where .= "m.mobile='{$mobile_v}' {$and} ";
			}else
			{
				$where .= 'm.mobile like "%'.$mobile_v.'%"'.$and;
			}
		}
		$telephone_key = IFilter::string(IReq::get('telephone_key'));
		$telephone_v = IFilter::act(IReq::get('telephone_value'),'string');
		if($telephone_key && $telephone_v)
		{
			if($telephone_key=='eq')
			{
				$where .= "m.telephone='{$telephone_v}' {$and} ";
			}else
			{
				$where .= 'm.telephone like "%'.$telephone_v.'%"'.$and;
			}
		}
		$email_key = IFilter::string(IReq::get('email_key'));
		$email_v = IFilter::act(IReq::get('email_value'),'string');
		if($email_key && $email_v)
		{
			if($email_key=='eq')
			{
				$where .= "u.email='{$email_v}' {$and} ";
			}else
			{
				$where .= 'u.email like "%'.$email_v.'%"'.$and;
			}
		}
		$zip_key = IFilter::string(IReq::get('zip_key'));
		$zip_v = IFilter::act((IReq::get('zip_value')),'string');
		if($zip_key && $zip_v)
		{
			if($zip_key=='eq')
			{
				$where .= "m.zip='{$zip_v}' {$and} ";
			}else
			{
				$where .= 'm.zip like "%'.$zip_v.'%"'.$and;
			}
		}
		$sex = intval(IReq::get('sex'));
		if($sex && $sex!='-1')
		{
			$where .= 'm.sex='.$sex.$and;
		}
		$point_key = IFilter::string(IReq::get('point_key'));
		$point_v = intval(IReq::get('point_value'));
		if($point_key && $point_v)
		{
			if($point_key=='eq')
			{
				$where .= 'm.point= "'.$point_v.'"'.$and;
			}
			elseif($point_key=='gt')
			{
				$where .= 'm.point > "'.$point_v.'"'.$and;
			}
			else
			{
				$where .= 'm.point < "'.$point_v.'"'.$and;
			}
		}
		$regtimeBegin = IFilter::string(IReq::get('regtimeBegin'));
		if($regtimeBegin)
		{
			$where .= 'm.time > "'.$regtimeBegin.'"'.$and;
		}
		$regtimeEnd = IFilter::string(IReq::get('regtimeEnd'));
		if($regtimeEnd)
		{
			$where .= 'm.time < "'.$regtimeEnd.'"'.$and;
		}
		$where .= ' 1 ';

		$query = new IQuery("member as m");
		$query->join = "left join user as u on m.user_id = u.id left join user_group as gp on m.group_id = gp.id";
		$query->fields = "m.*,u.username,u.email,gp.group_name";
		$query->where = $where;
		$query->page = $page;
		$query->pagesize = "20";
		$this->member_data['member_list'] = $query->find();
		$this->member_data['pageBar'] = $query->getPageBar('/member/member_filter/');
		$this->setRenderData($this->member_data);
		$this->redirect('member_filter');
	}
	
	function member_remove()
	{
		$user_ids = IFilter::act(IReq::get('check','post'),'int');
		$group_id = IFilter::act(IReq::get('move_group','post'),'int');
		$point    = IFilter::act(IReq::get('move_point','post'),'int');
		if($user_ids && is_array($user_ids))
		{
			$ids = implode(',',$user_ids);
			if($ids)
			{
				$tb_member = new IModel('member');
				$updatearray = array();

				//积分改动
				if($point)
				{
					$pointObj = new Point;
					$userList = $tb_member->query('user_id in('.$ids.')','user_id,point');

					foreach($userList as $val)
					{
						$c_point = intval($point - $val['point']);
						if($c_point != 0)
						{
							$tip = $c_point > 0 ? '奖励' : '扣除';
							$pointConfig = array(
								'user_id' => $val['user_id'],
								'point'   => $c_point,
								'log'     => '管理员'.$this->admin['admin_name'].'修改了积分，'.$tip.$c_point.'积分',
							);
							$pointObj->update($pointConfig);
						}
					}
				}
				$updatearray['group_id'] = $group_id;
				$tb_member->setData($updatearray);
				$where = "user_id in (".$ids.")";
				$tb_member->update($where);
			}
		}
		$this->member_list();
	}
	
	function member_restore()
	{
		$user_ids = IReq::get('check');
		$user_ids = is_array($user_ids) ? $user_ids : array($user_ids);
		if($user_ids)
		{
			$user_ids = IFilter::act($user_ids,'int');
			$ids = implode(',',$user_ids);
			if($ids)
			{
				$tb_member = new IModel('member');
				$tb_member->setData(array('status'=>'1'));
				$where = "user_id in (".$ids.")";
				$tb_member->update($where);
			}
		}
		$this->redirect('recycling');
	}
	
	/**
	 * @brief 回收站
	 */
	function recycling()
	{
		$search = IReq::get('search');
		$keywords = IReq::get('keywords');
		$search_sql = IFilter::act($search,'string');
		$keywords = IFilter::act($keywords,'string');

		$where = ' 1 ';
		if($search && $keywords)
		{
			$where .= " and $search_sql like '%{$keywords}%' ";
		}
		$this->member_data['search'] = $search;
		$this->member_data['keywords'] = $keywords;
		$this->member_data['where'] = $where;
		$tb_user_group = new IModel('user_group');
		$data_group = $tb_user_group->query();
		$data_group = is_array($data_group) ? $data_group : array();
		$group = array();
		foreach($data_group as $value)
		{
			$group[$value['id']] = $value['group_name'];
		}
		$this->member_data['group'] = $group;
		$this->setRenderData($this->member_data);
		$this->redirect('recycling');
		
	}
	/**
	 * @brief 彻底删除会员
	 */
	function member_del()
	{
		$user_ids = IReq::get('check');
		$user_ids = is_array($user_ids) ? $user_ids : array($user_ids);
		$user_ids = IFilter::act($user_ids,'int');
		if($user_ids)
		{
			$ids = implode(',',$user_ids);

			if($ids)
			{
				$tb_member = new IModel('member');
				$where = "user_id in (".$ids.")";
				$tb_member->del($where);

				$tb_user = new IModel('user');
				$where = "id in (".$ids.")";
				$tb_user->del($where);

				//$logObj = new log('db');
				//$logObj->write('operation',array("管理员:".$this->admin['admin_name'],"删除了用户","被删除的用户ID为：".$ids));
			}
		}
		$this->redirect('member_list');
	}
	/**
	 * @brief 删除至回收站
	 */
	function member_reclaim()
	{
		$user_ids = IReq::get('check');
		$user_ids = is_array($user_ids) ? $user_ids : array($user_ids);
		$user_ids = IFilter::act($user_ids,'int');
		if($user_ids)
		{
			$ids = implode(',',$user_ids);
			if($ids)
			{
				$tb_member = new IModel('member');
				$tb_member->setData(array('status'=>'2'));
				$where = "user_id in (".$ids.")";
				$tb_member->update($where);
			}
		}
		$this->member_list();
	}
	/**************** E  N  D ***************/ 
	
	
	
	/****************************************
	 * 2011-12-07
	 * Author:Qiulin
	 * 视频资源列表
	 * *************************************/
	//视频列表
	function video_list()
	{
		$this->redirect('video_list');
		
	}
	//删除视频
	function video_del()
	{
		$video_id = IReq::get('id');
		$videoObj = new IModel('upload_videos');
		$where = 'id = '.$video_id;
		$videoObj->del($where);
		$this->redirect('video_list');
	}
	/************ E N D *******************/
	

	//2011_12_4
	//曹俊
	//单页图片列表
	function picgroup_list()
	{	
		$query = new IQuery("column");
		$query->where = "type= 107";
		$query->fields= "id,name";
		$query->order ="id asc";
		$query->page = isset($_GET['page'])?$_GET['page']:1;
		$this->query = $query;
		$this->list =  $query->find();
		$this->redirect("picgroup_list");
	}
		/****************************************
	 * 2012-04-12
	 * Author:zhangfan
	 * 创建相册
	 * *************************************/
	function add_pic_group()
	{	
		$id = intval(IReq::get("id"));
		$this->column_id = $id;
		$this->redirect("add_pic_group");
	}
	function add_pic_group_act()
	{	
		$pgObj = new IModel("pic_group");
		//获取所属图片类型的栏目
		$column_id = intval(IReq::get("column"));
		$name = IFilter::act(IReq::get("name"),'string');
		$sort = intval(IReq::get("sort"));
		$create_time = date('Y-m-d');
		$data = array(
			'name' => $name,
			'sort' => $sort,
			'column_id' => $column_id,
			'create_time' => $create_time
		);
		$pgObj->setData($data);
		$pgObj->add();
		$this->redirect("picgroup_list");
	}
	//删除相册
	function del_img_group()
	{
		//相册id
		$id = intval(IReq::get("id"));
		$pgObj = new IModel("pic_group");
		$pObj  =  new IModel("source");
		
		//删除相册
		$pg_where = 'id='.$id;
		$pgObj->del($pg_where);
		
		//删除照片
		$p_where = 'img_group_id='.$id;
		$pObj->del($p_where);
		
		$this->redirect('picgroup_list');
	}
	/****************************************
	 * 2012-04-13
	 * Author:zhangfan
	 * 编辑相册
	 * *************************************/
	function picgroup_edit()
	{
		$pic_ids = array();
		$pic_intrs = array();
		//相册id
		$pic_group_id = intval(IReq::get("id"));
		$pg_where = 'id='.$pic_group_id;
		$pgObj = new IModel('pic_group');
		//相册数据
		$this->contentRow1 = $pgObj->getObj($pg_where);
		
		$pObj = new IQuery('source');
		$pObj->where = 'img_group_id ='.$pic_group_id;
		//相册的图片数据
		$this->pic_contentRow = $pObj->find();
	    $this->redirect('picgroup_edit');
	
	}
	
	function edit_pic_group_act()
	{
		//相册id
		$pic_group_id = intval(IReq::get("id"));
		//封面图片
		$front_pic = IReq::get("focus_photo");
		//相册名称
		$group_name = IReq::get("group_name");
		//排序
		$group_sort = IReq::get("sort");
		//更新相册封面数据
		$pic_group_Obj = new IModel('pic_group');
		$groupdata = array(
			'front_img'     => $front_pic,
			'name'     => $group_name,
			'sort'     => $group_sort,
		    
		);
		$pic_group_Obj->setData($groupdata);
		$pic_group_where = 'id='.$pic_group_id;
		$pic_group_Obj->update($pic_group_where);
		
	    //图片ids
		$pic_ids = IReq::get("source_id");
		//图片介绍s
		$pic_intrs = IReq::get("intr");
		
		//跟新source数据
		$picObj = new IModel('source');
		foreach($pic_ids as $key=>$val)
		{
			$pic_where = 'id ='.$val;
			$data = array(
			'describe'     => $pic_intrs[$key],
			'img_group_id' => $pic_group_id
			);
			$picObj->setData($data);
			$picObj->update($pic_where);
		}
		$this->redirect('picgroup_list');
	}
	//删除图片
	function del_img()
	{
		$path = IReq::get("path");
		$column_type = intval(IReq::get("column_type"));
		//根据文件路径删除数据库中的图片数据
		$sourceObj = new IModel("source");
		$source_where = 'path = \''.$path.'\'';
		$sourceObj->del($source_where);
		//删除文件夹中的图片文件
		if(empty($column_type))
		{
			$siteConfigObj = new Config("site_config");$site_config   = $siteConfigObj->getInfo();
			$morepath=explode(".",$path);
			unlink($path);
			$path = $morepath[0].'_'.$site_config['show_thumb_width'].'_'.$site_config['show_thumb_height'].'.'.$morepath[1];
			unlink($path);
			$path = $morepath[0].'_'.$site_config['list_thumb_width'].'_'.$site_config['list_thumb_height'].'.'.$morepath[1];
			unlink($path);
		}
		else{
			$morepath=explode(".",$path);
			unlink($path);
			$path = $morepath[0].'_126_75.'.$morepath[1];
			unlink($path);
			$path = $morepath[0].'_500_300.'.$morepath[1];
			unlink($path);
		}
	}
	/*********************************/
	//2011_12_4
	//曹俊
	//单页图片编辑功能
	function picture_edit()
	{
		$id = intval(IReq::get("id"));
		$arr = array();
		if($id){
			$contentObj = new IModel('picture_group');
			$contentObj1 = new IModel('column');
			$pictureObj= new IQuery('source');
			
			$where = 'column_id = '.$id;
			$this->contentRow = $contentObj->getObj($where);
			$where1 = 'id = '.$id;
			$this->contentRow1 = $contentObj1->getObj($where1);
			$pictureObj->where = 'column_id ='.$id .' and type = 1';
			$this->pic_contentRow = $pictureObj->find();
			$arr['name']=$this->contentRow1['name'];
			//var_dump($this->contentRow);
			if(count($this->contentRow)>0){
				$arr['introduce']=$this->contentRow['introduce'];
			}
			
			$arr['source']=$this->pic_contentRow;
			$this->pic_name='';
			//组合图片的名字
			foreach ($this->pic_contentRow as $value)
			{
				$this->pic_name .= $value['path'].',';
			}
			
			
			$this->setRenderData($arr);
			$this->redirect("picture_edit");
		}
	}
	function  picture_edit_act()
	{
		$id = intval(IReq::get('id','post'));
		//保存导读信息
		$picture_group= new IModel('picture_group');
		$where = 'column_id ='.$id;
		$introduce = IFilter::act(IReq::get('description','post'));
		$old_data = $picture_group->getObj($where);
		$data=array(
		'introduce' => $introduce,
		'column_id' => $id
		);
		$picture_group->setData($data);
		if(!empty($old_data))
		{
			$picture_group->update($where);
		}
		else 
		{
			$picture_group->add();
		}
		
		//初始化本栏目的所有的图片清空为零
		if($id)
		{
			/*
			$pic_clearObj = new IModel('source');
			$pic_clearObj->where = 'column_id = ' .$id;
			$clear_data = $pic_clearObj->find();
			*/
			$pictureObj= new IQuery('source');
			$pictureObj->where = 'column_id ='.$id .' and type = 1';
			$cleardata= $pictureObj->find();
			$pic_clearObj= new IModel('source');
			$DataArray = array(
				'column_id' => '0'
				);
			foreach ($cleardata as $key => $value)
			{
				$where ='path = "'.$value['path'].'"';
				$pic_clearObj->setData($DataArray);
				$pic_clearObj->update($where);
			}
		}
		
		
		
		//图片分割
		$all_photo = IFilter::act(IReq::get('photo_name','post'));
		if (!empty($all_photo))
		{
			$all_photo = explode(",", $all_photo);
		}
		
		//描述
		$all_descript = IFilter::act(IReq::get('intr','post'));
		if($id)
		{
			//source表的更新
			$pic_sourceObj = new IModel('source');
			foreach ( $all_descript as $key => $value) {
				$where ='path = "'.$all_photo[$key].'"';
				$DataArray = array(
				'describe' => $value,
				'column_id' => $id
				);
				$pic_sourceObj->setData($DataArray);
				$is_success= $pic_sourceObj->update($where);
			}
			$pic_picture_group = new IModel('picture_group');
			$pic_DataArray = array(
			'introduce' =>  IFilter::act(IReq::get('description','post'),'text'),
			'column_id' => $id
			);
			$pic_picture_group->setData($pic_DataArray);
			$where1= 'column_id = '.$id;
			$is_success1= $pic_picture_group->update($where1);
			$this->redirect('picture_list');
		}
		else 
		{
			Util::showMessage( "错误" );
		}	
	}
	
	function select_list()
	{
		$selectObj = new IQuery('select') ;
		$selectObj->where="parent_id=0" ;
		$this->selectdata = $selectObj->find() ;
		$this->redirect('select_list');
	}
	
	function select_edit()
	{
		$data = array();
		$id = intval( IReq::get('id') );
	//	$type = IFilter::act( IReq::get('type','get'),'string');

		if($id)
		{
			$catObj = new IModel('select');
			$where  = 'id = '.$id;
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$this->catRow = $data;
				$this->redirect('select_edit',false);
			}
		}else{
			//$this->catRow = array('type'=>$type);
			$this->redirect('select_edit');
		}
	}
	function  select_edit_act()
	{
		$id = intval(IReq::get('id','post'));
		$select = IFilter::act(IReq::get('select','post'));
		$name =IFilter::act(IReq::get('name','post'));
		if ($id!=0)	//更新
		{
			$mod = new IModel('select');
			$where = 'id= '.$id;
			$old_data = $mod->getObj($where);
			
			//如果选择改变了，并且改变的路径原来为基路径，则删除所有子选项
			if (($select!=0) &&($old_data['parent_id']==0))
			{
				$del_Obj=new IModel('select');
				$where = 'parent_id ='.$old_data['id'];
				$del_Obj->del($where);
			}
			
			//获得正确的路径
			if($select==0)
			{
				$path = ','.$old_data['id'].',';
			}
			else 
			{
				$path =','.$select.','.$old_data['id'].',';
			}
			$upObj= new IModel('select');
			$where = 'id= '.$id;
			$data= array(
				'name' =>$name,
				'parent_id' =>$select,
				'path' => $path
			);
			$upObj->setData($data);
			$upObj->update($where);
			
		}
		else 		//插入记录
		{	
			$insertObj = new IModel('select');
			$data= array(
				'name' =>$name,
				'parent_id' =>$select,
			);
			$insertObj->setData($data);
			$insertObj->add();
			
			//更新路径
			$where = 'name ="'.$name.'" and parent_id ='.$select;
			$old_data = $insertObj->getObj($where);
			if (!empty($old_data))
			{
				//获得正确的路径
				if($select==0)
				{
					$path = ','.$old_data['id'].',';
				}
				else 
				{
					$path =','.$select.','.$old_data['id'].',';
				}
				$update_Obj= new IModel('select');
				
				$data= array(
					'name' =>$name,
					'parent_id' =>$select,
					'path' => $path
				);
				$update_Obj->setData($data);
				$where = 'id = '.$old_data['id'];
				$update_Obj->update($where);
			}
		}	
		$this->redirect('select_list');
	}
	function select_del()
	{
		$id = intval( IReq::get('id') );
		$del_Obj=new IModel('select');
		$where1 = 'id ='.$id;
		$old_data =$del_Obj->getObj($where);
		if($old_data['parent_id']==0)
		{
			$where = 'parent_id ='.$old_data['id'];
			$del_Obj->del($where);
		}
		$del_Obj->del($where1);
		$this->redirect('select_list');
	}
	
	
//[活动管理]活动列表
	function huodong_list()
	{
		$this->redirect('huodong_list');
	}
	
//[活动管理]删除
	function huodong_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int'  );
		if(!is_array($id))
		{
			$id = array($id);
		}
		$id = implode(",",$id);

		$huodongObj = new IModel('huodong');
		$huodongObj->del( "id IN ({$id})" );
		$this->redirect('huodong_list');
	}

//[活动管理]内容编辑单页
	function huodong_edit()
	{
		$id = IReq::get('id');
		if($id)
		{
			$id = intval($id);

			//获取文章信息
			$huodongObj = new IModel('huodong');
			$where      = 'id = '.$id;
			$this->huodongRow = $huodongObj->getObj($where);
		}
		$this->redirect('huodong_edit',false);
	}
	
 //[活动管理]增加或者修改
	function huodong_edit_act() {
		$id=intval(IReq::get('id','post'));
		$huodongObj=new IModel('huodong');
		$dataArray = array(
		  'category_id'    => IFilter::act( IReq::get('category_id','post') ,'int' ),		
			'huodong'    => IFilter::act( IReq::get('huodong','post') ,'string' ),
			'huodong_num'    => IFilter::act( IReq::get('huodong_num','post') ,'int' ),
			'operational_area'    => IFilter::act( IReq::get('operational_area','post') ,'string' ),
			'run_time' => IReq::get('run_time','post'),
			'topic'    => IFilter::act( IReq::get('topic','post') ,'text' ),
			'description'    => IFilter::act( IReq::get('description','post') ,'text' ),
			'huodong_status'    => IFilter::act( IReq::get('huodong_status','post') ,'int' ),
			'end_time' => IReq::get('end_time','post'),
		);
		$dataArray['publish_time'] = date("Y-m-d");
		$huodongObj->setData($dataArray);
		if($id)
		{
			$where = 'id = '.$id;
			$result = $huodongObj->update($where);
		}else
		{
			$huodongObj->add();
		}
		$this->redirect('huodong_list');
	}
	/****************************************/
	function operator_link_list()
	{
		$this->redirect('operator_link_list');
	}
	//[友情链接]增加或者修改
	function operator_link_edit_act()
	{
		$type  = 1;    //上传方式(默认为文字)
		$photo = null; //图片地址

		//图片上传
		if(isset($_FILES['attach']['name']) && $_FILES['attach']['name']!='')
		{
			$photoObj = new PhotoUpload();
			$photo    = $photoObj->run();
			$type     = 2; //上传方式设置为
		}

		$id = IReq::get('id');
		$id = intval($id);
		$obj = new IModel('operator_links');

		//修改信息
		if($id)
		{
			$update = array(
				'name'    => IFilter::act( IReq::get('name','post'),'string' ),
				'type'    => $type,
				'linkurl' => IFilter::act( IReq::get('linkurl','post') ),
				'order'   => intval( IReq::get('order','post') ),
				'introduce'	=>IFilter::act( IReq::get('introduce','post'),'string' ),
			);

			if($photo!=null) $update['photo'] = $photo['attach']['img'];

			$obj->setData($update);
			$where = 'id = '.$id;
			$obj->update($where);
		}
		//新增信息
		else
		{
			$insertdata = array(
				'name'    	=> IFilter::act( IReq::get('name','post'),'string' ),
				'type'    	=> $type,
				'linkurl' 	=> IFilter::act( IReq::get('linkurl','post') ),
				'photo'   	=> $photo['attach']['img'],
				'order'   	=> intval( IReq::get('order','post') ),
				'introduce'	=>IFilter::act( IReq::get('introduce','post'),'string' ),
			);
			$obj->setData($insertdata);
			$obj->add();
		}
		$this->redirect('operator_link_list');
	}

	//[合作机构链接]link单页
	function operator_link_edit()
	{
		$id = intval( IReq::get('id') );
		if($id)
		{
			$obj = new IModel('operator_links');
			$where = 'id = '.$id;
			$data = $obj->getObj($where);
		}
		else
		{
			$data = array(
				'id'     	=> null,
				'name'   	=> null,
				'linkurl'	=> null,
				'photo'  	=> null,
				'order'     => null,
				'introduce' => null,
			);
		}
		$this->setRenderData($data);
		$this->redirect('operator_link_edit');
	}
	function operator_link_del()
	{
		$id = IFilter::act( IReq::get('id') , 'int' );
		$obj = new IModel('operator_links');
		if(!empty($id))
		{
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			}
			else
			{
				$where = 'id = '.$id;
			}
			$obj->del($where);
			$this->redirect('operator_link_list');
		}
		else
		{
			$this->redirect('operator_link_list',false);
			Util::showMessage('请选择要删除的链接');
		}
	}
}//end the tools calss