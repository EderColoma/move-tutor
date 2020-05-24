CREATE TABLE `rl_pokemon_game` ( `ID_POKEMON` int(11) NOT NULL,
								 `ID_GAME` int(11) NOT NULL,
							   	 PRIMARY KEY (`ID_POKEMON`,`ID_GAME`),
								 KEY `FK_ID_POKEMON_idx` (`ID_POKEMON`),
								 KEY `FK_ID_GAME_idx` (`ID_GAME`),
								 CONSTRAINT `FK_ID_POKEMON` FOREIGN KEY (`ID_POKEMON`) REFERENCES `pm_pokemon` (`ID_POKEMON`) ON DELETE NO ACTION ON UPDATE NO ACTION,
								 CONSTRAINT `FK_ID_GAME` FOREIGN KEY (`ID_GAME`) REFERENCES `pm_game` (`ID_GAME`) ON DELETE NO ACTION ON UPDATE NO ACTION );
