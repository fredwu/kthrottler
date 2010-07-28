-- --------------------------------------------------------

--
-- Table structure for table `kthrottler_logs`
--

CREATE TABLE `kthrottler_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scope` (`scope`),
  KEY `reference` (`reference`),
  KEY `scope_reference` (`scope`,`reference`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
