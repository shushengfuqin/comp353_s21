USE hjc353_1;
SELECT hw.emp_id, c.ssn, p.first_name, p.last_name, p.dob, c.medicare, p.phone, p.address, p.city, p.province, p.postal_code, p.citizenship, p.email, wh.start_date, wh.end_date
FROM health_worker hw
JOIN person p ON p.p_id = hw.p_id
JOIN citizen c ON hw.p_id = c.p_id 
JOIN work_history wh ON hw.emp_id = wh.emp_id         
JOIN facility f ON wh.loc_id = f.loc_id
WHERE f.type = 'special installment'
