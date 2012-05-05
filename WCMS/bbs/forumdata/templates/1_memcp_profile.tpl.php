<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div class="container">
	<div id="foruminfo">
		<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 编辑个人资料</div>
	</div>
	<div class="content">

<script src="include/javascript/calendar.js" type="text/javascript"></script>
<script src="include/javascript/bbcode.js" type="text/javascript"></script>
<script type="text/javascript">
var charset = '<?=$charset?>';
var maxsigsize = parseInt('<?=$maxsigsize?>');
var maxbiosize = parseInt('<?=$maxbiosize?>');
var maxbiotradesize = parseInt('<?=$maxbiotradesize?>');
var allowhtml = 0;
var forumallowhtml = 0;
var allowsmilies = 0;
var allowbbcode = 0;
var allowimgcode = 0;
var allowbiobbcode = parseInt('<?=$allowbiobbcode?>');
var allowbioimgcode = parseInt('<?=$allowbioimgcode?>');
var allowsigbbcode = parseInt('<?=$allowsigbbcode?>');
var allowsigimgcode = parseInt('<?=$allowsigimgcode?>');

function parseurl(str, mode) {
	str = str.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig, mode == 'html' ? '$1<img src="$2" border="0">' : '$1[img]$2[/img]');
	str = str.replace(/([^>=\]"'\/@]|^)((((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k):\/\/)|www\.)([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!#]*)*)/ig, mode == 'html' ? '$1<a href="$2" target="_blank">$2</a>' : '$1[url]$2[/url]');
	str = str.replace(/([^\w>=\]:"'\.\/]|^)(([\-\.\w]+@[\.\-\w]+(\.\w+)+))/ig, mode == 'html' ? '$1<a href="mailto:$2">$2</a>' : '$1[email]$2[/email]');
	return str;
}

function validate(theform) {
	<? if($typeid == 4) { ?>
		<? if($maxsigsize) { ?>
		if(mb_strlen(theform.signaturenew.value) > maxsigsize) {
			alert('您的签名长度超过 <?=$maxsigsize?> 字符的限制，请返回修改。');
			return false;
		}
		<? } ?>
		if(mb_strlen(theform.bionew.value) > maxbiosize) {
			alert('您的自我介绍长度超过 <?=$maxbiosize?> 字符的限制，请返回修改。');
			return false;
		}
		if(mb_strlen(theform.biotradenew.value) > maxbiotradesize) {
			alert('您的店铺介绍长度超过 <?=$maxbiotradesize?> 字符的限制，请返回修改。');
			return false;
		}
	<? } ?>
	return true;
}

function previewavatar(url) {
	if(url) {
		$('avatarpreview').innerHTML = '<img id="previewimg" /><br />';
		$('previewimg').src = url;
		if($('avatarwidthnew')) {
			$('avatarwidthnew').value = $('previewimg').clientWidth;
			$('avatarheightnew').value = $('previewimg').clientHeight;
		}
	} else {
		$('avatarpreview').innerHTML = '';
	}
}

</script>
<form name="reg" method="post" action="memcp.php?action=profile&amp;typeid=<?=$typeid?>" <?=$enctype?> onSubmit="return validate(this)">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
		<div class="mainbox formbox">
			<h1>编辑个人资料</h1>
			<ul class="tabs <? if($typeid==3) { ?>headertabs<? } ?>">
				<? if(!$passport_status) { ?><li<? if($typeid==1) { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=1">论坛登录</a></li><? } ?>
				<li<? if($typeid==2) { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=2">基本资料</a></li>
				<? if(!empty($_DCACHE['fields_required']) || !empty($_DCACHE['fields_optional'])) { ?>
					<li<? if($typeid==3) { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=3">扩展资料</a></li>
				<? } ?>
				<li<? if($typeid==4) { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=4">个性化资料</a></li>
				<li<? if($typeid==5) { ?> class="current"<? } ?>><a href="memcp.php?action=profile&amp;typeid=5">论坛选项</a></li>
			</ul>
<table summary="编辑个人资料" cellspacing="0" cellpadding="0">

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
<? } if($typeid == 1 && !$passport_status) { ?>

	<tr>
		<th><label for="oldpassword">原密码</label></th>
		<td><input type="password" name="oldpassword" id="oldpassword" size="25" /></td>
	</tr>

	<tr>
		<th><label for="newpassword">新密码</label></th>
		<td><input type="password" name="newpassword" id="newpassword" size="25" /></td>
	</tr>

	<tr>
		<th><label for="newpassword2">确认新密码</label></th>
		<td><input type="password" name="newpassword2" id="newpassword2" size="25" /></td>
	</tr>

	<tr>
		<th><label for="emailnew">Email</label></th>
		<td><input type="text" name="emailnew" id="emailnew" size="25" value="<?=$member['email']?>" />
		<? if($regverify == 1 && (($grouptype == 'member' && $adminid == 0) && $groupid == 8)) { ?> <em>!如更改地址，系统将修改您的密码并重新验证其有效性，请慎用</em><? } ?>
	</td>
	</tr>

	<tr>
		<th><label for="questionidnew">安全提问</label></th>
		<td><select name="questionidnew" id="questionidnew">
		<? if($discuz_secques) { ?><option value="-1">保持原有的安全提问和答案</option><? } ?>
		<option value="0">无安全提问</option>
		<option value="1">母亲的名字</option>
		<option value="2">爷爷的名字</option>
		<option value="3">父亲出生的城市</option>
		<option value="4">您其中一位老师的名字</option>
		<option value="5">您个人计算机的型号</option>
		<option value="6">您最喜欢的餐馆名称</option>
		<option value="7">驾驶执照的最后四位数字</option>
		</select> <em>如果您启用安全提问，登录时需填入相应的项目才能登录</em>
		</td>
	</tr>

	<tr>
		<th><label for="answernew">回答</label></th>
		<td><input type="text" name="answernew" id="answernew" size="25" /> <em>如您设置新的安全提问，请在此输入答案</em></td>
	</tr>

<? } elseif($typeid == 2) { ?>

	<? if($allownickname) { ?>
		<tr>
		<th><label for="nicknamenew">昵称</label></th>
		<td><input type="text" name="nicknamenew" id="nicknamenew" size="25" value="<?=$member['nickname']?>" /></td>
		</tr>
	<? } ?>

	<? if($allowcstatus) { ?>
		<tr>
		<th><label for="cstatusnew">自定义头衔</label></th>
		<td>
		<input type="text" name="cstatusnew" id="cstatusnew" size="25" value="<?=$member['customstatus']?>" /></td>
		</tr>
	<? } ?>

	<tr>
	<th>性别</th>
	<td>
	<label><input class="radio" type="radio" name="gendernew" value="1" <?=$gendercheck['1']?> /> 男 &nbsp;<label>
	<label><input class="radio" type="radio" name="gendernew" value="2" <?=$gendercheck['2']?> /> 女 &nbsp;</label>
	<label><input class="radio" type="radio" name="gendernew" value="0" <?=$gendercheck['0']?> /> 保密</label>
	</td></tr>

	<tr>
	<th><label for="bdaynew">生日</label></th>
	<td><input type="text" name="bdaynew" id="bdaynew" size="25" onclick="showcalendar(event, this)" onfocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''" value="<?=$member['bday']?>" /></td>
	</tr>

	<tr>
	<th><label for="locationnew">来自</label></th>
	<td><input type="text" name="locationnew" id="locationnew" size="25" value="<?=$member['location']?>" /></td>
	</tr>

	<tr>
	<th><label for="sitenew">个人网站</label></th>
	<td><input type="text" name="sitenew" id="sitenew" size="25" value="<?=$member['site']?>" /></td>
	</tr>

	<tr>
	<th><label for="qqnew">QQ</label></th>
	<td><input type="text" name="qqnew" id="qqnew" size="25" value="<?=$member['qq']?>" /></td>
	</tr>

	<tr>
	<th><label for="icqnew">ICQ</label></th>
	<td><input type="text" name="icqnew" id="icqnew" size="25" value="<?=$member['icq']?>" /></td>
	</tr>

	<tr>
	<th><label for="yahoonew">Yahoo</label></th>
	<td><input type="text" name="yahoonew" id="yahoonew" size="25" value="<?=$member['yahoo']?>" /></td>
	</tr>

	<tr>
	<th><label for="msnnew">MSN</label></th>
	<td><input type="text" name="msnnew" id="msnnew" size="25" value="<?=$member['msn']?>" /></td>
	</tr>

	<tr>
	<th><label for="taobaonew">阿里旺旺</label></th>
	<td><input type="text" name="taobaonew" id="taobaonew" size="25" value="<?=$member['taobao']?>" /></td>
	</tr>

	<tr>
	<th><label for="alipaynew">支付宝账号</label></th>
	<td><input type="text" name="alipaynew" id="alipaynew" size="25" value="<?=$member['alipay']?>" /></td>
	</tr>

<? } elseif($typeid == 3 && (!empty($_DCACHE['fields_required']) || !empty($_DCACHE['fields_optional']))) { ?>

	<? if($_DCACHE['fields_required']) { ?>
		<thead class="separation">
		<tr>
		<td colspan="2">基本信息 ( * 为必填项)</td>
		</tr>
		</thead><? if(is_array($_DCACHE['fields_required'])) { foreach($_DCACHE['fields_required'] as $field) { ?>			<tr>
			<th><?=$field['title']?><? if($field['description']) { ?><br /><em><?=$field['description']?></em><? } ?></th>
			<td>
			<? if($field['selective']) { ?>
				<select name="field_<?=$field['fieldid']?>new" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?>>
				<option value="">- 请选择 -</option><? if(is_array($field['choices'])) { foreach($field['choices'] as $index => $choice) { ?><option value="<?=$index?>" <? if($index == $member['field_'.$field['fieldid']]) { ?>selected="selected"<? } ?>><?=$choice?></option>
				<? } } ?></select>
			<? } else { ?>
				<input type="text" name="field_<?=$field['fieldid']?>new" size="25" value="<?=$member['field_'.$field['fieldid']]?>" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?> />
			<? } ?>
			<? if($field['unchangeable']) { ?>&nbsp;<em>请认真填写本项目，一旦确定将不可修改</em><? } ?>
			</td></tr><? } } } ?>

	<? if($_DCACHE['fields_optional']) { ?>
		<thead class="separation">
		<tr>
		<td colspan="2">扩展信息</td>
		</tr>
		</thead><? if(is_array($_DCACHE['fields_optional'])) { foreach($_DCACHE['fields_optional'] as $field) { ?>			<tr>
			<th><label for="field_<?=$field['fieldid']?>new"><?=$field['title']?><? if($field['description']) { ?><br /><em><?=$field['description']?></em><? } ?></label></th>
			<td>
			<? if($field['selective']) { ?>
				<select name="field_<?=$field['fieldid']?>new" id="field_<?=$field['fieldid']?>new" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?>>
				<option value="">- 请选择 -</option><? if(is_array($field['choices'])) { foreach($field['choices'] as $index => $choice) { ?><option value="<?=$index?>" <? if($index == $member['field_'.$field['fieldid']]) { ?>selected="selected"<? } ?>><?=$choice?></option>
				<? } } ?></select>
			<? } else { ?>
				<input type="text" name="field_<?=$field['fieldid']?>new" size="25" value="<?=$member['field_'.$field['fieldid']]?>" <? if($member['field_'.$field['fieldid']] && $field['unchangeable']) { ?>disabled<? } ?> />
			<? } ?>
			<? if($field['unchangeable']) { ?>&nbsp;<em>请认真填写本项目，一旦确定将不可修改</em><? } ?>
			</td></tr><? } } } } elseif($typeid == 4) { ?>

	<? if($allowavatar == 1) { ?>
		<tr>
		<th valign="top"><label for="urlavatar">头像</label></td>
		<td>
		<span id="avatarpreview"><? if($member['avatar']) { ?><img src="<?=$member['avatar']?>" /><br /><? } ?></span>
		<input type="text" name="urlavatar" id="urlavatar" onchange="previewavatar(this.value)" size="25" value="<?=$member['avatar']?>" /> &nbsp; <a href="member.php?action=viewavatars&amp;page=1" onclick="ajaxget(this.href, 'avatardiv');doane(event);">论坛头像列表</a>
		<span id="statusid"></span>
		<div id="avatardiv" style="display: none; margin-top: 10px;"></div></td>
		</tr>
	<? } elseif($allowavatar == 2) { ?>
		<tr>
		<th valign="top"><label for="urlavatar">头像</label></th>
		<td>
		<span id="avatarpreview"><? if($member['avatar']) { ?><img src="<?=$member['avatar']?>" width="<?=$member['avatarwidth']?>" height="<?=$member['avatarheight']?>" /><br /><? } ?></span>
		<input type="text" name="urlavatar" id="urlavatar" onchange="previewavatar(this.value)" size="25" value="<?=$member['avatar']?>" /> &nbsp; <a href="member.php?action=viewavatars&amp;page=1" onclick="ajaxget(this.href, 'avatardiv');doane(event);">论坛头像列表</a>
		<div id="avatardiv" style="display: none; margin-top: 10px;"></div>
		<br />宽: <input type="text" name="avatarwidthnew" id="avatarwidthnew" size="1" value="<?=$member['avatarwidth']?>" /> &nbsp; 高: <input type="text" name="avatarheightnew" id="avatarheightnew" size="1" value="<?=$member['avatarheight']?>" /></td>
		</tr>
	<? } elseif($allowavatar == 3) { ?>
		<tr>
		<th valign="top"><label for="urlavatar">头像</label></th>
		<td>
		<span id="avatarpreview"><? if($member['avatar']) { ?><img src="<?=$member['avatar']?>" width="<?=$member['avatarwidth']?>" height="<?=$member['avatarheight']?>" /><br /><? } ?></span>
		<input type="text" name="urlavatar" id="urlavatar" onchange="previewavatar(this.value)" size="25" value="<?=$member['avatar']?>" /> &nbsp; <a href="member.php?action=viewavatars&amp;page=1" onclick="ajaxget(this.href, 'avatardiv');doane(event);">论坛头像列表</a>
		<div id="avatardiv" style="display: none; margin-top: 10px;"></div>
		<br /><input type="file" name="customavatar" onchange="$('avatarwidthnew').value = $('avatarheightnew').value = '*';$('urlavatar').value = '';if(this.value) previewavatar('');" size="25" />
		<br />宽: <input type="text" name="avatarwidthnew" id="avatarwidthnew" size="1" value="<?=$member['avatarwidth']?>" /> &nbsp; 高: <input type="text" name="avatarheightnew" id="avatarheightnew" size="1" value="<?=$member['avatarheight']?>" /></td>
		</tr>
	<? } ?>

	<tr>
	<th valign="top"><label for="bionew">自我介绍 (<?=$maxbiosize?> 字节以内)<br /><em>不支持自定义 Discuz! 代码<br /><br />
	<a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a> <b><? if($allowbiobbcode) { ?>可用<? } else { ?>禁用<? } ?></b><br />
	[img] 代码 <b><? if($allowbioimgcode) { ?>可用<? } else { ?>禁用<? } ?></b><br /><br />
	<a href="###" onclick="allowbbcode = allowbiobbcode;allowimgcode = allowbioimgcode;$('biopreview').innerHTML = bbcode2html($('bionew').value)">预览</a>
	</em></label></th>
	<td><div id="biopreview"></div><textarea rows="8" cols="30" style="width: 380px" id="bionew" name="bionew"><?=$member['bio']?></textarea>
	</td>
	</tr>

	<tr>
	<th valign="top"><label for="biotradenew">店铺介绍 (<?=$maxbiotradesize?> 字节以内)<br /><em>不支持自定义 Discuz! 代码<br /><br />
	<a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a> <b>可用</b><br />
	[img] 代码 <b>可用</b><br /><br />
	<a href="###" onclick="allowbbcode = 1;allowimgcode = 1;$('biotradepreview').innerHTML = bbcode2html($('biotradenew').value)">预览</a>
	</em></label></th>
	<td><div id="biotradepreview"></div><textarea rows="8" cols="30" style="width: 380px" id="biotradenew" name="biotradenew"><?=$member['biotrade']?></textarea>
	</td>
	</tr>

	<? if($maxsigsize) { ?>
		<tr>
		<th valign="top"><label for="signaturenew">个人签名 (<?=$maxsigsize?> 字节以内)<br /><em>不支持自定义 Discuz! 代码</em><br /><br />
		<em>
		<a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a><b><? if($allowsigbbcode) { ?>可用<? } else { ?>禁用<? } ?></b><br />
		[img] 代码 <b><? if($allowsigimgcode) { ?>可用<? } else { ?>禁用<? } ?></b><br /><br />
		<a href="###" onclick="allowbbcode = allowsigbbcode;allowimgcode = allowsigimgcode;$('signaturepreview').innerHTML = bbcode2html($('signaturenew').value)">预览</a>
		</em></label></th>
		<td><div id="signaturepreview"></div><textarea rows="8" cols="30" style="width: 380px" id="signaturenew" name="signaturenew"><?=$member['signature']?></textarea>
		</td>
		</tr>
	<? } } elseif($typeid == 5) { ?>

	<tr>
	<th>界面风格</th>
	<td><select name="styleidnew">
	<option value="">- 使用默认 -</option>
	<?=$styleselect?></select></td>
	</tr>

	<tr>
	<th>每页主题数</th>
	<td><select name="tppnew">
	<option value="0" <?=$tppchecked['0']?>>- 使用默认 -</option>
	<option value="10" <?=$tppchecked['10']?>>10</option>
	<option value="20" <?=$tppchecked['20']?>>20</option>
	<option value="30" <?=$tppchecked['30']?>>30</option>
	</select></td>
	</tr>

	<tr>
	<th>每页帖数</th>
	<td><select name="pppnew">
	<option value="0" <?=$pppchecked['0']?>>- 使用默认 -</option>
	<option value="5" <?=$pppchecked['5']?>>5</option>
	<option value="10" <?=$pppchecked['10']?>>10</option>
	<option value="15" <?=$pppchecked['15']?>>15</option>
	</select></td>
	</tr>

	<tr>
	<th>签名显示设置</th>
	<td><select name="ssnew">
	<option value="2" <?=$sschecked['2']?>>- 使用默认 -</option>
	<option value="1" <?=$sschecked['1']?>>显示签名</option>
	<option value="0" <?=$sschecked['0']?>>不显示签名</option>
	</select></td>
	</tr>
	<tr>
	<th>头像显示设置</th>
	<td><select name="sanew">
	<option value="2" <?=$sachecked['2']?>>- 使用默认 -</option>
	<option value="1" <?=$sachecked['1']?>>显示头像</option>
	<option value="0" <?=$sachecked['0']?>>不显示头像</option>
	</select></td>
	</tr>
	<tr>
	<th>图片显示设置<br /><em>包括上传的附件图片和 [img] 代码图片</em></th>
	<td><select name="sinew">
	<option value="2" <?=$sichecked['2']?>>- 使用默认 -</option>
	<option value="1" <?=$sichecked['1']?>>显示图片</option>
	<option value="0" <?=$sichecked['0']?>>不显示图片</option>
	</select></td>
	</tr>

	<tr>
	<th>编辑器模式</th>
	<td><select name="editormodenew">
	<option value="2" <?=$emcheck['2']?>>- 使用默认 -</option>
	<option value="0" <?=$emcheck['0']?>>Discuz! 代码模式</option>
	<option value="1" <?=$emcheck['1']?>>所见即所得模式</option>
	</select></td>
	</tr>

	<tr>
	<th>时差设定</th>
	<td>
	<select name="timeoffsetnew">
	<option value="9999" <?=$toselect['9999']?>>- 使用默认 -</option>
	<option value="-12" <?=$toselect['-12']?>>(GMT -12:00) Eniwetok, Kwajalein</option>
	<option value="-11" <?=$toselect['-11']?>>(GMT -11:00) Midway Island, Samoa</option>
	<option value="-10" <?=$toselect['-10']?>>(GMT -10:00) Hawaii</option>
	<option value="-9" <?=$toselect['-9']?>>(GMT -09:00) Alaska</option>
	<option value="-8" <?=$toselect['-8']?>>(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
	<option value="-7" <?=$toselect['-7']?>>(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
	<option value="-6" <?=$toselect['-6']?>>(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
	<option value="-5" <?=$toselect['-5']?>>(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
	<option value="-4" <?=$toselect['-4']?>>(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
	<option value="-3.5" <?=$toselect['-3.5']?>>(GMT -03:30) Newfoundland</option>
	<option value="-3" <?=$toselect['-3']?>>(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
	<option value="-2" <?=$toselect['-2']?>>(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
	<option value="-1" <?=$toselect['-1']?>>(GMT -01:00) Azores, Cape Verde Islands</option>
	<option value="0"  <?=$toselect['0']?>>(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
	<option value="1" <?=$toselect['1']?>>(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
	<option value="2" <?=$toselect['2']?>>(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
	<option value="3" <?=$toselect['3']?>>(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi</option>
	<option value="3.5" <?=$toselect['3.5']?>>(GMT +03:30) Tehran</option>
	<option value="4" <?=$toselect['4']?>>(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
	<option value="4.5" <?=$toselect['4.5']?>>(GMT +04:30) Kabul</option>
	<option value="5" <?=$toselect['5']?>>(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
	<option value="5.5" <?=$toselect['5.5']?>>(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
	<option value="5.75" <?=$toselect['5.75']?>>(GMT +05:45) Katmandu</option>
	<option value="6" <?=$toselect['6']?>>(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
	<option value="6.5" <?=$toselect['6.5']?>>(GMT +06:30) Rangoon</option>
	<option value="7" <?=$toselect['7']?>>(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
	<option value="8" <?=$toselect['8']?>>(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
	<option value="9" <?=$toselect['9']?>>(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
	<option value="9.5" <?=$toselect['9.5']?>>(GMT +09:30) Adelaide, Darwin</option>
	<option value="10" <?=$toselect['10']?>>(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
	<option value="11" <?=$toselect['11']?>>(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
	<option value="12" <?=$toselect['12']?>>(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
	</select></td>
	</tr>

	<tr>
	<th>时间格式</th>
	<td>
	<label><input type="radio" value="0" name="timeformatnew" <?=$tfcheck['0']?> />默认 &nbsp;</label>
	<label><input type="radio" value="1" name="timeformatnew" <?=$tfcheck['1']?> />12 小时 &nbsp;</label>
	<label><input type="radio" value="2" name="timeformatnew" <?=$tfcheck['2']?> />24 小时</label></td>
	</tr>

	<tr>
	<th>日期格式</th>
	<td>
	<select name="dateformatnew">
	<option value="0" <?=$dfcheck['0']?>>默认</option><? if(is_array($dateformatlist)) { foreach($dateformatlist as $key => $value) { ?><option value="<?=$key?>" <?=$dfcheck[$key]?>><?=$value?></option><? } } ?></select>
	</td>
	</tr>

	<tr>
	<th>短消息提示音</th>
	<td><label><input type="radio" value="0" name="pmsoundnew" <?=$pscheck['0']?> />无 &nbsp;</label>
	<label><input type="radio" value="1" name="pmsoundnew" <?=$pscheck['1']?> /><a href="images/sound/pm_1.wav">#1</a> &nbsp;</label>
	<label><input type="radio" value="2" name="pmsoundnew" <?=$pscheck['2']?> /><a href="images/sound/pm_2.wav">#2</a> &nbsp;</label>
	<label><input type="radio" value="3" name="pmsoundnew" <?=$pscheck['3']?> /><a href="images/sound/pm_3.wav">#3</a></label></td>
	</tr>

	<tr>
	<th>其他选项</th>
	<td>
	<? if($allowinvisible) { ?>
		<label><input type="checkbox" name="invisiblenew" value="1" <?=$invisiblechecked?> /> 在线列表中隐身</label><br />
	<? } ?>
	<label><input type="checkbox" name="showemailnew" value="1" <?=$emailchecked?> /> Email 地址可见</label><br />
	<label><input type="checkbox" name="newsletternew" value="1" <?=$newschecked?> /> 同意接收论坛通知 (Email 或短消息)</label><br />
	</td></tr>

<? } ?>
	<tr>
		<th>&nbsp;</th>
		<td><button type="submit" class="submit" name="editsubmit" id="editsubmit" value="true">提交</button></td>
	</tr>
</table>

</div>


</form>

</td></tr></table>

	</div>
	<div class="side">
<? include template('personal_navbar'); ?>
</div>
</div>
<? include template('footer'); ?>
