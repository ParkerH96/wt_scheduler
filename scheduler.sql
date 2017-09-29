/*
  Wildcat Technology Group: Scheduler
  Author: Parker Householder

  Description: **DUMP FILE** This file contains the main MySQL code used to create the
  database used for the wildcat scheduler

*/

DROP DATABASE IF EXISTS wt_scheduler;
CREATE DATABASE wt_scheduler;

USE wt_scheduler;

DROP TABLE IF EXISTS EMPLOYEE;
CREATE TABLE EMPLOYEE
(
  employee_id int NOT NULL AUTO_INCREMENT,
  admin_tag int NOT NULL,
  first_name varchar(64) NOT NULL,
  last_name varchar(64) NOT NULL,
  email varchar(128) NOT NULL,
  phone_number varchar(16) NOT NULL,
  dob date NOT NULL,
  username varchar(64) NOT NULL,
  password varchar(64) NOT NULL,
  color varchar(16) NOT NULL,
  PRIMARY KEY (employee_id)
);

DROP TABLE IF EXISTS SHIFT;
CREATE TABLE SHIFT
(
  shift_id int NOT NULL AUTO_INCREMENT,
  employee_id int NOT NULL,
  shift_date date NOT NULL,
  start_time time NOT NULL,
  end_time time NOT NULL,
  PRIMARY KEY (shift_id),
  FOREIGN KEY (employee_id) REFERENCES EMPLOYEE(employee_id)
);

DROP TABLE IF EXISTS TRADE_SHIFTS;
CREATE TABLE TRADE_SHIFTS
(
  traded_by int NOT NULL,
  shift_traded_by int NOT NULL,
  traded_to int NOT NULL,
  shift_traded_to int NOT NULL,
  trade_status int NOT NULL,
  FOREIGN KEY (traded_by) REFERENCES EMPLOYEE(employee_id),
  FOREIGN KEY (shift_traded_by) REFERENCES SHIFT(shift_id),
  FOREIGN KEY (traded_to) REFERENCES EMPLOYEE(employee_id),
  FOREIGN KEY (shift_traded_to) REFERENCES SHIFT(shift_id)
);

INSERT INTO EMPLOYEE(admin_tag, first_name, last_name, email, phone_number, dob, username, password, color) VALUES
(1, 'Parker', 'Householder', 'paho224@g.uky.edu', '8593589125', '1996-05-01', 'paho224', 'wildcattech1', '#3bc19d'),
(1, 'Zack', 'Arnett', 'arnett.zackary@gmail.com', '8590849392', '1996-06-03', 'zsar222', 'UKengineer14!', '#5f62e7'),
(0, 'Lacy', 'May', 'asdf', 'asdf', '2017-09-13', 'LAcy', 'MAy', '#ef4354'),
(0, 'Madison', 'Bartlett', 'madison@gmail.com', '630654321', '2017-09-08', 'maddog', 'maddog', '#4daede'),
(0, 'Evan', 'Heaton', 'asdf', 'asdf', '2017-09-06', 'aad', 'asdf', '#deac4d'),
(0, 'Robert', 'Cala', 'asd', 'asdf', '2017-09-12', 'adsf', 'asdf', '#784dde'),
(0, 'David', 'Cottrell', 'adf', 'asdf', '2017-09-20', 'adsf', 'adf', '#de4d7b'),
(0, 'Zachary', 'Moore', 'alkjsd', 'dfg', '2017-09-06', 'asd', 'asd', '#4ddea3'),
(0, 'Brian', 'Luciano', 'asdf', 'asdf', '2017-09-20', 'asdf', 'asdf', '#ded44d'),
(0, 'Fox', 'Thorpe', 'adsf', 'asdf', '2017-09-20', 'ads', 'asdf', '#3a67bb'),
(0, 'Andrew', 'Jackson', 'Ardf', 'asdf', '2017-09-21', 'asdf', 'asdf', '#bb3a3a');

INSERT INTO SHIFT(employee_id, shift_date, start_time, end_time) VALUES
(1, '2017-09-13', '05:30:00', '07:30:00'),
(1, '2017-09-14', '04:00:00', '10:00:00'),
(1, '2017-09-15', '02:00:00', '06:00:00');
