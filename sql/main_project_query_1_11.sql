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

INSERT INTO `facility` (`loc_id`,`name`,`address`,`city`,`province`,`postal_code`,`phone`,`web`,`type`,`manager`) VALUES ("1001","test1_fac","test1_fac_add","test1_fac_city","QC","test1","5141111111","test1_web.com","Hospital","1");

--Update public health facility 
UPDATE `facility` SET `name` = 'test1_update' WHERE `loc_id` = 1001;

--display chosen  facility by id 
SELECT * FROM facility WHERE (loc_id = 1001);


--display all facility 
SELECT * FROM facility;

--Delete public health facility 
DELETE FROM facility WHERE (loc_id = 1);

--Query 4 

--Create Vaccination Type

INSERT INTO `vaccine` (`vac_id`,`name`,`vac_desc`,`status`) VALUES ("5","test","test desc","safe");

--Update vaccination type
UPDATE `vaccine` SET `status` = 'suspend' WHERE `vac_id` = 5;

--Display one by id
SELECT * FROM  `vaccine` WHERE `vac_id` = 5;

--Display all
SELECT * FROM `vaccine`;

--Delete by id
DELETE FROM `vaccine` WHERE (`vac_id` = 5);

--Query 5

-- Create Infection Variant type
INSERT INTO `variant_type` (`variant_id`,`variant_name`) VALUES ("6","test");

-- Update Infection Variant type
UPDATE `variant_type` SET `variant_name` = "test_update" WHERE `variant_id` = "6";

-- Display infection variant by id
SELECT * FROM `variant_type` WHERE `variant_id` = 6;

-- Display infection variant list
SELECT * FROM `variant_type`;

-- Delete by id
DELETE FROM `variant_type` WHERE `variant_id` = 6;

--QUERY 6

-- Create group age
INSERT INTO `age_group` (`grp_id`,`upper_limit`,`lower_limit`) VALUES ("11","300","250");

-- Update group age
UPDATE `age_group` SET `lower_limit` = "200" WHERE 'grp_id' = "11";

-- Display by grp_id
SELECT * FROM `age_group` WHERE `grp_id` = "11";

-- Display all
SELECT * FROM `age_group`;

-- Delete by grp_id
DELETE FROM `age_group` WHERE `grp_id` = "11";

-- Query 7

-- Add province
INSERT INTO `pv_age` (`province`,`grp_id`) VALUES ("TT","10");

-- Edit
UPDATE `pv_age` SET `province` = "TU" WHERE `province` = "TT";

-- Delete TO BE PERFORM AFTER QUERY 8
DELETE FROM `pv_age` WHERE `province` = "TU";

-- Query 8 

UPDATE `pv_age` SET `grp_id` = 9 WHERE `province` = "TU";

-- Query 9
-- ADD INTO INVENTORY OF LOC_ID 1 WITH VAC_ID 1. CURRENT QUANTIRY = 100. POST INSERT QUANTITY SHOULD = 101
INSERT INTO `shipment` (`ship_id`,`loc_id`,`sdate`,`vac_id`,`quantity`) VALUES ("1","1","2021-08-08","1","1");

-- Query 10
-- TRANSFER FROM LOC_ID 1 TO LOC_ID 2 WITH VAC_ID 1. POST INSERT LOC 1 quantity = 100 loc 2 quantity = 301
INSERT INTO `transfer` (`trans_id`,`from_loc`,`to_loc`,`tdate`,`vac_id`,`quantity`) VALUES ("1","1","2","2021-08-08","1","1");

-- Query 11
--Perform vaccin to p_id 1 where loc = 1, and the emp_id = 1 
INSERT INTO `comp353`.`vaccination` (`p_id`, `dose_num`, `emp_id`, `vac_id`, `loc_id`, `vdate`) VALUES ('1', '1', '1005', '1', '1', '2021-02-28');

