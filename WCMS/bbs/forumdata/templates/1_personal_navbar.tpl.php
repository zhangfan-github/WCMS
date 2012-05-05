<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div>
<h2>个人管理</h2>
<ul>
	<li class="<? if($BASESCRIPT == 'pm.php') { ?>side_on first<? } ?>"><h3><a href="pm.php">短消息</a></h3></li>
	<? if($BASESCRIPT == 'my.php') { ?>
		<li class="side_on">
			<h3>我的</h3>
			<ul>
				<li<? if(in_array($item, array('threads', 'posts'))) { ?> class="current"<? } ?>><a href="my.php?item=threads<?=$extrafid?>">我的话题</a></li>
				<li<? if($item == 'favorites') { ?> class="current"<? } ?>><a href="my.php?item=favorites&amp;type=thread<?=$extrafid?>">我的收藏</a></li>
				<li<? if($item == 'subscriptions') { ?> class="current"<? } ?>><a href="my.php?item=subscriptions&amp;type=forum<?=$extrafid?>">我的订阅</a></li>
				<li<? if($item == 'grouppermission') { ?> class="current"<? } ?>><a href="my.php?item=grouppermission">我的权限</a></li>
				<li<? if($item == 'polls') { ?> class="current"<? } ?>><a href="my.php?item=polls&amp;type=poll<?=$extrafid?>">我的投票</a></li>
				<li<? if(in_array($item, array('tradestats', 'selltrades', 'buytrades', 'tradethreads'))) { ?> class="current"<? } ?>><a href="my.php?item=tradestats<?=$extrafid?>">我的商品</a></li>
				<li<? if($item == 'reward') { ?> class="current"<? } ?>><a href="my.php?item=reward&amp;type=stats<?=$extrafid?>">我的悬赏</a></li>
				<li<? if($item == 'activities') { ?> class="current"<? } ?>><a href="my.php?item=activities&amp;type=orig<?=$extrafid?>">我的活动</a></li>
				<li<? if($item == 'debate') { ?> class="current"<? } ?>><a href="my.php?item=debate&amp;type=orig<?=$extrafid?>">我的辩论</a></li>
				<? if($videoopen) { ?>
					<li<? if($item == 'video') { ?> class="current"<? } ?>><a href="my.php?item=video&amp;type=orig<?=$extrafid?>">我的视频</a></li>
				<? } ?>
				<li<? if($item == 'buddylist') { ?> class="current"<? } ?>><a href="my.php?item=buddylist&amp;<?=$extrafid?>">我的好友</a></li>
				<? if($creditspolicy['promotion_visit'] || $creditspolicy['promotion_register']) { ?>
					<li<? if($item == 'promotion') { ?> class="current"<? } ?>><a href="my.php?item=promotion<?=$extrafid?>">我的推广</a></li>
				<? } ?>
				<? if($supe['status'] && $xspacestatus) { ?>
					<li><a href="<?=$supe['siteurl']?>/?uid/<?=$discuz_uid?>" target="_blank">个人空间</a></li>
				<? } elseif($spacestatus) { ?>
					<li><a href="space.php?uid=<?=$discuz_uid?>" target="_blank">个人空间</a></li>
				<? } ?>
			</ul>
		</li>
	<? } else { ?>
		<li><h3><a href="my.php">我的</a></h3></li>
	<? } ?>
	<? if($BASESCRIPT == 'memcp.php') { ?>
		<li class="side_on">
			<h3>控制面板</h3>
			<ul>
			<li<? if(!$action) { ?> class="current"<? } ?>><a href="memcp.php">控制面板首页</a></li>
			<li<? if($action == 'profile') { ?> class="current"<? } ?>><a href="memcp.php?action=profile">编辑个人资料</a></li>
			<? if($exchangestatus || $transferstatus || $ec_ratio) { ?>
				<li<? if($action == 'credits' && in_array($operation, array('exchange', 'transfer', 'addfunds'))) { ?> class="current"<? } ?>><a href="memcp.php?action=credits">积分交易</a></li>
			<? } ?>
			<li<? if($action == 'creditslog' && in_array($operation, array('creditslog', 'paymentlog', 'incomelog', 'rewardpaylog', 'rewardincomelog'))) { ?> class="current"<? } ?>><a href="memcp.php?action=creditslog">积分记录</a></li>
			<? if($allowmultigroups) { ?>
				<li<? if($action == 'usergroups') { ?> class="current"<? } ?>><a href="memcp.php?action=usergroups">公众用户组</a></li>
			<? } ?>
			<? if($spacestatus || $supe['status'] && $xspacestatus) { ?>
				<li><a href="memcp.php?action=spacemodule" target="_blank">个人空间管理</a></li>
			<? } ?>
			<? if($supe['status'] && !$xspacestatus) { ?>
				<li><a href="<?=$supe['siteurl']?>/?uid/<?=$discuz_uid?>" target="_blank">升级个人空间</a></li>
			<? } ?>
			</ul>
		</li>
	<? } else { ?>
		<li><h3><a href="memcp.php">控制面板</a></h3></li>
	<? } ?>
	<? if($regstatus > 1) { ?>
		<? if($BASESCRIPT == 'invite.php') { ?>
			<li class="side_on last">
				<h3>邀请注册</h3>
				<ul>
					<li<? if($action == 'buyinvite') { ?> class="current"<? } ?>><a href="invite.php?action=buyinvite">获得邀请码</a></li>
					<li<? if(in_array($action, array('availablelog', 'invalidlog', 'usedlog', 'sendlog'))) { ?> class="current"<? } ?>><a href="invite.php?action=availablelog">邀请记录</a></li>
				</ul>
			</li>
		<? } else { ?>
			<li><h3><a href="invite.php">邀请注册</a></h3></li>
		<? } ?>
	<? } ?>
	</ul>

</ul>

</div>

<div class="credits_info">
	<h2>积分概况</h2>
	<ul>
		<li>积分: <?=$credits?></li><? if(is_array($extcredits)) { foreach($extcredits as $id => $credit) { ?><li>
			<? if($id == $creditstrans) { ?>
			<?=$credit['title']?>: <span style="font-weight: bold;"><?=$GLOBALS['extcredits'.$id]?></span> <?=$credit['unit']?>
			<? } else { ?>
			<?=$credit['title']?>: <?=$GLOBALS['extcredits'.$id]?> <?=$credit['unit']?>
			<? } ?>
		</li><? } } ?></ul>
</div>
