-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+focal2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 19 déc. 2025 à 14:57
-- Version du serveur : 8.0.42-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3-4ubuntu2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dutinfopw201658`
--

-- --------------------------------------------------------

--
-- Structure de la table `Buvette`
--

CREATE TABLE `Buvette` (
  `id` bigint UNSIGNED NOT NULL,
  `Nom` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ListeJoueur`
--

CREATE TABLE `ListeJoueur` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `biographie` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ListeJoueur`
--

INSERT INTO `ListeJoueur` (`id`, `nom`, `biographie`) VALUES
(1, 'mick', 'un mec chill'),
(2, 'jsp', 'un mec chill qui aime les pizzas'),
(3, 'Thai-nam', 'est fort a clash royal'),
(5, 'test', 'ceci est un test'),
(7, 'babaaklnafjezqhbfuje', 'je suis un mec tout a fait banal qui aime les burgers'),
(8, 'yohann', 'aime elden ring');

-- --------------------------------------------------------

--
-- Structure de la table `TableEquipes`
--

CREATE TABLE `TableEquipes` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `anne_creation` date NOT NULL,
  `description` text NOT NULL,
  `pays` varchar(50) NOT NULL,
  `logo` varchar(300) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `TableEquipes`
--

INSERT INTO `TableEquipes` (`id`, `nom`, `anne_creation`, `description`, `pays`, `logo`) VALUES
(1, 'OM', '2000-01-01', 'MEILLEUR EQUIPE DE FRANCE', 'FRANCE', 'logos/OM.png\r\n'),
(2, 'PSG', '2001-01-01', 'equipe de foot francaise', 'FRANCE', 'logos/Paris.png'),
(5, 'defrtgth', '2025-11-03', 'ghj;kl:!m', 'Italie', 'logos/italie.png');

-- --------------------------------------------------------

--
-- Structure de la table `tableTests`
--

CREATE TABLE `tableTests` (
  `ID` bigint UNSIGNED NOT NULL,
  `texte` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tableTests`
--

INSERT INTO `tableTests` (`ID`, `texte`) VALUES
(1, 'simao'),
(2, 'CACA PIPI'),
(3, 'ta mère'),
(7, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');

-- --------------------------------------------------------

--
-- Structure de la table `TableUtilisateur`
--

CREATE TABLE `TableUtilisateur` (
  `id` bigint UNSIGNED NOT NULL,
  `login` varchar(50) NOT NULL,
  `mdp` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `TableUtilisateur`
--

INSERT INTO `TableUtilisateur` (`id`, `login`, `mdp`) VALUES
(1, 'aaa', '$2y$10$8XCTwTtp6yRbJNWuIB72yuphZvsR/vAbWG0PSy8cucykGFlAImnTK');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `idUtilisateur` bigint UNSIGNED NOT NULL,
  `nom_utilisateur` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`idUtilisateur`, `nom_utilisateur`, `mdp`) VALUES
(7, 'a', 'a'),
(8, 'salut', 'salut'),
(9, 'zebi', 'zebi'),
(10, 'zebi', 'zebi'),
(11, 'sasha', 'sasha'),
(12, 'dd', 'dd'),
(13, 'ff', 'ff'),
(14, 'vv', 'vv'),
(15, 'gg', 'gg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Buvette`
--
ALTER TABLE `Buvette`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `ListeJoueur`
--
ALTER TABLE `ListeJoueur`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `TableEquipes`
--
ALTER TABLE `TableEquipes`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `tableTests`
--
ALTER TABLE `tableTests`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Index pour la table `TableUtilisateur`
--
ALTER TABLE `TableUtilisateur`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Buvette`
--
ALTER TABLE `Buvette`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ListeJoueur`
--
ALTER TABLE `ListeJoueur`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `TableEquipes`
--
ALTER TABLE `TableEquipes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `tableTests`
--
ALTER TABLE `tableTests`
  MODIFY `ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `TableUtilisateur`
--
ALTER TABLE `TableUtilisateur`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `idUtilisateur` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
