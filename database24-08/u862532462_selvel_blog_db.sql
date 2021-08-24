-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2021 at 08:11 PM
-- Server version: 10.4.14-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u862532462_selvel_blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `se_commentmeta`
--

CREATE TABLE `se_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `se_comments`
--

CREATE TABLE `se_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `se_links`
--

CREATE TABLE `se_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `se_options`
--

CREATE TABLE `se_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_options`
--

INSERT INTO `se_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'https://solvoix.xyz/selvel/blog', 'yes'),
(2, 'home', 'https://solvoix.xyz/selvel/blog', 'yes'),
(3, 'blogname', 'Blog', 'yes'),
(4, 'blogdescription', '', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'digambar@innovins.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '', 'yes'),
(11, 'comments_notify', '', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'closed', 'yes'),
(20, 'default_ping_status', 'closed', 'yes'),
(21, 'default_pingback_flag', '', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'F j, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(26, 'comment_moderation', '', 'yes'),
(27, 'moderation_notify', '', 'yes'),
(28, 'permalink_structure', '/%category%/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:92:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:31:\".+?/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:41:\".+?/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:61:\".+?/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:56:\".+?/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:56:\".+?/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:37:\".+?/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:22:\"(.+?)/([^/]+)/embed/?$\";s:63:\"index.php?category_name=$matches[1]&name=$matches[2]&embed=true\";s:26:\"(.+?)/([^/]+)/trackback/?$\";s:57:\"index.php?category_name=$matches[1]&name=$matches[2]&tb=1\";s:46:\"(.+?)/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:69:\"index.php?category_name=$matches[1]&name=$matches[2]&feed=$matches[3]\";s:41:\"(.+?)/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:69:\"index.php?category_name=$matches[1]&name=$matches[2]&feed=$matches[3]\";s:34:\"(.+?)/([^/]+)/page/?([0-9]{1,})/?$\";s:70:\"index.php?category_name=$matches[1]&name=$matches[2]&paged=$matches[3]\";s:41:\"(.+?)/([^/]+)/comment-page-([0-9]{1,})/?$\";s:70:\"index.php?category_name=$matches[1]&name=$matches[2]&cpage=$matches[3]\";s:30:\"(.+?)/([^/]+)(?:/([0-9]+))?/?$\";s:69:\"index.php?category_name=$matches[1]&name=$matches[2]&page=$matches[3]\";s:20:\".+?/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:30:\".+?/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:50:\".+?/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:45:\".+?/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:45:\".+?/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:26:\".+?/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:38:\"(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:33:\"(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:14:\"(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:26:\"(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:33:\"(.+?)/comment-page-([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&cpage=$matches[2]\";s:8:\"(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:2:{i:0;s:37:\"breadcrumb-navxt/breadcrumb-navxt.php\";i:1;s:33:\"classic-editor/classic-editor.php\";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', 'a:3:{i:0;s:53:\"/var/www/html/blog/wp-content/themes/selvel/style.css\";i:1;s:57:\"/var/www/html/blog/wp-content/plugins/akismet/akismet.php\";i:2;s:0:\"\";}', 'no'),
(40, 'template', 'selvel', 'yes'),
(41, 'stylesheet', 'selvel', 'yes'),
(42, 'comment_whitelist', '', 'yes'),
(43, 'blacklist_keys', '', 'no'),
(44, 'comment_registration', '', 'yes'),
(45, 'html_type', 'text/html', 'yes'),
(46, 'use_trackback', '0', 'yes'),
(47, 'default_role', 'subscriber', 'yes'),
(48, 'db_version', '44719', 'yes'),
(49, 'uploads_use_yearmonth_folders', '1', 'yes'),
(50, 'upload_path', '', 'yes'),
(51, 'blog_public', '1', 'yes'),
(52, 'default_link_category', '2', 'yes'),
(53, 'show_on_front', 'posts', 'yes'),
(54, 'tag_base', '', 'yes'),
(55, 'show_avatars', '1', 'yes'),
(56, 'avatar_rating', 'G', 'yes'),
(57, 'upload_url_path', '', 'yes'),
(58, 'thumbnail_size_w', '150', 'yes'),
(59, 'thumbnail_size_h', '150', 'yes'),
(60, 'thumbnail_crop', '1', 'yes'),
(61, 'medium_size_w', '300', 'yes'),
(62, 'medium_size_h', '300', 'yes'),
(63, 'avatar_default', 'mystery', 'yes'),
(64, 'large_size_w', '1024', 'yes'),
(65, 'large_size_h', '1024', 'yes'),
(66, 'image_default_link_type', 'none', 'yes'),
(67, 'image_default_size', '', 'yes'),
(68, 'image_default_align', '', 'yes'),
(69, 'close_comments_for_old_posts', '', 'yes'),
(70, 'close_comments_days_old', '14', 'yes'),
(71, 'thread_comments', '', 'yes'),
(72, 'thread_comments_depth', '5', 'yes'),
(73, 'page_comments', '', 'yes'),
(74, 'comments_per_page', '50', 'yes'),
(75, 'default_comments_page', 'newest', 'yes'),
(76, 'comment_order', 'asc', 'yes'),
(77, 'sticky_posts', 'a:0:{}', 'yes'),
(78, 'widget_categories', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(79, 'widget_text', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(80, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(81, 'uninstall_plugins', 'a:1:{s:33:\"classic-editor/classic-editor.php\";a:2:{i:0;s:14:\"Classic_Editor\";i:1;s:9:\"uninstall\";}}', 'no'),
(82, 'timezone_string', '', 'yes'),
(83, 'page_for_posts', '0', 'yes'),
(84, 'page_on_front', '0', 'yes'),
(85, 'default_post_format', '0', 'yes'),
(86, 'link_manager_enabled', '0', 'yes'),
(87, 'finished_splitting_shared_terms', '1', 'yes'),
(88, 'site_icon', '7', 'yes'),
(89, 'medium_large_size_w', '768', 'yes'),
(90, 'medium_large_size_h', '0', 'yes'),
(91, 'wp_page_for_privacy_policy', '3', 'yes'),
(92, 'show_comments_cookies_opt_in', '', 'yes'),
(93, 'initial_db_version', '44719', 'yes'),
(94, 'se_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:18:\"bcn_manage_options\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(95, 'fresh_site', '0', 'yes'),
(96, 'widget_search', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(97, 'widget_recent-posts', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(98, 'widget_recent-comments', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(99, 'widget_archives', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(100, 'widget_meta', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(101, 'sidebars_widgets', 'a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:0:{}s:13:\"array_version\";i:3;}', 'yes'),
(102, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(103, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(104, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(105, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(107, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(108, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(110, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(111, 'cron', 'a:6:{i:1629577344;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1629584544;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1629627850;a:1:{s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1629627860;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1629627880;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}', 'yes'),
(112, 'theme_mods_twentynineteen', 'a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1593426385;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}', 'yes'),
(121, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:7:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:7:\"upgrade\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.3.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.3.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.5.3-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.5.3-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.5.3\";s:7:\"version\";s:5:\"5.5.3\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";}i:1;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.3.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.3.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.5.3-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.5.3-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.5.3\";s:7:\"version\";s:5:\"5.5.3\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:2;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.2.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.5.2.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.5.2-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.5.2-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.5.2\";s:7:\"version\";s:5:\"5.5.2\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:3;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.4.4.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.4.4.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.4.4-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.4.4-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.4.4\";s:7:\"version\";s:5:\"5.4.4\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:4;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.3.6.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.3.6.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.3.6-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.3.6-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.3.6\";s:7:\"version\";s:5:\"5.3.6\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:5;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.2.9.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.2.9.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.2.9-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.2.9-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.2.9\";s:7:\"version\";s:5:\"5.2.9\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:6;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.1.8.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.1.8.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.1.8-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.1.8-new-bundled.zip\";s:7:\"partial\";s:69:\"https://downloads.wordpress.org/release/wordpress-5.1.8-partial-6.zip\";s:8:\"rollback\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.1.8-rollback-6.zip\";}s:7:\"current\";s:5:\"5.1.8\";s:7:\"version\";s:5:\"5.1.8\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.3\";s:15:\"partial_version\";s:5:\"5.1.6\";s:9:\"new_files\";s:0:\"\";}}s:12:\"last_checked\";i:1604399207;s:15:\"version_checked\";s:5:\"5.1.6\";s:12:\"translations\";a:0:{}}', 'no'),
(124, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:21:\"digambar@innovins.com\";s:7:\"version\";s:5:\"5.1.6\";s:9:\"timestamp\";i:1593426200;}', 'no'),
(132, 'can_compress_scripts', '1', 'no'),
(146, 'recently_activated', 'a:0:{}', 'yes'),
(149, '_site_transient_update_themes', 'O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1629541697;s:7:\"checked\";a:1:{s:6:\"selvel\";s:0:\"\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}}', 'no'),
(150, 'current_theme', 'Selvel', 'yes'),
(151, 'theme_mods_simona', 'a:5:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;s:16:\"header_textcolor\";s:5:\"blank\";s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1593431242;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}', 'yes'),
(152, 'theme_switched', '', 'yes'),
(163, 'theme_mods_selvel', 'a:6:{i:0;b:0;s:18:\"nav_menu_locations\";a:1:{s:7:\"primary\";i:3;}s:18:\"custom_css_post_id\";i:-1;s:12:\"header_image\";s:76:\"http://localhost/wordpress/selvel-blog/wp-content/uploads/2020/06/banner.png\";s:17:\"header_image_data\";O:8:\"stdClass\":5:{s:13:\"attachment_id\";i:6;s:3:\"url\";s:76:\"http://localhost/wordpress/selvel-blog/wp-content/uploads/2020/06/banner.png\";s:13:\"thumbnail_url\";s:76:\"http://localhost/wordpress/selvel-blog/wp-content/uploads/2020/06/banner.png\";s:6:\"height\";i:322;s:5:\"width\";i:1366;}s:16:\"header_textcolor\";s:5:\"blank\";}', 'yes'),
(165, 'nav_menu_options', 'a:2:{i:0;b:0;s:8:\"auto_add\";a:0:{}}', 'yes'),
(200, 'widget_bcn_widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(201, 'bcn_version', '6.5.0', 'no'),
(202, 'bcn_options_bk', 'a:50:{s:17:\"bmainsite_display\";b:1;s:18:\"Hmainsite_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:28:\"Hmainsite_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:13:\"bhome_display\";b:1;s:14:\"Hhome_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:24:\"Hhome_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:13:\"bblog_display\";b:1;s:10:\"hseparator\";s:6:\" &gt; \";s:12:\"blimit_title\";b:0;s:17:\"amax_title_length\";i:20;s:20:\"bcurrent_item_linked\";b:1;s:28:\"bpost_page_hierarchy_display\";b:1;s:33:\"bpost_page_hierarchy_parent_first\";b:1;s:25:\"Spost_page_hierarchy_type\";s:15:\"BCN_POST_PARENT\";s:19:\"Hpost_page_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:29:\"Hpost_page_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:15:\"apost_page_root\";s:1:\"0\";s:15:\"Hpaged_template\";s:41:\"<span class=\"%type%\">Page %htitle%</span>\";s:14:\"bpaged_display\";b:1;s:19:\"Hpost_post_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:29:\"Hpost_post_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:15:\"apost_post_root\";s:1:\"0\";s:28:\"bpost_post_hierarchy_display\";b:1;s:33:\"bpost_post_hierarchy_parent_first\";b:0;s:27:\"bpost_post_taxonomy_referer\";b:0;s:25:\"Spost_post_hierarchy_type\";s:8:\"category\";s:32:\"bpost_attachment_archive_display\";b:1;s:34:\"bpost_attachment_hierarchy_display\";b:1;s:39:\"bpost_attachment_hierarchy_parent_first\";b:1;s:33:\"bpost_attachment_taxonomy_referer\";b:0;s:31:\"Spost_attachment_hierarchy_type\";s:15:\"BCN_POST_PARENT\";s:21:\"apost_attachment_root\";i:0;s:25:\"Hpost_attachment_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:35:\"Hpost_attachment_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:13:\"H404_template\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:10:\"S404_title\";s:3:\"404\";s:16:\"Hsearch_template\";s:319:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\">Search results for &#039;<a property=\"item\" typeof=\"WebPage\" title=\"Go to the first page of search results for %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current>%htitle%</a>&#039;</span><meta property=\"position\" content=\"%position%\"></span>\";s:26:\"Hsearch_template_no_anchor\";s:67:\"<span class=\"%type%\">Search results for &#039;%htitle%&#039;</span>\";s:22:\"Htax_post_tag_template\";s:268:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% tag archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:32:\"Htax_post_tag_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:25:\"Htax_post_format_template\";s:264:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:35:\"Htax_post_format_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:16:\"Hauthor_template\";s:258:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\">Articles by: <a title=\"Go to the first page of posts by %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current>%htitle%</a></span><meta property=\"position\" content=\"%position%\"></span>\";s:26:\"Hauthor_template_no_anchor\";s:49:\"<span class=\"%type%\">Articles by: %htitle%</span>\";s:12:\"Sauthor_name\";s:12:\"display_name\";s:12:\"aauthor_root\";i:0;s:22:\"Htax_category_template\";s:273:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% category archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:32:\"Htax_category_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:14:\"Hdate_template\";s:264:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:24:\"Hdate_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";}', 'yes'),
(203, 'bcn_options', 'a:50:{s:17:\"bmainsite_display\";b:1;s:18:\"Hmainsite_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:28:\"Hmainsite_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:13:\"bhome_display\";b:1;s:14:\"Hhome_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:24:\"Hhome_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:13:\"bblog_display\";b:1;s:10:\"hseparator\";s:6:\" &gt; \";s:12:\"blimit_title\";b:0;s:17:\"amax_title_length\";i:20;s:20:\"bcurrent_item_linked\";b:1;s:28:\"bpost_page_hierarchy_display\";b:1;s:33:\"bpost_page_hierarchy_parent_first\";b:1;s:25:\"Spost_page_hierarchy_type\";s:15:\"BCN_POST_PARENT\";s:19:\"Hpost_page_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:29:\"Hpost_page_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:15:\"apost_page_root\";s:1:\"0\";s:15:\"Hpaged_template\";s:41:\"<span class=\"%type%\">Page %htitle%</span>\";s:14:\"bpaged_display\";b:1;s:19:\"Hpost_post_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:29:\"Hpost_post_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:15:\"apost_post_root\";s:1:\"0\";s:28:\"bpost_post_hierarchy_display\";b:1;s:33:\"bpost_post_hierarchy_parent_first\";b:0;s:27:\"bpost_post_taxonomy_referer\";b:1;s:25:\"Spost_post_hierarchy_type\";s:8:\"category\";s:32:\"bpost_attachment_archive_display\";b:1;s:34:\"bpost_attachment_hierarchy_display\";b:1;s:39:\"bpost_attachment_hierarchy_parent_first\";b:1;s:33:\"bpost_attachment_taxonomy_referer\";b:0;s:31:\"Spost_attachment_hierarchy_type\";s:15:\"BCN_POST_PARENT\";s:21:\"apost_attachment_root\";i:0;s:25:\"Hpost_attachment_template\";s:251:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:35:\"Hpost_attachment_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:13:\"H404_template\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:10:\"S404_title\";s:3:\"404\";s:16:\"Hsearch_template\";s:319:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\">Search results for &#039;<a property=\"item\" typeof=\"WebPage\" title=\"Go to the first page of search results for %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current>%htitle%</a>&#039;</span><meta property=\"position\" content=\"%position%\"></span>\";s:26:\"Hsearch_template_no_anchor\";s:67:\"<span class=\"%type%\">Search results for &#039;%htitle%&#039;</span>\";s:22:\"Htax_post_tag_template\";s:268:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% tag archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:32:\"Htax_post_tag_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:25:\"Htax_post_format_template\";s:264:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:35:\"Htax_post_format_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:16:\"Hauthor_template\";s:258:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\">Articles by: <a title=\"Go to the first page of posts by %title%.\" href=\"%link%\" class=\"%type%\" bcn-aria-current>%htitle%</a></span><meta property=\"position\" content=\"%position%\"></span>\";s:26:\"Hauthor_template_no_anchor\";s:49:\"<span class=\"%type%\">Articles by: %htitle%</span>\";s:12:\"Sauthor_name\";s:12:\"display_name\";s:12:\"aauthor_root\";i:0;s:22:\"Htax_category_template\";s:273:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% category archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:32:\"Htax_category_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";s:14:\"Hdate_template\";s:264:\"<span property=\"itemListElement\" typeof=\"ListItem\"><a property=\"item\" typeof=\"WebPage\" title=\"Go to the %title% archives.\" href=\"%link%\" class=\"%type%\" bcn-aria-current><span property=\"name\">%htitle%</span></a><meta property=\"position\" content=\"%position%\"></span>\";s:24:\"Hdate_template_no_anchor\";s:195:\"<span property=\"itemListElement\" typeof=\"ListItem\"><span property=\"name\" class=\"%type%\">%htitle%</span><meta property=\"url\" content=\"%link%\"><meta property=\"position\" content=\"%position%\"></span>\";}', 'yes'),
(276, 'responsive_menu_version', '3.1.30', 'yes'),
(279, 'responsive_menu_current_page', 'button', 'yes'),
(280, 'hide_pro_options', 'no', 'yes'),
(1419, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1629541696;s:7:\"checked\";a:4:{s:19:\"akismet/akismet.php\";s:5:\"4.1.6\";s:37:\"breadcrumb-navxt/breadcrumb-navxt.php\";s:5:\"6.5.0\";s:33:\"classic-editor/classic-editor.php\";s:3:\"1.5\";s:21:\"hello-dolly/hello.php\";s:5:\"1.7.2\";}s:8:\"response\";a:3:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:6:\"4.1.10\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:57:\"https://downloads.wordpress.org/plugin/akismet.4.1.10.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";s:6:\"tested\";s:3:\"5.8\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:37:\"breadcrumb-navxt/breadcrumb-navxt.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:30:\"w.org/plugins/breadcrumb-navxt\";s:4:\"slug\";s:16:\"breadcrumb-navxt\";s:6:\"plugin\";s:37:\"breadcrumb-navxt/breadcrumb-navxt.php\";s:11:\"new_version\";s:5:\"6.6.0\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/breadcrumb-navxt/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/breadcrumb-navxt.6.6.0.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:69:\"https://ps.w.org/breadcrumb-navxt/assets/icon-256x256.png?rev=2410525\";s:2:\"1x\";s:61:\"https://ps.w.org/breadcrumb-navxt/assets/icon.svg?rev=1927103\";s:3:\"svg\";s:61:\"https://ps.w.org/breadcrumb-navxt/assets/icon.svg?rev=1927103\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/breadcrumb-navxt/assets/banner-1544x500.png?rev=1927103\";s:2:\"1x\";s:71:\"https://ps.w.org/breadcrumb-navxt/assets/banner-772x250.png?rev=1927103\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";s:6:\"tested\";s:5:\"5.7.2\";s:12:\"requires_php\";s:3:\"5.5\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:33:\"classic-editor/classic-editor.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:28:\"w.org/plugins/classic-editor\";s:4:\"slug\";s:14:\"classic-editor\";s:6:\"plugin\";s:33:\"classic-editor/classic-editor.php\";s:11:\"new_version\";s:5:\"1.6.2\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/classic-editor/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/classic-editor.1.6.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671\";s:2:\"1x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671\";s:2:\"1x\";s:69:\"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";s:6:\"tested\";s:3:\"5.8\";s:12:\"requires_php\";s:5:\"5.2.4\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:1:{s:21:\"hello-dolly/hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:21:\"hello-dolly/hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}}}', 'no'),
(2553, 'category_children', 'a:0:{}', 'yes'),
(3957, '_transient_is_multi_author', '0', 'yes'),
(3958, '_transient_simona_categories', '1', 'yes'),
(4642, '_site_transient_timeout_theme_roots', '1629543497', 'no'),
(4643, '_site_transient_theme_roots', 'a:1:{s:6:\"selvel\";s:7:\"/themes\";}', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `se_postmeta`
--

CREATE TABLE `se_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_postmeta`
--

INSERT INTO `se_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(5, 6, '_wp_attached_file', '2020/06/banner.png'),
(6, 6, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1366;s:6:\"height\";i:322;s:4:\"file\";s:18:\"2020/06/banner.png\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:18:\"banner-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:17:\"banner-300x71.png\";s:5:\"width\";i:300;s:6:\"height\";i:71;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:18:\"banner-768x181.png\";s:5:\"width\";i:768;s:6:\"height\";i:181;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:19:\"banner-1024x241.png\";s:5:\"width\";i:1024;s:6:\"height\";i:241;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(7, 7, '_wp_attached_file', '2020/06/logo.png'),
(8, 7, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:194;s:6:\"height\";i:161;s:4:\"file\";s:16:\"2020/06/logo.png\";s:5:\"sizes\";a:1:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:16:\"logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(31, 12, '_menu_item_type', 'custom'),
(32, 12, '_menu_item_menu_item_parent', '0'),
(33, 12, '_menu_item_object_id', '12'),
(34, 12, '_menu_item_object', 'custom'),
(35, 12, '_menu_item_target', ''),
(36, 12, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(37, 12, '_menu_item_xfn', ''),
(38, 12, '_menu_item_url', '#'),
(40, 13, '_menu_item_type', 'custom'),
(41, 13, '_menu_item_menu_item_parent', '0'),
(42, 13, '_menu_item_object_id', '13'),
(43, 13, '_menu_item_object', 'custom'),
(44, 13, '_menu_item_target', ''),
(45, 13, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(46, 13, '_menu_item_xfn', ''),
(47, 13, '_menu_item_url', '#'),
(49, 14, '_menu_item_type', 'custom'),
(50, 14, '_menu_item_menu_item_parent', '0'),
(51, 14, '_menu_item_object_id', '14'),
(52, 14, '_menu_item_object', 'custom'),
(53, 14, '_menu_item_target', ''),
(54, 14, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(55, 14, '_menu_item_xfn', ''),
(56, 14, '_menu_item_url', '#'),
(58, 15, '_menu_item_type', 'custom'),
(59, 15, '_menu_item_menu_item_parent', '0'),
(60, 15, '_menu_item_object_id', '15'),
(61, 15, '_menu_item_object', 'custom'),
(62, 15, '_menu_item_target', ''),
(63, 15, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(64, 15, '_menu_item_xfn', ''),
(65, 15, '_menu_item_url', '#'),
(76, 17, '_menu_item_type', 'custom'),
(77, 17, '_menu_item_menu_item_parent', '0'),
(78, 17, '_menu_item_object_id', '17'),
(79, 17, '_menu_item_object', 'custom'),
(80, 17, '_menu_item_target', ''),
(81, 17, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(82, 17, '_menu_item_xfn', ''),
(83, 17, '_menu_item_url', 'https://selvelglobal.com/index.php'),
(85, 18, '_menu_item_type', 'custom'),
(86, 18, '_menu_item_menu_item_parent', '0'),
(87, 18, '_menu_item_object_id', '18'),
(88, 18, '_menu_item_object', 'custom'),
(89, 18, '_menu_item_target', ''),
(90, 18, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(91, 18, '_menu_item_xfn', ''),
(92, 18, '_menu_item_url', 'https://www.selvelglobal.com/eat'),
(94, 19, '_menu_item_type', 'custom'),
(95, 19, '_menu_item_menu_item_parent', '0'),
(96, 19, '_menu_item_object_id', '19'),
(97, 19, '_menu_item_object', 'custom'),
(98, 19, '_menu_item_target', ''),
(99, 19, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(100, 19, '_menu_item_xfn', ''),
(101, 19, '_menu_item_url', 'https://www.selvelglobal.com/about-us.php'),
(103, 6, '_wp_attachment_custom_header_last_used_selvel', '1593431473'),
(104, 6, '_wp_attachment_is_custom_header', 'selvel'),
(109, 1, '_edit_lock', '1613060244:1'),
(112, 1, '_edit_last', '1'),
(113, 1, '_thumbnail_id', '73'),
(118, 24, '_wp_attached_file', '2020/06/4.jpg'),
(119, 24, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1274;s:6:\"height\";i:849;s:4:\"file\";s:13:\"2020/06/4.jpg\";s:5:\"sizes\";a:7:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:13:\"4-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:13:\"4-300x200.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:13:\"4-768x512.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:512;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:14:\"4-1024x682.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:682;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"post-thumbnail\";a:4:{s:4:\"file\";s:13:\"4-800x500.jpg\";s:5:\"width\";i:800;s:6:\"height\";i:500;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:18:\"simona-index-thumb\";a:4:{s:4:\"file\";s:13:\"4-390x450.jpg\";s:5:\"width\";i:390;s:6:\"height\";i:450;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:20:\"simona-gallery-thumb\";a:4:{s:4:\"file\";s:13:\"4-800x600.jpg\";s:5:\"width\";i:800;s:6:\"height\";i:600;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(122, 1, '_wp_old_slug', 'hello-world'),
(126, 28, '_edit_last', '1'),
(127, 28, '_edit_lock', '1613060019:1'),
(128, 30, '_wp_attached_file', '2020/07/banner.jpg'),
(129, 30, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:720;s:6:\"height\";i:438;s:4:\"file\";s:18:\"2020/07/banner.jpg\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:18:\"banner-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:18:\"banner-300x183.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:183;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(130, 28, '_thumbnail_id', '72'),
(132, 27, '_edit_last', '1'),
(133, 27, '_edit_lock', '1613056876:1'),
(137, 33, '_edit_last', '1'),
(138, 33, '_edit_lock', '1613059344:1'),
(141, 33, '_thumbnail_id', '70'),
(142, 42, '_wp_attached_file', '2020/07/d.png'),
(143, 42, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:389;s:6:\"height\";i:485;s:4:\"file\";s:13:\"2020/07/d.png\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:13:\"d-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:13:\"d-241x300.png\";s:5:\"width\";i:241;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(145, 43, '_wp_attached_file', '2020/07/a.png'),
(146, 43, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:407;s:6:\"height\";i:508;s:4:\"file\";s:13:\"2020/07/a.png\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:13:\"a-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:13:\"a-240x300.png\";s:5:\"width\";i:240;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(147, 44, '_wp_attached_file', '2020/07/b.png'),
(148, 44, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:394;s:6:\"height\";i:492;s:4:\"file\";s:13:\"2020/07/b.png\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:13:\"b-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:13:\"b-240x300.png\";s:5:\"width\";i:240;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(149, 45, '_wp_attached_file', '2020/07/c.png'),
(150, 45, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:390;s:6:\"height\";i:487;s:4:\"file\";s:13:\"2020/07/c.png\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:13:\"c-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:13:\"c-240x300.png\";s:5:\"width\";i:240;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(155, 46, '_menu_item_type', 'custom'),
(156, 46, '_menu_item_menu_item_parent', '0'),
(157, 46, '_menu_item_object_id', '46'),
(158, 46, '_menu_item_object', 'custom'),
(159, 46, '_menu_item_target', ''),
(160, 46, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(161, 46, '_menu_item_xfn', ''),
(162, 46, '_menu_item_url', 'https://selvelglobal.com/blog/'),
(163, 2, '_edit_lock', '1604478455:1'),
(165, 33, '_wp_old_slug', 'lorem-ipsum-is-simply-3'),
(167, 27, '_wp_old_slug', 'lorem-ipsum-is-simply'),
(168, 60, '_wp_attached_file', '2020/07/Healthy-Eating.jpg'),
(169, 60, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:2048;s:6:\"height\";i:1536;s:4:\"file\";s:26:\"2020/07/Healthy-Eating.jpg\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:26:\"Healthy-Eating-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:26:\"Healthy-Eating-300x225.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:225;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:26:\"Healthy-Eating-768x576.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:27:\"Healthy-Eating-1024x768.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:768;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(171, 61, '_wp_attached_file', '2020/07/Healthy-Eating-1.jpg'),
(172, 61, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1406;s:6:\"height\";i:1536;s:4:\"file\";s:28:\"2020/07/Healthy-Eating-1.jpg\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:28:\"Healthy-Eating-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:28:\"Healthy-Eating-1-275x300.jpg\";s:5:\"width\";i:275;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:28:\"Healthy-Eating-1-768x839.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:839;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:29:\"Healthy-Eating-1-937x1024.jpg\";s:5:\"width\";i:937;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(175, 33, '_wp_old_date', '2020-07-30'),
(178, 28, '_wp_old_slug', 'lorem-ipsum-is-simply-dummy-text-of-the-printing'),
(180, 1, '_wp_old_slug', 'lorem-ipsum-is-simply-dummy-text-of-the-printing-and-typesetting-industry'),
(183, 28, '_wp_old_date', '2020-07-30'),
(185, 27, '_wp_old_date', '2020-07-30'),
(187, 1, '_wp_old_date', '2020-06-29'),
(191, 68, '_wp_attached_file', '2021/01/Rajma-Curry.jpg'),
(192, 68, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:426;s:6:\"height\";i:426;s:4:\"file\";s:23:\"2021/01/Rajma-Curry.jpg\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"Rajma-Curry-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:23:\"Rajma-Curry-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(193, 27, '_thumbnail_id', '69'),
(195, 69, '_wp_attached_file', '2021/01/vegetable-biryani.jpeg'),
(196, 69, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:975;s:6:\"height\";i:1300;s:4:\"file\";s:30:\"2021/01/vegetable-biryani.jpeg\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:30:\"vegetable-biryani-150x150.jpeg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:30:\"vegetable-biryani-225x300.jpeg\";s:5:\"width\";i:225;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:31:\"vegetable-biryani-768x1024.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:31:\"vegetable-biryani-768x1024.jpeg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(198, 70, '_wp_attached_file', '2021/02/heathy.jpg'),
(199, 70, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:975;s:6:\"height\";i:1300;s:4:\"file\";s:18:\"2021/02/heathy.jpg\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:18:\"heathy-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:18:\"heathy-225x300.jpg\";s:5:\"width\";i:225;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:19:\"heathy-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:19:\"heathy-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(202, 72, '_wp_attached_file', '2021/02/diet.jpg'),
(203, 72, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:975;s:6:\"height\";i:1300;s:4:\"file\";s:16:\"2021/02/diet.jpg\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:16:\"diet-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:16:\"diet-225x300.jpg\";s:5:\"width\";i:225;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:17:\"diet-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:17:\"diet-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(206, 73, '_wp_attached_file', '2021/02/homemadefood.jpg'),
(207, 73, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:975;s:6:\"height\";i:1300;s:4:\"file\";s:24:\"2021/02/homemadefood.jpg\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:24:\"homemadefood-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:24:\"homemadefood-225x300.jpg\";s:5:\"width\";i:225;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:25:\"homemadefood-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:25:\"homemadefood-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(209, 74, '_edit_last', '1'),
(210, 74, '_edit_lock', '1622433986:1'),
(212, 76, '_wp_attached_file', '2021/02/family.jpg'),
(213, 76, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:975;s:6:\"height\";i:1300;s:4:\"file\";s:18:\"2021/02/family.jpg\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:18:\"family-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:18:\"family-225x300.jpg\";s:5:\"width\";i:225;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:19:\"family-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:19:\"family-768x1024.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(214, 74, '_thumbnail_id', '76');

-- --------------------------------------------------------

--
-- Table structure for table `se_posts`
--

CREATE TABLE `se_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_posts`
--

INSERT INTO `se_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2021-02-05 10:22:18', '2021-02-05 10:22:18', '<!-- wp:paragraph -->\r\n<p><b>Why are homemade foods better?</b></p>\r\n<p><span style=\"font-weight: 400;\">Home cooked meals are always better than meals cooked in hotels, restaurants, or some other places. The most important reason for homemade food being excellent is because of food hygiene / cleanliness that is followed at home. A study has also found that people who eat home cooked healthy meals are at lower risk of any health issues if compared to people who often eat outside. </span></p>\r\n<p><span style=\"font-weight: 400;\">There is always less chance of using preservatives in home made food and hence it helps in making our immune system stronger. </span></p>\r\n<p><b>Why should you carry home cooked food?</b></p>\r\n<p><span style=\"font-weight: 400;\">Outside food generally contains high amounts of sodium and refined grains which can affect the physical and mental health of a person. On the other side, home cooked foods tend to be healthier and happier as the use of preservatives are low which can result in higher energy levels, better immune system and a great physical and mental health. </span></p>\r\n<p><b>4 Benefits of Home Cooked Meals</b></p>\r\n<p><strong>1. Use of simple and Natural Ingredients</strong></p>\r\n<p><span style=\"font-weight: 400;\">As mentioned above, outside meals are prepared by using high levels of preservatives and contain high amounts of sodium that can harm the health of a person and weaken their immune system.  On the other side, homemade meals are prepared by using natural ingredients, fresh vegetables and minimum use of preservatives. Without the use of preservatives in homemade food the natural ingredients keep away the harmful effects and give a natural taste. </span></p>\r\n<p><strong>2. Food Safety</strong></p>\r\n<p><span style=\"font-weight: 400;\">In a study it is proven that people who consume outside food have more risk of food poisoning as food safety is followed at minimum level in hotels and restaurants.  It is always recommended to ensure that the food that you eat is cookeds with utmost safety as it can be one of the major reasons for illness. </span></p>\r\n<p><strong>3. Avoid food allergies and sensitivities</strong></p>\r\n<p><span style=\"font-weight: 400;\">Home Cooked food  can be especially beneficial if you or a family member has a food allergy. Because you are in control in your own kitchen, you can reduce the risk of an allergic reaction.</span></p>\r\n<p><strong>4. Brings Family together</strong></p>\r\n<p><span style=\"font-weight: 400;\">The most important and joyful part of having homemade food is it brings family together to dine and express gratitude together!</span></p>\r\n<p><span style=\"font-weight: 400;\">At Selvel, we understand the importance of home cooked food and emotions attached to it and hence our containers, tiffins and bottles are made with utmost care and safety to provide you good health. </span></p>\r\n<!-- /wp:paragraph -->', 'Top Homemade Food Health Benefits', '', 'publish', 'closed', 'closed', '', 'top-homemade-food-health-benefits', '', '', '2021-02-11 16:17:23', '2021-02-11 16:17:23', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=1', 0, 'post', '', 0),
(2, 1, '2020-06-29 10:22:18', '2020-06-29 10:22:18', '<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href=\"http://shareittofriends.com/demo/selvel/website/blog/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->', 'Sample Page', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2020-06-29 10:22:18', '2020-06-29 10:22:18', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?page_id=2', 0, 'page', '', 0),
(3, 1, '2020-06-29 10:22:18', '2020-06-29 10:22:18', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Our website address is: http://shareittofriends.com/demo/selvel/website/blog.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What personal data we collect and why we collect it</h2><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Comments</h3><!-- /wp:heading --><!-- wp:paragraph --><p>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Media</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Contact forms</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Cookies</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you have an account and you log in to this site, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Embedded content from other websites</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading {\"level\":3} --><h3>Analytics</h3><!-- /wp:heading --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Your contact information</h2><!-- /wp:heading --><!-- wp:heading --><h2>Additional information</h2><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>How we protect your data</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>What data breach procedures we have in place</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>What third parties we receive data from</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>What automated decision making and/or profiling we do with user data</h3><!-- /wp:heading --><!-- wp:heading {\"level\":3} --><h3>Industry regulatory disclosure requirements</h3><!-- /wp:heading -->', 'Privacy Policy', '', 'draft', 'closed', 'open', '', 'privacy-policy', '', '', '2020-06-29 10:22:18', '2020-06-29 10:22:18', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?page_id=3', 0, 'page', '', 0),
(6, 1, '2020-06-29 11:43:23', '2020-06-29 11:43:23', '', 'banner', '', 'inherit', 'open', 'closed', '', 'banner', '', '', '2020-06-29 11:43:23', '2020-06-29 11:43:23', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/06/banner.png', 0, 'attachment', 'image/png', 0),
(7, 1, '2020-06-29 11:43:25', '2020-06-29 11:43:25', '', 'logo', '', 'inherit', 'open', 'closed', '', 'logo', '', '', '2020-06-29 11:43:25', '2020-06-29 11:43:25', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/06/logo.png', 0, 'attachment', 'image/png', 0),
(12, 1, '2020-06-29 11:48:31', '2020-06-29 11:48:31', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2020-06-29 11:48:38', '2020-06-29 11:48:38', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=12', 1, 'nav_menu_item', '', 0),
(13, 1, '2020-06-29 11:48:32', '2020-06-29 11:48:32', '', 'Shop Now', '', 'publish', 'closed', 'closed', '', 'shop-now', '', '', '2020-06-29 11:48:38', '2020-06-29 11:48:38', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=13', 2, 'nav_menu_item', '', 0),
(14, 1, '2020-06-29 11:48:32', '2020-06-29 11:48:32', '', 'About', '', 'publish', 'closed', 'closed', '', 'about', '', '', '2020-06-29 11:48:38', '2020-06-29 11:48:38', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=14', 3, 'nav_menu_item', '', 0),
(15, 1, '2020-06-29 11:48:33', '2020-06-29 11:48:33', '', 'Explore', '', 'publish', 'closed', 'closed', '', 'explore', '', '', '2020-06-29 11:48:38', '2020-06-29 11:48:38', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=15', 4, 'nav_menu_item', '', 0),
(17, 1, '2020-06-29 11:50:32', '2020-06-29 11:50:32', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home-2', '', '', '2021-05-20 10:34:14', '2021-05-20 10:34:14', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=17', 1, 'nav_menu_item', '', 0),
(18, 1, '2020-06-29 11:50:32', '2020-06-29 11:50:32', '', 'Shop Now', '', 'publish', 'closed', 'closed', '', 'shop-now-2', '', '', '2021-05-20 10:34:14', '2021-05-20 10:34:14', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=18', 2, 'nav_menu_item', '', 0),
(19, 1, '2020-06-29 11:50:33', '2020-06-29 11:50:33', '', 'About', '', 'publish', 'closed', 'closed', '', 'about-2', '', '', '2021-05-20 10:34:14', '2021-05-20 10:34:14', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=19', 3, 'nav_menu_item', '', 0),
(22, 1, '2020-06-29 13:22:20', '2020-06-29 13:22:20', '<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->', 'Lorem Ipsum is simply dummy text of the printing and  typesetting industry.', '', 'inherit', 'closed', 'closed', '', '1-revision-v1', '', '', '2020-06-29 13:22:20', '2020-06-29 13:22:20', '', 1, 'http://shareittofriends.com/demo/selvel/website/blog/1-revision-v1/', 0, 'revision', '', 0),
(23, 1, '2020-06-29 13:24:54', '2020-06-29 13:24:54', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor.</p>\r\n<p>Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id. Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat.</p>\r\n<p>Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo. Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>\r\n<p>Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl.</p>\r\n<p>Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor. Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>\r\n<!-- /wp:paragraph -->', 'Lorem Ipsum is simply dummy text of the printing and  typesetting industry.', '', 'inherit', 'closed', 'closed', '', '1-revision-v1', '', '', '2020-06-29 13:24:54', '2020-06-29 13:24:54', '', 1, 'http://shareittofriends.com/demo/selvel/website/blog/1-revision-v1/', 0, 'revision', '', 0),
(24, 1, '2020-06-29 16:12:00', '2020-06-29 16:12:00', '', '4', '', 'inherit', 'open', 'closed', '', '4', '', '', '2020-06-29 16:12:00', '2020-06-29 16:12:00', '', 1, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/06/4.jpg', 0, 'attachment', 'image/jpeg', 0),
(27, 1, '2021-01-25 08:22:06', '2021-01-25 08:22:06', '<!-- wp:paragraph -->\r\n<p><span style=\"font-weight: 400;\">Healthy food is the way to a good life and eating healthy can be easy, affordable and delicious. It’s all about choosing the perfect ingredients and your healthy food will taste amazing. After all it has so many benefits in maintaining your body and preventing it from diseases. </span></p>\r\n<p><span style=\"font-weight: 400;\">It is always easy to choose junk food over nutritional food but our super easy and healthy food recipes will want you to switch your preference. We know it’s difficult to follow a strict diet all at once so we suggest you to slow start with us!</span></p>\r\n<p><b>5 Super Healthy and Delicious Recipes </b></p>\r\n<p><strong>1. Easy Veg Biryani </strong></p>\r\n<p><span style=\"font-weight: 400;\">Yes you read it correct! Veg Biryani is super easy and filled with a lot of nutrients is a delicious recipe you must definitely try. It contains 9g protein and 6g fats and it just takes 20 mins to cook this amazing veg biryani. </span></p>\r\n<p><span style=\"font-weight: 400;\">You would need 250 grams of basmati rice, 400 grams of mixed  vegetables of your choice, 8-10 raisins and roasted cashew nuts. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make this biryani mix all the ingredients together along with water, salt and put it in the microwave for 12 minutes at 850 watts.</span></p>\r\n<p><span style=\"font-weight: 400;\">Your deliciously healthy Veggie Biryani is ready to serve 4 people.</span></p>\r\n<p><strong>2. Oats Idli</strong></p>\r\n<p><span style=\"font-weight: 400;\">Oats are very beneficial as they are rich in fiber and it helps to feel fuller for longer time. It is also rich in vitamins, minerals and protein. Oats Idli are very simple to make and super delicious. </span></p>\r\n<p><span style=\"font-weight: 400;\">You would need 2 cups of roasted oats, 1 cup grated carrots/ capsicum and coriander. </span></p>\r\n<p><span style=\"font-weight: 400;\">You will have to mix this batter with water and steam this batter. The super tasty and nutritious Idlis are ready to serve 4 people.</span></p>\r\n<p><strong>3. Ragi Cookies</strong></p>\r\n<p><span style=\"font-weight: 400;\">Ragi is a rich source of fiber and it also helps to lower the levels of cholesterol. It is also considered to be beneficial for weight and diabetes management. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make these yummy ragi cookies you will require 1 cup ragi flour, half cup sugar or substitute of sugar, half tablespoon cardamom powder, 2 pinch of ginger powder, half cup oil and a pinch of salt. </span></p>\r\n<p><span style=\"font-weight: 400;\">Mix all the ingredients together and make small balls, preheat the oven for 5-6 minutes and bake for 8 minutes at 180 degree celcius.</span></p>\r\n<p><span style=\"font-weight: 400;\">Scrumptious Ragi cookies are ready to serve.</span></p>\r\n<p><strong>4. Palak Dal </strong></p>\r\n<p><span style=\"font-weight: 400;\">Palak/Spinach is popular for its health benefits. It is full of nutrients and contains low fat and high iron properties. Spinach is good for eyes, hair and skin. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make this healthy and easy recipe you will require 2 bunch of Spinach/Palak, half cup any dal of your choice (Arhar dal preferred), 1 tablespoon ghee, 1 green and red chilli, pinch of hing and salt. </span></p>\r\n<p><span style=\"font-weight: 400;\">The dal can be cooked in a pressure cooker by mixing all the ingredients together and waiting until 2-3 whistles and it will be ready to serve.</span></p>\r\n<p><strong>5. Rajma Curry</strong></p>\r\n<p><span style=\"font-weight: 400;\">Rajma also known as Red Kidney beans are a source of iron and dietary fibre. It helps to control cholesterol and tastes delicious with rice. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make Rajma curry you will require 1 cup soaked Rajma, 1 chopped onion, half cup yoghurt, 1 tablespoon oil, half cup tomato puree, 2 green chilli, sliced ginger and salt to taste. </span></p>\r\n<p><span style=\"font-weight: 400;\">Firstly, add soaked rajma with salt in a pressure cooker and cook until it gets soft, then saute the onion until it gets light brown in a heated pan and then add ginger, tomato puree, cook for sometime and then add the rajma and cook for 2 minutes. </span></p>\r\n<p><span style=\"font-weight: 400;\">The tempting Rajma curry is ready to serve with rice. </span></p>\r\n<!-- /wp:paragraph -->', '5 Indian Healthy Recipes', '', 'publish', 'closed', 'closed', '', '5-indian-healthy-recipes', '', '', '2021-02-11 15:20:37', '2021-02-11 15:20:37', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=27', 0, 'post', '', 0),
(28, 1, '2021-02-08 08:21:11', '2021-02-08 08:21:11', '<!-- wp:paragraph -->\r\n<p><b>What is a Sattvic diet?</b></p>\r\n<p><span style=\"font-weight: 400;\">The word Sattvic means ‘‘pure essence’’ and sattvic foods are considered as pure and balanced as they offer feelings of calmness, happiness and mental clarity. A Sattvic diet is based on ayurvedic principles of food. It is basically a vegetarian diet which is followed amongst the yoga enthusiasts. A person who follows a sattvic diet avoids foods that are rajasic and tamasic like Meat, Eggs, Sugar, Fried or spicy food. It is one of the oldest and medicinal diet forms originated in India 5000 years ago. </span></p>\r\n<p><span style=\"font-weight: 400;\">As Sattvic food is rich in fiber and contains low fat nutrients, it helps to maintain good physical and mental health. </span></p>\r\n<p><b>Benefits of Sattvic Diet</b></p>\r\n<p><span style=\"font-weight: 400;\">Sattvic or Yogic diet that balances body and soul has enormous benefits in maintaining your well being. Below are the top 4 benefits of following a Sattiv diet:</span></p>\r\n<p><strong>1. Promotes nutritional foods</strong></p>\r\n<p><span style=\"font-weight: 400;\">Sattvic Diet promotes consuming whole nutritious foods including vegetables, fruits, nuts which helps in promoting overall health of your body by providing the right amount of protein, vitamins, minerals, fiber and antioxidants that are important for our body to function well. </span></p>\r\n<p><span style=\"font-weight: 400;\">Only including foods rich in nutritions will not help alone in preserving our health, hence in a Sattvic diet it is very important to follow a fixed timing to have your meal as the time plays an important role in maintaining the internal health of our body. </span></p>\r\n<p><strong>2. Promotes Physical and Mental health</strong></p>\r\n<p><span style=\"font-weight: 400;\">Mental health is an important aspect in maintaining Physical health and a major benefit of including a Sattvic diet in your daily routine is that it promotes well being of mental health. As Sattvic diet is also known as Yogic diet it includes various types of yoga asanas along with a variety of food as it believes, a person’s Mental fitness is important to maintain a physical fitness.</span></p>\r\n<p><strong>3. Improves Immunity</strong></p>\r\n<p><span style=\"font-weight: 400;\">A Sattvic Diet promotes nutrient dense foods, including such meals everyday will provide your body with a balance of protein, vitamins, minerals, fiber and antioxidants and this will automatically promise a natural healthy immunity system.</span></p>\r\n<p><strong>4. Promotes Weight Management</strong></p>\r\n<p><span style=\"font-weight: 400;\">As Sattvic Diet promotes high fiber and plant based foods, which may help in weight loss. According to a study it is proved that people who follow a sattvic diet have lower body mass indexes and less body fat when compared to others.  </span></p>\r\n<p><span style=\"font-weight: 400;\">As it promotes vegetarian diet it is proved that, vegetarian diet promotes weight loss. </span></p>\r\n<p><span style=\"font-weight: 400;\">A Sattvic Diet is considered to be one of the most traditional and beneficial diets as it helps our body, soul and mind to connect together and play an important role in maintaining our Physical as well as mental Health. </span></p>', 'How Sattvic Diet can help your Mental and Physical Health.', '', 'publish', 'closed', 'closed', '', 'how-sattvic-diet-can-help-your-mental-and-physical-health', '', '', '2021-02-11 16:13:38', '2021-02-11 16:13:38', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=28', 0, 'post', '', 0),
(29, 1, '2020-07-30 08:16:58', '2020-07-30 08:16:58', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor.</p>\r\n<p>Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id. Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat.</p>\r\n<p>Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo. Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>\r\n<p>Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl.</p>\r\n<p>Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor. Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>\r\n<!-- /wp:paragraph -->', 'Lorem Ipsum is simply dummy text', '', 'inherit', 'closed', 'closed', '', '1-revision-v1', '', '', '2020-07-30 08:16:58', '2020-07-30 08:16:58', '', 1, 'http://shareittofriends.com/demo/selvel/website/blog/1-revision-v1/', 0, 'revision', '', 0),
(30, 1, '2020-07-30 08:21:05', '2020-07-30 08:21:05', '', 'banner', '', 'inherit', 'closed', 'closed', '', 'banner-2', '', '', '2020-07-30 08:21:05', '2020-07-30 08:21:05', '', 28, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/07/banner.jpg', 0, 'attachment', 'image/jpeg', 0),
(31, 1, '2020-07-30 08:21:11', '2020-07-30 08:21:11', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id. Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo. Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl. Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor. Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>', 'Lorem Ipsum is simply dummy text of the printing', '', 'inherit', 'closed', 'closed', '', '28-revision-v1', '', '', '2020-07-30 08:21:11', '2020-07-30 08:21:11', '', 28, 'http://shareittofriends.com/demo/selvel/website/blog/28-revision-v1/', 0, 'revision', '', 0),
(32, 1, '2020-07-30 08:22:06', '2020-07-30 08:22:06', '<!-- wp:paragraph -->\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor.\r\n\r\nSed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id. Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat.\r\n\r\nNullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo. Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\r\n\r\nAliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl.\r\n\r\nPraesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor. Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.\r\n\r\n<!-- /wp:paragraph -->', 'Lorem Ipsum is simply', '', 'inherit', 'closed', 'closed', '', '27-revision-v1', '', '', '2020-07-30 08:22:06', '2020-07-30 08:22:06', '', 27, 'http://shareittofriends.com/demo/selvel/website/blog/27-revision-v1/', 0, 'revision', '', 0),
(33, 1, '2021-02-02 09:49:09', '2021-02-02 09:49:09', '<!-- wp:paragraph -->\r\n<p><span style=\"font-weight: 400;\">We all know that to stay fit and strong we must eat healthy food, But </span><b>What is Healthy Eating?</b></p>\r\n<p><span style=\"font-weight: 400;\">Healthy eating means including a variety of food in our diet that will provide nutrients and help our body to feel good and energetic. Nutrition is an important factor to maintain good health as it provides us protein, carbohydrates, calcium, vitamins, minerals and fiber. </span></p>\r\n<p><b>Why is Healthy Eating important?</b></p>\r\n<p><span style=\"font-weight: 400;\">Eating healthy is the foundation to good health and well-being. As it helps us to maintain proper weight and reduce the risk of many diseases such as type 2 diabetes, high cholesterol, high blood pressure, etc. Healthy eating promotes good health and keeps our body protected. But in our busy schedule we often don’t get enough nutrients which are required by our body and face a lot of difficulties in managing good health. </span></p>\r\n<p><b>Tips for Healthy Eating</b></p>\r\n<p><span style=\"font-weight: 400;\">As we now know that the key to a healthy body is the right choice of food and proper time. It is recommended that men should have around 2,500 and women should have around 2,000 calories per day in order to maintain good health. </span></p>\r\n<p><span style=\"font-weight: 400;\">But in our busy schedule we often choose junk food over healthy food as it is tempting and tastes good. Apart from that food hygiene is the second most important factor in maintaining strong health which is often missing while we consume junk food. </span></p>\r\n<p><span style=\"font-weight: 400;\">The consequence of unhygienic junk food can affect internal parts of our body leading to various health issues. To avoid and preserve your health, Now eating healthy in our busy lifestyle is possible with Selvel. </span></p>\r\n<p><span style=\"font-weight: 400;\">At Selvel, we manufacture kitchenware products with utmost safety. To promote healthy eating habits we have introduced a wide range of containers, tiffin boxes and bottles so that carrying food along with you will not be a problem. </span></p>\r\n<p><span style=\"font-weight: 400;\">Healthy eating is a must and with Selvel products we ensure you a good health!  </span></p>', 'Healthy Eating for busy Lifestyle', '', 'publish', 'closed', 'closed', '', 'healthy-eating-for-busy-lifestyle', '', '', '2021-02-11 15:22:50', '2021-02-11 15:22:50', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=33', 0, 'post', '', 0),
(34, 1, '2020-07-30 09:48:31', '2020-07-30 09:48:31', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id. Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id.</p>\r\n<p>&nbsp;</p>\r\n<p>Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo. Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa.</p>\r\n<p>&nbsp;</p>\r\n<p>Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl. Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor. Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>\r\n<!-- /wp:paragraph -->', 'Lorem Ipsum is simply', '', 'inherit', 'closed', 'closed', '', '27-revision-v1', '', '', '2020-07-30 09:48:31', '2020-07-30 09:48:31', '', 27, 'http://shareittofriends.com/demo/selvel/website/blog/27-revision-v1/', 0, 'revision', '', 0),
(35, 1, '2020-07-30 09:48:53', '2020-07-30 09:48:53', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id.</p>\r\n<p>&nbsp;</p>\r\n<p>Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo.</p>\r\n<p>&nbsp;</p>\r\n<p>Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl. Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor.</p>\r\n<p>&nbsp;</p>\r\n<p>Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>', 'Lorem Ipsum is simply dummy text of the printing', '', 'inherit', 'closed', 'closed', '', '28-revision-v1', '', '', '2020-07-30 09:48:53', '2020-07-30 09:48:53', '', 28, 'http://shareittofriends.com/demo/selvel/website/blog/28-revision-v1/', 0, 'revision', '', 0),
(36, 1, '2020-07-30 09:49:09', '2020-07-30 09:49:09', '<!-- wp:paragraph -->\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id.\r\n\r\n&nbsp;\r\n\r\nNunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo.\r\n\r\n&nbsp;\r\n\r\nNulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl. Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor.\r\n\r\n&nbsp;\r\n\r\nMorbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.', 'Lorem Ipsum is simply 3', '', 'inherit', 'closed', 'closed', '', '33-revision-v1', '', '', '2020-07-30 09:49:09', '2020-07-30 09:49:09', '', 33, 'http://shareittofriends.com/demo/selvel/website/blog/33-revision-v1/', 0, 'revision', '', 0);
INSERT INTO `se_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(37, 1, '2020-07-30 09:49:30', '2020-07-30 09:49:30', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id.</p>\r\n<p>Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo.</p>\r\n<p>Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl. Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor.</p>\r\n<p>Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>', 'Lorem Ipsum is simply dummy text of the printing', '', 'inherit', 'closed', 'closed', '', '28-revision-v1', '', '', '2020-07-30 09:49:30', '2020-07-30 09:49:30', '', 28, 'http://shareittofriends.com/demo/selvel/website/blog/28-revision-v1/', 0, 'revision', '', 0),
(38, 1, '2021-02-11 14:23:26', '2021-02-11 14:23:26', '<!-- wp:paragraph -->\n<p><span style=\"font-weight: 400;\">Healthy food is the way to a good life and eating healthy can be easy, affordable and delicious. It’s all about choosing the perfect ingredients and your healthy food will taste amazing. After all it has so many benefits in maintaining your body and preventing it from diseases. </span></p>\n<p><span style=\"font-weight: 400;\">It is always easy to choose junk food over nutritional food but our super easy and healthy food recipes will want you to switch your preference. We know it’s difficult to follow a strict diet all at once so we suggest you to slow start with us!</span></p>\n<p><b>5 Super Healthy and Delicious Recipes </b></p>\n<p><strong>1. Easy Veg Biryani </strong></p>\n<p><span style=\"font-weight: 400;\">Yes you read it correct! Veg Biryani is super easy and filled with a lot of nutrients is a delicious recipe you must definitely try. It contains 9g protein and 6g fats and it just takes 20 mins to cook this amazing veg biryani. </span></p>\n<p><span style=\"font-weight: 400;\">You would need 250 grams of basmati rice, 400 grams of mixed  vegetables of your choice, 8-10 raisins and roasted cashew nuts. </span></p>\n<p><span style=\"font-weight: 400;\">To make this biryani mix all the ingredients together along with water, salt and put it in the microwave for 12 minutes at 850 watts.</span></p>\n<p><span style=\"font-weight: 400;\">Your deliciously healthy Veggie Biryani is ready to serve 4 people.</span></p>\n<ol>\n<li style=\"font-weight: 400;\" aria-level=\"1\"><span style=\"font-weight: 400;\">Oats Idli</span></li>\n</ol>\n<p><span style=\"font-weight: 400;\">Oats are very beneficial as they are rich in fiber and it helps to feel fuller for longer time. It is also rich in vitamins, minerals and protein. Oats Idli are very simple to make and super delicious. </span></p>\n<p>&nbsp;</p>\n<p><span style=\"font-weight: 400;\">You would need 2 cups of roasted oats, 1 cup grated carrots/ capsicum and coriander. </span></p>\n<p><span style=\"font-weight: 400;\">You will have to mix this batter with water and steam this batter. The super tasty and nutritious Idlis are ready to serve 4 people.</span></p>\n<ol>\n<li style=\"font-weight: 400;\" aria-level=\"1\"><span style=\"font-weight: 400;\">Ragi Cookies</span></li>\n</ol>\n<p><span style=\"font-weight: 400;\">Ragi is a rich source of fiber and it also helps to lower the levels of cholesterol. It is also considered to be beneficial for weight and diabetes management. </span></p>\n<p><span style=\"font-weight: 400;\">To make these yummy ragi cookies you will require 1 cup ragi flour, half cup sugar or substitute of sugar, half tablespoon cardamom powder, 2 pinch of ginger powder, half cup oil and a pinch of salt. </span></p>\n<p><span style=\"font-weight: 400;\">Mix all the ingredients together and make small balls, preheat the oven for 5-6 minutes and bake for 8 minutes at 180 degree celcius.</span></p>\n<p><span style=\"font-weight: 400;\">Scrumptious Ragi cookies are ready to serve.</span></p>\n<ol>\n<li style=\"font-weight: 400;\" aria-level=\"1\"><span style=\"font-weight: 400;\">Palak Dal </span></li>\n</ol>\n<p>&nbsp;</p>\n<p><span style=\"font-weight: 400;\">Palak/Spinach is popular for its health benefits. It is full of nutrients and contains low fat and high iron properties. Spinach is good for eyes, hair and skin. </span></p>\n<p><span style=\"font-weight: 400;\">To make this healthy and easy recipe you will require 2 bunch of Spinach/Palak, half cup any dal of your choice (Arhar dal preferred), 1 tablespoon ghee, 1 green and red chilli, pinch of hing and salt. </span></p>\n<p><span style=\"font-weight: 400;\">The dal can be cooked in a pressure cooker by mixing all the ingredients together and waiting until 2-3 whistles and it will be ready to serve.</span></p>\n<ol>\n<li style=\"font-weight: 400;\" aria-level=\"1\"><span style=\"font-weight: 400;\">Rajma Curry</span></li>\n</ol>\n<p><span style=\"font-weight: 400;\">Rajma also known as Red Kidney beans are a source of iron and dietary fibre. It helps to control cholesterol and tastes delicious with rice. </span></p>\n<p><span style=\"font-weight: 400;\">To make Rajma curry you will require 1 cup soaked Rajma, 1 chopped onion, half cup yoghurt, 1 tablespoon oil, half cup tomato puree, 2 green chilli, sliced ginger and salt to taste. </span></p>\n<p><span style=\"font-weight: 400;\">Firstly, add soaked rajma with salt in a pressure cooker and cook until it gets soft, then saute the onion until it gets light brown in a heated pan and then add ginger, tomato puree, cook for sometime and then add the rajma and cook for 2 minutes. </span></p>\n<p><span style=\"font-weight: 400;\">The tempting Rajma curry is ready to serve with rice. </span></p>\n<!-- /wp:paragraph -->', '5 Indian Healthy Recipes', '', 'inherit', 'closed', 'closed', '', '27-autosave-v1', '', '', '2021-02-11 14:23:26', '2021-02-11 14:23:26', '', 27, 'http://shareittofriends.com/demo/selvel/website/blog/27-autosave-v1/', 0, 'revision', '', 0),
(39, 1, '2020-07-30 09:49:38', '2020-07-30 09:49:38', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id. Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id.</p>\r\n<p>Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo. Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa.</p>\r\n<p>Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl. Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor. Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>\r\n<!-- /wp:paragraph -->', 'Lorem Ipsum is simply', '', 'inherit', 'closed', 'closed', '', '27-revision-v1', '', '', '2020-07-30 09:49:38', '2020-07-30 09:49:38', '', 27, 'http://shareittofriends.com/demo/selvel/website/blog/27-revision-v1/', 0, 'revision', '', 0),
(40, 1, '2020-07-30 09:49:51', '2020-07-30 09:49:51', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id.  </p>\r\n<p>Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo.   Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna. Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum.</p>\r\n<p>Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl. Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor.   Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>', 'Lorem Ipsum is simply 3', '', 'inherit', 'closed', 'closed', '', '33-revision-v1', '', '', '2020-07-30 09:49:51', '2020-07-30 09:49:51', '', 33, 'http://shareittofriends.com/demo/selvel/website/blog/33-revision-v1/', 0, 'revision', '', 0),
(41, 1, '2020-07-30 09:50:04', '2020-07-30 09:50:04', '<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris elementum quis elit sit amet ornare. Aliquam imperdiet, magna sit amet congue imperdiet, urna eros ullamcorper arcu, auctor lobortis felis nulla quis nunc. Aenean vestibulum, magna eget varius feugiat, libero ipsum efficitur libero, in consequat eros arcu dapibus nisl. Aenean vel dui fermentum, malesuada lorem ut, eleifend neque. Curabitur semper imperdiet risus id sagittis. Mauris pulvinar sed massa quis iaculis. Integer interdum massa felis, in gravida purus sollicitudin non. In vestibulum velit vitae massa tincidunt, tempus scelerisque leo tempor. Sed aliquet dolor dui, id fermentum sem interdum sit amet. Quisque vitae pretium magna. Duis suscipit justo magna, sit amet malesuada erat tempus id.</p>\r\n<p>Nunc in mollis neque. Sed ut tellus elit. Vivamus molestie rutrum tortor, nec porta erat condimentum id. Vestibulum ullamcorper fringilla elit, non dapibus ligula consequat in. Aliquam erat volutpat. Nullam bibendum mauris ac nisi porttitor posuere. Etiam in vestibulum diam. Proin venenatis maximus feugiat. Nulla nec orci sodales, porttitor neque eget, bibendum purus. Curabitur convallis lectus vitae nulla dapibus, et rhoncus velit commodo. Nulla congue, augue eget tincidunt lacinia, tortor neque interdum purus, nec suscipit turpis erat vitae urna.</p>\r\n<p>Integer ac nunc nec ipsum viverra lacinia. Vestibulum posuere purus vitae feugiat tempor. Duis augue nisl, blandit finibus libero ut, finibus elementum massa. Donec pulvinar eget massa ut lobortis. In accumsan auctor lectus, id consectetur eros euismod id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam ac nulla lacus. Aliquam eget ex sed nulla eleifend interdum. Morbi vulputate, nisl ut sollicitudin pulvinar, purus enim efficitur odio, et imperdiet leo ex eu nulla. Quisque eu sem blandit, finibus sem a, hendrerit lectus. Etiam nec luctus velit. Phasellus porttitor risus at congue condimentum. Mauris eget congue massa. Vivamus eget varius turpis. Morbi vitae feugiat erat, at faucibus felis. Nam et pellentesque nisl.</p>\r\n<p>Praesent eget turpis quis neque ullamcorper malesuada. Aenean quis velit quis nisl lacinia luctus non vestibulum dolor. Morbi aliquet maximus faucibus. Quisque nec tortor pellentesque, mollis enim ut, aliquam tortor. Mauris elementum neque et est ultrices vulputate. Fusce ac magna ante. Aliquam condimentum purus nec ornare mattis. Nam a nisi et mauris aliquam porta eget eget tortor. Proin ullamcorper vehicula mi. Maecenas varius sit amet urna in fringilla. Ut dapibus tristique odio, at dictum erat pharetra vel. Vivamus sit amet felis quam. Fusce sit amet semper ex. Cras ac faucibus dolor. Proin ut interdum libero. Duis id sapien in velit congue venenatis.</p>', 'Lorem Ipsum is simply dummy text of the printing', '', 'inherit', 'closed', 'closed', '', '28-revision-v1', '', '', '2020-07-30 09:50:04', '2020-07-30 09:50:04', '', 28, 'http://shareittofriends.com/demo/selvel/website/blog/28-revision-v1/', 0, 'revision', '', 0),
(42, 1, '2020-07-30 11:25:18', '2020-07-30 11:25:18', '', 'd', '', 'inherit', 'closed', 'closed', '', 'd', '', '', '2020-07-30 11:25:18', '2020-07-30 11:25:18', '', 28, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/07/d.png', 0, 'attachment', 'image/png', 0),
(43, 1, '2020-07-30 11:25:49', '2020-07-30 11:25:49', '', 'a', '', 'inherit', 'closed', 'closed', '', 'a', '', '', '2020-07-30 11:25:49', '2020-07-30 11:25:49', '', 33, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/07/a.png', 0, 'attachment', 'image/png', 0),
(44, 1, '2020-07-30 11:25:53', '2020-07-30 11:25:53', '', 'b', '', 'inherit', 'closed', 'closed', '', 'b', '', '', '2020-07-30 11:25:53', '2020-07-30 11:25:53', '', 33, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/07/b.png', 0, 'attachment', 'image/png', 0),
(45, 1, '2020-07-30 11:25:54', '2020-07-30 11:25:54', '', 'c', '', 'inherit', 'closed', 'closed', '', 'c', '', '', '2020-07-30 11:25:54', '2020-07-30 11:25:54', '', 33, 'http://shareittofriends.com/demo/selvel/website/blog/wp-content/uploads/2020/07/c.png', 0, 'attachment', 'image/png', 0),
(46, 1, '2020-07-30 13:26:29', '2020-07-30 13:26:29', '', 'Explore', '', 'publish', 'closed', 'closed', '', 'blog', '', '', '2021-05-20 10:34:14', '2021-05-20 10:34:14', '', 0, 'http://shareittofriends.com/demo/selvel/website/blog/?p=46', 4, 'nav_menu_item', '', 0),
(55, 1, '2021-02-11 15:22:32', '2021-02-11 15:22:32', '<!-- wp:paragraph -->\n<p><span style=\"font-weight: 400;\">We all know that to stay fit and strong we must eat healthy food, But </span><b>What is Healthy Eating?</b></p>\n<p><span style=\"font-weight: 400;\">Healthy eating means including a variety of food in our diet that will provide nutrients and help our body to feel good and energetic. Nutrition is an important factor to maintain good health as it provides us protein, carbohydrates, calcium, vitamins, minerals and fiber. </span></p>\n<p><b>Why is Healthy Eating important?</b></p>\n<p><span style=\"font-weight: 400;\">Eating healthy is the foundation to good health and well-being. As it helps us to maintain proper weight and reduce the risk of many diseases such as type 2 diabetes, high cholesterol, high blood pressure, etc. Healthy eating promotes good health and keeps our body protected. But in our busy schedule we often don’t get enough nutrients which are required by our body and face a lot of difficulties in managing good health. </span></p>\n<p><b>Tips for Healthy Eating</b></p>\n<p><span style=\"font-weight: 400;\">As we now know that the key to a healthy body is the right choice of food and proper time. It is recommended that men should have around 2,500 and women should have around 2,000 calories per day in order to maintain good health. </span></p>\n<p><span style=\"font-weight: 400;\">But in our busy schedule we often choose junk food over healthy food as it is tempting and tastes good. Apart from that food hygiene is the second most important factor in maintaining strong health which is often missing while we consume junk food. </span></p>\n<p><span style=\"font-weight: 400;\">The consequence of unhygienic junk food can affect internal parts of our body leading to various health issues. To avoid and preserve your health, Now eating healthy in our busy lifestyle is possible with Selvel. </span></p>\n<p><span style=\"font-weight: 400;\">At Selvel, we manufacture kitchenware products with utmost safety. To promote healthy eating habits we have introduced a wide range of containers, tiffin boxes and bottles so that carrying food along with you will not be a problem. </span></p>\n<p><span style=\"font-weight: 400;\">Healthy eating is a must and with Selvel products we ensure you a good health!  </span></p>', 'Healthy Eating for busy Lifestyle', '', 'inherit', 'closed', 'closed', '', '33-autosave-v1', '', '', '2021-02-11 15:22:32', '2021-02-11 15:22:32', '', 33, 'https://selvelglobal.com/blog/33-autosave-v1/', 0, 'revision', '', 0),
(56, 1, '2021-02-11 14:13:56', '2021-02-11 14:13:56', '<!-- wp:paragraph -->\r\n<p><span style=\"font-weight: 400;\">We all know that to stay fit and strong we must eat healthy food, But </span><b>What is Healthy Eating?</b></p>\r\n<p><span style=\"font-weight: 400;\">Healthy eating means including a variety of food in our diet that will provide nutrients and help our body to feel good and energetic. Nutrition is an important factor to maintain good health as it provides us protein, carbohydrates, calcium, vitamins, minerals and fiber. </span></p>\r\n<p>&nbsp;</p>\r\n<p><b>Why is Healthy Eating important?</b></p>\r\n<p><span style=\"font-weight: 400;\">Eating healthy is the foundation to good health and well-being. As it helps us to maintain proper weight and reduce the risk of many diseases such as type 2 diabetes, high cholesterol, high blood pressure, etc. Healthy eating promotes good health and keeps our body protected. But in our busy schedule we often don’t get enough nutrients which are required by our body and face a lot of difficulties in managing good health. </span></p>\r\n<p>&nbsp;</p>\r\n<p><b>Tips for Healthy Eating</b></p>\r\n<p><span style=\"font-weight: 400;\">As we now know that the key to a healthy body is the right choice of food and proper time. It is recommended that men should have around 2,500 and women should have around 2,000 calories per day in order to maintain good health. </span></p>\r\n<p><span style=\"font-weight: 400;\">But in our busy schedule we often choose junk food over healthy food as it is tempting and tastes good. Apart from that food hygiene is the second most important factor in maintaining strong health which is often missing while we consume junk food. </span></p>\r\n<p><span style=\"font-weight: 400;\">The consequence of unhygienic junk food can affect internal parts of our body leading to various health issues. To avoid and preserve your health, Now eating healthy in our busy lifestyle is possible with Selvel. </span></p>\r\n<p><span style=\"font-weight: 400;\">At Selvel, we manufacture kitchenware products with utmost safety. To promote healthy eating habits we have introduced a wide range of containers, tiffin boxes and bottles so that carrying food along with you will not be a problem. </span></p>\r\n<p><span style=\"font-weight: 400;\">Healthy eating is a must and with Selvel products we ensure you a good health!  </span></p>', 'Healthy Eating for busy Lifestyle', '', 'inherit', 'closed', 'closed', '', '33-revision-v1', '', '', '2021-02-11 14:13:56', '2021-02-11 14:13:56', '', 33, 'https://selvelglobal.com/blog/33-revision-v1/', 0, 'revision', '', 0),
(57, 1, '2021-02-11 14:23:59', '2021-02-11 14:23:59', '<!-- wp:paragraph -->\r\n<p><span style=\"font-weight: 400;\">Healthy food is the way to a good life and eating healthy can be easy, affordable and delicious. It’s all about choosing the perfect ingredients and your healthy food will taste amazing. After all it has so many benefits in maintaining your body and preventing it from diseases. </span></p>\r\n<p><span style=\"font-weight: 400;\">It is always easy to choose junk food over nutritional food but our super easy and healthy food recipes will want you to switch your preference. We know it’s difficult to follow a strict diet all at once so we suggest you to slow start with us!</span></p>\r\n<p><b>5 Super Healthy and Delicious Recipes </b></p>\r\n<p><strong>1. Easy Veg Biryani </strong></p>\r\n<p><span style=\"font-weight: 400;\">Yes you read it correct! Veg Biryani is super easy and filled with a lot of nutrients is a delicious recipe you must definitely try. It contains 9g protein and 6g fats and it just takes 20 mins to cook this amazing veg biryani. </span></p>\r\n<p><span style=\"font-weight: 400;\">You would need 250 grams of basmati rice, 400 grams of mixed  vegetables of your choice, 8-10 raisins and roasted cashew nuts. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make this biryani mix all the ingredients together along with water, salt and put it in the microwave for 12 minutes at 850 watts.</span></p>\r\n<p><span style=\"font-weight: 400;\">Your deliciously healthy Veggie Biryani is ready to serve 4 people.</span></p>\r\n<p><strong>2. Oats Idli</strong></p>\r\n<p><span style=\"font-weight: 400;\">Oats are very beneficial as they are rich in fiber and it helps to feel fuller for longer time. It is also rich in vitamins, minerals and protein. Oats Idli are very simple to make and super delicious. </span></p>\r\n<p><span style=\"font-weight: 400;\">You would need 2 cups of roasted oats, 1 cup grated carrots/ capsicum and coriander. </span></p>\r\n<p><span style=\"font-weight: 400;\">You will have to mix this batter with water and steam this batter. The super tasty and nutritious Idlis are ready to serve 4 people.</span></p>\r\n<p><strong>3. Ragi Cookies</strong></p>\r\n<p><span style=\"font-weight: 400;\">Ragi is a rich source of fiber and it also helps to lower the levels of cholesterol. It is also considered to be beneficial for weight and diabetes management. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make these yummy ragi cookies you will require 1 cup ragi flour, half cup sugar or substitute of sugar, half tablespoon cardamom powder, 2 pinch of ginger powder, half cup oil and a pinch of salt. </span></p>\r\n<p><span style=\"font-weight: 400;\">Mix all the ingredients together and make small balls, preheat the oven for 5-6 minutes and bake for 8 minutes at 180 degree celcius.</span></p>\r\n<p><span style=\"font-weight: 400;\">Scrumptious Ragi cookies are ready to serve.</span></p>\r\n<p><strong>4. Palak Dal </strong></p>\r\n<p><span style=\"font-weight: 400;\">Palak/Spinach is popular for its health benefits. It is full of nutrients and contains low fat and high iron properties. Spinach is good for eyes, hair and skin. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make this healthy and easy recipe you will require 2 bunch of Spinach/Palak, half cup any dal of your choice (Arhar dal preferred), 1 tablespoon ghee, 1 green and red chilli, pinch of hing and salt. </span></p>\r\n<p><span style=\"font-weight: 400;\">The dal can be cooked in a pressure cooker by mixing all the ingredients together and waiting until 2-3 whistles and it will be ready to serve.</span></p>\r\n<p><strong>5. Rajma Curry</strong></p>\r\n<p><span style=\"font-weight: 400;\">Rajma also known as Red Kidney beans are a source of iron and dietary fibre. It helps to control cholesterol and tastes delicious with rice. </span></p>\r\n<p><span style=\"font-weight: 400;\">To make Rajma curry you will require 1 cup soaked Rajma, 1 chopped onion, half cup yoghurt, 1 tablespoon oil, half cup tomato puree, 2 green chilli, sliced ginger and salt to taste. </span></p>\r\n<p><span style=\"font-weight: 400;\">Firstly, add soaked rajma with salt in a pressure cooker and cook until it gets soft, then saute the onion until it gets light brown in a heated pan and then add ginger, tomato puree, cook for sometime and then add the rajma and cook for 2 minutes. </span></p>\r\n<p><span style=\"font-weight: 400;\">The tempting Rajma curry is ready to serve with rice. </span></p>\r\n<!-- /wp:paragraph -->', '5 Indian Healthy Recipes', '', 'inherit', 'closed', 'closed', '', '27-revision-v1', '', '', '2021-02-11 14:23:59', '2021-02-11 14:23:59', '', 27, 'https://selvelglobal.com/blog/27-revision-v1/', 0, 'revision', '', 0),
(59, 1, '2021-02-11 14:26:47', '2021-02-11 14:26:47', '<!-- wp:paragraph -->\n<p><b>What is a Sattvic diet?</b></p>\n<p><span style=\"font-weight: 400;\">The word Sattvic means ‘‘pure essence’’ and sattvic foods are considered as pure and balanced as they offer feelings of calmness, happiness and mental clarity. A Sattvic diet is based on ayurvedic principles of food. It is basically a vegetarian diet which is followed amongst the yoga enthusiasts. A person who follows a sattvic diet avoids foods that are rajasic and tamasic like Meat, Eggs, Sugar, Fried or spicy food. It is one of the oldest and medicinal diet forms originated in India 5000 years ago. </span></p>\n<p><span style=\"font-weight: 400;\">As Sattvic food is rich in fiber and contains low fat nutrients, it helps to maintain good physical and mental health. </span></p>\n<p><b>Benefits of Sattvic Diet</b></p>\n<p><span style=\"font-weight: 400;\">Sattvic or Yogic diet that balances body and soul has enormous benefits in maintaining your well being. Below are the top 4 benefits of following a Sattiv diet:</span></p>\n<p><strong>1. Promotes nutritional foods</strong></p>\n<p><span style=\"font-weight: 400;\">Sattvic Diet promotes consuming whole nutritious foods including vegetables, fruits, nuts which helps in promoting overall health of your body by providing the right amount of protein, vitamins, minerals, fiber and antioxidants that are important for our body to function well. </span></p>\n<p><span style=\"font-weight: 400;\">Only including foods rich in nutritions will not help alone in preserving our health, hence in a Sattvic diet it is very important to follow a fixed timing to have your meal as the time plays an important role in maintaining the internal health of our body. </span></p>\n<p><strong>2. Promotes Physical and Mental health</strong></p>\n<p><span style=\"font-weight: 400;\">Mental health is an important aspect in maintaining Physical health and a major benefit of including a Sattvic diet in your daily routine is that it promotes well being of mental health. As Sattvic diet is also known as Yogic diet it includes various types of yoga asanas along with a variety of food as it believes, a person’s Mental fitness is important to maintain a physical fitness.</span></p>\n<p><strong>3. Improves Immunity</strong></p>\n<p><span style=\"font-weight: 400;\">A Sattvic Diet promotes nutrient dense foods, including such meals everyday will provide your body with a balance of protein, vitamins, minerals, fiber and antioxidants and this will automatically promise a natural healthy immunity system.</span></p>\n<p><strong>4. Promotes Weight Management</strong></p>\n<p><span style=\"font-weight: 400;\">As Sattvic Diet promotes high fiber and plant based foods, which may help in weight loss. According to a study it is proved that people who follow a sattvic diet have lower body mass indexes and less body fat when compared to others.  </span></p>\n<p><span style=\"font-weight: 400;\">As it promotes vegetarian diet it is proved that, vegetarian diet promotes weight loss. </span></p>\n<p>&nbsp;</p>\n<p><span style=\"font-weight: 400;\">A Sattvic Diet is considered to be one of the most traditional and beneficial diets as it helps our body, soul and mind to connect together and play an important role in maintaining our Physical as well as mental Health. </span></p>', 'How Sattvic Diet can help your Mental and Physical Health.', '', 'inherit', 'closed', 'closed', '', '28-autosave-v1', '', '', '2021-02-11 14:26:47', '2021-02-11 14:26:47', '', 28, 'https://selvelglobal.com/blog/28-autosave-v1/', 0, 'revision', '', 0),
(60, 1, '2021-02-11 14:28:44', '2021-02-11 14:28:44', '', 'Healthy Eating', '', 'inherit', 'closed', 'closed', '', 'healthy-eating', '', '', '2021-02-11 14:28:44', '2021-02-11 14:28:44', '', 33, 'https://selvelglobal.com/blog/wp-content/uploads/2020/07/Healthy-Eating.jpg', 0, 'attachment', 'image/jpeg', 0),
(61, 1, '2021-02-11 14:31:07', '2021-02-11 14:31:07', '', 'Healthy-Eating', '', 'inherit', 'closed', 'closed', '', 'healthy-eating-2', '', '', '2021-02-11 14:31:07', '2021-02-11 14:31:07', '', 33, 'https://selvelglobal.com/blog/wp-content/uploads/2020/07/Healthy-Eating-1.jpg', 0, 'attachment', 'image/jpeg', 0),
(62, 1, '2021-02-11 14:32:04', '2021-02-11 14:32:04', '<!-- wp:paragraph -->\r\n<p><span style=\"font-weight: 400;\">We all know that to stay fit and strong we must eat healthy food, But </span><b>What is Healthy Eating?</b></p>\r\n<p><span style=\"font-weight: 400;\">Healthy eating means including a variety of food in our diet that will provide nutrients and help our body to feel good and energetic. Nutrition is an important factor to maintain good health as it provides us protein, carbohydrates, calcium, vitamins, minerals and fiber. </span></p>\r\n<p><b>Why is Healthy Eating important?</b></p>\r\n<p><span style=\"font-weight: 400;\">Eating healthy is the foundation to good health and well-being. As it helps us to maintain proper weight and reduce the risk of many diseases such as type 2 diabetes, high cholesterol, high blood pressure, etc. Healthy eating promotes good health and keeps our body protected. But in our busy schedule we often don’t get enough nutrients which are required by our body and face a lot of difficulties in managing good health. </span></p>\r\n<p><b>Tips for Healthy Eating</b></p>\r\n<p><span style=\"font-weight: 400;\">As we now know that the key to a healthy body is the right choice of food and proper time. It is recommended that men should have around 2,500 and women should have around 2,000 calories per day in order to maintain good health. </span></p>\r\n<p><span style=\"font-weight: 400;\">But in our busy schedule we often choose junk food over healthy food as it is tempting and tastes good. Apart from that food hygiene is the second most important factor in maintaining strong health which is often missing while we consume junk food. </span></p>\r\n<p><span style=\"font-weight: 400;\">The consequence of unhygienic junk food can affect internal parts of our body leading to various health issues. To avoid and preserve your health, Now eating healthy in our busy lifestyle is possible with Selvel. </span></p>\r\n<p><span style=\"font-weight: 400;\">At Selvel, we manufacture kitchenware products with utmost safety. To promote healthy eating habits we have introduced a wide range of containers, tiffin boxes and bottles so that carrying food along with you will not be a problem. </span></p>\r\n<p><span style=\"font-weight: 400;\">Healthy eating is a must and with Selvel products we ensure you a good health!  </span></p>', 'Healthy Eating for busy Lifestyle', '', 'inherit', 'closed', 'closed', '', '33-revision-v1', '', '', '2021-02-11 14:32:04', '2021-02-11 14:32:04', '', 33, 'https://selvelglobal.com/blog/33-revision-v1/', 0, 'revision', '', 0),
(63, 1, '2021-02-11 14:39:06', '2021-02-11 14:39:06', '<!-- wp:paragraph -->\r\n<p><b>What is a Sattvic diet?</b></p>\r\n<p><span style=\"font-weight: 400;\">The word Sattvic means ‘‘pure essence’’ and sattvic foods are considered as pure and balanced as they offer feelings of calmness, happiness and mental clarity. A Sattvic diet is based on ayurvedic principles of food. It is basically a vegetarian diet which is followed amongst the yoga enthusiasts. A person who follows a sattvic diet avoids foods that are rajasic and tamasic like Meat, Eggs, Sugar, Fried or spicy food. It is one of the oldest and medicinal diet forms originated in India 5000 years ago. </span></p>\r\n<p><span style=\"font-weight: 400;\">As Sattvic food is rich in fiber and contains low fat nutrients, it helps to maintain good physical and mental health. </span></p>\r\n<p><b>Benefits of Sattvic Diet</b></p>\r\n<p><span style=\"font-weight: 400;\">Sattvic or Yogic diet that balances body and soul has enormous benefits in maintaining your well being. Below are the top 4 benefits of following a Sattiv diet:</span></p>\r\n<p><strong>1. Promotes nutritional foods</strong></p>\r\n<p><span style=\"font-weight: 400;\">Sattvic Diet promotes consuming whole nutritious foods including vegetables, fruits, nuts which helps in promoting overall health of your body by providing the right amount of protein, vitamins, minerals, fiber and antioxidants that are important for our body to function well. </span></p>\r\n<p><span style=\"font-weight: 400;\">Only including foods rich in nutritions will not help alone in preserving our health, hence in a Sattvic diet it is very important to follow a fixed timing to have your meal as the time plays an important role in maintaining the internal health of our body. </span></p>\r\n<p><strong>2. Promotes Physical and Mental health</strong></p>\r\n<p><span style=\"font-weight: 400;\">Mental health is an important aspect in maintaining Physical health and a major benefit of including a Sattvic diet in your daily routine is that it promotes well being of mental health. As Sattvic diet is also known as Yogic diet it includes various types of yoga asanas along with a variety of food as it believes, a person’s Mental fitness is important to maintain a physical fitness.</span></p>\r\n<p><strong>3. Improves Immunity</strong></p>\r\n<p><span style=\"font-weight: 400;\">A Sattvic Diet promotes nutrient dense foods, including such meals everyday will provide your body with a balance of protein, vitamins, minerals, fiber and antioxidants and this will automatically promise a natural healthy immunity system.</span></p>\r\n<p><strong>4. Promotes Weight Management</strong></p>\r\n<p><span style=\"font-weight: 400;\">As Sattvic Diet promotes high fiber and plant based foods, which may help in weight loss. According to a study it is proved that people who follow a sattvic diet have lower body mass indexes and less body fat when compared to others.  </span></p>\r\n<p><span style=\"font-weight: 400;\">As it promotes vegetarian diet it is proved that, vegetarian diet promotes weight loss. </span></p>\r\n<p><span style=\"font-weight: 400;\">A Sattvic Diet is considered to be one of the most traditional and beneficial diets as it helps our body, soul and mind to connect together and play an important role in maintaining our Physical as well as mental Health. </span></p>', 'How Sattvic Diet can help your Mental and Physical Health.', '', 'inherit', 'closed', 'closed', '', '28-revision-v1', '', '', '2021-02-11 14:39:06', '2021-02-11 14:39:06', '', 28, 'https://selvelglobal.com/blog/28-revision-v1/', 0, 'revision', '', 0),
(64, 1, '2021-02-11 14:40:34', '2021-02-11 14:40:34', '<!-- wp:paragraph -->\n<p>&nbsp;</p>\n<p><b>Why are homemade foods better?</b></p>\n<p>&nbsp;</p>\n<p><span style=\"font-weight: 400;\">Home cooked meals are always better than meals cooked in hotels, restaurants, or some other places. The most important reason for homemade food being excellent is because of food hygiene / cleanliness that is followed at home. A study has also found that  people who eat home cooked healthy meals are at lower risk of any health issues if compared to people who often eat outside. </span></p>\n<p><span style=\"font-weight: 400;\">There is always less chance of using preservatives in home made food and hence it helps in making our immune system stronger. </span></p>\n<p>&nbsp;</p>\n<p><b>Why should you carry home cooked food?</b></p>\n<p>&nbsp;</p>\n<p><span style=\"font-weight: 400;\">Outside food generally contains high amounts of sodium and refined grains which can affect the physical and mental health of a person. On the other side, home cooked foods tend to be healthier and happier as the use of preservatives are low which can result in higher energy levels, better immune system and a great physical and mental health. </span></p>\n<p><b>4 Benefits of Home Cooked Meals</b></p>\n<p><strong>1. Use of simple and Natural Ingredients</strong></p>\n<p><span style=\"font-weight: 400;\">As mentioned above, outside meals are prepared by using high levels of preservatives and contain high amounts of sodium that can harm the health of a person and weaken their immune system.  On the other side, homemade meals are prepared by using natural ingredients, fresh vegetables and minimum use of preservatives. Without the use of preservatives in homemade food the natural ingredients keep away the harmful effects and give a natural taste. </span></p>\n<p><strong>2. Food Safety</strong></p>\n<p><span style=\"font-weight: 400;\">In a study it is proven that people who consume outside food have more risk of food poisoning as food safety is followed at minimum level in hotels and restaurants.  It is always recommended to ensure that the food that you eat is cookeds with utmost safety as it can be one of the major reasons for illness. </span></p>\n<p><strong>3. Avoid food allergies and sensitivities</strong></p>\n<p><span style=\"font-weight: 400;\">Home Cooked food  can be especially beneficial if you or a family member has a food allergy. Because you are in control in your own kitchen, you can reduce the risk of an allergic reaction.</span></p>\n<p><span style=\"font-weight: 400;\">4Brings Family together</span></p>\n<p><span style=\"font-weight: 400;\">The most important and joyful part of having homemade food is it brings family together to dine and express gratitude together!</span></p>\n<p><span style=\"font-weight: 400;\">At Selvel, we understand the importance of home cooked food and emotions attached to it and hence our containers, tiffins and bottles are made with utmost care and safety to provide you good health. </span></p>\n<!-- /wp:paragraph -->', 'Top Homemade Food Health Benefits', '', 'inherit', 'closed', 'closed', '', '1-autosave-v1', '', '', '2021-02-11 14:40:34', '2021-02-11 14:40:34', '', 1, 'https://selvelglobal.com/blog/1-autosave-v1/', 0, 'revision', '', 0),
(65, 1, '2021-02-11 14:40:38', '2021-02-11 14:40:38', '<!-- wp:paragraph -->\r\n<p>&nbsp;</p>\r\n<p><b>Why are homemade foods better?</b></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-weight: 400;\">Home cooked meals are always better than meals cooked in hotels, restaurants, or some other places. The most important reason for homemade food being excellent is because of food hygiene / cleanliness that is followed at home. A study has also found that  people who eat home cooked healthy meals are at lower risk of any health issues if compared to people who often eat outside. </span></p>\r\n<p><span style=\"font-weight: 400;\">There is always less chance of using preservatives in home made food and hence it helps in making our immune system stronger. </span></p>\r\n<p>&nbsp;</p>\r\n<p><b>Why should you carry home cooked food?</b></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-weight: 400;\">Outside food generally contains high amounts of sodium and refined grains which can affect the physical and mental health of a person. On the other side, home cooked foods tend to be healthier and happier as the use of preservatives are low which can result in higher energy levels, better immune system and a great physical and mental health. </span></p>\r\n<p><b>4 Benefits of Home Cooked Meals</b></p>\r\n<p><strong>1. Use of simple and Natural Ingredients</strong></p>\r\n<p><span style=\"font-weight: 400;\">As mentioned above, outside meals are prepared by using high levels of preservatives and contain high amounts of sodium that can harm the health of a person and weaken their immune system.  On the other side, homemade meals are prepared by using natural ingredients, fresh vegetables and minimum use of preservatives. Without the use of preservatives in homemade food the natural ingredients keep away the harmful effects and give a natural taste. </span></p>\r\n<p><strong>2. Food Safety</strong></p>\r\n<p><span style=\"font-weight: 400;\">In a study it is proven that people who consume outside food have more risk of food poisoning as food safety is followed at minimum level in hotels and restaurants.  It is always recommended to ensure that the food that you eat is cookeds with utmost safety as it can be one of the major reasons for illness. </span></p>\r\n<p><strong>3. Avoid food allergies and sensitivities</strong></p>\r\n<p><span style=\"font-weight: 400;\">Home Cooked food  can be especially beneficial if you or a family member has a food allergy. Because you are in control in your own kitchen, you can reduce the risk of an allergic reaction.</span></p>\r\n<p><strong>4. Brings Family together</strong></p>\r\n<p><span style=\"font-weight: 400;\">The most important and joyful part of having homemade food is it brings family together to dine and express gratitude together!</span></p>\r\n<p><span style=\"font-weight: 400;\">At Selvel, we understand the importance of home cooked food and emotions attached to it and hence our containers, tiffins and bottles are made with utmost care and safety to provide you good health. </span></p>\r\n<!-- /wp:paragraph -->', 'Top Homemade Food Health Benefits', '', 'inherit', 'closed', 'closed', '', '1-revision-v1', '', '', '2021-02-11 14:40:38', '2021-02-11 14:40:38', '', 1, 'https://selvelglobal.com/blog/1-revision-v1/', 0, 'revision', '', 0),
(66, 1, '2021-02-11 14:56:26', '2021-02-11 14:56:26', '<!-- wp:paragraph -->\r\n<p><b>Why are homemade foods better?</b></p>\r\n<p><span style=\"font-weight: 400;\">Home cooked meals are always better than meals cooked in hotels, restaurants, or some other places. The most important reason for homemade food being excellent is because of food hygiene / cleanliness that is followed at home. A study has also found that  people who eat home cooked healthy meals are at lower risk of any health issues if compared to people who often eat outside. </span></p>\r\n<p><span style=\"font-weight: 400;\">There is always less chance of using preservatives in home made food and hence it helps in making our immune system stronger. </span></p>\r\n<p><b>Why should you carry home cooked food?</b></p>\r\n<p><span style=\"font-weight: 400;\">Outside food generally contains high amounts of sodium and refined grains which can affect the physical and mental health of a person. On the other side, home cooked foods tend to be healthier and happier as the use of preservatives are low which can result in higher energy levels, better immune system and a great physical and mental health. </span></p>\r\n<p><b>4 Benefits of Home Cooked Meals</b></p>\r\n<p><strong>1. Use of simple and Natural Ingredients</strong></p>\r\n<p><span style=\"font-weight: 400;\">As mentioned above, outside meals are prepared by using high levels of preservatives and contain high amounts of sodium that can harm the health of a person and weaken their immune system.  On the other side, homemade meals are prepared by using natural ingredients, fresh vegetables and minimum use of preservatives. Without the use of preservatives in homemade food the natural ingredients keep away the harmful effects and give a natural taste. </span></p>\r\n<p><strong>2. Food Safety</strong></p>\r\n<p><span style=\"font-weight: 400;\">In a study it is proven that people who consume outside food have more risk of food poisoning as food safety is followed at minimum level in hotels and restaurants.  It is always recommended to ensure that the food that you eat is cookeds with utmost safety as it can be one of the major reasons for illness. </span></p>\r\n<p><strong>3. Avoid food allergies and sensitivities</strong></p>\r\n<p><span style=\"font-weight: 400;\">Home Cooked food  can be especially beneficial if you or a family member has a food allergy. Because you are in control in your own kitchen, you can reduce the risk of an allergic reaction.</span></p>\r\n<p><strong>4. Brings Family together</strong></p>\r\n<p><span style=\"font-weight: 400;\">The most important and joyful part of having homemade food is it brings family together to dine and express gratitude together!</span></p>\r\n<p><span style=\"font-weight: 400;\">At Selvel, we understand the importance of home cooked food and emotions attached to it and hence our containers, tiffins and bottles are made with utmost care and safety to provide you good health. </span></p>\r\n<!-- /wp:paragraph -->', 'Top Homemade Food Health Benefits', '', 'inherit', 'closed', 'closed', '', '1-revision-v1', '', '', '2021-02-11 14:56:26', '2021-02-11 14:56:26', '', 1, 'https://selvelglobal.com/blog/1-revision-v1/', 0, 'revision', '', 0);
INSERT INTO `se_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(68, 1, '2021-02-11 15:02:30', '2021-02-11 15:02:30', '', 'Rajma-Curry', '', 'inherit', 'closed', 'closed', '', 'rajma-curry', '', '', '2021-02-11 15:02:30', '2021-02-11 15:02:30', '', 27, 'https://selvelglobal.com/blog/wp-content/uploads/2021/01/Rajma-Curry.jpg', 0, 'attachment', 'image/jpeg', 0),
(69, 1, '2021-02-11 15:20:33', '2021-02-11 15:20:33', '', 'vegetable biryani', '', 'inherit', 'closed', 'closed', '', 'vegetable-biryani', '', '', '2021-02-11 15:20:33', '2021-02-11 15:20:33', '', 27, 'https://selvelglobal.com/blog/wp-content/uploads/2021/01/vegetable-biryani.jpeg', 0, 'attachment', 'image/jpeg', 0),
(70, 1, '2021-02-11 15:22:46', '2021-02-11 15:22:46', '', 'heathy', '', 'inherit', 'closed', 'closed', '', 'heathy', '', '', '2021-02-11 15:22:46', '2021-02-11 15:22:46', '', 33, 'https://selvelglobal.com/blog/wp-content/uploads/2021/02/heathy.jpg', 0, 'attachment', 'image/jpeg', 0),
(71, 1, '2021-02-11 16:05:01', '2021-02-11 16:05:01', '<!-- wp:paragraph -->\r\n<p><b>Why are homemade foods better?</b></p>\r\n<p><span style=\"font-weight: 400;\">Home cooked meals are always better than meals cooked in hotels, restaurants, or some other places. The most important reason for homemade food being excellent is because of food hygiene / cleanliness that is followed at home. A study has also found that people who eat home cooked healthy meals are at lower risk of any health issues if compared to people who often eat outside. </span></p>\r\n<p><span style=\"font-weight: 400;\">There is always less chance of using preservatives in home made food and hence it helps in making our immune system stronger. </span></p>\r\n<p><b>Why should you carry home cooked food?</b></p>\r\n<p><span style=\"font-weight: 400;\">Outside food generally contains high amounts of sodium and refined grains which can affect the physical and mental health of a person. On the other side, home cooked foods tend to be healthier and happier as the use of preservatives are low which can result in higher energy levels, better immune system and a great physical and mental health. </span></p>\r\n<p><b>4 Benefits of Home Cooked Meals</b></p>\r\n<p><strong>1. Use of simple and Natural Ingredients</strong></p>\r\n<p><span style=\"font-weight: 400;\">As mentioned above, outside meals are prepared by using high levels of preservatives and contain high amounts of sodium that can harm the health of a person and weaken their immune system.  On the other side, homemade meals are prepared by using natural ingredients, fresh vegetables and minimum use of preservatives. Without the use of preservatives in homemade food the natural ingredients keep away the harmful effects and give a natural taste. </span></p>\r\n<p><strong>2. Food Safety</strong></p>\r\n<p><span style=\"font-weight: 400;\">In a study it is proven that people who consume outside food have more risk of food poisoning as food safety is followed at minimum level in hotels and restaurants.  It is always recommended to ensure that the food that you eat is cookeds with utmost safety as it can be one of the major reasons for illness. </span></p>\r\n<p><strong>3. Avoid food allergies and sensitivities</strong></p>\r\n<p><span style=\"font-weight: 400;\">Home Cooked food  can be especially beneficial if you or a family member has a food allergy. Because you are in control in your own kitchen, you can reduce the risk of an allergic reaction.</span></p>\r\n<p><strong>4. Brings Family together</strong></p>\r\n<p><span style=\"font-weight: 400;\">The most important and joyful part of having homemade food is it brings family together to dine and express gratitude together!</span></p>\r\n<p><span style=\"font-weight: 400;\">At Selvel, we understand the importance of home cooked food and emotions attached to it and hence our containers, tiffins and bottles are made with utmost care and safety to provide you good health. </span></p>\r\n<!-- /wp:paragraph -->', 'Top Homemade Food Health Benefits', '', 'inherit', 'closed', 'closed', '', '1-revision-v1', '', '', '2021-02-11 16:05:01', '2021-02-11 16:05:01', '', 1, 'https://selvelglobal.com/blog/1-revision-v1/', 0, 'revision', '', 0),
(72, 1, '2021-02-11 16:10:23', '2021-02-11 16:10:23', '', 'diet', '', 'inherit', 'closed', 'closed', '', 'diet', '', '', '2021-02-11 16:10:23', '2021-02-11 16:10:23', '', 1, 'https://selvelglobal.com/blog/wp-content/uploads/2021/02/diet.jpg', 0, 'attachment', 'image/jpeg', 0),
(73, 1, '2021-02-11 16:17:14', '2021-02-11 16:17:14', '', 'homemadefood', '', 'inherit', 'closed', 'closed', '', 'homemadefood', '', '', '2021-02-11 16:17:14', '2021-02-11 16:17:14', '', 1, 'https://selvelglobal.com/blog/wp-content/uploads/2021/02/homemadefood.jpg', 0, 'attachment', 'image/jpeg', 0),
(74, 1, '2021-02-12 12:44:17', '2021-02-12 12:44:17', '<span style=\"font-weight: 400;\">Family is an invaluable fortune that is gifted by God to everybody. These days, having food together by all relatives is considered as a social activity. As it is realized that eating with a family prompts numerous charming results, for example, reinforces relationship bond, upgrade our virtues, safeguard social qualities, and so on.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">In any case, eating together by families can cause numerous satisfactory outcomes. To start with, hectic and busy schedule at time surpasses the family time and cannot have the option to invest sufficient energy with their relatives however group eating gives them great freedoms to associate with them and they can share about the day\'s happenings. Generally, individuals call the eating time family time since all individuals are available and they can make the most of it. Accordingly, family time fortifies the relationship bond, individuals come closer to one another, guardians use it to advise their kids about their way of life which eventually protects their way of life.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">The advantages of family time have been broadly discussed. We realize that kids who have dinners with their family, will, in general, improve in school getting higher grades, they will, in general, be all the more sincerely acclimated to having less burden.</span>\r\n\r\n<span style=\"font-weight: 400;\">We know there are some great associations with eating food with family on the grounds that so much can be learned at the dining table. Your child learns good habits and gratitude when you train your kid to utilize words like \'please\' or \'thank you\'. Likewise, they figure out how to be liberal as you request them to give an enormous piece of cake to the visitor.</span>\r\n\r\n<span style=\"font-weight: 400;\">Children additionally gain proficiency with a ton of words at family time, in excess of 10 times more words they gain from being perused to, around night time. So kids get familiar with a ton of social and emotional learnings by getting the hang including phonetics.</span>\r\n\r\n<span style=\"font-weight: 400;\">Eating food all together gives the chance to discuss. This allows guardians to show solid correspondence without interruptions from cell phones, TV, PCs, and cell phones. Sitting together and eating food permits each member to examine their day and offer any energizing news. This encourages your youngster to participate. Try not to discourage your kid\'s capacity to hold a discussion.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">Regardless of how busy you are, never avoid an opportunity to eat with your family. A family dinner time resembles a casual social affair where you work your heart out and bond for life. Put forth efforts to have at any rate 2-3 meals consistently with family. Probably the best delight is imparting acceptable food to the ones you love. Life is too short to even consider passing up this straightforward bliss and all the beneficial things it can bring to your connections. A family that eats together stays together!</span>', 'Importance of having food together with family', '', 'publish', 'closed', 'closed', '', 'importance-of-having-food-together-with-family', '', '', '2021-02-12 12:52:01', '2021-02-12 12:52:01', '', 0, 'https://selvelglobal.com/blog/?p=74', 0, 'post', '', 0),
(75, 1, '2021-02-12 12:44:17', '2021-02-12 12:44:17', '<span style=\"font-weight: 400;\">Family is an invaluable fortune that is gifted by God to everybody. These days, having food together by all relatives is considered as a social activity. As it is realized that eating with a family prompts numerous charming results, for example, reinforces relationship bond, upgrade our virtues, safeguard social qualities, and so on.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">In any case, eating together by families can cause numerous satisfactory outcomes. To start with, hectic and busy schedule at time surpasses the family time and cannot have the option to invest sufficient energy with their relatives however group eating gives them great freedoms to associate with them and they can share about the day\'s happenings. Generally, individuals call the eating time family time since all individuals are available and they can make the most of it. Accordingly, family time fortifies the relationship bond, individuals come closer to one another, guardians use it to advise their kids about their way of life which eventually protects their way of life.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">The advantages of family time have been broadly discussed. We realize that kids who have dinners with their family, will, in general, improve in school getting higher grades, they will, in general, be all the more sincerely acclimated to having less burden.</span>\r\n\r\n&nbsp;\r\n\r\n<span style=\"font-weight: 400;\">We know there are some great associations with eating food with family on the grounds that so much can be learned at the dining table. Your child learns good habits and gratitude when you train your kid to utilize words like \'please\' or \'thank you\'. Likewise, they figure out how to be liberal as you request them to give an enormous piece of cake to the visitor.</span>\r\n\r\n<span style=\"font-weight: 400;\">Children additionally gain proficiency with a ton of words at family time, in excess of 10 times more words they gain from being perused to, around night time. So kids get familiar with a ton of social and emotional learnings by getting the hang including phonetics.</span>\r\n\r\n<span style=\"font-weight: 400;\">Eating food all together gives the chance to discuss. This allows guardians to show solid correspondence without interruptions from cell phones, TV, PCs, and cell phones. Sitting together and eating food permits each member to examine their day and offer any energizing news. This encourages your youngster to participate. Try not to discourage your kid\'s capacity to hold a discussion.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">Regardless of how busy you are, never avoid an opportunity to eat with your family. A family dinner time resembles a casual social affair where you work your heart out and bond for life. Put forth efforts to have at any rate 2-3 meals consistently with family. Probably the best delight is imparting acceptable food to the ones you love. Life is too short to even consider passing up this straightforward bliss and all the beneficial things it can bring to your connections. A family that eats together stays together!</span>', 'Importance of having food together with family', '', 'inherit', 'closed', 'closed', '', '74-revision-v1', '', '', '2021-02-12 12:44:17', '2021-02-12 12:44:17', '', 74, 'https://selvelglobal.com/blog/74-revision-v1/', 0, 'revision', '', 0),
(76, 1, '2021-02-12 12:51:57', '2021-02-12 12:51:57', '', 'family', '', 'inherit', 'closed', 'closed', '', 'family', '', '', '2021-02-12 12:51:57', '2021-02-12 12:51:57', '', 74, 'https://selvelglobal.com/blog/wp-content/uploads/2021/02/family.jpg', 0, 'attachment', 'image/jpeg', 0),
(77, 1, '2021-02-12 12:52:01', '2021-02-12 12:52:01', '<span style=\"font-weight: 400;\">Family is an invaluable fortune that is gifted by God to everybody. These days, having food together by all relatives is considered as a social activity. As it is realized that eating with a family prompts numerous charming results, for example, reinforces relationship bond, upgrade our virtues, safeguard social qualities, and so on.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">In any case, eating together by families can cause numerous satisfactory outcomes. To start with, hectic and busy schedule at time surpasses the family time and cannot have the option to invest sufficient energy with their relatives however group eating gives them great freedoms to associate with them and they can share about the day\'s happenings. Generally, individuals call the eating time family time since all individuals are available and they can make the most of it. Accordingly, family time fortifies the relationship bond, individuals come closer to one another, guardians use it to advise their kids about their way of life which eventually protects their way of life.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">The advantages of family time have been broadly discussed. We realize that kids who have dinners with their family, will, in general, improve in school getting higher grades, they will, in general, be all the more sincerely acclimated to having less burden.</span>\r\n\r\n<span style=\"font-weight: 400;\">We know there are some great associations with eating food with family on the grounds that so much can be learned at the dining table. Your child learns good habits and gratitude when you train your kid to utilize words like \'please\' or \'thank you\'. Likewise, they figure out how to be liberal as you request them to give an enormous piece of cake to the visitor.</span>\r\n\r\n<span style=\"font-weight: 400;\">Children additionally gain proficiency with a ton of words at family time, in excess of 10 times more words they gain from being perused to, around night time. So kids get familiar with a ton of social and emotional learnings by getting the hang including phonetics.</span>\r\n\r\n<span style=\"font-weight: 400;\">Eating food all together gives the chance to discuss. This allows guardians to show solid correspondence without interruptions from cell phones, TV, PCs, and cell phones. Sitting together and eating food permits each member to examine their day and offer any energizing news. This encourages your youngster to participate. Try not to discourage your kid\'s capacity to hold a discussion.</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">\r\n</span><span style=\"font-weight: 400;\">Regardless of how busy you are, never avoid an opportunity to eat with your family. A family dinner time resembles a casual social affair where you work your heart out and bond for life. Put forth efforts to have at any rate 2-3 meals consistently with family. Probably the best delight is imparting acceptable food to the ones you love. Life is too short to even consider passing up this straightforward bliss and all the beneficial things it can bring to your connections. A family that eats together stays together!</span>', 'Importance of having food together with family', '', 'inherit', 'closed', 'closed', '', '74-revision-v1', '', '', '2021-02-12 12:52:01', '2021-02-12 12:52:01', '', 74, 'https://selvelglobal.com/blog/74-revision-v1/', 0, 'revision', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `se_responsive_menu`
--

CREATE TABLE `se_responsive_menu` (
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_responsive_menu`
--

INSERT INTO `se_responsive_menu` (`name`, `value`) VALUES
('accordion_animation', 'off'),
('active_arrow_font_icon', ''),
('active_arrow_font_icon_type', 'font-awesome'),
('active_arrow_image', ''),
('active_arrow_image_alt', ''),
('active_arrow_shape', '▲'),
('admin_theme', 'dark'),
('animation_speed', '0.5'),
('animation_type', 'slide'),
('arrow_position', 'right'),
('auto_expand_all_submenus', 'off'),
('auto_expand_current_submenus', 'off'),
('breakpoint', '768'),
('button_background_colour', '#341a73'),
('button_background_colour_active', '#212121'),
('button_background_colour_hover', '#341a73'),
('button_click_animation', 'boring'),
('button_click_trigger', '#responsive-menu-button'),
('button_distance_from_side', '5'),
('button_distance_from_side_unit', '%'),
('button_font', ''),
('button_font_icon', ''),
('button_font_icon_type', 'font-awesome'),
('button_font_icon_when_clicked', ''),
('button_font_icon_when_clicked_type', 'font-awesome'),
('button_font_size', '14'),
('button_font_size_unit', 'px'),
('button_height', '55'),
('button_height_unit', 'px'),
('button_image', ''),
('button_image_alt', ''),
('button_image_alt_when_clicked', ''),
('button_image_when_clicked', ''),
('button_left_or_right', 'right'),
('button_line_colour', '#ffffff'),
('button_line_colour_active', '#ffffff'),
('button_line_colour_hover', '#ffffff'),
('button_line_height', '3'),
('button_line_height_unit', 'px'),
('button_line_margin', '5'),
('button_line_margin_unit', 'px'),
('button_line_width', '25'),
('button_line_width_unit', 'px'),
('button_position_type', 'fixed'),
('button_push_with_animation', 'off'),
('button_text_colour', '#ffffff'),
('button_title', ''),
('button_title_line_height', '13'),
('button_title_line_height_unit', 'px'),
('button_title_open', ''),
('button_title_position', 'left'),
('button_top', '15'),
('button_top_unit', 'px'),
('button_transparent_background', 'off'),
('button_trigger_type', 'click'),
('button_width', '55'),
('button_width_unit', 'px'),
('custom_css', ''),
('custom_walker', ''),
('desktop_menu_hide_and_show', ''),
('desktop_menu_options', '{\"17\":{\"type\":\"standard\",\"width\":\"auto\",\"parent_background_colour\":\"\",\"parent_background_image\":\"\"},\"18\":{\"type\":\"standard\",\"width\":\"auto\",\"parent_background_colour\":\"\",\"parent_background_image\":\"\"},\"19\":{\"type\":\"standard\",\"width\":\"auto\",\"parent_background_colour\":\"\",\"parent_background_image\":\"\"},\"16\":{\"type\":\"standard\",\"width\":\"auto\",\"parent_background_colour\":\"\",\"parent_background_image\":\"\"}}'),
('desktop_menu_positioning', 'fixed'),
('desktop_menu_side', ''),
('desktop_menu_to_hide', ''),
('desktop_menu_width', ''),
('desktop_menu_width_unit', '%'),
('desktop_submenu_open_animation', 'fade'),
('desktop_submenu_open_animation_speed', '100ms'),
('desktop_submenu_open_on_click', ''),
('enable_touch_gestures', ''),
('excluded_pages', NULL),
('external_files', 'off'),
('fade_submenus', 'off'),
('fade_submenus_delay', '100'),
('fade_submenus_side', 'left'),
('fade_submenus_speed', '500'),
('header_bar_adjust_page', NULL),
('header_bar_background_color', '#ffffff'),
('header_bar_breakpoint', '800'),
('header_bar_font', ''),
('header_bar_font_size', '14'),
('header_bar_font_size_unit', 'px'),
('header_bar_height', '80'),
('header_bar_height_unit', 'px'),
('header_bar_html_content', ''),
('header_bar_items_order', '{\"logo\":\"on\",\"title\":\"on\",\"search\":\"on\",\"html content\":\"on\"}'),
('header_bar_logo', ''),
('header_bar_logo_alt', ''),
('header_bar_logo_height', ''),
('header_bar_logo_height_unit', 'px'),
('header_bar_logo_link', ''),
('header_bar_logo_width', ''),
('header_bar_logo_width_unit', '%'),
('header_bar_position_type', 'fixed'),
('header_bar_text_color', '#ffffff'),
('header_bar_title', ''),
('hide_on_desktop', 'off'),
('hide_on_mobile', 'off'),
('inactive_arrow_font_icon', ''),
('inactive_arrow_font_icon_type', 'font-awesome'),
('inactive_arrow_image', ''),
('inactive_arrow_image_alt', ''),
('inactive_arrow_shape', '▼'),
('items_order', '{\"title\":\"\",\"menu\":\"on\",\"search\":\"\",\"additional content\":\"\"}'),
('keyboard_shortcut_close_menu', '27,37'),
('keyboard_shortcut_open_menu', '32,39'),
('menu_additional_content', ''),
('menu_additional_content_colour', '#ffffff'),
('menu_adjust_for_wp_admin_bar', 'off'),
('menu_appear_from', 'right'),
('menu_auto_height', 'off'),
('menu_background_colour', '#212121'),
('menu_background_image', ''),
('menu_border_width', '1'),
('menu_border_width_unit', 'px'),
('menu_close_on_body_click', 'off'),
('menu_close_on_link_click', 'off'),
('menu_close_on_scroll', 'off'),
('menu_container_background_colour', '#212121'),
('menu_current_item_background_colour', '#212121'),
('menu_current_item_background_hover_colour', '#3f3f3f'),
('menu_current_item_border_colour', '#212121'),
('menu_current_item_border_hover_colour', '#3f3f3f'),
('menu_current_link_colour', '#ffffff'),
('menu_current_link_hover_colour', '#ffffff'),
('menu_depth', '5'),
('menu_depth_0', '5'),
('menu_depth_0_unit', '%'),
('menu_depth_1', '10'),
('menu_depth_1_unit', '%'),
('menu_depth_2', '15'),
('menu_depth_2_unit', '%'),
('menu_depth_3', '20'),
('menu_depth_3_unit', '%'),
('menu_depth_4', '25'),
('menu_depth_4_unit', '%'),
('menu_depth_5', '30'),
('menu_depth_5_unit', '%'),
('menu_depth_side', 'left'),
('menu_disable_scrolling', 'off'),
('menu_font', ''),
('menu_font_icons', '{\"id\":[\"\"],\"icon\":[\"\"],\"type\":[\"\"]}'),
('menu_font_size', '13'),
('menu_font_size_unit', 'px'),
('menu_item_background_colour', '#212121'),
('menu_item_background_hover_colour', '#3f3f3f'),
('menu_item_border_colour', '#212121'),
('menu_item_border_colour_hover', '#212121'),
('menu_item_click_to_trigger_submenu', 'off'),
('menu_link_colour', '#ffffff'),
('menu_link_hover_colour', '#ffffff'),
('menu_links_height', '40'),
('menu_links_height_unit', 'px'),
('menu_links_line_height', '40'),
('menu_links_line_height_unit', 'px'),
('menu_maximum_width', ''),
('menu_maximum_width_unit', 'px'),
('menu_minimum_width', ''),
('menu_minimum_width_unit', 'px'),
('menu_overlay', 'off'),
('menu_overlay_colour', 'rgba(0, 0, 0, 0.7)'),
('menu_search_box_background_colour', '#ffffff'),
('menu_search_box_border_colour', '#dadada'),
('menu_search_box_placeholder_colour', '#c7c7cd'),
('menu_search_box_text', 'Search'),
('menu_search_box_text_colour', '#333333'),
('menu_sub_arrow_background_colour', '#212121'),
('menu_sub_arrow_background_colour_active', '#212121'),
('menu_sub_arrow_background_hover_colour', '#3f3f3f'),
('menu_sub_arrow_background_hover_colour_active', '#3f3f3f'),
('menu_sub_arrow_border_colour', '#212121'),
('menu_sub_arrow_border_colour_active', '#212121'),
('menu_sub_arrow_border_hover_colour', '#3f3f3f'),
('menu_sub_arrow_border_hover_colour_active', '#3f3f3f'),
('menu_sub_arrow_shape_colour', '#ffffff'),
('menu_sub_arrow_shape_colour_active', '#ffffff'),
('menu_sub_arrow_shape_hover_colour', '#ffffff'),
('menu_sub_arrow_shape_hover_colour_active', '#ffffff'),
('menu_text_alignment', 'left'),
('menu_theme', NULL),
('menu_title', ''),
('menu_title_alignment', 'left'),
('menu_title_background_colour', '#212121'),
('menu_title_background_hover_colour', '#212121'),
('menu_title_colour', '#ffffff'),
('menu_title_font_icon', ''),
('menu_title_font_icon_type', 'font-awesome'),
('menu_title_font_size', '13'),
('menu_title_font_size_unit', 'px'),
('menu_title_hover_colour', '#ffffff'),
('menu_title_image', ''),
('menu_title_image_alt', ''),
('menu_title_image_height', ''),
('menu_title_image_height_unit', 'px'),
('menu_title_image_width', ''),
('menu_title_image_width_unit', '%'),
('menu_title_link', ''),
('menu_title_link_location', '_self'),
('menu_to_hide', ''),
('menu_to_use', 'menu'),
('menu_width', '75'),
('menu_width_unit', '%'),
('menu_word_wrap', 'off'),
('minify_scripts', 'off'),
('mobile_only', 'off'),
('page_wrapper', ''),
('remove_bootstrap', ''),
('remove_fontawesome', ''),
('scripts_in_footer', 'off'),
('shortcode', 'off'),
('show_menu_on_page_load', ''),
('single_menu_font', ''),
('single_menu_font_size', '14'),
('single_menu_font_size_unit', 'px'),
('single_menu_height', '80'),
('single_menu_height_unit', 'px'),
('single_menu_item_background_colour', '#ffffff'),
('single_menu_item_background_colour_hover', '#ffffff'),
('single_menu_item_link_colour', '#000000'),
('single_menu_item_link_colour_hover', '#000000'),
('single_menu_item_submenu_background_colour', '#ffffff'),
('single_menu_item_submenu_background_colour_hover', '#ffffff'),
('single_menu_item_submenu_link_colour', '#000000'),
('single_menu_item_submenu_link_colour_hover', '#000000'),
('single_menu_line_height', '80'),
('single_menu_line_height_unit', 'px'),
('single_menu_submenu_font', ''),
('single_menu_submenu_font_size', '12'),
('single_menu_submenu_font_size_unit', 'px'),
('single_menu_submenu_height', ''),
('single_menu_submenu_height_unit', 'auto'),
('single_menu_submenu_line_height', '40'),
('single_menu_submenu_line_height_unit', 'px'),
('slide_effect_back_to_text', 'Back'),
('smooth_scroll_on', 'off'),
('smooth_scroll_speed', '500'),
('sub_menu_speed', '0.2'),
('submenu_arrow_height', '39'),
('submenu_arrow_height_unit', 'px'),
('submenu_arrow_position', 'right'),
('submenu_arrow_width', '40'),
('submenu_arrow_width_unit', 'px'),
('submenu_border_width', '1'),
('submenu_border_width_unit', 'px'),
('submenu_current_item_background_colour', '#212121'),
('submenu_current_item_background_hover_colour', '#3f3f3f'),
('submenu_current_item_border_colour', '#212121'),
('submenu_current_item_border_hover_colour', '#3f3f3f'),
('submenu_current_link_colour', '#ffffff'),
('submenu_current_link_hover_colour', '#ffffff'),
('submenu_descriptions_on', ''),
('submenu_font', ''),
('submenu_font_size', '13'),
('submenu_font_size_unit', 'px'),
('submenu_item_background_colour', '#212121'),
('submenu_item_background_hover_colour', '#3f3f3f'),
('submenu_item_border_colour', '#212121'),
('submenu_item_border_colour_hover', '#212121'),
('submenu_link_colour', '#ffffff'),
('submenu_link_hover_colour', '#ffffff'),
('submenu_links_height', '40'),
('submenu_links_height_unit', 'px'),
('submenu_links_line_height', '40'),
('submenu_links_line_height_unit', 'px'),
('submenu_sub_arrow_background_colour', '#212121'),
('submenu_sub_arrow_background_colour_active', '#212121'),
('submenu_sub_arrow_background_hover_colour', '#3f3f3f'),
('submenu_sub_arrow_background_hover_colour_active', '#3f3f3f'),
('submenu_sub_arrow_border_colour', '#212121'),
('submenu_sub_arrow_border_colour_active', '#212121'),
('submenu_sub_arrow_border_hover_colour', '#3f3f3f'),
('submenu_sub_arrow_border_hover_colour_active', '#3f3f3f'),
('submenu_sub_arrow_shape_colour', '#ffffff'),
('submenu_sub_arrow_shape_colour_active', '#ffffff'),
('submenu_sub_arrow_shape_hover_colour', '#ffffff'),
('submenu_sub_arrow_shape_hover_colour_active', '#ffffff'),
('submenu_submenu_arrow_height', '39'),
('submenu_submenu_arrow_height_unit', 'px'),
('submenu_submenu_arrow_width', '40'),
('submenu_submenu_arrow_width_unit', 'px'),
('submenu_text_alignment', 'left'),
('theme_location_menu', ''),
('transition_speed', '0.5'),
('use_desktop_menu', ''),
('use_header_bar', 'off'),
('use_slide_effect', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `se_termmeta`
--

CREATE TABLE `se_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `se_terms`
--

CREATE TABLE `se_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_terms`
--

INSERT INTO `se_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'selvelglobal', 'selvelglobal', 0),
(2, 'Menu 1', 'menu-1', 0),
(3, 'Menu', 'menu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `se_term_relationships`
--

CREATE TABLE `se_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_term_relationships`
--

INSERT INTO `se_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(12, 2, 0),
(13, 2, 0),
(14, 2, 0),
(15, 2, 0),
(17, 3, 0),
(18, 3, 0),
(19, 3, 0),
(27, 1, 0),
(28, 1, 0),
(33, 1, 0),
(46, 3, 0),
(74, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `se_term_taxonomy`
--

CREATE TABLE `se_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_term_taxonomy`
--

INSERT INTO `se_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 5),
(2, 2, 'nav_menu', '', 0, 4),
(3, 3, 'nav_menu', '', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `se_usermeta`
--

CREATE TABLE `se_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_usermeta`
--

INSERT INTO `se_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'selvel'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'false'),
(11, 1, 'locale', ''),
(12, 1, 'se_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'se_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', 'wp496_privacy'),
(15, 1, 'show_welcome_panel', '0'),
(17, 1, 'se_dashboard_quick_press_last_post_id', '79'),
(18, 1, 'se_user-settings', 'libraryContent=browse&editor=tinymce'),
(19, 1, 'se_user-settings-time', '1596097209'),
(20, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}'),
(21, 1, 'metaboxhidden_nav-menus', 'a:2:{i:0;s:12:\"add-post_tag\";i:1;s:15:\"add-post_format\";}'),
(22, 1, 'nav_menu_recently_edited', '3'),
(23, 1, 'closedpostboxes_post', 'a:0:{}'),
(24, 1, 'metaboxhidden_post', 'a:6:{i:0;s:11:\"postexcerpt\";i:1;s:13:\"trackbacksdiv\";i:2;s:10:\"postcustom\";i:3;s:16:\"commentstatusdiv\";i:4;s:7:\"slugdiv\";i:5;s:9:\"authordiv\";}'),
(25, 1, 'community-events-location', 'a:1:{s:2:\"ip\";s:11:\"1.186.126.0\";}'),
(28, 1, 'closedpostboxes_dashboard', 'a:1:{i:0;s:17:\"dashboard_php_nag\";}'),
(29, 1, 'metaboxhidden_dashboard', 'a:0:{}'),
(30, 1, 'session_tokens', 'a:1:{s:64:\"2f56aefdbde58b0b431d519736254ecfba90e545d81c250d8a899263dcfc3205\";a:4:{s:10:\"expiration\";i:1622606633;s:2:\"ip\";s:12:\"1.186.126.14\";s:2:\"ua\";s:114:\"Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36\";s:5:\"login\";i:1622433833;}}');

-- --------------------------------------------------------

--
-- Table structure for table `se_users`
--

CREATE TABLE `se_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `se_users`
--

INSERT INTO `se_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'selvel', '$P$BZRqIh2eEZbGu5LYrmISX5v8TFcAQA0', 'selvel', 'digambar@innovins.com', '', '2020-06-29 10:22:14', '', 0, 'selvel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `se_commentmeta`
--
ALTER TABLE `se_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `se_comments`
--
ALTER TABLE `se_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `se_links`
--
ALTER TABLE `se_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `se_options`
--
ALTER TABLE `se_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`);

--
-- Indexes for table `se_postmeta`
--
ALTER TABLE `se_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `se_posts`
--
ALTER TABLE `se_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `se_responsive_menu`
--
ALTER TABLE `se_responsive_menu`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `se_termmeta`
--
ALTER TABLE `se_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `se_terms`
--
ALTER TABLE `se_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `se_term_relationships`
--
ALTER TABLE `se_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `se_term_taxonomy`
--
ALTER TABLE `se_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `se_usermeta`
--
ALTER TABLE `se_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `se_users`
--
ALTER TABLE `se_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `se_commentmeta`
--
ALTER TABLE `se_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `se_comments`
--
ALTER TABLE `se_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `se_links`
--
ALTER TABLE `se_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `se_options`
--
ALTER TABLE `se_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4651;

--
-- AUTO_INCREMENT for table `se_postmeta`
--
ALTER TABLE `se_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `se_posts`
--
ALTER TABLE `se_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `se_termmeta`
--
ALTER TABLE `se_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `se_terms`
--
ALTER TABLE `se_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `se_term_taxonomy`
--
ALTER TABLE `se_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `se_usermeta`
--
ALTER TABLE `se_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `se_users`
--
ALTER TABLE `se_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
