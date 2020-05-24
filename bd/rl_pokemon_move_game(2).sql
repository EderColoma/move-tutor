CREATE TABLE `rl_pokemon_move_game` ( `id_pokemon` int(11) NOT NULL DEFAULT '0',
									  `id_game` int(11) NOT NULL DEFAULT '0',
									  `id_move` int(11) NOT NULL DEFAULT '0',
									  `level` int(11) DEFAULT NULL,
									  `type` int(11) DEFAULT NULL,
									  PRIMARY KEY (`id_pokemon`,`id_game`,`id_move`),
									  FOREIGN KEY (`id_pokemon` ) REFERENCES `u802852207_mvtutor`.`pm_pokemon` (`ID_POKEMON` ),
									  FOREIGN KEY (`id_move` ) REFERENCES `u802852207_mvtutor`.`pm_move` (`ID_MOVE` ),
									  FOREIGN KEY (`id_game` ) REFERENCES `u802852207_mvtutor`.`pm_game` (`ID_GAME` ));

