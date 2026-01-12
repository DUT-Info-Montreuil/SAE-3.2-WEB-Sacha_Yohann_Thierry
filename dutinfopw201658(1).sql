-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+focal2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 12 jan. 2026 à 17:31
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
-- Structure de la table `A_role`
--

CREATE TABLE `A_role` (
  `id_buvette` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Buvette`
--

CREATE TABLE `Buvette` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

CREATE TABLE `Commande` (
  `id` int NOT NULL,
  `contenu` varchar(255) DEFAULT NULL,
  `prix_cmd` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Commander`
--

CREATE TABLE `Commander` (
  `id_commande` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `CommanderPlat`
--

CREATE TABLE `CommanderPlat` (
  `id_commande_plat` int NOT NULL,
  `id_plat` int NOT NULL,
  `quantite` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Compte`
--

CREATE TABLE `Compte` (
  `id` int NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `solde` decimal(10,2) DEFAULT NULL,
  `id_utilisateur` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Compte`
--

INSERT INTO `Compte` (`id`, `login`, `mot_de_passe`, `solde`, `id_utilisateur`) VALUES
(1, 'ff', '$2y$10$DgJ3ElbWZG91Pef9rLsoBeHTwl27ZvgBvknCrtlCBoAOUL4/RRYqi', 0.00, 1),
(2, 'hartwell', '$2y$10$LmAy8t2629mQHbW7W7XMc.B1hh/Bx6hFwvULVjCaru5Lf/SnyIlya', 0.00, 2),
(4, 'roaaaaaer', '$2y$10$eQ/N7oJOeQhEQ/cFz7NiNeuvu7ADxTmT/JYTZq/OMEnejwYJbkWuS', 0.00, 4),
(5, 'spopravkoboinot', '$2y$10$r8nsKZEvVIeGl0cswD3B2uEFTGzCEtKfcYPITun/90jVvHWwbTKEG', 0.00, 5),
(6, 'hh', '$2y$10$jmTidEZ1VZGUG3GxVSgBSebvDsohJhG/oIqBzRrUQPbVn9SpFpe4C', 0.00, 6),
(7, 'hh', '$2y$10$E20FCsG9OEGtjkFOzplgIeS6Eu9.WurOn1UMtzkIQtRCkssjTbLVC', 0.00, 7),
(8, 'hh', '$2y$10$zrPfQN0ZaslfkhRdzZSJSeemSzvxGn0MtAvXLcEx1OSXv/Yjj7XtG', 0.00, 8),
(9, 'hh', '$2y$10$o4w1oGsz1Okbn1a7NxcviuW3igJdZAHYtTt8dXqRfSNK.wArfzip.', 0.00, 9),
(10, 'hh', '$2y$10$LPYjt7ozx96OEiT9ThaVs.yvxCIh5NoMhM35J1MG7mboy2nwF1ZYi', 0.00, 10),
(11, 'hh', '$2y$10$Z9h4/acdwrWbf8Ovbc8Kx.zAA/PC1TSGjH20IRYfN/RCLW32DpVsW', 0.00, 11),
(12, 'gg', '$2y$10$Tw3qIoB3m7zAyNcGnsLIJO.I4Om0BsQVWsQwbvYidBzeDtVj.L6.C', 0.00, 12),
(13, 'gg', '$2y$10$QxzAC.E2gxtEHV1a3Sfqd.ZbrCz/URs1/XnGUrrr8eWe6qRyl5c76', 0.00, 13),
(14, 'gg', '$2y$10$d/kLmPPTgyCjINikudYSOeshmIPShN9W0fYA2cCME3aomBYQSc4QC', 0.00, 14),
(15, 'gg', '$2y$10$tmLdT54q4AlI4gHogO2kjO8svHboMDlqlhdpCHwIB4wDv1nuaA9eW', 0.00, 15),
(16, 'gg', '$2y$10$Cg1kl9eBYpmv0qoLmKNq7.EztoI/9VlMJu2.LG6tqsY9e0gjAhAvO', 0.00, 16),
(17, 'gg', '$2y$10$vkKn1zEH9hGz2Tz26aX7lOcn3eM4Sy7ZMpzfqO9rjy8uTNQpGksqC', 0.00, 17),
(18, 'gg', '$2y$10$LXc2RVLO/kzzYlUc5VUedu2DGX0ukaM8X2lsmuWihVxVae1AbnnQq', 0.00, 18),
(19, 'gg', '$2y$10$S7Kot9HO4PPCQEw1qdo7LeztsVTfiIN1bO/6yzoiD0eZOei8XrmZe', 0.00, 19),
(20, 'kk', '$2y$10$9sT2ELkI7lNEunm4B5eFAOBkxPne23n758p.w5lBODwZiMkFrDgJS', 0.00, 20),
(21, 'll', '$2y$10$i1bOU87i9bJQNjfmPN1.8OhjlZjtizj8e57yV2THY/DP53NGbGIs2', 0.00, 21),
(22, 'll', '$2y$10$eW74I7in49MKLH0nWiShCeZapqbPPFRDTwVPQ9nG6/DOEYCa8sKQa', 0.00, 22),
(23, 'll', '$2y$10$PW80F93UwMCiGDvkrlrCWOJN8vOHhTMN3/U/ZZXlQtmOnwy7mEHYG', 0.00, 23),
(24, 'mm', '$2y$10$pHoxLfpG8VDNN3PE4YiS/OgSVlhL6FtFhsX4oxyxaY8m7AzmVaSOC', 0.00, 24);

-- --------------------------------------------------------

--
-- Structure de la table `Contient`
--

CREATE TABLE `Contient` (
  `id_produit` int NOT NULL,
  `id_plat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Fourni`
--

CREATE TABLE `Fourni` (
  `id_inventaire` int NOT NULL,
  `id_fournisseurProduit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `FournisseurProduit`
--

CREATE TABLE `FournisseurProduit` (
  `id` int NOT NULL,
  `nom_fourniseur` varchar(255) NOT NULL,
  `numero` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Inventaire`
--

CREATE TABLE `Inventaire` (
  `id` int NOT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `id_buvette` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `PasserCommande`
--

CREATE TABLE `PasserCommande` (
  `id_compte` int NOT NULL,
  `id_commande` int NOT NULL,
  `date_commande` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Plat`
--

CREATE TABLE `Plat` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prix` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Produit`
--

CREATE TABLE `Produit` (
  `id` int NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Remplir`
--

CREATE TABLE `Remplir` (
  `id_fournisseurProduit` int NOT NULL,
  `id_produit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Stock`
--

CREATE TABLE `Stock` (
  `id_inventaire` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `adresse_mail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `nom`, `prenom`, `adresse_mail`) VALUES
(1, 'ff', 'ff', 'ff'),
(2, 'skibidiii', 'yoyo', 'skibidi.com'),
(4, 'roaaaaaer', 'roaaaaaer', 'roaaaaaer'),
(5, 'popravko--boinot', 'sasha', 'spop@gmail.com'),
(6, 'hh', 'hh', 'hh'),
(7, 'hh', 'hh', 'hh'),
(8, 'hh', 'hh', 'hh'),
(9, 'hh', 'hh', 'hh'),
(10, 'hh', 'hh', 'hh'),
(11, 'hh', 'hh', 'hh'),
(12, 'gg', 'gg', 'gg'),
(13, 'gg', 'gg', 'gg'),
(14, 'gg', 'gg', 'gg'),
(15, 'gg', 'gg', 'gg'),
(16, 'gg', 'gg', 'gg'),
(17, 'gg', 'gg', 'gg'),
(18, 'gg', 'gg', 'gg'),
(19, 'gg', 'gg', 'gg'),
(20, 'kk', 'kk', 'kk'),
(21, 'll', 'll', 'll'),
(22, 'll', 'll', 'll'),
(23, 'll', 'll', 'll'),
(24, 'mm', 'mm', 'mm');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `A_role`
--
ALTER TABLE `A_role`
  ADD PRIMARY KEY (`id_buvette`,`id_utilisateur`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `Buvette`
--
ALTER TABLE `Buvette`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Commander`
--
ALTER TABLE `Commander`
  ADD PRIMARY KEY (`id_commande`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `CommanderPlat`
--
ALTER TABLE `CommanderPlat`
  ADD PRIMARY KEY (`id_commande_plat`,`id_plat`),
  ADD KEY `id_plat` (`id_plat`);

--
-- Index pour la table `Compte`
--
ALTER TABLE `Compte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `Contient`
--
ALTER TABLE `Contient`
  ADD PRIMARY KEY (`id_produit`,`id_plat`),
  ADD KEY `id_plat` (`id_plat`);

--
-- Index pour la table `Fourni`
--
ALTER TABLE `Fourni`
  ADD PRIMARY KEY (`id_inventaire`,`id_fournisseurProduit`),
  ADD KEY `id_fournisseurProduit` (`id_fournisseurProduit`);

--
-- Index pour la table `FournisseurProduit`
--
ALTER TABLE `FournisseurProduit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Inventaire`
--
ALTER TABLE `Inventaire`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_buvette` (`id_buvette`);

--
-- Index pour la table `PasserCommande`
--
ALTER TABLE `PasserCommande`
  ADD PRIMARY KEY (`id_compte`,`id_commande`),
  ADD KEY `id_commande` (`id_commande`);

--
-- Index pour la table `Plat`
--
ALTER TABLE `Plat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Produit`
--
ALTER TABLE `Produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Remplir`
--
ALTER TABLE `Remplir`
  ADD PRIMARY KEY (`id_fournisseurProduit`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `Stock`
--
ALTER TABLE `Stock`
  ADD PRIMARY KEY (`id_inventaire`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Buvette`
--
ALTER TABLE `Buvette`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Compte`
--
ALTER TABLE `Compte`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `FournisseurProduit`
--
ALTER TABLE `FournisseurProduit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Inventaire`
--
ALTER TABLE `Inventaire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Plat`
--
ALTER TABLE `Plat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Produit`
--
ALTER TABLE `Produit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `A_role`
--
ALTER TABLE `A_role`
  ADD CONSTRAINT `A_role_ibfk_1` FOREIGN KEY (`id_buvette`) REFERENCES `Buvette` (`id`),
  ADD CONSTRAINT `A_role_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id`);

--
-- Contraintes pour la table `Commander`
--
ALTER TABLE `Commander`
  ADD CONSTRAINT `Commander_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `Commande` (`id`),
  ADD CONSTRAINT `Commander_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id`);

--
-- Contraintes pour la table `CommanderPlat`
--
ALTER TABLE `CommanderPlat`
  ADD CONSTRAINT `CommanderPlat_ibfk_1` FOREIGN KEY (`id_commande_plat`) REFERENCES `Commande` (`id`),
  ADD CONSTRAINT `CommanderPlat_ibfk_2` FOREIGN KEY (`id_plat`) REFERENCES `Plat` (`id`);

--
-- Contraintes pour la table `Compte`
--
ALTER TABLE `Compte`
  ADD CONSTRAINT `Compte_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id`);

--
-- Contraintes pour la table `Contient`
--
ALTER TABLE `Contient`
  ADD CONSTRAINT `Contient_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id`),
  ADD CONSTRAINT `Contient_ibfk_2` FOREIGN KEY (`id_plat`) REFERENCES `Plat` (`id`);

--
-- Contraintes pour la table `Fourni`
--
ALTER TABLE `Fourni`
  ADD CONSTRAINT `Fourni_ibfk_1` FOREIGN KEY (`id_inventaire`) REFERENCES `Inventaire` (`id`),
  ADD CONSTRAINT `Fourni_ibfk_2` FOREIGN KEY (`id_fournisseurProduit`) REFERENCES `FournisseurProduit` (`id`);

--
-- Contraintes pour la table `Inventaire`
--
ALTER TABLE `Inventaire`
  ADD CONSTRAINT `Inventaire_ibfk_1` FOREIGN KEY (`id_buvette`) REFERENCES `Buvette` (`id`);

--
-- Contraintes pour la table `PasserCommande`
--
ALTER TABLE `PasserCommande`
  ADD CONSTRAINT `PasserCommande_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `Compte` (`id`),
  ADD CONSTRAINT `PasserCommande_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `Commande` (`id`);

--
-- Contraintes pour la table `Remplir`
--
ALTER TABLE `Remplir`
  ADD CONSTRAINT `Remplir_ibfk_1` FOREIGN KEY (`id_fournisseurProduit`) REFERENCES `FournisseurProduit` (`id`),
  ADD CONSTRAINT `Remplir_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id`);

--
-- Contraintes pour la table `Stock`
--
ALTER TABLE `Stock`
  ADD CONSTRAINT `Stock_ibfk_1` FOREIGN KEY (`id_inventaire`) REFERENCES `Inventaire` (`id`),
  ADD CONSTRAINT `Stock_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `Produit` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
