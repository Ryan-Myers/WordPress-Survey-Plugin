<?php
/*
@require_once('../../../wp-config.php');
include 'survey.php';
survey_activation();
//*/

function survey_insert_quiz() {
global $wpdb;

$wpdb->query("INSERT INTO `" . $wpdb->prefix . "survey` (`id`, `name`, `questions`, `questionsperpage`) VALUES
(1, 'Consussion Survey', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,".
"33,34,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,".
"72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,".
"112,113,114,115,116,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,".
"147,148,149', 3)");

$wpdb->query("INSERT INTO `" . $wpdb->prefix . "survey_users` (`id`, `username`, `password`, `fullname`, `physician`, `is_physician`, `logged_in`) VALUES
(4, 'drtest', '���,������+�[v''�', 'Dr. Test', 0, 1, '2012-01-10 13:46:36'),
(7, 'dkrete', '{327��.A[%L<���g�sd', 'Derek Krete', 0, 1, '2012-01-10 13:46:56'),
(8, '1234567', '{327��.A[%L<���g�sd', 'Vince Ruttan', 7, 0, '2011-11-28 03:20:33'),
(9, '7654321', '�_�����:���[Q�G�*', 'Ryan Myers', 7, 0, '2011-12-15 02:23:21'),
(11, 'test', '�+�atUhJ�	��v�5]�', 'test', 7, 0, '2011-12-15 12:55:16')");

$wpdb->query("INSERT INTO `" . $wpdb->prefix . "survey_user_answers` (`user`, `question`, `answer`, `lastedited`) VALUES
(2, 1, '1', '2011-11-16 18:29:41'),
(2, 2, 'January', '2011-11-16 18:29:41'),
(2, 3, '', '2011-11-16 18:29:41'),
(2, 4, 'Right', '2011-11-16 18:29:43'),
(2, 5, 'Male', '2011-11-16 18:29:43'),
(2, 6, '', '2011-11-16 18:29:43'),
(2, 7, '', '2011-11-16 18:29:45'),
(2, 8, '', '2011-11-16 18:29:45'),
(2, 9, '', '2011-11-16 18:29:45'),
(5, 1, '1', '2011-11-16 18:32:58'),
(5, 2, 'January', '2011-11-16 18:32:58'),
(5, 3, '', '2011-11-16 18:32:58'),
(5, 4, 'Right', '2011-11-16 18:32:59'),
(5, 5, 'Male', '2011-11-16 18:32:59'),
(5, 6, '', '2011-11-16 18:32:59'),
(5, 7, '', '2011-11-16 18:33:02'),
(5, 8, '', '2011-11-16 18:33:02'),
(5, 9, 'Football', '2011-11-16 18:33:02'),
(8, 1, '8', '2011-11-16 18:47:58'),
(8, 2, 'April', '2011-11-16 18:47:58'),
(8, 3, '1968', '2011-11-16 18:47:58'),
(8, 4, 'Right', '2011-11-16 18:48:03'),
(8, 5, 'Male', '2011-11-16 18:48:03'),
(8, 6, '', '2011-11-16 18:48:03'),
(8, 7, '', '2011-11-16 18:48:05'),
(8, 8, '', '2011-11-16 18:48:05'),
(8, 9, 'Soccer', '2011-11-16 19:27:37'),
(8, 10, '', '2011-11-16 18:48:06'),
(8, 11, 'Practice', '2011-11-16 18:48:06'),
(8, 12, 'House League', '2011-11-16 18:48:21'),
(8, 13, '', '2011-11-16 19:26:01'),
(8, 14, 'Head struck when you unknowingly initiated contact with opponent', '2011-11-16 19:26:01'),
(8, 15, 'Back of head', '2011-11-16 19:26:01'),
(8, 16, 'Yes', '2011-11-16 19:26:01'),
(8, 17, 'Yes', '2011-11-16 19:26:01'),
(8, 18, 'Minutes ', '2011-11-16 19:26:01'),
(8, 19, 'Yes', '2011-11-16 19:26:03'),
(8, 20, 'Minutes ', '2011-11-16 19:26:03'),
(8, 21, 'Seconds ', '2011-11-16 19:26:03'),
(8, 22, 'Feeling in a Fog;; Confusion', '2011-11-16 19:26:13'),
(8, 23, 'Yes', '2011-11-16 19:26:13'),
(8, 24, 'I have not yet returned to activity since I got hurt', '2011-11-16 19:26:13'),
(8, 25, 'Visited ED within 24-72 hours post injury', '2011-11-16 19:27:49'),
(8, 26, '', '2011-11-16 19:26:16'),
(8, 27, 'Back', '2011-11-16 19:26:16'),
(8, 28, 'Yes', '2011-11-16 19:26:17'),
(8, 29, '', '2011-11-16 19:26:17'),
(8, 30, 'Yes', '2011-11-16 19:26:17'),
(8, 31, 'Yes', '2011-11-16 19:26:20'),
(8, 32, 'No', '2011-11-16 19:26:20'),
(8, 33, '', '2011-11-16 19:26:20'),
(8, 34, 'Yes', '2011-11-16 19:26:21'),
(8, 36, 'Yes', '2011-11-16 19:26:21'),
(8, 37, 'Yes', '2011-11-16 19:26:21'),
(8, 38, 'Yes', '2011-11-16 19:26:22'),
(8, 39, 'Yes', '2011-11-16 19:26:22'),
(8, 40, 'Front', '2011-11-16 19:26:22'),
(8, 41, 'School', '2011-11-16 19:26:23'),
(8, 42, 'Tylenol', '2011-11-16 19:26:23'),
(8, 43, 'Yes', '2011-11-16 19:26:23'),
(8, 44, 'Minutes', '2011-11-16 19:26:25'),
(8, 45, 'Yes', '2011-11-16 19:26:25'),
(8, 46, 'A small change from before I got hurt', '2011-11-16 19:26:25'),
(8, 47, '', '2011-11-16 19:26:32'),
(8, 48, '', '2011-11-16 19:26:32'),
(8, 49, 'Rugby', '2011-11-16 19:26:32'),
(8, 50, '', '2011-11-16 19:26:36'),
(8, 51, 'Hours', '2011-11-16 19:26:36'),
(8, 52, 'Minutes', '2011-11-16 19:26:36'),
(8, 53, 'Migraines;; Recurrent Headaches;; Vertigo and/or Dizziness;; Meningitis and/or Encephalitis;; Scoliosis;; �Burners/Stingers�;; Halatosis', '2011-11-16 19:30:55'),
(8, 54, '', '2011-11-16 19:26:53'),
(8, 55, '', '2011-11-16 19:26:53'),
(8, 56, '', '2011-11-17 18:27:36'),
(8, 57, '', '2011-11-17 18:27:36'),
(8, 58, '', '2011-11-17 18:27:36'),
(8, 59, '', '2011-11-17 18:27:37'),
(8, 60, 'No', '2011-11-17 18:27:37'),
(8, 61, 'No', '2011-11-17 18:27:37'),
(8, 62, 'No', '2011-11-17 18:27:38'),
(8, 63, 'No', '2011-11-17 18:27:38'),
(8, 64, 'No', '2011-11-17 18:27:38'),
(8, 65, '60-70%', '2011-11-17 18:27:39'),
(8, 66, 'No', '2011-11-17 18:27:39'),
(8, 67, 'No', '2011-11-17 18:27:39'),
(8, 68, 'No', '2011-11-17 18:27:39'),
(8, 69, '', '2011-11-17 18:27:39'),
(8, 70, 'No', '2011-11-17 18:27:39'),
(8, 71, 'Other', '2011-11-17 18:27:41'),
(8, 72, '', '2011-11-17 18:27:41'),
(8, 73, '', '2011-11-17 18:27:41'),
(11, 1, '1', '2011-12-15 12:48:11'),
(11, 2, 'January', '2011-12-15 12:48:11'),
(11, 3, '', '2011-12-15 12:48:11'),
(11, 4, 'Right', '2011-12-15 12:48:12'),
(11, 5, 'Male', '2011-12-15 12:48:12'),
(11, 6, '', '2011-12-15 12:48:12'),
(11, 7, '', '2011-12-15 12:48:15'),
(11, 8, '', '2011-12-15 12:48:15'),
(11, 9, '', '2011-12-15 12:48:15'),
(11, 10, '', '2011-12-15 12:48:18'),
(11, 11, 'Practice', '2011-12-15 12:48:18'),
(11, 12, 'Grade School', '2011-12-15 12:48:18'),
(11, 13, '', '2011-12-15 12:48:19'),
(11, 14, 'Head struck when you unknowingly initiated contact with opponent', '2011-12-15 12:48:19'),
(11, 15, 'Back of head', '2011-12-15 12:48:19'),
(11, 16, 'Yes', '2011-12-15 12:48:20'),
(11, 17, 'Yes', '2011-12-15 12:48:20'),
(11, 18, 'Minutes ', '2011-12-15 12:48:20'),
(11, 19, 'Yes', '2011-12-15 12:48:21'),
(11, 20, 'Minutes ', '2011-12-15 12:48:21'),
(11, 21, 'Seconds ', '2011-12-15 12:48:21'),
(11, 22, '', '2011-12-15 12:48:23'),
(11, 23, 'Yes', '2011-12-15 12:48:23'),
(11, 24, '', '2011-12-15 12:48:23'),
(11, 25, 'EMS were on site, evaluated me, but did not transport me to the ED', '2011-12-15 12:48:24'),
(11, 26, '', '2011-12-15 12:48:24'),
(11, 27, 'Neck', '2011-12-15 12:48:24'),
(11, 28, 'Yes', '2011-12-15 12:48:25'),
(11, 29, '', '2011-12-15 12:48:25'),
(11, 30, 'Yes', '2011-12-15 12:48:25'),
(11, 31, 'Yes', '2011-12-15 12:48:26'),
(11, 32, 'Yes', '2011-12-15 12:48:26'),
(11, 33, '', '2011-12-15 12:48:26'),
(11, 34, 'Yes', '2011-12-15 12:48:27'),
(11, 36, 'Yes', '2011-12-15 12:48:27'),
(11, 37, 'Yes', '2011-12-15 12:48:27'),
(11, 38, 'Yes', '2011-12-15 12:48:27'),
(11, 39, 'Yes', '2011-12-15 12:48:27'),
(11, 40, 'Front', '2011-12-15 12:48:27'),
(11, 41, 'School', '2011-12-15 12:48:28'),
(11, 42, 'Tylenol', '2011-12-15 12:48:28'),
(11, 43, 'Yes', '2011-12-15 12:48:28'),
(11, 44, 'Minutes', '2011-12-15 12:48:29'),
(11, 45, 'Yes', '2011-12-15 12:48:29'),
(11, 46, 'A big change from before I got hurt', '2011-12-15 12:48:29'),
(11, 47, '', '2011-12-15 12:48:30'),
(11, 48, '', '2011-12-15 12:48:30'),
(11, 49, '', '2011-12-15 12:48:31'),
(11, 50, '', '2011-12-15 12:48:32'),
(11, 51, 'Minutes', '2011-12-15 12:48:32'),
(11, 52, 'Minutes', '2011-12-15 12:48:32'),
(11, 53, '', '2011-12-15 12:48:34'),
(11, 54, '', '2011-12-15 12:48:34'),
(11, 55, '', '2011-12-15 12:48:34'),
(11, 56, '', '2011-12-15 12:48:37'),
(11, 57, '', '2011-12-15 12:48:37'),
(11, 58, '', '2011-12-15 12:48:37'),
(11, 59, '', '2011-12-15 12:48:39'),
(11, 60, 'No', '2011-12-15 12:48:39'),
(11, 61, 'No', '2011-12-15 12:48:39'),
(11, 62, 'No', '2011-12-15 12:48:40'),
(11, 63, 'No', '2011-12-15 12:48:40'),
(11, 64, 'No', '2011-12-15 12:48:40'),
(11, 65, '60-70%', '2011-12-15 12:48:41'),
(11, 66, 'No', '2011-12-15 12:48:41'),
(11, 67, 'No', '2011-12-15 12:48:41'),
(11, 68, 'No', '2011-12-15 12:48:42'),
(11, 69, '', '2011-12-15 12:48:42'),
(11, 70, 'No', '2011-12-15 12:48:42')");

$wpdb->query("INSERT INTO `" . $wpdb->prefix . "survey_answers` (`id`, `question`, `answer`, `ordernum`, `hidden`) VALUES
(1, 1, '1', 1, 0),
(2, 1, '2', 2, 0),
(3, 1, '3', 3, 0),
(4, 1, '4', 4, 0),
(5, 1, '5', 5, 0),
(6, 1, '6', 6, 0),
(7, 1, '7', 7, 0),
(8, 1, '8', 8, 0),
(9, 1, '9', 9, 0),
(10, 1, '10', 10, 0),
(11, 1, '11', 11, 0),
(12, 1, '12', 12, 0),
(13, 1, '13', 13, 0),
(14, 1, '14', 14, 0),
(15, 1, '15', 15, 0),
(16, 1, '16', 16, 0),
(17, 1, '17', 17, 0),
(18, 1, '18', 18, 0),
(19, 1, '19', 19, 0),
(20, 1, '20', 20, 0),
(21, 1, '21', 21, 0),
(22, 1, '22', 22, 0),
(23, 1, '23', 23, 0),
(24, 1, '24', 24, 0),
(25, 1, '25', 25, 0),
(26, 1, '26', 26, 0),
(27, 1, '27', 27, 0),
(28, 1, '28', 28, 0),
(29, 1, '29', 29, 0),
(30, 1, '30', 30, 0),
(31, 1, '31', 31, 0),
(32, 2, 'January', 1, 0),
(33, 2, 'February', 2, 0),
(34, 2, 'March', 3, 0),
(35, 2, 'April', 4, 0),
(36, 2, 'May', 5, 0),
(37, 2, 'June', 6, 0),
(38, 2, 'July', 7, 0),
(39, 2, 'August', 8, 0),
(40, 2, 'September', 9, 0),
(41, 2, 'October', 10, 0),
(42, 2, 'November', 11, 0),
(43, 2, 'December', 12, 0),
(44, 4, 'Right', 1, 0),
(45, 4, 'Left', 2, 0),
(46, 5, 'Male', 1, 0),
(47, 5, 'Female', 2, 0),
(48, 9, 'Hockey', 1, 0),
(49, 9, 'Football', 2, 0),
(50, 9, 'Rugby', 3, 0),
(51, 9, 'Soccer', 4, 0),
(52, 9, 'Lacrosse', 5, 0),
(53, 9, 'Baseball', 6, 0),
(54, 9, 'Basketball', 7, 0),
(55, 9, 'Wrestling', 8, 0),
(56, 9, 'Skiing', 9, 0),
(57, 9, 'Snowboarding', 10, 0),
(58, 9, 'Cheer/Gymnastics', 11, 0),
(59, 9, 'Martial Arts', 12, 0),
(60, 9, 'Field Hockey', 13, 0),
(61, 9, 'Skateboarding', 14, 0),
(78, 11, 'Practice', 1, 0),
(79, 11, 'Play time', 2, 0),
(80, 12, 'Grade School', 0, 0),
(81, 12, 'Rep', 0, 0),
(82, 12, 'House League', 0, 0),
(83, 12, 'Recreation', 0, 0),
(84, 14, 'Head struck when you unknowingly initiated contact with opponent', 0, 0),
(85, 14, 'Head struck when opponent knowingly initiated contact with you', 0, 0),
(86, 15, 'Back of head', 0, 0),
(87, 15, 'Side of head', 0, 0),
(88, 15, 'Face', 0, 0),
(89, 16, 'Yes', 0, 0),
(90, 16, 'No', 0, 0),
(91, 17, 'Yes', 0, 0),
(92, 17, 'No', 0, 0),
(94, 18, 'Minutes ', 0, 0),
(95, 18, 'Hours', 0, 0),
(96, 18, 'Days', 0, 0),
(97, 18, 'I don�t know', 0, 0),
(98, 19, 'Yes', 0, 0),
(99, 19, 'No', 0, 0),
(100, 20, 'Minutes ', 0, 0),
(101, 20, 'Hours', 0, 0),
(102, 20, 'Days', 0, 0),
(103, 21, 'Seconds ', 0, 0),
(104, 21, 'Minutes', 0, 0),
(105, 21, 'Hours', 0, 0),
(106, 21, 'Days', 0, 0),
(107, 22, 'Headache', 0, 0),
(108, 22, 'Neck Pain', 0, 0),
(109, 22, 'Nausea', 0, 0),
(110, 22, 'Vomiting', 0, 0),
(111, 22, 'Dizziness', 0, 0),
(112, 22, 'Blurred Vision', 0, 0),
(113, 22, 'Balance Problems', 0, 0),
(114, 22, 'Feeling in a Fog', 0, 0),
(115, 22, 'Confusion', 0, 0),
(116, 22, 'Drowsiness ', 0, 0),
(117, 22, 'Nervous/Anxious', 0, 0),
(118, 22, 'Scared', 0, 0),
(119, 23, 'Yes', 0, 0),
(120, 23, 'No', 0, 0),
(121, 24, 'I did not return to the same competition, but have returned to activity since I got hurt', 0, 0),
(122, 24, 'I have not yet returned to activity since I got hurt', 0, 0),
(123, 25, 'EMS were on site, evaluated me, but did not transport me to the ED', 0, 0),
(124, 25, 'No EMS were on site, I was transported to the ED by other/s during or immediately following competition', 0, 0),
(125, 25, 'Visited ED within 24-72 hours post injury', 0, 0),
(126, 25, 'Visited ED >72 hours post injury', 0, 0),
(127, 25, 'Visited other health care practitioner prior to this visit', 0, 0),
(128, 25, 'None of the above', 0, 0),
(129, 26, 'None', 0, 0),
(130, 26, 'Xray', 0, 0),
(131, 26, 'CT Scan', 0, 0),
(132, 26, 'MRI', 0, 0),
(133, 27, 'Neck', 0, 0),
(134, 27, 'Back', 0, 0),
(135, 27, 'Arms', 0, 0),
(136, 27, 'Legs', 0, 0),
(137, 27, 'None', 0, 0),
(138, 28, 'Yes', 0, 0),
(139, 28, 'No', 0, 0),
(140, 29, '1', 0, 0),
(141, 30, 'Yes', 0, 0),
(142, 30, 'No', 0, 0),
(143, 31, 'Yes', 0, 0),
(144, 31, 'No', 0, 0),
(145, 32, 'Yes', 0, 0),
(146, 32, 'No', 0, 0),
(147, 32, ' I don�t know yet', 0, 0),
(148, 33, '1', 0, 0),
(149, 34, 'Yes', 0, 0),
(150, 34, 'No', 0, 0),
(152, 35, 'No', 0, 0),
(153, 36, 'Yes', 1, 0),
(154, 36, 'No', 2, 0),
(155, 37, 'Yes', 0, 0),
(156, 37, 'No', 0, 0),
(157, 38, 'Yes', 0, 0),
(158, 38, 'No', 0, 0),
(159, 39, 'Yes', 0, 0),
(160, 39, 'No', 0, 0),
(161, 40, 'Front', 0, 0),
(162, 40, 'One Side', 0, 0),
(163, 40, 'Both Sides', 0, 0),
(164, 40, 'Back of head', 0, 0),
(165, 41, 'School', 0, 0),
(166, 41, 'Screens', 0, 0),
(167, 41, 'Activity', 0, 0),
(168, 41, 'Stress', 0, 0),
(169, 42, 'Tylenol', 0, 0),
(170, 42, 'Advil', 0, 0),
(171, 42, 'Rest / Quiet', 0, 0),
(172, 42, 'Nothing', 0, 0),
(173, 43, 'Yes', 0, 0),
(174, 43, 'No', 0, 0),
(175, 44, 'Minutes', 0, 0),
(176, 44, 'Hours', 0, 0),
(177, 44, 'Days', 0, 0),
(178, 45, 'Yes', 0, 0),
(179, 45, 'No', 0, 0),
(180, 46, 'A big change from before I got hurt', 0, 0),
(181, 46, 'A small change from before I got hurt', 0, 0),
(182, 46, 'No change from before I got hurt�I always feel this way', 0, 0),
(183, 46, 'I don�t know', 0, 0),
(184, 47, '1', 0, 0),
(185, 48, '1', 0, 0),
(186, 49, 'Football', 1, 0),
(187, 49, 'Wrestling', 2, 0),
(188, 49, 'Rugby', 3, 0),
(189, 49, 'Soccer', 4, 0),
(190, 49, 'Lacrosse', 5, 0),
(191, 49, 'Baseball', 6, 0),
(192, 49, 'Wrestling', 7, 0),
(193, 49, 'Skiing', 8, 0),
(194, 49, 'Snowboarding', 9, 0),
(195, 49, 'Cheer/Gymnastics', 10, 0),
(196, 49, 'Field Hockey', 11, 0),
(197, 49, 'Skateboarding', 12, 0),
(198, 50, '0', 0, 0),
(199, 51, 'Minutes', 1, 0),
(200, 52, 'Minutes', 1, 0),
(201, 53, 'Attention Deficit Disorder and/or Hyperactivity', 0, 0),
(202, 54, '0', 0, 0),
(203, 55, '0', 0, 0),
(204, 56, 'Concussions', 0, 0),
(205, 57, 'Live Alone', 0, 0),
(206, 58, '0', 0, 0),
(207, 59, 'Kenner', 0, 0),
(208, 60, 'Yes', 0, 0),
(209, 61, 'Yes', 0, 0),
(210, 62, 'Yes', 0, 0),
(211, 63, 'Yes', 0, 0),
(212, 64, 'Yes', 0, 0),
(213, 65, '<60%', 0, 0),
(214, 66, 'Yes', 0, 0),
(215, 67, 'Yes', 0, 0),
(216, 68, 'Yes', 0, 0),
(217, 69, '0', 0, 0),
(218, 70, 'Yes', 0, 0),
(219, 71, 'NAD', 0, 0),
(220, 72, 'NAD', 0, 0),
(221, 73, 'Alert/Appropriate', 0, 0),
(222, 74, 'No palpable tenderness', 0, 0),
(223, 75, '0', 0, 0),
(224, 76, 'Intact', 0, 0),
(225, 77, 'Equal/Reactive', 0, 0),
(226, 78, 'Intact', 0, 0),
(227, 79, 'Intact', 0, 0),
(228, 80, 'Intact', 0, 0),
(229, 81, 'Yes', 0, 0),
(230, 82, 'None', 0, 0),
(231, 83, 'Intact', 0, 0),
(232, 84, 'Intact', 0, 0),
(233, 85, 'Intact', 0, 0),
(234, 86, 'Heel: Intact', 0, 0),
(235, 87, 'Eyes open: Intact', 0, 0),
(236, 88, '0', 0, 0),
(237, 89, 'Eyes open: Intact', 0, 0),
(238, 90, 'Eyes open: Intact', 0, 0),
(245, 97, '0', 0, 0),
(246, 98, '0', 0, 0),
(247, 99, '0', 0, 0),
(248, 100, '0', 0, 0),
(249, 101, '0', 0, 0),
(250, 102, '0', 0, 0),
(251, 103, '0', 0, 0),
(252, 104, '0', 0, 0),
(253, 105, '0', 0, 0),
(254, 106, '0', 0, 0),
(255, 107, '0', 0, 0),
(256, 108, '0', 0, 0),
(257, 109, '0', 0, 0),
(258, 110, '0', 0, 0),
(259, 111, '0', 0, 0),
(260, 112, '0', 0, 0),
(261, 113, '0', 0, 0),
(262, 114, '0', 0, 0),
(263, 115, '0', 0, 0),
(264, 116, '0', 0, 0),
(271, 123, '0', 0, 0),
(272, 124, '0', 0, 0),
(273, 125, '0', 0, 0),
(274, 126, '0', 0, 0),
(275, 127, '0', 0, 0),
(276, 128, '0', 0, 0),
(277, 129, '0', 0, 0),
(278, 130, '0', 0, 0),
(279, 131, '0', 0, 0),
(280, 132, '0', 0, 0),
(281, 133, '0', 0, 0),
(282, 134, '0', 0, 0),
(283, 135, '0', 0, 0),
(284, 136, '0', 0, 0),
(285, 137, '0', 0, 0),
(286, 138, '0', 0, 0),
(287, 139, '0', 0, 0),
(288, 140, '0', 0, 0),
(289, 141, '0', 0, 0),
(290, 142, '0', 0, 0),
(291, 143, '0', 0, 0),
(292, 144, '0', 0, 0),
(293, 145, '0', 0, 0),
(294, 146, '0', 0, 0),
(295, 147, '0', 0, 0),
(296, 148, '0', 0, 0),
(297, 149, '0', 0, 0),
(300, 51, 'Hours', 2, 0),
(301, 51, 'Days', 3, 0),
(302, 51, 'Months', 4, 0),
(303, 52, 'Hours', 2, 0),
(304, 52, 'Days', 3, 0),
(305, 52, 'Months', 4, 0),
(306, 53, 'Depression', 0, 0),
(307, 53, 'Anxiety', 0, 0),
(308, 53, 'Seizure Disorder and/or Epilepsy', 0, 0),
(309, 53, 'Migraines', 0, 0),
(310, 53, 'Recurrent Headaches', 0, 0),
(311, 53, 'Vertigo and/or Dizziness', 0, 0),
(312, 53, 'Meningitis and/or Encephalitis', 0, 0),
(313, 53, 'Scoliosis', 0, 0),
(314, 53, '�Burners/Stingers�', 0, 0),
(315, 53, 'Transient Quadriparesis', 0, 0),
(316, 53, 'Intracranial surgery', 0, 0),
(317, 53, 'Orthopedic surgery', 0, 0),
(318, 53, 'Visual Deficits and/or ocular surgery', 0, 0),
(319, 53, 'Eye Glasses', 0, 0),
(320, 56, 'Migraines', 0, 0),
(321, 56, 'Attention Deficit Disorder', 0, 0),
(322, 56, 'Substance Abuse', 0, 0),
(323, 56, 'Depression', 0, 0),
(324, 56, 'Anxiety', 0, 0),
(325, 56, 'Alzheimer�s Dementia', 0, 0),
(326, 56, 'Parkinson�s or Parkinson�s Like Syndrome', 0, 0),
(327, 57, 'Live with parents', 0, 0),
(328, 57, 'Live with guardians', 0, 0),
(329, 60, 'No', 0, 0),
(330, 61, 'No', 0, 0),
(331, 62, 'No', 0, 0),
(332, 63, 'No', 0, 0),
(333, 64, 'No', 0, 0),
(334, 65, '60-70%', 0, 0),
(335, 65, '70-80%', 0, 0),
(336, 65, '80-90%', 0, 0),
(337, 65, '90-100%', 0, 0),
(338, 66, 'No', 0, 0),
(339, 67, 'No', 0, 0),
(340, 68, 'No', 0, 0),
(341, 70, 'No', 0, 0),
(342, 71, 'Other', 0, 0),
(343, 72, 'Other and describe', 0, 0),
(344, 73, 'Other and describe', 0, 0),
(345, 74, 'Tender to palpation', 0, 0),
(347, 76, 'Other and describe', 0, 0),
(348, 77, 'Other and describe', 0, 0),
(349, 78, 'Other and describe', 0, 0),
(350, 79, 'Other and describe', 0, 0),
(351, 80, 'Other and describe', 0, 0),
(352, 81, 'No', 0, 0),
(353, 82, 'Present', 0, 0),
(354, 83, 'Not Intact', 0, 0),
(355, 84, 'Not Intact', 0, 0),
(356, 85, 'Not Intact', 0, 0),
(357, 86, 'Heel: Not Intact', 0, 0),
(358, 86, 'Toe: Intact', 0, 0),
(359, 86, 'Toe: Not Intact', 0, 0),
(360, 86, 'Tandem: Intact', 0, 0),
(361, 86, 'Tandem: Not Intact', 0, 0),
(362, 87, 'Eyes open: Not Intact', 0, 0),
(363, 87, 'Eyes closed: Intact', 0, 0),
(364, 87, 'Eyes closed: Not Intact', 0, 0),
(365, 89, 'Eyes open: Not Intact', 0, 0),
(366, 89, 'Eyes closed: Intact', 0, 0),
(367, 89, 'Eyes closed: Not Intact', 0, 0),
(368, 90, 'Eyes open: Not Intact', 0, 0),
(369, 90, 'Eyes closed: Intact', 0, 0),
(370, 90, 'Eyes closed: Not Intact', 0, 0),
(371, 150, 'PCVS', 1, 0),
(372, 150, 'Kenner', 2, 0),
(373, 150, 'Thomas A Steward', 3, 0),
(374, 150, '', 4, 0),
(375, 59, 'Thomas A Steward', 1, 0),
(376, 59, '', 2, 0)");

$wpdb->query("INSERT INTO `" . $wpdb->prefix . "survey_questions` (`id`, `question`, `questiontype`, `ordernum`, `dependentquestion`, `dependentanswer`, `physician`, `hidden`) VALUES
(1, 'Date of Birth - Day', 2, 1, -1, 0, 0, 0),
(2, 'Date of Birth - Month', 2, 2, -1, 0, 0, 0),
(3, 'Date of Birth - Year', 5, 3, -1, 0, 0, 0),
(4, 'What is your dominant hand?', 2, 4, -1, 0, 0, 0),
(5, 'What is your gender?', 2, 5, -1, 0, 0, 0),
(6, 'Height Units', 5, 6, -1, 0, 0, 0),
(7, 'Weight', 5, 7, -1, 0, 0, 0),
(8, 'When did you suffer your last concussion?', 5, 8, -1, 0, 0, 0),
(9, 'What were you playing?', 7, 9, -1, 0, 0, 0),
(10, 'What position were you playing? (If Applicable)', 5, 10, -1, 0, 0, 0),
(11, 'What was type of competition?', 2, 11, -1, 0, 0, 0),
(12, 'What was the level of competition?', 2, 12, -1, 0, 0, 0),
(13, 'How long had you been playing when you got hurt?', 5, 13, -1, 0, 0, 0),
(14, 'How did you get hurt? ', 2, 14, -1, 0, 0, 0),
(15, 'Where did you get hit? ', 2, 15, -1, 0, 0, 0),
(16, 'Were you wearing a helmet?', 2, 16, -1, 0, 0, 0),
(17, 'Were you knocked out?', 2, 17, -1, 0, 0, 0),
(18, 'If so, for how long were you knocked out?', 2, 18, -1, 0, 0, 0),
(19, 'Did you have any memory loss?', 2, 19, -1, 0, 0, 0),
(20, 'How much time passed before your first real memory after you got hurt?', 2, 20, -1, 0, 0, 0),
(21, 'How much time passed after your last real memory until you got hurt?', 2, 21, -1, 0, 0, 0),
(22, 'How did you feel right after you got hurt? (more than one may apply)', 8, 22, -1, 0, 0, 0),
(23, 'Are you still having feeling any symptoms since you got hurt?', 2, 23, -1, 0, 0, 0),
(24, 'When did you next return to play (more than one may apply)?', 8, 24, -1, 0, 0, 0),
(25, 'How was your injury managed right after you got hurt?  (more than one may apply)?', 2, 25, -1, 0, 0, 0),
(26, 'Have you had any imaging? (more than one may apply)', 7, 26, -1, 0, 0, 0),
(27, 'Did you suffer any other injuries when you got hurt?', 2, 27, -1, 0, 0, 0),
(28, 'Do you feel that you are getting better overall?', 2, 28, -1, 0, 0, 0),
(29, 'If yes, what percent improvement do you feel you have had overall since you were at your worst?', 5, 29, -1, 0, 0, 0),
(30, 'Do you feel you are �ready� to return to play now?  ', 2, 30, -1, 0, 0, 0),
(31, 'Would you like to return to play now?', 2, 31, -1, 0, 0, 0),
(32, 'Has your school performance suffered since your concussion?', 2, 32, -1, 0, 0, 0),
(33, 'Total hours of sleep last night ', 5, 33, -1, 0, 0, 0),
(34, 'Are you having headaches due to your concussion?', 2, 34, -1, 0, 0, 0),
(36, 'Is your headache constant', 2, 35, -1, 0, 0, 0),
(37, 'Do you have headaches each day ', 2, 36, -1, 0, 0, 0),
(38, 'Do you wake up with a headache', 2, 37, -1, 0, 0, 0),
(39, 'Does your headache worsen throughout the day', 2, 38, -1, 0, 0, 0),
(40, 'Where is headache typically located?', 2, 39, -1, 0, 0, 0),
(41, 'What one thing seems to worsen or trigger your headaches?', 2, 40, -1, 0, 0, 0),
(42, 'What makes your headache better?', 2, 41, -1, 0, 0, 0),
(43, 'Do you experience aura (lights/flashing vision) prior to your headache?', 2, 42, -1, 0, 0, 0),
(44, 'How long do your headaches typically last?', 2, 43, -1, 0, 0, 0),
(45, 'Do your headaches limit your ability to concentrate or do schoolwork?', 2, 44, -1, 0, 0, 0),
(46, 'Indicate if the symptoms you reported are:', 2, 45, -1, 0, 0, 0),
(47, 'When was the last time you had a concussion before this last injury? ', 5, 46, -1, 0, 0, 0),
(48, 'How many times have you been knocked out?', 5, 47, -1, 0, 0, 0),
(49, 'What were you playing when you had concussions? ', 8, 48, -1, 0, 0, 0),
(50, 'How many  games have you missed in past due to concussions?', 5, 49, -1, 0, 0, 0),
(51, 'What is the shortest time it has taken you to recover from a concussion?', 2, 50, -1, 0, 0, 0),
(52, 'What is the longest time it has taken you to recover from a concussion?', 2, 51, -1, 0, 0, 0),
(53, 'Past Medical and Surgical History', 8, 52, -1, -1, 0, 0),
(54, 'Medications', 6, 53, -1, 0, 0, 0),
(55, 'Allergies', 6, 54, -1, 0, 0, 0),
(56, 'Family History', 8, 55, -1, 0, 0, 0),
(57, 'What is your living arrangement?', 7, 56, -1, 0, 0, 0),
(58, 'Which grade are you in?', 5, 57, -1, 0, 0, 0),
(59, 'Which school do you attend?', 2, 58, -1, -1, 0, 0),
(60, 'Do you like school?', 2, 59, -1, 0, 0, 0),
(61, 'Do you or have you ever had an IED?', 2, 60, -1, 0, 0, 0),
(62, 'Do you have a diagnosed learning disability?', 2, 61, -1, 0, 0, 0),
(63, 'Have you ever received speech therapy?', 2, 62, -1, 0, 0, 0),
(64, 'Have you ever attended special education classes?', 2, 63, -1, 0, 0, 0),
(65, 'What is your previous average school performance?', 2, 64, -1, 0, 0, 0),
(66, 'Do you smoke?', 2, 65, -1, 0, 0, 0),
(67, 'Do you drink alcohol?', 2, 66, -1, 0, 0, 0),
(68, 'Any history of past or present substance abuse? ', 2, 67, -1, 0, 0, 0),
(69, 'If so, please indicate form', 5, 68, -1, 0, 0, 0),
(70, 'Is there any history of physical or emotional abuse? ', 2, 69, -1, 0, 0, 0),
(71, 'General: Constitutional', 2, 70, -1, 0, 1, 0),
(72, 'Constitutional ', 7, 71, -1, 0, 1, 0),
(73, 'Psychiatric', 7, 72, -1, 0, 1, 0),
(74, 'C-Spine: Unrestricted pain free range of motion', 2, 73, -1, 0, 1, 0),
(75, 'General Neurological', 5, 74, -1, 0, 1, 0),
(76, 'Cranial Nerves II-XII', 2, 75, -1, 0, 1, 0),
(77, 'Pupils ', 2, 76, -1, 0, 1, 0),
(78, 'Motor', 2, 77, -1, 0, 1, 0),
(79, 'Sensory', 2, 78, -1, 0, 1, 0),
(80, 'Reflexes', 2, 79, -1, 0, 1, 0),
(81, 'Upper motor Neuron Signs', 2, 80, -1, 0, 1, 0),
(82, 'Palmomental Sign', 2, 81, -1, 0, 1, 0),
(83, 'Coordination: Heel to Shin', 2, 82, -1, 0, 1, 0),
(84, 'Finger to Nose', 2, 83, -1, 0, 1, 0),
(85, 'Rapid Alternating Movements', 2, 84, -1, 0, 1, 0),
(86, 'Gait', 2, 85, -1, 0, 1, 0),
(87, 'Balance Screen: Feet together sold surface', 2, 86, -1, 0, 1, 0),
(88, 'Comments', 5, 87, -1, 0, 1, 0),
(89, 'Feet together foam surface', 2, 88, -1, 0, 1, 0),
(90, 'Tandem Stance', 2, 89, -1, 0, 1, 0),
(97, 'Ocular Motor/Vestibulo-Ocular Screen', 5, 90, -1, 0, 1, 0),
(98, 'Pursuit Movements', 5, 91, -1, 0, 1, 0),
(99, 'H test', 5, 92, -1, 0, 1, 0),
(100, 'Saccades', 5, 93, -1, 0, 1, 0),
(101, 'Vestibulo-Ocular Reflex', 5, 94, -1, 0, 1, 0),
(102, 'Convergence', 5, 95, -1, 0, 1, 0),
(103, 'INVESTIGATIONS: XRAYS', 5, 96, -1, 0, 1, 0),
(104, 'CT', 5, 97, -1, 0, 1, 0),
(105, 'MRI', 5, 98, -1, 0, 1, 0),
(106, 'Computer based Cognitive Assessment', 5, 99, -1, 0, 1, 0),
(107, 'Pre-Injury Testing', 5, 100, -1, 0, 1, 0),
(108, 'Post-Injury Testing', 5, 101, -1, 0, 1, 0),
(109, 'DIAGNOSIS', 5, 102, -1, 0, 1, 0),
(110, 'Prognosis is:', 5, 103, -1, 0, 1, 0),
(111, 'Recommendations:', 5, 104, -1, 0, 1, 0),
(112, 'Return to play:', 5, 105, -1, 0, 1, 0),
(113, 'Activity restrictions:', 5, 106, -1, 0, 1, 0),
(114, 'Academic restrictions:', 5, 107, -1, 0, 1, 0),
(115, 'Rehabilitation Referral:', 5, 108, -1, 0, 1, 0),
(116, 'Specialist Referral:', 5, 109, -1, 0, 1, 0),
(123, 'Do you feel that you are getting better overall?', 5, 110, -1, 0, 1, 0),
(124, 'If yes, what percent improvement do you feel you have had overall since you were at your worst?   ', 5, 111, -1, 0, 1, 0),
(125, 'Do you feel you are �ready� to return to play now?  ', 5, 112, -1, 0, 1, 0),
(126, 'Would you like to return to play now?', 5, 113, -1, 0, 1, 0),
(127, 'Has your school performance suffered since your concussion? ', 5, 114, -1, 0, 1, 0),
(128, 'Are you currently experiencing symptoms due to your concussion?', 5, 115, -1, 0, 1, 0),
(129, 'Total hours of sleep last night ', 5, 116, -1, 0, 1, 0),
(130, 'What is your current activity level?', 5, 117, -1, 0, 1, 0),
(131, 'Have you attempted to return to your sport at a competitive level?', 5, 118, -1, 0, 1, 0),
(132, 'If so, have you tolerated your sport without worsened symptoms?', 5, 119, -1, 0, 1, 0),
(133, 'Any new medications or medication changes since the last visit?', 5, 120, -1, 0, 1, 0),
(134, 'Any specific treatments since last visit?', 5, 121, -1, 0, 1, 0),
(135, 'Have any of these treatments be helpful?', 5, 122, -1, 0, 1, 0),
(136, 'If so, which has helped?', 5, 123, -1, 0, 1, 0),
(137, 'Current Symptoms/most prevalent current symptom *refer to symptom inventory', 5, 124, -1, 0, 1, 0),
(138, 'PHYSICAL EXAMINATION', 5, 125, -1, 0, 1, 0),
(139, 'Balance Screen (as above)', 5, 126, -1, 0, 1, 0),
(140, 'Ocular Motor/Vestibulo-Ocular Screen', 5, 127, -1, 0, 1, 0),
(141, 'DIAGNOSIS', 5, 128, -1, 0, 1, 0),
(142, 'Prognosis is:', 5, 129, -1, 0, 1, 0),
(143, 'Recommendations:', 5, 130, -1, 0, 1, 0),
(144, 'Return to play:', 5, 131, -1, 0, 1, 0),
(145, 'Activity restrictions:', 5, 132, -1, 0, 1, 0),
(146, 'Academic restrictions:', 5, 133, -1, 0, 1, 0),
(147, 'Rehabilitation Referral:', 5, 134, -1, 0, 1, 0),
(148, 'Specialist Referral:', 5, 135, -1, 0, 1, 0),
(149, 'Imaging:', 5, 136, -1, 0, 1, 0),
(150, 'What school do you attend', 2, 1, -1, -1, 0, 0)");
}