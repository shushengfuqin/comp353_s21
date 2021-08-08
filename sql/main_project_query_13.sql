USE hjc353_1;


SELECT p.first_name, p.last_name, p.dob, p.email, p.phone, p.city,v.vdate, va.name AS vaccination_type,IF(inf.p_id IS NOT NULL,'YES','NO') AS 'infected'
FROM person p
JOIN vaccination v ON p.p_id = v.p_id
JOIN vaccine va ON v.vac_id = va.vac_id
LEFT JOIN  (SELECT DISTINCT(p_id) FROM infection) AS inf ON inf.p_id = p.p_id
WHERE p.p_id IN (SELECT v1.p_id
					FROM (SELECT p_id, dose_num, vac_id
							FROM vaccination 
							WHERE p_id IN (SELECT p_id
											FROM vaccination
											GROUP BY p_id
											HAVING COUNT(dose_num)>1)
									AND dose_num > 1)AS v1
					JOIN
						(SELECT p_id, dose_num, vac_id
							FROM vaccination 
							WHERE p_id IN (SELECT p_id
											FROM vaccination
											GROUP BY p_id
											HAVING COUNT(dose_num)>1)
									AND dose_num = 1)AS v2 ON v2.p_id = v1.p_id
					WHERE v1.vac_id != v2.vac_id)
	 AND (p.city = 'Montreal')
