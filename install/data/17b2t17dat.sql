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


// archive table
ALTER TABLE `ncaster_archive` CHANGE `unixdate` `unixdate` INT( 10 ) DEFAULT NULL;

// build table
ALTER TABLE `ncaster_build` ADD `start_row` INT( 20 ) NOT NULL ,
ADD `sortby` VARCHAR( 6 ) DEFAULT 'DESC' NOT NULL ,
ADD `filter` TEXT NOT NULL ,
ADD `buildkey` VARCHAR( 20 ) NOT NULL ;

// categorys table
ALTER TABLE `ncaster_categorys` ADD `is_hub` TINYINT( 1 ) NOT NULL ,
ADD `relate_to` INT( 10 ) NOT NULL ,
ADD `new_title` VARCHAR( 255 ) NOT NULL ,
ADD `new_description` VARCHAR( 255 ) NOT NULL ,
ADD `new_article` VARCHAR( 255 ) NOT NULL ,
ADD `allow_uploads` TINYINT( 1 ) NOT NULL ,
ADD `allow_groups` TEXT NOT NULL ,
ADD `enable_br` TINYINT( 1 ) NOT NULL ,
ADD `enable_bump` TINYINT( 1 ) NOT NULL ,
ADD `enable_watermark` TINYINT( 1 ) NOT NULL ,
ADD `enable_sticky` TINYINT( 1 ) NOT NULL ,
ADD `relate_txt` VARCHAR( 255 ) ;

// news table
ALTER TABLE `ncaster_news` CHANGE `page` `page` BIGINT( 20 ) DEFAULT NULL;
ALTER TABLE `ncaster_news` DROP INDEX `uniq`;
ALTER TABLE `ncaster_news` ADD INDEX ( `page` );
ALTER TABLE `ncaster_news` ADD INDEX ( `uniq` );
UPDATE `ncaster_news` SET page=NULL;

// news custom table
ALTER TABLE `ncaster_newscustom` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT,
CHANGE `identity` `identity` VARCHAR( 30 ) DEFAULT NULL;
ALTER TABLE `ncaster_newscustom` ADD INDEX ( `identity` );