<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="foruminfo">
	<div id="headsearch">
		<? if(!empty($google) && ($google & 2)) { ?>
			<script src="forumdata/cache/google_var.js" type="text/javascript"></script>
			<script src="include/javascript/google.js" type="text/javascript"></script>
		<? } ?>
	<? if(!empty($qihoo['status']) && ($qihoo['searchbox'] & 2)) { ?>
		<form method="post" action="search.php?srchtype=qihoo" onSubmit="this.target='_blank';">
		<input type="hidden" name="searchsubmit" value="yes" />
		<input type="text" name="srchtxt" size="27" value="<?=$qihoo_searchboxtxt?>" />
		&nbsp;<button type="submit">搜索</button>
		</form>
	<? } ?>
	<p>
		<? if($forum['rules']) { ?><span id="rules_link" style="<?=$collapse['rules_link']?>"><a href="###" onclick="$('rules_link').style.display = 'none';toggle_collapse('rules', 1);<? if($forum['recommendlist']) { ?>$('recommendlist').className = 'rules';<? } ?>">本版规则</a> |</span><? } ?>
		<? if($forum['recommendlist']) { ?><span id="recommendlist_link" style="<?=$collapse['recommendlist_link']?>"><a href="###" onclick="$('recommendlist_link').style.display = 'none';toggle_collapse('recommendlist', 1)">版主推荐</a> |</span><? } ?>
		<? if($supe['status'] && $discuz_uid) { ?>
			<? if(!$xspacestatus) { ?>
				<a href="<?=$supe['siteurl']?>/index.php?action/register" target="_blank">开通个人空间</a> |
			<? } else { ?>
				<a href="<?=$supe['siteurl']?>/index.php?action/space/uid/<?=$discuz_uid?>" target="_blank">个人空间</a> |
			<? } ?>
		<? } ?>
		<a href="my.php?item=favorites&amp;fid=<?=$fid?>" id="ajax_favorite" onclick="ajaxmenu(event, this.id)">收藏本版</a> |
		<a href="my.php?item=threads&amp;srchfid=<?=$fid?>">我的话题</a>
	<? if($allowmodpost && $forum['modnewposts']) { ?>
		| <a href="admincp.php?action=modthreads&amp;frames=yes" target="_blank">审核新主题</a>
		<? if($forum['modnewposts'] == 2) { ?>| <a href="admincp.php?action=modreplies&amp;frames=yes" target="_blank">审核新回复</a><? } ?>
	<? } ?>
	<? if($adminid == 1 && $forum['recyclebin']) { ?>
		| <a href="admincp.php?action=recyclebin&amp;frames=yes" target="_blank">回收站</a>
	<? } ?>
	<? if($rssstatus) { ?><a href="rss.php?fid=<?=$fid?>&amp;auth=<?=$rssauth?>" target="_blank"><img src="images/common/xml.gif" border="0" class="absmiddle" alt="RSS 订阅全部版块" /></a><? } ?>
	</p>
	</div>
	<div id="nav">
		<p><a id="forumlist" href="<?=$indexname?>"<? if($forumjump && $jsmenu['1']) { ?> class="dropmenu" onmouseover="showMenu(this.id)"<? } ?>><?=$bbname?></a> <?=$navigation?></p>
		<p>版主: <? if($moderatedby) { ?><?=$moderatedby?><? } else { ?>*空缺中*<? } ?></p>
	</div>
</div>

<? if($forum['rules'] || $forum['recommendlist']) { ?>
<table summary="Rules and Recommend" class="portalbox" cellpadding="0" cellspacing="1">
	<tr>
		<? if($forum['rules']) { ?>
		<td id="rules" style="<?=$collapse['rules']?>">
			<span class="headactions recommendrules"><img id="rules_img" src="<?=IMGDIR?>/collapsed_no.gif" title="收起/展开" alt="收起/展开" onclick="$('rules_link').style.display = '';toggle_collapse('rules', 1);<? if($forum['recommendlist']) { ?>$('recommendlist').className = '';<? } ?>" /></span>
			<h3>本版规则</h3>
			<?=$forum['rules']?>
		</td>
		<? } ?>
		<? if($forum['recommendlist']) { ?>
		<td id="recommendlist" <? if($forum['rules']) { if(!$collapse['rules']) { ?>class="rules" <? } ?>style="width: 50%;"<? } ?> style="<?=$collapse['recommendlist']?>">
			<span class="headactions recommendrules"><img id="recommendlist_img" src="<?=IMGDIR?>/collapsed_no.gif" title="收起/展开" alt="收起/展开" onclick="$('recommendlist_link').style.display = '';toggle_collapse('recommendlist', 1);" /></span>
			<h3>版主推荐 <? if($forum['ismoderator'] && $forum['modrecommend']['sort'] != 1) { ?><em>[<a href="admincp.php?action=forumrecommend&amp;fid=<?=$fid?>&amp;frames=yes" target="_blank">管理</a>]</em><? } ?></h3>
			<ul><? if(is_array($forum['recommendlist'])) { foreach($forum['recommendlist'] as $tid => $thread) { ?><li><cite><a href="space.php?uid=<?=$thread['authorid']?>" target="_blank"><?=$thread['author']?></a>: </cite><a href="viewthread.php?tid=<?=$tid?>" <?=$thread['subjectstyles']?> target="_blank"><?=$thread['subject']?></a></li><? } } ?></ul>
		</td>
		<? } ?>
	</tr>
</table>
<? } if(!empty($newpmexists) || $announcepm) { ?>
	<div class="maintable" id="pmprompt">
<? include template('pmprompt'); ?>
</div>
<? } if($subexists) { ?>
<div class="mainbox forumlist">
<? include template('forumdisplay_subforum'); ?>
</div>
<? } if($admode && empty($insenz['hardadstatus']) && !empty($advlist['text'])) { ?><div class="ad_text" id="ad_text"><table summary="Text Ad" cellpadding="0" cellspacing="1"><?=$advlist['text']?></table></div><? } else { ?><div id="ad_text"></div><? } if($_DCACHE['supe_updatecircles']) { ?>
<div class="mainbox forumlist">
	<h3>最近更新的圈子</h3>
	<table id="updatecircles" summary="最近更新的圈子" cellspacing="0" cellpadding="0">
		<tr><? if(is_array($_DCACHE['supe_updatecircles'])) { foreach($_DCACHE['supe_updatecircles'] as $k => $v) { ?><th>
				<img class="circlelogo" src="<?=$v['logo']?>" alt="" />
				<h2><a href="<?=$supe['siteurl']?>/?action_mygroup_gid_<?=$v['gid']?>" target="_blank"><?=$v['groupname']?></a></h2>
				<p>
					圈主: <a href="space.php?action=viewpro&amp;uid=<?=$v['uid']?>"><?=$v['username']?></a> ,
					成员: <?=$v['usernum']?>
				</p>
				<p>
					最后更新: <?=$v['lastpost']?>
				</p>
			</th>
		<? if($k == 3) { ?></tr><tr><? } } } ?></tr>
	</table>
</div>
<? } ?>

<div class="pages_btns">
	<?=$multipage?>
	<? if($allowpost || !$discuz_uid) { ?>
		<span class="postbtn" id="newspecial" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu(this.id)"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>" title="发新话题"><img src="<?=IMGDIR?>/newtopic.gif" alt="发新话题" /></a></span>
	<? } ?>
</div>

<? if($allowposttrade || $allowpostpoll || $allowpostreward || $allowpostactivity || $allowpostdebate  || $allowpostvideo || $forum['threadtypes'] || !$discuz_uid) { ?>
	<ul class="popupmenu_popup newspecialmenu" id="newspecial_menu" style="display: none">
		<? if(!$forum['allowspecialonly']) { ?><li><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>">发新话题</a></li><? } ?>
		<? if($allowpostpoll || !$discuz_uid) { ?><li class="poll"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=1">发布投票</a></li><? } ?>
		<? if($allowposttrade || !$discuz_uid) { ?><li class="trade"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=2">发布商品</a></li><? } ?>
		<? if($allowpostreward || !$discuz_uid) { ?><li class="reward"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=3">发布悬赏</a></li><? } ?>
		<? if($allowpostactivity || !$discuz_uid) { ?><li class="activity"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=4">发布活动</a></li><? } ?>
		<? if($allowpostdebate || !$discuz_uid) { ?><li class="debate"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=5">发布辩论</a></li><? } ?>
		<? if($allowpostvideo || !$discuz_uid) { ?><li class="video"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;special=6">发布视频</a></li><? } ?>
		<? if($forum['threadtypes'] && !$forum['allowspecialonly']) { if(is_array($forum['threadtypes']['types'])) { foreach($forum['threadtypes']['types'] as $id => $threadtypes) { if($forum['threadtypes']['special'][$id] && $forum['threadtypes']['show'][$id]) { ?>
					<li class="popupmenu_option"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;typeid=<?=$id?>"><?=$threadtypes?></a></li>
				<? } } } if(is_array($forum['typemodels'])) { foreach($forum['typemodels'] as $id => $model) { ?><li class="popupmenu_option"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;modelid=<?=$id?>"><?=$model['name']?></a></li><? } } } ?>
	</ul>
<? } ?>

<div id="headfilter">
	<ul class="tabs">
		<li <? if(empty($filter)) { ?> class="current"<? } ?> ><a href="forumdisplay.php?fid=<?=$fid?>">全部</a></li>
		<li <? if($filter == 'digest') { ?> class="current"<? } ?>><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=digest">精华</a></li>
		<? if($showpoll) { ?><li <? if($filter == 'poll') { ?> class="current"<? } ?>><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=poll">投票</a></li><? } ?>
		<? if($showtrade) { ?><li <? if($filter == 'trade') { ?> class="current"<? } ?>><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=trade">商品</a></li><? } ?>
		<? if($showreward) { ?><li <? if($filter == 'reward') { ?> class="current"<? } ?>><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=reward">悬赏</a></li><? } ?>
		<? if($showactivity) { ?><li <? if($filter == 'activity') { ?> class="current"<? } ?>><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=activity">活动</a></li><? } ?>
		<? if($showdebate) { ?><li <? if($filter == 'debate') { ?> class="current"<? } ?>><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=debate">辩论</a></li><? } ?>
		<? if($showvideo) { ?><li <? if($filter == 'video') { ?> class="current"<? } ?>><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=video">视频</a></li><? } ?>
	</ul>
</div>

<? if($forum['threadtypes']['special'][$typeid]) { ?>
	<div style="float: right; margin-top: -24px; margin-right: 10px;">
		<a href="search.php?srchtype=threadtype&amp;typeid=<?=$typeid?>&amp;srchfid=<?=$fid?>" target="_blank">搜索更多<?=$forum['threadtypes']['types'][$typeid]?>分类信息</a>
	</div>
<? } ?>

<div class="mainbox threadlist">
	<? if($forum['threadtypes'] && $forum['threadtypes']['listable']) { ?>
	<div class="headactions"><? if(is_array($forum['threadtypes']['flat'])) { foreach($forum['threadtypes']['flat'] as $id => $name) { if($typeid != $id) { ?><a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=type&amp;typeid=<?=$id?>"><?=$name?></a><? } else { ?><strong><?=$name?></strong><? } ?> <? } } if($forum['threadtypes']['selectbox']) { ?>
			<span id="threadtypesmenu" class="dropmenu" onmouseover="showMenu(this.id)">更多分类</span>
			<div class="popupmenu_popup" id="threadtypesmenu_menu" style="display: none">
			<ul><? if(is_array($forum['threadtypes']['selectbox'])) { foreach($forum['threadtypes']['selectbox'] as $id => $name) { ?><li>
				<? if($typeid != $id) { ?>
					<a href="forumdisplay.php?fid=<?=$fid?>&amp;filter=type&amp;typeid=<?=$id?>&amp;sid=<?=$sid?>"><?=$name?></a>
				<? } else { ?>
					<strong><?=$name?></strong>
				<? } ?>
				</li><? } } ?></ul>
			</div>
		<? } ?>
	</div>
	<? } ?>
	<h1>
		<a href="forumdisplay.php?fid=<?=$fid?>" class="bold"><?=$forum['name']?></a>
	</h1>
	<form method="post" name="moderate" action="topicadmin.php?action=moderate&amp;fid=<?=$fid?>">
		<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
		<table summary="forum_<?=$fid?>" <? if(!$separatepos) { ?>id="forum_<?=$fid?>"<? } ?> cellspacing="0" cellpadding="0">
			<thead class="category">
				<tr>
					<td class="folder">&nbsp;</td>
					<td class="icon">&nbsp;</td>
					<th>标题</th>
					<td class="author">作者</td>
					<td class="nums">回复/查看</td>
					<td class="lastpost">最后发表</td>
				</tr>
			</thead>

			<? if($page == 1 && !empty($announcement)) { ?>
			<tbody>
				<tr>
					<td class="folder"><img src="<?=IMGDIR?>/folder_common.gif" alt="announcement" /></td>
					<td class="icon">&nbsp;</td>
					<th>论坛公告: <? if(empty($announcement['type'])) { ?><a href="announcement.php?id=<?=$announcement['id']?>#<?=$announcement['id']?>" target="_blank"><?=$announcement['subject']?></a><? } else { ?><a href="<?=$announcement['message']?>" target="_blank"><?=$announcement['subject']?></a><? } ?></th>
					<td class="author">
						<cite><a href="space.php?action=viewpro&amp;uid=<?=$announcement['authorid']?>"><?=$announcement['author']?></a></cite>
						<em><?=$announcement['starttime']?></em>
					</td>
					<td class="nums">-</td>
					<td class="lastpost">-</td>
				</tr>
			</tbody>
			<? } if($threadcount) { if(is_array($threadlist)) { foreach($threadlist as $key => $thread) { if($separatepos == $key + 1) { ?>
		</table>
		<table summary="forum_<?=$fid?>" id="forum_<?=$fid?>" cellspacing="0" cellpadding="0">
		<thead class="separation">
			<tr><td>&nbsp;</td><td>&nbsp;</td><td colspan="4">版块主题</td></tr>
		</thead>
		<? } ?>
		<tbody id="<?=$thread['id']?>" <? if(in_array($thread['displayorder'], array(4, 5))) { ?>style="display: none"<? } ?>>
			<tr>
				<td class="folder"><a href="viewthread.php?tid=<?=$thread['tid']?>&amp;extra=<?=$extra?>" title="新窗口打开" target="_blank"><img src="<?=IMGDIR?>/folder_<?=$thread['folder']?>.gif" /></a></td>
				<td class="icon">
				<? if($thread['special'] == 1) { ?>
					<img src="<?=IMGDIR?>/pollsmall.gif" alt="投票" />
				<? } elseif($thread['special'] == 2) { ?>
					<img src="<?=IMGDIR?>/tradesmall.gif" alt="商品" />
				<? } elseif($thread['special'] == 3) { ?>
					<? if($thread['price'] > 0) { ?>
						<img src="<?=IMGDIR?>/rewardsmall.gif" alt="悬赏" />
					<? } elseif($thread['price'] < 0) { ?>
						<img src="<?=IMGDIR?>/rewardsmallend.gif" alt="悬赏已解决" />
					<? } ?>
				<? } elseif($thread['special'] == 4) { ?>
					<img src="<?=IMGDIR?>/activitysmall.gif" alt="活动" />
				<? } elseif($thread['special'] == 5) { ?>
					<img src="<?=IMGDIR?>/debatesmall.gif" alt="辩论" />
				<? } elseif($thread['special'] == 6) { ?>
					<img src="<?=IMGDIR?>/videosmall.gif" alt="视频" />
				<? } else { ?>
					<?=$thread['icon']?>
				<? } ?>
				</td>
				<th class="<?=$thread['folder']?>" <? if($forum['ismoderator']) { ?> ondblclick="ajaxget('modcp.php?action=editsubject&tid=<?=$thread['tid']?>', 'thread_<?=$thread['tid']?>', 'specialposts');doane(event);"<? } ?>>
					<label>
					<? if($thread['rate'] > 0) { ?>
						<img src="<?=IMGDIR?>/agree.gif" alt="" />
					<? } elseif($thread['rate'] < 0) { ?>
						<img src="<?=IMGDIR?>/disagree.gif" alt="" />
					<? } ?>
					<? if(in_array($thread['displayorder'], array(1, 2, 3))) { ?>
						<img src="<?=IMGDIR?>/pin_<?=$thread['displayorder']?>.gif" alt="<?=$threadsticky[3-$thread['displayorder']]?>" />
					<? } ?>
					<? if($thread['digest'] > 0) { ?>
						<img src="<?=IMGDIR?>/digest_<?=$thread['digest']?>.gif" alt="精华 <?=$thread['digest']?>" />
					<? } ?>
					&nbsp;</label>
					<? if($forum['ismoderator']) { ?>
						<? if($thread['fid'] == $fid && $thread['digest'] >= 0) { ?>
							<input class="checkbox" type="checkbox" name="moderate[]" value="<?=$thread['tid']?>" />
						<? } else { ?>
							<input class="checkbox" type="checkbox" disabled="disabled" />
						<? } ?>
					<? } ?>
					<? if($thread['moved']) { ?>
						<? if($forum['ismoderator']) { ?>
							<a href="topicadmin.php?action=delete&amp;tid=<?=$thread['moved']?>">移动:</a>
						<? } else { ?>
							移动:
						<? } ?>
					<? } ?>
					<?=$thread['typeid']?>
					<? if(isset($circle[$thread['sgid']])) { ?>
						<em>[<a href="<?=$supe['siteurl']?>/?action_mygroup_gid_<?=$thread['sgid']?>" target="_blank"><span class="lighttxt"><?=$circle[$thread['sgid']]?></span></a>]</em>
					<? } ?>
					<span id="thread_<?=$thread['tid']?>"><a href="viewthread.php?tid=<?=$thread['tid']?>&amp;extra=<?=$extra?>"<?=$thread['highlight']?>><?=$thread['subject']?></a></span>
					<? if($thread['readperm']) { ?> - [阅读权限 <span class="bold"><?=$thread['readperm']?></span>]<? } ?>
					<? if($thread['price'] > 0) { ?>
						<? if($thread['special'] == '3') { ?>
						- [悬赏
						<? } else { ?>
						- [售价
						<? } ?>
						<?=$extcredits[$creditstrans]['title']?> <span class="bold"><?=$thread['price']?></span> <?=$extcredits[$creditstrans]['unit']?>]
					<? } elseif($thread['special'] == '3' && $thread['price'] < 0) { ?>
						- [已解决]
					<? } ?>
					<? if($thread['attachment']) { ?>
						<img src="images/attachicons/common.gif" alt="附件" class="attach" />
					<? } ?>
					<? if($thread['multipage']) { ?>
						<span class="threadpages"><?=$thread['multipage']?></span>
					<? } ?>
					<? if($thread['new']) { ?>
						<a href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=newpost<?=$highlight?>#newpost" class="new">New</a>
					<? } ?>
				</th>
				<td class="author">
					<cite>
					<? if($thread['authorid'] && $thread['author']) { ?>
						<a href="space.php?action=viewpro&amp;uid=<?=$thread['authorid']?>"><?=$thread['author']?></a>
					<? } else { ?>
						<? if($forum['ismoderator']) { ?>
							<a href="space.php?action=viewpro&amp;uid=<?=$thread['authorid']?>">匿名</a>
						<? } else { ?>
							匿名
						<? } ?>
					<? } ?>
					</cite>
					<em><?=$thread['dateline']?></em>
				</td>
				<td class="nums"><strong><?=$thread['replies']?></strong> / <em><?=$thread['views']?></em></td>
				<td class="lastpost">
					<em><a href="redirect.php?tid=<?=$thread['tid']?>&amp;goto=lastpost<?=$highlight?>#lastpost"><?=$thread['lastpost']?></a></em>
					<cite>by <? if($thread['lastposter']) { ?><a href="space.php?action=viewpro&amp;username=<?=$thread['lastposterenc']?>"><?=$thread['lastposter']?></a><? } else { ?>匿名<? } ?></cite>
				</td>
			</tr>
		</tbody><? } } } else { ?>
	<tbody><tr><th colspan="6">本版块或指定的范围内尚无主题。</th></tr></tbody>
<? } ?>
</table>

<? if($forum['ismoderator'] && $threadcount) { ?>
<div class="footoperation">
	<input type="hidden" name="operation" />
	<label><input class="checkbox" type="checkbox" name="chkall" onclick="checkall(this.form, 'moderate')" /> 全选</label>
	<? if($allowdelpost) { ?><button onclick="modthreads('delete')">删除主题</button><? } ?>
	<button onclick="modthreads('move')">移动主题</button>
	<button onclick="modthreads('highlight')">高亮显示</button>
	<? if(empty($form['threadtypes'])) { ?><button onclick="modthreads('type')">主题分类</button> <? } ?>
	<button onclick="modthreads('close')">关闭/打开主题</button>
	<button onclick="modthreads('bump')">提升/下沉主题</button>
	<? if($allowstickthread) { ?><button onclick="modthreads('stick')">置顶/解除置顶</button><? } ?>
	<button onclick="modthreads('digest')">加入/解除精华</button>
	<? if($supe['status'] && $forum['supe_pushsetting']['status'] == 2) { ?><button onclick="modthreads('supe_push')">推送/解除推送</button><? } ?>
	<? if($forum['modrecommend']['open'] && $forum['modrecommend']['sort'] != 1) { ?><button type="button" onclick="modthreads('recommend')">推荐主题</button><? } ?>
	<script type="text/javascript">
		function modthreads(operation) {
			document.moderate.operation.value = operation;
			document.moderate.submit();
		}
	</script>
</div>
<? } ?>
</form>
</div>

<div class="pages_btns">
	<?=$multipage?>
	<? if($allowpost || !$discuz_uid) { ?>
		<span class="postbtn" id="newspecialtmp" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu(this.id)"><a href="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>" title="发新话题"><img src="<?=IMGDIR?>/newtopic.gif" alt="发新话题" /></a></span>
	<? } ?>
</div>

<? if($fastpost && $allowpost) { ?>
	<script src="include/javascript/post.js" type="text/javascript"></script>
	<script type="text/javascript">
	var postminchars = parseInt('<?=$minpostsize?>');
	var postmaxchars = parseInt('<?=$maxpostsize?>');
	var disablepostctrl = parseInt('<?=$disablepostctrl?>');
	var typerequired = parseInt('<?=$forum['threadtypes']['required']?>');
	function validate(theform) {
		if (theform.typeid && theform.typeid.options[theform.typeid.selectedIndex].value == 0 && typerequired) {
			alert("请选择主题对应的分类。");
			theform.typeid.focus();
			return false;
		} else if (theform.subject.value == "" || theform.message.value == "") {
			alert("请完成标题或内容栏。");
			theform.subject.focus();
			return false;
		} else if (theform.subject.value.length > 80) {
			alert("您的标题超过 80 个字符的限制。");
			theform.subject.focus();
			return false;
		}
		if (!disablepostctrl && ((postminchars != 0 && theform.message.value.length < postminchars) || (postmaxchars != 0 && theform.message.value.length > postmaxchars))) {
			alert("您的帖子长度不符合要求。\n\n当前长度: "+theform.message.value.length+" 字节\n系统限制: "+postminchars+" 到 "+postmaxchars+" 字节");
			return false;
		}
		if(!fetchCheckbox('parseurloff')) {
			theform.message.value = parseurl(theform.message.value, 'bbcode');
		}
		theform.topicsubmit.disabled = true;
		return true;
	}
	</script>
	<form method="post" id="postform" action="post.php?action=newthread&amp;fid=<?=$fid?>&amp;extra=<?=$extra?>&amp;topicsubmit=yes" onSubmit="return validate(this)">
		<input type="hidden" name="formhash" value="<?=FORMHASH?>" />
		<div id="quickpost" class="box">
			<span class="headactions"><a href="member.php?action=credits&amp;view=forum_post&amp;fid=<?=$fid?>" target="_blank">查看积分策略说明</a></span>
			<h4>快速发新话题</h4>
			<div class="postoptions">
				<h5>选项</h5>
				<p><label><input class="checkbox" type="checkbox" name="parseurloff" id="parseurloff" value="1" /> 禁用 URL 识别</label></p>
				<p><label><input class="checkbox" type="checkbox" name="smileyoff" id="smileyoff" value="1" /> 禁用 </label><a href="faq.php?action=message&amp;id=32" target="_blank">表情</a></p>
				<p><label><input class="checkbox" type="checkbox" name="bbcodeoff" id="bbcodeoff" value="1" /> 禁用 </label><a href="faq.php?action=message&amp;id=18" target="_blank">Discuz!代码</a></p>
				<? if($allowanonymous || $forum['allowanonymous']) { ?><p><label><input class="checkbox" type="checkbox" name="isanonymous" value="1" /> 使用匿名发帖</label></p><? } ?>
				<p><label><input class="checkbox" type="checkbox" name="usesig" value="1" <?=$usesigcheck?> /> 使用个人签名</label></p>
				<p><label><input class="checkbox" type="checkbox" name="emailnotify" value="1" /> 接收新回复邮件通知</label></p>
				<? if($allowuseblog && $forum['allowshare']) { ?><p><label><input class="checkbox" type="checkbox" name="addtoblog" value="1" /> 加入文集</label></p><? } ?>
			</div>
			<div class="postform">
				<h5><label for="subject">标题</label>
				<? if($iscircle && $mycircles) { ?><select name='sgid'><option value="0">请选择圈子</option><? if(is_array($mycircles)) { foreach($mycircles as $id => $name) { ?><option value="<?=$id?>"><?=$name?></option><? } } ?></select><? } else { ?><?=$typeselect?><? } ?> <input type="text" id="subject" name="subject" tabindex="1" /></label></h5>
				<div id="threadtypes"></div>
				<p><label>内容</label>
				<textarea rows="7" cols="80" class="autosave" name="message" id="message" onKeyDown="ctlent(event);" tabindex="2"></textarea>
				</p>
				<p class="btns">
					<button type="submit" name="topicsubmit" id="postsubmit" tabindex="3">发表帖子</button>[完成后可按 Ctrl+Enter 发布]&nbsp;
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
<? } if($whosonlinestatus) { ?>
	<div class="box">
	<? if($detailstatus) { ?>
		<span class="headactions"><a href="forumdisplay.php?fid=<?=$fid?>&amp;page=<?=$page?>&amp;showoldetails=no#online"><img src="<?=IMGDIR?>/collapsed_no.gif" alt="" /></a></span>
		<h4>正在浏览此版块的会员</h4>
		<ul class="userlist"><? if(is_array($whosonline)) { foreach($whosonline as $key => $online) { ?><li title="时间: <?=$online['lastactivity']?><?="\n"?> 操作: <?=$online['action']?><?="\n"?> 版块: <?=$forumname?>">
			<img src="images/common/<?=$online['icon']?>"  alt="" />
			<? if($online['uid']) { ?>
				<a href="space.php?uid=<?=$online['uid']?>"><?=$online['username']?></a>
			<? } else { ?>
				<?=$online['username']?>
			<? } ?>
			</li><? } } ?></ul>
	<? } else { ?>
		<span class="headactions"><a href="forumdisplay.php?fid=<?=$fid?>&amp;page=<?=$page?>&amp;showoldetails=yes#online" class="nobdr"><img src="<?=IMGDIR?>/collapsed_yes.gif" alt="" /></a></span>
		<h4>正在浏览此版块的会员</h4>
	<? } ?>
</div>
<? } ?>

<div id="footfilter" class="box">
	<form method="get" action="forumdisplay.php">
		<input type="hidden" name="fid" value="<?=$fid?>" />
		<? if($filter == 'digest' || $filter == 'type') { ?>
			<input type="hidden" name="filter" value="<?=$filter?>" />
			<input type="hidden" name="typeid" value="<?=$typeid?>" />
		<? } else { ?>
			查看 <select name="filter">
				<option value="0" <?=$check['0']?>>全部主题</option>
				<option value="86400" <?=$check['86400']?>>1 天以来主题</option>
				<option value="172800" <?=$check['172800']?>>2 天以来主题</option>
				<option value="604800" <?=$check['604800']?>>1 周以来主题</option>
				<option value="2592000" <?=$check['2592000']?>>1 个月以来主题</option>
				<option value="7948800" <?=$check['7948800']?>>3 个月以来主题</option>
				<option value="15897600" <?=$check['15897600']?>>6 个月以来主题</option>
				<option value="31536000" <?=$check['31536000']?>>1 年以来主题</option>
			</select>
		<? } ?>
		排序方式
		<select name="orderby">
			<option value="lastpost" <?=$check['lastpost']?>>回复时间</option>
			<option value="dateline" <?=$check['dateline']?>>发布时间</option>
			<option value="replies" <?=$check['replies']?>>回复数量</option>
			<option value="views" <?=$check['views']?>>浏览次数</option>
		</select>
		<select name="ascdesc">
			<option value="DESC" <?=$check['DESC']?>>按降序排列</option>
			<option value="ASC" <?=$check['ASC']?>>按升序排列</option>
		</select>
		&nbsp;<button type="submit">提交</button>
	</form>
<? if($forumjump && !$jsmenu['1']) { ?>
	<span id="forumjump" onmouseover="showMenu(this.id, false, 2)" class="dropmenu">版块跳转 ...</span>&nbsp;
	<ul class="popupmenu_popup" id="forumjump_menu" style="display: none">
	<?=$forumselect?>
	</ul>
<? } if($visitedforums) { ?>
	<span id="visited_forums" onmouseover="showMenu(this.id, false, 2)" class="dropmenu">最近访问的版块</span>
	<ul class="popupmenu_popup" id="visited_forums_menu" style="display: none">
	<?=$visitedforums?>
	</ul>
<? } ?>
</div>


<div class="legend">
	<label><img src="<?=IMGDIR?>/folder_new.gif" alt="有新回复" />有新回复</label>
	<label><img src="<?=IMGDIR?>/folder_common.gif" alt="无新回复" />无新回复</label>
	<label><img src="<?=IMGDIR?>/folder_hot.gif" alt="热门主题" />热门主题</label>
	<label><img src="<?=IMGDIR?>/folder_lock.gif" alt="关闭主题" />关闭主题</label>
</div>

<? if($forumjump && $jsmenu['1']) { ?>
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
			window.location = 'forumdisplay.php?fid=<?=$fid?><?=$forumdisplayadd?>&page=<? echo $page+1;; ?>';
		}
		<? } ?>
		<? if($page > 1) { ?>
		if(actualCode == 37) {
			window.location = 'forumdisplay.php?fid=<?=$fid?><?=$forumdisplayadd?>&page=<? echo $page-1;; ?>';
		}
		<? } ?>
	}
}
</script>
<? include template('footer'); ?>
