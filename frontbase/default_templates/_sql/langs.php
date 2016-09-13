CREATE TABLE `<?=$table?>_lang` (
  `<?=$fk?>` int(11) NOT NULL default '0',
  `field` varchar(100) NOT NULL default '',
  `text` text,
  `language` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`<?=$fk?>`,`field`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;