CREATE USER INIKITIN
IDENTIFIED BY INIKITIN
  DEFAULT TABLESPACE USERS
  ACCOUNT UNLOCK;

GRANT CONNECT TO INIKITIN;
GRANT DBA TO INIKITIN;

CREATE TABLE inikitin.element (
  el_id NUMBER NOT NULL,
  el_name VARCHAR2(20),
  el_type VARCHAR2(20),
  el_desc VARCHAR2(20),
  el_amount INTEGER
) TABLESPACE "USERS";

CREATE TABLE inikitin.board (
  board_id NUMBER NOT NULL,
  board_type VARCHAR2(20),
  board_ac INTEGER,
  board_el_id INTEGER
) TABLESPACE "USERS";

CREATE TABLE inikitin.facility (
  fac_id NUMBER NOT NULL,
  fac_name VARCHAR2(20),
  fac_desc VARCHAR2(250),
  fac_pers_id INTEGER,
  fac_oper_id INTEGER
) TABLESPACE "USERS";

CREATE TABLE inikitin.operation (
  oper_id INTEGER NOT NULL,
  oper_name VARCHAR2(20),
  oper_time DATE,
  oper_util_id INTEGER,
  oper_board_id INTEGER
) TABLESPACE "USERS";

CREATE TABLE inikitin.personal (
  pers_id INTEGER NOT NULL,
  pers_f VARCHAR2(20),
  pers_i VARCHAR2(20),
  pers_o VARCHAR2(20),
  pers_job VARCHAR2(20),
  pers_login VARCHAR2(20),
  pers_pass VARCHAR2(20),
  pers_type VARCHAR2 (20)
) TABLESPACE "USERS";

CREATE TABLE inikitin.utility (
  util_id INTEGER NOT NULL,
  util_name VARCHAR2(25),
  util_type VARCHAR2(25),
  util_amount INTEGER
) TABLESPACE "USERS";

ALTER	TABLE	inikitin.board	ADD	(	CONSTRAINT
  board_id_PK
PRIMARY KEY (board_id) VALIDATE );

ALTER TABLE inikitin.element ADD ( CONSTRAINT el_id_PK PRIMARY KEY (el_id) VALIDATE );

ALTER TABLE inikitin.facility ADD ( CONSTRAINT fac_id_PK PRIMARY KEY (fac_id) VALIDATE );

ALTER TABLE inikitin.operation ADD ( CONSTRAINT oper_id_PK PRIMARY KEY (oper_id) VALIDATE );

ALTER TABLE inikitin.personal ADD ( CONSTRAINT pers_id_PK PRIMARY KEY (pers_id) VALIDATE );

ALTER TABLE inikitin.utility ADD ( CONSTRAINT util_id_PK PRIMARY KEY (util_id) VALIDATE );

ALTER TABLE inikitin.board ADD ( CONSTRAINT board_el_id_FK FOREIGN KEY (board_el_id) REFERENCES inikitin.element (el_id) VALIDATE );

ALTER TABLE inikitin.facility ADD ( CONSTRAINT fac_pers_id_FK FOREIGN KEY (fac_pers_id) REFERENCES inikitin.personal (pers_id) VALIDATE );

ALTER TABLE inikitin.facility ADD ( CONSTRAINT fac_oper_id_FK FOREIGN KEY (fac_oper_id) REFERENCES inikitin.operation (oper_id) VALIDATE );

ALTER TABLE inikitin.operation ADD ( CONSTRAINT oper_util_id_FK FOREIGN KEY (oper_util_id) REFERENCES inikitin.utility (util_id) VALIDATE );

ALTER TABLE inikitin.operation ADD ( CONSTRAINT oper_board_id_FK FOREIGN KEY (oper_board_id) REFERENCES inikitin.board (board_id) VALIDATE );

ALTER TABLE inikitin.personal ADD ( CONSTRAINT pers_login_UQ UNIQUE (pers_login) VALIDATE );

INSERT INTO personal(pers_id, pers_f, pers_i, pers_o, pers_job, pers_login, pers_pass, pers_type)
      VALUES (1, admin, admin, admin, admin, admin, admin, admin);

INSERT INTO personal(pers_id, pers_f, pers_i, pers_o, pers_job, pers_login, pers_pass, pers_type)
      VALUES (2, guest, guest, guest, guest, guest, guest, guest);
