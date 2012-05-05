<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>

</div>

<? if(!empty($jsmenu) && (empty($bbclosed) || $adminid == 1)) { include template('jsmenu'); } if($admode && empty($insenz['hardadstatus']) && !empty($advlist)) { ?>
	<div class="ad_footerbanner" id="ad_footerbanner1"><?=$advlist['footerbanner1']?></div><div class="ad_footerbanner" id="ad_footerbanner2"><?=$advlist['footerbanner2']?></div><div class="ad_footerbanner" id="ad_footerbanner3"><?=$advlist['footerbanner3']?></div>
<? } else { ?>
	<div id="ad_footerbanner1"></div><div id="ad_footerbanner2"></div><div id="ad_footerbanner3"></div>
<? } ?>

<div id="footer">
	<div class="wrap">
		<div id="footlinks">
			<p>当前时区 GMT<?=$timenow['offset']?>, 现在时间是 <?=$timenow['time']?><? if($icp) { ?> <a href="http://www.miibeian.gov.cn/" target="_blank"><?=$icp?></a><? } ?></p>
			<p>
				<a href="member.php?action=clearcookies&amp;formhash=<?=FORMHASH?>">清除 Cookies</a>
				- <span class="scrolltop" onclick="window.scrollTo(0,0);">TOP</span>
				<? if(!empty($stylejumpstatus)) { ?>
					- <span id="styleswitcher" class="dropmenu" onmouseover="showMenu(this.id)">界面风格</span>
					<script type="text/javascript">
					function setstyle(styleid) {
					<? if(CURSCRIPT == 'forumdisplay') { ?>
						location.href = 'forumdisplay.php?fid=<?=$fid?>&page=<?=$page?>&styleid=' + styleid;
					<? } elseif(CURSCRIPT == 'viewthread') { ?>
						location.href = 'viewthread.php?tid=<?=$tid?>&page=<?=$page?>&styleid=' + styleid;
					<? } else { ?>
						location.href = '<?=$indexname?>?styleid=' + styleid;
					<? } ?>
					}
					</script>
					<div id="styleswitcher_menu" class="popupmenu_popup" style="display: none;">
					<ul><? if(is_array($stylejump)) { foreach($stylejump as $id => $name) { ?><li<? if($id == $styleid) { ?> class="current"<? } ?>><a href="###" onclick="setstyle(<?=$id?>)"><?=$name?></a></li><? } } ?></ul>
					</div>
				<? } ?>
			</p>
		</div><? updatesession(); ?></div>
</div>
<? if($_DCACHE['settings']['frameon'] && in_array(CURSCRIPT, array('index', 'forumdisplay', 'viewthread')) && $_DCOOKIE['frameon'] == 'yes') { ?>
	<script src="include/javascript/iframe.js" type="text/javascript"></script>
<? } output(); ?></body>
</html>