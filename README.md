# CourseWeb
courseweb is an open php web framework for 
The Probability Theory course.


## Requirement
To run couseweb, we need:

* Apache
* php
* mysql

In short, our development environment is LAMP
(Linux + Apache + Mysql + php).
Usually, the order of setting up these
software/source is apache --> mysql --> php.

### Apache
To build apache, we need apr, apr-util, pcre:

1. apr:
```
./configure --prefix=/usr/local/apr
make
sudo make install
```
2. apr-util:
```
./configure --prefix=/usr/local/apr-util --with-apr=/usr/local/apr
make
sudo make install
```
3. pcre
```
./configure --prefix=/usr/local/pcre
make
sudo make install
```

Now we can install apache:
```
./configure --prefix=/usr/local/apache2 --with-apr=/usr/local/apr --with-apr-util=/usr/local/apr-util --with-pcre=/usr/local/pcre
make
sudo make install
```
Next, you can customize your Apache HTTP server by editing the configuration files under PREFIX/conf/,
such as ServerAdmin, ServerName.

Finally start up the apache:
```APACHEROOT/bin/apachectl -k start```,
You should then be able to request your first document via the URL http://127.0.0.1/.
### Mysql
It's convenient to install mysql by referring to
http://dev.mysql.com/doc/mysql-apt-repo-quick-guide/en/.
download the dev file, then:
```
sudo apt-get update
sudo apt-get install mysql-server
```

### PHP
http://php.net/manual/zh/install.unix.apache2.php.
version: 5.6
```
./configure --with-apxs2=/usr/local/apache2/bin/apxs --with-mysqli
make
sudo make install
```
copy the configure:
```
cp php.ini-development /usr/local/lib/php.ini
```
modify the configure of apache, add:
```
LoadModule php5_module modules/libphp5.so
<FilesMatch \.php$>
    SetHandler application/x-httpd-php
</FilesMatch>
```
Restart your apache.

Write a test.php:
```
<?php
    phpinfo();
?>
```
To confirm whether success, input 127.0.0.1/test.php.

## Install
```
cd APACHEROOT/htdocs
git clone git@github.com:TBXChina/courseweb.git
cd courseweb
```
customize your courseweb
```
vim include/configure.php include/new_configure.php
```

In your browser, input ```127.0.0.1/courseweb/setup.php```.

Enjoy! <font color=red>Don't forget to remove the setup.php and replace the ```include/configure.php``` by ```include/new_configure.php```!</font>