/*!40101 SET NAMES utf8 */;


/* AÑADIR is_localized ? */

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `attributes_types` */

DROP TABLE IF EXISTS `attributes_types`;

CREATE TABLE `attributes_types` (
  `type_id` int(45) NOT NULL default '0',
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `is_principal` tinyint(3) unsigned default '0',
  `weight` int(10) unsigned default '0',
  PRIMARY KEY  (`type_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `contents` */

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type_id` int(10) unsigned default '0',
  `title` varchar(255) default NULL,
  `brief` text,
 	`body` text,
  `created` datetime default '0000-00-00 00:00:00',
  `updated` datetime default '0000-00-00 00:00:00',
  `file_name` varchar(255) default NULL,
  `original_file_name` varchar(255) default NULL,
  `weight` int(10) unsigned default '0',
  `status` tinyint(3) unsigned default '0',
  `page_template` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `contents_attributes` */

DROP TABLE IF EXISTS `contents_attributes`;

CREATE TABLE `contents_attributes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` varchar(45) NOT NULL default '',
  `keyword` varchar(45) NOT NULL default '',
  `weight` tinyint(4) default NULL,
  `multilang` tinyint(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `contents_boolean` */

DROP TABLE IF EXISTS `contents_boolean`;

CREATE TABLE `contents_boolean` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `value` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `contents_datetime` */

DROP TABLE IF EXISTS `contents_datetime`;

CREATE TABLE `contents_datetime` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `contents_float` */

DROP TABLE IF EXISTS `contents_float`;

CREATE TABLE `contents_float` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `value` float NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Table structure for table `contents_integer` */

DROP TABLE IF EXISTS `contents_integer`;

CREATE TABLE `contents_integer` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `value` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `contents_sections` */

DROP TABLE IF EXISTS `contents_sections`;

CREATE TABLE `contents_sections` (
  `content_id` int(10) unsigned NOT NULL auto_increment,
  `section_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`content_id`,`section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Table structure for table `contents_string` */

DROP TABLE IF EXISTS `contents_string`;

CREATE TABLE `contents_string` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `contents_taxonomy` */

DROP TABLE IF EXISTS `contents_taxonomy`;

CREATE TABLE `contents_taxonomy` (
  `content_id` int(10) unsigned NOT NULL default '0',
  `taxonomyterm_id` int(10) unsigned NOT NULL default '0',
  `taxonomytype_id` int(10) unsigned NOT NULL default '0' COMMENT 'redundant',
  PRIMARY KEY  (`taxonomyterm_id`,`content_id`,`taxonomytype_id`),
  KEY `Index_1` (`taxonomyterm_id`,`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `contents_text` */

DROP TABLE IF EXISTS `contents_text`;

CREATE TABLE `contents_text` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `attribute_id` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `cross_references` */

DROP TABLE IF EXISTS `cross_references`;

CREATE TABLE `cross_references` (
  `content_id` int(10) unsigned NOT NULL auto_increment,
  `content_id_refered` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`content_id`,`content_id_refered`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `file_name` varchar(45) NOT NULL default '',
  `description` varchar(225) NOT NULL default '',
  `weight` int(10) unsigned NOT NULL default '0',
  `extension` varchar(5) NOT NULL default '',
  `original_name` varchar(225) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `images` */

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned NOT NULL default '0',
  `file_name` varchar(45) NOT NULL default '',
  `description` mediumtext,
  `weight` int(10) unsigned NOT NULL default '0',
  `extension` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `requests` */

DROP TABLE IF EXISTS `requests`;

CREATE TABLE `requests` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(150) default NULL,
  `lastname` varchar(150) default NULL,
  `arrival` date default NULL,
  `departure` date default NULL,
  `people` tinyint(4) default '0',
  `adults` tinyint(4) default '0',
  `children` tinyint(4) default '0',
  `prefference_smoking` varchar(150) default NULL,
  `prefference_beds` varchar(150) default NULL,
  `roomtype_id` int(11) default NULL,
  `email` varchar(150) default NULL,
  `phone` varchar(150) default NULL,
  `mobile` varchar(150) default NULL,
  `is_deleted` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `roomtypes` */

DROP TABLE IF EXISTS `roomtypes`;

CREATE TABLE `roomtypes` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(150) default NULL,
  `is_deleted` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `sections` */

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `file_name` varchar(45) default NULL,
  `original_file_name` varchar(255) default NULL,
  `parent_id` int(10) unsigned default '0',
  `public_name` varchar(255) default NULL,
  `has_brief` tinyint(3) unsigned default '0',
  `brief` mediumtext,
  `has_body` tinyint(3) unsigned default '0',
  `body` mediumtext COMMENT 'experimental',
  `page_file` varchar(255) default NULL,
  `is_node` tinyint(3) unsigned default '1',
  `weight` tinyint(3) unsigned default '0',
  `action` varchar(100) default NULL,
  `action_children` varchar(100) default NULL,
  `has_file` tinyint(4) default '0',
  `action_contents` varchar(100) default NULL COMMENT 'Disponible solo para modalidad contenido has one section',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `sections_attributes` */

DROP TABLE IF EXISTS `sections_attributes`;

CREATE TABLE `sections_attributes` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `keyword` varchar(50) default NULL,
  `type` varchar(50) default NULL,
  `weight` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Table structure for table `sections_values_boolean` */

DROP TABLE IF EXISTS `sections_values_boolean`;

CREATE TABLE `sections_values_boolean` (
  `section_id` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default '0',
  PRIMARY KEY  (`section_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sections_values_datetime` */

DROP TABLE IF EXISTS `sections_values_datetime`;

CREATE TABLE `sections_values_datetime` (
  `section_id` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`section_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sections_values_file` */

DROP TABLE IF EXISTS `sections_values_file`;

CREATE TABLE `sections_values_file` (
  `section_id` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`section_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sections_values_float` */

DROP TABLE IF EXISTS `sections_values_float`;

CREATE TABLE `sections_values_float` (
  `section_id` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`section_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sections_values_string` */

DROP TABLE IF EXISTS `sections_values_string`;

CREATE TABLE `sections_values_string` (
  `section_id` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`section_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sections_values_text` */

DROP TABLE IF EXISTS `sections_values_text`;

CREATE TABLE `sections_values_text` (
  `section_id` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` text,
  PRIMARY KEY  (`section_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `taxonomy_terms` */

DROP TABLE IF EXISTS `taxonomy_terms`;

CREATE TABLE `taxonomy_terms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `taxonomytype_id` int(10) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `taxonomy_types` */

DROP TABLE IF EXISTS `taxonomy_types`;

CREATE TABLE `taxonomy_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL default '',
  `multiple` tinyint(3) unsigned NOT NULL default '0',
  `plural` varchar(45) NOT NULL default '',
  `keyword` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `types` */

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `human_name` varchar(255) NOT NULL default '',
  `plural_human_name` varchar(45) NOT NULL default '',
  `has_brief` tinyint(4) unsigned NOT NULL default '0',
  `has_body` tinyint(4) unsigned NOT NULL default '0',
  `body_name` varchar(45) NOT NULL default '',
  `is_file` tinyint(4) unsigned default NULL,
  `has_status` tinyint(4) unsigned NOT NULL default '0',
  `extra_status` tinyint(4) unsigned NOT NULL default '0',
  `has_weight` tinyint(4) unsigned NOT NULL default '0',
  `has_images` tinyint(4) unsigned NOT NULL default '0',
  `has_files` tinyint(4) NOT NULL default '0',
  `can_reference` tinyint(4) unsigned NOT NULL default '0' COMMENT 'waiting approval',
  `can_be_referenced` tinyint(4) unsigned NOT NULL default '0' COMMENT 'waiting approval',
  `show_in_search` tinyint(4) NOT NULL default '1',
  `parent_type_id` tinyint(4) unsigned NOT NULL default '0',
  `genre_es` char(1) NOT NULL default 'm',
  `translations` tinyint(4) unsigned NOT NULL default '0',
  `action` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `types_taxonomies` */

DROP TABLE IF EXISTS `types_taxonomies`;

CREATE TABLE `types_taxonomies` (
  `type_id` int(10) unsigned NOT NULL default '0',
  `taxonomytype_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`type_id`,`taxonomytype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) default NULL,
  `password` varchar(50) default NULL,
  `name` varchar(45) NOT NULL default '',
  `lastname` varchar(45) NOT NULL default '',
  `email` varchar(155) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
