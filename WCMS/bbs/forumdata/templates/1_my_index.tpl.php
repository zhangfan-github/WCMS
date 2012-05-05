<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<h1>我的</h1>

<div class="msgtabs"><strong>最近的五条主题</strong></div>
<table cellspacing="0" cellpadding="0" width="100%">
<thead>
<tr>
<td style="width: 50%">标题</td>
<td class="time">版块</td>
<td class="time">最后发表</td>
<td width="40">状态</td>
</tr>
</thead>
<tbody>
<? if($threadlist) { if(is_array($threadlist)) { foreach($threadlist as $thread) { ?>		<tr>
		<td><? if($thread['displayorder'] >= 0) { ?><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><?=$thread['subject']?></a><? } else { ?><?=$thread['subject']?><? } ?></td>
		<td><a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$thread['forumname']?></a></td>
		<td><cite><a href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost#lastpost"><?=$thread['lastpost']?></a><br /> by <? if($thread['lastposter']) { ?><a href="space.php?username=<?=$thread['lastposterenc']?>" target="_blank"><?=$thread['lastposter']?></a><? } else { ?>匿名<? } ?></cite></td>
		<td><? if($thread['displayorder'] == '-1') { ?>回收站<? } elseif($thread['displayorder'] == '-2') { ?>待审核<? } elseif($thread['closed'] == '1') { ?>关闭<? } else { ?>正常<? } ?></td>
		</tr>
	<? } } } else { ?>
	<tr><td colspan="4">本版块或指定的范围内尚无主题。</td></tr>
<? } ?>
</tbody>
</table>
<div class="msgtabs"><strong>最近的五条回复</strong></div>
<table cellspacing="0" cellpadding="0" width="100%">
<thead>
<tr>
<td style="width: 50%">所在主题</td>
<td class="time">版块</td>
<td class="time">最后发表</td>
<td width="40">状态</td>
</tr>
</thead>
<tbody>
<? if($postlist) { if(is_array($postlist)) { foreach($postlist as $post) { ?>		<tr>
		<td><? if($post['invisible'] == 0) { ?><a href="redirect.php?goto=findpost&amp;pid=<?=$post['pid']?>&amp;ptid=<?=$post['tid']?>" target="_blank"><? if($post['subject']) { ?><?=$post['subject']?><? } else { ?>无标题<? } ?></a><? } else { if($post['subject']) { ?><?=$post['subject']?><? } else { ?>无标题<? } } ?></td>
		<td><a href="forumdisplay.php?fid=<?=$post['fid']?>" target="_blank"><?=$post['forumname']?></a></td>
		<td><cite><a href="redirect.php?tid=<?=$post['tid']?>&amp;goto=lastpost#lastpost"><?=$post['lastpost']?></a><br /> by <? if($post['lastposter']) { ?><a href="space.php?username=<?=$post['lastposterenc']?>" target="_blank"><?=$post['lastposter']?></a><? } else { ?>匿名<? } ?></cite></td>
		<td><? if($post['invisible'] == '-1') { ?>待删除<? } elseif($post['invisible'] == '2') { ?>待删除<? } else { ?>正常<? } ?></td>
		</tr>
	<? } } } else { ?>
	<tr><td colspan="4">本版块或指定的范围内尚无主题。</td></tr>
<? } ?>
</tbody>
</table>