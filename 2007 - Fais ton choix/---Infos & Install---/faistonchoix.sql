-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Lundi 02 Avril 2007 à 07:08
-- Version du serveur: 3.23.58
-- Version de PHP: 4.3.10
-- 
-- Base de données: `ftc`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_admin`
-- 

CREATE TABLE `iuf_admin` (
  `id` int(5) NOT NULL auto_increment,
  `pseudo` varchar(255) NOT NULL default '',
  `pass` varchar(255) NOT NULL default '',
  `groupe` int(2) NOT NULL default '0',
  `nb_actions` int(10) NOT NULL default '0',
  `nb_duels` int(10) NOT NULL default '0',
  `nb_photos` int(10) NOT NULL default '0',
  `nb_connexion` int(10) NOT NULL default '0',
  `last_ip` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Contenu de la table `iuf_admin`
-- 

INSERT INTO `iuf_admin` VALUES (4, 'admin', 'yoI6fDJLKO1RQ', 5, 0, 0, 0, 1, '127.0.0.1');

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_blocnote`
-- 

CREATE TABLE `iuf_blocnote` (
  `nom` varchar(255) NOT NULL default '',
  `blocnote` longtext NOT NULL
) TYPE=MyISAM;

-- 
-- Contenu de la table `iuf_blocnote`
-- 

INSERT INTO `iuf_blocnote` VALUES ('admin', 'Bloc note de la team ');

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_duels`
-- 

CREATE TABLE `iuf_duels` (
  `id` int(13) NOT NULL auto_increment,
  `nom1` varchar(100) NOT NULL default '',
  `nom2` varchar(100) NOT NULL default '',
  `img1` varchar(255) NOT NULL default '',
  `img2` varchar(255) NOT NULL default '',
  `note1` int(10) NOT NULL default '1',
  `note2` int(10) NOT NULL default '1',
  `votestotal` int(15) NOT NULL default '2',
  `date` varchar(5) NOT NULL default '',
  `timestamp` varchar(40) NOT NULL default '',
  `admin` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=52 ;

-- 
-- Contenu de la table `iuf_duels`
-- 

INSERT INTO `iuf_duels` VALUES (16, 'Titi', 'Grosminet', 'titi.jpg', 'grosminet.jpg', 26, 21, 47, '04.03', '1173004677', 'kevin');
INSERT INTO `iuf_duels` VALUES (15, 'Amour', 'Sexe', 'amour.jpg', 'sexe.jpg', 24, 44, 68, '04.03', '1173004644', 'kevin');
INSERT INTO `iuf_duels` VALUES (6, 'Durex', 'Manix', 'durex.png', 'manix.png', 22, 23, 45, '03.03', '1172944457', 'julien');
INSERT INTO `iuf_duels` VALUES (7, 'Hawaii', 'Tahiti', 'hawaii.png', 'tahiti.png', 9, 30, 39, '03.03', '1172948065', 'julien');
INSERT INTO `iuf_duels` VALUES (8, 'PSG', 'OM', 'psg.png', 'om.png', 19, 27, 46, '03.03', '1172949353', 'julien');
INSERT INTO `iuf_duels` VALUES (9, 'Xbox 360', 'Playstation 3', 'xbox360.png', 'playstation3.png', 18, 31, 49, '03.03', '1172949635', 'julien');
INSERT INTO `iuf_duels` VALUES (26, 'Desperados', 'Smirnoff', 'despe.png', 'smirnoff.png', 25, 45, 70, '07.03', '1173298458', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (27, 'Fumer', 'Interdire de fumer', 'smoke.png', 'nosmoke.png', 30, 96, 126, '07.03', '1173298473', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (17, 'Internet Explorer', 'Firefox', 'ie.png', 'mozillafirefox.jpg', 17, 68, 85, '04.03', '1173004717', 'kevin');
INSERT INTO `iuf_duels` VALUES (18, 'Moto', 'Voiture', 'moto.jpg', 'voiture.jpg', 19, 42, 61, '04.03', '1173004737', 'kevin');
INSERT INTO `iuf_duels` VALUES (20, 'Chien', 'Chat', 'chien.jpg', 'chat.jpg', 27, 50, 77, '04.03', '1173010089', 'florent');
INSERT INTO `iuf_duels` VALUES (29, 'Star Academy', 'Nouvelle Star', 'starac.jpg', 'nouvellestar.jpg', 18, 26, 44, '09.03', '1173463057', 'julien');
INSERT INTO `iuf_duels` VALUES (34, 'Slip', 'String', 'slip.jpg', 'string.jpg', 12, 56, 68, '10.03', '1173523526', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (32, 'Panda', 'Twingo', 'panda.jpg', 'twingo.jpg', 7, 37, 44, '10.03', '1173521002', 'julien');
INSERT INTO `iuf_duels` VALUES (33, '17h00', '02h00', '16h00.jpg', '2h00.jpg', 14, 29, 43, '10.03', '1173523459', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (36, 'DS Lite', 'PSP', 'ds.jpg', 'psp.jpg', 21, 40, 61, '10.03', '1173542148', 'julien');
INSERT INTO `iuf_duels` VALUES (37, 'Chamallow', 'Oeufs', 'chamallow.jpg', 'oeuf.jpg', 23, 29, 52, '10.03', '1173555157', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (39, 'Msn love', 'Sms love', 'msnlove.jpg', 'smslove.jpg', 50, 20, 70, '10.03', '1173560696', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (40, 'Linux', 'Windows', 'linux.jpg', 'windows.jpg', 23, 30, 53, '12.03', '1173724016', 'julien');
INSERT INTO `iuf_duels` VALUES (41, 'Google', 'Yahoo', 'google.jpg', 'yahoo.jpg', 43, 4, 47, '13.03', '1173804157', 'kevin');
INSERT INTO `iuf_duels` VALUES (42, 'Booba', 'Sinik', 'booba.jpg', 'sinik.jpg', 27, 17, 44, '13.03', '1173806286', 'kevin');
INSERT INTO `iuf_duels` VALUES (43, 'Puma', 'Airness', 'puma.jpg', 'airness.jpg', 38, 13, 51, '13.03', '1173807104', 'kevin');
INSERT INTO `iuf_duels` VALUES (44, 'NRJ', 'Skyrock', 'nrj.jpg', 'skyrock.jpg', 29, 17, 46, '14.03', '1173878819', 'kevin');
INSERT INTO `iuf_duels` VALUES (45, 'Winamp', 'Windows Media', 'winamp.jpg', 'windowsmediaplayer.jpg', 43, 27, 70, '14.03', '1173878842', 'kevin');
INSERT INTO `iuf_duels` VALUES (46, 'Snow', 'Surf', 'ski.png', 'surf.png', 20, 10, 30, '18.03', '1174204312', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (47, 'TF1', 'M6', 'TF1.png', 'M6.png', 15, 25, 40, '18.03', '1174204331', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (48, 'Football', 'Rugby', 'foot.png', 'rugby.png', 29, 16, 45, '18.03', '1174204346', 'yotsumi');
INSERT INTO `iuf_duels` VALUES (49, 'Apple', 'Archos', 'apple.jpg', 'archos.jpg', 33, 16, 49, '18.03', '1174246511', 'julien');
INSERT INTO `iuf_duels` VALUES (50, 'Lego', 'Playmobil', 'lego.jpg', 'playmobil.jpg', 34, 10, 44, '21.03', '1174511305', 'kevin');
INSERT INTO `iuf_duels` VALUES (51, 'Amour', 'Sexe', 'amour.jpg', 'sexe.jpg', 24, 48, 72, '25.03', '1174853262', 'yotsumi');

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_membres`
-- 

CREATE TABLE `iuf_membres` (
  `id` int(13) NOT NULL auto_increment,
  `email` varchar(200) NOT NULL default '',
  `first_connexion` datetime NOT NULL default '0000-00-00 00:00:00',
  `nb_votes` int(10) NOT NULL default '0',
  `nb_soumissions` int(10) NOT NULL default '0',
  `points` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=35 ;

-- 
-- Contenu de la table `iuf_membres`
-- 

INSERT INTO `iuf_membres` VALUES (26, 'dvildj84@hotmail.com', '2007-03-12 18:46:29', 0, 0, 0);
INSERT INTO `iuf_membres` VALUES (25, 'mobdo@hotmail.fr', '2007-03-11 21:08:06', 96, 1, 101);
INSERT INTO `iuf_membres` VALUES (24, 'devildj84@hotmail.com', '2007-03-11 12:21:37', 279, 0, 279);
INSERT INTO `iuf_membres` VALUES (23, 'yoyouu@gmail.com', '2007-03-10 13:46:51', 0, 0, 0);
INSERT INTO `iuf_membres` VALUES (22, 'Yotsumi@gmail.com', '2007-03-10 13:44:21', 0, 0, 0);
INSERT INTO `iuf_membres` VALUES (21, 'julsniper@gmail.com', '2007-03-09 23:38:46', 0, 0, 0);
INSERT INTO `iuf_membres` VALUES (20, 'jojoedu77@hotmail.com', '2007-03-09 17:53:11', 104, 0, 104);
INSERT INTO `iuf_membres` VALUES (19, 'manager@alienfx.net', '2007-03-09 16:33:26', 380, 0, 380);
INSERT INTO `iuf_membres` VALUES (17, 'en_trance@hotmail.Fr', '2007-03-07 23:35:47', 218, 1, 223);
INSERT INTO `iuf_membres` VALUES (18, 'gregory.moles@gmail.com', '2007-03-09 10:20:22', 2, 0, 2);
INSERT INTO `iuf_membres` VALUES (27, 'maxer_@hotmail.fr', '2007-03-14 14:24:52', 50, 0, 50);
INSERT INTO `iuf_membres` VALUES (28, 'euqoxaman@gmail.com', '2007-03-15 20:49:14', 6, 0, 6);
INSERT INTO `iuf_membres` VALUES (29, 'anti.steam@free.fr', '2007-03-16 21:39:54', 18, 0, 18);
INSERT INTO `iuf_membres` VALUES (30, 'xender49@hotmail.fr', '2007-03-20 13:58:38', 0, 0, 0);
INSERT INTO `iuf_membres` VALUES (31, 'fdsfdsfd@fsdfsd.fr', '2007-03-20 18:22:39', 0, 0, 0);
INSERT INTO `iuf_membres` VALUES (32, 'cast123321@yahoo.fr', '2007-03-27 17:30:31', 11, 0, 11);
INSERT INTO `iuf_membres` VALUES (33, 'faistonchoix@feerik.com', '2007-03-27 22:27:46', 2, 0, 2);
INSERT INTO `iuf_membres` VALUES (34, 'gerard.candille@wanadoo.fr', '2007-03-28 00:35:42', 15, 0, 15);

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_propositions`
-- 

CREATE TABLE `iuf_propositions` (
  `id` int(13) NOT NULL auto_increment,
  `id_membre` int(13) NOT NULL default '0',
  `nom1` varchar(255) NOT NULL default '',
  `nom2` varchar(255) NOT NULL default '',
  `pseudo` varchar(255) NOT NULL default '',
  `site` varchar(255) NOT NULL default '',
  `etat` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=49 ;

-- 
-- Contenu de la table `iuf_propositions`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_themes`
-- 

CREATE TABLE `iuf_themes` (
  `id` int(13) NOT NULL auto_increment,
  `nom` varchar(255) NOT NULL default '',
  `miniature` varchar(255) NOT NULL default '',
  `description` tinytext NOT NULL,
  `afficher` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Contenu de la table `iuf_themes`
-- 

INSERT INTO `iuf_themes` VALUES (1, 'Sexy !', 'star.jpg', 'Votez pour la célébritée la plus sexy ', 1);
INSERT INTO `iuf_themes` VALUES (2, 'Stars H', 'starh.jpg', 'Votez pour votre célébrité homme préféré !', 0);
INSERT INTO `iuf_themes` VALUES (3, 'Manga', 'manga.jpg', 'Votez pour votre manga préféré', 1);
INSERT INTO `iuf_themes` VALUES (4, 'Voiture', 'voiture.jpg', '', 1);
INSERT INTO `iuf_themes` VALUES (5, 'Film', 'film.jpg', '123', 0);
INSERT INTO `iuf_themes` VALUES (7, 'Jeux Video', 'jeux1.jpg', '', 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_themes_photos`
-- 

CREATE TABLE `iuf_themes_photos` (
  `id` int(13) NOT NULL auto_increment,
  `id_theme` int(13) NOT NULL default '0',
  `nom` varchar(255) NOT NULL default '',
  `img` varchar(255) NOT NULL default '',
  `nb_votes` int(13) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `id_theme` (`id_theme`)
) TYPE=MyISAM AUTO_INCREMENT=85 ;

-- 
-- Contenu de la table `iuf_themes_photos`
-- 

INSERT INTO `iuf_themes_photos` VALUES (2, 7, 'Tomb Raider', 'lara.jpg', 32);
INSERT INTO `iuf_themes_photos` VALUES (3, 7, 'Pong', 'pong.jpg', 26);
INSERT INTO `iuf_themes_photos` VALUES (4, 7, 'Pacman', 'pacman.jpg', 34);
INSERT INTO `iuf_themes_photos` VALUES (5, 7, 'Counter Strike', 'cs.jpg', 50);
INSERT INTO `iuf_themes_photos` VALUES (6, 7, 'Sims', 'sims.jpg', 32);
INSERT INTO `iuf_themes_photos` VALUES (7, 7, 'Battlefield', 'bf2.jpg', 46);
INSERT INTO `iuf_themes_photos` VALUES (8, 7, 'Doom', 'doom.jpg', 33);
INSERT INTO `iuf_themes_photos` VALUES (9, 7, 'Half Life 2', 'hl2.jpg', 52);
INSERT INTO `iuf_themes_photos` VALUES (10, 7, 'Tetris', 'tetris.png', 32);
INSERT INTO `iuf_themes_photos` VALUES (11, 7, 'PES', 'pes.jpg', 36);
INSERT INTO `iuf_themes_photos` VALUES (12, 7, 'Nintendogs', 'nintendogs.jpg', 10);
INSERT INTO `iuf_themes_photos` VALUES (13, 7, 'WoW', 'wow.jpg', 40);
INSERT INTO `iuf_themes_photos` VALUES (14, 7, 'Zelda gameboy', 'zelda.jpg', 24);
INSERT INTO `iuf_themes_photos` VALUES (16, 0, 'dfg', 'no.png', 1);
INSERT INTO `iuf_themes_photos` VALUES (20, 5, 'sdsd', 'no.png', 6);
INSERT INTO `iuf_themes_photos` VALUES (59, 4, 'Bmw M6', 'bmwm6.jpg', 39);
INSERT INTO `iuf_themes_photos` VALUES (23, 2, 'qsd', 'no.png', 5);
INSERT INTO `iuf_themes_photos` VALUES (25, 5, 'qsdqsd', 'no.png', 4);
INSERT INTO `iuf_themes_photos` VALUES (27, 5, 'qsdqsd', 'no.png', 6);
INSERT INTO `iuf_themes_photos` VALUES (60, 4, 'Bmw Serie 1', 'bmwserie1.jpg', 41);
INSERT INTO `iuf_themes_photos` VALUES (30, 2, 'hjkhj', 'no.png', 3);
INSERT INTO `iuf_themes_photos` VALUES (31, 2, 'ghjgh', 'no.png', 6);
INSERT INTO `iuf_themes_photos` VALUES (58, 4, 'Audi TT', 'auditt.jpg', 64);
INSERT INTO `iuf_themes_photos` VALUES (41, 1, 'Alyssa Milano', 'alyssa_milano.jpg', 73);
INSERT INTO `iuf_themes_photos` VALUES (34, 2, 'hjkhjk', 'no.png', 2);
INSERT INTO `iuf_themes_photos` VALUES (35, 7, 'Mario', 'mario.jpg', 36);
INSERT INTO `iuf_themes_photos` VALUES (36, 7, 'Metal Gear', 'snake.jpg', 45);
INSERT INTO `iuf_themes_photos` VALUES (37, 7, 'Sonic', 'sonic.jpg', 29);
INSERT INTO `iuf_themes_photos` VALUES (38, 7, 'Diablo II', 'diablo2.jpg', 25);
INSERT INTO `iuf_themes_photos` VALUES (39, 7, 'Prince of Persia', 'pop.jpg', 29);
INSERT INTO `iuf_themes_photos` VALUES (40, 7, 'Final Fantasy', 'ff.jpg', 41);
INSERT INTO `iuf_themes_photos` VALUES (42, 1, 'Anna Kournikova', 'Anna_Kournikova.jpg', 78);
INSERT INTO `iuf_themes_photos` VALUES (43, 1, 'Apri Scott', 'Apri_Scott.jpg', 120);
INSERT INTO `iuf_themes_photos` VALUES (44, 1, 'Carmen Electra', 'carmen_electra.jpg', 53);
INSERT INTO `iuf_themes_photos` VALUES (45, 1, 'Clara Morgane', 'clara_morgane.jpg', 156);
INSERT INTO `iuf_themes_photos` VALUES (46, 1, 'Danielle Lloyd', 'Danielle_Lloyd.jpg', 144);
INSERT INTO `iuf_themes_photos` VALUES (47, 1, 'Danii Minogue', 'Danii_Minogue.jpg', 71);
INSERT INTO `iuf_themes_photos` VALUES (48, 1, 'Elisha Cuthbert', 'Elisha_Cuthbert.jpg', 114);
INSERT INTO `iuf_themes_photos` VALUES (49, 1, 'Evengeline Lilly', 'evengeline_lilly.jpg', 85);
INSERT INTO `iuf_themes_photos` VALUES (50, 1, 'Holly Valance', 'Holly_Valance.jpg', 91);
INSERT INTO `iuf_themes_photos` VALUES (51, 1, 'Jennifer Love', 'Jennifer_Love.jpg', 101);
INSERT INTO `iuf_themes_photos` VALUES (52, 1, 'Jessica Alba', 'jessica_alba.jpg', 103);
INSERT INTO `iuf_themes_photos` VALUES (53, 1, 'Jessica Garner', 'jessica_garner.jpg', 57);
INSERT INTO `iuf_themes_photos` VALUES (54, 1, 'Mayuko Iwasa', 'Mayuko_Iwasa.jpg', 69);
INSERT INTO `iuf_themes_photos` VALUES (55, 1, 'Penelope Cruz', 'Penelope_Cruz.jpg', 52);
INSERT INTO `iuf_themes_photos` VALUES (56, 1, 'Rachel Bilson', 'Rachel_Bilson.jpg', 88);
INSERT INTO `iuf_themes_photos` VALUES (57, 1, 'Sarah Michelle Gellar', 'Sarah_Michelle_Gellar.jpg', 62);
INSERT INTO `iuf_themes_photos` VALUES (61, 4, 'VW Eos', 'eos.jpg', 40);
INSERT INTO `iuf_themes_photos` VALUES (62, 4, 'Ferrari Enzo', 'ferrari.jpg', 52);
INSERT INTO `iuf_themes_photos` VALUES (63, 4, 'Hummer H2', 'hummerh2.jpg', 22);
INSERT INTO `iuf_themes_photos` VALUES (64, 4, 'Jaguar JX220', 'jaguar.jpg', 45);
INSERT INTO `iuf_themes_photos` VALUES (65, 4, 'Lamborghini Murcielago', 'lamborghini.jpg', 93);
INSERT INTO `iuf_themes_photos` VALUES (66, 4, 'Porsche 911', 'porsche.jpg', 69);
INSERT INTO `iuf_themes_photos` VALUES (67, 4, 'VW Touareg', 'touareg.jpg', 22);
INSERT INTO `iuf_themes_photos` VALUES (68, 3, 'Angel Heart', 'angel.jpg', 16);
INSERT INTO `iuf_themes_photos` VALUES (69, 3, 'Bleach', 'bleach.jpg', 27);
INSERT INTO `iuf_themes_photos` VALUES (70, 3, 'Cowboy Bebop', 'cowboy.jpg', 26);
INSERT INTO `iuf_themes_photos` VALUES (71, 3, 'Dragon Ball Z', 'dragonballz.jpg', 30);
INSERT INTO `iuf_themes_photos` VALUES (72, 3, 'Evangelion', 'evangelion.jpg', 28);
INSERT INTO `iuf_themes_photos` VALUES (73, 3, 'Eyeshield 21', 'eyeshield.jpg', 9);
INSERT INTO `iuf_themes_photos` VALUES (74, 3, 'Full Metal Panic', 'fullmetal.jpg', 30);
INSERT INTO `iuf_themes_photos` VALUES (75, 3, 'Full Metal Alchemist', 'fullmetalalchemist.jpg', 22);
INSERT INTO `iuf_themes_photos` VALUES (76, 3, 'Get Backers', 'Get_Backers.jpg', 20);
INSERT INTO `iuf_themes_photos` VALUES (77, 3, 'Hellsing', 'hellsing.jpg', 21);
INSERT INTO `iuf_themes_photos` VALUES (78, 3, 'Hunter x Hunter', 'hunterx.jpg', 15);
INSERT INTO `iuf_themes_photos` VALUES (79, 3, 'Love Hina', 'lovehina.jpg', 14);
INSERT INTO `iuf_themes_photos` VALUES (80, 3, 'Naruto', 'naruto.jpg', 27);
INSERT INTO `iuf_themes_photos` VALUES (81, 3, 'Saint Seiya', 'saint_seiya.jpg', 17);
INSERT INTO `iuf_themes_photos` VALUES (82, 3, 'Trigun', 'trigun.jpg', 13);
INSERT INTO `iuf_themes_photos` VALUES (83, 3, 'One Piece', 'onepiece.jpg', 25);
INSERT INTO `iuf_themes_photos` VALUES (84, 3, 'Ah my Goddess', 'goddness.jpg', 32);

-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_themes_verif`
-- 

CREATE TABLE `iuf_themes_verif` (
  `id` int(13) NOT NULL auto_increment,
  `idphoto` int(13) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3043 ;

-- 
-- Contenu de la table `iuf_themes_verif`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `iuf_verifduel`
-- 

CREATE TABLE `iuf_verifduel` (
  `id` int(15) NOT NULL auto_increment,
  `id_duel` int(13) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `vote` enum('1','2') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1696 ;

-- 
-- Contenu de la table `iuf_verifduel`
-- 

