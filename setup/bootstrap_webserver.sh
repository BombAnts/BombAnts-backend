#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PASSWORD='root'
PROJECTFOLDER='/home/ubuntu/projects'
PROJECTNAME='myproject'


# create project folder
mkdir -p "${PROJECTFOLDER}"
ln -s /vagrant/public/ "${PROJECTFOLDER}/${PROJECTNAME}"



# install php 7
sudo apt-get install -y php-dev
sudo apt-get install -y php7.0
sudo apt-get install -y php7.0-cli
sudo apt-get install -y php7.0-curl
sudo apt-get install -y php7.0-bcmath
sudo apt-get install -y php7.0-mbstring
sudo apt-get install -y php-xml



# install git
sudo apt-get -y install git

# install zip / unzip
sudo apt-get install zip unzip

# install Composer
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
