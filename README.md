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
Create replication folder
```
mkdir -p /var/lib/osm/replication
```
Create replication config
```
cat <<EOF > /var/lib/osm/replication/configuration.txt
baseUrl=https://planet.openstreetmap.org/replication/day
maxInterval=1000
retryDelay=60
maxRetryCount=3
EOF
```
Download replication state file
```
wget https://download.geofabrik.de/europe/slovakia-updates/state.txt -O /var/lib/osm/replication/state.txt
```
Write replication changes to file
```
osmosis --read-replication-interval workingDirectory=/var/lib/osm/replication --simplify-change --write-xml-change /var/lib/osm/replication/changes.osc.gz
```
Import replication changes to database
```
su osm -c "osm2pgsql --append --slim --database world --cache 2048 --hstore --style /home/osm/openstreetmap-carto/openstreetmap-carto.style /var/lib/osm/replication/changes.osc.gz"
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
Merge more countries into one
```
apt-get install osmium-tool
osmium merge country_1.osm.pbf country_2.osm.pbf -o final_country.osm.pbf
```

