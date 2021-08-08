USE hjc353_1;
SELECT p.first_name, p.last_name, p.dob, p.email, p.phone, p.city, v.vdate, va.name AS vaccination_type, COUNT(p.p_id)AS infected_times
FROM person p
JOIN vaccination v ON p.p_id = v.p_id
JOIN vaccine va ON v.vac_id = va.vac_id
JOIN infection i ON i.p_id = p.p_id
WHERE p.p_id IN (SELECT DISTINCT(inf1.p_id)
				FROM  infection inf1, infection inf2 
				WHERE (inf1.type != inf2.type)  AND  ( inf1.p_id = inf2.p_id))
GROUP BY p.p_id


                    

                    


