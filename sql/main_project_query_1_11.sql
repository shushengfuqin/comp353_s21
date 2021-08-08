--Query 1

--create person

INSERT INTO person (`p_id`, `first_name`, `last_name`, `dob`, `phone`, `address`, `city`, `province`, `postal_code`, `email`, `citizenship`) VALUES ('1', 'test1', 'test1', '2021-08-08', '5141111111', '1234', 'montreal', 'qc', '111111', '1111@1111.com', 'Canada');

--update person
UPDATE person SET `last_name` = 'test1.1', `address` = '1234.testupdate' WHERE `person`.`p_id` = 1;

--display person information  
SELECT * FROM person WHERE (p_id = 1);

--display chosen person infection history 
SELECT idate, variant_name FROM infection JOIN variant_type ON (type=variant_id) WHERE p_id=1;

--delete person
DELETE FROM person WHERE (p_id = 1);

--Query 2

--Create health_worker
    --make sure that it is in citizen (INSERT INTO `comp353`.`citizen` (`p_id`,`SSN`,`medicare`) VALUES ("1","12341234","12341234");)
INSERT INTO `comp353`.`health_worker` (`p_id`, `emp_id`) VALUES ('1', '1');

--update health_woker
UPDATE `comp353`.`health_worker` SET `emp_id` = 2 WHERE `p_id` = 1;

--display chosen health_worker by emp_id
SELECT * FROM health_worker WHERE （emp_id = 2);

--display all health_worker
SELECT * FROM health_worker;

--delete health_worker
DELETE FROM health_worker WHERE (p_id = 1);

--Query 3

--Create public health facility
INSERT INTO facility ("loc_id","name","address","city","province","postal_code","phone","web","type","manager") VALUES ("1","test1_fac","test1_fac_add","test1_fac_city","QC","test1_pc","5141111111","test1_web.com","Hospital","1");

--Update public health facility 
UPDATE facility ("name","address","city","province","postal_code","phone","web","type","manager") VALUES ("test1_fac_UP","test1_fac_add_UP","test1_fac_city","QC","test1_pc","5141111111","test1_web.com","Hospital","1");

--display chosen  facility by id 
SELECT * FROM facility WHERE (loc_id = 1);

--display all facility 
SELECT * FROM facility;

--Delete public health facility 
DELETE FROM facility WHERE (loc_id = 1);

--Query 4

