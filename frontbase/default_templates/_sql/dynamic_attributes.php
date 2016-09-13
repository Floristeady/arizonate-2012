CREATE TABLE `<?=$table?>_attributes` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `keyword` varchar(50) default NULL,
  `type` varchar(50) default NULL,
  `weight` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

CREATE TABLE `<?=$table?>_values_boolean` (
  `<?=$fk?>` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default '0',
  PRIMARY KEY  (`<?=$fk?>`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `<?=$table?>_values_datetime` (
  `<?=$fk?>` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`<?=$fk?>`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `<?=$table?>_values_file` (
  `<?=$fk?>` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`<?=$fk?>`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `<?=$table?>_values_float` (
  `<?=$fk?>` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`<?=$fk?>`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `<?=$table?>_values_string` (
  `<?=$fk?>` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`<?=$fk?>`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `<?=$table?>_values_text` (
  `<?=$fk?>` int(11) NOT NULL default '0',
  `attribute_id` int(11) NOT NULL default '0',
  `value` text default NULL,
  PRIMARY KEY  (`<?=$fk?>`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
