CREATE TABLE `zt_translation` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(30) NOT NULL,
  `module` varchar(30) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `translator` char(30) NOT NULL,
  `translationTime` datetime NOT NULL,
  `reviewer` char(30) NOT NULL,
  `reviewTime` datetime NOT NULL,
  `reason` text NOT NULL,
  `version` varchar(20) NOT NULL,
  `mode` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang_module_key_mode` (`lang`,`module`,`key`,`mode`)
) ENGINE=MyISAM AUTO_INCREMENT=5216 DEFAULT CHARSET=utf8
