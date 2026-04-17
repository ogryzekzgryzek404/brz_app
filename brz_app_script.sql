-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2025 at 09:19 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `brz_kategorie` (
  `ids` int(11) NOT NULL,
  `kategoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `brz_kategorie` (`ids`, `kategoria`) VALUES
(7, 'telefon komórkowy'),
(8, 'portfel z zawartością'),
(9, 'aparat fotograficzny'),
(10, 'pieniądze'),
(11, 'dokumenty'),
(12, 'bagaż z zawartością'),
(13, 'zegarek'),
(14, 'klucz'),
(15, 'karta bankowa'),
(16, 'etui z zawartością'),
(17, 'rower'),
(18, 'wózek'),
(19, 'laptop'),
(20, 'tablet'),
(21, 'inny sprzęt elektroniczny'),
(22, 'biżuteria'),
(23, 'plecak z zawartością'),
(24, 'hulajnoga'),
(25, 'inne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rejestr`
--

CREATE TABLE `brz_rejestr` (
  `ids` int(11) NOT NULL,
  `data_znalezienia` date NOT NULL,
  `termin_odbioru` date DEFAULT NULL,
  `miejsce_znalezienia` varchar(255) NOT NULL,
  `rodzaj_rzeczy` int(11) NOT NULL,
  `opis_rzeczy` longtext NOT NULL,
  `numer_seryjny` varchar(255) DEFAULT NULL,
  `hash_numeru` varchar(255) DEFAULT NULL,
  `id_urzedu` int(11) NOT NULL,
  `znak_sprawy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `rok_rejestracji` datetime DEFAULT NULL,
  `OZ` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rejestr`
--

INSERT INTO `brz_rejestr` (`ids`, `data_znalezienia`, `termin_odbioru`, `miejsce_znalezienia`, `rodzaj_rzeczy`, `opis_rzeczy`, `numer_seryjny`, `hash_numeru`, `id_urzedu`, `znak_sprawy`, `rok_rejestracji`, `OZ`) VALUES
(1, '2025-12-06', NULL, 'Hackaton Bydgozcz', 7, 'fdfdfdfd', 'trtr', 'f90006008a3a13163c974bd2eba85c72b24c7a391a3aefa08097ea635fe319f1', 1, '1/2025', NULL, 0),
(2, '2025-12-09', NULL, 'sklep żabka - Bydgoszcz', 9, 'Canon lustrzanka', 'cfdvdvd', '04b02a0709f52c37a9e4e02d7573577fbcf028ad8bcb0ac3f34d7a2f254cd0ef', 1, '2/2025', NULL, 0),
(3, '2025-12-17', NULL, 'Plac zabaw w Bydgoszczy', 14, 'fdfdfd', 'fd', '8bd574fdb05c2dc5017188a2f4c32d5b81963e0a33eccba92404e968c665006d', 1, '3/2025', NULL, 0),
(4, '2025-12-03', '2027-12-03', 'Centrum Bydgoszczy', 22, 'Złota obrączka z grawerunkiem', '', NULL, 1, '4/2025', NULL, 0),
(5, '2024-12-04', '2026-12-04', 'Bydgoszcz', 14, 'do samochodu KIA', '', NULL, 1, '1/2024', NULL, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `urzedy`
--

CREATE TABLE `brz_urzedy` (
  `ids` int(11) NOT NULL,
  `nazwa_urzedu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `urzedy`
--

INSERT INTO `brz_urzedy` (`ids`, `nazwa_urzedu`) VALUES
(1, 'Starostwo Powiatowe w Bolesławcu'),
(2, 'Starostwo Powiatowe w Dzierżoniowie'),
(3, 'Starostwo Powiatowe w Głogowie'),
(4, 'Starostwo Powiatowe w Górze'),
(5, 'Starostwo Powiatowe w Jaworze'),
(6, 'Urząd Miasta Jelenia Góra'),
(7, 'Starostwo Powiatowe w Kamiennej Górze'),
(8, 'Starostwo Powiatowe w Jeleniej Górze'),
(9, 'Starostwo Powiatowe w Kłodzku'),
(10, 'Urząd Miasta Legnicy'),
(11, 'Starostwo Powiatowe w Legnicy'),
(12, 'Starostwo Powiatowe w Lubaniu'),
(13, 'Starostwo Powiatowe w Lubinie'),
(14, 'Starostwo Powiatowe w Lwówku Śląskim'),
(15, 'Starostwo Powiatowe w Miliczu'),
(16, 'Starostwo Powiatowe w Oleśnicy'),
(17, 'Starostwo Powiatowe w Oławie'),
(18, 'Starostwo Powiatowe w Polkowicach'),
(19, 'Starostwo Powiatowe w Strzelinie'),
(20, 'Starostwo Powiatowe w Środzie Śląskiej'),
(21, 'Starostwo Powiatowe w Świdnicy'),
(22, 'Starostwo Powiatowe w Trzebnicy'),
(23, 'Urząd Miejski w Wałbrzychu'),
(24, 'Starostwo Powiatowe w Wałbrzychu'),
(25, 'Starostwo Powiatowe w Wołowie'),
(26, 'Urząd Miejski Wrocławia'),
(27, 'Starostwo Powiatowe we Wrocławiu'),
(28, 'Starostwo Powiatowe w Ząbkowicach Śląskich'),
(29, 'Starostwo Powiatowe w Zgorzelcu'),
(30, 'Starostwo Powiatowe w Złotoryi'),
(31, 'Starostwo Powiatowe w Aleksandrowie Kujawskim'),
(32, 'Starostwo Powiatowe w Brodnicy'),
(33, 'Starostwo Powiatowe w Bydgoszczy'),
(34, 'Urząd Miasta Bydgoszczy'),
(35, 'Starostwo Powiatowe w Chełmnie'),
(36, 'Starostwo Powiatowe w Golubiu - Dobrzyniu'),
(37, 'Urząd Miejski w Grudziądzu'),
(38, 'Starostwo Powiatowe w Grudziądzu'),
(39, 'Starostwo Powiatowe w Inowrocławiu'),
(40, 'Starostwo Powiatowe w Lipnie'),
(41, 'Starostwo Powiatowe w Mogilnie'),
(42, 'Starostwo Powiatowe w Nakle nad Notecią'),
(43, 'Starostwo Powiatowe w Radziejowie'),
(44, 'Starostwo Powiatowe w Rypinie'),
(45, 'Starostwo Powiatowe w Sępólnie Krajeńskim'),
(46, 'Starostwo Powiatowe w Świeciu'),
(47, 'Urząd Miasta Torunia'),
(48, 'Starostwo Powiatowe w Toruniu'),
(49, 'Starostwo Powiatowe w Tucholi'),
(50, 'Starostwo Powiatowe w Wąbrzeźnie'),
(51, 'Urząd Miasta Włocławek'),
(52, 'Starostwo Powiatowe we Włocławku'),
(53, 'Starostwo Powiatowe w Żninie'),
(54, 'Starostwo Powiatowe w Białej Podlaskiej'),
(55, 'Urząd Miasta Biała Podlaska'),
(56, 'Starostwo Powiatowe w Biłgoraju'),
(57, 'Urząd Miasta Chełm'),
(58, 'Starostwo Powiatowe w Chełmie'),
(59, 'Starostwo Powiatowe w Hrubieszowie'),
(60, 'Starostwo Powiatowe w Janowie Lubelskim'),
(61, 'Starostwo Powiatowe w Krasnymstawie'),
(62, 'Starostwo Powiatowe w Kraśniku'),
(63, 'Starostwo Powiatowe w Lubartowie'),
(64, 'Starostwo Powiatowe w Lublinie'),
(65, 'Urząd Miasta Lublin'),
(66, 'Starostwo Powiatowe w Łęcznej'),
(67, 'Starostwo Powiatowe w Łukowie'),
(68, 'Starostwo Powiatowe w Opolu Lubelskim'),
(69, 'Starostwo Powiatowe w Parczewie'),
(70, 'Starostwo Powiatowe w Puławach'),
(71, 'Starostwo Powiatowe w Radzyniu Podlaskim'),
(72, 'Starostwo Powiatowe w Rykach'),
(73, 'Starostwo Powiatowe w Świdniku'),
(74, 'Starostwo Powiatowe w Tomaszowie Lubelskim'),
(75, 'Starostwo Powiatowe we Włodawie'),
(76, 'Starostwo Powiatowe w Zamościu'),
(77, 'Urząd Miasta Zamość'),
(78, 'Starostwo Powiatowe w Gorzowie Wielkopolskim'),
(79, 'Urząd Miasta Gorzowa Wielkopolskiego'),
(80, 'Starostwo Powiatowe w Krośnie Odrzańskim'),
(81, 'Starostwo Powiatowe w Międzyrzeczu'),
(82, 'Starostwo Powiatowe w Nowej Soli'),
(83, 'Starostwo Powiatowe w Słubicach'),
(84, 'Starostwo Powiatowe w Strzelcach Krajeńskich'),
(85, 'Starostwo Powiatowe w Sulęcinie'),
(86, 'Starostwo Powiatowe w Świebodzinie'),
(87, 'Starostwo Powiatowe we Wschowie'),
(88, 'Urząd Miasta Zielona Góra'),
(89, 'Starostwo Powiatowe w Zielonej Górze'),
(90, 'Starostwo Powiatowe w Żaganiu'),
(91, 'Starostwo Powiatowe w Żarach'),
(92, 'Starostwo Powiatowe w Bełchatowie'),
(93, 'Starostwo Powiatowe w Brzezinach'),
(94, 'Starostwo Powiatowe w Kutnie'),
(95, 'Starostwo Powiatowe w Łasku'),
(96, 'Starostwo Powiatowe w Łęczycy'),
(97, 'Starostwo Powiatowe w Łowiczu'),
(98, 'Starostwo Powiatowe w Łodzi'),
(99, 'Urząd Miasta Łodzi'),
(100, 'Starostwo Powiatowe w Opocznie'),
(101, 'Starostwo Powiatowe w Pabianicach'),
(102, 'Starostwo Powiatowe w Pajęcznie'),
(103, 'Starostwo Powiatowe w Piotrkowie Trybunalskim'),
(104, 'Urząd Miasta Piotrkowa Trybunalskiego'),
(105, 'Starostwo Powiatowe w Poddębicach'),
(106, 'Starostwo Powiatowe w Radomsku'),
(107, 'Starostwo Powiatowe w Rawie Mazowieckiej'),
(108, 'Starostwo Powiatowe w Sieradzu'),
(109, 'Urząd Miasta Skierniewice'),
(110, 'Starostwo Powiatowe w Skierniewicach'),
(111, 'Starostwo Powiatowe w Tomaszowie Mazowieckim'),
(112, 'Starostwo Powiatowe w Wieluniu'),
(113, 'Starostwo Powiatowe w Wieruszowie'),
(114, 'Starostwo Powiatowe w Zduńskiej Woli'),
(115, 'Starostwo Powiatowe w Zgierzu'),
(116, 'Starostwo Powiatowe w Bochni'),
(117, 'Starostwo Powiatowe w Brzesku'),
(118, 'Starostwo Powiatowe w Chrzanowie'),
(119, 'Starostwo Powiatowe w Dąbrowie Tarnowskiej'),
(120, 'Starostwo Powiatowe w Gorlicach'),
(121, 'Starostwo Powiatowe w Krakowie'),
(122, 'Urząd Miasta Krakowa'),
(123, 'Starostwo Powiatowe w Limanowej'),
(124, 'Starostwo Powiatowe w Miechowie'),
(125, 'Starostwo Powiatowe w Myślenicach '),
(126, 'Starostwo Powiatowe w Nowym Sączu'),
(127, 'Starostwo Powiatowe w Nowym Targu'),
(128, 'Urząd Miasta Nowego Sącza'),
(129, 'Starostwo Powiatowe w Olkuszu'),
(130, 'Starostwo Powiatowe w Oświęcimiu'),
(131, 'Starostwo Powiatowe w Proszowicach'),
(132, 'Starostwo Powiatowe w Suchej Beskidzkiej'),
(133, 'Starostwo Powiatowe w Tarnowie'),
(134, 'Urząd Miasta Tarnowa'),
(135, 'Starostwo Powiatowe w Zakopanem'),
(136, 'Starostwo Powiatowe w Wadowicach'),
(137, 'Starostwo Powiatowe w Wieliczce'),
(138, 'Starostwo Powiatowe w Białobrzegach'),
(139, 'Starostwo Powiatowe w Ciechanowie'),
(140, 'Starostwo Powiatowe w Garwolinie'),
(141, 'Starostwo Powiatowe w Gostyninie'),
(142, 'Starostwo Powiatowe w Grodzisku Mazowieckim'),
(143, 'Starostwo Powiatowe w Grójcu'),
(144, 'Starostwo Powiatowe w Kozienicach'),
(145, 'Starostwo Powiatowe w Legionowie'),
(146, 'Starostwo Powiatowe w Lipsku'),
(147, 'Starostwo Powiatowe w Łosicach'),
(148, 'Starostwo Powiatowe w Makowie Mazowieckim'),
(149, 'Starostwo Powiatowe w Mińsku Mazowieckim'),
(150, 'Starostwo Powiatowe w Mławie'),
(151, 'Starostwo Powiatowe w Nowym Dworze Mazowieckim'),
(152, 'Starostwo Powiatowe w Ostrołęce'),
(153, 'Urząd Miasta Ostrołęki'),
(154, 'Starostwo Powiatowe w Ostrowi Mazowieckiej'),
(155, 'Starostwo Powiatowe w Otwocku'),
(156, 'Starostwo Powiatowe w Piasecznie'),
(157, 'Urząd Miasta Płocka'),
(158, 'Starostwo Powiatowe w Płocku'),
(159, 'Starostwo Powiatowe w Płońsku'),
(160, 'Starostwo Powiatowe w Pruszkowie'),
(161, 'Starostwo Powiatowe w Przasnyszu'),
(162, 'Starostwo Powiatowe w Przysusze'),
(163, 'Starostwo Powiatowe w Pułtusku'),
(164, 'Urząd Miejski w Radomiu'),
(165, 'Starostwo Powiatowe w Radomiu'),
(166, 'Urząd Miasta Siedlce'),
(167, 'Starostwo Powiatowe w Siedlcach'),
(168, 'Starostwo Powiatowe w Sierpcu'),
(169, 'Starostwo Powiatowe w Sochaczewie'),
(170, 'Starostwo Powiatowe w Sokołowie Podlaskim'),
(171, 'Starostwo Powiatowe w Szydłowcu'),
(172, 'Urząd Miasta Stołecznego Warszawy'),
(173, 'Starostwo Powiatowe w Ożarowie Mazowieckim'),
(174, 'Starostwo Powiatowe w Węgrowie'),
(175, 'Starostwo Powiatowe w Wołominie'),
(176, 'Starostwo Powiatowe w Wyszkowie'),
(177, 'Starostwo Powiatowe w Zwoleniu'),
(178, 'Starostwo Powiatowe w Żurominie'),
(179, 'Starostwo Powiatowe w Żyrardowie'),
(180, 'Starostwo Powiatowe w Brzegu'),
(181, 'Starostwo Powiatowe w Głubczycach'),
(182, 'Starostwo Powiatowe w Kędzierzynie-Koźlu'),
(183, 'Starostwo Powiatowe w Kluczborku'),
(184, 'Starostwo Powiatowe w Krapkowicach'),
(185, 'Starostwo Powiatowe w Namysłowie'),
(186, 'Starostwo Powiatowe w Nysie'),
(187, 'Starostwo Powiatowe w Oleśnie'),
(188, 'Urząd Miasta Opola'),
(189, 'Starostwo Powiatowe w Opolu'),
(190, 'Starostwo Powiatowe w Prudniku'),
(191, 'Starostwo Powiatowe w Strzelcach Opolskich'),
(192, 'Starostwo Powiatowe w Ustrzykach Dolnych'),
(193, 'Starostwo Powiatowe w Brzozowie'),
(194, 'Starostwo Powiatowe w Dębicy'),
(195, 'Starostwo Powiatowe w Jarosławiu'),
(196, 'Starostwo Powiatowe w Jaśle'),
(197, 'Starostwo Powiatowe w Kolbuszowej'),
(198, 'Urząd Miasta Krosna'),
(199, 'Starostwo Powiatowe w Krośnie'),
(200, 'Starostwo Powiatowe w Lesku'),
(201, 'Starostwo Powiatowe w Leżajsku'),
(202, 'Starostwo Powiatowe w Lubaczowie'),
(203, 'Starostwo Powiatowe w Łańcucie'),
(204, 'Starostwo Powiatowe w Mielcu'),
(205, 'Starostwo Powiatowe w Nisku'),
(206, 'Starostwo Powiatowe w Przemyślu'),
(207, 'Urząd Miejski w Przemyślu'),
(208, 'Starostwo Powiatowe w Przeworsku'),
(209, 'Starostwo Powiatowe w Ropczycach'),
(210, 'Starostwo Powiatowe w Rzeszowie'),
(211, 'Urząd Miasta Rzeszowa'),
(212, 'Starostwo Powiatowe w Sanoku'),
(213, 'Starostwo Powiatowe w Stalowej Woli'),
(214, 'Starostwo Powiatowe w Strzyżowie'),
(215, 'Urząd Miasta Tarnobrzega'),
(216, 'Starostwo Powiatowe w Tarnobrzegu'),
(217, 'Starostwo Powiatowe w Augustowie'),
(218, 'Starostwo Powiatowe w Białymstoku'),
(219, 'Urząd Miejski w Białymstoku'),
(220, 'Starostwo Powiatowe w Bielsku Podlaskim'),
(221, 'Starostwo Powiatowe w Grajewie'),
(222, 'Starostwo Powiatowe w Hajnówce'),
(223, 'Starostwo Powiatowe w Kolnie'),
(224, 'Urząd Miejski w Łomży'),
(225, 'Starostwo Powiatowe w Łomży'),
(226, 'Starostwo Powiatowe w Mońkach'),
(227, 'Starostwo Powiatowe w Sejnach'),
(228, 'Starostwo Powiatowe w Siemiatyczach'),
(229, 'Starostwo Powiatowe w Sokółkce'),
(230, 'Starostwo Powiatowe w Suwałkach'),
(231, 'Urząd Miejski w Suwałkach'),
(232, 'Starostwo Powiatowe w Wysokiem Mazowieckiem'),
(233, 'Starostwo Powiatowe w Zambrowie'),
(234, 'Starostwo Powiatowe w Bytowie'),
(235, 'Starostwo Powiatowe w Chojnicach'),
(236, 'Starostwo Powiatowe w Człuchowie'),
(237, 'Urząd Miejski w Gdańsku'),
(238, 'Starostwo Powiatowe w Pruszczu Gdańskim'),
(239, 'Urząd Miasta Gdyni'),
(240, 'Starostwo Powiatowe w Kartuzach'),
(241, 'Starostwo Powiatowe w Kościerzynie'),
(242, 'Starostwo Powiatowe w Kwidzynie'),
(243, 'Starostwo Powiatowe w Lęborku'),
(244, 'Starostwo Powiatowe w Malborku'),
(245, 'Starostwo Powiatowe w Nowym Dworze Gdańskim'),
(246, 'Starostwo Powiatowe w Pucku'),
(247, 'Urząd Miejski w Słupsku'),
(248, 'Starostwo Powiatowe w Słupsku'),
(249, 'Urząd Miasta Sopotu'),
(250, 'Starostwo Powiatowe w Starogardzie Gdańskim'),
(251, 'Starostwo Powiatowe w Sztumie'),
(252, 'Starostwo Powiatowe w Tczewie'),
(253, 'Starostwo Powiatowe w Wejherowie'),
(254, 'Starostwo Powiatowe w Będzinie'),
(255, 'Starostwo Powiatowe w Bielsku-Białej'),
(256, 'Urząd Miejski w Bielsku-Białej'),
(257, 'Starostwo Powiatowe w Bieruniu'),
(258, 'Urząd Miejski w Bytomiu'),
(259, 'Urząd Miasta Chorzów'),
(260, 'Starostwo Powiatowe w Cieszynie'),
(261, 'Urząd Miasta Częstochowy'),
(262, 'Starostwo Powiatowe w Częstochowie'),
(263, 'Urząd Miejski w Dąbrowie Górniczej'),
(264, 'Urząd Miejski w Gliwicach'),
(265, 'Starostwo Powiatowe w Gliwicach'),
(266, 'Urząd Miasta Jastrzębie-Zdrój'),
(267, 'Urząd Miejski w Jaworznie'),
(268, 'Urząd Miasta Katowice'),
(269, 'Starostwo Powiatowe w Kłobucku'),
(270, 'Starostwo Powiatowe w Lublińcu'),
(271, 'Starostwo Powiatowe w Mikołowie'),
(272, 'Urząd Miasta Mysłowice'),
(273, 'Starostwo Powiatowe w Myszkowie'),
(274, 'Urząd Miasta Piekary Śląskie'),
(275, 'Starostwo Powiatowe w Pszczynie'),
(276, 'Starostwo Powiatowe w Raciborzu'),
(277, 'Urząd Miasta Ruda Śląska'),
(278, 'Starostwo Powiatowe w Rybniku'),
(279, 'Urząd Miasta Rybnika'),
(280, 'Urząd Miasta Siemianowice Śląskie'),
(281, 'Urząd Miejski w Sosnowcu'),
(282, 'Urząd Miejski w Świętochłowicach'),
(283, 'Starostwo Powiatowe w Tarnowskich Górach'),
(284, 'Urząd Miasta Tychy'),
(285, 'Starostwo Powiatowe w Wodzisławiu Śląskim'),
(286, 'Urząd Miejski w Zabrzu'),
(287, 'Starostwo Powiatowe w Zawierciu'),
(288, 'Urząd Miasta Żory'),
(289, 'Starostwo Powiatowe w Żywcu'),
(290, 'Starostwo Powiatowe w Busku-Zdroju'),
(291, 'Starostwo Powiatowe w Jędrzejowie'),
(292, 'Starostwo Powiatowe w Kazimierzy Wielkiej'),
(293, 'Urząd Miasta Kielce'),
(294, 'Starostwo Powiatowe w Kielcach'),
(295, 'Starostwo Powiatowe w Końskich'),
(296, 'Starostwo Powiatowe w Opatowie'),
(297, 'Starostwo Powiatowe w Ostrowcu Świętokrzyskim'),
(298, 'Starostwo Powiatowe w Pińczowie'),
(299, 'Starostwo Powiatowe w Sandomierzu'),
(300, 'Starostwo Powiatowe w Skarżysko – Kamiennej'),
(301, 'Starostwo Powiatowe w Starachowicach'),
(302, 'Starostwo Powiatowe w Staszowie'),
(303, 'Starostwo Powiatowe we Włoszczowie'),
(304, 'Starostwo Powiatowe w Bartoszycach'),
(305, 'Starostwo Powiatowe w Braniewie'),
(306, 'Starostwo Powiatowe w Działdowie'),
(307, 'Urząd Miejski w Elblągu'),
(308, 'Starostwo Powiatowe w Ełku'),
(309, 'Starostwo Powiatowe w Giżycku'),
(310, 'Starostwo Powiatowe w Gołdapi'),
(311, 'Starostwo Powiatowe w Iławie'),
(312, 'Starostwo Powiatowe w Kętrzynie'),
(313, 'Starostwo Powiatowe w Lidzbarku Warmińskim'),
(314, 'Starostwo Powiatowe w Mrągowie'),
(315, 'Starostwo Powiatowe w Nidzicy'),
(316, 'Starostwo Powiatowe w Nowym Mieście Lubawskim'),
(317, 'Starostwo Powiatowe w Olecku'),
(318, 'Urząd Miasta Olsztyna'),
(319, 'Starostwo Powiatowe w Olsztynie'),
(320, 'Starostwo Powiatowe w Ostródzie'),
(321, 'Starostwo Powiatowe w Piszu'),
(322, 'Starostwo Powiatowe w Szczytnie'),
(323, 'Starostwo Powiatowe w Węgorzewie'),
(324, 'Starostwo Powiatowe w Elblągu'),
(325, 'Urząd Miasta Kalisza'),
(326, 'Urząd Miejski w Koninie'),
(327, 'Urząd Miasta Leszna'),
(328, 'Starostwo Powiatowe w Chodzieży'),
(329, 'Starostwo Powiatowe w Czarnkowie'),
(330, 'Starostwo Powiatowe w Gnieźnie'),
(331, 'Starostwo Powiatowe w Gostyniu'),
(332, 'Starostwo Powiatowe w Grodzisku Wielkopolskim'),
(333, 'Starostwo Powiatowe w Jarocinie'),
(334, 'Starostwo Powiatowe w Kaliszu'),
(335, 'Starostwo Powiatowe w Kępnie'),
(336, 'Starostwo Powiatowe w Kole'),
(337, 'Starostwo Powiatowe w Koninie'),
(338, 'Starostwo Powiatowe w Kościanie'),
(339, 'Starostwo Powiatowe w Krotoszynie'),
(340, 'Starostwo Powiatowe w Lesznie'),
(341, 'Starostwo Powiatowe w Międzychodzie'),
(342, 'Starostwo Powiatowe w Nowym Tomyślu'),
(343, 'Starostwo Powiatowe w Obornikach'),
(344, 'Starostwo Powiatowe w Ostrowie Wielkopolskim'),
(345, 'Starostwo Powiatowe w Ostrzeszowie'),
(346, 'Starostwo Powiatowe w Pile'),
(347, 'Starostwo Powiatowe w Pleszewie'),
(348, 'Starostwo Powiatowe w Poznaniu'),
(349, 'Starostwo Powiatowe w Rawiczu'),
(350, 'Starostwo Powiatowe w Słupcy'),
(351, 'Starostwo Powiatowe w Szamotułach'),
(352, 'Starostwo Powiatowe w Środzie Wielkopolskiej'),
(353, 'Starostwo Powiatowe w Śremie'),
(354, 'Starostwo Powiatowe w Turku'),
(355, 'Starostwo Powiatowe w Wągrowcu'),
(356, 'Starostwo Powiatowe w Wolsztynie'),
(357, 'Starostwo Powiatowe we Wrześni'),
(358, 'Starostwo Powiatowe w Złotowie'),
(359, 'Urząd Miasta Poznania'),
(360, 'Starostwo Powiatowe w Białogradzie'),
(361, 'Starostwo Powiatowe w Choszcznie'),
(362, 'Starostwo Powiatowe w Drawsku Pomorskim'),
(363, 'Starostwo Powiatowe w Goleniowie'),
(364, 'Starostwo Powiatowe w Gryficach'),
(365, 'Starostwo Powiatowe w Gryfinie'),
(366, 'Starostwo Powiatowe w Kamieniu Pomorskim'),
(367, 'Starostwo Powiatowe w Kołobrzegu'),
(368, 'Urząd Miejski w Koszalinie'),
(369, 'Starostwo Powiatowe w Koszalinie'),
(370, 'Starostwo Powiatowe w Łobzie'),
(371, 'Starostwo Powiatowe w Myśliborzu'),
(372, 'Starostwo Powiatowe w Policach'),
(373, 'Starostwo Powiatowe w Pyrzycach'),
(374, 'Starostwo Powiatowe w Sławnie'),
(375, 'Starostwo Powiatowe w Stargardzie '),
(376, 'Urząd Miasta Szczecin'),
(377, 'Starostwo Powiatowe w Szczecinku'),
(378, 'Starostwo Powiatowe w Świdwinie'),
(379, 'Urząd Miasta Świnoujście'),
(380, 'Starostwo Powiatowe w Wałczu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `brz_uzytkownicy` (
  `ids` varchar(255) NOT NULL,
  `imie_i_nazwisko` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `ids_urzedu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `brz_uzytkownicy` (`ids`, `imie_i_nazwisko`, `password_hash`, `ids_urzedu`) VALUES
('test', 'Zdzisław Dyrma', '$2y$10$un9X0F6Di2Xg.zDDP4cnOO62HUcmKIAstkw2OkCIgBChmLXIrkVyS', 1);
-- ,('test1', 'Olga Malinowska', '$2y$10$D1eMnQdumb3xz76wuATI9OgvPeaBb/1K/AAnaLqg5Jj/10PzV079i', 32);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `api_keys`
--
-- ALTER TABLE `api_keys`
--  ADD PRIMARY KEY (`id`),
--  ADD UNIQUE KEY `api_key` (`api_key`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `brz_kategorie`
  ADD PRIMARY KEY (`ids`);

--
-- Indeksy dla tabeli `rejestr`
--
ALTER TABLE `brz_rejestr`
  ADD PRIMARY KEY (`ids`),
  ADD KEY `fk_rejestr_kategorie` (`rodzaj_rzeczy`),
  ADD KEY `fk_rejestr_urzedy` (`id_urzedu`);

--
-- Indeksy dla tabeli `urzedy`
--
ALTER TABLE `brz_urzedy`
  ADD PRIMARY KEY (`ids`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `brz_uzytkownicy`
  ADD PRIMARY KEY (`ids`),
  ADD KEY `fk_urzedy` (`ids_urzedu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_keys`
--
-- ALTER TABLE `api_keys`
--  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `brz_kategorie`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `rejestr`
--
ALTER TABLE `brz_rejestr`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `urzedy`
--
ALTER TABLE `brz_urzedy`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rejestr`
--
ALTER TABLE `brz_rejestr`
  ADD CONSTRAINT `fk_rejestr_kategorie` FOREIGN KEY (`rodzaj_rzeczy`) REFERENCES `brz_kategorie` (`ids`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rejestr_urzedy` FOREIGN KEY (`id_urzedu`) REFERENCES `brz_urzedy` (`ids`) ON UPDATE CASCADE;

--
-- Constraints for table `uzytkownicy`
--
ALTER TABLE `brz_uzytkownicy`
  ADD CONSTRAINT `fk_urzedy` FOREIGN KEY (`ids_urzedu`) REFERENCES `brz_urzedy` (`ids`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
