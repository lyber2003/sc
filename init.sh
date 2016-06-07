#!/bin/bash

docker exec -it otsoscreditdocker_db-psql_1 sh load_dump_psql.sh
docker exec -it otsoscreditdocker_php_1 php init.php
