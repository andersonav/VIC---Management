-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Ago-2019 às 19:20
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cr3gmeit_vicmanagement`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade1`
--

CREATE TABLE `atividade1` (
  `ati1_id` int(11) NOT NULL,
  `ati1_codigo` varchar(55) NOT NULL,
  `at1_nome` varchar(255) DEFAULT NULL,
  `lot_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `atividade1`
--

INSERT INTO `atividade1` (`ati1_id`, `ati1_codigo`, `at1_nome`, `lot_id`, `created_at`, `updated_at`) VALUES
(1, '1.1', 'ESTALEIRO | ON SITE NEEDS', 1, NULL, '2019-08-29 08:05:08'),
(2, '1.2', 'ESTRUTURA | CONCRETE STRUCTURE', 1, NULL, NULL),
(3, '1.3', 'ALVENARIAS | MASONRY', 1, NULL, NULL),
(4, '1.4', 'IMPERMEABILIZAÇÕES | WATERPROOFING', 1, NULL, NULL),
(5, '1.5', 'CANTARIAS | STONEWORK', 1, NULL, NULL),
(6, '1.6', 'REVESTIMENTOS VERTICAIS INTERIORES | INTERIOR VERTICAL COATINGS', 1, NULL, NULL),
(7, '1.7', 'REVESTIMENTOS VERTICAIS EXTERIORES | EXTERIOR VERTICAL COATINGS', 1, NULL, NULL),
(8, '1.8', 'REVESTIMENTOS DE PAVIMENTOS | FLOOR COVERING', 1, NULL, NULL),
(9, '1.9', 'REVESTIMENTOS DE TETOS | CEILING COATINGS', 1, NULL, NULL),
(10, '2.0', 'SERRALHARIAS | STEEL WORKS', 1, NULL, NULL),
(11, '2.1', 'PINTURAS | PAINTINGS', 1, NULL, NULL),
(12, '2.2', 'ESTORES | BLINDS', 1, NULL, NULL),
(13, '2.3', 'CAIXILHARIA DE ALUMINIO | ALUMINUM WINDOWS', 1, NULL, NULL),
(14, '2.4', 'SOLUÇÔES DE VIDRO INDEPENDENTES | GLASS SOLUTIONS', 1, NULL, NULL),
(15, '2.5', 'FACHADA VENTILADA | VENTILATED FACADE', 1, NULL, NULL),
(16, '2.6', 'CARPINTARIAS | CARPENTRY', 1, NULL, NULL),
(17, '2.7', 'CASAS DE BANHO | BATHROOMS', 1, NULL, NULL),
(18, '2.8', 'COZINHAS | KITCHENS', 1, NULL, NULL),
(19, '2.9', 'REDES, BAIXA TENSÃO E TELECOMUNICAÇÕES, MECÂNICA | LOW VOLTAGE NETWORKS, TELECOMUNICATIONS, MECHANICS', 1, NULL, NULL),
(20, '3.0', 'APOIO Á CONSTRUÇÃO CIVIL | SUPPORT TO CIVIL CONSTRUCTION', 1, NULL, NULL),
(21, '3.1', 'INSTALAÇÕES ELÉCTRICAS | ELECTRICAL INSTALLATIONS', 1, NULL, NULL),
(22, '3.2', 'AVAC | HVAC', 1, NULL, NULL),
(23, '3.3', 'PAINEIS SOLARES | SOLAR PANELS', 1, NULL, NULL),
(24, '3.4', 'REDE DE DISTRIBUIÇÃO DE ÁGUA | WATER DISTRIBUTION NETWORKS', 1, NULL, NULL),
(25, '3.5', 'REDE DE DRENAGEM DE ESGOTOS DOMÉSTICOS E ÁGUAS PLUVIAIS | WATER DISTRIBUTION NETWORKS', 1, NULL, NULL),
(26, '3.6', 'REDE DE GÁS NATURAL | NATURAL GAS NETWORK', 1, NULL, NULL),
(27, '3.7', 'ELEVADORES PANORÂMICOS | PANORAMIC ELEVATORS', 1, NULL, NULL),
(28, '3.8', 'ARRANJOS e PAVIMENTOS EXTERIORES | EXTERIOR ARRANGEMENTS AND PAVEMENTS', 1, NULL, NULL),
(29, '3.9', 'SINALÉCTICA | SIGNALS', 1, NULL, NULL),
(30, '4.0', 'MESTRAGEM | FINAL ARRANGEMENTS', 2, NULL, NULL),
(31, '4.1', 'LIMPEZA FINAL OBRA | FINAL CLEANING WORK', 1, NULL, NULL),
(32, '2.0', 'Testeeeee', 1, '2019-08-29 17:59:02', '2019-08-29 17:59:02'),
(33, '2.1', 'Anderson Teste', 1, '2019-08-29 17:59:36', '2019-08-29 17:59:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade2`
--

CREATE TABLE `atividade2` (
  `ati2_id` int(11) NOT NULL,
  `ati2_codigo` varchar(55) DEFAULT NULL,
  `ati2_descricao` varchar(255) DEFAULT NULL,
  `ati2_preco_unidade` decimal(55,0) DEFAULT NULL,
  `ati2_quantidade` decimal(55,0) DEFAULT NULL,
  `ati2_faturado` decimal(50,0) DEFAULT NULL,
  `ati1_id` int(11) NOT NULL,
  `uni_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `atividade2`
--

INSERT INTO `atividade2` (`ati2_id`, `ati2_codigo`, `ati2_descricao`, `ati2_preco_unidade`, `ati2_quantidade`, `ati2_faturado`, `ati1_id`, `uni_id`, `created_at`, `updated_at`) VALUES
(2, '1.0', 'Montagem das instalações do Estaleiro, incluindo limpeza da área de implantação, instalações do Dono da Obra e da Fiscalização, redes  provisórias  de:  água;  esgotos;  eletricidade  e telecomunicações,  vias  internas  de  circulação, vedações, painéis', '80', '1', '20', 1, 1, NULL, '2019-08-29 09:04:32'),
(3, '1.1', 'BETÕES, ARGAMASSAS, CIMENTO, CALDAS', '85', '1', NULL, 2, 1, NULL, NULL),
(4, '1.1', 'ALVENARIAS EXTERIORES', '80', '1', NULL, 3, 2, NULL, NULL),
(5, '1.2', 'Em paredes simples constituídas por tijolo de 30x20x22 (E01 de 220mm + E05 de 220mm + E10 de 220mm)', '16', '1', NULL, 3, 2, NULL, NULL),
(6, '1.3', 'Em paredes simples constituídas por tijolo de 30x20x15 (E01a de 150mm + E06 de 150mm + E07 de 150mm)', '80', '2', '80', 3, 2, NULL, NULL),
(7, '1.4', 'Em paredes dupla constituídas por dois panos de tijolo de 30x20x11 (E02 de 110mm x2 + E08 de 110mm x2 + E09 de 110mm x2 +E15 de 110mm)', '90', '10', '90', 3, 2, NULL, NULL),
(8, '1.5', 'Em paredes duplas constituídas por tijolo de 30x20x07 + 30x20x11 (E04 de 70mm+110mm + E12 de 70mm+110mm)', '80', '34', '60', 3, 2, NULL, NULL),
(9, '1.6', 'Em paredes dupla constituídas por dois panos de tijolo de 30X20X11 + 30x20x15 (E01B de 110mm + 150mm + E01C de 110mm + 150mm)', '10', '34', '8', 3, 2, NULL, NULL),
(10, '1.7', 'Em paredes simples constituídas por tijolo de 30x20x11 (E11 de 110mm)', '70', '12', '60', 3, 2, NULL, NULL),
(11, '1.8', 'dsfdfd', '80', '20', '22', 2, 1, '2019-08-29 09:22:13', '2019-08-29 09:22:13'),
(12, '1.9', 'sdsdsdsdsd sds', '80', '20', '22', 1, 1, '2019-08-29 09:24:14', '2019-08-29 09:24:14'),
(13, '2.2', 'Testetetete etet', '80', '20', '22', 33, 1, '2019-08-29 18:02:43', '2019-08-29 18:02:43'),
(14, '2.2', 'Testetetete etet', '80', '20', '22', 33, 1, '2019-08-29 18:02:43', '2019-08-29 18:02:43'),
(15, '2.3', 'fdfdddf', '80', '20', '22', 33, 2, '2019-08-29 18:04:20', '2019-08-29 18:04:20'),
(16, '2.4', 'sfdsfdfdfd', '80', '20', '22', 33, 1, '2019-08-29 18:04:46', '2019-08-29 18:04:46'),
(17, '2.5', 'dfdfdsgfgf gfg', '80', '20', '22', 1, 1, '2019-08-29 18:29:29', '2019-08-29 18:29:29'),
(18, '2.8', 'dfdfdf', '80', '20', '22', 1, 1, '2019-08-29 19:59:29', '2019-08-29 19:59:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lote`
--

CREATE TABLE `lote` (
  `lot_id` int(11) NOT NULL,
  `lot_nome` varchar(255) DEFAULT NULL,
  `pro_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `lote`
--

INSERT INTO `lote` (`lot_id`, `lot_nome`, `pro_id`, `created_at`, `updated_at`) VALUES
(1, 'Lote 7', 1, NULL, '2019-08-29 03:54:08'),
(2, 'Lote 1', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE `menu` (
  `men_id` int(11) NOT NULL,
  `men_nome` varchar(255) NOT NULL,
  `men_icone` varchar(255) NOT NULL,
  `men_rota` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`men_id`, `men_nome`, `men_icone`, `men_rota`, `created_at`, `updated_at`) VALUES
(1, 'Projetos', 'fas fa-fw fa-table', NULL, NULL, NULL),
(2, 'Lotes', 'fas fa-fw fa-table', NULL, NULL, NULL),
(3, 'Atividades', 'fas fa-fw fa-table', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu_tipo_usuario`
--

CREATE TABLE `menu_tipo_usuario` (
  `men_tip_usu_id` int(11) NOT NULL,
  `men_id` int(11) NOT NULL,
  `tip_usu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `menu_tipo_usuario`
--

INSERT INTO `menu_tipo_usuario` (`men_tip_usu_id`, `men_id`, `tip_usu_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 1, 2),
(4, 2, 1),
(5, 2, 3),
(6, 2, 2),
(7, 3, 1),
(8, 3, 2),
(9, 3, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('anderson.alvesprogrammer@gmail.com', '$2y$10$0QZgv/Pch8iOw0PGnRtPpORs3pYZ4Mk5psRo55wwH/pe90hXAYCdm', '2019-08-28 05:05:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `pro_id` int(11) NOT NULL,
  `pro_nome` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`pro_id`, `pro_nome`, `created_at`, `updated_at`) VALUES
(1, 'Braço de Prata Vilas boas 7', NULL, '2019-08-29 19:58:43'),
(2, 'Graça Residences', NULL, NULL),
(3, 'Vila Montrose', NULL, NULL),
(4, 'Manuel Machado', NULL, NULL),
(5, 'Aveiro Vilage', NULL, NULL),
(6, 'Beja Vilage', NULL, NULL),
(7, 'Braga Vilage', NULL, NULL),
(8, 'Bragança Vilage', NULL, NULL),
(9, 'Castelo Branco Vilage', NULL, NULL),
(10, 'Coimbra Vilage', NULL, NULL),
(11, 'Évora Vilage', NULL, NULL),
(12, 'Faro Vilage', NULL, NULL),
(13, 'Guarda Vilage', NULL, NULL),
(14, 'Leiria Vilage', NULL, NULL),
(15, 'Lisboa Vilage', NULL, NULL),
(16, 'Portalegre Vilage', NULL, NULL),
(17, 'Porto Vilage', NULL, NULL),
(18, 'Santarém Vilage', NULL, NULL),
(19, 'Setúbal Vilage', NULL, NULL),
(20, 'Viana do Castelo Vilage', NULL, NULL),
(21, ' Vila Real Vilage', NULL, NULL),
(24, 'Angola', NULL, NULL),
(26, 'Matinha', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_menu`
--

CREATE TABLE `sub_menu` (
  `sub_men_id` int(11) NOT NULL,
  `sub_men_nome` varchar(255) NOT NULL,
  `sub_men_rota` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sub_menu`
--

INSERT INTO `sub_menu` (`sub_men_id`, `sub_men_nome`, `sub_men_rota`) VALUES
(1, 'Editar Projetos', 'editarProjetos'),
(2, 'Cadastrar Projetos', 'cadastrarProjetos'),
(3, 'Visualizar Projetos', 'visualizarProjetos'),
(4, 'Editar Lotes', 'editarLotes'),
(5, 'Cadastrar Lotes', 'cadastrarLotes'),
(6, 'Visualizar Lotes', 'visualizarLotes'),
(7, 'Editar Atividades', 'editarAtividades'),
(8, 'Cadastrar Atividades', 'cadastrarAtividades'),
(9, 'Visualizar Atividades', 'visualizarAtividades');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_menu_tipo_usuario`
--

CREATE TABLE `sub_menu_tipo_usuario` (
  `sub_men_tip_usu_id` int(11) NOT NULL,
  `sub_men_id` int(11) NOT NULL,
  `men_id` int(11) NOT NULL,
  `tip_usu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sub_menu_tipo_usuario`
--

INSERT INTO `sub_menu_tipo_usuario` (`sub_men_tip_usu_id`, `sub_men_id`, `men_id`, `tip_usu_id`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 3, 1, 3),
(5, 1, 1, 2),
(6, 3, 1, 2),
(7, 4, 2, 1),
(8, 4, 2, 2),
(9, 5, 2, 1),
(10, 6, 2, 1),
(11, 6, 2, 2),
(12, 6, 2, 3),
(13, 7, 3, 1),
(14, 7, 3, 2),
(15, 8, 3, 1),
(16, 9, 3, 1),
(17, 9, 3, 2),
(18, 9, 3, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `tip_usu_id` int(11) NOT NULL,
  `tip_usu_nome` varchar(255) NOT NULL,
  `tip_usu_attr` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`tip_usu_id`, `tip_usu_nome`, `tip_usu_attr`) VALUES
(1, 'Super Admin', 'superAdmin'),
(2, 'Admin', 'admin'),
(3, 'Usuário', 'user');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade`
--

CREATE TABLE `unidade` (
  `uni_id` int(11) NOT NULL,
  `uni_nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `unidade`
--

INSERT INTO `unidade` (`uni_id`, `uni_nome`) VALUES
(1, 'vg'),
(2, 'm²');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usu_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tip_usu_id` int(11) DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usu_id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `tip_usu_id`) VALUES
(3, 'Anderson Alves', 'anderson.alvesprogrammer@gmail.com', '$2y$10$xm9ckKgmBwZDpxHW.Pp5qOd/61.O3i/YqgVewzV9os9E.hQlRqgZ2', 'aZxx0HPCIQnbKmPGCgjWir3LkWoj5SFRoDue6fANQsulsCYGIUe4EeEcg4ia', '2019-08-28 05:05:06', '2019-08-28 05:05:06', 1),
(4, 'Admin', 'admin@gmail.com', '$2y$10$87JPghrSFVvLO6XEBnbdNu8GOYGpoXApjYhIg.qup4CmjZYhTYrd6', 'y6SAmZwkw09avJg6FPAnnWlr3H2ODg314azDY79Z693fMhu1PadyeLsLpOZ7', '2019-08-28 16:44:52', '2019-08-28 16:44:52', 2),
(5, 'Usuário', 'user@gmail.com', '$2y$10$6ND07uDQXM.FECWHCb8qcumMC.SAcY9c9/cEgQkqVvLuQriZh9LrG', 'gRQejJiBirrC4OLjVyh3ulyN7gqKpYoFRAZq2pi06igaCIjDUaaCp2Cgq2kZ', '2019-08-28 19:53:34', '2019-08-28 19:53:34', 3),
(6, 'Alfredo', 'alfredo@gmail.com', '$2y$10$sVizltXfXi213eMF29aCYO8yuw7fD0gbF0skRcPeinfwvpJRzdQPu', 'bX89sCsczoFPg685mZkb2juwHnPAuPZLTlhG8pRCGYnTasE4TiPBXjUf0Mva', '2019-08-29 04:14:44', '2019-08-29 04:14:44', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `uti_id` int(11) NOT NULL,
  `uti_nome` varchar(255) DEFAULT NULL,
  `uti_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atividade1`
--
ALTER TABLE `atividade1`
  ADD PRIMARY KEY (`ati1_id`),
  ADD KEY `fk_atividade_lote1_idx` (`lot_id`);

--
-- Índices para tabela `atividade2`
--
ALTER TABLE `atividade2`
  ADD PRIMARY KEY (`ati2_id`),
  ADD KEY `fk_atividade2_atividade11_idx` (`ati1_id`),
  ADD KEY `fk_atividade2_unidade1_idx` (`uni_id`);

--
-- Índices para tabela `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`lot_id`),
  ADD KEY `fk_lote_projeto1_idx` (`pro_id`);

--
-- Índices para tabela `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`men_id`);

--
-- Índices para tabela `menu_tipo_usuario`
--
ALTER TABLE `menu_tipo_usuario`
  ADD PRIMARY KEY (`men_tip_usu_id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Índices para tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`pro_id`);

--
-- Índices para tabela `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`sub_men_id`);

--
-- Índices para tabela `sub_menu_tipo_usuario`
--
ALTER TABLE `sub_menu_tipo_usuario`
  ADD PRIMARY KEY (`sub_men_tip_usu_id`);

--
-- Índices para tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`tip_usu_id`);

--
-- Índices para tabela `unidade`
--
ALTER TABLE `unidade`
  ADD PRIMARY KEY (`uni_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `tipo_usuario_fk_idx` (`tip_usu_id`);

--
-- Índices para tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`uti_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atividade1`
--
ALTER TABLE `atividade1`
  MODIFY `ati1_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `atividade2`
--
ALTER TABLE `atividade2`
  MODIFY `ati2_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `lote`
--
ALTER TABLE `lote`
  MODIFY `lot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
  MODIFY `men_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `menu_tipo_usuario`
--
ALTER TABLE `menu_tipo_usuario`
  MODIFY `men_tip_usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `sub_men_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `sub_menu_tipo_usuario`
--
ALTER TABLE `sub_menu_tipo_usuario`
  MODIFY `sub_men_tip_usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `tip_usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `unidade`
--
ALTER TABLE `unidade`
  MODIFY `uni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `uti_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atividade1`
--
ALTER TABLE `atividade1`
  ADD CONSTRAINT `fk_atividade_lote1` FOREIGN KEY (`lot_id`) REFERENCES `lote` (`lot_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `atividade2`
--
ALTER TABLE `atividade2`
  ADD CONSTRAINT `fk_atividade2_atividade11` FOREIGN KEY (`ati1_id`) REFERENCES `atividade1` (`ati1_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_atividade2_unidade1` FOREIGN KEY (`uni_id`) REFERENCES `unidade` (`uni_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `fk_lote_projeto1` FOREIGN KEY (`pro_id`) REFERENCES `projeto` (`pro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `tipo_usuario_fk` FOREIGN KEY (`tip_usu_id`) REFERENCES `tipo_usuario` (`tip_usu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
