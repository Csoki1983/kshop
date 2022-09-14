-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2019. Feb 26. 08:14
-- Kiszolgáló verziója: 5.7.21
-- PHP verzió: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `kshop`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

DROP TABLE IF EXISTS `felhasznalok`;
CREATE TABLE IF NOT EXISTS `felhasznalok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `nev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `jelszo` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `admin_e` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `email`, `nev`, `jelszo`, `admin_e`) VALUES
(1, 'admin@teszt.hu', 'Admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', 1),
(2, 'teszt@teszt.hu', 'Teszt Elek', '*2BC59571EB571AA04F12481D56B5777D25788E18', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepregenyek`
--

DROP TABLE IF EXISTS `kepregenyek`;
CREATE TABLE IF NOT EXISTS `kepregenyek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kep` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `nev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `ar` int(11) NOT NULL,
  `orszagok_id` int(11) NOT NULL,
  `kiado_id` int(11) NOT NULL,
  `leiras` text COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orszagok_id` (`orszagok_id`),
  KEY `kiado_id` (`kiado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kepregenyek`
--

INSERT INTO `kepregenyek` (`id`, `kep`, `nev`, `ar`, `orszagok_id`, `kiado_id`, `leiras`) VALUES
(5, '2019-02-25_180522_927.jpg', 'teszt212', 1212, 2, 1, '1212');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kiado`
--

DROP TABLE IF EXISTS `kiado`;
CREATE TABLE IF NOT EXISTS `kiado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kiado` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kiado`
--

INSERT INTO `kiado` (`id`, `kiado`) VALUES
(1, 'DC'),
(2, 'MARVEL');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orszagok`
--

DROP TABLE IF EXISTS `orszagok`;
CREATE TABLE IF NOT EXISTS `orszagok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orszag` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `orszagok`
--

INSERT INTO `orszagok` (`id`, `orszag`) VALUES
(1, 'Magyar'),
(2, 'Japán');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rendelesek`
--

DROP TABLE IF EXISTS `rendelesek`;
CREATE TABLE IF NOT EXISTS `rendelesek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `felhasznalo_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `ar` int(11) NOT NULL,
  `hol_tart` tinyint(4) NOT NULL COMMENT '0-új, 1-folyamatban, 2-teljesítve',
  PRIMARY KEY (`id`),
  KEY `felhasznalo_id` (`felhasznalo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rend_tetelei`
--

DROP TABLE IF EXISTS `rend_tetelei`;
CREATE TABLE IF NOT EXISTS `rend_tetelei` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rendeles_id` int(11) NOT NULL,
  `kepregeny_id` int(11) NOT NULL,
  `darab` int(11) NOT NULL,
  `ar` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kepregeny_id` (`kepregeny_id`),
  KEY `rendeles_id` (`rendeles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `kepregenyek`
--
ALTER TABLE `kepregenyek`
  ADD CONSTRAINT `kepregenyek_ibfk_1` FOREIGN KEY (`orszagok_id`) REFERENCES `orszagok` (`id`),
  ADD CONSTRAINT `kepregenyek_ibfk_2` FOREIGN KEY (`kiado_id`) REFERENCES `kiado` (`id`);

--
-- Megkötések a táblához `rendelesek`
--
ALTER TABLE `rendelesek`
  ADD CONSTRAINT `rendelesek_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`id`);

--
-- Megkötések a táblához `rend_tetelei`
--
ALTER TABLE `rend_tetelei`
  ADD CONSTRAINT `rend_tetelei_ibfk_1` FOREIGN KEY (`rendeles_id`) REFERENCES `rendelesek` (`id`),
  ADD CONSTRAINT `rend_tetelei_ibfk_2` FOREIGN KEY (`kepregeny_id`) REFERENCES `kepregenyek` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
