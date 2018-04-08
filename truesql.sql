
alter session set NLS_LANGUAGE = 'RUSSIAN';

CREATE TABLE inikitin.radioelements (
  rad_id NUMBER NOT NULL,
  rad_nom VARCHAR2(64),
  rad_type VARCHAR2(64),
  rad_ope_id INTEGER NOT NULL,
  RAD_PCB_ID INTEGER NOT NULL
) TABLESPACE "USERS";

COMMENT ON TABLE radioelements IS 'Элементы';
COMMENT ON COLUMN radioelements.rad_id IS 'Номер записи';
COMMENT ON COLUMN radioelements.rad_type IS 'Название элементы';
COMMENT ON COLUMN radioelements.rad_nom IS 'Тип элемента';
COMMENT ON COLUMN radioelements.rad_ope_id IS 'Операции с элементом';
COMMENT ON COLUMN radioelements.RAD_PCB_ID IS 'Платы с элементом';

CREATE TABLE inikitin.pcb (
  pcb_id NUMBER NOT NULL,
  pcb_size VARCHAR2(64),
  pcb_mat VARCHAR2(64),
  pcb_class INTEGER,
  pcb_vend VARCHAR2(64)
) TABLESPACE "USERS";

COMMENT ON TABLE pcb IS 'Печатная плата';
COMMENT ON COLUMN pcb.pcb_id IS 'Номер записи';
COMMENT ON COLUMN pcb.pcb_size IS 'Размер платы';
COMMENT ON COLUMN pcb.pcb_mat IS 'Материал платы';
COMMENT ON COLUMN pcb.pcb_class IS 'Класс точности платы';
COMMENT ON COLUMN pcb.pcb_vend IS 'Поставщик плат';

CREATE TABLE inikitin.facility (
  fac_id NUMBER NOT NULL,
  fac_name VARCHAR2(20),
  fac_desc VARCHAR2(250),
  fac_pers_id INTEGER,
  fac_oper_id INTEGER
) TABLESPACE "USERS";

COMMENT ON TABLE FACILITY IS 'Отдел';
COMMENT ON COLUMN FACILITY.fac_id IS 'Номер записи';
COMMENT ON COLUMN FACILITY.fac_name IS 'Название отдела';
COMMENT ON COLUMN FACILITY.fac_desc IS 'Описание отдела';
COMMENT ON COLUMN FACILITY.fac_pers_id IS 'Персонал, работающий в этом отделе';
COMMENT ON COLUMN FACILITY.fac_oper_id IS 'Операции, выполняемые в этом отделе';

CREATE TABLE inikitin.operation (
  oper_id INTEGER NOT NULL,
  oper_name VARCHAR2(20),
  oper_time INTEGER,
  oper_util_id INTEGER,
  oper_board_id INTEGER
) TABLESPACE "USERS";

COMMENT ON TABLE OPERATION IS 'Операции';
COMMENT ON COLUMN OPERATION.oper_id IS 'Номер записи';
COMMENT ON COLUMN OPERATION.oper_name IS 'Название операции';
COMMENT ON COLUMN OPERATION.oper_time IS 'Время выполнения операции';
COMMENT ON COLUMN OPERATION.oper_util_id IS 'Оснастка, используемая в этой операции';
COMMENT ON COLUMN OPERATION.oper_board_id IS 'Платы, над которыми выполняются эти операции';

CREATE TABLE inikitin.personal (
  pers_id INTEGER NOT NULL,
  pers_last_name VARCHAR2(20),
  pers_first_name VARCHAR2(20),
  pers_middle_name VARCHAR2(24),
  pers_job VARCHAR2(20),
  pers_login VARCHAR2(20),
  pers_pass VARCHAR2(20),
  pers_type VARCHAR2 (20)
) TABLESPACE "USERS";

COMMENT ON TABLE PERSONAL IS 'Персонал';
COMMENT ON COLUMN PERSONAL.pers_id IS 'Номер записи';
COMMENT ON COLUMN PERSONAL.pers_first_name IS 'Имя';
COMMENT ON COLUMN PERSONAL.pers_last_name IS 'Фамилия';
COMMENT ON COLUMN PERSONAL.pers_middle_name IS 'Отчество';
COMMENT ON COLUMN PERSONAL.pers_job IS 'Должность';
COMMENT ON COLUMN PERSONAL.pers_login IS 'Логин';
COMMENT ON COLUMN PERSONAL.pers_pass IS 'Пароль';
COMMENT ON COLUMN PERSONAL.pers_type IS 'Тип пользователя';

CREATE TABLE inikitin.utility (
  util_id INTEGER NOT NULL,
  util_name VARCHAR2(25),
  util_type VARCHAR2(25),
  util_amount INTEGER
) TABLESPACE "USERS";

COMMENT ON TABLE UTILITY IS 'Оснастки';
COMMENT ON COLUMN UTILITY.util_id IS 'Номер записи';
COMMENT ON COLUMN UTILITY.util_name IS 'Название остнастки';
COMMENT ON COLUMN UTILITY.util_type IS 'Тип оснастки';
COMMENT ON COLUMN UTILITY.util_amount IS 'Стоимость оснастки';

ALTER	TABLE	inikitin.pcb	ADD	(	CONSTRAINT
  board_id_PK
PRIMARY KEY (pcb_id) VALIDATE );

ALTER TABLE inikitin.radioelements ADD ( CONSTRAINT el_id_PK PRIMARY KEY (rad_id) VALIDATE );

ALTER TABLE inikitin.facility ADD ( CONSTRAINT fac_id_PK PRIMARY KEY (fac_id) VALIDATE );

ALTER TABLE inikitin.operation ADD ( CONSTRAINT oper_id_PK PRIMARY KEY (oper_id) VALIDATE );

ALTER TABLE inikitin.personal ADD ( CONSTRAINT pers_id_PK PRIMARY KEY (pers_id) VALIDATE );

ALTER TABLE inikitin.utility ADD ( CONSTRAINT util_id_PK PRIMARY KEY (util_id) VALIDATE );

ALTER TABLE inikitin.radioelements ADD ( CONSTRAINT rad_el_id_FK FOREIGN KEY (rad_ope_id) REFERENCES inikitin.operation (oper_id) VALIDATE );
ALTER TABLE inikitin.radioelements ADD ( CONSTRAINT rad_pcb_id_FK FOREIGN KEY (RAD_PCB_ID) REFERENCES inikitin.operation (oper_id) VALIDATE );

ALTER TABLE inikitin.facility ADD ( CONSTRAINT fac_pers_id_FK FOREIGN KEY (fac_pers_id) REFERENCES inikitin.personal (pers_id) VALIDATE );

ALTER TABLE inikitin.facility ADD ( CONSTRAINT fac_oper_id_FK FOREIGN KEY (fac_oper_id) REFERENCES inikitin.operation (oper_id) VALIDATE );

ALTER TABLE inikitin.operation ADD ( CONSTRAINT oper_util_id_FK FOREIGN KEY (oper_util_id) REFERENCES inikitin.utility (util_id) VALIDATE );

ALTER TABLE inikitin.operation ADD ( CONSTRAINT oper_board_id_FK FOREIGN KEY (oper_board_id) REFERENCES inikitin.board (board_id) VALIDATE );

ALTER TABLE inikitin.personal ADD ( CONSTRAINT pers_login_UQ UNIQUE (pers_login) VALIDATE );

INSERT INTO personal(pers_id, pers_first_name, pers_last_name, pers_middle_name, pers_job, pers_login, pers_pass, pers_type)
      VALUES (1, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin');

INSERT INTO personal(pers_id, pers_first_name, pers_last_name, pers_middle_name, pers_job, pers_login, pers_pass, pers_type)
    VALUES (2, 'guest','guest', 'guest', 'guest', 'guest', 'guest', 'guest');
