-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2013 at 12:38 PM
-- Server version: 5.1.50
-- PHP Version: 5.4.0-ZS5.6.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iscored`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `ban_id` bigint(22) unsigned NOT NULL,
  `barea_id` int(11) unsigned DEFAULT NULL,
  `btype_id` int(22) DEFAULT NULL,
  `ban_name` varchar(255) DEFAULT NULL,
  `ban_file` varchar(255) DEFAULT NULL,
  `ban_embed_code` text,
  `ban_link` varchar(255) DEFAULT NULL,
  `ban_startdate` date DEFAULT NULL,
  `ban_enddate` date DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`ban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`ban_id`, `barea_id`, `btype_id`, `ban_name`, `ban_file`, `ban_embed_code`, `ban_link`, `ban_startdate`, `ban_enddate`, `status_id`) VALUES
(1, 4, 3, 'Test Banner', '1_300banner3.gif', '<a href="http://imstore.bet365affiliates.com/Tracker.aspx?AffiliateId=46375&AffiliateCode=365_080477&CID=354&DID=64&TID=1&PID=149&LNG=1 " target="_blank"><img src="http://imstore.bet365affiliates.com/?AffiliateCode=365_080477&CID=354&DID=64&TID=1&PID=149&LNG=1" border="0" /></a>', 'http://www.esol-tech.com/iscored/', '2010-05-05', '2014-06-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banner_areas`
--

CREATE TABLE IF NOT EXISTS `banner_areas` (
  `barea_id` int(11) unsigned NOT NULL,
  `barea_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`barea_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner_areas`
--

INSERT INTO `banner_areas` (`barea_id`, `barea_name`) VALUES
(1, 'TopLeft'),
(2, 'BottomLeft'),
(3, 'TopRight'),
(4, 'MiddleRight'),
(5, 'BottomRight');

-- --------------------------------------------------------

--
-- Table structure for table `banner_type`
--

CREATE TABLE IF NOT EXISTS `banner_type` (
  `btype_id` smallint(2) unsigned NOT NULL,
  `btype_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner_type`
--

INSERT INTO `banner_type` (`btype_id`, `btype_name`) VALUES
(1, 'Image'),
(2, 'Flash (SWF)'),
(3, 'Embed Code');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` bigint(22) unsigned NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_parent_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_parent_id`) VALUES
(1, 'Autos & Vehicles', 0),
(2, 'Comedy', 0),
(3, 'Education', 0),
(4, 'Entertainment', 0),
(5, 'Film & Animation', 0),
(6, 'Gaming', 0),
(7, 'Howto & Style', 0),
(8, 'Music', 0),
(9, 'News & Politics', 0),
(10, 'Nonprofits & Activism', 0),
(11, 'People & Blogs', 0),
(12, 'Pets & Animals', 0),
(13, 'Science & Technology', 0),
(14, 'Sports', 0),
(15, 'Travel & Events', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `cnt_id` int(11) unsigned NOT NULL DEFAULT '0',
  `cnt_heading` varchar(255) DEFAULT NULL,
  `cnt_details` text,
  `cnt_keywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cnt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`cnt_id`, `cnt_heading`, `cnt_details`, `cnt_keywords`) VALUES
(1, 'About Us', '<p> Under Construction</p>', ''),
(2, 'Welcome Text', '<p> Under Construction</p>', ''),
(3, 'Legal', '<p> Under Construction</p>', ''),
(4, 'Contact', '<p>\r\n<b>Algie Salmon</b><br />\r\n40 Geen dragons yard, ld montague Street,<br />\r\nLondon E1 5NJ<br />\r\n</p>\r\n<br />\r\n<p>Phone: 07951 988 380</p>\r\n<br />\r\n<p>Email: <a href="mailto:algsalmon@yahoo.co.uk">algsalmon@yahoo.co.uk</a></p>', ''),
(5, 'Sitemap', '<p> Under Construction</p>', NULL),
(6, 'Advertiser', '<p> Under Construction</p>', NULL),
(7, 'REFUND POLICY', '<p>Refunds are only given if video is not delivered. Quality and length of the video is down to the camara man and iscored will not be responsible for this. Full refunds will be given back within 24 hours if video is not delivered.Please send any complaints to <a href="mailto:info@i-scored.co.uk">info@i-scored.co.uk</a></p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `countries_id` int(11) NOT NULL AUTO_INCREMENT,
  `countries_name` varchar(64) NOT NULL DEFAULT '',
  `countries_iso_code_2` char(2) NOT NULL DEFAULT '',
  `countries_iso_code_3` char(3) NOT NULL DEFAULT '',
  `address_format_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countries_id`, `countries_name`, `countries_iso_code_2`, `countries_iso_code_3`, `address_format_id`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', 1),
(2, 'Albania', 'AL', 'ALB', 1),
(3, 'Algeria', 'DZ', 'DZA', 1),
(4, 'American Samoa', 'AS', 'ASM', 1),
(5, 'Andorra', 'AD', 'AND', 1),
(6, 'Angola', 'AO', 'AGO', 1),
(7, 'Anguilla', 'AI', 'AIA', 1),
(8, 'Antarctica', 'AQ', 'ATA', 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', 1),
(10, 'Argentina', 'AR', 'ARG', 1),
(11, 'Armenia', 'AM', 'ARM', 1),
(12, 'Aruba', 'AW', 'ABW', 1),
(13, 'Australia', 'AU', 'AUS', 1),
(14, 'Austria', 'AT', 'AUT', 5),
(15, 'Azerbaijan', 'AZ', 'AZE', 1),
(16, 'Bahamas', 'BS', 'BHS', 1),
(17, 'Bahrain', 'BH', 'BHR', 1),
(18, 'Bangladesh', 'BD', 'BGD', 1),
(19, 'Barbados', 'BB', 'BRB', 1),
(20, 'Belarus', 'BY', 'BLR', 1),
(21, 'Belgium', 'BE', 'BEL', 1),
(22, 'Belize', 'BZ', 'BLZ', 1),
(23, 'Benin', 'BJ', 'BEN', 1),
(24, 'Bermuda', 'BM', 'BMU', 1),
(25, 'Bhutan', 'BT', 'BTN', 1),
(26, 'Bolivia', 'BO', 'BOL', 1),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', 1),
(28, 'Botswana', 'BW', 'BWA', 1),
(29, 'Bouvet Island', 'BV', 'BVT', 1),
(30, 'Brazil', 'BR', 'BRA', 1),
(31, 'British Indian Ocean \r\n\r\nTerritory', 'IO', 'IOT', 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', 1),
(33, 'Bulgaria', 'BG', 'BGR', 1),
(34, 'Burkina Faso', 'BF', 'BFA', 1),
(35, 'Burundi', 'BI', 'BDI', 1),
(36, 'Cambodia', 'KH', 'KHM', 1),
(37, 'Cameroon', 'CM', 'CMR', 1),
(38, 'Canada', 'CA', 'CAN', 1),
(39, 'Cape Verde', 'CV', 'CPV', 1),
(40, 'Cayman Islands', 'KY', 'CYM', 1),
(41, 'Central African Republic', 'CF', 'CAF', 1),
(42, 'Chad', 'TD', 'TCD', 1),
(43, 'Chile', 'CL', 'CHL', 1),
(44, 'China', 'CN', 'CHN', 1),
(45, 'Christmas Island', 'CX', 'CXR', 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1),
(47, 'Colombia', 'CO', 'COL', 1),
(48, 'Comoros', 'KM', 'COM', 1),
(49, 'Congo', 'CG', 'COG', 1),
(50, 'Cook Islands', 'CK', 'COK', 1),
(51, 'Costa Rica', 'CR', 'CRI', 1),
(52, 'Cote D''Ivoire', 'CI', 'CIV', 1),
(53, 'Croatia', 'HR', 'HRV', 1),
(54, 'Cuba', 'CU', 'CUB', 1),
(55, 'Cyprus', 'CY', 'CYP', 1),
(56, 'Czech Republic', 'CZ', 'CZE', 1),
(57, 'Denmark', 'DK', 'DNK', 1),
(58, 'Djibouti', 'DJ', 'DJI', 1),
(59, 'Dominica', 'DM', 'DMA', 1),
(60, 'Dominican Republic', 'DO', 'DOM', 1),
(61, 'East Timor', 'TP', 'TMP', 1),
(62, 'Ecuador', 'EC', 'ECU', 1),
(63, 'Egypt', 'EG', 'EGY', 1),
(64, 'El Salvador', 'SV', 'SLV', 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', 1),
(66, 'Eritrea', 'ER', 'ERI', 1),
(67, 'Estonia', 'EE', 'EST', 1),
(68, 'Ethiopia', 'ET', 'ETH', 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1),
(70, 'Faroe Islands', 'FO', 'FRO', 1),
(71, 'Fiji', 'FJ', 'FJI', 1),
(72, 'Finland', 'FI', 'FIN', 1),
(73, 'France', 'FR', 'FRA', 1),
(74, 'France, Metropolitan', 'FX', 'FXX', 1),
(75, 'French Guiana', 'GF', 'GUF', 1),
(76, 'French Polynesia', 'PF', 'PYF', 1),
(77, 'French Southern Territories', 'TF', 'ATF', 1),
(78, 'Gabon', 'GA', 'GAB', 1),
(79, 'Gambia', 'GM', 'GMB', 1),
(80, 'Georgia', 'GE', 'GEO', 1),
(81, 'Germany', 'DE', 'DEU', 5),
(82, 'Ghana', 'GH', 'GHA', 1),
(83, 'Gibraltar', 'GI', 'GIB', 1),
(84, 'Greece', 'GR', 'GRC', 1),
(85, 'Greenland', 'GL', 'GRL', 1),
(86, 'Grenada', 'GD', 'GRD', 1),
(87, 'Guadeloupe', 'GP', 'GLP', 1),
(88, 'Guam', 'GU', 'GUM', 1),
(89, 'Guatemala', 'GT', 'GTM', 1),
(90, 'Guinea', 'GN', 'GIN', 1),
(91, 'Guinea-bissau', 'GW', 'GNB', 1),
(92, 'Guyana', 'GY', 'GUY', 1),
(93, 'Haiti', 'HT', 'HTI', 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1),
(95, 'Honduras', 'HN', 'HND', 1),
(96, 'Hong Kong', 'HK', 'HKG', 1),
(97, 'Hungary', 'HU', 'HUN', 1),
(98, 'Iceland', 'IS', 'ISL', 1),
(99, 'India', 'IN', 'IND', 1),
(100, 'Indonesia', 'ID', 'IDN', 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1),
(102, 'Iraq', 'IQ', 'IRQ', 1),
(103, 'Ireland', 'IE', 'IRL', 1),
(104, 'Israel', 'IL', 'ISR', 1),
(105, 'Italy', 'IT', 'ITA', 1),
(106, 'Jamaica', 'JM', 'JAM', 1),
(107, 'Japan', 'JP', 'JPN', 1),
(108, 'Jordan', 'JO', 'JOR', 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', 1),
(110, 'Kenya', 'KE', 'KEN', 1),
(111, 'Kiribati', 'KI', 'KIR', 1),
(112, 'Korea, Democratic People''s \r\n\r\nRepublic of', 'KP', 'PRK', 1),
(113, 'Korea, Republic of', 'KR', 'KOR', 1),
(114, 'Kuwait', 'KW', 'KWT', 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', 1),
(116, 'Lao People''s Democratic \r\n\r\nRepublic', 'LA', 'LAO', 1),
(117, 'Latvia', 'LV', 'LVA', 1),
(118, 'Lebanon', 'LB', 'LBN', 1),
(119, 'Lesotho', 'LS', 'LSO', 1),
(120, 'Liberia', 'LR', 'LBR', 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1),
(122, 'Liechtenstein', 'LI', 'LIE', 1),
(123, 'Lithuania', 'LT', 'LTU', 1),
(124, 'Luxembourg', 'LU', 'LUX', 1),
(125, 'Macau', 'MO', 'MAC', 1),
(126, 'Macedonia, The Former Yugoslav \r\n\r\nRepublic of', 'MK', 'MKD', 1),
(127, 'Madagascar', 'MG', 'MDG', 1),
(128, 'Malawi', 'MW', 'MWI', 1),
(129, 'Malaysia', 'MY', 'MYS', 1),
(130, 'Maldives', 'MV', 'MDV', 1),
(131, 'Mali', 'ML', 'MLI', 1),
(132, 'Malta', 'MT', 'MLT', 1),
(133, 'Marshall Islands', 'MH', 'MHL', 1),
(134, 'Martinique', 'MQ', 'MTQ', 1),
(135, 'Mauritania', 'MR', 'MRT', 1),
(136, 'Mauritius', 'MU', 'MUS', 1),
(137, 'Mayotte', 'YT', 'MYT', 1),
(138, 'Mexico', 'MX', 'MEX', 1),
(139, 'Micronesia, Federated States \r\n\r\nof', 'FM', 'FSM', 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', 1),
(141, 'Monaco', 'MC', 'MCO', 1),
(142, 'Mongolia', 'MN', 'MNG', 1),
(143, 'Montserrat', 'MS', 'MSR', 1),
(144, 'Morocco', 'MA', 'MAR', 1),
(145, 'Mozambique', 'MZ', 'MOZ', 1),
(146, 'Myanmar', 'MM', 'MMR', 1),
(147, 'Namibia', 'NA', 'NAM', 1),
(148, 'Nauru', 'NR', 'NRU', 1),
(149, 'Nepal', 'NP', 'NPL', 1),
(150, 'Netherlands', 'NL', 'NLD', 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', 1),
(152, 'New Caledonia', 'NC', 'NCL', 1),
(153, 'New Zealand', 'NZ', 'NZL', 1),
(154, 'Nicaragua', 'NI', 'NIC', 1),
(155, 'Niger', 'NE', 'NER', 1),
(156, 'Nigeria', 'NG', 'NGA', 1),
(157, 'Niue', 'NU', 'NIU', 1),
(158, 'Norfolk Island', 'NF', 'NFK', 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', 1),
(160, 'Norway', 'NO', 'NOR', 1),
(161, 'Oman', 'OM', 'OMN', 1),
(162, 'Pakistan', 'PK', 'PAK', 1),
(163, 'Palau', 'PW', 'PLW', 1),
(164, 'Panama', 'PA', 'PAN', 1),
(165, 'Papua New Guinea', 'PG', 'PNG', 1),
(166, 'Paraguay', 'PY', 'PRY', 1),
(167, 'Peru', 'PE', 'PER', 1),
(168, 'Philippines', 'PH', 'PHL', 1),
(169, 'Pitcairn', 'PN', 'PCN', 1),
(170, 'Poland', 'PL', 'POL', 1),
(171, 'Portugal', 'PT', 'PRT', 1),
(172, 'Puerto Rico', 'PR', 'PRI', 1),
(173, 'Qatar', 'QA', 'QAT', 1),
(174, 'Reunion', 'RE', 'REU', 1),
(175, 'Romania', 'RO', 'ROM', 1),
(176, 'Russian Federation', 'RU', 'RUS', 1),
(177, 'Rwanda', 'RW', 'RWA', 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1),
(179, 'Saint Lucia', 'LC', 'LCA', 1),
(180, 'Saint Vincent and the \r\n\r\nGrenadines', 'VC', 'VCT', 1),
(181, 'Samoa', 'WS', 'WSM', 1),
(182, 'San Marino', 'SM', 'SMR', 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', 1),
(184, 'Saudi Arabia', 'SA', 'SAU', 1),
(185, 'Senegal', 'SN', 'SEN', 1),
(186, 'Seychelles', 'SC', 'SYC', 1),
(187, 'Sierra Leone', 'SL', 'SLE', 1),
(188, 'Singapore', 'SG', 'SGP', 4),
(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', 1),
(190, 'Slovenia', 'SI', 'SVN', 1),
(191, 'Solomon Islands', 'SB', 'SLB', 1),
(192, 'Somalia', 'SO', 'SOM', 1),
(193, 'South Africa', 'ZA', 'ZAF', 1),
(194, 'South Georgia and the South \r\n\r\nSandwich Islands', 'GS', 'SGS', 1),
(195, 'Spain', 'ES', 'ESP', 3),
(196, 'Sri Lanka', 'LK', 'LKA', 1),
(197, 'St. Helena', 'SH', 'SHN', 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1),
(199, 'Sudan', 'SD', 'SDN', 1),
(200, 'Suriname', 'SR', 'SUR', 1),
(201, 'Svalbard and Jan Mayen \r\n\r\nIslands', 'SJ', 'SJM', 1),
(202, 'Swaziland', 'SZ', 'SWZ', 1),
(203, 'Sweden', 'SE', 'SWE', 1),
(204, 'Switzerland', 'CH', 'CHE', 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', 1),
(206, 'Taiwan', 'TW', 'TWN', 1),
(207, 'Tajikistan', 'TJ', 'TJK', 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1),
(209, 'Thailand', 'TH', 'THA', 1),
(210, 'Togo', 'TG', 'TGO', 1),
(211, 'Tokelau', 'TK', 'TKL', 1),
(212, 'Tonga', 'TO', 'TON', 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', 1),
(214, 'Tunisia', 'TN', 'TUN', 1),
(215, 'Turkey', 'TR', 'TUR', 1),
(216, 'Turkmenistan', 'TM', 'TKM', 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', 1),
(218, 'Tuvalu', 'TV', 'TUV', 1),
(219, 'Uganda', 'UG', 'UGA', 1),
(220, 'Ukraine', 'UA', 'UKR', 1),
(221, 'United Arab Emirates', 'AE', 'ARE', 1),
(222, 'United Kingdom', 'GB', 'GBR', 1),
(223, 'United States', 'US', 'USA', 2),
(224, 'United States Minor Outlying \r\n\r\nIslands', 'UM', 'UMI', 1),
(225, 'Uruguay', 'UY', 'URY', 1),
(226, 'Uzbekistan', 'UZ', 'UZB', 1),
(227, 'Vanuatu', 'VU', 'VUT', 1),
(228, 'Vatican City State (Holy \r\n\r\nSee)', 'VA', 'VAT', 1),
(229, 'Venezuela', 'VE', 'VEN', 1),
(230, 'Viet Nam', 'VN', 'VNM', 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1),
(234, 'Western Sahara', 'EH', 'ESH', 1),
(235, 'Yemen', 'YE', 'YEM', 1),
(236, 'Yugoslavia', 'YU', 'YUG', 1),
(237, 'Zaire', 'ZR', 'ZAR', 1),
(238, 'Zambia', 'ZM', 'ZMB', 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `gen_id` smallint(2) unsigned NOT NULL,
  `gen_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`gen_id`, `gen_name`) VALUES
(1, 'Male'),
(2, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `image_id` bigint(22) unsigned NOT NULL,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `image_title` varchar(255) DEFAULT NULL,
  `image_file` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `menu_id`, `image_title`, `image_file`) VALUES
(1, 2, 'test', '1_Fotos_DSC_Y347831.JPG'),
(2, 2, 'sasas', '2_big_image.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `mem_id` bigint(22) unsigned NOT NULL,
  `mem_login` varchar(255) DEFAULT NULL,
  `mem_password` varchar(255) DEFAULT NULL,
  `mem_name` varchar(255) DEFAULT NULL,
  `mem_dob` date DEFAULT NULL,
  `gen_id` smallint(2) unsigned DEFAULT NULL,
  `mem_phone` varchar(255) DEFAULT NULL,
  `mem_address` varchar(255) DEFAULT NULL,
  `mem_city` varchar(255) DEFAULT NULL,
  `countries_id` int(11) unsigned DEFAULT NULL,
  `mem_ac_title` varchar(255) DEFAULT NULL,
  `mem_ac_number` varchar(255) DEFAULT NULL,
  `mem_bank_name` varchar(255) DEFAULT NULL,
  `mem_swift_code` varchar(255) DEFAULT NULL,
  `mem_bank_address` text,
  `status_id` int(11) unsigned DEFAULT '1',
  `mem_datecreated` date DEFAULT NULL,
  `mem_lastupdated` date DEFAULT NULL,
  `mem_last_login` date DEFAULT NULL,
  `mem_total_videos` int(11) unsigned DEFAULT '0',
  `mem_view_videos` int(11) unsigned DEFAULT '0',
  `mem_confirm` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`mem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mem_id`, `mem_login`, `mem_password`, `mem_name`, `mem_dob`, `gen_id`, `mem_phone`, `mem_address`, `mem_city`, `countries_id`, `mem_ac_title`, `mem_ac_number`, `mem_bank_name`, `mem_swift_code`, `mem_bank_address`, `status_id`, `mem_datecreated`, `mem_lastupdated`, `mem_last_login`, `mem_total_videos`, `mem_view_videos`, `mem_confirm`) VALUES
(1, 'aqeelashraf@gmail.com', 'aaa', 'Aqeel Ashraf', '1980-04-04', 1, NULL, NULL, NULL, 162, NULL, NULL, NULL, NULL, NULL, 1, '2010-03-24', NULL, '2013-01-31', 0, 0, 1),
(2, 'aqeelashraf@yahoo.com', 'aaa', 'Aqeel Ashraf', '0000-00-00', 1, NULL, NULL, NULL, 162, NULL, NULL, NULL, NULL, NULL, 1, '2010-04-12', NULL, NULL, 0, 0, 0),
(3, 'usmansadiq786@gmail.com', '111111', 'usman sadiq', '1990-01-01', 1, '03010202020220', 'ksksksksks', 'kdksksksks', 162, '', '', '', '', '', 1, '2013-01-31', NULL, '2013-01-31', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `cnt_id` int(11) unsigned DEFAULT '0',
  `menu_title` varchar(255) DEFAULT NULL,
  `mtype_id` int(11) unsigned DEFAULT '1',
  `menu_parent_id` int(11) unsigned DEFAULT '0',
  `status_id` int(11) unsigned DEFAULT NULL,
  `menu_rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `cnt_id`, `menu_title`, `mtype_id`, `menu_parent_id`, `status_id`, `menu_rank`) VALUES
(1, 2, 'Home', 1, 0, 1, 1),
(2, 1, 'ABOUT US', 1, 0, 1, 2),
(4, 3, 'LEGAL', 1, 0, 1, 4),
(5, 4, 'CONTACT', 1, 0, 1, 5),
(6, 5, 'Sitemap', 1, 0, 1, 6),
(7, 6, 'Advertise', 1, 0, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `ord_id` bigint(22) unsigned NOT NULL,
  `cat_id` bigint(22) unsigned DEFAULT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `vid_id` bigint(22) unsigned DEFAULT NULL,
  `ord_date` date DEFAULT NULL,
  `pstatus_id` int(2) unsigned DEFAULT '0',
  `ord_trans_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ord_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ord_id`, `cat_id`, `mem_id`, `vid_id`, `ord_date`, `pstatus_id`, `ord_trans_id`) VALUES
(1, 2, 1, 5, '2010-11-07', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pay_status`
--

CREATE TABLE IF NOT EXISTS `pay_status` (
  `pstatus_id` int(2) unsigned NOT NULL,
  `pstatus_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pstatus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pay_status`
--

INSERT INTO `pay_status` (`pstatus_id`, `pstatus_name`) VALUES
(0, 'Pending'),
(1, 'Completed'),
(2, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `site_config`
--

CREATE TABLE IF NOT EXISTS `site_config` (
  `config_id` int(11) unsigned NOT NULL DEFAULT '0',
  `config_sitename` varchar(255) DEFAULT NULL,
  `config_sitetitle` varchar(255) DEFAULT NULL,
  `config_metakey` text,
  `config_metades` text,
  `config_upload_limit` int(11) unsigned DEFAULT '0',
  `status_id` smallint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_config`
--

INSERT INTO `site_config` (`config_id`, `config_sitename`, `config_sitetitle`, `config_metakey`, `config_metades`, `config_upload_limit`, `status_id`) VALUES
(1, 'iscored.com', 'iscored', 'iscored', 'iscored', 21504, 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(0, 'Inactive'),
(1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` bigint(22) unsigned NOT NULL,
  `tag_name` varchar(255) DEFAULT NULL,
  `tag_total` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`, `tag_total`) VALUES
(1, 'Autos', 0),
(2, 'Vehicles', 0),
(3, 'Comedy', 0),
(4, 'Education', 0),
(5, 'Entertainment', 0),
(6, 'Film', 0),
(7, 'Animation', 1),
(8, 'Gaming', 1),
(9, 'Style', 1),
(10, 'News', 1),
(11, 'Politics', 1),
(12, 'Nonprofits', 1),
(13, 'Activism', 1),
(14, 'People', 1),
(15, 'Blogs', 1),
(16, 'Pets', 1),
(17, 'Animals', 1),
(18, 'Science', 1),
(19, 'Technology', 1),
(20, 'Sports', 1),
(21, 'Travel', 1),
(22, 'Events', 1),
(23, '', 5),
(24, 'eferfvfrvc', 13),
(25, 'xczx', 11);

-- --------------------------------------------------------

--
-- Table structure for table `team_cast`
--

CREATE TABLE IF NOT EXISTS `team_cast` (
  `cast_id` int(11) unsigned NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `cast_time` datetime DEFAULT NULL,
  `post_code` int(22) DEFAULT NULL,
  PRIMARY KEY (`cast_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_cast`
--

INSERT INTO `team_cast` (`cast_id`, `team_id`, `cast_time`, `post_code`) VALUES
(1, 1, '2013-01-01 19:44:15', 243),
(2, 1, '2013-01-31 17:33:07', 45234234),
(3, 1, NULL, 54545),
(4, 1, '2012-01-02 02:02:00', 45234324),
(5, 1, '2011-01-02 12:22:00', 32432423),
(6, 1, '2012-02-02 01:02:00', 43412434);

-- --------------------------------------------------------

--
-- Table structure for table `team_mem`
--

CREATE TABLE IF NOT EXISTS `team_mem` (
  `mem_id` int(11) unsigned NOT NULL,
  `mem_name_f` varchar(255) DEFAULT NULL,
  `mem_name_l` varchar(255) DEFAULT NULL,
  `mem_email` varchar(255) DEFAULT NULL,
  `cast_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_mem`
--

INSERT INTO `team_mem` (`mem_id`, `mem_name_f`, `mem_name_l`, `mem_email`, `cast_id`) VALUES
(4, 'ummtyrgetv', 'mthrgtew', 'thygrb@uttyrt.uynrtb', 1),
(6, 'umtyrtberv', 'mntyrtebrv', 'hngbfvdc@terw.ynrtberw', 1),
(10, 'frjgoj', 'IOAHDVIDAH', 'wrghi@nipoadhf.eoifdh', 1),
(11, '3iuwr', 'OJISHCVHADSCH', 'sdjdvcusdagc@jhc.wifhi', 1),
(12, 'utyrht', 'trbe', 'unyrbt@ihd.efhi', 1),
(31, 'k jhgfgbd', 'nhgbfv', 'djfodkfpakxpka@asj.sa', 1),
(32, 'yrhtegr', 'tmnbev', 'rtbevr@ihd.eofj', 1),
(33, 'asdihisah', 'HIDADHAI', 'ASIH@sadkh.assj', 1),
(34, 'Usman', 'Sadiq', 'usmadi@iia.spa', 1),
(35, 'Usman', 'asaaa', 'ppppp@hhh.ccc', 1),
(36, 'Usman', 'Sadiq', 'uswaj@kk.caa', 1),
(37, 'Ukjsaj', 'ashdhs', 'usmana@is.zs', 1),
(38, 'regerg', 'grgreg', 'usmana@is.zss', 1),
(39, 'yhtjnyrt', 'gtrbrgbg', 'grbgrbr@fevef.ergfvefv', 2),
(40, 'aaaaa', 'bbbbb', 'cccc@dudh.eofkj', 2),
(41, 'etgerg', 'rgergerg', 'asddfwdw@eretrgerg.wrgfewr', 2),
(42, 'ergerge', 'ergergreg', 'ege@ryrhrt.rgfwrrfgwr', 2),
(43, '4t43t', 'wetewetrwe', 'wefwefw@wregfwe.ewfgew', 2),
(44, 'ewfwef', 'wefwefewf', 'wefwef@gnhet.wrgfwrg', 2),
(45, 'gergrfadsf', 'asfsdfsdf', 'dsfsdfsd@wergfewr.wergfwre', 2),
(46, 'wefsdafdafadsf', 'dfadsfafasf', 'asdsadgdfsga@ergwer.wefwef', 3),
(47, 'dfsdfdfd', 'fsdfsdfsdfsd', 'fsdfsdfsdf@eregreg.ereer', 4),
(48, 'wdwqdwq', 'qwdwqwdqwd', 'qefqweew@thh.wefwe', 2),
(49, 'erfqwaDQWD', 'WEFWEQFDQWFD', 'DWWEFA@WRFW.WEFWE', 2),
(50, 'EFQEWDFQ', 'DQWDQW', 'QWDQWD@EFGWE.EF', 2),
(51, 'EFWEFWE', 'FWEFWE', 'WEFEWF@ERG.WERFWE', 2),
(52, 'FDFSDF', 'FSDFSDF', 'SDFDSDFS@ERG.WRFGEWR', 2),
(53, 'DFSDFSD', 'FSDFDSFSD', 'ADFSDF@EGER.WRFWRF', 2),
(54, 'EWFWEFW', 'EFWEFWE', 'FWEFWEFWEF@WF.WEF', 5),
(55, 'WQDWQDWQDD', 'QWDQWD', 'ASSDQ@EREG.EF', 5),
(56, 'eqdqwdw', 'qdqwdqwdqwd', 'qwdqw@dfvdw.ewfew', 6),
(57, 'eedqwedqd', 'qwdqwdqwd', 'dqwdqwd@gtte.rgreg', 6),
(58, 'wefewf', 'efewfwfwef', 'dqwdqwd@gtte.rgregeqfeq', 6);

-- --------------------------------------------------------

--
-- Table structure for table `team_played`
--

CREATE TABLE IF NOT EXISTS `team_played` (
  `team_id` int(11) unsigned NOT NULL,
  `team_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_played`
--

INSERT INTO `team_played` (`team_id`, `team_name`) VALUES
(1, 'East Punjab'),
(3, 'adjcidaj'),
(4, '234234'),
(6, 'ergerg'),
(7, 'rwgrwg'),
(9, 'opassjd'),
(10, 'aaa'),
(11, 'bbbss');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` tinyint(9) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `user_password` varchar(255) NOT NULL DEFAULT '',
  `utype_id` int(11) unsigned DEFAULT NULL,
  `clt_id` bigint(22) unsigned DEFAULT '0',
  `status_id` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `utype_id`, `clt_id`, `status_id`) VALUES
(1, 'sadmin', 'sadmin', 1, 0, 1),
(2, 'admin', 'admin', 2, 0, 1),
(3, 'manager', 'manager', 3, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `utype_id` int(11) unsigned NOT NULL,
  `utype_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`utype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`utype_id`, `utype_name`) VALUES
(1, 'SuperAdmin'),
(2, 'Admin'),
(3, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `vid_id` bigint(22) unsigned NOT NULL,
  `mem_id` bigint(22) unsigned DEFAULT '0',
  `cat_id` bigint(22) unsigned DEFAULT NULL,
  `vid_name` varchar(255) DEFAULT NULL,
  `vid_details` text,
  `vid_file_path` varchar(255) DEFAULT NULL,
  `vid_clip_path` varchar(255) DEFAULT NULL,
  `vid_thumb` varchar(255) DEFAULT NULL,
  `vid_dateadded` date DEFAULT NULL,
  `vid_views` int(11) unsigned DEFAULT '0',
  `vid_price` float(16,2) unsigned DEFAULT NULL,
  `vstatus_id` int(11) unsigned DEFAULT '0',
  `vid_featured` smallint(1) unsigned DEFAULT '0',
  `vid_home` tinyint(1) unsigned DEFAULT '0',
  `vid_length` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`vid_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`vid_id`, `mem_id`, `cat_id`, `vid_name`, `vid_details`, `vid_file_path`, `vid_clip_path`, `vid_thumb`, `vid_dateadded`, `vid_views`, `vid_price`, `vstatus_id`, `vid_featured`, `vid_home`, `vid_length`) VALUES
(2, 1, 1, 'test', 'zazaza', '2_test.flv', '2_test.flv', NULL, '2010-04-16', 0, 50.00, 1, 1, 0, 0),
(3, 1, 1, 'new test 1', 'test image', '3_test.flv', '3_test.flv', NULL, '2010-04-19', 0, 44.00, 1, 1, 0, 0),
(4, 1, 1, 'dfdsf', 'cczc', '4_consumer_plus.flv', '4_consumer_plus.flv', NULL, '2010-04-21', 1, 2232.00, 1, 1, 0, 0),
(5, 1, 2, 'new comerdy', 'asdsads', '5_test.flv', '5_test.flv', NULL, '2010-04-14', 0, 50.00, 1, 1, 1, 0),
(6, 0, 2, 'New File', 'Must see this....', '6_WhatADance.flv', NULL, NULL, '2010-05-12', 0, 50.00, 0, 0, 0, 0),
(7, 1, 1, 'ccccc', 'fvfvfvv', '7_8a23294934_clip1_(1).flv', NULL, '7_8a23294934_clip1_(1).jpg', '2013-01-31', 0, 66666.00, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `video_tags`
--

CREATE TABLE IF NOT EXISTS `video_tags` (
  `vid_id` bigint(255) unsigned NOT NULL,
  `tag_id` bigint(255) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_tags`
--

INSERT INTO `video_tags` (`vid_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(2, 4),
(2, 3),
(3, 5),
(3, 4),
(3, 6),
(5, 23),
(4, 23),
(7, 24),
(7, 25);

-- --------------------------------------------------------

--
-- Table structure for table `vid_comments`
--

CREATE TABLE IF NOT EXISTS `vid_comments` (
  `vcom_id` bigint(22) unsigned NOT NULL,
  `vid_id` bigint(22) unsigned DEFAULT NULL,
  `mem_id` bigint(22) unsigned DEFAULT '0',
  `vcom_comment` text,
  `vcom_date` date DEFAULT NULL,
  `vstatus_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`vcom_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vid_comments`
--

INSERT INTO `vid_comments` (`vcom_id`, `vid_id`, `mem_id`, `vcom_comment`, `vcom_date`, `vstatus_id`) VALUES
(1, 1, 1, 'dsadsa dsadsa ds ds dsadsad asd sads adsa dsa fdsa fdas fds fv sdf dsaf dsaf sadf dsfdasfdsf dsf dsf ds fdsa fds f dsf dsf dsf ds', '2010-04-20', 1),
(2, 1, 1, 'fdsv ghtr cfdasfd dsfsda fdf g fd dsafds  dsafddf gfegfes fsdfd fewafrewr fdss fdsafdsf fdsafdsfdas', '2010-04-22', 1),
(3, 4, 1, 'txtcomments', '2010-04-27', 0),
(4, 4, 1, 'another test comments', '2010-04-27', 0),
(5, 4, 1, 'This is test coimments', '2010-04-27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vstatus`
--

CREATE TABLE IF NOT EXISTS `vstatus` (
  `vstatus_id` int(11) unsigned NOT NULL,
  `vstatus_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`vstatus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vstatus`
--

INSERT INTO `vstatus` (`vstatus_id`, `vstatus_name`) VALUES
(0, 'Pending'),
(1, 'Approved'),
(2, 'Denied'),
(3, 'Blocked');
