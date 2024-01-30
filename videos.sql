-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 30 jan. 2024 à 00:32
-- Version du serveur : 8.0.31
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `videos`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int NOT NULL,
  `note` decimal(10,1) NOT NULL,
  `commentaires` text COLLATE utf8mb4_general_ci NOT NULL,
  `videos_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `note`, `commentaires`, `videos_id`) VALUES
(1, 8.0, 'Ça fait rêver!', 1),
(4, 8.8, 'J\'aimerais bien vivre sur une île!', 4),
(5, 8.4, 'C\'est le chemin de fer le plus long du monde!', 5),
(6, 9.3, 'Ils n\'ont jamais réussi à trouver à qui était l\'empreinte.', 6),
(7, 7.8, 'Une comédie à écouter si vous aimez la ville de New York !', 7),
(8, 9.0, 'J\'aimerais faire le tour du monde comme voyage de rêve!', 1),
(9, 8.5, 'Ça donne envie de partir en voyage!', 1),
(10, 9.5, 'La vidéo était vraiment magnifique!', 1);

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE `videos` (
  `id` int NOT NULL,
  `img_url` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `categories` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `auteur_nom` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auteur_description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auteur_verifie` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `datePublication` date NOT NULL,
  `duree` int NOT NULL,
  `nombreVues` int NOT NULL,
  `score` int NOT NULL,
  `sousTitres` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `videos`
--

INSERT INTO `videos` (`id`, `img_url`, `nom`, `description`, `categories`, `auteur_nom`, `auteur_description`, `auteur_verifie`, `datePublication`, `duree`, `nombreVues`, `score`, `sousTitres`) VALUES
(1, 'https://picsum.photos/id/49/400/250', 'Un voyage de rêve', 'Description de la vidéo 1', 'Voyage', 'Julia Pearson', 'Description de Julia Pearson', '0', '2021-05-15', 2436, 5000, 2385, 'ss'),
(4, 'https://picsum.photos/id/124/400/250', 'Perdue sur une île', 'Description de la vidéo 4', 'Drame', 'Rachel Owen', 'Description de Rachel Owen', 'true', '2022-01-16', 1489, 243, 6400, 'ss'),
(5, 'https://picsum.photos/id/155/400/250', 'Le chemin de fer', 'Description de la vidéo 5', 'Action', 'Lily Clark', 'Description de Lily Clark', 'true', '2022-02-21', 1376, 326, 3610, 'ss'),
(6, 'https://picsum.photos/id/156/400/250', 'Une empreinte inconnue', 'Description de la vidéo 6', 'Drame', 'Emily Parker', 'Description de Emily Parker', 'true', '2022-03-11', 1128, 259, 5542, 'ss'),
(7, 'https://picsum.photos/id/274/400/250', 'Bienvenue à New York', 'Description de la vidéo 7', 'Humour', 'Olivia Anderson', 'Description de Olivia Anderson', 'true', '2022-06-05', 2157, 192, 2470, 'ss'),
(8, 'https://picsum.photos/id/318/400/250', 'Bonjour Paris', 'Description de la vidéo 8', 'Voyage', 'Sophia Mitchell', 'Description de Sophia Mitchell', 'true', '2022-07-05', 1368, 290, 6250, 'ss'),
(9, 'https://picsum.photos/id/336/400/250', 'Les serrures de l\'amour', 'Description de la vidéo 9', 'Romantique', 'Isabella Morgan', 'Description de Isabella Morgan', 'true', '2023-03-23', 1735, 318, 4500, 'ss'),
(16, 'https://picsum.photos/id/191/400/250', 'La route sinueuse', 'Description de la vidéo 16', 'Action', 'Olivia Collins', 'Description de Olivia Collins', '1', '2021-05-15', 2436, 300, 5932, 'ss');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `avis_videos` (`videos_id`);

--
-- Index pour la table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_videos` FOREIGN KEY (`videos_id`) REFERENCES `videos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
