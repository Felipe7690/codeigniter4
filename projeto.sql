-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 17/06/2025 às 20:20
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

-- --------------------------------------------------------

CREATE TABLE `cidades` (
  `cidades_id` int NOT NULL AUTO_INCREMENT,
  `cidades_nome` varchar(255) NOT NULL,
  `cidades_uf` varchar(2) NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`cidades_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

CREATE TABLE `clientes` (
  `clientes_id` int NOT NULL AUTO_INCREMENT,
  `clientes_usuarios_id` int NOT NULL,
  `clientes_endereco` varchar(255) DEFAULT NULL,
  `clientes_cidade_id` int DEFAULT NULL,
  PRIMARY KEY (`clientes_id`),
  FOREIGN KEY (`clientes_usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE,
  FOREIGN KEY (`clientes_cidade_id`) REFERENCES `cidades` (`cidades_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

CREATE TABLE `funcionarios` (
  `funcionarios_id` int NOT NULL AUTO_INCREMENT,
  `funcionarios_usuarios_id` int NOT NULL,
  `funcionarios_cargo` varchar(255) DEFAULT NULL,
  `funcionarios_salario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`funcionarios_id`),
  FOREIGN KEY (`funcionarios_usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE
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
  FOREIGN KEY (`produtos_categorias_id`) REFERENCES `categorias` (`categorias_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- TABELA INCLUÍDA NOVAMENTE
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


-- --------------------------------------------------------
-- TABELA INCLUÍDA NOVAMENTE
-- --------------------------------------------------------

CREATE TABLE `estoques` (
  `estoques_id` int NOT NULL AUTO_INCREMENT,
  `estoques_produtos_id` int NOT NULL,
  `estoques_quantidade` int NOT NULL,
  PRIMARY KEY (`estoques_id`),
  FOREIGN KEY (`estoques_produtos_id`) REFERENCES `produtos` (`produtos_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- TABELA CORRIGIDA E ALINHADA COM O MODEL
-- --------------------------------------------------------

CREATE TABLE `vendas` (
  `vendas_id` int NOT NULL AUTO_INCREMENT,
  `vendas_clientes_id` int NOT NULL,
  `vendas_funcionarios_id` int DEFAULT NULL,
  `vendas_data` datetime NOT NULL,
  `vendas_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vendas_status` varchar(50) DEFAULT 'Aberta',
  PRIMARY KEY (`vendas_id`),
  FOREIGN KEY (`vendas_clientes_id`) REFERENCES `clientes` (`clientes_id`) ON DELETE CASCADE,
  FOREIGN KEY (`vendas_funcionarios_id`) REFERENCES `funcionarios` (`funcionarios_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

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

-- --------------------------------------------------------
-- TABELA INCLUÍDA NOVAMENTE
-- --------------------------------------------------------

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