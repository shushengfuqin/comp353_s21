USE hjc353_1;
SELECT hw.emp_id, p.first_name, p.last_name, p.dob, p.phone, p.city, p.email, f.name AS location_name
FROM health_worker hw
JOIN person p ON p.p_id = hw.p_id 
JOIN work_history wh ON hw.emp_id = wh.emp_id         
JOIN facility f ON wh.loc_id = f.loc_id
WHERE p.province = 'QC' AND hw.p_id NOT IN (SELECT p_id
											FROM vaccination
											GROUP BY p_id
											HAVING COUNT(p_id)>1)