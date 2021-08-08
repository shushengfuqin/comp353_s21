USE hjc353_1;

SELECT pop.province, pop.type_vaccine,COUNT(pop.p_id)AS total_num
FROM
(SELECT f.province, va.name AS type_vaccine, v.p_id
FROM vaccination v          
JOIN facility f ON v.loc_id = f.loc_id
JOIN vaccine va ON va.vac_id = v.vac_id
WHERE v.vdate BETWEEN '2021-01-01' AND '2021-07-22'
GROUP BY f.province, type_vaccine, v.p_id)AS pop
GROUP BY pop.province, pop.type_vaccine
ORDER BY pop.province




