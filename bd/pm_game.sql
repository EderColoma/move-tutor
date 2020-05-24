CREATE TABLE `pm_game` ( `ID_GAME` int(11) NOT NULL,
						 `NAME` varchar(45) DEFAULT NULL,
						 `IMAGE` varchar(100) DEFAULT NULL,
						 `LINK` varchar(100) DEFAULT NULL,
						 `GENERATION` int(11) DEFAULT NULL,
						 PRIMARY KEY (`ID_GAME`) );