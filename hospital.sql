-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 29 Sie 2021, 19:30
-- Wersja serwera: 10.4.20-MariaDB
-- Wersja PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `hospital`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(600) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(600) COLLATE utf8_polish_ci NOT NULL,
  `specialisation` varchar(1000) COLLATE utf8_polish_ci NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `surname`, `specialisation`, `phone`) VALUES
(1, 'Jan', 'Kowalski', 'Chirurgia dziecięca', 502567965),
(2, 'Marcin', 'Nowak', 'Alergologia', 753579138),
(3, 'Kamil', 'Hosak', 'Audiologia i foniatria', 653642581),
(4, 'Darek', 'Kowalski', 'Chirurgia dziecięca', 508577925);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(400) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(400) COLLATE utf8_polish_ci NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `notes` varchar(1500) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `patients`
--

INSERT INTO `patients` (`id`, `name`, `surname`, `id_doctor`, `notes`) VALUES
(1, 'Gosia', 'Jurewicz', 1, 'Złamanie kości w prawej ręce'),
(2, 'Michał', 'Dzunek', 1, 'Wybicie palca u ręki '),
(3, 'Rafał', 'Szyszko ', 2, 'Leczenie schorzeń alergicznych');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN KEY` (`id_doctor`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT dla tabeli `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `FOREIGN KEY` FOREIGN KEY (`id_doctor`) REFERENCES `doctors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
