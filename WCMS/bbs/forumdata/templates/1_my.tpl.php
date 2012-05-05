<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<div id="nav">
	<a href="<?=$indexname?>"><?=$bbname?></a> &raquo; <? if($srchfid) { ?><a href="my.php?item=<?=$item?><?=$extra?>"><? } if(empty($item)) { ?>我的...<? } elseif($item == 'threads') { ?>我的主题<? } elseif($item == 'polls') { ?>我的投票<? } elseif($item == 'posts') { ?>我的回复<? } elseif($item == 'favorites' && $type == 'thread') { ?>收藏的主题<? } elseif($item == 'favorites' && $type == 'forum') { ?>收藏的版块<? } elseif($item == 'subscriptions') { ?>订阅的主题<? } elseif(in_array($item, array('tradestats', 'selltrades', 'buytrades', 'tradethreads'))) { ?>我的商品<? } elseif($item == 'reward') { ?>我的悬赏<? } elseif($item == 'activities') { ?>我的活动<? } elseif($item == 'debate') { ?>我的辩论<? } elseif($item == 'video') { ?>我的视频<? } elseif($item == 'promotion' && ($creditspolicy['promotion_visit'] || $creditspolicy['promotion_register'])) { ?>我的推广<? } if($srchfid) { ?></a> &raquo; <?=$forumname?><? } ?>
</div>
<div class="container">
	<div class="content">
		<div class="mainbox">

<? if(empty($item)) { include template('my_index'); } elseif(in_array($item, array('threads', 'posts'))) { ?>
	<h1>我的话题</h1>
	<ul class="tabs headertabs">
	<li <? if($item == 'threads') { ?> class="current"<? } ?>><a href="my.php?item=threads<?=$extrafid?>">我的主题</a></li>
	<li <? if($item == 'posts') { ?> class="current"<? } ?>><a href="my.php?item=posts<?=$extrafid?>">我的回复</a></li>
	</ul>
	<? if($item == 'threads') { include template('my_threads'); } elseif($item == 'posts') { include template('my_posts'); } } elseif($item == 'favorites') { ?>
	<h1>我的收藏</h1>
	<ul class="tabs headertabs">
	<li <? if($type == 'thread') { ?> class="current"<? } ?>><a href="my.php?item=favorites&amp;type=thread<?=$extrafid?>">收藏的主题</a></li>
	<li <? if($type == 'forum') { ?> class="current"<? } ?>><a href="my.php?item=favorites&amp;type=forum<?=$extrafid?>">收藏的版块</a></li>
	</ul>
<? include template('my_favorites'); } elseif($item == 'subscriptions') { ?>
	<h1>我的订阅</h1>
	<ul class="tabs headertabs">
	<li class="current"><a href="my.php?item=subscriptions&amp;type=forum<?=$extrafid?>" class="current">订阅的主题</a></li>
	</ul>
<? include template('my_subscriptions'); } elseif($item == 'polls') { ?>
	<h1>我的投票</h1>
	<ul class="tabs headertabs">
	<li <? if($item == 'polls' && $type == 'poll') { ?> class="current"<? } ?>><a href="my.php?item=polls&amp;type=poll<?=$extrafid?>">我发起的投票</a></li>
	<li <? if($item == 'polls' && $type == 'join') { ?> class="current"<? } ?>><a href="my.php?item=polls&amp;type=join<?=$extrafid?>">我参与的投票</a></li>
	</ul>
<? include template('my_polls'); } elseif(in_array($item, array('tradestats', 'selltrades', 'buytrades', 'tradethreads'))) { ?>
	<h1>我的商品</h1>
	<ul class="tabs <? if($item == 'tradestats') { ?>headertabs<? } ?>">
	<li <? if($item == 'tradestats') { ?> class="current"<? } ?>><a href="my.php?item=tradestats<?=$extrafid?>">交易统计</a></li>
	<li <? if($item == 'buytrades') { ?> class="dropmenu hover current"<? } else { ?> class="dropmenu"<? } ?>><a href="my.php?item=buytrades<?=$extrafid?>" id="buytrades" onmouseover="showMenu(this.id)">我是买家</a></li>
	<li <? if($item == 'selltrades' || $item == 'tradethreads') { ?> class="dropmenu hover current"<? } else { ?> class="dropmenu"<? } ?>><a href="my.php?item=tradethreads<?=$extrafid?>" id="tradethreads" onmouseover="showMenu(this.id)">我是卖家</a></li>
	<li><a href="eccredit.php?uid=<?=$discuz_uid?>" target="_blank">信用评价</a></li>
	</ul>

	<ul class="popupmenu_popup headermenu_popup" id="buytrades_menu" style="display: none">
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>">进行中的交易</a></li>
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=attention">关注的交易</a></li>
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=eccredit">评价的交易</a></li>
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=success">成功的交易</a></li>
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=refund">退款的交易</a></li>
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=closed">失败的交易</a></li>
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=unstart">未生效的交易</a></li>
	<li><a href="my.php?item=buytrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=all">全部交易</a></li>
	</ul>

	<ul class="popupmenu_popup headermenu_popup" id="tradethreads_menu" style="display: none">
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>">进行中的交易</a></li>
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=attention">关注的交易</a></li>
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=eccredit">评价的交易</a></li>
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=success">成功的交易</a></li>
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=refund">退款的交易</a></li>
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=closed">失败的交易</a></li>
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=unstart">未生效的交易</a></li>
	<li><a href="my.php?item=selltrades<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>&amp;filter=all">全部交易</a></li>
	<li><a href="my.php?item=tradethreads<?=$extratid?><?=$extrafid?><?=$extrasrchkey?>">出售中的商品</a></li>
	</ul>

	<? if($item == 'tradestats') { include template('my_tradestats'); } elseif($item == 'selltrades' || $item == 'buytrades') { include template('my_trades'); } elseif($item == 'tradethreads') { include template('my_tradethreads'); } } elseif($item == 'reward') { ?>
	<h1>我的悬赏</h1>
	<ul class="tabs">
	<li <? if($type == 'stats') { ?> class="current"<? } ?>><a href="my.php?item=reward&amp;type=stats<?=$extrafid?>">悬赏统计</a></li>
	<li <? if($type == 'question') { ?> class="dropmenu hover current"<? } else { ?> class="dropmenu"<? } ?>><a href="my.php?item=reward&amp;type=question<?=$extrafid?>" id="myquestion" onmouseover="showMenu(this.id)">我的问题</a></li>
	<li <? if($type == 'answer') { ?> class="dropmenu hover current"<? } else { ?> class="dropmenu"<? } ?>><a href="my.php?item=reward&amp;type=answer<?=$extrafid?>" id="myanswer" onmouseover="showMenu(this.id)">我的回答</a></li>
	</ul>

	<ul class="popupmenu_popup headermenu_popup" id="myquestion_menu" style="display: none">
	<li><a href="my.php?item=reward&amp;type=question&amp;filter=<?=$extrafid?>">全部问题</a></li>
	<li><a href="my.php?item=reward&amp;type=question&amp;filter=solved<?=$extrafid?>">已解决的问题</a></li>
	<li><a href="my.php?item=reward&amp;type=question&amp;filter=unsolved<?=$extrafid?>">未解决的问题</a></li>
	</ul>

	<ul class="popupmenu_popup headermenu_popup" id="myanswer_menu" style="display: none">
	<li><a href="my.php?item=reward&amp;type=answer&amp;filter=<?=$extrafid?>">全部回答</a></li>
	<li><a href="my.php?item=reward&amp;type=answer&amp;filter=adopted<?=$extrafid?>">被采纳的回答</a></li>
	<li><a href="my.php?item=reward&amp;type=answer&amp;filter=unadopted<?=$extrafid?>">未采纳的回答</a></li>
	</ul>
<? include template('my_rewards'); } elseif($item == 'activities') { ?>
	<h1>我的活动</h1>
	<ul class="tabs">
	<li <? if($type == 'orig') { ?> class="dropmenu hover current"<? } else { ?> class="dropmenu"<? } ?>><a href="my.php?item=activities&amp;type=orig<?=$extrafid?>" id="myorig" onmouseover="showMenu(this.id)">发起的活动</a></li>
	<li <? if($type == 'apply') { ?> class="dropmenu hover current"<? } else { ?> class="dropmenu"<? } ?>><a href="my.php?item=activities&amp;type=apply<?=$extrafid?>" id="myapply" onmouseover="showMenu(this.id)">申请的活动</a></li>
	</ul>

	<ul class="popupmenu_popup headermenu_popup" id="myorig_menu" style="display: none">
	<li><a href="my.php?item=activities&amp;type=orig&amp;filter=<?=$extrafid?>">全部活动</a></li>
	<li><a href="my.php?item=activities&amp;type=orig&amp;ended=no<?=$extrafid?>">未结束的活动</a></li>
	<li><a href="my.php?item=activities&amp;type=orig&amp;ended=yes<?=$extrafid?>">已结束的活动</a></li>
	</ul>

	<ul class="popupmenu_popup headermenu_popup" id="myapply_menu" style="display: none">
	<li><a href="my.php?item=activities&amp;type=apply&amp;filter=<?=$extrafid?>">全部活动</a></li>
	<li><a href="my.php?item=activities&amp;type=apply&amp;ended=no<?=$extrafid?>">未结束的活动</a></li>
	<li><a href="my.php?item=activities&amp;type=apply&amp;ended=yes<?=$extrafid?>">已结束的活动</a></li>
	</ul>
<? include template('my_activities'); } elseif($item == 'debate') { ?>
	<h1>我的辩论</h1>
	<ul class="tabs headertabs">
	<li <? if($item == 'debate' && $type == 'orig') { ?> class="current"<? } ?>><a href="my.php?item=debate&amp;type=orig<?=$extrafid?>">我发起的辩论</a></li>
	<li <? if($item == 'debate' && $type == 'apply') { ?> class="current"<? } ?>><a href="my.php?item=debate&amp;type=apply<?=$extrafid?>">我参与的辩论</a></li>
	</ul>
<? include template('my_debate'); } elseif($item == 'buddylist') { ?>
	<h1>我的好友</h1>
<? include template('my_buddylist'); } elseif($item == 'promotion' && ($creditspolicy['promotion_visit'] || $creditspolicy['promotion_register'])) { ?>
	<h1>我的推广</h1>
<? include template('my_promotion'); } elseif($item == 'video') { ?>
	<h1>我的视频</h1>
<? include template('my_video'); } ?>

</div>
<? if(!empty($multipage)) { ?><div class="pages_btns"><?=$multipage?></div><? } ?>
</div>
<div class="side">
<? include template('personal_navbar'); ?>
</div>
</div>
<? include template('footer'); ?>
