CREATE TABLE `tipologia` (
  `id` int(11) NOT NULL auto_increment,
  `tipologia` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `probjuridico` (
  `id` int(11) NOT NULL auto_increment,
  `id_tipologia` int(11) NOT NULL default '0',
  `problema` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`id_tipologia`) REFERENCES `tipologia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
