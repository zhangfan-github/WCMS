<? if(!defined('IN_DISCUZ')) exit('Access Denied'); if(!$iscircle || !$sgid) { include template('header'); } else { include template('supesite_header'); } ?>

<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> <?=$navigation?> &raquo; <? if($special == 1) { ?>发新投票<? } elseif($special == 3) { ?>发起悬赏<? } elseif($special == 5) { ?>发表辩论<? } else { ?>发新话题<? } ?></div>

<? if($special == 4 || $special == 5) { ?>
	<script src="include/javascript/calendar.js" type="text/javascript"></script>
<? } ?>
<script type="text/javascript">
var postminchars = parseInt('<?=$minpostsize?>');
var postmaxchars = parseInt('<?=$maxpostsize?>');
var disablepostctrl = parseInt('<?=$disablepostctrl?>');
var typerequired = parseInt('<?=$forum['threadtypes']['required']?>');
var bbinsert = parseInt('<?=$bbinsert?>');
var seccodecheck = parseInt('<?=$seccodecheck?>');
var secqaacheck = parseInt('<?=$secqaacheck?>');
var special = parseInt('<?=$special?>');
var isfirstpost = 1;
var allowposttrade = parseInt('<?=$allowposttrade?>');
var allowpostreward = parseInt('<?=$allowpostreward?>');
var allowpostactivity = parseInt('<?=$allowpostactivity?>');
lang['board_allowed'] = '系统限制';
lang['lento'] = '到';
lang['bytes'] = '字节';
lang['post_curlength'] = '当前长度';
lang['post_subject_and_message_isnull'] = '请完成标题或内容栏。';
lang['post_subject_toolong'] = '您的标题超过 80 个字符的限制。';
lang['post_message_length_invalid'] = '您的帖子长度不符合要求。';
lang['post_type_isnull'] = '请选择主题对应的分类。';
lang['post_reward_credits_null'] = '对不起，您输入悬赏积分。';
</script>
<? include template('post_preview'); ?>
<form method="post" id="postform" action="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;topicsubmit=yes" <?=$enctype?>>
	<input type="hidden" name="formhash" id="formhash" value="<?=FORMHASH?>" />
	<input type="hidden" name="isblog" value="<?=$isblog?>" />
	<input type="hidden" name="frombbs" value="1" />
	<? if($special) { ?>
		<input type="hidden" name="special" value="<?=$special?>" />
	<? } ?>

	<div class="mainbox formbox">
		<span class="headactions"><a class="notabs" href="member.php?action=credits&amp;view=forum_post&amp;fid=<?=$fid?>" target="_blank">查看积分策略说明</a></span>
		<h1><? if($special == 1) { ?>发新投票<? } elseif($special == 3) { ?>发起悬赏<? } elseif($special == 5) { ?>发表辩论<? } else { ?>发新话题<? } ?></h1>
		<table summary="post" cellspacing="0" cellpadding="0" id="newpost">
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
		<? } ?>

		<? if($secqaacheck) { ?>
			<tr><th><label for="secanswer">验证问答</label></th>
			<td><div id="secquestion"></div><input type="text" name="secanswer" id="secanswer" size="25" maxlength="50" tabindex="1" />
			<script type="text/javascript">ajaxget('ajax.php?action=updatesecqaa', 'secquestion');</script></td>
			</tr>
		<? } ?>

		<? if($special == 3 && $allowpostreward) { ?>
			<tr>
				<th>悬赏价格<? if(!empty($extcredits[$creditstrans]['title'])) { ?>(<?=$extcredits[$creditstrans]['title']?>)<? } ?></th>
				<td><input onkeyup="getrealprice(this.value)" type="text" name="rewardprice" size="6" value="<?=$minrewardprice?>" tabindex="2" /> <em class="tips">
			税后支付: <span id="realprice">0</span>  <?=$extcredits[$creditstrans]['unit']?> (最低 <?=$minrewardprice?> <?=$extcredits[$creditstrans]['unit']?><? if($maxrewardprice > 0) { ?> - <?=$maxrewardprice?> <?=$extcredits[$creditstrans]['unit']?><? } ?></em>)
			</td>
			</tr>
			<script type="text/javascript">
				$('realprice').innerHTML = parseInt($('postform').rewardprice.value) + parseInt(Math.ceil( $('postform').rewardprice.value * <?=$creditstax?> ));
				function getrealprice(price){
					if(!price.search(/^\d+$/) ) {
						n = Math.ceil(parseInt(price) + price * <?=$creditstax?>);
						if(price > 32767) {
							$('realprice').innerHTML = '<b>售价不能高于 32767</b>';
						} else if(price < <?=$minrewardprice?> || (<?=$maxrewardprice?> > 0 && price > <?=$maxrewardprice?>)) {
							$('realprice').innerHTML = '<b>售价超出范围</b>';
						} else {
							$('realprice').innerHTML = n;
						}
					}else{
						$('realprice').innerHTML = '<b>填写无效</b>';
					}
				}
			</script>
		<? } ?>

		<tr>
			<th style="border-bottom: 0"><label for="subject">标题</label></th>
			<td style="border-bottom: 0">
				<? if($iscircle && $mycircles) { ?>
					<select name='sgid'>
						<option value="0">请选择圈子</option><? if(is_array($mycircles)) { foreach($mycircles as $id => $name) { ?><option value="<?=$id?>"><?=$name?></option><? } } ?></select>
				<? } else { ?>
					<?=$typeselect?>
				<? } ?>
				<input type="text" name="subject" id="subject" size="45" value="<?=$subject?>" tabindex="3" />

			</td>
		</tr>

		<tbody id="threadtypes"></tbody>

		<? if($special == 6 && $allowpostvideo) { ?>
			<tr>
				<th style="border-bottom: 0" valign="top">
					<label for="uploaddiv"><input type="radio" name="visup" value="1" checked="checked" onclick="$('uploaddiv').innerHTML = getVideoPlayer(0)">发布视频</label><br />
					<label for="recorddiv"><input type="radio" name="visup" value="0" onclick="$('uploaddiv').innerHTML = getVideoPlayer(1)">录制视频</label>
					</th>
				<td style="border-bottom: 0">
					<div id="uploaddiv"></div>
					<input type="checkbox" name="vautoplay" value="1">自动播放
					<input type="checkbox" name="vshare" value="1" checked>允许分享
					 <br /><em>最大上限: 100M</em>
					 <br /><em>支持格式: .flv .mpg .m4v .mpeg .mpe .vod .wmv .wm .rm .rmvb .avi .asx .ra .ram .asf .3gp .mov .mp4</em>
					<input type="hidden" name="vid" id="vid" />
					<input type="hidden" name="subjectu8" id="subjectu8">
					<input type="hidden" name="tagsu8" id="tagsu8"><? $vcode = urlencode(authcode('siteurl='.$boardurl.'&uid='.$discuz_uid, 'ENCODE', "$vkey")); ?><script type="text/javascript">
					function setVideoInfo(vid) {
						$('vid').value = vid;
					}
					function getVideoPlayer(isup) {
						if(!isup) {
							var s = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="351" height="30" title="aa" id="vidPlayer">';
							s += '<param name="movie" value=\'http://union.bokecc.com/flash/discuz2/VideoDuke.swf?siteid=<?=$vsiteid?>&code=<?=$vcode?>\'/>';
							s += '<param name="quality" value="high" />';
							s += '<param name="allowScriptAccess" value="always" />';
							s += '<param name="allownetworking" value="all" />';
							s += '<embed src=\'http://union.bokecc.com/flash/discuz2/VideoDuke.swf?siteid=<?=$vsiteid?>&code=<?=$vcode?>\' quality="high" allowScriptAccess="always" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="351" height="30"></embed>';
							s += '</object>';
						} else {
							var s = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="351" height="237" title="aa" id="vidPlayer">';
							s += '<param name="movie" value=\'http://union.bokecc.com/flash/discuz2/VideoRecord.swf?siteid=<?=$vsiteid?>&code=<?=$vcode?>\'/>';
							s += '<param name="quality" value="high" />';
							s += '<param name="allowScriptAccess" value="always" />';
							s += '<param name="allownetworking" value="all" />';
							s += '<embed src=\'http://union.bokecc.com/flash/discuz2/VideoRecord.swf?siteid=<?=$vsiteid?>&code=<?=$vcode?>\' quality="high" allowScriptAccess="always" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="351" height="237"></embed>';
							s += '</object>';
						}
						return s;
					}
					$('uploaddiv').innerHTML = getVideoPlayer(0);
					</script>
				</td>
			</tr>
			<tr>
				<th style="border-bottom: 0" valign="top">视频分类</th>
				<td style="border-bottom: 0" valign="top"><?=$vclassesselect?></td>
			</tr>
		<? } ?>

		<? if($special == 1 && $allowpostpoll) { ?>
			<tr>
				<th><label for="expiration">有效记票天数</label></th>
				<td><input type="text" name="expiration" id="expiration" value="0" size="6" tabindex="4" /><em class="tips">(0或空为不限制)</em></td>
			</tr>
			<tr>
			<th valign="top">投票选项<br />
			每行填写 1 个选项<br />最多可填写 <?=$maxpolloptions?> 个选项<br /><br />
			<input type="checkbox" name="visiblepoll" value="1" /> 提交投票后结果才可见<br />
			<input type="checkbox" name="multiplepoll" value="1" onclick="this.checked?$('maxchoicescontrol').style.display='':$('maxchoicescontrol').style.display='none';" /> 多选投票<br />
			<span id="maxchoicescontrol" style="display: none">最多可选项数: <input type="text" name="maxchoices" value="<?=$maxpolloptions?>" size="5"><br /></span>
			</th><td>
			<textarea rows="8" name="polloptions" style="width: 600px; word-break: break-all" tabindex="5"><?=$polloptions?></textarea></td>
			</tr>
		<? } ?>

		<tr>
<? include template('post_editor'); ?>
</tr>

		<? if($tagstatus) { ?>
			<tr>
				<th><label for="tags">标签(TAG)</label></th>
				<td>
					<input size="45" type="input" id="tags" name="tags" value="" tabindex="200" />&nbsp;
					<button onclick="relatekw();return false">可用标签</button><span id="tagselect"></span>
					<em class="tips">(用逗号或空格隔开多个标签，最多可填写 <strong>5</strong> 个)</em>
				</td>
			</tr>
		<? } ?>

		<? if($special == 5) { ?>
			<tr>
			<th><label class="affirmpoint">正方观点</label></th>
			<td><textarea name="affirmpoint" id="affirmpoint" rows="10" cols="20" style="width:99%; height:60px" tabindex="201" onkeydown="ctlent(event)"></textarea></td>
			</tr>
			<tr>
			<th><label class="negapoint">反方观点</label></th>
			<td><textarea name="negapoint" id="negapoint" rows="10" cols="20" style="width:99%; height:60px" tabindex="202" onkeydown="ctlent(event)"></textarea></td>
			</tr>
		<? } ?>

		<thead>
			<tr>
				<th>&nbsp;</th>
				<td><label><input id="advshow" class="checkbox" type="checkbox" onclick="showadv()" tabindex="203" />其他信息</label></td>
			</tr>
		</thead>
		<tbody id="adv" style="display: none">

			<? if($special == 5) { ?>
				<tr>
				<th><label for="endtime">结束时间</label></th>
				<td><input onclick="showcalendar(event, this, true)" type="text" name="endtime" size="45" value="" tabindex="204" /></td>
				</tr>
				<tr>
				<th><label for="umpire">裁判</label></th>
				<td><input type="text" name="umpire" id="umpire" size="45" tabindex="205" onblur="checkuserexists(this.value, 'checkuserinfo')" value="<?=$discuz_user?>" /><span id="checkuserinfo"></span></td>
				</tr>
			<? } ?>

			<? if($allowsetreadperm) { ?>
				<tr>
					<th><label for="readperm">所需阅读权限</label></th>
					<td><input type="text" name="readperm" id="readperm" size="6" value="<?=$readperm?>" tabindex="206" /> <em class="tips">(0或空为不限制)</em></td>
				</tr>
			<? } ?>

			<? if($maxprice && !$special) { ?>
				<tr>
					<th><label for="price">售价(<?=$extcredits[$creditstrans]['title']?>)</label></th>
					<td><input type="text" name="price" id="price" size="6" value="<?=$price?>" tabindex="207" /> <em class="tips"><?=$extcredits[$creditstrans]['unit']?> (最高 <?=$maxprice?> <?=$extcredits[$creditstrans]['unit']?><? if($maxincperthread) { ?>，单一主题作者最高收入 <?=$maxincperthread?> <?=$extcredits[$creditstrans]['unit']?><? } if($maxchargespan) { ?>，最高出售时限 <?=$maxchargespan?> 小时<? } ?>)
					您可以使用 <code><strong>[free]</strong>message<strong>[/free]</strong></code> 代码发表无需付费也能查看的免费信息</em>
				</td>
				</tr>
			<? } ?>

			<? if(!$special) { ?>
				<tr>
					<th>图标</th>
					<td><label><input class="radio" type="radio" name="iconid" value="0" checked="checked" tabindex="208" /> 无</label> <?=$icons?></td>
				</tr>
			<? } ?>

			</tbody>
			<tr class="btns">
				<th>&nbsp;</th>
				<td>
					<input type="hidden" name="wysiwyg" id="<?=$editorid?>_mode" value="<?=$editormode?>" />
					<button type="submit" name="topicsubmit" id="postsubmit" value="true" tabindex="300"><? if($special == 1) { ?>发新投票<? } elseif($special == 3) { ?>发起悬赏<? } elseif($special == 5) { ?>发表辩论<? } else { ?>发新话题<? } ?></button>
					<em>[完成后可按 Ctrl+Enter 发布]</em>&nbsp;&nbsp;
					&nbsp;<a href="###" id="restoredata" onclick="loadData()" title="恢复上次自动保存的数据">恢复数据</a>
				</td>
			</tr>
		</table>
	</div>
<br />

</form>

<script type="text/javascript">
	function showadv() {
		if($("advshow").checked == true) {
			$("adv").style.display = "";
		} else {
			$("adv").style.display = "none";
		}
	}
	function checkuserexists(username, objname) {
		var x = new Ajax();
		username = is_ie && document.charset == 'utf-8' ? encodeURIComponent(username) : username;
		x.get('ajax.php?inajax=1&action=checkuserexists&username=' + username, function(s){
			var obj = $(objname);
			obj.innerHTML = s;
		});
	}
	<? if($typeid) { ?>ajaxget('post.php?action=threadtypes&typeid=<?=$typeid?>&fid=<?=$fid?>&inajax=1', 'threadtypes', 'threadtypeswait');<? } ?>
</script>
<? include template('post_js'); if(!$iscircle || !$sgid) { include template('footer'); } else { include template('supesite_footer'); } ?>