USE phpquiz_free;

--
-- Изменить таблицу assignments
--
ALTER TABLE assignments
        ADD COLUMN allow_review INT(11) NOT NULL DEFAULT 2 AFTER status,
        ADD COLUMN qst_order INT(11) NOT NULL DEFAULT 1 AFTER allow_review,
        ADD COLUMN answer_order INT(11) NOT NULL DEFAULT 1 AFTER qst_order,
        ADD COLUMN affect_changes INT(11) NOT NULL AFTER answer_order,
        ADD COLUMN limited INT(11) NOT NULL AFTER affect_changes,
        ADD COLUMN send_results INT(11) NOT NULL AFTER limited,
        ADD COLUMN accept_new_users INT(11) NOT NULL AFTER send_results;

--
-- Создать таблицу email_templates
--
CREATE TABLE email_templates(
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL,
  vars VARCHAR(300) DEFAULT NULL,
  body TEXT DEFAULT NULL,
  subject VARCHAR(200) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = MYISAM
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Изменить таблицу imported_users
--
ALTER TABLE imported_users
        ADD COLUMN email VARCHAR(150) NOT NULL AFTER `password`;

--
-- Создать таблицу mailed_users
--
CREATE TABLE mailed_users(
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  user_type INT(11) NOT NULL,
  assignment_id INT(11) NOT NULL,
  mail_type INT(11) NOT NULL,
  user_quiz_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  INDEX mailed_users_ibfk_1 (assignment_id)
)
ENGINE = MYISAM
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Создать таблицу pages
--
CREATE TABLE pages(
  id INT(11) NOT NULL AUTO_INCREMENT,
  page_name VARCHAR(800) NOT NULL,
  page_content TEXT NOT NULL,
  priority INT(11) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = MYISAM
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Создать таблицу rating_temps
--
CREATE TABLE rating_temps(
  id INT(11) NOT NULL AUTO_INCREMENT,
  temp_name VARCHAR(255) NOT NULL DEFAULT '',
  active_img VARCHAR(255) NOT NULL DEFAULT '',
  inactive_img VARCHAR(255) NOT NULL DEFAULT '',
  half_active_img VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Создать таблицу ratings
--
CREATE TABLE ratings(
  id INT(11) NOT NULL AUTO_INCREMENT,
  description VARCHAR(455) NOT NULL DEFAULT '',
  temp_id INT(11) NOT NULL DEFAULT 0,
  header_text VARCHAR(555) NOT NULL DEFAULT '',
  footer_text VARCHAR(555) NOT NULL DEFAULT '',
  img_count INT(11) NOT NULL DEFAULT 0,
  show_results INT(11) NOT NULL DEFAULT 0,
  restrict_user INT(11) NOT NULL DEFAULT 0,
  bgcolor VARCHAR(255) NOT NULL DEFAULT '',
  added_date DATETIME DEFAULT NULL,
  status INT(11) NOT NULL DEFAULT 1,
  lang VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Изменить таблицу user_answers
--
ALTER TABLE user_answers
        ADD INDEX user_answers_ibfk_1 (user_quiz_id);

--
-- Изменить таблицу users
--
ALTER TABLE users
        ADD COLUMN address VARCHAR(200) NOT NULL AFTER email,
        ADD COLUMN phone VARCHAR(50) NOT NULL AFTER address,
        ADD COLUMN random_str VARCHAR(100) DEFAULT NULL AFTER phone,
        ADD COLUMN approved INT(11) NOT NULL AFTER random_str,
        ADD COLUMN disabled INT(11) NOT NULL AFTER approved;

--
-- Изменить таблицу questions
--


ALTER TABLE questions
        DROP FOREIGN KEY questions_ibfk_1;

ALTER TABLE questions
        ADD CONSTRAINT questions_ibfk_1 FOREIGN KEY (quiz_id)
        REFERENCES quizzes (id) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Изменить таблицу user_quizzes
--
ALTER TABLE user_quizzes
        ADD COLUMN archived INT(11) NOT NULL AFTER pass_score_perc;

--
-- Создать таблицу user_ratings
--
CREATE TABLE user_ratings(
  id INT(11) NOT NULL AUTO_INCREMENT,
  rate_id INT(11) NOT NULL DEFAULT 0,
  product_id VARCHAR(1255) NOT NULL DEFAULT '',
  `point` INT(11) NOT NULL DEFAULT 0,
  ip_address VARCHAR(255) NOT NULL DEFAULT '',
  user_id INT(11) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT user_ratings_ibfk_1 FOREIGN KEY (rate_id)
  REFERENCES ratings (id) ON DELETE CASCADE ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Изменить представление v_imported_users
--
CREATE OR REPLACE
VIEW v_imported_users
AS
SELECT `imported_users`.`id` AS `UserID`
     , `imported_users`.`name` AS `Name`
     , `imported_users`.`surname` AS `Surname`
     , `imported_users`.`user_name` AS `UserName`
     , `imported_users`.`password` AS `Password`
     , `imported_users`.`email` AS `email`
FROM
  `imported_users`;

delete from modules;
delete from roles_rights ;


INSERT INTO `ratings` (`id`, `description`, `temp_id`, `header_text`, `footer_text`, `img_count`, `show_results`, `restrict_user`, `bgcolor`, `added_date`, `status`, `lang`) VALUES
(26, 'rating 1', 6, '', '', 5, 1, 1, '-1', '2011-12-20 12:23:00', 1, 'English'),
(31, 'rating 2', 3, '', '', 5, 1, 2, '-1', '2011-12-20 12:23:19', 1, 'English'),
(32, 'rating 3', 2, '', '', 5, 1, 1, '-1', '2011-12-20 12:23:31', 1, 'English');

INSERT INTO `rating_temps` (`id`, `temp_name`, `active_img`, `inactive_img`, `half_active_img`) VALUES
(1, 'Star1', '1.gif', '1_n.gif', '1_h.gif'),
(2, 'Star1', '7.gif', '7_n.gif', '7_h.gif'),
(3, 'Star2', '2.gif', '2_n.gif', '2_h.gif'),
(4, 'Star3', '3.gif', '3_n.gif', '3_h.gif'),
(5, 'Star4', '4.gif', '4_n.gif', '4_h.gif'),
(6, 'Star5', '5.gif', '5_n.gif', '5_h.gif'),
(7, 'Star6', '6.gif', '6_n.gif', '6_h.gif'),
(8, 'Star7', '8.gif', '8_n.gif', '8_h.gif');
 

--

INSERT INTO `modules` (`id`, `module_name`, `file_name`, `parent_id`, `priority`) VALUES
(1, 'Quizzes', NULL, 0, '1'),
(2, 'Categories', 'cats', 1, '1'),
(3, 'Quizzes', 'quizzes', 1, '2'),
(4, 'Local users', 'local_users', 13, '4'),
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
(22, 'Email templates', 'email_templates', 21, '0'),
(23, 'Content management', 'cms', 21, '1'),
(24, 'SQL Queries', 'sql_queries', 21, '2'),
(25, 'Test mail', 'test_mail', 21, '3'),
(26, 'Imported users', 'imported_users', 13, '5');

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

INSERT INTO `email_templates` (`id`, `name`, `vars`, `body`, `subject`) VALUES
(1, 'register_user', '[UserName],[Name],[Surname],[email], [address], [phone], [url]', 'Dear [Name] [Surname] , \n\nYou have registered in our system . Here is the details of registration\n\nName : [Name] \nSurname  : [Surname]\nLogin : [UserName]\nAddress : [address]\nPhone : [phone]\nEmail : [email]\n\nTo approve your registration in our Quiz system , please open below link \n\n[url]\n\nThanks', 'Registration in Quiz System'),
(2, 'forgot_password', '[UserName],[Name],[Surname],[email],[address],[phone],[url],[random_password]', 'Dear [Name] [Surname] ,\n\nYou password has been reseted , please find your password below .\n\nLogin : [UserName]\nPassword : [random_password]\nEmail : [email]\n\nThanks', 'Restoring the password'),
(3, 'quiz_start_message', '[UserName],[Name],[Surname],[email],[address], [phone],[url],[quiz_name]', 'Dear [Name] [Surname] , \n\nThe below listed exam has been started . \n\nQuiz name : [quiz_name]\nName : [Name] \nSurname  : [Surname]\nLogin : [UserName]\n\nTo join to exam please , use below link\n\n[url]\n\nThanks', 'Online exam started'),
(4, 'quiz_results_success', '[UserName],[Name],[Surname],[email],[url],[quiz_name],[start_date],[finish_date],[pass_score],[user_score]', 'Dear [Name] [Surname] ,\n\nYou passed exam successfully . \n\nQuiz name : [quiz_name]\nStart date : [start_date]\nFinish date : [finish_date]\nPass score : [pass_score]\nYour score : [user_score]\n\nThanks,\nAdministrator', 'You passed exam succesfully'),
(5, 'quiz_results_not_success', '[UserName],[Name],[Surname],[email],[url],[quiz_name],[start_date],[finish_date],[pass_score],[user_score]', 'Dear [Name] [Surname] ,\n\nSorry , you didn''t pass exam succesfully . \n\nQuiz name : [quiz_name]\nStart date : [start_date]\nFinish date : [finish_date]\nPass score : [pass_score]\nYour score : [user_score]\n\nThanks,\nAdministrator', 'Sorry , you didn''t pass exam succesfully');


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

update users set approved = 1;