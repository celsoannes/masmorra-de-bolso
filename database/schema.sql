-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 15/03/2025 às 22:17
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
-- Banco de dados: `dungeon`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agua`
--

CREATE TABLE `agua` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agua`
--

INSERT INTO `agua` (`id`, `descricao`) VALUES
(1, 'A água é na verdade veneno mortal.'),
(2, 'A água cura completamente a primeira pessoa que a beber.'),
(3, 'A poça contém um pequeno elemental da água que atacará quando alguém se aproximar a 5 pés.'),
(4, 'A poça contém 2d10 piranhas que são quase invisíveis contra as laterais.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `armadilhas`
--

CREATE TABLE `armadilhas` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `armadilhas`
--

INSERT INTO `armadilhas` (`id`, `descricao`) VALUES
(1, 'Armadilha de flechas.'),
(2, 'Armadilha de fogo.'),
(3, 'Armadilha de gelo.'),
(4, 'Armadilha de espinhos.'),
(5, 'Armadilha de veneno.'),
(6, 'Armadilha de líquido corrosivo.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `assunto_estatua`
--

CREATE TABLE `assunto_estatua` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `assunto_estatua`
--

INSERT INTO `assunto_estatua` (`id`, `descricao`) VALUES
(1, 'Estatuas de batalhas épicas.'),
(2, 'Estatuas de rituais religiosos.'),
(3, 'Estatuas de caça a monstros.'),
(4, 'Estatuas de sacrifícios humanos.'),
(5, 'Estatuas de figuras lendárias.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chao`
--

CREATE TABLE `chao` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chao`
--

INSERT INTO `chao` (`id`, `descricao`) VALUES
(1, 'Folhas mortas e detritos semelhantes'),
(2, 'Nada de notável'),
(3, 'Ossos roídos e manchas de sangue antigas'),
(4, 'Restos de uma estátua esmagada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `circulos`
--

CREATE TABLE `circulos` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `circulos`
--

INSERT INTO `circulos` (`id`, `descricao`) VALUES
(1, 'Um círculo mágico está desenhado no chão de laje de pedra.'),
(2, 'Uma poça de água no centro do chão de pedra áspera.'),
(3, 'Um anel de cogumelos no centro está crescendo no chão de terra da sala.'),
(4, 'Uma poça de água estagnada e suja no centro do chão.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cobertura_porta`
--

CREATE TABLE `cobertura_porta` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cobertura_porta`
--

INSERT INTO `cobertura_porta` (`id`, `descricao`) VALUES
(1, 'Uma pilha de lixo e detritos.'),
(2, 'Uma tapeçaria mofada.'),
(3, 'Uma plataforma de madeira parcialmente desmoronada.'),
(4, 'Uma grande estátua de gesso de alguma pessoa desconhecida.'),
(5, 'Uma massa espessa de teias de aranha, contendo dezenas de aranhas do tamanho de uma mão.'),
(6, 'Uma ilusão de uma parede normal.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `conteudo_buraco`
--

CREATE TABLE `conteudo_buraco` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `conteudo_buraco`
--

INSERT INTO `conteudo_buraco` (`id`, `descricao`) VALUES
(1, 'Alguns centímetros de água lamacenta.'),
(2, 'Espinhos afiados.'),
(3, 'Espinhos envenenados.'),
(4, 'Centenas de escorpiões vivos.'),
(5, 'Um adicional de 1d6+60 centímetos de água e um enxame de 5d10+10 piranhas.'),
(6, 'Um texugo gigante irritado que está preso aqui há um dia e não está nada feliz com isso.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `decoracao_masmorra`
--

CREATE TABLE `decoracao_masmorra` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `decoracao_masmorra`
--

INSERT INTO `decoracao_masmorra` (`id`, `descricao`) VALUES
(1, 'O grupo encontra um toco de tocha queimado no chão.'),
(2, 'Há um número excepcional de teias de aranha perto do teto.'),
(3, 'Há uma mancha de algum tipo de ico, ainda pegajosa, no canto sudeste.'),
(4, 'Um pedaço quebrado de uma lâmina está nas sombras no canto noroeste.'),
(5, 'Há um cheiro notável de mofo aqui.'),
(6, 'Água pinga de pontos aleatórios no teto, fazendo pequenos barulhos de pingos.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estatuas`
--

CREATE TABLE `estatuas` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estatuas`
--

INSERT INTO `estatuas` (`id`, `descricao`) VALUES
(1, 'Estatuas de guerreiros antigos.'),
(2, 'Estatuas de deuses com cabeças de animais.'),
(3, 'Estatuas de demônios com chifres e presas.'),
(4, 'Estatuas de figuras históricas importantes.'),
(5, 'Estatuas de criaturas mitológicas.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lado`
--

CREATE TABLE `lado` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lado`
--

INSERT INTO `lado` (`id`, `descricao`) VALUES
(1, 'Norte.'),
(2, 'Sul.'),
(3, 'Leste.'),
(4, 'Oeste.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `luz`
--

CREATE TABLE `luz` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `luz`
--

INSERT INTO `luz` (`id`, `descricao`) VALUES
(1, 'Uma entidade elétrica que atacará o grupo com relâmpagos quando eles entrarem na sala.'),
(2, 'A luz de um vaga-lume gigante que tentará fugir, mas atacará se for encurralado.'),
(3, 'Uma luz de cadáver flutuando acima do local onde um zumbi está escondido sob o chão. O zumbi irromperá e atacará qualquer um que se aproxime de sua sepultura.'),
(4, 'Um globo de luz mágica que não se move por conta própria, mas que pode ser ensacado e carregado; ele fornecerá luz tão brilhante quanto uma tocha por 1d6 semanas.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `magia`
--

CREATE TABLE `magia` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `magia`
--

INSERT INTO `magia` (`id`, `descricao`) VALUES
(1, '2d4 figuras encapuzadas ficam em silêncio ao redor dele, segurando tochas que queimam com chamas esverdeadas e fumacentas (são orcs).'),
(2, 'O círculo contém um demônio menor, que está extremamente irritado por estar aqui há 1d10+5 anos. Ele não pode afetar nada ou ser afetado a menos que o círculo seja quebrado.'),
(3, 'O círculo contém uma grande pilha de ossos humanoides. 1d4 centopeias enormes estão escondidas sob os ossos.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `monstros`
--

CREATE TABLE `monstros` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `monstros`
--

INSERT INTO `monstros` (`id`, `descricao`) VALUES
(1, 'Os nichos a leste contêm duas estátuas vivas que atacam quando o grupo se aproxima a 4 metros e meio.'),
(2, '1d4 goblins se escondem aqui, nas sombras atrás das estátuas nos nichos a leste.'),
(3, 'Uma pilha de detritos no canto sudoeste esconde 2d6 centopeias grandes que atacam qualquer um que se aproxime das escadas ao sul. As estátuas nos nichos a leste são apenas estátuas.'),
(4, 'Embora o grupo ouça sons fracos à distância, a sala está vazia. As estátuas nos nichos a leste são apenas estátuas.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `numero_pessoa`
--

CREATE TABLE `numero_pessoa` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `numero_pessoa`
--

INSERT INTO `numero_pessoa` (`id`, `descricao`) VALUES
(1, 'A primeira pessoa a atravessar.'),
(2, 'A segunda pessoa a atravessar.'),
(3, 'A terceira pessoa a atravessar.'),
(4, 'A quarta pessoa a atravessar.'),
(5, 'A quinta pessoa a atravessar.'),
(6, 'A sexta pessoa a atravessar.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `paredes`
--

CREATE TABLE `paredes` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `paredes`
--

INSERT INTO `paredes` (`id`, `descricao`) VALUES
(1, 'Paredes de pedra áspera'),
(2, 'Paredes com vestígios de antigos murais'),
(3, 'Paredes de pedra com argamassa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `portas`
--

CREATE TABLE `portas` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `portas`
--

INSERT INTO `portas` (`id`, `descricao`) VALUES
(1, 'Portas de madeira.'),
(2, 'Portas de madeira reforçadas com ferro.'),
(3, 'Portas de ferro.'),
(4, 'Portas enferrujadas.'),
(5, 'Portas com runas mágicas.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `salas`
--

CREATE TABLE `salas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `salas`
--

INSERT INTO `salas` (`id`, `nome`, `descricao`, `imagem`) VALUES
(1, 'Sala 1', 'A entrada principal da masmorra fica a oeste, e uma ampla escadaria leva para baixo através de um arco ao sul.', 'sala1.png'),
(2, 'Sala 2', 'Esta sala grande tem um teto alto (1d6+3 metros). Escadas levam para cima através de um arco largo ao norte. Um par de portas duplas é visível na parte norte da parede leste, e uma porta secreta está no canto sudeste. As portas têm 50% de chance de estarem trancadas.', 'sala2.png'),
(3, 'Sala 3', 'A característica mais notável desta sala é um grande círculo. Há uma porta dupla a leste e uma porta secreta na parede norte.', 'sala3.png'),
(4, 'Sala 4', 'O corredor curto atrás da porta secreta leva a esta sala. Ela contém um monstro guardando um tesouro.', 'sala4.png'),
(5, 'Sala 5', 'Há escadas largas subindo tanto no sudoeste quanto no nordeste. Há uma bola de luz flutuante no noroeste.', 'sala5.png'),
(6, 'Sala 6', 'Esta sala tem uma escada larga descendo no centro da parede oeste. Há uma porta oculta na parede sul que só pode ser localizada quando a cobertura sobre ela é removida.', 'sala6.png'),
(7, 'Sala 7', 'Há uma porta no centro do lado norte desta sala quadrada, que tem uma porta oculta no canto sudoeste. Ao redor das paredes estão seis estátuas. No centro há um sarcófago em forma de laje com um monstro em cima dele. Ele contém um tesouro.', 'sala7.png'),
(8, 'Sala 8', 'No ponto marcado nesta passagem secreta há uma armadilha.', 'sala8.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sons_fracos`
--

CREATE TABLE `sons_fracos` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `sons_fracos`
--

INSERT INTO `sons_fracos` (`id`, `descricao`) VALUES
(1, 'Assobio.'),
(2, 'Gemidos.'),
(3, 'Rosnados.'),
(4, 'Arranhões.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tesouros`
--

CREATE TABLE `tesouros` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tesouros`
--

INSERT INTO `tesouros` (`id`, `descricao`) VALUES
(1, 'Um baú com 1d100x10 peças de ouro em moedas antigas e algumas pequenas gemas no valor de 1d20x10 peças de ouro.'),
(2, 'Um baú cheio de roupas velhas, com um mapa mostrando as portas secretas nesta masmorra no fundo.'),
(3, 'Uma chave esquelética mágica que pode abrir qualquer fechadura, mas quebra após um único uso.'),
(4, 'Uma caixa cheia de pergaminhos mofados e comidos por vermes, entre os quais podem ser encontrados 1d3 pergaminhos mágicos.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_spray`
--

CREATE TABLE `tipo_spray` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo_spray`
--

INSERT INTO `tipo_spray` (`id`, `descricao`) VALUES
(1, 'Veneno.'),
(2, 'Poção de encolhimento.'),
(3, 'Ácido.'),
(4, 'Líquido que causa coceira (-3 de modificador em todas as ações até ser lavado completamente).'),
(5, 'Líquido de fogo.'),
(6, 'Líquido nauseante.');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agua`
--
ALTER TABLE `agua`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `armadilhas`
--
ALTER TABLE `armadilhas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `assunto_estatua`
--
ALTER TABLE `assunto_estatua`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `chao`
--
ALTER TABLE `chao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `circulos`
--
ALTER TABLE `circulos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cobertura_porta`
--
ALTER TABLE `cobertura_porta`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `conteudo_buraco`
--
ALTER TABLE `conteudo_buraco`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `decoracao_masmorra`
--
ALTER TABLE `decoracao_masmorra`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estatuas`
--
ALTER TABLE `estatuas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lado`
--
ALTER TABLE `lado`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `luz`
--
ALTER TABLE `luz`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `magia`
--
ALTER TABLE `magia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `monstros`
--
ALTER TABLE `monstros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `numero_pessoa`
--
ALTER TABLE `numero_pessoa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `paredes`
--
ALTER TABLE `paredes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `portas`
--
ALTER TABLE `portas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sons_fracos`
--
ALTER TABLE `sons_fracos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tesouros`
--
ALTER TABLE `tesouros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tipo_spray`
--
ALTER TABLE `tipo_spray`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agua`
--
ALTER TABLE `agua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `armadilhas`
--
ALTER TABLE `armadilhas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `assunto_estatua`
--
ALTER TABLE `assunto_estatua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `chao`
--
ALTER TABLE `chao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `circulos`
--
ALTER TABLE `circulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cobertura_porta`
--
ALTER TABLE `cobertura_porta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `conteudo_buraco`
--
ALTER TABLE `conteudo_buraco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `decoracao_masmorra`
--
ALTER TABLE `decoracao_masmorra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `estatuas`
--
ALTER TABLE `estatuas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `lado`
--
ALTER TABLE `lado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `luz`
--
ALTER TABLE `luz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `magia`
--
ALTER TABLE `magia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `monstros`
--
ALTER TABLE `monstros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `numero_pessoa`
--
ALTER TABLE `numero_pessoa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `paredes`
--
ALTER TABLE `paredes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `portas`
--
ALTER TABLE `portas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `salas`
--
ALTER TABLE `salas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `sons_fracos`
--
ALTER TABLE `sons_fracos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tesouros`
--
ALTER TABLE `tesouros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipo_spray`
--
ALTER TABLE `tipo_spray`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;