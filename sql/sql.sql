CREATE TABLE servers (
  id INT(10) NOT NULL AUTO_INCREMENT,
  name VARCHAR(30) NULL DEFAULT NULL,
  ip VARCHAR(30) NOT NULL,
  user VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL,
  port VARCHAR(10) NOT NULL,
  key_path VARCHAR(50) NOT NULL,
  key_passphrase VARCHAR(30) NOT NULL,
  ignore_server INT(1) NOT NULL DEFAULT '0',
  use_rsa INT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
)
  COLLATE='utf8_unicode_ci'
  ENGINE=InnoDB
;

CREATE TABLE config (
	id INT(10) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(35) NOT NULL,
	description VARCHAR(100) NOT NULL,
	parameter VARCHAR(35),
	PRIMARY KEY(id)
)
  COLLATE='utf8_unicode_ci'
  ENGINE=InnoDB
;

INSERT INTO config (name, description, parameter) VALUES ('STOP_ON_ERROR', 'Stops the execution when it catches an error', 1);
INSERT INTO config (name, description, parameter) VALUES ('IGNORE_SERVER_AFTER_CMD', 'Sets "ignore_server" column to 1 after command execution', 1);