DROP SCHEMA IF EXISTS comp353 ;
CREATE SCHEMA IF NOT EXISTS comp353 DEFAULT CHARACTER SET utf8 ;
USE comp353;
DROP TABLE IF EXISTS person;

CREATE TABLE IF NOT EXISTS person(
	p_id INT AUTO_INCREMENT NOT NULL,
	first_name VARCHAR(50),
    last_name VARCHAR(50),
    dob DATE DEFAULT CURRENT_DATE,
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


