## OpenStreetMaps based on Debian
Download from docker
```
docker pull admik/openstreetmaps:D10
```
In case of needed, remove database
```
gosu postgres psql -c "DROP DATABASE world;"
```
Create new database
```
gosu postgres psql -c "CREATE USER osm;"
gosu postgres psql -c "CREATE DATABASE world;"
gosu postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE world TO osm;"
gosu postgres psql -c "CREATE EXTENSION hstore;" -d world
gosu postgres psql -c "CREATE EXTENSION postgis;" -d world
```
Import continet, or country
```
su osm -c "osm2pgsql --slim --database world --cache 2048 --cache-strategy sparse --hstore --style /home/osm/openstreetmap-carto/openstreetmap-carto.style /PATH_FOR_FILE/FILENAME.osm.pbf"
```
Import psql files into existing DB
```
gosu postgres psql -f /PATH_FOR_FILE/FILENAME.psql
```
Usefull links
```
https://download.geofabrik.de/
git clone https://github.com/openstreetmap/mod_tile.git
git clone https://github.com/gravitystorm/openstreetmap-carto.git
```
Render the map
```
su osm -c "render_list -m default -a -z 0 -Z 5"
```
Show status of rendered map
```
cat /var/run/renderd/renderd.stats | grep -v ": 0"
```
