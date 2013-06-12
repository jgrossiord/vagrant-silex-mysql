#!/bin/bash -e
export BOOTSTRAP_LOG_FILE=/vagrant/logs/db/bootstrap.log

echo "`date` - Start `echo $0`" > $BOOTSTRAP_LOG_FILE

bash /vagrant/script/vagrant-bootstrap.sh $BOOTSTRAP_LOG_FILE

echo "`date` - Start install MySQL" >> $BOOTSTRAP_LOG_FILE
echo mysql-server-5.5 mysql-server/root_password password root | sudo debconf-set-selections
echo mysql-server-5.5 mysql-server/root_password_again password root | sudo debconf-set-selections
sudo apt-get install -y  -o dir::cache::archives="/vagrant/logs/apt-cache" mysql-server-5.5
echo "`date` - End install MySQL" >> $BOOTSTRAP_LOG_FILE

# disable bind-address to enable connection from other computers
sudo sed -i -e 's/^\(bind-address\)/#\1/g' /etc/mysql/my.cnf
sudo service mysql restart

echo "`date` - Start init scripts MySQL" >> $BOOTSTRAP_LOG_FILE
mysql -u root -proot < /vagrant/script/db-init.sql
echo "`date` - End init scripts MySQL" >> $BOOTSTRAP_LOG_FILE

ifconfig  | grep 'inet addr:'| grep -v '127.0.0.1' | grep -v '10.0.2' | cut -d: -f2 | awk '{ print $1}' > /vagrant/logs/db/urls.txt
echo "You can access mySQL on IP "
cat /vagrant/logs/db/urls.txt
echo "`date` - End `echo $0`" >> $BOOTSTRAP_LOG_FILE