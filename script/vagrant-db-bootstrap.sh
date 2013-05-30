#!/bin/bash -e

bash /vagrant/script/vagrant-bootstrap.sh

export DEBIAN_FRONTEND=noninteractive
sudo apt-get install -y -q mysql-server

mysql -u root < /vagrant/script/db-init.sql


ifconfig  | grep 'inet addr:'| grep -v '127.0.0.1' | grep -v '10.0.2' | cut -d: -f2 | awk '{ print $1}' > /vagrant/logs/db/urls.txt
echo "You can access mySQL on IP "
cat /vagrant/logs/db/urls.txt