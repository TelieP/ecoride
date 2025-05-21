

CREATE DATABASE IF NOT EXISTS `covoitbdd`  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `covoitbdd`;


CREATE TABLE `avis` (
  `Id_avis` int(11) NOT NULL,
  `commentaire` varchar(50) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `statut` enum('En attente','Validé','Supprimé','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `avis` (`Id_avis`, `commentaire`, `note`, `statut`) VALUES
(1, 'Le voyage s\'est très bien passé. Je recommande ce ', '5', 'En attente'),
(2, 'bien ', '5', 'En attente'),
(4, 'conductrice très aimable , et gentille , je recomm', '5', NULL);




CREATE TABLE `configuration` (
  `Id_configuration` int(11) NOT NULL,
  `Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





CREATE TABLE `covoiturage` (
  `Id_covoiturage` int(11) NOT NULL,
  `date_depart` date DEFAULT NULL,
  `heure_depart` varchar(50) DEFAULT NULL,
  `lieu_depart` varchar(50) DEFAULT NULL,
  `date_arrivee` date DEFAULT NULL,
  `heure_arrivee` varchar(50) DEFAULT NULL,
  `lieu_arrivee` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `nb_place` int(11) DEFAULT NULL,
  `prix_personne` int(11) DEFAULT NULL,
  `Id_voiture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `covoiturage` (`Id_covoiturage`, `date_depart`, `heure_depart`, `lieu_depart`, `date_arrivee`, `heure_arrivee`, `lieu_arrivee`, `statut`, `nb_place`, `prix_personne`, `Id_voiture`) VALUES
(2, '2025-03-12', '10:20', 'tolouse', '2025-03-25', '18:55', 'paris', 'en cours', 4, 55, 1),
(3, '2025-02-27', '09:10', 'Lyon', '2025-02-27', '14:25', 'Narbonne', 'Disponible', 2, 20, 2),
(4, '2025-03-23', '10:20', 'narbonne', '2025-03-23', '18:55', 'paris', 'en cours', 4, 55, 2),
(5, '2025-03-23', '08:12', 'narbonne', '2025-03-23', '14:25', 'paris', 'en cours', 0, 30, 1),
(6, '2025-04-24', '10:20', 'lyon', '2025-04-24', '14:25', 'bordeaux', 'en cours', 3, 22, 2),
(7, '2025-04-15', '07:05', 'Perpignan', '2025-04-15', '14:25', 'Pau', 'Disponible', 2, 26, 2),
(8, '2025-04-15', '10:20', 'brest', '2025-04-15', '14:25', 'paris', 'en cours', 4, 30, 3),
(9, '2025-04-15', '09:10', 'brest', '2025-04-15', '14:25', 'paris', 'Disponible', 2, 20, 1),
(10, '2025-04-15', '06:00', 'brest', '2025-04-15', '9:25', 'paris', 'en cours', 2, 24, 2),
(21, '2025-08-23', '10:20', 'tolouse', '2025-08-23', '14:25', 'paris', 'en cours', 2, 30, 2),
(22, '2025-08-02', '10:00', 'toulouse', NULL, NULL, 'paris', 'en cours', 2, 30, 1),
(23, '2025-05-28', '10:00', 'toulouse', NULL, NULL, 'paris', 'en cours', 1, 20, 1),
(24, '2025-05-30', '10:30', 'Lézignan-corbières', NULL, NULL, 'Carcassonne', 'en cours', 2, 5, 6);



CREATE TABLE `depose` (
  `Id_utilisateur` int(11) NOT NULL,
  `Id_avis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





CREATE TABLE `marque` (
  `Id_marque` int(11) NOT NULL,
  `libelle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `marque` (`Id_marque`, `libelle`) VALUES
(1, 'Toyota'),
(2, 'Nissan'),
(3, 'Renault'),
(4, 'Peugeot'),
(5, 'Hundai'),
(6, 'Kia'),
(7, 'Mercedez'),
(8, 'Porshe'),
(9, 'Range rover'),
(10, 'Audi'),
(11, 'BMW'),
(12, 'Fiat'),
(13, 'Dacia'),
(14, 'Krisler'),
(15, 'BYD'),
(16, 'Testla'),
(17, 'BW'),
(18, 'Opel'),
(19, 'Suziki'),
(20, 'Ford'),
(21, 'Honda');



CREATE TABLE `parametre` (
  `Id_parametre` int(11) NOT NULL,
  `propriete` varchar(50) DEFAULT NULL,
  `valeur` varchar(50) DEFAULT NULL,
  `Id_configuration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `participe` (
  `Id_utilisateur` int(11) NOT NULL,
  `Id_covoiturage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `possede` (
  `Id_role` int(11) NOT NULL,
  `Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `possede` (`Id_role`, `Id_utilisateur`) VALUES
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(4, 14);



CREATE TABLE `reservation` (
  `Id_reservation` int(255) NOT NULL,
  `Id_utilisateur` int(100) NOT NULL,
  `Id_covoiturage` int(11) NOT NULL,
  `places_reserves` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `reservation` (`Id_reservation`, `Id_utilisateur`, `Id_covoiturage`, `places_reserves`) VALUES
(1, 4, 5, 2),
(2, 7, 5, 1),
(3, 7, 5, 1),
(4, 7, 5, 1),
(5, 7, 5, 1),
(6, 7, 5, 1),
(7, 7, 5, 1),
(8, 7, 4, 3),
(9, 7, 4, 1),
(10, 7, 5, 1),
(11, 7, 23, 1);



CREATE TABLE `role` (
  `Id_role` int(11) NOT NULL,
  `libelle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `role` (`Id_role`, `libelle`) VALUES
(2, 'user'),
(3, 'employé'),
(4, 'Admin');



CREATE TABLE `utilisateur` (
  `Id_utilisateur` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `date_naissance` varchar(50) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `utilisateur` (`Id_utilisateur`, `nom`, `prenom`, `email`, `password`, `telephone`, `adresse`, `date_naissance`, `photo`, `pseudo`) VALUES
(1, 'FONGANG Telie', 'Parfait', 'paflesix@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$MkJEUHFCNmJhOUV5dTMycA$YiaCSsIgaFrnis7KOvKGEfmB+QGAiJeQhhIaNpmJ9Gc', '0615487341', '53 avenue georges clemenceau', '2000-12-12', 'images/conducteurs/imguser01.jpg', 'baba'),
(2, 'baba', 'bobo', 'parfait@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$RVhmWC9Fb3ZKbVA4TmZPVA$Hoh3rXek+IBeOq87tR5HerLwdXasXWigSP1suWJdDuk', '0611251436', '2bis rue renan 66000 perpignan', '1985-12-22', '../images/conducteurs/imguser03.jpg', 'bobolo'),
(3, 'telie', 'papa', 'papa@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$RDRBd3JPVlJ6OUFicnRWUA$Mka1WvMuzRsnuPPuTqLcCayGRYHhbzcmZ0MP1E3TNS0', '12478812420', '12 rue paul ', '2000-12-12', '../images/conducteurs/imguser02.jpg', 'prince'),
(4, 'Bouzina', 'Anais', 'anais@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$bVMvelEvNi9XLzVsYW9uYw$Bm9BbqrCMFp4oRj/szbOu1GgB/9jF39+wNG02sWYvJQ', '0615487341', '53 avenue georges clemenceau', '1980-12-12', 'images/imguser01.jpg', 'anais92'),
(7, 'Mamon', 'marie', 'marie@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$L1VDQ2Y5dHJBL2JneUtOSA$h+eoXSL4BOqL421+AJsLHvDK5brNiIv3Gp6/O25dTJI', '0712131415', '69 rue paul gautier', '2000-09-23', 'images/conducteurs/imguser03.jpg', 'marilou'),
(8, 'nana', 'nana', 'nana0000@gmail.fr', '$argon2id$v=19$m=65536,t=4,p=1$YWx1T3Bac2twa1BFWS5TZw$FtuRUnndZ09RFTMPVN18FocO+fU4GZxFZcdSYu4QQIQ', '0689472514', '12 rue paul 95000 Paris ', '1990-06-12', 'nana.jpg', 'nanou'),
(9, 'manon', 'manon', 'manon1234@outlook.fr', '$argon2id$v=19$m=65536,t=4,p=1$NjFGYTd4Nk5MTDBOVkkzZA$GFz2rp/9nUUloxVzaPHtDwm2v9KbIanfFwv9auRTzgk', '0203040506', '32 rue voltaire 95000 paris', '1990-03-12', 'images/conducteurs/manon.jpg', 'manon'),
(10, 'coco', 'paul', 'coco1234@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$TjBhSWRCRnZ5ZHFJMUN3MA$FCmIsorpi/jdVH8xnc4Q0gLp3/NbJj6klWZ2Q1FUUGs', '0602030405', '53 rue alain georges', '2000-12-12', 'images', 'coco'),
(11, 'test1', 'test', 'test0000@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$enhLakRlblJwT1IvUXludw$8BN2EfcQD1NQSrNoBFu5AlYUFrWRx5KsZze2cZdTqOM', '0103020506', '21 saint charles 11100 narbonne', '1980-07-02', 'images', 'test1'),
(12, 'test2', 'test2', 'test2000000@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$T0Q4ajA4TUJFQmphV3NseA$miJnJjDYCkVb+aRUFOttsfwBBwbO01TX5IFbTjaSbFQ', '0604050201', '2 avenue jerome ', '1988-09-06', 'images/conducteurs/pexels-cottonbro-8358795.jpg', 'test2'),
(14, 'admin', 'admin', 'admin@admin.fr', '$argon2id$v=19$m=65536,t=4,p=1$ajlSZ2U4WkVqSGNEZE5MUQ$twbkhl1MLIS582bEucZXwEmvResmUYbBBGgNDF1WaIA', '0101010101', '2 espace administrateur 92000 admin', '1960-01-01', 'images//conducteurs//', 'admin');



CREATE TABLE `voiture` (
  `Id_voiture` int(11) NOT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `immatriculation` varchar(50) DEFAULT NULL,
  `energie` varchar(50) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `date_premiere_immatriculation` varchar(50) DEFAULT NULL,
  `Id_utilisateur` int(11) NOT NULL,
  `Id_marque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `voiture` (`Id_voiture`, `modele`, `immatriculation`, `energie`, `couleur`, `date_premiere_immatriculation`, `Id_utilisateur`, `Id_marque`) VALUES
(1, 'toyota', 'BH-485-GR', 'essence', 'rouge', '12/06/2024', 1, 1),
(2, 'nissan', 'JK-364-PO', 'Diesel', 'noire', '30/01/2007', 2, 2),
(3, 'modelo', 'BJ-160-MX', 'Electrique', 'Blue', '12/02/2025', 4, 8),
(4, 'A145', 'NJ-195JK', 'hybride', NULL, '2017-03-12', 7, 1),
(5, 'A145', 'AZ-800-YU', 'hybride', NULL, '2020-08-20', 7, 6),
(6, 'E250', 'ZK-189-BH', 'diesel', NULL, '2023-12-12', 7, 7),
(7, '3008', 'BJ-145-AZ', 'hybride', NULL, '2024-12-03', 7, 4);


ALTER TABLE `avis`
  ADD PRIMARY KEY (`Id_avis`);


ALTER TABLE `configuration`
  ADD PRIMARY KEY (`Id_configuration`),
  ADD KEY `Id_utilisateur` (`Id_utilisateur`);


ALTER TABLE `covoiturage`
  ADD PRIMARY KEY (`Id_covoiturage`),
  ADD KEY `Id_voiture` (`Id_voiture`);


ALTER TABLE `depose`
  ADD PRIMARY KEY (`Id_utilisateur`,`Id_avis`),
  ADD KEY `Id_avis` (`Id_avis`);


ALTER TABLE `marque`
  ADD PRIMARY KEY (`Id_marque`);


ALTER TABLE `parametre`
  ADD PRIMARY KEY (`Id_parametre`),
  ADD KEY `Id_configuration` (`Id_configuration`);


ALTER TABLE `participe`
  ADD PRIMARY KEY (`Id_utilisateur`,`Id_covoiturage`),
  ADD KEY `Id_covoiturage` (`Id_covoiturage`);


ALTER TABLE `possede`
  ADD PRIMARY KEY (`Id_role`,`Id_utilisateur`),
  ADD KEY `Id_utilisateur` (`Id_utilisateur`);


ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Id_reservation`),
  ADD KEY `Id_utilisateur` (`Id_utilisateur`),
  ADD KEY `Id_covoiturage` (`Id_covoiturage`);


ALTER TABLE `role`
  ADD PRIMARY KEY (`Id_role`);


ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Id_utilisateur`);


ALTER TABLE `voiture`
  ADD PRIMARY KEY (`Id_voiture`),
  ADD KEY `Id_utilisateur` (`Id_utilisateur`),
  ADD KEY `Id_marque` (`Id_marque`);


ALTER TABLE `avis`
  MODIFY `Id_avis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `configuration`
  MODIFY `Id_configuration` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `covoiturage`
  MODIFY `Id_covoiturage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;


ALTER TABLE `marque`
  MODIFY `Id_marque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;


ALTER TABLE `parametre`
  MODIFY `Id_parametre` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `reservation`
  MODIFY `Id_reservation` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;


ALTER TABLE `role`
  MODIFY `Id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `utilisateur`
  MODIFY `Id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `voiture`
  MODIFY `Id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `configuration`
  ADD CONSTRAINT `configuration_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);


ALTER TABLE `covoiturage`
  ADD CONSTRAINT `covoiturage_ibfk_1` FOREIGN KEY (`Id_voiture`) REFERENCES `voiture` (`Id_voiture`);


ALTER TABLE `depose`
  ADD CONSTRAINT `depose_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`),
  ADD CONSTRAINT `depose_ibfk_2` FOREIGN KEY (`Id_avis`) REFERENCES `avis` (`Id_avis`);


ALTER TABLE `parametre`
  ADD CONSTRAINT `parametre_ibfk_1` FOREIGN KEY (`Id_configuration`) REFERENCES `configuration` (`Id_configuration`);


ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`),
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`Id_covoiturage`) REFERENCES `covoiturage` (`Id_covoiturage`);


ALTER TABLE `possede`
  ADD CONSTRAINT `possede_ibfk_1` FOREIGN KEY (`Id_role`) REFERENCES `role` (`Id_role`),
  ADD CONSTRAINT `possede_ibfk_2` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);


ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Id_covoiturage`) REFERENCES `covoiturage` (`Id_covoiturage`);


ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`),
  ADD CONSTRAINT `voiture_ibfk_2` FOREIGN KEY (`Id_marque`) REFERENCES `marque` (`Id_marque`);
COMMIT;

