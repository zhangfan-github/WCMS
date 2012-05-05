<? if(!defined('IN_DISCUZ')) exit('Access Denied'); if(!$iscircle || !empty($frombbs)) { include template('header'); } else { include template('supesite_header'); } ?>

<script src="include/javascript/viewthread.js" type="text/javascript"></script>
<script type="text/javascript">zoomstatus = parseInt(<?=$zoomstatus?>);</script>

<div id="foruminfo">
	<div id="nav">
		<? if($forumjump && $jsmenu['1']) { ?><a href="<?=$indexname?>" id="forumlist" onmouseover="showMenu(this.id)" class="dropmenu"><?=$bbname?></a><? } else { ?><a href="<?=$indexname?>"><?=$bbname?></a><? } ?> <?=$navigation?>
	</div>
	<div id="headsearch">
	<? if(!empty($google) && ($google & 4)) { ?>
		<script src="forumdata/cache/google_var.js" type="text/javascript"></script>
		<script src="include/javascript/google.js" type="text/javascript"></script>
	<? } ?>
	<? if(!empty($qihoo['status']) && ($qihoo['searchbox'] & 4)) { ?>
		<form method="post" action="search.php?srchtype=qihoo" onSubmit="this.target='_blank';">
		<input type="hidden" name="searchsubmit" value="yes" />
		<input type="text" name="srchtxt" value="<?=$qihoo_searchboxtxt?>" size="27" class="input" style="<?=BGCODE?>" onmouseover="this.focus();this.value='';this.onmouseover=null;" onfocus="this.select()" />
		&nbsp;<button type="submit">搜索</button>
		</form>
	<? } ?>
	</div>
</div>

<? if($admode && empty($insenz['hardadstatus']) && !empty($advlist['text'])) { ?><div class="ad_text" id="ad_text"><table summary="Text Ad" cellpadding="0" cellspacing="1"><?=$advlist['text']?></table></div><? } else { ?><div id="ad_text"></div><? } if(!empty($newpmexists) || $announcepm) { ?>
	<div class="maintable" id="pmprompt">
<? include template('pmprompt'); ?>
</div>
<? } ?>

<div class="pages_btns">
	<div class="threadflow"><a href="redirect.php?fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;goto=nextoldset"> &lsaquo;&lsaquo; 上一主题</a> | <a href="redirect.php?fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;goto=nextnewset">下一主题 &rsaquo;&rsaquo;</a></div>
	<?=$multipage?>
	<? if($allowpost || !$discuz_uid) { ?>
		<span class="postbtn" id="newspecial" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu(this.id)"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>"><img src="<?=IMGDIR?>/newtopic.gif" border="0" alt="发新话题" title="发新话题" /></a></span>
	<? } ?>
	<? if($allowpostreply || !$discuz_uid) { ?><span class="replybtn"><a href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;extra=<?=$extra?>"><img src="<?=IMGDIR?>/reply.gif" border="0" alt="" /></a></span><? } ?>
</div>

<? if($allowposttrade || $allowpostpoll || $allowpostreward || $allowpostactivity || $allowpostdebate || $allowpostvideo || $forum['threadtypes'] || !$discuz_uid) { ?>
	<ul class="popupmenu_popup newspecialmenu" id="newspecial_menu" style="display: none">
		<li><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>">发新话题</a></li>
		<? if($allowpostpoll || !$discuz_uid) { ?><li class="poll"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=1">发布投票</a></li><? } ?>
		<? if($allowposttrade || !$discuz_uid) { ?><li class="trade"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=2">发布商品</a></li><? } ?>
		<? if($allowpostreward || !$discuz_uid) { ?><li class="reward"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=3">发布悬赏</a></li><? } ?>
		<? if($allowpostactivity || !$discuz_uid) { ?><li class="activity"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=4">发布活动</a></li><? } ?>
		<? if($allowpostdebate || !$discuz_uid) { ?><li class="debate"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=5">发布辩论</a></li><? } ?>
		<? if($allowpostvideo || !$discuz_uid) { ?><li class="video"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=6">发布视频</a></li><? } ?>
		<? if($forum['threadtypes'] && !$forum['allowspecialonly']) { if(is_array($forum['threadtypes']['types'])) { foreach($forum['threadtypes']['types'] as $typeid => $threadtypes) { if($forum['threadtypes']['special'][$typeid] && $forum['threadtypes']['show'][$typeid]) { ?>
					<li class="popupmenu_option"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;typeid=<?=$typeid?>"><?=$threadtypes?></a></li>
				<? } } } if(is_array($forum['typemodels'])) { foreach($forum['typemodels'] as $id => $model) { ?><li class="popupmenu_option"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;modelid=<?=$id?>"><?=$model['name']?></a></li><? } } } ?>
	</ul>
<? } ?>

<form method="post" name="modactions">
	<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
	<div class="mainbox viewthread">
		<span class="headactions">
		<? if($discuz_uid) { ?>
			<? if($supe['status']) { ?>
				<? if($xspacestatus && $thread['authorid'] == $discuz_uid) { ?>
					<? if(!$thread['itemid']) { ?>
						<a href="<?=$supe['siteurl']?>/spacecp.php?action=spaceblogs&amp;op=add&amp;tid=<?=$tid?>" target="_blank">加入个人空间</a>
					<? } else { ?>
						<a href="<?=$supe['siteurl']?>/?action-viewspace-itemid-<?=$thread['itemid']?>-fromdiscuz-<?=$supe_fromdiscuz?>" target="_blank">在个人空间查看</a>
					<? } ?>
				<? } ?>
				<? if($discuz_uid) { ?>
					<a href="<?=$supe['siteurl']?>/spacecp.php?action=spacenews&op=add&tid=<?=$tid?>" target="_blank">加入资讯</a>
				<? } ?>
			<? } ?>
			<? if(!($supe['status'] && $xspacestatus && $thread['authorid'] == $discuz_uid) && $spacestatus && $thread['authorid'] && ($thread['authorid'] == $discuz_uid || $forum['ismoderator'])) { ?>
				<? if($thread['blog']) { ?>
					<a href="misc.php?action=blog&amp;tid=<?=$tid?>" id="ajax_blog" onclick="ajaxmenu(event, this.id, 2000, 'changestatus', 0)">从文集移除</a>
				<? } elseif($allowuseblog && $forum['allowshare'] && $thread['authorid'] == $discuz_uid) { ?>
					<a href="misc.php?action=blog&amp;tid=<?=$tid?>" id="ajax_blog" onclick="ajaxmenu(event, this.id, 2000, 'changestatus', 0)">加入文集</a>
				<? } ?>
				<script type="text/javascript">
					function changestatus(obj) {
						obj.innerHTML = obj.innerHTML == '从文集移除' ? '加入文集' : '从文集移除';
					}
				</script>
			<? } ?>
			<a href="my.php?item=favorites&amp;tid=<?=$tid?>" id="ajax_favorite" onclick="ajaxmenu(event, this.id, 3000, 0)">收藏</a>
			<a href="my.php?item=subscriptions&amp;subadd=<?=$tid?>" id="ajax_subscription" onclick="ajaxmenu(event, this.id, 3000, null, 0)">订阅</a>
			<a href="misc.php?action=emailfriend&amp;tid=<?=$tid?>" id="emailfriend" onclick="ajaxmenu(event, this.id, 9000000, null, 0)">推荐</a>
		<? } ?>
		<a href="viewthread.php?action=printable&amp;tid=<?=$tid?>" target="_blank" <? if(!$forum['ismoderator']) { ?>class="notabs"<? } ?>>打印</a>
		<? if($forum['ismoderator']) { ?>
			<script type="text/javascript">
				function modaction(action) {
					if(!action) {
						return;
					}
					if(!in_array(action, ['delpost', 'banpost'])) {
						window.location=('topicadmin.php?tid=<?=$tid?>&fid=<?=$fid?>&action='+ action +'&sid=<?=$sid?>');
					} else {
						document.modactions.action = 'topicadmin.php?action='+ action +'&fid=<?=$fid?>&tid=<?=$tid?>&page=<?=$page?>';
						document.modactions.submit();
					}
				}
			</script>
			<span id="modoption" onmouseover="showMenu(this.id)" class="dropmenu">管理选项</span>
			<ul class="popupmenu_popup headermenu_popup" id="modoption_menu" style="display: none">
			<? if($allowdelpost) { ?>
				<li><a href="###" onclick="modaction('delpost')">删除回帖</a></li>
				<? if($thread['digest'] >= 0) { ?><li><a href="###" onclick="modaction('delete')">删除主题</a></li><? } ?>
			<? } ?>
			<? if($allowbanpost) { ?>
				<li><a href="###" onclick="modaction('banpost')">屏蔽帖子</a></li>
			<? } ?>
			<? if($thread['digest'] >= 0) { ?>
				<li><a href="###" onclick="modaction('close')">关闭主题</a></li>
				<li><a href="###" onclick="modaction('move')">移动主题</a></li>
				<li><a href="###" onclick="modaction('copy')">复制主题</a></li>
				<li><a href="###" onclick="modaction('highlight')">高亮显示</a></li>
				<li><a href="###" onclick="modaction('type')">主题分类</a></li>
				<li><a href="###" onclick="modaction('digest')">设置精华</a></li>
				<? if($allowstickthread) { ?>
					<li><a href="###" onclick="modaction('stick')">主题置顶</a></li>
				<? } ?>
				<? if($thread['price'] > 0 && $allowrefund) { ?>
					<li><a href="###" onclick="modaction('refund')">强制退款</a></li>
				<? } ?>
				<li><a href="###" onclick="modaction('split')">分割主题</a></li>
				<li><a href="###" onclick="modaction('merge')">合并主题</a></li>
				<li><a href="###" onclick="modaction('bump')">提升主题</a></li>
				<li><a href="###" onclick="modaction('repair')">修复主题</a></li>
				<? if($forum['modrecommend']['open'] && $forum['modrecommend']['sort'] != 1) { ?>
					<li><a href="###" onclick="modaction('recommend')">推荐主题</a></li>
				<? } ?>
				<? if($supe['status'] && $allowpushthread && $forum['supe_pushsetting']['status'] == 2 && $thread['supe_pushstatus'] == 0) { ?>
					<li><a href="###" onclick="modaction('supe_push')">推送/解除</a></li>
				<? } ?>
			<? } ?>
			</ul>
		<? } ?>
		</span>
		<h1><?=$thread['subject']?>
		</h1>
		<? if($lastmod['modaction'] || $thread['blog'] || $thread['readperm'] || $thread['price'] != 0 || $thread['itemid'] || $lastmod['magicname']) { ?>
		<ins>
			<? if($thread['itemid']) { ?>
				<a href="<?=$supe['siteurl']?>/?action-viewspace-itemid-<?=$thread['itemid']?>" target="_blank">本帖已经被作者加入个人空间</a>
			<? } ?>
			<? if($thread['price'] > 0) { ?>
				<a href="misc.php?action=viewpayments&amp;tid=<?=$tid?>">浏览需支付 <?=$extcredits[$creditstrans]['title']?> <strong><?=$thread['price']?></strong> <?=$extcredits[$creditstrans]['unit']?></a>
			<? } ?>
			<? if($lastmod['modaction']) { ?><a href="misc.php?action=viewthreadmod&amp;tid=<?=$tid?>" title="主题操作记录" target="_blank">本主题由 <?=$lastmod['modusername']?> 于 <?=$lastmod['moddateline']?> <?=$lastmod['modaction']?></a><? } ?>
			<? if($spacestatus && $thread['blog']) { ?><a href="space.php?<?=$thread['authorid']?>/myblogs" target="_blank">本主题被作者加入到个人文集中</a><? } ?>
			<? if($thread['readperm']) { ?>所需阅读权限 <?=$thread['readperm']?><? } ?>
			<? if($lastmod['magicname']) { ?><a href="misc.php?action=viewthreadmod&amp;tid=<?=$tid?>" title="主题操作记录" target="_blank">本主题由 <?=$lastmod['modusername']?> 于 <?=$lastmod['moddateline']?> 使用 <?=$lastmod['magicname']?> 道具</a><? } ?>
		</ins>
		<? } ?>
		<? if($highlightstatus) { ?><ins><a href="viewthread.php?tid=<?=$tid?>&amp;page=<?=$page?>" style="font-weight: normal">取消高亮</a></ins><? } $postcount = 0; if(is_array($postlist)) { foreach($postlist as $post) { ?>	<? if($postcount++) { ?>
	</div>
	<div class="mainbox viewthread">
	<? } ?>
		<table id="pid<?=$post['pid']?>" summary="pid<?=$post['pid']?>" cellspacing="0" cellpadding="0">
			<tr>
				<td class="postauthor">
					<?=$post['newpostanchor']?> <?=$post['lastpostanchor']?>
					<cite><? if($forum['ismoderator']) { ?>
						<? if($allowviewip && ($thread['digest'] >= 0 || !$post['first'])) { ?><label><a href="topicadmin.php?action=getip&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" id="ajax_getip_<?=$post['count']?>" onclick="ajaxmenu(event, this.id, 10000, null, 0)" title="查看 IP">IP</a></label><? } ?>
					<? } ?>
					<? if($post['authorid'] && $post['username'] && !$post['anonymous']) { ?>
						<a href="space.php?uid=<?=$post['authorid']?>" target="_blank" id="userinfo<?=$post['pid']?>" class="dropmenu" onmouseover="showMenu(this.id)"><?=$post['author']?></a></cite>
						<? if($post['nickname']) { ?><p><?=$post['nickname']?></p><? } ?>
						<? if($post['avatar'] && $showavatars) { ?>
							<?=$post['avatar']?>
						<? } ?>
						<p><em><?=$post['authortitle']?></em></p>
						<p><? showstars($post['stars']); ?></p>
						<? if($post['customstatus']) { ?><p class="customstatus"><?=$post['customstatus']?></p><? } ?>
						<? if($customauthorinfo['1']) { ?><dl class="profile"><? @eval('echo "'.$customauthorinfo['1'].'";'); ?></dl><? } ?>
						<? if($post['medals']) { ?><p><? if(is_array($post['medals'])) { foreach($post['medals'] as $medal) { ?>							<img src="images/common/<?=$medal['image']?>" alt="<?=$medal['name']?>" />
							<? } } ?></p>
						<? } ?>

						<ul>
						<? if($spacestatus) { ?>
							<li class="space">
							<? if(!empty($post['spacename'])) { ?>
								<a href="space.php?uid=<?=$post['authorid']?>" target="_blank" title="<?=$post['spacename']?>">
							<? } else { ?>
								<a href="space.php?uid=<?=$post['authorid']?>" target="_blank" title="<?=$post['username']?>的个人空间">
							<? } ?>
							个人空间</a></li>
						<? } elseif($supe['status']) { ?>
							<li class="space"><a href="<?=$supe['siteurl']?>/?uid-<?=$post['authorid']?>" target="_blank">个人空间</a></li>
						<? } ?>
						<li class="pm"><a href="pm.php?action=send&amp;uid=<?=$post['authorid']?>" target="_blank" id="ajax_uid_<?=$post['pid']?>" onclick="ajaxmenu(event, this.id, 9000000, null, 0)">发短消息</a></li>
						<li class="buddy"><a href="my.php?item=buddylist&amp;newbuddyid=<?=$post['authorid']?>&amp;buddysubmit=yes" target="_blank" id="ajax_buddy_<?=$post['count']?>" onclick="ajaxmenu(event, this.id, null, 0)">加为好友</a></li>

						<? if($vtonlinestatus && $post['authorid']) { ?>
							<? if(($vtonlinestatus == 2 && $onlineauthors[$post['authorid']]) || ($vtonlinestatus == 1 && ($timestamp - $post['lastactivity'] <= 10800) && !$post['invisible'])) { ?>
								<li class="online">当前在线
							<? } else { ?>
								<li class="offline">当前离线
							<? } ?>
							</li>
						<? } ?>

						</ul>
					<? } else { ?>
						<? if(!$post['authorid']) { ?>
							<a href="javascript:;">游客 <em><?=$post['useip']?></em></a></cite>
							未注册
						<? } elseif($post['authorid'] && $post['username'] && $post['anonymous']) { ?>
							<? if($forum['ismoderator']) { ?><a href="space.php?uid=<?=$post['authorid']?>" target="_blank">匿名</a><? } else { ?>匿名<? } ?></cite>
							该用户匿名发帖
						<? } else { ?>
							<?=$post['author']?></cite>
							该用户已被删除
						<? } ?>
					<? } ?>
				</td>
				<td class="postcontent" <? if($forum['ismoderator'] && ($thread['digest'] >= 0 || !$post['first'])) { ?> ondblclick="ajaxget('modcp.php?action=editmessage&pid=<?=$post['pid']?>&tid=<?=$post['tid']?>', 'postmessage_<?=$post['pid']?>')"<? } ?>>
					<div class="postinfo">
						<strong title="复制帖子链接到剪贴板" id="postnum<?=$post['pid']?>" onclick="setcopy('<?=$boardurl?>viewthread.php?tid=<?=$tid?>&amp;page=<?=$page?><?=$fromuid?>#pid<?=$post['pid']?>', '帖子链接已经复制到剪贴板')"><? if(!empty($postno[$post['number']])) { ?><?=$postno[$post['number']]?><? } else { ?><?=$post['number']?><?=$postno['0']?><? } ?></strong>
						<? if(MSGBIGSIZE || MSGSMALLSIZE) { ?>
							<? if(MSGBIGSIZE) { ?><em onclick="$('postmessage_<?=$post['pid']?>').className='t_bigfont'">大</em><? } ?>
							<em onclick="$('postmessage_<?=$post['pid']?>').className='t_msgfont'">中</em>
							<? if(MSGSMALLSIZE) { ?><em onclick="$('postmessage_<?=$post['pid']?>').className='t_smallfont'">小</em><? } ?>
						<? } ?>
						<? if($thread['price'] >= 0 || $post['first']) { ?>发表于 <?=$post['dateline']?>&nbsp;<? } ?>
						<? if($post['authorid'] && !$post['anonymous']) { ?>
							<? if(!$authorid) { ?>
								<a href="viewthread.php?tid=<?=$post['tid']?>&amp;page=<?=$page?>&amp;authorid=<?=$post['authorid']?>" rel="nofollow">只看该作者</a>
							<? } else { ?>
								<a href="viewthread.php?tid=<?=$post['tid']?>&amp;page=<?=$page?>" rel="nofollow">显示全部帖子</a>
							<? } ?>
						<? } ?>
					</div>
					<? if($admode && empty($insenz['hardadstatus']) && !empty($advlist['thread2'][$post['count']])) { ?><div class="ad_textlink2" id="ad_thread2_<?=$post['count']?>"><?=$advlist['thread2'][$post['count']]?></div><? } else { ?><div id="ad_thread2_<?=$post['count']?>"></div><? } ?>
					<div class="postmessage defaultpost">
						<? if(!empty($post['ratings'])) { ?>
							<span class="postratings"><a href="misc.php?action=viewratings&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" title="评分 <?=$post['rate']?>"><?=$post['ratings']?></a></span>
						<? } ?>
						<? if($admode && empty($insenz['hardadstatus']) && !empty($advlist['thread3'][$post['count']])) { ?><div class="ad_pip" id="ad_thread3_<?=$post['count']?>"><?=$advlist['thread3'][$post['count']]?></div><? } else { ?><div id="ad_thread3_<?=$post['count']?>"></div><? } ?><div id="ad_thread4_<?=$post['count']?>"></div>
						<? if($post['subject']) { ?>
							<h2><?=$post['subject']?></h2>
						<? } ?>

						<? if(!$typetemplate && $optionlist && $post['first'] && !$post['status']) { ?>
							<div class="box typeoption">
								<h4>分类信息 - <?=$forum['threadtypes']['types'][$thread['typeid']]?></h4>
								<table summary="分类信息" cellpadding="0" cellspacing="0"><? if(is_array($optionlist)) { foreach($optionlist as $option) { ?>									<tr>
										<th><?=$option['title']?></th>
										<td><? if($option['value']) { ?><?=$option['value']?><? } else { ?>-<? } ?></td>
									</tr>
								<? } } ?></table>
							</div>
						<? } ?>

						<? if($adminid != 1 && $bannedmessages && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))) { ?>
							<div class="notice" style="width: 500px">提示: <em>作者被禁止或删除 内容自动屏蔽</em></div></div>
						<? } elseif($adminid != 1 && $post['status'] == 1) { ?>
							<div class="notice" style="width: 500px">提示: <em>该帖被管理员或版主屏蔽</em></div></div>
						<? } elseif($post['first'] && isset($threadpay)) { include template('viewthread_pay'); } else { ?>
							<? if($bannedmessages && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))) { ?>
								<div class="notice" style="width: 500px">提示: <em>作者被禁止或删除 内容自动屏蔽，只有管理员可见</em></div>
							<? } elseif($post['status'] == 1) { ?>
								<div class="notice" style="width: 500px">提示: <em>该帖被管理员或版主屏蔽，只有管理员可见</em></div>
							<? } ?>
							<? if($post['number'] == 1 && $typetemplate) { ?><?=$typetemplate?><? } ?>
							<div id="postmessage_<?=$post['pid']?>" class="t_msgfont"><?=$post['message']?></div>

							<? if($post['attachment']) { ?>
								<div class="notice" style="width: 500px">附件: <em>您所在的用户组无法下载或查看附件</em></div>
							<? } elseif($hideattach[$post['pid']] && $post['attachments']) { ?>
								<div class="notice" style="width: 500px">附件: <em>本帖附件需要回复才可下载或查看</em></div>
							<? } elseif($post['attachlist']) { ?>
								<div class="box postattachlist">
									<h4>附件</h4>
									<?=$post['attachlist']?>
								</div>
							<? } ?>

							<? if($post['number'] == 1 && ($thread['tags'] || $relatedkeywords)) { ?>
								<p class="posttags">搜索更多相关主题的帖子:
								<? if($thread['tags']) { ?><?=$thread['tags']?><? } ?>
								<? if($relatedkeywords) { ?><span class="postkeywords"><?=$relatedkeywords?></span><? } ?>
								</p>
							<? } ?>

							<? if($relatedthreadlist && !$qihoo['relate']['position'] && $post['number'] == 1) { ?>
								<fieldset>
									<legend>相关主题</legend>
									<ul><? if(is_array($relatedthreadlist)) { foreach($relatedthreadlist as $key => $threads) { if($threads['tid'] != $tid) { ?>
										<li style="padding: 3px">
											<? if(!$threads['insite']) { ?>
											[站外] <a href="topic.php?url=<? echo urlencode($threads['tid']); ?>&amp;md5=<? echo md5($threads['tid']); ?>&amp;statsdata=<?=$fid?>||<?=$tid?>" target="_blank"><?=$threads['title']?></a>&nbsp;&nbsp;&nbsp;
											[ <a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;url=<? echo urlencode($threads['tid']); ?>&amp;md5=<? echo md5($threads['tid']); ?>&amp;from=direct" style="color: #090" target="_blank">转帖</a> ]
											<? } else { ?>
											<a href="viewthread.php?tid=<?=$threads['tid']?>&amp;statsdata=<?=$fid?>||<?=$tid?>" target="_blank"><?=$threads['title']?></a>
											<? } ?>
										</li>
										<? } } } ?><li style="text-align:right"><a style="color: #333; background: none; line-height: 22px;" href="http://search.qihoo.com/sint/qusearch.html?kw=<?=$searchkeywords?>&amp;sort=rdate&amp;ics=<?=$charset?>&amp;domain=<?=$site?>&amp;tshow=1" target="_blank">更多相关主题</a></li>
									</ul>
								</fieldset>
							<? } ?>

							<? if(!empty($post['ratelog'])) { ?>
								<fieldset>
									<legend><a href="misc.php?action=viewratings&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>" title="查看评分记录">本帖最近评分记录</a></legend>

									<ul>
									<div id="post_rate_<?=$post['pid']?>"></div><? if(is_array($post['ratelog'])) { foreach($post['ratelog'] as $ratelog) { ?>										<li>
											<cite><a href="space.php?uid=<?=$ratelog['uid']?>" target="_blank"><?=$ratelog['username']?></a></cite>
											<?=$extcredits[$ratelog['extcredits']]['title']?>
											<strong><?=$ratelog['score']?></strong>
											<em><?=$ratelog['reason']?></em>
											<?=$ratelog['dateline']?>
										</li>
									<? } } ?></ul>
								</fieldset>
							<? } else { ?>
								<div id="post_rate_div_<?=$post['pid']?>"></div>
							<? } ?>

						</div>
						<? if($post['signature'] && !$post['anonymous'] && $showsignatures) { ?>
							<div class="signatures" style="maxHeightIE: <?=MAXSIGROWS?>px;">
								<?=$post['signature']?>
							</div>
						<? } ?>
					<? } ?>
				</div>
			</td>
		</tr>
		<tr>
			<td class="postauthor">
				<? if($post['authorid'] && $post['username'] && !$post['anonymous']) { ?>
				<div class="popupmenu_popup userinfopanel" id="userinfo<?=$post['pid']?>_menu" style="display: none;">
					<? if($post['msn'] || $post['qq'] || $post['icq'] || $post['yahoo'] || $post['taobao']) { ?>
					<div class="imicons">
						<? if($post['msn']) { ?><a href="javascript:;" onclick="msnoperate('add', '<?=$post['msn']?>')" title="添加 <?=$post['username']?> 为MSN好友"><img src="<?=IMGDIR?>/msnadd.gif" alt="添加 <?=$post['username']?> 为MSN好友" /></a>
							<a href="javascript:;" onclick="msnoperate('chat', '<?=$post['msn']?>')" title="通过MSN和 <?=$post['username']?> 交谈"><img src="<?=IMGDIR?>/msnchat.gif" alt="通过MSN和 <?=$post['username']?> 交谈" /></a><? } ?>
						<? if($post['qq']) { ?><a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?=$post['qq']?>&amp;Site=<?=$bbname?>&amp;Menu=yes" target="_blank"><img src="<?=IMGDIR?>/qq.gif" alt="QQ" /></a><? } ?>
						<? if($post['icq']) { ?><a href="http://wwp.icq.com/scripts/search.dll?to=<?=$post['icq']?>" target="_blank"><img src="<?=IMGDIR?>/icq.gif" alt="ICQ" /></a><? } ?>
						<? if($post['yahoo']) { ?><a href="http://edit.yahoo.com/config/send_webmesg?.target=<?=$post['yahoo']?>&amp;.src=pg" target="_blank"><img src="<?=IMGDIR?>/yahoo.gif" alt="Yahoo!"  /></a><? } ?>
						<? if($post['taobao']) { ?><script type="text/javascript">document.write('<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&amp;uid='+encodeURIComponent('<?=$post['taobaoas']?>')+'&amp;s=2"><img src="<?=IMGDIR?>/taobao.gif" alt="阿里旺旺" /></a>');</script><? } ?>
					</div>
					<? } ?>
					<dl><? @eval('echo "'.$customauthorinfo['2'].'";'); ?></dl>
					<? if($post['site']) { ?>
						<p><a href="<?=$post['site']?>" target="_blank">查看个人网站</a></p>
					<? } ?>
					<p><a href="space.php?action=viewpro&amp;uid=<?=$post['authorid']?>" target="_blank">查看详细资料</a></p>
					<? if($allowedituser || $allowbanuser) { ?>
						<? if($adminid == 1) { ?>
							<p><a href="admincp.php?action=members&amp;username=<?=$post['usernameenc']?>&amp;searchsubmit=yes&amp;frames=yes" target="_blank">编辑用户</a></p>
						<? } else { ?>
							<p><a href="admincp.php?action=editmember&amp;uid=<?=$post['authorid']?>&amp;membersubmit=yes&amp;frames=yes" target="_blank">编辑用户</a></p>
							<? } ?>
						<p><a href="admincp.php?action=banmember&amp;uid=<?=$post['authorid']?>&amp;membersubmit=yes&amp;frames=yes" target="_blank">禁止用户</a></p>
					<? } ?>
				</div>
				<? } ?>
			</td>
			<td class="postcontent">
				<div class="postactions">
					<? if($forum['ismoderator'] && $allowdelpost) { ?>
						<? if($post['first'] && $thread['digest'] == -1) { ?>
							<input type="checkbox" disabled="disabled" />
						<? } else { ?>
							<input type="checkbox" name="topiclist[]" value="<?=$post['pid']?>" />
						<? } ?>
					<? } ?>
					<p>
						<? if((($forum['ismoderator'] && $alloweditpost && !(in_array($post['adminid'], array(1, 2, 3)) && $adminid > $post['adminid'])) || ($forum['alloweditpost'] && $discuz_uid && $post['authorid'] == $discuz_uid)) && ($thread['digest'] >= 0 || !$post['first'])) { ?>
							<a href="post.php?action=edit&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>&amp;page=<?=$page?>&amp;extra=<?=$extra?>">编辑</a>
						<? } ?>
						<? if($allowpostreply) { ?>
							<a href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;repquote=<?=$post['pid']?>&amp;extra=<?=$extra?>&amp;page=<?=$page?>">引用</a>
						<? } ?>
						<? if($discuz_uid && $magicstatus) { ?>
							<a href="magic.php?action=user&amp;pid=<?=$post['pid']?>" target="_blank">使用道具</a>
						<? } ?>
						<? if($discuz_uid && $reportpost) { ?>
							<a href="misc.php?action=report&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>&amp;page=<?=$page?>" id="ajax_report_<?=$post['pid']?>" onclick="ajaxmenu(event, this.id, 9000000, null, 0)">报告</a>
						<? } ?>
						<? if($raterange && $post['authorid']) { ?>
							<a href="misc.php?action=rate&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>&amp;page=<?=$page?>" id="ajax_rate_<?=$post['pid']?>" onclick="ajaxmenu(event, this.id, 9000000, null, 0)">评分</a>
						<? } ?>
						<? if($post['rate'] && $forum['ismoderator']) { ?>
							<a href="misc.php?action=removerate&amp;tid=<?=$tid?>&amp;pid=<?=$post['pid']?>&amp;page=<?=$page?>">撤销评分</a>
						<? } ?>
						<? if($fastpost && $allowpostreply) { ?>
							<a href="###" onclick="fastreply('回复 # 的帖子', <?=$post['pid']?>)">回复</a>
						<? } ?>
						<? if($forum['ismoderator']) { ?>
							<a href="topicadmin.php?action=delpost&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;topiclist[]=<?=$post['pid']?>&amp;page=<?=$page?>">删除</a>
							<a href="topicadmin.php?action=banpost&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;topiclist[]=<?=$post['pid']?>&amp;page=<?=$page?>">屏蔽</a>
						<? } ?>
						<strong onclick="scroll(0,0)" title="顶部">TOP</strong>
					</p>
					<? if($admode && empty($insenz['hardadstatus']) && !empty($advlist['thread1'][$post['count']])) { ?><div class="ad_textlink1" id="ad_thread1_<?=$post['count']?>"><?=$advlist['thread1'][$post['count']]?></div><? } else { ?><div id="ad_thread1_<?=$post['count']?>"></div><? } ?>
				</div>
			</td>
		</tr>
		</table>
		<? if($post['first'] && $thread['replies']) { ?></div><? if($admode && empty($insenz['hardadstatus']) && !empty($advlist['interthread'])) { ?><div class="ad_column" id="ad_interthread"><?=$advlist['interthread']?><? } else { ?><div id="ad_interthread"><? } } } } ?></div>
</form>

<div class="pages_btns">
	<div class="threadflow"><a href="redirect.php?fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;goto=nextoldset"> &lsaquo;&lsaquo; 上一主题</a> | <a href="redirect.php?fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;goto=nextnewset">下一主题 &rsaquo;&rsaquo;</a></div>
	<?=$multipage?>
	<? if($allowpost || !$discuz_uid) { ?>
		<span class="postbtn" id="newspecialtmp" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu(this.id)"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>"><img src="<?=IMGDIR?>/newtopic.gif" border="0" alt="发新话题" title="发新话题" /></a></span>
	<? } ?>
	<? if($allowpostreply || !$discuz_uid) { ?><span class="replybtn"><a href="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;extra=<?=$extra?>"><img src="<?=IMGDIR?>/reply.gif" border="0" alt="" /></a></span><? } ?>
</div>

<? if($relatedthreadlist && $qihoo['relate']['position']) { include template('viewthread_relatedthread'); } if($fastpost && $allowpostreply) { ?>
	<script src="include/javascript/post.js" type="text/javascript"></script>
	<script type="text/javascript">
	var postminchars = parseInt('<?=$minpostsize?>');
	var postmaxchars = parseInt('<?=$maxpostsize?>');
	var disablepostctrl = parseInt('<?=$disablepostctrl?>');
	function validate(theform) {
		if (theform.message.value == "" && theform.subject.value == "") {
			alert("请完成标题或内容栏。");
			theform.message.focus();
			return false;
		} else if (theform.subject.value.length > 80) {
			alert("您的标题超过 80 个字符的限制。");
			theform.subject.focus();
			return false;
		}
		if (!disablepostctrl && ((postminchars != 0 && theform.message.value.length < postminchars) || (postmaxchars != 0 && theform.message.value.length > postmaxchars))) {
			alert("您的帖子长度不符合要求。\n\n当前长度: "+theform.message.value.length+" 字节\n系统限制: "+postminchars+" 发送到 "+postmaxchars+" 字节");
			return false;
		}
		if(!fetchCheckbox('parseurloff')) {
			theform.message.value = parseurl(theform.message.value, 'bbcode');
		}
		theform.replysubmit.disabled = true;
		return true;
	}
	</script>
	<form method="post" id="postform" action="post.php?action=reply&amp;fid=<?=$fid?>&amp;tid=<?=$tid?>&amp;extra=<?=$extra?>&amp;replysubmit=yes" onSubmit="return validate(this)">
		<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
		<div id="quickpost" class="box">
			<span class="headactions"><a href="member.php?action=credits&amp;view=forum_reply&amp;fid=<?=$fid?>" target="_blank">查看积分策略说明</a></span>
			<h4>快速回复主题</h4>
			<div class="postoptions">
				<h5>选项</h5>
				<p><label><input class="checkbox" type="checkbox" name="parseurloff" id="parseurloff" value="1"> 禁用 URL 识别</label></p>
				<p><label><input class="checkbox" type="checkbox" name="smileyoff" id="smileyoff" value="1"> 禁用 <a href="faq.php?action=message&amp;id=32" target="_blank">表情</a></label></p>
				<p><label><input class="checkbox" type="checkbox" name="bbcodeoff" id="bbcodeoff" value="1"> 禁用 <a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a></label></p>
				<? if($allowanonymous || $forum['allowanonymous']) { ?><p><label><input class="checkbox" type="checkbox" name="isanonymous" value="1"> 使用匿名发帖</label></p><? } ?>
				<p><label><input class="checkbox" type="checkbox" name="usesig" value="1" <?=$usesigcheck?>> 使用个人签名</label></p>
				<p><label><input class="checkbox" type="checkbox" name="emailnotify" value="1"> 接收新回复邮件通知</label></p>
			</div>
			<div class="postform">
				<h5><label>标题
				<input type="text" name="subject" value="" tabindex="1"></label></h5>
				<p><label>内容</label>
				<textarea rows="7" cols="80" class="autosave" name="message" id="message" onKeyDown="ctlent(event);" tabindex="2"></textarea>
				</p>
				<p class="btns">
					<button type="submit" name="replysubmit" id="postsubmit" value="replysubmit" tabindex="3">发表帖子</button>[完成后可按 Ctrl+Enter 发布]&nbsp;
					<a href="###" id="previewpost" onclick="$('postform').action=$('postform').action + '&previewpost=yes';$('postform').submit();">预览帖子</a>&nbsp;
					<a href="###" id="restoredata" title="恢复上次自动保存的数据" onclick="loadData()">恢复数据</a>&nbsp;
					<a href="###" onclick="$('postform').reset()">清空内容</a>
				</p>
			</div>
			<? if($smileyinsert) { ?>
				<div class="smilies">
					<div id="smilieslist"></div>
					<script type="text/javascript">ajaxget('post.php?action=smilies', 'smilieslist');</script>
				</div>
			<? } ?>
			<script type="text/javascript">
				var textobj = $('message');
				window.onbeforeunload = function () {saveData(textobj.value)};
				if(is_ie >= 5 || is_moz >= 2) {
					lang['post_autosave_none'] = "没有可以恢复的数据！";
					lang['post_autosave_confirm'] = "此操作将覆盖当前帖子内容，确定要恢复数据吗？";
				} else {
					$('restoredata').style.display = 'none';
				}
			</script>
		</div>
	</form>
<? } if($forumjump && !$jsmenu['1'] || $visitedforums) { ?>
	<div id="footfilter" class="box">
	<? if($forumjump && !$jsmenu['1']) { ?>
		<span id="forumjump" onmouseover="showMenu(this.id, false, 2)" class="dropmenu">版块跳转 ...</span>&nbsp;
		<ul class="popupmenu_popup" id="forumjump_menu" style="display: none">
		<?=$forumselect?>
		</ul>
	<? } ?>
	<? if($visitedforums) { ?>
		<span id="visited_forums" onmouseover="showMenu(this.id, false, 2)" class="dropmenu">最近访问的版块</span>
		<ul class="popupmenu_popup" id="visited_forums_menu" style="display: none">
		<?=$visitedforums?>
		</ul>
	<? } ?>
	</div>
<? } if($forumjump && $jsmenu['1']) { ?>
	<div class="popupmenu_popup" id="forumlist_menu" style="display: none">
		<?=$forummenu?>
	</div>
<? } ?>

<script type="text/javascript">
var maxpage = <? if($maxpage) { ?><?=$maxpage?><? } else { ?>1<? } ?>;
if(maxpage > 1) {
	document.onkeyup = function(e){
		e = e ? e : window.event;
		var tagname = is_ie ? e.srcElement.tagName : e.target.tagName;
		if(tagname == 'INPUT' || tagname == 'TEXTAREA') return;
		actualCode = e.keyCode ? e.keyCode : e.charCode;
		<? if($page < $maxpage) { ?>
		if(actualCode == 39) {
			window.location = 'viewthread.php?tid=<?=$tid?>&page=<? echo $page+1;; ?>';
		}
		<? } ?>
		<? if($page > 1) { ?>
		if(actualCode == 37) {
			window.location = 'viewthread.php?tid=<?=$tid?>&page=<? echo $page-1;; ?>';
		}
		<? } ?>
	}
}
</script>
<? if(!$iscircle || !empty($frombbs)) { include template('footer'); } else { include template('supesite_footer'); } ?>
<script src="include/javascript/msn.js" type="text/javascript"></script>
<? if($relatedthreadupdate) { ?>
<script src="relatethread.php?tid=<?=$tid?>&subjectenc=<?=$thread['subjectenc']?>&tagsenc=<?=$thread['tagsenc']?>&verifykey=<?=$verifykey?>&up=<?=$qihoo_up?>" type="text/javascript"></script>
<? } if($qihoo['relate']['bbsnum'] && $statsdata) { ?>
	<img style="display:none;" src="http://pvstat.qihoo.com/dimana.gif?_pdt=discuz&amp;_pg=s100812&amp;_r=<?=$randnum?>&amp;_dim_k=orgthread&amp;_dim_v=<? echo urlencode($boardurl);; ?>||<?=$statsdata?>||0" width="1" height="1" alt="" />
	<img style="display:none;" src="http://pvstat.qihoo.com/dimana.gif?_pdt=discuz&amp;_pg=s100812&amp;_r=<?=$randnum?>&amp;_dim_k=relthread&amp;_dim_v=<?=$statskeywords?>||<?=$statsurl?>" width="1" height="1" alt="" />
<? } ?>