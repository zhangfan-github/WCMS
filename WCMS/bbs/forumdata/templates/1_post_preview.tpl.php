<? if(!defined('IN_DISCUZ')) exit('Access Denied'); if(empty($showpreview)) { ?>
<div class="mainbox viewthread" id="previewtable" style="display: <?=$previewdisplay?>">
	<h1>预览帖子</h1>
	<table summary="预览帖子" cellspacing="0" cellpadding="0">
		<tr>
			<td class="postauthor">
				<? if($action == 'edit') { ?>
					<? if($postinfo['authorid']) { ?><a href="space.php?uid=<?=$postinfo['authorid']?>"><?=$postinfo['author']?></a><? } else { ?>游客<? } ?>
				<? } else { ?>
					<? if($discuz_uid) { ?><?=$discuz_userss?><? } else { ?>游客<? } ?>
				<? } ?>
			</td>
			<td class="postcontent">
				<div class="postmessage" id="previewmessage">
					<h2><?=$subject?></h2>
					<?=$message_preview?>
				</div>
			</td>
		</tr>
	</table>
	</div>
<br />
<? } ?>