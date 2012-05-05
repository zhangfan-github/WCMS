<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script type="text/javascript">
	if(!(is_ie >= 5 || is_moz >= 2)) {
		$('restoredata').style.display = 'none';
	}
	var editorid = '<?=$editorid?>';
	var textobj = $(editorid + '_textarea');
	var wysiwyg = (is_ie || is_moz || (is_opera >= 9)) && parseInt('<?=$editormode?>') && bbinsert == 1 ? 1 : 0;
	var allowswitcheditor = parseInt('<?=$allowswitcheditor?>');
	var allowhtml = parseInt('<?=$allowhtml?>');
	var forumallowhtml = parseInt('<?=$forum['allowhtml']?>');
	var allowsmilies = parseInt('<?=$forum['allowsmilies']?>');
	var allowbbcode = parseInt('<?=$forum['allowbbcode']?>');
	var allowimgcode = parseInt('<?=$forum['allowimgcode']?>');
	var special = parseInt('<?=$special?>');
	var BORDERCOLOR = "<?=BORDERCOLOR?>";
	var ALTBG2 = "<?=ALTBG2?>";
	var charset = '<?=$charset?>';
	var smilies = new Array();
	<? if(!empty($GLOBALS['_DCACHE']['smilies']) && is_array($GLOBALS['_DCACHE']['smilies'])) { if(is_array($_DCACHE['smilies_display'])) { foreach($_DCACHE['smilies_display'] as $typeid => $smilies) { if(is_array($smilies)) { foreach($smilies as $key => $smiley) { $smiley['code']=addcslashes($smiley['code'], '\\\''); ?>smilies[<?=$key?>] = {'code' : '<?=$smiley['code']?>', 'url' : '<?=$_DCACHE['smileytypes'][$typeid]['directory']?>/<?=$smiley['url']?>'};<? } } } } } ?>
	lang['post_autosave_none']		= "没有可以恢复的数据！";
	lang['post_autosave_confirm']		= "此操作将覆盖当前帖子内容，确定要恢复数据吗？";
	lang['post_video_uploading']		= "您还没有上传视频，或者视频还在上传中，请稍侯重试。";
	lang['post_video_vclass_required']	= "请您选择视频所属分类。";
</script>

<? if($allowpostattach) { ?>
	<script type="text/javascript">
		var thumbwidth = parseInt(<?=$thumbwidth?>);
		var thumbheight = parseInt(<?=$thumbheight?>);
		var extensions = '<?=$attachextensions?>';
		lang['post_attachment_ext_notallowed']	= '对不起，不支持上传此类扩展名的附件。';
		lang['post_attachment_img_invalid']	= '无效的图片文件。';
		lang['post_attachment_deletelink']	= '删除';
		lang['post_attachment_insert']		= '点击这里将本附件插入帖子内容中当前光标的位置';
		lang['post_attachment_insertlink']	= '插入';
	</script>
	<script src="include/javascript/post_attach.js" type="text/javascript"></script>
<? } ?>

<script src="include/javascript/post.js" type="text/javascript"></script>

<? if($bbinsert) { ?>
	<script type="text/javascript">
		var fontoptions = new Array("仿宋_GB2312", "黑体", "楷体_GB2312", "宋体", "新宋体", "微软雅黑", "Trebuchet MS", "Tahoma", "Arial", "Impact", "Verdana", "Times New Roman");
		var custombbcodes = new Array();
		<? if($forum['allowbbcode'] && $allowcusbbcode) { if(is_array($_DCACHE['bbcodes_display'])) { foreach($_DCACHE['bbcodes_display'] as $tag => $bbcode) { ?>custombbcodes["<?=$tag?>"] = {'prompt' : '<?=$bbcode['prompt']?>'};<? } } } ?>
		lang['enter_list_item']			= "输入一个列表项目.\r\n留空或者点击取消完成此列表.";
		lang['enter_link_url']			= "请输入链接的地址:";
		lang['enter_image_url']			= "请输入图片链接地址:";
		lang['enter_email_link']		= "请输入此链接的邮箱地址:";
		lang['fontname']			= "字体";
		lang['fontsize']			= "大小";
		lang['post_advanceeditor']		= "全部功能";
		lang['post_simpleeditor']		= "简单功能";
		lang['submit']				= "提交";
		lang['cancel']				= "取消";
	</script>
	<script src="include/javascript/editor.js" type="text/javascript"></script>
<? } ?>

<script src="include/javascript/bbcode.js" type="text/javascript"></script>

<? if($action == 'edit' || $action == 'reply' && $repquote) { ?>
	<script type="text/javascript">
		if(wysiwyg) {
			initialized = false;
			newEditor(1, bbcode2html(textobj.value));
		}
	</script>
<? } ?>

<script src="include/javascript/post_editor.js" type="text/javascript"></script>

<script type="text/javascript">
	$(editorid + '_contract').onclick = function() {resizeEditor(-100)};
	$(editorid + '_expand').onclick = function() {resizeEditor(100)};
	$('checklength').onclick = function() {checklength($('postform'))};
	$('previewbutton').onclick = function() {previewpost()};
	$('clearcontent').onclick = function() {clearcontent()};
	$('postform').onsubmit = function() {return validate(this);};
	<? if($action == 'newthread') { ?>
		$('subject').focus();
	<? } else { ?>
		checkFocus();
		setCaretAtEnd();
	<? } ?>
</script>

<? if($smileyinsert) { ?><script type="text/javascript">ajaxget('post.php?action=smilies', 'smilieslist');</script><? } ?>