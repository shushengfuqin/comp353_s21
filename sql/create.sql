DROP SCHEMA IF EXISTS hjc353_1 ;
CREATE SCHEMA IF NOT EXISTS hjc353_1 DEFAULT CHARACTER SET utf8 ;
USE hjc353_1;
DROP TABLE IF EXISTS person;

CREATE TABLE IF NOT EXISTS person(
	p_id INT AUTO_INCREMENT NOT NULL,
	first_name VARCHAR(50),
    last_name VARCHAR(50),
    dob DATE,
    phone CHAR(10),
    address VARCHAR(100),
    city VARCHAR(50),
    province CHAR(2),
    postal_code CHAR(6),
    email VARCHAR(50),
    citizenship VARCHAR(50),
    PRIMARY KEY(p_id)
);

DROP TABLE IF EXISTS non_citizen;
CREATE TABLE  IF NOT EXISTS non_citizen(
	p_id INT NOT NULL,
    passport VARCHAR(50) NOT NULL,
    PRIMARY KEY(p_id),
    FOREIGN KEY(p_id) REFERENCES person(p_id)
);

DROP TABLE IF EXISTS citizen;
CREATE TABLE IF NOT EXISTS citizen(
	p_id INT NOT NULL,
    ssn CHAR(9) NOT NULL,
    medicare CHAR(12) NOT NULL,
    PRIMARY KEY(p_id),
    FOREIGN KEY(p_id) REFERENCES person(p_id)
);

DROP TABLE IF EXISTS health_worker;
CREATE TABLE IF NOT EXISTS health_worker(
	p_id INT NOT NULL,
    emp_id INT NOT NULL UNIQUE,
    PRIMARY KEY(p_id),
    FOREIGN KEY(p_id) REFERENCES citizen(p_id)
);


DROP TABLE IF EXISTS age_group;
CREATE TABLE IF NOT EXISTS age_group(
	grp_id SMALLINT NOT NULL,
    upper_limit SMALLINT,
    lower_limit SMALLINT,
    PRIMARY KEY(grp_id)
);


DROP TABLE IF EXISTS pv_age;
CREATE TABLE IF NOT EXISTS pv_age(
	province CHAR(2) NOT NULL,
    grp_id SMALLINT DEFAULT 0,
    PRIMARY KEY(province),
    FOREIGN KEY(grp_id) REFERENCES age_group(grp_id)
);

DROP TABLE IF EXISTS facility;
CREATE TABLE IF NOT EXISTS facility(
	loc_id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(50),
    address VARCHAR(50),
    city VARCHAR(20),
    province CHAR(2),
    postal_code CHAR(6),
    phone CHAR(10),
    web VARCHAR(100),
    type ENUM('Hospital','Clinic','special installment'),
    manager INT UNIQUE,
    PRIMARY KEY(loc_id),
    FOREIGN KEY(manager) REFERENCES citizen(p_id),
    FOREIGN KEY(province) REFERENCES pv_age(province)
);

DROP TABLE IF EXISTS work_history;
CREATE TABLE IF NOT EXISTS work_history(
	emp_id INT NOT NULL,
    loc_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    PRIMARY KEY(emp_id, loc_id, start_date),
    FOREIGN KEY(loc_id) REFERENCES facility(loc_id),
    FOREIGN KEY(emp_id) REFERENCES health_worker(emp_id)
);

DROP TABLE IF EXISTS vaccine;
CREATE TABLE IF NOT EXISTS vaccine(
	vac_id SMALLINT NOT NULL,
    name VARCHAR(50),
    vac_desc VARCHAR(100),
    status ENUM ('safe','suspend'),
    PRIMARY KEY(vac_id)
);

DROP TABLE IF EXISTS vaccine_history;
CREATE TABLE IF NOT EXISTS vaccine_history(
	vac_id SMALLINT NOT NULL,
    update_date DATE NOT NULL,
    update_status ENUM ('safe','suspend') NOT NULL,
    PRIMARY KEY(vac_id, update_date, update_status)
);

DROP TABLE IF EXISTS vaccination;
CREATE TABLE IF NOT EXISTS vaccination(
	p_id INT NOT NULL,
    dose_num SMALLINT NOT NULL,
    emp_id INT NOT NULL,
    vac_id SMALLINT NOT NULL,
    loc_id INT NOT NULL,
    vdate DATE NOT NULL,
    PRIMARY KEY(p_id, dose_num),
    FOREIGN KEY(emp_id) REFERENCES health_worker(emp_id),
    FOREIGN KEY(vac_id) REFERENCES vaccine(vac_id),
    FOREIGN KEY(loc_id) REFERENCES facility(loc_id)
);

DROP TABLE IF EXISTS variant_type;
CREATE TABLE IF NOT EXISTS variant_type(
	variant_id INT AUTO_INCREMENT NOT NULL,
    variant_name VARCHAR(20) DEFAULT 'UNKNOWN',
	PRIMARY KEY(variant_id)
);


DROP TABLE IF EXISTS infection;
CREATE TABLE IF NOT EXISTS infection(
	p_id INT NOT NULL,
    idate DATE,
    type INT NOT NULL,
    PRIMARY KEY(p_id, idate),
    FOREIGN KEY(p_id) REFERENCES person(p_id),
    FOREIGN KEY(type) REFERENCES variant_type(variant_id)
);

DROP TABLE IF EXISTS inventory;
CREATE TABLE IF NOT EXISTS inventory(
	loc_id INT NOT NULL,
    vac_id SMALLINT NOT NULL,
    quantity BIGINT DEFAULT 0,
    PRIMARY KEY(loc_id, vac_id),
    FOREIGN KEY(loc_id) REFERENCES facility(loc_id),
    FOREIGN KEY(vac_id) REFERENCES vaccine(vac_id)
);

DROP TABLE IF EXISTS shipment;
CREATE TABLE IF NOT EXISTS shipment(
	ship_id INT AUTO_INCREMENT NOT NULL,
    loc_id INT NOT NULL,
    sdate DATE NOT NULL,
    vac_id SMALLINT NOT NULL,
    quantity BIGINT NOT NULL,
    PRIMARY KEY(ship_id),
    FOREIGN KEY(loc_id) REFERENCES facility(loc_id),
    FOREIGN KEY(vac_id) REFERENCES vaccine(vac_id)
);

DROP TABLE IF EXISTS transfer;
CREATE TABLE IF NOT EXISTS transfer(
	trans_id INT AUTO_INCREMENT NOT NULL,
    from_loc INT NOT NULL,
    to_loc INT NOT NULL,
    tdate DATE NOT NULL,
    vac_id SMALLINT NOT NULL,
    quantity BIGINT NULL,
	PRIMARY KEY(trans_id),
    FOREIGN KEY(from_loc) REFERENCES facility(loc_id),
    FOREIGN KEY(to_loc) REFERENCES facility(loc_id),
    FOREIGN KEY(vac_id) REFERENCES vaccine(vac_id)
);


# TRIGGER 
DROP TRIGGER IF EXISTS `hjc353_1`.`shipment_BEFORE_INSERT`;

DELIMITER $$
USE `hjc353_1`$$
CREATE DEFINER=`hjc353_1`@`132.205.%.%` TRIGGER `shipment_BEFORE_INSERT` BEFORE INSERT ON `shipment` FOR EACH ROW BEGIN
	
update inventory set inventory.quantity = inventory.quantity + new.quantity where (new.loc_id = inventory.loc_id) AND (new.vac_id = inventory.vac_id);
        

END$$
DELIMITER ;



DROP TRIGGER IF EXISTS `hjc353_1`.`shipment_AFTER_DELETE`;

DELIMITER $$
USE `hjc353_1`$$
CREATE DEFINER=`hjc353_1`@`132.205.%.%` TRIGGER `shipment_AFTER_DELETE` AFTER DELETE ON `shipment` FOR EACH ROW BEGIN

 update inventory set inventory.quantity = inventory.quantity - old.quantity where (old.loc_id = inventory.loc_id) AND (old.vac_id = inventory.vac_id);

END$$
DELIMITER ;






DROP TRIGGER IF EXISTS `hjc353_1`.`transfer_BEFORE_INSERT`;

DELIMITER $$
USE `hjc353_1`$$
CREATE DEFINER=`hjc353_1`@`132.205.%.%` TRIGGER `transfer_BEFORE_INSERT` BEFORE INSERT ON `transfer` FOR EACH ROW 
BEGIN
	
	IF EXISTS(SELECT i.quantity FROM inventory i WHERE i.loc_id = new.from_loc AND i.vac_id = new.vac_id AND i.quantity > new.quantity)THEN
    
	
	update inventory set inventory.quantity = inventory.quantity + new.quantity where (new.to_loc = inventory.loc_id) AND (new.vac_id = inventory.vac_id);
	update inventory set inventory.quantity = inventory.quantity - new.quantity where (new.from_loc = inventory.loc_id) AND (new.vac_id = inventory.vac_id);
    
    else
    SIGNAL sqlstate '45000' SET MESSAGE_TEXT = 'THE INVENTORY QUANTITY IS LESS THAN NEW INSERT QUANTITY';	

    end if;
	
END$$
DELIMITER ;




DROP TRIGGER IF EXISTS `hjc353_1`.`transfer_AFTER_DELETE`;

DELIMITER $$
USE `hjc353_1`$$
CREATE DEFINER=`hjc353_1`@`132.205.%.%` TRIGGER `transfer_AFTER_DELETE` AFTER DELETE ON `transfer` FOR EACH ROW BEGIN
update inventory set inventory.quantity = inventory.quantity - old.quantity where (old.to_loc = inventory.loc_id) AND (old.vac_id = inventory.vac_id);
update inventory set inventory.quantity = inventory.quantity + old.quantity where (old.from_loc = inventory.loc_id) AND (old.vac_id = inventory.vac_id);
END$$
DELIMITER ;






DROP TRIGGER IF EXISTS `hjc353_1`.`vaccination_BEFORE_INSERT`;

DELIMITER $$
USE `hjc353_1`$$
CREATE DEFINER=`hjc353_1`@`132.205.%.%` TRIGGER `vaccination_BEFORE_INSERT` BEFORE INSERT ON `vaccination` FOR EACH ROW BEGIN
if exists(SELECT ag.grp_id 
    FROM pv_age pv, facility f, person p, age_group ag
    WHERE  new.loc_id = f.loc_id  AND pv.province = f.province AND p.p_id = new.p_id 
    AND (TRUNCATE(DATEDIFF(CURDATE(), p.dob) / 365, 0) BETWEEN ag.lower_limit AND ag.upper_limit) AND ag.grp_id > pv.grp_id)
    then
    SIGNAL sqlstate '45000' SET MESSAGE_TEXT = 'THE PERSON AGE IS NOT ELIGIBLE ';
 
elseif exists(SELECT i.quantity FROM inventory i  WHERE new.loc_id = i.loc_id AND new.vac_id = i.vac_id AND i.quantity=0)then
    SIGNAL sqlstate '45000' SET MESSAGE_TEXT = 'THE INVENTORY QUANTITY IS LESS THAN NEW INSERT QUANTITY';
elseif new.emp_id NOT IN (SELECT wh.emp_id 
                            FROM work_history wh 
                            WHERE wh.loc_id = new.loc_id 
                                AND ((new.vdate BETWEEN wh.start_date AND wh.end_date) OR (new.vdate > wh.start_date AND end_date IS NULL)))then
    SIGNAL sqlstate '45000' SET MESSAGE_TEXT = 'THE EMPLOYEE ID IS NOT CORRECT ';
elseif new.vac_id IN (SELECT vac_id FROM vaccine WHERE status = 'suspend')then
    SIGNAL sqlstate '45000' SET MESSAGE_TEXT = 'THE VACCINE IS SUSPEND STATUS ';
else
    update inventory set inventory.quantity = inventory.quantity - 1 where (new.loc_id = inventory.loc_id) AND (new.vac_id = inventory.vac_id);
end if;
END$$
DELIMITER ;




DROP TRIGGER IF EXISTS `hjc353_1`.`vaccination_AFTER_DELETE`;

DELIMITER $$
USE `hjc353_1`$$
CREATE DEFINER=`hjc353_1`@`132.205.%.%` TRIGGER `vaccination_AFTER_DELETE` AFTER DELETE ON `vaccination` FOR EACH ROW BEGIN

 update inventory set inventory.quantity = inventory.quantity + 1 where (old.loc_id = inventory.loc_id) AND (old.vac_id = inventory.vac_id);

END$$
DELIMITER ;

