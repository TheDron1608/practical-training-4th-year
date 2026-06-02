-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 02 2026 г., 14:50
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
('curator', 15, 1773228665),
('curator', 17, 1779365984),
('curator', 46, 1780398351),
('teacher', 8, 1773138658),
('teacher', 10, 1773139019),
('teacher', 11, 1773139153),
('teacher', 12, 1773139298),
('teacher', 13, 1773139394),
('user', 1, 1672963122),
('user', 14, 1773148894),
('user', 18, 1780396599),
('user', 19, 1780396635),
('user', 20, 1780396680),
('user', 21, 1780396719),
('user', 22, 1780396752),
('user', 23, 1780396788),
('user', 24, 1780396826),
('user', 25, 1780396866),
('user', 26, 1780396896),
('user', 27, 1780396936),
('user', 28, 1780397423),
('user', 29, 1780397448),
('user', 30, 1780397513),
('user', 31, 1780397539),
('user', 32, 1780397570),
('user', 33, 1780397598),
('user', 34, 1780397625),
('user', 35, 1780397649),
('user', 36, 1780397679),
('user', 37, 1780397702),
('user', 38, 1780397898),
('user', 39, 1780397928),
('user', 40, 1780397959),
('user', 41, 1780398036),
('user', 42, 1780398069),
('user', 43, 1780398132),
('user', 44, 1780398244),
('user', 45, 1780398269),
('user', 47, 1780398383);

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
(29, 2, NULL, '3599699016-Yarost-jk6v-3440x1440-MM-100.jpg', '/uploaded_files/user_id_2/2023-05-28/8064727c89ad265.jpg', 'qrocYxKczsQZsQNh9kxmjv3ldkC9ZL19u7ywH4loJfW9WuzjonztDNuZu75LNFzMjzkFKyLGjznovzVxJDKfGDziUQ-EPV7fFQiFmuQUA5YVeddq_HaqdI5knSPjPD6h', NULL, 'jpg', 1020440, 'edu', 'active', 1685224585),
(34, 14, NULL, '4.png', '/uploaded_files/user_id_14/2026-05-14/806a05ab985fe16.png', 'AqN9pbIvAyfaC7JvG5VqBFRlO4rvwokXxlXk1S0ceUMK_KiEQmBynpApwI3kYf4zCunC1h3JFFW0bFA87CRde0RVwF4a5pnv4gyPw5JTj0dHeXyuKqkxZzMSXiSSxVBd', NULL, 'png', 80556, 'edu', 'active', 1778756504),
(35, 14, NULL, '12.png', '/uploaded_files/user_id_14/2026-05-14/806a05c5e95142f.png', '5LqDFtFtj2qa1XK5d1Z_udQ05BI0a3GoSCU-1tvewWaofFVNUkKby2eujcx37qW6fF0hHmu-lOtMOpU2ZkLeNa5oVHOCX5fmxcmV72B-U4-BGdiSmCAGwyf9oIOvXZ4Y', NULL, 'png', 25654, 'filehub', 'active', 1778763241),
(36, 14, NULL, '12 (3).png', '/uploaded_files/user_id_14/2026-05-18/806a0af87318218.png', 'aWzEAI6jzSv05jP0rCi31TFRKkzcNWo5TGG3KfgiDQR8DmPG4UqEOrKKah7fzSDzapOI0bx_V9xpaT9g_7R20il0gKu7KDoqX-QCecWnIlNfp8KhRwClMc5vYSkELCL0', NULL, 'png', 25654, 'edu', 'active', 1779103859),
(37, 14, NULL, '4 (5).png', '/uploaded_files/user_id_14/2026-05-18/806a0b06bd9aa94.png', 'fG9dL77aHxiui0eiwt9RjOgQjQQ0MfSK3tQZuchZgYzMGAuA979V0-QhQl-uTxJTrbT8Ll8LUCcTthZe5KHXxM4OuhLPQVpngmRkBlf2ZCQx83pyFw7QuTKZqlMTAWrk', NULL, 'png', 80556, 'edu', 'active', 1779107517),
(41, 8, NULL, '12 (1).png', '/uploaded_files/user_id_8/2026-05-18/806a0b11641b4a0.png', 'b6Rk2otCi0hoK97QrAa-rTn3J7Tj7VDiQmHK54mFSa2M2BUAPXZC9Evq4hcdET9EZymeggV6g3q0eEGd7vN_-w6d2HHkKLYprYH9lt6-GtXXX06tr3glmtTV2g6Ozmg6', NULL, 'png', 25654, 'edu', 'active', 1779110244),
(43, 14, NULL, '4 (6).png', '/uploaded_files/user_id_14/2026-05-18/806a0b12f8d8a3a.png', 'r0AcVUQh7rQppQMsvXi_1h8dlYGlbA19ohxut16IOIwaY_FAdHb0uwHxwG2nuxDuMo-fC4jiWrhtHJM5lK6hrilzUuyrV_o9uvYesDRILWUy4nlfukUhSg8la0S7KWow', NULL, 'png', 80556, 'edu', 'active', 1779110648);

-- --------------------------------------------------------

--
-- Структура таблицы `edu_cycle`
--

CREATE TABLE `edu_cycle` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `edu_cycle`
--

INSERT INTO `edu_cycle` (`id`, `name`, `code`) VALUES
(0, 'Общеобразовательный цикл', 'О.00'),
(2, 'Общий гуманитарный и социально-экономический учебный цикл', 'ОГСЭ'),
(3, 'Математический и общий естественнонаучный учебный цикл', 'ЕН'),
(4, 'Общепрофессиональный цикл', 'ОП.00'),
(5, 'Профессиональный цикл', 'П.00');

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
  `homework_deadline` date DEFAULT NULL COMMENT 'К какому времени нужно сдать дз.',
  `homework_options` json DEFAULT NULL COMMENT 'Доп. настройки к дз.',
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `edu_homework`
--

INSERT INTO `edu_homework` (`id`, `homework_teacher_id`, `homework_group_id`, `homework_subject_id`, `homework_answer_file_id`, `homework_file_ids`, `homework_title`, `homework_content`, `homework_deadline`, `homework_options`, `status`, `created_at`, `updated_at`) VALUES
(14, 8, 22, 20, NULL, NULL, 'Задание 1', '', '2026-05-31', NULL, 'active', 1779107293, 1779107293),
(15, 8, 22, 20, NULL, NULL, 'Просроченное задание', 'kjlhm ', '2026-05-04', NULL, 'active', 1779109599, 1779109599),
(16, 8, 22, 20, NULL, NULL, 'Задание 2222', '', '2026-05-23', NULL, 'active', 1779109931, 1779109931),
(22, 8, 28, 20, NULL, NULL, 'Задание3', 'паым', '2026-05-24', NULL, 'active', 1779110168, 1779110168),
(23, 8, 22, 20, NULL, '[41]', 'qqqqqqqqqqqqqqqqq', 'qqqqqqqqqqqqqqqqq', '2026-05-31', NULL, 'active', 1779110244, 1779110244),
(24, 8, 22, 20, NULL, NULL, 'Просроченное задание', '', '2026-05-04', NULL, 'active', 1779362950, 1779362950),
(25, 8, 22, 21, NULL, NULL, 'Задание 5', '', '2026-05-24', NULL, 'active', 1779371716, 1779371716),
(26, 8, 28, 20, NULL, NULL, 'Задание 5', '', '2026-05-24', NULL, 'active', 1779372031, 1779372031);

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
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `allow_overdue` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `edu_homework_users`
--

INSERT INTO `edu_homework_users` (`id`, `homework_id`, `homework_user_id`, `homework_answer_ids`, `homework_answer_comment`, `homework_grade`, `homework_teacher_comment`, `status`, `allow_overdue`) VALUES
(28, 14, 14, '[37]', 'sdfbv ', 4, 'нормас', 'checked', 0),
(29, 15, 14, NULL, NULL, NULL, NULL, 'waiting_for_an_answer', 0),
(30, 16, 14, NULL, NULL, NULL, NULL, 'waiting_for_an_answer', 0),
(31, 23, 14, '[43]', 'ertgsecg', NULL, 'csfad', 'checked', 0),
(32, 24, 14, NULL, NULL, NULL, NULL, 'checked', 1),
(33, 25, 14, NULL, NULL, NULL, NULL, 'waiting_for_an_answer', 0);

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
(20, 'Разработчик веб и мультимедийных приложений-2023', '', 'active', 2023, 3, '9', '');

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
  `subject_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Название предмета.',
  `subject_about` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'О предмете.',
  `status` set('active','deactivated') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cycle_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `edu_subjects`
--

INSERT INTO `edu_subjects` (`id`, `subject_title`, `subject_about`, `status`, `cycle_id`) VALUES
(17, 'Русский язык', '', 'active', 0),
(18, 'Литература', '', 'active', 0),
(19, 'Математика', '', 'active', 0),
(20, 'Основы проектирования баз данных', '', 'active', 5),
(21, 'Разработка кода информационных систем', '', 'active', 5),
(22, 'Операционные системы и среды', '', 'active', 4),
(23, 'Операционные системы и среды', '', 'active', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `edu_subjects_groups`
--

CREATE TABLE `edu_subjects_groups` (
  `id` int NOT NULL,
  `subject_qualification_id` int NOT NULL,
  `group_id` int NOT NULL,
  `teacher_id` int NOT NULL
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
(22, 15, 'ИВ1К-22', '', NULL, 'active', 1773143658, 1773228867, 3, 7),
(28, 15, 'ИВ1-23-1', '', NULL, 'active', 1778160017, 1779792702, 3, 7),
(31, 17, 'ИВ1-23-2', '', NULL, 'active', 1779792310, 1779792310, 3, 7);

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
(78, 28, 7, 'author'),
(79, 28, 15, 'curator'),
(80, 28, 18, 'user'),
(81, 28, 19, 'user'),
(82, 28, 20, 'user'),
(83, 28, 20, 'user'),
(84, 28, 22, 'user'),
(85, 28, 23, 'user'),
(86, 28, 24, 'user'),
(87, 28, 25, 'user'),
(88, 28, 26, 'user'),
(89, 28, 27, 'user'),
(90, 31, 7, 'author'),
(91, 31, 17, 'curator'),
(92, 31, 28, 'user'),
(93, 31, 29, 'user'),
(94, 31, 30, 'user'),
(95, 31, 31, 'user'),
(96, 31, 32, 'user'),
(97, 31, 33, 'user'),
(98, 31, 34, 'user'),
(99, 31, 35, 'user'),
(100, 31, 36, 'user'),
(101, 31, 37, 'user'),
(102, 22, 7, 'author'),
(103, 22, 15, 'curator'),
(104, 22, 14, 'user'),
(105, 22, 38, 'user'),
(106, 22, 39, 'user'),
(107, 22, 40, 'user'),
(108, 22, 41, 'user'),
(109, 22, 42, 'user'),
(110, 22, 43, 'user'),
(111, 22, 44, 'user'),
(112, 22, 44, 'user'),
(113, 22, 45, 'user'),
(114, 22, 47, 'user');

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
(24, 21, 17, '03', 120),
(25, 22, 20, 'ОП.01', 47);

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
(7, NULL, 'Админ', 'Админ', 'Админ', 'admin@main.ru', NULL, 'XrQR7vnppA156lAQO317ZoLu9MPTEztsdfZRxzlhbgmKcRW-1g3SoxNtM37gVyJutlh8grKWIbO7YmW9gLqsE0UNGuLhAJ3ktGIpiOWSQHo09_Sc1BQRq50QMZ2i9mO4', '$2y$13$R.OxloAA3QzE3DHUcxObWeT303XXAYi4fJu2owWNTT0b9MCGaVxsm', NULL, NULL, NULL, 10, 1772793615, 1772793615, 1772793615, NULL),
(8, NULL, 'Гордеев', 'Никита', 'Николаевич', 'gordeev_n@mail.com', NULL, 'OR1auNC4DFDVfnLa1DliH7q9t29VwztCxJKpZaweC9EM058MyhdTDji7z4ta8cXeleXxvGjvbX2TryyY-hdJjw-jIb-_AcrrWwR9Mr-J0m-nYsjUbwiZza7ojF3iFpiG', '$2y$13$ETYVrr3Tb4UGcjgQHQs/MuC.0Q16oYpEKWLZvA95rRSqGEP8kLNzW', NULL, '', NULL, 10, 1773138658, 1777546203, 1773138658, '123-123-123-13'),
(10, NULL, 'Богач', 'Дмитрий', 'Александрович', 'bogach_d@mail.com', NULL, 'eM1eC_iE0MOdIul0IuIj3aEuFZkjGbhe4KtgC0yTXTail-_2jPK_G3mNJDPhDbFKJ9PnoYlq0vdRFvghrODs7FBJpOq-ef8DTJR9x476X3iAvbNenuZMmBoX0NVbwefF', '$2y$13$TKa0MhkThNT6doeZBf/uZefwoWcLnvzq2M408gmwjpdCdzTcrp3C.', NULL, NULL, NULL, 10, 1773139019, 1773139019, 1773139018, NULL),
(11, NULL, 'Сенникова', 'Эльвира', 'Александровна', 'sennikova_e@mail.com', NULL, 'cHyavt5c1cY_frUE-p7LG3RmkxHM47RMfrTc1NruV2YNoXNoaseF-iI9fUctMBfuXu66Hiiv0GSFCJwNTFmWj-mH0NOx2Ma2cjl9-PG87Ir7xdStPBjZNa9LujOLq9os', '$2y$13$N.X.YNdOAaQU2/BoCyKDxueD6FqsOdcqJFj2DnZkY943KJDiZ7QBC', NULL, NULL, NULL, 10, 1773139153, 1773139153, 1773139152, NULL),
(12, NULL, 'Фирсин', 'Сергей', 'Викторович', 'firsin_s@mail.com', NULL, 'U_AKAbS68cLn_Tp0o37DrYSoZJQ8udR5YMAYzYPYxBDth2MmBdf7RbHR-3ZZqYOZeulGOLHCMY44VfHf71JgblgTRzemlk9SkUVaUsQvsBLXSiDIvkm-PslmWqCP1hsA', '$2y$13$jEhoqQx/R6FvRcTkhDdwT.OF5ZocF71HvQ/.iMrYP5gIE9yt0pWAa', NULL, NULL, NULL, 10, 1773139298, 1773139298, 1773139298, NULL),
(13, NULL, 'Самойлов', 'Владимир', 'Васильевич', 'samoylov_v@mail.com', NULL, 'suxnyQsgYjqvHi4oz3ciUkDHE8Bd3iVc-4yzHprTV5dXG6HPUQH_WNjb-UEIG09Ph1RNbIDyr8VDm3SuGaaPVVhu0tWI_Msj_tjWa06bBJziCHj8QfDlMTmy0zUgzV9I', '$2y$13$Z.sbRj5tZTjnNJzzrrzVY.gBsViAntVmGnUqkLGhTewG7gibhyBqa', NULL, NULL, NULL, 10, 1773139394, 1773139394, 1773139394, NULL),
(14, NULL, 'Коржев', 'Андрей', 'Артёмович', 'user1@mail.com', NULL, 'xgFGg9NxZ06pMdjFh0Qh3jyDc2rTOlz3qhDfvI4cIrduetPomhQwXfMZ-V4HVwnxWc5d2AXECtoy3tSBeq1-T4FUxS5dADt0tq-QAFu-aoyo9Fi6HEAbl9H405876n-r', '$2y$13$S9vmnzE2SRBsbCkzr4oAEeajWZblJu5sMuUeermYfOzbmjUgXph.C', NULL, '', NULL, 10, 1773148894, 1778590384, 1773148894, ''),
(15, NULL, 'Бабай', 'Наталья', 'Юрьевна', 'babay_n@mail.ru', NULL, 'PVlQ1S1zLdUDtUTYp2kxEBKUg1vdyTNYmb5RqJfH281tclPj1Rb2YlIvrwhFsB6Hofab9ypSMMec1QlgFHeFJy6h-Si5eZ78Y0QmLd26hr51WRls_bUYLIuxQMTj90v3', '$2y$13$yFcqeqqkK1llpjK.4vLAA..M9giLy6iboWlGnviT1uW..QN7h7lzW', NULL, '', NULL, 10, 1773228665, 1773228678, 1773228664, ''),
(17, NULL, 'Зяблицева', 'Екатерина', 'Викторовна', 'zabliceva@mail.com', NULL, 'gxTTeSV8JRJ1pk-c-5Gh0hDlxz5FqP2tpFBgENrDJY-W-Isl6FkB8fXSgu-6mROXAEoEh-Hy4qcLISuJIP5LnkA_CQjxbr96DCTyLXzcAEcD2dTYFYBIgir0BI3K7f2w', '$2y$13$cnhH.i1wTkcex6CxTHVfVeIHudBZ/Xx6DU5r3Pp6opHAKdQjrdOZ2', NULL, NULL, NULL, 10, 1779365984, 1779365984, 1779365984, NULL),
(18, NULL, 'Бакалым', 'Валерия', 'Валерьевна', 'student1@mail.com', NULL, 'JMPhuxrwUwrDId9U_4yK1pK0-W8XCtnDiQZIuVeCDDy_LEyG-BmD_4CSD8NHFmzN6sacrXDi7Xl-8_GrDmKun9Oi-sPaJF46hPZLoLekdPnijLZaJtmy0AbJ_tDhDKA0', '$2y$13$ihZIcec58HQ7mAzfLCB8PeYBwxUQqWUbzGQ/OtyBw.TRdujkSxaNS', NULL, NULL, NULL, 10, 1780396599, 1780396599, 1780396598, NULL),
(19, NULL, 'Воробьева', 'Диана', 'Викторовна', 'student2@mail.com', NULL, 'XS-79MA0tb5I4nzpiLq5Hhr7qFK_u-QduDQ-RvawJuiDrHOfqrbXnRuSEtRj7ddnJEH4CTXUZOF1-7Ygt3yOT4OcNtfpS7JIVnkeMyx5M2fwp9YlWmfz7feSyRRgO-YL', '$2y$13$9/8rUg7y9eySN8BbVyumz.jmo7O.xEK8Kzr1rsaffXwPqez/3Us.S', NULL, NULL, NULL, 10, 1780396635, 1780396635, 1780396635, NULL),
(20, NULL, 'Гайсанюк', 'Богдан', 'Игоревич', 'student3@mail.com', NULL, 'BwVz2rboV70cDImDDJDOWUNug2NA9elmZtP_7ivMcEgQayKPx_Fi7NMrLLPkKxTIuOcmf4_WefxJnGbJl9I2I74fEUUMSPFOJSq9mudzUGhfQsAG6ghngqtNi2kvNlgL', '$2y$13$f8fHZbLbyMFGFplcWRFSA.XobL61UrVUyYVwWnHAefTErtec0LX5S', NULL, NULL, NULL, 10, 1780396680, 1780396680, 1780396680, NULL),
(21, NULL, 'Горбенко', 'Станислав', 'Павлович', 'student4@mail.com', NULL, 'jdwGoLakhkAlSvZK0qchOb4vsp6pnUMbm7EMYwWZp3G4oBqhdWoVc3gqjKaWwXAIsEHEOjSR-NUyBWpfYUs_PxKFmP4Bn5yUI6LDFFbFBOUtXDlMwou-OIWHaV1OPTng', '$2y$13$F2s0ow16kRi1sshi2Hsjpuq89tYtDTAZqyyfn3X9Qyq18c5jXCXiO', NULL, NULL, NULL, 10, 1780396719, 1780396719, 1780396718, NULL),
(22, NULL, 'Доспалов', 'Егор', 'Тимурович', 'student5@mail.com', NULL, 'B9Vh1wQavETUesRVWA5h784oT6JyYh-zh0LNkYHH8MvVE3auAtbr0XJkOBZrwXyZ0zs4v1iZ_TPFq6ZTy64vyKcEaoTTLUUdmypnmRvOGLUOusArDqif3PrXZS6eUk8B', '$2y$13$/wDP/DrA4pjMUtq4AGZD4exkOXq5h4keJIX5fRTg837LgGaWyYmze', NULL, NULL, NULL, 10, 1780396752, 1780396752, 1780396751, NULL),
(23, NULL, 'Ежовский', 'Георгий', 'Вячеславович', 'student6@mail.com', NULL, 'HH1HRE-IwGg9P9raxUQdOmxeCCiouJ38oP7z1PhnXfLnXPMBp79BHmvzxch_FLFquuO0Dlw-sgZO0Lvbd-5jWBCO9IB1PJkxwyV4bNfQ3rdtM37JWXCAupPg7qc-mdgS', '$2y$13$3Ia8kdQ8y6T45g3QXcqAieHmzflhKoLKkmyjcLA948HYtMNPH/XTO', NULL, NULL, NULL, 10, 1780396788, 1780396788, 1780396788, NULL),
(24, NULL, 'Ефимов', 'Кирилл', 'Олегович', 'student7@mail.com', NULL, 'OEExAj6aUiy1424p8D_55mYXddlXdhloRRZ5xQcLe4uJc_DIcxzvhCAyqz39-2CeLwSg8HEx73Ams4hJQGQEIj2eUEZzLfVlYYUjMyTCk6I9-BQVnz6Kb64_V5d3is97', '$2y$13$Oij.XX3lpbHt7O1KZUEK6upBilqDoat9xyKG5.LnwrYWKqjgtEAgG', NULL, NULL, NULL, 10, 1780396826, 1780396826, 1780396826, NULL),
(25, NULL, 'Ждан', 'Марина', 'Евгеньевна', 'student8@mail.com', NULL, 'XFVo_C84YpXUmNLcSYTOycvWFFpZiFyV9JReiRn7SPnpgDF70Ymq90458VKRXIcKT_m9uy3xcPONTDeB759N5zzATKDh_bWHXsfx3zy5IwbUeJYWUFjYZcIndvcRbrfy', '$2y$13$r0tymxyHGrzGO0XXyRRNluKhdqhJ4nq8a20iZDjy.38CxDXjcGDfa', NULL, NULL, NULL, 10, 1780396866, 1780396866, 1780396865, NULL),
(26, NULL, 'Иванова', 'Яна', 'Сергеевна', 'student9@mail.com', NULL, 'flJPplxAMX_9-6dtyIrRT6H5tgLWbbCpovZL7HETLhp7_5C0_3Qt1uWI_8MdDOvWfmMgZy1cbpYsTO2vbnb_AiyMF0gcLokGESd4KHtzesCVG55fvG-bB5t1We-d7fi2', '$2y$13$Z/vT.gmnV.GB7ZzoKxJCpu3vNBd9D8X1zpFIUi1aiXDFPFO0J0Dl.', NULL, NULL, NULL, 10, 1780396896, 1780396896, 1780396896, NULL),
(27, NULL, 'Кабаков', 'Глеб', 'Романович', 'student10@mail.com', NULL, 'iGgt5TJy5S_5L6Y8SG_1KO2gfUkazUS25cHmDlPiOZjB9c_FAE57u_oFPGa3SQpMFqFmdJyyrmSXtC9UlrEhpQPBl8mb5CFJ7aEM_OrvAYGEeL3fHAYsxCInZcxlbiFa', '$2y$13$LxjrMVaqLMIrIDyvm2mb/OdYBhlAzSwHAlsLZ8QuslKoo.7xEWMmK', NULL, NULL, NULL, 10, 1780396936, 1780396936, 1780396936, NULL),
(28, NULL, 'Баладин', 'Александр', '', 'student11@mail.com', NULL, 'SIPf2SvBWO1DQ7e3fjA3hJj7iuT-l_1947W7pZPwnn8JKRND5_WNQf0Y96YGNQjalJaG7mkqLt_JLhVRnzfrl-Zf6U8O8g3r8vpLnz9Y6ptj3E6wIxTI-Q1GqYRqwsJ7', '$2y$13$BOSK0XzoBs5wYpVuFxY8IOiikwwYwkI3e3.15sEUc.2J2GZg7ekjS', NULL, NULL, NULL, 10, 1780397423, 1780397423, 1780397423, NULL),
(29, NULL, 'Басалий', 'Никита', '', 'student12@mail.com', NULL, 'w9lPxZOBink8bYFSV9z-Rr2XAt_1UdNxfKM0DJLAr1Z9fUAalPGShgMh-tXINyKCQHuTYaRoLLlACNsBP539_6A5TecCbDgT0xmNXCGN_Gv8r0pA4dSQFOuQ1PVR2Uqu', '$2y$13$yBXaxcyVH2nMPo5oEFOfbOSwzYcqg92xT80m9NXj3HRi5WrWlY90W', NULL, NULL, NULL, 10, 1780397448, 1780397448, 1780397447, NULL),
(30, NULL, 'Борисенко', 'Дарина', '', 'student13@mail.com', NULL, 'kfYcJMfrVzBYbB3mZesqGhmkXRndi2LJY1_1k8-iaWQ76XIDrkSbJYF6leQJIb_xFi_-CQ-jcuNqDmi87I-TLZughygYXvMm6u0YCAxl6Duw_2hEm9EvjHHl40iXs4CK', '$2y$13$PQS/CBNgceAaz1GZN9DwD.qMMZWBAU2KRNPW/ZQuHrinWvtbFwY3m', NULL, NULL, NULL, 10, 1780397513, 1780397513, 1780397513, NULL),
(31, NULL, 'Войтко', 'Виктория', '', 'student14@mail.com', NULL, 'BTnPj0T0N1dqp9PArCqpbBbMb98aFl11njlokM4ueaLoI5mm2nKiKbTd6iY9C3AFz8llDW1Oxc-tm4pCoaF6xp-rsiWgHUFFtW75fSvo7qEJoLMcEQ8_UA2dMAQlfZad', '$2y$13$DqFvkajJ3OvBbrsfqrARQeFCVvK0BKoJs3EeIqb1c.a6.naIZafYO', NULL, NULL, NULL, 10, 1780397539, 1780397539, 1780397539, NULL),
(32, NULL, 'Горбачева', 'Анна', '', 'student15@mail.com', NULL, 'J8gcpFavi1-A7s_weXzG3ZvXJv3okPnjP4It3EwwUnrjJYhJ0rnqACSD0ggP8qSf_hqtO7sWPx8V40vz6NLU9s-S6jBuCMW5i1BY4EMmVi3sT6xE4HGpQK92Sg5luqjK', '$2y$13$eSkTRrFdFNuT3Ok4Efvp8OMfTdMVFgSVOmZ3plw2LEnB01aygERxu', NULL, NULL, NULL, 10, 1780397570, 1780397570, 1780397570, NULL),
(33, NULL, 'Евлампиев', 'Виктор', '', 'student16@mail.com', NULL, 'hd_TaIQJ522v0flvVf8Eba-GcCT0cpOVhP3ybLJXJdmFPgg5QvLMQXTBxesICvpszxs1RkonXEbU0d9dmIHjT9C4Jh8kG8Shit1DqUb-KI-fPKxkL3krZUaCYoMBh6cL', '$2y$13$aANHY9fHQCAOuI7dtU6CIOM4bgOLwJaW93ogCH4mal4kw7fS1lAN2', NULL, NULL, NULL, 10, 1780397598, 1780397598, 1780397598, NULL),
(34, NULL, 'Еремичев', 'Эдуард', '', 'student17@mail.com', NULL, 'URMUmQ5Rb4NKCnh7bqZvoQJko7jv37MgWOgdd1k17NZo4D_6KspsTbB3S6u1yyiJVNXgYwlwv2R2rB9Yy_-pvIV-kKbYJ-i6KiD_pDv4tum9287-pqP6JK8t_sc7IKrF', '$2y$13$7fAWOd.x2YnKnkkPQ7Uhl..3iVdQWo1TbDiiRE75ND7GIrP2uF56m', NULL, NULL, NULL, 10, 1780397625, 1780397625, 1780397624, NULL),
(35, NULL, 'Ёрамахадова', 'Камила', '', 'student18@mail.com', NULL, 'Yby3o5nOXcKa96yHGIxXs2mmIfDSb7bukAvibjMRF08RPz0bpxXZwSmU1eUhPaH00IFySdXJ_WtxOfRt6zL_CTgl6oAX9Lu9OJJlwpNSBeOJyt87eX-8OSAm464ULGwv', '$2y$13$3a9gVDbNR6KtP0X3EgreieY2CgWohDJc45ET1G20YxzbAsSTEr.sq', NULL, NULL, NULL, 10, 1780397649, 1780397649, 1780397649, NULL),
(36, NULL, 'Жашкевич', 'Анна', '', 'student19@mail.com', NULL, 'D2I9qbozrjZ6MntvImv_ahuqVUeS_GAazyl7_mgeCvq5VGCWfLcTCRlKCk-gocH6lbcGpiNnii4S-0zM7fXHanvqrUxAbsOfwERLcj74IGafMLIeMCBp9iAiRSeXBOWt', '$2y$13$UUjqS/AtK4TKNB9sRVR1BuAjlim3jeh.WGPOoGHu7AJ2K7lcn.erW', NULL, NULL, NULL, 10, 1780397679, 1780397679, 1780397678, NULL),
(37, NULL, 'Игнашев', 'Никита', '', 'student20@mail.com', NULL, 'HCwgB4NWzH-LB41C2xo1VUkEs_GY4lIYkZ-mpL9-dSX9VKY_O-2azKzib1IRyB20eeXg1MaRT96-qT5onQQwa8LwuVmYDbmiq9Ux_pxs6T4ydS1hs2-xFDphg9GgJRM5', '$2y$13$6oIgl/olIJl8hMz0v13Hm.TZ8XSb0vpggJgfsbrZZG5TFN53CTghC', NULL, NULL, NULL, 10, 1780397702, 1780397702, 1780397702, NULL),
(38, NULL, 'Дерновой', 'Игорь', '', 'user21@mail.com', NULL, 'B5zoscyfzzaTtko8fDlB_B_9QKk7W8BsYCocJOoZMMl9ffbbgP1wnUZQelrV_0oO6_NB-L7KBI_ZKU0CH_CjW0Ew2ARfRWLV3VXsLyKUvbtaPD2p-3e-jLJghHgQnDuD', '$2y$13$HwwNWSb3rxq6z87xenPw9eQLBHPbmOx1PA54uduKb05D8HxWY7AHe', NULL, NULL, NULL, 10, 1780397898, 1780397898, 1780397897, NULL),
(39, NULL, 'Ракитин', 'Янислав', '', 'user22@mail.com', NULL, 'QEhK-g0I_KJvpi797M5tBs1ppnUM6zbJ8AuLnIFp1C9pLDtNjkrvEq8CbvB1WtBDrMfOUSuEPg20316DbZD0QHsg60qrrPGf-FTKknntFjZcg1yfVNQvFHNE4rZSzJDY', '$2y$13$EZADdWknr9s06jJ9XVDoKO7gOOFK6GEwKDDXNwjhwWNEvYkPSft1i', NULL, NULL, NULL, 10, 1780397928, 1780397928, 1780397928, NULL),
(40, NULL, 'Меньшов', 'Максим', '', 'user23@mail.com', NULL, 'rtdOeHYWO9yPNuHokLn9ZtIzlKk3Ce5vIa9vAHZ9snC6qoPigsJKD-UHgPD1NygbLKBaJ5wIXesLlVkWCzWHCi1ARBfwQTfkXdip0D7o5l2DZjckOH7RRQ5iq8jFMjSL', '$2y$13$twbj7xxRmj2E4Ogoc6wq6.Lc.4bSH4BE.AoQudN.AUtRdvu/JbMJu', NULL, NULL, NULL, 10, 1780397959, 1780397959, 1780397958, NULL),
(41, NULL, 'Сиротник', 'Максим', '', 'user24@mail.com', NULL, 'wKh5w-blSDZgUDdZvYa10U8oduCcpkSeJzqGwJ405Tyj-Fsr7c75QoTJmCkTM__ZDZBa0uVr4IAptMQyrOdLHtFqX8BY-1DR4zu6k1zFr8Wju1hmcjTR1RjG6Ecza6py', '$2y$13$XoOXIdmZ1gPrgc9yHPjHfOTvICW31yFaG8A2MPThpfDu0I6jWacP.', NULL, NULL, NULL, 10, 1780398036, 1780398036, 1780398036, NULL),
(42, NULL, 'Скулков', 'Владимир', '', 'user25@mail.com', NULL, '9wNrA3f-ilcJFxyoy2Cs1fzN1wxCLW2da7nf298ODXNMeDdcBqtPOt1UE2WG8BAWg23j2_6B4NGqZMP2yB5Ee5Y6FJ5IMEuDQxCFo3-paqxgu2tmSw8VkoyA9ElFNq3c', '$2y$13$UFQarHf1r7/dkoFU1dqmS.YYHA2kpcDOWJPwZl2r9c3l51GYVNizC', NULL, NULL, NULL, 10, 1780398069, 1780398069, 1780398068, NULL),
(43, NULL, 'Милена', 'Маркарян', '', 'user26@mail.com', NULL, '_Nr15fKaBRuaNF7xjC3yWnYGJgle0m4ZJqBoj8r-FLLqLcMreK3QZka-7CD7jtSe5w8lCFfVFXypKCW_1S0s4t5tYCP2sXsKBA3gWexWTH-qDhB1EeY8x7YLSU9gfpAu', '$2y$13$2Xl85NNBgSQF3cJ0CmR6hOqgf/lkSyLnUcRsc6Kjvvl1nMcOQ7c2K', NULL, NULL, NULL, 10, 1780398132, 1780398132, 1780398132, NULL),
(44, NULL, 'Иванов', 'Сергей', '', 'user27@mail.com', NULL, 'bgWDaPJaPub3zvTddSqCYV5izLe6Om-SedzX8jMcHxpcATd1pI5_j3mQf7_tIgfymeSrVbo067K4NSu-rhVZJzBRIyAN-nRAxJETxVC1dljQ8euuW5EKXnQuvy0j_xQ-', '$2y$13$SZhIfLdTUqrGJ/EIBPuOk.iDaXkZOemjxnpxqtj.HYSGNwoKjbmke', NULL, NULL, NULL, 10, 1780398244, 1780398244, 1780398243, NULL),
(45, NULL, 'Корнеев', 'Кирилл', '', 'user28@mail.com', NULL, '4Pq-3WJduPXeG0Ay-pVCkIm6GiDtL1gELjbgTKIR7ApBPXw2UK_4m9mjZapF6aP5lPW8p3CMhtRTPwIyRBhMCsQhdgwe7qBL-JfULKTfjJsY4dtYsP8tLyCIhmKNVT82', '$2y$13$lyCTf6TcI4O7Zo.e35AOUuj4oMrIH6A2WMtM86Fun30902s5l8/iy', NULL, NULL, NULL, 10, 1780398269, 1780398269, 1780398269, NULL),
(46, NULL, 'Гюббинет', 'Елизавета', '', 'user29@mail.com', NULL, 'yD_aaLIcK1_JKbux--vMASSpfBBPIVJl40r4aNr2y4FZ9yEZhGwd-z6l2pydtuZ6awFMhBnT_G1PRBV7SwW2-qZ9xd2h76J1-xAd53HVsI-yH053jaE7hnybjLzFjk7i', '$2y$13$8r1yrtmt1ShQue1mWvsYCOftlgOHYp7vRoFQc62VNwFGROP61IBNS', NULL, NULL, NULL, 10, 1780398351, 1780398351, 1780398350, NULL),
(47, NULL, 'Юсупов', 'Дияр', 'Бахтиярович', 'user30@mail.com', NULL, '3yi-UjRJsJ4vprhEwTe2Y0cbBF7foK_kixJ5YgGKuXu5tj6-m1GRr_l2KkA1KsmC2V80KF11M-k2wBZelsBebyFdrXSkenpdp0E7PsYwrkd3qnA3c1QwBPLbCabb9M39', '$2y$13$BA0kCJtWEDcOhuJlxMWTBuO1MMns63MsnbqaE8dRuKZf.G3KE.MDe', NULL, NULL, NULL, 10, 1780398383, 1780398383, 1780398383, NULL);

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
-- Индексы таблицы `edu_cycle`
--
ALTER TABLE `edu_cycle`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `specialisation_id` (`specialisation_id`);

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
  ADD KEY `cycle_id` (`cycle_id`);

--
-- Индексы таблицы `edu_subjects_groups`
--
ALTER TABLE `edu_subjects_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-edu_subjects_groups-subject_id-edu_subjects-id` (`subject_qualification_id`),
  ADD KEY `fk-edu_subjects_groups-group_id-groups-id` (`group_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `edu_cycle`
--
ALTER TABLE `edu_cycle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `edu_homework`
--
ALTER TABLE `edu_homework`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `edu_homework_users`
--
ALTER TABLE `edu_homework_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `edu_qualifications`
--
ALTER TABLE `edu_qualifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `edu_specialisation`
--
ALTER TABLE `edu_specialisation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `edu_subjects`
--
ALTER TABLE `edu_subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `edu_subjects_groups`
--
ALTER TABLE `edu_subjects_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `filehub_folders`
--
ALTER TABLE `filehub_folders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `groups_users`
--
ALTER TABLE `groups_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT для таблицы `subject_qualifications`
--
ALTER TABLE `subject_qualifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
  ADD CONSTRAINT `edu_subjects_ibfk_1` FOREIGN KEY (`cycle_id`) REFERENCES `edu_cycle` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `edu_subjects_groups`
--
ALTER TABLE `edu_subjects_groups`
  ADD CONSTRAINT `edu_subjects_groups_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `edu_subjects_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `edu_subjects_groups_ibfk_3` FOREIGN KEY (`subject_qualification_id`) REFERENCES `subject_qualifications` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
