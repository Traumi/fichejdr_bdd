-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 29 mars 2019 à 17:14
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `fiches`
--

CREATE TABLE `fiches` (
  `id` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `id_creator` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fiches`
--

INSERT INTO `fiches` (`id`, `url`, `id_creator`) VALUES
(1, 'pahr_silver.json', 'Traumination'),
(2, 'snow_.json', 'Traumination'),
(5, 'maggie_lunar.json', 'null'),
(6, 'krone_dirikson.json', 'null'),
(7, 'redmes_.json', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `login` varchar(30) NOT NULL,
  `pw` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `last_token` date DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`login`, `pw`, `admin`, `last_token`, `token`) VALUES
('azerty', '$2y$12$xdVGnrF6jlhXdhvSvz.pi.6Y6uR/pBOoW5uFr5b/ErTMcrZsk4UkK', 0, '2019-04-01', 'bf8f4b776826d4bc48d0ce7ddbaa2012'),
('test', '$2y$12$wLQPaAF.wdILw7v9vsFNGeQN1pBHfuwarwBKkETF9gYTejHrrOb/G', 0, '2019-04-03', '147dd3a39da51107518c2a9997b044b6'),
('Traumination', '$2y$12$Ja.tfejGnOaC/MEk23bJ5exs2eU4ffyGf/1xtyUyvbVebeKVq7p3G', 1, '2019-04-03', 'dd382fac8bf72b57c6048db2037f3d48');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `fiches`
--
ALTER TABLE `fiches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `fiches`
--
ALTER TABLE `fiches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
