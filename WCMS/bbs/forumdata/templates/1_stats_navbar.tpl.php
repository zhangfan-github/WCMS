<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div>
	<h2>统计选项</h2>
	<ul>
		<li <?=$navstyle['home']?>><a href="stats.php">基本概况</a></li>
		<? if($statstatus) { ?><li <?=$navstyle['views']?>><a href="stats.php?type=views">流量统计</a></li><? } ?>
		<? if($statstatus) { ?><li <?=$navstyle['agent']?>><a href="stats.php?type=agent">客户软件</a></li><? } ?>
		<? if($statstatus) { ?><li <?=$navstyle['posts']?>><a href="stats.php?type=posts">发帖量记录</a></li><? } ?>
		<li <?=$navstyle['forumsrank']?>><a href="stats.php?type=forumsrank">版块排行</a></li>
		<li <?=$navstyle['threadsrank']?>><a href="stats.php?type=threadsrank">主题排行</a></li>
		<li <?=$navstyle['postsrank']?>><a href="stats.php?type=postsrank">发帖排行</a></li>
		<li <?=$navstyle['creditsrank']?>><a href="stats.php?type=creditsrank">积分排行</a></li>
		<li <?=$navstyle['trade']?>><a href="stats.php?type=trade">交易排行</a></li>
		<? if($oltimespan) { ?><li <?=$navstyle['onlinetime']?>><a href="stats.php?type=onlinetime">在线时间</a></li><? } ?>
		<li <?=$navstyle['team']?>><a href="stats.php?type=team">管理团队</a></li>
		<? if($modworkstatus) { ?><li <?=$navstyle['modworks']?>><a href="stats.php?type=modworks">管理统计</a></li><? } ?>
	</ul>
</div>
