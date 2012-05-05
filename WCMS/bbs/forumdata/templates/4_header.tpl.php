<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>" />
<title><?=$navtitle?> <?=$bbname?> <?=$seotitle?></title>
<?=$seohead?>
<meta name="keywords" content="<?=$metakeywords?><?=$seokeywords?>" />
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
<script>
function addCookie() {
	
	if(document.all) {
		window.external.addFavorite('http://www.xmlyclub.com','ìûÂèÀ­Ø');
	}
	else if(window.sidebar) {
	
		window.sidebar.addPanel('ìûÂèÀ­Øó','http://www.xmlyclub.com',"");
	}
}
</script>
</head>

<body onkeydown="if(event.keyCode==27) return false;">
	
		<!--top start-->
	<div class="header" style="width:974px;height:67px;margin:0 auto;">
	<div class="logo" style="width:242px;height:67px;float:left;margin-left:28px;">
			<img src="/image/logo.gif">		
	</div>
</div>	
	<div class="menu_bg">
    <div class="mid_974">
    	
		<div class="top_info">
		<? if($_DCACHE['settings']['frameon'] > 0) { ?>
			<span class="frameswitch">
			<script type="text/javascript">
			if(top == self) {
			<? if(($_DCACHE['settings']['frameon'] == 2 && !defined('CACHE_FILE') && in_array(CURSCRIPT, array('index', 'forumdisplay', 'viewthread')) && (($_DCOOKIE['frameon'] == 'yes' && $_GET['frameon'] != 'no') || (empty($_DCOOKIE['frameon']) && empty($_GET['frameon']))))) { ?>
				top.location = 'frame.php?frameon=yes&referer='+escape(self.location);
			<? } ?>
				document.write('<a href="frame.php?frameon=yes" target="_top" class="frameon">·ÖÀ¸Ä£Ê½<\/a>');
			} else {
				document.write('<a href="frame.php?frameon=no" target="_top" class="frameoff">Æ½°åÄ£Ê½<\/a>');
			}
			</script>
			</span>
		<? } ?>
		
			<table style="float:left;">
				<tr>
					
					
					<? if($allowsearch || $qihoo['status']) { ?><td<? if($BASESCRIPT == 'search.php') { ?> class="current"<? } ?>><a href="search.php<? if(!empty($fid)) { ?>?srchfid=<?=$fid?><? } ?>">ËÑË÷</a></td><? } ?>
					<? if($plugins['links']) { if(is_array($plugins['links'])) { foreach($plugins['links'] as $module) { ?>							<? if(!$module['adminid'] || ($module['adminid'] && $adminid > 0 && $module['adminid'] >= $adminid)) { ?><td><?=$module['url']?></td><? } ?>
						<? } } } ?>
					<? if($discuz_uid) { ?>
						<? if($regstatus >1) { ?><td <? if($BASESCRIPT == 'invite.php') { ?> class="current"<? } ?>><a href="invite.php">ÑûÇë×¢²á</a></td><? } ?>
						<? if($jsmenu['4']) { ?><td id="my" class="dropmenu<? if($BASESCRIPT == 'my.php') { ?> current<? } ?>" onmouseover="showMenu(this.id)"><a href="my.php">ÎÒµÄ</a></td><? } else { ?><td><a href="my.php?item=threads"<? if($BASESCRIPT == 'my.php') { ?> class="current"<? } ?>>ÎÒµÄ»°Ìâ</a></td><td><a href="my.php?item=grouppermission">ÎÒµÄÈ¨ÏŞ</a></td><? } ?>
						<? if($jsmenu['2']) { ?><td id="memcp" class="dropmenu<? if($BASESCRIPT == 'memcp.php') { ?> current<? } ?>" id="<? if($discuz_uid && in_array($adminid,array(1,2,3))) { } else { ?>last<? } ?>" onmouseover="showMenu(this.id)"><a href="memcp.php">¿ØÖÆÃæ°å</a></td><? } else { ?><td><a href="memcp.php"<? if($BASESCRIPT == 'memcp.php') { ?> class="current"<? } ?>>¿ØÖÆÃæ°å</a></td><? } ?>
					<? } ?>
					
					<? if($discuz_uid && in_array($adminid,array(1,2,3))) { ?><td id="last"><a href="admincp.php" target="_blank">ÏµÍ³ÉèÖÃ</a></td><? } ?>
					<? if($discuz_uid) { ?>
					<td class="no_border"><a href="<?=$link_logout?>">ÍË³ö</a></td>
					
					<? } else { ?>
					<td<? if($BASESCRIPT == $regname) { ?> class="current"<? } ?>><a href="<?=$link_register?>"><?=$reglinkname?></a></td>
					<td<? if($BASESCRIPT == 'logging.php') { ?> id="last" class="current"<? } ?>><a href="<?=$link_login?>">µÇÂ¼</a></td>
					<? } ?>
				</tr>
			</table>
			<div style="float:right;">
				
						<a href="/index.php/site/column/id/80">¹ØÓÚÎÒÃÇ</a>|
					
						<a href="/index.php/site/column/id/82">ÁªÏµÎÒÃÇ</a>|
					
						<a href="javascript:addCookie()">¼ÓÈëÊÕ²Ø</a>
				
			</div>
		</div>
		
        <ul class="top_menu">
        	<li><a href="/"><span class="m_ch">Ê×Ò³</span><span class="m_en">HOME</span></a></li>
            <li><a href="/index.php/site/column/id/11"><span class="m_ch">ìûÂè·şÎñ</span><span class="m_en">SERVICES</span></a></li>
            <li><a href="/index.php/site/column/id/17"><span class="m_ch">ÔĞÓı°Ù¿Æ</span><span class="m_en">KNOWLEDGE</span></a></li>
            <li><a href="/index.php/site/column/id/21"><span class="m_ch">Õ¹Ê¾¿Õ¼ä</span><span class="m_en">SHOW</span></a></li>
            <li><a href="/index.php/site/column/id/27"><span class="m_ch">×¨¼ÒÍÅ¶Ó</span><span class="m_en">SPECILISTS</span></a></li>
            <li><a href="/index.php/site/column/id/34"><span class="m_ch">ÔÚÏß×ÉÑ¯</span><span class="m_en">CONSULTATION</span></a></li>
        	<li><a href="/bbs"><span class="m_ch">»áÔ±ÉçÇø</span><span class="m_en">COMMUNITY</span></a></li>
        </ul>
    </div>
    </div>
<!--top end-->
	
	<div class="wrap">
