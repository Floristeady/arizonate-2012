
CREATE TABLE `sql` (
  `id` int(11) NOT NULL auto_increment,
  `query` varchar(255) default NULL,
  `sql` mediumtext,
  `time` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
