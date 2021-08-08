USE hjc353_1;
SELECT f.city, SUM(s.quantity)AS total_vaccines
FROM facility f 
JOIN shipment s ON s.loc_id = f.loc_id
WHERE (f.province = 'QC') AND (s.sdate BETWEEN '2021-01-01' AND '2021-07-22')
GROUP BY f.city



