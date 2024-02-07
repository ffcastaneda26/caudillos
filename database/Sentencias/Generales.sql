-- Actualizar campos para desempate en pronósticos

UPDATE picks pic,games ga
SET pic.dif_points_local=abs(2-pic.local_points),
    pic.dif_points_visit= abs(14-pic.visit_points),
	 pic.dif_points_total= abs(abs(14-pic.visit_points)+abs(2-pic.local_points)),
	 hit_local= CASE WHEN pic.local_points=2 THEN 1 ELSE 0  END,
	 hit_visit= CASE WHEN pic.visit_points=14 THEN 1 ELSE 0  END,
	 hit= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END,
	 dif_points_winner= CASE WHEN (2>14) THEN abs(pic.local_points - 2) ELSE abs(pic.visit_points - 14)  END,
	 pic.dif_victory=abs(16-(pic.local_points + pic.visit_points))
WHERE ga.id = pic.game_id   AND ga.id=4

// Usuarios con su rol
SELECT concat(us.first_name," ",last_name) as Nombre,us.email,ro.name
FROM users us,roles ro,user_roles ur
WHERE us.id = ur.user_id
  AND ro.id = ur.role_id;


-- Pronósticos de usuario
SELECT ga.id AS 'Juego Id',
		concat(us.first_name,' ' ,us.last_name) AS nombre,
	--	ga.game_day AS 'Fecha',
	--	ga.game_time AS 'Hora',
		tv.name AS 'Visita',
		pic.visit_points AS 'Puntos Visita',
		tl.name AS 'Local',
		pic.local_points AS 'Puntos Local',
		if(pic.winner = 1,'Local','Visita')  AS 'Ganador Pronosticado',
		ga.visit_points AS 'Ptos Par Visita',
		ga.local_points AS 'Ptos Par Local',
		if(ga.winner = 1,tl.name,tv.name)  AS 'Ganador Partido',
		if(ga.winner = pic.winner,'SI','NO') AS 'Acerto Partido',
		if(pic.hit_last_game,'SI','NO') AS 'Acertó Último'
FROM users us,games ga,teams tv,teams tl,picks pic
WHERE us.id = pic.user_id
  AND tv.id = ga.visit_team_id
  AND tl.id = ga.local_team_id
  AND ga.id = pic.game_id
  AND us.id = 2
  AND ga.round_id = 1
ORDER BY ga.game_day,ga.game_time;

-- Insertar perfiles
INSERT INTO `profiles` (`id`, `user_id`, `gender`, `birthday`, `curp`, `entidad_id`, `municipio_id`, `codpos`, `ine_anverso`, `ine_reverso`) VALUES
	(1, 2, 'Hombre', '1918-03-11', 'CAHS181103HCHSRB01', 6, 153, '31300', 'public/ines/ine_002_TDxCausa.png', 'public/ines/ine_002_jidosha_vertical.png');

-- Mostrar criterios de desempate
SELECT  dif_points_winner,
        dif_points_local,
        dif_points_visit,
        dif_points_total,
        dif_victory,
        hit_visit ,
        hit_local,
        hit AS 'Acertó Partido',
        hit_last_game AS 'Acertó Ultimo',
        points_by_local AS 'Local',
        points_by_visit AS 'Visita',
        points_by_hit_game AS 'Partido',
        points_by_hit_tie_breaker_game AS 'Ultimo Partido',
		  total_points AS 'Total'
FROM picks
WHERE game_id = 1
