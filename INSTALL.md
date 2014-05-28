TTM Installation
================

Table of contents:

 * Introduction
 * Requirements
 * Installation
 
Introduction
------------

TBD.  Note these instructions assume Debian GNU/Linux 7.0.

Requirements 
-------------

TTM's dependencies are pretty simple:

 * GNU/Linux or similar operating system
 * PHP 5.3 or higher
 * MySQL 5.0.15 or higher (<http://www.mysql.com/>
   We have not tested with a drop-in replacement such as MariaDB
   <https://mariadb.org/> but would be interested to know if it works.
   We'd also like to know if you get TTM running on PostgreSQL.
 * Apache HTTPD 2.0 or higher
 * OpenSSL

Installation
------------

We assume that a GNU/Linux server with LAMP stack is installed.
See https://wiki.debian.org/LaMp.

The following assumptions are also made about the installation:

 * The webroot is `/var/www/ttm`.
   (It could be somewhere else; `/var/www/ttm` is just the location
   we use in these instructions.)

Steps to install:

1.  Make sure the right ports are open on your server.

    Ports 80 and 443 will need to be opened.  If you plan to SSH in to
    the server to do the rest of this installation, you'll also need
    port 22 open for SSH.

    (Note that if you're deploying on Amazon Web Services, port 22 may
    not be open by default; you would typically open it up via the AWS
    security group.)

2.  Ensure you have the necessary dependencies installed.

    On Debian GNU/Linux 7.0 distribution as of 2014-05-27, that looks
    like this:

        $ sudo apt-get update
        $ sudo apt-get install mysql-server mysql-client
        $ sudo apt-get install apache2 apache2-doc
        $ sudo apt-get install openssl
        $ sudo apt-get install php5 php5-mysql libapache2-mod-php5

3.  Download the latest version of the TTM code:
   
        $ git clone https://github.com/OpenTechStrategies/lisc-ttm.git

4.  Configure Apache to serve the site.

    Define an httpd configuration block for the site like this:

        <VirtualHost *:80>
          ServerAdmin webmaster@localhost
          ServerName your-ttm-hostname.com
          DocumentRoot /var/www/ttm
          ErrorLog ${APACHE_LOG_DIR}/ttm_error.log
          LogLevel debug
        </VirtualHost>
        
        <Directory /var/www/ttm>
          AllowOverride all
        </Directory>

        ### TBD: Update for SSL/TLS cert ###

    On Debian, the standard is to put that in a file named (e.g.)
    `/etc/apache2/sites-available/ttm.conf`, and then install it like
    this:

        $ cd /etc/apache2/sites-enabled/
        $ sudo rm 000-default  # old default site not interesting to us now
        $ sudo ln -s ../sites-available/ttm.conf 000-ttm.conf

    Don't forget to restart Apache:

        $ sudo service apache2 restart

5.  Set up the MySQL database:

        $ mysql -u root -p
        Password: ********
        mysql> grant all on `ttm-core`.* to ttmcorerw@localhost             \
               identified by 'PASSWORD';
        mysql> grant all on `ttm-lsna`.* to ttmlsnarw@localhost             \
               identified by 'PASSWORD';
        mysql> grant all on `ttm-swop`.* to ttmswoprw@localhost             \
               identified by 'PASSWORD';
        mysql> grant all on `ttm-bickerdike`.* to ttmbickerdikerw@localhost \
               identified by 'PASSWORD';
        mysql> grant all on `ttm-trp`.* to ttmtrprw@localhost               \
               identified by 'PASSWORD';
        mysql> grant all on `ttm-enlace`.* to ttmenlacerw@localhost         \
               identified by 'PASSWORD';
        mysql> quit;
        $ 

Rest TBD.
