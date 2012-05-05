<? if(!defined('IN_DISCUZ')) exit('Access Denied'); // Space Module Template Functions for Discuz! Version 1.0.0

function threadspecial($thread) {
 if($thread['special'] == 1) { ?>
		<img src="images/default/pollsmall.gif" alt="投票" border="0" />
	<? } elseif($thread['special'] == 2) { ?>
		<img src="images/default/tradesmall.gif" alt="商品" border="0" />
	<? } elseif($thread['special'] == 3) { ?>
		<? if($thread['price'] > 0) { ?>
		 	<img src="images/default/rewardsmall.gif" alt="悬赏" border="0" />
		<? } elseif($thread['price'] < 0) { ?>
			<img src="images/default/rewardsmallend.gif" alt="悬赏已解决" border="0" />
		<? } ?>
	<? } elseif($thread['special'] == 4) { ?>
		<img src="images/default/activitysmall.gif" alt="活动" border="0" />
	<? } elseif($thread['special'] == 5) { ?>
		<img src="images/default/debatesmall.gif" alt="辩论" border="0" />
	<? } elseif($thread['special'] == 6) { ?>
		<img src="images/default/videosmall.gif" alt="视频" border="0" />
	<? } ?>
	<? if($thread['attachment']) { ?>
		<img src="images/attachicons/common.gif" alt="附件" border="0" />
	<? } }

function userinfo($moduledata) {
global $spacesettings, $uid;
list($moduledata['bio'], $moduledata['biotrade']) = explode("\t\t\t", $moduledata['bio']);
 ?><div id="module_userinfo">
	<div class="status">状态: <span><? if($moduledata['online']) { ?>当前在线<? } else { ?>当前离线<? } ?></span></div>
	<div class="info">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed; overflow: hidden">
	<tr><td align="center">
	<? if($moduledata['avatar']) { ?>
		<a href="space.php?action=viewpro&amp;uid=<?=$uid?>"><img src="<?=$moduledata['avatar']?>" width="<?=$moduledata['avatarwidth']?>" height="<?=$moduledata['avatarheight']?>" border="0" alt="" /></a>
	<? } else { ?>
		<img src="images/avatars/noavatar.gif" alt="" />
	<? } ?>
	</td></tr></table></div>
	<div class="username"><?=$moduledata['username']?><? if($moduledata['nickname']) { ?><br /><?=$moduledata['nickname']?><? } ?></div>
	<div class="operation">
	<img src="mspace/<?=$spacesettings['style']?>/sendmail.gif" alt="" /><a target="_blank" href="pm.php?action=send&amp;uid=<?=$uid?>">发短消息</a>
	<img src="mspace/<?=$spacesettings['style']?>/buddy.gif"alt="" /><a target="_blank" href="my.php?item=buddylist&amp;newbuddyid=<?=$uid?>&amp;buddysubmit=yes" id="ajax_buddy" onclick="ajaxmenu(event, this.id)">加为好友</a>
	</div>
	<? if($moduledata['bio']) { ?>
	<div class="more">
	<br /><?=$moduledata['bio']?>
	</div>
	<? } ?>
	</div><? }

function viewcalendar($moduledata) {
global $timestamp, $uid;
 ?><table id="module_calendar" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
	<tr class="header"><td colspan="7">
	<table cellspacing="0" cellpadding="0" width="100%"><tr>
	<td width="30%" align="right"><a href="space.php?<?=$uid?>/myblogs/<?=$moduledata['pstarttime']?>/<?=$moduledata['pendtime']?>">&laquo;</a></td>
	<td width="40%" align="center" nowrap><?=$moduledata['curtime']?></td>
	<td width="30%" align="left">
	<? if($moduledata['nstarttime'] < $timestamp) { ?>
		<a href="space.php?<?=$uid?>/myblogs/<?=$moduledata['nstarttime']?>/<?=$moduledata['nendtime']?>">&raquo;</a>
	<? } ?>
	&nbsp;</td></tr></table></td></tr>
	<tr class="header1" align="center"><td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr>
	<?=$moduledata['html']?>
	</table><? }

function mythreads($moduledata, $center = '') {
global $discuz_uid, $mod, $multipage, $_DCACHE, $dateformat, $timeformat, $timeoffset;
 ?><div id="module_mythreads">
	<? if($mod) { ?>
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr class="list_category"><td class="subject">标题</td><td class="forum">版块</td><td class="views">回复/查看</td><td class="lastpost">最后发表</td></tr><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<tr>
			<td class="subject"><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></td>
			<td class="forum"><a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a></td>
			<td class="views"><?=$thread['replies']?> / <?=$thread['views']?></td>
			<td class="lastpost"><a target="_blank" href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost#lastpost"><? echo gmdate("$dateformat $timeformat", $thread['lastpost'] + $timeoffset * 3600);; ?></a><br />
				by <? if($thread['lastposter']) { ?><a href="space.php?username=<? echo rawurlencode($thread['lastposter']); ?>" target="_blank"><?=$thread['lastposter']?></a><? } else { ?>匿名<? } ?></td>
			</tr>
		<? } } ?></table>
		<div class="line"></div>
		<?=$multipage?>
	<? } elseif($center) { ?>
		<div class="center"><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<div class="center_subject"><ul><li><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></li></ul></div>
			<div class="center_lastpost">
				<a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a> | <a target="_blank" href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost#lastpost"><? echo gmdate("$dateformat $timeformat", $thread['lastpost'] + $timeoffset * 3600);; ?></a>
			</div>
			<div class="center_message">
				<?=$thread['message']?>
			</div>
			<div class="center_views">
				<? if($thread['authorid'] == $discuz_uid) { ?><a target="_blank" href="post.php?action=edit&amp;fid=<?=$thread['fid']?>&amp;tid=<?=$thread['tid']?>&amp;pid=<?=$thread['pid']?>">编辑</a> |<? } ?>
				查看(<?=$thread['views']?>) |
				<a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank">回复(<?=$thread['replies']?>)</a> | <a target="_blank" href="my.php?item=favorites&amp;tid=<?=$thread['tid']?>" id="ajax_favorite_t<?=$thread['tid']?>" onclick="ajaxmenu(event, this.id)">收藏</a>
			</div>
		<? } } ?></div>
	<? } else { ?>
		<div class="side"><ul><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<li><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></li>
		<? } } ?></ul></div>
	<? } ?>
	</div><? }

function myreplies($moduledata, $center = '') {
global $mod, $multipage, $_DCACHE, $dateformat, $timeformat, $timeoffset;
 ?><div id="module_myreplies">
	<? if($mod) { ?>
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr class="list_category"><td class="subject">标题</td><td class="forum">版块</td><td class="views">回复/查看</td><td class="lastpost">最后发表</td></tr><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<tr>
			<td class="subject"><a href="redirect.php?goto=findpost&amp;pid=<?=$thread['pid']?>&amp;ptid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></td>
			<td class="forum"><a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a></td>
			<td class="views"><?=$thread['replies']?> / <?=$thread['views']?></td>
			<td class="lastpost"><a target="_blank" href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost#lastpost"><? echo gmdate("$dateformat $timeformat", $thread['lastpost'] + $timeoffset * 3600);; ?></a><br />
				by <? if($thread['lastposter']) { ?><a href="space.php?username=<? echo rawurlencode($thread['lastposter']); ?>" target="_blank"><?=$thread['lastposter']?></a><? } else { ?>匿名<? } ?></td>
			</tr>
		<? } } ?></table>
		<div class="line"></div>
		<?=$multipage?>
	<? } elseif($center) { ?>
		<div class="center"><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<div class="center_subject"><ul><li><a href="redirect.php?goto=findpost&amp;pid=<?=$thread['pid']?>&amp;ptid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></li></ul></div>
			<div class="center_lastpost">
				<a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a> | <a target="_blank" href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost#lastpost"><? echo gmdate("$dateformat $timeformat", $thread['lastpost'] + $timeoffset * 3600);; ?></a>
			</div>
			<div class="center_message">
				<?=$thread['message']?>
			</div>
			<div class="center_views">
				查看(<?=$thread['views']?>) |
				<a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank">回复(<?=$thread['replies']?>)</a> | <a target="_blank" href="my.php?item=favorites&amp;tid=<?=$thread['tid']?>" id="ajax_favorite_r<?=$thread['tid']?>" onclick="ajaxmenu(event, this.id)">收藏</a>
			</div>
		<? } } ?></div>
	<? } else { ?>
		<div class="side"><ul><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<li><a href="redirect.php?goto=findpost&amp;pid=<?=$thread['pid']?>&amp;ptid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></li>
		<? } } ?></ul></div>
	<? } ?>
	</div><? }

function myrewards($moduledata, $center = '') {
global $mod, $multipage, $_DCACHE, $dateformat, $timeformat, $timeoffset, $extcredits, $creditstrans;
 ?><div id="module_myrewards">
	<? if($mod) { ?>
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr class="list_category"><td class="subject">标题</td><td class="forum">版块</td><td class="price">悬赏总额</td></tr><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<tr>
			<td class="subject"><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><?=$thread['subject']?></a></td>
			<td class="forum"><a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a></td>
			<td class="price">
			<? if($thread['answererid']) { ?>
				悬赏已解决: <a href="space.php?uid=<?=$thread['answererid']?>" target="_blank"><?=$thread['username']?></a>
			<? } else { ?>
				<?=$thread['price']?> <?=$extcredits[$creditstrans]['unit']?>
			<? } ?>
			</td></tr>
		<? } } ?></table>
		<div class="line"></div>
		<?=$multipage?>
	<? } elseif($center) { ?>
		<div class="center"><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<div class="center_subject"><ul><li><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><?=$thread['subject']?></a></li></ul></div>
			<div class="center_lastpost">
				<a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a>
				<? if($thread['answererid']) { ?>
				悬赏已解决: <a href="space.php?uid=<?=$thread['answererid']?>" target="_blank"><?=$thread['username']?></a>
				<? } else { ?>
					悬赏: <?=$thread['price']?> <?=$extcredits[$creditstrans]['unit']?>
				<? } ?>
			</div>
			<div class="center_message">
				<?=$thread['message']?>
			</div>
			<div class="center_views">
				查看(<?=$thread['views']?>) |
				<a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank">回复(<?=$thread['replies']?>)</a> | <a target="_blank" href="my.php?item=favorites&amp;tid=<?=$thread['tid']?>" id="ajax_favorite_w<?=$thread['tid']?>" onclick="ajaxmenu(event, this.id)">收藏</a>
			</div>
		<? } } ?></div>
	<? } else { ?>
		<table cellspacing="0" cellpadding="0" width="100%"><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<tr>
			<td class="side_subject"><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><?=$thread['subject']?></a></td>
			<td class="side_answerer">
			<? if($thread['answererid']) { ?>
				<a href="space.php?uid=<?=$thread['answererid']?>" target="_blank"><?=$thread['username']?></a>
			<? } else { ?>
				<?=$thread['price']?> <?=$extcredits[$creditstrans]['unit']?>
			<? } ?>
			</td></tr>
		<? } } ?></table>
	<? } ?>
	</div><? }

function mytrades($moduledata, $center = '') {
global $mod, $multipage, $_DCACHE, $dateformat, $timeformat, $timeoffset, $tradeimagewidth, $tradeimageheight, $tradetypeid;
 ?><div id="module_mytrades">
	<? if($mod || $center) { if(is_array($moduledata)) { foreach($moduledata as $trade) { format_expiration($trade); ?><div style="float: left;width: 30%; margin:5px;text-align: center">
			<table cellspacing="0" cellpadding="0" style="width: 80%"><tr><td height="100" align="center" valign="top">
			<a href="viewthread.php?do=tradeinfo&amp;tid=<?=$trade['tid']?>&amp;pid=<?=$trade['pid']?>" target="_blank">
			<img border="0" <? if($trade['aid']) { ?>src="attachment.php?aid=<?=$trade['aid']?>"<? } else { ?>src="images/default/trade_nophoto.gif"<? } ?> onload="thumbImg(this)" width="96" height="96" alt="<?=$trade['subject']?>" />
			</a></td></tr></table>
			<div class="item" style="height: 100px">
			<a class="subject" href="viewthread.php?do=tradeinfo&amp;tid=<?=$trade['tid']?>&amp;pid=<?=$trade['pid']?>" target="_blank"><?=$trade['subject']?></a><br />
			<? if($trade['costprice'] > 0) { ?>
				商品原价: <span style="text-decoration: line-through"><?=$trade['costprice']?></span> 元<br />
			<? } ?>
			商品现价: <span class="price"><?=$trade['price']?></span> 元<br />
			<span class="expiration">
			<? if($trade['closed']) { ?>
				成交结束
			<? } elseif($trade['expiration'] > 0) { ?>
				剩余 <?=$trade['expiration']?>天
			<? } elseif($trade['expiration'] == -1) { ?>
				成交结束
			<? } ?>
			</span>
			</div></div>
		<? } } if(isset($tradetypeid)) { ?>
			<div class="line" style="clear: both"></div>
			<?=$multipage?>
		<? } ?>
	<? } else { if(is_array($moduledata)) { foreach($moduledata as $trade) { format_expiration($trade); ?><div class="item">
			<span class="side_price"><span class="price"><?=$trade['price']?></span> 元</span>
			<a class="side_subject" href="viewthread.php?do=tradeinfo&amp;tid=<?=$trade['tid']?>&amp;pid=<?=$trade['pid']?>" target="_blank"><?=$trade['subject']?></a><br />
			</div>
		<? } } } ?>
	</div><? }

function myvideos($moduledata, $center = '') {
global $mod, $multipage, $dateformat, $timeformat, $timeoffset;
 ?><div id="module_myvideos">
	<? if($mod) { if(is_array($moduledata)) { foreach($moduledata as $video) { ?>			<div style="float: left;width: 45%; margin:5px;text-align: center">
			<table cellspacing="0" cellpadding="0" style="width: 80%"><tr><td height="96" align="center" valign="middle">
			<a href="viewthread.php?tid=<?=$video['tid']?>" target="_blank"><img src="<?=$video['vthumb']?>" alt="<?=$video['vtitle']?>" width="124" height="94" border="0" /></a></td></tr></table>
			<div class="item" style="height: 80px">
			<?=$video['vtitle']?><br />
			发布时间: <? echo gmdate("$dateformat $timeformat", $video['dateline'] + $timeoffset * 3600);; ?><br />
			播放次数: <?=$video['vview']?><br />
			<? if($video['vtime']) { ?>片长: <?=$video['vtime']?> 分钟<? } ?>
			</div></div>
		<? } } } else { if(is_array($moduledata)) { foreach($moduledata as $video) { ?>			<a href="viewthread.php?tid=<?=$video['tid']?>" target="_blank"><img src="<?=$video['vthumb']?>" alt="<?=$video['vtitle']?>" width="124" height="94" border="0" /></a><br /><?=$video['vtitle']?><br /><br />
		<? } } } ?>
	</div><? }

function mytradetypes($moduledata) {
global $uid, $tradetypes;

 ?><div id="module_userinfo">
		<ul>
		<li><a href="space.php?uid=<?=$uid?>&amp;mod=mytrades">店铺首页</a></li>
		<li><a href="space.php?uid=<?=$uid?>&amp;mod=mytrades&amp;tradetypeid=all">所有商品</a></li>
		<li><a href="space.php?uid=<?=$uid?>&amp;mod=mytrades&amp;tradetypeid=stick">推荐商品</a></li><? if(is_array($moduledata)) { foreach($moduledata as $typeid) { ?>			<li><a href="space.php?uid=<?=$uid?>&amp;mod=mytrades&amp;tradetypeid=<?=$typeid['typeid']?>"><? if($typeid['typeid']) { ?><?=$tradetypes[$typeid['typeid']]?><? } else { ?>无类别商品<? } ?></a></li>
		<? } } ?></ul>
	</div><? }

function mycounters($moduledata, $center = '') {
global $_DCACHE, $multipage;
 ?><div id="module_mythreads">
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr class="list_category"><td class="subject">标题</td><td class="forum">版块</td><td class="views">回复/查看</td></tr><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<tr>
			<td class="subject"><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></td>
			<td class="forum"><a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a></td>
			<td class="views"><?=$thread['replies']?> / <?=$thread['views']?></td>
			</tr>
		<? } } ?></table>
		<div class="line"></div>
		<?=$multipage?>
	</div><? }

function tradeinfo($moduledata) {
global $spacesettings, $uid;
list($moduledata['bio'], $moduledata['biotrade']) = explode("\t\t\t", $moduledata['bio']);
 ?><div id="module_userinfo"><div class="more">
	<?=$moduledata['biotrade']?>
	</div></div><? }

function myblogs($moduledata, $center = '') {
global $discuz_uid, $mod, $multipage, $_DCACHE, $dateformat, $timeformat, $timeoffset;
 ?><div id="module_myblogs">
	<? if($mod || $center) { ?>
		<div class="center"><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<div class="center_subject"><ul><li><a target="_blank" href="blog.php?tid=<?=$thread['tid']?>"><? threadspecial($thread); ?><?=$thread['subject']?></a></li></ul></div>
			<div class="center_lastpost">
				<a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a> | <? echo gmdate("$dateformat", $thread['dateline'] + $timeoffset * 3600);; ?></div>
			<div class="center_message">
				<?=$thread['message']?>
			</div>
			<div class="center_views">
				<? if($thread['authorid'] == $discuz_uid) { ?><a target="_blank" href="post.php?action=edit&amp;fid=<?=$thread['fid']?>&amp;tid=<?=$thread['tid']?>&amp;pid=<?=$thread['pid']?>">编辑</a> |<? } ?>
				查看(<?=$thread['views']?>) |
				<a target="_blank" href="blog.php?tid=<?=$thread['tid']?>">评论(<?=$thread['replies']?>)</a> | <a target="_blank" href="my.php?item=favorites&amp;tid=<?=$thread['tid']?>" id="ajax_favorite_b<?=$thread['tid']?>" onclick="ajaxmenu(event, this.id)">收藏</a>
			</div>
		<? } } ?></div>
		<? if($mod) { ?>
			<div class="line"></div>
			<?=$multipage?>
		<? } ?>
	<? } else { ?>
		<div class="side"><ul><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<li><a target="_blank" href="blog.php?tid=<?=$thread['tid']?>"><? threadspecial($thread); ?><?=$thread['subject']?></a></li>
		<? } } ?></ul></div>
	<? } ?>
	</div><? }

function postblog() {
global $mod, $forumselect;
 ?><div id="module_postblog">
	<form method="get" action="post.php">
	<input type="hidden" name="action" value="newthread">
	<input type="hidden" name="isblog" value="yes">
	<br /><select name="fid" style="width: 92%"><?=$forumselect?></select><br />
	<br /><input class="button" type="submit" value="提交"><br /><br />
	</form>
	</div><? }

function hotblog($moduledata) {
global $starttime, $endtime;
 ?><div id="module_hotblog"><ul><? if(is_array($moduledata)) { foreach($moduledata as $blog) { ?>		<li><a href="blog.php?tid=<?=$blog['tid']?>" target="_blank" title="<?=$blog['views']?> 查看, <?=$blog['replies']?> 评论"><?=$blog['subject']?></a></li>
	<? } } ?></ul></div><? }

function lastpostblog($moduledata) {
global $starttime, $endtime;
 ?><div id="module_hotblog"><ul><? if(is_array($moduledata)) { foreach($moduledata as $blog) { ?>		<li><a href="blog.php?tid=<?=$blog['tid']?>" target="_blank" title="<?=$blog['views']?> 查看, <?=$blog['replies']?> 评论"><?=$blog['subject']?></a></li>
	<? } } ?></ul></div><? }

function myfavforums($moduledata, $center = '') {
global $mod, $multipage;
 ?><div id="module_myfavforums">
	<? if($mod) { ?>
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr class="list_category"><td class="forum">版块</td><td class="threads">主题</td><td class="posts">帖数</td><td class="todayposts">今日</td></tr><? if(is_array($moduledata)) { foreach($moduledata as $forum) { ?>			<tr>
			<td class="forum"><a href="forumdisplay.php?fid=<?=$forum['fid']?>" target="_blank"><?=$forum['name']?></a></td>
			<td class="threads"><?=$forum['threads']?></td>
			<td class="posts"><?=$forum['posts']?></td>
			<td class="todayposts"><?=$forum['todayposts']?></td>
			</tr>
		<? } } ?></table>
		<div class="line"></div>
		<?=$multipage?>
	<? } else { ?>
		<div class="side"><ul><? if(is_array($moduledata)) { foreach($moduledata as $forum) { ?>			<li><a href="forumdisplay.php?fid=<?=$forum['fid']?>" target="_blank"><?=$forum['name']?></a> <? if($forum['todayposts']) { ?>(<?=$forum['todayposts']?>)<? } ?></li>
		<? } } ?></ul></div>
	<? } ?>
	</div><? }

function myfavthreads($moduledata, $center = '') {
global $mod, $multipage, $_DCACHE, $dateformat, $timeformat, $timeoffset;
 ?><div id="module_myfavthreads">
	<? if($mod) { ?>
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr class="list_category"><td class="subject">标题</td><td class="forum">版块</td><td class="views">回复/查看</td><td class="lastpost">最后发表</td></tr><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<tr>
			<td class="subject"><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a></td>
			<td class="forum"><a href="forumdisplay.php?fid=<?=$thread['fid']?>" target="_blank"><?=$_DCACHE['forums'][$thread['fid']]['name']?></a></td>
			<td class="views"><?=$thread['replies']?> / <?=$thread['views']?></td>
			<td class="lastpost"><a target="_blank" href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost#lastpost"><? echo gmdate("$dateformat $timeformat", $thread['lastpost'] + $timeoffset * 3600);; ?></a><br />
				by <? if($thread['lastposter']) { ?><a href="space.php?username=<? echo rawurlencode($thread['lastposter']); ?>" target="_blank"><?=$thread['lastposter']?></a><? } else { ?>匿名<? } ?></td>
			</tr>
		<? } } ?></table>
		<div class="line"></div>
		<?=$multipage?>
	<? } else { ?>
		<div class="side"><ul><? if(is_array($moduledata)) { foreach($moduledata as $thread) { ?>			<li><a href="viewthread.php?tid=<?=$thread['tid']?>" target="_blank"><? threadspecial($thread); ?><?=$thread['subject']?></a> (<?=$thread['replies']?>)</li>
		<? } } ?></ul></div>
	<? } ?>
	</div><? }

function myfriends($moduledata) {
global $mod, $spacelanguage;
 ?><div id="module_myfriends"><? if(is_array($moduledata)) { foreach($moduledata as $friend) { ?>	<div class="friend"><ul><li><a href="space.php?uid=<?=$friend['uid']?>" target="_blank"><?=$friend['username']?></a></li></ul></div>
	<div class="space"><a href="space.php?uid=<?=$friend['uid']?>" target="_blank"><? if(!empty($friend['spacename'])) { ?><?=$friend['spacename']?><? } else { ?><?=$friend['username']?><?=$spacelanguage['space']?><? } ?></a></div>
	<? } } ?></div><? }

 ?>