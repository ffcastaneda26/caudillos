
TRUNCATE positions;
TRUNCATE picks;


SELECT 'Pronósticos=' as Tipo,COUNT(*) as total FROM picks
UNION
SELECT 'Posiciones=' as Tipo,COUNT(*) as total FROM positions;|

---
SELECT vt.short AS VISITANTE,
 		 lt.short AS VISITANTE,
       ga.id,ga.winner,
		 if(ga.winner=1,'Local','Visita') AS Ganador,
		 IF(pic.winner=1,'Local','Visita') AS PROOSTICO_QUIEN_GANA,
		 pic.winner AS PRONOSTICOX,
		 if(ga.winner=pic.winner,'Acerttó','Falló') AS Resultado,
		 pic.local_points AS "PRONOSTICO PUNTOS LOCALES",
		 pic.visit_points AS "PRONOSTICO PUNTOS VISITA",
		 pic.id AS "PIC_ID"
FROM games ga,picks pic,teams lt,teams vt
WHERE ga.id = pic.game_id
  AND lt.id = ga.local_team_id
  AND vt.id = ga.visit_team_id
  AND ga.round_id = 2
  AND (ga.local_team_id = 1 OR ga.visit_team_id = 1)

---
SELECT concat(us.first_name,' ',us.last_name) as nombre,
		lt.name as local,
        vt.name as visita,
		pi.winner as pronosticó,
        ga.winner as resultado,
        if (pi.winner = ga.winner,"SI","NO") as ACERTÓ
FROM users us,picks pi,games ga,teams lt,teams vt
WHERE us.id = pi.user_id
  AND ga.id = pi.game_id
  AND lt.id = ga.local_team_id
  AND vt.id = ga.visit_team_id
  AND pi.game_id BETWEEN 1 AND 5;
--
UPDATE games
SET local_points = NULL,visit_points = NULL;


----- ACIERTOS DE JUEGOS DE UNA JORNADA ----
SELECT ga.id ,CONCAT(us.first_name,' ', us.last_name) AS PARTICIPANTE ,
		tv.name AS VISITA,ga.visit_points,
		tl.name AS LOCAL,ga.local_points,
		if(pic.winner=1,"LOCAL","VISITA") AS pronóstico,
		if(ga.winner = pic.winner,"Acertó","Falló") AS RESULTADO,
		pic.local_points AS PRON_LOCAL,
		pic.visit_points AS PRON_VISITA
FROM games ga,picks pic,teams tv,teams tl,users us
WHERE ga.id = pic.game_id
  AND tv.id = ga.visit_team_id
  AND tl.id = ga.local_team_id
  AND us.id = pic.user_id
  AND ga.round_id = 1


----- Borrar pronósticos -----
USE  caudillos;
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE picks;
TRUNCATE general_positions;
TRUNCATE positions;
 UPDATE games SET visit_points=NULL,local_points=NULL,winner=NULL;

--- Pronósticos de usuario -----
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

----- CRITERIOS DE DESEMPATE ----
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

-- Posiciones de una jornada
SELECT concat(us.first_name,' ',us.last_name) as Nombre,
       pos.hits as Aciertos,
       pos.points_by_local as 'Pts x Local',
       pos.points_by_visit as 'pts x Visita',
       pos.points_by_hit_tie_breaker_game as 'Pts x Desempate',
       pos.points_by_hit_game as 'Pts x Juego',
	   pos.total_points as 'Pts Totales',
       pos.position as 'Posición'
FROM users us,positions pos
WHERE us.id = pos.user_id
  AND pos.round_id = 1
ORDER BY pos.position;
