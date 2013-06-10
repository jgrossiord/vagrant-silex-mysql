#!/bin/bash -e

bash /vagrant/script/vagrant-bootstrap.sh

echo mysql-server-5.5 mysql-server/root_password password root | sudo debconf-set-selections
echo mysql-server-5.5 mysql-server/root_password_again password root | sudo debconf-set-selections
sudo apt-get install -y  -o dir::cache::archives="/vagrant/logs/apt-cache" mysql-server-5.5

# disable bind-address to enable connection from other computers
sudo sed -i -e 's/^\(bind-address\)/#\1/g' /etc/mysql/my.cnf
sudo service mysql restart

mysql -u root -proot < /vagrant/script/db-init.sql

ifconfig  | grep 'inet addr:'| grep -v '127.0.0.1' | grep -v '10.0.2' | cut -d: -f2 | awk '{ print $1}' > /vagrant/logs/db/urls.txt
echo "You can access mySQL on IP "
cat /vagrant/logs/db/urls.txt