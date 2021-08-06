USE hjc353_1;

SELECT f.province, v.name AS vaccine_type,SUM(i.quantity)AS total
FROM facility f 
JOIN inventory i ON i.loc_id = f.loc_id
JOIN vaccine v ON v.vac_id = i.vac_id
GROUP BY f.province,i.vac_id
ORDER BY f.province, vaccine_type DESC











                    