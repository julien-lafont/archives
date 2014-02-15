-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Serveur: db625.1and1.fr
-- Généré le : Jeudi 03 Août 2006 à 19:47
-- Version du serveur: 5.0.19
-- Version de PHP: 4.3.10-200.schlund.1
-- 
-- Base de données: `db168497404`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `membres`
-- 

CREATE TABLE `membres` (
  `id` int(5) NOT NULL auto_increment,
  `pseudo` varchar(50) collate latin1_german2_ci NOT NULL default '',
  `pass` varchar(50) collate latin1_german2_ci NOT NULL default '',
  `email` varchar(100) collate latin1_german2_ci NOT NULL default '',
  `ip` varchar(25) collate latin1_german2_ci NOT NULL default '',
  `level` int(1) NOT NULL default '0',
  `jour` int(11) NOT NULL default '0',
  `mois` int(11) NOT NULL default '0',
  `total` int(11) NOT NULL default '0',
  `com` varchar(255) collate latin1_german2_ci NOT NULL,
  `click` int(5) NOT NULL,
  `fraude` int(5) NOT NULL,
  `ban` char(1) collate latin1_german2_ci NOT NULL,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=2 ;

-- 
-- Contenu de la table `membres`
-- 

INSERT INTO `membres` VALUES (1, 'tonpseudo', 'tonpass', 'tonemail', '82.255.6.118', 5, 0, 5, 17, 'Moi :)', 5, 9, '9');
