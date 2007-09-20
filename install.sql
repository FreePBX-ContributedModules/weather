CREATE TABLE IF NOT EXISTS `zipcodes` (
  `id` mediumint(6) NOT NULL auto_increment,
  `zip` varchar(5) NOT NULL default '',
  `latitude` varchar(11) NOT NULL default '',
  `longitude` varchar(11) NOT NULL default '',
  `city` varchar(40) NOT NULL default '',
  `state` char(2) NOT NULL default '',
  `fullstate` varchar(30) NOT NULL default '',
  `county` varchar(40) NOT NULL default '',
  `zipclass` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `zip` (`zip`),
  KEY `city` (`city`,`state`),
  KEY `state` (`state`,`city`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii AUTO_INCREMENT=42742;
