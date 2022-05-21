# The multi pages in articles stuture has changed we need
# to null all the page values so we can use the new pages engine
# however it is no longer compatable with any articles that where multipaged in 1.6.5
# not all that many knew how to use it any way.

// approve table
CREATE TABLE ncaster_notapproved (
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


UPDATE `ncaster_news` SET page=NULL;

# change archive to init type
ALTER TABLE `ncaster_archive` CHANGE `unixdate` `unixdate` INT( 10 ) DEFAULT NULL;

# alter build table

ALTER TABLE `ncaster_build` ADD `compiled` TEXT NOT NULL ,
ADD `mode` TINYINT( 2 ) NOT NULL ,
ADD `start_row` INT( 20 ) NOT NULL ,
ADD `sortby` VARCHAR( 6 ) NOT NULL ,
ADD `filter` TEXT NOT NULL ,
ADD `buildkey` VARCHAR( 20 ) NOT NULL ;


# create categorys table

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

# create field types table
CREATE TABLE ncaster_fieldtypes (
  id mediumint(100) NOT NULL auto_increment,
  profilename varchar(255) default NULL,
  options text,
  btype varchar(255) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
) TYPE=MyISAM;

# now the nc-auth table

# drop pr key
ALTER TABLE `ncaster_ncauth` DROP PRIMARY KEY;

# alter
ALTER TABLE `ncaster_ncauth` ADD `id` INT( 10 ) NOT NULL FIRST ;

# add key
ALTER TABLE `ncaster_ncauth` DROP PRIMARY KEY ,
ADD UNIQUE (
`id` 
); 

# make auto
ALTER TABLE `ncaster_ncauth` CHANGE `id` `id` INT( 10 ) DEFAULT '0' NOT NULL AUTO_INCREMENT; 

# add index for name field
ALTER TABLE `ncaster_ncauth` ADD INDEX ( `name` ) ;

#change name to 32 chars
ALTER TABLE `ncaster_ncauth` CHANGE `name` `name` VARCHAR( 32 ) NOT NULL;

#change pass to 32
ALTER TABLE `ncaster_ncauth` CHANGE `pass` `pass` VARCHAR( 32 ) NOT NULL;

# add new fields. to ncauth
ALTER TABLE `ncaster_ncauth` ADD `realname` VARCHAR( 80 ) NOT NULL ,
ADD `info` TEXT NOT NULL ,
ADD `hobbys` TEXT NOT NULL ,
ADD `aim` VARCHAR( 80 ) NOT NULL ,
ADD `icq` VARCHAR( 80 ) NOT NULL ,
ADD `msn` VARCHAR( 80 ) NOT NULL ,
ADD `yahoo` VARCHAR( 80 ) NOT NULL ,
ADD `birthdate` VARCHAR( 80 ) NOT NULL ,
ADD `gender` VARCHAR( 6 ) NOT NULL ,
ADD `html_editor` VARCHAR( 10 ) NOT NULL ,
ADD `nccode_editor` VARCHAR( 10 ) NOT NULL ,
ADD `language` VARCHAR( 80 ) NOT NULL ,
ADD `avartar` VARCHAR( 80 ) NOT NULL ;

# full page
DROP TABLE `ncaster_fullpage`;

# news style
DROP TABLE `ncaster_newsstyle`;

# now news table
# alter id
ALTER TABLE `ncaster_news` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;

# alter uniq
ALTER TABLE `ncaster_news` CHANGE `uniq` `uniq` BIGINT( 20 ) DEFAULT NULL ;

# alter title
ALTER TABLE `ncaster_news` CHANGE `title` `title` VARCHAR( 255 ) DEFAULT NULL;

# alter author
ALTER TABLE `ncaster_news` CHANGE `author` `author` VARCHAR( 32 ) DEFAULT NULL;

# alter submited
ALTER TABLE `ncaster_news` CHANGE `submitted` `submitted` INT( 10 ) DEFAULT NULL ;

# alter page
ALTER TABLE `ncaster_news` CHANGE `page` `page` BIGINT( 20 ) DEFAULT NULL ;

#alter hits
ALTER TABLE `ncaster_news` CHANGE `hits` `hits` BIGINT( 100 ) DEFAULT NULL;

#drop ratting
ALTER TABLE `ncaster_news` DROP `ratting` ;

#add fields
ALTER TABLE `ncaster_news` ADD `sticky` TINYINT( 1 ) NOT NULL ,
ADD `category_id` INT( 10 ) NOT NULL ,
ADD `author_id` INT( 10 ) NOT NULL ;

#add index's
ALTER TABLE `ncaster_news` ADD INDEX ( `author_id` ) ;
ALTER TABLE `ncaster_news` ADD INDEX ( `page` ) ;
ALTER TABLE `ncaster_news` ADD INDEX ( `category_id` ) ;
ALTER TABLE `ncaster_news` ADD INDEX ( `uniq` ) ;

# news custom table
# alter id
ALTER TABLE `ncaster_newscustom` CHANGE `id` `id` BIGINT( 20 ) NOT NULL; 

ALTER TABLE `ncaster_newscustom` DROP PRIMARY KEY , ADD INDEX ( `id` );

# alter uniq
ALTER TABLE `ncaster_newscustom` CHANGE `uniq` `uniq` BIGINT( 20 ) DEFAULT NULL ;

# identity
ALTER TABLE `ncaster_newscustom` CHANGE `identity` `identity` VARCHAR( 30 ) DEFAULT NULL  ;

#category
ALTER TABLE `ncaster_newscustom` CHANGE `catogory` `catogory` VARCHAR( 100 ) DEFAULT NULL ;

# add fields
ALTER TABLE `ncaster_newscustom` ADD `category_id` INT( 10 ) NOT NULL ;

#add indexs
ALTER TABLE `ncaster_newscustom` ADD INDEX ( `identity` ) ;
ALTER TABLE `ncaster_newscustom` ADD INDEX ( `category_id` , `uniq` );

# nfields
# note categorys is for each is now integer.
# update set category=$newc[id] where c=news

ALTER TABLE `ncaster_nfields` ADD `forder` INT( 3 ) NOT NULL ;

# sessions
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