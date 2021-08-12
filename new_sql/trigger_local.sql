# TRIGGER 
DROP TRIGGER IF EXISTS `comp353`.`shipment_BEFORE_INSERT`;

DELIMITER $$
USE `comp353`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `shipment_BEFORE_INSERT` BEFORE INSERT ON `shipment` FOR EACH ROW BEGIN
	
update inventory set inventory.quantity = inventory.quantity + new.quantity where (new.loc_id = inventory.loc_id) AND (new.vac_id = inventory.vac_id);
        

END$$
DELIMITER ;



DROP TRIGGER IF EXISTS `comp353`.`shipment_AFTER_DELETE`;

DELIMITER $$
USE `comp353`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `shipment_AFTER_DELETE` AFTER DELETE ON `shipment` FOR EACH ROW BEGIN

 update inventory set inventory.quantity = inventory.quantity - old.quantity where (old.loc_id = inventory.loc_id) AND (old.vac_id = inventory.vac_id);

END$$
DELIMITER ;






DROP TRIGGER IF EXISTS `comp353`.`transfer_BEFORE_INSERT`;

DELIMITER $$
USE `comp353`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `transfer_BEFORE_INSERT` BEFORE INSERT ON `transfer` FOR EACH ROW 
BEGIN
	
	IF EXISTS(SELECT i.quantity FROM inventory i WHERE i.loc_id = new.from_loc AND i.vac_id = new.vac_id AND i.quantity > new.quantity)THEN
    
	
	update inventory set inventory.quantity = inventory.quantity + new.quantity where (new.to_loc = inventory.loc_id) AND (new.vac_id = inventory.vac_id);
	update inventory set inventory.quantity = inventory.quantity - new.quantity where (new.from_loc = inventory.loc_id) AND (new.vac_id = inventory.vac_id);
    
    else
    SIGNAL sqlstate '45000' SET MESSAGE_TEXT = 'THE INVENTORY QUANTITY IS LESS THAN NEW INSERT QUANTITY';	

    end if;
	
END$$
DELIMITER ;




DROP TRIGGER IF EXISTS `comp353`.`transfer_AFTER_DELETE`;

DELIMITER $$
USE `comp353`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `transfer_AFTER_DELETE` AFTER DELETE ON `transfer` FOR EACH ROW BEGIN
update inventory set inventory.quantity = inventory.quantity - old.quantity where (old.to_loc = inventory.loc_id) AND (old.vac_id = inventory.vac_id);
update inventory set inventory.quantity = inventory.quantity + old.quantity where (old.from_loc = inventory.loc_id) AND (old.vac_id = inventory.vac_id);
END$$
DELIMITER ;






DROP TRIGGER IF EXISTS `comp353`.`vaccination_BEFORE_INSERT`;

DELIMITER $$
USE `comp353`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `vaccination_BEFORE_INSERT` BEFORE INSERT ON `vaccination` FOR EACH ROW BEGIN
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




DROP TRIGGER IF EXISTS `comp353`.`vaccination_AFTER_DELETE`;

DELIMITER $$
USE `comp353`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `vaccination_AFTER_DELETE` AFTER DELETE ON `vaccination` FOR EACH ROW BEGIN

 update inventory set inventory.quantity = inventory.quantity + 1 where (old.loc_id = inventory.loc_id) AND (old.vac_id = inventory.vac_id);

END$$
DELIMITER ;