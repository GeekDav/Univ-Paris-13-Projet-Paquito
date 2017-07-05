CREATE DATABASE IF NOT EXISTS epitelio_store;
USE epitelio_store;

CREATE TABLE IF NOT EXISTS `queue` (
   `Git_link` VARCHAR(200) NOT NULL,
   `Name` VARCHAR(200) NOT NULL,
   CONSTRAINT PK_GIT_LINK PRIMARY KEY(`Git_link`)  
);

CREATE TABLE IF NOT EXISTS `followed_git` (
    `Git_link` VARCHAR(200) NOT NULL,
    `Name` VARCHAR(200) NOT NULL,
    `Dir` VARCHAR(200) NOT NULL,
    `Webhook_enable` BOOLEAN NOT NULL,
    `Include_YAML` BOOLEAN NOT NULL,
    CONSTRAINT PK_GIT_LINK PRIMARY KEY(`Git_link`)
);

INSERT INTO queue VALUES ('https://github.com/DamiX/paquito.git', 'Paquito');
INSERT INTO queue VALUES ('https://github.com/DamiX/Epitelio.git', 'Epitelio');

-- INSERT INTO followed_git VALUES ('https://github.com/DamiX/Epitelio/', 'Epitelio', false);
-- INSERT INTO followed_git VALUES ('https://github.com/DamiX/paquito/', 'Paquito', false);

-- CREATE VIEW IF NOT EXISTS `to_plan` SELECT `Git_link`, `Name` FROM `followed_git` WHERE `Webhook_enable` = true;