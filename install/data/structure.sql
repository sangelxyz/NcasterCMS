# phpMyAdmin MySQL-Dump
# version 2.3.0-rc4
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Sep 22, 2003 at 06:01 PM
# Server version: 3.23.43
# PHP Version: 4.3.0
# Database : `datest2`
# --------------------------------------------------------

#
# Table structure for table `ncaster_archive`
#

CREATE TABLE ncaster_archive (
  id mediumint(100) NOT NULL auto_increment,
  date varchar(100) default NULL,
  unixdate int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_build`
#

CREATE TABLE ncaster_build (
  id mediumint(100) NOT NULL auto_increment,
  db varchar(100) default NULL,
  template mediumint(100) default NULL,
  savefile text,
  articles varchar(100) default NULL,
  tag varchar(100) default NULL,
  templateid varchar(100) default NULL,
  compiled text NOT NULL,
  mode tinyint(2) NOT NULL default '0',
  start_row int(20) NOT NULL default '0',
  sortby varchar(6) NOT NULL default 'DESC',
  filter text NOT NULL,
  buildkey varchar(20) NOT NULL default '',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_categorys`
#

CREATE TABLE ncaster_categorys (
  cid int(10) NOT NULL auto_increment,
  cperent bigint(80) NOT NULL default '0',
  clayer bigint(80) NOT NULL default '0',
  sortid bigint(80) NOT NULL default '0',
  cname varchar(100) default NULL,
  mergelist bigint(80) NOT NULL default '0',
  filterlist bigint(80) NOT NULL default '0',
  filtersplist bigint(80) NOT NULL default '0',
  redirectlist bigint(80) NOT NULL default '0',
  template bigint(80) NOT NULL default '0',
  template2 bigint(80) NOT NULL default '0',
  permissions tinyint(10) NOT NULL default '0',
  avatar text NOT NULL,
  is_hub tinyint(1) NOT NULL default '0',
  relate_to int(10) NOT NULL default '0',
  new_title varchar(255) NOT NULL default '',
  new_description varchar(255) NOT NULL default '',
  new_article varchar(255) NOT NULL default '',
  allow_uploads tinyint(1) NOT NULL default '0',
  allow_groups text NOT NULL,
  enable_br tinyint(1) NOT NULL default '0',
  enable_bump tinyint(1) NOT NULL default '0',
  enable_watermark tinyint(1) NOT NULL default '0',
  enable_sticky tinyint(1) NOT NULL default '0',
  relate_txt varchar(255) default NULL,
  PRIMARY KEY  (cid),
  UNIQUE KEY cid (cid),
  KEY cperent (cperent),
  KEY clayer (clayer),
  KEY sortid (sortid),
  KEY template (template),
  KEY template2 (template2)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_counter`
#

CREATE TABLE ncaster_counter (
  id mediumint(100) NOT NULL auto_increment,
  uniq text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_fieldtypes`
#

CREATE TABLE ncaster_fieldtypes (
  id mediumint(100) NOT NULL auto_increment,
  profilename varchar(255) default NULL,
  options text,
  btype varchar(255) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_ncauth`
#

CREATE TABLE ncaster_ncauth (
  id int(10) NOT NULL auto_increment,
  name varchar(32) default NULL,
  pass varchar(32) NOT NULL default '',
  level int(10) NOT NULL default '0',
  email varchar(80) NOT NULL default '',
  realname varchar(80) default NULL,
  info text,
  hobbys text,
  aim varchar(80) default NULL,
  icq varchar(80) default NULL,
  msn varchar(80) default NULL,
  yahoo varchar(80) default NULL,
  birthdate varchar(80) default NULL,
  gender varchar(6) default NULL,
  html_editor varchar(10) default NULL,
  nccode_editor varchar(10) default NULL,
  language varchar(80) default NULL,
  avartar varchar(80) default NULL,
  UNIQUE KEY id (id),
  KEY name (name)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_news`
#

CREATE TABLE ncaster_news (
  id bigint(20) NOT NULL auto_increment,
  uniq bigint(20) NOT NULL default '0',
  title varchar(255) default NULL,
  description text,
  author varchar(32) default NULL,
  submitted int(10) default NULL,
  article text,
  catogory varchar(100) default NULL,
  arctime varchar(100) default NULL,
  page bigint(20) default NULL,
  hits bigint(100) NOT NULL default '0',
  sticky tinyint(1) default NULL,
  category_id int(10) NOT NULL default '0',
  author_id int(10) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY author_id (author_id),
  KEY page (page),
  KEY category_id (category_id),
  KEY uniq (uniq)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_newscustom`
#

CREATE TABLE ncaster_newscustom (
  id bigint(20) NOT NULL default '0',
  uniq bigint(20) default NULL,
  identity varchar(30) default NULL,
  catogory varchar(100) default NULL,
  custom text,
  category_id int(10) NOT NULL default '0',
  KEY identity (identity),
  KEY uniq (uniq,category_id),
  KEY id (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_nfields`
#

CREATE TABLE ncaster_nfields (
  id mediumint(100) NOT NULL auto_increment,
  title varchar(100) default NULL,
  type varchar(10) default NULL,
  value text,
  sizew varchar(10) default NULL,
  sizeh varchar(10) default NULL,
  subject varchar(100) default NULL,
  display char(3) default NULL,
  catogory varchar(100) default NULL,
  forder int(3) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_sessions`
#

CREATE TABLE ncaster_sessions (
  id int(10) NOT NULL auto_increment,
  sess_key varchar(32) NOT NULL default '',
  val int(10) NOT NULL default '0',
  ip varchar(16) NOT NULL default '',
  access int(25) NOT NULL default '0',
  type tinyint(1) NOT NULL default '0',
  in_page bigint(80) NOT NULL default '0',
  in_module varchar(20) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY sess_key (sess_key),
  KEY in_page (in_page),
  KEY in_module (in_module)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `ncaster_templates`
#

CREATE TABLE ncaster_templates (
  id mediumint(100) NOT NULL auto_increment,
  title varchar(80) default NULL,
  template text,
  type varchar(100) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY id (id),
  KEY title (title)
) TYPE=MyISAM;

