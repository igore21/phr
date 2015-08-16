CREATE TABLE `user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`first_name` VARCHAR(45) NOT NULL,
	`last_name` VARCHAR(45) NOT NULL,
	`email` VARCHAR(45) NOT NULL,
	`password` VARCHAR(45) NOT NULL,
	`role` SMALLINT NULL,
	`active` BIT NULL DEFAULT 1,
PRIMARY KEY (`id`),
UNIQUE INDEX `email_UNIQUE` (`email` ASC));
  
  
CREATE TABLE `parameter` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(45) NOT NULL,
	'data_type' INT,
PRIMARY KEY (`id`),
UNIQUE INDEX `name_UNIQUE` (`name` ASC));


CREATE TABLE assignment (
	`id` INT NOT NULL AUTO_INCREMENT,
	`pacient_id` INT NOT NULL,
	`doctor_id` INT NOT NULL,
	`start_time` DATETIME NULL,
	`end_time` DATETIME NULL,
	`name` VARCHAR(45) NOT NULL,
	`description` TEXT NULL,
    `actions` TEXT,
    `frequency` INT,
    `max_delay` INT,
    `comment` TEXT,
PRIMARY KEY (`id`),
INDEX `fk_pacient_id_idx` (`pacient_id` ASC),
INDEX `fk_doctor_id_idx` (`doctor_id` ASC),
CONSTRAINT `fk_pacient_id`
FOREIGN KEY (`pacient_id`)
REFERENCES `phr`.`user` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `fk_doctor_id`
FOREIGN KEY (`doctor_id`)
REFERENCES `phr`.`user` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);


CREATE TABLE `assignment_parameter` (
`assignment_id` INT NOT NULL,
`parameter_id` INT NOT NULL,
PRIMARY KEY (`assignment_id`, `parameter_id`),
INDEX `fk_parameter_idx` (`parameter_id` ASC),
CONSTRAINT `fk_assignment`
FOREIGN KEY (`assignment_id`)
REFERENCES `phr`.`assignment` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION,
CONSTRAINT `fk_parameter`
FOREIGN KEY (`parameter_id`)
REFERENCES `phr`.`parameter` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION);




insert into parameter
values  (1, 'blood_pressure', 2),
		(2, 'height', 1),
		(3, 'weight', 1),
		(4, 'temperature', 1);





CREATE TABLE `data` (
	`id` INT NOT NULL,
	`userID` INT NULL,
	`assignment` VARCHAR(45) NULL,
	`blood_pressure` VARCHAR(45) NULL,
	`height` VARCHAR(45) NULL,
	`weight` VARCHAR(45) NULL,
	`temperature` VARCHAR(45) NULL,
	`time` TIMESTAMP NULL,
PRIMARY KEY (`id`));