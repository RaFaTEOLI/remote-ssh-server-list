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
  COLLATE='latin1_swedish_ci'
  ENGINE=InnoDB
;

CREATE TABLE config (
  id INT(10) NOT NULL AUTO_INCREMENT,
  stop_on_error INT(1) NOT NULL DEFAULT '0',
  ignoreServer_afterCmd INT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
)
  COLLATE='latin1_swedish_ci'
  ENGINE=InnoDB
;

INSERT INTO config (stop_on_error, ignoreServer_afterCmd) VALUES (0, 0);