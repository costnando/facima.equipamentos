-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 16-Dez-2017 às 18:49
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antesupload`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserve`
--

CREATE TABLE `reserve` (
  `id_reserve` int(11) NOT NULL,
  `delivery_reserve` varchar(255) NOT NULL,
  `date_reserve` varchar(255) CHARACTER SET latin1 NOT NULL,
  `local_reserve` varchar(200) NOT NULL,
  `item` varchar(255) CHARACTER SET latin1 NOT NULL,
  `quantidade` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user` varchar(255) CHARACTER SET latin1 NOT NULL,
  `devolution` varchar(255) CHARACTER SET latin1 NOT NULL,
  `horaentrega` varchar(255) CHARACTER SET latin1 NOT NULL,
  `horadevolucao` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` enum('1','2','3') CHARACTER SET latin1 NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stock`
--

CREATE TABLE `stock` (
  `id_item` int(11) NOT NULL,
  `code_item` varchar(11) CHARACTER SET latin1 NOT NULL,
  `amount_item` int(255) NOT NULL,
  `name_item` varchar(200) CHARACTER SET latin1 NOT NULL,
  `description_item` varchar(300) CHARACTER SET latin1 NOT NULL,
  `img_item` mediumblob,
  `remaining` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `full_name_user` varchar(200) NOT NULL,
  `name_user` varchar(200) NOT NULL,
  `email_user` varchar(200) NOT NULL,
  `cpf_user` varchar(14) NOT NULL,
  `password_user` varchar(200) NOT NULL,
  `permission_user` enum('1','2','3') NOT NULL DEFAULT '1',
  `avatar` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'profile.jpg',
  `status` enum('true','false') CHARACTER SET latin1 NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id_user`, `full_name_user`, `name_user`, `email_user`, `cpf_user`, `password_user`, `permission_user`, `avatar`, `status`) VALUES
(1, 'Night Web', 'admin', 'contato@nightweb.com.br', '000.000.000-00', '4731b79953fcf72967d3aad1717d8d6450532880', '3', 'profile.jpg', 'true');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`id_reserve`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_item`,`name_item`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`,`cpf_user`,`email_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reserve`
--
ALTER TABLE `reserve`
  MODIFY `id_reserve` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
