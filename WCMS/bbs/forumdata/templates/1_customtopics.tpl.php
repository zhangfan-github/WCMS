<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>" />
<title>用户专题 - Powered by Discuz!</title>
<? if($allowcsscache) { ?><link rel="stylesheet" type="text/css" href="forumdata/cache/style_<?=$styleid?>.css" /><? } else { ?><style type="text/css">
<? include template('css'); ?>
</style><? } ?>
</head>

<script type="text/javascript">
function checkall(form, prefix, checkall) {
	var checkall = checkall ? checkall : 'chkall';
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.name != checkall && (!prefix || (prefix && e.name.match(prefix)))) {
			e.checked = form.elements(checkall).checked;;
		}
	}
}
</script>

<form method="post" action="misc.php?action=customtopics">
<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
<input type="hidden" name="keywordsubmit" value="yes" />
<div class="mainbox">

<table cellspacing="0" cellpadding="0" width="100%" align="center">
<thead>
<tr>
<td><input class="checkbox" type="checkbox" name="chkall" class="header" onclick="checkall(this.form, 'delete')" />删?</td>
<td>用户专题</td>
</tr>
</thead>
<tbody><? if(is_array($customkwlist)) { foreach($customkwlist as $vals) { ?>	<tr align="center">
	<td width="8%"><input type="checkbox" name="delete[]" value="<?=$vals['keyword']?>" /></td>
	<td width="16%"><?=$vals['url']?></a></td>
	</tr><? } } ?><tr align="center">
<td width="8%">新增:</td>
<td width="16%"><input type="text" name="newkeyword" value="" size="25" /></td>
</tr></tbody>
<tr class="btns">
<td></td>
<td><button type="submit" class="submit" name="keywordsubmit" value="true">提交</button>&nbsp;&nbsp;<button type="submit" name="close" value="true" onClick="window.close()">关闭</button></td>

</table></div>

</form><? output(); ?>