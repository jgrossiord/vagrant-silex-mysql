#!/bin/bash -e
export BOOTSTRAP_LOG_FILE=/vagrant/logs/web/bootstrap.log

echo "`date` - Start bootstrap shell" > $BOOTSTRAP_LOG_FILE

bash /vagrant/script/vagrant-bootstrap.sh $BOOTSTRAP_LOG_FILE

echo "`date` - Start install Apache / PHP..." >> $BOOTSTRAP_LOG_FILE
sudo apt-get install -y  -o dir::cache::archives="/vagrant/logs/apt-cache" curl apache2 php5 php5-cli php-pear php5-curl phpunit php5-intl php5-memcache php5-dev php5-gd php5-mcrypt php5-dev php5-mysql git-core git #mongodb-10gen make 
echo "`date` - End install Apache / PHP..." >> $BOOTSTRAP_LOG_FILE

echo "`date` - Start config Apache / PHP..." >> $BOOTSTRAP_LOG_FILE
sudo cp /vagrant/script/template/silex-app.conf /etc/apache2/sites-available/silex-app

rm -f /vagrant/logs/web/apache-*.log
rm -f /vagrant/logs/web/urls.txt

sudo a2enmod rewrite
sudo a2dissite 000-default
sudo a2ensite silex-app
sudo service apache2 restart
echo "`date` - End config Apache / PHP..." >> $BOOTSTRAP_LOG_FILE

echo "`date` - Start installing Composer" >> $BOOTSTRAP_LOG_FILE
cd /vagrant
curl -s http://getcomposer.org/installer | php5
php5 composer.phar install
echo "`date` - End installing Composer" >> $BOOTSTRAP_LOG_FILE
echo "`date` - Start Composer update" >> $BOOTSTRAP_LOG_FILE
php5 composer.phar update
echo "`date` - End Composer update" >> $BOOTSTRAP_LOG_FILE

echo "`date` - Start installing PHPUnit" >> $BOOTSTRAP_LOG_FILE
sudo pear config-set auto_discover 1
sudo pear install pear.phpunit.de/PHPUnit || true 
echo "`date` - End installing PHPUnit" >> $BOOTSTRAP_LOG_FILE

echo "`date` - Start running PHPUnit" >> $BOOTSTRAP_LOG_FILE
sudo phpunit
echo "`date` - End running PHPUnit" >> $BOOTSTRAP_LOG_FILE

ifconfig  | grep 'inet addr:'| grep -v '127.0.0.1' | grep -v '10.0.2' | grep -v '10.11.12.1' | cut -d: -f2 | awk '{ print "http://"$1"/"}' > /vagrant/logs/web/urls.txt
echo "You can access your application on "
cat /vagrant/logs/web/urls.txt
echo "`date` - End bootstrap shell" >> $BOOTSTRAP_LOG_FILE