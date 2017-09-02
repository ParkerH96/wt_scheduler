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
  color varchar(16) NOT NULL,
  PRIMARY KEY (shift_id),
  FOREIGN KEY (employee_id) REFERENCES EMPLOYEE(employee_id)
);

INSERT INTO EMPLOYEE(admin_tag, first_name, last_name, email, phone_number, dob, username, password) VALUES
(1, 'Parker', 'Householder', 'paho224@g.uky.edu', '8593589125', '1996-05-01', 'paho224', 'wildcattech1'),
(0, 'Zack', 'Arnett', 'zarnett@gmail.com', '8590849392', '1996-06-03', 'zsar221', 'wildcattech2');

INSERT INTO SHIFT(employee_id, shift_date, start_time, end_time, color) VALUES
(1, '2017-09-13', '05:30:00', '07:30:00', '#FF0000'),
(1, '2017-09-14', '04:00:00', '10:00:00', '#003A00'),
(1, '2017-09-15', '02:00:00', '06:00:00', '#47d1de');
