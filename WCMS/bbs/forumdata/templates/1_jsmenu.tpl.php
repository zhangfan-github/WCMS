<? if(!defined('IN_DISCUZ')) exit('Access Denied'); if(!empty($jsmenu['2'])) { ?>
	<ul class="popupmenu_popup headermenu_popup" id="memcp_menu" style="display: none">
		<li><a href="memcp.php">控制面板首页</a></li>
		<li><a href="memcp.php?action=profile">编辑个人资料</a></li>
		<? if($exchangestatus || $transferstatus || $ec_ratio) { ?>
			<li><a href="memcp.php?action=credits">积分交易</a></li>
		<? } ?>
		<li><a href="memcp.php?action=creditslog">积分记录</a></li>
		<li><a href="memcp.php?action=usergroups">公众用户组</a></li>
	<? if($spacestatus) { ?>
		<li><a href="memcp.php?action=spacemodule" target="_blank">个人空间管理</a></li>
	<? } ?>
	<? if($supe['status'] && !$xspacestatus) { ?>
		<li><a href="<?=$supe['siteurl']?>/?uid/<?=$discuz_uid?>" target="_blank">升级个人空间</a></li>
	<? } ?>
	</ul>
<? } if(!empty($plugins['jsmenu'])) { ?>
	<ul class="popupmenu_popup headermenu_popup" id="plugin_menu" style="display: none"><? if(is_array($plugins['jsmenu'])) { foreach($plugins['jsmenu'] as $module) { ?>	     <? if(!$module['adminid'] || ($module['adminid'] && $adminid > 0 && $module['adminid'] >= $adminid)) { ?>
	     <li><?=$module['url']?></li>
	     <? } ?>
	<? } } ?></ul>
<? } if(!empty($jsmenu['3'])) { ?>
	<ul class="popupmenu_popup headermenu_popup" id="stats_menu" style="display: none">
		<li><a href="stats.php">基本概况</a></li>
		<? if($statstatus) { ?>
			<li><a href="stats.php?type=views">流量统计</a></li><li><a href="stats.php?type=agent">客户软件</a></li><li><a href="stats.php?type=posts">发帖量记录</a></li>
		<? } ?>
		<li><a href="stats.php?type=forumsrank">版块排行</a></li><li><a href="stats.php?type=threadsrank">主题排行</a></li><li><a href="stats.php?type=postsrank">发帖排行</a></li><li><a href="stats.php?type=creditsrank">积分排行</a></li>
		<li><a href="stats.php?type=trade">交易排行</a></li>
		<? if($oltimespan) { ?><li><a href="stats.php?type=onlinetime">在线时间</a></li><? } ?>
		<li><a href="stats.php?type=team">管理团队</a></li>
		<? if($modworkstatus) { ?><li><a href="stats.php?type=modworks">管理统计</a></li><? } ?>
	</ul>
<? } if($discuz_uid && $jsmenu['4']) { ?>
	<ul class="popupmenu_popup headermenu_popup" id="my_menu" style="display: none">
		<li><a href="my.php?item=threads">我的话题</a></li>
		<li><a href="my.php?item=favorites&amp;type=thread">我的收藏</a></li>
		<li><a href="my.php?item=subscriptions">我的订阅</a></li>
		<li><a href="my.php?item=grouppermission">我的权限</a></li>
		<li><a href="my.php?item=polls&amp;type=poll">我的投票</a></li>
		<li><a href="my.php?item=tradestats">我的商品</a></li>
		<li><a href="my.php?item=reward&amp;type=stats">我的悬赏</a></li>
		<li><a href="my.php?item=activities&amp;type=orig&amp;ended=no">我的活动</a></li>
		<li><a href="my.php?item=debate&amp;type=debate">我的辩论</a></li>
		<? if($videoopen) { ?>
			<li><a href="my.php?item=video">我的视频</a></li>
		<? } ?>
		<li><a href="my.php?item=buddylist">我的好友</a></li>
		<? if($creditspolicy['promotion_visit'] || $creditspolicy['promotion_register']) { ?>
			<li><a href="my.php?item=promotion">我的推广</a></li>
		<? } ?>
		<? if($supe['status'] && $xspacestatus) { ?>
			<li><a href="<?=$supe['siteurl']?>/?uid/<?=$discuz_uid?>" target="_blank">个人空间</a></li>
		<? } elseif($spacestatus) { ?>
			<li><a href="space.php?uid=<?=$discuz_uid?>" target="_blank">个人空间</a></li>
		<? } ?>
	</ul>
<? } ?>