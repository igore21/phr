insert into user (first_name, file_id, last_name, email, password, role, active) values
('Igor', null, 'Eric', 'ie@gmail.com', '123', 2, 1),
('Uros', null, 'Eric', 'ue@gmail.com', '456', 2, 1),
('Nikola', 12345, 'Sutic', 'nik@gmail.com', '789', 1, 1);

insert into assignment (pacient_id, doctor_id, start_time, end_time, name, description)
values (3, 2, '2015-07-12', '2015-07-19', 'plasticna operacija', 'ugradjivanje silikona');