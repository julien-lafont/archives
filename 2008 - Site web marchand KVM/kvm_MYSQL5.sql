-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Vendredi 27 Juillet 2007 à 09:53
-- Version du serveur: 5.0.27
-- Version de PHP: 5.2.0
-- 
-- Base de données: `kvm`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_admins_droits`
-- 

DROP TABLE IF EXISTS `kvm_admins_droits`;
CREATE TABLE `kvm_admins_droits` (
  `id_admin` mediumint(8) unsigned NOT NULL auto_increment,
  `droit_membres` char(1) collate latin1_general_ci default '0',
  `droit_editorial` char(1) collate latin1_general_ci default '0',
  `droit_gestion_commandes` char(1) collate latin1_general_ci default '0',
  `droit_config` char(1) collate latin1_general_ci NOT NULL default '0',
  PRIMARY KEY  (`id_admin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- 
-- Contenu de la table `kvm_admins_droits`
-- 

INSERT INTO `kvm_admins_droits` (`id_admin`, `droit_membres`, `droit_editorial`, `droit_gestion_commandes`, `droit_config`) VALUES 
(1, '1', '1', '1', '1');

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_categories`
-- 

DROP TABLE IF EXISTS `kvm_categories`;
CREATE TABLE `kvm_categories` (
  `id_cat` mediumint(8) unsigned NOT NULL auto_increment,
  `id_cat_parent` mediumint(8) unsigned default '0',
  `nom` varchar(255) collate latin1_general_ci default NULL,
  `image` varchar(255) collate latin1_general_ci default NULL,
  `description` text collate latin1_general_ci,
  PRIMARY KEY  (`id_cat`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_commandes`
-- 

DROP TABLE IF EXISTS `kvm_commandes`;
CREATE TABLE `kvm_commandes` (
  `id_commande` mediumint(8) unsigned NOT NULL auto_increment,
  `id_membre` mediumint(8) unsigned default NULL,
  `liste_produits_s` text collate latin1_general_ci,
  `total_prix` float default NULL,
  `total_ecotaxe` float default NULL,
  `id_devise` tinyint(3) unsigned default NULL,
  `mode_paiement` varchar(50) collate latin1_general_ci default NULL,
  `id_fdp` mediumint(8) unsigned default NULL,
  `statut` enum('en_attente','paye','preparation','expedie') collate latin1_general_ci default NULL,
  `validation_date` datetime NOT NULL,
  `paiement_date` datetime NOT NULL,
  `envoie_date` datetime NOT NULL,
  `ref_paiement` varchar(255) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id_commande`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;



-- 
-- Structure de la table `kvm_config`
-- 

DROP TABLE IF EXISTS `kvm_config`;
CREATE TABLE `kvm_config` (
  `id_config` mediumint(8) unsigned NOT NULL auto_increment,
  `description` varchar(255) collate latin1_general_ci default NULL,
  `cle` varchar(30) collate latin1_general_ci default NULL,
  `valeur` varchar(255) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id_config`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `kvm_config`
-- 

INSERT INTO `kvm_config` (`id_config`, `description`, `cle`, `valeur`) VALUES 
(1, 'Meta tag -description generale-', 'DESCRIPTION', 'blipblouphgjfg'),
(2, 'Meta tag -mots cles-', 'KEYWORDS', 'ba bi boufgfg'),
(3, 'Page s''affichant a l''accueil du site', 'PAGE_DEFAUT', 'accueil'),
(4, 'Template par defaut', 'TEMPLATE_DEFAUT', 'simple'),
(10, 'Nombre d''articles par pages', 'NB_ARTICLES', '2'),
(5, 'Chemin des images affichees par defaut', 'CHEMIN_DEFAUT', 'images/defaut/'),
(6, 'Montant des taxes (TVA) avec conversion', 'TAXE', '1.19'),
(7, 'Nom du site', 'NOM', 'Kvm E-commmerce'),
(8, 'Numero du groupe par defaut pour les membres bannis', 'GROUPE_BAN', '9'),
(9, 'Groupe d''administrateur', 'GROUPE_ADMIN', '5'),
(11, 'ID de la devise par defaut', 'DEVISE_DEFAUT', '5');

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_devises`
-- 

DROP TABLE IF EXISTS `kvm_devises`;
CREATE TABLE `kvm_devises` (
  `id_devise` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` varchar(50) collate latin1_general_ci default NULL,
  `symbole_g` varchar(12) collate latin1_general_ci default NULL,
  `symbole_d` varchar(12) collate latin1_general_ci default NULL,
  `convers_euro` decimal(16,8) default NULL,
  `last_maj` datetime default NULL,
  PRIMARY KEY  (`id_devise`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- 
-- Contenu de la table `kvm_devises`
-- 

INSERT INTO `kvm_devises` (`id_devise`, `nom`, `symbole_g`, `symbole_d`, `convers_euro`, `last_maj`) VALUES 
(5, 'USD', '$', NULL, 1.37840000, '2007-07-17 21:10:51');

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_frais_de_ports`
-- 

DROP TABLE IF EXISTS `kvm_frais_de_ports`;
CREATE TABLE `kvm_frais_de_ports` (
  `id_fdp` mediumint(8) unsigned NOT NULL auto_increment,
  `mode_envoie` varchar(50) collate latin1_general_ci default NULL,
  `prix_euros` float default NULL,
  `delais` varchar(50) collate latin1_general_ci default NULL,
  `logo` varchar(255) collate latin1_general_ci default NULL,
  `description` text collate latin1_general_ci,
  PRIMARY KEY  (`id_fdp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_marques`
-- 

DROP TABLE IF EXISTS `kvm_marques`;
CREATE TABLE `kvm_marques` (
  `id_marque` mediumint(8) unsigned NOT NULL auto_increment,
  `nom` varchar(100) collate latin1_general_ci default NULL,
  `image` varchar(255) collate latin1_general_ci default NULL,
  `site` varchar(255) collate latin1_general_ci default NULL,
  `infos` longtext collate latin1_general_ci,
  PRIMARY KEY  (`id_marque`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_membres`
-- 

DROP TABLE IF EXISTS `kvm_membres`;
CREATE TABLE `kvm_membres` (
  `id_membre` mediumint(8) unsigned NOT NULL auto_increment,
  `pseudo` varchar(75) collate latin1_general_ci default NULL,
  `pass` varchar(50) collate latin1_general_ci default NULL,
  `email` varchar(75) collate latin1_general_ci default NULL,
  `cle` varchar(20) collate latin1_general_ci default NULL,
  `last_ip` varchar(15) collate latin1_general_ci default NULL,
  `last_activity` varchar(20) collate latin1_general_ci default NULL,
  `groupe` char(1) collate latin1_general_ci default '0',
  PRIMARY KEY  (`id_membre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `kvm_membres`
-- 

INSERT INTO `kvm_membres` (`id_membre`, `pseudo`, `pass`, `email`, `cle`, `last_ip`, `last_activity`, `groupe`) VALUES 
(1, 'admin', 'yoI6fDJLKO1RQ', 'email@admin.com', 'BbWlmVYo', '127.0.0.1', '1185521784', '5');

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_membres_config`
-- 

DROP TABLE IF EXISTS `kvm_membres_config`;
CREATE TABLE `kvm_membres_config` (
  `id_membre` mediumint(8) unsigned default NULL,
  `langue` varchar(20) collate latin1_general_ci default NULL,
  `id_devise` tinyint(3) unsigned default NULL,
  `question_secrete` tinytext collate latin1_general_ci,
  `reponse` varchar(255) collate latin1_general_ci default NULL,
  `newsletter` enum('html','txt','none') collate latin1_general_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Contenu de la table `kvm_membres_config`
-- 

INSERT INTO `kvm_membres_config` (`id_membre`, `langue`, `id_devise`, `question_secrete`, `reponse`, `newsletter`) VALUES 
(1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_membres_infos`
-- 

DROP TABLE IF EXISTS `kvm_membres_infos`;
CREATE TABLE `kvm_membres_infos` (
  `id_membre` mediumint(8) unsigned default NULL,
  `genre` enum('h','f') collate latin1_general_ci default NULL,
  `prenom` varchar(50) collate latin1_general_ci default NULL,
  `nom` varchar(50) collate latin1_general_ci default NULL,
  `adresse` tinytext collate latin1_general_ci,
  `cp` varchar(5) collate latin1_general_ci default NULL,
  `ville` varchar(50) collate latin1_general_ci default NULL,
  `pays` varchar(50) collate latin1_general_ci default NULL,
  `tel` varchar(13) collate latin1_general_ci default NULL,
  `portable` varchar(13) collate latin1_general_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Contenu de la table `kvm_membres_infos`
-- 

INSERT INTO `kvm_membres_infos` (`id_membre`, `genre`, `prenom`, `nom`, `adresse`, `cp`, `ville`, `pays`, `tel`, `portable`) VALUES 
(1, 'h', 'Julien', 'LAFONT', 'qsdqsdsqd', '84100', 'ORANGE', 'France2', '0490516480', '0676015812');

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_paniers_membres`
-- 

DROP TABLE IF EXISTS `kvm_paniers_membres`;
CREATE TABLE `kvm_paniers_membres` (
  `id_panier` mediumint(8) unsigned NOT NULL auto_increment,
  `id_membre` mediumint(8) unsigned default NULL,
  `id_sess_invite` mediumint(8) unsigned default NULL,
  `liste_produits_s` text collate latin1_general_ci,
  `id_devise` tinyint(3) unsigned default NULL,
  `code_promo` varchar(30) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id_panier`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;



-- 
-- Structure de la table `kvm_produits`
-- 

DROP TABLE IF EXISTS `kvm_produits`;
CREATE TABLE `kvm_produits` (
  `id_produit` mediumint(8) unsigned NOT NULL auto_increment,
  `id_cat` mediumint(8) unsigned default NULL,
  `id_marque` mediumint(8) unsigned default NULL,
  `nom` varchar(255) collate latin1_general_ci default NULL,
  `reference` varchar(50) collate latin1_general_ci default NULL,
  `description` longtext collate latin1_general_ci,
  `caracteristiques` longtext collate latin1_general_ci,
  `image` varchar(255) collate latin1_general_ci default NULL,
  `images_plus_s` longtext collate latin1_general_ci,
  `prix` float default NULL,
  `ecotaxe` float default NULL,
  `stock` varchar(40) collate latin1_general_ci default NULL,
  `nb_vue` int(8) NOT NULL,
  `nb_achat` int(8) NOT NULL,
  PRIMARY KEY  (`id_produit`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_produits_accueil`
-- 

DROP TABLE IF EXISTS `kvm_produits_accueil`;
CREATE TABLE `kvm_produits_accueil` (
  `zone_coup_de_coeur` text collate latin1_general_ci,
  `zone_test` text collate latin1_general_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Contenu de la table `kvm_produits_accueil`
-- 

INSERT INTO `kvm_produits_accueil` (`zone_coup_de_coeur`, `zone_test`) VALUES 
('', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `kvm_session_invites`
-- 

DROP TABLE IF EXISTS `kvm_session_invites`;
CREATE TABLE `kvm_session_invites` (
  `id_session` mediumint(8) unsigned NOT NULL auto_increment,
  `ip` varchar(12) collate latin1_general_ci default NULL,
  `cle` varchar(50) collate latin1_general_ci default NULL,
  `last_activitee` varchar(20) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id_session`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `kvm_session_invites`
-- 