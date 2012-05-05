<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 在线用户</div>

<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } ?>
<div class="mainbox">
	<h1>在线用户</h1>
<? if($allowviewip) { ?>
	<table summary="" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td>用户名</td>
				<td class="time">时间</td>
				<td>当前动作</td>
				<td>所在版块</td>
				<td>所在主题</td>
				<td class="time">IP 地址</td>
			</tr>
		</thead><? if(is_array($onlinelist)) { foreach($onlinelist as $online) { ?>		<tbody>
			<tr>
				<td><? if($online['uid']) { ?><a href="space.php?uid=<?=$online['uid']?>"><?=$online['username']?></a><? } else { ?>游客<? } ?>&nbsp;</td>
				<td class="time"><?=$online['lastactivity']?>&nbsp;</td>
				<td><?=$online['action']?>&nbsp;</td>
				<td><? if($online['fid']) { ?><a href="forumdisplay.php?fid=<?=$online['fid']?>"><?=$online['name']?></a><? } ?>&nbsp;</td>
				<td><? if($online['tid']) { ?><a href="viewthread.php?tid=<?=$online['tid']?>"><?=$online['subject']?></a><? } ?>&nbsp;</td>
				<td><?=$online['ip']?>&nbsp;</td>
			</tr>
		</tbody>
		<? } } ?></table>
<? } else { ?>
	<table summary="" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td>用户名</td>
				<td class="time">时间</td>
				<td>当前动作</td>
				<td>所在版块</td>
				<td>所在主题</td>
			</tr>
		</thead><? if(is_array($onlinelist)) { foreach($onlinelist as $online) { ?>		<tbody>
			<tr>
				<td><? if($online['uid']) { ?><a href="space.php?uid=<?=$online['uid']?>"><?=$online['username']?></a><? } else { ?>游客<? } ?>&nbsp;</td>
				<td class="time"><?=$online['lastactivity']?>&nbsp;</td>
				<td><?=$online['action']?>&nbsp;</td>
				<td><? if($online['fid']) { ?><a href="forumdisplay.php?fid=<?=$online['fid']?>"><?=$online['name']?></a><? } ?>&nbsp;</td>
				<td><? if($online['tid']) { ?><a href="viewthread.php?tid=<?=$online['tid']?>"><?=$online['subject']?></a><? } ?>&nbsp;</td>
			</tr>
		</tbody>
		<? } } ?></table>
<? } ?>
</div>
<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } include template('footer'); ?>
