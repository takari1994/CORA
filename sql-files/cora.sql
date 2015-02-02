-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2015 at 04:16 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ragnarok_he`
--

-- --------------------------------------------------------

--
-- Table structure for table `tcp_cart`
--

CREATE TABLE IF NOT EXISTS `tcp_cart` (
`cart_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `qty` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_dash_li`
--

CREATE TABLE IF NOT EXISTS `tcp_dash_li` (
`dash_li_id` int(11) NOT NULL,
  `desc` varchar(45) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_dash_li`
--

INSERT INTO `tcp_dash_li` (`dash_li_id`, `desc`, `url`) VALUES
(1, 'Posts', 'dashboard/posts'),
(2, 'Pages', 'dashboard/pages'),
(3, 'Users', 'dashboard/users'),
(4, 'Navigation', 'dashboard/navigation'),
(5, 'Widgets', 'dashboard/widgets'),
(6, 'Cash Shop', 'dashboard/shop'),
(7, 'Currency', 'dashboard/currency'),
(8, 'Logs', 'dashboard/logs'),
(9, 'Settings', 'dashboard/settings');

-- --------------------------------------------------------

--
-- Table structure for table `tcp_donate`
--

CREATE TABLE IF NOT EXISTS `tcp_donate` (
`donate_id` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_donate_log`
--

CREATE TABLE IF NOT EXISTS `tcp_donate_log` (
`donate_log_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned DEFAULT NULL,
  `amount` int(10) unsigned NOT NULL,
  `currency` varchar(45) NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_logs`
--

CREATE TABLE IF NOT EXISTS `tcp_logs` (
`log_id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknown',
  `user1` int(11) NOT NULL DEFAULT '0',
  `user1_str` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user2` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '127.0.0.1',
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tcp_logs`
--

INSERT INTO `tcp_logs` (`log_id`, `type`, `user1`, `user1_str`, `user2`, `date`, `ip`, `note`) VALUES
(1, 'Login', 1, '', NULL, '2015-01-16 02:53:59', '::1', 'Admin Login');

-- --------------------------------------------------------

--
-- Table structure for table `tcp_nav`
--

CREATE TABLE IF NOT EXISTS `tcp_nav` (
`nav_id` int(11) NOT NULL,
  `description` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_nav`
--

INSERT INTO `tcp_nav` (`nav_id`, `description`, `status`) VALUES
(1, 'Main Navigation', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tcp_nav_li`
--

CREATE TABLE IF NOT EXISTS `tcp_nav_li` (
`nav_li_id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `label` varchar(45) NOT NULL,
  `url` text NOT NULL,
  `position` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_nav_li`
--

INSERT INTO `tcp_nav_li` (`nav_li_id`, `nav_id`, `label`, `url`, `position`) VALUES
(1, 1, 'Home', '', 1),
(2, 1, 'Account', 'account/profile', 2),
(3, 1, 'Cash Shop', 'shop', 3),
(4, 1, 'Donate', 'donate', 4),
(5, 1, 'Vote 4 Points', 'v4p', 5),
(6, 1, 'Search', 'database', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tcp_order`
--

CREATE TABLE IF NOT EXISTS `tcp_order` (
`order_id` int(10) unsigned NOT NULL,
  `recipient_id` int(10) unsigned NOT NULL,
  `sender_id` int(10) unsigned DEFAULT NULL,
  `total_dp` int(10) unsigned NOT NULL,
  `total_vp` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_order_items`
--

CREATE TABLE IF NOT EXISTS `tcp_order_items` (
`order_items_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `qty` int(10) unsigned NOT NULL,
  `amount_dp` int(10) unsigned NOT NULL,
  `amount_vp` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_page`
--

CREATE TABLE IF NOT EXISTS `tcp_page` (
`page_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `content` text NOT NULL,
  `author` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_pass_res`
--

CREATE TABLE IF NOT EXISTS `tcp_pass_res` (
`pass_res_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '127.0.0.1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_post`
--

CREATE TABLE IF NOT EXISTS `tcp_post` (
`post_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `content` text NOT NULL,
  `author` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_post_event`
--

CREATE TABLE IF NOT EXISTS `tcp_post_event` (
`post_event_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_profile`
--

CREATE TABLE IF NOT EXISTS `tcp_profile` (
`profile_id` int(10) unsigned NOT NULL,
  `account_id` varchar(45) NOT NULL,
  `fname` varchar(45) NOT NULL DEFAULT 'fname',
  `lname` varchar(45) NOT NULL DEFAULT 'lname',
  `birthday` date NOT NULL DEFAULT '1996-12-14',
  `donate_points` int(10) unsigned NOT NULL DEFAULT '0',
  `vote_points` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_register`
--

CREATE TABLE IF NOT EXISTS `tcp_register` (
`register_id` int(10) unsigned NOT NULL,
  `userid` varchar(45) NOT NULL,
  `userpass` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sex` enum('M','F') NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `birthday` date NOT NULL,
  `code` varchar(20) NOT NULL,
  `save_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_sessions`
--

CREATE TABLE IF NOT EXISTS `tcp_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_sessions`
--

INSERT INTO `tcp_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('40fbe885ef8797718b91f5100028813b', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2243.0 Safari/537.36', 1418727859, 'a:2:{s:9:"user_data";s:0:"";s:12:"admin_userid";s:9:"coraadmin";}'),
('95b233674a3e06a463dd5dd39ac7dc8f', '::1', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.3 Safari/537.36', 1421348075, 'a:3:{s:9:"user_data";s:0:"";s:8:"admin_id";s:1:"1";s:12:"admin_userid";s:9:"coraadmin";}');

-- --------------------------------------------------------

--
-- Table structure for table `tcp_set_acc`
--

CREATE TABLE IF NOT EXISTS `tcp_set_acc` (
  `set_acc_id` int(10) unsigned NOT NULL,
  `pw_allow_char` varchar(45) NOT NULL,
  `un_allow_char` varchar(45) NOT NULL,
  `pw_format_error` varchar(255) DEFAULT NULL,
  `un_format_error` varchar(255) DEFAULT NULL,
  `char_res_pos` varchar(100) DEFAULT NULL,
  `char_no_res` varchar(100) NOT NULL,
  `min_age` int(10) unsigned DEFAULT NULL,
  `req_email_ver` tinyint(1) NOT NULL,
  `sex_allow_change` tinyint(1) NOT NULL,
  `email_allow_dupe` tinyint(1) NOT NULL,
  `req_capt_reg` tinyint(1) NOT NULL,
  `use_md5` tinyint(1) NOT NULL DEFAULT '0',
  `bday_allow_change` tinyint(1) NOT NULL DEFAULT '0',
  `un_allow_change` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_set_acc`
--

INSERT INTO `tcp_set_acc` (`set_acc_id`, `pw_allow_char`, `un_allow_char`, `pw_format_error`, `un_format_error`, `char_res_pos`, `char_no_res`, `min_age`, `req_email_ver`, `sex_allow_change`, `email_allow_dupe`, `req_capt_reg`, `use_md5`, `bday_allow_change`, `un_allow_change`) VALUES
(1, '/^[a-zA-Z0-9_!@#\\$%\\^&\\*\\(\\)\\-=\\+\\? ]{6,32}$/', '/^[a-zA-Z0-9_]{6,23}$/', 'Password must only contain a-z,0-9,_!@#$%^&*()-=+? with a 6-32 character length.', 'Username must be alphanumeric and 6-23 characters in length.', 'prontera,155,170', 'sec_pri', 0, 0, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcp_set_adm`
--

CREATE TABLE IF NOT EXISTS `tcp_set_adm` (
  `admin_id` int(10) unsigned NOT NULL,
  `ad_userid` varchar(23) NOT NULL,
  `ad_userpw` varchar(100) NOT NULL,
  `disp_name` varchar(23) NOT NULL DEFAULT 'coraadmin',
  `last_login` datetime NOT NULL,
  `last_ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_set_adm`
--

INSERT INTO `tcp_set_adm` (`admin_id`, `ad_userid`, `ad_userpw`, `disp_name`, `last_login`, `last_ip`) VALUES
(1, 'coraadmin', 'c3c51582043246e717b3763dcc28673c', 'coraadmin', '2015-01-16 02:53:58', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tcp_set_cur`
--

CREATE TABLE IF NOT EXISTS `tcp_set_cur` (
  `set_cur_id` int(10) unsigned NOT NULL,
  `use_sandbox` tinyint(1) NOT NULL DEFAULT '1',
  `pp_merch_id` varchar(45) DEFAULT NULL,
  `pp_org_name` varchar(45) DEFAULT NULL,
  `pp_currency` varchar(10) NOT NULL DEFAULT 'USD',
  `return_url` varchar(100) NOT NULL DEFAULT 'donate/thankyou',
  `cancel_url` varchar(100) NOT NULL DEFAULT 'donate/cancel',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_set_cur`
--

INSERT INTO `tcp_set_cur` (`set_cur_id`, `use_sandbox`, `pp_merch_id`, `pp_org_name`, `pp_currency`, `return_url`, `cancel_url`, `status`) VALUES
(0, 1, '', 'Organization Name', 'USD', 'donate/thankyou', 'donate/cancel', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcp_set_gen`
--

CREATE TABLE IF NOT EXISTS `tcp_set_gen` (
  `set_gen_id` int(10) unsigned NOT NULL,
  `serv_name` varchar(45) NOT NULL,
  `theme` varchar(45) NOT NULL,
  `emulator` enum('e','h','r') NOT NULL DEFAULT 'r',
  `homepage` int(11) DEFAULT NULL,
  `tospage` int(11) NOT NULL DEFAULT '0',
  `capt_pvt_key` varchar(100) NOT NULL,
  `capt_pub_key` varchar(100) NOT NULL,
  `const_mode` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_set_gen`
--

INSERT INTO `tcp_set_gen` (`set_gen_id`, `serv_name`, `theme`, `emulator`, `homepage`, `tospage`, `capt_pvt_key`, `capt_pub_key`, `const_mode`) VALUES
(1, 'Cora Ragnarok Online', 'cora', 'h', 0, 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tcp_set_mail`
--

CREATE TABLE IF NOT EXISTS `tcp_set_mail` (
  `set_mail_id` int(10) unsigned NOT NULL,
  `email` varchar(45) NOT NULL,
  `email_smtp` varchar(45) NOT NULL,
  `userpass` varchar(45) DEFAULT NULL,
  `smtp_host` varchar(45) NOT NULL,
  `smtp_port` int(10) unsigned NOT NULL,
  `active_service` enum('SMTP','MAIL') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_set_mail`
--

INSERT INTO `tcp_set_mail` (`set_mail_id`, `email`, `email_smtp`, `userpass`, `smtp_host`, `smtp_port`, `active_service`) VALUES
(1, 'admin@example.com', 'user@gmail.com', 'password', 'ssl://smtp.googlemail.com', 465, 'SMTP');

-- --------------------------------------------------------

--
-- Table structure for table `tcp_shop`
--

CREATE TABLE IF NOT EXISTS `tcp_shop` (
`shop_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `price_donate` int(10) unsigned NOT NULL,
  `price_vote` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_v4p`
--

CREATE TABLE IF NOT EXISTS `tcp_v4p` (
`v4p_id` int(10) unsigned NOT NULL,
  `label` varchar(45) NOT NULL,
  `url` text NOT NULL,
  `cooldown` int(10) unsigned NOT NULL DEFAULT '720',
  `value` int(10) unsigned NOT NULL,
  `image` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_vote_log`
--

CREATE TABLE IF NOT EXISTS `tcp_vote_log` (
`vote_log_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `v4p_id` int(10) unsigned NOT NULL,
  `last_vote` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_wid`
--

CREATE TABLE IF NOT EXISTS `tcp_wid` (
`wid_id` int(11) NOT NULL,
  `desc` varchar(45) NOT NULL,
  `child_tbl` varchar(45) DEFAULT NULL,
  `page` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcp_wid`
--

INSERT INTO `tcp_wid` (`wid_id`, `desc`, `child_tbl`, `page`) VALUES
(1, 'Account', '', 'wid_acc'),
(2, 'Server Status', 'tcp_wid_ss', 'wid_ss'),
(3, 'Navigation', 'tcp_wid_nav', 'wid_nav'),
(4, 'Vote 4 Points', NULL, 'wid_v4p'),
(5, 'Server Status Inline', 'tcp_wid_ss', 'wid_ss_inline'),
(6, 'Account Inline', NULL, 'wid_acc_inline'),
(7, 'Rankings', 'tcp_wid_rank', 'wid_rank'),
(8, 'Search', NULL, 'wid_search');

-- --------------------------------------------------------

--
-- Table structure for table `tcp_wid_nav`
--

CREATE TABLE IF NOT EXISTS `tcp_wid_nav` (
`wid_nav_id` int(11) NOT NULL,
  `wid_used_id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_wid_rank`
--

CREATE TABLE IF NOT EXISTS `tcp_wid_rank` (
`wid_rank_id` int(11) NOT NULL,
  `wid_used_id` int(11) NOT NULL,
  `display` enum('b','p','g') NOT NULL DEFAULT 'b',
  `pl_rank_sort` enum('k','l','z') NOT NULL DEFAULT 'k',
  `gl_rank_sort` enum('l','c') NOT NULL DEFAULT 'l'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_wid_ss`
--

CREATE TABLE IF NOT EXISTS `tcp_wid_ss` (
`wid_ss_id` int(11) NOT NULL,
  `wid_used_id` int(11) DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `port_map` int(11) NOT NULL DEFAULT '5121',
  `port_char` int(11) NOT NULL DEFAULT '6121',
  `port_login` int(11) NOT NULL DEFAULT '6900',
  `player_online` tinyint(1) DEFAULT '1',
  `player_peak` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tcp_wid_used`
--

CREATE TABLE IF NOT EXISTS `tcp_wid_used` (
`wid_used_id` int(11) NOT NULL,
  `wid_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `parent` varchar(45) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tcp_cart`
--
ALTER TABLE `tcp_cart`
 ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `tcp_dash_li`
--
ALTER TABLE `tcp_dash_li`
 ADD PRIMARY KEY (`dash_li_id`);

--
-- Indexes for table `tcp_donate`
--
ALTER TABLE `tcp_donate`
 ADD PRIMARY KEY (`donate_id`);

--
-- Indexes for table `tcp_donate_log`
--
ALTER TABLE `tcp_donate_log`
 ADD PRIMARY KEY (`donate_log_id`);

--
-- Indexes for table `tcp_logs`
--
ALTER TABLE `tcp_logs`
 ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tcp_nav`
--
ALTER TABLE `tcp_nav`
 ADD PRIMARY KEY (`nav_id`);

--
-- Indexes for table `tcp_nav_li`
--
ALTER TABLE `tcp_nav_li`
 ADD PRIMARY KEY (`nav_li_id`);

--
-- Indexes for table `tcp_order`
--
ALTER TABLE `tcp_order`
 ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tcp_order_items`
--
ALTER TABLE `tcp_order_items`
 ADD PRIMARY KEY (`order_items_id`);

--
-- Indexes for table `tcp_page`
--
ALTER TABLE `tcp_page`
 ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `tcp_pass_res`
--
ALTER TABLE `tcp_pass_res`
 ADD PRIMARY KEY (`pass_res_id`);

--
-- Indexes for table `tcp_post`
--
ALTER TABLE `tcp_post`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tcp_post_event`
--
ALTER TABLE `tcp_post_event`
 ADD PRIMARY KEY (`post_event_id`);

--
-- Indexes for table `tcp_profile`
--
ALTER TABLE `tcp_profile`
 ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `tcp_register`
--
ALTER TABLE `tcp_register`
 ADD PRIMARY KEY (`register_id`);

--
-- Indexes for table `tcp_sessions`
--
ALTER TABLE `tcp_sessions`
 ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `tcp_shop`
--
ALTER TABLE `tcp_shop`
 ADD PRIMARY KEY (`shop_id`), ADD UNIQUE KEY `item_id` (`item_id`);

--
-- Indexes for table `tcp_v4p`
--
ALTER TABLE `tcp_v4p`
 ADD PRIMARY KEY (`v4p_id`);

--
-- Indexes for table `tcp_vote_log`
--
ALTER TABLE `tcp_vote_log`
 ADD PRIMARY KEY (`vote_log_id`);

--
-- Indexes for table `tcp_wid`
--
ALTER TABLE `tcp_wid`
 ADD PRIMARY KEY (`wid_id`);

--
-- Indexes for table `tcp_wid_nav`
--
ALTER TABLE `tcp_wid_nav`
 ADD PRIMARY KEY (`wid_nav_id`);

--
-- Indexes for table `tcp_wid_rank`
--
ALTER TABLE `tcp_wid_rank`
 ADD PRIMARY KEY (`wid_rank_id`);

--
-- Indexes for table `tcp_wid_ss`
--
ALTER TABLE `tcp_wid_ss`
 ADD PRIMARY KEY (`wid_ss_id`);

--
-- Indexes for table `tcp_wid_used`
--
ALTER TABLE `tcp_wid_used`
 ADD PRIMARY KEY (`wid_used_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tcp_cart`
--
ALTER TABLE `tcp_cart`
MODIFY `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_dash_li`
--
ALTER TABLE `tcp_dash_li`
MODIFY `dash_li_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tcp_donate`
--
ALTER TABLE `tcp_donate`
MODIFY `donate_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_donate_log`
--
ALTER TABLE `tcp_donate_log`
MODIFY `donate_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_logs`
--
ALTER TABLE `tcp_logs`
MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tcp_nav`
--
ALTER TABLE `tcp_nav`
MODIFY `nav_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tcp_nav_li`
--
ALTER TABLE `tcp_nav_li`
MODIFY `nav_li_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tcp_order`
--
ALTER TABLE `tcp_order`
MODIFY `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_order_items`
--
ALTER TABLE `tcp_order_items`
MODIFY `order_items_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_page`
--
ALTER TABLE `tcp_page`
MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_pass_res`
--
ALTER TABLE `tcp_pass_res`
MODIFY `pass_res_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_post`
--
ALTER TABLE `tcp_post`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_post_event`
--
ALTER TABLE `tcp_post_event`
MODIFY `post_event_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_profile`
--
ALTER TABLE `tcp_profile`
MODIFY `profile_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_register`
--
ALTER TABLE `tcp_register`
MODIFY `register_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_shop`
--
ALTER TABLE `tcp_shop`
MODIFY `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_v4p`
--
ALTER TABLE `tcp_v4p`
MODIFY `v4p_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_vote_log`
--
ALTER TABLE `tcp_vote_log`
MODIFY `vote_log_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_wid`
--
ALTER TABLE `tcp_wid`
MODIFY `wid_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tcp_wid_nav`
--
ALTER TABLE `tcp_wid_nav`
MODIFY `wid_nav_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_wid_rank`
--
ALTER TABLE `tcp_wid_rank`
MODIFY `wid_rank_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_wid_ss`
--
ALTER TABLE `tcp_wid_ss`
MODIFY `wid_ss_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tcp_wid_used`
--
ALTER TABLE `tcp_wid_used`
MODIFY `wid_used_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
