-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Nov-2017 às 00:57
-- Versão do servidor: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediapost`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `contatos`
--

CREATE TABLE IF NOT EXISTS `contatos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `contatos`
--

INSERT INTO `contatos` (`id`, `nome`) VALUES
(10, 'Leandro de Oliveira Novais'),
(11, 'Adonis Santana'),
(12, 'Ana Cla&uacute;dia'),
(13, 'Thor Batista'),
(14, 'Eike Batista'),
(17, 'Roberto Caverna'),
(18, 'Marina Rui Barbosa'),
(20, 'Lucas Oliveira'),
(21, 'Martinha Gomes'),
(22, 'Neymar Juarez Jr'),
(23, 'Odila Perez Duarte'),
(24, 'Fernanda Nunez'),
(25, 'Saitama'),
(26, 'Cora Coraline'),
(27, 'Cristina Yang'),
(29, 'Jorge Omalley'),
(30, 'Luiza Hornet');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL,
  `contato_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `emails`
--

INSERT INTO `emails` (`id`, `contato_id`, `tipo_id`, `descricao`) VALUES
(3, 11, 1, 'teste2@example.com'),
(4, 11, 2, 'adonis@adonis.com'),
(10, 20, 1, 'lucas@example.com'),
(11, 11, 2, 'black@example.com'),
(12, 11, 1, 'pangeia@jurassica.org.gov'),
(13, 18, 2, 'example@example3.com'),
(14, 18, 2, 'altenativo@teste.com'),
(15, 30, 1, 'luiza@google.com'),
(16, 30, 1, 'lili@google.com'),
(17, 30, 2, 'luiza@pratrabalho.br'),
(18, 10, 2, 'leandro@mediapost.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE IF NOT EXISTS `telefones` (
  `id` int(11) NOT NULL,
  `contato_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `descricao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`id`, `contato_id`, `tipo_id`, `descricao`) VALUES
(5, 10, 2, '(11) 99999-9999'),
(6, 10, 3, '(11) 00233-2232'),
(8, 11, 1, '(11) 88644-5455'),
(9, 12, 1, '(23) 22213-2132'),
(10, 12, 1, '(55) 23213-1231'),
(18, 11, 2, '(12) 12123-2443'),
(19, 20, 3, '(11) 93434-3434'),
(20, 30, 1, '(11) 23323-2232'),
(21, 30, 1, '(44) 34343-4343');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_email`
--

CREATE TABLE IF NOT EXISTS `tipos_email` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipos_email`
--

INSERT INTO `tipos_email` (`id`, `descricao`) VALUES
(1, 'Pessoal'),
(2, 'Trabalho');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_telefone`
--

CREATE TABLE IF NOT EXISTS `tipos_telefone` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipos_telefone`
--

INSERT INTO `tipos_telefone` (`id`, `descricao`) VALUES
(1, 'Celular'),
(2, 'Residencial'),
(3, 'Trabalho');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contatos`
--
ALTER TABLE `contatos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_emails_contato_idx` (`contato_id`),
  ADD KEY `fk_emails_tipos_idx` (`tipo_id`);

--
-- Indexes for table `telefones`
--
ALTER TABLE `telefones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_telefones_contatos_idx` (`contato_id`),
  ADD KEY `fk_telefones_tipos_idx` (`tipo_id`);

--
-- Indexes for table `tipos_email`
--
ALTER TABLE `tipos_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos_telefone`
--
ALTER TABLE `tipos_telefone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contatos`
--
ALTER TABLE `contatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `telefones`
--
ALTER TABLE `telefones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tipos_email`
--
ALTER TABLE `tipos_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tipos_telefone`
--
ALTER TABLE `tipos_telefone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `fk_emails_contatos` FOREIGN KEY (`contato_id`) REFERENCES `contatos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_emails_tipos` FOREIGN KEY (`tipo_id`) REFERENCES `tipos_email` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `telefones`
--
ALTER TABLE `telefones`
  ADD CONSTRAINT `fk_telefones_contatos` FOREIGN KEY (`contato_id`) REFERENCES `contatos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_telefones_tipos` FOREIGN KEY (`tipo_id`) REFERENCES `tipos_telefone` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
