CREATE DATABASE audioScripter_db;
USE audioScripter_db;
CREATE TABLE script(
    id MEDIUMINT NOT NULL AUTO_INCREMENT,
    describtion VARCHAR(255),
    script TEXT,
    date_added DATETIME NOT NULL,
    PRIMARY KEY (id)
);
INSERT INTO script(describtion, script, date_added) VALUES ('some random audio', "generated text from AI model", now());