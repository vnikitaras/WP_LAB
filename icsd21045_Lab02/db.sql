DROP DATABASE IF EXISTS Football_Club;
CREATE DATABASE IF NOT EXISTS Football_Club;

USE Football_Club;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_role INT NOT NULL
    );

--Administrator  Owner  Manager   Player   Trainer  Caregiver
--     1           2       3         4        5         6