-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************
-------------------------------------------------------------

-- 
-- Table `tl_pm`
-- 

CREATE TABLE `tl_pm` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `sender` int(10) unsigned NOT NULL default '0',
  `recipient` int(10) unsigned NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `message` text NULL,
  `status` int(1) NOT NULL default '0',
  `senderDeleted` char(1) NOT NULL default '',
  `recipientDeleted` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-------------------------------------------------------------

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `pmShowEmpty` char(1) NOT NULL default '',
  `pmAllowNewGroups` blob NULL,
  `pmAllowReplyGroups` blob NULL,
  `pmJumpToReader` int(10) NOT NULL default '0',
  `pmJumpToWriter` int(10) NOT NULL default '0',
  `pmJumpToList` int(10) NOT NULL default '0',
  `pmFolder` varchar(10) NOT NULL default '',
  `pmInput` varchar(10) NOT NULL default '',
  `pmFields` blob NULL,
  `pmFormat` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-------------------------------------------------------------

-- 
-- Table `tl_member`
-- 

CREATE TABLE `tl_member` (
  `pmNotify` char(1) NOT NULL default '',
  `pmDisable` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

