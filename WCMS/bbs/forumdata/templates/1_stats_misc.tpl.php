<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <a href="stats.php">论坛统计</a>
&raquo;
<? if($type == 'views') { ?>
	流量统计
<? } elseif($type == 'agent') { ?>
	客户软件
<? } elseif($type == 'posts') { ?>
	发帖量记录
<? } elseif($type == 'forumsrank') { ?>
	版块排行
<? } elseif($type == 'threadsrank') { ?>
	主题排行
<? } elseif($type == 'postsrank') { ?>
	发帖排行
<? } elseif($type == 'creditsrank') { ?>
	积分排行
<? } elseif($type == 'modworks') { ?>
	管理统计
<? } ?>
</div>
<div class="container">
<div class="side">
<? include template('stats_navbar'); ?>
</div>
<div class="content">
<div class="mainbox">
<? if($type == 'views') { ?>
	<h1>流量统计</h1>
	<table summary="星期流量" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<td colspan="2">星期流量</td>
			</tr>
		</thead>
		<?=$statsbar_week?>
		<thead>
			<tr>
				<td colspan="2">时段流量</td>
			</tr>
		</thead>
		<?=$statsbar_hour?>
	</table>

<? } elseif($type == 'agent') { ?>
	<h1>客户软件</h1>
	<table summary="客户软件" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<td colspan="2">操作系统</td>
			</tr>
		</thead>
		<?=$statsbar_os?>
		<thead>
			<tr>
				<td colspan="2">浏览器</td>
			</tr>
		</thead>
		<?=$statsbar_browser?>
	</table>

<? } elseif($type == 'posts') { ?>
	<h1>发帖量记录</h1>
	<table summary="发帖量记录" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<td colspan="2">每月新增帖子记录</td>
			</tr>
		</thead>
		<?=$statsbar_monthposts?>
		<thead>
			<tr>
				<td colspan="2">每日新增帖子记录</td>
			</tr>
		</thead>
		<?=$statsbar_dayposts?>
	</table>

<? } elseif($type == 'forumsrank') { ?>
	<h1>版块排行</h1>
	<table summary="版块排行" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td colspan="2">发帖 排行榜</td>
				<td colspan="2">回复 排行榜</td>
				<td colspan="2">最近 30 天发帖 排行榜</td>
				<td colspan="2">最近 24 小时发帖 排行榜</td>
			</tr>
		</thead>
		<?=$forumsrank?>
	</table>

<? } elseif($type == 'threadsrank') { ?>
	<h1>主题排行</h1>
	<table summary="主题排行" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td colspan="2">被浏览最多的主题</td>
				<td colspan="2">被回复最多的主题</td>
			</tr>
		</thead>
		<?=$threadsrank?>
	</table>

<? } elseif($type == 'postsrank') { ?>
	<h1>发帖排行</h1>
	<table summary="发帖排行" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td colspan="2">发帖 排行榜</td>
				<td colspan="2">精华帖 排行榜</td>
				<td colspan="2">最近 30 天发帖 排行榜</td>
				<td colspan="2">最近 24 小时发帖 排行榜</td>
			</tr>
		</thead>
		<?=$postsrank?>
		</table>

<? } elseif($type == 'creditsrank') { ?>
	<h1>积分排行</h1>
	<table summary="积分排行" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td colspan="2">积分 排行榜</td><? if(is_array($arrextcredits['0'])) { foreach($arrextcredits['0'] as $id => $credit) { ?><td colspan="2"><?=$credit['title']?> 排行榜</td><? } } ?></tr>
		</thead>

	<?=$creditsrank['0']?>
	</td></table>
	<br />
	<? if(!empty($arrextcredits['1'])) { ?>
		<table summary="积分排行" cellpadding="0" cellspacing="0">
			<thead>
				<tr><? if(is_array($arrextcredits['1'])) { foreach($arrextcredits['1'] as $id => $credit) { ?><td colspan="2"><?=$credit['title']?> 排行榜</td><? } } ?></tr>
			</thead>

		<?=$creditsrank['1']?>
		</td></table>
	<? } ?>
	</div>

<? } elseif($type == 'modworks' && $uid) { ?>

	<h1>管理统计 - <?=$member['username']?></h1>
	<table width="100%" cellpadding="0" cellspacing="0">
	<thead>
	<tr align=center><td width="8%">时间</td><? if(is_array($modactioncode)) { foreach($modactioncode as $key => $val) { ?><td width="<?=$tdwidth?>"><?=$val?></td><? } } ?></tr>
	</thead>
	<tbody><? if(is_array($modactions)) { foreach($modactions as $day => $modaction) { ?><tr align="center">
		<td><em class="tips"><?=$day?></em></td><? if(is_array($modactioncode)) { foreach($modactioncode as $key => $val) { if($modaction[$key]['posts']) { ?><td title="帖子: <?=$modaction[$key]['posts']?>"><?=$modaction[$key]['count']?><? } else { ?><td>&nbsp;<? } ?></td><? } } ?></tr><? } } ?></tbody>
	<tr ><td colspan="<?=$tdcols?>"></td></tr>
	<tr align="center">
	<td>本月管理</td><? if(is_array($modactioncode)) { foreach($modactioncode as $key => $val) { ?><td class="<?=$bgarray[$key]?>" <? if($totalactions[$key]['posts']) { ?>title="帖子: <?=$totalactions[$key]['posts']?>"<? } ?>><?=$totalactions[$key]['count']?></td><? } } ?></tr>
	</table>


	<table cellspacing="0" cellpadding="4" border="0" width="100%%" align="center" class="tips">
	<tr><td align="right">月份: <? if(is_array($monthlinks)) { foreach($monthlinks as $link) { ?> &nbsp;<?=$link?>&nbsp; <? } } ?></td></tr></table><br />


<? } elseif($type == 'modworks') { ?>

	<h1>管理统计 - 全体管理人员</h1>
	<table width="100%" cellpadding="0" cellspacing="0">
	<thead>
	<tr align=center><td width="8%">用户名</td><? if(is_array($modactioncode)) { foreach($modactioncode as $key => $val) { ?><td width="<?=$tdwidth?>"><?=$val?></td><? } } ?></tr>
	</thead>
	<tbody><? if(is_array($members)) { foreach($members as $uid => $member) { ?><tr align="center">
		<td><a href="stats.php?type=modworks&amp;before=<?=$before?>&amp;uid=<?=$uid?>" title="查看详细管理统计"><?=$member['username']?></a></td><? if(is_array($modactioncode)) { foreach($modactioncode as $key => $val) { if($member[$key]['posts']) { ?><td title="帖子: <?=$member[$key]['posts']?>"><em class="tips"><?=$member[$key]['count']?></em><? } else { ?><td>&nbsp;<? } ?></td><? } } ?></tr><? } } ?></tbody>
	</table>

	<table cellspacing="0" cellpadding="4" border="0" width="95%" align="center" class="tips">
	<tr><td align="right">月份: <? if(is_array($monthlinks)) { foreach($monthlinks as $link) { ?> &nbsp;<?=$link?>&nbsp; <? } } ?></td></tr></table><br />
<? } ?>

			</div>
			<? if($type == 'forumsrank') { ?><div class="notice">统计数据已被缓存，上次于 <?=$lastupdate?> 被更新，下次将于 <?=$nextupdate?> 进行更新</div><? } ?>
		</div>
	</div>
<? include template('footer'); ?>
