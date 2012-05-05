<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); if(!$inajax) { ?>
	<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; 提示信息</div>

	<div class="box message">
		<h1><?=$bbname?> 提示信息</h1>

		<p><?=$show_message?></p>

	<? if(in_array($message, array('post_reply_succeed', 'post_reply_blog_succeed', 'post_newthread_blog_succeed', 'post_newthread_succeed', 'post_edit_delete_succeed', 'post_edit_succeed'))) { ?>
		<input type="hidden" id="textarea">
		<script src="include/javascript/post.js" type="text/javascript"></script>
		<script type="text/javascript">
			if(is_ie) {
				var textobj = $('textarea');
				textobj.addBehavior('#default#userData');
				deleteData();
			}
		</script>
	<? } ?>

	<? if($url_forward) { ?>
		<p><a href="<?=$url_forward?>">如果您的浏览器没有自动跳转，请点击这里</a></p>
	<? } elseif(stristr($show_message, '返回')) { ?>
		<p><a href="javascript:history.back()">[ 点击这里返回上一页 ]</a></p>
	<? } ?>

	</div>
<? } else { ?><?=$show_message?><? if($extra == 'HALTED' || $extra == 'NOPERM' || $extra == 'AJAXERROR') { ?><script type="text/javascript" reload="1">

function ajaxerror() {
	alert('<?=$show_message?>');
}

ajaxerror();

</script><? } } include template('footer'); ?>
