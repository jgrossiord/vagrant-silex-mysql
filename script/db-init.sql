CREATE DATABASE IF NOT EXISTS silex;
USE silex;
DROP PROCEDURE IF EXISTS Init;

DELIMITER //

CREATE PROCEDURE Init()

BEGIN
    DECLARE USER_EXISTS, TABLE_POPULATED integer;
    CREATE TABLE IF NOT EXISTS silex.users  (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, firstname char(50), lastname char(50));

    SET USER_EXISTS = (SELECT 1 FROM mysql.user WHERE User = 'silex' AND Host = '%');
    SET TABLE_POPULATED = (SELECT count(*) FROM silex.users);

    IF USER_EXISTS IS NULL THEN 
        CREATE USER 'silex'@'%' IDENTIFIED BY 'silex';
        GRANT SELECT,INSERT,UPDATE,DELETE ON silex.* TO 'silex'@'%';
    END IF;


    IF TABLE_POPULATED = 0 THEN
        INSERT INTO silex.users (firstname, lastname) VALUES ('Harrison', 'Ford') , ('Georges', 'Clooney'), ('Julia', 'Roberts');
    END IF;

END //
DELIMITER ;

CALL Init;
DROP PROCEDURE IF EXISTS Init;

#UPDATE mysql.user SET Password=PASSWORD('root') WHERE User='root';
DELETE FROM mysql.user WHERE User='';
DROP DATABASE IF EXISTS test;
DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';
FLUSH PRIVILEGES;
