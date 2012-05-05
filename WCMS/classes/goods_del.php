<?php
/**
 * @copyright (c) 2011 jooyea.net
 * @file article.php
 * @brief 商品删除
 * @author zhouyong
 * @date 2011-04-27
 * @version 0.6
 */
class goods_del
{
	/**
	* @brief 删除与商品相关表中的数据
	*/
	public function del($goods_id)
	{
		//删除推荐类商品
		$tb_commend_goods = new IModel('commend_goods');
		$commend_goods_info = $tb_commend_goods->query('goods_id = '.$goods_id);
		if(count($commend_goods_info)>0)
		{
			foreach ($commend_goods_info as $value)
			{
				$tb_commend_goods->del('id = '.$value['id']);
			}
		}
		//删除商品公用属性
		$tb_goods_attribute = new IModel('goods_attribute');
		$goods_attribute_info = $tb_goods_attribute->query('goods_id = '.$goods_id);
		if(count($goods_attribute_info)>0)
		{
			foreach ($goods_attribute_info as $value)
			{
				$tb_goods_attribute->del('id = '.$value['id']);
			}
		}
		//删除相册商品关系表
		$tb_goods_relation = new IModel('goods_photo_relation');
		$goods_relation_info = $tb_goods_relation->query('goods_id = '.$goods_id);
		if(count($goods_relation_info)>0)
		{
			foreach ($goods_relation_info as $value)
			{
				$tb_goods_relation->del('id = '.$value['id']);
			}
		}
		//删除货品表
		$tb_products = new IModel('products');
		$products_info = $tb_products->query('goods_id = '.$goods_id);
		if(count($products_info)>0)
		{
			foreach ($products_info as $value)
			{
				$tb_products->del('id = '.$value['id']);
			}
		}
		//删除会员价格表
		$tb_group_price = new IModel('group_price');
		$group_price_info = $tb_group_price->query('goods_id = '.$goods_id);
		if(count($group_price_info)>0)
		{
			foreach ($group_price_info as $value)
			{
				$tb_group_price->del('id = '.$value['id']);
			}
		}
		//删除商品表
		$tb_goods = new IModel('goods');
		$tb_goods ->del('id='.$goods_id);
	}
}

?>