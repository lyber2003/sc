<?php

use Phinx\Migration\AbstractMigration;

class RebuildClientAll extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {

        $query =
            <<<'EOD'
drop table if EXISTS card CASCADE ;
drop table if EXISTS employment CASCADE ;
drop table if EXISTS financial CASCADE ;
drop table if EXISTS personal CASCADE ;
drop table if EXISTS address CASCADE ;
drop table if EXISTS phone CASCADE ;
drop table if EXISTS social CASCADE ;
drop table if EXISTS person2client;
drop table if EXISTS client CASCADE ;

drop table if EXISTS client_card CASCADE ;
drop table if EXISTS client_employment CASCADE ;
drop table if EXISTS client_financial CASCADE ;
drop table if EXISTS client_personal CASCADE ;
drop table if EXISTS client_address CASCADE ;
drop table if EXISTS client_phone CASCADE ;
drop table if EXISTS client_social CASCADE ;
drop table if EXISTS client_client CASCADE ;
drop table if EXISTS client_personal_familystatus;
drop table if EXISTS client_personal_gender;


delete from ref
where relname in ('card','employment','financial','personal','phone','social','person2client');

CREATE TABLE client
(
    id SERIAL PRIMARY KEY NOT NULL,
    email text not null,
    person_owner_id INTEGER,
    password TEXT,
    phone_id INTEGER ,
    card_id INTEGER,
    address_id INTEGER,
    personal_id INTEGER,
    employment_id INTEGER,
    financial_id INTEGER,
    social_id integer,
    state_id INTEGER DEFAULT state_id('core.client.new'::text),
    pasportscan_verified BOOLEAN DEFAULT false NOT NULL,
    maxamount DOUBLE PRECISION DEFAULT 2000,
    is_fraud BOOLEAN DEFAULT false,
    init_obj_id INTEGER DEFAULT class_id('core'::text),
    create_time TIMESTAMP DEFAULT now(),
    update_time TIMESTAMP
);
select create_class('core.client',null);
select create_state('core.client','deleted,new,blocked',null);
select ddl_history_tbl('client','recreate');


CREATE TABLE client_card
(
    id SERIAL PRIMARY KEY NOT NULL,
    client_id INTEGER not null REFERENCES client(id),
    is_verified BOOLEAN NOT NULL,
    is_primary BOOLEAN NOT NULL,
    was_verified BOOLEAN,
    numberencrypted TEXT,
    expiredate TIMESTAMP,
    owner TEXT,
    cvv TEXT,
    preauthsum decimal(8,2),
    paymenttoken TEXT,
    init_obj_id INTEGER REFERENCES obj(obj_id),
    binnumber TEXT,
    create_time TIMESTAMP,
    update_time TIMESTAMP
);
select ddl_history_tbl('client_card','recreate');
select create_class('core.client_card',null);

CREATE TABLE client_address
(
    id SERIAL PRIMARY KEY NOT NULL,
    location_ns_id INTEGER REFERENCES location_ns(id) check (is_settlement(location_ns_id)),
    street TEXT,
    house TEXT,
    apartment TEXT,
    postindex TEXT,
    lived_since TIMESTAMP,
    is_same_reg_location_ns_id INTEGER REFERENCES location_ns(id),
    is_same_reg_street TEXT,
    is_same_reg_house TEXT,
    is_same_reg_apartment TEXT,
    is_same_reg_postindex TEXT,
    is_same_reg_lived_since TIMESTAMP,
    is_history BOOLEAN DEFAULT false NOT NULL,
    init_obj_id INTEGER REFERENCES obj(obj_id),
    create_time TIMESTAMP DEFAULT now(),
    update_time TIMESTAMP
);
SELECT ddl_history_tbl('client_address', 'recreate');
SELECT create_class('core.client_address', NULL);
CREATE UNIQUE INDEX client_address_is_history_partial_unq ON client_address (id)
    WHERE is_history = FALSE;

CREATE TABLE client_financial
(
    id SERIAL PRIMARY KEY NOT NULL,
    loanfirstpaydate TIMESTAMP NOT NULL,
    monthlyincome DOUBLE PRECISION,
    monthlycost DOUBLE PRECISION NOT NULL,
    is_history BOOLEAN DEFAULT false NOT NULL,
    init_obj_id integer REFERENCES obj(obj_id),
    create_time TIMESTAMP DEFAULT now(),
    update_time TIMESTAMP
);
SELECT create_class('core.client_financial', NULL);
SELECT ddl_history_tbl('client_financial', 'recreate');
CREATE UNIQUE INDEX client_financial_is_history_partial_unq ON client_address (id)
    WHERE is_history = FALSE;

CREATE TABLE client_employment
(
    id SERIAL PRIMARY KEY NOT NULL,
    jobsworksince TIMESTAMP NOT NULL,
    type_id INTEGER,
    jobplace TEXT NOT NULL,
    is_history BOOLEAN DEFAULT false NOT NULL,
    init_obj_id integer REFERENCES obj(obj_id),
    create_time TIMESTAMP DEFAULT now(),
    update_time TIMESTAMP
);
SELECT create_class('core.client_financial', NULL);
SELECT ddl_history_tbl('client_financial', 'recreate');
CREATE UNIQUE INDEX client_employment_is_history_partial_unq ON client_employment (id)
    WHERE is_history = FALSE;

CREATE TABLE client_phone
(
    id INTEGER PRIMARY KEY NOT NULL,
    main TEXT,
    home TEXT,
    ext TEXT,
    work TEXT,
    lived TEXT,
    is_history BOOLEAN,
    init_obj_id integer REFERENCES obj(obj_id),
    create_time TIMESTAMP DEFAULT now(),
    update_time TIMESTAMP
);
SELECT create_class('core.client_phone', NULL);
SELECT ddl_history_tbl('client_phone', 'recreate');
CREATE UNIQUE INDEX client_phone_is_history_partial_unq ON client_phone (id)
    WHERE is_history = FALSE;

create table client_personal_familystatus
(
    id serial PRIMARY KEY,
    name text not null,
    descr text,
    init_obj_id integer REFERENCES obj(obj_id),
    create_time TIMESTAMP,
    update_time TIMESTAMP
);
SELECT create_class('core.client_personal_familystatus', NULL);
SELECT ddl_history_tbl('client_personal_familystatus', 'recreate');
insert into client_personal_familystatus (name,descr)
    SELECT 'married','Замужем/Женат'
    UNION ALL
    SELECT 'unmarried','Не замужем/Не женат';

CREATE UNIQUE INDEX client_personal_familystatus_name_unq ON client_personal_familystatus (name);


create table client_personal_gender
(
    id serial PRIMARY KEY,
    name text not null,
    descr text,
    init_obj_id integer REFERENCES obj(obj_id),
    create_time TIMESTAMP,
    update_time TIMESTAMP
);
SELECT create_class('core.client_personal_gender', NULL);
SELECT ddl_history_tbl('client_personal_gender', 'recreate');
CREATE UNIQUE INDEX client_personal_gender_name_unq ON client_personal_gender (name);
insert into client_personal_gender (name,descr)
    SELECT 'male','Мужчина'
    UNION ALL
    SELECT 'famale','Женщина';

CREATE TABLE client_personal
(
    id SERIAL PRIMARY KEY NOT NULL,
    pasport TEXT NOT NULL,
    birth TIMESTAMP NOT NULL,
    inn TEXT NOT NULL,
    familystatus_id INTEGER REFERENCES ref(obj_id),
    fname TEXT NOT NULL,
    mname TEXT NOT NULL,
    lname TEXT NOT NULL,
    gender_id INTEGER REFERENCES client_personal_familystatus(id),
    is_history BOOLEAN DEFAULT false NOT NULL,
    init_obj_id integer REFERENCES obj(obj_id),
    create_time TIMESTAMP DEFAULT now(),
    update_time TIMESTAMP
);
SELECT create_class('core.client_personal', NULL);
SELECT ddl_history_tbl('client_personal', 'recreate');
CREATE UNIQUE INDEX client_personal_is_history_partion_unq ON client_personal (id) where is_history = false;



ALTER TABLE client ADD FOREIGN KEY (phone_id) REFERENCES client_phone (id);
ALTER TABLE client ADD FOREIGN KEY (address_id) REFERENCES client_address (id);
ALTER TABLE client ADD FOREIGN KEY (personal_id) REFERENCES client_personal (id);
ALTER TABLE client ADD FOREIGN KEY (person_owner_id) REFERENCES person_ns (obj_id);
ALTER TABLE client ADD FOREIGN KEY (employment_id) REFERENCES client_employment (id);
ALTER TABLE client ADD FOREIGN KEY (financial_id) REFERENCES client_financial (id);
ALTER TABLE client ADD FOREIGN KEY (card_id) REFERENCES client_card (id);
ALTER TABLE client_card ADD FOREIGN KEY (client_id) REFERENCES client(id);
ALTER TABLE client ADD FOREIGN KEY (state_id) REFERENCES ref (obj_id);
ALTER TABLE client ADD FOREIGN KEY (init_obj_id) REFERENCES obj (obj_id);

drop table if EXISTS  application cascade ;

CREATE TABLE public.application (
  obj_id INTEGER PRIMARY KEY NOT NULL,
  client_id INTEGER NOT NULL REFERENCES obj(obj_id),
  state_id INTEGER REFERENCES ref(obj_id),
  ammount NUMERIC(8,2) NOT NULL,
  ammount_to_repay NUMERIC(8,2) NOT NULL,
  closed_loan INTEGER NOT NULL,
  term INTEGER NOT NULL,
  term_date_end TIMESTAMP WITHOUT TIME ZONE NOT NULL,
  address_id INTEGER not null REFERENCES client_address(id),
  purpose_id INTEGER,
  visitsource_id INTEGER,
  employment_id INTEGER not null REFERENCES client_employment(id),
  personal_id INTEGER not null REFERENCES client_personal(id),
  phone_id INTEGER not null REFERENCES client_phone(id),
  social_id INTEGER,
  financial_id INTEGER not null REFERENCES client_financial(id),
  ip INET NOT NULL,
  browser TEXT NOT NULL,
  bki_id INTEGER,
  device_id integer not null REFERENCES device(id),
  init_obj_id INTEGER REFERENCES obj(obj_id) DEFAULT class_id('core'::text),
  operator_id INTEGER REFERENCES person_ns(obj_id),
  create_time TIMESTAMP WITHOUT TIME ZONE DEFAULT now(),
  update_time TIMESTAMP WITHOUT TIME ZONE
);

ALTER TABLE scoringvectoritem ADD FOREIGN KEY (application_id) REFERENCES application(obj_id);

EOD;
        $count = $this->execute($query);







    }
}
