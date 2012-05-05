<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<title><? if(!empty($member['spacename'])) { ?><?=$member['spacename']?><? } else { ?><?=$member['username']?>的个人空间<? } if(CURSCRIPT == 'viewpro') { ?> - <?=$member['username']?> 的个人资料<? } else { ?><?=$titleextra?><? } ?></title>
<meta name="keywords" content="<?=$metakeywords?>Discuz!,Board,Comsenz,forums,bulletin board,<?=$seokeywords?>">
<meta name="description" content="<?=$bbname?> <?=$seodescription?> - Discuz! Board">
<meta name="generator" content="Discuz! <?=$version?>">
<meta name="author" content="Discuz! Team & Comsenz UI Team">
<meta name="copyright" content="2001-2007 Comsenz Inc.">
<meta name="MSSmartTagsPreventParsing" content="TRUE">
<meta http-equiv="MSThemeCompatible" content="Yes">
<?=$extrahead?>

<link rel="stylesheet" type="text/css" id="stylecss" href="mspace/<?=$spacesettings['style']?>/style.css">
<style type="text/css">
.popupmenu_popup { text-align: left; line-height: 1.4em; padding: 10px; overflow: hidden; border: 0; background: #FFF; background-repeat: repeat-x; background-position: 0 1px;  }
img { border: 0; }
</style>
<script type="text/javascript">var attackevasive = '<?=$attackevasive?>';var IMGDIR = '<?=IMGDIR?>';</script>
<script src="include/javascript/common.js" type="text/javascript"></script>
<script src="include/javascript/menu.js" type="text/javascript"></script>
<script src="include/javascript/ajax.js" type="text/javascript"></script>
<script src="include/javascript/viewthread.js" type="text/javascript"></script>
<script type="text/javascript">
	<? if($_DCACHE['settings']['frameon']) { ?>
		if(parent.location != self.location) {
			parent.location = self.location;
		}
	<? } ?>
	function addbookmark(url, site){
		if(is_ie) {
			window.external.addFavorite(url, site);
		} else {
			alert('Please press "Ctrl+D" to add bookmark');
		}
	}
</script>
</head>
<body>
<div id="append_parent"></div><div id="ajaxwaitid" style="position: absolute;right: 0"></div>
<div id="menu_top">
	<div class="bgleft"></div>
	<div class="bg">
	<span>欢迎您
	<? if($discuz_uid) { ?>
		<?=$discuz_user?>&nbsp; &nbsp;<a href="<?=$link_logout?>">退出</a> | <a href="pm.php">短消息</a>
	<? } else { ?>
		游客&nbsp; &nbsp;<a href="<?=$link_register?>"><?=$reglinkname?></a> | <a href="<?=$link_login?>">登录</a>
	<? } ?>
	| <a href="<?=$indexname?>">返回论坛</a></span>
	</div>
	<div class="bgright"></div>
</div>
<div id="header">
	<div class="bg">
	<div class="title"><? if(!empty($member['spacename'])) { ?><?=$member['spacename']?><? } else { ?><?=$member['username']?>的个人空间<? } ?></div>
	<div class="desc"><?=$spacesettings['description']?></div>
	<div class="headerurl"><? if(in_array($rewritestatus, array(2, 3))) { ?><a href="space.php?uid=<?=$uid?>" class="spaceurl"><?=$boardurl?>space-uid-<?=$uid?>.html</a><? } else { ?><a href="space.php?uid=<?=$uid?>" class="spaceurl"><?=$boardurl?>space.php?uid=<?=$uid?></a><? } ?> <a href="###" onclick="setcopy('<?=$boardurl?>space.php?uid=<?=$uid?>', '帖子链接已经复制到剪贴板')">复制链接</a> | <a href="###" onclick="addbookmark('<?=$boardurl?>space.php?uid=<?=$uid?>', document.title)">加入收藏</a></div></div>
</div>
<div id="menu">
	<div class="block"><a href="space.php?uid=<?=$uid?>">空间首页</a>&nbsp;
	<? if($allowviewpro) { ?>&nbsp;<a href="space.php?action=viewpro&amp;uid=<?=$uid?>">个人信息</a>&nbsp;&nbsp;<? } if(is_array($menulist)) { foreach($menulist as $menu) { ?>&nbsp;<a href="space.php?<?=$uid?>/<?=$menu?>"><?=$spacelanguage[$menu]?></a>&nbsp;&nbsp;<? } } ?></div>
	<div class="control">
	<? if($discuz_uid == $uid) { ?>
		<a href="memcp.php?action=spacemodule">个人空间管理</a>
	<? } elseif($discuz_uid) { ?>
		<a href="space.php?uid=<?=$discuz_uid?>">我的空间</a>
	<? } else { ?>
		<a href="<?=$regname?>">开通个人空间</a>
	<? } ?>
	</div>
	<div class="icon"></div>
</div>

<div class="outer">
<table class="main" border="0" cellspacing="0">
<tr>
<? if($action != 'viewpro') { ?>
	<? if(!$tid) { ?>
		<? if($spacesettings['side'] != 2) { ?>
			<td id="main_layout0"><? if(is_array($layout['0'])) { foreach($layout['0'] as $module) { ?>				<table class="module" cellpadding="0" cellspacing="0" border="0"><tr><td class="header">
				<div class="title"><?=$spacelanguage[$module]?></div>
				<? if(array_key_exists($module, $listmodule)) { ?><div class="more"><a href="space.php?<?=$uid?>/<?=$module?>">更多</a></div><? } ?>
				</td></tr>
				<tr><td><? $module($moduledata[$module]['value']); ?></td></tr>
				</table>
			<? } } ?></td>
		<? } ?>

		<td id="main_layout1"><? if(is_array($layout['1'])) { foreach($layout['1'] as $module) { ?>			<table class="module" cellpadding="0" cellspacing="0" border="0"><tr><td class="header">
			<div class="title"><?=$spacelanguage[$module]?></div>
			<? if(!$mod && array_key_exists($module, $listmodule)) { ?><div class="more"><a href="space.php?<?=$uid?>/<?=$module?>">更多</a></div><? } ?>
			</td></tr>
			<tr><td><? $module($moduledata[$module]['value'], 1); ?></td></tr>
			</table>
		<? } } ?></td>

		<? if($spacesettings['side'] != 1) { ?>
			<td id="main_layout2" align="right"><? if(is_array($layout['2'])) { foreach($layout['2'] as $module) { ?>				<table class="module" cellpadding="0" cellspacing="0" border="0"><tr><td class="header">
				<div class="title"><?=$spacelanguage[$module]?></div>
				<? if(array_key_exists($module, $listmodule)) { ?><div class="more"><a href="space.php?<?=$uid?>/<?=$module?>">更多</a></div><? } ?>
				</td></tr>
				<tr><td><? $module($moduledata[$module]['value']); ?></td></tr>
				</table>
			<? } } ?></td>
		<? } ?>
	<? } else { include template('space_topic'); } } else { include template('viewpro'); } ?>
</tr>
</table>
</div>

<div id="footer"><div>
</div></div>
</body>
</html><? output(); ?>