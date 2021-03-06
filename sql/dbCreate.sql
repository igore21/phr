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
	`measure_unit` TEXT NULL,
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
	`mandatory` TINYINT(1) NOT NULL,
	`valid_range_low` DOUBLE NULL,
	`valid_range_high` DOUBLE NULL,
	`ref_range_low` DOUBLE NULL,
	`ref_range_high` DOUBLE NULL,
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
	`parameter_id` INT NOT NULL,
	`state` SMALLINT NOT NULL DEFAULT 1,
	`scheduled_time` DATETIME NOT NULL,
	`modified_time` DATETIME NULL,
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

DROP TABLE IF EXISTS `template_parameter`;
CREATE TABLE `template_parameter` (
	`template_id` INT NOT NULL,
	`parameter_id` INT NOT NULL,
	`name` TEXT NOT NULL,
	`execute_after` INT NOT NULL,
	`time_unit` INT NOT NULL,
	`comment` TEXT,
	`mandatory` TINYINT(1) NOT NULL,
	`valid_range_low` DOUBLE NULL,
	`valid_range_high` DOUBLE NULL,
	`ref_range_low` DOUBLE NULL,
	`ref_range_high` DOUBLE NULL,
PRIMARY KEY (`template_id`, `parameter_id`),
INDEX `fk_template_id_idx` (`template_id` ASC),
CONSTRAINT `fk_template_parameter_id`
	FOREIGN KEY (`parameter_id`)
	REFERENCES `parameter` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);
	
-- data_type: int=1; double=2; string=3; bool=4;
insert into parameter (id, data_type, name, measure_unit) values
	(1, 3, 'open_ended', null),
	(2, 4, 'antibiotic', null),
	(3, 2, 'height', 'cm'),
	(4, 2, 'weight', 'kg'),
	(5, 2, 'temperature', '°C'),
	(6, 2, 'bloodGlucoseLevel', 'mg/dL'),
	(7, 3, 'sleepQuality', null),
	(8, 3, 'appetite', null),
	(9, 3, 'blood_pressure', null),
	(10, 3, 'nausea', null),
	(11, 1, 'numberOfHeartBeats', null),
	(12, 3, 'cough', null);

insert into template_parameter
	(template_id, name, parameter_id, execute_after, time_unit, mandatory,
	valid_range_low, valid_range_high, ref_range_low, ref_range_high, comment)
values
	(1, 'bronhitis', 5, 12, 1, 1, 35, 45, null, 37, 'Meriti ujutru i uvece pre spavanja.'),
	(1, 'bronhitis', 12, 1, 2, 1, null, null, null, null, 'Jacina kaslja pre spavanja.'),
	(1, 'bronhitis', 8, 12, 1, 0, null, null, null, null, ''),
	(2, 'stomacni virus', 5, 12, 1, 1, 35, 45, null, 37, 'Meriti ujutru i uvece pre spavanja.'),
	(2, 'stomacni virus', 8, 12, 1, 0, null, null, null, null, ''),
	(2, 'stomacni virus', 10, 8, 1, 0, null, null, null, null, 'Osecaj mucnine nakon obroka');

-- It must be at the end of the file
SET FOREIGN_KEY_CHECKS=1;