-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/10/2026 às 01:05
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gamebit`
--
CREATE DATABASE IF NOT EXISTS `gamebit` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gamebit`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `status`, `nome`, `observacao`, `data_cadastro`) VALUES
(1, 1, 'Administrador', 'Administrador geral do sistema.', '2026-01-01 00:00:00'),
(2, 1, 'Vendedor', 'Responsável por realizar as vendas.', '2026-01-01 00:00:00'),
(4, 1, 'Gerente', 'Responsável pela gestão da loja e supervisão dos funcionários.', '2026-10-15 14:37:34'),
(5, 1, 'Atendente', 'Responsável pelo atendimento inicial aos clientes.', '2026-10-15 14:37:34'),
(6, 1, 'Estoquista', 'Responsável pelo controle e organização do estoque de produtos.', '2026-10-15 14:37:34'),
(7, 1, 'Operador de Caixa', 'Responsável pelo registro de vendas e operações de pagamento.', '2026-10-15 14:37:34'),
(8, 0, 'Analista de Produtos', 'Responsável pelo cadastro e atualização de jogos e consoles.', '2026-10-15 14:37:34'),
(9, 1, 'Assistente de Marketing', 'Responsável pela divulgação de produtos e campanhas promocionais.', '2026-10-15 14:37:34'),
(10, 1, 'Suporte Técnico', 'Responsável pelo suporte técnico relacionado a consoles e acessórios.', '2026-10-15 14:37:34'),
(11, 1, 'Comprador', 'Responsável pela aquisição de jogos, consoles e acessórios.', '2026-10-15 14:37:34'),
(12, 1, 'Auxiliar Administrativo', 'Responsável pelo apoio às rotinas administrativas da loja.', '2026-10-15 14:37:34'),
(13, 1, 'Desenvolvedor de Sistemas', 'Responsável pela manutenção e evolução do sistema da loja.', '2026-10-15 14:37:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(5) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome`, `data_cadastro`, `status`) VALUES
(1, 'Jogos', '2026-01-01 00:00:00', 1),
(2, 'Consoles', '2026-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `cpf` char(14) NOT NULL,
  `status` tinyint(3) UNSIGNED DEFAULT NULL,
  `endereco` varchar(70) NOT NULL,
  `complemento` varchar(40) DEFAULT NULL,
  `cidade` varchar(100) NOT NULL,
  `cep` char(9) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `estado` char(2) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone_residencial` char(14) DEFAULT NULL,
  `telefone_celular` char(15) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  `sexo` char(1) NOT NULL,
  `data_nascimento` date NOT NULL,
  `estado_civil` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nome`, `rg`, `cpf`, `status`, `endereco`, `complemento`, `cidade`, `cep`, `numero`, `bairro`, `estado`, `email`, `senha`, `telefone_residencial`, `telefone_celular`, `data_cadastro`, `sexo`, `data_nascimento`, `estado_civil`) VALUES
(1, 'Lucas Almeida', '00.000.000-01', '000.000.000-01', 1, 'Rua das Flores', 'Apto 12', 'Piracicaba', '13400-001', 125, 'Centro', 'SP', 'cliente01@example.com', 'Teste@123', '(19) 3000-0001', '(19) 99000-0001', '2026-10-15 14:55:03', 'M', '1998-05-14', 'Solteiro(a)'),
(2, 'Mariana Costa', '00.000.000-02', '000.000.000-02', 1, 'Avenida Brasil', NULL, 'Campinas', '13010-002', 240, 'Cambuí', 'SP', 'cliente02@example.com', 'Teste@123', '(19) 3000-0002', '(19) 99000-0002', '2026-10-15 14:55:03', 'F', '1995-08-22', 'Casado(a)'),
(3, 'Pedro Henrique Souza', '', '000.000.000-03', 1, 'Rua do Comércio', 'Casa 2', 'Limeira', '13480-003', 350, 'Vila Cláudia', 'SP', 'cliente03@example.com', 'Teste@123', '(19) 3000-0003', '(19) 99000-0003', '2026-10-15 14:55:03', 'M', '2001-02-10', 'Solteiro(a)'),
(4, 'Ana Beatriz Oliveira', '00.000.000-04', '000.000.000-04', 1, 'Rua São João', NULL, 'Rio Claro', '13500-004', 48, 'Saúde', 'SP', 'cliente04@example.com', 'Teste@123', '(19) 3000-0004', '(19) 99000-0004', '2026-10-15 14:55:03', 'F', '1992-11-03', 'Divorciado(a)'),
(5, 'Gabriel Santos', '', '000.000.000-05', 1, 'Avenida Independência', 'Bloco B', 'Piracicaba', '13416-005', 520, 'Paulista', 'SP', 'cliente05@example.com', 'Teste@123', '(19) 3000-0005', '(19) 99000-0005', '2026-10-15 14:55:03', 'M', '1999-07-19', 'Solteiro(a)'),
(6, 'Juliana Ferreira', '00.000.000-06', '000.000.000-06', 1, 'Rua das Acácias', 'Fundos', 'Americana', '13465-006', 76, 'Jardim Girassol', 'SP', 'cliente06@example.com', 'Teste@123', '(19) 3000-0006', '(19) 99000-0006', '2026-10-15 14:55:03', 'F', '1997-04-28', 'União Estável'),
(7, 'Rafael Martins', '00.000.000-07', '000.000.000-07', 1, 'Rua XV de Novembro', NULL, 'São Paulo', '01013-007', 184, 'República', 'SP', 'cliente07@example.com', 'Teste@123', '(11) 3000-0007', '(11) 99000-0007', '2026-10-15 14:55:03', 'M', '1988-09-12', 'Casado(a)'),
(8, 'Camila Rodrigues', '00.000.000-08', '000.000.000-08', 1, 'Rua das Palmeiras', 'Apto 31', 'Jundiaí', '13201-008', 91, 'Anhangabaú', 'SP', 'cliente08@example.com', 'Teste@123', '(11) 3000-0008', '(11) 99000-0008', '2026-10-15 14:55:03', 'F', '2000-01-25', 'Solteiro(a)'),
(9, 'Felipe Carvalho', '', '000.000.000-09', 1, 'Avenida Central', NULL, 'Sorocaba', '18035-009', 630, 'Jardim Europa', 'SP', 'cliente09@example.com', 'Teste@123', '(15) 3000-0009', '(15) 99000-0009', '2026-10-15 14:55:03', 'M', '1994-12-07', 'Separado(a) Judicialmente'),
(10, 'Beatriz Lima', '00.000.000-10', '000.000.000-10', 1, 'Rua dos Ipês', 'Casa 4', 'Santos', '11055-010', 215, 'Gonzaga', 'SP', 'cliente10@example.com', 'Teste@123', '(13) 3000-0010', '(13) 99000-0010', '2026-10-15 14:55:03', 'F', '1996-06-16', 'Casado(a)'),
(11, 'Gustavo Ribeiro', '00.000.000-11', '000.000.000-11', 1, 'Rua do Bosque', NULL, 'Piracicaba', '13405-011', 72, 'Água Branca', 'SP', 'cliente11@example.com', 'Teste@123', '(19) 3000-0011', '(19) 99000-0011', '2026-10-15 14:55:03', 'M', '2002-03-09', 'Solteiro(a)'),
(12, 'Isabela Mendes', '00.000.000-12', '000.000.000-12', 1, 'Avenida dos Estados', 'Apto 44', 'Santo André', '09010-012', 410, 'Centro', 'SP', 'cliente12@example.com', 'Teste@123', '(11) 3000-0012', '(11) 99000-0012', '2026-10-15 14:55:03', 'F', '1993-10-30', 'União Estável'),
(13, 'Matheus Barbosa', '00.000.000-13', '000.000.000-13', 1, 'Rua Bela Vista', NULL, 'Indaiatuba', '13330-013', 155, 'Cidade Nova', 'SP', 'cliente13@example.com', 'Teste@123', '(19) 3000-0013', '(19) 99000-0013', '2026-10-15 14:55:03', 'M', '1999-02-17', 'Solteiro(a)'),
(14, 'Larissa Gomes', '00.000.000-14', '000.000.000-14', 1, 'Rua Santa Catarina', 'Casa 1', 'Bauru', '17010-014', 83, 'Vila Falcão', 'SP', 'cliente14@example.com', 'Teste@123', '(14) 3000-0014', '(14) 99000-0014', '2026-10-15 14:55:03', 'F', '1991-05-21', 'Divorciado(a)'),
(15, 'Bruno Teixeira', '', '000.000.000-15', 1, 'Avenida Paulista', 'Apto 82', 'São Paulo', '01310-015', 950, 'Bela Vista', 'SP', 'cliente15@example.com', 'Teste@123', '(11) 3000-0015', '(11) 99000-0015', '2026-10-15 14:55:03', 'M', '1987-08-04', 'Casado(a)'),
(16, 'Amanda Nascimento', '00.000.000-16', '000.000.000-16', 0, 'Rua Paraná', '', 'Franca', '14400-016', 304, 'Estação', 'SP', 'cliente16@example.com', 'Teste@123', '(16) 3000-0016', '(16) 99000-0016', '2026-10-15 14:55:03', 'F', '2003-12-11', 'Solteiro(a)'),
(17, 'Diego Moreira', '00.000.000-17', '000.000.000-17', 1, 'Rua das Orquídeas', 'Bloco C', 'Araraquara', '14801-017', 67, 'Jardim Primavera', 'SP', 'cliente17@example.com', 'Teste@123', '(16) 3000-0017', '(16) 99000-0017', '2026-10-15 14:55:03', 'M', '1990-04-13', 'Viúvo(a)'),
(18, 'Letícia Cardoso', '00.000.000-18', '000.000.000-18', 1, 'Rua Minas Gerais', NULL, 'Mogi das Cruzes', '08710-018', 228, 'Centro', 'SP', 'cliente18@example.com', 'Teste@123', '(11) 3000-0018', '(11) 99000-0018', '2026-10-15 14:55:03', 'F', '1998-07-26', 'Solteiro(a)'),
(19, 'Vinícius Lopes', '00.000.000-19', '000.000.000-19', 1, 'Avenida das Nações', 'Apto 15', 'São José dos Campos', '12210-019', 512, 'Vila Adyana', 'SP', 'cliente19@example.com', 'Teste@123', '(12) 3000-0019', '(12) 99000-0019', '2026-10-15 14:55:03', 'N', '2000-09-01', 'União Estável'),
(20, 'Sofia Azevedo', '00.000.000-20', '000.000.000-20', 1, 'Rua do Lago', NULL, 'Taubaté', '12010-020', 143, 'Centro', 'SP', 'cliente20@example.com', 'Teste@123', '(12) 3000-0020', '(12) 99000-0020', '2026-10-15 14:55:03', 'F', '1997-01-18', 'Casado(a)'),
(21, 'Eduardo Freitas', '00.000.000-21', '000.000.000-21', 1, 'Rua Tiradentes', 'Casa 3', 'Botucatu', '18600-021', 89, 'Vila dos Lavradores', 'SP', 'cliente21@example.com', 'Teste@123', '(14) 3000-0021', '(14) 99000-0021', '2026-10-15 14:55:03', 'M', '1985-11-24', 'Separado(a) Judicialmente'),
(22, 'Nicole Vieira', '00.000.000-22', '000.000.000-22', 1, 'Rua do Sol', NULL, 'Marília', '17500-022', 376, 'Fragata', 'SP', 'cliente22@example.com', 'Teste@123', '(14) 3000-0022', '(14) 99000-0022', '2026-10-15 14:55:03', 'F', '2001-06-05', 'Solteiro(a)'),
(23, 'Henrique Dias', '00.000.000-23', '000.000.000-23', 1, 'Avenida dos Trabalhadores', 'Apto 21', 'Guarulhos', '07010-023', 621, 'Macedo', 'SP', 'cliente23@example.com', 'Teste@123', '(11) 3000-0023', '(11) 99000-0023', '2026-10-15 14:55:03', 'M', '1996-03-27', 'Divorciado(a)'),
(24, 'Vitória Monteiro', '00.000.000-24', '000.000.000-24', 1, 'Rua das Oliveiras', NULL, 'Jundiaí', '13214-024', 97, 'Vila Rami', 'SP', 'cliente24@example.com', 'Teste@123', '(11) 3000-0024', '(11) 99000-0024', '2026-10-15 14:55:03', 'F', '1994-08-15', 'Casado(a)'),
(25, 'André Correia', '00.000.000-25', '000.000.000-25', 1, 'Rua Primeiro de Maio', 'Fundos', 'Piracicaba', '13417-025', 266, 'Vila Rezende', 'SP', 'cliente25@example.com', 'Teste@123', '(19) 3000-0025', '(19) 99000-0025', '2026-10-15 14:55:03', 'M', '1989-02-08', 'União Estável'),
(26, 'Eduarda Pires', '00.000.000-26', '000.000.000-26', 1, 'Rua dos Jasmins', NULL, 'Campinas', '13050-026', 118, 'Jardim Aurélia', 'SP', 'cliente26@example.com', 'Teste@123', '(19) 3000-0026', '(19) 99000-0026', '2026-10-15 14:55:03', 'F', '2002-10-19', 'Solteiro(a)'),
(27, 'Leonardo Batista', '00.000.000-27', '000.000.000-27', 1, 'Avenida das Américas', 'Apto 9', 'Ribeirão Preto', '14020-027', 745, 'Jardim Sumaré', 'SP', 'cliente27@example.com', 'Teste@123', '(16) 3000-0027', '(16) 99000-0027', '2026-10-15 14:55:03', 'M', '1993-07-02', 'Viúvo(a)'),
(28, 'Manuela Castro', '00.000.000-28', '000.000.000-28', 1, 'Rua do Carmo', NULL, 'Santos', '11015-028', 302, 'Paquetá', 'SP', 'cliente28@example.com', 'Teste@123', '(13) 3000-0028', '(13) 99000-0028', '2026-10-15 14:55:03', 'F', '1999-12-29', 'Solteiro(a)'),
(29, 'Thiago Farias', '00.000.000-29', '000.000.000-29', 1, 'Rua Sete de Setembro', 'Casa 5', 'Sorocaba', '18010-029', 431, 'Centro', 'SP', 'cliente29@example.com', 'Teste@123', '(15) 3000-0029', '(15) 99000-0029', '2026-10-15 14:55:03', 'M', '1991-09-06', 'Casado(a)'),
(30, 'Clara Rezende', '00.000.000-30', '000.000.000-30', 1, 'Rua das Magnólias', NULL, 'Bauru', '17015-030', 159, 'Jardim América', 'SP', 'cliente30@example.com', 'Teste@123', '(14) 3000-0030', '(14) 99000-0030', '2026-10-15 14:55:03', 'F', '2000-04-23', 'Solteiro(a)');

-- --------------------------------------------------------

--
-- Estrutura para tabela `desenvolvedor`
--

CREATE TABLE `desenvolvedor` (
  `id_desenvolvedor` int(5) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `data_cadastro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `desenvolvedor`
--

INSERT INTO `desenvolvedor` (`id_desenvolvedor`, `nome`, `status`, `data_cadastro`) VALUES
(1, 'Mojang Studios', 1, '2026-10-15 14:39:32'),
(2, 'Nintendo', 1, '2026-10-15 14:39:42'),
(3, 'Rockstar Games', 1, '2026-10-15 14:39:42'),
(4, 'CD Projekt Red', 1, '2026-10-15 14:39:42'),
(5, 'Ubisoft', 1, '2026-10-15 14:39:42'),
(6, 'Electronic Arts', 1, '2026-10-15 14:39:42'),
(7, 'Naughty Dog', 1, '2026-10-15 14:39:42'),
(8, 'Santa Monica Studio', 1, '2026-10-15 14:39:42'),
(9, 'Insomniac Games', 1, '2026-10-15 14:39:42'),
(10, 'Guerrilla Games', 1, '2026-10-15 14:39:42'),
(11, 'Capcom', 1, '2026-10-15 14:39:42'),
(12, 'Square Enix', 1, '2026-10-15 14:39:42'),
(13, 'Bandai Namco Studios', 1, '2026-10-15 14:39:42'),
(14, 'FromSoftware', 1, '2026-10-15 14:39:42'),
(15, 'Konami', 1, '2026-10-15 14:39:42'),
(16, 'SEGA', 1, '2026-10-15 14:39:42'),
(17, 'Bethesda Game Studios', 1, '2026-10-15 14:39:42'),
(18, 'Blizzard Entertainment', 1, '2026-10-15 14:39:42'),
(19, 'Valve', 1, '2026-10-15 14:39:42'),
(20, 'Epic Games', 1, '2026-10-15 14:39:42'),
(21, 'Riot Games', 1, '2026-10-15 14:39:42'),
(22, 'Larian Studios', 1, '2026-10-15 14:39:42'),
(23, 'Obsidian Entertainment', 1, '2026-10-15 14:39:42'),
(24, 'Team Cherry', 1, '2026-10-15 14:39:42'),
(25, 'ConcernedApe', 1, '2026-10-15 14:39:42'),
(26, 'Avalanche Software', 1, '2026-10-15 16:39:57'),
(27, 'Playground Games', 1, '2026-10-15 16:49:01'),
(28, 'EA Sports', 1, '2026-10-15 16:54:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id_func` int(11) NOT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `nome_social` varchar(100) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `estado_civil` varchar(35) DEFAULT NULL,
  `cpf` char(14) NOT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `salario` decimal(7,2) DEFAULT NULL,
  `endereco` varchar(70) NOT NULL,
  `numero` int(4) NOT NULL,
  `complemento` varchar(40) DEFAULT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `estado` char(2) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `telefone_residencial` char(14) DEFAULT NULL,
  `telefone_celular` char(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_acesso` tinyint(3) UNSIGNED NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`id_func`, `id_cargo`, `nome`, `nome_social`, `foto`, `data_nascimento`, `sexo`, `estado_civil`, `cpf`, `rg`, `salario`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `telefone_residencial`, `telefone_celular`, `email`, `usuario`, `senha`, `tipo_acesso`, `data_cadastro`, `status`) VALUES
(1, 1, 'Administrador', '', 'admin/admin-photo.png', '2000-01-01', 'N', 'Solteiro(a)', '000.000.000-00', '00.000.000-0', 0.00, '', 0, '', '', '', '', '00000-000', '', '', 'admin@admin.com', 'ADMIN', 'ADMIN', 1, '2026-01-01 00:00:00', 1),
(2, 1, 'Lucas Almeida', NULL, '', '1990-05-14', 'M', 'Casado(a)', '000.000.000-31', '00.000.001-1', 4500.00, 'Rua das Flores', 125, 'Apto 12', 'Centro', 'Piracicaba', 'SP', '13400-001', '(19) 3000-0031', '(19) 99000-0031', 'funcionario01@example.com', 'lucas.almeida', 'Teste@123', 1, '2026-10-15 15:04:25', 1),
(3, 2, 'Mariana Costa', 'Mari Costa', '', '1995-08-22', 'F', 'Solteiro(a)', '000.000.000-32', '00.000.002-2', 2400.00, 'Avenida Brasil', 240, NULL, 'Cambuí', 'Campinas', 'SP', '13010-002', '(19) 3000-0032', '(19) 99000-0032', 'funcionario02@example.com', 'mariana.costa', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(4, 4, 'Pedro Henrique Souza', NULL, '', '1988-02-10', 'M', 'Casado(a)', '000.000.000-33', '00.000.003-3', 3200.00, 'Rua do Comércio', 350, 'Casa 2', 'Vila Cláudia', 'Limeira', 'SP', '13480-003', '(19) 3000-0033', '(19) 99000-0033', 'funcionario03@example.com', 'pedro.souza', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(5, 5, 'Ana Beatriz Oliveira', 'Ana Oliveira', '', '1992-11-03', 'F', 'Divorciado(a)', '000.000.000-34', '00.000.004-4', 2800.00, 'Rua São João', 48, NULL, 'Saúde', 'Rio Claro', 'SP', '13500-004', '(19) 3000-0034', '(19) 99000-0034', 'funcionario04@example.com', 'ana.oliveira', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(6, 6, 'Gabriel Santos', NULL, '', '1997-07-19', 'M', 'Solteiro(a)', '000.000.000-35', '00.000.005-5', 2600.00, 'Avenida Independência', 520, 'Bloco B', 'Paulista', 'Piracicaba', 'SP', '13416-005', '(19) 3000-0035', '(19) 99000-0035', 'funcionario05@example.com', 'gabriel.santos', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(7, 7, 'Juliana Ferreira', NULL, '', '1994-04-28', 'F', 'União Estável', '000.000.000-36', '00.000.006-6', 3500.00, 'Rua das Acácias', 76, 'Fundos', 'Jardim Girassol', 'Americana', 'SP', '13465-006', '(19) 3000-0036', '(19) 99000-0036', 'funcionario06@example.com', 'juliana.ferreira', 'Teste@123', 1, '2026-10-15 15:04:25', 1),
(8, 8, 'Rafael Martins', 'Rafa Martins', '', '1989-09-12', 'M', 'Casado(a)', '000.000.000-37', '00.000.007-7', 2900.00, 'Rua XV de Novembro', 184, NULL, 'República', 'São Paulo', 'SP', '01013-007', '(11) 3000-0037', '(11) 99000-0037', 'funcionario07@example.com', 'rafael.martins', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(9, 9, 'Camila Rodrigues', NULL, '', '1998-01-25', 'F', 'Solteiro(a)', '000.000.000-38', '00.000.008-8', 2300.00, 'Rua das Palmeiras', 91, 'Apto 31', 'Anhangabaú', 'Jundiaí', 'SP', '13201-008', '(11) 3000-0038', '(11) 99000-0038', 'funcionario08@example.com', 'camila.rodrigues', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(10, 10, 'Felipe Carvalho', '', '', '1987-12-07', 'M', 'Solteiro', '000.000.000-39', '00.000.009-9', 3800.00, 'Avenida Central', 630, '', 'Jardim Europa', 'Sorocaba', 'SP', '18035-009', '(15) 3000-0039', '(15) 99000-0039', 'funcionario09@example.com', 'felipe.carvalho', 'Teste@123', 1, '2026-10-15 15:04:25', 0),
(11, 11, 'Beatriz Lima', 'Bia Lima', '', '1996-06-16', 'F', 'Casado(a)', '000.000.000-40', '00.000.010-0', 2500.00, 'Rua dos Ipês', 215, NULL, 'Gonzaga', 'Santos', 'SP', '11055-010', '(13) 3000-0040', '(13) 99000-0040', 'funcionario10@example.com', 'beatriz.lima', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(12, 12, 'Gustavo Ribeiro', NULL, '', '1993-03-09', 'M', 'Solteiro(a)', '000.000.000-41', '00.000.011-1', 3100.00, 'Rua do Bosque', 72, 'Casa 1', 'Água Branca', 'Piracicaba', 'SP', '13405-011', '(19) 3000-0041', '(19) 99000-0041', 'funcionario11@example.com', 'gustavo.ribeiro', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(13, 13, 'Isabela Mendes', NULL, '', '1991-10-30', 'F', 'União Estável', '000.000.000-42', '00.000.012-2', 4200.00, 'Avenida dos Estados', 410, 'Apto 44', 'Centro', 'Santo André', 'SP', '09010-012', '(11) 3000-0042', '(11) 99000-0042', 'funcionario12@example.com', 'isabela.mendes', 'Teste@123', 1, '2026-10-15 15:04:25', 1),
(14, 1, 'Matheus Barbosa', '', 'minimalist-backiee.jpg', '1999-02-17', 'M', 'Solteiro', '000.000.000-43', '00.000.013-3', 2700.00, 'Rua Bela Vista', 155, '', 'Cidade Nova', 'Indaiatuba', 'SP', '13330-013', '(19) 3000-0043', '(19) 99000-0043', 'funcionario13@example.com', 'matheus.barbosa', 'Teste@123', 0, '2026-10-15 15:04:25', 1),
(15, 2, 'Larissa Gomes', 'Lari Gomes', '', '1990-05-21', 'F', 'Divorciado(a)', '000.000.000-44', '00.000.014-4', 3300.00, 'Rua Santa Catarina', 83, 'Casa 3', 'Vila Falcão', 'Bauru', 'SP', '17010-014', '(14) 3000-0044', '(14) 99000-0044', 'funcionario14@example.com', 'larissa.gomes', 'Teste@123', 1, '2026-10-15 15:04:25', 1),
(16, 4, 'Bruno Teixeira', NULL, '', '1985-08-04', 'M', 'Casado(a)', '000.000.000-45', '00.000.015-5', 4000.00, 'Avenida Paulista', 950, 'Apto 82', 'Bela Vista', 'São Paulo', 'SP', '01310-015', '(11) 3000-0045', '(11) 99000-0045', 'funcionario15@example.com', 'bruno.teixeira', 'Teste@123', 1, '2026-10-15 15:04:25', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `genero_jogo`
--

CREATE TABLE `genero_jogo` (
  `id_genero` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `genero_jogo`
--

INSERT INTO `genero_jogo` (`id_genero`, `nome`, `data_cadastro`, `status`) VALUES
(2, 'Ação', '2026-10-15 14:31:29', 1),
(3, 'Aventura', '2026-10-15 14:33:13', 1),
(23, 'RPG', '2026-10-15 14:33:49', 1),
(24, 'Estratégia', '2026-10-15 14:33:49', 1),
(25, 'Simulação', '2026-10-15 14:33:49', 1),
(26, 'Esportes', '2026-10-15 14:33:49', 1),
(27, 'Corrida', '2026-10-15 14:33:49', 1),
(28, 'Luta', '2026-10-15 14:33:49', 1),
(29, 'Tiro', '2026-10-15 14:33:49', 1),
(30, 'Terror', '2026-10-15 14:33:49', 1),
(31, 'Sobrevivência', '2026-10-15 14:33:49', 1),
(32, 'Plataforma', '2026-10-15 14:33:49', 1),
(33, 'Quebra-cabeça', '2026-10-15 14:33:49', 1),
(34, 'Musical', '2026-10-15 14:33:49', 1),
(35, 'Stealth', '2026-10-15 14:33:49', 1),
(36, 'Battle Royale', '2026-10-15 14:33:49', 1),
(37, 'Mundo Aberto', '2026-10-15 14:33:49', 1),
(38, 'Hack and Slash', '2026-10-15 14:33:49', 1),
(39, 'Metroidvania', '2026-10-15 14:33:49', 1),
(40, 'Visual Novel', '2026-10-15 14:33:49', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `data_cadastro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `marca`
--

INSERT INTO `marca` (`id_marca`, `nome`, `status`, `data_cadastro`) VALUES
(1, 'Microsoft', 1, '2026-10-15 14:13:35'),
(2, 'Sony', 1, '2026-10-15 14:13:43'),
(4, 'Valve', 1, '2026-10-15 14:15:19'),
(5, 'Sega', 1, '2026-10-15 14:15:39'),
(6, 'Nintendo', 1, '2026-10-15 14:15:48'),
(7, 'Atari', 1, '2026-10-15 14:17:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `plataforma`
--

CREATE TABLE `plataforma` (
  `id_plataforma` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `data_cadastro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `plataforma`
--

INSERT INTO `plataforma` (`id_plataforma`, `nome`, `status`, `data_cadastro`) VALUES
(1, 'PlayStation', 1, '2026-10-15 14:17:37'),
(2, 'PlayStation 2', 1, '2026-10-15 14:17:44'),
(3, 'PlayStation 3', 1, '2026-10-15 14:17:52'),
(4, 'PlayStation 4', 1, '2026-10-15 14:18:00'),
(5, 'PlayStation 5', 1, '2026-10-15 14:18:10'),
(6, 'Xbox', 1, '2026-10-15 14:18:20'),
(7, 'Xbox 360', 1, '2026-10-15 14:19:45'),
(8, 'Xbox One', 1, '2026-10-15 14:19:55'),
(9, 'Xbox Series', 1, '2026-10-15 14:20:03'),
(10, 'Steam Deck', 1, '2026-10-15 14:20:14'),
(11, 'Super Nintendo', 1, '2026-10-15 14:28:00'),
(12, 'Nintendo 64', 1, '2026-10-15 14:28:06'),
(13, 'Nintendo Wii', 1, '2026-10-15 14:28:15'),
(14, 'Nintendo Wii U', 1, '2026-10-15 14:28:23'),
(15, 'Nintendo Switch', 1, '2026-10-15 14:28:47'),
(16, 'Nintendo Switch 2', 1, '2026-10-15 14:28:55'),
(17, 'Nintendo 3DS', 1, '2026-10-15 14:29:10'),
(18, 'Dreamcast', 1, '2026-10-15 14:29:30'),
(19, 'Mega Drive', 1, '2026-10-15 14:29:38'),
(20, 'PC', 1, '2026-10-15 16:37:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_desenvolvedor` int(11) DEFAULT NULL,
  `id_plataforma` int(11) DEFAULT NULL,
  `id_genero` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `estoque` int(5) DEFAULT NULL,
  `cor` varchar(35) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `cpu_min` varchar(50) DEFAULT NULL,
  `gpu_min` varchar(50) DEFAULT NULL,
  `so_min` varchar(50) DEFAULT NULL,
  `ram_min` varchar(10) DEFAULT NULL,
  `preco_custo` decimal(8,2) NOT NULL,
  `lucro` decimal(5,2) NOT NULL,
  `preco_venda` decimal(8,2) NOT NULL,
  `status_promocao` tinyint(3) UNSIGNED DEFAULT NULL,
  `desconto` decimal(5,2) DEFAULT NULL,
  `preco_promocao` decimal(8,2) DEFAULT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `imagem_principal` varchar(255) DEFAULT NULL,
  `imagem_2` varchar(255) DEFAULT NULL,
  `imagem_3` varchar(255) DEFAULT NULL,
  `imagem_4` varchar(255) DEFAULT NULL,
  `armazenamento` varchar(10) DEFAULT NULL,
  `leitor` tinyint(3) UNSIGNED DEFAULT NULL,
  `voltagem` varchar(30) DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_desenvolvedor`, `id_plataforma`, `id_genero`, `id_categoria`, `id_marca`, `nome`, `estoque`, `cor`, `data_cadastro`, `cpu_min`, `gpu_min`, `so_min`, `ram_min`, `preco_custo`, `lucro`, `preco_venda`, `status_promocao`, `desconto`, `preco_promocao`, `descricao`, `imagem_principal`, `imagem_2`, `imagem_3`, `imagem_4`, `armazenamento`, `leitor`, `voltagem`, `status`) VALUES
(14, 7, 5, 31, 1, NULL, 'The Last Of Us Part I', 120, '', '2026-10-15 16:08:10', NULL, NULL, NULL, NULL, 150.00, 35.00, 202.50, 0, NULL, NULL, 'Aventura narrativa de sobrevivência em um mundo devastado por uma infecção.', 'tlou_A.png', 'tlou_B.jpg', 'tlou_C.jpg', 'tlou_D.jpg', NULL, 0, '', 1),
(15, 4, 20, 23, 1, NULL, 'Cyperpunk 2077', 143, '', '2026-10-15 16:38:37', 'Intel Core i5-10400F', 'NVIDIA GeForce GTX 1060', 'Windows 10', '12GB', 95.00, 10.00, 104.50, 0, 0.00, 0.00, 'RPG futurista em mundo aberto ambientado em Night City.', 'Acyber2077.png', 'cp2077-8.webp', 'cyberpunk-2077-distritos.jpg', 'evolucao-games-2010-2020-20cyberpunk-2077.webp', NULL, 0, '', 1),
(16, NULL, 9, 3, 1, NULL, 'Hogwarts Legacy', 55, '', '2026-10-15 16:40:38', NULL, NULL, NULL, NULL, 85.00, 30.00, 110.50, 0, NULL, NULL, 'Aventura ambientada no universo de Harry Potter, com exploração de Hogwarts e uso de magia.', 'Ahl.jpeg', 'harry-potter.webp', 'images (1).jpg', 'images.jpg', NULL, 0, '', 1),
(17, 3, 4, 2, 1, NULL, 'Red Dead Redemption 2', 14, '', '2026-10-15 16:41:55', NULL, NULL, NULL, NULL, 80.00, 40.00, 112.00, 1, 20.00, 89.60, 'Aventura de faroeste em mundo aberto, com narrativa, exploração e atividades de sobrevivência.', '0rdr2.png', '07123837773203_5agf.jpg', 'Red-Dead-Redemption-2-Gameforfun-5-1.jpg', 'Red-Dead-Redemption-2-in-game-Screenshot-Image-Source-Steam-Community-User-Oppai-Dragon.png', NULL, 0, '', 1),
(19, 24, 5, 39, 1, NULL, 'Hollow Knight Silksong', 22, '', '2026-10-15 16:43:39', NULL, NULL, NULL, NULL, 20.00, 50.00, 30.00, 1, 15.00, 25.50, 'Aventura de exploração em um reino subterrâneo, com combates e áreas interconectadas.', '0silksong.jpeg', 'hollow-knight-silksong.jpg', '', '', NULL, 0, '', 1),
(20, 25, 20, 25, 1, NULL, 'Stardew Valley', 30, '', '2026-10-15 16:44:48', 'AMD Ryzen 5 2600', 'NVIDIA GeForce GTX 1060', 'Windows 7', '4GB', 15.00, 33.00, 19.95, 0, NULL, NULL, 'Simulador de fazenda com agricultura, pesca, mineração e relacionamento com personagens.', '0stardew.png', 'fcp7vcbvcasijaj_z66z.1200.webp', 'ss_9ac899fe2cda15d48b0549bba77ef8c4a090a.webp', '', NULL, 0, '', 1),
(21, 11, 16, 28, 1, NULL, 'Street Fighter 6', 323, '', '2026-10-15 16:47:31', NULL, NULL, NULL, NULL, 100.00, 10.00, 110.00, 1, 5.00, 104.50, 'Jogo de luta com combates individuais, personagens variados e modos competitivos.', '0street6.jpg', '91llyvngt-l-_ac_sl1500_-c151ptm42m.jpg', 'guile-sonic-boom.webp', 'street-fighter-6.webp', NULL, 0, '', 1),
(22, 27, 9, 27, 1, NULL, 'Forza Horizon 6', 200, '', '2026-10-15 16:49:48', NULL, NULL, NULL, NULL, 235.00, 25.00, 293.75, 1, 15.00, 249.69, 'Jogo de corrida em mundo aberto ambientado em paisagens inspiradas no Japão.', '0forza6.jpg', 'Forza_Horizon6_Launch_03_Hirosaki_Castle_16x9_WM_405a5941e3.jpg', 'G_SWGT9XsAE3ssd.webp', 'screenshot_wss2.png', NULL, 0, '', 1),
(23, 3, 20, 2, 1, NULL, 'Grand Theft Auto V', 20, '', '2026-10-15 16:50:55', 'Intel Core i5-8400', 'NVIDIA GeForce GTX 1060', 'Windows 10', '4GB', 70.00, 40.00, 98.00, 0, NULL, NULL, 'Jogo de ação em mundo aberto com missões, veículos e atividades criminosas fictícias.', '0gta5.png', 'Grand_Theft_Auto_V_Los_Santos.png', 'gta-5.webp', 'reproducao-gta-v-divulgacao-scaled.jpg', NULL, 0, '', 1),
(24, 11, 5, 30, 1, NULL, 'Resident Evil 4 (Remake)', 5, '', '2026-10-15 16:52:07', NULL, NULL, NULL, NULL, 100.00, 35.00, 135.00, 1, 5.00, 128.25, 'Ação e terror de sobrevivência em uma missão para resgatar a filha do presidente.', 're4.png', 'remake-resident-evil-4.webp', 'resident-evil-4_1.webp', 'resident-evil-4-remake-the-mercenaries-abril-modo-sobrevivencia.webp', NULL, 0, '', 1),
(25, 4, 9, 23, 1, NULL, 'The Witcher 3: Wild Hunt', 10, '', '2026-10-15 16:53:09', NULL, NULL, NULL, NULL, 55.00, 45.00, 79.75, 1, 20.00, 63.80, 'RPG de fantasia em mundo aberto, com exploração, monstros e escolhas narrativas.', '0tw3.png', '2013-03-01-the-witcher-3-wild-hunt-cavalo-paisagem.webp', '2015-06-03-splash2.webp', 'The_Witcher_3_Wild_Hunt_Hearts_of_Stone_Fine_Ill_do_it_but_first_you_need_a_breath_mint.png', NULL, 0, '', 1),
(27, 8, 20, 2, 1, NULL, 'God of War Ragnarök', 8, '', '2026-10-15 16:56:35', 'Intel Core i5-8400', 'NVIDIA GeForce GTX 1060', 'Windows 10', '8GB', 120.00, 30.00, 156.00, 1, 8.00, 143.52, 'Aventura de ação mitológica protagonizada por Kratos e Atreus.', '0gowr.jpg', 'god-of-war-ragnarok-kratos-thor-historia-controle-tematico.webp', 'god-of-war-ragnarok-tudo-sobre-ps5-ps4-problemas-pandemia.webp', 'i610384.png', NULL, 0, '', 1),
(29, 28, 9, 26, 1, NULL, 'EA Sports FC 26', 1, '', '2026-10-15 17:05:33', NULL, NULL, NULL, NULL, 160.00, 25.00, 200.00, 1, 15.00, 170.00, 'Simulador de futebol com clubes, competições e modos online.', '0eas26.png', 'ea-sports-fc-26-the-worlds-game-update-screenshots_usz1.600.webp', 'jogo-ea-sports-fc-26-ps4-ea000012ps4_1756844983_gg.webp', '', NULL, 0, '', 1),
(30, NULL, NULL, NULL, 2, 1, 'Xbox Series X', 50, 'Preto', '2026-10-15 17:23:44', NULL, NULL, NULL, NULL, 3200.00, 15.00, 3680.00, 0, NULL, NULL, 'Console de alto desempenho da Microsoft, com suporte a jogos em 4K.', '185203.png', 'Console-Xbox-Series-X-Microsoft-1Tb-Controle-Sem-Fio-Preto_1788272014.webp', 'D_NQ_NP_769415-MLA76534763124_052024-O.webp', 'xbox-series-x-generacion-xbox.webp', '1TB', 1, 'Bi-volt', 1),
(31, NULL, NULL, NULL, 2, 1, 'Xbox Series S', 118, 'Branco', '2026-10-15 17:28:25', NULL, NULL, NULL, NULL, 2000.00, 18.00, 2360.00, 1, 8.00, 2171.20, 'Console compacto e totalmente digital, voltado a jogos da geração atual.', '0a0338236-2.webp', '1BConsole-Microsoft-Xbox-Series-S-59.webp', '4236e89d-9beb-4520-8dbd-ae16fcf1c641.jpg', 'z4aac334d-a7f7-4bc3-93a8-58151dd17851.jpg', '512GB', 0, 'Bi-volt', 1),
(33, 14, 20, 23, 1, NULL, 'Elden Ring', 80, '', '2026-10-15 17:36:21', 'Intel Core i5-8400', 'NVIDIA GeForce GTX 1060', 'Windows 10', '12GB', 110.00, 35.00, 148.50, 1, 10.00, 133.65, 'RPG de ação com exploração, chefes desafiadores e um vasto mundo de fantasia.', 'elden.jpg', 'eldenring-12-4k.webp', 'xelden-ring2.webp', 'zelden-ring.jpg', NULL, 0, '', 1),
(34, NULL, NULL, NULL, 2, 2, 'PlayStation 4 Slim', 15, '', '2026-10-15 17:59:58', NULL, NULL, NULL, NULL, 1750.00, 25.00, 2187.50, 1, 10.00, 1968.75, 'Console de oitava geração com uma ampla biblioteca de jogos.', '0000a11301202420456792.webp', '01_NQ_NP_622622-MLB92487594940_092025-O.webp', 'b237aa34b4c.webp', 'play4_2.jpg', '1TB', 1, 'Bi-volt', 1),
(35, NULL, NULL, NULL, 2, 6, 'Nintendo Switch 2', 150, NULL, '2026-10-15 18:07:44', '', '', '', '', 3000.00, 15.00, 3450.00, 1, 5.00, 3277.50, 'Sucessor do Nintendo Switch, com hardware atualizado e suporte a jogos', NULL, NULL, NULL, NULL, '256GB', 0, 'Bi-volt', 1),
(36, NULL, NULL, NULL, 2, 2, 'PlayStation 5', 50, '', '2026-10-15 18:29:36', NULL, NULL, NULL, NULL, 3750.00, 20.00, 4500.00, 1, 10.00, 4050.00, 'Console de nona geração com gráficos avançados e suporte a jogos em alta resolução.', '0main-ps5.jpg', '1play5-no-main.webp', 'console-playstation-5-slim-ssd-1tb-edicao-digital-branco-2-jogos-1000038914_1728056167_gg.webp', 'ps5traz.webp', '1TB', 1, 'Bi-volt', 1),
(37, NULL, NULL, NULL, 2, 2, 'PlayStation 2 Slim', 5, '', '2026-10-15 18:37:56', NULL, NULL, NULL, NULL, 350.00, 30.00, 455.00, 0, NULL, NULL, 'Console histórico conhecido por sua extensa biblioteca de jogos e popularidade no Brasil.', '00play2-box.webp', 'D_NQ_NP_783443-MLA78158255856_082024-O.webp', 'playstation-2-ps2-20-anos-fatos-curiosos-slim-usado.webp', 'zplaystation-2-capa-1-trzn51w0yiwm.webp', NULL, 1, '127V', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_venda`
--

CREATE TABLE `produto_venda` (
  `id_itens` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_venda` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor_item` decimal(7,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `produto_venda`
--

INSERT INTO `produto_venda` (`id_itens`, `id_produto`, `id_venda`, `quantidade`, `valor_item`, `valor_total`) VALUES
(1, 29, 1, 1, 160.00, 160.00),
(2, 15, 1, 1, 95.00, 133.00),
(3, 31, 1, 2, 2000.00, 4000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id_venda` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_func` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status` tinyint(3) UNSIGNED DEFAULT NULL,
  `forma_pagamento` varchar(60) DEFAULT NULL,
  `valor_bruto` decimal(7,2) DEFAULT NULL,
  `percentual_desconto` decimal(4,2) DEFAULT NULL,
  `preco_desconto` decimal(7,2) DEFAULT NULL,
  `valor_total` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `venda`
--

INSERT INTO `venda` (`id_venda`, `id_cliente`, `id_func`, `data`, `status`, `forma_pagamento`, `valor_bruto`, `percentual_desconto`, `preco_desconto`, `valor_total`) VALUES
(1, 25, 15, '2026-10-15 19:34:28', 1, 'PIX', 4293.00, 10.00, 3863.70, 4293.00);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `desenvolvedor`
--
ALTER TABLE `desenvolvedor`
  ADD PRIMARY KEY (`id_desenvolvedor`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_func`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- Índices de tabela `genero_jogo`
--
ALTER TABLE `genero_jogo`
  ADD PRIMARY KEY (`id_genero`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `plataforma`
--
ALTER TABLE `plataforma`
  ADD PRIMARY KEY (`id_plataforma`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_desenvolvedor` (`id_desenvolvedor`),
  ADD KEY `id_plataforma` (`id_plataforma`),
  ADD KEY `id_genero` (`id_genero`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Índices de tabela `produto_venda`
--
ALTER TABLE `produto_venda`
  ADD PRIMARY KEY (`id_itens`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_venda` (`id_venda`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_func` (`id_func`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `desenvolvedor`
--
ALTER TABLE `desenvolvedor`
  MODIFY `id_desenvolvedor` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_func` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `genero_jogo`
--
ALTER TABLE `genero_jogo`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `plataforma`
--
ALTER TABLE `plataforma`
  MODIFY `id_plataforma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `produto_venda`
--
ALTER TABLE `produto_venda`
  MODIFY `id_itens` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_desenvolvedor`) REFERENCES `desenvolvedor` (`id_desenvolvedor`),
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`id_plataforma`) REFERENCES `plataforma` (`id_plataforma`),
  ADD CONSTRAINT `produto_ibfk_3` FOREIGN KEY (`id_genero`) REFERENCES `genero_jogo` (`id_genero`),
  ADD CONSTRAINT `produto_ibfk_4` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `produto_ibfk_5` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`);

--
-- Restrições para tabelas `produto_venda`
--
ALTER TABLE `produto_venda`
  ADD CONSTRAINT `produto_venda_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  ADD CONSTRAINT `produto_venda_ibfk_2` FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id_venda`);

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`id_func`) REFERENCES `funcionario` (`id_func`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
