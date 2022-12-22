#!/bin/bash

mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "ALTER USER ${MYSQL_USER}@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_PASSWORD}';"
