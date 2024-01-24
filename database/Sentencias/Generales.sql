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
