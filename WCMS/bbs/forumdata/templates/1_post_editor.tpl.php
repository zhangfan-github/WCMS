<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script type="text/javascript">
lang['post_discuzcode_code'] = '请输入要插入的代码';
lang['post_discuzcode_quote'] = '请输入要插入的引用';
lang['post_discuzcode_free'] = '请输入要插入的免费信息';
lang['post_discuzcode_hide'] = '请输入要插入的隐藏内容';
var editorcss = 'forumdata/cache/style_<?=STYLEID?>.css';
var editorcss_append = 'forumdata/cache/style_<?=STYLEID?>_append.css';
var TABLEBG = '<?=TABLEBG?>';
</script>
<script src="include/javascript/calendar.js" type="text/javascript"></script>
<th valign="top">
	<label for="posteditor_textarea">
	<? if($special == 1) { ?>
		背景资料
	<? } elseif($thread['special'] == 2 && $isfirstpost) { ?>
		柜台商品介绍
	<? } elseif($thread['special'] == 2 && $special == 2) { ?>
		商品描述
	<? } elseif($special == 3 && $allowpostreward) { ?>
		补充资料
	<? } elseif($special == 4 && $allowpostactivity) { ?>
		活动说明
	<? } elseif($special == 5) { ?>
		<? if($allowpostdebate && $isfirstpost || $action == 'newthread') { ?>
			背景资料
		<? } else { ?>
			立场
		<? } ?>
	<? } else { ?>
		内容
	<? } ?>
	</label>
	<div id="<?=$editorid?>_left" <? if(!$advanceeditor) { ?>style="display: none"<? } ?>>
		<ul <? if(!$advanceeditor) { ?>style="display: none"<? } ?>>
			<li>Html 代码 <em><? if($forum['allowhtml'] || $allowhtml) { ?>可用<? } else { ?>禁用<? } ?></em></li>
			<li><a href="faq.php?action=message&amp;id=32" target="_blank">表情</a> <em><? if($forum['allowsmilies']) { ?>可用<? } else { ?>禁用<? } ?></em></li>
			<li><a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a> <em><? if($forum['allowbbcode']) { ?>可用<? } else { ?>禁用<? } ?></em></li>
			<li>[img] 代码 <em><? if($forum['allowimgcode']) { ?>可用<? } else { ?>禁用<? } ?></em></li>
		</ul>
	<? if($smileyinsert) { ?>
		<div class="">
			<div id="smilieslist"><img src="<?=IMGDIR?>/loading.gif"></div>
		</div>
	<? } ?>

	<ul>
		<li><label><input type="checkbox" name="parseurloff" id="parseurloff" value="1" <?=$urloffcheck?> /> 禁用 URL 识别</label></li>
		<li><label><input type="checkbox" name="smileyoff" id="smileyoff" value="1" <?=$smileyoffcheck?> /> 禁用 <a href="faq.php?action=message&amp;id=32" target="_blank">表情</a></label></li>
		<li><label><input type="checkbox" name="bbcodeoff" id="bbcodeoff" value="1" <?=$codeoffcheck?> /> 禁用 <a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a></label></li>
		<? if($tagstatus && ($action == 'newthread' || $action == 'edit' && $isfirstpost)) { ?><li><label><input type="checkbox" name="tagoff" id="tagoff" value="1" <?=$tagoffcheck?> /> 禁用 标签解析</label></li><? } ?>
		<? if($allowhtml) { ?><li><label><input type="checkbox" name="htmlon" id="htmlon" value="1" <?=$htmloncheck?> /> 启用 Html 代码</label></li><? } ?>
		<? if($action != 'edit') { ?>
			<? if($allowanonymous) { ?><li><label><input type="checkbox" name="isanonymous" value="1" /> 使用匿名发帖</label></li><? } ?>
		<? } else { ?>
			<? if($allowanonymous || (!$allowanonymous && $orig['anonymous'])) { ?><li><label><input type="checkbox" name="isanonymous" value="1" <? if($orig['anonymous']) { ?>checked="checked"<? } ?> /> 使用匿名发帖</label></li><? } ?>
		<? } ?>
		<li><label><input type="checkbox" name="usesig" value="1" <?=$usesigcheck?>> 使用个人签名</label></li>
		<? if($action != 'edit') { ?>
			<li><label><input type="checkbox" name="emailnotify" value="1" <?=$notifycheck?>> 接收新回复邮件通知</label></li>
			<? if($action == 'newthread') { ?>
				<? if($forum['ismoderator'] && ($allowdirectpost || !$forum['modnewposts'])) { ?>
					<li><label><input type="checkbox" name="sticktopic" value="1" <?=$stickcheck?>> 主题置顶</label></li>
					<li><label><input type="checkbox" name="addtodigest" value="1" <?=$digestcheck?>> 精华帖子</label></li>
				<? } ?>
				<? if($allowuseblog && $forum['allowshare']) { ?><li><label><input type="checkbox" name="addtoblog" value="1" <?=$blogcheck?>> 加入文集</label></li><? } ?>
			<? } ?>
		<? } else { ?>
			<? if(($isorigauthor || $forum['ismoderator']) && $isfirstpost && $thread['replies'] < 1) { ?>
				<li><label><input type="checkbox" name="delete" value="1"> <b>!删除本帖</b>
				<? if($thread['special'] == 3) { ?>返还悬赏费用，不退还手续费。<? } ?></label></li>
			<? } elseif(!$isfirstpost && ($isorigauthor || $forum['ismoderator'])) { ?>
				<li><label><input type="checkbox" name="delete" value="1"> <b>!删除本帖</b></label></li>
			<? } ?>

			<? if($auditstatuson) { ?><li><label><input type="checkbox" name="audit" value="1"> <b>通过审核</b></label></li><? } ?>
		<? } ?>
</div>
</th>

<td valign="top">
	<div id="<?=$editorid?>">

	<? if($bbinsert) { ?>
		<table summary="editor" id="editor" cellpadding="0" cellspacing="0">
			<tr>
			<td id="<?=$editorid?>_controls" class="editortoolbar">
				<table summary="Editor ToolBar" cellpadding="0" cellspacing="0">
					<tr>
						<td><a id="<?=$editorid?>_cmd_bold"><img src="images/common/bb_bold.gif" title="粗体" alt="B" /></a></td>
						<td><a id="<?=$editorid?>_cmd_italic"><img src="images/common/bb_italic.gif" title="斜体" alt="I" /></a></td>
						<td><a id="<?=$editorid?>_cmd_underline"><img src="images/common/bb_underline.gif" title="下划线" alt="U" /></a></td>

						<td><img src="images/common/bb_separator.gif" alt="|" /></td>

						<td>
							<a id="<?=$editorid?>_popup_fontname" title="字体">
								<span style="width: 110px; display: block; white-space: nowrap;" id="<?=$editorid?>_font_out" class="dropmenu">字体</span>
							</a>
						</td>

						<td>
							<a id="<?=$editorid?>_popup_fontsize" title="大小">
								<span style="width: 30px; display: block;" id="<?=$editorid?>_size_out" class="dropmenu">大小</span>
							</a>
						</td>

						<td>
							<a id="<?=$editorid?>_popup_forecolor" title="颜色">
								<span style="width: 30px; display: block;" class="dropmenu"><img src="images/common/bb_color.gif" width="21" height="16" alt="" /><br /><img src="images/common/bb_clear.gif" id="<?=$editorid?>_color_bar" alt="" style="background-color:black" width="21" height="4" /></span>
							</a>
						</td>

						<td><img src="images/common/bb_separator.gif" alt="|" /></td>

						<td><a id="<?=$editorid?>_cmd_justifyleft"><img src="images/common/bb_left.gif" title="居左" alt="Align Left" /></a></td>
						<td><a id="<?=$editorid?>_cmd_justifycenter"><img src="images/common/bb_center.gif" title="居中" alt="Align Center" /></a></td>
						<td><a id="<?=$editorid?>_cmd_justifyright"><img src="images/common/bb_right.gif" title="居右" alt="Align Right" /></a></td>

						<td><img src="images/common/bb_separator.gif" alt="|" /></td>

						<td><a id="<?=$editorid?>_cmd_createlink"><img src="images/common/bb_url.gif" title="插入链接" alt="Url" /></a></td>
						<td><a id="<?=$editorid?>_cmd_email"><img src="images/common/bb_email.gif" title="插入邮箱链接" alt="Email" /></a></td>
						<td><a id="<?=$editorid?>_cmd_insertimage"><img src="images/common/bb_image.gif" title="插入图片" alt="Image" /></a></td>
						<? if($forum['allowmediacode']) { ?>
							<td><a id="<?=$editorid?>_popup_media"><img src="images/common/bb_media.gif" title="插入多媒体文件" alt="Media" /></a></td>
						<? } ?>

						<td><img src="images/common/bb_separator.gif" alt="|" /></td>

						<td><a id="<?=$editorid?>_cmd_quote"><img src="images/common/bb_quote.gif" title="插入引用" alt="Quote" /></a></td>
						<td><a id="<?=$editorid?>_cmd_code"><img src="images/common/bb_code.gif" title="插入代码" alt="Code" /></a></td>

					</tr>
				</table>

				<table summary="Editor ToolBar" cellpadding="0" cellspacing="0" id="<?=$editorid?>_morebuttons0" <? if(!$advanceeditor) { ?>style="display: none"<? } ?>>
					<tr>

					<td><a id="<?=$editorid?>_cmd_removeformat"><img src="images/common/bb_removeformat.gif" title="清除文本格式" alt="Rremove Format" /></a></td>
					<td><a id="<?=$editorid?>_cmd_unlink"><img src="images/common/bb_unlink.gif" title="移除链接" alt="Unlink" /></a></td>
					<td><a id="<?=$editorid?>_cmd_undo"><img src="images/common/bb_undo.gif" title="撤销" alt="Undo" /></a></td>
					<td><a id="<?=$editorid?>_cmd_redo"><img src="images/common/bb_redo.gif" title="重做" alt="Redo" /></a></td>

					<td><img src="images/common/bb_separator.gif" alt="|" /></td>

					<td><a id="<?=$editorid?>_cmd_insertorderedlist"><img src="images/common/bb_orderedlist.gif" title="排序的列表" alt="Ordered List" /></a></td>
					<td><a id="<?=$editorid?>_cmd_insertunorderedlist"><img src="images/common/bb_unorderedlist.gif" title="未排序列表" alt="Unordered List" /></a></td>
					<td><a id="<?=$editorid?>_cmd_outdent"><img src="images/common/bb_outdent.gif" title="减少缩进" alt="Outdent" /></a></td>
					<td><a id="<?=$editorid?>_cmd_indent"><img src="images/common/bb_indent.gif" title="增加缩进" alt="Indent" /></a></td>
					<td><a id="<?=$editorid?>_cmd_floatleft"><img src="images/common/bb_floatleft.gif" title="左浮动" alt="Float Left" /></a></td>
					<td><a id="<?=$editorid?>_cmd_floatright"><img src="images/common/bb_floatright.gif" title="右浮动" alt="Float Right" /></a></td>

					<td><img src="images/common/bb_separator.gif" alt="|" /></td>

					<td><a id="<?=$editorid?>_cmd_table"><img src="images/common/bb_table.gif" title="插入表格" alt="Table" /></a></td>

					<td><a id="<?=$editorid?>_cmd_free"><img src="images/common/bb_free.gif" title="插入免费信息" alt="Free" /></a></td>
					<? if($allowhidecode) { ?><td><a id="<?=$editorid?>_cmd_hide"><img src="images/common/bb_hide.gif" title="插入隐藏内容" alt="Hide" /></a></td><? } ?>

					<td><img src="images/common/bb_separator.gif" alt="|" /></td>
					<? if($forum['allowbbcode'] && $allowcusbbcode) { $cusnum=0; if(is_array($_DCACHE['bbcodes_display'])) { foreach($_DCACHE['bbcodes_display'] as $tag => $bbcode) { ?><td><a id="<?=$editorid?>_cmd_custom<?=$bbcode['params']?>_<?=$tag?>"><img src="images/common/<?=$bbcode['icon']?>" title="<?=$bbcode['explanation']?>" alt="<?=$tag?>" /></a></td><? if(in_array($cusnum++, array(5, 25))) { ?></tr></table><table summary="Editor ToolBar" cellpadding="0" cellspacing="0" id="<?=$editorid?>_morebuttons<? if($cusnum == 6) { ?>1<? } else { ?>2<? } ?>" <? if(!$advanceeditor) { ?>style="display: none"<? } ?>><tr><? } } } } ?>
					</tr>
				</table>

				<div id="<?=$editorid?>_switcher" class="editor_switcher_bar">
					<a id="<?=$editorid?>_buttonctrl" class="right"><? if($advanceeditor) { ?>简单功能<? } else { ?>全部功能<? } ?></a>
					<button type="button" id="bbcodemode">Discuz! 代码模式</button>
					<button type="button" id="wysiwygmode">所见即所得模式</button>
				</div>

				</td>
			</tr>
			<tr>
				<td class="editortoolbar"><? $fontoptions = array("仿宋_GB2312", "黑体", "楷体_GB2312", "宋体", "新宋体", "微软雅黑", "Trebuchet MS", "Tahoma", "Arial", "Impact", "Verdana", "Times New Roman") ?><div class="popupmenu_popup fontname_menu" id="<?=$editorid?>_popup_fontname_menu" style="display: none">
					<ul unselectable="on"><? if(is_array($fontoptions)) { foreach($fontoptions as $fontname) { ?>							<li onclick="discuzcode('fontname', '<?=$fontname?>');hideMenu()" style="font-family: <?=$fontname?>" unselectable="on"><?=$fontname?></li>
					<? } } ?></ul>
					</div><? $sizeoptions = array(1, 2, 3, 4, 5, 6, 7) ?><div class="popupmenu_popup fontsize_menu" id="<?=$editorid?>_popup_fontsize_menu" style="display: none">
					<ul unselectable="on"><? if(is_array($sizeoptions)) { foreach($sizeoptions as $size) { ?>							<li onclick="discuzcode('fontsize', <?=$size?>);hideMenu()" unselectable="on"><font size="<?=$size?>" unselectable="on"><?=$size?></font></li>
					<? } } ?></ul>
					</div>

					<? if($forum['allowmediacode']) { ?>
						<div class="popupmenu_popup" id="<?=$editorid?>_popup_media_menu" style="width: 240px;display: none">
						<input type="hidden" id="<?=$editorid?>_mediatype" value="ra">
						<input type="hidden" id="<?=$editorid?>_mediaautostart" value="0">
						<table cellpadding="4" cellspacing="0" border="0" unselectable="on">
						<tr class="popupmenu_option">
							<td nowrap>
								请输入多媒体文件的地址:<br />
								<input id="<?=$editorid?>_mediaurl" size="40" value="" onkeyup="setmediatype('<?=$editorid?>')" />
							</td>
						</tr>
						<tr class="popupmenu_option">
							<td nowrap>
								<label style="float: left; width: 32%"><input type="radio" name="<?=$editorid?>_mediatyperadio" id="<?=$editorid?>_mediatyperadio_ra" onclick="$('<?=$editorid?>_mediatype').value = 'ra'" checked="checked">RA</label>
								<label style="float: left; width: 32%"><input type="radio" name="<?=$editorid?>_mediatyperadio" id="<?=$editorid?>_mediatyperadio_wma" onclick="$('<?=$editorid?>_mediatype').value = 'wma'">WMA</label>
								<label style="float: left; width: 32%"><input type="radio" name="<?=$editorid?>_mediatyperadio" id="<?=$editorid?>_mediatyperadio_mp3" onclick="$('<?=$editorid?>_mediatype').value = 'mp3'">MP3</label>
								<label style="float: left; width: 32%"><input type="radio" name="<?=$editorid?>_mediatyperadio" id="<?=$editorid?>_mediatyperadio_rm" onclick="$('<?=$editorid?>_mediatype').value = 'rm'">RM/RMVB</label>
								<label style="float: left; width: 32%"><input type="radio" name="<?=$editorid?>_mediatyperadio" id="<?=$editorid?>_mediatyperadio_wmv" onclick="$('<?=$editorid?>_mediatype').value = 'wmv'">WMV</label>
								<label style="float: left; width: 32%"><input type="radio" name="<?=$editorid?>_mediatyperadio" id="<?=$editorid?>_mediatyperadio_mov" onclick="$('<?=$editorid?>_mediatype').value = 'mov'">MOV</label>
							</td>
						</tr>
						<tr class="popupmenu_option">
							<td nowrap>
								<label style="float: left; width: 32%">宽: <input id="<?=$editorid?>_mediawidth" size="5" value="400" /></label>
								<label style="float: left; width: 32%">高: <input id="<?=$editorid?>_mediaheight" size="5" value="300" /></label>
								<label style="float: left; width: 32%"><input type="checkbox" onclick="$('<?=$editorid?>_mediaautostart').value = this.checked ? 1 : 0"> 自动播放</label>
							</td>
						</tr>

						<tr class="popupmenu_option">
							<td align="center" colspan="2"><input type="button" size="8" value="提交" onclick="setmediacode('<?=$editorid?>')"> <input type="button" onclick="hideMenu()" value="取消" /></td>
						</tr>
						</table>
						</div>
					<? } $coloroptions = array('Black', 'Sienna', 'DarkOliveGreen', 'DarkGreen', 'DarkSlateBlue', 'Navy', 'Indigo', 'DarkSlateGray', 'DarkRed', 'DarkOrange', 'Olive', 'Green', 'Teal', 'Blue', 'SlateGray', 'DimGray', 'Red', 'SandyBrown', 'YellowGreen', 'SeaGreen', 'MediumTurquoise', 'RoyalBlue', 'Purple', 'Gray', 'Magenta', 'Orange', 'Yellow', 'Lime', 'Cyan', 'DeepSkyBlue', 'DarkOrchid', 'Silver', 'Pink', 'Wheat', 'LemonChiffon', 'PaleGreen', 'PaleTurquoise', 'LightBlue', 'Plum', 'White') ?><div class="popupmenu_popup" id="<?=$editorid?>_popup_forecolor_menu" style="display: none">
					<table cellpadding="0" cellspacing="0" border="0" unselectable="on" style="width: auto;"><tr><? if(is_array($coloroptions)) { foreach($coloroptions as $key => $colorname) { ?><td class="editor_colornormal" onclick="discuzcode('forecolor', '<?=$colorname?>');hideMenu()" unselectable="on" onmouseover="colorContext(this, 'mouseover')" onmouseout="colorContext(this, 'mouseout')"><div style="background-color: <?=$colorname?>" unselectable="on"></div></td><? if(($key + 1) % 8 == 0) { ?></tr><tr><? } } } ?></tr></table></div>
				</td>
			</tr>
		</table>
	<? } ?>

	<table class="editor_text" summary="Message Textarea" cellpadding="0" cellspacing="0" style="table-layout: fixed;">
		<tr>
			<td>
				<textarea class="autosave" name="message" rows="10" cols="60" style="width:99%; height:250px" tabindex="100" id="<?=$editorid?>_textarea"><? if($action == 'edit') { ?><?=$postinfo['message']?><? } else { ?><?=$message?><? } ?></textarea>
			</td>
		</tr>
	</table>

	<div id="<?=$editorid?>_bottom" <? if(!$advanceeditor) { ?>style="border-top: none; display: none"<? } ?>>

		<table summary="Enitor Buttons" cellpadding="0" cellspacing="0" class="editor_button" style="border-top: none;">
			<tr>
				<td style="border-top: none;">
					<div class="editor_textexpand">
						<img src="images/common/bb_contract.gif" width="11" height="21" title="收缩编辑框" alt="收缩编辑框" id="<?=$editorid?>_contract" /><img src="images/common/bb_expand.gif" width="12" height="21" title="扩展编辑框" alt="扩展编辑框" id="<?=$editorid?>_expand" />
					</div>
					</td>
				<td align="right" style="border-top: none;">
					<button type="button" id="checklength">字数检查</button>
					<button type="button" name="previewbutton" id="previewbutton" tabindex="102">预览帖子</button>
					<button type="button" tabindex="103" id="clearcontent">清空内容</button>
				</td>
			</tr>
		</table>

		<? if($allowpostattach) { ?>
			<table class="box" summary="Upload" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>上传附件</th>
						<? if($allowsetattachperm) { ?><td class="nums">阅读权限</td><? } ?>
						<? if($maxprice) { ?><td class="nums">售价</td><? } ?>
						<td>描述</td>
					</tr>
				</thead>
				<tbody id="attachbodyhidden" style="display:none"><tr>
					<th>
						<input type="file" name="attach[]" />
						<span id="localfile[]"></span>
						<input type="hidden" name="localid[]" />
					</th>
					<? if($allowsetattachperm) { ?><td class="nums"><input type="text" name="attachperm[]" value="0" size="1" /></td><? } ?>
					<? if($maxprice) { ?><td class="nums"><input type="text" name="attachprice[]" value="0" size="1" /><?=$extcredits[$creditstrans]['unit']?></td><? } ?>
					<td><input type="text" name="attachdesc[]" size="25" /></td>
				</tr></tbody>
				<tbody id="attachbody"></tbody>
				<tr><td colspan="5" style="border-bottom: none;">
					文件尺寸: <strong><? if($maxattachsize_kb) { ?>小于 <?=$maxattachsize_kb?> kb <? } else { ?>大小不限制<? } ?></strong><br />
					<? if($attachextensions) { ?>可用扩展名: <strong><?=$attachextensions?></strong><br /><? } ?>
					<? if($maxprice) { ?>售价: <strong>最高 <?=$maxprice?> <?=$extcredits[$creditstrans]['unit']?><?=$extcredits[$creditstrans]['title']?><? if($maxincperthread) { ?>，单一主题作者最高收入 <?=$maxincperthread?> <?=$extcredits[$creditstrans]['unit']?><? } if($maxchargespan) { ?>，最高出售时限 <?=$maxchargespan?> 小时<? } } ?></strong>
				</td></tr>
			</table>
			<div id="img_hidden" alt="1" style="position:absolute;top:-100000px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='image');width:<?=$thumbwidth?>px;height:<?=$thumbheight?>px"></div>
		<? } ?>
	</div>
</div>
</td>