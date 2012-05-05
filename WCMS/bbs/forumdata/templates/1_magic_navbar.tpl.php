<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div>
	<h2>道具中心</h2>
	<ul>
		<li<? if($action == 'shop') { ?> class="current"<? } ?>><a href="magic.php?action=shop">道具商店</a></li>
		<? if($magicmarket) { ?>
		<li<? if($action == 'market') { ?> class="current"<? } ?>><a href="magic.php?action=market">道具市场</a></li>
		<? } ?>
		<li<? if($action == 'user') { ?> class="current"<? } ?>><a href="magic.php?action=user">我的道具箱</a></li>
		<li><a href="memcp.php?action=credits&amp;operation=addfunds" target="_blank">积分充值</a></li>
	</ul>
	<h2>道具记录</h2>
	<ul>
		<li<? if($operation == 'uselog') { ?> class="current"<? } ?>><a href="magic.php?action=log&amp;operation=uselog">道具使用记录</a></li>
		<li<? if($operation == 'buylog') { ?> class="current"<? } ?>><a href="magic.php?action=log&amp;operation=buylog">道具购买记录</a></li>
		<li<? if($operation == 'givelog') { ?> class="current"<? } ?>><a href="magic.php?action=log&amp;operation=givelog">道具赠送记录</a></li>
		<li<? if($operation == 'receivelog') { ?> class="current"<? } ?>><a href="magic.php?action=log&amp;operation=receivelog">道具获赠记录</a></li>
		<? if($magicmarket) { ?>
		<li<? if($operation == 'marketlog') { ?> class="current"<? } ?>><a href="magic.php?action=log&amp;operation=marketlog">道具市场记录</a></li>
		<? } ?>
	</ul>
	<? if($magicsdiscount || $maxmagicsweight) { ?>
		<h2>其他信息</h2>
		<ul>
		<? if($magicsdiscount) { ?>
			<li>折扣: <?=$magicsdiscount?> 折</li>
		<? } ?>
		<? if($maxmagicsweight) { ?>
			<li>道具负载量: <?=$totalweight?>/<?=$maxmagicsweight?></li>
		<? } ?>
		</ul>
	<? } ?>
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