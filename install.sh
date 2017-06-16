#! /bin/bash
sudo apt-get update
apt-get -y install libapache2-mod-php5 git emacs php-elisp imagemagick php5-xsl php5-xdebug
rm -rf /var/www/html
cp -r /vagrant/site/html /var/www/
#git clone https://github.com/blekinge/altoviewer /var/www/html
echo "display_errors = On" > /etc/php5/apache2/conf.d/05-dev.ini
<<EOF
zend_extension="/usr/lib/php5/20121212/xdebug.so"
xdebug.remote_enable=1
xdebug.remote_handler=dbgp 
xdebug.remote_mode=req
xdebug.remote_host=127.0.0.1 
xdebug.remote_port=9000
xdebug.max_nesting_level=300
EOF

apachectl restart
#convert mn_19231115_001.jp2 mn_19231115_001.jpg
