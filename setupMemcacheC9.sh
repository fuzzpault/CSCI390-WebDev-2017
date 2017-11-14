#!/bin/bash
sudo apt-get -y update
sudo apt-get -y install php5-memcache memcached 
sudo service memcached restart
sudo service apache2 restart