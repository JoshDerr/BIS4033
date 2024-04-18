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
	gender CHAR(6) NOT NULL CHECK (gender IN ("Male", "Female", "Other")),
	birthdate DATE NOT NULL,
	genetics VARCHAR(255),
	diabetes CHAR(3) NOT NULL CHECK (diabetes IN ("Yes", "No")), 
	other_conditions VARCHAR(255), 
	PRIMARY KEY (patient_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO patients (patient_first_name, patient_last_name, gender, birthdate, genetics, diabetes, other_conditions) VALUES 
	("Ryan", "Gosling", "Male", "1980-09-12", "Blue Eyes", "No", "Depression from never being Kenough"),
	("Emma", "Watson", "Female", "1990-04-15", "Brown Hair", "No", NULL),
	("Chris", "Evans", "Male", "1981-06-13", NULL, "No", NULL),
	("Sophia", "Loren", "Female", "1934-09-20", NULL, "Yes", "Hypertension"),
	("Alexander", "Skarsgard", "Other", "1976-08-25", "Tall", "No", NULL),
	("Mila", "Kunis", "Female", "1983-08-14", NULL, "Yes", "Allergies to nuts"),
	("Liam", "Hemsworth", "Other", "1990-01-13", "Athletic Build", "Yes", NULL),
	("Zoe", "Saldana", "Female", "1978-06-19", NULL, "No", NULL),
	("Jennifer", "Lawrence", "Female", "1990-08-15", "Blonde Hair", "No", NULL),
	("Tom", "Holland", "Male", "1996-06-01", "British Heritage", "No", "Asthma");

CREATE TABLE doctors (
	doctor_id INT AUTO_INCREMENT NOT NULL,
	doctor_first_name VARCHAR(100) NOT NULL,
	doctor_last_name VARCHAR(100) NOT NULL,
	doctor_specialty VARCHAR(255) NOT NULL,
	PRIMARY KEY (doctor_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO doctors (doctor_first_name, doctor_last_name, doctor_specialty) VALUES 
	("Evelyn", "Hart", "Cardiology"),
	("Marcus", "Stone", "Neurology"),
	("Clara", "Winston", "Dermatology"),
	("Julian", "Vega", "Orthopedics"),
	("Sophia", "Chang", "Pediatrics"),
	("Lucas", "Greene", "Endocrinology"),
	("Amelia", "Bishop", "Oncology"),
	("Theo", "Murray", "Gastroenterology"),
	("Lily", "Foster", "Rheumatology"),
	("Nathan", "Daniels", "Psychiatry");

CREATE TABLE medications (
	medication_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	medication_name VARCHAR(100) NOT NULL,
	medication_type VARCHAR(255),
	medication_dosage VARCHAR(255) NOT NULL,
	medication_quantity INT NOT NULL,
	medication_frequency CHAR(3) CHECK (medication_frequency IN ("QD", "BID", "TID", "QHS", "N/A")), 
	PRIMARY KEY (medication_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO medications (medication_name, medication_type, medication_dosage, medication_quantity, medication_frequency) VALUES
	("Vest", "Therapeutic Device", "N/A", 1, NULL),  
	("Acapella", "Respiratory Device", "N/A", 1, "BID"),
	("Pulmozyme", "Enzyme Replacement", "2.5mg", 30, "QD"),
	("Inhaled Tobi", "Antibiotic", "300mg", 56, "BID"),
	("Inhaled Colistin", "Antibiotic", "1 million IU", 60, "BID"),
	("Hypertonic Saline", "Solution", "3% solution", 30, "BID"),
	("Hypertonic Saline", "Solution", "7% solution", 30, "BID"),
	("Azithromycin", "Antibiotic", "250mg", 30, "QD"),
	("Clarithromycin", "Antibiotic", "500mg", 14, "BID"),
	("Inhaled Gentamicin", "Antibiotic", "80mg", 30, "BID"),
	("Enzymes", "Digestive Aid", "N/A", 90, NULL);

CREATE TABLE visits (
	visit_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	doctor_id INT NOT NULL,
	patient_id INT NOT NULL,
	date_of_visit DATE NOT NULL,
	PRIMARY KEY (visit_id),
	CONSTRAINT visit_FK1 FOREIGN KEY (doctor_id) REFERENCES doctors (doctor_id),
	CONSTRAINT visit_FK2 FOREIGN KEY (patient_id) REFERENCES patients (patient_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO visits (doctor_id, patient_id, date_of_visit) VALUES
	(3, 5, "2024-04-01"),
	(7, 2, "2023-11-21"),
	(1, 4, "2024-02-07"),
	(6, 3, "2023-08-18"),
	(8, 8, "2023-12-29"),
	(2, 1, "2024-01-13"),
	(9, 9, "2024-03-09"),
	(4, 4, "2023-09-23"),
	(5, 6, "2023-06-17"),
	(10, 7, "2024-04-12"),
	(6, 10, "2023-04-28");

CREATE TABLE prescriptions (
	prescription_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	medication_id INT NOT NULL,
	visit_id INT NOT NULL,
	prescription_lot_num VARCHAR(100) NOT NULL,
	prescription_expiration_date DATE NOT NULL,
	PRIMARY KEY (prescription_id),
	CONSTRAINT prescription_FK1 FOREIGN KEY (medication_id) REFERENCES medications (medication_id),
	CONSTRAINT prescription_FK2 FOREIGN KEY (visit_id) REFERENCES visits (visit_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO prescriptions (medication_id, visit_id, prescription_lot_num, prescription_expiration_date) VALUES
	(6, 5, "RX2023M0415I", "2026-02-24"),
	(9, 9, "RX2023M0415D", "2025-12-17"),
	(2, 1, "RX2023M0415G", "2024-09-02"),
	(3, 2, "RX2023M0415A", "2025-04-09"),
	(1, 11, "RX2023M0415H", "2025-10-16"),
	(8, 8, "RX2023M0415K", "2024-05-07"),
	(10, 10, "RX2023M0415C", "2026-07-25"),
	(7, 6, "RX2023M0415F", "2025-11-20"),
	(9, 3, "RX2023M0415E", "2026-02-01"),
	(11, 4, "RX2023M0415B", "2024-08-14"),
	(4, 7, "RX2023M0415J", "2024-06-26");

CREATE TABLE fev1s (
	fev1_id INT AUTO_INCREMENT NOT NULL UNIQUE,
	visit_id INT NOT NULL,
	fev1_value VARCHAR(255) NOT NULL,
	PRIMARY KEY (fev1_id),
	CONSTRAINT fev1_FK1 FOREIGN KEY (visit_id) REFERENCES visits (visit_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE USER IF NOT EXISTS "kermit"@"localhost" IDENTIFIED BY "sesame";