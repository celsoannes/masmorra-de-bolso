-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 04/03/2025 às 04:34
-- Versão do servidor: 10.11.6-MariaDB-0+deb12u1
-- Versão do PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestao3d`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `componentes`
--

CREATE TABLE `componentes` (
  `id` int(11) NOT NULL,
  `nome_material` varchar(255) NOT NULL,
  `tipo_material` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `unidade_medida` varchar(50) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `fornecedor` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `caminho_imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `componentes`
--

INSERT INTO `componentes` (`id`, `nome_material`, `tipo_material`, `descricao`, `unidade_medida`, `preco_unitario`, `fornecedor`, `observacoes`, `caminho_imagem`) VALUES
(7, 'Tigelas Redonda Cumbuca Em Aço Inox 17cm', 'Aço Inox', 'Tigelas Redonda Cumbuca Em Aço Inox 17cm\r\n\r\nNão tem um recipiente adequado para servir sobremesa, molhos e porções?\r\n\r\nA tigelas cumbuca em Inox 17cm é ideal para casa, lanchonetes ou restaurantes trazendo durabilidade, beleza e praticada a sua cozinha no momento de preparar e levar a mesa.\r\n\r\nFabricado em aço inox.\r\nTamanho: 500ml\r\n\r\nMedida aproximadas de: 17 L x 4 A cm.\r\n\r\nAcompanha o produto:\r\n   • - 12 x Tigela Redonda Cumbuca Em Aço Inox 17cm', 'pc', 6.40, 'https://shopee.com.br/product/741556559/23507289429?uls_trackid=524d37sh01s1&utm_campaign=id_7XfK3pi6C6&utm_content=----&utm_medium=affiliates&utm_source=an_18307260223&utm_term=cngp98wqgiy5', '', '../uploads/imagens/afc4674651512c525fbc65425eb591bd.png'),
(8, 'Ímã de neodímio 8x3 mm', 'Ímã', 'Ímã de neodímio super potente\r\nEscolha a medida para o envio de 1 kit com 20 peças da medida escolhida\r\nTemos o maior acervo em tamanhos e medias diferente de ímã de neodímio do Brasil\r\n\r\nEspecificações de cada tamanho disponível neste anuncio:\r\n\r\nCaracterísticas Gerais\r\nRevestimento de Níquel (Ni-Cu-Ni)\r\nTemperatura máxima de trabalho: 80 °C\r\nFormato: Disco\r\n\r\n8x3 mm\r\nDiâmetro: 8 mm ou 0,8 cm\r\nEspessura: 2 mm ou 0,2 cm\r\nSuporta até 1,2 kg cada peça\r\nPossui 3600 Gauss\r\nPeso: 1,1 gramas cada peça', 'pc', 2.03, 'https://shopee.com.br/%C3%8Dm%C3%A3-de-neod%C3%ADmio-8x1-8x1-5-8x2-8x3-8x4-8x5-8x8-8x10-mm-20-pe%C3%A7as-super-%C3%ADmas-potente-disco-imediato-i.1345872510.22697752989', '', '../uploads/imagens/df4b64131c19e4492daca61039d3ec52.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estacoes_lavagem`
--

CREATE TABLE `estacoes_lavagem` (
  `ID` int(11) NOT NULL,
  `Marca` varchar(255) DEFAULT NULL,
  `Modelo` varchar(255) DEFAULT NULL,
  `Localizacao` varchar(255) DEFAULT NULL,
  `Data_Aquisicao` date DEFAULT NULL,
  `Valor_do_Bem` decimal(10,2) DEFAULT NULL,
  `Tempo_de_Vida_Util` int(11) DEFAULT NULL,
  `kWh` decimal(10,3) DEFAULT NULL,
  `lavagem_id` int(10) UNSIGNED DEFAULT NULL,
  `tempo_lavagem` time DEFAULT NULL,
  `tempo_cura` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estacoes_lavagem`
--

INSERT INTO `estacoes_lavagem` (`ID`, `Marca`, `Modelo`, `Localizacao`, `Data_Aquisicao`, `Valor_do_Bem`, `Tempo_de_Vida_Util`, `kWh`, `lavagem_id`, `tempo_lavagem`, `tempo_cura`) VALUES
(4, 'Elegoo', 'MERCURY PLUS V3.0', 'Laboratório', '2024-03-01', 1293.99, 8766, 0.060, 1, '00:05:00', '00:30:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estudios`
--

CREATE TABLE `estudios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estudios`
--

INSERT INTO `estudios` (`id`, `nome`, `site`, `created_at`) VALUES
(2, 'Curations By Kira', 'https://www.curationsbykira.com/', '2025-03-02 06:29:35'),
(8, 'Goldem Dragons', NULL, '2025-03-03 20:23:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `filamentos`
--

CREATE TABLE `filamentos` (
  `id` int(11) NOT NULL,
  `Tipo` varchar(255) DEFAULT NULL,
  `Fabricante` varchar(255) DEFAULT NULL,
  `Valor_Kg` decimal(10,2) DEFAULT NULL,
  `Ultima_Atualizacao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filamentos`
--

INSERT INTO `filamentos` (`id`, `Tipo`, `Fabricante`, `Valor_Kg`, `Ultima_Atualizacao`) VALUES
(1, 'PLA PREMIUM', 'F3D', 99.00, '2025-03-01'),
(2, 'Troca de Cor', 'Voolt', 67.90, '2025-03-02'),
(3, 'Velvet', 'Voolt', 117.90, '2025-03-03'),
(4, 'Rainbow Multicolor', 'Voolt', 139.90, '2025-03-04'),
(5, 'Duo Color e Dourado', 'Voolt', 137.90, '2025-03-05'),
(6, 'Cosmo Multicolor', 'Voolt', 127.90, '2025-03-01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `impressoras`
--

CREATE TABLE `impressoras` (
  `ID` int(11) NOT NULL,
  `Marca` varchar(255) DEFAULT NULL,
  `Modelo` varchar(255) DEFAULT NULL,
  `Tipo` enum('Resina','Filamento') DEFAULT NULL,
  `Localizacao` varchar(255) DEFAULT NULL,
  `Data_Aquisicao` date DEFAULT NULL,
  `Valor_do_Bem` decimal(10,2) DEFAULT NULL,
  `Tempo_de_Vida_Util` int(11) DEFAULT NULL,
  `kWh` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `impressoras`
--

INSERT INTO `impressoras` (`ID`, `Marca`, `Modelo`, `Tipo`, `Localizacao`, `Data_Aquisicao`, `Valor_do_Bem`, `Tempo_de_Vida_Util`, `kWh`) VALUES
(1, 'Bambu Lab', 'A1', 'Filamento', 'Laboratório', '2024-01-15', 5999.00, 8766, 0.500),
(2, 'Elegoo', 'Saturn 3 Ultra', 'Resina', 'Laboratório', '2024-02-20', 3295.99, 2000, 0.072);

-- --------------------------------------------------------

--
-- Estrutura para tabela `lavagem`
--

CREATE TABLE `lavagem` (
  `id` int(10) UNSIGNED NOT NULL,
  `Produto` varchar(255) DEFAULT NULL,
  `Valor_Litro` decimal(10,2) DEFAULT NULL,
  `Fator_Consumo` decimal(10,3) DEFAULT NULL,
  `Ultima_Atualizacao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lavagem`
--

INSERT INTO `lavagem` (`id`, `Produto`, `Valor_Litro`, `Fator_Consumo`, `Ultima_Atualizacao`) VALUES
(1, 'Álcool Isopropílico', 24.00, 0.024, '2025-03-01'),
(2, 'Etanol', 5.95, 0.006, '2025-03-01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pecas`
--

CREATE TABLE `pecas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `estudio_id` int(11) DEFAULT NULL,
  `nome_original` varchar(255) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `impressora` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `quantidade_material` decimal(10,2) NOT NULL,
  `tempo_impressao` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pecas`
--

INSERT INTO `pecas` (`id`, `nome`, `estudio_id`, `nome_original`, `nome_arquivo`, `impressora`, `material`, `quantidade_material`, `tempo_impressao`, `created_at`, `imagem`) VALUES
(24, 'Torre de Dados Toca do Hobbit Faminto com Tigela de Petiscos', 2, 'Hungry Halfling Snack Bowl Dice Tower', 'Hungry Halfling Snack Bowl Dice Tower v1.7.3mf', '1', 'Duo Color e Dourado', 358.00, '19:59:00', '2025-03-03 16:40:10', '../uploads/pecas/67c5db6a65ef6.png'),
(26, 'Snackbowl Divider', 2, 'Snackbowl Divider', 'snack bowl dice divider v1.2.stl', '1', 'Rainbow Multicolor', 64.00, '01:58:00', '2025-03-03 17:09:40', '../uploads/pecas/67c5e254347a5.png'),
(27, 'Berdolock', 8, 'Berdolock', 'Berdolock - Miniaturas para FtQ.stl', '2', 'Semi-Flexível (70/30)', 7.00, '02:12:00', '2025-03-03 20:23:42', '../uploads/pecas/67c60fce69403.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `caminho_imagem` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `baixar` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `lucro` decimal(10,2) NOT NULL DEFAULT 150.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `caminho_imagem`, `video`, `baixar`, `observacoes`, `lucro`) VALUES
(8, 'Torre de Dados Toca do Hobbit Faminto com Tigela de Petiscos', '../uploads/imagens/d7914ebf4f752e858b0bce859a9f9968.png', 'http://192.168.0.220/controllers/adicionar_produto.php', 'http://192.168.0.220/controllers/adicionar_produto.php', 'http://192.168.0.220/controllers/adicionar_produto.php', 150.00),
(9, 'Berdolock - Miniaturas para FtQ', '../uploads/imagens/e38661b2bd06e68dca2fe48d6dbcaa4a.png', 'http://192.168.0.220/controllers/adicionar_produto.php', 'http://192.168.0.220/controllers/adicionar_produto.php', '', 150.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_componentes`
--

CREATE TABLE `produtos_componentes` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `componente_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos_componentes`
--

INSERT INTO `produtos_componentes` (`id`, `produto_id`, `componente_id`, `quantidade`) VALUES
(14, 8, 7, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_pecas`
--

CREATE TABLE `produtos_pecas` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `peca_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos_pecas`
--

INSERT INTO `produtos_pecas` (`id`, `produto_id`, `peca_id`, `quantidade`) VALUES
(32, 8, 24, 1),
(33, 8, 26, 1),
(34, 9, 27, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `resinas`
--

CREATE TABLE `resinas` (
  `id` int(11) NOT NULL,
  `Tipo` varchar(255) DEFAULT NULL,
  `Fabricante` varchar(255) DEFAULT NULL,
  `Valor_Kg` decimal(10,2) DEFAULT NULL,
  `Ultima_Atualizacao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `resinas`
--

INSERT INTO `resinas` (`id`, `Tipo`, `Fabricante`, `Valor_Kg`, `Ultima_Atualizacao`) VALUES
(1, 'Abs-Like Mk3', 'M.I.H.', 148.06, '2025-03-01'),
(2, 'Resina Flexível', 'M.I.H.', 228.88, '2025-03-01'),
(3, 'Semi-Flexível (70/30)', 'M.I.H.', 172.30, '2025-03-01'),
(4, 'Basic', 'F3D', 99.00, '2025-03-01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_energia`
--

CREATE TABLE `tabela_energia` (
  `id` int(11) NOT NULL,
  `Prestadora` varchar(255) DEFAULT NULL,
  `kWh` decimal(10,2) DEFAULT NULL,
  `ICMS` decimal(5,2) DEFAULT NULL,
  `PIS_PASEP` decimal(5,2) DEFAULT NULL,
  `COFINS` decimal(5,2) DEFAULT NULL,
  `TOTAL_horas` decimal(10,2) DEFAULT NULL,
  `Ultima_Atualizacao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tabela_energia`
--

INSERT INTO `tabela_energia` (`id`, `Prestadora`, `kWh`, `ICMS`, `PIS_PASEP`, `COFINS`, `TOTAL_horas`, `Ultima_Atualizacao`) VALUES
(1, 'RGE RS', 0.98, 17.00, 1.02, 4.17, 1.20, '2025-03-01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `ultimo_acesso` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha_hash`, `ultimo_acesso`, `created_at`) VALUES
(1, 'Mago Supremo', 'celsoannes@gmail.com', '$2y$10$8I2jv4zRgK7Bs8ji26zYRufxSuWbadOEiD9ST/hAgij5brbeEXteW', '2025-03-04 01:51:48', '2025-03-02 05:19:43');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estacoes_lavagem`
--
ALTER TABLE `estacoes_lavagem`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_estacoes_lavagem_lavagem` (`lavagem_id`);

--
-- Índices de tabela `estudios`
--
ALTER TABLE `estudios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `filamentos`
--
ALTER TABLE `filamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `impressoras`
--
ALTER TABLE `impressoras`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `lavagem`
--
ALTER TABLE `lavagem`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pecas`
--
ALTER TABLE `pecas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `nome_original` (`nome_original`),
  ADD UNIQUE KEY `nome_arquivo` (`nome_arquivo`),
  ADD KEY `estudio_id` (`estudio_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos_componentes`
--
ALTER TABLE `produtos_componentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `componente_id` (`componente_id`);

--
-- Índices de tabela `produtos_pecas`
--
ALTER TABLE `produtos_pecas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `peca_id` (`peca_id`);

--
-- Índices de tabela `resinas`
--
ALTER TABLE `resinas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tabela_energia`
--
ALTER TABLE `tabela_energia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `estacoes_lavagem`
--
ALTER TABLE `estacoes_lavagem`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `estudios`
--
ALTER TABLE `estudios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `filamentos`
--
ALTER TABLE `filamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `impressoras`
--
ALTER TABLE `impressoras`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `lavagem`
--
ALTER TABLE `lavagem`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pecas`
--
ALTER TABLE `pecas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `produtos_componentes`
--
ALTER TABLE `produtos_componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `produtos_pecas`
--
ALTER TABLE `produtos_pecas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `resinas`
--
ALTER TABLE `resinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tabela_energia`
--
ALTER TABLE `tabela_energia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estacoes_lavagem`
--
ALTER TABLE `estacoes_lavagem`
  ADD CONSTRAINT `fk_estacoes_lavagem_lavagem` FOREIGN KEY (`lavagem_id`) REFERENCES `lavagem` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `pecas`
--
ALTER TABLE `pecas`
  ADD CONSTRAINT `pecas_ibfk_1` FOREIGN KEY (`estudio_id`) REFERENCES `estudios` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `produtos_componentes`
--
ALTER TABLE `produtos_componentes`
  ADD CONSTRAINT `produtos_componentes_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produtos_componentes_ibfk_2` FOREIGN KEY (`componente_id`) REFERENCES `componentes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `produtos_pecas`
--
ALTER TABLE `produtos_pecas`
  ADD CONSTRAINT `produtos_pecas_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produtos_pecas_ibfk_2` FOREIGN KEY (`peca_id`) REFERENCES `pecas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;