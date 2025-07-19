-- phpMyAdmin SQL Dump
-- version 4.0.7
-- http://www.phpmyadmin.net
--
-- Darbinė stotis: localhost
-- Atlikimo laikas: 2014 m. Grd 30 d. 14:12
-- Serverio versija: 5.5.32
-- PHP versija: 5.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Duomenų bazė: `pox_dbz1`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `aukcijonas`
--

CREATE TABLE IF NOT EXISTS `aukcijonas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kas` varchar(15) NOT NULL,
  `preke` int(11) NOT NULL,
  `kiek` int(11) NOT NULL,
  `kaina` bigint(20) NOT NULL,
  `valiuta` int(11) NOT NULL,
  `laikas` int(11) NOT NULL,
  `pskirta` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=572 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `auros`
--

CREATE TABLE IF NOT EXISTS `auros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) NOT NULL,
  `aura1` varchar(2) NOT NULL,
  `aura2` varchar(2) NOT NULL,
  `aura3` varchar(2) NOT NULL,
  `aura4` varchar(2) NOT NULL,
  `aura5` varchar(2) NOT NULL,
  `aura6` varchar(2) NOT NULL,
  `aura7` varchar(2) NOT NULL,
  `aura8` varchar(2) NOT NULL,
  `aura9` varchar(2) NOT NULL,
  `aura10` varchar(2) NOT NULL,
  `aura11` varchar(2) NOT NULL,
  `aura12` varchar(2) NOT NULL,
  `aura13` varchar(2) NOT NULL,
  `aura14` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `auru_inf`
--

CREATE TABLE IF NOT EXISTS `auru_inf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `img` varchar(100) NOT NULL,
  `lygis` int(11) NOT NULL,
  `jegos` int(11) NOT NULL,
  `gynybos` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Sukurta duomenų kopija lentelei `auru_inf`
--

INSERT INTO `auru_inf` (`id`, `name`, `img`, `lygis`, `jegos`, `gynybos`) VALUES
(1, 'Standartinė aura', 'img/auros/1.png', 10, 10000, 12000),
(2, 'Purpurinė aura', 'img/auros/2.png', 20, 20000, 24000),
(3, 'Rožinė aura', 'img/auros/3.png', 30, 62000, 74000),
(4, 'Kaio-Ken aura', 'img/auros/4.png', 40, 104000, 124000),
(5, 'Energy Barrier aura', 'img/auros/5.png', 50, 208000, 248000),
(6, 'Cell''s Dead Soul aura', 'img/auros/6.png', 55, 416000, 496000),
(7, 'Super Saiyan aura', 'img/auros/7.png', 60, 832000, 992000),
(8, 'Ultra Super Saiyan aura', 'img/auros/8.png', 65, 1664000, 1984000),
(9, 'Genki Dama aura', 'img/auros/9.png', 70, 3328000, 3968000),
(10, 'Pushing aura', 'img/auros/10.png', 75, 4828000, 5468000),
(11, 'Majin aura', 'img/auros/11.png', 80, 6028000, 6668000),
(12, 'Mystic aura', 'img/auros/12.png', 90, 7328000, 7868000),
(13, 'Powering Super Saiyan aura', 'img/auros/13.png', 100, 8569000, 9218000),
(14, 'Super Saiyan Attack aura', 'img/auros/14.png', 110, 9376000, 9961800);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `balsavimas`
--

CREATE TABLE IF NOT EXISTS `balsavimas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klausimas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `autorius` varchar(100) NOT NULL,
  `ats` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `ats2` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `ats3` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Sukurta duomenų kopija lentelei `balsavimas`
--

INSERT INTO `balsavimas` (`id`, `klausimas`, `autorius`, `ats`, `ats2`, `ats3`) VALUES
(1, 'Kaip jūms žaidimas?', 'bleaz', 'Geras', 'Lievas', 'Neblogas'),
(2, 'Koks adresas būtų geriausias šiam žaidimui?', 'bleaz', 'wapdbf.eu', 'wdbf.eu', 'wdbzl.eu');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `bals_rez`
--

CREATE TABLE IF NOT EXISTS `bals_rez` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(25) NOT NULL,
  `ats` varchar(25) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `bals_id` int(11) NOT NULL,
  `time` int(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Sukurta duomenų kopija lentelei `bals_rez`
--

INSERT INTO `bals_rez` (`id`, `nick`, `ats`, `bals_id`, `time`) VALUES
(1, 'profas', 'Geras', 1, 1419773598),
(2, 'bleaz', 'Geras', 1, 1419773609),
(3, 'legend', 'Neblogas', 1, 1419773738),
(4, 'samanta', 'Neblogas', 1, 1419773788),
(5, 'popis', 'Geras', 1, 1419774216),
(6, 'gabis', 'Geras', 1, 1419774833),
(7, 'tabakas', 'Lievas', 1, 1419776144),
(8, 'deimantee', 'Geras', 1, 1419776387),
(9, 'gokas', 'Neblogas', 1, 1419779446),
(10, 'lagger', 'Lievas', 1, 1419779846),
(11, 'traktorius', 'Lievas', 1, 1419781243),
(12, 'teemo', 'Geras', 1, 1419781559),
(13, 'legend', 'wdbzl.eu', 2, 1419783390),
(14, 'popis', 'wdbf.eu', 2, 1419783399),
(15, 'bleaz', 'wdbzl.eu', 2, 1419783400),
(16, 'samanta', 'wdbzl.eu', 2, 1419783419),
(17, 'gabis', 'wdbzl.eu', 2, 1419783455),
(18, 'profas', 'wdbf.eu', 2, 1419783463),
(19, 'lagger', 'wdbf.eu', 2, 1419783468),
(20, 'tabakas', 'wdbf.eu', 2, 1419783487),
(21, 'fausta', 'wdbf.eu', 2, 1419784095),
(22, 'dbzltk', 'wdbf.eu', 2, 1419784427),
(23, 'gokugoku', 'wdbf.eu', 2, 1419786458),
(24, 'drifftezas', 'wdbf.eu', 2, 1419786708),
(25, 'd3rs3', 'wdbf.eu', 2, 1419788034),
(26, 'optical', 'wdbf.eu', 2, 1419788832),
(27, 'wectra', 'wdbzl.eu', 2, 1419792522),
(28, 'sitigo', 'wdbzl.eu', 2, 1419793372),
(29, 'pokeris', 'wdbf.eu', 2, 1419793778),
(30, 'chromeboy', 'wdbf.eu', 2, 1419793808),
(31, 'skillasss', 'wdbf.eu', 2, 1419794005),
(32, 'lyderis', 'wdbzl.eu', 2, 1419794347),
(33, 'twilight', 'wdbzl.eu', 2, 1419795472),
(34, 'exotazy', 'wdbzl.eu', 2, 1419796271),
(35, 'ernis', 'wdbf.eu', 2, 1419796550),
(36, 'wevilrock', 'wdbf.eu', 2, 1419798276),
(37, 'skautas', 'wdbf.eu', 2, 1419800580),
(38, 'strike', 'wdbzl.eu', 2, 1419801354),
(39, 'twist', 'wdbf.eu', 2, 1419802804),
(40, 'skyle', 'wdbzl.eu', 2, 1419803468),
(41, 'ingiux', 'wdbf.eu', 2, 1419804339),
(42, 'zaidejas', 'wdbzl.eu', 2, 1419806345),
(43, 'saimon', 'wapdbf.eu', 2, 1419806698),
(44, 'tawodraugas', 'wdbf.eu', 2, 1419810313),
(45, 'nerijus', 'wdbf.eu', 2, 1419834592),
(46, 'testas', 'wdbf.eu', 2, 1419837178),
(47, 'aurimas', 'wdbf.eu', 2, 1419837198);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `block`
--

CREATE TABLE IF NOT EXISTS `block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(100) NOT NULL,
  `uz` text CHARACTER SET utf32 COLLATE utf32_lithuanian_ci NOT NULL,
  `time` int(255) NOT NULL,
  `kas_ban` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `block1`
--

CREATE TABLE IF NOT EXISTS `block1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(50) NOT NULL,
  `uz` text NOT NULL,
  `time` int(11) NOT NULL,
  `kas_ban` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `boss`
--

CREATE TABLE IF NOT EXISTS `boss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `img` varchar(200) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `exp` bigint(20) NOT NULL,
  `zen` bigint(20) NOT NULL,
  `krd` bigint(20) NOT NULL,
  `max_hit` int(11) NOT NULL,
  `laikas` int(11) NOT NULL,
  `prisikels` int(11) NOT NULL,
  `nukirto` varchar(20) NOT NULL,
  `nick` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Sukurta duomenų kopija lentelei `boss`
--

INSERT INTO `boss` (`id`, `name`, `img`, `max_hp`, `hp`, `exp`, `zen`, `krd`, `max_hit`, `laikas`, `prisikels`, `nukirto`, `nick`) VALUES
(1, 'Garlikas', 'img/boss/Jr.Garlic.png', 200000, 200000, 50000, 1000000, 5, 10000, 5400, 1419843933, 'nerijus', ''),
(2, 'Turles', 'img/boss/turles.png', 500000, 500000, 100000, 2500000, 10, 20000, 10800, 1419849299, 'nerijus', ''),
(3, 'Kuleris', 'img/boss/kuleris.png', 1000000, 427469, 150000, 5000000, 15, 35000, 16200, 1418802236, 'alkotester', ''),
(4, 'Babidis', 'img/boss/babidis.png', 2000000, 2000000, 200000, 17000000, 20, 50000, 21600, 1418807643, 'alkotester', ''),
(5, 'Super Buu', 'img/boss/superbuu.png', 5000000, 5000000, 350000, 23000000, 25, 70000, 27000, 1418813051, 'alkotester', ''),
(6, 'Dr. Myuu', 'img/boss/drmyuu.png', 10000000, 9935302, 800000, 41000000, 30, 120000, 32400, 1418818456, 'alkotester', ''),
(7, 'Lord Yao', 'img/boss/lordyao.png', 25000000, 25000000, 2300000, 103500000, 35, 150000, 37800, 1418823861, 'alkotester', ''),
(8, 'Ryan Shenron', 'img/boss/ryanhenron.png', 57800000, 57292650, 17300000, 781000000, 50, 200000, 43200, 1418829277, 'alkotester', '');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `drtop`
--

CREATE TABLE IF NOT EXISTS `drtop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) NOT NULL,
  `rutuliai` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `dtop`
--

CREATE TABLE IF NOT EXISTS `dtop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(100) NOT NULL,
  `vksm` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `duk`
--

CREATE TABLE IF NOT EXISTS `duk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klausimas` varchar(150) NOT NULL,
  `atsakymas` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `eventas`
--

CREATE TABLE IF NOT EXISTS `eventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(50) NOT NULL,
  `kiek` int(11) NOT NULL,
  `ko` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `forum_kat`
--

CREATE TABLE IF NOT EXISTS `forum_kat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Sukurta duomenų kopija lentelei `forum_kat`
--

INSERT INTO `forum_kat` (`id`, `name`) VALUES
(1, '*  Viskas apie bet ką (off-topic)'),
(2, '*  Žaidimo klaidos'),
(3, '*  Forumo pramogos'),
(4, '*  Vadovai'),
(5, '*  Žaidimo aptarimas'),
(6, '*  Klausimai. Pagalba naujokams');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `forum_tem`
--

CREATE TABLE IF NOT EXISTS `forum_tem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kat` int(11) NOT NULL,
  `kas` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `forum_zin`
--

CREATE TABLE IF NOT EXISTS `forum_zin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(100) NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `data` int(255) NOT NULL,
  `kat` int(10) NOT NULL,
  `tem` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `fotkes`
--

CREATE TABLE IF NOT EXISTS `fotkes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(15) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `foto` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=292 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `inventorius`
--

CREATE TABLE IF NOT EXISTS `inventorius` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(15) NOT NULL,
  `daiktas` int(11) NOT NULL,
  `tipas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `tipas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Sukurta duomenų kopija lentelei `items`
--

INSERT INTO `items` (`id`, `name`, `tipas`) VALUES
(1, 'Tocher Sword', 1),
(2, 'Tocher Armor', 2),
(3, 'Žemės Drakono Rutuliai', 3),
(4, 'Stebuklingos pupos', 3),
(5, 'Microshem', 3),
(6, 'Fusion Tail', 3),
(7, 'Sayian Tail', 3),
(8, 'Stone', 3),
(9, 'Gold Sword', 1),
(10, 'Gold Armor', 2),
(11, 'Energy Sword', 1),
(12, 'Energy Armor', 2),
(13, 'Soul', 3),
(14, 'Mėlynos snaigės', 3),
(15, 'Geltonos snaigės', 3),
(16, 'Baltos snaigės', 3),
(17, 'Raudonos snaigės', 3),
(18, 'Energy Stone', 3),
(19, 'Pragaro vaisius', 3),
(20, 'Majin sroll', 3),
(21, 'Gold Stone', 3),
(22, 'Magic Ball', 3),
(23, 'Power Stone', 3),
(24, 'Medis', 3),
(25, 'Vidutinės Malkos', 3),
(26, 'Mažos Malkos', 3),
(27, 'Kirvis', 3),
(28, 'Uoliena', 3),
(29, 'Juodasis drakono rutulys', 3),
(30, 'Nameko drakono rutuliai', 3),
(31, 'Majin Sword', 1),
(32, 'Majin Armor', 2);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `klaidu_komentarai`
--

CREATE TABLE IF NOT EXISTS `klaidu_komentarai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) NOT NULL,
  `komentaras` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `time` int(11) NOT NULL,
  `k_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `lokacijos`
--

CREATE TABLE IF NOT EXISTS `lokacijos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Sukurta duomenų kopija lentelei `lokacijos`
--

INSERT INTO `lokacijos` (`id`, `name`) VALUES
(1, 'Žemės planeta'),
(2, 'Pragaras'),
(3, 'Namekai'),
(4, 'Vakarų Miestas'),
(5, 'Planeta Nr.79'),
(6, 'Kajų planeta'),
(7, 'Kereozas'),
(8, 'Sajanai'),
(9, 'Legendiniai sajanai'),
(10, 'ULTRA Sajanai');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `m2_lokacijos`
--

CREATE TABLE IF NOT EXISTS `m2_lokacijos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Sukurta duomenų kopija lentelei `m2_lokacijos`
--

INSERT INTO `m2_lokacijos` (`id`, `name`) VALUES
(5, 'Robotai');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `m2_mobai`
--

CREATE TABLE IF NOT EXISTS `m2_mobai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `kg` varchar(2555) NOT NULL,
  `pin` bigint(20) NOT NULL,
  `exp` bigint(20) NOT NULL,
  `lokacija` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `mobai`
--

CREATE TABLE IF NOT EXISTS `mobai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kg` bigint(20) NOT NULL,
  `pin` bigint(20) NOT NULL,
  `exp` bigint(20) NOT NULL,
  `lokacija` int(11) NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Sukurta duomenų kopija lentelei `mobai`
--

INSERT INTO `mobai` (`id`, `name`, `kg`, `pin`, `exp`, `lokacija`, `foto`) VALUES
(1, 'Bulma', 10, 9, 1, 1, ''),
(2, 'Pilafas', 30, 19, 7, 1, ''),
(3, 'Ponas Šetonas', 50, 26, 14, 1, ''),
(4, 'Krilinas', 100, 37, 21, 1, ''),
(5, 'Jamcis', 500, 58, 28, 1, ''),
(6, 'Tensinhanas', 1000, 138, 35, 1, ''),
(7, 'Napas', 3000, 214, 66, 2, ''),
(8, 'Dodoris', 4500, 444, 88, 2, ''),
(9, 'Fryzas', 6500, 666, 144, 2, ''),
(10, 'Cell', 8000, 879, 187, 2, ''),
(11, 'Babidis', 12000, 1087, 287, 2, ''),
(12, 'Buu', 20000, 1689, 487, 2, ''),
(13, 'Mustardas', 50000, 3678, 698, 2, ''),
(14, 'Dendis', 100000, 7356, 766, 3, ''),
(15, 'Neilas', 500000, 14653, 977, 3, ''),
(16, 'Sulas', 1000000, 19453, 1033, 3, ''),
(17, 'Androidas 19', 3000000, 24362, 3099, 4, ''),
(18, 'Dr.Giras', 5000000, 31234, 3788, 4, ''),
(19, 'Androidas 18', 10000000, 39344, 4271, 4, ''),
(20, 'Androidas 17', 20000000, 43211, 4722, 4, ''),
(21, 'Selas jaunėlis', 50000000, 47322, 5133, 4, ''),
(22, 'Selas 2 formos', 100000000, 49233, 5733, 4, ''),
(24, 'Abo', 2500000000, 80464, 22879, 5, ''),
(25, 'Kado', 3500000000, 104767, 27532, 5, ''),
(26, 'Kuis', 4500000000, 144321, 33621, 5, ''),
(27, 'Orenas', 5500000000, 173581, 39781, 5, ''),
(28, 'Fryzas 1 forma', 7500000000, 197561, 44321, 5, ''),
(29, 'Fryzas 2 forma', 9500000000, 211723, 47651, 5, ''),
(30, 'Fryzas 3 forma', 12500000000, 234789, 54678, 5, ''),
(31, 'Fryzas 4 forma', 16500000000, 258971, 57988, 5, ''),
(32, 'Fryzas Galutinė Forma', 20500000000, 301532, 81444, 5, ''),
(34, 'Kibitas', 25000000000, 351000, 95100, 6, ''),
(35, 'šiaurės kajus', 30000000000, 400000, 100000, 6, ''),
(36, 'Pietų kajus', 35000000000, 435000, 120000, 6, ''),
(37, 'Vakarų kajus', 40000000000, 499000, 165000, 6, ''),
(38, 'Rytų kajus', 45000000000, 536000, 210000, 6, ''),
(39, 'Izas pirma forma', 50000000000, 300000, 150000, 7, ''),
(40, 'Izas antra forma', 60000000000, 320000, 170000, 7, ''),
(41, 'Izas trečia forma', 70000000000, 340000, 190000, 7, ''),
(42, 'Mega izas', 100000000000, 360000, 210000, 7, ''),
(44, 'Tranksas', 150000000000, 420000, 280000, 8, ''),
(45, 'Ateities Tranksas', 200000000000, 450000, 310, 8, ''),
(46, 'Gokas', 250000000000, 480000, 340000, 8, ''),
(47, 'Broly', 300000000000, 510000, 470000, 8, ''),
(48, 'Vedžitas', 350000000000, 550000, 400000, 8, ''),
(49, 'Legendinis Gotenas', 400000000000, 600000, 430000, 9, ''),
(50, 'Legendinis Vedžitas', 500000000000, 650000, 460000, 9, ''),
(51, 'Legendinis Buu', 600000000000, 700000, 490000, 9, ''),
(52, 'Legendinis Celas', 700000000000, 750000, 530000, 9, ''),
(53, 'Legendinis Gotranksas', 800000000000, 800000, 560000, 9, ''),
(54, 'ULTRA Gotenas', 1000000000000, 900000, 600000, 10, ''),
(55, 'ULTRA Tranksas', 3000000000000, 1000000, 680000, 10, ''),
(56, 'ULTRA Vedžitas', 4000000000000, 1100000, 720000, 10, ''),
(57, 'ULTRA Gokas', 5000000000000, 1200000, 750000, 10, ''),
(58, 'ULTRA Buu', 6000000000000, 1400000, 800000, 10, ''),
(60, 'ULTRA Cell', 7000000000000, 1400000, 900000, 10, '');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `new` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kas` varchar(100) NOT NULL,
  `data` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `unlike` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Sukurta duomenų kopija lentelei `news`
--

INSERT INTO `news` (`id`, `name`, `new`, `kas`, `data`, `likes`, `unlike`) VALUES
(1, 'Mokejimai.lt', 'Pajungiau mokejimai.lt sistema, galėsite pirkti sms žinutę paslaugas :)', 'bleaz', '1419765995', 0, 0),
(2, 'Stilaus keitimas', 'Sukūriau 2 naujus stilius, jos keisti galite mano meniu skiltyje.', 'bleaz', '1419768935', 0, 0),
(3, 'Padusimai', 'Sutvarkytas bugas su padusimais. g0hanas  ir express būdavo kas 0 sec padusimai..', 'bleaz', '1419769072', 0, 0),
(4, 'Gyvatės kelio užduotys', 'Sutvarkyta gyvatės kelio užduotys, Gyvatės kelio misijas vygdyti galima nuo 40 lygio! o būvo bugas kur ir galėjai vygdyti nuo 0 lygio.', 'bleaz', '1419769509', 0, 0),
(5, 'Apsauga nuo reklameriu', 'Įndėjau apsauga nuo reklameriu į čhata ir PM, įnrašant adresa ji filtruos į žvaigždutes :)', 'bleaz', '1419777240', 0, 0),
(6, 'Moderatoriaus topic`kas', 'Sukūriau MOD TOPIC`ą.', 'bleaz', '1419778569', 0, 0),
(7, 'Žaidėju topic', 'Įjungiau žaidėju topic`ą rodys paskutinius 3 pranešimus :)', 'bleaz', '1419783279', 0, 0),
(8, 'Prižiūrėtojas', 'Padariau kad žaidimo prižiūrėtojas galėtu kurti lokacijas ir monstrus.', 'bleaz', '1419792346', 0, 0),
(9, 'SMS TOP', 'Laikinai įšimtas SMS TOPAS.', 'bleaz', '1419862402', 0, 0),
(10, 'Kovą prieš kitą žaidėja &amp;&amp; K.G', 'Būva rasta klaidą kai užpuoli kitą žaidėja jo K.G rodo <b>0</b>, dabar rodys ir jūsų ir jo K.G normalei', 'bleaz', '1419864047', 0, 0),
(11, 'Savaitės kovų konkursas', 'Padarytas &lt;font color=blue&gt;&amp;legend&lt;/font&gt; pasiūlymas: &lt;b&gt;Padaryk savaites tope 3 prizines vietas&lt;/b&gt;, bei padariau savaitęs tope kad rodytu TOP 3 o ne TOP 5 :)', 'bleaz', '1419865147', 0, 0),
(12, 'PM rašymas', 'Padarytas &lt;font color=blue&gt;&amp;legend&lt;/font&gt; pasiūlymas: &lt;b&gt;Padaryk jog administracijai visai galetu zaidejai rasyti nuo 1lygio. &lt;/b&gt; Bei padariau kad ne tik &lt;b&gt;administracijai&lt;/b&gt; galėtu rašyt nuo 1 lygio bet ir &lt;b&gt;Žaidimo prižiūrėtojui&lt;/b&gt;.', 'bleaz', '1419865755', 0, 0),
(13, 'MINI pokalbiai', 'Padarytas &lt;font color=blue&gt;&amp;legend&lt;/font&gt; pasiūlymas: &lt;b&gt;Padaryk chate jog galetumem nutrint zinute &lt;/b&gt; su [X]', 'bleaz', '1419866788', 0, 0);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `nustatymai`
--

CREATE TABLE IF NOT EXISTS `nustatymai` (
  `1` int(11) NOT NULL AUTO_INCREMENT,
  `mod_topic` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `max_on` int(11) NOT NULL,
  `dtop_priz` bigint(255) NOT NULL,
  `dtop_rek` int(11) NOT NULL,
  `dtop_rek_n` varchar(100) NOT NULL,
  `dtop_date` varchar(100) NOT NULL,
  `event` varchar(2) NOT NULL,
  `admin_topic` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `admin_kas` varchar(20) NOT NULL,
  `admin_time` int(11) NOT NULL,
  `new_time` int(11) NOT NULL,
  `reg` varchar(5) NOT NULL,
  `count` text NOT NULL,
  `day` int(11) NOT NULL,
  `newl` varchar(15) NOT NULL,
  `dtop_plitai` int(11) NOT NULL,
  `dtop_nick` varchar(255) NOT NULL,
  `drtop_litai` int(11) NOT NULL,
  `drtop_date` varchar(255) NOT NULL,
  `drtop_nick` varchar(255) NOT NULL,
  `sms_date` varchar(255) NOT NULL,
  `sms_priz` varchar(255) NOT NULL,
  `sms_nick` varchar(255) NOT NULL,
  `savaites_kovu_topas` int(225) NOT NULL,
  `savaites_litai` int(225) NOT NULL,
  `savaites_kreditai` int(225) NOT NULL,
  `mod_kas` text NOT NULL,
  `mod_time` int(11) NOT NULL,
  PRIMARY KEY (`1`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Sukurta duomenų kopija lentelei `nustatymai`
--

INSERT INTO `nustatymai` (`1`, `mod_topic`, `max_on`, `dtop_priz`, `dtop_rek`, `dtop_rek_n`, `dtop_date`, `event`, `admin_topic`, `admin_kas`, `admin_time`, `new_time`, `reg`, `count`, `day`, `newl`, `dtop_plitai`, `dtop_nick`, `drtop_litai`, `drtop_date`, `drtop_nick`, `sms_date`, `sms_priz`, `sms_nick`, `savaites_kovu_topas`, `savaites_litai`, `savaites_kreditai`, `mod_kas`, `mod_time`) VALUES
(1, '...', 15, 1776054727, 8010, 'tabakas', '2014-12-29', '', 'Rytoj būs didesnios dalybos!! kvieskit žaidėjus :) P.S veikią sms žinučiu siuntimas, galite pirkti sms litus už savo telefono sąskaita :)', 'bleaz', 1419792039, 1419866848, '+', '<a href="http://wtop.us/i.php?id=inkult"><img src="http://wtop.us/count.php?id=inkult" alt="dbzl.tk"/></a>', 2, '2014-12-30', 2, 'tabakas', 2, '2014-12-29', 'legend', '2014-12-29', '14', 'bleaz', 1419982715, 25, 75, 'legend', 1419834772);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(100) NOT NULL,
  `vieta` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `nrs` text NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  `time_on` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `pasiekimai`
--

CREATE TABLE IF NOT EXISTS `pasiekimai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(30) NOT NULL,
  `psk_1` varchar(1) NOT NULL,
  `psk_2` varchar(1) NOT NULL,
  `psk_3` varchar(1) NOT NULL,
  `psk_4` varchar(1) NOT NULL,
  `psk_5` varchar(1) NOT NULL,
  `psk_6` varchar(1) NOT NULL,
  `psk_7` varchar(1) NOT NULL,
  `psk_8` varchar(1) NOT NULL,
  `psk_9` varchar(1) NOT NULL,
  `psk_10` varchar(1) NOT NULL,
  `psk_11` varchar(11) NOT NULL,
  `psk_12` varchar(11) NOT NULL,
  `psk_13` varchar(11) NOT NULL,
  `psk_14` varchar(11) NOT NULL,
  `psk_15` varchar(11) NOT NULL,
  `psk_16` varchar(11) NOT NULL,
  `psk_17` varchar(11) NOT NULL,
  `psk_18` varchar(11) NOT NULL,
  `psk_19` varchar(11) NOT NULL,
  `psk_20` varchar(11) NOT NULL,
  `psk_21` varchar(11) NOT NULL,
  `psk_22` varchar(11) NOT NULL,
  `psk_23` varchar(11) NOT NULL,
  `psk_24` varchar(11) NOT NULL,
  `psk_25` varchar(11) NOT NULL,
  `psk_26` varchar(11) NOT NULL,
  `psk_27` varchar(11) NOT NULL,
  `psk_28` varchar(11) NOT NULL,
  `psk_29` varchar(11) NOT NULL,
  `psk_30` varchar(11) NOT NULL,
  `psk_31` varchar(11) NOT NULL,
  `psk_32` varchar(11) NOT NULL,
  `psk_33` varchar(11) NOT NULL,
  `psk_34` varchar(11) NOT NULL,
  `psk_35` varchar(11) NOT NULL,
  `psk_36` varchar(11) NOT NULL,
  `psk_37` varchar(11) NOT NULL,
  `psk_38` varchar(11) NOT NULL,
  `psk_39` varchar(11) NOT NULL,
  `psk_40` varchar(11) NOT NULL,
  `psk_41` varchar(11) NOT NULL,
  `psk_42` varchar(11) NOT NULL,
  `psk_43` varchar(11) NOT NULL,
  `psk_44` varchar(11) NOT NULL,
  `psk_45` varchar(11) NOT NULL,
  `psk_46` varchar(11) NOT NULL,
  `psk_47` varchar(11) NOT NULL,
  `psk_48` varchar(11) NOT NULL,
  `psk_49` varchar(11) NOT NULL,
  `psk_50` varchar(11) NOT NULL,
  `psk_51` varchar(11) NOT NULL,
  `psk_52` varchar(11) NOT NULL,
  `psk_53` varchar(11) NOT NULL,
  `psk_54` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `pasiulymai`
--

CREATE TABLE IF NOT EXISTS `pasiulymai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pasiulymas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kas` varchar(20) NOT NULL,
  `laikas` int(11) NOT NULL,
  `busena` varchar(150) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `komentaras` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `pas_kom`
--

CREATE TABLE IF NOT EXISTS `pas_kom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kom` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kas` varchar(20) NOT NULL,
  `laikas` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `perved_log`
--

CREATE TABLE IF NOT EXISTS `perved_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `pm`
--

CREATE TABLE IF NOT EXISTS `pm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `what` varchar(15) NOT NULL,
  `txt` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `time` int(11) NOT NULL,
  `gavejas` varchar(15) NOT NULL,
  `nauj` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `pokalbiai`
--

CREATE TABLE IF NOT EXISTS `pokalbiai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(100) NOT NULL,
  `sms` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `data` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1090 ;

--
-- Sukurta duomenų kopija lentelei `pokalbiai`
--

INSERT INTO `pokalbiai` (`id`, `nick`, `sms`, `data`) VALUES
(1089, 'Sistema', '<span style="color:#ff041e;">&copy;bleaz</span> išvalė pokalbius.', 1419867560);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `prep`
--

CREATE TABLE IF NOT EXISTS `prep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kas` varchar(25) NOT NULL,
  `kam` varchar(25) NOT NULL,
  `ka` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `puzsakymai`
--

CREATE TABLE IF NOT EXISTS `puzsakymai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) NOT NULL,
  `preke` int(11) NOT NULL,
  `kiekis` int(11) NOT NULL,
  `kaina` varchar(255) NOT NULL,
  `valiuta` int(11) NOT NULL,
  `laikas` int(11) NOT NULL,
  `suma` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `rep`
--

CREATE TABLE IF NOT EXISTS `rep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kam` varchar(30) NOT NULL,
  `kas` varchar(30) NOT NULL,
  `ka` varchar(2) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `rinkimas`
--

CREATE TABLE IF NOT EXISTS `rinkimas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) NOT NULL,
  `kiek` int(11) NOT NULL,
  `atlygis` bigint(20) NOT NULL,
  `ka` varchar(50) NOT NULL,
  `daiktas` int(11) NOT NULL,
  `tipas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `sagos`
--

CREATE TABLE IF NOT EXISTS `sagos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pavadinimas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `sagu` int(11) NOT NULL,
  `sagu2` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `sagos_info`
--

CREATE TABLE IF NOT EXISTS `sagos_info` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `aprasymas` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `foto` varchar(150) NOT NULL,
  `saga` int(11) NOT NULL,
  `kg` varchar(30) NOT NULL,
  `atlygis` varchar(30) NOT NULL,
  `ko` varchar(25) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Sukurta duomenų kopija lentelei `sagos_info`
--

INSERT INTO `sagos_info` (`ID`, `aprasymas`, `foto`, `saga`, `kg`, `atlygis`, `ko`) VALUES
(1, 'Atskrido Raditas, jis nori užkariauti žemęs. Neleisk jam to padaryti!', 'img/sagos/.png', 1, '750', '500', 'kgi'),
(2, 'Greitu metu turi atskristi du paslaptingį kovotojai, kas tai galėtų būti? Geriau kibk į treniruotes!', 'img/sagos/.png', 1, '1000', '10000', 'litai'),
(3, 'Kovotojai atskrido, tai Napas su Vedžitu. Pirmasis į kovą stoją Napas.', 'img/sagos/.png', 1, '2500', '500', 'kgi'),
(4, 'Napas pralaimėjo ir Vedžitas jį pribaigė, dabar Vedžitas parodys savo jėga.', 'img/sagos/.png', 1, '5000', '1000', 'kgi'),
(5, 'Vedžitas pralaiminėjo, todėl pasivertė į Ozarų!', 'img/sagos/.png', 1, '10000', '1500000', 'litai'),
(6, 'Atskridote į Namekų planetą ieškoti Drakono Rutulių, tačiau jums kelia pastoja Fryzo parankinis iš Ginio pajėgų.', 'img/sagos/.png', 2, '50000', '3500', 'kgi'),
(7, 'Atrasis karys yra Rikūmas, jis galingesnis negu Guldas.', 'img/sagos/.png', 2, '115000', '7500', 'kgi'),
(8, 'Trečiasis karys yra Bartas, jis gana stiprus, tad pasisaugok!', 'img/sagos/.png', 2, '350000', '15000', 'kgi'),
(9, 'Ginio pajėgas sudaro viso 5 nariai, liko Džeisas ir Ginis, pirmasis stos Džeisas!', 'img/sagos/.png', 2, '750000', '30000', 'kgi'),
(10, 'Dabar Ginio eilė, pažiūrėsim ką jis mums parodys...', 'img/sagos/.png', 2, '1150000', '45000', 'kgi'),
(11, 'Dabr jūs kovosite su Fryzu!', 'img/sagos/.png', 2, '2500000', '65000', 'kgi'),
(12, 'Fryzas išsigando todėl parodys aukštesnėję savo formą!', 'img/sagos/.png', 2, '3750000', '100000', 'kgi'),
(13, 'Ha! Fryzo 2 forma nėra tokia jau stipri! Tačiau jis parodys dar aukštesnę formą!', 'img/sagos/.png', 2, '7500000', '175000', 'kgi'),
(14, 'Fryzas parodė savo paskutinę formą, ir jis įniršo todėl jis pasiekę visą 100% savo jėgos!', 'img/sagos/.png', 2, '15000000', '210000', 'kgi'),
(15, 'Į žeme atskrido kažkaip išgyvenęs Fryzas, tačiau jis dabar lyg ir kiborgas!', 'img/sagos/.png', 3, '20000000', '250000', 'kgi'),
(16, 'Fryzas krito, tačiau jo tėvas, Karalius Koldas ruošesi tave pulti, neleisk jam to padaryti.', 'img/sagos/.png', 3, '25500000', '275000', 'kgi'),
(17, 'Pasirodė pirmasis Androidas, jo numeris 19.', 'img/sagos/.png', 3, '30000000', '295000', 'kgi'),
(18, 'Tas Androidas nėra toks stiprus kaip 20, tad pasisaugok!', 'img/sagos/.png', 3, '34500000', '325000', 'kgi'),
(19, 'Selas, super Androidas, turintis visų kovotojų lastelių.', 'img/sagos/.png', 4, '37000000', '350000', 'kgi'),
(20, 'Pasirodo jis yra netik super Androidas, bet jis gali ir susiurbti kitus kovotojus.', 'img/sagos/.png', 4, '50000000', '450000', 'kgi'),
(21, 'Jis susiurbė paskutinį kovotoją ir taip pasiekė aukščiausią formą!', 'img/sagos/.png', 4, '75000000', '555000', 'kgi'),
(22, 'Na štai, jūs primaja Babidžio laivo auklšte!', 'img/sagos/.png', 5, '75000000', '500000', 'kgi'),
(23, 'Jis nebu toks stiprus, tačiau šis kovotojas tvirtesnis...', 'img/sagos/.png', 5, '100000000', '625000', 'kgi'),
(24, 'Babidis supyko todėl, liepė paskutiniam kovotojui susikautis!', 'img/sagos/.png', 5, '135000000', '675000', 'kgi'),
(25, 'Buu pasirodė, kolkas jis turi tik darželinuko protą.', 'img/sagos/.png', 6, '150000000', '750000', 'kgi'),
(26, 'Oba, dabar jau du, tačiau Blogasis puola gerajį ir jau jį užmušė...', 'img/sagos/.png', 6, '200000000', '1000000', 'kgi'),
(27, 'Tai dar nepabaigai, jis tapo Supr Buu, turime su juo susidoroti!', 'img/sagos/.png', 6, '275000000', '1250000', 'kgi'),
(28, 'Dabar jau pabaiga... Jis tapo savo pradinės ir stipriausios formos!!!', 'img/sagos/.png', 6, '325000000', '1350000', 'kgi'),
(29, 'Daktaras Myju, sukūrė biomechaninį padarą vaikelį ir dabar nori jums sutrukdyti sunaikinit jį.', 'img/sagos/.png', 7, '750000000', '2500000', 'kgi'),
(30, 'Vaikelis pradėjo augti ir pasiekė savo pirmą formą!', 'img/sagos/.png', 7, '1000000000', '5000000', 'kgi'),
(31, 'Prakeikstas vaikelis auga, kaip žmogus tik greičiau.', 'img/sagos/.png', 7, '1750000000', '7250000', 'kgi'),
(32, 'Jis pasiekia savo galutinę formą ir dabar yra žymiai galingesnis...', 'img/sagos/.png', 7, '2500000000', '10000000', 'kgi'),
(33, 'Prakeiktas vaikelis moka įsikūnitį į kitų kūnus...', 'img/sagos/.png', 7, '5000000000', '15000000', 'kgi'),
(34, 'Tai dar neviskas, jis vėl keičiasi!', 'img/sagos/.png', 7, '9500000000', '25000000', 'kgi'),
(35, 'Štai jo galutinė ir nenugalima forma!', 'img/sagos/.png', 7, '15000000000', '37500000', 'kgi'),
(36, 'Į Žemę atvyko blogio drakonas, norintis sužlugdyti tave ir atimti visus drakono rutulius!', 'img/sagos/.png', 8, '30000000000', '57500000', 'kgi'),
(37, 'Drakonas transformuojasi į antrą transformaciją, taip įgaudamas daugiau galios!', 'img/sagos/.png', 8, '60000000000', '87500000', 'kgi'),
(38, 'Drakonui neužtenka galios tavęs įveikti, todėl jis tampa trečios transformacijos!', 'img/sagos/.png', 8, '102000000000', '102500000', 'kgi'),
(39, 'Blogio drakonas žudo tavo draugus.. Įveik jį!', 'img/sagos/.png', 8, '211500000000', '142500000', 'kgi'),
(40, 'Savo smūgiais jam, tu jį tik stiprini.. Keisk taktiką!', 'img/sagos/.png', 8, '341600000000', '182500000', 'kgi'),
(41, 'Tu jam ne priešas, jeigu nesugebi jo nužudyti iki galo..', 'img/sagos/.png', 8, '471600000000', '309500000', 'kgi'),
(42, 'Paskutinis drakonas.. Žūsi tu arba jis.. Rinktis tau!', 'img/sagos/.png', 8, '539500000000', '639500000', 'kgi');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `savaites_topas`
--

CREATE TABLE IF NOT EXISTS `savaites_topas` (
  `id` int(225) NOT NULL AUTO_INCREMENT,
  `nick` varchar(225) NOT NULL,
  `veiksmai` int(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `prekes_id` int(11) NOT NULL,
  `pardavimo_kaina` bigint(20) NOT NULL,
  `pirkimo_kaina` bigint(20) NOT NULL,
  `tipas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Sukurta duomenų kopija lentelei `shop`
--

INSERT INTO `shop` (`id`, `name`, `prekes_id`, `pardavimo_kaina`, `pirkimo_kaina`, `tipas`) VALUES
(1, 'Tocher Sword', 1, 50000, 100000, 1),
(2, 'Tocher Armor', 2, 50000, 100000, 2),
(3, 'Gold Sword', 9, 200000, 500000, 1),
(4, 'Gold Armor', 10, 200000, 500000, 2),
(5, 'Energy Sword', 11, 800000, 2000000, 1),
(6, 'Energy Armor', 12, 800000, 2000000, 2),
(7, 'Stebuklingos pupos', 4, 0, 0, 3),
(8, 'Microshem', 5, 10000, 0, 3),
(9, 'Fusion Tail', 6, 13000, 0, 3),
(10, 'Sayian Tail', 7, 17000, 0, 3),
(11, 'Stone', 8, 22000, 0, 3),
(12, 'Soul', 13, 30000, 0, 3),
(13, 'Kirvis', 27, 0, 0, 3),
(14, 'Majin Sword', 31, 0, 0, 1),
(15, 'Majin Armor', 32, 0, 0, 2),
(16, 'Magic Ball', 22, 50000, 0, 3);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `siukslynas`
--

CREATE TABLE IF NOT EXISTS `siukslynas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) NOT NULL,
  `daiktas` int(11) NOT NULL,
  `tipas` int(11) NOT NULL,
  `kiek` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `smile`
--

CREATE TABLE IF NOT EXISTS `smile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kodas` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Sukurta duomenų kopija lentelei `smile`
--

INSERT INTO `smile` (`id`, `kodas`, `img`) VALUES
(1, ':D', '<img src="img/smile/1.gif" alt=":D"/>'),
(2, ':)', '<img src="img/smile/2.gif" alt=":)"/>'),
(3, ':(', '<img src="img/smile/3.gif" alt=":("/>'),
(4, ':P', '<img src="img/smile/4.gif" alt=":P"/>'),
(5, '(rofl)', '<img src="img/smile/5.gif" alt="(rofl)"/>'),
(6, ';)', '<img src="img/smile/6.gif" alt=";)"/>'),
(7, ';D', '<img src="img/smile/7.gif" alt=";D"/>'),
(8, ':debilas', '<img src="img/smile/8.gif" alt=":debilas"/>'),
(9, ':O', '<img src="img/smile/9.gif" alt=":O"/>'),
(10, ':yay', '<img src="img/smile/10.gif" alt=":yay"/>'),
(11, ':good', '<img src="img/smile/11.gif" alt=":goot"/>'),
(12, 'xD', '<img src="img/smile/12.gif" alt="xD"/>'),
(13, ':pff', '<img src="img/smile/13.gif" alt=":pff"/>'),
(14, '(zzz)', '<img src="img/smile/14.gif" alt="(zzz)"/>'),
(15, '(hi)', '<img src="img/smile/15.gif" alt="(hi)"/>'),
(16, ':]', '<img src="img/smile/16.gif" alt=":]"/>'),
(17, ':A', '<img src="img/smile/17.gif" alt=":A"/>'),
(18, '(sex)', '<img src="img/smile/18.gif" alt="(sex)"/>'),
(19, ':/', '<img src="img/smile/19.gif" alt=":/"/>'),
(20, ':negalima', '<img src="img/smile/20.gif" alt=":negalima"/>');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `sms_top`
--

CREATE TABLE IF NOT EXISTS `sms_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sms` bigint(255) NOT NULL,
  `nick` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `snake_misijos`
--

CREATE TABLE IF NOT EXISTS `snake_misijos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kiek` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `atlygis` int(11) NOT NULL,
  `atlygis_ko` varchar(100) NOT NULL,
  `daikto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `susijungimas`
--

CREATE TABLE IF NOT EXISTS `susijungimas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) NOT NULL,
  `kitas_zaidejas` varchar(20) NOT NULL,
  `ar_susijungias` varchar(5) NOT NULL,
  `kas_kviecia` varchar(20) NOT NULL,
  `ar_kvieti` varchar(5) NOT NULL,
  `ka_kvieti` varchar(20) NOT NULL,
  `uzdirbo_exp` varchar(255) NOT NULL,
  `fusion_dance` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL,
  `team` varchar(255) NOT NULL,
  `pinigai` bigint(255) NOT NULL,
  `vadas` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`,`team`,`pinigai`,`vadas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `technikos`
--

CREATE TABLE IF NOT EXISTS `technikos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) NOT NULL,
  `st_1` varchar(2) NOT NULL,
  `st_2` varchar(2) NOT NULL,
  `st_3` varchar(2) NOT NULL,
  `st_4` varchar(2) NOT NULL,
  `st_5` varchar(2) NOT NULL,
  `st_6` varchar(2) NOT NULL,
  `st_7` varchar(2) NOT NULL,
  `st_8` varchar(2) NOT NULL,
  `st_9` varchar(2) NOT NULL,
  `st_10` varchar(2) NOT NULL,
  `st_11` varchar(2) NOT NULL,
  `st_12` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kas` varchar(15) NOT NULL,
  `time` int(11) NOT NULL,
  `time2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vaskinimas`
--

CREATE TABLE IF NOT EXISTS `vaskinimas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kas` varchar(15) NOT NULL,
  `kiek` bigint(20) NOT NULL,
  `zenklas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `veikejai`
--

CREATE TABLE IF NOT EXISTS `veikejai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `trans` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Sukurta duomenų kopija lentelei `veikejai`
--

INSERT INTO `veikejai` (`id`, `name`, `trans`) VALUES
(1, 'Android 17', 1),
(2, 'Bardock', 4),
(3, 'Broly', 3),
(4, 'Bulma', 1),
(5, 'Buu', 6),
(6, 'Cell', 3),
(7, 'Cooler', 2),
(8, 'Fryzas', 5),
(9, 'Future Trunks', 4),
(10, 'Gohanas', 4),
(11, 'Gokas', 6),
(12, 'Kid Goten', 2),
(13, 'Kid Trunks', 2),
(14, 'Pan', 4),
(15, 'Pikolas', 1),
(16, 'Raditas', 4),
(17, 'Vedzitas', 5),
(18, 'Baby', 5);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vikte_cfg`
--

CREATE TABLE IF NOT EXISTS `vikte_cfg` (
  `kiek_iki` int(11) NOT NULL,
  `kls` int(11) NOT NULL,
  `iki_k` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vikte_chat`
--

CREATE TABLE IF NOT EXISTS `vikte_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(110) NOT NULL,
  `sms` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `time` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `vikte_klsm`
--

CREATE TABLE IF NOT EXISTS `vikte_klsm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klsm` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `ats` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zaidejai`
--

CREATE TABLE IF NOT EXISTS `zaidejai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(15) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `pass` varchar(255) NOT NULL,
  `litai` varchar(255) NOT NULL,
  `winter_e` int(11) NOT NULL,
  `kred` varchar(255) NOT NULL,
  `topic` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `k_dovana` varchar(1) NOT NULL,
  `color` varchar(7) NOT NULL,
  `veikejas` varchar(100) NOT NULL,
  `online_time` int(255) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `css` varchar(100) NOT NULL,
  `statusas` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `mini_chat` int(1) NOT NULL,
  `jega` varchar(255) NOT NULL,
  `gynyba` varchar(255) NOT NULL,
  `gyvybes` varchar(255) NOT NULL,
  `max_gyvybes` varchar(255) NOT NULL,
  `exp` varchar(255) NOT NULL,
  `expl` varchar(255) NOT NULL,
  `lygis` bigint(255) NOT NULL,
  `veiksmai` bigint(255) NOT NULL,
  `radaras` bigint(255) NOT NULL,
  `kg_mat` bigint(255) NOT NULL,
  `nelec` bigint(255) NOT NULL,
  `sword` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `armor` varchar(100) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `swordp` bigint(20) NOT NULL,
  `armorp` bigint(20) NOT NULL,
  `dovana` varchar(2) NOT NULL,
  `chate` int(11) NOT NULL,
  `vikte` int(11) NOT NULL,
  `forums` int(11) NOT NULL,
  `last_att` varchar(20) NOT NULL,
  `attime` int(11) NOT NULL,
  `taskai` int(11) NOT NULL,
  `sptechnika` int(11) NOT NULL,
  `sptechnika_time` int(11) NOT NULL,
  `kbokstas` int(11) NOT NULL,
  `pveiksmai` bigint(20) NOT NULL,
  `vveiksmai` bigint(20) NOT NULL,
  `pask_veiksmas` int(11) NOT NULL,
  `uzsiregistravo` int(11) NOT NULL,
  `kmis` int(11) NOT NULL,
  `kambarys` int(11) NOT NULL,
  `trans` int(11) NOT NULL,
  `rep_teig` int(11) NOT NULL,
  `rep_neig` int(11) NOT NULL,
  `majin` int(11) NOT NULL,
  `snake` int(11) NOT NULL,
  `auto` varchar(3) NOT NULL,
  `sms_litai` bigint(255) NOT NULL,
  `auto_time` int(11) NOT NULL,
  `pad_time` int(11) NOT NULL,
  `sagos` int(11) NOT NULL,
  `kg` varchar(255) NOT NULL,
  `rulete` int(11) NOT NULL,
  `gravitacijos_kambarys` int(11) NOT NULL,
  `aktyvumas` int(11) NOT NULL,
  `onliner` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `vip` int(11) NOT NULL,
  `b_sms_litu` int(11) NOT NULL,
  `mini_chata` int(11) NOT NULL,
  `idball` int(11) NOT NULL,
  `b_zenu` varchar(255) NOT NULL,
  `b_kreditu` varchar(255) NOT NULL,
  `technikos` int(11) NOT NULL,
  `grigas` varchar(2) NOT NULL,
  `klaivas_time` int(11) NOT NULL,
  `klaivas` int(2) NOT NULL,
  `namek` varchar(2) NOT NULL,
  `namek_time` int(11) NOT NULL,
  `mgalios` varchar(2) NOT NULL,
  `indball` int(11) NOT NULL,
  `kd` int(225) NOT NULL,
  `kaledine_dovana` varchar(1) NOT NULL,
  `kgi` varchar(999) NOT NULL,
  `inf_uzslaptinimas` bigint(255) NOT NULL,
  `team` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nick` (`nick`),
  KEY `nick_2` (`nick`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `zklaidos`
--

CREATE TABLE IF NOT EXISTS `zklaidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klaida` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `nick` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `laikas` int(11) NOT NULL,
  `busena` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `komentaras` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
         