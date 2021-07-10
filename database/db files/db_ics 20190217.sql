-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2019 at 01:08 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ics_test`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetChatAbsoluteCount` (IN `p_class_id` INT)  NO SQL
BEGIN
	Select count(*) as absoluteCount from chat c where class_id = p_class_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetChats` (IN `p_class_id` INT, IN `p_chat_from` INT, IN `p_chat_to` INT)  NO SQL
BEGIN

    CREATE TEMPORARY TABLE tempChats (
        row_num int,
        chat_id int,
        class_id int,
        account_id int,
		message text,
        send_at datetime
    );

    SET @row_number = 0;
	
    insert into tempChats
	Select (@row_number:=@row_number + 1) AS row_num, c.* from chat c where class_id = p_class_id order by send_at desc;
    
    if p_chat_from = 0 and p_chat_to = 0 then
    	
    		select * from tempChats;
        
	else
    	
        	select * from tempChats where row_num >= p_chat_from and row_num <= p_chat_to;
        
    	 
    end if;
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetLastestMessages` (IN `param_class_id` INT, IN `param_chat_id` INT)  NO SQL
begin
	select * from chat where class_id = param_class_id and chat_id > param_chat_id; 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPosts` (IN `p_class_id` INT, IN `p_post_from` INT, IN `p_post_to` INT)  READS SQL DATA
BEGIN

    CREATE TEMPORARY TABLE tempPosts (
        row_num int,
        post_id int,
        class_id int,
        account_id int,
        description text,
        post_at datetime,
        updated_at datetime,
        post_status_at int
    );

    SET @row_number = 0;
	
    insert into tempPosts
	Select (@row_number:=@row_number + 1) AS row_num, p.* from posts p where class_id = p_class_id order by post_at desc;
    
    if p_post_from = 0 and p_post_to = 0 then
    	
    		select * from tempPosts;
        
	else
    	
        	select * from tempPosts where row_num >= p_post_from and row_num <= p_post_to;
        
    	 
    end if;
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPostsAbsoluteCount` (IN `p_class_id` INT)  NO SQL
begin 

	select count(*) as absoluteCount from posts where class_id = p_class_id;
    
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegisterLastViewedChat` (IN `param_class_id` INT, IN `param_account_id` INT)  NO SQL
begin

	/****** Identify if account exist in last_viewed_chat table  ******/
	declare has_last_view int;
    declare last_view int;
    declare current_view int;
    create TEMPORARY table temp_last_view(
        lvc_id int, 
        account_id int, 
        class_id int, 
        last_chat_id int, 
        current_chat_id int
    );
    
    insert into temp_last_view
    select 
    	LVC_ID,
        account_id,
        class_id,
        last_chat_id,
        current_chat_id
    from last_viewed_chats where class_id = param_class_id and account_id = param_account_id;
    
    
    set has_last_view = (select count(*) from temp_last_view);
    
    if has_last_view > 0 THEN
        begin
        
			set last_view = (select current_chat_id from temp_last_view);
            set current_view = (select chat_id from chat where class_id = param_class_id order by send_at desc limit 1);
            
            update last_viewed_chats set last_chat_id = last_view, current_chat_id = current_view where class_id = param_class_id and account_id = param_account_id;
        end;
    else
    	begin
        	set last_view = 0;
            
            set current_view = (select chat_id from chat where class_id = param_class_id order by send_at desc limit 1);
            
            if current_view is null then 
            	set current_view = 0;
            end if;
            
            insert into last_viewed_chats(account_id, class_id, last_chat_id, current_chat_id)
            values (param_account_id, param_class_id, last_view, current_view);
        end;
    end if;
    
    select
        case  
            when last_chat_id = 0 then 0 
            when last_chat_id > 0 then (current_chat_id - last_chat_id)
        end as num_of_new_messages,
        last_chat_id as last_viewed_chat_id
    from last_viewed_chats 
    where class_id = param_class_id and account_id = param_account_id;
      
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SystemResetData` ()  NO SQL
begin

-- Clear data on tables
truncate table accounts;
truncate table admin;
truncate table announcements;
truncate table chat;
truncate table classes;
truncate table class_lists;
truncate table comments;
truncate table courses;
truncate table curriculum;
truncate table curriculum_subjects;
truncate table curriculum_year_sem;
truncate table events;
truncate table homeworks;
truncate table homework_uploaded_files;
truncate table ics_details;
truncate table last_viewed_chats;
truncate table loads;
truncate table messages;
truncate table posts;
truncate table post_files;
truncate table school_years;
truncate table semesters;
truncate table sent_items;
truncate table students;
truncate table subjects;
truncate table submitted_homeworks;
truncate table submitted_homework_files;
truncate table teachers;

-- create default admin account
insert into admin(
	last_name
	, first_name
	, middle_name
	, image
	, created_at
	, updated_at
    , is_active
)
values(
	'Tali'
	, 'Vanessa'
	, 'Gabica'
	, ''
	, now()
	, null
    , 1
);

insert into accounts(
	user_id
	, type
	, username
	, password
	, email_address
	, hash_password
	, created_at
	, updated_at
	, is_approved
) values (
	1
	, 'admin'
	, 'wmsu_ics'
	, 'Starta123'
    , 'wmsuics@wmsu.edu.ph'
	, '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec'
	, now()
	, null
	, 1
);

-- Insert default school year
insert into school_years (
	sy_from
	, sy_to 
	, is_current_sy
) values (
	(year(now()) - 1)
	, year(now())
	, 1
);

-- Insert default semester
insert into semesters (
    semester
    , is_current_semester
) values (
	'1st'
	, 1
);

-- Provide default ICS Details
insert into ics_details (
	organization_name
	, mission
	, vision
	, goals
	, objectives
	, history
	, ics_logo
	, wmsu_logo
	, address
	, tel_number
	, email_address
	, mission_updated_at
	, vision_updated_at
	, goals_updated_at
	, objectives_updated_at
	, history_updated_at
	, ics_logo_updated_at
	, wmsu_logo_updated_at
	, address_updated_at
	, tel_number_updated_at
	, email_address_updated_at
	, organization_name_updated_at
) values (
	"WMSU ICS"
	, "Mission"
	, "Vision"
	, "Goals"
	, "Objectives"
	, "History"
	, ""
	, ""
	, "Normal Road, Baliwasan, R.T. Lim Boulevard, Zamboanga City"
	, "123456"
	, "wmsuics@wmsu.edu.ph"
	, now()
	, now()
	, now()
	, now()
	, now()
	, now()
	, now()
	, now()
	, now()
	, now()
	, now()
);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateLastViewChat` (IN `param_class_id` INT, IN `param_account_id` INT)  NO SQL
BEGIN

	declare var_latest_chat_id int;
    declare has_last_view int;
    
    set has_last_view = (select count(*) from last_viewed_chats where class_id = param_class_id and account_id = param_account_id);
    
    set var_latest_chat_id  = (select chat_id from chat where class_id = param_class_id order by send_at desc limit 1);
    
    if has_last_view > 0 then
    	begin
        	update last_viewed_chats set last_chat_id = var_latest_chat_id, current_chat_id = var_latest_chat_id where class_id = param_class_id and account_id = param_account_id;
        end;
    else
    	begin
			insert into last_viewed_chats(class_id, account_id, last_chat_id, current_chat_id)
            values(param_class_id, param_account_id, var_latest_chat_id, var_latest_chat_id);
        end;
    end if;
    
	select last_chat_id, current_chat_id from last_viewed_chats where class_id = param_class_id and account_id = param_account_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `hash_password` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_approved` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `user_id`, `type`, `username`, `password`, `email_address`, `hash_password`, `created_at`, `updated_at`, `is_approved`) VALUES
(1, 1, 'admin', 'admin', 'Starta123', 'vanessatali@gmail.com', '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec', '2017-02-03 06:48:54', '2019-01-21 16:27:50', 1),
(2, 1, 'student', 'student', 'student', 'sansathequeen@gmail.com', '204036a1ef6e7360e536300ea78c6aeb4a9333dd', '2017-02-04 15:36:46', '2017-04-03 06:35:16', 1),
(6, 4, 'teacher', 'teacher', 'teacher', 'queenme@gmail.com', '4a82cb6db537ef6c5b53d144854e146de79502e8', '2017-02-20 18:14:12', '2017-04-03 06:45:00', 1),
(7, 5, 'teacher', 'sam', 'Starta123', 'evilking@gmail.com', '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec', '2017-02-20 18:40:11', '2019-01-23 17:22:57', 1),
(8, 6, 'teacher', 'thomas', '12', 'thomas@gmail.com', '7b52009b64fd0a2a49e6d8a939753077792b0554', '2017-02-21 05:51:44', '2017-02-21 08:12:55', 1),
(9, 10, 'student', 'ed', 'ed', NULL, 'd3c79247ce5d2ec54b04309cadf356cf9b9f5e77', '2017-02-22 04:14:10', NULL, 1),
(10, 7, 'student', 'louise', '123', 'enebeyen@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-02-22 04:15:33', '2017-04-03 06:09:23', 1),
(11, 11, 'student', 'cersie', '123', 'queenofkingslanding@gmail.com', 'd3c79247ce5d2ec54b04309cadf356cf9b9f5e77', '2017-02-26 10:34:39', '2017-04-03 06:40:43', 1),
(12, 8, 'teacher', 'tyron', '123', 'thegreatimp@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2017-03-05 13:02:14', '2017-11-19 10:30:49', 1),
(13, 12, 'student', 'roi', 'roi', 'amatongroi@gmail.com', '70fe19c13a4007bd60b3b30ca92b8c191f0ba12e', '2017-03-25 05:35:39', NULL, 1),
(14, 13, 'student', 'van', 'van', 'vanessatali@gmail.com', 'efa44987b6e36a90882a7df93eedc89343acdcb6', '2017-03-25 06:16:50', NULL, 1),
(15, 14, 'student', 'lyanna', '123', 'lyanna@gmail.com', 'd36f34bddffa7523b4f5dcd9cdda6d12f0072571', '2017-03-27 03:40:40', '2017-04-03 06:10:36', 1),
(21, 9, 'teacher', 'ed', 'ed', 'nedstark@gmail.com', 'a162caffcb6897220f4d1cf28164d73cb91993a8', '2017-04-16 14:19:37', '2017-04-16 14:20:38', 1),
(22, 20, 'student', 'vince', 'vincent123', 'vincent@gmail.com', '43410c0701c765a1feeedb949d8bf688fc37fed5', '2017-04-16 15:23:38', '2018-12-31 09:27:29', 1),
(24, 22, 'student', 'myra', 'roi', 'myra@gmail.com', '70fe19c13a4007bd60b3b30ca92b8c191f0ba12e', '2017-04-16 16:04:13', '2018-12-31 08:25:45', 1),
(25, 23, 'student', 'grace', 'grace123', 'grace@gmail.com', 'd4011813dc4ebaaf9e86b389ba4efad263cd2a5b', '2017-04-16 16:15:16', '2017-04-16 16:17:46', 1),
(26, 24, 'student', 'markandres', 'dale123', 'Dale@gmail.com', 'b952ce51c9a2c5eb06660a4c083b191259cfba80', '2017-04-16 16:23:35', '2019-01-13 05:39:34', 1),
(27, 25, 'student', 'alyssa', 'alyssa123', 'alyssa@gmail.com', '3263697c871f378a582f980124459c75b9538cee', '2017-04-16 16:27:09', '2017-04-16 16:28:05', 1),
(28, 26, 'student', 'jane', 'elora', 'janelocson@gmail.com', 'd289adb4221e208aa879cc1c111114dec3d194d4', '2017-04-16 16:43:08', '2017-04-16 16:45:53', 1),
(29, 10, 'teacher', 'roilarrence.amatong', 'Starta123', 'amatongroi@gmail.com', '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec', '2018-12-31 21:42:37', '2018-12-31 22:22:34', 1),
(30, 11, 'teacher', 'james.harden', 'Starta123', 'james.harden@gmail.com', '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec', '2018-12-31 23:38:54', NULL, 1),
(31, 27, 'student', 'kira.yamato', 'Starta123', 'yamato.kira@gmail.com', '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec', '2019-01-01 00:10:08', NULL, 1),
(32, 28, 'student', 'jancarlo.duterte', 'Starta123', 'jcduterte@gmail.com', '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec', '2019-01-09 13:00:37', '2019-01-23 16:54:37', 1),
(33, 12, 'teacher', 'jc.duterte', '12345', 'jancarloduterte@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '2019-01-09 13:06:38', NULL, 1),
(34, 29, 'student', 'cp3', 'Starta123', 'chrispaul@gmail.com', '2b0cd5f075d9b03dfbd66f59e2d43c6e91ce65ec', '2019-01-10 17:39:30', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `last_name`, `first_name`, `middle_name`, `image`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Vanessa', 'Tali', 'Gabica', '', '2019-02-17 23:37:48', '2019-02-17 15:37:48', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `post_status` int(11) NOT NULL DEFAULT '0',
  `post_date` datetime DEFAULT NULL,
  `original_filename` text NOT NULL,
  `generated_filename` text NOT NULL,
  `size` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `description`, `created_at`, `updated_at`, `post_status`, `post_date`, `original_filename`, `generated_filename`, `size`) VALUES
(7, 'Blue crisp', '<div><!--block-->dfjhdjhff hdjf f</div>', '2017-04-03 05:59:47', '2017-11-04 22:01:36', 1, '2017-04-03 05:59:58', 'download.jfif', '479766846_655700684_879364014.jfif', 5024),
(9, 'Sample Announcement - updated', '<div><!--block-->Sample description for this announcement - updated</div>', '2017-07-25 00:14:51', '2017-07-25 03:47:51', 1, '2019-01-02 05:47:13', 'a2.jpg', '982452393_73425293_536346436.jpg', 66118),
(10, 'NBA Playoffs All Star 2019', '<div><!--block-->Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&nbsp;<br>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</div>', '2019-01-24 16:33:56', '2019-01-24 16:55:41', 1, '2019-01-24 16:39:29', 'd2bcd3da3751f29a4a62351f2057c14d.jpg', '546026735_290343106_182225733.jpg', 19532);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `send_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chat_id`, `class_id`, `account_id`, `message`, `send_at`) VALUES
(32, 3, 11, 'fksd fsd', '2017-03-03 00:00:00'),
(50, 4, 6, 'hello guys', '2017-03-04 05:42:19'),
(51, 4, 6, 'hehe', '2017-03-04 05:42:21'),
(52, 4, 6, 'hello', '2017-03-04 06:39:28'),
(56, 1, 6, 'hello roi. :)', '2017-03-04 06:59:45'),
(57, 1, 10, 'hello. musta?.hehe', '2017-03-04 07:00:15'),
(58, 1, 6, 'ok lang namn. kwa, musta? :D', '2017-03-04 07:00:37'),
(59, 1, 10, 'ok lang din naman. musta ka na pla?.haha', '2017-03-04 07:02:12'),
(60, 1, 6, 'haha', '2017-03-04 07:03:15'),
(61, 1, 6, 'hehe', '2017-03-04 07:03:25'),
(62, 1, 10, 'wiw', '2017-03-04 07:03:39'),
(63, 1, 6, 'wew', '2017-03-04 07:03:48'),
(64, 1, 6, 'sd', '2017-03-04 07:03:56'),
(65, 1, 6, 'sdd', '2017-03-04 07:04:04'),
(66, 1, 6, 'sadsa', '2017-03-04 07:04:12'),
(67, 1, 6, 'dfd', '2017-03-04 07:06:05'),
(68, 1, 10, 'rpo', '2017-03-04 07:06:34'),
(69, 1, 6, 'sds', '2017-03-04 07:06:45'),
(70, 1, 6, 'haha', '2017-03-04 07:06:59'),
(71, 1, 6, 'gcing ka pa?', '2017-03-04 07:07:54'),
(72, 1, 10, 'oo, kaw?hah', '2017-03-04 07:08:15'),
(73, 1, 6, 'haha.buang. anu pa pla ginagawa mo dyan? :D', '2017-03-04 07:08:37'),
(74, 1, 10, 'code lang. kaw?', '2017-03-04 07:09:04'),
(75, 4, 6, 'uy', '2017-03-04 07:09:32'),
(76, 1, 10, 'ha', '2017-03-04 07:10:23'),
(77, 4, 6, 'roi', '2017-03-04 07:17:35'),
(78, 4, 6, 'hello guys. my assignment na kyo? haha', '2017-03-04 07:23:43'),
(79, 4, 6, 'hello laravel.heh', '2017-03-04 07:24:36'),
(80, 4, 10, 'sdkabd dsaid', '2017-03-04 07:26:03'),
(81, 1, 6, 'uy.hah', '2017-03-04 07:28:28'),
(82, 1, 10, 'haha', '2017-03-04 07:28:45'),
(83, 1, 10, 'roi', '2017-03-04 07:28:56'),
(84, 1, 6, 'sdsd', '2017-03-04 07:29:16'),
(85, 1, 10, 'sdsjd', '2017-03-04 07:29:23'),
(86, 1, 10, 'haha', '2017-03-04 07:29:53'),
(87, 1, 10, 'jdhd', '2017-03-04 07:33:00'),
(88, 1, 10, 'kkdsd', '2017-03-04 07:34:51'),
(89, 1, 10, 'sdsd', '2017-03-04 07:35:53'),
(90, 1, 6, 'hello', '2017-03-05 08:49:17'),
(91, 1, 10, 'roi', '2017-03-05 09:40:57'),
(92, 1, 10, 'vanessa', '2017-03-05 09:41:15'),
(93, 1, 6, 'haha', '2017-03-05 09:41:20'),
(94, 1, 10, 'goodluck.haha', '2017-03-05 09:41:52'),
(95, 1, 6, 'hel\'lo', '2017-03-05 13:07:59'),
(96, 1, 6, 'fsdf', '2017-03-05 13:09:16'),
(97, 1, 10, 'hello', '2017-03-05 13:24:12'),
(98, 1, 6, 'hi', '2017-03-05 13:24:23'),
(99, 1, 6, 'hello', '2017-03-05 17:54:15'),
(100, 1, 10, 'hello', '2017-03-05 17:54:27'),
(101, 1, 6, 'hi', '2017-03-05 17:55:04'),
(102, 1, 10, 'hello maam :)', '2017-03-05 17:55:29'),
(103, 1, 6, 'hi maam', '2017-03-06 06:50:19'),
(104, 1, 10, 'hehe', '2017-03-06 07:23:46'),
(105, 1, 6, 'hello every one', '2017-03-13 03:36:30'),
(106, 4, 10, 'haha', '2017-03-15 22:10:22'),
(107, 8, 6, 'helllo', '2017-03-25 10:19:06'),
(108, 8, 10, 'hehe', '2017-04-03 05:13:45'),
(109, 7, 7, 'Hello guys, kamusta thesis nyo?', '2017-04-16 12:58:19'),
(110, 8, 13, 'Hi :)', '2017-04-16 14:48:45'),
(111, 8, 14, 'hi guys :)', '2017-04-16 15:14:57'),
(112, 7, 28, 'Di pa tapos Sir. Huhuhu', '2017-05-20 13:11:28'),
(113, 8, 13, 'hello', '2017-07-25 04:48:41'),
(114, 1, 6, 'heeeeey', '2017-11-05 09:28:00'),
(115, 1, 6, 'heeeeey', '2017-11-05 09:28:05'),
(116, 1, 6, 'hii', '2017-11-05 09:28:54'),
(117, 2, 6, 'hello world', '2017-11-05 09:32:00'),
(118, 4, 6, 'Homework', '2017-11-05 09:36:13'),
(119, 32, 7, 'Hi :)', '2019-01-17 03:08:50'),
(120, 32, 7, 'Hi :)', '2019-01-17 03:08:51'),
(121, 32, 32, 'Hi Sir', '2019-01-18 17:47:15'),
(122, 32, 32, 'Are you going to meet us in our class tomorrow?', '2019-01-18 17:48:13'),
(123, 32, 32, 'hello', '2019-01-21 07:40:39'),
(124, 32, 7, 'hi everyone', '2019-01-24 17:39:28'),
(125, 32, 7, 'hha', '2019-01-24 17:39:47'),
(126, 32, 7, 'hhahehe', '2019-01-24 17:39:49'),
(127, 32, 7, 'nice', '2019-01-24 17:39:52'),
(128, 32, 7, 'nice cool', '2019-01-24 17:39:54'),
(129, 32, 7, 'sample conversation', '2019-01-29 11:24:34'),
(130, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(131, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(132, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(133, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(134, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(135, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(136, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(137, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(138, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(139, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(140, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(141, 32, 7, 'sample conversation', '2019-01-29 11:26:14'),
(142, 32, 32, 'sample conversation', '2019-01-29 11:27:12'),
(143, 32, 7, 'sample conversation', '2019-01-29 11:27:12'),
(144, 32, 32, 'sample conversation', '2019-01-29 11:27:12'),
(145, 32, 7, 'sample conversation', '2019-01-29 11:27:12'),
(146, 32, 7, 'sample conversation', '2019-01-29 11:27:12'),
(147, 32, 32, 'sample conversation', '2019-01-29 11:27:12'),
(148, 32, 7, 'sample conversation', '2019-01-29 11:27:12'),
(149, 32, 7, 'sample conversation', '2019-01-29 11:27:12'),
(150, 32, 7, 'sample conversation', '2019-01-29 11:27:12'),
(151, 32, 32, 'sample conversation', '2019-01-29 11:27:12'),
(152, 32, 7, 'sample conversation', '2019-01-29 11:27:12'),
(153, 32, 32, 'sample conversation', '2019-01-29 11:27:12'),
(154, 32, 32, 'sample conversation', '2019-01-29 11:27:19'),
(155, 32, 7, 'sample conversation', '2019-01-29 11:27:19'),
(156, 32, 32, 'sample conversation', '2019-01-29 11:27:19'),
(157, 32, 7, 'sample conversation', '2019-01-29 11:27:19'),
(158, 32, 7, 'sample conversation', '2019-01-29 11:27:19'),
(159, 32, 32, 'sample conversation', '2019-01-29 11:27:19'),
(160, 32, 7, 'sample conversation', '2019-01-29 11:27:19'),
(161, 32, 7, 'sample conversation', '2019-01-29 11:27:19'),
(162, 32, 7, 'sample conversation', '2019-01-29 11:27:19'),
(163, 32, 32, 'sample conversation', '2019-01-29 11:27:19'),
(164, 32, 7, 'sample conversation', '2019-01-29 11:27:19'),
(165, 32, 32, 'sample conversation', '2019-01-29 11:27:19'),
(166, 32, 7, 'hi', '2019-01-29 05:23:06'),
(167, 32, 7, 'roi', '2019-01-29 05:27:31'),
(168, 32, 7, 'ajdadnasd asd asd', '2019-01-29 05:31:22'),
(169, 34, 7, 'haha', '2019-01-29 05:35:35'),
(170, 32, 32, 'Hello Sir', '2019-01-30 03:23:59'),
(171, 32, 32, 'Hi', '2019-01-30 03:24:17'),
(172, 32, 32, 'cool', '2019-01-30 03:24:27'),
(173, 32, 32, 'hehe', '2019-01-30 03:24:32'),
(174, 32, 32, 'haha', '2019-01-30 03:49:09'),
(175, 32, 32, 'thank God :)', '2019-01-30 03:50:26'),
(176, 32, 32, 'nice Roi', '2019-01-30 03:54:41'),
(177, 32, 7, 'Yeah right', '2019-01-30 04:02:13'),
(178, 32, 7, 'hehe', '2019-01-30 04:27:19'),
(179, 32, 7, 'success', '2019-01-30 04:29:41'),
(180, 32, 32, 'HI sir', '2019-01-30 05:03:56'),
(181, 32, 32, 'please', '2019-01-30 05:10:59'),
(182, 32, 32, 'HI heh', '2019-01-30 05:23:20'),
(183, 32, 32, 'it works', '2019-01-30 05:46:37'),
(184, 32, 32, '.it works. yehey 11!', '2019-01-30 05:48:31'),
(185, 32, 32, 'wiww', '2019-01-30 05:56:47'),
(186, 32, 32, 'hello', '2019-01-30 06:01:08'),
(187, 32, 32, 'roi', '2019-01-30 06:06:31'),
(188, 32, 7, 'nice', '2019-01-30 06:07:31'),
(189, 32, 32, 'nice', '2019-01-30 06:08:12'),
(190, 32, 7, 'hi jan', '2019-01-30 06:09:09'),
(191, 32, 32, 'Hi Sir', '2019-01-30 06:12:46'),
(192, 32, 7, 'good morning', '2019-01-30 06:13:18'),
(193, 32, 32, 'hell', '2019-01-30 06:23:56'),
(194, 32, 32, 'hha', '2019-01-30 06:25:33'),
(195, 32, 32, 'hi po', '2019-01-30 06:34:52'),
(196, 32, 7, 'uy', '2019-01-30 06:35:11'),
(197, 32, 7, 'hehe', '2019-01-30 06:36:02'),
(198, 32, 7, 'nice', '2019-01-30 06:36:20'),
(199, 32, 32, 'nice nice nice', '2019-01-30 18:16:15'),
(200, 32, 32, 'hehe', '2019-01-30 18:16:26'),
(201, 32, 32, 'try again', '2019-01-30 18:23:44'),
(202, 32, 32, 'this is it', '2019-01-30 18:23:46'),
(203, 32, 32, 'nice hehe', '2019-01-31 04:12:11'),
(204, 32, 7, 'roi', '2019-01-31 04:39:41'),
(205, 32, 32, 'success', '2019-01-31 04:44:44'),
(206, 32, 32, 'success', '2019-01-31 04:45:18'),
(207, 32, 32, 'hehe', '2019-01-31 04:45:22'),
(208, 32, 32, 'nice nice cnice', '2019-01-31 05:15:20'),
(209, 32, 32, 'hahaha', '2019-01-31 05:18:16'),
(210, 32, 32, 'hello roi', '2019-01-31 05:24:50'),
(211, 32, 32, 'hi jan', '2019-01-31 05:25:58'),
(212, 33, 7, 'hi guys :)', '2019-01-31 05:59:33'),
(213, 33, 7, 'welcome to this class', '2019-01-31 05:59:37'),
(214, 33, 32, 'hello po sir', '2019-01-31 06:10:32'),
(215, 33, 32, ':)', '2019-01-31 06:10:38'),
(216, 33, 7, 'have received any information for our upcoming ICS Fest', '2019-01-31 06:11:29'),
(217, 33, 7, '?', '2019-01-31 06:11:32'),
(218, 33, 32, 'yes sir.', '2019-01-31 06:12:05'),
(219, 33, 32, 'required po ba ang attendance?', '2019-01-31 06:12:16'),
(220, 33, 32, ':D', '2019-01-31 06:12:18'),
(221, 33, 32, ':D', '2019-01-31 06:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `load_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `school_year_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `load_id`, `semester_id`, `school_year_id`, `teacher_id`) VALUES
(1, 1, 1, 1, 4),
(2, 2, 1, 1, 4),
(3, 3, 1, 1, 4),
(4, 4, 1, 1, 4),
(5, 7, 1, 1, 5),
(6, 6, 1, 1, 5),
(7, 7, 2, 1, 5),
(8, 8, 2, 1, 4),
(9, 11, 2, 1, 9),
(10, 14, 2, 1, 9),
(11, 15, 2, 1, 9),
(12, 17, 1, 1, 5),
(13, 18, 1, 1, 8),
(14, 19, 1, 1, 8),
(15, 20, 1, 1, 8),
(16, 21, 1, 1, 8),
(17, 23, 1, 1, 8),
(18, 24, 1, 1, 8),
(19, 25, 1, 1, 8),
(20, 25, 1, 1, 8),
(21, 26, 1, 1, 8),
(22, 27, 1, 1, 8),
(23, 28, 1, 1, 8),
(24, 29, 1, 1, 8),
(25, 30, 1, 1, 9),
(26, 31, 1, 1, 8),
(27, 32, 1, 1, 8),
(28, 33, 1, 1, 5),
(29, 34, 1, 1, 5),
(30, 35, 1, 1, 5),
(31, 36, 1, 1, 5),
(32, 37, 1, 1, 5),
(33, 38, 1, 1, 5),
(34, 39, 1, 1, 5),
(35, 40, 1, 1, 12),
(36, 41, 1, 1, 12),
(37, 42, 1, 1, 12),
(38, 41, 1, 1, 12),
(39, 42, 1, 1, 12),
(40, 43, 1, 1, 12),
(41, 44, 1, 1, 12),
(42, 45, 1, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `class_lists`
--

CREATE TABLE `class_lists` (
  `class_list_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `is_approved` int(11) NOT NULL DEFAULT '1',
  `requested_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_lists`
--

INSERT INTO `class_lists` (`class_list_id`, `class_id`, `student_id`, `is_approved`, `requested_at`) VALUES
(6, 4, 7, 1, '0000-00-00 00:00:00'),
(7, 4, 1, 1, '0000-00-00 00:00:00'),
(8, 4, 11, 1, '0000-00-00 00:00:00'),
(9, 2, 7, 1, '0000-00-00 00:00:00'),
(11, 1, 11, 1, '0000-00-00 00:00:00'),
(12, 1, 7, 1, '0000-00-00 00:00:00'),
(13, 8, 13, 1, '0000-00-00 00:00:00'),
(15, 8, 7, 1, '2017-04-02 22:28:34'),
(17, 8, 14, 1, '2017-04-02 23:48:00'),
(18, 8, 12, 1, '2017-04-03 06:52:22'),
(19, 7, 7, 1, '2017-04-16 05:54:56'),
(20, 7, 12, 1, '2017-04-16 05:55:00'),
(21, 7, 14, 1, '2017-04-16 05:55:09'),
(22, 7, 11, 1, '2017-04-16 05:55:14'),
(23, 7, 1, 1, '2017-04-16 05:55:23'),
(24, 7, 13, 1, '2017-04-16 05:57:04'),
(25, 8, 16, 1, '2017-04-16 08:02:47'),
(26, 8, 19, 1, '2017-04-16 08:02:52'),
(27, 8, 17, 1, '2017-04-16 08:02:59'),
(28, 8, 18, 1, '2017-04-16 08:03:03'),
(29, 8, 22, 0, '2017-04-16 16:05:27'),
(30, 8, 23, 0, '2017-04-16 16:16:16'),
(31, 7, 23, 0, '2017-04-16 16:16:24'),
(32, 7, 22, 0, '2017-04-16 16:18:49'),
(33, 8, 22, 0, '2017-04-16 16:18:55'),
(34, 7, 24, 0, '2017-04-16 16:24:24'),
(35, 8, 24, 0, '2017-04-16 16:24:28'),
(36, 7, 25, 0, '2017-04-16 16:27:42'),
(37, 8, 25, 0, '2017-04-16 16:27:45'),
(38, 7, 26, 0, '2017-04-16 16:45:11'),
(39, 8, 26, 0, '2017-04-16 16:45:13'),
(40, 1, 22, 1, '2017-11-05 01:57:51'),
(41, 1, 20, 1, '2017-11-05 01:57:57'),
(42, 13, 22, 1, '2017-11-19 03:39:10'),
(43, 1, 12, 1, '2017-12-02 11:48:47'),
(44, 22, 22, 1, '2018-03-04 22:29:59'),
(47, 22, 12, 1, '2018-03-11 15:59:51'),
(48, 22, 7, 1, '2018-03-11 16:02:12'),
(49, 25, 22, 1, '2018-07-14 12:34:51'),
(50, 25, 24, 1, '2018-07-14 12:35:13'),
(51, 30, 20, 1, '2019-01-03 02:25:09'),
(52, 30, 24, 1, '2019-01-03 02:25:15'),
(53, 30, 7, 1, '2019-01-03 02:25:49'),
(54, 30, 26, 1, '2019-01-03 02:25:52'),
(56, 32, 28, 1, '2019-01-12 01:03:08'),
(57, 32, 24, 1, '2019-01-12 01:03:18'),
(58, 32, 7, 1, '2019-01-12 01:03:22'),
(59, 32, 11, 1, '2019-01-13 15:34:45'),
(60, 32, 20, 1, '2019-01-13 16:34:53'),
(61, 32, 12, 1, '2019-01-13 16:39:29'),
(62, 33, 28, 1, '2019-01-21 06:40:19'),
(63, 33, 24, 1, '2019-01-31 13:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `commented_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `account_id`, `comment`, `commented_at`, `updated_at`) VALUES
(5, 3, 6, 'wow', '2017-03-05 23:26:22', '2017-03-05 15:26:22'),
(7, 3, 6, 'hehe', '2017-03-06 00:56:43', '2017-03-05 16:56:43'),
(9, 3, 6, 'vanes', '2017-03-06 01:31:00', '2017-03-05 17:31:00'),
(10, 3, 6, 'roi', '2017-03-06 01:32:34', '2017-03-05 17:32:34'),
(11, 3, 6, 'hehe', '2017-03-06 01:33:39', '2017-03-05 17:33:39'),
(15, 3, 6, 'roi', '2017-03-06 01:40:30', '2017-03-05 17:40:30'),
(16, 3, 6, 'avanessa', '2017-03-06 01:41:48', '2017-03-05 17:41:48'),
(28, 6, 10, 'vane', '2017-03-06 02:59:12', NULL),
(29, 7, 6, 'hello maam.hehe', '2017-04-03 05:08:58', NULL),
(30, 10, 7, 'Ay, charot lang. Teacher pala ako. HAHAHAHA!', '2017-04-16 12:50:07', NULL),
(37, 8, 13, 'hi maam', '2017-04-16 14:51:17', NULL),
(38, 8, 13, 'hehehehe', '2017-04-16 14:53:04', NULL),
(39, 8, 13, 'haha', '2017-07-25 04:49:02', NULL),
(40, 6, 6, 'Hi there people pakyu internet!', '2017-11-05 07:38:00', '2017-11-05 08:19:01'),
(41, 12, 7, 'HI hello', '2019-01-14 16:57:08', NULL),
(42, 34, 7, 'HI Smith', '2019-01-16 04:17:06', NULL),
(43, 34, 7, 'Hi again Smith', '2019-01-16 16:14:31', NULL),
(44, 34, 7, 'Hi Roi', '2019-01-16 16:16:40', NULL),
(45, 27, 7, 'Hi', '2019-01-17 16:59:30', NULL),
(46, 27, 7, 'hello', '2019-01-17 17:01:21', NULL),
(47, 27, 7, 'hi', '2019-01-17 17:08:48', NULL),
(48, 27, 7, 'hehe', '2019-01-17 17:11:00', NULL),
(49, 27, 7, 'Hi test', '2019-01-17 17:13:22', NULL),
(50, 27, 7, 'adasdas', '2019-01-17 17:33:42', NULL),
(51, 27, 7, 'asdas', '2019-01-17 17:35:29', NULL),
(52, 26, 7, 'hi', '2019-01-17 17:35:57', NULL),
(53, 26, 7, 'helo', '2019-01-17 17:36:03', NULL),
(54, 26, 7, 'nice', '2019-01-17 17:36:08', NULL),
(55, 26, 7, 'cool', '2019-01-17 17:36:11', NULL),
(56, 34, 32, 'Hey, how you doin?', '2019-01-18 17:26:31', '2019-01-18 17:28:29'),
(57, 27, 7, 'hello', '2019-01-28 18:02:14', NULL),
(58, 34, 32, 'hi', '2019-01-31 04:20:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `description`) VALUES
(1, 'information Technology updated'),
(2, 'Computer Science'),
(7, 'dummy course'),
(11, 'Computer Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `curriculum`
--

CREATE TABLE `curriculum` (
  `curriculum_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `school_year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `curriculum`
--

INSERT INTO `curriculum` (`curriculum_id`, `course_id`, `school_year_id`) VALUES
(2, 2, 6),
(3, 2, 6),
(4, 2, 6),
(5, 2, 6),
(6, 1, 1),
(7, 1, 1),
(8, 1, 1),
(9, 1, 1),
(10, 1, 1),
(11, 2, 4),
(12, 2, 6),
(13, 2, 6),
(14, 2, 6),
(15, 2, 1),
(16, 2, 6),
(17, 2, 4),
(18, 1, 1),
(20, 1, 1),
(21, 7, 6),
(22, 7, 6),
(23, 7, 6),
(24, 1, 6),
(26, 1, 6),
(27, 1, 6),
(28, 1, 6),
(29, 1, 15),
(30, 1, 15),
(31, 2, 6),
(32, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_subjects`
--

CREATE TABLE `curriculum_subjects` (
  `curriculum_subject_id` int(11) NOT NULL,
  `curriculum_year_sem_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `curriculum_subjects`
--

INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_year_sem_id`, `subject_id`) VALUES
(2, 2, 2),
(3, 3, 4),
(4, 4, 2),
(5, 5, 4),
(6, 6, 3),
(7, 7, 2),
(8, 8, 4),
(9, 9, 2),
(10, 10, 5),
(11, 11, 5),
(12, 12, 6),
(13, 13, 5),
(14, 14, 6),
(15, 15, 6),
(16, 16, 3),
(17, 17, 7),
(18, 19, 6),
(19, 20, 6),
(20, 21, 4),
(21, 22, 6),
(22, 23, 6),
(23, 25, 13),
(25, 27, 3),
(26, 28, 3),
(27, 29, 4),
(28, 30, 3),
(29, 31, 13);

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_year_sem`
--

CREATE TABLE `curriculum_year_sem` (
  `curriculum_year_sem_id` int(11) NOT NULL,
  `curriculum_id` int(11) NOT NULL,
  `year_level` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `curriculum_year_sem`
--

INSERT INTO `curriculum_year_sem` (`curriculum_year_sem_id`, `curriculum_id`, `year_level`, `semester_id`) VALUES
(1, 2, 1, 1),
(2, 3, 2, 1),
(3, 4, 1, 1),
(4, 5, 1, 1),
(5, 6, 2, 1),
(6, 7, 2, 1),
(7, 8, 2, 1),
(8, 9, 2, 2),
(9, 10, 2, 2),
(10, 11, 4, 2),
(11, 12, 4, 2),
(12, 13, 4, 1),
(13, 14, 4, 2),
(14, 15, 1, 1),
(15, 16, 1, 1),
(16, 17, 1, 1),
(17, 18, 2, 1),
(19, 20, 2, 1),
(20, 21, 1, 1),
(21, 22, 1, 1),
(22, 23, 2, 2),
(23, 24, 1, 1),
(25, 26, 1, 1),
(26, 27, 1, 1),
(27, 28, 1, 1),
(28, 29, 1, 1),
(29, 30, 1, 1),
(30, 31, 1, 1),
(31, 32, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `color` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `post_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `description`, `date_from`, `date_to`, `color`, `created_at`, `updated_at`, `post_status`) VALUES
(1, 'Graduation Ceremony', '2019-03-28', '2019-03-29', 'red', '2017-06-15 00:00:00', '2017-04-16 13:32:14', 0),
(2, 'Baccalaureate', '2019-03-27', '2019-03-28', 'red', '2017-03-06 18:25:28', '2017-04-16 13:31:24', 0),
(3, 'Lenten Season', '2019-04-13', '2019-04-16', 'green', '2017-04-16 13:33:22', NULL, 0),
(5, 'All saints day', '2019-11-01', '2019-11-01', 'blue', '2017-11-04 22:07:45', '2017-11-04 23:39:29', 0),
(6, 'EDSA people power anniversary', '2019-02-25', '2019-02-27', 'blue', '2019-01-27 23:23:36', NULL, 0),
(7, 'EDSA people power anniversary', '2019-02-25', '2019-02-27', 'blue', '2019-01-27 23:24:56', NULL, 0),
(8, 'Valentines day', '2019-02-14', '2019-02-14', 'red', '2019-01-27 23:24:56', NULL, 0),
(9, 'National Heroes Day', '2019-03-01', '2019-03-01', 'blue', '2019-01-27 23:24:56', NULL, 0),
(10, 'April Fools day', '2019-04-01', '2019-04-01', 'red', '2019-01-27 23:24:56', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `homeworks`
--

CREATE TABLE `homeworks` (
  `homework_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `send_at` datetime DEFAULT NULL,
  `due_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `send_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homeworks`
--

INSERT INTO `homeworks` (`homework_id`, `class_id`, `title`, `description`, `send_at`, `due_at`, `update_at`, `created_at`, `send_status`) VALUES
(3, 1, 'Internet connection', '<div><!--block-->Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</div>', '2017-11-05 09:11:08', '2017-11-22 00:00:00', NULL, '2017-03-15 03:36:33', 1),
(22, 4, 'Sample Homeworks', '<div><!--block-->Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</div>', '2017-03-15 18:41:25', '2017-03-18 00:00:00', NULL, '2017-03-15 18:41:25', 1),
(23, 4, 'Another sample homework', '<div><!--block-->Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</div>', '2017-03-15 19:17:52', '2017-03-16 00:00:00', NULL, '2017-03-15 19:17:52', 1),
(25, 4, 'Rdasd', '<div><!--block-->jaskdasd</div>', '2017-03-15 19:41:28', '2017-03-15 00:00:00', NULL, '2017-03-15 19:24:54', 1),
(28, 4, 'zsdsd', '<div><!--block-->sdsad</div>', '2017-03-15 21:44:40', '2017-03-15 00:00:00', NULL, '2017-03-15 21:44:40', 1),
(29, 1, 'HomeWorks for Life', '<div><!--block-->Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</div>', '2017-11-05 09:07:05', '2017-11-13 00:00:00', NULL, '2017-03-16 21:33:41', 1),
(30, 8, 'hello', '<div><!--block-->sand adsandas danda da dadk sdasndas dnsad sa dkas</div>', '2017-04-03 05:46:25', '2017-04-02 00:00:00', NULL, '2017-04-03 05:46:25', 1),
(31, 1, 'Baccalaureate', 'null', '2017-11-05 09:20:44', '2017-12-25 00:00:00', NULL, '2017-11-05 09:14:05', 1),
(32, 32, 'Fundamentals of programming (1)', '<div><!--block-->Research the following fundamentals of programming and give a sample code for each:</div><ul><li><!--block--><strong>variable</strong></li><li><!--block--><strong>datatype</strong></li><li><!--block--><strong>loops</strong></li><li><!--block--><strong>conditional statements</strong></li></ul><div><!--block--><br></div><div><!--block-->See attached files as reference. :)</div>', '2019-01-13 16:20:36', '2019-01-21 00:00:00', NULL, '2019-01-13 16:20:36', 1),
(33, 32, '(2) Homework - updated', '<div><!--block-->This is an example of homework description - updated</div>', '2019-01-21 10:32:58', '2019-01-23 00:00:00', NULL, '2019-01-14 15:06:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `homework_uploaded_files`
--

CREATE TABLE `homework_uploaded_files` (
  `homework_uploaded_file_id` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `file_type` text NOT NULL,
  `size` double NOT NULL,
  `original_file_name` text NOT NULL,
  `generated_file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homework_uploaded_files`
--

INSERT INTO `homework_uploaded_files` (`homework_uploaded_file_id`, `homework_id`, `file_type`, `size`, `original_file_name`, `generated_file_name`) VALUES
(4, 22, 'file', 0, 'Doc1.docx', '927520752_210876465_143524170.docx'),
(5, 22, 'file', 0, 'IZA MAE.docx', '911499024_542633057_820617676.docx'),
(6, 22, 'file', 0, 'ABIFE.docx', '917816163_371826172_530792237.docx'),
(7, 22, 'file', 0, 'testdb.mdb', '92468262_862030030_353637696.mdb'),
(8, 23, 'file', 0, 'Doc1.docx', '360748292_120178223_194915772.docx'),
(9, 23, 'file', 0, 'IZA MAE.docx', '700683594_1251221_497497559.docx'),
(10, 23, 'file', 0, 'ABIFE.docx', '635223389_756713868_921051026.docx'),
(11, 23, 'file', 0, 'testdb.mdb', '318176270_401702881_365478516.mdb'),
(12, 32, 'file', 22167, '3 - Chapter 1 (1-4).docx', '15081194_423897681_985685287.docx'),
(13, 32, 'file', 30216, '4 - Review of Related Literature (5-14).docx', '692331798_993726810_742114150.docx'),
(14, 33, 'file', 17437, '2.docx', '951537931_874587432_520455632.docx'),
(15, 33, 'file', 22167, '3 - Chapter 1 (1-4).docx', '298647492_15665265_514476988.docx'),
(16, 33, 'file', 30216, '4 - Review of Related Literature (5-14).docx', '233975085_75436774_387123840.docx'),
(17, 33, 'file', 20747, '3-CH1-INTRO-1-4.docx', '209783851_668099738_652759063.docx');

-- --------------------------------------------------------

--
-- Table structure for table `ics_details`
--

CREATE TABLE `ics_details` (
  `ics_detail_id` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `mission` text NOT NULL,
  `vision` text NOT NULL,
  `goals` text NOT NULL,
  `objectives` text NOT NULL,
  `history` text NOT NULL,
  `ics_logo` text NOT NULL,
  `wmsu_logo` text NOT NULL,
  `address` varchar(50) NOT NULL,
  `tel_number` varchar(50) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `mission_updated_at` datetime NOT NULL,
  `vision_updated_at` datetime NOT NULL,
  `goals_updated_at` datetime NOT NULL,
  `objectives_updated_at` datetime NOT NULL,
  `history_updated_at` datetime NOT NULL,
  `ics_logo_updated_at` datetime NOT NULL,
  `wmsu_logo_updated_at` datetime NOT NULL,
  `address_updated_at` datetime NOT NULL,
  `tel_number_updated_at` datetime NOT NULL,
  `email_address_updated_at` datetime NOT NULL,
  `organization_name_updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ics_details`
--

INSERT INTO `ics_details` (`ics_detail_id`, `organization_name`, `mission`, `vision`, `goals`, `objectives`, `history`, `ics_logo`, `wmsu_logo`, `address`, `tel_number`, `email_address`, `mission_updated_at`, `vision_updated_at`, `goals_updated_at`, `objectives_updated_at`, `history_updated_at`, `ics_logo_updated_at`, `wmsu_logo_updated_at`, `address_updated_at`, `tel_number_updated_at`, `email_address_updated_at`, `organization_name_updated_at`) VALUES
(1, 'Institute of Computer Studies', 'To educate and produce top quality engineers who will become the country’s leading Technologists engineers, industrial managers, environmentalists and information technology experts in support of the socio-economic and technological development of the country. Utilize our resources and expertise to support local industries and strengthen linkages.', 'We aspire to be an Asian standard school of engineering in Western Mindanao producing graduates imbued with sound Filipino values, highly productive, globally competitive and committed to quality engineering services.', '<p></p>\n\n<p>To prepare educate future leaders in the engineering profession who possess the competence and expertise and are recognized for their:</p><p></p><ul><p></p><p></p><li>Analytical and technical capability in utilizing the tools of engineering mathematics, sciences and technology to solve societal problems.<p></p><p></p></li><p></p><p></p><li>Proficiency in oral and written communication.<p></p><p></p></li><p></p><p></p><li>Contributions to society as planners, consultants, contractors, and leaders in multidisciplinary teams.<p></p><p></p></li><p></p><p></p><li>Pursuit of lifelong learning and professional development.</li></ul>', '<ul><li>To effectively apply the computer science theories and methodologies and mathematical concepts in modeling, designing and developing of computer -based systems of varying complexity.</li><li>To adapt new technologies and ideas in the design, analysis and implementation of software, and to formulate an effective solution to solve information technology-related program.</li><li>To provide students with opportunity to pursue personal development and lifelong learning through research, graduate studies, professional and membership to professional organization to be globally competitive.</li><li>To produce student-leaders and graduates who recognize the societal needs and understand the professional, legal security, and ethical issues relevant to computing career practice.</li><li>To involve and to encourage students to produce researches relevant with the institutional, regional and national priorities and responsive to the needs and concerns of the communities they serve.</li></ul>', 'The ICS is one of the oldest colleges of the University. From its humble beginnings as an Institute of Engineering and Technology offering only two engineering courses, it has now produce engineering graduates in the different fields of engineering. The college is consistently producing board to notch and high board passing rate in the Engineering Board Examinations which are consistently higher than the national passing rate.', '948894954_569840715_376625947.jpg', '', 'Normal Rd. Baliwasan Zamboanga City', '09265032398', 'wmsu_ics@gmail.com', '2017-04-16 13:07:45', '2017-04-16 13:08:36', '2017-04-16 13:10:57', '2017-04-16 13:06:09', '2017-04-16 13:11:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-04-03 13:09:50', '2017-02-14 21:32:22', '2017-04-03 13:10:01', '2017-03-06 08:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `last_viewed_chats`
--

CREATE TABLE `last_viewed_chats` (
  `LVC_ID` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `last_chat_id` int(11) NOT NULL,
  `current_chat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `last_viewed_chats`
--

INSERT INTO `last_viewed_chats` (`LVC_ID`, `account_id`, `class_id`, `last_chat_id`, `current_chat_id`) VALUES
(1, 32, 32, 211, 211),
(2, 7, 32, 209, 211),
(3, 8, 32, 207, 207),
(4, 7, 33, 217, 221),
(5, 32, 33, 221, 221);

-- --------------------------------------------------------

--
-- Table structure for table `loads`
--

CREATE TABLE `loads` (
  `load_id` int(11) NOT NULL,
  `curriculum_subject_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `curriculum_school_year_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `section` varchar(10) DEFAULT NULL,
  `monday` int(11) NOT NULL DEFAULT '0',
  `tuesday` int(11) NOT NULL DEFAULT '0',
  `wednesday` int(11) NOT NULL DEFAULT '0',
  `thursday` int(11) NOT NULL DEFAULT '0',
  `friday` int(11) NOT NULL DEFAULT '0',
  `saturday` int(11) NOT NULL DEFAULT '0',
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loads`
--

INSERT INTO `loads` (`load_id`, `curriculum_subject_id`, `course_id`, `curriculum_school_year_id`, `subject_id`, `section`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `start_time`, `end_time`, `room`) VALUES
(27, 0, 2, 6, 2, 'C', 1, 1, 1, 0, 0, 1, '09:30:00', '15:30:00', 'Ne29'),
(28, 0, 2, 6, 6, 'A', 1, 0, 0, 0, 1, 1, '10:30:00', '12:30:00', 'ne23'),
(30, 0, 1, 15, 3, 'B', 1, 0, 1, 0, 1, 0, '08:30:00', '10:00:00', 'NE29'),
(31, 0, 1, 6, 13, 'D', 0, 0, 0, 1, 0, 1, '07:00:00', '10:30:00', 'NE31'),
(32, 0, 1, 6, 3, 'D', 0, 0, 0, 1, 0, 1, '10:30:00', '12:30:00', 'AVR'),
(33, 0, 2, 6, 4, 'C', 1, 0, 1, 0, 0, 0, '08:30:00', '10:00:00', 'AVR'),
(35, 0, 2, 6, 2, 'A', 0, 1, 0, 1, 0, 0, '12:00:00', '13:30:00', 'NE25'),
(36, 0, 2, 6, 2, 'A', 1, 0, 1, 0, 0, 0, '07:00:00', '08:30:00', 'NE28'),
(37, 4, 2, 6, 2, 'A', 1, 1, 0, 0, 0, 0, '08:00:00', '10:30:00', 'NE29'),
(38, 3, 2, 6, 4, 'B', 0, 0, 0, 1, 1, 0, '07:00:00', '10:00:00', 'AVR'),
(39, 12, 2, 6, 6, 'B', 1, 1, 0, 0, 0, 0, '10:00:00', '13:30:00', 'NE28'),
(40, 25, 1, 6, 3, 'P', 0, 1, 0, 0, 0, 0, '10:30:00', '12:00:00', 'TM 890'),
(44, 22, 1, 6, 6, 'A', 1, 1, 0, 0, 0, 0, '10:00:00', '11:30:00', 'b12'),
(45, 22, 1, 6, 6, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `send_to_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `is_read` int(11) DEFAULT '0',
  `is_replied` int(11) NOT NULL DEFAULT '0',
  `reply_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `account_id` int(100) NOT NULL,
  `description` text NOT NULL,
  `post_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `post_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_files`
--

CREATE TABLE `post_files` (
  `post_file_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `original_file_name` text NOT NULL,
  `generated_file_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `school_year_id` int(11) NOT NULL,
  `sy_from` int(11) NOT NULL,
  `sy_to` int(11) NOT NULL,
  `is_current_sy` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `semester_id` int(11) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `is_current_semester` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sent_items`
--

CREATE TABLE `sent_items` (
  `sent_item_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `replied_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stud_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `image` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `subject_description` varchar(50) NOT NULL,
  `lec_units` float NOT NULL,
  `lab_units` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `submitted_homeworks`
--

CREATE TABLE `submitted_homeworks` (
  `submitted_homework_id` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `is_submitted` int(11) NOT NULL DEFAULT '0',
  `date_submitted` datetime DEFAULT NULL,
  `approved_status` int(11) DEFAULT '0',
  `date_approved` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `submitted_homework_files`
--

CREATE TABLE `submitted_homework_files` (
  `submitted_homework_file_id` int(11) NOT NULL,
  `submitted_homework_id` int(11) NOT NULL,
  `file_type` text,
  `original_file_name` text,
  `generated_file_name` text,
  `size` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthdate` datetime NOT NULL,
  `academic_rank` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_lists`
--
ALTER TABLE `class_lists`
  ADD PRIMARY KEY (`class_list_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`curriculum_id`);

--
-- Indexes for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  ADD PRIMARY KEY (`curriculum_subject_id`);

--
-- Indexes for table `curriculum_year_sem`
--
ALTER TABLE `curriculum_year_sem`
  ADD PRIMARY KEY (`curriculum_year_sem_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `homeworks`
--
ALTER TABLE `homeworks`
  ADD PRIMARY KEY (`homework_id`);

--
-- Indexes for table `homework_uploaded_files`
--
ALTER TABLE `homework_uploaded_files`
  ADD PRIMARY KEY (`homework_uploaded_file_id`);

--
-- Indexes for table `ics_details`
--
ALTER TABLE `ics_details`
  ADD PRIMARY KEY (`ics_detail_id`);

--
-- Indexes for table `last_viewed_chats`
--
ALTER TABLE `last_viewed_chats`
  ADD PRIMARY KEY (`LVC_ID`);

--
-- Indexes for table `loads`
--
ALTER TABLE `loads`
  ADD PRIMARY KEY (`load_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `sent_items`
--
ALTER TABLE `sent_items`
  ADD PRIMARY KEY (`sent_item_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stud_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `submitted_homeworks`
--
ALTER TABLE `submitted_homeworks`
  ADD PRIMARY KEY (`submitted_homework_id`);

--
-- Indexes for table `submitted_homework_files`
--
ALTER TABLE `submitted_homework_files`
  ADD PRIMARY KEY (`submitted_homework_file_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `class_lists`
--
ALTER TABLE `class_lists`
  MODIFY `class_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `curriculum`
--
ALTER TABLE `curriculum`
  MODIFY `curriculum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  MODIFY `curriculum_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `curriculum_year_sem`
--
ALTER TABLE `curriculum_year_sem`
  MODIFY `curriculum_year_sem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `homeworks`
--
ALTER TABLE `homeworks`
  MODIFY `homework_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `homework_uploaded_files`
--
ALTER TABLE `homework_uploaded_files`
  MODIFY `homework_uploaded_file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ics_details`
--
ALTER TABLE `ics_details`
  MODIFY `ics_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `last_viewed_chats`
--
ALTER TABLE `last_viewed_chats`
  MODIFY `LVC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `loads`
--
ALTER TABLE `loads`
  MODIFY `load_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sent_items`
--
ALTER TABLE `sent_items`
  MODIFY `sent_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submitted_homeworks`
--
ALTER TABLE `submitted_homeworks`
  MODIFY `submitted_homework_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submitted_homework_files`
--
ALTER TABLE `submitted_homework_files`
  MODIFY `submitted_homework_file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
