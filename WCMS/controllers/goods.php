<?php
class Goods extends IController
{
	protected $checkRight  = 'all';
    public $layout = 'admin';
    private $data = array();
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

    
	/**
	 * @brief 构造函数，调用父类构造函数、声明语言包对象
	 */
	function __construct()
	{
		parent::__construct(IWeb::$app,strtolower(__CLASS__));
		$this->lang = new ILanguage();
	}
	
	
	
	//[服务项目管理] 服务类别列表
	function goods_cat_list()
	{
		$this->redirect('goods_cat_list');
	}
	//[服务项目管理] 增加修改服务类别
	function goods_cat_edit()
	{
		$data = array();
		$id = intval( IReq::get('id') );

		if($id)
		{
			$catObj = new IModel('goods_cat');
			$where  = 'id = '.$id;
			$data = $catObj->getObj($where);
			if(count($data)>0)
			{
				$this->catRow = $data;
				$this->redirect('goods_cat_edit',false);
			}
		}else{
			$this->redirect('goods_cat_edit');
		}
	}

	//[服务项目管理] 增加和修改动作
	function goods_cat_edit_act()
	{
		$id        = intval( IReq::get('id','post') );

		$catObj    = new IModel('goods_cat');
		$DataArray = array(
			'name'      => IFilter::act( IReq::get('name','post'),'string'),
			'sort'      => intval( IReq::get('sort','post') ),
		);
		$catObj->setData($DataArray);
		
		//1,修改操作
		if($id)
		{
			$where  = 'id = '.$id;
			$catObj->update($where);
		}
		//2,新增操作
		else
		{
			$catObj->add();
		}
		$this->redirect('goods_cat_list');
	}

	//[服务项目管理] 删除
	function goods_cat_del()
	{
		$id = intval( IReq::get('id') );
		$catObj = new IModel('goods_cat');
		$goodsObj = new IModel('goods');

		//是否执行删除检测值
		$isCheck=true;

		$where   = 'cat_id = '.$id;
		$goodsData = $goodsObj->getObj($where);
		if(!empty($goodsData))
		{
			$isCheck=false;
			$message='此分类下还有商品';
		}

		//开始删除
		
		if($isCheck==true)
		{
			$where  = 'id = '.$id;
			$result = $catObj->del($where);
			$this->redirect('goods_cat_list');
		}
		else
		{
			$message = isset($message) ? $message : '删除失败';
			$this->redirect('goods_cat_list',false);
			Util::showMessage($message);
		}
	}
	
	/**
	 * @brief 添加或修改商品
	 */
	function goods_edit()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$tb_goods = new IModel('goods');
		$where = "id = ".$id;
		$this->goods_data = $tb_goods->getObj($where);
		$this->redirect('goods_edit');
		
	}
	
	
	/**
	 * @brief 添加或修改商品（动作）
	 */
	function goods_edit_act()
	{
		$id = IFilter::act(IReq::get('id'),'int');
		$cat_id = IFilter::act(IReq::get('cat_id'),'int');
		$arr_image = explode(',', IReq::get('image'));
		$arr_goods = array(
			'name' => IReq::get('name'),
			'gid' => IReq::get('gid'),
			'image' => $arr_image[0],
			'price' => IReq::get('price'),
			'describe' => IReq::get('describe'),
			'introduction' => IReq::get('introduction'),
			'sort' => IReq::get('sort'),
			'state' => IReq::get('state'),
			'cat_id' => $cat_id,
			);
		$tb_goods = new IModel('goods');
		$tb_goods->setData($arr_goods);
		if($id)
		{
			//修改商品
			$where = 'id = '.$id;
			$tb_goods->update($where);	
		}
		else {
			$tb_goods->add();
		}
		$this->redirect('goods_list');
	}
	
	/**
	 * @brief 商品列表
	 */
	function goods_list()
	{
		$this->redirect('goods_list');
	}
	
	/**
	 * @brief 删除商品
	 */
	function goods_del()
	{
		$id = IFilter::act( IReq::get('id') ,'int' );
		if(!empty($id))
		{
			$tb_goods = new IModel('goods');
			
			if(is_array($id) && isset($id[0]) && $id[0]!='')
			{
				$id_str = join(',',$id);
				$where = ' id in ('.$id_str.')';
			
			}
			else
			{
				$where = 'id = '.$id;
			}
			$tb_goods->del($where);               //删除商品
			
			$this->redirect('goods_list');
		}
		else
		{
			$this->redirect('goods_list',false);
			Util::showMessage('请选择要删除的商品');
		}
	}
}
