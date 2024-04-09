/*****************************************
 * Created by Josh Derr
 * Use to create the Scrum Project database
*****************************************/
DROP DATABASE IF EXISTS ACMEMedical;

CREATE DATABASE IF NOT EXISTS ACMEMedical;

USE ACMEMedical;

CREATE TABLE patients (
	patient_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	patient_first_name VARCHAR(100) NOT NULL,
	patient_last_name VARCHAR(100) NOT NULL,
	gender CHAR(20) NOT NULL CHECK (gender IN ("Male", "Female", "Other; Prefer not to answer")),
	birthdate DATE NOT NULL,
	genetics VARCHAR(255) NOT NULL,
	diabetes CHAR(3) NOT NULL CHECK (diabetes IN ("Yes", "No")), 
	other_conditions VARCHAR(255) NOT NULL, 
	PRIMARY KEY (patient_id)
);

/*
CREATE TABLE patient_medications (
	patient_medication_id INT AUTO_INCREMENT NOT NULL,
	vest CHAR(3) NOT NULL CHECK (vest IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	acapella CHAR(3) NOT NULL CHECK (acapella IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	plumozyme CHAR(3) NOT NULL CHECK (plumozyme IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	plumozyme_quantity INT,
	plumozyme_date DATE,
	inhaled_tobi CHAR(3) NOT NULL CHECK (inhaled_tobi IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	inhaled_colistin CHAR(3) NOT NULL CHECK (inhaled_colistin IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	hypertonic_saline VARCHAR(6) NOT NULL CHECK (hypertonic_saline IN ("Yes 3%", "Yes 7%", "No")),
	azithromycin CHAR(3) NOT NULL CHECK (azithromycin IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	clarithromycin CHAR(3) NOT NULL CHECK (clarithromycin IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	inhaled_gentamicin CHAR(3) NOT NULL CHECK (inhaled_gentamicin IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	enzymes CHAR(3) NOT NULL CHECK (enzymes IN ("Yes", "No", "yes", "no", "Y", "N", "y", "n")),
	enzymes_type VARCHAR(255),
	patient_id INT(255) NOT NULL,
	PRIMARY KEY (patient_medication_id),
	CONSTRAINT patient_medication_FK FOREIGN KEY (patient_id) REFERENCES patients (patient_id)
);
*/

CREATE TABLE doctors (
	doctor_id INT AUTO_INCREMENT NOT NULL,
	doctor_first_name VARCHAR(100) NOT NULL,
	doctor_last_name VARCHAR(100) NOT NULL,
	doctor_specialty VARCHAR(255) NOT NULL,
	PRIMARY KEY (doctor_id)
);

INSERT INTO doctors (doctor_first_name, doctor_last_name, doctor_specialty) VALUES 
	('Evelyn', 'Hart', 'Cardiology'),
	('Marcus', 'Stone', 'Neurology'),
	('Clara', 'Winston', 'Dermatology'),
	('Julian', 'Vega', 'Orthopedics'),
	('Sophia', 'Chang', 'Pediatrics'),
	('Lucas', 'Greene', 'Endocrinology'),
	('Amelia', 'Bishop', 'Oncology'),
	('Theo', 'Murray', 'Gastroenterology'),
	('Lily', 'Foster', 'Rheumatology'),
	('Nathan', 'Daniels', 'Psychiatry');

CREATE TABLE medications (
	medication_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	medication_name VARCHAR(100) NOT NULL,
	medication_type VARCHAR(255) NOT NULL,
	medication_dosage VARCHAR(255),
	medication_quantity VARCHAR(255), 
	PRIMARY KEY (medication_id)
);

/*
Insert into medications (medication_name, medication_type) values
	('Vest'),
	('Acapella'),
	('Plumozyme'),
	('Inhaled Tobi'),
	('Inhaled Colistin'),
	('Hypertonic Saline'),
	('Azithromycin'),
	('Clarithromycin'),
	('Inhaled Gentamicin'),
	('Enzymes');
*/

CREATE TABLE prescriptions (
	prescription_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	medication_id INT NOT NULL,
	patient_id INT NOT NULL,
	PRIMARY KEY (prescription_id),
	CONSTRAINT prescription_FK1 FOREIGN KEY (medication_id) REFERENCES medications (medication_id),
	CONSTRAINT prescription_FK2 FOREIGN KEY (patient_id) REFERENCES patients (patient_id)
);

CREATE TABLE visits (
	visit_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	doctor_id INT NOT NULL,
	patient_id INT NOT NULL,
	prescription_id INT NOT NULL,
	date_of_visit DATE NOT NULL,
	PRIMARY KEY (visit_id),
	CONSTRAINT visit_FK1 FOREIGN KEY (doctor_id) REFERENCES doctors (doctor_id),
	CONSTRAINT visit_FK2 FOREIGN KEY (patient_id) REFERENCES patients (patient_id),
	CONSTRAINT visit_FK3 FOREIGN KEY (prescription_id) REFERENCES prescriptions (prescription_id)
);

CREATE TABLE fev1s (
	fev1_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	visit_id INT NOT NULL,
	fev1_value VARCHAR(255) NOT NULL,
	PRIMARY KEY (fev1_id),
	CONSTRAINT fev1_FK1 FOREIGN KEY (visit_id) REFERENCES visits (visit_id)
);

CREATE USER IF NOT EXISTS "kermit"@"localhost" IDENTIFIED BY "sesame";