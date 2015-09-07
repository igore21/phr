SET FOREIGN_KEY_CHECKS=0;
truncate user;
truncate assignment;
truncate assignment_parameter;
SET FOREIGN_KEY_CHECKS=1;

insert into user (id, first_name, file_id, last_name, email, password, role, active) values
	(1,'Igor', null, 'Eric', 'ie@gmail.com', '123', 2, 1),
	(2, 'Uros', null, 'Eric', 'ue@gmail.com', '123', 2, 1),
	(3, 'Nikola', 1234, 'Sutic', 'ns@gmail.com', '111', 1, 1),
	(4, 'Nikola', 1212, 'Nikolic', 'nn@gmail.com', '111', 1, 1),
	(5, 'Nikola', 1313, 'Petrovic', 'np@gmail.com', '111', 1, 1),
	(6,'Petar', 1112, 'Petrovic', 'pp@gmail.com', '111', 1, 1),
	(7, 'Petar', 1414, 'Markovic', 'pm@gmail.com', '111', 1, 1),
	(8, 'Stevan', 1515, 'Simic', 'ss@gmail.com', '111', 1, 1),
	(9, 'Stevan', 1616, 'Sremac', 'ss2@gmail.com', '111', 1, 1),
	(10, 'Goran', 1717, 'Petrovic', 'gp@gmail.com', '111', 1, 1),
	(11, 'Mihajlo', 1818, 'Pantic', 'mp@gmail.com', '111', 1, 1),
	(12, 'Dragan', 2020, 'Jovanovic', 'dj@gmail.com', '111', 1, 1),
	(13, 'Jovan', 2121, 'Jovanovic', 'jj@gmail.com', '111', 1, 1),
	(14, 'Ivan', 2222, 'Kokeric', 'ik@gmail.com', '111', 1, 1);

insert into assignment (id, patient_id, doctor_id, start_time, end_time, name, description) values
	(1,3, 1, '2015-09-12', '2015-09-19', 'lecenje gripa', 'terapija antibioticima'),
	(2, 4, 1, '2015-09-12', '2015-09-29', '', ''),
	(3, 5, 2, '2015-08-12', '2015-08-28', 'lecenje stomacnog virusa', ''),
	(4, 6, 2, '2015-07-12', '2015-07-19', 'lecenje gnojeve angine', 'terapija inekcijama'),
	(5, 7, 2, '2015-07-12', '2015-07-21', 'lecenje stomacnog virusa', ''),
	(6, 7, 1, '2015-09-12', '2015-09-30', 'lecenje upale uva', 'terapija inekcijama'),
	(7, 7, 2, '2015-09-01', '2015-09-22', 'lecenje gripa', 'terapija antibioticima'),
	(8, 8, 2, '2015-10-12', '2015-10-19', 'lecenje gnojeve angine', 'terapija inekcijama'),
	(9, 9, 1, '2015-08-12', '2015-09-19', '', ''),
	(10, 9, 2, '2015-09-07', '2015-09-21', 'lecenje upale uva', 'terapija inekcijama'),
	(11, 10, 2, '2015-11-12', '2015-11-19', '', ''),
	(12, 11, 1, '2015-11-01', '2015-11-21', '', ''),
	(13, 11, 2, '2015-11-01', '2015-11-15', 'lecenje stomacnog virusa', ''),
	(14, 12, 2, '2015-11-10', '2015-11-24', 'lecenje upale uva', 'terapija inekcijama');

INSERT INTO assignment_parameter (assignment_id, parameter_id) values
(1, 4), (1, 10),
(2, 1), (2, 5),
(3, 2), (3, 10), (3, 3),
(4, 2), (4, 10), (4, 8),
(5, 2), (5, 10), (5, 3),
(6, 4), (6, 3), (6, 8),
(7, 4), (7, 10),
(8, 4), (8, 10), (8, 8),
(9, 1), (9, 5), (9, 9),
(10, 4), (10, 3), (10, 8),
(11, 6), (11, 7), (11, 9),
(12, 2), (12, 3), (12, 7), (12, 9),
(13, 2), (13, 10), (13, 3),
(14, 4), (14, 3), (14, 8);

