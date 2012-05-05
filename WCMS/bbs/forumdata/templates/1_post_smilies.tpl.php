<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<h4><span<? if(count($_DCACHE['smileytypes']) > 1) { ?> id="<?=$editorid?>_popup_smileytypes" onmouseover="showMenu(this.id, true, 0, 2)" class="dropmenu"<? } ?>><?=$_DCACHE['smileytypes'][$stypeid]['name']?></span></h4>

<table summary="smilies" cellpadding="0" cellspacing="0">
<tr align="center"><? $i=0; if(is_array($smilies)) { foreach($smilies as $key => $smiley) { ?>        <? if($i >= $smcols * $smrows) { break; } ?>
        <? if(!($i % $smcols)) { if($i) { ?></tr><? } ?><tr height="<? echo ($smthumb + 6);; ?>"><? } ?>
        <td align="center" id="smilie_<?=$key?>_parent" onMouseover="smileyMenu(this)" onClick="insertSmiley(<?=$key?>)"><img src="images/smilies/<?=$_DCACHE['smileytypes'][$_DCACHE['smilies']['typearray'][$key]]['directory']?>/<?=$smiley['url']?>" id="smilie_<?=$key?>" alt="<?=$smiley['code']?>" title="<?=$smiley['lw']?>" width="<?=$smiley['w']?>" height="<?=$smiley['h']?>" border="0" /></td>
        <? $i++; } } ?></tr>
<? if(ceil($i/$smcols) < $smrows) { echo str_repeat('<tr height="'.($smthumb + 6).'"><td colspan="'.$smrows.'"></td></tr>', $smrows - ceil($i/$smcols));; } ?>
</table>
<?=$multipage?>

<? if(count($_DCACHE['smileytypes']) > 1) { ?>
	<ul unselectable="on" class="popupmenu_popup" id="<?=$editorid?>_popup_smileytypes_menu" style="display: none"><? unset($_DCACHE['smileytypes'][$stypeid]); if(is_array($_DCACHE['smileytypes'])) { foreach($_DCACHE['smileytypes'] as $typeid => $type) { ?><li unselectable="on"><a href="post.php?action=smilies&amp;stypeid=<?=$typeid?>&amp;inajax=1" ajaxtarget="smilieslist"><?=$type['name']?></a></li><? } } ?></ul>
<? } include template('footer'); ?>
