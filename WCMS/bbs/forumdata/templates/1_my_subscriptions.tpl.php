<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<form method="post" action="my.php?item=subscriptions">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />

<table cellspacing="0" cellpadding="0" width="100%" summary="订阅的主题">
<thead>
<tr>
<td width="48"><input type="checkbox" name="chkall" class="header checkbox" onclick="checkall(this.form)" />删?</td>
<td>标题</td>
<td>版块</td>
<td>回复</td>
<td>最后发表</td>
</tr>
</thead>
<tbody>
<? if($subslist) { if(is_array($subslist)) { foreach($subslist as $subs) { ?>		<tr>
		<td><input class="checkbox" type="checkbox" name="delete[]" value="<?=$subs['tid']?>" /></td>
		<td><a href="viewthread.php?tid=<?=$subs['tid']?>" target="_blank"><?=$subs['subject']?></a></td>
		<td><a href="forumdisplay.php?fid=<?=$subs['fid']?>" target="_blank"><?=$subs['name']?></a></td>
		<td><?=$subs['replies']?></td>
		<td><cite><a href="redirect.php?tid=<?=$subs['tid']?>&amp;goto=lastpost#lastpost"><?=$subs['lastpost']?></a> by <? if($subs['lastposter']) { ?><a href="space.php?username=<?=$subs['lastposterenc']?>" target="_blank"><?=$subs['lastposter']?></a><? } else { ?>匿名<? } ?></cite></td>
		</tr>
	<? } } } else { ?>
	<tr><td colspan="5">目前没有被订阅的主题。</td></tr>
<? } ?>

</table>
<p class="btns"><button type="submit" class="submit" name="subsubmit" value="true">提交</button></p>

</form>