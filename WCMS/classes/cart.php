<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file cart.php
 * @brief 购物车类库
 * @author chendeshan
 * @date 2011-04-12
 * @version 0.6
 */

/**
 * @class Cart
 * @brief 购物车类库
 */
class Cart
{
	/*购物车结构
	* [id]   :array  商品id值;
	* [count]:int    商品数量;
	* [info] :array  商品信息 [goods]=>array( ['id']=>商品ID , ['data'] => array( [商品ID]=>array ( [name]商品或货品名称, [list_img]商品图片, [sell_price]价格, [count]购物车中此商品的数量, [store_nums]此商品的库存量 ,[type]类型goods,product ,[goods_id]商品ID值 ) ) ) , [product]=>array( 同上 ) , [count]购物车商品和货品数量 , [sum]商品和货品总额 ;
	* [sum]  :int    商品总价格;
	*/
	private $cartStruct  = array('goods' => array('id' => array(), 'data' => array() ),'product' => array( 'id' => array() , 'data' => array()),'count' => 0,'sum' => 0);

	//购物车名字前缀
	private $cartNamePre = 'shoppingcart_';

	//购物车保存时效[单位：分钟]
	private $cartTime    = 7200;

	//构造函数
	function __construct()
	{
		$cartInfo = $this->getMyCart();
		if($cartInfo == null)
		{
			$this->setMyCart($this->cartStruct);
		}
	}

	/**
	 * @brief 将商品或者货品加入购物车
	 * @param $gid  商品或者货品ID值
	 * @param $num  购买数量
	 * @param $type 加入类型 goods商品; product:货品;
	 */
	public function add($gid, $num = 1 ,$type = 'goods')
	{
		$gid = intval($gid);
		$num = intval($num);
		if($type != 'goods')
		{
			$type = 'product';
		}

		//购物车中已经存在此商品
		$cartInfo = $this->getMyCart();

		if(in_array($gid,$cartInfo[$type]['id']))
		{
			$goodsRow = $cartInfo[$type]['data'][$gid];

			//错误：库存超量
			if($goodsRow['store_nums'] < $goodsRow['count'] + $num)
			{
				return false;
			}
			$cartInfo[$type]['data'][$gid]['count']+= $num;
		}
		else
		{
			//添加商品数据
			$goodsRow = $this->getGoodInfo($gid,$type);
			if(!empty($goodsRow) && $goodsRow['store_nums'] >= $num)
			{
				$cartInfo[$type]['id'][]                = $gid;
				$cartInfo[$type]['data'][$gid]          = $goodsRow;
				$cartInfo[$type]['data'][$gid]['count'] = $num;
			}
			else
			{
				//IError::show(403,'not found this goods');
				return false;
			}
		}
		$cartInfo['count'] += $num;
		$cartInfo['sum']   += $goodsRow['sell_price'] * $num;

		$this->setMyCart($cartInfo);
	}

	//删除商品
	public function del($gid , $type = 'goods')
	{
		$cartInfo = $this->getMyCart();
		if($type != 'goods')
		{
			$type = 'product';
		}

		//删除商品数据
		if(isset($cartInfo[$type]['data'][$gid]))
		{
			$goodsRow = $cartInfo[$type]['data'][$gid];

			$idKey = array_search($gid,$cartInfo[$type]['id']);
			unset($cartInfo[$type]['id'][$idKey]);
			unset($cartInfo[$type]['data'][$gid]);

			$cartInfo['count'] -= $goodsRow['count'];
			$cartInfo['sum']   -= $goodsRow['count'] * $goodsRow['sell_price'];

			$this->setMyCart($cartInfo);
		}
		else
		{
			//IError::show(403,'not found this goods');
			return false;
		}
	}

	//根据 $gid 获取商品信息
	private function getGoodInfo($gid, $type = 'goods')
	{
		$dataArray = array();

		//商品方式
		if($type == 'goods')
		{
			$goodsObj  = new IModel('goods');
			$dataArray = $goodsObj->getObj('id = '.$gid.' and is_del = 0','id as goods_id,name,list_img,sell_price,store_nums');
			$dataArray['id'] = $dataArray['goods_id'];
		}

		//货品方式
		else
		{
			$productObj = new IQuery('products as pro , goods as go');
			$productObj->fields = ' go.id as goods_id , go.name, pro.sell_price ,go.list_img, pro.store_nums ,pro.id ';
			$productObj->where  = ' pro.id = '.$gid.' and go.is_del = 0 and pro.goods_id = go.id';
			$productRow = $productObj->find();
			if(!empty($productRow) && count($productRow) > 0)
			{
				$dataArray = $productRow[0];
			}
		}

		if(!empty($dataArray))
		{
			$dataArray['type'] = $type;
		}

		return $dataArray;
	}

	//获取当前购物车信息
	public function getMyCart()
	{
		$cookieName  = $this->getCartName();
		$cookieValue = ICookie::get($cookieName);
		if($cookieValue == null)
		{
			return $this->cartStruct;
		}
		else
		{
			return $cookieValue;
		}
	}

	//清空购物车
	public function clear()
	{
		$cookieName = $this->getCartName();
		ICookie::clear($cookieName);
	}

	//[私有]写入购物车
	private function setMyCart($goodsInfo)
	{
		$cookieName = $this->getCartName();
		ICookie::set($cookieName,$goodsInfo,$this->cartTime);
	}

	//[私有]获取购物车名字
	private function getCartName()
	{
		$cookieName = md5($this->cartNamePre);
		return $cookieName;
	}

}
?>