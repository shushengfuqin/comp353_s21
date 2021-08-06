USE hjc353_1;
SELECT f.loc_id, f.name, f.address, f.type, f.phone, emp.total_emp, s.total_shipment, t.total_from_loc, tt.total_to_loc, i.total_vaccine, p.total_people, v.total_dose
FROM facility f
LEFT JOIN (SELECT wh.loc_id, COUNT(wh.emp_id)AS total_emp
		FROM  work_history wh
		WHERE wh.end_date IS NULL
		GROUP BY wh.loc_id)AS emp ON emp.loc_id = f.loc_id
LEFT JOIN (SELECT s1.loc_id, SUM(s1.quantity)AS total_shipment
		FROM shipment s1 
		GROUP BY s1.loc_id)AS s ON s.loc_id = f.loc_id
LEFT JOIN (SELECT t1.from_loc, SUM(t1.quantity)AS total_from_loc
		FROM transfer t1 
		GROUP BY t1.from_loc)AS t ON t.from_loc = f.loc_id
LEFT JOIN (SELECT t2.to_loc, SUM(t2.quantity)AS total_to_loc
		FROM transfer t2 
		GROUP BY t2.to_loc)AS tt ON tt.to_loc = f.loc_id
LEFT JOIN (SELECT inv.loc_id,SUM(inv.quantity)AS total_vaccine
		FROM inventory inv
		GROUP BY inv.loc_id) AS i ON i.loc_id = f.loc_id
LEFT JOIN (SELECT peop.loc_id, COUNT(peop.p_id)AS total_people
			FROM (SELECT va.loc_id, va.p_id
					FROM vaccination va 
					GROUP BY va.loc_id, va.p_id)AS peop
			GROUP BY peop.loc_id)AS p ON p.loc_id = f.loc_id
LEFT JOIN (SELECT va.loc_id, COUNT(va.dose_num)AS total_dose
			FROM vaccination va 
			GROUP BY va.loc_id)AS v ON v.loc_id = f.loc_id





