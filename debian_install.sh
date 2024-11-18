#!/bin/bash
mkdir docker
cd docker

wget https://download.docker.com/linux/debian/dists/bookworm/pool/stable/amd64/containerd.io_1.7.23-1_amd64.deb
wget https://download.docker.com/linux/debian/dists/bookworm/pool/stable/amd64/docker-ce-cli_27.3.1-1~debian.12~bookworm_amd64.deb
wget https://download.docker.com/linux/debian/dists/bookworm/pool/stable/amd64/docker-ce_27.3.1-1~debian.12~bookworm_amd64.deb
dpkg -i *.deb
docker --version


curl -L https://github.com/docker/compose/releases/download/v2.24.2/docker-compose-linux-x86_64  -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
docker-compose --version

cat < EOF > docker-compose.yml
version: '2'
networks:
   docker0:
     driver: bridge
     driver_opts:
       com.docker.network.bridge.name: "compose0"
       com.docker.network.enable_ipv6: "false"
       com.docker.network.bridge.enable_ip_masquerade: "true"
     ipam:
       driver: default
       config:
       - subnet: 172.20.0.0/24
         gateway: 172.20.0.1

services:
   osm_planet:
     container_name: osm_planet
     restart: always
     image: admik/openstreetmaps
     hostname: osm_planet
     networks:
       docker0:
         ipv4_address: 172.20.0.200
     volumes:
       - /data2/docker/osm_planet/mod_tile/default:/var/lib/mod_tile/default:Z
       - /data2/docker/osm_planet/psql_data:/var/lib/postgresql/9.6/main:Z
       - /data2/docker/osm_planet/html:/var/www/html:Z
       - /data2/docker/osm_planet/source:/source:Z
     ports:
       - "8080:80"
EOF
