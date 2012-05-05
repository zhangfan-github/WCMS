<? if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('header'); ?>
<script src="include/javascript/viewthread.js" type="text/javascript"></script>
<script type="text/javascript">zoomstatus = parseInt(<?=$zoomstatus?>);</script>

<div class="container">
	<div id="foruminfo">
		<div id="nav">
			<a href="<?=$indexname?>"><?=$bbname?></a> &raquo; ¶ÌÏûÏ¢
		</div>
	</div>
	<div class="content">

		<? if(empty($action)) { include template('pm_folder'); } elseif($action == 'view') { include template('pm_view'); } elseif($action == 'send') { include template('pm_send'); } elseif($action == 'search') { ?>
			<? if(!empty($searchid)) { include template('pm_search_result'); } else { include template('pm_search'); } ?>
		<? } elseif($action == 'archive') { include template('pm_archive'); } elseif($action == 'ignore') { include template('pm_ignore'); } ?>

	</div>
	<div class="side">
<? include template('personal_navbar'); ?>
</div>
</div>
<? include template('footer'); ?>
