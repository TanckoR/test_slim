-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 15 2020 г., 11:20
-- Версия сервера: 5.5.57
-- Версия PHP: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pet_project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `pet_users`
--

CREATE TABLE `pet_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `session` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `update_hash` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pet_users`
--

INSERT INTO `pet_users` (`id`, `username`, `password`, `role`, `session`, `email`, `update_hash`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$LGSBO.4/SayE65NW8cOen.vgLt8NbwVBNDWgvHxw9y60hBV3o2xxK', 'admin', NULL, 'vlad_ermolaev@inbox.ru', NULL, '2020-12-11 15:22:19', '2020-12-15 11:18:28'),
(2, 'admin', '$2y$10$3I3Jtbvpl5SQbk1i1E6o8.f8q22TNNA52j.5DDL6zjXqUpjmc.xo6', 'user', NULL, 'vlad1_ermolaev@inbox.ru', NULL, '2020-12-11 15:22:34', '2020-12-15 10:58:04');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pet_users`
--
ALTER TABLE `pet_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pet_users`
--
ALTER TABLE `pet_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
