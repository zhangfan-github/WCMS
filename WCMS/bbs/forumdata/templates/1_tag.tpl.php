<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="foruminfo">
	<div id="headsearch">
	<form method="get" action="tag.php">
		<input type="text" name="name" />
		&nbsp;<button type="submit">搜索</button>
	</form>
	</div>
	<div id="nav"><a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <a href="tag.php">标签</a></div>
</div>

<div class="mainbox">
	<h1>热门标签</h1>
	<ul class="taglist">
		<? if($hottags) { if(is_array($hottaglist)) { foreach($hottaglist as $tag) { ?>			<li><a href="tag.php?name=<?=$tag['tagnameenc']?>" target="_blank"><?=$tag['tagname']?></a><em>(<?=$tag['total']?>)</em></li>
		<? } } } else { ?>
			<li>标签信息不存在</li>
		<? } ?>
	</ul>
</div>

<div class="mainbox">
	<h3>随机标签</h3>
	<ul class="taglist">
		<? if($randtaglist) { if(is_array($randtaglist)) { foreach($randtaglist as $tag) { ?>			<li><a href="tag.php?name=<?=$tag['tagnameenc']?>" target="_blank"><?=$tag['tagname']?></a><em>(<?=$tag['total']?>)</em></li>
		<? } } } else { ?>
			<li>标签信息不存在</li>
		<? } ?>
	</ul>
</div>
<? include template('footer'); ?>
