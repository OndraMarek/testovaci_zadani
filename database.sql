-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 09. úno 2025, 17:30
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `engine_covers`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'abarth'),
(2, 'alfa romeo'),
(3, 'audi'),
(4, 'bmw'),
(5, 'citroën'),
(6, 'cupra'),
(7, 'dacia'),
(8, 'daewoo'),
(9, 'daihatsu'),
(10, 'dodge'),
(11, 'ds'),
(12, 'fiat'),
(13, 'ford'),
(14, 'honda'),
(18, 'hyundai'),
(19, 'chevrolet'),
(20, 'chrysler'),
(21, 'isuzu'),
(22, 'iveco'),
(23, 'jaguar'),
(24, 'jeep'),
(25, 'kia'),
(26, 'lada'),
(27, 'lancia'),
(28, 'land rover'),
(29, 'lexus'),
(30, 'man'),
(31, 'mazda'),
(32, 'mercedes-benz'),
(33, 'mini'),
(34, 'mitsubishi'),
(35, 'nissan'),
(36, 'opel'),
(37, 'peugeot'),
(38, 'porsche'),
(39, 'renault'),
(40, 'saab'),
(41, 'seat'),
(42, 'smart'),
(43, 'ssangyong'),
(44, 'subaru'),
(45, 'suzuki'),
(46, 'škoda'),
(47, 'toyota'),
(48, 'volkswagen'),
(49, 'volvo');

-- --------------------------------------------------------

--
-- Struktura tabulky `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250201175723', '2025-02-01 18:57:59', 44),
('DoctrineMigrations\\Version20250201175903', '2025-02-01 18:59:14', 9),
('DoctrineMigrations\\Version20250201180542', '2025-02-01 19:05:50', 92);

-- --------------------------------------------------------

--
-- Struktura tabulky `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `material`
--

INSERT INTO `material` (`id`, `name`) VALUES
(1, 'hlinik'),
(2, 'plast'),
(3, 'plech');

-- --------------------------------------------------------

--
-- Struktura tabulky `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `product`
--

INSERT INTO `product` (`id`, `brand_id`, `material_id`, `code`, `name`, `description`, `price`) VALUES
(1, 3, 2, 'PM00014', 'Kryt pod motor AUDI A3 Hatchback (8L1)', 'Plast (1J0825237M, 1J0825245E01C, 1J0 825 237R)', 968),
(2, 5, 2, 'PM00868', 'Kryt pod motor CITROËN C3 II (SC_)', 'Plast (7013GL)', 1331),
(3, 3, 2, 'PM00020', 'Kryt pod motor AUDI A4 B5 Sedan (8D2)', 'Plast (8D0863821F)', 968),
(4, 4, 3, 'PM00105', 'Kryt pod motor BMW 3 E46', 'Plech (51718159292)', 1850),
(5, 12, 2, 'PM00211', 'Kryt pod motor FIAT PUNTO II', 'Plast (46723948)', 899),
(6, 13, 1, 'PM00334', 'Kryt pod motor FORD FOCUS MK1', 'Hliník (98AG6A023AC)', 2025),
(7, 14, 2, 'PM00458', 'Kryt pod motor HONDA CIVIC VII', 'Plast (74111S5A000)', 1100),
(8, 18, 3, 'PM00589', 'Kryt pod motor HYUNDAI I30', 'Plech (291102H000)', 1680),
(9, 19, 2, 'PM00640', 'Kryt pod motor CHEVROLET CRUZE', 'Plast (95228122)', 1155),
(10, 32, 1, 'PM00723', 'Kryt pod motor MERCEDES-BENZ C-CLASS W204', 'Hliník (2045201523)', 2400),
(11, 35, 3, 'PM00879', 'Kryt pod motor NISSAN QASHQAI', 'Plech (75892JD00A)', 1955),
(12, 36, 2, 'PM00941', 'Kryt pod motor OPEL ASTRA H', 'Plast (13123452)', 980),
(13, 37, 1, 'PM01002', 'Kryt pod motor PEUGEOT 307', 'Hliník (7013CL)', 2075),
(14, 39, 3, 'PM01165', 'Kryt pod motor RENAULT MEGANE II', 'Plech (8200410830)', 1720),
(15, 41, 2, 'PM01248', 'Kryt pod motor SEAT LEON I', 'Plast (1M0825237C)', 990),
(16, 44, 1, 'PM01331', 'Kryt pod motor SUBARU IMPREZA', 'Hliník (56410FE040)', 2320),
(17, 45, 3, 'PM01405', 'Kryt pod motor SUZUKI SWIFT III', 'Plech (71741-63J00)', 1820),
(18, 46, 2, 'PM01512', 'Kryt pod motor ŠKODA OCTAVIA II', 'Plast (1Z0825237A)', 1150),
(19, 47, 1, 'PM01629', 'Kryt pod motor TOYOTA COROLLA', 'Hliník (51410-02030)', 2080),
(20, 48, 3, 'PM01793', 'Kryt pod motor VOLKSWAGEN GOLF V', 'Plech (1K0825235E)', 1900),
(22, 3, 2, 'PM01800', 'Kryt pod motor AUDI A6 C6', 'Plast (4F0863821A)', 1250),
(23, 5, 3, 'PM01801', 'Kryt pod motor CITROËN C4 Picasso', 'Plech (7013HL)', 1750),
(24, 4, 1, 'PM01802', 'Kryt pod motor BMW 5 E60', 'Hliník (51757129391)', 2200),
(25, 12, 2, 'PM01803', 'Kryt pod motor FIAT PANDA III', 'Plast (735566715)', 950),
(26, 13, 3, 'PM01804', 'Kryt pod motor FORD MONDEO MK4', 'Plech (6G911761AA)', 1800),
(27, 18, 2, 'PM01805', 'Kryt pod motor HYUNDAI TUCSON', 'Plast (29110D7000)', 1300),
(28, 25, 1, 'PM01806', 'Kryt pod motor KIA SPORTAGE', 'Hliník (29110-3W000)', 2100),
(29, 29, 2, 'PM01807', 'Kryt pod motor LEXUS RX400h', 'Plast (51410-48020)', 1600),
(30, 32, 3, 'PM01808', 'Kryt pod motor MERCEDES-BENZ E-CLASS W211', 'Plech (2115201523)', 1900),
(31, 35, 2, 'PM01809', 'Kryt pod motor NISSAN X-TRAIL', 'Plast (75892-2Y90A)', 1250),
(32, 37, 1, 'PM01810', 'Kryt pod motor PEUGEOT 206', 'Hliník (7013AK)', 1950),
(33, 41, 3, 'PM01811', 'Kryt pod motor SEAT IBIZA IV', 'Plech (6R0825237B)', 1700),
(34, 44, 2, 'PM01812', 'Kryt pod motor SUBARU OUTBACK', 'Plast (56410AJ000)', 1400),
(35, 47, 1, 'PM01813', 'Kryt pod motor TOYOTA RAV4', 'Hliník (51410-42100)', 2150),
(36, 48, 3, 'PM01814', 'Kryt pod motor VOLKSWAGEN PASSAT B7', 'Plech (3AA825235E)', 1850);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexy pro tabulku `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD44F5D008` (`brand_id`),
  ADD KEY `IDX_D34A04ADE308AC6F` (`material_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pro tabulku `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `FK_D34A04ADE308AC6F` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
