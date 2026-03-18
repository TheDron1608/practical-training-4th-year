-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 18 2026 г., 11:56
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kadi_educational_institution`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 7, 1772793615),
('curator', 5, 1772017894),
('curator', 15, 1773228665),
('teacher', 8, 1773138658),
('teacher', 10, 1773139019),
('teacher', 11, 1773139153),
('teacher', 12, 1773139298),
('teacher', 13, 1773139394),
('user', 1, 1672963122),
('user', 14, 1773148894),
('user', 16, 1773822880);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администратор', NULL, NULL, 1672960006, 1672960006),
('curator', 1, 'Куратор', NULL, NULL, NULL, NULL),
('teacher', 1, 'Преподаватель', NULL, NULL, 1672960125, 1672960125),
('user', 1, 'Пользователь', NULL, NULL, 1672960094, 1672960094);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `core_files`
--

CREATE TABLE `core_files` (
  `id` int NOT NULL,
  `file_user_id` int NOT NULL COMMENT 'Кто создал.',
  `file_folder_id` int DEFAULT NULL COMMENT 'Id папки в которой находиться файл.',
  `file_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Имя файла.',
  `file_patch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Путь к файлу.',
  `file_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Зашифрованный путь к файлу.',
  `file_comment` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Комментарий к файлу.',
  `file_extension` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Расширение файла.',
  `file_size` int NOT NULL COMMENT 'Размер файла.',
  `file_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Код файла (Пример: Аватар).',
  `status` set('active','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `core_files`
--

INSERT INTO `core_files` (`id`, `file_user_id`, `file_folder_id`, `file_title`, `file_patch`, `file_hash`, `file_comment`, `file_extension`, `file_size`, `file_code`, `status`, `created_at`) VALUES
(1, 1, NULL, '961549865-abstract-PqB2-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-26/80642044d5e221b.jpg', '6X1jUjA3R_I2fqKy-Z5KyjhOqp1SZ5W6Qc-v9UAXSwFnUo7a30nybrD57QXz2XivXSV53Uh810MWcJL7S66j-6gUDLbVM14-oKaxBJMyKQeW4YbUH7_1b760AbZ3YQ2R', NULL, 'jpg', 820934, 'filehub', 'active', 1679836373),
(2, 1, NULL, '1869545681-fallout-5K0x-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-26/8064204523bf1b6.jpg', 'vtLh4hX0z-zv96d7iN-iS86dOgv8thKUqN2-4Uj8yXwsh1Z6EiyTdX5kziHDfprbAGzXTOQ81Ly1dwY52dSzvl_GEAqAMSZAS9eLolbINlak38HTzUzhKJV3b8gW4aTY', NULL, 'jpg', 1878258, 'filehub', 'active', 1679836451),
(3, 1, NULL, '3599699016-Yarost-jk6v-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-26/80642083c9966a5.jpg', '3gjtlJd1JFTkTNduVeygqyAys19fG3A30QuLDLaK7XkjoBzA0j3JO3A3yZtk7lKa5Bq59X2-SLfSJmOAyI0svOjerma6zJ2EGOfOjQHCzhP4Nrj_VD-8Dwa2UF1AiOVk', NULL, 'jpg', 1020440, 'filehub', 'active', 1679852489),
(4, 1, NULL, '3599699016-Yarost-jk6v-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-27/806422036866d81.jpg', 'pgDSb90vcHeXRVkqfhRCPdmDJMPMNQAxLZKvMT_Nl62_99fjseJcqXIb6Ub_eROIvzbd6voOTWCSxM4aT2kZoH_FUAH5RwGl1YFSFpDt4kq9NcyavnP5ZYQyvVGXk-XY', NULL, 'jpg', 1020440, 'filehub', 'active', 1679950696),
(6, 1, NULL, '917060590-planet-kx2E-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-29/8064249f4f36f9d.jpg', 'Xr1uWW5cYiJUOyyiKqkZ1CvvMfuhMVMv_iyGDzG0eDhASZiahB0smDIuvlYvB0it0yKYqT91V0kpio8UWjuq7E27Z_ZS336m_y-5KPXIeQHJOLpwneqPyYmmV6HoW3Fs', NULL, 'jpg', 1594045, 'filehub', 'active', 1680121679),
(7, 1, NULL, '74068790.png', '//uploaded_files/user_id_1/2023-03-29/8064249f7391263.png', 'tiriNK4DwwVEq-jj4in_zMrOSEsESOAwm-ZPsU0ofnuMLWYjnURnEIfl11V7ZV0LxhmOrTlgBa-5-y1jq1CP0sn2AXZ2qaaWcEpZDIIE0C4RUMt3SIG4CyhBxhDfICoI', NULL, 'png', 1764086, 'filehub_my', 'active', 1680121715),
(8, 1, NULL, '74068790.png', '//uploaded_files/user_id_1/2023-03-29/8064249f9094b60.png', 'IAWcADnvWdvXGRSiy5VpKOTurPEkqfK3ZHT_2-3YoqLRdBAlvAYND7s-XEuYGE8C5dkIh6X5bl5i0oq9ssDydzQQDsw7EX_Kn7VE7XZ_yuWTvnJfj54cgp2xdIPJRjUM', NULL, 'png', 1764086, 'filehub', 'active', 1680121744),
(9, 1, NULL, '1869545681-fallout-5K0x-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-29/806424a062cc7f5.jpg', '8qLsPTxISbk1Pgb2J6b4a3ih2KREGvSROIlpH-TIvVZ0h3D882VzRXKc2ZCR7FppDhLDoTadWdTwOp27-47S2HEyxhXDf9X4_j7AzzcVZpZpSGq2LTajSwgG8vUqYmue', NULL, 'jpg', 1878258, 'filehub_my', 'active', 1680121954),
(10, 1, NULL, '3599699016-Yarost-jk6v-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-29/806424a0721b7bf.jpg', '-3PYDCOgb1f75hvovJTxpPfMYZcImP5EA-c1UhRWNvP25ZRIlv2ETZ_hUkb1V9vd8xO3c1_YAuy6KhNi8RpSSCWe8h-vY95Uocd4QBp1BY1DesoQquBmjZro59YsiazZ', NULL, 'jpg', 1020440, 'filehub_my', 'active', 1680121970),
(11, 1, NULL, '1869545681-fallout-5K0x-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-29/806424a0a17898a.jpg', 'MiXaKbjTEJhrHQGptsjZaGMss7EMMYrPCLZFx9anB55r79-z6x5Kol3PFT7PSj53dhW3LX9c2noYbmGeTtrE4cizXqkDesjcpcv6IzgS-ZspqGIv65l5EgykEXlDRAPm', NULL, 'jpg', 1878258, 'filehub', 'active', 1680122017),
(12, 1, NULL, '1869545681-fallout-5K0x-3440x1440-MM-100.jpg', '//uploaded_files/user_id_1/2023-03-29/806424a0b2cf7ed.jpg', 'YhEH5OANYntjvYu0QfJs9M9KLSdTZHu6IoQxIrNPJYchhvJ3MKkg0UcH1GXxMcPUqrXYTcGmyThuHapXigwN-rEMarlHrNfjWh-9QURr76J508I4ujBAEO_fQqQ06MF-', NULL, 'jpg', 1878258, 'filehub', 'active', 1680122034),
(13, 1, NULL, '74068790.png', '//uploaded_files/user_id_1/2023-03-29/806424a0bc6841d.png', 'pSUcmuS_fdUuffKklbi-80p6kcaeuxvfum77YfZ145apQRkyQqrDtSPIepN3rBDln9elDuhhiqqYtL1M5cBhay5_2t897k_3prV2Px9XPP_RqM28WGjs12Vs_EOjq4Ua', NULL, 'png', 1764086, 'filehub_my', 'active', 1680122044),
(14, 1, NULL, '1354680171-planeta-54GY-3440x1440-MM-100.jpg', '/uploaded_files/user_id_1/2023-03-29/806424a192895ee.jpg', 'yexHLrunwqSSPWaiBqzJYvDqPDY6y4sl49RQEWIY5cRbIPKbee361IYu2v6_lGi_4ZnwiYufy-wyIV0z0Wjsryoo6huQxGbvolvBua5QQ_kpTEe2tgblrqLig-RboNz1', NULL, 'jpg', 778503, 'filehub_my', 'active', 1680122258),
(18, 1, NULL, '1354680171-planeta-54GY-3440x1440-MM-100.jpg', '/uploaded_files/user_id_1/2023-05-23/80646c9a7e0f148.jpg', 'ZD2c1CuTbDyuRm-X74KEvjy0A8se1Mxpb7Nt890nAQHhPn3QWpY0buOSojyqsfwehgjo8ycm0X7zIfQaaPMUibi3erq8slZryWIfqqR-ETcirUcvrZatMSxWxPtIFM_g', NULL, 'jpg', 778503, 'avatar', 'active', 1684839038),
(19, 1, 3, '1869545681-fallout-5K0x-3440x1440-MM-100.jpg', '/uploaded_files/user_id_1/2023-05-24/80646e7891e1590.jpg', 'xVtBf4npoTeaXa2-jQnprfpNcCZ4xoU1MPEPF4TC12xCLDYi-kERMaAThQzNxzc2HPbXvBwnmVBjxiH-GI4yJHi0mbUF_9qtoQzRcHbVPMfyaNtvHK9IzG0fjL-E_chB', NULL, 'jpg', 1878258, 'filehub', 'active', 1684961425),
(20, 1, 3, '1869545681-fallout-5K0x-3440x1440-MM-100.jpg', '/uploaded_files/user_id_1/2023-05-24/80646e795955f7b.jpg', '8CnWcRAz63gFKxbjT0ax0OgexdSaIONxi84zBnWn-ULiP1Bzy4m_-PznbjUvkVF1tbo63LmqgNTlUgjYnPdyZvF_I6e-jDrvZZ9SYbd-AxVSgTTV4h7-dooh0GrsrzfZ', NULL, 'jpg', 1878258, 'filehub', 'active', 1684961625),
(21, 1, 3, '3599699016-Yarost-jk6v-3440x1440-MM-100.jpg', '/uploaded_files/user_id_1/2023-05-24/80646e795957070.jpg', 'dTuH3mI6JV1085-x9wqu0ZdtNxPtfkYY5xBMwySS32k3RzxjJBRQmIW13wAZr2fmpPWqSmVXeK5Lush2afTOyAZkXgrfl2UKcLRwDxpcGPXB_m1ojL9Cj-tm3EGTtiEA', NULL, 'jpg', 1020440, 'filehub', 'active', 1684961625),
(22, 3, NULL, '3599699016-Yarost-jk6v-3440x1440-MM-100.jpg', '/uploaded_files/user_id_3/2023-05-26/806470764e74516.jpg', 'YHnu9o6gFBwTfQTlZ3_9tIlbTU-2v8JjNd1sdxzeuWcEATTLH8dydvHFgbsOEAnSKb7QtZ_GAWuBYE15m7Qlhirxlpwu3t8N8BCAThGUSEDZnfcRZlTeiEn0HO0I9O5x', NULL, 'jpg', 1020440, 'avatar', 'active', 1685091918),
(26, 2, NULL, '961549865-abstract-PqB2-3440x1440-MM-100.jpg', '/uploaded_files/user_id_2/2023-05-27/806471427f39156.jpg', 'Kal6FPJ-HLPoAIc_N9oSecF8rM8N93mGAzj9tkNaDpoM76ziLobqoHy7tawSyrU0GRaDzschSEtRicUrXovN1TPTDV3VcEKKr2lRUFkAxuEqP--2VJETGcQztwUkxV-N', NULL, 'jpg', 820934, 'edu', 'active', 1685144191),
(27, 2, NULL, '1354680171-planeta-54GY-3440x1440-MM-100.jpg', '/uploaded_files/user_id_2/2023-05-28/8064727c89ac049.jpg', 'u8eHDJjHpKGedYitgDt3L7wx2wLZ_o8EwAqiOfS__NdYETq8ILT5DEquPiIVVxygvNNFbfGDk6K_NPoGwa-fgYE0nwT9qbECcrXEl7wLEWnUHQ92jfa-bXMVwVllAbpy', NULL, 'jpg', 778503, 'edu', 'active', 1685224585),
(28, 2, NULL, '1869545681-fallout-5K0x-3440x1440-MM-100.jpg', '/uploaded_files/user_id_2/2023-05-28/8064727c89acf08.jpg', '0Z3tPp4KnlSN6375gV4NPV9WqsrQthPaJoyG6k9MbRBWmJwiReKijilnZFVvntvo_ILCF0eNuxkBgtoz5TEKGMJ8T3FoPyKVar3HP6mKQ2YkHoWBYD1edKpPMjXc0nls', NULL, 'jpg', 1878258, 'edu', 'active', 1685224585),
(29, 2, NULL, '3599699016-Yarost-jk6v-3440x1440-MM-100.jpg', '/uploaded_files/user_id_2/2023-05-28/8064727c89ad265.jpg', 'qrocYxKczsQZsQNh9kxmjv3ldkC9ZL19u7ywH4loJfW9WuzjonztDNuZu75LNFzMjzkFKyLGjznovzVxJDKfGDziUQ-EPV7fFQiFmuQUA5YVeddq_HaqdI5knSPjPD6h', NULL, 'jpg', 1020440, 'edu', 'active', 1685224585);

-- --------------------------------------------------------

--
-- Структура таблицы `edu_homework`
--

CREATE TABLE `edu_homework` (
  `id` int NOT NULL,
  `homework_teacher_id` int NOT NULL COMMENT 'Id учителя который задал дз.',
  `homework_group_id` int NOT NULL COMMENT 'Id группы в которой задали это дз.',
  `homework_subject_id` int NOT NULL COMMENT 'Id предмета по которому задали дз.',
  `homework_answer_file_id` int DEFAULT NULL COMMENT 'Id файл с ответом на дз.',
  `homework_file_ids` json DEFAULT NULL COMMENT 'Ids прикрепленных файлов.',
  `homework_title` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `homework_content` varchar(8192) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Содержание/Комментарий.',
  `homework_deadline` datetime DEFAULT NULL COMMENT 'К какому времени нужно сдать дз.',
  `homework_options` json DEFAULT NULL COMMENT 'Доп. настройки к дз.',
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `edu_homework_users`
--

CREATE TABLE `edu_homework_users` (
  `id` int NOT NULL,
  `homework_id` int NOT NULL COMMENT 'Id дз.',
  `homework_user_id` int NOT NULL COMMENT 'Id того кому задали.',
  `homework_answer_ids` json DEFAULT NULL COMMENT 'Ids прикрепляных файлов.',
  `homework_answer_comment` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Коммент ответа на дз.',
  `homework_grade` int DEFAULT NULL COMMENT 'Оценка за дз.',
  `homework_teacher_comment` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Комментирий от того кто задал.',
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `edu_qualifications`
--

CREATE TABLE `edu_qualifications` (
  `id` int NOT NULL,
  `qualification_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qualification_about` varchar(4096) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` set('active','deactivated') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year` year NOT NULL,
  `specialisation_id` int NOT NULL,
  `base_education` set('9','11') COLLATE utf8mb4_general_ci NOT NULL,
  `code` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `edu_qualifications`
--

INSERT INTO `edu_qualifications` (`id`, `qualification_title`, `qualification_about`, `status`, `year`, `specialisation_id`, `base_education`, `code`) VALUES
(17, 'Разработчик веб и мультимедийных приложений', '', 'active', 2022, 3, '9', ''),
(19, 'fdsasdax', '', 'active', 2026, 3, '9', '312321');

-- --------------------------------------------------------

--
-- Структура таблицы `edu_specialisation`
--

CREATE TABLE `edu_specialisation` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `fgos` text NOT NULL,
  `code` text NOT NULL,
  `status` set('active','deactivated') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `edu_specialisation`
--

INSERT INTO `edu_specialisation` (`id`, `name`, `fgos`, `code`, `status`) VALUES
(3, 'Информационные системы и программирование', 'от 09.12.2016 №1547', '09.02.2007', 'active');

-- --------------------------------------------------------

--
-- Структура таблицы `edu_subjects`
--

CREATE TABLE `edu_subjects` (
  `id` int NOT NULL,
  `subject_teacher_id` int NOT NULL COMMENT 'Id учителя / преподавателя.',
  `subject_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Название предмета.',
  `subject_about` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'О предмете.',
  `status` set('active','deactivated') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `edu_subjects`
--

INSERT INTO `edu_subjects` (`id`, `subject_teacher_id`, `subject_title`, `subject_about`, `status`) VALUES
(17, 10, 'Русский язык', '', 'active'),
(18, 10, 'Литература', '', 'active'),
(19, 11, 'Математика', '', 'active');

-- --------------------------------------------------------

--
-- Структура таблицы `edu_subjects_groups`
--

CREATE TABLE `edu_subjects_groups` (
  `id` int NOT NULL,
  `subject_id` int NOT NULL,
  `group_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `filehub_folders`
--

CREATE TABLE `filehub_folders` (
  `id` int NOT NULL,
  `folder_owner_id` int NOT NULL COMMENT 'Id ответственного за папку.',
  `folder_parent_id` int DEFAULT NULL COMMENT 'Id папки в которой он находиться.',
  `folder_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Название папки.',
  `folder_about` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'MY - для меня, COMMON - для общего списка.',
  `folder_code` set('my','common') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` set('active','draft') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `filehub_folders`
--

INSERT INTO `filehub_folders` (`id`, `folder_owner_id`, `folder_parent_id`, `folder_title`, `folder_about`, `folder_code`, `status`, `created_at`) VALUES
(2, 1, 1, 'Тест', 'wer', 'my', 'active', 1679939363),
(3, 1, NULL, 'Тест', '123123', 'common', 'active', 1680131942),
(5, 1, NULL, 'Тест', 'уке', 'my', 'active', 1683061865),
(6, 1, 3, 'Тест для папки', '', 'my', 'active', 1684963363),
(7, 2, NULL, 'Моя папка', 'Нужна мне', 'my', 'active', 1685042394);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int NOT NULL,
  `group_curator_id` int DEFAULT NULL COMMENT 'Id куратора группы.',
  `group_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Название группы.',
  `group_about` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'О группе.',
  `group_options` json DEFAULT NULL COMMENT 'Доп. настройки.',
  `status` set('active','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `group_specialisation_id` int NOT NULL COMMENT 'Id специальности',
  `group_author_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `group_curator_id`, `group_title`, `group_about`, `group_options`, `status`, `created_at`, `updated_at`, `group_specialisation_id`, `group_author_id`) VALUES
(22, 15, 'ИВ1К-22', '', NULL, 'active', 1773143658, 1773228867, 3, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `groups_users`
--

CREATE TABLE `groups_users` (
  `id` int NOT NULL,
  `group_id` int NOT NULL COMMENT 'Id группы.',
  `user_id` int NOT NULL COMMENT 'Id пользователя.',
  `user_role` set('author','moder','user','curator') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `groups_users`
--

INSERT INTO `groups_users` (`id`, `group_id`, `user_id`, `user_role`) VALUES
(19, 22, 7, 'author'),
(20, 22, 15, 'curator');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1672955015),
('m140506_102106_rbac_init', 1672955280),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1672955280),
('m180523_151638_rbac_updates_indexes_without_prefix', 1672955280),
('m200409_110543_rbac_update_mssql_trigger', 1672955280),
('m230105_213242_create_user_table', 1672955016),
('m230107_120525_create_core_files_table', 1673093517),
('m230114_180528_create_groups_table', 1673722039),
('m230114_180539_create_groups_users_table', 1673722039),
('m230325_160956_create_filehub_folders_table', 1679761347),
('m230326_115809_update_core_files_table', 1679832188),
('m230327_225300_update_filehub_folders_table', 1679957698),
('m230503_223047_create_edu_qualifications_table', 1683155592),
('m230503_225618_create_edu_subjects_table', 1683155592),
('m230503_230204_create_edu_subjects_groups_table', 1683155592),
('m230507_115849_update_groups_table', 1683460958),
('m230507_143020_create_edu_homework_table', 1683495007),
('m230507_180226_create_edu_homework_users_table', 1685212527);

-- --------------------------------------------------------

--
-- Структура таблицы `subject_qualifications`
--

CREATE TABLE `subject_qualifications` (
  `id` int NOT NULL,
  `subject_id` int NOT NULL,
  `qualification_id` int NOT NULL,
  `code` text NOT NULL,
  `hours` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `subject_qualifications`
--

INSERT INTO `subject_qualifications` (`id`, `subject_id`, `qualification_id`, `code`, `hours`) VALUES
(9, 17, 19, '111', 123123),
(10, 17, 17, '12313', 3333);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `avatar_id` int DEFAULT NULL COMMENT 'Id картинки пользователя.',
  `user_f` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_i` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_o` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `access_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `auth_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `about` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `options` json DEFAULT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `last_visit_at` int NOT NULL,
  `snils` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `avatar_id`, `user_f`, `user_i`, `user_o`, `email`, `access_token`, `auth_key`, `password_hash`, `password_reset_token`, `about`, `options`, `status`, `created_at`, `updated_at`, `last_visit_at`, `snils`) VALUES
(1, 18, 'Admin1', 'Adm', '', 'admin@mail.ru', NULL, 'v-N79kiPC1TGB1kdXSCdLLAtLqSY_Ts_Ma1ZrfAc2uoOlOf_1XnJPgP88PKuAt_LrnZRbmeqolil8Bj1AAUxnM0cvygIdmWqLZ-gUwGQQmHFvPiZfyyj-UI1NXMlMiPR', '$2y$13$crj3mL/XhAxTKwKpJKewI.2sdrX385/ejB8E4SXzY0c.a3l620Npy', NULL, 'qewqewqwe', NULL, 0, 1672963122, 1773138574, 1672963121, NULL),
(2, NULL, 'Test', 'TEST', '', 'test@mail.ru', NULL, 'v-N79kiPC1TGB1kdXSCdLLAtLqSY_Ts_Ma1ZrfAc2uoOlOf_1XnJPgP88PKuAt_LrnZRbmeqolil8Bj1AAUxnM0cvygIdmWqLZ-gUwGQQmHFvPiZfyyj-UI1NXMlTYUI', '$2y$13$crj3mL/XhAxTKwKpJKewI.2sdrX385/ejB8E4SXzY0c.a3l620Npy', NULL, 'ertertrere', NULL, 0, 1672963122, 1772793845, 1672963121, NULL),
(5, NULL, 'Куратор', 'Куратор', 'Куратор', 'curator@mail.ru', NULL, 'p5oEfTyLj1_7UHBOUj-LZjEmq0I5WTZOFNg1B5KowiYAX4KeK8MFG1mO2l0VwIgWZ0Lo6JIKdt3d2U_uWw9TqE4bIqfzTfn71jDpH5UjyItrLgGyavk7A27P_qwMQN1v', '$2y$13$Js4mjPSlJCxDZ6TIHxDM2.J7CCr8ALP0WXJ6z2QIhlLHWDGzzJtW6', NULL, NULL, NULL, 10, 1772017894, 1772017894, 1772017894, NULL),
(7, NULL, 'Админ', 'Админ', 'Админ', 'admin@main.ru', NULL, 'XrQR7vnppA156lAQO317ZoLu9MPTEztsdfZRxzlhbgmKcRW-1g3SoxNtM37gVyJutlh8grKWIbO7YmW9gLqsE0UNGuLhAJ3ktGIpiOWSQHo09_Sc1BQRq50QMZ2i9mO4', '$2y$13$R.OxloAA3QzE3DHUcxObWeT303XXAYi4fJu2owWNTT0b9MCGaVxsm', NULL, NULL, NULL, 10, 1772793615, 1772793615, 1772793615, NULL),
(8, NULL, 'Гордеев', 'Никита', 'Николаевич', 'gordeev_n@mail.com', NULL, 'OR1auNC4DFDVfnLa1DliH7q9t29VwztCxJKpZaweC9EM058MyhdTDji7z4ta8cXeleXxvGjvbX2TryyY-hdJjw-jIb-_AcrrWwR9Mr-J0m-nYsjUbwiZza7ojF3iFpiG', '$2y$13$dqto2leSwCxIgD2kCufRSe5kTFNpNByWCJ2OQrhvdHj9VMfxTt.re', NULL, '', NULL, 10, 1773138658, 1773228607, 1773138658, ''),
(10, NULL, 'Богач', 'Дмитрий', 'Александрович', 'bogach_d@mail.com', NULL, 'eM1eC_iE0MOdIul0IuIj3aEuFZkjGbhe4KtgC0yTXTail-_2jPK_G3mNJDPhDbFKJ9PnoYlq0vdRFvghrODs7FBJpOq-ef8DTJR9x476X3iAvbNenuZMmBoX0NVbwefF', '$2y$13$TKa0MhkThNT6doeZBf/uZefwoWcLnvzq2M408gmwjpdCdzTcrp3C.', NULL, NULL, NULL, 10, 1773139019, 1773139019, 1773139018, NULL),
(11, NULL, 'Сенникова', 'Эльвира', 'Александровна', 'sennikova_e@mail.com', NULL, 'cHyavt5c1cY_frUE-p7LG3RmkxHM47RMfrTc1NruV2YNoXNoaseF-iI9fUctMBfuXu66Hiiv0GSFCJwNTFmWj-mH0NOx2Ma2cjl9-PG87Ir7xdStPBjZNa9LujOLq9os', '$2y$13$N.X.YNdOAaQU2/BoCyKDxueD6FqsOdcqJFj2DnZkY943KJDiZ7QBC', NULL, NULL, NULL, 10, 1773139153, 1773139153, 1773139152, NULL),
(12, NULL, 'Фирсин', 'Сергей', 'Викторович', 'firsin_s@mail.com', NULL, 'U_AKAbS68cLn_Tp0o37DrYSoZJQ8udR5YMAYzYPYxBDth2MmBdf7RbHR-3ZZqYOZeulGOLHCMY44VfHf71JgblgTRzemlk9SkUVaUsQvsBLXSiDIvkm-PslmWqCP1hsA', '$2y$13$jEhoqQx/R6FvRcTkhDdwT.OF5ZocF71HvQ/.iMrYP5gIE9yt0pWAa', NULL, NULL, NULL, 10, 1773139298, 1773139298, 1773139298, NULL),
(13, NULL, 'Самойлов', 'Владимир', 'Васильевич', 'samoylov_v@mail.com', NULL, 'suxnyQsgYjqvHi4oz3ciUkDHE8Bd3iVc-4yzHprTV5dXG6HPUQH_WNjb-UEIG09Ph1RNbIDyr8VDm3SuGaaPVVhu0tWI_Msj_tjWa06bBJziCHj8QfDlMTmy0zUgzV9I', '$2y$13$Z.sbRj5tZTjnNJzzrrzVY.gBsViAntVmGnUqkLGhTewG7gibhyBqa', NULL, NULL, NULL, 10, 1773139394, 1773139394, 1773139394, NULL),
(14, NULL, 'Коржев', 'Андрей', 'Артёмович', 'korjev_a@mail.com', NULL, 'xgFGg9NxZ06pMdjFh0Qh3jyDc2rTOlz3qhDfvI4cIrduetPomhQwXfMZ-V4HVwnxWc5d2AXECtoy3tSBeq1-T4FUxS5dADt0tq-QAFu-aoyo9Fi6HEAbl9H405876n-r', '$2y$13$g7/.M66T8xoFWSDKYBNCwOaqrS.jbXVj0oZ5dJcj0x1OEaBZdAVm6', NULL, '', NULL, 10, 1773148894, 1773149133, 1773148894, ''),
(15, NULL, 'Бабай', 'Наталья', 'Юрьевна', 'babay_n@mail.ru', NULL, 'PVlQ1S1zLdUDtUTYp2kxEBKUg1vdyTNYmb5RqJfH281tclPj1Rb2YlIvrwhFsB6Hofab9ypSMMec1QlgFHeFJy6h-Si5eZ78Y0QmLd26hr51WRls_bUYLIuxQMTj90v3', '$2y$13$yFcqeqqkK1llpjK.4vLAA..M9giLy6iboWlGnviT1uW..QN7h7lzW', NULL, '', NULL, 10, 1773228665, 1773228678, 1773228664, ''),
(16, NULL, 'Ученик', 'Ученик', 'Ученик', 'user@mail.com', NULL, 'PyPc_M1Ya2YwzDv1_HihsxsG_5xqTkPcDldpUVQqbGppp8h8LIgcPdAL48hAdvWN3aIlunnZd5O0n25Sl4aLPrQwNKAngQ_fqDKQ0zFJrOzIu5nReCjs2FGFlZi7Bse8', '$2y$13$TQrcugfxCkrA7vf8rqAwLuWWU0neFHdfjB44OeH/H1q9J3ntgB1cC', NULL, NULL, NULL, 10, 1773822880, 1773822880, 1773822880, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `core_files`
--
ALTER TABLE `core_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-core_files-file_folder_id-filehub_folders-id` (`file_folder_id`);

--
-- Индексы таблицы `edu_homework`
--
ALTER TABLE `edu_homework`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i-edu_homework-homework_title` (`homework_title`),
  ADD KEY `fk-edu_homework-homework_teacher_id-user-id` (`homework_teacher_id`),
  ADD KEY `fk-edu_homework-homework_group_id-groups-id` (`homework_group_id`),
  ADD KEY `fk-edu_homework-homework_subject_id-edu_subjects-id` (`homework_subject_id`),
  ADD KEY `fk-edu_homework-homework_answer_file_id-core_files-id` (`homework_answer_file_id`);

--
-- Индексы таблицы `edu_homework_users`
--
ALTER TABLE `edu_homework_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-edu_homework_users-homework_id-edu_homework-id` (`homework_id`),
  ADD KEY `fk-edu_homework_users-homework_user_id-user-id` (`homework_user_id`);

--
-- Индексы таблицы `edu_qualifications`
--
ALTER TABLE `edu_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i-edu_qualifications-qualification_title` (`qualification_title`),
  ADD KEY `specialization_id` (`specialisation_id`);

--
-- Индексы таблицы `edu_specialisation`
--
ALTER TABLE `edu_specialisation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `edu_subjects`
--
ALTER TABLE `edu_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i-edu_subjects-subject_title` (`subject_title`),
  ADD KEY `fk-edu_subjects-subject_teacher_id-user-id` (`subject_teacher_id`);

--
-- Индексы таблицы `edu_subjects_groups`
--
ALTER TABLE `edu_subjects_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-edu_subjects_groups-subject_id-edu_subjects-id` (`subject_id`),
  ADD KEY `fk-edu_subjects_groups-group_id-groups-id` (`group_id`);

--
-- Индексы таблицы `filehub_folders`
--
ALTER TABLE `filehub_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filehub_folders-folder_title-index` (`folder_title`),
  ADD KEY `fk-filehub_folders-folder_owner_id-user-id` (`folder_owner_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-groups-group_curator_id-user-id` (`group_curator_id`),
  ADD KEY `fk-groups-group_qualification_id-edu_qualifications-id` (`group_specialisation_id`);

--
-- Индексы таблицы `groups_users`
--
ALTER TABLE `groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-groups_users-group_id-groups-id` (`group_id`),
  ADD KEY `fk-groups_users-user_id-user-id` (`user_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `subject_qualifications`
--
ALTER TABLE `subject_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualification_id` (`qualification_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `access_token` (`access_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `core_files`
--
ALTER TABLE `core_files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `edu_homework`
--
ALTER TABLE `edu_homework`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `edu_homework_users`
--
ALTER TABLE `edu_homework_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `edu_qualifications`
--
ALTER TABLE `edu_qualifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `edu_specialisation`
--
ALTER TABLE `edu_specialisation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `edu_subjects`
--
ALTER TABLE `edu_subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `edu_subjects_groups`
--
ALTER TABLE `edu_subjects_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `filehub_folders`
--
ALTER TABLE `filehub_folders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `groups_users`
--
ALTER TABLE `groups_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `subject_qualifications`
--
ALTER TABLE `subject_qualifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `core_files`
--
ALTER TABLE `core_files`
  ADD CONSTRAINT `fk-core_files-file_folder_id-filehub_folders-id` FOREIGN KEY (`file_folder_id`) REFERENCES `filehub_folders` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `edu_homework`
--
ALTER TABLE `edu_homework`
  ADD CONSTRAINT `fk-edu_homework-homework_answer_file_id-core_files-id` FOREIGN KEY (`homework_answer_file_id`) REFERENCES `core_files` (`id`),
  ADD CONSTRAINT `fk-edu_homework-homework_group_id-groups-id` FOREIGN KEY (`homework_group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `fk-edu_homework-homework_subject_id-edu_subjects-id` FOREIGN KEY (`homework_subject_id`) REFERENCES `edu_subjects` (`id`),
  ADD CONSTRAINT `fk-edu_homework-homework_teacher_id-user-id` FOREIGN KEY (`homework_teacher_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `edu_homework_users`
--
ALTER TABLE `edu_homework_users`
  ADD CONSTRAINT `fk-edu_homework_users-homework_id-edu_homework-id` FOREIGN KEY (`homework_id`) REFERENCES `edu_homework` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-edu_homework_users-homework_user_id-user-id` FOREIGN KEY (`homework_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `edu_qualifications`
--
ALTER TABLE `edu_qualifications`
  ADD CONSTRAINT `edu_qualifications_ibfk_1` FOREIGN KEY (`specialisation_id`) REFERENCES `edu_specialisation` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `edu_subjects`
--
ALTER TABLE `edu_subjects`
  ADD CONSTRAINT `fk-edu_subjects-subject_teacher_id-user-id` FOREIGN KEY (`subject_teacher_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `edu_subjects_groups`
--
ALTER TABLE `edu_subjects_groups`
  ADD CONSTRAINT `fk-edu_subjects_groups-group_id-groups-id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-edu_subjects_groups-subject_id-edu_subjects-id` FOREIGN KEY (`subject_id`) REFERENCES `edu_subjects` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `filehub_folders`
--
ALTER TABLE `filehub_folders`
  ADD CONSTRAINT `fk-filehub_folders-folder_owner_id-user-id` FOREIGN KEY (`folder_owner_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `fk-groups-group_curator_id-user-id` FOREIGN KEY (`group_curator_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`group_specialisation_id`) REFERENCES `edu_specialisation` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `fk-groups_users-group_id-groups-id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-groups_users-user_id-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subject_qualifications`
--
ALTER TABLE `subject_qualifications`
  ADD CONSTRAINT `subject_qualifications_ibfk_1` FOREIGN KEY (`qualification_id`) REFERENCES `edu_qualifications` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `subject_qualifications_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `edu_subjects` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
