-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 04 2023 г., 14:40
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ContactUs`
--
CREATE DATABASE IF NOT EXISTS `ContactUs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `ContactUs`;

-- --------------------------------------------------------

--
-- Структура таблицы `contactus`
--

CREATE TABLE `contactus` (
  `id` int NOT NULL,
  `имя` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `сообщение` text NOT NULL,
  `пол` varchar(10) NOT NULL,
  `категория` varchar(20) DEFAULT NULL,
  `подписка` varchar(3) DEFAULT NULL,
  `файл` varchar(255) DEFAULT NULL,
  `Время отправки` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `contactus`
--

INSERT INTO `contactus` (`id`, `имя`, `email`, `сообщение`, `пол`, `категория`, `подписка`, `файл`, `Время отправки`) VALUES
(260, 'Bekmurod', 'sad@gmail.com', 'Не работает оплата.', 'мужчина', 'проблема', 'да', 'Error_1696340419.docx', '2023-10-03 13:40:21'),
(261, 'Mari', 'Mari@gmail.com', 'Добавьте темную тему.', 'женщина', 'предложение', 'Нет', 'Error_1696342070.docx', '2023-10-03 14:07:52'),
(263, 'Xusan', 'Xusan@gmail.com', 'Hello', 'мужчина', 'вопрос', 'Нет', '説得・交渉力を高める_1696395311.docx', '2023-10-04 04:55:14'),
(264, 'Nurislom', 'Nurislom@gmail.com', 'Hellow', 'мужчина', 'предложение', 'Нет', 'Error_1696402310.docx', '2023-10-04 06:51:53'),
(265, 'Baxrom', 'Baxrom@gmail.com', 'web sire not working', 'мужчина', 'проблема', 'да', 'Error_1696409630.docx', '2023-10-04 08:53:53');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
