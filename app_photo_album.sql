-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 28 juin 2026 à 20:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app_photo_album`
--

-- --------------------------------------------------------

--
-- Structure de la table `albums`
--

CREATE TABLE `albums` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `visibility` enum('private','public','restricted') DEFAULT 'private',
  `created_at` datetime DEFAULT current_timestamp(),
  `share_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `albums`
--

INSERT INTO `albums` (`id`, `user_id`, `title`, `description`, `visibility`, `created_at`, `share_token`) VALUES
(1, 1, 'Photo Soka', 'Toute les photos de soka hihi', 'public', '2026-06-18 11:54:26', '4f5f62a64e6ae9ac19335d35d21c756c');

-- --------------------------------------------------------

--
-- Structure de la table `album_access`
--

CREATE TABLE `album_access` (
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission` enum('view','edit') DEFAULT 'view'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `album_access`
--

INSERT INTO `album_access` (`album_id`, `user_id`, `permission`) VALUES
(1, 2, 'view');

-- --------------------------------------------------------

--
-- Structure de la table `album_tags`
--

CREATE TABLE `album_tags` (
  `album_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `album_tags`
--

INSERT INTO `album_tags` (`album_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `photo_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `photo_id`, `user_id`, `content`, `created_at`) VALUES
(3, 5, 2, 'Trop mimi', '2026-06-28 19:34:40'),
(4, 4, 1, 'trop moche le chien', '2026-06-28 19:43:49'),
(5, 2, 1, 'trop bien', '2026-06-28 20:05:26'),
(6, 3, 1, 'Trop mimi', '2026-06-28 20:08:00');

-- --------------------------------------------------------

--
-- Structure de la table `favorite_photos`
--

CREATE TABLE `favorite_photos` (
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `favorite_photos`
--

INSERT INTO `favorite_photos` (`user_id`, `photo_id`) VALUES
(1, 2),
(1, 3),
(1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id` int(10) UNSIGNED NOT NULL,
  `album_id` int(10) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `taken_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `capture_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id`, `album_id`, `description`, `file_path`, `taken_at`, `created_at`, `capture_date`, `location`) VALUES
(2, 1, 'Kawaii', '/uploads/img_6a3e77a39ed9d0.58955240.jpeg', NULL, '2026-06-26 14:59:15', NULL, NULL),
(3, 1, '', '/uploads/img_6a3e77b553d529.44114333.jpeg', NULL, '2026-06-26 14:59:33', NULL, NULL),
(4, 1, '', '/uploads/img_6a3e77c90697e0.54942048.jpeg', NULL, '2026-06-26 14:59:53', NULL, NULL),
(5, 1, 'Gros chien sur le dos', '/uploads/img_6a3e77d6e06093.41258728.jpeg', NULL, '2026-06-26 15:00:06', '2026-06-01', 'dans mon lit avec romain');

-- --------------------------------------------------------

--
-- Structure de la table `photo_tags`
--

CREATE TABLE `photo_tags` (
  `photo_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(2, 'chien'),
(3, 'quotidien'),
(4, 'test'),
(1, 'vacances');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `profile_pic`, `created_at`, `bio`, `profile_picture`) VALUES
(1, 'Mathys', 'azerty@gmail.com', '$2y$10$fiHOc/4hNoQ5dTLIgM0tB.4cqQke/xcNwUm9JsGRK/b24G.j9QLJe', NULL, '2026-06-18 11:53:09', 'Oui c\'est moi Mathys', '/uploads/profiles/profile_1_1782672015.png'),
(2, 'Romain', 'qwerty@gmail.com', '$2y$10$.6FEk6DpWocn.uXjxgLezeL1/7DpboAqEkJab7YDjGGEpY2pyw7kW', NULL, '2026-06-28 19:31:02', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `share_token` (`share_token`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `album_access`
--
ALTER TABLE `album_access`
  ADD PRIMARY KEY (`album_id`,`user_id`);

--
-- Index pour la table `album_tags`
--
ALTER TABLE `album_tags`
  ADD PRIMARY KEY (`album_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `favorite_photos`
--
ALTER TABLE `favorite_photos`
  ADD PRIMARY KEY (`user_id`,`photo_id`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- Index pour la table `photo_tags`
--
ALTER TABLE `photo_tags`
  ADD PRIMARY KEY (`photo_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `album_tags`
--
ALTER TABLE `album_tags`
  ADD CONSTRAINT `album_tags_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `album_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `photo_tags`
--
ALTER TABLE `photo_tags`
  ADD CONSTRAINT `photo_tags_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `photo_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
