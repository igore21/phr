SET FOREIGN_KEY_CHECKS=0;
truncate user;
truncate assignment;
truncate assignment_parameter;
truncate data;
SET FOREIGN_KEY_CHECKS=1;

insert into user (id, first_name, file_id, last_name, email, password, role, active) values
	(1,'Igor', null, 'Eric', 'ie@gmail.com', '123', 2, 1),
	(2, 'Uros', null, 'Eric', 'ue@gmail.com', '123', 2, 1),
	(3, 'Nikola', 103, 'Sutic', 'ns@gmail.com', '123', 1, 1),
	(4, 'Nikola', 104, 'Nikolic', 'nn@gmail.com', '123', 1, 1),
	(5, 'Nikola', 105, 'Petrovic', 'np@gmail.com', '123', 1, 1),
	(6,'Petar', 106, 'Petrovic', 'pp@gmail.com', '123', 1, 1),
	(7, 'Petar', 107, 'Markovic', 'pm@gmail.com', '123', 1, 1),
	(8, 'Stevan', 108, 'Simic', 'ss@gmail.com', '123', 1, 1),
	(9, 'Stevan', 109, 'Sremac', 'ss2@gmail.com', '123', 1, 1),
	(10, 'Goran', 110, 'Petrovic', 'gp@gmail.com', '123', 1, 1),
	(11, 'Mihajlo', 111, 'Pantic', 'mp@gmail.com', '123', 1, 1),
	(12, 'Dragan', 112, 'Jovanovic', 'dj@gmail.com', '123', 1, 1),
	(13, 'Jovan', 113, 'Jovanovic', 'jj@gmail.com', '123', 1, 1),
	(14, 'Ivan', 114, 'Kokeric', 'ik@gmail.com', '123', 1, 1);

insert into assignment (id, doctor_id, patient_id, start_time, end_time, name, description) values
	(1, 1, 3, '2015-09-01', '2015-12-01', 'Cesta malaksalost', 'Pacijent se zali na cestu malaksalost');
insert into assignment_parameter (assignment_id, parameter_id, execute_after, time_unit, comment) values
	(1, 4, 12, 1, 'Meriti temperaturu ujutru i uvece.');

insert into assignment (id, doctor_id, patient_id, start_time, end_time, name, description) values
	(2, 1, 3, '2015-09-12', '2015-09-29', 'Grip', 'Curenje nosa, kasalj - uzimati antibiotike');
insert into assignment_parameter (assignment_id, parameter_id, execute_after, time_unit, comment) values
	(2, 1, 8, 1, 'Piti ferveks na 8 sati.'),
	(2, 4, 12, 1, 'Meriti temperaturu ujutru i uvece.');

insert into assignment (id, doctor_id, patient_id, start_time, end_time, name, description) values
	(3, 2, 3, '2015-07-20', '2015-08-10', 'Stomacni virus', '');
insert into assignment_parameter (assignment_id, parameter_id, execute_after, time_unit, comment) values
	(3, 11, 8, 1, 'Upisati osecaj mucnine posle svakog obroka ');

insert into assignment (id, doctor_id, patient_id, start_time, end_time, name, description) values
	(4, 1, 6, '2015-09-05', '2015-09-25', 'Nesanica', 'Pacijent se zali na cestu nesanicu');
insert into assignment_parameter (assignment_id, parameter_id, execute_after, time_unit, comment) values
	(4, 8, 1, 2, 'Svako jutro opisite koliko ste dugo spavali.');
	
insert into assignment (id, doctor_id, patient_id, start_time, end_time, name, description) values
	(5, 1, 8, '2015-08-01', '2015-08-25', 'Upala sinusa', 'Zapaljenje grla, piti cajeve i uzmati defrinol');
insert into assignment_parameter (assignment_id, parameter_id, execute_after, time_unit, comment) values
	(5, 1, 8, 1, 'Defrinol 3 puta dnevno posle obroka.');


