CREATE TABLE `pm_pokemon` ( `ID_POKEMON` int(11) NOT NULL,
							`NAME` varchar(45) DEFAULT NULL,
							`IMAGE` varchar(100) DEFAULT NULL,
							`ICON` varchar(100) DEFAULT NULL,
							`LINK` varchar(100) DEFAULT NULL,
							`ID_EVOLUTION` int(11) DEFAULT NULL,
							PRIMARY KEY (`ID_POKEMON`) );

