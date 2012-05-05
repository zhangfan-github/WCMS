<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <? if(!$action) { ?>帮助<? } else { ?><a href="faq.php">帮助</a> <?=$navigation?><? } ?></div>

<? if(!$action) { ?>
	<table summary="FAQ" class="portalbox" cellpadding="0" cellspacing="1">
		<tr><? if(is_array($faqparent)) { foreach($faqparent as $parent) { ?>			<td>
			<h3><?=$parent['title']?></h3>
			<ul style="margin: 2px auto;"><? if(is_array($faqsub[$parent['id']])) { foreach($faqsub[$parent['id']] as $sub) { ?>				<li><a href="faq.php?action=message&amp;id=<?=$sub['id']?>"><?=$sub['title']?></a></li>
			<? } } ?></ul>
			</td>
		<? } } ?></tr>
	</table>
<? } elseif($action == 'message') { ?>

	<div class="box viewthread specialthread faq">
		<table summary="" cellpadding="0" cellspacing="0">
			<tr>
				<td class="postcontent">
					<h1><?=$faq['title']?></h1>
					<div class="postmessage"><?=$faq['message']?></div>
				</td>
				<? if($otherlist) { ?>
				<td valign="top" style="width: 260px; border: none;">
					<div class="box" style="margin: 8px; border: none;">
						<h4>相关帮助</h4>
						<ul style="padding: 5px; line-height: 2em;"><? if(is_array($otherlist)) { foreach($otherlist as $other) { ?>							<li><a href="faq.php?action=message&amp;id=<?=$other['id']?>"><?=$other['title']?></a></li>
							<? } } ?></ul>
					</div>
				<? } ?>
				</td>
			</tr>
		</table>
	</div>

<? } elseif($action == 'search') { if(is_array($faqlist)) { foreach($faqlist as $faq) { ?>		<div class="box viewthread specialthread faq">
		<div class="postcontent"><h1><?=$faq['title']?></h1></div>
		<div class="postmessage"><?=$faq['message']?></div>
		</div><br />
	<? } } } ?>

<div class="legend">
	<form method="post" action="faq.php?action=search&amp;searchsubmit=yes">
		<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
		搜索帮助 <input type="text" name="keyword" size="30" value="<?=$keyword?>" />
		<select name="searchtype">
			<option value="all">搜索帮助标题和内容</option>
			<option value="title">搜索帮助标题</option>
			<option value="message">搜索帮助内容</option>
		</select>&nbsp;
		<button type="submit" name="searchsubmit">提交</button>
	</form>
</div>
<? include template('footer'); ?>
