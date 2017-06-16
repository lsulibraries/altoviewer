#! /bin/bash
sudo apt-get update
apt-get install libapache2-mod-php5 git emacs php-elisp imagemagick php5-xsl
rm -rf /var/www/html
cp -r /vagrant/site/html /var/www/
#git clone https://github.com/blekinge/altoviewer /var/www/html
apachectl restart
#convert mn_19231115_001.jp2 mn_19231115_001.jpg
