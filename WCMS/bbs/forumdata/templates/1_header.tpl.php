<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>" />
<title><?=$navtitle?> <?=$bbname?> <?=$seotitle?></title>
<?=$seohead?>
<meta name="keywords" content="<?=$metakeywords?><?=$seokeywords?>" />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<link rel="archives" title="<?=$bbname?>" href="<?=$boardurl?>archiver/" />
<?=$rsshead?>
<?=$extrahead?>
<? if($allowcsscache) { ?>
	<link rel="stylesheet" type="text/css" href="forumdata/cache/style_<?=STYLEID?>.css" />
<? } else { ?>
	<style type="text/css">
<? include template('css'); ?>
</style>
	<style type="text/css">
<? include template('css_append'); ?>
</style>
<? } ?>
<script type="text/javascript">var IMGDIR = '<?=IMGDIR?>';var attackevasive = '<?=$attackevasive?>';var gid = 0;<? if(in_array(CURSCRIPT, array('viewthread', 'forumdisplay'))) { ?>gid = parseInt('<?=$thisgid?>');<? } elseif(CURSCRIPT == 'index') { ?>gid = parseInt('<?=$gid?>');<? } ?>var fid = parseInt('<?=$fid?>');var tid = parseInt('<?=$tid?>');</script>
<script src="include/javascript/common.js" type="text/javascript"></script>
<script src="include/javascript/menu.js" type="text/javascript"></script>
<script src="include/javascript/ajax.js" type="text/javascript"></script>
</head>

<body onkeydown="if(event.keyCode==27) return false;">

	<div id="append_parent"></div><div id="ajaxwaitid"></div>
	<div class="wrap">
		<div id="header">
			<h2><a href="<?=$indexname?>" title="<?=$bbname?>"><?=BOARDLOGO?></a></h2>
			<div id="ad_headerbanner"><? if($admode && empty($insenz['hardadstatus']) && !empty($advlist['headerbanner'])) { ?><?=$advlist['headerbanner']?><? } ?></div>
		</div>
		<div id="menu">
		<? if($_DCACHE['settings']['frameon'] > 0) { ?>
			<span class="frameswitch">
			<script type="text/javascript">
			if(top == self) {
			<? if(($_DCACHE['settings']['frameon'] == 2 && !defined('CACHE_FILE') && in_array(CURSCRIPT, array('index', 'forumdisplay', 'viewthread')) && (($_DCOOKIE['frameon'] == 'yes' && $_GET['frameon'] != 'no') || (empty($_DCOOKIE['frameon']) && empty($_GET['frameon']))))) { ?>
				top.location = 'frame.php?frameon=yes&referer='+escape(self.location);
			<? } ?>
				document.write('<a href="frame.php?frameon=yes" target="_top" class="frameon">分栏模式<\/a>');
			} else {
				document.write('<a href="frame.php?frameon=no" target="_top" class="frameoff">平板模式<\/a>');
			}
			</script>
			</span>
		<? } ?>

			<ul>
			<? if($discuz_uid) { ?>
				<li><cite><a href="space.php?action=viewpro&amp;uid=<?=$discuz_uid?>"><?=$discuz_userss?></a></cite></li>
				<li><a href="<?=$link_logout?>" class="notabs">退出</a></li>
				<? if($maxpmnum) { ?><li<? if($BASESCRIPT == 'pm.php') { ?> class="current"<? } ?>><a href="pm.php" target="_blank">短消息</a></li><? } ?>
			<? } else { ?>
				<li<? if($BASESCRIPT == $regname) { ?> class="current"<? } ?>><a href="<?=$link_register?>" class="notabs"><?=$reglinkname?></a></li>
				<li<? if($BASESCRIPT == 'logging.php') { ?> class="current"<? } ?>><a href="<?=$link_login?>">登录</a></li>
			<? } ?>

			<? if($memliststatus) { ?><li<? if($BASESCRIPT == 'member.php') { ?> class="current"<? } ?>><a href="member.php?action=list">会员</a></li><? } ?>
			<? if($allowsearch || $qihoo['status']) { ?><li<? if($BASESCRIPT == 'search.php') { ?> class="current"<? } ?>><a href="search.php<? if(!empty($fid)) { ?>?srchfid=<?=$fid?><? } ?>">搜索</a></li><? } ?>
			<? if($tagstatus) { ?><li<? if($BASESCRIPT == 'tag.php') { ?> class="current"<? } ?>><a href="tag.php">标签</a></li><? } ?>
			<? if(!empty($plugins['links'])) { if(is_array($plugins['links'])) { foreach($plugins['links'] as $module) { ?>						<? if(!$module['adminid'] || ($module['adminid'] && $adminid > 0 && $module['adminid'] >= $adminid)) { ?><li><?=$module['url']?></li><? } ?>
				<? } } } ?>
			<? if($discuz_uid) { ?>
				<? if($jsmenu['4']) { ?><li id="my" class="dropmenu<? if($BASESCRIPT == 'my.php') { ?> current<? } ?>" onmouseover="showMenu(this.id)"><a href="my.php">我的</a></li><? } else { ?><li><a href="my.php?item=threads"<? if($BASESCRIPT == 'my.php') { ?>class="current"<? } ?>>我的话题</a></li><li><a href="my.php?item=grouppermission">我的权限</a></li><? } ?>
				<? if($jsmenu['2']) { ?><li id="memcp" class="dropmenu<? if($BASESCRIPT == 'memcp.php') { ?> current<? } ?>" onmouseover="showMenu(this.id)"><a href="memcp.php">控制面板</a></li><? } else { ?><li><a href="memcp.php"<? if($BASESCRIPT == 'memcp.php') { ?>class="current"<? } ?>>控制面板</a></li><? } ?>
				<? if($regstatus > 1) { ?><li<? if($BASESCRIPT == 'invite.php') { ?> class="current"<? } ?>><a href="invite.php">邀请注册</a></li><? } ?>
				<? if($magicstatus) { ?><li<? if($BASESCRIPT == 'magic.php') { ?> class="current"<? } ?>><a href="magic.php">道具</a></li><? } ?>
			<? } ?>
			<? if(!empty($plugins['jsmenu'])) { ?><li id="plugin" class="dropmenu" onmouseover="showMenu(this.id)"><a href="#"><?=$pluginjsmenu?></a></li><? } ?>
			<? if($allowviewstats) { if(!empty($jsmenu['3'])) { ?><li id="stats" class="dropmenu<? if($BASESCRIPT == 'stats.php') { ?> current<? } ?>" onmouseover="showMenu(this.id)"><a href="stats.php">统计</a></li><? } else { ?><li><a href="stats.php">统计</a></li><? } } ?>
			<? if($discuz_uid && in_array($adminid, array(1, 2, 3))) { ?><li><a href="admincp.php" target="_blank">系统设置</a></li><? } ?>
				<li<? if($BASESCRIPT == 'faq.php') { ?> class="current"<? } ?>><a href="faq.php">帮助</a></li>
			</ul>
		</div>