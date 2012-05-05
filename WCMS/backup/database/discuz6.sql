-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 05 月 05 日 05:25
-- 服务器版本: 5.5.16
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `xmly`
--

-- --------------------------------------------------------

--
-- 表的结构 `discuz_access`
--

CREATE TABLE IF NOT EXISTS `discuz_access` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `allowview` tinyint(1) NOT NULL DEFAULT '0',
  `allowpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowreply` tinyint(1) NOT NULL DEFAULT '0',
  `allowgetattach` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostattach` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_activities`
--

CREATE TABLE IF NOT EXISTS `discuz_activities` (
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cost` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `starttimefrom` int(10) unsigned NOT NULL DEFAULT '0',
  `starttimeto` int(10) unsigned NOT NULL DEFAULT '0',
  `place` char(40) NOT NULL DEFAULT '',
  `class` char(20) NOT NULL DEFAULT '',
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `uid` (`uid`,`starttimefrom`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_activityapplies`
--

CREATE TABLE IF NOT EXISTS `discuz_activityapplies` (
  `applyid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(15) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `message` char(200) NOT NULL DEFAULT '',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `payment` mediumint(8) NOT NULL DEFAULT '0',
  `contact` char(200) NOT NULL,
  PRIMARY KEY (`applyid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `dateline` (`tid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_adminactions`
--

CREATE TABLE IF NOT EXISTS `discuz_adminactions` (
  `admingid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `disabledactions` text NOT NULL,
  PRIMARY KEY (`admingid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_admingroups`
--

CREATE TABLE IF NOT EXISTS `discuz_admingroups` (
  `admingid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `alloweditpost` tinyint(1) NOT NULL DEFAULT '0',
  `alloweditpoll` tinyint(1) NOT NULL DEFAULT '0',
  `allowstickthread` tinyint(1) NOT NULL DEFAULT '0',
  `allowmodpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowdelpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowmassprune` tinyint(1) NOT NULL DEFAULT '0',
  `allowrefund` tinyint(1) NOT NULL DEFAULT '0',
  `allowcensorword` tinyint(1) NOT NULL DEFAULT '0',
  `allowviewip` tinyint(1) NOT NULL DEFAULT '0',
  `allowbanip` tinyint(1) NOT NULL DEFAULT '0',
  `allowedituser` tinyint(1) NOT NULL DEFAULT '0',
  `allowmoduser` tinyint(1) NOT NULL DEFAULT '0',
  `allowbanuser` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostannounce` tinyint(1) NOT NULL DEFAULT '0',
  `allowviewlog` tinyint(1) NOT NULL DEFAULT '0',
  `allowbanpost` tinyint(1) NOT NULL DEFAULT '0',
  `disablepostctrl` tinyint(1) NOT NULL DEFAULT '0',
  `supe_allowpushthread` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admingid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_admingroups`
--

INSERT INTO `discuz_admingroups` (`admingid`, `alloweditpost`, `alloweditpoll`, `allowstickthread`, `allowmodpost`, `allowdelpost`, `allowmassprune`, `allowrefund`, `allowcensorword`, `allowviewip`, `allowbanip`, `allowedituser`, `allowmoduser`, `allowbanuser`, `allowpostannounce`, `allowviewlog`, `allowbanpost`, `disablepostctrl`, `supe_allowpushthread`) VALUES
(1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 1, 0, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(3, 1, 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_adminnotes`
--

CREATE TABLE IF NOT EXISTS `discuz_adminnotes` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(15) NOT NULL DEFAULT '',
  `access` tinyint(3) NOT NULL DEFAULT '0',
  `adminid` tinyint(3) NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_adminsessions`
--

CREATE TABLE IF NOT EXISTS `discuz_adminsessions` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `errorcount` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_adminsessions`
--

INSERT INTO `discuz_adminsessions` (`uid`, `ip`, `dateline`, `errorcount`) VALUES
(1, '218.75.123.171', 1329271924, -1);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_advertisements`
--

CREATE TABLE IF NOT EXISTS `discuz_advertisements` (
  `advid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `targets` text NOT NULL,
  `parameters` text NOT NULL,
  `code` text NOT NULL,
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`advid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_announcements`
--

CREATE TABLE IF NOT EXISTS `discuz_announcements` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(15) NOT NULL DEFAULT '',
  `subject` varchar(250) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `groups` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timespan` (`starttime`,`endtime`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_attachments`
--

CREATE TABLE IF NOT EXISTS `discuz_attachments` (
  `aid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `readperm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `price` smallint(6) unsigned NOT NULL DEFAULT '0',
  `filename` char(100) NOT NULL DEFAULT '',
  `description` char(100) NOT NULL DEFAULT '',
  `filetype` char(50) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment` char(100) NOT NULL DEFAULT '',
  `downloads` mediumint(8) NOT NULL DEFAULT '0',
  `isimage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thumb` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `remote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`,`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_attachpaymentlog`
--

CREATE TABLE IF NOT EXISTS `discuz_attachpaymentlog` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `aid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `netamount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`,`uid`),
  KEY `uid` (`uid`),
  KEY `authorid` (`authorid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_attachtypes`
--

CREATE TABLE IF NOT EXISTS `discuz_attachtypes` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `extension` char(12) NOT NULL DEFAULT '',
  `maxsize` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_banned`
--

CREATE TABLE IF NOT EXISTS `discuz_banned` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `ip1` smallint(3) NOT NULL DEFAULT '0',
  `ip2` smallint(3) NOT NULL DEFAULT '0',
  `ip3` smallint(3) NOT NULL DEFAULT '0',
  `ip4` smallint(3) NOT NULL DEFAULT '0',
  `admin` varchar(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_bbcodes`
--

CREATE TABLE IF NOT EXISTS `discuz_bbcodes` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL,
  `replacement` text NOT NULL,
  `example` varchar(255) NOT NULL DEFAULT '',
  `explanation` text NOT NULL,
  `params` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `prompt` text NOT NULL,
  `nest` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `discuz_bbcodes`
--

INSERT INTO `discuz_bbcodes` (`id`, `available`, `tag`, `icon`, `replacement`, `example`, `explanation`, `params`, `prompt`, `nest`) VALUES
(1, 0, 'fly', 'bb_fly.gif', '<marquee width="90%" behavior="alternate" scrollamount="3">{1}</marquee>', '[fly]This is sample text[/fly]', '使内容横向滚动，这个效果类似 HTML 的 marquee 标签，注意：这个效果只在 Internet Explorer 浏览器下有效。', 1, '请输入滚动显示的文字:', 1),
(2, 0, 'flash', 'bb_flash.gif', '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="550" height="400"><param name="allowScriptAccess" value="sameDomain"><param name="movie" value="{1}"><param name="quality" value="high"><param name="bgcolor" value="#ffffff"><embed src="{1}" quality="high" bgcolor="#ffffff" width="550" height="400" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>', 'Flash Movie', '嵌入 Flash 动画', 1, '请输入 Flash 动画的 URL:', 1),
(3, 1, 'qq', 'bb_qq.gif', '<a href="http://wpa.qq.com/msgrd?V=1&Uin={1}&amp;Site=[Discuz!]&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:{1}:1" border="0"></a>', '[qq]688888[/qq]', '显示 QQ 在线状态，点这个图标可以和他（她）聊天', 1, '请输入显示在线状态 QQ 号码:', 1),
(4, 0, 'sup', 'bb_sup.gif', '<sup>{1}</sup>', 'X[sup]2[/sup]', '嵌入 Real 音频', 1, '请输入上标文字：', 1),
(5, 0, 'sub', 'bb_sub.gif', '<sub>{1}</sub>', 'X[sub]2[/sub]', '嵌入 Real 音频或视频', 1, '请输入下标文字：', 1);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_buddys`
--

CREATE TABLE IF NOT EXISTS `discuz_buddys` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `buddyid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `description` char(255) NOT NULL DEFAULT '',
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_caches`
--

CREATE TABLE IF NOT EXISTS `discuz_caches` (
  `cachename` varchar(32) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `expiration` int(10) unsigned NOT NULL,
  `data` mediumtext NOT NULL,
  PRIMARY KEY (`cachename`),
  KEY `expiration` (`type`,`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_caches`
--

INSERT INTO `discuz_caches` (`cachename`, `type`, `dateline`, `expiration`, `data`) VALUES
('settings', 1, 1326429968, 0, '$_DCACHE[''settings''] = array (\n  ''accessemail'' => '''',\n  ''adminipaccess'' => '''',\n  ''allowcsscache'' => ''1'',\n  ''archiverstatus'' => ''1'',\n  ''attachbanperiods'' => '''',\n  ''attachimgpost'' => ''1'',\n  ''attachrefcheck'' => ''0'',\n  ''attachsave'' => ''3'',\n  ''authkey'' => ''437ae0XEXifqb5NU'',\n  ''bannedmessages'' => ''1'',\n  ''bbclosed'' => ''0'',\n  ''bbinsert'' => ''1'',\n  ''bbname'' => ''禧妈拉伢俱乐部会员社区'',\n  ''bdaystatus'' => ''0'',\n  ''boardlicensed'' => ''0'',\n  ''censoremail'' => '''',\n  ''censoruser'' => '''',\n  ''creditsformula'' => ''$member[\\''extcredits1\\'']'',\n  ''creditsformulaexp'' => '''',\n  ''creditspolicy'' => \n  array (\n    ''post'' => \n    array (\n    ),\n    ''reply'' => \n    array (\n    ),\n    ''digest'' => \n    array (\n      1 => 10,\n    ),\n    ''postattach'' => \n    array (\n    ),\n    ''getattach'' => \n    array (\n    ),\n    ''pm'' => \n    array (\n    ),\n    ''search'' => \n    array (\n    ),\n  ),\n  ''creditstax'' => ''0.2'',\n  ''creditstrans'' => ''2'',\n  ''dateformat'' => ''Y-n-j'',\n  ''debug'' => ''1'',\n  ''delayviewcount'' => ''0'',\n  ''deletereason'' => '''',\n  ''doublee'' => ''1'',\n  ''dupkarmarate'' => ''0'',\n  ''ec_account'' => '''',\n  ''ec_maxcredits'' => ''1000'',\n  ''ec_maxcreditspermonth'' => ''0'',\n  ''ec_mincredits'' => ''0'',\n  ''ec_ratio'' => ''0'',\n  ''editedby'' => ''1'',\n  ''editoroptions'' => ''1'',\n  ''edittimelimit'' => '''',\n  ''exchangemincredits'' => ''100'',\n  ''extcredits'' => \n  array (\n    1 => \n    array (\n      ''title'' => ''威望'',\n      ''showinthread'' => '''',\n    ),\n    2 => \n    array (\n      ''title'' => ''金钱'',\n      ''showinthread'' => '''',\n    ),\n  ),\n  ''fastpost'' => ''1'',\n  ''floodctrl'' => ''15'',\n  ''forumjump'' => ''0'',\n  ''globalstick'' => ''1'',\n  ''gzipcompress'' => ''0'',\n  ''hideprivate'' => ''1'',\n  ''hottopic'' => ''10'',\n  ''icp'' => '''',\n  ''initcredits'' => ''0,0,0,0,0,0,0,0,0'',\n  ''ipaccess'' => '''',\n  ''ipregctrl'' => '''',\n  ''jscachelife'' => ''1800'',\n  ''jsrefdomains'' => '''',\n  ''jsstatus'' => ''0'',\n  ''karmaratelimit'' => ''0'',\n  ''loadctrl'' => ''0'',\n  ''losslessdel'' => ''365'',\n  ''maxavatarpixel'' => ''120'',\n  ''maxavatarsize'' => ''20000'',\n  ''maxbdays'' => ''0'',\n  ''maxchargespan'' => ''0'',\n  ''maxfavorites'' => ''100'',\n  ''maxincperthread'' => ''0'',\n  ''maxmodworksmonths'' => ''3'',\n  ''maxonlinelist'' => ''0'',\n  ''maxpolloptions'' => ''10'',\n  ''maxpostsize'' => ''10000'',\n  ''maxsearchresults'' => ''500'',\n  ''maxsigrows'' => ''100'',\n  ''maxsmilies'' => ''10'',\n  ''maxspm'' => ''0'',\n  ''maxsubscriptions'' => ''100'',\n  ''membermaxpages'' => ''100'',\n  ''memberperpage'' => ''25'',\n  ''memliststatus'' => ''1'',\n  ''minpostsize'' => ''10'',\n  ''moddisplay'' => ''flat'',\n  ''modratelimit'' => ''0'',\n  ''modworkstatus'' => ''0'',\n  ''myrecorddays'' => ''30'',\n  ''newbiespan'' => ''0'',\n  ''nocacheheaders'' => ''0'',\n  ''oltimespan'' => ''10'',\n  ''onlinerecord'' => ''7	1326374069'',\n  ''passport_expire'' => ''3600'',\n  ''passport_extcredits'' => ''0'',\n  ''passport_key'' => ''1234567890'',\n  ''passport_login_url'' => ''index.php?controller=simple&action=login'',\n  ''passport_logout_url'' => ''index.php?controller=simple&action=logout'',\n  ''passport_register_url'' => ''index.php?controller=simple&action=reg'',\n  ''passport_status'' => ''passport'',\n  ''passport_url'' => ''/'',\n  ''postbanperiods'' => '''',\n  ''postmodperiods'' => '''',\n  ''postperpage'' => ''10'',\n  ''pvfrequence'' => ''60'',\n  ''qihoo'' => \n  array (\n  ),\n  ''ratelogrecord'' => ''5'',\n  ''regadvance'' => ''0'',\n  ''regctrl'' => ''0'',\n  ''regfloodctrl'' => ''0'',\n  ''regstatus'' => ''1'',\n  ''regverify'' => ''0'',\n  ''reportpost'' => ''1'',\n  ''rewritestatus'' => ''0'',\n  ''rssstatus'' => ''1'',\n  ''rssttl'' => ''60'',\n  ''searchbanperiods'' => '''',\n  ''searchctrl'' => ''30'',\n  ''seccodestatus'' => ''0'',\n  ''seodescription'' => '''',\n  ''seohead'' => '''',\n  ''seokeywords'' => '''',\n  ''seotitle'' => '''',\n  ''showemail'' => '''',\n  ''showimages'' => ''1'',\n  ''showsettings'' => ''7'',\n  ''sitename'' => ''禧妈拉伢俱乐部'',\n  ''siteurl'' => ''http://www.xylaclub.com'',\n  ''smcols'' => ''4'',\n  ''smileyinsert'' => ''1'',\n  ''starthreshold'' => ''2'',\n  ''statscachelife'' => ''180'',\n  ''statstatus'' => '''',\n  ''styleid'' => ''4'',\n  ''stylejump'' => \n  array (\n    1 => ''默认风格'',\n    2 => ''喝彩奥运'',\n    3 => ''深邃永恒'',\n    4 => ''粉妆精灵'',\n    5 => ''诗意田园'',\n    6 => ''春意盎然'',\n  ),\n  ''subforumsindex'' => ''0'',\n  ''threadmaxpages'' => ''1000'',\n  ''threadsticky'' => \n  array (\n    0 => ''全局置顶'',\n    1 => ''分类置顶'',\n    2 => ''本版置顶'',\n  ),\n  ''timeformat'' => ''H:i'',\n  ''timeoffset'' => ''8'',\n  ''topicperpage'' => ''20'',\n  ''transfermincredits'' => ''1000'',\n  ''transsidstatus'' => ''0'',\n  ''userstatusby'' => ''1'',\n  ''visitbanperiods'' => '''',\n  ''visitedforums'' => ''10'',\n  ''vtonlinestatus'' => ''1'',\n  ''wapcharset'' => ''2'',\n  ''wapdateformat'' => ''n/j'',\n  ''wapmps'' => ''500'',\n  ''wapppp'' => ''5'',\n  ''wapstatus'' => ''1'',\n  ''waptpp'' => ''10'',\n  ''watermarkquality'' => ''80'',\n  ''watermarkstatus'' => ''0'',\n  ''watermarktrans'' => ''65'',\n  ''whosonlinestatus'' => ''1'',\n  ''indexname'' => ''index.php'',\n  ''spacedata'' => \n  array (\n    ''cachelife'' => ''900'',\n    ''limitmythreads'' => ''5'',\n    ''limitmyreplies'' => ''5'',\n    ''limitmyrewards'' => ''5'',\n    ''limitmytrades'' => ''5'',\n    ''limitmyvideos'' => ''0'',\n    ''limitmyblogs'' => ''8'',\n    ''limitmyfriends'' => ''0'',\n    ''limitmyfavforums'' => ''5'',\n    ''limitmyfavthreads'' => ''0'',\n    ''textlength'' => ''300'',\n  ),\n  ''thumbstatus'' => ''0'',\n  ''thumbwidth'' => ''400'',\n  ''thumbheight'' => ''300'',\n  ''forumlinkstatus'' => ''0'',\n  ''pluginjsmenu'' => ''插件'',\n  ''magicstatus'' => ''1'',\n  ''magicmarket'' => ''1'',\n  ''maxmagicprice'' => ''50'',\n  ''upgradeurl'' => ''http://localhost/develop/dzhead/develop/upgrade.php'',\n  ''ftp'' => \n  array (\n    ''on'' => ''0'',\n    ''ssl'' => ''0'',\n    ''host'' => '''',\n    ''port'' => ''21'',\n    ''username'' => '''',\n    ''password'' => '''',\n    ''attachdir'' => ''.'',\n    ''attachurl'' => '''',\n    ''hideurl'' => ''0'',\n    ''timeout'' => ''0'',\n    ''connid'' => 0,\n  ),\n  ''wapregister'' => ''0'',\n  ''passport_shopex'' => ''0'',\n  ''seccodeanimator'' => ''1'',\n  ''welcomemsgtitle'' => ''{username}，您好，感谢您的注册，请阅读以下内容。'',\n  ''cacheindexlife'' => ''0'',\n  ''cachethreadlife'' => ''0'',\n  ''cachethreaddir'' => ''forumdata/threadcaches'',\n  ''jsdateformat'' => '''',\n  ''seccodedata'' => \n  array (\n    ''minposts'' => '''',\n    ''loginfailedcount'' => 0,\n    ''width'' => 150,\n    ''height'' => 60,\n    ''type'' => ''0'',\n    ''background'' => ''1'',\n    ''adulterate'' => ''1'',\n    ''ttf'' => ''0'',\n    ''angle'' => ''0'',\n    ''color'' => ''1'',\n    ''size'' => ''0'',\n    ''shadow'' => ''1'',\n    ''animator'' => ''0'',\n  ),\n  ''frameon'' => ''0'',\n  ''framewidth'' => ''180'',\n  ''smrows'' => ''4'',\n  ''watermarktype'' => ''0'',\n  ''secqaa'' => \n  array (\n    ''status'' => \n    array (\n      1 => ''0'',\n      2 => ''0'',\n      3 => ''0'',\n    ),\n  ),\n  ''spacestatus'' => ''1'',\n  ''whosonline_contract'' => ''0'',\n  ''attachdir'' => ''D:/wwwroot/panfeng/wwwroot/bbs/./attachments'',\n  ''attachurl'' => ''attachments'',\n  ''onlinehold'' => 900,\n  ''msgforward'' => ''a:3:{s:11:"refreshtime";i:3;s:5:"quick";i:1;s:8:"messages";a:13:{i:0;s:19:"thread_poll_succeed";i:1;s:19:"thread_rate_succeed";i:2;s:23:"usergroups_join_succeed";i:3;s:23:"usergroups_exit_succeed";i:4;s:25:"usergroups_update_succeed";i:5;s:20:"buddy_update_succeed";i:6;s:17:"post_edit_succeed";i:7;s:18:"post_reply_succeed";i:8;s:24:"post_edit_delete_succeed";i:9;s:22:"post_newthread_succeed";i:10;s:13:"admin_succeed";i:11;s:17:"pm_delete_succeed";i:12;s:15:"search_redirect";}}'',\n  ''smthumb'' => ''20'',\n  ''tagstatus'' => ''1'',\n  ''hottags'' => ''20'',\n  ''viewthreadtags'' => ''100'',\n  ''rewritecompatible'' => '''',\n  ''imagelib'' => ''0'',\n  ''regname'' => ''register.php'',\n  ''reglinkname'' => ''注册'',\n  ''activitytype'' => ''朋友聚会\r\n出外郊游\r\n自驾出行\r\n公益活动\r\n线上活动'',\n  ''userdateformat'' => \n  array (\n    0 => ''Y-n-j'',\n    1 => ''Y/n/j'',\n    2 => ''j-n-Y'',\n    3 => ''j/n/Y'',\n  ),\n  ''tradetypes'' => \n  array (\n  ),\n  ''tradeimagewidth'' => ''200'',\n  ''tradeimageheight'' => ''150'',\n  ''ec_credit'' => \n  array (\n    ''maxcreditspermonth'' => 6,\n    ''rank'' => \n    array (\n      1 => 4,\n      2 => 11,\n      3 => 41,\n      4 => 91,\n      5 => 151,\n      6 => 251,\n      7 => 501,\n      8 => 1001,\n      9 => 2001,\n      10 => 5001,\n      11 => 10001,\n      12 => 20001,\n      13 => 50001,\n      14 => 100001,\n      15 => 200001,\n    ),\n  ),\n  ''mail'' => ''a:10:{s:8:"mailsend";s:1:"1";s:6:"server";s:13:"smtp.21cn.com";s:4:"port";s:2:"25";s:4:"auth";s:1:"1";s:4:"from";s:26:"Discuz <username@21cn.com>";s:13:"auth_username";s:17:"username@21cn.com";s:13:"auth_password";s:8:"password";s:13:"maildelimiter";s:1:"0";s:12:"mailusername";s:1:"1";s:15:"sendmail_silent";s:1:"1";}'',\n  ''watermarktext'' => \n  array (\n  ),\n  ''watermarkminwidth'' => ''0'',\n  ''watermarkminheight'' => ''0'',\n  ''historyposts'' => ''0	0'',\n  ''zoomstatus'' => ''1'',\n  ''maxbiotradesize'' => ''400'',\n  ''insenz'' => \n  array (\n  ),\n  ''google'' => 0,\n  ''baidusitemap'' => ''1'',\n  ''baidusitemap_life'' => ''12'',\n  ''version'' => ''6.0.0'',\n  ''totalmembers'' => ''12'',\n  ''lastmember'' => ''wise'',\n  ''cachethreadon'' => 0,\n  ''cronnextrun'' => ''1326470400'',\n  ''jsmenu'' => \n  array (\n    1 => true,\n    2 => true,\n    3 => true,\n    4 => true,\n  ),\n  ''stylejumpstatus'' => ''1'',\n  ''globaladvs'' => \n  array (\n  ),\n  ''redirectadvs'' => \n  array (\n  ),\n  ''invitecredit'' => '''',\n  ''vsiteurl'' => '''',\n  ''vkey'' => '''',\n  ''vpassword'' => '''',\n  ''vsiteid'' => '''',\n  ''videotype'' => \n  array (\n    0 => ''新闻	军事	音乐	影视	动漫'',\n  ),\n  ''videoopen'' => 0,\n  ''exchangestatus'' => false,\n  ''transferstatus'' => true,\n  ''supe'' => \n  array (\n    ''status'' => 0,\n  ),\n  ''pluginlinks'' => \n  array (\n  ),\n  ''plugins'' => \n  array (\n  ),\n  ''hooks'' => \n  array (\n  ),\n);\n\n'),
('forums', 1, 1326429968, 0, '$_DCACHE[''forums''] = array (\n  3 => \n  array (\n    ''fid'' => ''3'',\n    ''type'' => ''group'',\n    ''name'' => ''综合区'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  29 => \n  array (\n    ''fid'' => ''29'',\n    ''type'' => ''forum'',\n    ''name'' => ''休闲生活'',\n    ''fup'' => ''3'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  30 => \n  array (\n    ''fid'' => ''30'',\n    ''type'' => ''forum'',\n    ''name'' => ''热点关注'',\n    ''fup'' => ''3'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  4 => \n  array (\n    ''fid'' => ''4'',\n    ''type'' => ''forum'',\n    ''name'' => ''宝宝养育'',\n    ''fup'' => ''3'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  13 => \n  array (\n    ''fid'' => ''13'',\n    ''type'' => ''sub'',\n    ''name'' => ''前期教育'',\n    ''fup'' => ''4'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  12 => \n  array (\n    ''fid'' => ''12'',\n    ''type'' => ''sub'',\n    ''name'' => ''智力开发'',\n    ''fup'' => ''4'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  15 => \n  array (\n    ''fid'' => ''15'',\n    ''type'' => ''forum'',\n    ''name'' => ''孕产健康'',\n    ''fup'' => ''3'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  8 => \n  array (\n    ''fid'' => ''8'',\n    ''type'' => ''group'',\n    ''name'' => ''孕产区'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  11 => \n  array (\n    ''fid'' => ''11'',\n    ''type'' => ''forum'',\n    ''name'' => ''备孕期'',\n    ''fup'' => ''8'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  10 => \n  array (\n    ''fid'' => ''10'',\n    ''type'' => ''forum'',\n    ''name'' => ''孕期'',\n    ''fup'' => ''8'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  9 => \n  array (\n    ''fid'' => ''9'',\n    ''type'' => ''forum'',\n    ''name'' => ''分娩期'',\n    ''fup'' => ''8'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  17 => \n  array (\n    ''fid'' => ''17'',\n    ''type'' => ''forum'',\n    ''name'' => ''月子期'',\n    ''fup'' => ''8'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  5 => \n  array (\n    ''fid'' => ''5'',\n    ''type'' => ''group'',\n    ''name'' => ''育儿区'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  28 => \n  array (\n    ''fid'' => ''28'',\n    ''type'' => ''forum'',\n    ''name'' => ''早期教育'',\n    ''fup'' => ''5'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  16 => \n  array (\n    ''fid'' => ''16'',\n    ''type'' => ''forum'',\n    ''name'' => ''育儿总坛'',\n    ''fup'' => ''5'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  6 => \n  array (\n    ''fid'' => ''6'',\n    ''type'' => ''forum'',\n    ''name'' => ''宝宝起名'',\n    ''fup'' => ''5'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  27 => \n  array (\n    ''fid'' => ''27'',\n    ''type'' => ''forum'',\n    ''name'' => ''成长日志'',\n    ''fup'' => ''5'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  14 => \n  array (\n    ''fid'' => ''14'',\n    ''type'' => ''group'',\n    ''name'' => ''护理区'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  34 => \n  array (\n    ''fid'' => ''34'',\n    ''type'' => ''forum'',\n    ''name'' => ''护理'',\n    ''fup'' => ''14'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  35 => \n  array (\n    ''fid'' => ''35'',\n    ''type'' => ''forum'',\n    ''name'' => ''保健'',\n    ''fup'' => ''14'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  26 => \n  array (\n    ''fid'' => ''26'',\n    ''type'' => ''forum'',\n    ''name'' => ''坐月子'',\n    ''fup'' => ''14'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  20 => \n  array (\n    ''fid'' => ''20'',\n    ''type'' => ''group'',\n    ''name'' => ''营养区'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  31 => \n  array (\n    ''fid'' => ''31'',\n    ''type'' => ''forum'',\n    ''name'' => ''母乳喂养'',\n    ''fup'' => ''20'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  32 => \n  array (\n    ''fid'' => ''32'',\n    ''type'' => ''forum'',\n    ''name'' => ''食谱大全'',\n    ''fup'' => ''20'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  33 => \n  array (\n    ''fid'' => ''33'',\n    ''type'' => ''forum'',\n    ''name'' => ''均衡营养'',\n    ''fup'' => ''20'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  21 => \n  array (\n    ''fid'' => ''21'',\n    ''type'' => ''group'',\n    ''name'' => ''心灵交流'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  24 => \n  array (\n    ''fid'' => ''24'',\n    ''type'' => ''forum'',\n    ''name'' => ''孕妈交流'',\n    ''fup'' => ''21'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  25 => \n  array (\n    ''fid'' => ''25'',\n    ''type'' => ''forum'',\n    ''name'' => ''想要宝宝'',\n    ''fup'' => ''21'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  22 => \n  array (\n    ''fid'' => ''22'',\n    ''type'' => ''group'',\n    ''name'' => ''塑身恢复'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  38 => \n  array (\n    ''fid'' => ''38'',\n    ''type'' => ''forum'',\n    ''name'' => ''产后食谱'',\n    ''fup'' => ''22'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  39 => \n  array (\n    ''fid'' => ''39'',\n    ''type'' => ''forum'',\n    ''name'' => ''产后瑜伽'',\n    ''fup'' => ''22'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  23 => \n  array (\n    ''fid'' => ''23'',\n    ''type'' => ''group'',\n    ''name'' => ''技艺沙龙'',\n    ''fup'' => ''0'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  36 => \n  array (\n    ''fid'' => ''36'',\n    ''type'' => ''forum'',\n    ''name'' => ''活动'',\n    ''fup'' => ''23'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n  37 => \n  array (\n    ''fid'' => ''37'',\n    ''type'' => ''forum'',\n    ''name'' => ''公告'',\n    ''fup'' => ''23'',\n    ''viewperm'' => '''',\n    ''orderby'' => ''lastpost'',\n    ''ascdesc'' => ''DESC'',\n  ),\n);\n\n'),
('icons', 1, 1326429968, 0, '$_DCACHE[''icons''] = array (\n  19 => ''icon1.gif'',\n  20 => ''icon2.gif'',\n  21 => ''icon3.gif'',\n  22 => ''icon4.gif'',\n  23 => ''icon5.gif'',\n  24 => ''icon6.gif'',\n  25 => ''icon7.gif'',\n  26 => ''icon8.gif'',\n  27 => ''icon9.gif'',\n);\n\n'),
('ranks', 1, 1326429968, 0, '$_DCACHE[''ranks''] = array (\n);\n\n'),
('usergroups', 1, 1326429968, 0, '$_DCACHE[''usergroups''] = array (\n  1 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''管理员'',\n    ''stars'' => ''9'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''200'',\n    ''allowavatar'' => ''3'',\n    ''allowcusbbcode'' => ''1'',\n    ''allowuseblog'' => ''1'',\n    ''userstatusby'' => 1,\n  ),\n  9 => \n  array (\n    ''type'' => ''member'',\n    ''grouptitle'' => ''乞丐'',\n    ''creditshigher'' => ''-9999999'',\n    ''creditslower'' => ''0'',\n    ''stars'' => ''0'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''0'',\n    ''allowavatar'' => ''0'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  8 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''等待验证会员'',\n    ''stars'' => ''0'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''0'',\n    ''allowavatar'' => ''0'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  7 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''游客'',\n    ''stars'' => ''0'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''1'',\n    ''allowavatar'' => ''0'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  6 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''禁止 IP'',\n    ''stars'' => ''0'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''0'',\n    ''allowavatar'' => ''0'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  5 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''禁止访问'',\n    ''stars'' => ''0'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''0'',\n    ''allowavatar'' => ''0'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  4 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''禁止发言'',\n    ''stars'' => ''0'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''0'',\n    ''allowavatar'' => ''0'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  3 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''版主'',\n    ''stars'' => ''7'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''100'',\n    ''allowavatar'' => ''3'',\n    ''allowcusbbcode'' => ''1'',\n    ''allowuseblog'' => ''1'',\n    ''userstatusby'' => 1,\n  ),\n  2 => \n  array (\n    ''type'' => ''system'',\n    ''grouptitle'' => ''超级版主'',\n    ''stars'' => ''8'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''150'',\n    ''allowavatar'' => ''3'',\n    ''allowcusbbcode'' => ''1'',\n    ''allowuseblog'' => ''1'',\n    ''userstatusby'' => 1,\n  ),\n  10 => \n  array (\n    ''type'' => ''member'',\n    ''grouptitle'' => ''新手上路'',\n    ''creditshigher'' => ''0'',\n    ''creditslower'' => ''50'',\n    ''stars'' => ''1'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''10'',\n    ''allowavatar'' => ''0'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  11 => \n  array (\n    ''type'' => ''member'',\n    ''grouptitle'' => ''注册会员'',\n    ''creditshigher'' => ''50'',\n    ''creditslower'' => ''200'',\n    ''stars'' => ''2'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''20'',\n    ''allowavatar'' => ''1'',\n    ''allowcusbbcode'' => ''0'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  12 => \n  array (\n    ''type'' => ''member'',\n    ''grouptitle'' => ''中级会员'',\n    ''creditshigher'' => ''200'',\n    ''creditslower'' => ''500'',\n    ''stars'' => ''3'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''30'',\n    ''allowavatar'' => ''2'',\n    ''allowcusbbcode'' => ''1'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  13 => \n  array (\n    ''type'' => ''member'',\n    ''grouptitle'' => ''高级会员'',\n    ''creditshigher'' => ''500'',\n    ''creditslower'' => ''1000'',\n    ''stars'' => ''4'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''50'',\n    ''allowavatar'' => ''3'',\n    ''allowcusbbcode'' => ''1'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  14 => \n  array (\n    ''type'' => ''member'',\n    ''grouptitle'' => ''金牌会员'',\n    ''creditshigher'' => ''1000'',\n    ''creditslower'' => ''3000'',\n    ''stars'' => ''6'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''70'',\n    ''allowavatar'' => ''3'',\n    ''allowcusbbcode'' => ''1'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n  15 => \n  array (\n    ''type'' => ''member'',\n    ''grouptitle'' => ''论坛元老'',\n    ''creditshigher'' => ''3000'',\n    ''creditslower'' => ''9999999'',\n    ''stars'' => ''8'',\n    ''groupavatar'' => '''',\n    ''readaccess'' => ''90'',\n    ''allowavatar'' => ''3'',\n    ''allowcusbbcode'' => ''1'',\n    ''allowuseblog'' => ''0'',\n    ''userstatusby'' => 1,\n  ),\n);\n\n'),
('jswizard', 1, 1326429968, 0, '$_DCACHE[''jswizard''] = array (\n);\n\n'),
('medals', 1, 1326429968, 0, '$_DCACHE[''medals''] = array (\n);\n\n'),
('magics', 1, 1326429968, 0, '$_DCACHE[''magics''] = array (\n  1 => \n  array (\n    ''identifier'' => ''CCK'',\n    ''available'' => ''1'',\n    ''name'' => ''变色卡'',\n    ''description'' => ''可以变换主题的颜色,并保存24小时'',\n    ''weight'' => ''20'',\n    ''price'' => ''10'',\n  ),\n  2 => \n  array (\n    ''identifier'' => ''MOK'',\n    ''available'' => ''1'',\n    ''name'' => ''金钱卡'',\n    ''description'' => ''可以随机获得一些金币'',\n    ''weight'' => ''30'',\n    ''price'' => ''10'',\n  ),\n  3 => \n  array (\n    ''identifier'' => ''SEK'',\n    ''available'' => ''1'',\n    ''name'' => ''IP卡'',\n    ''description'' => ''可以查看帖子作者的IP'',\n    ''weight'' => ''30'',\n    ''price'' => ''15'',\n  ),\n  4 => \n  array (\n    ''identifier'' => ''UPK'',\n    ''available'' => ''1'',\n    ''name'' => ''提升卡'',\n    ''description'' => ''可以提升某个主题'',\n    ''weight'' => ''30'',\n    ''price'' => ''10'',\n  ),\n  5 => \n  array (\n    ''identifier'' => ''TOK'',\n    ''available'' => ''1'',\n    ''name'' => ''置顶卡'',\n    ''description'' => ''可以将主题置顶24小时'',\n    ''weight'' => ''40'',\n    ''price'' => ''20'',\n  ),\n  6 => \n  array (\n    ''identifier'' => ''REK'',\n    ''available'' => ''1'',\n    ''name'' => ''悔悟卡'',\n    ''description'' => ''可以删除自己的帖子'',\n    ''weight'' => ''30'',\n    ''price'' => ''10'',\n  ),\n  7 => \n  array (\n    ''identifier'' => ''RTK'',\n    ''available'' => ''1'',\n    ''name'' => ''狗仔卡'',\n    ''description'' => ''查看某个用户是否在线'',\n    ''weight'' => ''30'',\n    ''price'' => ''15'',\n  ),\n  8 => \n  array (\n    ''identifier'' => ''CLK'',\n    ''available'' => ''1'',\n    ''name'' => ''沉默卡'',\n    ''description'' => ''24小时内不能回复'',\n    ''weight'' => ''30'',\n    ''price'' => ''15'',\n  ),\n  9 => \n  array (\n    ''identifier'' => ''OPK'',\n    ''available'' => ''1'',\n    ''name'' => ''喧嚣卡'',\n    ''description'' => ''使贴子可以回复'',\n    ''weight'' => ''30'',\n    ''price'' => ''15'',\n  ),\n  10 => \n  array (\n    ''identifier'' => ''YSK'',\n    ''available'' => ''1'',\n    ''name'' => ''隐身卡'',\n    ''description'' => ''可以将自己的帖子匿名'',\n    ''weight'' => ''30'',\n    ''price'' => ''20'',\n  ),\n  11 => \n  array (\n    ''identifier'' => ''CBK'',\n    ''available'' => ''1'',\n    ''name'' => ''恢复卡'',\n    ''description'' => ''将匿名恢复为正常显示的用户名,匿名终结者'',\n    ''weight'' => ''20'',\n    ''price'' => ''15'',\n  ),\n  12 => \n  array (\n    ''identifier'' => ''MVK'',\n    ''available'' => ''1'',\n    ''name'' => ''移动卡'',\n    ''description'' => ''可将自已的帖子移动到其他版面（隐含、特殊限定版面除外）'',\n    ''weight'' => ''50'',\n    ''price'' => ''50'',\n  ),\n);\n\n'),
('modreasons', 1, 1326429968, 0, '$_DCACHE[''modreasons''] = array (\n  0 => ''广告/SPAM'',\n  1 => ''恶意灌水'',\n  2 => ''违规内容'',\n  3 => ''文不对题'',\n  4 => ''重复发帖'',\n  5 => '''',\n  6 => ''我很赞同'',\n  7 => ''精品文章'',\n  8 => ''原创内容'',\n);\n\n'),
('advs_archiver', 1, 1326429968, 0, '$_DCACHE[''advs''] = array (\n);\n\n'),
('advs_register', 1, 1326429968, 0, '$_DCACHE[''advs''] = array (\n);\n\n'),
('faqs', 1, 1326429968, 0, '$_DCACHE[''faqs''] = array (\n  ''login'' => \n  array (\n    ''id'' => ''3'',\n    ''keyword'' => ''登录帮助'',\n  ),\n  ''discuzcode'' => \n  array (\n    ''id'' => ''18'',\n    ''keyword'' => ''Discuz!代码'',\n  ),\n  ''smilies'' => \n  array (\n    ''id'' => ''32'',\n    ''keyword'' => ''表情'',\n  ),\n);\n\n'),
('secqaa', 1, 1331599076, 0, '$_DCACHE[''secqaa''] = array (\n  0 => NULL,\n  1 => NULL,\n  2 => NULL,\n  3 => NULL,\n  4 => NULL,\n  5 => NULL,\n  6 => NULL,\n  7 => NULL,\n  8 => NULL,\n  9 => NULL,\n);\n\n'),
('supe_updatecircles', 1, 1326429968, 0, '$_DCACHE[''supe_updatecircles''] = array (\n);\n\n'),
('censor', 1, 1326429968, 0, '$_DCACHE[''censor''] = array (\n  ''filter'' => \n  array (\n  ),\n  ''banned'' => '''',\n  ''mod'' => '''',\n);\n\n'),
('ipbanned', 1, 1326429968, 0, '$_DCACHE[''ipbanned''] = array (\n);\n\n'),
('google', 1, 1326429968, 0, '$_DCACHE[''google''] = '''';\n\n'),
('announcements', 1, 1326429968, 0, '$_DCACHE[''announcements''] = array (\n);\n\n'),
('onlinelist', 1, 1326429968, 0, '$_DCACHE[''onlinelist''] = array (\n  ''legend'' => ''<img src="images/common/online_admin.gif" alt="" /> 管理员 &nbsp; &nbsp; &nbsp; <img src="images/common/online_supermod.gif" alt="" /> 超级版主 &nbsp; &nbsp; &nbsp; <img src="images/common/online_moderator.gif" alt="" /> 版主 &nbsp; &nbsp; &nbsp; <img src="images/common/online_member.gif" alt="" /> 会员 &nbsp; &nbsp; &nbsp; '',\n  1 => ''online_admin.gif'',\n  2 => ''online_supermod.gif'',\n  3 => ''online_moderator.gif'',\n  0 => ''online_member.gif'',\n);\n\n'),
('forumlinks', 1, 1326429968, 0, '$_DCACHE[''forumlinks''] = array (\n);\n\n'),
('advs_index', 1, 1326429968, 0, '$_DCACHE[''advs''] = array (\n);\n\n'),
('supe_updateusers', 1, 1326429968, 0, '$_DCACHE[''supe_updateusers''] = array (\n);\n\n'),
('supe_updateitems', 1, 1326429968, 0, '$_DCACHE[''supe_updateitems''] = array (\n);\n\n'),
('tags_index', 1, 1331580080, 0, '$_DCACHE[''tags''] = '''';\n\n'),
('announcements_forum', 1, 1326429968, 0, '$_DCACHE[''announcements_forum''] = array (\n);\n\n'),
('pmlist', 1, 1326429968, 0, '$_DCACHE[''pmlist''] = array (\n);\n\n'),
('globalstick', 1, 1326429968, 0, '$_DCACHE[''globalstick''] = array (\n  ''global'' => \n  array (\n    ''tids'' => 0,\n    ''count'' => 0,\n  ),\n);\n\n'),
('floatthreads', 1, 1326429968, 0, '$_DCACHE[''floatthreads''] = array (\n);\n\n'),
('advs_forumdisplay', 1, 1326429968, 0, '$_DCACHE[''advs''] = array (\n);\n\n'),
('bbcodes', 1, 1326429968, 0, '$_DCACHE[''bbcodes''] = array (\n  ''searcharray'' => \n  array (\n    0 => ''/\\\\[qq]([^"]+?)\\\\[\\\\/qq\\\\]/is'',\n  ),\n  ''replacearray'' => \n  array (\n    0 => ''<a href="http://wpa.qq.com/msgrd?V=1&Uin=\\\\1&amp;Site=[Discuz!]&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:\\\\1:1" border="0"></a>'',\n  ),\n);\n\n'),
('smilies', 1, 1326429968, 0, '$_DCACHE[''smilies''] = array (\n  ''searcharray'' => \n  array (\n    28 => ''/\\\\:loveliness\\\\:/'',\n    17 => ''/\\\\:handshake/'',\n    14 => ''/\\\\:victory\\\\:/'',\n    29 => ''/\\\\:funk\\\\:/'',\n    15 => ''/\\\\:time\\\\:/'',\n    16 => ''/\\\\:kiss\\\\:/'',\n    18 => ''/\\\\:call\\\\:/'',\n    13 => ''/\\\\:hug\\\\:/'',\n    12 => ''/\\\\:lol/'',\n    4 => ''/\\\\:\\''\\\\(/'',\n    11 => ''/\\\\:Q/'',\n    10 => ''/\\\\:L/'',\n    9 => ''/;P/'',\n    8 => ''/\\\\:\\\\$/'',\n    7 => ''/\\\\:P/'',\n    6 => ''/\\\\:o/'',\n    5 => ''/\\\\:@/'',\n    3 => ''/\\\\:D/'',\n    2 => ''/\\\\:\\\\(/'',\n    1 => ''/\\\\:\\\\)/'',\n  ),\n  ''replacearray'' => \n  array (\n    28 => ''loveliness.gif'',\n    17 => ''handshake.gif'',\n    14 => ''victory.gif'',\n    29 => ''funk.gif'',\n    15 => ''time.gif'',\n    16 => ''kiss.gif'',\n    18 => ''call.gif'',\n    13 => ''hug.gif'',\n    12 => ''lol.gif'',\n    4 => ''cry.gif'',\n    11 => ''mad.gif'',\n    10 => ''sweat.gif'',\n    9 => ''titter.gif'',\n    8 => ''shy.gif'',\n    7 => ''tongue.gif'',\n    6 => ''shocked.gif'',\n    5 => ''huffy.gif'',\n    3 => ''biggrin.gif'',\n    2 => ''sad.gif'',\n    1 => ''smile.gif'',\n  ),\n  ''typearray'' => \n  array (\n    28 => ''1'',\n    17 => ''1'',\n    14 => ''1'',\n    29 => ''1'',\n    15 => ''1'',\n    16 => ''1'',\n    18 => ''1'',\n    13 => ''1'',\n    12 => ''1'',\n    4 => ''1'',\n    11 => ''1'',\n    10 => ''1'',\n    9 => ''1'',\n    8 => ''1'',\n    7 => ''1'',\n    6 => ''1'',\n    5 => ''1'',\n    3 => ''1'',\n    2 => ''1'',\n    1 => ''1'',\n  ),\n);\n\n'),
('smileytypes', 1, 1326429968, 0, '$_DCACHE[''smileytypes''] = array (\n  1 => \n  array (\n    ''name'' => ''默认表情'',\n    ''directory'' => ''default'',\n  ),\n);\n\n'),
('advs_viewthread', 1, 1326429968, 0, '$_DCACHE[''advs''] = array (\n);\n\n'),
('tags_viewthread', 1, 1331580080, 0, '$_DCACHE[''tags''] = array (\n  1 => ''[\\''\\'']'',\n  0 => ''[\\''\\'']'',\n);\n\n'),
('custominfo', 1, 1326429968, 0, '$_DCACHE[''custominfo''] = array (\n  ''customauthorinfo'' => \n  array (\n    2 => ''<dt>UID</dt><dd>$post[uid]&nbsp;</dd><dt>帖子</dt><dd>$post[posts]&nbsp;</dd><dt>精华</dt><dd><a href=\\\\"digest.php?authorid=$post[authorid]\\\\">$post[digestposts]</a>&nbsp;</dd><dt>积分</dt><dd>$post[credits]&nbsp;</dd><dt>阅读权限</dt><dd>$post[readaccess]&nbsp;</dd>".($post[location] ? "<dt>来自</dt><dd>$post[location]&nbsp;</dd>" : "")."<dt>在线时间</dt><dd>$post[oltime] 小时&nbsp;</dd><dt>注册时间</dt><dd>$post[regdate]&nbsp;</dd><dt>最后登录</dt><dd>$post[lastdate]&nbsp;</dd>'',\n    1 => NULL,\n    3 => NULL,\n  ),\n  ''fieldsadd'' => '''',\n  ''profilefields'' => \n  array (\n  ),\n  ''postno'' => \n  array (\n    0 => ''<sup>#</sup>'',\n    1 => '''',\n  ),\n);\n\n'),
('bbcodes_display', 1, 1326429968, 0, '$_DCACHE[''bbcodes_display''] = array (\n  ''qq'' => \n  array (\n    ''icon'' => ''bb_qq.gif'',\n    ''explanation'' => ''显示 QQ 在线状态，点这个图标可以和他（她）聊天'',\n    ''params'' => ''1'',\n    ''prompt'' => ''请输入显示在线状态 QQ 号码:'',\n  ),\n);\n\n'),
('smilies_display', 1, 1326429968, 0, '$_DCACHE[''smilies_display''] = array (\n  1 => \n  array (\n    1 => \n    array (\n      ''code'' => '':)'',\n      ''url'' => ''smile.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    12 => \n    array (\n      ''code'' => '':lol'',\n      ''url'' => ''lol.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    13 => \n    array (\n      ''code'' => '':hug:'',\n      ''url'' => ''hug.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    14 => \n    array (\n      ''code'' => '':victory:'',\n      ''url'' => ''victory.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    15 => \n    array (\n      ''code'' => '':time:'',\n      ''url'' => ''time.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    16 => \n    array (\n      ''code'' => '':kiss:'',\n      ''url'' => ''kiss.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    17 => \n    array (\n      ''code'' => '':handshake'',\n      ''url'' => ''handshake.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    18 => \n    array (\n      ''code'' => '':call:'',\n      ''url'' => ''call.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    28 => \n    array (\n      ''code'' => '':loveliness:'',\n      ''url'' => ''loveliness.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    11 => \n    array (\n      ''code'' => '':Q'',\n      ''url'' => ''mad.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    10 => \n    array (\n      ''code'' => '':L'',\n      ''url'' => ''sweat.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    2 => \n    array (\n      ''code'' => '':('',\n      ''url'' => ''sad.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    3 => \n    array (\n      ''code'' => '':D'',\n      ''url'' => ''biggrin.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    4 => \n    array (\n      ''code'' => '':\\''('',\n      ''url'' => ''cry.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    5 => \n    array (\n      ''code'' => '':@'',\n      ''url'' => ''huffy.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    6 => \n    array (\n      ''code'' => '':o'',\n      ''url'' => ''shocked.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    7 => \n    array (\n      ''code'' => '':P'',\n      ''url'' => ''tongue.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    8 => \n    array (\n      ''code'' => '':$'',\n      ''url'' => ''shy.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    9 => \n    array (\n      ''code'' => '';P'',\n      ''url'' => ''titter.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n    29 => \n    array (\n      ''code'' => '':funk:'',\n      ''url'' => ''funk.gif'',\n      ''w'' => 20,\n      ''h'' => 20,\n      ''lw'' => 20,\n    ),\n  ),\n);\n\n'),
('fields_required', 1, 1326429968, 0, '$_DCACHE[''fields_required''] = array (\n);\n\n'),
('fields_optional', 1, 1326429968, 0, '$_DCACHE[''fields_optional''] = array (\n);\n\n');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_campaigns`
--

CREATE TABLE IF NOT EXISTS `discuz_campaigns` (
  `id` mediumint(8) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `fid` smallint(6) unsigned NOT NULL,
  `tid` mediumint(8) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `begintime` int(10) unsigned NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `expiration` int(10) unsigned NOT NULL,
  `nextrun` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`type`),
  KEY `tid` (`tid`),
  KEY `nextrun` (`nextrun`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_creditslog`
--

CREATE TABLE IF NOT EXISTS `discuz_creditslog` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fromto` char(15) NOT NULL DEFAULT '',
  `sendcredits` tinyint(1) NOT NULL DEFAULT '0',
  `receivecredits` tinyint(1) NOT NULL DEFAULT '0',
  `send` int(10) unsigned NOT NULL DEFAULT '0',
  `receive` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `operation` char(3) NOT NULL DEFAULT '',
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_crons`
--

CREATE TABLE IF NOT EXISTS `discuz_crons` (
  `cronid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('user','system') NOT NULL DEFAULT 'user',
  `name` char(50) NOT NULL DEFAULT '',
  `filename` char(50) NOT NULL DEFAULT '',
  `lastrun` int(10) unsigned NOT NULL DEFAULT '0',
  `nextrun` int(10) unsigned NOT NULL DEFAULT '0',
  `weekday` tinyint(1) NOT NULL DEFAULT '0',
  `day` tinyint(2) NOT NULL DEFAULT '0',
  `hour` tinyint(2) NOT NULL DEFAULT '0',
  `minute` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`cronid`),
  KEY `nextrun` (`available`,`nextrun`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `discuz_crons`
--

INSERT INTO `discuz_crons` (`cronid`, `available`, `type`, `name`, `filename`, `lastrun`, `nextrun`, `weekday`, `day`, `hour`, `minute`) VALUES
(1, 1, 'system', '清空今日发帖数', 'todayposts_daily.inc.php', 1331574088, 1331654400, -1, -1, 0, '0'),
(2, 1, 'system', '清空本月在线时间', 'onlinetime_monthly.inc.php', 1330706634, 1333209600, -1, 1, 0, '0'),
(3, 1, 'system', '每日数据清理', 'cleanup_daily.inc.php', 1331598659, 1331674200, -1, -1, 5, '30'),
(4, 1, 'system', '生日统计与邮件祝福', 'birthdays_daily.inc.php', 1331574652, 1331654400, -1, -1, 0, '0'),
(5, 1, 'system', '主题回复通知', 'notify_daily.inc.php', 1331597471, 1331672400, -1, -1, 5, '00'),
(6, 1, 'system', '每日公告清理', 'announcements_daily.inc.php', 1331574733, 1331654400, -1, -1, 0, '0'),
(7, 1, 'system', '限时操作清理', 'threadexpiries_hourly.inc.php', 1331598249, 1331672400, -1, -1, 5, '0'),
(8, 1, 'system', '论坛推广清理', 'promotions_hourly.inc.php', 1331576156, 1331654400, -1, -1, 0, '00'),
(9, 1, 'system', '每月主题清理', 'cleanup_monthly.inc.php', 1330724425, 1333231200, -1, 1, 6, '00'),
(10, 1, 'system', '每日 X-Space更新用户', 'supe_daily.inc.php', 1331577346, 1331654400, -1, -1, 0, '0'),
(12, 1, 'system', '道具自动补货', 'magics_daily.inc.php', 1331578938, 1331654400, -1, -1, 0, '0'),
(13, 1, 'system', '每日验证问答更新', 'secqaa_daily.inc.php', 1331599076, 1331676000, -1, -1, 6, '0'),
(14, 1, 'system', '每日标签更新', 'tags_daily.inc.php', 1331580080, 1331654400, -1, -1, 0, '0');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_debateposts`
--

CREATE TABLE IF NOT EXISTS `discuz_debateposts` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `stand` tinyint(1) NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `voters` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `voterids` text NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `pid` (`pid`,`stand`),
  KEY `tid` (`tid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_debates`
--

CREATE TABLE IF NOT EXISTS `discuz_debates` (
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `affirmdebaters` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `negadebaters` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `affirmvotes` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `negavotes` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `umpire` varchar(15) NOT NULL DEFAULT '',
  `winner` tinyint(1) NOT NULL DEFAULT '0',
  `bestdebater` varchar(50) NOT NULL DEFAULT '',
  `affirmpoint` text NOT NULL,
  `negapoint` text NOT NULL,
  `umpirepoint` text NOT NULL,
  `affirmvoterids` text NOT NULL,
  `negavoterids` text NOT NULL,
  `affirmreplies` mediumint(8) unsigned NOT NULL,
  `negareplies` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `uid` (`uid`,`starttime`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_failedlogins`
--

CREATE TABLE IF NOT EXISTS `discuz_failedlogins` (
  `ip` char(15) NOT NULL DEFAULT '',
  `count` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_faqs`
--

CREATE TABLE IF NOT EXISTS `discuz_faqs` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `fpid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `identifier` varchar(20) NOT NULL,
  `keyword` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `displayplay` (`displayorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `discuz_faqs`
--

INSERT INTO `discuz_faqs` (`id`, `fpid`, `displayorder`, `identifier`, `keyword`, `title`, `message`) VALUES
(1, 0, 1, '', '', '用户须知', ''),
(2, 1, 1, '', '', '我必须要注册吗？', '这取决于管理员如何设置 Discuz! 论坛的用户组权限选项，您甚至有可能必须在注册成正式用户后后才能浏览帖子。当然，在通常情况下，您至少应该是正式用户才能发新帖和回复已有帖子。请 <a href="register.php" target="_blank">点击这里</a> 免费注册成为我们的新用户！\r\n<br /><br />强烈建议您注册，这样会得到很多以游客身份无法实现的功能。'),
(3, 1, 2, 'login', '登录帮助', '我如何登录论坛？', '如果您已经注册成为该论坛的会员，哪么您只要通过访问页面右上的<a href="logging.php?action=login" target="_blank">登录</a>，进入登陆界面填写正确的用户名和密码（如果您设有安全提问，请选择正确的安全提问并输入对应的答案），点击“提交”即可完成登陆如果您还未注册请点击这里。<br /><br />\r\n如果需要保持登录，请选择相应的 Cookie 时间，在此时间范围内您可以不必输入密码而保持上次的登录状态。'),
(4, 1, 3, '', '', '忘记我的登录密码，怎么办？', '当您忘记了用户登录的密码，您可以通过注册时填写的电子邮箱重新设置一个新的密码。点击登录页面中的 <a href="member.php?action=lostpasswd" target="_blank">取回密码</a>，按照要求填写您的个人信息，系统将自动发送重置密码的邮件到您注册时填写的 Email 信箱中。如果您的 Email 已失效或无法收到信件，请与论坛管理员联系。'),
(5, 0, 2, '', '', '帖子相关操作', ''),
(6, 0, 3, '', '', '基本功能操作', ''),
(7, 0, 4, '', '', '其他相关问题', ''),
(8, 1, 4, '', '', '我如何使用个性化头像', '在<a href="memcp.php" target="_blank">控制面板</a>中的“编辑个人资料”，有一个“头像”的选项，可以使用论坛自带的头像或者自定义的头像。'),
(9, 1, 5, '', '', '我如何修改登录密码', '在<a href="memcp.php" target="_blank">控制面板</a>中的“编辑个人资料”，填写“原密码”，“新密码”，“确认新密码”。点击“提交”，即可修改。'),
(10, 1, 6, '', '', '我如何使用个性化签名和昵称', '在<a href="memcp.php" target="_blank">控制面板</a>中的“编辑个人资料”，有一个“昵称”和“个人签名”的选项，可以在此设置。'),
(11, 5, 1, '', '', '我如何发表新主题', '在论坛版块中，点“新帖”，如果有权限，您可以看到有“投票，悬赏，活动，交易”，点击即可进入功能齐全的发帖界面。\r\n<br /><br />注意：一般论坛都设置为高级别的用户组才能发布这四类特殊主题。如发布普通主题，直接点击“新帖”，当然您也可以使用版块下面的“快速发帖”发表新帖(如果此选项打开)。一般论坛都设置为需要登录后才能发帖。'),
(12, 5, 2, '', '', '我如何发表回复', '回复有分三种：第一、贴子最下方的快速回复； 第二、在您想回复的楼层点击右下方“回复”； 第三、完整回复页面，点击本页“新帖”旁边的“回复”。'),
(13, 5, 3, '', '', '我如何编辑自己的帖子', '在帖子的右下角，有编辑，回复，报告等选项，点击编辑，就可以对帖子进行编辑。'),
(14, 5, 4, '', '', '我如何出售购买主题', '<li>出售主题：\r\n当您进入发贴界面后，如果您所在的用户组有发买卖贴的权限，在“售价(金钱)”后面填写主题的价格，这样其他用户在查看这个帖子的时候就需要进入交费的过程才可以查看帖子。</li>\r\n<li>购买主题：\r\n浏览你准备购买的帖子，在帖子的相关信息的下面有[查看付款记录] [购买主题] [返回上一页] \r\n等链接，点击“购买主题”进行购买。</li>'),
(15, 5, 5, '', '', '我如何出售购买附件', '<li>上传附件一栏有个售价的输入框，填入出售价格即可实现需要支付才可下载附件的功能。</li>\r\n<li>点击帖子中[购买附件]按钮或点击附件的下载链接会跳转至附件购买页面，确认付款的相关信息后点提交按钮，即可得到附件的下载权限。只需购买一次，就有该附件的永远下载权限。</li>'),
(16, 5, 6, '', '', '我如何上传附件', '<li>发表新主题的时候上传附件，步骤为：写完帖子标题和内容后点上传附件右方的浏览，然后在本地选择要上传附件的具体文件名，最后点击发表话题。</li>\r\n<li>发表回复的时候上传附件，步骤为：写完回复楼主的内容，然后点上传附件右方的浏览，找到需要上传的附件，点击发表回复。</li>'),
(17, 5, 7, '', '', '我如何实现发帖时图文混排效果', '<li>发表新主题的时候点击上传附件左侧的“[插入]”链接把附件标记插入到帖子中适当的位置即可。</li>'),
(18, 5, 8, 'discuzcode', 'Discuz!代码', '我如何使用Discuz!代码', '<table width="99%" cellpadding="2" cellspacing="2">\r\n  <tr>\r\n    <th width="50%">Discuz!代码</th>\r\n    <th width="402">效果</th>\r\n  </tr>\r\n  <tr>\r\n    <td>[b]粗体文字 Abc[/b]</td>\r\n    <td><strong>粗体文字 Abc</strong></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[i]斜体文字 Abc[/i]</td>\r\n    <td><em>斜体文字 Abc</em></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[u]下划线文字 Abc[/u]</td>\r\n    <td><u>下划线文字 Abc</u></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[color=red]红颜色[/color]</td>\r\n    <td><font color="red">红颜色</font></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[size=3]文字大小为 3[/size] </td>\r\n    <td><font size="3">文字大小为 3</font></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[font=仿宋]字体为仿宋[/font] </td>\r\n    <td><font face="仿宋">字体为仿宋</font></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[align=Center]内容居中[/align] </td>\r\n    <td><div align="center">内容居中</div></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[url]http://www.comsenz.com[/url]</td>\r\n    <td><a href="http://www.comsenz.com" target="_blank">http://www.comsenz.com</a>（超级链接）</td>\r\n  </tr>\r\n  <tr>\r\n    <td>[url=http://www.Discuz.net]Discuz! 论坛[/url]</td>\r\n    <td><a href="http://www.Discuz.net" target="_blank">Discuz! 论坛</a>（超级链接）</td>\r\n  </tr>\r\n  <tr>\r\n    <td>[email]myname@mydomain.com[/email]</td>\r\n    <td><a href="mailto:myname@mydomain.com">myname@mydomain.com</a>（E-mail链接）</td>\r\n  </tr>\r\n  <tr>\r\n    <td>[email=support@discuz.net]Discuz! 技术支持[/email]</td>\r\n    <td><a href="mailto:support@discuz.net">Discuz! 技术支持（E-mail链接）</a></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[quote]Discuz! Board 是由康盛创想（北京）科技有限公司开发的论坛软件[/quote] </td>\r\n    <td><div style="font-size: 12px"><br /><br /><div class="quote"><h5>引用:</h5><blockquote>原帖由 <i>admin</i> 于 2006-12-26 08:45 发表<br />Discuz! Board 是由康盛创想（北京）科技有限公司开发的论坛软件</blockquote></div></td>\r\n  </tr>\r\n   <tr>\r\n    <td>[code]Discuz! Board 是由康盛创想（北京）科技有限公司开发的论坛软件[/code] </td>\r\n    <td><div style="font-size: 12px"><br /><br /><div class="blockcode"><h5>代码:</h5><code id="code0">Discuz! Board 是由康盛创想（北京）科技有限公司开发的论坛软件</code></div></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[hide]隐藏内容 Abc[/hide]</td>\r\n    <td>效果:只有当浏览者回复本帖时，才显示其中的内容，否则显示为“<b>**** 隐藏信息 跟帖后才能显示 *****</b>”</td>\r\n  </tr>\r\n  <tr>\r\n    <td>[hide=20]隐藏内容 Abc[/hide]</td>\r\n    <td>效果:只有当浏览者积分高于 20 点时，才显示其中的内容，否则显示为“<b>**** 隐藏信息 积分高于 20 点才能显示 ****</b>”</td>\r\n  </tr>\r\n  <tr>\r\n    <td>[list][*]列表项 #1[*]列表项 #2[*]列表项 #3[/list]</td>\r\n    <td><ul>\r\n      <li>列表项 ＃1</li>\r\n      <li>列表项 ＃2</li>\r\n      <li>列表项 ＃3 </li>\r\n    </ul></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[img]http://www.discuz.net/images/default/logo.gif[/img] </td>\r\n    <td>帖子内显示为：<img src="http://www.discuz.net/images/default/logo.gif" /></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[img=88,31]http://www.discuz.net/images/logo.gif[/img] </td>\r\n    <td>帖子内显示为：<img src="http://www.discuz.net/images/logo.gif" /></td>\r\n  </tr> <tr>\r\n    <td>[media=400,300,1]多媒体 URL[/media]</td>\r\n    <td>帖子内嵌入多媒体，宽 400 高 300 自动播放</td>\r\n  </tr>\r\n <tr>\r\n    <td>[fly]飞行的效果[/fly]</td>\r\n    <td><marquee scrollamount="3" behavior="alternate" width="90%">飞行的效果</marquee></td>\r\n  </tr>\r\n  <tr>\r\n    <td>[flash]Flash网页地址 [/flash] </td>\r\n    <td>帖子内嵌入 Flash 动画</td>\r\n  </tr>\r\n  <tr>\r\n    <td>[qq]123456789[/qq]</td>\r\n    <td>在帖子内显示 QQ 在线状态，点这个图标可以和他（她）聊天</td>\r\n  </tr>\r\n  <tr>\r\n    <td>X[sup]2[/sup]</td>\r\n    <td>X<sup>2</sup></td>\r\n  </tr>\r\n  <tr>\r\n    <td>X[sub]2[/sub]</td>\r\n    <td>X<sub>2</sub></td>\r\n  </tr>\r\n  \r\n</table>'),
(19, 6, 1, '', '', '我如何使用短消息功能', '您登录后，点击导航栏上的短消息按钮，即可进入短消息管理。\r\n点击[发送短消息]按钮，在"发送到"后输入收信人的用户名，填写完标题和内容，点提交(或按 Ctrl+Enter 发送)即可发出短消息。\r\n<br /><br />如果要保存到发件箱，以在提交前勾选"保存到发件箱中"前的复选框。\r\n<ul>\r\n<li>点击收件箱可打开您的收件箱查看收到的短消息。</li>\r\n<li>点击发件箱可查看保存在发件箱里的短消息。 </li>\r\n<li>点击已发送来查看对方是否已经阅读您的短消息。 </li>\r\n<li>点击搜索短消息就可通过关键字，发信人，收信人，搜索范围，排序类型等一系列条件设定来找到您需要查找的短消息。 </li>\r\n<li>点击导出短消息可以将自己的短消息导出htm文件保存在自己的电脑里。 </li>\r\n<li>点击忽略列表可以设定忽略人员，当这些被添加的忽略用户给您发送短消息时将不予接收。</li>\r\n</ul>'),
(20, 6, 2, '', '', '我如何向好友群发短消息', '登录论坛后，点击短消息，然后点发送短消息，如果有好友的话，好友群发后面点击全选，可以给所有的好友群发短消息。'),
(21, 6, 3, '', '', '我如何查看论坛会员数据', '点击导航栏上面的会员，然后显示的是此论坛的会员数据。注：需要论坛管理员开启允许你查看会员资料才可看到。'),
(22, 6, 4, '', '', '我如何使用搜索', '点击导航栏上面的搜索，输入搜索的关键字并选择一个范围，就可以检索到您有权限访问论坛中的相关的帖子。'),
(23, 6, 5, '', '', '我如何使用“我的”功能', '<li>会员必须首先<a href="logging.php?action=login" target="_blank">登录</a>，没有用户名的请先<a href="register.php" target="_blank">注册</a>；</li>\r\n<li>登录之后在论坛的左上方会出现一个“我的”的超级链接，点击这个链接之后就可进入到有关于您的信息。</li>'),
(24, 7, 1, '', '', '我如何向管理员报告帖子', '打开一个帖子，在帖子的右下角可以看到：“编辑”、“引用”、“报告”、“评分”、“回复”等等几个按钮，点击其中的“报告”按钮进入报告页面，填写好“我的意见”，单击“报告”按钮即可完成报告某个帖子的操作。'),
(25, 7, 2, '', '', '我如何“打印”，“推荐”，“订阅”，“收藏”帖子', '当你浏览一个帖子时，在它的右上角可以看到：“打印”、“推荐”、“订阅”、“收藏”，点击相对应的文字连接即可完成相关的操作。'),
(26, 7, 3, '', '', '我如何设置论坛好友', '设置论坛好友有3种简单的方法。\r\n<ul>\r\n<li>当您浏览帖子的时候可以点击“发表时间”右侧的“加为好友”设置论坛好友。</li>\r\n<li>当您浏览某用户的个人资料时，可以点击头像下方的“加为好友”设置论坛好友。</li>\r\n<li>您也可以在控制面板中的好友列表增加您的论坛好友。</li>\r\n<ul>'),
(27, 7, 4, '', '', '我如何使用RSS订阅', '在论坛的首页和进入版块的页面的右上角就会出现一个rss订阅的小图标<img src="images/common/xml.gif" border="0">，鼠标点击之后将出现本站点的rss地址，你可以将此rss地址放入到你的rss阅读器中进行订阅。'),
(28, 7, 5, '', '', '我如何清除Cookies', 'cookie是由浏览器保存在系统内的，在论坛的右下角提供有"清除 Cookies"的功能，点击后即可帮您清除系统内存储的Cookies。 <br /><br />\r\n以下介绍3种常用浏览器的Cookies清除方法(注：此方法为清除全部的Cookies,请谨慎使用)\r\n<ul>\r\n<li>Internet Explorer: 工具（选项）内的Internet选项→常规选项卡内，IE6直接可以看到删除Cookies的按钮点击即可，IE7为“浏 览历史记录”选项内的删除点击即可清空Cookies。对于Maxthon,腾讯TT等IE核心浏览器一样适用。 </li>\r\n<li>FireFox:工具→选项→隐私→Cookies→显示Cookie里可以对Cookie进行对应的删除操作。 </li>\r\n<li>Opera:工具→首选项→高级→Cookies→管理Cookies即可对Cookies进行删除的操作。</li>\r\n</ul>'),
(29, 7, 6, '', '', '我如何联系管理员', '您可以通过论坛底部右下角的“联系我们”链接快速的发送邮件与我们联系。也可以通过管理团队中的用户资料发送短消息给我们。'),
(30, 7, 7, '', '', '我如何开通个人空间', '如果您有权限开通“我的个人空间”，当用户登录论坛以后在论坛首页，用户名的右方点击开通我的个人空间，进入个人空间的申请页面。'),
(31, 7, 8, '', '', '我如何将自己的主题加入个人空间', '如果您有权限开通“我的个人空间”，在您发表的主题上方点击“加入个人空间”，您发表的主题以及回复都会加入到您空间的日志里。'),
(32, 5, 9, 'smilies', '表情', '我如何使用表情代码', '表情是一些用字符表示的表情符号，如果打开表情功能，Discuz! 会把一些符号转换成小图像，显示在帖子中，更加美观明了。目前支持下面这些表情：<br /><br />\r\n<table cellspacing="0" cellpadding="4" width="30%" align="center">\r\n<tr><th width="25%" align="center">表情符号</td>\r\n<th width="75%" align="center">对应图像</td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:)</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/smile.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:(</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/sad.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:D</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/biggrin.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:\\''(</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/cry.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:@</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/huffy.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:o</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/shocked.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:P</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/tongue.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:$</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/shy.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">;P</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/titter.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:L</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/sweat.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:Q</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/mad.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:lol</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/lol.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:hug:</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/hug.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:victory:</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/victory.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:time:</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/time.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:kiss:</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/kiss.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:handshake</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/handshake.gif" alt="" /></td>\r\n</tr>\r\n<tr>\r\n<td width="25%" align="center">:call:</td>\r\n<td width="75%" align="center"><img src="images/smilies/default/call.gif" alt="" /></td>\r\n</tr>\r\n</table>\r\n</div></div>\r\n<br />'),
(33, 0, 5, '', '', '论坛高级功能使用', ''),
(34, 33, 0, 'forwardmessagelist', '', '论坛快速跳转关键字列表', 'Discuz! 支持自定义快速跳转页面，当某些操作完成后，可以不显示提示信息，直接跳转到新的页面，从而方便用户进行下一步操作，避免等待。 在实际使用当中，您根据需要，把关键字添加到快速跳转设置里面(后台 -- 基本设置 --  界面与显示方式 -- [<a href="admincp.php?action=settings&do=styles&frames=yes" target="_blank">提示信息跳转设置</a> ])，让某些信息不显示而实现快速跳转。以下是 Discuz! 当中的一些常用信息的关键字:\r\n</br></br>\r\n\r\n<table width="99%" cellpadding="2" cellspacing="2">\r\n  <tr>\r\n    <td width="50%">关键字</td>\r\n    <td width="50%">提示信息页面或者作用</td>\r\n  </tr>\r\n  <tr>\r\n    <td>login_succeed</td>\r\n    <td>登录成功</td>\r\n  </tr>\r\n  <tr>\r\n    <td>logout_succeed</td>\r\n    <td>退出登录成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>thread_poll_succeed</td>\r\n    <td>投票成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>thread_rate_succeed</td>\r\n    <td>评分成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>register_succeed</td>\r\n    <td>注册成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>usergroups_join_succeed</td>\r\n    <td>加入扩展组成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td height="22">usergroups_exit_succeed</td>\r\n    <td>退出扩展组成功</td>\r\n  </tr>\r\n  <tr>\r\n    <td>usergroups_update_succeed</td>\r\n    <td>更新扩展组成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>buddy_update_succeed</td>\r\n    <td>好友更新成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>post_edit_succeed</td>\r\n    <td>编辑帖子成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>post_edit_delete_succeed</td>\r\n    <td>删除帖子成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>post_reply_succeed</td>\r\n    <td>回复成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>post_newthread_succeed</td>\r\n    <td>发表新主题成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>post_reply_blog_succeed</td>\r\n    <td>文集评论发表成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>post_newthread_blog_succeed</td>\r\n    <td>blog 发表成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>profile_avatar_succeed</td>\r\n    <td>头像设置成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>profile_succeed</td>\r\n    <td>个人资料更新成功</td>\r\n  </tr>\r\n    <tr>\r\n    <td>pm_send_succeed</td>\r\n    <td>短消息发送成功</td>\r\n  </tr>\r\n  </tr>\r\n    <tr>\r\n    <td>pm_delete_succeed</td>\r\n    <td>短消息删除成功</td>\r\n  </tr>\r\n  </tr>\r\n    <tr>\r\n    <td>pm_ignore_succeed</td>\r\n    <td>短消息忽略列表更新</td>\r\n  </tr>\r\n    <tr>\r\n    <td>admin_succeed</td>\r\n    <td>管理操作成功〔注意：设置此关键字后，所有管理操作完毕都将直接跳转〕</td>\r\n  </tr>\r\n    <tr>\r\n    <td>admin_succeed_next&nbsp;</td>\r\n    <td>管理成功并将跳转到下一个管理动作</td>\r\n  </tr> \r\n    <tr>\r\n    <td>search_redirect</td>\r\n    <td>搜索完成，进入搜索结果列表</td>\r\n  </tr>\r\n</table>');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_favorites`
--

CREATE TABLE IF NOT EXISTS `discuz_favorites` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_forumfields`
--

CREATE TABLE IF NOT EXISTS `discuz_forumfields` (
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `password` varchar(12) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `postcredits` varchar(255) NOT NULL DEFAULT '',
  `replycredits` varchar(255) NOT NULL DEFAULT '',
  `getattachcredits` varchar(255) NOT NULL DEFAULT '',
  `postattachcredits` varchar(255) NOT NULL DEFAULT '',
  `digestcredits` varchar(255) NOT NULL DEFAULT '',
  `redirect` varchar(255) NOT NULL DEFAULT '',
  `attachextensions` varchar(255) NOT NULL DEFAULT '',
  `formulaperm` text NOT NULL,
  `moderators` text NOT NULL,
  `rules` text NOT NULL,
  `threadtypes` text NOT NULL,
  `viewperm` text NOT NULL,
  `postperm` text NOT NULL,
  `replyperm` text NOT NULL,
  `getattachperm` text NOT NULL,
  `postattachperm` text NOT NULL,
  `keywords` text NOT NULL,
  `supe_pushsetting` text NOT NULL,
  `modrecommend` text NOT NULL,
  `tradetypes` text NOT NULL,
  `typemodels` mediumtext NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_forumfields`
--

INSERT INTO `discuz_forumfields` (`fid`, `description`, `password`, `icon`, `postcredits`, `replycredits`, `getattachcredits`, `postattachcredits`, `digestcredits`, `redirect`, `attachextensions`, `formulaperm`, `moderators`, `rules`, `threadtypes`, `viewperm`, `postperm`, `replyperm`, `getattachperm`, `postattachperm`, `keywords`, `supe_pushsetting`, `modrecommend`, `tradetypes`, `typemodels`) VALUES
(3, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, '养一个天才宝宝哦、、、', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(5, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, '为宝宝起个好名字哦', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(8, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, '', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(10, '', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(11, '备孕期备孕期', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(12, '2010年1月26日，飞鹤“全程护航”母婴健康营养研究中心启动仪式在京举行。', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(13, '', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(14, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, '', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(16, '', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(17, '坐月子坐月子了', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(25, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(24, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(20, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(21, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(22, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(23, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(26, '', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(27, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(28, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(29, '一向为亲子服代表的美国品牌Ralph Lauren Childrenswear；代理Dior，Cholé等童服的BAROCCO；日系童装潮服COMME CA KIDS等，让一众高品位父母为子女打造高贵典雅形象。', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(30, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(31, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(32, '好吃点，多吃点，吃好点', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(33, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(34, '护理保健', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(35, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(36, '这里有好的活动额', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(37, '这是公告、', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', ''),
(38, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(39, '做运动、做运动啦', '', '', '', '', '', '', '', '', '', 'a:2:{i:0;s:0:"";i:1;s:0:"";}', '', '', '', '', '', '', '', '', '', '', 'a:5:{s:4:"open";s:1:"0";s:3:"num";i:10;s:9:"maxlength";i:0;s:9:"cachelife";i:900;s:8:"dateline";i:0;}', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_forumlinks`
--

CREATE TABLE IF NOT EXISTS `discuz_forumlinks` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `logo` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `discuz_forumlinks`
--

INSERT INTO `discuz_forumlinks` (`id`, `displayorder`, `name`, `url`, `description`, `logo`) VALUES
(1, 0, 'Discuz! 官方论坛', 'http://www.discuz.com', '提供最新 Discuz! 产品新闻、软件下载与技术交流', 'images/logo.gif');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_forumrecommend`
--

CREATE TABLE IF NOT EXISTS `discuz_forumrecommend` (
  `fid` smallint(6) unsigned NOT NULL,
  `tid` mediumint(8) unsigned NOT NULL,
  `displayorder` tinyint(1) NOT NULL,
  `subject` char(80) NOT NULL,
  `author` char(15) NOT NULL,
  `authorid` mediumint(8) NOT NULL,
  `moderatorid` mediumint(8) NOT NULL,
  `expiration` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `displayorder` (`fid`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_forums`
--

CREATE TABLE IF NOT EXISTS `discuz_forums` (
  `fid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `fup` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type` enum('group','forum','sub') NOT NULL DEFAULT 'forum',
  `name` char(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `styleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `threads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `todayposts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lastpost` char(110) NOT NULL DEFAULT '',
  `allowsmilies` tinyint(1) NOT NULL DEFAULT '0',
  `allowhtml` tinyint(1) NOT NULL DEFAULT '0',
  `allowbbcode` tinyint(1) NOT NULL DEFAULT '0',
  `allowimgcode` tinyint(1) NOT NULL DEFAULT '0',
  `allowmediacode` tinyint(1) NOT NULL DEFAULT '0',
  `allowanonymous` tinyint(1) NOT NULL DEFAULT '0',
  `allowshare` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostspecial` smallint(6) unsigned NOT NULL DEFAULT '0',
  `allowspecialonly` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `alloweditrules` tinyint(1) NOT NULL DEFAULT '0',
  `recyclebin` tinyint(1) NOT NULL DEFAULT '0',
  `modnewposts` tinyint(1) NOT NULL DEFAULT '0',
  `jammer` tinyint(1) NOT NULL DEFAULT '0',
  `disablewatermark` tinyint(1) NOT NULL DEFAULT '0',
  `inheritedmod` tinyint(1) NOT NULL DEFAULT '0',
  `autoclose` smallint(6) NOT NULL DEFAULT '0',
  `forumcolumns` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `threadcaches` tinyint(1) NOT NULL DEFAULT '0',
  `allowpaytoauthor` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `alloweditpost` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `simple` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`fid`),
  KEY `forum` (`status`,`type`,`displayorder`),
  KEY `fup` (`fup`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=40 ;

--
-- 转存表中的数据 `discuz_forums`
--

INSERT INTO `discuz_forums` (`fid`, `fup`, `type`, `name`, `status`, `displayorder`, `styleid`, `threads`, `posts`, `todayposts`, `lastpost`, `allowsmilies`, `allowhtml`, `allowbbcode`, `allowimgcode`, `allowmediacode`, `allowanonymous`, `allowshare`, `allowpostspecial`, `allowspecialonly`, `alloweditrules`, `recyclebin`, `modnewposts`, `jammer`, `disablewatermark`, `inheritedmod`, `autoclose`, `forumcolumns`, `threadcaches`, `allowpaytoauthor`, `alloweditpost`, `simple`) VALUES
(3, 0, 'group', '综合区', 1, 1, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(4, 3, 'forum', '宝宝养育', 1, 0, 0, 1, 1, 0, '15	支持	1326459258	wismartzy', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(5, 0, 'group', '育儿区', 1, 3, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(6, 5, 'forum', '宝宝起名', 1, 1, 0, 1, 1, 0, '13	女儿起名字	1326442597	xifeng666', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(8, 0, 'group', '孕产区', 1, 2, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(9, 8, 'forum', '分娩期', 1, 2, 0, 1, 2, 0, '10	剖腹产好还是顺产好呢？？？	1326437454	wismartzy', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(10, 8, 'forum', '孕期', 1, 1, 0, 1, 1, 0, '2	孕妈妈常见疾病如何预防	1326435649	wismartzy', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(11, 8, 'forum', '备孕期', 1, 0, 0, 1, 2, 0, '3	手机放哪儿才不会影响生育	1329061864	009', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(12, 4, 'sub', '智力开发', 1, 0, 0, 0, 0, 0, '			', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(13, 4, 'sub', '前期教育', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(14, 0, 'group', '护理区', 1, 4, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(15, 3, 'forum', '孕产健康', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(16, 5, 'forum', '育儿总坛', 1, 0, 0, 1, 1, 0, '6	有助于宝宝增高食物你知道吗？	1326436580	wismartzy', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(17, 8, 'forum', '月子期', 1, 3, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(25, 21, 'forum', '想要宝宝', 1, 1, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(24, 21, 'forum', '孕妈交流', 1, 0, 0, 1, 1, 0, '12	孕妇手麻是怎么回事呢？	1326437709	wismartzy', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(20, 0, 'group', '营养区', 1, 5, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(21, 0, 'group', '心灵交流', 1, 6, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(22, 0, 'group', '塑身恢复', 1, 7, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(23, 0, 'group', '技艺沙龙', 1, 8, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(26, 14, 'forum', '坐月子', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(27, 5, 'forum', '成长日志', 1, 2, 0, 1, 1, 0, '9	培养一个有耐性的宝宝	1326436932	wismartzy', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(28, 5, 'forum', '早期教育', 1, 0, 0, 1, 1, 0, '7	宝宝智力发展的八个黄金期	1326436702	wismartzy', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(29, 3, 'forum', '休闲生活', 1, 0, 0, 1, 1, 0, '11	春运不可怕~	1326437597	wismartzy', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(30, 3, 'forum', '热点关注', 1, 0, 0, 1, 3, 0, '1	很喜欢禧妈拉伢俱乐部提供的服务套餐	1326442657	xifeng666', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(31, 20, 'forum', '母乳喂养', 1, 0, 0, 1, 1, 0, '16	测试	1329063333	2727', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(32, 20, 'forum', '食谱大全', 1, 0, 0, 3, 3, 0, '14	北方的孕妈妈，都吃什么水果呢	1326443069	xifeng666', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(33, 20, 'forum', '均衡营养', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(34, 14, 'forum', '护理', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(35, 14, 'forum', '保健', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(36, 23, 'forum', '活动', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(37, 23, 'forum', '公告', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(38, 22, 'forum', '产后食谱', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 127, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(39, 22, 'forum', '产后瑜伽', 1, 0, 0, 0, 0, 0, '', 1, 0, 1, 1, 0, 0, 1, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_imagetypes`
--

CREATE TABLE IF NOT EXISTS `discuz_imagetypes` (
  `typeid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `type` enum('smiley','icon','avatar') NOT NULL DEFAULT 'smiley',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `directory` char(100) NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `discuz_imagetypes`
--

INSERT INTO `discuz_imagetypes` (`typeid`, `name`, `type`, `displayorder`, `directory`) VALUES
(1, '默认表情', 'smiley', 1, 'default');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_invites`
--

CREATE TABLE IF NOT EXISTS `discuz_invites` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `inviteip` char(15) NOT NULL,
  `invitecode` char(16) NOT NULL,
  `reguid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `regdateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  KEY `uid` (`uid`,`status`),
  KEY `invitecode` (`invitecode`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_itempool`
--

CREATE TABLE IF NOT EXISTS `discuz_itempool` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL,
  `question` text NOT NULL,
  `answer` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_magiclog`
--

CREATE TABLE IF NOT EXISTS `discuz_magiclog` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `magicid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `action` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` smallint(6) unsigned NOT NULL DEFAULT '0',
  `price` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `targettid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `targetpid` int(10) unsigned NOT NULL DEFAULT '0',
  `targetuid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  KEY `uid` (`uid`,`dateline`),
  KEY `targetuid` (`targetuid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_magicmarket`
--

CREATE TABLE IF NOT EXISTS `discuz_magicmarket` (
  `mid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `magicid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(15) NOT NULL,
  `price` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `num` (`magicid`,`num`),
  KEY `price` (`magicid`,`price`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_magics`
--

CREATE TABLE IF NOT EXISTS `discuz_magics` (
  `magicid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `identifier` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `price` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num` smallint(6) unsigned NOT NULL DEFAULT '0',
  `salevolume` smallint(6) unsigned NOT NULL DEFAULT '0',
  `supplytype` tinyint(1) NOT NULL DEFAULT '0',
  `supplynum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `weight` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `filename` varchar(50) NOT NULL,
  `magicperm` text NOT NULL,
  PRIMARY KEY (`magicid`),
  UNIQUE KEY `identifier` (`identifier`),
  KEY `displayorder` (`available`,`displayorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `discuz_magics`
--

INSERT INTO `discuz_magics` (`magicid`, `available`, `type`, `name`, `identifier`, `description`, `displayorder`, `price`, `num`, `salevolume`, `supplytype`, `supplynum`, `weight`, `filename`, `magicperm`) VALUES
(1, 1, 1, '变色卡', 'CCK', '可以变换主题的颜色,并保存24小时', 0, 10, 999, 0, 0, 0, 20, 'magic_color.inc.php', ''),
(2, 1, 3, '金钱卡', 'MOK', '可以随机获得一些金币', 0, 10, 999, 0, 0, 0, 30, 'magic_money.inc.php', ''),
(3, 1, 1, 'IP卡', 'SEK', '可以查看帖子作者的IP', 0, 15, 999, 0, 0, 0, 30, 'magic_see.inc.php', ''),
(4, 1, 1, '提升卡', 'UPK', '可以提升某个主题', 0, 10, 999, 0, 0, 0, 30, 'magic_up.inc.php', ''),
(5, 1, 1, '置顶卡', 'TOK', '可以将主题置顶24小时', 0, 20, 999, 0, 0, 0, 40, 'magic_top.inc.php', ''),
(6, 1, 1, '悔悟卡', 'REK', '可以删除自己的帖子', 0, 10, 999, 0, 0, 0, 30, 'magic_del.inc.php', ''),
(7, 1, 2, '狗仔卡', 'RTK', '查看某个用户是否在线', 0, 15, 999, 0, 0, 0, 30, 'magic_reporter.inc.php', ''),
(8, 1, 1, '沉默卡', 'CLK', '24小时内不能回复', 0, 15, 999, 0, 0, 0, 30, 'magic_close.inc.php', ''),
(9, 1, 1, '喧嚣卡', 'OPK', '使贴子可以回复', 0, 15, 999, 0, 0, 0, 30, 'magic_open.inc.php', ''),
(10, 1, 1, '隐身卡', 'YSK', '可以将自己的帖子匿名', 0, 20, 999, 0, 0, 0, 30, 'magic_hidden.inc.php', ''),
(11, 1, 1, '恢复卡', 'CBK', '将匿名恢复为正常显示的用户名,匿名终结者', 0, 15, 999, 0, 0, 0, 20, 'magic_renew.inc.php', ''),
(12, 1, 1, '移动卡', 'MVK', '可将自已的帖子移动到其他版面（隐含、特殊限定版面除外）', 0, 50, 989, 0, 0, 0, 50, 'magic_move.inc.php', '');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_medals`
--

CREATE TABLE IF NOT EXISTS `discuz_medals` (
  `medalid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`medalid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `discuz_medals`
--

INSERT INTO `discuz_medals` (`medalid`, `name`, `available`, `image`) VALUES
(1, 'Medal No.1', 0, 'medal1.gif'),
(2, 'Medal No.2', 0, 'medal2.gif'),
(3, 'Medal No.3', 0, 'medal3.gif'),
(4, 'Medal No.4', 0, 'medal4.gif'),
(5, 'Medal No.5', 0, 'medal5.gif'),
(6, 'Medal No.6', 0, 'medal6.gif'),
(7, 'Medal No.7', 0, 'medal7.gif'),
(8, 'Medal No.8', 0, 'medal8.gif'),
(9, 'Medal No.9', 0, 'medal9.gif'),
(10, 'Medal No.10', 0, 'medal10.gif');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_memberfields`
--

CREATE TABLE IF NOT EXISTS `discuz_memberfields` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `nickname` varchar(30) NOT NULL DEFAULT '',
  `site` varchar(75) NOT NULL DEFAULT '',
  `alipay` varchar(50) NOT NULL DEFAULT '',
  `icq` varchar(12) NOT NULL DEFAULT '',
  `qq` varchar(12) NOT NULL DEFAULT '',
  `yahoo` varchar(40) NOT NULL DEFAULT '',
  `msn` varchar(40) NOT NULL DEFAULT '',
  `taobao` varchar(40) NOT NULL DEFAULT '',
  `location` varchar(30) NOT NULL DEFAULT '',
  `customstatus` varchar(30) NOT NULL DEFAULT '',
  `medals` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `avatarwidth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `avatarheight` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bio` text NOT NULL,
  `sightml` text NOT NULL,
  `ignorepm` text NOT NULL,
  `groupterms` text NOT NULL,
  `authstr` varchar(20) NOT NULL DEFAULT '',
  `spacename` varchar(40) NOT NULL,
  `buyercredit` smallint(6) NOT NULL DEFAULT '0',
  `sellercredit` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_memberfields`
--

INSERT INTO `discuz_memberfields` (`uid`, `nickname`, `site`, `alipay`, `icq`, `qq`, `yahoo`, `msn`, `taobao`, `location`, `customstatus`, `medals`, `avatar`, `avatarwidth`, `avatarheight`, `bio`, `sightml`, `ignorepm`, `groupterms`, `authstr`, `spacename`, `buyercredit`, `sellercredit`) VALUES
(1, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(2, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(3, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(4, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(5, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(6, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(7, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(8, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(9, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(10, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(11, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(12, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(13, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(14, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(15, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(16, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(17, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(18, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(19, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(20, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(21, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(22, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(23, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(24, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(25, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0),
(26, '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_membermagics`
--

CREATE TABLE IF NOT EXISTS `discuz_membermagics` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `magicid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `num` smallint(6) unsigned NOT NULL DEFAULT '0',
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_members`
--

CREATE TABLE IF NOT EXISTS `discuz_members` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(15) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `secques` char(8) NOT NULL DEFAULT '',
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `adminid` tinyint(1) NOT NULL DEFAULT '0',
  `groupid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `groupexpiry` int(10) unsigned NOT NULL DEFAULT '0',
  `extgroupids` char(20) NOT NULL DEFAULT '',
  `regip` char(15) NOT NULL DEFAULT '',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` char(15) NOT NULL DEFAULT '',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `digestposts` smallint(6) unsigned NOT NULL DEFAULT '0',
  `oltime` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pageviews` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `credits` int(10) NOT NULL DEFAULT '0',
  `extcredits1` int(10) NOT NULL DEFAULT '0',
  `extcredits2` int(10) NOT NULL DEFAULT '0',
  `extcredits3` int(10) NOT NULL DEFAULT '0',
  `extcredits4` int(10) NOT NULL DEFAULT '0',
  `extcredits5` int(10) NOT NULL DEFAULT '0',
  `extcredits6` int(10) NOT NULL DEFAULT '0',
  `extcredits7` int(10) NOT NULL DEFAULT '0',
  `extcredits8` int(10) NOT NULL DEFAULT '0',
  `email` char(40) NOT NULL DEFAULT '',
  `bday` date NOT NULL DEFAULT '0000-00-00',
  `sigstatus` tinyint(1) NOT NULL DEFAULT '0',
  `tpp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ppp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `styleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `dateformat` tinyint(1) NOT NULL DEFAULT '0',
  `timeformat` tinyint(1) NOT NULL DEFAULT '0',
  `pmsound` tinyint(1) NOT NULL DEFAULT '0',
  `showemail` tinyint(1) NOT NULL DEFAULT '0',
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `invisible` tinyint(1) NOT NULL DEFAULT '0',
  `timeoffset` char(4) NOT NULL DEFAULT '',
  `newpm` tinyint(1) NOT NULL DEFAULT '0',
  `accessmasks` tinyint(1) NOT NULL DEFAULT '0',
  `editormode` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `customshow` tinyint(1) unsigned NOT NULL DEFAULT '26',
  `xspacestatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `discuz_members`
--

INSERT INTO `discuz_members` (`uid`, `username`, `password`, `secques`, `gender`, `adminid`, `groupid`, `groupexpiry`, `extgroupids`, `regip`, `regdate`, `lastip`, `lastvisit`, `lastactivity`, `lastpost`, `posts`, `digestposts`, `oltime`, `pageviews`, `credits`, `extcredits1`, `extcredits2`, `extcredits3`, `extcredits4`, `extcredits5`, `extcredits6`, `extcredits7`, `extcredits8`, `email`, `bday`, `sigstatus`, `tpp`, `ppp`, `styleid`, `dateformat`, `timeformat`, `pmsound`, `showemail`, `newsletter`, `invisible`, `timeoffset`, `newpm`, `accessmasks`, `editormode`, `customshow`, `xspacestatus`) VALUES
(1, 'admin', 'f6fdffe48c908deb0f4c3bd36c032e72', '', 0, 1, 1, 0, '', 'hidden', 1323074108, '218.75.123.171', 1326463812, 1329269715, 1323074108, 0, 0, 7, 421, 0, 0, 0, 0, 0, 0, 0, 0, 0, '499139122@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, '9999', 0, 0, 2, 26, 0),
(2, 'liqiulin', 'liqiulin', '', 0, 0, 10, 0, '', '127.0.0.1', 1324885833, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'liqiulin@echox.net', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(3, 'test3', 'liqiulin', '', 0, 0, 10, 0, '', '127.0.0.1', 1324886107, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'test3@echox.net', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(4, 'fgsertgs', 'liqiulin', '', 0, 0, 10, 0, '', '127.0.0.1', 1324888265, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'asda@ejoj.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(5, 'liqiulintest', 'liqiulin', '', 0, 0, 10, 0, '', '127.0.0.1', 1324889635, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'liqiulin@echox.net', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(6, 'xifeng', '540b043d0ccc05b1f3e2c78e53c3e1d1', '', 0, 0, 10, 0, '', '10.6.11.225', 1326250842, '218.75.123.171', 1326536430, 1329902405, 1326434747, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'xf507756@163.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(7, 'zhangfan', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 0, 10, 0, '', '10.6.11.126', 1326345678, '218.75.123.171', 0, 1326504196, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '327605168@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(8, '110', 'f6fdffe48c908deb0f4c3bd36c032e72', '', 0, 0, 10, 0, '', '127.0.0.1', 1326354396, '218.75.123.171', 1326370596, 1326438493, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'xcodeman@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(9, '鏇逛繆', '4342c3ea55a1619b91a7a89422caa582', '', 0, 0, 10, 0, '', '127.0.0.1', 1326374015, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'xcodeman@hotmail.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(10, 'xizixin', '540b043d0ccc05b1f3e2c78e53c3e1d1', '', 0, 0, 10, 0, '', '10.6.11.225', 1326424245, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1009418813@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(11, '09073316', '26c67d31bfa976711c9aed5a13a85515', '', 0, 0, 10, 0, '', '127.0.0.1', 1326424833, '218.75.123.171', 0, 1326436997, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'yeahdreamer@gmail.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(12, 'wise', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 0, 10, 0, '', '10.6.11.225', 1326425024, '218.75.123.171', 1326425031, 1326537786, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '123456@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(13, 'wismartzy', '2608b47641d7e8a119b3b5de4bbf0fe2', '', 0, 0, 10, 0, '', '218.75.123.171', 1326435487, '218.75.123.171', 1326459098, 1326513907, 1326459611, 12, 0, 0, 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'wismartzy@sina.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(14, 'xifeng666', '96e79218965eb72c92a549dd5a330112', '', 0, 0, 10, 0, '', '218.75.123.171', 1326436882, '218.75.123.171', 1326436887, 1326507947, 1326443069, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '7897968@163.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(15, 'yyw', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 0, 10, 0, '', '218.75.123.171', 1326537188, '218.75.123.171', 0, 1326538036, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '874561239@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(16, 'cici', '123456', '', 0, 0, 10, 0, '', '218.75.123.171', 1326537512, '218.75.123.171', 0, 1326537524, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1201@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(17, '01', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 0, 10, 0, '', '218.75.123.171', 1326537873, '218.75.123.171', 0, 1326537910, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'test@test.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(18, 'chenxufeng', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 0, 10, 0, '', '218.75.123.171', 1326544781, '218.75.123.171', 0, 1326544795, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'chenxf2008@live.cn', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(19, '02', '647c8bb5d3c4c9d1c6d50d464d18fc87', '', 0, 0, 10, 0, '', '218.75.123.171', 1326695472, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'a@ximalaya.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(20, '009', 'c8c605999f3d8352d7bb792cf3fdb25b', '', 0, 0, 10, 0, '', '115.206.163.243', 1326698012, '125.120.154.98', 1326806752, 1329061839, 1329061864, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'a@ximalaya.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(21, '111', 'bbb8aae57c104cda40c93843ad5e6db8', '', 0, 0, 10, 0, '', '115.206.163.243', 1326698355, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'a@ximalaya.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(22, '999', 'c8c605999f3d8352d7bb792cf3fdb25b', '', 0, 0, 10, 0, '', '125.119.254.211', 1327988905, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'sdf@126.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(23, '2727', '4b3d1251a8d58b4733542911617ddf10', '', 0, 0, 10, 0, '', '125.120.154.98', 1329063099, '218.75.123.171', 1329063310, 1329213873, 1329063333, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'abab@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(24, '33', 'e2537517c5c777846964d4470ef855d2', '', 0, 0, 10, 0, '', '125.120.149.207', 1329107068, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'a@ximalaya.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(25, '011', 'e10adc3949ba59abbe56e057f20f883e', '', 0, 0, 10, 0, '', '218.75.123.171', 1329120068, '218.75.123.171', 1329120676, 1329269584, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'a@ximalaya.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0),
(26, 'xifeng01', '123456', '', 0, 0, 10, 0, '', '218.75.123.171', 1329134065, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1@qq.com', '0000-00-00', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '9999', 0, 0, 2, 26, 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_memberspaces`
--

CREATE TABLE IF NOT EXISTS `discuz_memberspaces` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `style` char(20) NOT NULL,
  `description` char(100) NOT NULL,
  `layout` char(200) NOT NULL,
  `side` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_memberspaces`
--

INSERT INTO `discuz_memberspaces` (`uid`, `style`, `description`, `layout`, `side`) VALUES
(1, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(5, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(6, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(8, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(9, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(12, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(14, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(11, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(13, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(10, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(18, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(19, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(20, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(22, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(17, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(16, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(4, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(2, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(3, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(15, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(7, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(26, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(23, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(25, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(24, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1),
(21, 'default', '', '[userinfo][calendar][myreplies][myfavforums]	[myblogs][mythreads]	', 1);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_moderators`
--

CREATE TABLE IF NOT EXISTS `discuz_moderators` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `inherited` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_modworks`
--

CREATE TABLE IF NOT EXISTS `discuz_modworks` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `modaction` char(3) NOT NULL DEFAULT '',
  `dateline` date NOT NULL DEFAULT '2006-01-01',
  `count` smallint(6) unsigned NOT NULL DEFAULT '0',
  `posts` smallint(6) unsigned NOT NULL DEFAULT '0',
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_myposts`
--

CREATE TABLE IF NOT EXISTS `discuz_myposts` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `position` smallint(6) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `special` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`tid`),
  KEY `tid` (`tid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_myposts`
--

INSERT INTO `discuz_myposts` (`uid`, `tid`, `pid`, `position`, `dateline`, `special`) VALUES
(20, 3, 19, 1, 1329061864, 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_mythreads`
--

CREATE TABLE IF NOT EXISTS `discuz_mythreads` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `special` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`tid`),
  KEY `tid` (`tid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_mythreads`
--

INSERT INTO `discuz_mythreads` (`uid`, `tid`, `special`, `dateline`) VALUES
(23, 16, 0, 1329063333);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_onlinelist`
--

CREATE TABLE IF NOT EXISTS `discuz_onlinelist` (
  `groupid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `url` varchar(30) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_onlinelist`
--

INSERT INTO `discuz_onlinelist` (`groupid`, `displayorder`, `title`, `url`) VALUES
(1, 1, '管理员', 'online_admin.gif'),
(2, 2, '超级版主', 'online_supermod.gif'),
(3, 3, '版主', 'online_moderator.gif'),
(0, 4, '会员', 'online_member.gif');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_onlinetime`
--

CREATE TABLE IF NOT EXISTS `discuz_onlinetime` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thismonth` smallint(6) unsigned NOT NULL DEFAULT '0',
  `total` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_onlinetime`
--

INSERT INTO `discuz_onlinetime` (`uid`, `thismonth`, `total`, `lastupdate`) VALUES
(1, 0, 440, 1329271905),
(8, 0, 50, 1326438493),
(6, 0, 140, 1329902405),
(13, 0, 110, 1326521416),
(14, 0, 80, 1326507947),
(12, 0, 10, 1326537786),
(20, 0, 20, 1329062479),
(23, 0, 10, 1329213873),
(25, 0, 10, 1329269584);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_orders`
--

CREATE TABLE IF NOT EXISTS `discuz_orders` (
  `orderid` char(32) NOT NULL DEFAULT '',
  `status` char(3) NOT NULL DEFAULT '',
  `buyer` char(50) NOT NULL DEFAULT '',
  `admin` char(15) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `price` float(7,2) unsigned NOT NULL DEFAULT '0.00',
  `submitdate` int(10) unsigned NOT NULL DEFAULT '0',
  `confirmdate` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `orderid` (`orderid`),
  KEY `submitdate` (`submitdate`),
  KEY `uid` (`uid`,`submitdate`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_paymentlog`
--

CREATE TABLE IF NOT EXISTS `discuz_paymentlog` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `netamount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`,`uid`),
  KEY `uid` (`uid`),
  KEY `authorid` (`authorid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_pluginhooks`
--

CREATE TABLE IF NOT EXISTS `discuz_pluginhooks` (
  `pluginhookid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pluginid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `code` mediumtext NOT NULL,
  PRIMARY KEY (`pluginhookid`),
  KEY `pluginid` (`pluginid`),
  KEY `available` (`available`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_plugins`
--

CREATE TABLE IF NOT EXISTS `discuz_plugins` (
  `pluginid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `adminid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '',
  `identifier` varchar(40) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `datatables` varchar(255) NOT NULL DEFAULT '',
  `directory` varchar(100) NOT NULL DEFAULT '',
  `copyright` varchar(100) NOT NULL DEFAULT '',
  `modules` text NOT NULL,
  PRIMARY KEY (`pluginid`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_pluginvars`
--

CREATE TABLE IF NOT EXISTS `discuz_pluginvars` (
  `pluginvarid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pluginid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `variable` varchar(40) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT 'text',
  `value` text NOT NULL,
  `extra` text NOT NULL,
  PRIMARY KEY (`pluginvarid`),
  KEY `pluginid` (`pluginid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_pms`
--

CREATE TABLE IF NOT EXISTS `discuz_pms` (
  `pmid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgfrom` varchar(15) NOT NULL DEFAULT '',
  `msgfromid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `msgtoid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `folder` enum('inbox','outbox') NOT NULL DEFAULT 'inbox',
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `subject` varchar(75) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `delstatus` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pmid`),
  KEY `msgtoid` (`msgtoid`,`folder`,`dateline`),
  KEY `msgfromid` (`msgfromid`,`folder`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_pmsearchindex`
--

CREATE TABLE IF NOT EXISTS `discuz_pmsearchindex` (
  `searchid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `searchstring` varchar(255) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `pms` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pmids` text NOT NULL,
  PRIMARY KEY (`searchid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_polloptions`
--

CREATE TABLE IF NOT EXISTS `discuz_polloptions` (
  `polloptionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `votes` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `polloption` varchar(80) NOT NULL DEFAULT '',
  `voterids` mediumtext NOT NULL,
  PRIMARY KEY (`polloptionid`),
  KEY `tid` (`tid`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_polls`
--

CREATE TABLE IF NOT EXISTS `discuz_polls` (
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `multiple` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `maxchoices` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_posts`
--

CREATE TABLE IF NOT EXISTS `discuz_posts` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `first` tinyint(1) NOT NULL DEFAULT '0',
  `author` varchar(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(80) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` mediumtext NOT NULL,
  `useip` varchar(15) NOT NULL DEFAULT '',
  `invisible` tinyint(1) NOT NULL DEFAULT '0',
  `anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `usesig` tinyint(1) NOT NULL DEFAULT '0',
  `htmlon` tinyint(1) NOT NULL DEFAULT '0',
  `bbcodeoff` tinyint(1) NOT NULL DEFAULT '0',
  `smileyoff` tinyint(1) NOT NULL DEFAULT '0',
  `parseurloff` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` tinyint(1) NOT NULL DEFAULT '0',
  `rate` smallint(6) NOT NULL DEFAULT '0',
  `ratetimes` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `fid` (`fid`),
  KEY `authorid` (`authorid`),
  KEY `dateline` (`dateline`),
  KEY `invisible` (`invisible`),
  KEY `displayorder` (`tid`,`invisible`,`dateline`),
  KEY `first` (`tid`,`first`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `discuz_posts`
--

INSERT INTO `discuz_posts` (`pid`, `fid`, `tid`, `first`, `author`, `authorid`, `subject`, `dateline`, `message`, `useip`, `invisible`, `anonymous`, `usesig`, `htmlon`, `bbcodeoff`, `smileyoff`, `parseurloff`, `attachment`, `rate`, `ratetimes`, `status`) VALUES
(1, 30, 1, 1, 'xifeng', 6, '很喜欢禧妈拉伢俱乐部提供的服务套餐', 1326434747, '很喜欢禧妈拉伢俱乐部提供的服务套餐，顶一个。。。。。。。\n\n[[i] 本帖最后由 xifeng 于 2012-1-13 14:09 编辑 [/i]]', '218.75.123.171', 0, 0, 0, 0, 0, -1, 0, 0, 0, 0, 0),
(2, 10, 2, 1, 'wismartzy', 13, '孕妈妈常见疾病如何预防', 1326435649, '　水肿\r\n　　90%以上的女性在怀孕期间脚踝和腿部都会出现水肿现象，如果经过检查没有其他症状，可视为正常现象，一般在怀孕后期会好转。\r\n　　事实上，水肿怀孕期间体内的水分增加、盆腔静脉受压、下肢静脉回流受阻有关。如果孕妈妈因水肿而产生不适，应尽可能抬高腿部以利于下肢静脉血液回流。最好能侧躺下来，在小腿处垫一个小枕头，休息半小时。\r\n　　在饮食上，过咸、太辛辣、腌制品等食物要适量进食，平常可以多喝点具有利尿效果的红豆汤。此外，孕妇最好多喝白开水，协助排泄系统把体内废物排出，有助于防止水分在体内停滞，但也要注意喝水不要过量。\r\n\r\n　　感冒\r\n　　准妈妈特别容易感冒。感冒时，一般不要使用抗生素之类的药物，尤其是在怀孕初期，使用药物有可能会对正在发育的胎儿产生影响。同时，务必分清是普通感冒还是病毒性流行性感冒。如果是一般的小感冒，建议用物理治疗的方式，如：多喝白开水、保持睡眠充足、多吃水果和绿色蔬菜、注意保暖等方式来治疗。如果准妈妈患的是流行性感冒，并伴随发烧等现象，则要在医生指导下作一些特殊处理。\r\n　　饮食方面，准妈妈在病期应补充高蛋白、高维生素、高矿物质的食物，太油腻的食物等不宜食用。\r\n\r\n　　腹痛腹泻\r\n　　准妈妈出现腹痛的原因有很多，如果发作应该及时到医院做详细检查，首先确定是否与腹中宝宝有关，其他引起腹痛的原因有胃胀气、肠痉挛、阑尾炎和细菌性痢疾等。有腹痛症状的孕妇千万不可拖延就医时间，以防病情恶化，因为引发腹痛的阑尾炎等甚至会造成胎儿早产。\r\n　　引起肠胃不适的最常见原因是消化不良。这一般不需要药物处理，孕妈妈只要减少高脂肪食物的摄取，避免辛辣食物和含有咖啡因的饮料，增加高纤维食物的摄取即可，这样还可以减缓消化不良引起的便秘问题。同时，孕妈妈还应少量多餐。\r\n\r\n　　产前抑郁\r\n　　常常担心胎儿的健康，老是怀疑自己的怀孕症状有没有问题，看到相关的医学介绍就会莫名的紧张和害怕，夜晚睡觉时常常有失眠且多梦。这些症状的产生主要是因为准妈妈压力过大，还有一些准妈妈会出现较严重的产前抑郁症，如：情绪低落、食欲不振、极度缺乏安全感。\r\n　　当准妈妈心理不适时，体内的小宝宝也会受到影响，因为母子紧密相连，宝宝的个性更会受到妈妈心情的牵引。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(3, 11, 3, 1, 'wismartzy', 13, '手机放哪儿才不会影响生育', 1326435842, '随着无线通讯技术的发展，使用手机的人越来越多，而手机带来的相关健康问题也引起了人们更多的关注。手机的辐射到底对人体有多大危害，如何把危害的程度降到最低，成了手机用户最关心的问题。当人们使用手机时，手机会向发射基站传送无线电波 ，而无线电波或多或少地会被人体吸收，这些电波就是手机辐射。一般来说，手机待机时辐射较小，通话时辐射大一些，而在手机号码已经拨出而尚未接通时，辐射最大，辐射量是待机时的3倍左右。这些辐射有可能改变人体组织，对人体健康造成不利影响。 \r\n       手机别放枕头边\r\n       手机辐射对人的头部危害较大，它会对人的中枢神经系统造成机能性障碍，引起头痛、头昏、失眠、多梦和脱发等症状，有的人面部还会有刺激感。因此，人们在接电话时最好先把手机拿到离身体较远的距离接通，然后再放到耳边通话。此外，尽量不要用手机聊天，睡觉时也注意不要把手机放在枕头边。\r\n       莫把手机挂胸前\r\n       许多女孩子喜欢把手机挂在胸前，但是研究表明，手机挂在胸前，会对心脏和内分泌系统产生一定影响。即使在辐射较小的待机状态下，手机周围的电磁波辐射也会对人体造成伤害。心脏功能不全、心律不齐的人尤其要注意不能把手机挂在胸前。有专家认为，电磁辐射还会影响内分泌功能，导致女性月经失调。另外，电磁波辐射还会影响正常的细胞代谢，造成体内钾、钙、钠等金属离子紊乱。\r\n       手机中一般装有屏蔽设备，可减少辐射对人体的伤害，含铝、铅等重金属的屏蔽设备防护效果较好。但女性为了美观，往往会选择小巧的手机，这种手机的防护功能有可能不够完善，因此，在还没有出现既小巧、防护功能又强的手机之前，女性朋友最好不要把手机挂在胸前。\r\n       挂在腰部影响生育\r\n据了解，经常携带和使用手机的男性的精子数目可减少多达30%。有医学专家指出，手机若常挂在人体的腰部或腹部旁，其收发信号时产生的电磁波将辐射到人体内的精子或卵子，这可能会影响使用者的生育机能。英国的实验报告指出，老鼠被手机微波辐射5分钟，就会产生DNA病变;人类的精、卵子长时间受到手机微波辐射，也有可能产生DNA病变。\r\n      专家建议手机使用者尽量让手机远离腰、腹部，不要将手机挂在腰上或放在大衣口袋里。有些男性把手机塞在裤子口袋内，这对精子威胁最大，因为裤子的口袋就在睾丸旁边。当使用者在办公室、家中或车上时，最好把手机摆在一边。外出时可以把手机放在皮包里，这样离身体较远。使用耳机来接听手机也能有效减少手机辐射的影响。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(4, 32, 4, 1, 'wismartzy', 13, '豆腐：跟谁搭配最有营养', 1326436203, '1.豆腐配鱼营养富裕。　　豆腐蛋氨酸含量较少，而鱼类含量非常丰富;鱼类苯丙氨酸含量比较少，而豆腐中则含量较高。这样两者合起来吃，可以取长补短，相辅相成，从而提高营养价值。由于豆腐含钙量较多，而鱼中富含维生素D，两者合吃，借助鱼体内维生素D的作用，可使人体对钙的吸收率提高很多倍。因此，特别适合中老年人、青少年、孕妇食用。\r\n　　2.豆腐配肉蛋营养高一半。\r\n　　豆腐虽含有丰富的蛋白质，但缺少一种人体必需的氨基酸———蛋氨酸。如果单独烧菜，蛋白质的利用率则很低。如果将豆腐和其他的肉类、蛋类食物搭配在一起，可以提高豆腐中蛋白质的营养利用率。\r\n　　3.豆腐配海带加碘又补钙。\r\n　　豆腐及其大豆制品，营养丰富，价格便宜，能补充人体需要的优质蛋白质、卵磷脂、亚油酸、维生素 B1、维生素E、钙、铁等。豆腐中还含有多种皂角甙，能阻止过氧化脂质的产生，抑制脂肪吸收，促进脂肪分解;但皂角甙又可促进碘的排泄，容易引起碘的缺乏，海带含碘丰富，将豆腐与海带一起烹调，是十分合理的搭配。\r\n　　 4.豆腐配萝卜身体不受挫。\r\n　　豆腐属植物蛋白，多食会引起消化不良。萝卜，特别是白萝卜的消化功能强，若与豆腐拌食，有利于豆腐的吸收，人也就不会受消化不良的困扰。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(5, 32, 5, 1, 'wismartzy', 13, '饭菜水果一块吃不消化', 1326436375, '水果的主要成分是果糖，无需通过胃来消化，它可直接进入小肠被吸收。而米饭、面食、肉食等含淀粉及蛋白质成分的食物，则需要在胃里停留一段时间。如果进餐时饭菜、水果一块吃，消化慢的淀粉蛋白质会影响消化快的水果，水果在胃内停留的时间延长时，体内的高温会使其产生发酵反应甚至腐败，出现胀气、便秘等症状，给消化道带来不良影响。\r\n含鞣酸成分多的水果(如柿子、石榴、柠檬、葡萄、酸柚、杨梅等)，也不宜与鱿鱼、龙虾、藻类等富含蛋白质及矿物质的海味同吃，因水果中的鞣酸不仅会降低海味蛋白质的营养价值，还容易和海味品中的钙、铁结合成一种不易消化的物质，这种物质能刺激胃肠，引起恶心、呕吐、腹痛等。所以，建议最好在吃完饭半小时后再食用水果。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(6, 30, 1, 0, 'wismartzy', 13, '必须的~', 1326436447, ':victory: 必须得顶啊~:lol :lol :lol', '218.75.123.171', 0, 0, 0, 0, -1, 0, 0, 0, 0, 0, 0),
(7, 16, 6, 1, 'wismartzy', 13, '有助于宝宝增高食物你知道吗？', 1326436580, '我们人类有两个增高高峰，一个是婴幼儿时期，一个是青春期，那作为婴儿期，\r\n我们该怎样护理儿童的健康成长。\r\n以下是增高医院的给吃以下建议。\r\n　　妈妈们可以根据孩子的口味做菜，下列食物是有助于增高方法的食物。\r\n　　成长过程中必须均衡摄取四种营养元素，一定要多吃富含蛋白质、钙、铁、维生素的食物。\r\n　　1、富含蛋白质的食物：这是为成长提供必需蛋白质的食物类型。成长的关键在于生长激素的分泌，如果不分泌生长激素那肯定是长不高的。蛋白质是促进生长激素分泌的重要营养物质，此外还为孩子制造肌肉和血液。\r\n    黄豆，豆奶，豆腐，牛肉、猪肉、鸡肉等肉类，鱼，贝类等\r\n　　2、富含钙质的食物：如果说其他营养物质有助于成长，那么钙就是直接影响成长的营养物质。大部\r\n分营养物质在各种食物中都有分布，所以只要吃就能摄取到，但是富含钙的食物范围相对较窄。如果不吃\r\n这些食物，就有可能引发缺钙，影响正常生长。\r\n　　牛奶，海带，海藻，紫菜，莴苣，凤尾鱼，银鱼等\r\n　　3、富含维生素的食物：维生素可以帮助蛋白质、钙等营养物质的吸收，还能调节身体各种功能。特\r\n别是维生素D 可以促进钙的吸收，帮助骨骼成长。\r\n　　菠菜，胡萝卜，南瓜，紫菜，海藻，香菇，伞菌，桔子，草莓等\r\n　　4、富含铁的食物：铁是血液中血红蛋白的主要成分，缺乏铁会引发贫血症。\r\n　　苏子叶，鸡蛋，牛肝，奶酪，海带，桔子等', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(8, 28, 7, 1, 'wismartzy', 13, '宝宝智力发展的八个黄金期', 1326436702, '宝宝智力发展的八个黄金期，详细介绍如下：\r\n第一次：所有的感官都开始工作\r\n婴儿在第5周左右出现器官的迅速成熟过程中变化最明显，婴儿在哭的时候第一次流泪，他也更多地微笑表示高兴，更经常地进行观察和聆听，对气味和动静会作出明显的反应。婴儿对环境的兴趣变得大多了。\r\n第二次：恐惧感提升\r\n婴儿在第8周左右发现，周围环境是不统一的，而且是由活动的具体东西组成的(例如自己的手)。这么多的新印象起初会引起恐惧，同母亲接触最有助于消除这种恐惧感。\r\n第三次：发现动作\r\n婴儿在第12周左右会认识活动的过程。他自己的动作也不那么死板了，而且受到了控制。他会发出尖叫，格格地笑，兴奋地牙牙学语。\r\n第四次：抓住一切\r\n到第19周时，婴儿会抓东西，会转动和翻动东西，会注视物体的活动过程，这时他对一切都要研究——用手摸或者干脆往嘴里放。\r\n第五次：研究事物之间的关联\r\n在第26周左右，婴儿开始理解事物之间的关联，生长激素例如按按钮同放音乐之间的关系。他开始能区分物品的位置与距离，如里外远近，最喜欢的游戏是把东西拿进拿出，把什么都弄得乱七八糟。\r\n第六次：许多东西都很相似\r\n婴儿在第37周时开始对东西和经历进行分类，从而开始像成人那样思维。例如，狗的“汪汪” 叫，不论大小，不论白色褐色。\r\n第七次：一切都按顺序\r\n婴儿在第46周会认识到，做事情要有一定的顺序。他最喜欢的游戏是“自己动手”和“帮助家里干活”。\r\n第八次：制定自己的计划\r\n第55周的婴儿会发现“程序”，即先后次序。但这次序不是固定，而是可以自由变动的。这时的孩子会非常明确地表示他想要什么，例如当他想外出时，就有穿衣穿鞋的要求。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(9, 4, 8, 1, 'wismartzy', 13, '鼓励宝宝模仿 挖掘艺术潜能', 1326436828, '培养孩子的模仿能力，可以从孩子1岁半到2岁半时就开始，再大一些的孩子开始玩角色扮演游戏，尝试着扮演他们所观察到的大人甚至有些动物的各种活动或动作，有时甚至能模仿得活灵活现，惟妙惟肖。\r\n对于孩子的这种能力或者才能，大人不要打扰或反对，而是应该给孩子提供一定的条件或环境，让孩子的这一潜能得到尽可能的发挥。\r\n从艺术欣赏的角度来看，在人类最早的绘画和雕刻中，模仿占有突出的地位，模仿是人类的天性，人对于模仿的作品总有一种如何增高的快感。那么对于孩子来说，模仿是他们最初的再现艺术才能的显石，不论他们模仿的像与不像，当孩子在模仿之前都需要经过认真的观察，模仿时都需要发挥各种思维能力，包括记忆力、想像力、抽象思维能力等才能达到模仿的目的，孩子如果特别的喜欢模仿并且模仿的很像的话，很可能是孩子具有表演潜能的初步显现，大人们千万不要错过利用孩子的 这一兴趣培养孩子潜能的机会。要知道，孩子的模仿不仅对孩子的智力发展没有坏处，而是对孩子的智力发展有极大的促进作用。 \r\n培养孩子的模仿能力，可以在日常生活中进行，在领孩子观看了动物以后，让孩子模仿鸡是如何叫的、猫和狗是如何叫的，小鱼是如何吃东西的，小乌是如何飞的、小猫如何走路的等等。这些不仅能培养孩子的模仿能力，而且对孩子的记忆力、观察力、思维能力都是很好的培养和锻炼，也能使孩子获得更多的知识。 \r\n在有条件的时候，给孩子提供观看别人艺术表演的机会，或者通过电视、电形等媒体给孩了提供观看艺术表演的机会，看过了之后让孩子学着模仿表演。观看士兵的操练、观察交通誉察如何折挥交通，过后让孩子模仿。对于孩子的模仿给以积极的肯定和及时的表扬，这些都对提高孩子的模仿能力很存好处。不论是舞蹈还是表演，都是儿童智慧的组成部分，大人应当尽最的保留和发展孩子在早期显露的这份兴趣和艺术潜能。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(10, 27, 9, 1, 'wismartzy', 13, '培养一个有耐性的宝宝', 1326436932, '面前的蛋糕还没吃完，毛毛便迫不及待地嚷着要吃巧克力；在游乐场看到好玩的滑梯，毛毛无视前面正在排队的小朋友，自己硬要抢先上去玩；上兴趣班时，毛毛发现自己怎样也无法做好时，便轻易放弃；遇到要求没有被及时满足的时候，他立即发脾气，甚至情绪失控……如此种种，3岁的毛毛在父母的眼里就是一个“急性子”，遇事没有一点耐心。\r\n       早教专家表示，小朋友的忍耐力，其实与其年龄成反比，然而“耐性”这种特质，必须从小开始培养。专家建议家长应在幼儿至小学阶段，开始逐步培养孩子的忍耐力、耐性及坚毅能力。如果小朋友得到不正确的引导教育，长大后就可能要承受“恶果”。例如，孩子容易被自己的情绪所左右，稍不如意就觉得无法忍受，不能够冷静地思考解决问题的方法，不能承受挫折，以至于影响自己的工作和生活。\r\n专家强调，父母应该首先了解自己孩子的年纪、能力及脾气秉性。其次，父母要以身作则，如果家长本身也是急性子，就很难去训练小朋友的耐性。父母应该时刻注意自己在生活中的表现，力求做个耐心的典范。\r\n方法1：刻意让孩子等待佳佳通常总是迫不及待地想得到东西，如看动画片、切开刚买回的西瓜或是再讲一个故事等等。佳佳妈妈都会告诉她，她可以得到，但需要等一会儿。给佳佳时间用来体会和比较，让她明白“等待”是一种什么感受，这段时间里可以为孩子唱个短小的歌曲或是从1数到10。这样孩子就能了解“等待”只是一小段时间。\r\n专家点评：以上案例列举的方法对培养孩子耐心很实用。培养孩子耐心，就得尝试向孩子解释，让他明白应该等待多长时间，然后不要理睬孩子将有可能对你的打扰。不过，对于学龄前的孩子不要一下就让他等5分钟。刚开始时可先等1分钟，然后再增加到3分钟，一般在家里训练，效果会比较好。\r\n提示：也可以在孩子在等待的时间里干点事，譬如妈妈接电话时，让孩子安静1分钟。如果孩子能安安静静等待了这1分钟，妈妈应该这样表扬他：“你真有耐心，能在妈妈说话的时候自己玩。”如果孩子不能乖乖听话，那么接下来的1分钟可以不理会他，并且向她说明为什么。这样做，需要父母硬下心肠，不然训练将会前功尽弃。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(11, 9, 10, 1, 'xifeng666', 14, '剖腹产好还是顺产好呢？？？', 1326437293, ':o :o :o :o :o', '218.75.123.171', 0, 0, 0, 0, -1, 0, 0, 0, 0, 0, 0),
(12, 9, 10, 0, 'wismartzy', 13, '这么说', 1326437454, '据专家介绍\r\n    很多妇女对生产的疼痛怀有恐惧心理，担心自己忍受不了这种痛苦，其实这是没有必要的。每个妇女都有自己分娩的能力，这是人的一种本能。当妊娠即将结束时，自然的发生宫缩、见红、宫口自然的开大、破水、儿头自然下降，直到胎儿自然分娩。无论阵发性的宫缩疼痛的剧烈与否，产妇都能忍耐至分娩成功。胎儿在宫腔中，也为自然分娩做好了充分的准备，当每阵宫缩来临时，胎儿处于暂时的缺氧状态，经过几个小时的产程，胎儿并不会因宫缩的缺氧而发生胎死宫内；骨产道是崎岖不平的，胎儿能够通过内旋转，不断寻找骨盆内最适合自己的途径不断下降，最终娩出母体。这是人类世代繁衍的最基本的能力。自产的产妇产后出血较少，并且恢复较快，产后很快就可以下地活动，这也是自产的优势。\r\n剖宫产与顺产并不是一成不变的，是可以互相转化的。当决定顺产后，进入产程，胎儿可因宫缩过强，发生宫内缺氧，无法耐受产程，这时医生会建议剖宫产；在产程中，由于胎头位置不好，无法内旋转，也需要剖宫产；有时产妇的子宫口水肿不再继续开大，也无法自产。有的产妇说受二茬罪，实际上胎儿经过几个小时的宫缩，经受了锻炼，减少感觉统合失调综合症的发生，有利无害。也有些产妇已决定剖宫产，但还未来得及完成准备工作，已临产顺利自娩。\r\n    所以女性朋友在选择生产方式的时候，最好是根据产科医生的建议，选择一种对自己与胎儿都有利的方式，避免不正规的操作危害到产妇与胎儿的生命安全。\r\n   意见仅供参考~:victory:', '218.75.123.171', 0, 0, 0, 0, -1, 0, 0, 0, 0, 0, 0),
(13, 29, 11, 1, 'wismartzy', 13, '春运不可怕~', 1326437597, '又一年冬去春来，中国又迎来了她每年一次、人类最大规模的周期性人口大迁徙——春运。中国之声的报道说，为期40天的2012年全国春运正式启动，预测客流量将达到31.58亿人次，再创历史新高，春运期间客流量相当于全国人口整体迁移两次。外媒习惯性地以惊奇的目光关注着这个他们难以理解的大迁徙和他们的国家无法完成的任务，惊叹这是“人类史上最大的地表迁移运动”。\r\n        面对这个大迁徙，媒体是如何报道的呢？一些媒体在提供各种春运服务信息的时候，也习惯性地在一种渲染个别极端案例中将春运“悲情化”——比如，报道那些因买不到票或觉得票价太高，而骑摩托车回家的农民工；报道那些排了两三个晚上也没有买到票的人；报道各种一票难求的抱怨、挤不上车的苦难、拥挤的痛苦、挨票贩子宰的不堪、回家路上的劳累等。媒体前几天一则“白领借道国外曲线回家”的报道（不过后来有媒体调查发现，消息不实），加上农民工致信铁道部抱怨“买票机会被网购剥夺”，更是将这种回家的悲情和苦难演绎到了新的高度。\r\n       买票当然很难，回家的路当然很挤，但“难”和“挤”却并不对应着悲情。负责任的媒体有必要向买票的长队和拥挤的列车，多传递一份理解和宽容。买票难必须面对，应该多一点点耐心；拥挤无法避免，应该多一点点平和。悲情的自我强化，只能传递焦虑不安。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(14, 24, 12, 1, 'wismartzy', 13, '孕妇手麻是怎么回事呢？', 1326437709, '孕妇手麻的问题常见于孕14周（即怀孕3个月）以后。所谓孕妇手麻，指的就是指孕妇在孕期间出现手麻的状况，这是相当常见的症状。那么孕妇手麻是怎么回事呢？出现孕妇手麻是什么原因所导致呢？孕妇手麻是病还是正常情况呢？\r\n      要解答孕妇手麻是怎么回事，其实并不难，倘若孕妇手麻发生在夜晚熟睡后醒来的时候，那么孕妇手麻的原因可能是睡觉时压到手了。因为孕妇怀孕2个月后，准妈妈的肚子就鼓起来了，妈妈睡觉时就会小心翼翼的，生长激素增高不免枕着手或者用手保护肚皮，这样都会容易压到手。\r\n要是孕妇处于孕晚期，并且孕妇还出现了水肿的情况，这个时候的孕妇手麻的原因是由于孕晚期孕妇水肿，血液淋巴液会渗出，会影响到手部的腕管，而腕管和手掌相通，腕管内压力增加压迫手部神经出现手麻的表现。这种原因导致的孕妇手麻也多出现在夜间熟睡后。\r\n       有的人会问，我也会出现孕妇手麻的状况，可是我没有到孕晚期，也没有出现水肿的情况呀，这是为什么呢？到底这样的孕妇手麻是怎么回事呢？\r\n不错，孕妇手麻的原因还有一点就是孕妇缺钙。孕早期、孕晚期、孕后期随着宝宝的骨骼发育，孕妇对钙的需求会越来越大。而孕妇日常从食物中摄取的钙是远远不够自身及宝宝生长的需求的。当孕妈妈体内的钙质不足的时候，孕妈妈就是启动身体骨骼钙，以供宝宝的需求。\r\n这个时候出现孕妇手麻就是由于准妈妈自身缺钙了，缺钙的表现就是手脚麻、腰酸背痛的状况，而且严重还会影响胎宝宝的骨骼发育。那么孕妇手麻缺钙怎么办呢？孕妇补钙也有讲究。给宝宝的一定要选最好的，目前市售口碑最好的孕妇补钙产品就是迪巧，妈妈们可别选错了。\r\n反馈总结：\r\n      在上面我们解释了孕妇手麻是怎么回事，希望通过这些各位准妈妈可以清楚了解到孕妇手麻这一问题。孕妇手麻出现之后，应该要区别对待手麻的原因，正确判断出现孕妇手麻是怎么回事，倘若确实是由于缺钙造成孕妇手麻的话，那么准妈妈们就需及早补钙了。', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(15, 6, 13, 1, 'xifeng666', 14, '女儿起名字', 1326442597, '女儿是2012年1月11号晚上21点半出生的,父亲姓易,求一好名字,万分感谢', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(16, 30, 1, 0, 'xifeng666', 14, '', 1326442657, ':) :handshake 恩恩 同感', '218.75.123.171', 0, 0, 0, 0, -1, 0, 0, 0, 0, 0, 0),
(17, 32, 14, 1, 'xifeng666', 14, '北方的孕妈妈，都吃什么水果呢', 1326443069, '真犯愁，没什么水果可以吃，现在只有苹果，橘子，橙子，葡萄都不新鲜，偶尔在吃点草莓，感觉没什么可吃的呢？你们都在吃什么？', '218.75.123.171', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(19, 11, 3, 0, '009', 20, '', 1329061864, 'zdxgdffg的个fgs', '125.120.154.98', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0),
(20, 31, 16, 1, '2727', 23, '测试', 1329063333, 'sdjafhasjdfasjasdf', '125.120.154.98', 0, 0, 0, 0, -1, -1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_profilefields`
--

CREATE TABLE IF NOT EXISTS `discuz_profilefields` (
  `fieldid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `invisible` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `size` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `displayorder` smallint(6) NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `unchangeable` tinyint(1) NOT NULL DEFAULT '0',
  `showinthread` tinyint(1) NOT NULL DEFAULT '0',
  `selective` tinyint(1) NOT NULL DEFAULT '0',
  `choices` text NOT NULL,
  PRIMARY KEY (`fieldid`),
  KEY `available` (`available`,`required`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_projects`
--

CREATE TABLE IF NOT EXISTS `discuz_projects` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `discuz_projects`
--

INSERT INTO `discuz_projects` (`id`, `name`, `type`, `description`, `value`) VALUES
(1, '技术性论坛', 'extcredit', '如果您不希望会员通过灌水、页面访问等方式得到积分，而是需要发布一些技术性的帖子获得积分。', 'a:4:{s:10:"savemethod";a:2:{i:0;s:1:"1";i:1;s:1:"2";}s:14:"creditsformula";s:49:"posts*0.5+digestposts*5+extcredits1*2+extcredits2";s:13:"creditspolicy";s:299:"a:12:{s:4:"post";a:0:{}s:5:"reply";a:0:{}s:6:"digest";a:1:{i:1;i:10;}s:10:"postattach";a:0:{}s:9:"getattach";a:0:{}s:2:"pm";a:0:{}s:6:"search";a:0:{}s:15:"promotion_visit";a:1:{i:3;i:2;}s:18:"promotion_register";a:1:{i:3;i:2;}s:13:"tradefinished";a:0:{}s:8:"votepoll";a:0:{}s:10:"lowerlimit";a:0:{}}";s:10:"extcredits";s:1444:"a:8:{i:1;a:8:{s:5:"title";s:4:"威望";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:2;a:8:{s:5:"title";s:4:"金钱";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:3;a:8:{s:5:"title";s:4:"贡献";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:4;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:5;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:6;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:7;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:8;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}}";}'),
(2, '娱乐性论坛', 'extcredit', '此类型论坛的会员可以通过发布一些评论、回复等获得积分，同时扩大论坛的访问量。更重要的是希望会员发布一些有价值的娱乐新闻等。', 'a:4:{s:10:"savemethod";a:2:{i:0;s:1:"1";i:1;s:1:"2";}s:14:"creditsformula";s:81:"posts+digestposts*5+oltime*5+pageviews/1000+extcredits1*2+extcredits2+extcredits3";s:13:"creditspolicy";s:315:"a:12:{s:4:"post";a:1:{i:1;i:1;}s:5:"reply";a:1:{i:2;i:1;}s:6:"digest";a:1:{i:1;i:10;}s:10:"postattach";a:0:{}s:9:"getattach";a:0:{}s:2:"pm";a:0:{}s:6:"search";a:0:{}s:15:"promotion_visit";a:1:{i:3;i:2;}s:18:"promotion_register";a:1:{i:3;i:2;}s:13:"tradefinished";a:0:{}s:8:"votepoll";a:0:{}s:10:"lowerlimit";a:0:{}}";s:10:"extcredits";s:1036:"a:8:{i:1;a:6:{s:5:"title";s:4:"威望";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;}i:2;a:6:{s:5:"title";s:4:"金钱";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;}i:3;a:6:{s:5:"title";s:4:"贡献";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;}i:4;a:6:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;}i:5;a:6:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;}i:6;a:6:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;}i:7;a:6:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;}i:8;a:6:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;}}";}'),
(3, '动漫、摄影类论坛', 'extcredit', '此类型论坛需要更多的图片附件发布给广大会员，因此增加一项扩展积分：魅力。', 'a:4:{s:10:"savemethod";a:2:{i:0;s:1:"1";i:1;s:1:"2";}s:14:"creditsformula";s:86:"posts+digestposts*2+pageviews/2000+extcredits1*2+extcredits2+extcredits3+extcredits4*3";s:13:"creditspolicy";s:324:"a:12:{s:4:"post";a:1:{i:2;i:1;}s:5:"reply";a:0:{}s:6:"digest";a:1:{i:1;i:10;}s:10:"postattach";a:1:{i:4;i:3;}s:9:"getattach";a:1:{i:2;i:-2;}s:2:"pm";a:0:{}s:6:"search";a:0:{}s:15:"promotion_visit";a:1:{i:3;i:2;}s:18:"promotion_register";a:1:{i:3;i:2;}s:13:"tradefinished";a:0:{}s:8:"votepoll";a:0:{}s:10:"lowerlimit";a:0:{}}";s:10:"extcredits";s:1454:"a:8:{i:1;a:8:{s:5:"title";s:4:"威望";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:2;a:8:{s:5:"title";s:4:"金钱";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:3;a:8:{s:5:"title";s:4:"贡献";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:4;a:8:{s:5:"title";s:4:"魅力";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:5;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:6;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:7;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:8;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}}";}'),
(4, '文章、小说类论坛', 'extcredit', '此类型的论坛更重视会员的原创文章或者是转发的文章，因此增加一项扩展积分：文采。', 'a:4:{s:10:"savemethod";a:2:{i:0;s:1:"1";i:1;s:1:"2";}s:14:"creditsformula";s:57:"posts+digestposts*8+extcredits2+extcredits3+extcredits4*2";s:13:"creditspolicy";s:307:"a:12:{s:4:"post";a:1:{i:2;i:1;}s:5:"reply";a:0:{}s:6:"digest";a:1:{i:4;i:10;}s:10:"postattach";a:0:{}s:9:"getattach";a:0:{}s:2:"pm";a:0:{}s:6:"search";a:0:{}s:15:"promotion_visit";a:1:{i:3;i:2;}s:18:"promotion_register";a:1:{i:3;i:2;}s:13:"tradefinished";a:0:{}s:8:"votepoll";a:0:{}s:10:"lowerlimit";a:0:{}}";s:10:"extcredits";s:1454:"a:8:{i:1;a:8:{s:5:"title";s:4:"威望";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:2;a:8:{s:5:"title";s:4:"金钱";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:3;a:8:{s:5:"title";s:4:"贡献";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:4;a:8:{s:5:"title";s:4:"文采";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:5;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:6;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:7;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:8;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}}";}'),
(5, '调研性论坛', 'extcredit', '此类型论坛更期望的是得到会员的建议和意见，主要是通过投票的方式体现会员的建议，因此增加一项积分策略为：参加投票，增加一项扩展积分为：积极性。', 'a:4:{s:10:"savemethod";a:2:{i:0;s:1:"1";i:1;s:1:"2";}s:14:"creditsformula";s:63:"posts*0.5+digestposts*2+extcredits1*2+extcredits3+extcredits4*2";s:13:"creditspolicy";s:306:"a:12:{s:4:"post";a:0:{}s:5:"reply";a:0:{}s:6:"digest";a:1:{i:1;i:8;}s:10:"postattach";a:0:{}s:9:"getattach";a:0:{}s:2:"pm";a:0:{}s:6:"search";a:0:{}s:15:"promotion_visit";a:1:{i:3;i:2;}s:18:"promotion_register";a:1:{i:3;i:2;}s:13:"tradefinished";a:0:{}s:8:"votepoll";a:1:{i:4;i:5;}s:10:"lowerlimit";a:0:{}}";s:10:"extcredits";s:1456:"a:8:{i:1;a:8:{s:5:"title";s:4:"威望";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:2;a:8:{s:5:"title";s:4:"金钱";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:3;a:8:{s:5:"title";s:4:"贡献";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:4;a:8:{s:5:"title";s:6:"积极性";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:5;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:6;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:7;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:8;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}}";}'),
(6, '贸易性论坛', 'extcredit', '此类型论坛更注重的是会员之间的交易，因此使用积分策略：交易成功，增加一项扩展积分：诚信度。', 'a:4:{s:10:"savemethod";a:2:{i:0;s:1:"1";i:1;s:1:"2";}s:14:"creditsformula";s:55:"posts+digestposts+extcredits1*2+extcredits3+extcredits4";s:13:"creditspolicy";s:306:"a:12:{s:4:"post";a:0:{}s:5:"reply";a:0:{}s:6:"digest";a:1:{i:1;i:5;}s:10:"postattach";a:0:{}s:9:"getattach";a:0:{}s:2:"pm";a:0:{}s:6:"search";a:0:{}s:15:"promotion_visit";a:1:{i:3;i:2;}s:18:"promotion_register";a:1:{i:3;i:2;}s:13:"tradefinished";a:1:{i:4;i:6;}s:8:"votepoll";a:0:{}s:10:"lowerlimit";a:0:{}}";s:10:"extcredits";s:1456:"a:8:{i:1;a:8:{s:5:"title";s:4:"威望";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:2;a:8:{s:5:"title";s:4:"金钱";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:3;a:8:{s:5:"title";s:4:"贡献";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:4;a:8:{s:5:"title";s:6:"诚信度";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";s:1:"1";s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:5;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:6;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:7;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}i:8;a:8:{s:5:"title";s:0:"";s:4:"unit";s:0:"";s:5:"ratio";i:0;s:9:"available";N;s:10:"lowerlimit";i:0;s:12:"showinthread";N;s:15:"allowexchangein";N;s:16:"allowexchangeout";N;}}";}'),
(7, '坛内事务类版块', 'forum', '该板块设置了不允许其他模块共享，以及设置了需要很高的权限才能浏览该版块。也适合于保密性高版块。', 'a:33:{s:7:"styleid";s:1:"0";s:12:"allowsmilies";s:1:"1";s:9:"allowhtml";s:1:"0";s:11:"allowbbcode";s:1:"1";s:12:"allowimgcode";s:1:"1";s:14:"allowanonymous";s:1:"0";s:10:"allowshare";s:1:"0";s:16:"allowpostspecial";s:1:"0";s:14:"alloweditrules";s:1:"1";s:10:"recyclebin";s:1:"1";s:11:"modnewposts";s:1:"0";s:6:"jammer";s:1:"0";s:16:"disablewatermark";s:1:"0";s:12:"inheritedmod";s:1:"0";s:9:"autoclose";s:1:"0";s:12:"forumcolumns";s:1:"0";s:12:"threadcaches";s:2:"40";s:16:"allowpaytoauthor";s:1:"0";s:13:"alloweditpost";s:1:"1";s:6:"simple";s:1:"0";s:11:"postcredits";s:0:"";s:12:"replycredits";s:0:"";s:16:"getattachcredits";s:0:"";s:17:"postattachcredits";s:0:"";s:13:"digestcredits";s:0:"";s:16:"attachextensions";s:0:"";s:11:"threadtypes";s:0:"";s:8:"viewperm";s:7:"	1	2	3	";s:8:"postperm";s:7:"	1	2	3	";s:9:"replyperm";s:7:"	1	2	3	";s:13:"getattachperm";s:7:"	1	2	3	";s:14:"postattachperm";s:7:"	1	2	3	";s:16:"supe_pushsetting";s:0:"";}'),
(8, '技术交流类版块', 'forum', '该设置开启了主题缓存系数。其他的权限设置级别较低。', 'a:33:{s:7:"styleid";s:1:"0";s:12:"allowsmilies";s:1:"1";s:9:"allowhtml";s:1:"0";s:11:"allowbbcode";s:1:"1";s:12:"allowimgcode";s:1:"1";s:14:"allowanonymous";s:1:"0";s:10:"allowshare";s:1:"1";s:16:"allowpostspecial";s:1:"5";s:14:"alloweditrules";s:1:"0";s:10:"recyclebin";s:1:"1";s:11:"modnewposts";s:1:"0";s:6:"jammer";s:1:"0";s:16:"disablewatermark";s:1:"0";s:12:"inheritedmod";s:1:"0";s:9:"autoclose";s:1:"0";s:12:"forumcolumns";s:1:"0";s:12:"threadcaches";s:2:"40";s:16:"allowpaytoauthor";s:1:"1";s:13:"alloweditpost";s:1:"1";s:6:"simple";s:1:"0";s:11:"postcredits";s:0:"";s:12:"replycredits";s:0:"";s:16:"getattachcredits";s:0:"";s:17:"postattachcredits";s:0:"";s:13:"digestcredits";s:0:"";s:16:"attachextensions";s:0:"";s:11:"threadtypes";s:0:"";s:8:"viewperm";s:0:"";s:8:"postperm";s:0:"";s:9:"replyperm";s:0:"";s:13:"getattachperm";s:0:"";s:14:"postattachperm";s:0:"";s:16:"supe_pushsetting";s:0:"";}'),
(9, '发布公告类版块', 'forum', '该设置开启了发帖审核，限制了允许发帖的用户组。', 'a:33:{s:7:"styleid";s:1:"0";s:12:"allowsmilies";s:1:"1";s:9:"allowhtml";s:1:"0";s:11:"allowbbcode";s:1:"1";s:12:"allowimgcode";s:1:"1";s:14:"allowanonymous";s:1:"0";s:10:"allowshare";s:1:"1";s:16:"allowpostspecial";s:1:"1";s:14:"alloweditrules";s:1:"0";s:10:"recyclebin";s:1:"1";s:11:"modnewposts";s:1:"1";s:6:"jammer";s:1:"1";s:16:"disablewatermark";s:1:"0";s:12:"inheritedmod";s:1:"0";s:9:"autoclose";s:1:"0";s:12:"forumcolumns";s:1:"0";s:12:"threadcaches";s:1:"0";s:16:"allowpaytoauthor";s:1:"1";s:13:"alloweditpost";s:1:"0";s:6:"simple";s:1:"0";s:11:"postcredits";s:0:"";s:12:"replycredits";s:0:"";s:16:"getattachcredits";s:0:"";s:17:"postattachcredits";s:0:"";s:13:"digestcredits";s:0:"";s:16:"attachextensions";s:0:"";s:11:"threadtypes";s:0:"";s:8:"viewperm";s:0:"";s:8:"postperm";s:7:"	1	2	3	";s:9:"replyperm";s:0:"";s:13:"getattachperm";s:0:"";s:14:"postattachperm";s:0:"";s:16:"supe_pushsetting";s:0:"";}'),
(10, '发起活动类版块', 'forum', '该类型设置里发起主题一个月之后会自动关闭主题。', 'a:33:{s:7:"styleid";s:1:"0";s:12:"allowsmilies";s:1:"1";s:9:"allowhtml";s:1:"0";s:11:"allowbbcode";s:1:"1";s:12:"allowimgcode";s:1:"1";s:14:"allowanonymous";s:1:"0";s:10:"allowshare";s:1:"1";s:16:"allowpostspecial";s:1:"9";s:14:"alloweditrules";s:1:"0";s:10:"recyclebin";s:1:"1";s:11:"modnewposts";s:1:"0";s:6:"jammer";s:1:"0";s:16:"disablewatermark";s:1:"0";s:12:"inheritedmod";s:1:"1";s:9:"autoclose";s:2:"30";s:12:"forumcolumns";s:1:"0";s:12:"threadcaches";s:2:"40";s:16:"allowpaytoauthor";s:1:"1";s:13:"alloweditpost";s:1:"1";s:6:"simple";s:1:"0";s:11:"postcredits";s:0:"";s:12:"replycredits";s:0:"";s:16:"getattachcredits";s:0:"";s:17:"postattachcredits";s:0:"";s:13:"digestcredits";s:0:"";s:16:"attachextensions";s:0:"";s:8:"viewperm";s:0:"";s:8:"postperm";s:22:"	1	2	3	11	12	13	14	15	";s:9:"replyperm";s:0:"";s:13:"getattachperm";s:0:"";s:14:"postattachperm";s:0:"";s:16:"supe_pushsetting";s:0:"";}'),
(11, '娱乐灌水类版块', 'forum', '该设置了主题缓存系数，开启了所有的特殊主题按钮。', 'a:33:{s:7:"styleid";s:1:"0";s:12:"allowsmilies";s:1:"1";s:9:"allowhtml";s:1:"0";s:11:"allowbbcode";s:1:"1";s:12:"allowimgcode";s:1:"1";s:14:"allowanonymous";s:1:"0";s:10:"allowshare";s:1:"1";s:16:"allowpostspecial";s:2:"15";s:14:"alloweditrules";s:1:"0";s:10:"recyclebin";s:1:"1";s:11:"modnewposts";s:1:"0";s:6:"jammer";s:1:"0";s:16:"disablewatermark";s:1:"0";s:12:"inheritedmod";s:1:"0";s:9:"autoclose";s:1:"0";s:12:"forumcolumns";s:1:"0";s:12:"threadcaches";s:2:"40";s:16:"allowpaytoauthor";s:1:"1";s:13:"alloweditpost";s:1:"1";s:6:"simple";s:1:"0";s:11:"postcredits";s:0:"";s:12:"replycredits";s:0:"";s:16:"getattachcredits";s:0:"";s:17:"postattachcredits";s:0:"";s:13:"digestcredits";s:0:"";s:16:"attachextensions";s:0:"";s:11:"threadtypes";s:0:"";s:8:"viewperm";s:0:"";s:8:"postperm";s:0:"";s:9:"replyperm";s:0:"";s:13:"getattachperm";s:0:"";s:14:"postattachperm";s:0:"";s:16:"supe_pushsetting";s:0:"";}');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_promotions`
--

CREATE TABLE IF NOT EXISTS `discuz_promotions` (
  `ip` char(15) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_ranks`
--

CREATE TABLE IF NOT EXISTS `discuz_ranks` (
  `rankid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `ranktitle` varchar(30) NOT NULL DEFAULT '',
  `postshigher` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `stars` tinyint(3) NOT NULL DEFAULT '0',
  `color` varchar(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`rankid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `discuz_ranks`
--

INSERT INTO `discuz_ranks` (`rankid`, `ranktitle`, `postshigher`, `stars`, `color`) VALUES
(1, '新生入学', 0, 1, ''),
(2, '小试牛刀', 50, 2, ''),
(3, '实习记者', 300, 5, ''),
(4, '自由撰稿人', 1000, 4, ''),
(5, '特聘作家', 3000, 5, '');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_ratelog`
--

CREATE TABLE IF NOT EXISTS `discuz_ratelog` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(15) NOT NULL DEFAULT '',
  `extcredits` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `score` smallint(6) NOT NULL DEFAULT '0',
  `reason` char(40) NOT NULL DEFAULT '',
  KEY `pid` (`pid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_regips`
--

CREATE TABLE IF NOT EXISTS `discuz_regips` (
  `ip` char(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `count` smallint(6) NOT NULL DEFAULT '0',
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_relatedthreads`
--

CREATE TABLE IF NOT EXISTS `discuz_relatedthreads` (
  `tid` mediumint(8) NOT NULL DEFAULT '0',
  `type` enum('general','trade') NOT NULL DEFAULT 'general',
  `expiration` int(10) NOT NULL DEFAULT '0',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `relatedthreads` text NOT NULL,
  PRIMARY KEY (`tid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_rewardlog`
--

CREATE TABLE IF NOT EXISTS `discuz_rewardlog` (
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `answererid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  `netamount` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `userid` (`authorid`,`answererid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_rsscaches`
--

CREATE TABLE IF NOT EXISTS `discuz_rsscaches` (
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `forum` char(50) NOT NULL DEFAULT '',
  `author` char(15) NOT NULL DEFAULT '',
  `subject` char(80) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  UNIQUE KEY `tid` (`tid`),
  KEY `fid` (`fid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_searchindex`
--

CREATE TABLE IF NOT EXISTS `discuz_searchindex` (
  `searchid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `searchstring` text NOT NULL,
  `useip` varchar(15) NOT NULL DEFAULT '',
  `uid` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `threadtypeid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `threads` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tids` text NOT NULL,
  PRIMARY KEY (`searchid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_sessions`
--

CREATE TABLE IF NOT EXISTS `discuz_sessions` (
  `sid` char(6) NOT NULL DEFAULT '',
  `ip1` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip2` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip3` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip4` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(15) NOT NULL DEFAULT '',
  `groupid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `styleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `invisible` tinyint(1) NOT NULL DEFAULT '0',
  `action` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  `lastolupdate` int(10) unsigned NOT NULL DEFAULT '0',
  `pageviews` smallint(6) unsigned NOT NULL DEFAULT '0',
  `seccode` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `bloguid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sid` (`sid`),
  KEY `uid` (`uid`),
  KEY `bloguid` (`bloguid`)
) ENGINE=MEMORY DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_settings`
--

CREATE TABLE IF NOT EXISTS `discuz_settings` (
  `variable` varchar(32) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_settings`
--

INSERT INTO `discuz_settings` (`variable`, `value`) VALUES
('accessemail', ''),
('adminipaccess', ''),
('allowcsscache', '1'),
('archiverstatus', '1'),
('attachbanperiods', ''),
('attachimgpost', '1'),
('attachrefcheck', '0'),
('attachsave', '3'),
('authkey', '437ae0XEXifqb5NU'),
('bannedmessages', '1'),
('bbclosed', '0'),
('bbinsert', '1'),
('bbname', '禧妈拉伢俱乐部会员社区'),
('bbrules', '0'),
('bbrulestxt', ''),
('bdaystatus', '0'),
('boardlicensed', '0'),
('censoremail', ''),
('censoruser', ''),
('closedreason', ''),
('creditsformula', 'extcredits1'),
('creditsformulaexp', ''),
('creditsnotify', ''),
('creditspolicy', 'a:7:{s:4:"post";a:0:{}s:5:"reply";a:0:{}s:6:"digest";a:1:{i:1;i:10;}s:10:"postattach";a:0:{}s:9:"getattach";a:0:{}s:2:"pm";a:0:{}s:6:"search";a:0:{}}'),
('creditstax', '0.2'),
('creditstrans', '2'),
('custombackup', ''),
('dateformat', 'Y-n-j'),
('debug', '1'),
('delayviewcount', '0'),
('deletereason', ''),
('doublee', '1'),
('dupkarmarate', '0'),
('ec_account', ''),
('ec_maxcredits', '1000'),
('ec_maxcreditspermonth', '0'),
('ec_mincredits', '0'),
('ec_ratio', '0'),
('editedby', '1'),
('editoroptions', '1'),
('edittimelimit', ''),
('exchangemincredits', '100'),
('extcredits', 'a:2:{i:1;a:3:{s:5:"title";s:4:"威望";s:12:"showinthread";s:0:"";s:9:"available";i:1;}i:2;a:3:{s:5:"title";s:4:"金钱";s:12:"showinthread";s:0:"";s:9:"available";i:1;}}'),
('fastpost', '1'),
('floodctrl', '15'),
('forumjump', '0'),
('globalstick', '1'),
('gzipcompress', '0'),
('hideprivate', '1'),
('hottopic', '10'),
('icp', ''),
('initcredits', '0,0,0,0,0,0,0,0,0'),
('ipaccess', ''),
('ipregctrl', ''),
('jscachelife', '1800'),
('jsmenustatus', '15'),
('jsrefdomains', ''),
('jsstatus', '0'),
('karmaratelimit', '0'),
('loadctrl', '0'),
('losslessdel', '365'),
('maxavatarpixel', '120'),
('maxavatarsize', '20000'),
('maxbdays', '0'),
('maxchargespan', '0'),
('maxfavorites', '100'),
('maxincperthread', '0'),
('maxmodworksmonths', '3'),
('maxonlinelist', '0'),
('maxonlines', '5000'),
('maxpolloptions', '10'),
('maxpostsize', '10000'),
('maxsearchresults', '500'),
('maxsigrows', '100'),
('maxsmilies', '10'),
('maxspm', '0'),
('maxsubscriptions', '100'),
('backupdir', 'b8bcb3'),
('membermaxpages', '100'),
('memberperpage', '25'),
('memliststatus', '1'),
('minpostsize', '10'),
('moddisplay', 'flat'),
('modratelimit', '0'),
('modreasons', '广告/SPAM\r\n恶意灌水\r\n违规内容\r\n文不对题\r\n重复发帖\r\n\r\n我很赞同\r\n精品文章\r\n原创内容'),
('modworkstatus', '0'),
('myrecorddays', '30'),
('newbiespan', '0'),
('newsletter', ''),
('nocacheheaders', '0'),
('oltimespan', '10'),
('onlinerecord', '11	1328175201'),
('passport_expire', '3600'),
('passport_extcredits', '0'),
('passport_key', '1234567890'),
('passport_login_url', 'index.php?controller=simple&action=login'),
('passport_logout_url', 'index.php?controller=simple&action=logout'),
('passport_register_url', 'index.php?controller=simple&action=reg'),
('passport_status', 'passport'),
('passport_url', '/'),
('postbanperiods', ''),
('postmodperiods', ''),
('postperpage', '10'),
('pvfrequence', '60'),
('qihoo', 'a:9:{s:6:"status";i:0;s:9:"searchbox";i:6;s:7:"summary";i:1;s:6:"jammer";i:1;s:9:"maxtopics";i:10;s:8:"keywords";s:0:"";s:10:"adminemail";s:0:"";s:8:"validity";i:1;s:14:"relatedthreads";a:6:{s:6:"bbsnum";i:0;s:6:"webnum";i:0;s:4:"type";a:3:{s:4:"blog";s:4:"blog";s:4:"news";s:4:"news";s:3:"bbs";s:3:"bbs";}s:6:"banurl";s:0:"";s:8:"position";i:1;s:8:"validity";i:1;}}'),
('ratelogrecord', '5'),
('regadvance', '0'),
('regctrl', '0'),
('regfloodctrl', '0'),
('regstatus', '1'),
('regverify', '0'),
('reportpost', '1'),
('rewritestatus', '0'),
('rssstatus', '1'),
('rssttl', '60'),
('searchbanperiods', ''),
('searchctrl', '30'),
('seccodestatus', '0'),
('seodescription', ''),
('seohead', ''),
('seokeywords', ''),
('seotitle', ''),
('showemail', ''),
('showimages', '1'),
('showsettings', '7'),
('sitename', '禧妈拉伢俱乐部'),
('siteurl', 'http://www.xylaclub.com'),
('smcols', '4'),
('smileyinsert', '1'),
('starthreshold', '2'),
('statscachelife', '180'),
('statstatus', ''),
('styleid', '4'),
('stylejump', '1'),
('subforumsindex', '0'),
('supe_siteurl', ''),
('supe_sitename', ''),
('supe_status', '0'),
('supe_tablepre', ''),
('threadmaxpages', '1000'),
('threadsticky', '全局置顶,分类置顶,本版置顶'),
('timeformat', 'H:i'),
('timeoffset', '8'),
('topicperpage', '20'),
('transfermincredits', '1000'),
('transsidstatus', '0'),
('userstatusby', '1'),
('visitbanperiods', ''),
('visitedforums', '10'),
('vtonlinestatus', '1'),
('wapcharset', '2'),
('wapdateformat', 'n/j'),
('wapmps', '500'),
('wapppp', '5'),
('wapstatus', '1'),
('waptpp', '10'),
('watermarkquality', '80'),
('watermarkstatus', '0'),
('watermarktrans', '65'),
('welcomemsg', ''),
('welcomemsgtxt', '尊敬的{username}，您已经注册成为{sitename}的会员，请您在发表言论时，遵守当地法律法规。\r\n如果您有什么疑问可以联系管理员，Email: {adminemail}。\r\n\r\n\r\n{bbname}\r\n{time}'),
('whosonlinestatus', '1'),
('indexname', 'index.php'),
('spacedata', 'a:11:{s:9:"cachelife";s:3:"900";s:14:"limitmythreads";s:1:"5";s:14:"limitmyreplies";s:1:"5";s:14:"limitmyrewards";s:1:"5";s:13:"limitmytrades";s:1:"5";s:13:"limitmyvideos";s:1:"0";s:12:"limitmyblogs";s:1:"8";s:14:"limitmyfriends";s:1:"0";s:16:"limitmyfavforums";s:1:"5";s:17:"limitmyfavthreads";s:1:"0";s:10:"textlength";s:3:"300";}'),
('thumbstatus', '0'),
('thumbwidth', '400'),
('thumbheight', '300'),
('forumlinkstatus', '0'),
('pluginjsmenu', '插件'),
('magicstatus', '1'),
('magicmarket', '1'),
('maxmagicprice', '50'),
('upgradeurl', 'http://localhost/develop/dzhead/develop/upgrade.php'),
('ftp', 'a:10:{s:2:"on";s:1:"0";s:3:"ssl";s:1:"0";s:4:"host";s:0:"";s:4:"port";s:2:"21";s:8:"username";s:0:"";s:8:"password";s:0:"";s:9:"attachdir";s:1:".";s:9:"attachurl";s:0:"";s:7:"hideurl";s:1:"0";s:7:"timeout";s:1:"0";}'),
('wapregister', '0'),
('jswizard', ''),
('passport_shopex', '0'),
('seccodeanimator', '1'),
('welcomemsgtitle', '{username}，您好，感谢您的注册，请阅读以下内容。'),
('cacheindexlife', '0'),
('cachethreadlife', '0'),
('cachethreaddir', 'forumdata/threadcaches'),
('jsdateformat', ''),
('seccodedata', 'a:13:{s:8:"minposts";s:0:"";s:16:"loginfailedcount";i:0;s:5:"width";i:150;s:6:"height";i:60;s:4:"type";s:1:"0";s:10:"background";s:1:"1";s:10:"adulterate";s:1:"1";s:3:"ttf";s:1:"0";s:5:"angle";s:1:"0";s:5:"color";s:1:"1";s:4:"size";s:1:"0";s:6:"shadow";s:1:"1";s:8:"animator";s:1:"0";}'),
('frameon', '0'),
('framewidth', '180'),
('smrows', '4'),
('watermarktype', '0'),
('secqaa', 'a:2:{s:8:"minposts";s:1:"1";s:6:"status";i:0;}'),
('supe_circlestatus', '0'),
('spacestatus', '1'),
('whosonline_contract', '0'),
('attachdir', './attachments'),
('attachurl', 'attachments'),
('onlinehold', '15'),
('msgforward', 'a:3:{s:11:"refreshtime";i:3;s:5:"quick";i:1;s:8:"messages";a:13:{i:0;s:19:"thread_poll_succeed";i:1;s:19:"thread_rate_succeed";i:2;s:23:"usergroups_join_succeed";i:3;s:23:"usergroups_exit_succeed";i:4;s:25:"usergroups_update_succeed";i:5;s:20:"buddy_update_succeed";i:6;s:17:"post_edit_succeed";i:7;s:18:"post_reply_succeed";i:8;s:24:"post_edit_delete_succeed";i:9;s:22:"post_newthread_succeed";i:10;s:13:"admin_succeed";i:11;s:17:"pm_delete_succeed";i:12;s:15:"search_redirect";}}'),
('smthumb', '20'),
('tagstatus', '1'),
('hottags', '20'),
('viewthreadtags', '100'),
('rewritecompatible', ''),
('imagelib', '0'),
('imageimpath', ''),
('regname', 'register.php'),
('reglinkname', '注册'),
('activitytype', '朋友聚会\r\n出外郊游\r\n自驾出行\r\n公益活动\r\n线上活动'),
('userdateformat', 'Y-n-j\r\nY/n/j\r\nj-n-Y\r\nj/n/Y'),
('tradetypes', ''),
('tradeimagewidth', '200'),
('tradeimageheight', '150'),
('customauthorinfo', 'a:1:{i:0;a:9:{s:3:"uid";a:1:{s:4:"menu";s:1:"1";}s:5:"posts";a:1:{s:4:"menu";s:1:"1";}s:6:"digest";a:1:{s:4:"menu";s:1:"1";}s:7:"credits";a:1:{s:4:"menu";s:1:"1";}s:8:"readperm";a:1:{s:4:"menu";s:1:"1";}s:8:"location";a:1:{s:4:"menu";s:1:"1";}s:6:"oltime";a:1:{s:4:"menu";s:1:"1";}s:7:"regtime";a:1:{s:4:"menu";s:1:"1";}s:8:"lastdate";a:1:{s:4:"menu";s:1:"1";}}}'),
('ec_credit', 'a:2:{s:18:"maxcreditspermonth";i:6;s:4:"rank";a:15:{i:1;i:4;i:2;i:11;i:3;i:41;i:4;i:91;i:5;i:151;i:6;i:251;i:7;i:501;i:8;i:1001;i:9;i:2001;i:10;i:5001;i:11;i:10001;i:12;i:20001;i:13;i:50001;i:14;i:100001;i:15;i:200001;}}'),
('mail', 'a:10:{s:8:"mailsend";s:1:"1";s:6:"server";s:13:"smtp.21cn.com";s:4:"port";s:2:"25";s:4:"auth";s:1:"1";s:4:"from";s:26:"Discuz <username@21cn.com>";s:13:"auth_username";s:17:"username@21cn.com";s:13:"auth_password";s:8:"password";s:13:"maildelimiter";s:1:"0";s:12:"mailusername";s:1:"1";s:15:"sendmail_silent";s:1:"1";}'),
('watermarktext', ''),
('watermarkminwidth', '0'),
('watermarkminheight', '0'),
('inviteconfig', ''),
('historyposts', '0	18'),
('zoomstatus', '1'),
('postno', '#'),
('postnocustom', 'a:1:{i:0;s:0:"";}'),
('maxbiotradesize', '400'),
('insenz', ''),
('videoinfo', 'a:12:{s:4:"open";i:0;s:5:"vtype";s:24:"新闻	军事	音乐	影视	动漫";s:6:"bbname";s:0:"";s:3:"url";s:0:"";s:5:"email";s:0:"";s:4:"logo";s:0:"";s:8:"sitetype";s:179:"新闻	军事	音乐	影视	动漫	游戏	美女	娱乐	交友	教育	艺术	学术	技术	动物	旅游	生活	时尚	电脑	汽车	手机	摄影	戏曲	外语	公益	校园	数码	电脑	历史	天文	地理	财经	地区	人物	体育	健康	综合";s:7:"vsiteid";s:0:"";s:9:"vpassword";s:0:"";s:4:"vkey";s:0:"";s:8:"vclasses";a:22:{i:22;s:4:"新闻";i:15;s:4:"体育";i:27;s:4:"教育";i:28;s:4:"明星";i:26;s:4:"美色";i:1;s:4:"搞笑";i:29;s:4:"另类";i:18;s:4:"影视";i:12;s:4:"音乐";i:8;s:4:"动漫";i:7;s:4:"游戏";i:24;s:4:"综艺";i:11;s:4:"广告";i:19;s:4:"艺术";i:5;s:4:"时尚";i:21;s:4:"居家";i:23;s:4:"旅游";i:25;s:4:"动物";i:14;s:4:"汽车";i:30;s:4:"军事";i:16;s:4:"科技";i:31;s:4:"其它";}s:12:"vclassesable";a:22:{i:0;i:22;i:1;i:15;i:2;i:27;i:3;i:28;i:4;i:26;i:5;i:1;i:6;i:29;i:7;i:18;i:8;i:12;i:9;i:8;i:10;i:7;i:11;i:24;i:12;i:11;i:13;i:19;i:14;i:5;i:15;i:21;i:16;i:23;i:17;i:25;i:18;i:14;i:19;i:30;i:20;i:16;i:21;i:31;}}'),
('google', ''),
('baidusitemap', '1'),
('baidusitemap_life', '12'),
('siteuniqueid', 'LMFI9Idb34qjFTNm');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_smilies`
--

CREATE TABLE IF NOT EXISTS `discuz_smilies` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` smallint(6) unsigned NOT NULL,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `type` enum('smiley','icon') NOT NULL DEFAULT 'smiley',
  `code` varchar(30) NOT NULL DEFAULT '',
  `url` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `discuz_smilies`
--

INSERT INTO `discuz_smilies` (`id`, `typeid`, `displayorder`, `type`, `code`, `url`) VALUES
(1, 1, 0, 'smiley', ':)', 'smile.gif'),
(2, 1, 0, 'smiley', ':(', 'sad.gif'),
(3, 1, 0, 'smiley', ':D', 'biggrin.gif'),
(4, 1, 0, 'smiley', ':''(', 'cry.gif'),
(5, 1, 0, 'smiley', ':@', 'huffy.gif'),
(6, 1, 0, 'smiley', ':o', 'shocked.gif'),
(7, 1, 0, 'smiley', ':P', 'tongue.gif'),
(8, 1, 0, 'smiley', ':$', 'shy.gif'),
(9, 1, 0, 'smiley', ';P', 'titter.gif'),
(10, 1, 0, 'smiley', ':L', 'sweat.gif'),
(11, 1, 0, 'smiley', ':Q', 'mad.gif'),
(12, 1, 0, 'smiley', ':lol', 'lol.gif'),
(13, 1, 0, 'smiley', ':hug:', 'hug.gif'),
(14, 1, 0, 'smiley', ':victory:', 'victory.gif'),
(15, 1, 0, 'smiley', ':time:', 'time.gif'),
(16, 1, 0, 'smiley', ':kiss:', 'kiss.gif'),
(17, 1, 0, 'smiley', ':handshake', 'handshake.gif'),
(18, 1, 0, 'smiley', ':call:', 'call.gif'),
(19, 0, 0, 'icon', '', 'icon1.gif'),
(20, 0, 0, 'icon', '', 'icon2.gif'),
(21, 0, 0, 'icon', '', 'icon3.gif'),
(22, 0, 0, 'icon', '', 'icon4.gif'),
(23, 0, 0, 'icon', '', 'icon5.gif'),
(24, 0, 0, 'icon', '', 'icon6.gif'),
(25, 0, 0, 'icon', '', 'icon7.gif'),
(26, 0, 0, 'icon', '', 'icon8.gif'),
(27, 0, 0, 'icon', '', 'icon9.gif'),
(28, 1, 0, 'smiley', ':loveliness:', 'loveliness.gif'),
(29, 1, 0, 'smiley', ':funk:', 'funk.gif');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_spacecaches`
--

CREATE TABLE IF NOT EXISTS `discuz_spacecaches` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `variable` varchar(20) NOT NULL,
  `value` text NOT NULL,
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_spacecaches`
--

INSERT INTO `discuz_spacecaches` (`uid`, `variable`, `value`, `expiration`) VALUES
(12, 'mythreads', 'a:0:{}', 1331291123),
(12, 'myreplies', 'a:0:{}', 1331291123),
(12, 'myfavforums', 'a:0:{}', 1331291123),
(12, 'myblogs', 'a:0:{}', 1331291123),
(6, 'mythreads', 'a:0:{}', 1331323811),
(6, 'myreplies', 'a:0:{}', 1331323811),
(6, 'myfavforums', 'a:0:{}', 1331323811),
(6, 'myblogs', 'a:0:{}', 1331323811),
(14, 'mythreads', 'a:0:{}', 1331249973),
(14, 'myreplies', 'a:0:{}', 1331249973),
(14, 'myfavforums', 'a:0:{}', 1331249973),
(14, 'myblogs', 'a:0:{}', 1331249973),
(11, 'mythreads', 'a:0:{}', 1331451020),
(11, 'myreplies', 'a:0:{}', 1331451020),
(11, 'myfavforums', 'a:0:{}', 1331451020),
(11, 'myblogs', 'a:0:{}', 1331451020),
(13, 'mythreads', 'a:0:{}', 1330841149),
(13, 'hotblog', 'a:0:{}', 1331300226),
(13, 'lastpostblog', 'a:0:{}', 1331300226),
(8, 'mythreads', 'a:0:{}', 1331324359),
(8, 'myreplies', 'a:0:{}', 1331324359),
(8, 'myfavforums', 'a:0:{}', 1331324359),
(8, 'myblogs', 'a:0:{}', 1331324359),
(13, 'myreplies', 'a:0:{}', 1330841149),
(13, 'myfavforums', 'a:0:{}', 1330841149),
(13, 'myblogs', 'a:0:{}', 1330841149),
(1, 'myreplies', 'a:0:{}', 1331324391),
(1, 'myfavforums', 'a:0:{}', 1331324391),
(1, 'myblogs', 'a:0:{}', 1331324391),
(1, 'hotblog', 'a:0:{}', 1331496801),
(1, 'lastpostblog', 'a:0:{}', 1331496801),
(6, 'hotblog', 'a:0:{}', 1331328514),
(6, 'lastpostblog', 'a:0:{}', 1331328514),
(14, 'hotblog', 'a:0:{}', 1331293129),
(14, 'lastpostblog', 'a:0:{}', 1331293129),
(1, 'mythreads', 'a:0:{}', 1331324391),
(10, 'hotblog', 'a:0:{}', 1331536339),
(10, 'lastpostblog', 'a:0:{}', 1331536339),
(12, 'hotblog', 'a:0:{}', 1331293577),
(12, 'lastpostblog', 'a:0:{}', 1331293577),
(18, 'mythreads', 'a:0:{}', 1329403319),
(18, 'myreplies', 'a:0:{}', 1329403319),
(18, 'myfavforums', 'a:0:{}', 1329403319),
(18, 'myblogs', 'a:0:{}', 1329403319),
(10, 'mythreads', 'a:0:{}', 1330849017),
(10, 'myreplies', 'a:0:{}', 1330849017),
(10, 'myfavforums', 'a:0:{}', 1330849017),
(10, 'myblogs', 'a:0:{}', 1330849017),
(19, 'mythreads', 'a:0:{}', 1328802954),
(19, 'myreplies', 'a:0:{}', 1328802954),
(19, 'myfavforums', 'a:0:{}', 1328802954),
(19, 'myblogs', 'a:0:{}', 1328802954),
(20, 'mythreads', 'a:0:{}', 1328802859),
(20, 'myreplies', 'a:0:{}', 1328802859),
(20, 'myfavforums', 'a:0:{}', 1328802859),
(20, 'myblogs', 'a:0:{}', 1328802859),
(22, 'mythreads', 'a:0:{}', 1331294082),
(22, 'myreplies', 'a:0:{}', 1331294082),
(22, 'myfavforums', 'a:0:{}', 1331294082),
(22, 'myblogs', 'a:0:{}', 1331294082),
(8, 'hotblog', 'a:0:{}', 1331326644),
(8, 'lastpostblog', 'a:0:{}', 1331326644),
(9, 'mythreads', 'a:0:{}', 1331496079),
(9, 'myreplies', 'a:0:{}', 1331496079),
(9, 'myfavforums', 'a:0:{}', 1331496079),
(9, 'myblogs', 'a:0:{}', 1331496079),
(9, 'hotblog', 'a:0:{}', 1331493856),
(9, 'lastpostblog', 'a:0:{}', 1331493856),
(17, 'mythreads', 'a:0:{}', 1331450537),
(17, 'myreplies', 'a:0:{}', 1331450537),
(17, 'myfavforums', 'a:0:{}', 1331450537),
(17, 'myblogs', 'a:0:{}', 1331450537),
(17, 'hotblog', 'a:0:{}', 1331450491),
(17, 'lastpostblog', 'a:0:{}', 1331450491),
(11, 'hotblog', 'a:0:{}', 1331524554),
(11, 'lastpostblog', 'a:0:{}', 1331524554),
(19, 'hotblog', 'a:0:{}', 1329685012),
(19, 'lastpostblog', 'a:0:{}', 1329685012),
(18, 'hotblog', 'a:0:{}', 1331528278),
(18, 'lastpostblog', 'a:0:{}', 1331528278),
(16, 'mythreads', 'a:0:{}', 1331580980),
(16, 'myreplies', 'a:0:{}', 1331580980),
(16, 'myfavforums', 'a:0:{}', 1331580980),
(16, 'myblogs', 'a:0:{}', 1331580980),
(16, 'hotblog', 'a:0:{}', 1331494329),
(16, 'lastpostblog', 'a:0:{}', 1331494329),
(22, 'hotblog', 'a:0:{}', 1331335879),
(22, 'lastpostblog', 'a:0:{}', 1331335879),
(20, 'hotblog', 'a:0:{}', 1329684837),
(20, 'lastpostblog', 'a:0:{}', 1329684837),
(4, 'mythreads', 'a:0:{}', 1329403076),
(4, 'myreplies', 'a:0:{}', 1329403076),
(4, 'myfavforums', 'a:0:{}', 1329403076),
(4, 'myblogs', 'a:0:{}', 1329403076),
(4, 'hotblog', 'a:0:{}', 1331527336),
(4, 'lastpostblog', 'a:0:{}', 1331527336),
(2, 'mythreads', 'a:0:{}', 1329444799),
(2, 'myreplies', 'a:0:{}', 1329444799),
(2, 'myfavforums', 'a:0:{}', 1329444799),
(2, 'myblogs', 'a:0:{}', 1329444799),
(2, 'hotblog', 'a:0:{}', 1331581017),
(2, 'lastpostblog', 'a:0:{}', 1331581017),
(5, 'mythreads', 'a:0:{}', 1329444819),
(5, 'myreplies', 'a:0:{}', 1329444819),
(5, 'myfavforums', 'a:0:{}', 1329444819),
(5, 'myblogs', 'a:0:{}', 1329444819),
(5, 'hotblog', 'a:0:{}', 1331598371),
(5, 'lastpostblog', 'a:0:{}', 1331598371),
(3, 'mythreads', 'a:0:{}', 1329684978),
(3, 'myreplies', 'a:0:{}', 1329684978),
(3, 'myfavforums', 'a:0:{}', 1329684978),
(3, 'myblogs', 'a:0:{}', 1329684978),
(3, 'hotblog', 'a:0:{}', 1329684893),
(3, 'lastpostblog', 'a:0:{}', 1329684893),
(15, 'mythreads', 'a:0:{}', 1330887946),
(15, 'myreplies', 'a:0:{}', 1330887946),
(15, 'myfavforums', 'a:0:{}', 1330887946),
(15, 'myblogs', 'a:0:{}', 1330887946),
(15, 'hotblog', 'a:0:{}', 1330886236),
(15, 'lastpostblog', 'a:0:{}', 1330886236),
(7, 'mythreads', 'a:0:{}', 1330940193),
(7, 'myreplies', 'a:0:{}', 1330940193),
(7, 'myfavforums', 'a:0:{}', 1330940193),
(7, 'myblogs', 'a:0:{}', 1330940193),
(7, 'hotblog', 'a:0:{}', 1330940358),
(7, 'lastpostblog', 'a:0:{}', 1330940358),
(26, 'mythreads', 'a:0:{}', 1329135849),
(26, 'myreplies', 'a:0:{}', 1329135849),
(26, 'myfavforums', 'a:0:{}', 1329135849),
(26, 'myblogs', 'a:0:{}', 1329135849),
(23, 'mythreads', 'a:1:{i:0;a:14:{s:3:"tid";s:2:"16";s:7:"subject";s:4:"测试";s:7:"special";s:1:"0";s:5:"price";s:1:"0";s:3:"fid";s:2:"31";s:5:"views";s:1:"3";s:7:"replies";s:1:"0";s:6:"author";s:4:"2727";s:8:"authorid";s:2:"23";s:8:"lastpost";s:10:"1329063333";s:10:"lastposter";s:4:"2727";s:10:"attachment";s:1:"0";s:3:"pid";s:2:"20";s:7:"message";s:18:"sdjafhasjdfasjasdf";}}', 1329889023),
(23, 'myreplies', 'a:0:{}', 1329889023),
(23, 'myfavforums', 'a:0:{}', 1329889023),
(23, 'myblogs', 'a:0:{}', 1329889023),
(25, 'mythreads', 'a:0:{}', 1329777635),
(25, 'myreplies', 'a:0:{}', 1329777635),
(25, 'myfavforums', 'a:0:{}', 1329777635),
(25, 'myblogs', 'a:0:{}', 1329777635),
(24, 'mythreads', 'a:0:{}', 1329776909),
(24, 'myreplies', 'a:0:{}', 1329776909),
(24, 'myfavforums', 'a:0:{}', 1329776909),
(24, 'myblogs', 'a:0:{}', 1329776909),
(21, 'mythreads', 'a:0:{}', 1329777477),
(21, 'myreplies', 'a:0:{}', 1329777477),
(21, 'myfavforums', 'a:0:{}', 1329777477),
(21, 'myblogs', 'a:0:{}', 1329777477);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_stats`
--

CREATE TABLE IF NOT EXISTS `discuz_stats` (
  `type` char(10) NOT NULL DEFAULT '',
  `variable` char(10) NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`type`,`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_stats`
--

INSERT INTO `discuz_stats` (`type`, `variable`, `count`) VALUES
('total', 'hits', 1),
('total', 'members', 0),
('total', 'guests', 1),
('os', 'Windows', 1),
('os', 'Mac', 0),
('os', 'Linux', 0),
('os', 'FreeBSD', 0),
('os', 'SunOS', 0),
('os', 'OS/2', 0),
('os', 'AIX', 0),
('os', 'Spiders', 0),
('os', 'Other', 0),
('browser', 'MSIE', 1),
('browser', 'Netscape', 0),
('browser', 'Mozilla', 0),
('browser', 'Lynx', 0),
('browser', 'Opera', 0),
('browser', 'Konqueror', 0),
('browser', 'Other', 0),
('week', '0', 0),
('week', '1', 1),
('week', '2', 0),
('week', '3', 0),
('week', '4', 0),
('week', '5', 0),
('week', '6', 0),
('hour', '00', 0),
('hour', '01', 0),
('hour', '02', 0),
('hour', '03', 0),
('hour', '04', 0),
('hour', '05', 0),
('hour', '06', 0),
('hour', '07', 0),
('hour', '08', 0),
('hour', '09', 0),
('hour', '10', 1),
('hour', '11', 0),
('hour', '12', 0),
('hour', '13', 0),
('hour', '14', 0),
('hour', '15', 0),
('hour', '16', 0),
('hour', '17', 0),
('hour', '18', 0),
('hour', '19', 0),
('hour', '20', 0),
('hour', '21', 0),
('hour', '22', 0),
('hour', '23', 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_statvars`
--

CREATE TABLE IF NOT EXISTS `discuz_statvars` (
  `type` varchar(20) NOT NULL DEFAULT '',
  `variable` varchar(20) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`type`,`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `discuz_statvars`
--

INSERT INTO `discuz_statvars` (`type`, `variable`, `value`) VALUES
('monthposts', 'starttime', '2011-12-01'),
('dayposts', '20120221', '0'),
('dayposts', '20120220', '0'),
('dayposts', '20120219', '0'),
('dayposts', '20120218', '0'),
('dayposts', '20120217', '0'),
('dayposts', '20120216', '0'),
('dayposts', '20120215', '0'),
('dayposts', '20120214', '0'),
('dayposts', '20120213', '1'),
('dayposts', '20120212', '1'),
('dayposts', '20120211', '0'),
('dayposts', '20120210', '0'),
('dayposts', '20120209', '0'),
('dayposts', '20120208', '0'),
('dayposts', '20120207', '0'),
('dayposts', '20120206', '0'),
('dayposts', '20120123', '0'),
('dayposts', '20120124', '0'),
('dayposts', '20120125', '0'),
('dayposts', '20120205', '0'),
('dayposts', '20120204', '0'),
('dayposts', '20120203', '0'),
('dayposts', '20120202', '0'),
('dayposts', '20120201', '0'),
('monthposts', '201112', '0'),
('main', 'lastupdate', '1329887019'),
('main', 'forums', '26'),
('main', 'threads', '15'),
('main', 'posts', '19'),
('main', 'runtime', '30.4234'),
('main', 'members', '26'),
('main', 'postsaddtoday', '0'),
('main', 'membersaddtoday', '0'),
('main', 'admins', '1'),
('main', 'memnonpost', '21'),
('main', 'hotforum', 'a:4:{s:5:"posts";s:1:"3";s:7:"threads";s:1:"3";s:3:"fid";s:2:"32";s:4:"name";s:8:"食谱大全";}'),
('main', 'bestmem', 'None'),
('main', 'bestmemposts', '0'),
('dayposts', '20120131', '0'),
('team', 'lastupdate', '1329885654'),
('team', 'team', 'a:10:{s:10:"categories";a:0:{}s:6:"forums";a:8:{i:3;a:7:{i:3;a:6:{s:3:"fid";s:1:"3";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:6:"综合区";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:29;a:6:{s:3:"fid";s:2:"29";s:3:"fup";s:1:"3";s:4:"type";s:5:"forum";s:4:"name";s:8:"休闲生活";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:30;a:6:{s:3:"fid";s:2:"30";s:3:"fup";s:1:"3";s:4:"type";s:5:"forum";s:4:"name";s:8:"热点关注";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:4;a:6:{s:3:"fid";s:1:"4";s:3:"fup";s:1:"3";s:4:"type";s:5:"forum";s:4:"name";s:8:"宝宝养育";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:15;a:6:{s:3:"fid";s:2:"15";s:3:"fup";s:1:"3";s:4:"type";s:5:"forum";s:4:"name";s:8:"孕产健康";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:13;a:6:{s:3:"fid";s:2:"13";s:3:"fup";s:1:"4";s:4:"type";s:3:"sub";s:4:"name";s:8:"前期教育";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:12;a:6:{s:3:"fid";s:2:"12";s:3:"fup";s:1:"4";s:4:"type";s:3:"sub";s:4:"name";s:8:"智力开发";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}i:8;a:5:{i:8;a:6:{s:3:"fid";s:1:"8";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:6:"孕产区";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:11;a:6:{s:3:"fid";s:2:"11";s:3:"fup";s:1:"8";s:4:"type";s:5:"forum";s:4:"name";s:6:"备孕期";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:10;a:6:{s:3:"fid";s:2:"10";s:3:"fup";s:1:"8";s:4:"type";s:5:"forum";s:4:"name";s:4:"孕期";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:9;a:6:{s:3:"fid";s:1:"9";s:3:"fup";s:1:"8";s:4:"type";s:5:"forum";s:4:"name";s:6:"分娩期";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:17;a:6:{s:3:"fid";s:2:"17";s:3:"fup";s:1:"8";s:4:"type";s:5:"forum";s:4:"name";s:6:"月子期";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}i:5;a:5:{i:5;a:6:{s:3:"fid";s:1:"5";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:6:"育儿区";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:28;a:6:{s:3:"fid";s:2:"28";s:3:"fup";s:1:"5";s:4:"type";s:5:"forum";s:4:"name";s:8:"早期教育";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:16;a:6:{s:3:"fid";s:2:"16";s:3:"fup";s:1:"5";s:4:"type";s:5:"forum";s:4:"name";s:8:"育儿总坛";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:6;a:6:{s:3:"fid";s:1:"6";s:3:"fup";s:1:"5";s:4:"type";s:5:"forum";s:4:"name";s:8:"宝宝起名";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:27;a:6:{s:3:"fid";s:2:"27";s:3:"fup";s:1:"5";s:4:"type";s:5:"forum";s:4:"name";s:8:"成长日志";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}i:14;a:4:{i:14;a:6:{s:3:"fid";s:2:"14";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:6:"护理区";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:34;a:6:{s:3:"fid";s:2:"34";s:3:"fup";s:2:"14";s:4:"type";s:5:"forum";s:4:"name";s:4:"护理";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:35;a:6:{s:3:"fid";s:2:"35";s:3:"fup";s:2:"14";s:4:"type";s:5:"forum";s:4:"name";s:4:"保健";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:26;a:6:{s:3:"fid";s:2:"26";s:3:"fup";s:2:"14";s:4:"type";s:5:"forum";s:4:"name";s:6:"坐月子";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}i:20;a:4:{i:20;a:6:{s:3:"fid";s:2:"20";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:6:"营养区";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:31;a:6:{s:3:"fid";s:2:"31";s:3:"fup";s:2:"20";s:4:"type";s:5:"forum";s:4:"name";s:8:"母乳喂养";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:32;a:6:{s:3:"fid";s:2:"32";s:3:"fup";s:2:"20";s:4:"type";s:5:"forum";s:4:"name";s:8:"食谱大全";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:33;a:6:{s:3:"fid";s:2:"33";s:3:"fup";s:2:"20";s:4:"type";s:5:"forum";s:4:"name";s:8:"均衡营养";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}i:21;a:3:{i:21;a:6:{s:3:"fid";s:2:"21";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:8:"心灵交流";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:24;a:6:{s:3:"fid";s:2:"24";s:3:"fup";s:2:"21";s:4:"type";s:5:"forum";s:4:"name";s:8:"孕妈交流";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:25;a:6:{s:3:"fid";s:2:"25";s:3:"fup";s:2:"21";s:4:"type";s:5:"forum";s:4:"name";s:8:"想要宝宝";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}i:22;a:3:{i:22;a:6:{s:3:"fid";s:2:"22";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:8:"塑身恢复";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:38;a:6:{s:3:"fid";s:2:"38";s:3:"fup";s:2:"22";s:4:"type";s:5:"forum";s:4:"name";s:8:"产后食谱";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:39;a:6:{s:3:"fid";s:2:"39";s:3:"fup";s:2:"22";s:4:"type";s:5:"forum";s:4:"name";s:8:"产后瑜伽";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}i:23;a:3:{i:23;a:6:{s:3:"fid";s:2:"23";s:3:"fup";s:1:"0";s:4:"type";s:5:"group";s:4:"name";s:8:"技艺沙龙";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:36;a:6:{s:3:"fid";s:2:"36";s:3:"fup";s:2:"23";s:4:"type";s:5:"forum";s:4:"name";s:4:"活动";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}i:37;a:6:{s:3:"fid";s:2:"37";s:3:"fup";s:2:"23";s:4:"type";s:5:"forum";s:4:"name";s:4:"公告";s:12:"inheritedmod";s:1:"0";s:10:"moderators";i:0;}}}s:6:"admins";a:1:{i:0;s:1:"1";}s:10:"moderators";a:0:{}s:7:"members";a:1:{i:1;a:9:{s:3:"uid";s:1:"1";s:8:"username";s:5:"admin";s:7:"adminid";s:1:"1";s:12:"lastactivity";s:10:"1329269715";s:7:"credits";s:1:"0";s:5:"posts";s:1:"0";s:11:"thismonthol";d:0.330000000000000015543122344752191565930843353271484375;s:7:"totalol";d:7.3300000000000000710542735760100185871124267578125;s:7:"offdays";i:7;}}s:10:"avgoffdays";i:7;s:17:"avgthismonthposts";i:0;s:10:"avgtotalol";d:7.3300000000000000710542735760100185871124267578125;s:14:"avgthismonthol";d:0.330000000000000015543122344752191565930843353271484375;s:13:"avgmodactions";i:0;}'),
('trade', 'lastupdate', '1330326480'),
('trade', 'tradesums', 'N;'),
('trade', 'totalitems', 'N;'),
('postsrank', 'lastupdate', '1329770350'),
('postsrank', 'posts', 'a:20:{i:0;a:3:{s:8:"username";s:9:"wismartzy";s:3:"uid";s:2:"13";s:5:"posts";s:2:"12";}i:1;a:3:{s:8:"username";s:9:"xifeng666";s:3:"uid";s:2:"14";s:5:"posts";s:1:"4";}i:2;a:3:{s:8:"username";s:3:"009";s:3:"uid";s:2:"20";s:5:"posts";s:1:"1";}i:3;a:3:{s:8:"username";s:6:"xifeng";s:3:"uid";s:1:"6";s:5:"posts";s:1:"1";}i:4;a:3:{s:8:"username";s:4:"2727";s:3:"uid";s:2:"23";s:5:"posts";s:1:"1";}i:5;a:3:{s:8:"username";s:3:"999";s:3:"uid";s:2:"22";s:5:"posts";s:1:"0";}i:6;a:3:{s:8:"username";s:3:"011";s:3:"uid";s:2:"25";s:5:"posts";s:1:"0";}i:7;a:3:{s:8:"username";s:4:"cici";s:3:"uid";s:2:"16";s:5:"posts";s:1:"0";}i:8;a:3:{s:8:"username";s:2:"01";s:3:"uid";s:2:"17";s:5:"posts";s:1:"0";}i:9;a:3:{s:8:"username";s:10:"chenxufeng";s:3:"uid";s:2:"18";s:5:"posts";s:1:"0";}i:10;a:3:{s:8:"username";s:2:"02";s:3:"uid";s:2:"19";s:5:"posts";s:1:"0";}i:11;a:3:{s:8:"username";s:2:"33";s:3:"uid";s:2:"24";s:5:"posts";s:1:"0";}i:12;a:3:{s:8:"username";s:3:"111";s:3:"uid";s:2:"21";s:5:"posts";s:1:"0";}i:13;a:3:{s:8:"username";s:3:"yyw";s:3:"uid";s:2:"15";s:5:"posts";s:1:"0";}i:14;a:3:{s:8:"username";s:5:"admin";s:3:"uid";s:1:"1";s:5:"posts";s:1:"0";}i:15;a:3:{s:8:"username";s:8:"liqiulin";s:3:"uid";s:1:"2";s:5:"posts";s:1:"0";}i:16;a:3:{s:8:"username";s:5:"test3";s:3:"uid";s:1:"3";s:5:"posts";s:1:"0";}i:17;a:3:{s:8:"username";s:8:"fgsertgs";s:3:"uid";s:1:"4";s:5:"posts";s:1:"0";}i:18;a:3:{s:8:"username";s:12:"liqiulintest";s:3:"uid";s:1:"5";s:5:"posts";s:1:"0";}i:19;a:3:{s:8:"username";s:8:"zhangfan";s:3:"uid";s:1:"7";s:5:"posts";s:1:"0";}}'),
('postsrank', 'digestposts', 'a:20:{i:0;a:3:{s:8:"username";s:5:"admin";s:3:"uid";s:1:"1";s:11:"digestposts";s:1:"0";}i:1;a:3:{s:8:"username";s:3:"yyw";s:3:"uid";s:2:"15";s:11:"digestposts";s:1:"0";}i:2;a:3:{s:8:"username";s:4:"cici";s:3:"uid";s:2:"16";s:11:"digestposts";s:1:"0";}i:3;a:3:{s:8:"username";s:2:"01";s:3:"uid";s:2:"17";s:11:"digestposts";s:1:"0";}i:4;a:3:{s:8:"username";s:10:"chenxufeng";s:3:"uid";s:2:"18";s:11:"digestposts";s:1:"0";}i:5;a:3:{s:8:"username";s:2:"02";s:3:"uid";s:2:"19";s:11:"digestposts";s:1:"0";}i:6;a:3:{s:8:"username";s:3:"009";s:3:"uid";s:2:"20";s:11:"digestposts";s:1:"0";}i:7;a:3:{s:8:"username";s:3:"111";s:3:"uid";s:2:"21";s:11:"digestposts";s:1:"0";}i:8;a:3:{s:8:"username";s:3:"999";s:3:"uid";s:2:"22";s:11:"digestposts";s:1:"0";}i:9;a:3:{s:8:"username";s:4:"2727";s:3:"uid";s:2:"23";s:11:"digestposts";s:1:"0";}i:10;a:3:{s:8:"username";s:2:"33";s:3:"uid";s:2:"24";s:11:"digestposts";s:1:"0";}i:11;a:3:{s:8:"username";s:3:"011";s:3:"uid";s:2:"25";s:11:"digestposts";s:1:"0";}i:12;a:3:{s:8:"username";s:9:"xifeng666";s:3:"uid";s:2:"14";s:11:"digestposts";s:1:"0";}i:13;a:3:{s:8:"username";s:9:"wismartzy";s:3:"uid";s:2:"13";s:11:"digestposts";s:1:"0";}i:14;a:3:{s:8:"username";s:8:"liqiulin";s:3:"uid";s:1:"2";s:11:"digestposts";s:1:"0";}i:15;a:3:{s:8:"username";s:5:"test3";s:3:"uid";s:1:"3";s:11:"digestposts";s:1:"0";}i:16;a:3:{s:8:"username";s:8:"fgsertgs";s:3:"uid";s:1:"4";s:11:"digestposts";s:1:"0";}i:17;a:3:{s:8:"username";s:12:"liqiulintest";s:3:"uid";s:1:"5";s:11:"digestposts";s:1:"0";}i:18;a:3:{s:8:"username";s:6:"xifeng";s:3:"uid";s:1:"6";s:11:"digestposts";s:1:"0";}i:19;a:3:{s:8:"username";s:8:"zhangfan";s:3:"uid";s:1:"7";s:11:"digestposts";s:1:"0";}}'),
('postsrank', 'thismonth', 'a:2:{i:0;a:2:{s:8:"username";s:3:"009";s:5:"posts";s:1:"1";}i:1;a:2:{s:8:"username";s:4:"2727";s:5:"posts";s:1:"1";}}'),
('postsrank', 'today', 'a:0:{}'),
('forumsrank', 'lastupdate', '1329768113'),
('forumsrank', 'threads', 'a:20:{i:0;a:3:{s:3:"fid";s:2:"32";s:4:"name";s:8:"食谱大全";s:7:"threads";s:1:"3";}i:1;a:3:{s:3:"fid";s:1:"4";s:4:"name";s:8:"宝宝养育";s:7:"threads";s:1:"1";}i:2;a:3:{s:3:"fid";s:1:"6";s:4:"name";s:8:"宝宝起名";s:7:"threads";s:1:"1";}i:3;a:3:{s:3:"fid";s:2:"10";s:4:"name";s:4:"孕期";s:7:"threads";s:1:"1";}i:4;a:3:{s:3:"fid";s:1:"9";s:4:"name";s:6:"分娩期";s:7:"threads";s:1:"1";}i:5;a:3:{s:3:"fid";s:2:"27";s:4:"name";s:8:"成长日志";s:7:"threads";s:1:"1";}i:6;a:3:{s:3:"fid";s:2:"31";s:4:"name";s:8:"母乳喂养";s:7:"threads";s:1:"1";}i:7;a:3:{s:3:"fid";s:2:"30";s:4:"name";s:8:"热点关注";s:7:"threads";s:1:"1";}i:8;a:3:{s:3:"fid";s:2:"29";s:4:"name";s:8:"休闲生活";s:7:"threads";s:1:"1";}i:9;a:3:{s:3:"fid";s:2:"28";s:4:"name";s:8:"早期教育";s:7:"threads";s:1:"1";}i:10;a:3:{s:3:"fid";s:2:"24";s:4:"name";s:8:"孕妈交流";s:7:"threads";s:1:"1";}i:11;a:3:{s:3:"fid";s:2:"16";s:4:"name";s:8:"育儿总坛";s:7:"threads";s:1:"1";}i:12;a:3:{s:3:"fid";s:2:"11";s:4:"name";s:6:"备孕期";s:7:"threads";s:1:"1";}i:13;a:3:{s:3:"fid";s:2:"17";s:4:"name";s:6:"月子期";s:7:"threads";s:1:"0";}i:14;a:3:{s:3:"fid";s:2:"25";s:4:"name";s:8:"想要宝宝";s:7:"threads";s:1:"0";}i:15;a:3:{s:3:"fid";s:2:"12";s:4:"name";s:8:"智力开发";s:7:"threads";s:1:"0";}i:16;a:3:{s:3:"fid";s:2:"39";s:4:"name";s:8:"产后瑜伽";s:7:"threads";s:1:"0";}i:17;a:3:{s:3:"fid";s:2:"38";s:4:"name";s:8:"产后食谱";s:7:"threads";s:1:"0";}i:18;a:3:{s:3:"fid";s:2:"37";s:4:"name";s:4:"公告";s:7:"threads";s:1:"0";}i:19;a:3:{s:3:"fid";s:2:"36";s:4:"name";s:4:"活动";s:7:"threads";s:1:"0";}}'),
('forumsrank', 'forums', '20'),
('forumsrank', 'posts', 'a:20:{i:0;a:3:{s:3:"fid";s:2:"30";s:4:"name";s:8:"热点关注";s:5:"posts";s:1:"3";}i:1;a:3:{s:3:"fid";s:2:"32";s:4:"name";s:8:"食谱大全";s:5:"posts";s:1:"3";}i:2;a:3:{s:3:"fid";s:2:"11";s:4:"name";s:6:"备孕期";s:5:"posts";s:1:"2";}i:3;a:3:{s:3:"fid";s:1:"9";s:4:"name";s:6:"分娩期";s:5:"posts";s:1:"2";}i:4;a:3:{s:3:"fid";s:1:"6";s:4:"name";s:8:"宝宝起名";s:5:"posts";s:1:"1";}i:5;a:3:{s:3:"fid";s:2:"10";s:4:"name";s:4:"孕期";s:5:"posts";s:1:"1";}i:6;a:3:{s:3:"fid";s:2:"27";s:4:"name";s:8:"成长日志";s:5:"posts";s:1:"1";}i:7;a:3:{s:3:"fid";s:2:"31";s:4:"name";s:8:"母乳喂养";s:5:"posts";s:1:"1";}i:8;a:3:{s:3:"fid";s:1:"4";s:4:"name";s:8:"宝宝养育";s:5:"posts";s:1:"1";}i:9;a:3:{s:3:"fid";s:2:"29";s:4:"name";s:8:"休闲生活";s:5:"posts";s:1:"1";}i:10;a:3:{s:3:"fid";s:2:"28";s:4:"name";s:8:"早期教育";s:5:"posts";s:1:"1";}i:11;a:3:{s:3:"fid";s:2:"24";s:4:"name";s:8:"孕妈交流";s:5:"posts";s:1:"1";}i:12;a:3:{s:3:"fid";s:2:"16";s:4:"name";s:8:"育儿总坛";s:5:"posts";s:1:"1";}i:13;a:3:{s:3:"fid";s:2:"17";s:4:"name";s:6:"月子期";s:5:"posts";s:1:"0";}i:14;a:3:{s:3:"fid";s:2:"25";s:4:"name";s:8:"想要宝宝";s:5:"posts";s:1:"0";}i:15;a:3:{s:3:"fid";s:2:"12";s:4:"name";s:8:"智力开发";s:5:"posts";s:1:"0";}i:16;a:3:{s:3:"fid";s:2:"39";s:4:"name";s:8:"产后瑜伽";s:5:"posts";s:1:"0";}i:17;a:3:{s:3:"fid";s:2:"38";s:4:"name";s:8:"产后食谱";s:5:"posts";s:1:"0";}i:18;a:3:{s:3:"fid";s:2:"37";s:4:"name";s:4:"公告";s:5:"posts";s:1:"0";}i:19;a:3:{s:3:"fid";s:2:"36";s:4:"name";s:4:"活动";s:5:"posts";s:1:"0";}}'),
('forumsrank', 'thismonth', 'a:2:{i:0;a:3:{s:3:"fid";s:2:"11";s:4:"name";s:6:"备孕期";s:5:"posts";s:1:"1";}i:1;a:3:{s:3:"fid";s:2:"31";s:4:"name";s:8:"母乳喂养";s:5:"posts";s:1:"1";}}'),
('forumsrank', 'today', 'a:0:{}'),
('dayposts', '20120130', '0'),
('dayposts', '20120129', '0'),
('dayposts', '20120128', '0'),
('onlines', 'lastupdate', '0'),
('onlines', 'total', 'a:9:{i:0;a:3:{s:3:"uid";s:1:"1";s:8:"username";s:5:"admin";s:4:"time";d:7.3300000000000000710542735760100185871124267578125;}i:1;a:3:{s:3:"uid";s:1:"6";s:8:"username";s:6:"xifeng";s:4:"time";d:2.1699999999999999289457264239899814128875732421875;}i:2;a:3:{s:3:"uid";s:2:"13";s:8:"username";s:9:"wismartzy";s:4:"time";d:1.8300000000000000710542735760100185871124267578125;}i:3;a:3:{s:3:"uid";s:2:"14";s:8:"username";s:9:"xifeng666";s:4:"time";d:1.3300000000000000710542735760100185871124267578125;}i:4;a:3:{s:3:"uid";s:1:"8";s:8:"username";s:3:"110";s:4:"time";d:0.82999999999999996003197111349436454474925994873046875;}i:5;a:3:{s:3:"uid";s:2:"20";s:8:"username";s:3:"009";s:4:"time";d:0.330000000000000015543122344752191565930843353271484375;}i:6;a:3:{s:3:"uid";s:2:"12";s:8:"username";s:4:"wise";s:4:"time";d:0.1700000000000000122124532708767219446599483489990234375;}i:7;a:3:{s:3:"uid";s:2:"23";s:8:"username";s:4:"2727";s:4:"time";d:0.1700000000000000122124532708767219446599483489990234375;}i:8;a:3:{s:3:"uid";s:2:"25";s:8:"username";s:3:"011";s:4:"time";d:0.1700000000000000122124532708767219446599483489990234375;}}'),
('onlines', 'thismonth', 'a:4:{i:0;a:3:{s:3:"uid";s:1:"1";s:8:"username";s:5:"admin";s:4:"time";d:0.330000000000000015543122344752191565930843353271484375;}i:1;a:3:{s:3:"uid";s:2:"20";s:8:"username";s:3:"009";s:4:"time";d:0.330000000000000015543122344752191565930843353271484375;}i:2;a:3:{s:3:"uid";s:2:"23";s:8:"username";s:4:"2727";s:4:"time";d:0.1700000000000000122124532708767219446599483489990234375;}i:3;a:3:{s:3:"uid";s:2:"25";s:8:"username";s:3:"011";s:4:"time";d:0.1700000000000000122124532708767219446599483489990234375;}}'),
('creditsrank', 'lastupdate', '1329885301'),
('creditsrank', 'credits', 'a:20:{i:0;a:3:{s:8:"username";s:5:"admin";s:3:"uid";s:1:"1";s:7:"credits";s:1:"0";}i:1;a:3:{s:8:"username";s:3:"yyw";s:3:"uid";s:2:"15";s:7:"credits";s:1:"0";}i:2;a:3:{s:8:"username";s:4:"cici";s:3:"uid";s:2:"16";s:7:"credits";s:1:"0";}i:3;a:3:{s:8:"username";s:2:"01";s:3:"uid";s:2:"17";s:7:"credits";s:1:"0";}i:4;a:3:{s:8:"username";s:10:"chenxufeng";s:3:"uid";s:2:"18";s:7:"credits";s:1:"0";}i:5;a:3:{s:8:"username";s:2:"02";s:3:"uid";s:2:"19";s:7:"credits";s:1:"0";}i:6;a:3:{s:8:"username";s:3:"009";s:3:"uid";s:2:"20";s:7:"credits";s:1:"0";}i:7;a:3:{s:8:"username";s:3:"111";s:3:"uid";s:2:"21";s:7:"credits";s:1:"0";}i:8;a:3:{s:8:"username";s:3:"999";s:3:"uid";s:2:"22";s:7:"credits";s:1:"0";}i:9;a:3:{s:8:"username";s:4:"2727";s:3:"uid";s:2:"23";s:7:"credits";s:1:"0";}i:10;a:3:{s:8:"username";s:2:"33";s:3:"uid";s:2:"24";s:7:"credits";s:1:"0";}i:11;a:3:{s:8:"username";s:3:"011";s:3:"uid";s:2:"25";s:7:"credits";s:1:"0";}i:12;a:3:{s:8:"username";s:9:"xifeng666";s:3:"uid";s:2:"14";s:7:"credits";s:1:"0";}i:13;a:3:{s:8:"username";s:9:"wismartzy";s:3:"uid";s:2:"13";s:7:"credits";s:1:"0";}i:14;a:3:{s:8:"username";s:8:"liqiulin";s:3:"uid";s:1:"2";s:7:"credits";s:1:"0";}i:15;a:3:{s:8:"username";s:5:"test3";s:3:"uid";s:1:"3";s:7:"credits";s:1:"0";}i:16;a:3:{s:8:"username";s:8:"fgsertgs";s:3:"uid";s:1:"4";s:7:"credits";s:1:"0";}i:17;a:3:{s:8:"username";s:12:"liqiulintest";s:3:"uid";s:1:"5";s:7:"credits";s:1:"0";}i:18;a:3:{s:8:"username";s:6:"xifeng";s:3:"uid";s:1:"6";s:7:"credits";s:1:"0";}i:19;a:3:{s:8:"username";s:8:"zhangfan";s:3:"uid";s:1:"7";s:7:"credits";s:1:"0";}}'),
('creditsrank', 'extendedcredits', 'a:2:{i:1;a:20:{i:0;a:3:{s:8:"username";s:5:"admin";s:3:"uid";s:1:"1";s:7:"credits";s:1:"0";}i:1;a:3:{s:8:"username";s:3:"yyw";s:3:"uid";s:2:"15";s:7:"credits";s:1:"0";}i:2;a:3:{s:8:"username";s:4:"cici";s:3:"uid";s:2:"16";s:7:"credits";s:1:"0";}i:3;a:3:{s:8:"username";s:2:"01";s:3:"uid";s:2:"17";s:7:"credits";s:1:"0";}i:4;a:3:{s:8:"username";s:10:"chenxufeng";s:3:"uid";s:2:"18";s:7:"credits";s:1:"0";}i:5;a:3:{s:8:"username";s:2:"02";s:3:"uid";s:2:"19";s:7:"credits";s:1:"0";}i:6;a:3:{s:8:"username";s:3:"009";s:3:"uid";s:2:"20";s:7:"credits";s:1:"0";}i:7;a:3:{s:8:"username";s:3:"111";s:3:"uid";s:2:"21";s:7:"credits";s:1:"0";}i:8;a:3:{s:8:"username";s:3:"999";s:3:"uid";s:2:"22";s:7:"credits";s:1:"0";}i:9;a:3:{s:8:"username";s:4:"2727";s:3:"uid";s:2:"23";s:7:"credits";s:1:"0";}i:10;a:3:{s:8:"username";s:2:"33";s:3:"uid";s:2:"24";s:7:"credits";s:1:"0";}i:11;a:3:{s:8:"username";s:3:"011";s:3:"uid";s:2:"25";s:7:"credits";s:1:"0";}i:12;a:3:{s:8:"username";s:9:"xifeng666";s:3:"uid";s:2:"14";s:7:"credits";s:1:"0";}i:13;a:3:{s:8:"username";s:9:"wismartzy";s:3:"uid";s:2:"13";s:7:"credits";s:1:"0";}i:14;a:3:{s:8:"username";s:8:"liqiulin";s:3:"uid";s:1:"2";s:7:"credits";s:1:"0";}i:15;a:3:{s:8:"username";s:5:"test3";s:3:"uid";s:1:"3";s:7:"credits";s:1:"0";}i:16;a:3:{s:8:"username";s:8:"fgsertgs";s:3:"uid";s:1:"4";s:7:"credits";s:1:"0";}i:17;a:3:{s:8:"username";s:12:"liqiulintest";s:3:"uid";s:1:"5";s:7:"credits";s:1:"0";}i:18;a:3:{s:8:"username";s:6:"xifeng";s:3:"uid";s:1:"6";s:7:"credits";s:1:"0";}i:19;a:3:{s:8:"username";s:8:"zhangfan";s:3:"uid";s:1:"7";s:7:"credits";s:1:"0";}}i:2;a:20:{i:0;a:3:{s:8:"username";s:5:"admin";s:3:"uid";s:1:"1";s:7:"credits";s:1:"0";}i:1;a:3:{s:8:"username";s:3:"yyw";s:3:"uid";s:2:"15";s:7:"credits";s:1:"0";}i:2;a:3:{s:8:"username";s:4:"cici";s:3:"uid";s:2:"16";s:7:"credits";s:1:"0";}i:3;a:3:{s:8:"username";s:2:"01";s:3:"uid";s:2:"17";s:7:"credits";s:1:"0";}i:4;a:3:{s:8:"username";s:10:"chenxufeng";s:3:"uid";s:2:"18";s:7:"credits";s:1:"0";}i:5;a:3:{s:8:"username";s:2:"02";s:3:"uid";s:2:"19";s:7:"credits";s:1:"0";}i:6;a:3:{s:8:"username";s:3:"009";s:3:"uid";s:2:"20";s:7:"credits";s:1:"0";}i:7;a:3:{s:8:"username";s:3:"111";s:3:"uid";s:2:"21";s:7:"credits";s:1:"0";}i:8;a:3:{s:8:"username";s:3:"999";s:3:"uid";s:2:"22";s:7:"credits";s:1:"0";}i:9;a:3:{s:8:"username";s:4:"2727";s:3:"uid";s:2:"23";s:7:"credits";s:1:"0";}i:10;a:3:{s:8:"username";s:2:"33";s:3:"uid";s:2:"24";s:7:"credits";s:1:"0";}i:11;a:3:{s:8:"username";s:3:"011";s:3:"uid";s:2:"25";s:7:"credits";s:1:"0";}i:12;a:3:{s:8:"username";s:9:"xifeng666";s:3:"uid";s:2:"14";s:7:"credits";s:1:"0";}i:13;a:3:{s:8:"username";s:9:"wismartzy";s:3:"uid";s:2:"13";s:7:"credits";s:1:"0";}i:14;a:3:{s:8:"username";s:8:"liqiulin";s:3:"uid";s:1:"2";s:7:"credits";s:1:"0";}i:15;a:3:{s:8:"username";s:5:"test3";s:3:"uid";s:1:"3";s:7:"credits";s:1:"0";}i:16;a:3:{s:8:"username";s:8:"fgsertgs";s:3:"uid";s:1:"4";s:7:"credits";s:1:"0";}i:17;a:3:{s:8:"username";s:12:"liqiulintest";s:3:"uid";s:1:"5";s:7:"credits";s:1:"0";}i:18;a:3:{s:8:"username";s:6:"xifeng";s:3:"uid";s:1:"6";s:7:"credits";s:1:"0";}i:19;a:3:{s:8:"username";s:8:"zhangfan";s:3:"uid";s:1:"7";s:7:"credits";s:1:"0";}}}'),
('monthposts', '201201', '17'),
('dayposts', '20120126', '0'),
('dayposts', '20120127', '0');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_styles`
--

CREATE TABLE IF NOT EXISTS `discuz_styles` (
  `styleid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `templateid` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`styleid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `discuz_styles`
--

INSERT INTO `discuz_styles` (`styleid`, `name`, `available`, `templateid`) VALUES
(1, '默认风格', 1, 1),
(2, '喝彩奥运', 1, 2),
(3, '深邃永恒', 1, 3),
(4, '粉妆精灵', 1, 4),
(5, '诗意田园', 1, 1),
(6, '春意盎然', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_stylevars`
--

CREATE TABLE IF NOT EXISTS `discuz_stylevars` (
  `stylevarid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `styleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `variable` text NOT NULL,
  `substitute` text NOT NULL,
  PRIMARY KEY (`stylevarid`),
  KEY `styleid` (`styleid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=241 ;

--
-- 转存表中的数据 `discuz_stylevars`
--

INSERT INTO `discuz_stylevars` (`stylevarid`, `styleid`, `variable`, `substitute`) VALUES
(1, 1, 'available', ''),
(2, 1, 'commonboxborder', '#E8E8E8'),
(3, 1, 'noticebg', '#FFFFF2'),
(4, 1, 'tablebg', '#FFF'),
(5, 1, 'highlightlink', '#069'),
(6, 1, 'commonboxbg', '#F7F7F7'),
(7, 1, 'bgcolor', '#FFF'),
(8, 1, 'altbg1', '#F5FAFE'),
(9, 1, 'altbg2', '#E8F3FD'),
(10, 1, 'link', '#000'),
(11, 1, 'bordercolor', '#9DB3C5'),
(12, 1, 'headercolor', '#2F589C header_bg.gif'),
(13, 1, 'headertext', '#FFF'),
(14, 1, 'tabletext', '#000'),
(15, 1, 'text', '#666'),
(16, 1, 'catcolor', '#E8F3FD cat_bg.gif'),
(17, 1, 'borderwidth', '1px'),
(18, 1, 'fontsize', '12px'),
(19, 1, 'tablespace', '1px'),
(20, 1, 'msgfontsize', '14px'),
(21, 1, 'msgbigsize', '16px'),
(22, 1, 'msgsmallsize', '12px'),
(23, 1, 'font', 'Helvetica, Arial, sans-serif'),
(24, 1, 'smfontsize', '0.83em'),
(25, 1, 'smfont', 'Verdana, Arial, Helvetica, sans-serif'),
(26, 1, 'bgborder', '#CAD9EA'),
(27, 1, 'maintablewidth', '98%'),
(28, 1, 'imgdir', 'images/default'),
(29, 1, 'boardimg', 'logo.gif'),
(30, 1, 'inputborder', '#DDD'),
(31, 1, 'catborder', '#CAD9EA'),
(32, 1, 'lighttext', '#999'),
(33, 1, 'framebgcolor', 'frame_bg.gif'),
(34, 1, 'headermenu', '#FFF menu_bg.gif'),
(35, 1, 'headermenutext', '#333'),
(36, 1, 'boxspace', '10px'),
(37, 1, 'portalboxbgcode', '#FFF portalbox_bg.gif'),
(38, 1, 'noticeborder', '#EDEDCE'),
(39, 1, 'noticetext', '#090'),
(40, 1, 'stypeid', '1'),
(41, 2, 'available', ''),
(42, 2, 'bgcolor', '#FFF'),
(43, 2, 'altbg1', '#FFF'),
(44, 2, 'altbg2', '#F7F7F3'),
(45, 2, 'link', '#262626'),
(46, 2, 'bordercolor', '#C1C1C1'),
(47, 2, 'headercolor', '#FFF forumbox_head.gif'),
(48, 2, 'headertext', '#D00'),
(49, 2, 'catcolor', '#F90 cat_bg.gif'),
(50, 2, 'tabletext', '#535353'),
(51, 2, 'text', '#535353'),
(52, 2, 'borderwidth', '1px'),
(53, 2, 'tablespace', '1px'),
(54, 2, 'fontsize', '12px'),
(55, 2, 'msgfontsize', '14px'),
(56, 2, 'msgbigsize', '16px'),
(57, 2, 'msgsmallsize', '12px'),
(58, 2, 'font', 'Arial,Helvetica,sans-serif'),
(59, 2, 'smfontsize', '11px'),
(60, 2, 'smfont', 'Arial,Helvetica,sans-serif'),
(61, 2, 'boardimg', 'logo.gif'),
(62, 2, 'imgdir', './images/Beijing2008'),
(63, 2, 'maintablewidth', '98%'),
(64, 2, 'bgborder', '#C1C1C1'),
(65, 2, 'catborder', '#E2E2E2'),
(66, 2, 'inputborder', '#D7D7D7'),
(67, 2, 'lighttext', '#535353'),
(68, 2, 'headermenu', '#FFF menu_bg.gif'),
(69, 2, 'headermenutext', '#54564C'),
(70, 2, 'framebgcolor', ''),
(71, 2, 'noticebg', ''),
(72, 2, 'commonboxborder', '#F0F0ED'),
(73, 2, 'tablebg', '#FFF'),
(74, 2, 'highlightlink', '#535353'),
(75, 2, 'commonboxbg', '#F5F5F0'),
(76, 2, 'boxspace', '8px'),
(77, 2, 'portalboxbgcode', '#FFF portalbox_bg.gif'),
(78, 2, 'noticeborder', ''),
(79, 2, 'noticetext', '#DD0000'),
(80, 2, 'stypeid', '1'),
(81, 3, 'available', ''),
(82, 3, 'bgcolor', '#222D2D'),
(83, 3, 'altbg1', '#3E4F4F'),
(84, 3, 'altbg2', '#384747'),
(85, 3, 'link', '#CEEBEB'),
(86, 3, 'bordercolor', '#1B2424'),
(87, 3, 'headercolor', '#1B2424'),
(88, 3, 'headertext', '#94B3C5'),
(89, 3, 'catcolor', '#293838'),
(90, 3, 'tabletext', '#CEEBEB'),
(91, 3, 'text', '#999'),
(92, 3, 'borderwidth', '6px'),
(93, 3, 'tablespace', '0'),
(94, 3, 'fontsize', '12px'),
(95, 3, 'msgfontsize', '14px'),
(96, 3, 'msgbigsize', '16px'),
(97, 3, 'msgsmallsize', '12px'),
(98, 3, 'font', 'Arial'),
(99, 3, 'smfontsize', '11px'),
(100, 3, 'smfont', 'Arial,sans-serif'),
(101, 3, 'boardimg', 'logo.gif'),
(102, 3, 'imgdir', './images/Overcast'),
(103, 3, 'maintablewidth', '98%'),
(104, 3, 'bgborder', '#384747'),
(105, 3, 'catborder', '#1B2424'),
(106, 3, 'inputborder', '#EEE'),
(107, 3, 'lighttext', '#74898E'),
(108, 3, 'headermenu', '#3E4F4F'),
(109, 3, 'headermenutext', '#CEEBEB'),
(110, 3, 'framebgcolor', '#222D2D'),
(111, 3, 'noticebg', '#3E4F4F'),
(112, 3, 'commonboxborder', '#384747'),
(113, 3, 'tablebg', '#3E4F4F'),
(114, 3, 'highlightlink', '#9CB2A0'),
(115, 3, 'commonboxbg', '#384747'),
(116, 3, 'boxspace', '6px'),
(117, 3, 'portalboxbgcode', '#293838'),
(118, 3, 'noticeborder', '#384747'),
(119, 3, 'noticetext', '#C7E001'),
(120, 3, 'stypeid', '1'),
(121, 4, 'noticetext', '#C44D4D'),
(122, 4, 'noticeborder', '#D6D6D6'),
(123, 4, 'portalboxbgcode', '#FFF portalbox_bg.gif'),
(124, 4, 'boxspace', '6px'),
(125, 4, 'commonboxbg', '#FAFAFA'),
(126, 4, 'highlightlink', '#C44D4D'),
(127, 4, 'tablebg', '#FFF'),
(128, 4, 'commonboxborder', '#DEDEDE'),
(129, 4, 'noticebg', '#FAFAFA'),
(130, 4, 'framebgcolor', '#FFECF9'),
(131, 4, 'headermenu', 'transparent'),
(132, 4, 'headermenutext', ''),
(133, 4, 'lighttext', '#999'),
(134, 4, 'catborder', '#D7D7D7'),
(135, 4, 'inputborder', ''),
(136, 4, 'bgborder', '#CECECE'),
(137, 4, 'stypeid', '1'),
(138, 4, 'maintablewidth', '920px'),
(139, 4, 'imgdir', 'images/PinkDresser'),
(140, 4, 'boardimg', 'logo.gif'),
(141, 4, 'smfont', 'Arial,Helvetica,sans-serif'),
(142, 4, 'smfontsize', '12px'),
(143, 4, 'font', 'Arial,Helvetica,sans-serif'),
(144, 4, 'msgsmallsize', '12px'),
(145, 4, 'msgbigsize', '16px'),
(146, 4, 'msgfontsize', '14px'),
(147, 4, 'fontsize', '12px'),
(148, 4, 'tablespace', '0'),
(149, 4, 'borderwidth', '1px'),
(150, 4, 'text', '#666'),
(151, 4, 'tabletext', '#666'),
(152, 4, 'catcolor', '#FAFAFA category_bg.gif'),
(153, 4, 'headertext', '#FFF'),
(154, 4, 'headercolor', '#E7BFC9 forumbox_head.gif'),
(155, 4, 'bordercolor', '#D88E9D'),
(156, 4, 'link', '#C44D4D'),
(157, 4, 'altbg2', '#F1F1F1'),
(158, 4, 'available', ''),
(159, 4, 'altbg1', '#FBFBFB'),
(160, 4, 'bgcolor', '#FBF4F5 bg.gif'),
(161, 5, 'available', ''),
(162, 5, 'bgcolor', '#FFF'),
(163, 5, 'altbg1', '#FFFBF8'),
(164, 5, 'altbg2', '#FBF6F1'),
(165, 5, 'link', '#54564C'),
(166, 5, 'bordercolor', '#D7B094'),
(167, 5, 'headercolor', '#BE6A2D forumbox_head.gif'),
(168, 5, 'headertext', '#FFF'),
(169, 5, 'catcolor', '#E9E9E9 cat_bg.gif'),
(170, 5, 'tabletext', '#7B7D72'),
(171, 5, 'text', '#535353'),
(172, 5, 'borderwidth', '1px'),
(173, 5, 'tablespace', '1px'),
(174, 5, 'fontsize', '12px'),
(175, 5, 'msgfontsize', '14px'),
(176, 5, 'msgbigsize', '16px'),
(177, 5, 'msgsmallsize', '12px'),
(178, 5, 'font', 'Arial, sans-serif'),
(179, 5, 'smfontsize', '11px'),
(180, 5, 'smfont', 'Arial, sans-serif'),
(181, 5, 'boardimg', 'logo.gif'),
(182, 5, 'imgdir', './images/Picnicker'),
(183, 5, 'maintablewidth', '98%'),
(184, 5, 'bgborder', '#E8C9B7'),
(185, 5, 'catborder', '#E6E6E2'),
(186, 5, 'inputborder', ''),
(187, 5, 'lighttext', '#878787'),
(188, 5, 'headermenu', '#FFF menu_bg.gif'),
(189, 5, 'headermenutext', '#54564C'),
(190, 5, 'framebgcolor', 'frame_bg.gif'),
(191, 5, 'noticebg', '#FAFAF7'),
(192, 5, 'commonboxborder', '#E6E6E2'),
(193, 5, 'tablebg', '#FFF'),
(194, 5, 'highlightlink', ''),
(195, 5, 'commonboxbg', '#F5F5F0'),
(196, 5, 'boxspace', '6px'),
(197, 5, 'portalboxbgcode', '#FFF portalbox_bg.gif'),
(198, 5, 'noticeborder', '#E6E6E2'),
(199, 5, 'noticetext', '#FF3A00'),
(200, 5, 'stypeid', '1'),
(201, 6, 'available', ''),
(202, 6, 'bgcolor', '#FFF'),
(203, 6, 'altbg1', '#F5F5F0'),
(204, 6, 'altbg2', '#F9F9F9'),
(205, 6, 'link', '#54564C'),
(206, 6, 'bordercolor', '#D9D9D4'),
(207, 6, 'headercolor', '#80A400 forumbox_head.gif'),
(208, 6, 'headertext', '#FFF'),
(209, 6, 'catcolor', '#F5F5F0 cat_bg.gif'),
(210, 6, 'tabletext', '#7B7D72'),
(211, 6, 'text', '#535353'),
(212, 6, 'borderwidth', '1px'),
(213, 6, 'tablespace', '1px'),
(214, 6, 'fontsize', '12px'),
(215, 6, 'msgfontsize', '14px'),
(216, 6, 'msgbigsize', '16px'),
(217, 6, 'msgsmallsize', '12px'),
(218, 6, 'font', 'Arial,sans-serif'),
(219, 6, 'smfontsize', '11px'),
(220, 6, 'smfont', 'Arial,sans-serif'),
(221, 6, 'boardimg', 'logo.gif'),
(222, 6, 'imgdir', './images/GreenPark'),
(223, 6, 'maintablewidth', '98%'),
(224, 6, 'bgborder', '#D9D9D4'),
(225, 6, 'catborder', '#D9D9D4'),
(226, 6, 'inputborder', '#D9D9D4'),
(227, 6, 'lighttext', '#878787'),
(228, 6, 'headermenu', '#FFF menu_bg.gif'),
(229, 6, 'headermenutext', '#262626'),
(230, 6, 'framebgcolor', ''),
(231, 6, 'noticebg', '#FAFAF7'),
(232, 6, 'commonboxborder', '#E6E6E2'),
(233, 6, 'tablebg', '#FFF'),
(234, 6, 'highlightlink', '#535353'),
(235, 6, 'commonboxbg', '#F9F9F9'),
(236, 6, 'boxspace', '6px'),
(237, 6, 'portalboxbgcode', '#FFF portalbox_bg.gif'),
(238, 6, 'noticeborder', '#E6E6E2'),
(239, 6, 'noticetext', '#FF3A00'),
(240, 6, 'stypeid', '1');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_subscriptions`
--

CREATE TABLE IF NOT EXISTS `discuz_subscriptions` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastnotify` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_tags`
--

CREATE TABLE IF NOT EXISTS `discuz_tags` (
  `tagname` char(20) NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `total` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`tagname`),
  KEY `total` (`total`),
  KEY `closed` (`closed`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_templates`
--

CREATE TABLE IF NOT EXISTS `discuz_templates` (
  `templateid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `directory` varchar(100) NOT NULL DEFAULT '',
  `copyright` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`templateid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `discuz_templates`
--

INSERT INTO `discuz_templates` (`templateid`, `name`, `directory`, `copyright`) VALUES
(1, '默认模板套系', './templates/default', '康盛创想（北京）科技有限公司'),
(2, '喝彩奥运', './templates/Beijing2008', '康盛创想（北京）科技有限公司'),
(3, '深邃永恒', './templates/Overcast', '康盛创想（北京）科技有限公司'),
(4, '粉妆精灵', './templates/PinkDresser', '康盛创想（北京）科技有限公司');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_threads`
--

CREATE TABLE IF NOT EXISTS `discuz_threads` (
  `tid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `iconid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `readperm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `price` smallint(6) NOT NULL DEFAULT '0',
  `author` char(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` char(80) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastposter` char(15) NOT NULL DEFAULT '',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `replies` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(1) NOT NULL DEFAULT '0',
  `highlight` tinyint(1) NOT NULL DEFAULT '0',
  `digest` tinyint(1) NOT NULL DEFAULT '0',
  `rate` tinyint(1) NOT NULL DEFAULT '0',
  `blog` tinyint(1) NOT NULL DEFAULT '0',
  `special` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` tinyint(1) NOT NULL DEFAULT '0',
  `subscribed` tinyint(1) NOT NULL DEFAULT '0',
  `moderated` tinyint(1) NOT NULL DEFAULT '0',
  `closed` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `itemid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `supe_pushstatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `digest` (`digest`),
  KEY `displayorder` (`fid`,`displayorder`,`lastpost`),
  KEY `blog` (`blog`,`authorid`,`dateline`),
  KEY `typeid` (`fid`,`typeid`,`displayorder`,`lastpost`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `discuz_threads`
--

INSERT INTO `discuz_threads` (`tid`, `fid`, `iconid`, `typeid`, `readperm`, `price`, `author`, `authorid`, `subject`, `dateline`, `lastpost`, `lastposter`, `views`, `replies`, `displayorder`, `highlight`, `digest`, `rate`, `blog`, `special`, `attachment`, `subscribed`, `moderated`, `closed`, `itemid`, `supe_pushstatus`) VALUES
(1, 30, 0, 0, 0, 0, 'xifeng', 6, '很喜欢禧妈拉伢俱乐部提供的服务套餐', 1326434747, 1326442657, 'xifeng666', 34, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 10, 0, 0, 0, 0, 'wismartzy', 13, '孕妈妈常见疾病如何预防', 1326435649, 1326435649, 'wismartzy', 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 11, 0, 0, 0, 0, 'wismartzy', 13, '手机放哪儿才不会影响生育', 1326435842, 1329061864, '009', 16, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 32, 0, 0, 0, 0, 'wismartzy', 13, '豆腐：跟谁搭配最有营养', 1326436203, 1326436203, 'wismartzy', 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 32, 0, 0, 0, 0, 'wismartzy', 13, '饭菜水果一块吃不消化', 1326436375, 1326436375, 'wismartzy', 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 16, 0, 0, 0, 0, 'wismartzy', 13, '有助于宝宝增高食物你知道吗？', 1326436580, 1326436580, 'wismartzy', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 28, 0, 0, 0, 0, 'wismartzy', 13, '宝宝智力发展的八个黄金期', 1326436702, 1326436702, 'wismartzy', 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 4, 0, 0, 0, 0, 'wismartzy', 13, '鼓励宝宝模仿 挖掘艺术潜能', 1326436828, 1326436828, 'wismartzy', 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 27, 0, 0, 0, 0, 'wismartzy', 13, '培养一个有耐性的宝宝', 1326436932, 1326436932, 'wismartzy', 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 9, 0, 0, 0, 0, 'xifeng666', 14, '剖腹产好还是顺产好呢？？？', 1326437293, 1326437454, 'wismartzy', 18, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 29, 0, 0, 0, 0, 'wismartzy', 13, '春运不可怕~', 1326437597, 1326437597, 'wismartzy', 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 24, 0, 0, 0, 0, 'wismartzy', 13, '孕妇手麻是怎么回事呢？', 1326437709, 1326437709, 'wismartzy', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 6, 0, 0, 0, 0, 'xifeng666', 14, '女儿起名字', 1326442597, 1326442597, 'xifeng666', 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 32, 0, 0, 0, 0, 'xifeng666', 14, '北方的孕妈妈，都吃什么水果呢', 1326443069, 1326443069, 'xifeng666', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 31, 0, 0, 0, 0, '2727', 23, '测试', 1329063333, 1329063333, '2727', 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_threadsmod`
--

CREATE TABLE IF NOT EXISTS `discuz_threadsmod` (
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `action` char(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `magicid` smallint(6) unsigned NOT NULL,
  KEY `tid` (`tid`,`dateline`),
  KEY `expiration` (`expiration`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_threadtags`
--

CREATE TABLE IF NOT EXISTS `discuz_threadtags` (
  `tagname` char(20) NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  KEY `tagname` (`tagname`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_threadtypes`
--

CREATE TABLE IF NOT EXISTS `discuz_threadtypes` (
  `typeid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `special` smallint(6) NOT NULL DEFAULT '0',
  `modelid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `expiration` tinyint(1) NOT NULL DEFAULT '0',
  `template` text NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_tradecomments`
--

CREATE TABLE IF NOT EXISTS `discuz_tradecomments` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `orderid` char(32) NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `raterid` mediumint(8) unsigned NOT NULL,
  `rater` char(15) NOT NULL,
  `rateeid` mediumint(8) unsigned NOT NULL,
  `ratee` char(15) NOT NULL,
  `message` char(200) NOT NULL,
  `explanation` char(200) NOT NULL,
  `score` tinyint(1) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `raterid` (`raterid`,`type`,`dateline`),
  KEY `rateeid` (`rateeid`,`type`,`dateline`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_tradelog`
--

CREATE TABLE IF NOT EXISTS `discuz_tradelog` (
  `tid` mediumint(8) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `orderid` varchar(32) NOT NULL,
  `tradeno` varchar(32) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quality` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `itemtype` tinyint(1) NOT NULL DEFAULT '0',
  `number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tax` decimal(6,2) unsigned NOT NULL DEFAULT '0.00',
  `locus` varchar(100) NOT NULL,
  `sellerid` mediumint(8) unsigned NOT NULL,
  `seller` varchar(15) NOT NULL,
  `selleraccount` varchar(50) NOT NULL,
  `buyerid` mediumint(8) unsigned NOT NULL,
  `buyer` varchar(15) NOT NULL,
  `buyercontact` varchar(50) NOT NULL,
  `buyercredits` smallint(5) unsigned NOT NULL DEFAULT '0',
  `buyermsg` varchar(200) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  `offline` tinyint(1) NOT NULL DEFAULT '0',
  `buyername` varchar(50) NOT NULL,
  `buyerzip` varchar(10) NOT NULL,
  `buyerphone` varchar(20) NOT NULL,
  `buyermobile` varchar(20) NOT NULL,
  `transport` tinyint(1) NOT NULL DEFAULT '0',
  `transportfee` smallint(6) unsigned NOT NULL DEFAULT '0',
  `baseprice` decimal(8,2) NOT NULL,
  `discount` tinyint(1) NOT NULL DEFAULT '0',
  `ratestatus` tinyint(1) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  UNIQUE KEY `orderid` (`orderid`),
  KEY `sellerid` (`sellerid`),
  KEY `buyerid` (`buyerid`),
  KEY `status` (`status`),
  KEY `buyerlog` (`buyerid`,`status`,`lastupdate`),
  KEY `sellerlog` (`sellerid`,`status`,`lastupdate`),
  KEY `tid` (`tid`,`pid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_tradeoptionvars`
--

CREATE TABLE IF NOT EXISTS `discuz_tradeoptionvars` (
  `typeid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `optionid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `value` mediumtext NOT NULL,
  KEY `typeid` (`typeid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_trades`
--

CREATE TABLE IF NOT EXISTS `discuz_trades` (
  `tid` mediumint(8) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `typeid` smallint(6) unsigned NOT NULL,
  `sellerid` mediumint(8) unsigned NOT NULL,
  `seller` char(15) NOT NULL,
  `account` char(50) NOT NULL,
  `subject` char(100) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `amount` smallint(6) unsigned NOT NULL DEFAULT '1',
  `quality` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `locus` char(20) NOT NULL,
  `transport` tinyint(1) NOT NULL DEFAULT '0',
  `ordinaryfee` smallint(4) unsigned NOT NULL DEFAULT '0',
  `expressfee` smallint(4) unsigned NOT NULL DEFAULT '0',
  `emsfee` smallint(4) unsigned NOT NULL DEFAULT '0',
  `itemtype` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `lastbuyer` char(15) NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  `totalitems` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tradesum` decimal(8,2) NOT NULL DEFAULT '0.00',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `aid` mediumint(8) unsigned NOT NULL,
  `displayorder` tinyint(1) NOT NULL,
  `costprice` decimal(8,2) NOT NULL,
  PRIMARY KEY (`tid`,`pid`),
  KEY `sellerid` (`sellerid`),
  KEY `totalitems` (`totalitems`),
  KEY `tradesum` (`tradesum`),
  KEY `displayorder` (`tid`,`displayorder`),
  KEY `sellertrades` (`sellerid`,`tradesum`,`totalitems`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_typemodels`
--

CREATE TABLE IF NOT EXISTS `discuz_typemodels` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `options` mediumtext NOT NULL,
  `customoptions` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=101 ;

--
-- 转存表中的数据 `discuz_typemodels`
--

INSERT INTO `discuz_typemodels` (`id`, `name`, `displayorder`, `type`, `options`, `customoptions`) VALUES
(1, '房屋交易信息', 0, 1, '7	10	13	65	66	68', ''),
(2, '车票交易信息', 0, 1, '55	56	58	67	7	13	68', ''),
(3, '兴趣交友信息', 0, 1, '8	9	31', ''),
(4, '公司招聘信息', 0, 1, '34	48	54	51	47	46	44	45	52	53', '');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_typeoptions`
--

CREATE TABLE IF NOT EXISTS `discuz_typeoptions` (
  `optionid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `identifier` varchar(40) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `rules` mediumtext NOT NULL,
  PRIMARY KEY (`optionid`),
  KEY `classid` (`classid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=3001 ;

--
-- 转存表中的数据 `discuz_typeoptions`
--

INSERT INTO `discuz_typeoptions` (`optionid`, `classid`, `displayorder`, `title`, `description`, `identifier`, `type`, `rules`) VALUES
(1, 0, 0, '通用类', '', '', '', ''),
(2, 0, 0, '房产类', '', '', '', ''),
(3, 0, 0, '交友类', '', '', '', ''),
(4, 0, 0, '求职招聘类', '', '', '', ''),
(5, 0, 0, '交易类', '', '', '', ''),
(6, 0, 0, '互联网类', '', '', '', ''),
(7, 1, 0, '姓名', '', 'name', 'text', ''),
(9, 1, 0, '年龄', '', 'age', 'number', ''),
(10, 1, 0, '地址', '', 'address', 'text', ''),
(11, 1, 0, 'QQ', '', 'qq', 'number', ''),
(12, 1, 0, '邮箱', '', 'mail', 'email', ''),
(13, 1, 0, '电话', '', 'phone', 'text', ''),
(14, 5, 0, '培训费用', '', 'teach_pay', 'text', ''),
(15, 5, 0, '培训时间', '', 'teach_time', 'text', ''),
(20, 2, 0, '楼层', '', 'floor', 'number', ''),
(21, 2, 0, '交通状况', '', 'traf', 'textarea', ''),
(22, 2, 0, '地图', '', 'images', 'image', ''),
(24, 2, 0, '价格', '', 'price', 'text', ''),
(26, 5, 0, '培训名称', '', 'teach_name', 'text', ''),
(28, 3, 0, '身高', '', 'heighth', 'number', ''),
(29, 3, 0, '体重', '', 'weighth', 'number', ''),
(33, 1, 0, '照片', '', 'photo', 'image', ''),
(35, 5, 0, '服务方式', '', 'service_type', 'text', ''),
(36, 5, 0, '服务时间', '', 'service_time', 'text', ''),
(37, 5, 0, '服务费用', '', 'service_pay', 'text', ''),
(39, 6, 0, '网址', '', 'site_url', 'url', ''),
(40, 6, 0, '电子邮件', '', 'site_mail', 'email', ''),
(42, 6, 0, '网站名称', '', 'site_name', 'text', ''),
(46, 4, 0, '职位', '', 'recr_intend', 'text', ''),
(47, 4, 0, '工作地点', '', 'recr_palce', 'text', ''),
(49, 4, 0, '有效期至', '', 'recr_end', 'calendar', ''),
(51, 4, 0, '公司名称', '', 'recr_com', 'text', ''),
(52, 4, 0, '年龄要求', '', 'recr_age', 'text', ''),
(54, 4, 0, '专业', '', 'recr_abli', 'text', ''),
(55, 5, 0, '始发', '', 'leaves', 'text', ''),
(56, 5, 0, '终点', '', 'boundfor', 'text', ''),
(57, 6, 0, 'Alexa排名', '', 'site_top', 'number', ''),
(58, 5, 0, '车次/航班', '', 'train_no', 'text', ''),
(59, 5, 0, '数量', '', 'trade_num', 'number', ''),
(60, 5, 0, '价格', '', 'trade_price', 'text', ''),
(61, 5, 0, '有效期至', '', 'trade_end', 'calendar', ''),
(63, 1, 0, '详细描述', '', 'detail_content', 'textarea', ''),
(64, 1, 0, '籍贯', '', 'born_place', 'text', ''),
(65, 2, 0, '租金', '', 'money', 'text', ''),
(66, 2, 0, '面积', '', 'acreage', 'text', ''),
(67, 5, 0, '发车时间', '', 'time', 'calendar', 'N;'),
(68, 1, 0, '所在地', '', 'now_place', 'text', ''),
(8, 1, 2, '性别', '', 'gender', 'radio', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:10:"1=男\r\n2=女";}'),
(16, 2, 0, '房屋类型', '', 'property', 'select', 'a:1:{s:7:"choices";s:50:"1=写字楼\r\n2=公寓\r\n3=小区\r\n4=平房\r\n5=别墅\r\n6=地下室";}'),
(17, 2, 0, '座向', '', 'face', 'radio', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:30:"1=南向\r\n2=北向\r\n3=西向\r\n4=东向";}'),
(18, 2, 0, '装修情况', '', 'makes', 'radio', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:30:"1=无装修\r\n2=简单装修\r\n3=精装修";}'),
(19, 2, 0, '居室', '', 'mode', 'select', 'a:1:{s:7:"choices";s:44:"1=独居\r\n2=两居室\r\n3=三居室\r\n4=四居室\r\n5=别墅";}'),
(23, 2, 0, '屋内设施', '', 'equipment', 'checkbox', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:131:"1=水电\r\n2=宽带\r\n3=管道气\r\n4=有线电视\r\n5=电梯\r\n6=电话\r\n7=冰箱\r\n8=洗衣机\r\n9=热水器\r\n10=空调\r\n11=暖气\r\n12=微波炉\r\n13=油烟机\r\n14=饮水机";}'),
(25, 2, 0, '是否中介', '', 'bool', 'radio', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:10:"1=是\r\n2=否";}'),
(27, 3, 0, '星座', '', 'Horoscope', 'select', 'a:1:{s:7:"choices";s:121:"1=白羊座\r\n2=金牛座\r\n3=双子座\r\n4=巨蟹座\r\n5=狮子座\r\n6=处女座\r\n7=天秤座\r\n8=天蝎座\r\n9=射手座\r\n10=摩羯座\r\n11=水瓶座\r\n12=双鱼座";}'),
(30, 3, 0, '婚姻状况', '', 'marrige', 'radio', 'a:1:{s:7:"choices";s:14:"1=已婚\r\n2=未婚";}'),
(31, 3, 0, '爱好', '', 'hobby', 'checkbox', 'a:1:{s:7:"choices";s:196:"1=美食\r\n2=唱歌\r\n3=跳舞\r\n4=电影\r\n5=音乐\r\n6=戏剧\r\n7=聊天\r\n8=拍托\r\n9=电脑\r\n10=网络\r\n11=游戏\r\n12=绘画\r\n13=书法\r\n14=雕塑\r\n15=异性\r\n16=阅读\r\n17=运动\r\n18=旅游\r\n19=八卦\r\n20=购物\r\n21=赚钱\r\n22=汽车\r\n23=摄影";}'),
(32, 3, 0, '收入范围', '', 'salary', 'select', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:89:"1=保密\r\n2=800元以上\r\n3=1500元以上\r\n4=2000元以上\r\n5=3000元以上\r\n6=5000元以上\r\n7=8000元以上";}'),
(34, 1, 0, '学历', '', 'education', 'radio', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:72:"1=文盲\r\n2=小学\r\n3=初中\r\n4=高中\r\n5=中专\r\n6=大专\r\n7=本科\r\n8=研究生\r\n9=博士";}'),
(38, 5, 0, '席别', '', 'seats', 'select', 'a:1:{s:7:"choices";s:38:"1=站票\r\n2=硬座\r\n3=软座\r\n4=硬卧\r\n5=软卧";}'),
(44, 4, 0, '是否应届', '', 'recr_term', 'radio', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:16:"1=应届\r\n2=非应届";}'),
(48, 4, 0, '薪金', '', 'recr_salary', 'select', 'a:1:{s:7:"choices";s:108:"1=面议\r\n2=1000以下\r\n3=1000~1500\r\n4=1500~2000\r\n5=2000~3000\r\n6=3000~4000\r\n7=4000~6000\r\n8=6000~8000\r\n9=8000以上";}'),
(50, 4, 0, '工作性质', '', 'recr_work', 'radio', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:14:"1=全职\r\n2=兼职";}'),
(53, 4, 0, '性别要求', '', 'recr_sex', 'checkbox', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:10:"1=男\r\n2=女";}'),
(62, 5, 0, '付款方式', '', 'pay_type', 'checkbox', 'a:3:{s:8:"required";s:1:"0";s:12:"unchangeable";s:1:"0";s:7:"choices";s:32:"1=电汇\r\n2=支付宝\r\n3=现金\r\n4=其他";}');

-- --------------------------------------------------------

--
-- 表的结构 `discuz_typeoptionvars`
--

CREATE TABLE IF NOT EXISTS `discuz_typeoptionvars` (
  `typeid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `optionid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `value` mediumtext NOT NULL,
  KEY `typeid` (`typeid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_typevars`
--

CREATE TABLE IF NOT EXISTS `discuz_typevars` (
  `typeid` smallint(6) NOT NULL DEFAULT '0',
  `optionid` smallint(6) NOT NULL DEFAULT '0',
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `unchangeable` tinyint(1) NOT NULL DEFAULT '0',
  `search` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  UNIQUE KEY `optionid` (`typeid`,`optionid`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_usergroups`
--

CREATE TABLE IF NOT EXISTS `discuz_usergroups` (
  `groupid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `radminid` tinyint(3) NOT NULL DEFAULT '0',
  `type` enum('system','special','member') NOT NULL DEFAULT 'member',
  `system` char(8) NOT NULL DEFAULT 'private',
  `grouptitle` char(30) NOT NULL DEFAULT '',
  `creditshigher` int(10) NOT NULL DEFAULT '0',
  `creditslower` int(10) NOT NULL DEFAULT '0',
  `stars` tinyint(3) NOT NULL DEFAULT '0',
  `color` char(7) NOT NULL DEFAULT '',
  `groupavatar` char(60) NOT NULL DEFAULT '',
  `readaccess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `allowvisit` tinyint(1) NOT NULL DEFAULT '0',
  `allowpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowreply` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostpoll` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostreward` tinyint(1) NOT NULL DEFAULT '0',
  `allowposttrade` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostactivity` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostvideo` tinyint(1) NOT NULL DEFAULT '0',
  `allowdirectpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowgetattach` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostattach` tinyint(1) NOT NULL DEFAULT '0',
  `allowvote` tinyint(1) NOT NULL DEFAULT '0',
  `allowmultigroups` tinyint(1) NOT NULL DEFAULT '0',
  `allowsearch` tinyint(1) NOT NULL DEFAULT '0',
  `allowavatar` tinyint(1) NOT NULL DEFAULT '0',
  `allowcstatus` tinyint(1) NOT NULL DEFAULT '0',
  `allowuseblog` tinyint(1) NOT NULL DEFAULT '0',
  `allowinvisible` tinyint(1) NOT NULL DEFAULT '0',
  `allowtransfer` tinyint(1) NOT NULL DEFAULT '0',
  `allowsetreadperm` tinyint(1) NOT NULL DEFAULT '0',
  `allowsetattachperm` tinyint(1) NOT NULL DEFAULT '0',
  `allowhidecode` tinyint(1) NOT NULL DEFAULT '0',
  `allowhtml` tinyint(1) NOT NULL DEFAULT '0',
  `allowcusbbcode` tinyint(1) NOT NULL DEFAULT '0',
  `allowanonymous` tinyint(1) NOT NULL DEFAULT '0',
  `allownickname` tinyint(1) NOT NULL DEFAULT '0',
  `allowsigbbcode` tinyint(1) NOT NULL DEFAULT '0',
  `allowsigimgcode` tinyint(1) NOT NULL DEFAULT '0',
  `allowviewpro` tinyint(1) NOT NULL DEFAULT '0',
  `allowviewstats` tinyint(1) NOT NULL DEFAULT '0',
  `disableperiodctrl` tinyint(1) NOT NULL DEFAULT '0',
  `reasonpm` tinyint(1) NOT NULL DEFAULT '0',
  `maxprice` smallint(6) unsigned NOT NULL DEFAULT '0',
  `maxpmnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `maxsigsize` smallint(6) unsigned NOT NULL DEFAULT '0',
  `maxattachsize` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `maxsizeperday` int(10) unsigned NOT NULL DEFAULT '0',
  `maxpostsperhour` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `attachextensions` char(100) NOT NULL DEFAULT '',
  `raterange` char(150) NOT NULL DEFAULT '',
  `mintradeprice` smallint(6) unsigned NOT NULL DEFAULT '1',
  `maxtradeprice` smallint(6) unsigned NOT NULL DEFAULT '0',
  `minrewardprice` smallint(6) NOT NULL DEFAULT '1',
  `maxrewardprice` smallint(6) NOT NULL DEFAULT '0',
  `magicsdiscount` tinyint(1) NOT NULL,
  `allowmagics` tinyint(1) unsigned NOT NULL,
  `maxmagicsweight` smallint(6) unsigned NOT NULL,
  `allowbiobbcode` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `allowbioimgcode` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `maxbiosize` smallint(6) unsigned NOT NULL DEFAULT '0',
  `allowinvite` tinyint(1) NOT NULL DEFAULT '0',
  `allowmailinvite` tinyint(1) NOT NULL DEFAULT '0',
  `maxinvitenum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `inviteprice` smallint(6) unsigned NOT NULL DEFAULT '0',
  `maxinviteday` smallint(6) unsigned NOT NULL DEFAULT '0',
  `allowpostdebate` tinyint(1) NOT NULL DEFAULT '0',
  `tradestick` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`groupid`),
  KEY `creditsrange` (`creditshigher`,`creditslower`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `discuz_usergroups`
--

INSERT INTO `discuz_usergroups` (`groupid`, `radminid`, `type`, `system`, `grouptitle`, `creditshigher`, `creditslower`, `stars`, `color`, `groupavatar`, `readaccess`, `allowvisit`, `allowpost`, `allowreply`, `allowpostpoll`, `allowpostreward`, `allowposttrade`, `allowpostactivity`, `allowpostvideo`, `allowdirectpost`, `allowgetattach`, `allowpostattach`, `allowvote`, `allowmultigroups`, `allowsearch`, `allowavatar`, `allowcstatus`, `allowuseblog`, `allowinvisible`, `allowtransfer`, `allowsetreadperm`, `allowsetattachperm`, `allowhidecode`, `allowhtml`, `allowcusbbcode`, `allowanonymous`, `allownickname`, `allowsigbbcode`, `allowsigimgcode`, `allowviewpro`, `allowviewstats`, `disableperiodctrl`, `reasonpm`, `maxprice`, `maxpmnum`, `maxsigsize`, `maxattachsize`, `maxsizeperday`, `maxpostsperhour`, `attachextensions`, `raterange`, `mintradeprice`, `maxtradeprice`, `minrewardprice`, `maxrewardprice`, `magicsdiscount`, `allowmagics`, `maxmagicsweight`, `allowbiobbcode`, `allowbioimgcode`, `maxbiosize`, `allowinvite`, `allowmailinvite`, `maxinvitenum`, `inviteprice`, `maxinviteday`, `allowpostdebate`, `tradestick`) VALUES
(1, 1, 'system', 'private', '管理员', 0, 0, 9, '', '', 200, 1, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 2, 3, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 30, 200, 500, 2048000, 0, 0, '', '1	-30	30	500', 1, 0, 1, 0, 0, 2, 200, 2, 2, 0, 0, 0, 0, 0, 0, 1, 5),
(2, 2, 'system', 'private', '超级版主', 0, 0, 8, '', '', 150, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 0, 20, 120, 300, 2048000, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '1	-15	15	50', 1, 0, 1, 0, 0, 2, 180, 2, 2, 0, 0, 0, 0, 0, 0, 1, 5),
(3, 3, 'system', 'private', '版主', 0, 0, 7, '', '', 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 0, 10, 80, 200, 2048000, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '1	-10	10	30', 1, 0, 1, 0, 0, 2, 160, 2, 2, 0, 0, 0, 0, 0, 0, 1, 5),
(4, 0, 'system', 'private', '禁止发言', 0, 0, 0, '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(5, 0, 'system', 'private', '禁止访问', 0, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(6, 0, 'system', 'private', '禁止 IP', 0, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(7, 0, 'system', 'private', '游客', 0, 0, 0, '', '', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 'gif,jpg,jpeg,png', '', 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(8, 0, 'system', 'private', '等待验证会员', 0, 0, 0, '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 50, 0, 0, 0, '', '', 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(9, 0, 'member', 'private', '乞丐', -9999999, 0, 0, '', '', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'chm,pdf,zip,rar,tar,gz,bzip2,gif,jpg,jpeg,png', '', 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
(10, 0, 'member', 'private', '新手上路', 0, 50, 1, '', '', 10, 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 20, 80, 0, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '', 1, 0, 1, 0, 0, 1, 40, 1, 1, 0, 0, 0, 0, 0, 0, 1, 5),
(11, 0, 'member', 'private', '注册会员', 50, 200, 2, '', '', 20, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 0, 0, 0, 30, 100, 0, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '', 1, 0, 1, 0, 0, 1, 60, 1, 1, 0, 0, 0, 0, 0, 0, 1, 5),
(12, 0, 'member', 'private', '中级会员', 200, 500, 3, '', '', 30, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 1, 1, 0, 0, 0, 50, 150, 256000, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '', 1, 0, 1, 0, 0, 1, 80, 1, 1, 0, 0, 0, 0, 0, 0, 1, 5),
(13, 0, 'member', 'private', '高级会员', 500, 1000, 4, '', '', 50, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 3, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 0, 1, 1, 0, 0, 0, 60, 200, 512000, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '1	-10	10	30', 1, 0, 1, 0, 0, 2, 100, 2, 2, 0, 0, 0, 0, 0, 0, 1, 5),
(14, 0, 'member', 'private', '金牌会员', 1000, 3000, 6, '', '', 70, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 3, 1, 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0, 80, 300, 1024000, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '1	-15	15	40', 1, 0, 1, 0, 0, 2, 120, 2, 2, 0, 0, 0, 0, 0, 0, 1, 5),
(15, 0, 'member', 'private', '论坛元老', 3000, 9999999, 8, '', '', 90, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 3, 1, 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 100, 500, 2048000, 0, 0, 'chm, pdf, zip, rar, tar, gz, bzip2, gif, jpg, jpeg, png', '1	-20	20	50', 1, 0, 1, 0, 0, 2, 140, 2, 2, 0, 0, 0, 0, 0, 0, 1, 5);

-- --------------------------------------------------------

--
-- 表的结构 `discuz_validating`
--

CREATE TABLE IF NOT EXISTS `discuz_validating` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `submitdate` int(10) unsigned NOT NULL DEFAULT '0',
  `moddate` int(10) unsigned NOT NULL DEFAULT '0',
  `admin` varchar(15) NOT NULL DEFAULT '',
  `submittimes` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `remark` text NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_videos`
--

CREATE TABLE IF NOT EXISTS `discuz_videos` (
  `vid` varchar(16) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `vtype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vview` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `vtime` smallint(6) unsigned NOT NULL DEFAULT '0',
  `visup` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vthumb` varchar(128) NOT NULL DEFAULT '',
  `vtitle` varchar(64) NOT NULL DEFAULT '',
  `vclass` varchar(32) NOT NULL DEFAULT '',
  `vautoplay` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`),
  UNIQUE KEY `uid` (`vid`,`uid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_videotags`
--

CREATE TABLE IF NOT EXISTS `discuz_videotags` (
  `tagname` char(10) NOT NULL DEFAULT '',
  `vid` char(14) NOT NULL DEFAULT '',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `tagname` (`tagname`,`vid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `discuz_words`
--

CREATE TABLE IF NOT EXISTS `discuz_words` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(15) NOT NULL DEFAULT '',
  `find` varchar(255) NOT NULL DEFAULT '',
  `replacement` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
