-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 13/06/2025 às 21:14
-- Versão do servidor: 8.0.41
-- Versão do PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto`
--

-- --------------------------------------------------------

CREATE TABLE `categorias` (
  `categorias_id` int NOT NULL AUTO_INCREMENT,
  `categorias_nome` varchar(255) NOT NULL,
  PRIMARY KEY (`categorias_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categorias` (`categorias_id`, `categorias_nome`) VALUES
(1, 'Sanduíches2'),
(2, 'Pizzas');

-- --------------------------------------------------------

CREATE TABLE `cidades` (
  `cidades_id` int NOT NULL AUTO_INCREMENT,
  `cidades_nome` varchar(255) NOT NULL,
  `cidades_uf` varchar(2) NOT NULL,
  PRIMARY KEY (`cidades_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `cidades` (`cidades_id`, `cidades_nome`, `cidades_uf`) VALUES
(1, 'Ceres', 'GO');

-- --------------------------------------------------------

CREATE TABLE `usuarios` (
  `usuarios_id` int NOT NULL AUTO_INCREMENT,
  `usuarios_nome` varchar(255) NOT NULL,
  `usuarios_sobrenome` varchar(255) NOT NULL,
  `usuarios_email` varchar(255) NOT NULL,
  `usuarios_cpf` varchar(14) NOT NULL,
  `usuarios_data_nasc` date NOT NULL,
  `usuarios_nivel` int NOT NULL,
  `usuarios_fone` varchar(15) NOT NULL,
  `usuarios_senha` varchar(32) NOT NULL,
  `usuarios_data_cadastro` datetime NOT NULL,
  PRIMARY KEY (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuarios` (`usuarios_id`, `usuarios_nome`, `usuarios_sobrenome`, `usuarios_email`, `usuarios_cpf`, `usuarios_data_nasc`, `usuarios_nivel`, `usuarios_fone`, `usuarios_senha`, `usuarios_data_cadastro`) VALUES
(1, 'Vilson', 'Soares de Siqueira', 'vilsonsoares@gmail.com', '999.999.999-99', '1981-12-03', 1, '6398474-3380', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00');

-- --------------------------------------------------------

CREATE TABLE `clientes` (
  `clientes_id` int NOT NULL AUTO_INCREMENT,
  `clientes_usuarios_id` int NOT NULL,
  `clientes_endereco` varchar(255) DEFAULT NULL,
  `clientes_cidade_id` int DEFAULT NULL,
  PRIMARY KEY (`clientes_id`),
  KEY `clientes_usuarios_id` (`clientes_usuarios_id`),
  KEY `clientes_cidade_id` (`clientes_cidade_id`),
  CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`clientes_usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE,
  CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`clientes_cidade_id`) REFERENCES `cidades` (`cidades_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

CREATE TABLE `funcionarios` (
  `funcionarios_id` int NOT NULL AUTO_INCREMENT,
  `funcionarios_usuarios_id` int NOT NULL,
  `funcionarios_cargo` varchar(255) DEFAULT NULL,
  `funcionarios_salario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`funcionarios_id`),
  KEY `funcionarios_usuarios_id` (`funcionarios_usuarios_id`),
  CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`funcionarios_usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

CREATE TABLE `produtos` (
  `produtos_id` int NOT NULL AUTO_INCREMENT,
  `produtos_nome` varchar(255) NOT NULL,
  `produtos_descricao` text NOT NULL,
  `produtos_preco_custo` float(9,2) NOT NULL,
  `produtos_preco_venda` float(9,2) NOT NULL,
  `produtos_categorias_id` int NOT NULL,
  PRIMARY KEY (`produtos_id`),
  KEY `fk_categorias_produto` (`produtos_categorias_id`),
  CONSTRAINT `fk_categorias_produto` FOREIGN KEY (`produtos_categorias_id`) REFERENCES `categorias` (`categorias_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `produtos` (`produtos_id`, `produtos_nome`, `produtos_descricao`, `produtos_preco_custo`, `produtos_preco_venda`, `produtos_categorias_id`) VALUES
(1, 'Pizza Calabresa', 'Pizza Calabresa', 35.00, 60.00, 2),
(2, 'X-Tudo', 'X-Tudo', 15.50, 24.99, 1);

-- --------------------------------------------------------

CREATE TABLE `imgprodutos` (
  `imgprodutos_id` int NOT NULL AUTO_INCREMENT,
  `imgprodutos_link` varchar(255) NOT NULL,
  `imgprodutos_descricao` text NOT NULL,
  `imgprodutos_produtos_id` int NOT NULL,
  PRIMARY KEY (`imgprodutos_id`),
  KEY `fk_imagens_produtos` (`imgprodutos_produtos_id`),
  CONSTRAINT `fk_imagens_produtos` FOREIGN KEY (`imgprodutos_produtos_id`) REFERENCES `produtos` (`produtos_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `imgprodutos` (`imgprodutos_id`, `imgprodutos_link`, `imgprodutos_descricao`, `imgprodutos_produtos_id`) VALUES
(1, 'uploads/20250416/1744801962_9165428592f42702f939.jpg', 'Pizza1', 1);

-- --------------------------------------------------------
-- Novas tabelas com herança e controle de operações
-- --------------------------------------------------------

CREATE TABLE `estoques` (
  `estoques_id` int NOT NULL AUTO_INCREMENT,
  `estoques_produtos_id` int NOT NULL,
  `estoques_quantidade` int NOT NULL,
  PRIMARY KEY (`estoques_id`),
  FOREIGN KEY (`estoques_produtos_id`) REFERENCES `produtos` (`produtos_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `vendas` (
  `vendas_id` int NOT NULL AUTO_INCREMENT,
  `vendas_clientes_id` int NOT NULL,
  `vendas_data` datetime NOT NULL,
  `vendas_valor_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`vendas_id`),
  FOREIGN KEY (`vendas_clientes_id`) REFERENCES `clientes` (`clientes_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pedidos` (
  `pedidos_id` int NOT NULL AUTO_INCREMENT,
  `pedidos_vendas_id` int NOT NULL,
  `pedidos_produtos_id` int NOT NULL,
  `pedidos_quantidade` int NOT NULL,
  `pedidos_preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`pedidos_id`),
  FOREIGN KEY (`pedidos_vendas_id`) REFERENCES `vendas` (`vendas_id`) ON DELETE CASCADE,
  FOREIGN KEY (`pedidos_produtos_id`) REFERENCES `produtos` (`produtos_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `entregas` (
  `entregas_id` int NOT NULL AUTO_INCREMENT,
  `entregas_vendas_id` int NOT NULL,
  `entregas_funcionarios_id` int NOT NULL,
  `entregas_data` datetime NOT NULL,
  `entregas_status` varchar(100) DEFAULT 'Pendente',
  PRIMARY KEY (`entregas_id`),
  FOREIGN KEY (`entregas_vendas_id`) REFERENCES `vendas` (`vendas_id`) ON DELETE CASCADE,
  FOREIGN KEY (`entregas_funcionarios_id`) REFERENCES `funcionarios` (`funcionarios_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
