-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 15 2025 г., 07:18
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `nutrikids_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `anketa`
--

CREATE TABLE `anketa` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `anketa`
--

INSERT INTO `anketa` (`name`, `email`, `phone`, `message`) VALUES
('Джон Мюллер', 'd.azbergenova@aues.kz', '', 'Мен заказ '),
('Джон Мюллер', 'd.azbergenova@aues.kz', '', 'Мен заказ '),
('Джон Мюллер', 'd.azbergenova@aues.kz', '', 'Мен заказ '),
('Дильназ', 'dilnaz.azbergenova@mail.ru', '8705465520', 'Балага питание'),
('Berik', 'bake@gmail.com', '8705465520', 'Мен каша алгым келеди'),
('РИНАТ', 'kazakhreality@gmail.com', '8705465520', 'Мен десткое питание алгым келеди'),
('Абай Кунанбаев', 'd.azbergenova@aues.kz', '8705465520', 'rfnflk');

-- --------------------------------------------------------

--
-- Структура таблицы `catalog`
--

CREATE TABLE `catalog` (
  `image` varchar(225) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `catalog`
--

INSERT INTO `catalog` (`image`, `name`, `description`, `price`) VALUES
('', 'каша', 'Каша с бананом', 1700),
('banana.jpg', 'Каша', 'Каша с бананом', 1700),
('yogurt.jpg', 'Йогурт', 'Йогурт с фруктами', 1500),
('rice.jpg', 'Рисовая каша', 'Нежная каша рисовая', 900),
('ovs.jpg', 'Овсянка', 'Овсянка с бананом', 850);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `user_email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `ordered_at` date DEFAULT NULL,
  `shipped_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`user_email`, `address`, `payment_method`, `item_name`, `item_price`, `status`, `ordered_at`, `shipped_at`) VALUES
('dilnaz@gmail.com', '', '', 'Молоко сухое Modest', 1500, '', NULL, NULL),
('d.azbergenova18@gmail.com', '', '', 'Молоко сухое Modest', 1500, '', NULL, NULL),
('rinat@gmail.com', 'Байтурсынова 127', 'при получении', 'Каша молочная Modest', 800, '', NULL, NULL),
('rinat@gmail.com', 'Байтурсынова 127', 'при получении', 'Йогурт детский Modest', 400, '', NULL, NULL),
('rinat@gmail.com', '3 мкрн', 'онлайн', 'Сок фруктовый Modest', 600, 'Жіберілді', NULL, NULL),
('rinat@gmail.com', '3 мкрн', 'онлайн', 'Пюре овощное Modest', 500, 'Жіберілді', NULL, NULL),
('rinat@gmail.com', 'тимирязева 41', 'онлайн', 'Молоко сухое Modest', 1500, 'Жіберілді', NULL, NULL),
('dighlnaz@gmail.com', 'Жандосова 54', 'при получении', 'Каша молочная Modest', 800, 'Жіберілді', NULL, NULL),
('d.azbergenova18@gmail.com', 'Шевченко 85', 'при получении', 'Молоко сухое Modest', 1500, 'Жіберілді', NULL, '2025-03-15'),
('d.azbergenova18@gmail.com', 'Шевченко 85', 'при получении', 'Молоко сухое Modest', 1500, 'Жіберілді', NULL, '2025-03-15'),
('bake@gmail.com', 'Мирас 120', 'онлайн', 'Сок фруктовый Modest', 600, 'Жіберілді', '2025-03-15', '2025-03-15'),
('bake@gmail.com', 'Мирас 120', 'онлайн', 'Молоко сухое Modest', 1500, 'Жіберілді', '2025-03-15', '2025-03-15'),
('bake@gmail.com', 'Мирас 120', 'онлайн', 'Пюре овощное Modest', 500, 'Жіберілді', '2025-03-15', '2025-03-15'),
('bake@gmail.com', 'Аскарова 76', 'при получении', 'Молоко сухое Modest', 1500, 'Жіберілді', '2025-03-15', '2025-03-15'),
('bake@gmail.com', 'Аскарова 76', 'при получении', 'Каша молочная Modest', 800, 'Жіберілді', '2025-03-15', '2025-03-15');

-- --------------------------------------------------------

--
-- Структура таблицы `registration`
--

CREATE TABLE `registration` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `registration`
--

INSERT INTO `registration` (`name`, `email`, `phone`, `password`) VALUES
('Алексей Васильев Николаевич', 'd.azbergenova18@gmail.com', '8705465520', '$2y$10$lLFKo9xY1ckaf6eDPD8nNO4MZmy0cPReXcE/crvr/rUjDhFM9FSbO'),
('Алексей Васильев Николаевич', 'd.azbergenova18@gmail.com', '8705465520', '$2y$10$a5FvXqMk5XAFteMOo6VUCe/ophEbIBbnd5brVMipxkaJzsBaMYT6y'),
('Dilnaz', 'dilnaz@gmail.com', '87058264900', '$2y$10$8MEsx5qO0UZLFDn66sj7xO.qLSr4/srYlCEeoYgpwE07CExn6nczu'),
('Ринат', 'rinat@gmail.com', '8705465520', '$2y$10$Ze0H9osygvxxsoltwc5OqOzsQaG9jTRHmwvpDLVXtDuOO/WFmErTS'),
('Дильназ', 'dighlnaz@gmail.com', '8705465520', '$2y$10$pDBPqdT6SewbYUvuyoMfVOnJjfuCQnu0sUMwhujIE/2nmKMsomHbK'),
('berik', 'bake@gmail.com', '8745211265', '$2y$10$1EhzN26rjaR8HnA/6XxP/uNZd398HuNdcrnw6Bz7YTudzE166Qwny');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
