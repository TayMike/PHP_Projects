-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 21, 2023 at 04:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TrabalhoFinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `alimento`
--

CREATE TABLE `alimento` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `dataColheita` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alimento`
--

INSERT INTO `alimento` (`id`, `nome`, `dataColheita`) VALUES
(1, 'Arroz', '2023-12-12'),
(2, 'Feijão', '2023-11-20'),
(3, 'Morango', '2023-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `fazendeiro`
--

CREATE TABLE `fazendeiro` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `dataCadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fazendeiro`
--

INSERT INTO `fazendeiro` (`id`, `nome`, `dataCadastro`) VALUES
(1, 'Luigi', '2023-01-20'),
(2, 'Ana', '2023-02-10'),
(3, 'Tayson', '2023-01-15'),
(4, 'Eduardo', '2023-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `plantacao`
--

CREATE TABLE `plantacao` (
  `id` int(11) NOT NULL,
  `idAlimento` int(11) NOT NULL,
  `idFazendeiro` int(11) NOT NULL,
  `dataPlantacao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plantacao`
--

INSERT INTO `plantacao` (`id`, `idAlimento`, `idFazendeiro`, `dataPlantacao`) VALUES
(1, 1, 1, '2023-11-15'),
(5, 1, 4, '2023-11-20'),
(2, 2, 1, '2023-11-30'),
(4, 2, 3, '2023-11-23'),
(3, 3, 2, '2023-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `sessao`
--

CREATE TABLE `sessao` (
  `sessaoId` varchar(20) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessao`
--

INSERT INTO `sessao` (`sessaoId`, `userId`) VALUES
('082df7cdac3c21545511', 1),
('eccc43e1389c0375b5a8', 2);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `userlogin` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `userlogin`, `senha`) VALUES
(1, 'user@login.com', '123456'),
(2, 'Tayson', '$2y$11$2zPgatcqLicF.sDu7dHkGeYlH.5mqvJDa/5Rr/w.THuUhlpLnW8p6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alimento`
--
ALTER TABLE `alimento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_NomeAlimento` (`nome`);

--
-- Indexes for table `fazendeiro`
--
ALTER TABLE `fazendeiro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_NomeFazendeiro` (`nome`);

--
-- Indexes for table `plantacao`
--
ALTER TABLE `plantacao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_VendaUnica` (`idAlimento`,`idFazendeiro`,`dataPlantacao`),
  ADD KEY `idfazendeiro` (`idFazendeiro`);

--
-- Indexes for table `sessao`
--
ALTER TABLE `sessao`
  ADD PRIMARY KEY (`sessaoId`),
  ADD UNIQUE KEY `sessaoId` (`sessaoId`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `LOGIN` (`userlogin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alimento`
--
ALTER TABLE `alimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fazendeiro`
--
ALTER TABLE `fazendeiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `plantacao`
--
ALTER TABLE `plantacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `plantacao`
--
ALTER TABLE `plantacao`
  ADD CONSTRAINT `plantacao_ibfk_1` FOREIGN KEY (`idAlimento`) REFERENCES `alimento` (`id`),
  ADD CONSTRAINT `plantacao_ibfk_2` FOREIGN KEY (`idFazendeiro`) REFERENCES `fazendeiro` (`id`);

--
-- Constraints for table `sessao`
--
ALTER TABLE `sessao`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
