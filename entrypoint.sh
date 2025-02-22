#!/bin/bash
chown -R postgres:postgres /var/lib/postgresql/11/main
chmod 0700 /var/lib/postgresql/11/main

if [ ! -f /var/lib/postgresql/11/main/PG_VERSION_ok ]; then
 cp -pr /var/lib/postgresql/11/main_bak/* /var/lib/postgresql/11/main/
 /etc/init.d/postgresql restart
 gosu postgres psql -c "CREATE USER osm;"
 gosu postgres psql -c "CREATE DATABASE world;"
 gosu postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE world TO osm;"
 gosu postgres psql -c "CREATE EXTENSION hstore;" -d world
 gosu postgres psql -c "CREATE EXTENSION postgis;" -d world
 touch /var/lib/postgresql/11/main/PG_VERSION_ok
fi

if [ ! -f /var/www/html/index.php ]; then
 cp /var/www/html_bak/index.php /var/www/html/index.php
fi

if [ ! -f /var/www/html/leaflet.css ]; then
 cp /var/www/html_bak/leaflet.css /var/www/html/leaflet.css
fi

if [ ! -f /var/www/html/leaflet.js ]; then
 cp /var/www/html_bak/leaflet.js /var/www/html/leaflet.js
fi

/etc/init.d/postgresql restart
sleep 5
/etc/init.d/renderd restart
sleep 5
/etc/init.d/apache2 restart

while true; do
 sleep 600
done
