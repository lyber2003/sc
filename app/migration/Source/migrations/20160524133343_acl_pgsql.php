<?php

use Phinx\Migration\AbstractMigration;

class AclPgsql extends AbstractMigration
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
CREATE TABLE core_acl_role (
  id          INTEGER,
  name        TEXT NOT NULL,
  init_obj_id INTEGER REFERENCES obj (obj_id),
  description TEXT,
  create_time TIMESTAMP,
  update_time TIMESTAMP
);
SELECT create_class('core.core_acl_role');
SELECT ddl_history_tbl('core_acl_role', 'recreate');

INSERT INTO core_acl_role (id, name, description) VALUES
  (1, 'admin', NULL),
  (2, 'guest', NULL),
  (3, 'user', NULL);

CREATE TABLE core_acl_resource (
  id          INTEGER,
  name        TEXT NOT NULL,
  description TEXT,
  init_obj_id INTEGER REFERENCES obj (obj_id),
  create_time TIMESTAMP,
  update_time TIMESTAMP
);
SELECT create_class('core.core_acl_resource');
SELECT ddl_history_tbl('core_acl_resource', 'recreate');


INSERT INTO core_acl_resource (id, name, description) VALUES
  (1, 'admin_area', NULL),
  (2, '*', NULL);

CREATE TABLE core_acl_resource_access (
  id          INTEGER NOT NULL,
  resource_id INTEGER NOT NULL,
  name        TEXT    NOT NULL,
  init_obj_id INTEGER REFERENCES obj (obj_id),
  create_time TIMESTAMP,
  update_time TIMESTAMP
);
SELECT create_class('core.core_acl_resource_access');
SELECT ddl_history_tbl('core_acl_resource_access', 'recreate');

INSERT INTO core_acl_resource_access (id, resource_id, name) VALUES
  (1, 1, '*');


CREATE TABLE core_acl_access_list (
  id          INTEGER NOT NULL,
  role_id     INTEGER NOT NULL,
  resource_id INTEGER NOT NULL,
  access_id   INTEGER NOT NULL,
  allowed     INTEGER NOT NULL,
  init_obj_id INTEGER REFERENCES obj (obj_id),
  create_time TIMESTAMP,
  update_time TIMESTAMP
);
SELECT create_class('core.core_acl_resource_access');
SELECT ddl_history_tbl('core_acl_resource_access', 'recreate');


INSERT INTO core_acl_access_list (id, role_id, resource_id, access_id, allowed) VALUES
  (1, 1, 1, 1, 1);


CREATE TABLE core_acl_role_inherit (
  id              INTEGER NOT NULL,
  role_id         INTEGER NOT NULL,
  inherit_role_id INTEGER NOT NULL,
  init_obj_id     INTEGER REFERENCES obj (obj_id),
  create_time     TIMESTAMP,
  update_time     TIMESTAMP
);
SELECT create_class('core.core_acl_role_inherit');
SELECT ddl_history_tbl('core_acl_role_inherit', 'recreate');


/*CREATE TYPE core_menu_item_status AS ENUM ('active', 'noactive');*/


CREATE TABLE core_menu_item (
  id            INTEGER NOT NULL,
  menu_id       INTEGER NOT NULL,
  controller_id INTEGER NOT NULL,
  parent_id     INTEGER NOT NULL                         DEFAULT '0',
  alias         TEXT    NOT NULL,
  title         TEXT    NOT NULL,
  description   TEXT    NOT NULL                         DEFAULT '',
  image         TEXT    NOT NULL                         DEFAULT '',
  position      INTEGER NOT NULL                         DEFAULT '1',
  state_id      INTEGER NOT NULL REFERENCES ref (obj_id) DEFAULT state_id('core.core_menu_item.active'),
  init_obj_id   INTEGER REFERENCES obj (obj_id),
  create_time   TIMESTAMP,
  update_time   TIMESTAMP
);
SELECT create_class('core.core_menu_item');
SELECT ddl_history_tbl('core_menu_item', 'recreate');
SELECT create_state('core.core_menu_item', 'active,noactive', NULL);


INSERT INTO core_menu_item (id, menu_id, controller_id, parent_id, alias, title, description, image, position, state_id)
VALUES
  (1, 1, '-1', 0, '', 'Settings', 'Project settings', '', 5, state_id('core.core_menu_item.active')),
  (2, 1, '-1', 1, '', 'User acccesses', '', '', 1, state_id('core.core_menu_item.active')),
  (3, 1, '6', 2, '', 'Roles', '', '', 1, state_id('core.core_menu_item.active')),
  (4, 1, '-1', 1, '', 'Menu', '', '', 2, state_id('core.core_menu_item.active')),
  (5, 1, '-1', 1, '', 'Mvc', '', '', 3, state_id('core.core_menu_item.active')),
  (7, 1, '2', 4, '', 'Items', '', '', 2, state_id('core.core_menu_item.active')),
  (8, 1, '3', 5, '', 'Modules', '', '', 1, state_id('core.core_menu_item.active')),
  (9, 1, '4', 5, '', 'Controllers', '', '', 2, state_id('core.core_menu_item.active')),
  (10, 1, '5', 5, '', 'Actions', '', '', 3, state_id('core.core_menu_item.active')),
  (11, 1, '1', 4, '', 'Menus', '', '', 1, state_id('core.core_menu_item.active')),
  (12, 1, '7', 2, '', 'Accesses', '', '', 4, state_id('core.core_menu_item.active')),
  (13, 1, '8', 2, '', 'Resources', '', '', 2, state_id('core.core_menu_item.active')),
  (14, 1, '9', 2, '', 'Access list', '', '', 5, state_id('core.core_menu_item.active')),
  (19, 1, '14', 15, '', 'Settings', 'Cron settings', '', 0, state_id('core.core_menu_item.active')),
  (20, 1, '15', 2, '', 'Users', '', '', 5, state_id('core.core_menu_item.active'));


CREATE TABLE core_menu_menus (
  id          INTEGER NOT NULL,
  name        TEXT    NOT NULL,
  init_obj_id INTEGER REFERENCES obj (obj_id),
  create_time TIMESTAMP,
  update_time TIMESTAMP
);
SELECT create_class('core.core_menu_item');
SELECT ddl_history_tbl('core_menu_item', 'recreate');

INSERT INTO core_menu_menus (id, name) VALUES
  (1, 'admin');

CREATE TABLE core_mvc_action (
  id            INTEGER NOT NULL,
  controller_id INTEGER NOT NULL,
  name          TEXT    NOT NULL,
  state_id      INTEGER REFERENCES ref (obj_id) DEFAULT state_id('core.core_mvc_action.active'),
  init_obj_id   INTEGER REFERENCES obj (obj_id),
  create_time   TIMESTAMP,
  update_time   TIMESTAMP
);
SELECT create_class('core.core_mvc_action');
SELECT ddl_history_tbl('core_mvc_action', 'recreate');
SELECT create_state('core.core_menu_item', 'active,not_active', NULL);


/*CREATE TYPE core_mvc_module_status AS ENUM ('active', 'not_active');*/


CREATE TABLE core_mvc_module (
  id          INTEGER NOT NULL,
  name        TEXT    NOT NULL,
  state_id    INTEGER NOT NULL DEFAULT state_id('core.core_mvc_module.active'),
  init_obj_id INTEGER REFERENCES obj (obj_id),
  create_time TIMESTAMP,
  update_time TIMESTAMP
);
SELECT create_class('core.core_mvc_module');
SELECT ddl_history_tbl('core_mvc_module', 'recreate');
SELECT create_state('core.core_mvc_module', 'active,noactive', NULL);


INSERT INTO core_mvc_module (id, name, state_id) VALUES
  (1, 'admin', state_id('core.core_mvc_module.active')),
  (2, 'core', state_id('core.core_mvc_module.active')),
  (4, 'user', state_id('core.core_mvc_module.active'));

CREATE TABLE core_mvc_controller (
  id          INTEGER NOT NULL,
  module_id   INTEGER NOT NULL,
  name        TEXT    NOT NULL,
  state_id    INTEGER NOT NULL DEFAULT state_id('core.core_mvc_module.active'),
  init_obj_id INTEGER REFERENCES obj (obj_id),
  create_time TIMESTAMP,
  update_time TIMESTAMP
);
SELECT create_class('core.core_mvc_controller');
SELECT ddl_history_tbl('core_mvc_controller', 'recreate');
SELECT create_state('core.core_mvc_controller', 'active,noactive', NULL);


INSERT INTO core_mvc_controller (id, module_id, name, state_id) VALUES
  (1, 2, 'menu-menus', state_id('core.core_mvc_controller.active')),
  (2, 2, 'menu-item', state_id('core.core_mvc_controller.active')),
  (3, 2, 'mvc-module', state_id('core.core_mvc_controller.active')),
  (4, 2, 'mvc-controller', state_id('core.core_mvc_controller.active')),
  (5, 2, 'mvc-action', state_id('core.core_mvc_controller.active')),
  (6, 2, 'acl-role', state_id('core.core_mvc_controller.active')),
  (7, 2, 'acl-access', state_id('core.core_mvc_controller.active')),
  (8, 2, 'acl-resource', state_id('core.core_mvc_controller.active')),
  (9, 2, 'acl-accessList', state_id('core.core_mvc_controller.active')),
  (10, 2, 'acl-roleInherit', state_id('core.core_mvc_controller.active')),
  (14, 3, 'setting', state_id('core.core_mvc_controller.active')),
  (15, 4, 'users', state_id('core.core_mvc_controller.active'));

/*
CREATE TABLE user_users (
  obj_id integer NOT NULL REFERENCES obj(obj_id),
  email text NOT NULL,
  password text NOT NULL,
  name text NOT NULL,
  core_acl_role_id integer NOT NULL,
  state_id integer NOT NULL REFERENCES ref(obj_id),
  init_obj_id integer REFERENCES obj(obj_id),
  create_time TIMESTAMP,
  update_time TIMESTAMP);
select create_class('core.user_users');

INSERT INTO user_users (obj_id,email, password, name, core_acl_role_id, state_id) VALUES
(6, 'temafey@gmail.com', '$2a$08$GAeqa0pyDZMWBJYdAtKBI.rocjxtQ4RQV9ca1Np02LF6Z6LKUdTNu', 'Artem', 1, state_id('core.user_users.active'));*/


/*DROP TRIGGER IF EXISTS ms_refresh_person_ns ON person_ns;
DROP FUNCTION IF EXISTS ms_refresh_person_ns();

DROP TRIGGER IF EXISTS person_ns_before_insert ON person_ns;
DROP FUNCTION IF EXISTS person_ns_before_insert();
DROP TRIGGER IF EXISTS person_ns_before_update ON person_ns;
DROP FUNCTION IF EXISTS person_ns_before_update();
DROP TRIGGER IF EXISTS person_ns_odb_after_delete_trigger ON person_ns;
DROP TRIGGER IF EXISTS person_ns_odb_before_insert_trigger ON person_ns;
DROP TRIGGER IF EXISTS person_ns_before_change_history_trigger ON person_ns;*/


drop MATERIALIZED view vw_pr;

/*ALTER TABLE person_ns DROP COLUMN auth_key;
ALTER TABLE person_ns DROP COLUMN token;*/




DROP FUNCTION IF EXISTS ms_refresh_person_ns() CASCADE ;

delete from person_ns
where login not in ('soscredit');

alter table person_ns drop COLUMN type_id;
alter table person_ns drop COLUMN state_id;


DELETE
FROM ref
WHERE relname = 'person_ns';



ALTER TABLE person_ns DROP COLUMN update_time;
ALTER TABLE person_ns DROP COLUMN create_time;

ALTER TABLE person_ns ADD COLUMN name text;


select create_class('core.person_ns',null);
SELECT create_state('core.person_ns', 'active,noactive,deleted,blocked', NULL);

alter table person_ns add COLUMN state_id integer DEFAULT state_id('core.person_ns.active');

ALTER TABLE person_ns ADD COLUMN update_time TIMESTAMP;
ALTER TABLE person_ns ADD COLUMN create_time TIMESTAMP;




ALTER TABLE core_acl_access_list  ADD PRIMARY KEY (id);
CREATE UNIQUE INDEX ON core_acl_access_list (role_id, resource_id, access_id);

CREATE SEQUENCE core_acl_access_list_id_seq;
ALTER TABLE core_acl_access_list ALTER COLUMN id SET DEFAULT nextval('core_acl_access_list_id_seq');
SELECT setval('core_acl_access_list_id_seq', (SELECT max(id) + 1
                                              FROM core_acl_access_list));


ALTER TABLE core_acl_resource ADD PRIMARY KEY (id);
CREATE UNIQUE INDEX ON core_acl_resource (name);

CREATE SEQUENCE core_acl_resource_id_seq;
ALTER TABLE core_acl_resource ALTER COLUMN id SET DEFAULT nextval('core_acl_resource_id_seq');
SELECT setval('core_acl_access_list_id_seq', (SELECT max(id) + 1
                                              FROM core_acl_resource));

ALTER TABLE core_acl_resource_access ADD PRIMARY KEY (id);
CREATE UNIQUE INDEX ON core_acl_resource_access (resource_id, name);

CREATE SEQUENCE core_acl_resource_access_id_seq;
ALTER TABLE core_acl_resource_access ALTER COLUMN id SET DEFAULT nextval('core_acl_resource_access_id_seq');
SELECT setval('core_acl_resource_access_id_seq', (SELECT max(id) + 1
                                                  FROM core_acl_resource_access));

ALTER TABLE core_acl_role ADD PRIMARY KEY (id);
CREATE UNIQUE INDEX ON core_acl_role (name);

CREATE SEQUENCE core_acl_role_id_seq;
ALTER TABLE core_acl_role  ALTER COLUMN id SET DEFAULT nextval('core_acl_role_id_seq');
SELECT setval('core_acl_role_id_seq', (SELECT max(id) + 1
                                       FROM core_acl_role));

ALTER TABLE core_acl_role_inherit ADD PRIMARY KEY (id);
CREATE UNIQUE INDEX ON core_acl_role_inherit (role_id, inherit_role_id);


CREATE SEQUENCE core_acl_role_inherit_id_seq;
ALTER TABLE core_acl_role_inherit  ALTER COLUMN id SET DEFAULT nextval('core_acl_role_inherit_id_seq');
SELECT setval('core_acl_role_inherit_id_seq', (SELECT max(id) + 1
                                               FROM core_acl_role_inherit));

ALTER TABLE core_menu_item ADD PRIMARY KEY (id);
CREATE INDEX ON core_menu_item (state_id);

CREATE SEQUENCE core_menu_item_id_seq;
ALTER TABLE core_menu_item  ALTER COLUMN id SET DEFAULT nextval('core_menu_item_id_seq');
SELECT setval('core_menu_item_id_seq', (SELECT max(id) + 1
                                        FROM core_menu_item));

ALTER TABLE core_menu_menus ADD PRIMARY KEY (id);

CREATE SEQUENCE core_menu_menus_id_seq;
ALTER TABLE core_menu_menus  ALTER COLUMN id SET DEFAULT nextval('core_menu_menus_id_seq');
SELECT setval('core_menu_menus_id_seq', (SELECT max(id) + 1
                                         FROM core_menu_menus));


ALTER TABLE core_mvc_action ADD PRIMARY KEY (id);
CREATE UNIQUE INDEX ON core_mvc_action (controller_id, name);


CREATE SEQUENCE core_mvc_action_id_seq;
ALTER TABLE core_mvc_action  ALTER COLUMN id SET DEFAULT nextval('core_mvc_action_id_seq');
SELECT setval('core_mvc_action_id_seq', (SELECT max(id) + 1
                                         FROM core_menu_menus));

ALTER TABLE core_mvc_controller ADD PRIMARY KEY (id);

CREATE SEQUENCE core_mvc_controller_id_seq;
ALTER TABLE core_mvc_controller ALTER COLUMN id SET DEFAULT nextval('core_mvc_controller_id_seq');
SELECT setval('core_mvc_controller_id_seq', (SELECT max(id) + 1
                                             FROM core_mvc_controller));


ALTER TABLE core_mvc_module ADD PRIMARY KEY (id);

CREATE SEQUENCE core_mvc_module_id_seq;
ALTER TABLE core_mvc_module ALTER COLUMN id SET DEFAULT nextval('core_mvc_module_id_seq');
SELECT setval('core_mvc_module_id_seq', (SELECT max(id) + 1
                                         FROM core_mvc_module));


ALTER TABLE core_acl_role_inherit     ADD FOREIGN KEY (role_id) REFERENCES core_acl_role (id);
ALTER TABLE core_acl_role_inherit     ADD FOREIGN KEY (inherit_role_id) REFERENCES core_acl_role_inherit (id);
ALTER TABLE core_acl_resource_access  ADD FOREIGN KEY (resource_id) REFERENCES core_acl_resource (id);
ALTER TABLE core_acl_access_list  ADD FOREIGN KEY (role_id) REFERENCES core_acl_role (id);
ALTER TABLE core_acl_access_list  ADD FOREIGN KEY (resource_id) REFERENCES core_acl_resource (id);
ALTER TABLE core_acl_access_list  ADD FOREIGN KEY (access_id) REFERENCES core_acl_resource_access (id);


ALTER TABLE person_ns ADD COLUMN core_acl_role_id INTEGER NOT NULL REFERENCES core_acl_role (id) DEFAULT 1;
ALTER TABLE person_ns drop column login;
ALTER TABLE person_ns alter column tree set DEFAULT 1;
ALTER TABLE person_ns drop column pathl;



create UNIQUE INDEX person_ns_email_unq on person_ns(email);

select ddl_history_tbl('person_ns','recreate');

update person_ns
set email = 'soscredit@boss.com';

INSERT INTO person_ns (email,password, name, core_acl_role_id, state_id) VALUES
  ('temafey@gmaill.com','$2a$08$GAeqa0pyDZMWBJYdAtKBI.rocjxtQ4RQV9ca1Np02LF6Z6LKUdTNu', 'Artem', 1,
   state_id('core.person_ns.active'));

INSERT INTO person_ns (email,password, name, core_acl_role_id, state_id) VALUES
  ('fursin.v@gmail.com','$2a$08$GAeqa0pyDZMWBJYdAtKBI.rocjxtQ4RQV9ca1Np02LF6Z6LKUdTNu', 'Victor', 1,
   state_id('core.person_ns.active'));

INSERT INTO person_ns (email,password, name, core_acl_role_id, state_id) VALUES
  ('nemolvlad@gmail.com','$2a$08$GAeqa0pyDZMWBJYdAtKBI.rocjxtQ4RQV9ca1Np02LF6Z6LKUdTNu', 'Oleg', 1,
   state_id('core.person_ns.active'));

EOD;
    $count = $this->execute($query);
    }
}
