-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 02 2012 г., 07:40
-- Версия сервера: 5.1.63-0ubuntu0.10.04.1
-- Версия PHP: 5.3.2-1ubuntu4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `answer_text` varchar(800) CHARACTER SET utf8 DEFAULT NULL,
  `answer_image` varchar(450) CHARACTER SET utf8 DEFAULT NULL,
  `correct_answer` int(11) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `correct_answer_text` varchar(800) CHARACTER SET utf8 DEFAULT NULL,
  `answer_pos` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL,
  `answer_text_eng` varchar(800) CHARACTER SET utf8 DEFAULT NULL,
  `control_type` int(11) DEFAULT NULL,
  `answer_parent_id` int(11) DEFAULT NULL,
  `text_unit` char(10) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=176229 ;

-- --------------------------------------------------------

--
-- Структура таблицы `assignments`
--

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL DEFAULT '0',
  `org_quiz_id` int(11) NOT NULL DEFAULT '0',
  `results_mode` int(11) NOT NULL DEFAULT '0',
  `added_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `quiz_time` int(11) NOT NULL DEFAULT '0',
  `show_results` int(11) NOT NULL DEFAULT '0',
  `pass_score` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quiz_type` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `allow_review` int(11) NOT NULL DEFAULT '2',
  `qst_order` int(11) NOT NULL DEFAULT '1',
  `answer_order` int(11) NOT NULL DEFAULT '1',
  `affect_changes` int(11) NOT NULL,
  `limited` int(11) NOT NULL,
  `send_results` int(11) NOT NULL,
  `accept_new_users` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Структура таблицы `assignment_users`
--

DROP TABLE IF EXISTS `assignment_users`;
CREATE TABLE IF NOT EXISTS `assignment_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) NOT NULL DEFAULT '0',
  `user_type` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `assignment_id` (`assignment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=270 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cats`
--

DROP TABLE IF EXISTS `cats`;
CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Дамп данных таблицы `cats`
--

INSERT INTO `cats` (`id`, `cat_name`) VALUES
(61, 'IT tests');

-- --------------------------------------------------------

--
-- Структура таблицы `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `vars` varchar(300) DEFAULT NULL,
  `body` text,
  `subject` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `vars`, `body`, `subject`) VALUES
(1, 'register_user', '[UserName],[Name],[Surname],[email], [address], [phone], [url]', 'Dear [Name] [Surname] , \n\nYou have registered in our system . Here is the details of registration\n\nName : [Name] \nSurname  : [Surname]\nLogin : [UserName]\nAddress : [address]\nPhone : [phone]\nEmail : [email]\n\nTo approve your registration in our Quiz system , please open below link \n\n[url]\n\nThanks', 'Registration in Quiz System'),
(2, 'forgot_password', '[UserName],[Name],[Surname],[email],[address],[phone],[url],[random_password]', 'Dear [Name] [Surname] ,\n\nYou password has been reseted , please find your password below .\n\nLogin : [UserName]\nPassword : [random_password]\nEmail : [email]\n\nThanks', 'Restoring the password'),
(3, 'quiz_start_message', '[UserName],[Name],[Surname],[email],[address], [phone],[url],[quiz_name]', 'Dear [Name] [Surname] , \n\nThe below listed exam has been started . \n\nQuiz name : [quiz_name]\nName : [Name] \nSurname  : [Surname]\nLogin : [UserName]\n\nTo join to exam please , use below link\n\n[url]\n\nThanks', 'Online exam started'),
(4, 'quiz_results_success', '[UserName],[Name],[Surname],[email],[url],[quiz_name],[start_date],[finish_date],[pass_score],[user_score]', 'Dear [Name] [Surname] ,\n\nYou passed exam successfully . \n\nQuiz name : [quiz_name]\nStart date : [start_date]\nFinish date : [finish_date]\nPass score : [pass_score]\nYour score : [user_score]\n\nThanks,\nAdministrator', 'You passed exam succesfully'),
(5, 'quiz_results_not_success', '[UserName],[Name],[Surname],[email],[url],[quiz_name],[start_date],[finish_date],[pass_score],[user_score]', 'Dear [Name] [Surname] ,\n\nSorry , you didn''t pass exam succesfully . \n\nQuiz name : [quiz_name]\nStart date : [start_date]\nFinish date : [finish_date]\nPass score : [pass_score]\nYour score : [user_score]\n\nThanks,\nAdministrator', 'Sorry , you didn''t pass exam succesfully');

-- --------------------------------------------------------

--
-- Структура таблицы `imported_users`
--

DROP TABLE IF EXISTS `imported_users`;
CREATE TABLE IF NOT EXISTS `imported_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `surname` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(150) NOT NULL DEFAULT '',
  `password` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;



DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `priority` int(11) default '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `file_name`, `parent_id`, `priority`) VALUES
(1, 'Quizzes', NULL, 0, '1'),
(2, 'Categories', 'cats', 1, '1'),
(3, 'Quizzes', 'quizzes', 1, '2'),
(4, 'Local users', 'local_users', 13, '4'),
(26, 'Imported users', 'imported_users', 13, '5'),
(5, 'Assignments', NULL, 0, '2'),
(6, 'Assignments', 'assignments', 5, '6'),
(7, 'New Assignment', 'add_assignment', 5, '7'),
(8, 'Assignments', NULL, 0, '3'),
(9, 'Active Assignments', 'active_assignments', 8, '1'),
(10, 'My old assigments', 'old_assignments', 8, '2'),
(11, 'New User', 'add_edit_user', 13, '7'),
(12, 'New Quiz', 'add_edit_quiz', 1, '3'),
(13, 'Users', '', 0, '4'),
(17, 'Ratings', '', 0, '5'),
(18, 'Ratings', 'ratings', 17, '1'),
(19, 'Add rating', 'add_edit_rating', 17, '2'),
(20, 'Change password', 'change_password', 13, '10'),
(21, 'Settings', NULL, 0, '6'),
(23, 'Content management', 'cms', 21, '1'),
(24, 'SQL Queries', 'sql_queries', 21, '2');


-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(800) NOT NULL,
  `page_content` text NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `page_content`, `priority`) VALUES
(1, 'Home', '', 0),
(2, 'About', '', 0),
(15, 'Link2', '', 101),
(4, 'Links', '', 0),
(5, 'Forum', '', 0),
(14, 'Link1', '', 100),
(8, 'Products', '', 0),
(9, 'Documentation', '', 0),
(13, 'Information', '', 99);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(3800) DEFAULT NULL,
  `question_type_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `point` decimal(18,0) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` int(11) NOT NULL,
  `question_total` decimal(18,0) DEFAULT NULL,
  `check_total` int(11) DEFAULT NULL,
  `header_text` varchar(1500) CHARACTER SET utf8 DEFAULT NULL,
  `footer_text` varchar(1500) CHARACTER SET utf8 DEFAULT NULL,
  `question_text_eng` varchar(1800) CHARACTER SET utf8 DEFAULT NULL,
  `help_image` varchar(550) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=389 ;

-- --------------------------------------------------------

--
-- Структура таблицы `question_groups`
--

DROP TABLE IF EXISTS `question_groups`;
CREATE TABLE IF NOT EXISTS `question_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(450) NOT NULL,
  `show_header` int(11) NOT NULL,
  `group_total` decimal(18,0) NOT NULL,
  `show_footer` int(11) DEFAULT NULL,
  `check_total` decimal(18,0) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `group_name_eng` varchar(450) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=425 ;

-- --------------------------------------------------------

--
-- Структура таблицы `question_types`
--

DROP TABLE IF EXISTS `question_types`;
CREATE TABLE IF NOT EXISTS `question_types` (
  `id` int(11) NOT NULL,
  `question_type` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `question_types`
--

INSERT INTO `question_types` (`id`, `question_type`) VALUES
(0, 'Multi answer (checkbox)'),
(3, 'Free text (textarea)'),
(4, 'Multi text (numbers only)'),
(1, 'One answer (radio button)');

-- --------------------------------------------------------

--
-- Структура таблицы `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `quiz_name` varchar(500) NOT NULL,
  `quiz_desc` varchar(500) NOT NULL,
  `added_date` datetime NOT NULL,
  `parent_id` int(11) NOT NULL,
  `show_intro` int(11) NOT NULL,
  `intro_text` varchar(3850) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(455) NOT NULL DEFAULT '',
  `temp_id` int(11) NOT NULL DEFAULT '0',
  `header_text` varchar(555) NOT NULL DEFAULT '',
  `footer_text` varchar(555) NOT NULL DEFAULT '',
  `img_count` int(11) NOT NULL DEFAULT '0',
  `show_results` int(11) NOT NULL DEFAULT '0',
  `restrict_user` int(11) NOT NULL DEFAULT '0',
  `bgcolor` varchar(255) NOT NULL DEFAULT '',
  `added_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `lang` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Дамп данных таблицы `ratings`
--

INSERT INTO `ratings` (`id`, `description`, `temp_id`, `header_text`, `footer_text`, `img_count`, `show_results`, `restrict_user`, `bgcolor`, `added_date`, `status`, `lang`) VALUES
(26, 'rating 1', 6, '', '', 5, 1, 1, '-1', '2011-12-20 12:23:00', 1, 'English'),
(31, 'rating 2', 3, '', '', 5, 1, 2, '-1', '2011-12-20 12:23:19', 1, 'English'),
(32, 'rating 3', 2, '', '', 5, 1, 1, '-1', '2011-12-20 12:23:31', 1, 'English');

-- --------------------------------------------------------

--
-- Структура таблицы `rating_temps`
--

DROP TABLE IF EXISTS `rating_temps`;
CREATE TABLE IF NOT EXISTS `rating_temps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temp_name` varchar(255) NOT NULL DEFAULT '',
  `active_img` varchar(255) NOT NULL DEFAULT '',
  `inactive_img` varchar(255) NOT NULL DEFAULT '',
  `half_active_img` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `rating_temps`
--

INSERT INTO `rating_temps` (`id`, `temp_name`, `active_img`, `inactive_img`, `half_active_img`) VALUES
(1, 'Star1', '1.gif', '1_n.gif', '1_h.gif'),
(2, 'Star1', '7.gif', '7_n.gif', '7_h.gif'),
(3, 'Star2', '2.gif', '2_n.gif', '2_h.gif'),
(4, 'Star3', '3.gif', '3_n.gif', '3_h.gif'),
(5, 'Star4', '4.gif', '4_n.gif', '4_h.gif'),
(6, 'Star5', '5.gif', '5_n.gif', '5_h.gif'),
(7, 'Star6', '6.gif', '6_n.gif', '6_h.gif'),
(8, 'Star7', '8.gif', '8_n.gif', '8_h.gif');

-- --------------------------------------------------------

--
-- Структура таблицы `roles_rights`
--

DROP TABLE IF EXISTS `roles_rights`;
CREATE TABLE IF NOT EXISTS `roles_rights` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `roles_rights`
--

INSERT INTO `roles_rights` (`Id`, `role_id`, `module_id`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 1, 6),
(5, 1, 7),
(13, 1, 1),
(12, 1, 12),
(11, 1, 11),
(9, 2, 9),
(10, 2, 10),
(14, 1, 5),
(15, 1, 13),
(16, 2, 8),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 2, 20),
(22, 2, 13),
(23, 1, 21),
(24, 1, 22),
(25, 1, 23),
(26, 1, 24),
(27, 1, 26),
(28, 1, 25);



-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Surname` varchar(150) NOT NULL,
  `added_date` datetime NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `random_str` varchar(100) DEFAULT NULL,
  `approved` int(11) NOT NULL,
  `disabled` int(11) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50005 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Name`, `Surname`, `added_date`, `user_type`, `email`, `address`, `phone`, `random_str`, `approved`, `disabled`) VALUES
(50001, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '2011-10-27 12:02:06', 1, 'elshan999@mail.ru', '', '', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_answers`
--

DROP TABLE IF EXISTS `user_answers`;
CREATE TABLE IF NOT EXISTS `user_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_quiz_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `user_answer_id` int(11) DEFAULT NULL,
  `user_answer_text` varchar(3800) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_answers_ibfk_1` (`user_quiz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=234 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_quizzes`
--

DROP TABLE IF EXISTS `user_quizzes`;
CREATE TABLE IF NOT EXISTS `user_quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `success` int(11) DEFAULT NULL,
  `finish_date` datetime DEFAULT NULL,
  `pass_score_point` decimal(10,2) DEFAULT NULL,
  `pass_score_perc` decimal(10,2) DEFAULT NULL,
  `archived` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assignment_id` (`assignment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_ratings`
--

DROP TABLE IF EXISTS `user_ratings`;
CREATE TABLE IF NOT EXISTS `user_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rate_id` int(11) NOT NULL DEFAULT '0',
  `product_id` varchar(1255) NOT NULL DEFAULT '',
  `point` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_ratings_ibfk_1` (`rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_types`
--

INSERT INTO `user_types` (`id`, `type_name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `v_imported_users`
--
DROP VIEW IF EXISTS `v_imported_users`;
CREATE TABLE IF NOT EXISTS `v_imported_users` (
`UserID` int(11)
,`Name` varchar(250)
,`Surname` varchar(255)
,`UserName` varchar(150)
,`Password` varchar(150)
,`email` varchar(150)
);


insert into pages(id,page_name,page_content,priority)
values (1000000,'<font color=blue>License</font>', '<p><br /><br />
Developed by : <a href="http://www.phpexamscript.net">http://www.phpexamscript.net</a>
<br /><br />
	To remove this page , go to Settings - Content Management&nbsp;</p>',1000000);

-- --------------------------------------------------------

CREATE UNIQUE INDEX USR_LOGIN_INDEX ON users (UserName);
CREATE UNIQUE INDEX USR_EMAIL_INDEX ON users (email);

alter table users add column app_type int(11) default 0 not null;
update users SET app_type=0;


CREATE TABLE payment_orders (
  order_id int(11) NOT NULL AUTO_INCREMENT,
  txn_id varchar(19) NOT NULL,
  payer_email varchar(75) NOT NULL,
  mc_gross decimal(18, 4) NOT NULL,  
  inserted_date datetime NOT NULL,
  currency varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,  
  PRIMARY KEY (order_id),
  UNIQUE INDEX txn_id (txn_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 68
AVG_ROW_LENGTH = 1820
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Структура для представления `v_imported_users`
--
DROP TABLE IF EXISTS `v_imported_users`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_imported_users` AS select `imported_users`.`id` AS `UserID`,`imported_users`.`name` AS `Name`,`imported_users`.`surname` AS `Surname`,`imported_users`.`user_name` AS `UserName`,`imported_users`.`password` AS `Password`,`imported_users`.`email` AS `email` from `imported_users`;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `question_groups` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `assignment_users`
--
ALTER TABLE `assignment_users`
  ADD CONSTRAINT `assignment_users_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `question_groups`
--
ALTER TABLE `question_groups`
  ADD CONSTRAINT `question_groups_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;



--
-- Ограничения внешнего ключа таблицы `user_quizzes`
--
ALTER TABLE `user_quizzes`
  ADD CONSTRAINT `user_quizzes_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE;


--

--
-- Ограничения внешнего ключа таблицы `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD CONSTRAINT `user_ratings_ibfk_1` FOREIGN KEY (`rate_id`) REFERENCES `ratings` (`id`) ON DELETE CASCADE;
