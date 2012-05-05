<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<span class="headactions"><img id="subforum_<?=$forum['fid']?>_img" src="<?=IMGDIR?>/<?=$collapseimg['subforum']?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('subforum_<?=$forum['fid']?>');" /></span>
<h3>子版块</h3>
<table id="subforum_<?=$forum['fid']?>" summary="subform" cellspacing="0" cellpadding="0" style="<?=$collapse['subforum']?>">
<? if(!$forum['forumcolumns']) { ?>
	<thead class="category">
		<tr>
			<th>版块</th>
			<td class="nums">主题</td>
			<td class="nums">帖数</td>
			<td class="lastpost">最后发表</td>
		</tr>
	</thead><? if(is_array($sublist)) { foreach($sublist as $sub) { ?>		<? if($sub['permission']) { ?>
			<tbody>
				<tr>
					<th<?=$sub['folder']?>>
						<?=$sub['icon']?>
						<h2><a href="forumdisplay.php?fid=<?=$sub['fid']?>"><?=$sub['name']?></a><? if($sub['todayposts']) { ?> <em>(今日: <?=$sub['todayposts']?>)</em><? } ?></h2>
						<? if($sub['description']) { ?><p><?=$sub['description']?></p><? } ?>
						<? if($sub['moderators']) { if($moddisplay == 'flat') { ?><p class="moderators">版主: <?=$sub['moderators']?></p><? } else { ?><span class="dropmenu" id="mod<?=$sub['fid']?>" onmouseover="showMenu(this.id)">版主</span><ul class="moderators popupmenu_popup" id="mod<?=$sub['fid']?>_menu" style="display: none"><?=$sub['moderators']?></ul><? } } ?>
					</th>
					<td class="nums"><?=$sub['threads']?></td>
					<td class="nums"><?=$sub['posts']?></td>
					<td class="lastpost">
					<? if($sub['permission'] == 1) { ?>
						私密版块
					<? } else { ?>
						<? if(is_array($sub['lastpost'])) { ?>
							<a href="redirect.php?tid=<?=$sub['lastpost']['tid']?>&amp;goto=lastpost#lastpost"><?=$sub['lastpost']['subject']?></a>
							<cite>by <? if($sub['lastpost']['author']) { ?><?=$sub['lastpost']['author']?><? } else { ?>匿名<? } ?> - <?=$sub['lastpost']['dateline']?></cite>
						<? } else { ?>
							从未
						<? } ?>
					<? } ?>
					</td>
				</tr>
			</tbody>
		<? } ?>
	<? } } } else { ?>
	<tr><? if(is_array($sublist)) { foreach($sublist as $sub) { ?>		<? if($sub['orderid'] && ($sub['orderid'] % $forum['forumcolumns'] == 0)) { ?>
			</tr></tbody>
			<? if($sub['orderid'] < $forum['subscount']) { ?>
				<tbody><tr>
			<? } ?>
		<? } ?>
		<th width="<?=$forum['forumcolwidth']?>"<?=$sub['folder']?>>
			<h2><a href="forumdisplay.php?fid=<?=$sub['fid']?>"><?=$sub['name']?></a><? if($sub['todayposts']) { ?><em> (今日: <?=$sub['todayposts']?>)</em><? } ?></h2>
			<p>
				最后发表:
				<? if(is_array($sub['lastpost'])) { ?>
					<a href="redirect.php?tid=<?=$sub['lastpost']['tid']?>&amp;goto=lastpost#lastpost"><?=$sub['lastpost']['dateline']?></a>
					by <? if($sub['lastpost']['author']) { ?><?=$sub['lastpost']['author']?><? } else { ?>匿名<? } ?>
				<? } else { ?>
					从未
				<? } ?>
			</p>
			<p>主题:<?=$sub['threads']?>, 帖数: <?=$sub['posts']?></p>
		</th>
	<? } } ?><?=$forum['endrows']?>
<? } ?>
</table>