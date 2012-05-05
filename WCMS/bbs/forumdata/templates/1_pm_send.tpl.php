<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<form method="post" id="postform" action="pm.php?action=send&amp;pmsubmit=yes" onSubmit="return validate(this)">
	<? if($folder == 'outbox') { ?><input type="hidden" name="pmid" value="<?=$pmid?>" /><? } ?>
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<div class="mainbox formbox">
	<h1>发送短消息</h1>
	<ul class="tabs">
		<li class="current sendpm"><a href="pm.php?action=send">发送短消息</a></li>
		<li><a href="pm.php?folder=inbox">收件箱[<span id="pm_unread"><?=$pm_inbox_newpm?></span>]</a></li>
		<li><a href="pm.php?folder=outbox">草稿箱</a></li>
		<li><a href="pm.php?folder=track">已发送</a></li>
		<li><a href="pm.php?action=search">搜索短消息</a></li>
		<li><a href="pm.php?action=archive">导出短消息</a></li>
		<li><a href="pm.php?action=ignore">忽略列表</a></li>
	</ul>
	<table summary="发送短消息" cellspacing="0" cellpadding="0" id="pmlist">
		<? if($seccodecheck) { ?>
			<tr>
				<th><label for="seccodeverify">验证码</label></th>
				<td>
					<div id="seccodeimage"></div>
					<input type="text" onfocus="updateseccode();this.onfocus = null" id="seccodeverify" name="seccodeverify" size="8" maxlength="4" />
					<em class="tips"><strong>点击输入框显示验证码</strong> <? if($seccodedata['type'] == 2) { ?>请确认您的浏览器支持 Flash 的显示，如果看不清验证码，请点<a href="###" onclick="updateseccode()">这里</a>刷新<? } elseif($seccodedata['animator'] == 1) { ?>请确认您的浏览器支持动画的显示，如果看不清验证码，请点图片刷新<? } else { ?>如果看不清验证码，请点图片刷新<? } ?></em></td>
					<script type="text/javascript">
						var seccodedata = [<?=$seccodedata['width']?>, <?=$seccodedata['height']?>, <?=$seccodedata['type']?>];
					</script>
			</tr>
		<? } ?>

		<? if($secqaacheck) { ?>
			<tr>
			<th>验证问答</th>
			<td><div id="secquestion"></div><input type="text" name="secanswer" size="25" maxlength="50" tabindex="1" /></td>
			</tr>
			<script type="text/javascript">
			<? if(($attackevasive & 1) && $seccodecheck) { ?>
				setTimeout("updatesecqaa()", 2001);
			<? } else { ?>
				updatesecqaa();
			<? } ?>
			</script>
		<? } ?>

		<tr>
			<th><label for="msgto">发送到</label></th>
			<td><input type="text" id="msgto" name="msgto" size="65" value="<?=$touser?>" tabindex="2" /></td>
		</tr>

		<? if($buddylist) { ?>
		<tr>
			<th id="buddy"><label><input class="checkbox" type="checkbox" name="chkall" onclick="checkall(this.form, 'msgtobuddys')" tabindex="3" />好友群发</label></th>
			<td>
				<ul class="userlist"><? if(is_array($buddylist)) { foreach($buddylist as $key => $buddy) { ?><li><label><input class="checkbox" type="checkbox" name="msgtobuddys[]" value="<?=$buddy['buddyid']?>" /> <?=$buddy['buddyname']?></label></li><? } } ?></ul>
			</td>
		</tr>
		<? } ?>

		<tr>
			<th><label for="subject">标题</th>
			<td><input type="text" id="subject" name="subject" size="65" value="<?=$subject?>" tabindex="4" /></td>
		</tr>

		<tr>
			<th valign="top"><label for="pm_textarea">内容</label>
				<? if($smileyinsert) { ?>
					<div id="smilieslist"></div>
					<script type="text/javascript">ajaxget('post.php?action=smilies', 'smilieslist');</script>
				<? } ?>
			</th>
			<td><textarea id="pm_textarea" class="autosave" rows="15" cols="10" name="message" style="width: 95%;" onKeyDown="ctlent(event);" tabindex="5">
<? if($do == 'reply') { ?>[b]原始短消息:[/b] [url=<?=$boardurl?>pm.php?action=view&folder=inbox&pmid=<?=$pm['pmid']?>]<?=$pm['subject']?>[/url]<?="\n"?>
<? } elseif($do == 'forward') { ?>
[b]原始短消息[/b] [url=<?=$boardurl?>pm.php?action=send&pmid=<?=$pm['pmid']?>&do=reply](回复)[/url]
[b]来自:[/b] [url=<?=$boardurl?>space.php?uid=<?=$pm['msgfromid']?>]<?=$pm['msgfrom']?>[/url]
[b]发送到:[/b] [url=<?=$boardurl?>space.php?uid=<?=$discuz_uid?>]<?=$discuz_user?>[/url]
[b]时间:[/b] <?=$pm['dateline']?><?="\n"?><?="\n"?>
<? } ?><?=$message?></textarea>
					<br /><label><input type="checkbox" name="saveoutbox" value="1"<? if($folder == 'outbox') { ?> checked=checked""<? } ?> tabindex="6" />不发送，只保存到草稿箱中</label>
			</td>
		</tr>

		<tr class="btns">
			<th>&nbsp;</th>
			<td>
				<button type="submit" class="submit" name="pmsubmit" id="postsubmit" value="true" tabindex="7">提交</button>
				<em>[完成后可按 Ctrl+Enter 发布]</em>
				&nbsp;<a href="###" id="restoredata" onclick="loadData()" title="恢复上次自动保存的数据">恢复数据</a>
			</td>
		</tr>
</table>
</div>
</form>
<script src="include/javascript/post.js" type="text/javascript"></script>
<script type="text/javascript">
	var wysiwyg = bbinsert = 0;
	lang['post_autosave_none'] = "没有可以恢复的数据！";
	lang['post_autosave_confirm'] = "此操作将覆盖当前帖子内容，确定要恢复数据吗？";
	function validate(theform) {
		if (theform.subject.value == '' || theform.message.value == '') {
			alert("请完成标题或内容栏。");
			theform.subject.focus();
			return false;
		} else if (theform.subject.value.length > 75) {
			alert("您的标题超过 80 个字符的限制。");
			theform.subject.focus();
			return false;
		}
		theform.message.value = parseurl(theform.message.value, 'bbcode');
		theform.pmsubmit.disabled = true;
		return true;
	}
	checkFocus();
	setCaretAtEnd();
	var textobj = $('pm_textarea');
	if(!(is_ie >= 5 || is_moz >= 2)) {
		$('restoredata').style.display = 'none';
	}
</script>