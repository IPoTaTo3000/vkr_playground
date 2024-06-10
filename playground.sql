-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.2
-- Время создания: Май 22 2024 г., 22:12
-- Версия сервера: 8.2.0
-- Версия PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `playground`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Completed_works`
--

CREATE TABLE `Completed_works` (
  `id_completed_work` int NOT NULL,
  `Date` date NOT NULL,
  `id_offer` int NOT NULL,
  `id_work` int NOT NULL,
  `id_worker` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Completed_works`
--

INSERT INTO `Completed_works` (`id_completed_work`, `Date`, `id_offer`, `id_work`, `id_worker`) VALUES
(1, '2024-05-19', 1, 6, 1),
(2, '2024-05-19', 2, 3, 2),
(3, '2024-05-19', 3, 2, 1),
(4, '2024-05-19', 4, 4, 2),
(5, '2024-05-20', 5, 3, 1),
(6, '2024-05-20', 6, 3, 2),
(7, '2024-05-20', 7, 6, 2),
(9, '2024-05-20', 8, 1, 1),
(11, '2024-05-20', 9, 2, 1),
(12, '2024-05-20', 10, 5, 2),
(13, '2024-05-20', 12, 6, 2),
(14, '2024-05-21', 17, 3, 1),
(15, '2024-05-21', 18, 3, 1),
(16, '2024-05-21', 13, 3, 2),
(17, '2024-05-21', 15, 2, 2),
(18, '2024-05-22', 11, 1, 1),
(19, '2024-05-22', 14, 3, 1),
(20, '2024-05-22', 20, 1, 1),
(21, '2024-05-22', 23, 4, 2),
(22, '2024-05-22', 25, 4, 1),
(23, '2024-05-22', 24, 1, 1),
(24, '2024-05-22', 28, 3, 1),
(25, '2024-05-22', 32, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Location`
--

CREATE TABLE `Location` (
  `id_location` int NOT NULL,
  `City` varchar(40) DEFAULT NULL,
  `District` varchar(40) DEFAULT NULL,
  `Residential_complex` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Location`
--

INSERT INTO `Location` (`id_location`, `City`, `District`, `Residential_complex`) VALUES
(1, 'Москва', 'Академический', 'Студенческий городок'),
(2, 'Москва', 'Хамовники', 'Фрунзенская набережная'),
(3, 'Москва', 'Академический', 'REPUBLIC'),
(4, 'Москва', 'Академический', 'iLove'),
(5, 'Москва', 'Хамовники', 'Метрополия'),
(6, 'Москва', 'Печатники', 'Portland'),
(7, 'Москва', 'Печатники', 'Квартал на воде');

-- --------------------------------------------------------

--
-- Структура таблицы `Offer`
--

CREATE TABLE `Offer` (
  `id_offer` int NOT NULL,
  `date_p` date NOT NULL,
  `status_p` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `discription_p` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_playground` int NOT NULL,
  `id_work` int DEFAULT NULL,
  `id_worker` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Offer`
--

INSERT INTO `Offer` (`id_offer`, `date_p`, `status_p`, `discription_p`, `id_user`, `id_playground`, `id_work`, `id_worker`) VALUES
(1, '2024-05-18', 'completed', 'all good', 1, 1, NULL, NULL),
(2, '2024-05-18', 'completed', 'all bad', 3, 2, NULL, NULL),
(3, '2024-05-18', 'completed', 'jopa', 7, 2, NULL, NULL),
(4, '2024-05-19', 'completed', 'slomana lavka', 8, 2, NULL, NULL),
(5, '2024-05-20', 'completed', 'качели подводят', 1, 2, NULL, NULL),
(6, '2024-05-20', 'completed', 'мало песка в песочнице', 1, 2, NULL, NULL),
(7, '2024-05-20', 'completed', 'slomano', 10, 2, NULL, NULL),
(8, '2024-05-20', 'completed', 'Все хорошо', 1, 2, NULL, NULL),
(9, '2024-05-20', 'completed', 'как карта ляжет', 1, 2, NULL, NULL),
(10, '2024-05-20', 'completed', 'Все отлично дизайн растет', 1, 1, NULL, NULL),
(11, '2024-05-20', 'completed', 'по второй вопросы', 1, 2, NULL, NULL),
(12, '2024-05-20', 'completed', 'с площадкой все ок', 1, 1, NULL, NULL),
(13, '2024-05-20', 'completed', '9983289', 1, 1, NULL, NULL),
(14, '2024-05-20', 'completed', 'вот оно', 1, 1, NULL, NULL),
(15, '2024-05-20', 'completed', 'по второй площадке норм', 1, 2, NULL, NULL),
(17, '2024-05-21', 'completed', 'xnj nj gbitim', 7, 2, NULL, NULL),
(18, '2024-05-21', 'completed', 'cсламаны качели', 11, 1, NULL, NULL),
(20, '2024-05-22', 'completed', 'ffsdfsdfsdafsd', 8, 1, 1, 1),
(22, '2024-05-22', 'in progress', 'dsadamkldmlkasmkl; masdkl;mdlas', 7, 1, 3, 2),
(23, '2024-05-22', 'completed', 'ddas,dkl nmekwmqwqdwq ', 7, 1, 4, 2),
(24, '2024-05-22', 'completed', 'создаю заявку 1 тест', 1, 1, 1, 1),
(25, '2024-05-22', 'completed', 'создаю заявку 2 тест', 1, 2, 4, 1),
(26, '2024-05-22', 'active', 'test style', 1, 1, NULL, NULL),
(27, '2024-05-22', 'active', 'test style 2', 1, 1, NULL, NULL),
(28, '2024-05-22', 'completed', 'test style 3', 1, 1, 3, 1),
(29, '2024-05-22', 'active', 'test style 4', 1, 1, NULL, NULL),
(30, '2024-05-22', 'active', 'test style 5', 1, 1, NULL, NULL),
(31, '2024-05-22', 'active', 'тест в папках', 1, 1, NULL, NULL),
(32, '2024-05-22', 'completed', 'проверка после оптимизации', 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Playground`
--

CREATE TABLE `Playground` (
  `Function_p` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Age` varchar(5) DEFAULT NULL,
  `Coating` varchar(20) DEFAULT NULL,
  `photo_url` varchar(200) NOT NULL,
  `id_location` int NOT NULL,
  `id_playground` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Playground`
--

INSERT INTO `Playground` (`Function_p`, `Age`, `Coating`, `photo_url`, `id_location`, `id_playground`) VALUES
('Тематическая', '6+', 'Резиновое', '../photos/photo1.jpg', 1, 1),
('Спортивная', '12+', 'Резиновое', '../photos/photo2.jpg', 1, 2),
('Детская', '0+', 'Резиновое', '../photos/photo3.jpg\r\n', 1, 3),
('Замок', '3+', 'Резиновая плитка', '../photos/photo4.jpeg\r\n', 2, 7),
('Замок', '6+', 'Асфальт', '../photos/photo5.jpg\r\n', 2, 8),
('Детская', '0+', 'Песок', '../photos/photo6.jpg\r\n', 2, 9),
('Детская', '0+', 'Резиновая плитка', '../photos/photo7.jpg\r\n', 3, 10),
('Детская', '6+', 'Резиновое', '../photos/photo8.jpg\r\n', 3, 11),
('Детская', '0+', 'Резиновое', '../photos/photo9.jpg\r\n', 4, 12),
('Детская', '6+', 'Газон', '../photos/photo10.jpg\r\n', 4, 13),
('Детская', '0+', 'Песок', '../photos/photo11.jpg\r\n', 4, 14),
('Спортивная', '6+', 'Резиновая крошка', '../photos/photo12.jpg', 5, 15),
('Замок', '3+', 'Резиновая плитка', '../photos/photo13.jpg', 5, 16),
('Детская', '0+', 'Резиновое', '../photos/photo14.jpg', 5, 17),
('Детская', '3+', 'Газон', '../photos/photo15.jpg', 5, 18),
('Детская', '6+', 'Песок', '../photos/photo16.jpg', 6, 19),
('Спортивная', '6+', 'Газон', '../photos/photo17.jpg', 6, 20),
('Спортивная', '6+', 'Песок', '../photos/photo18.jpg', 6, 21),
('Парковая', '0+', 'Газон', '../photos/photo19.jpg', 7, 22),
('Тематическая', '0+', 'Резиновое', '../photos/photo20.jpg', 7, 23);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id_user` int NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `Name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id_user`, `login`, `password`, `Name`, `Phone_number`, `Email`) VALUES
(1, 'potato', '123', 'Дед Максим', '89106941080', 'alex.anfimov@mail.ru'),
(2, 'jordano', '777', NULL, '89109941080', NULL),
(3, 'amica', '123', NULL, '81111111111', NULL),
(4, '123', '123', NULL, '89106941080', NULL),
(5, '1234', '1234', NULL, '1234', NULL),
(6, '333', '333', NULL, '333', NULL),
(7, 'frik', '555', NULL, '4567', NULL),
(8, 'homa12', 'homa12', NULL, '89158486096', NULL),
(9, 'admin', 'admin', NULL, '89107778899', NULL),
(10, 'bogdan', '123', NULL, '89156789015', NULL),
(11, 'roma', 'roma', NULL, '81111111112', NULL),
(12, 'test', 'test', NULL, '81111111113', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Work`
--

CREATE TABLE `Work` (
  `id_work` int NOT NULL,
  `Name` varchar(40) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `Discription` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Work`
--

INSERT INTO `Work` (`id_work`, `Name`, `Category`, `Discription`) VALUES
(1, 'Осмотр', 'Профилактическая', 'Проверить объект на наличие поломок и неисправностей'),
(2, 'Горка', 'Ремонт', ''),
(3, 'Качели', 'Ремонт', NULL),
(4, 'Лавочка', 'Ремонт', NULL),
(5, 'Газон', 'Уход', NULL),
(6, 'Песок в печонице', 'Уход', 'Обновить или добавить песок в песочницу');

-- --------------------------------------------------------

--
-- Структура таблицы `Worker`
--

CREATE TABLE `Worker` (
  `id_worker` int NOT NULL,
  `Company_name` varchar(40) DEFAULT NULL,
  `Company_adress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Phone_number` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Worker`
--

INSERT INTO `Worker` (`id_worker`, `Company_name`, `Company_adress`, `Phone_number`) VALUES
(1, 'РемонтМосква', 'г. Москва, ул. Донская, д. 8 стр. 1', '89156783462'),
(2, 'МскСтройИнк', ' г. Москва, пр. Вернадского, д. 43', '89108996565'),
(3, 'АртРемонт', 'г. Москва, Золоторожский вал д.32, стр.4', '772201001'),
(4, 'СВсервис', 'Улица Льва Толстого, 23 к7 ст3 ', '18770394'),
(5, 'Вира-АртСтрой', 'г. Москва, ул. Берзарина, д. 23.', '044525411'),
(6, 'Студия Ремонтов', 'г. Москва, Пресненская набережная 12, Башня Федерация Восток\r\nэтаж 42', '11677464045'),
(7, 'Домео', ' г Москва, набережная Лужнецкая, дом 2/4 строение 17', '7704374157');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Completed_works`
--
ALTER TABLE `Completed_works`
  ADD PRIMARY KEY (`id_completed_work`),
  ADD KEY `id_worker` (`id_worker`),
  ADD KEY `id_work` (`id_work`),
  ADD KEY `id_offer` (`id_offer`);

--
-- Индексы таблицы `Location`
--
ALTER TABLE `Location`
  ADD PRIMARY KEY (`id_location`),
  ADD KEY `id_location` (`id_location`);

--
-- Индексы таблицы `Offer`
--
ALTER TABLE `Offer`
  ADD PRIMARY KEY (`id_offer`),
  ADD KEY `id_user` (`id_user`) USING BTREE,
  ADD KEY `id_playground` (`id_playground`),
  ADD KEY `id_work` (`id_work`),
  ADD KEY `id_worker` (`id_worker`);

--
-- Индексы таблицы `Playground`
--
ALTER TABLE `Playground`
  ADD PRIMARY KEY (`id_playground`),
  ADD KEY `id_location` (`id_location`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id_user`);

--
-- Индексы таблицы `Work`
--
ALTER TABLE `Work`
  ADD PRIMARY KEY (`id_work`);

--
-- Индексы таблицы `Worker`
--
ALTER TABLE `Worker`
  ADD PRIMARY KEY (`id_worker`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Completed_works`
--
ALTER TABLE `Completed_works`
  MODIFY `id_completed_work` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `Location`
--
ALTER TABLE `Location`
  MODIFY `id_location` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `Offer`
--
ALTER TABLE `Offer`
  MODIFY `id_offer` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `Playground`
--
ALTER TABLE `Playground`
  MODIFY `id_playground` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `Work`
--
ALTER TABLE `Work`
  MODIFY `id_work` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `Worker`
--
ALTER TABLE `Worker`
  MODIFY `id_worker` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Completed_works`
--
ALTER TABLE `Completed_works`
  ADD CONSTRAINT `completed_works_ibfk_1` FOREIGN KEY (`id_worker`) REFERENCES `Worker` (`id_worker`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `completed_works_ibfk_2` FOREIGN KEY (`id_work`) REFERENCES `Work` (`id_work`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `completed_works_ibfk_3` FOREIGN KEY (`id_offer`) REFERENCES `Offer` (`id_offer`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `Offer`
--
ALTER TABLE `Offer`
  ADD CONSTRAINT `offer_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `offer_ibfk_5` FOREIGN KEY (`id_playground`) REFERENCES `Playground` (`id_playground`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `offer_ibfk_6` FOREIGN KEY (`id_work`) REFERENCES `Work` (`id_work`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `offer_ibfk_7` FOREIGN KEY (`id_worker`) REFERENCES `Worker` (`id_worker`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `Playground`
--
ALTER TABLE `Playground`
  ADD CONSTRAINT `playground_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `Location` (`id_location`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
