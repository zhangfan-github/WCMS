<? if(!defined('IN_DISCUZ')) exit('Access Denied'); if(!$iscircle || !$sgid) { include template('header'); } else { include template('supesite_header'); } ?>

<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> <?=$navigation?> &raquo; 发表回复</div>

<script type="text/javascript">
var postminchars = parseInt('<?=$minpostsize?>');
var postmaxchars = parseInt('<?=$maxpostsize?>');
var disablepostctrl = parseInt('<?=$disablepostctrl?>');
var bbinsert = parseInt('<?=$bbinsert?>');
var seccodecheck = parseInt('<?=$seccodecheck?>');
var secqaacheck = parseInt('<?=$secqaacheck?>');
lang['board_allowed'] = '系统限制';
lang['lento'] = '到';
lang['bytes'] = '字节';
lang['post_curlength'] = '当前长度';
lang['post_subject_and_message_isnull'] = '请完成标题或内容栏。';
lang['post_subject_toolong'] = '您的标题超过 80 个字符的限制。';
lang['post_message_length_invalid'] = '您的帖子长度不符合要求。';
</script>
<? include template('post_preview'); ?>
<form method="post" id="postform" action="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;replysubmit=yes" <?=$enctype?>>
<input type="hidden" name="formhash" id="formhash" value="<?=FORMHASH?>" />

<div class="mainbox formbox">
	<h1>发表回复</h1>
	<table summary="发表回复" cellspacing="0" cellpadding="0">

		<thead>
			<tr>
				<th>用户名</th>
				<td>
					<? if($discuz_uid) { ?>
						<?=$discuz_userss?> [<a href="<?=$link_logout?>">退出登录</a>]
					<? } else { ?>
						游客 [<a href="<?=$link_login?>">会员登录</a>]
					<? } ?>
				</td>
			</tr>
		</thead>

<? if($seccodecheck) { ?>
	<tr>
		<th><label for="seccodeverify">验证码</label></th>
		<td>
			<div id="seccodeimage"></div>
			<input type="text" onfocus="updateseccode();this.onfocus = null" id="seccodeverify" name="seccodeverify" size="8" maxlength="4" tabindex="0" />
			<em class="tips"><strong>点击输入框显示验证码</strong> <? if($seccodedata['type'] == 2) { ?>请确认您的浏览器支持 Flash 的显示，如果看不清验证码，请点<a href="###" onclick="updateseccode()">这里</a>刷新<? } elseif($seccodedata['animator'] == 1) { ?>请确认您的浏览器支持动画的显示，如果看不清验证码，请点图片刷新<? } else { ?>如果看不清验证码，请点图片刷新<? } ?></em></td>
			<script type="text/javascript">
				var seccodedata = [<?=$seccodedata['width']?>, <?=$seccodedata['height']?>, <?=$seccodedata['type']?>];
			</script>
	</tr>
<? } if($secqaacheck) { ?>
	<tr><th><label for="secanswer">验证问答</label></th>
	<td><div id="secquestion"></div><input type="text" name="secanswer" id="secanswer" size="25" maxlength="50" tabindex="1" />
	<script type="text/javascript">
	<? if(($attackevasive & 1) && $seccodecheck) { ?>
		setTimeout("ajaxget('ajax.php?action=updatesecqaa&inajax=1', 'secquestion')", 2001);
	<? } else { ?>
		ajaxget('ajax.php?action=updatesecqaa&inajax=1', 'secquestion');
	<? } ?>
	</script></td>
	</tr>
<? } if($special == 5) { ?>
	<tr>
	<th>立场</th>
	<td>
	<? if(empty($firststand)) { ?>
		<select name="stand" tabindex="2"><option value="0" selected>中立</option><option  value="1">正方</option><option  value="2">反方</option></select></td>
	<? } elseif($firststand == 1) { ?>
		正方
	<? } elseif($firststand == 2) { ?>
		反方
	<? } ?>

	</tr>
<? } ?>

<tr>
<th><label for="subject">标题</label></th>
<td><input type="text" name="subject" id="subject" size="45" value="<?=$subject?>" tabindex="3" />&nbsp; <em class="tips">(可选)</em></td>
</tr>

<tr class="bottom">
<? include template('post_editor'); ?>
</tr>
		<tr class="btns">
			<th>&nbsp;</th>
			<td>
				<input type="hidden" name="wysiwyg" id="<?=$editorid?>_mode" value="<?=$editormode?>" />
				<input type="hidden" name="fid" id="fid" value="<?=$fid?>" />
				<button type="submit" name="replysubmit" id="postsubmit" value="true" tabindex="300">发表回复</button>
				<em>[完成后可按 Ctrl+Enter 发布]</em>&nbsp;&nbsp;
				&nbsp;<a href="###" id="restoredata" onclick="loadData()" title="恢复上次自动保存的数据">恢复数据</a>
			</td>
		</tr>

</table></div>

</form>

<div class="box">
	<h4>主题回顾</h4>

	<? if($thread['replies'] > $ppp) { ?>
		<div class="specialpost">
			<div class="postmessage">本主题回复较多，请 <a href="viewthread.php?fid=<?=$fid?>&amp;tid=<?=$tid?>">点击这里</a> 查看。</div>
		</div>
	<? } else { if(is_array($postlist)) { foreach($postlist as $post) { ?>			<div class="specialpost">
				<p class="postinfo"><? if($post['author'] && !$post['anonymous']) { ?><?=$post['author']?><? } else { ?>匿名<? } ?> 发表于 <?=$post['dateline']?></p>
				<div class="postmessage"><?=$post['message']?></div>
			</div>
		<? } } } ?>

	</table>
</div>
<? include template('post_js'); if(!$iscircle || !$sgid) { include template('footer'); } else { include template('supesite_footer'); } ?>