#!/bin/bash
/usr/bin/mysqld_safe &
sleep 5
mysql --user=root --password=root -e "CREATE DATABASE wordpress"
mysql --user=root --password=root wordpress < /tmp/wordpress.sql