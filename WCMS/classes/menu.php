<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file menu.php
 * @brief 后台系统菜单管理
 * @author webning
 * @date 2011-01-12
 * @version 0.6
 * @note
 */
/**
 * @brief Menu
 * @class Menu
 * @note
 */
class Menu
{
	private static $commonMenu = array('/system/default');
	public $current;
    //菜单的配制数据
	private static $menu = array(
    
		'系统'=>array(
       /*
        '后台首页'=>array(
        			'/system/default' => '后台首页',
        		),
       */
        '网站管理'=>array(
            		'/system/conf_base' => '网站设置',
            		//'/system/conf_ui'   => '主题设置',
            	),
        '栏目管理'=>array(
	       			'/system/column_list'=> '栏目列表',
	       			'/system/column_edit'=> '添加栏目',
	      ), 

				'访问控制'=>array(
            		'/system/ip_access' => 'IP访问管理',
        ),
        '权限管理'=>array(
            		'/system/admin_list' => '管理员',
            		'/system/role_list'  => '角色',
            		'/system/right_list' => '权限资源'
        ),
  	
            	/*'支付管理'=>array(
                '/system/payment_list' => '支付方式'
            	),*/
/*
            	'配送管理'=>array(
                '/system/delivery'  	=> '配送方式',
                '/system/area'  		=> '地区管理'
            	),*/


				'数据库管理'=>array(
					'/system/db_bak' => '数据库备份',
					'/system/db_res' => '数据库还原',
				)
		),
		'工具'=>array(
			  '站内邮件管理'=>array(
     			'/tools/notice_list'=> '站内邮件列表',
     			'/tools/notice_edit'=> '站内邮件发布',
     		), 
			  '友情链接管理'=>array(
	       			'/tools/link_list'=> '友情链接列表',
	       			'/tools/link_edit'=> '添加友情链接',
	      ),
			'合作机构链接管理'=>array(
	       			'/tools/operator_link_list'=> '合作机构链接列表',
	       			'/tools/operator_link_edit'=> '添加合作机构链接',
	      ),
    		'广告管理'=>array(
	   			'/tools/ad_position_list'=> '广告位列表',
	   			'/tools/ad_list'=> '广告列表'
   			),
   		  '招聘管理'=>array(
	       			'/tools/select_list' =>'招聘选项',
					    '/tools/position_list'=>'招聘列表',
					    '/tools/position_edit'=> '发布招聘信息',
				), 
				'简历管理'=> array(
				      '/tools/position_apply_list'=> '简历列表',
				),  	
		),
		'内容'=>array(
 					'新闻管理'=>array(
						'/tools/news_cat_list'=> '新闻分类',
						'/tools/news_list'=> '新闻列表',
						'/tools/news_edit'=> '添加新闻',
					),	
					'文章管理'=>array(
						'/tools/article_cat_list'=> '文章分类',
						'/tools/article_list'=> '文章列表',
						'/tools/article_edit'=> '添加文章',
					),				
					'活动管理'=>array(
						'/tools/huodong_list'=> '活动策划列表',
						'/tools/huodong_edit'=> '添加活动策划',
					),	
					'页面管理'=>array(
	       			'/tools/content_list'=> '页面列表',
	       			//'/tools/column_edit/type/102'=> '添加页面',
	       	),	
	       	'视频管理'=>array(
						'/tools/vedio_cat_list'=> '视频分类',
	       		'/tools/video_list'=>   '视频链接列表',
	       		'/tools/upload_video'=> '添加视频链接',
	        ),		

       		'图片管理'=>array(
		       			'/tools/picgroup_list'=> '图片栏目列表',
			            '/tools/add_pic_group'=> '添加相册',
		       		),
       		
	       	'下载管理'=>array(
						'/tools/download_cat_list'=>'下载分类',
						'/tools/download_list'=>'下载列表',
						'/tools/download_edit'=>'添加下载',
					),
	         
					'栏目链接管理'=>array(
						'/tools/colum_link_list'=>'栏目链接列表',
					),
					
				
			//	'留言和建议管理'=>array(
			//		'/tools/message_list'=>'留言管理',
			//		'/tools/opinion_list'=>'投诉建议',
			//	),
	
			//	'DIY'=>array(
			//		'/tools/tyzx_list'=>'DIY列表',
			//		'/tools/tyzx_add'=>'添加DIY'
			//	),

		),
		
		'信息'=>array(
				'站内消息' => array(
					//'/comment/suggestion_list'  => '建议管理',
					//'/comment/refer_list'		=> '咨询管理',
					//'/comment/discussion_list'	=> '讨论管理',
					//'/comment/comment_list'		=> '评价管理',
					'/comment/message_list'		=> '站内消息群发',
					//'/message/notify_list'	=>	'到货通知',
				),
				'预订报名信息'=>array(
					'/message/online_yuding'		=>	'在线预订',
					'/message/online_baoming'   => '活动报名',
					'/message/online_service_baoming'	=>'服务报名',
					'/message/online_servicepack_baoming'	=>'服务套餐报名',
				),
		),
		
		'服务'=>array(
				'服务套餐管理'=>array(
				 '/service/service_cat_list' => '服务项目分类',
				 '/service/service_list' => "服务项目列表",
				 '/service/service_edit' => "添加服务项目",
				 '/service/service_package_list' => "服务套餐列表",
				 '/service/service_package_edit' => "添加服务套餐",
				),
				'服务课程表管理' => array(
					'/service/kebiao_list'		=> '课程表查询',
					'/service/kebiao_edit'		=> '课程表安排',
				),
		   '专家管理'=> array(
				  '/member/expert_cat_list'=>'专家组列表',
					'/member/expert_list'=>'专家列表',
					'/member/expert_edit'=>'添加专家',
				),
				'专家咨询排班管理'=>array(
					'/service/paiban_list'		=>	'排班查询',
					'/service/paiban_edit'		=>	'专家排班',
				),
				'营养菜谱管理'=>array(
					'/service/dish_type_list' => '菜谱分类',
					'/service/dish_list' => '菜谱列表'
				),
				'温馨提示管理'	=>array(
					'/service/reminder_list' => '温馨提示列表',
					'/service/reminder_edit' => '添加温馨提示'
				),
		),
	/*
		'策划'=>array(
				'技艺沙龙活动管理'=>array(
				 '/service/cehua_list' => "活动策划",
				),
		),		
	
   */
    /*
    '会员'=>array(
    		'会员管理'=>array(
					'/tools/member_list'=>'会员列表',
					'/tools/recycling'=>'会员回收站',
					'/member/group_list' => '会员组列表',
				),
    ),
    */
    
    		'商品'=>array(
				'商品管理'=>array(
					'/goods/goods_list' => '商品列表',
					'/goods/goods_edit' => '商品添加'
				),
				'商品分类'=>array(
					'/goods/goods_cat_list'	=>	'分类列表',
					'/goods/goods_cat_edit'	=>	'添加分类'
				),/*
				'品牌'=>array(
					'/brand/category_list'		=>	'品牌分类',
					'/brand/brand_list'		=>	'品牌列表'
				),
				'模型'=>array(
					'/goods/model_list'=>'模型列表',
					'/goods/spec_list'=>'规格列表',
					'/goods/spec_photo'=>'规格图库'
				),
				'热门搜索'=>array(
					'/tools/keyword_list' => '关键词列表'
				)*/
		),
		'会员'=>array(
				'会员管理'=>array(
            	//'/member/group_list' => '会员组列表',
				'/member/member_list' => '会员列表',
             	'/member/recycling' => '会员回收站',				
				),
				'健康档案'=>array(
				'/member/vip_member_list' => 'VIP列表',
				'/member/vip_member_edit' => '添加VIP',
				'/member/attribute_edit' => '编辑会员属性扩展项',
				'/member/output_users' => '导出VIP客户注册信息',
				),
		),

	);

	private static $menu_non_display = array(
		'/tools/article_edit_act'=>'/tools/article_list',
		'/message/notify_filter' =>'/message/notify_list',
		'/market/ticket_edit' => '/market/ticket_list',
		'/order/collection_show' => '/order/order_collection_list',
		'/order/refundment_show' => '/order/refundment_list',
		'/order/delivery_show' => '/order/order_delivery_list',
		'/order/returns_show' => '/order/order_returns_list',
		'/order/refundment_doc_show' => '/order/refundment_list',
		'/system/navigation' => '/system/conf_none_exists',
		'/system/navigation_edit' => '/system/conf_none_exists',
		'/system/navigation_recycle' => '/system/conf_none_exists',
		'/order/print_template' => '/order/order_list_non_exists',
		'/system/area_edit' => '/system/area',
		'/system/delivery_edit' => '/system/delivery',
		'/system/delivery_recycle' => '/system/delivery',
		'/member/recycling' => '/member/member_list',
		'/order/collection_recycle_list' => '/order/order_collection_list',
		'/order/delivery_recycle_list' => '/order/order_delivery_list',
		'/order/returns_recycle_list'	=>	'/order/order_returns_list',
		'/order/recycle_list'	=>	'/order/ship_info_list'

	);

    /**
     * @brief 根据用户的权限过滤菜单
     * @return array



     */
    private function filterMenu()
    {
    	$rights = ISafe::get('admin_right');

		//如果不是超级管理员则要过滤菜单
		if($rights != 'administrator')
		{
			foreach(self::$menu as $firstKey => $firstVal)
			{
				if(is_array($firstVal))
				{
					foreach($firstVal as $secondKey => $secondVal)
					{
						if(is_array($secondVal))
						{
							foreach($secondVal as $thirdKey => $thirdVal)
							{
								if(!in_array($thirdKey,self::$commonMenu) && (stripos(str_replace('@','/',$rights),','.substr($thirdKey,1).',') === false))
								{
									unset(self::$menu[$firstKey][$secondKey][$thirdKey]);
								}
							}
							if(empty(self::$menu[$firstKey][$secondKey]))
							{
								unset(self::$menu[$firstKey][$secondKey]);
							}
						}
					}
					if(empty(self::$menu[$firstKey]))
					{
						unset(self::$menu[$firstKey]);
					}
				}
			}
		}
    }

    /**
     * @brief 取得当前菜单应该生成的对应JSON数据
     * @return Json
     */
	public function submenu()
	{
		$controllerObj = IWeb::$app->getController();
		$controller = $controllerObj->getId();
		$actionObj = $controllerObj->getAction();
		$action = $actionObj->getId();
		$this->current = '/'.$controller.'/'.$action;
        $this->vcurrent = '/'.$controller.'/';
		$items  = array();

		if(isset(self::$menu_non_display[$this->current]))
		{
			$this->current = self::$menu_non_display[$this->current];
			$tmp = explode("/",$this->current);
			$this->vcurrent = $tmp[1];
			$action = $tmp[2];
		}

		//过滤菜单
		$this->filterMenu();
		$find_current = false;
		$items = array();
		foreach(self::$menu as $key => $value)
		{
			if(!is_array($value))
			{
				return;
			}
			$item = array();
			$item['current'] = false;
			$item['title'] = $key;

			foreach($value as $big_cat_name => $big_cat)
			{
				foreach($big_cat as $link=>$title)
				{
					if(!isset($item['link']) )
					{
						$item['link'] = $link;
					}

					if($find_current)
					{
						break;
					}

					$tmp1 = explode('_',$action);
					$tmp1 = $tmp1[0];
					if($link == $this->current || preg_match("!^/[^/]+/{$tmp1}_!",$link) )
					{

						$item['current'] = $find_current = true;
						$item['list'] = $value;
					}
				}

				if($find_current)
				{
					break;
				}
			}
			$items[] = $item;
		}
		return JSON::encode($items);
	}
}
?>
