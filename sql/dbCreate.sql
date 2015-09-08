SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`file_id` INT UNIQUE,
	`first_name` VARCHAR(45) NOT NULL,
	`last_name` VARCHAR(45) NOT NULL,
	`email` VARCHAR(45) UNIQUE NOT NULL,
	`password` VARCHAR(45) NOT NULL,
	`role` SMALLINT NOT NULL,
	`active` BIT NOT NULL DEFAULT 1,
	`gender` SMALLINT NULL,
PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `parameter`;
CREATE TABLE `parameter` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(45) NOT NULL,
	`data_type` INT NOT NULL,
PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `assignment`;
CREATE TABLE assignment (
	`id` INT NOT NULL AUTO_INCREMENT,
	`doctor_id` INT NOT NULL,
	`patient_id` INT NOT NULL,
	`name` VARCHAR(45) NOT NULL,
	`description` TEXT NULL,
	`start_time` DATETIME NOT NULL,
	`end_time` DATETIME NOT NULL,
PRIMARY KEY (`id`),
INDEX `fk_patient_id_idx` (`patient_id` ASC),
CONSTRAINT `fk_patient_id`
	FOREIGN KEY (`patient_id`)
	REFERENCES `user` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
INDEX `fk_doctor_id_idx` (`doctor_id` ASC),
CONSTRAINT `fk_doctor_id`
	FOREIGN KEY (`doctor_id`)
	REFERENCES `user` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);

DROP TABLE IF EXISTS `assignment_parameter`;
CREATE TABLE `assignment_parameter` (
	`assignment_id` INT NOT NULL,
	`parameter_id` INT NOT NULL,
	`execute_after` INT NOT NULL,
	`time_unit` INT NOT NULL,
	`comment` TEXT,
PRIMARY KEY (`assignment_id`, `parameter_id`),
INDEX `fk_assignmentd_id_idx` (`assignment_id` ASC),
CONSTRAINT `fk_assignmentd_id`
	FOREIGN KEY (`assignment_id`)
	REFERENCES `assignment` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
CONSTRAINT `fk_parameter_id`
	FOREIGN KEY (`parameter_id`)
	REFERENCES `parameter` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);

DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`patient_id` INT NOT NULL,
	`assignment_id` INT NOT NULL,
	`time` TIMESTAMP NOT NULL,
	`data_type` SMALLINT NOT NULL,	-- int=1; double=2; string=3; bool=4;
	`integer_value` INT NULL,
	`double_value` DOUBLE NULL,
	`string_value` TEXT NULL,
	`bool_value` TINYINT(1) NULL,
PRIMARY KEY (`id`),
INDEX `fk_data_patient_id_idx` (`patient_id` ASC),
CONSTRAINT `fk_data_patient_id`
	FOREIGN KEY (`patient_id`)
	REFERENCES `user` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
INDEX `fk_data_assignment_id_idx` (`assignment_id` ASC),
CONSTRAINT `fk_data_assignment_id`
	FOREIGN KEY (`patient_id`)
	REFERENCES `user` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);

-- data_type: int=1; double=2; string=3; bool=4;
insert into parameter (id, name, data_type) values
	(1, 'antibiotic', 4),
	(2, 'height', 2),
	(3, 'weight', 2),
	(4, 'temperature', 2),
	(5, 'numberOfHeartBeats', 1),
	(6, 'bloodSugerLevel', 2),
	(7, 'glucoseLevel', 2),
	(8, 'sleepQuality', 3),
	(9, 'appetite', 3),
	(10, 'blood_pressure', 3),
	(11, 'open_ended', 3);


-- It must be at the end of the file
SET FOREIGN_KEY_CHECKS=1;