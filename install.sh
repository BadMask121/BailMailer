#!/bin/bash
# php -r "print_r(class_exists('Thred'));"
check_pthread=$(php -r "print_r(class_exists('Thread'));" 2>&1)
check_php=$(php -r "echo PHP_ZTS;" 2>&1)
check_OS= hostnamectl | grep -oP '(?<=Operating System: ).*'




#Installion for Ubuntu 18 pthread 
initUbuntu(){
    set -x
    echo -e "\nInstalling all neccessary files for BailMailer set back and relax\n"
    sudo apt update -y
    echo -e "\nupdate complete\n"
    echo -e "Installing new files \n"
    sudo apt install -y libzip-dev bison autoconf build-essential pkg-config git-core 
    sudo apt install -y libltdl-dev libbz2-dev libxml2-dev libxslt1-dev libssl-dev libicu-dev  
    sudo apt install -y libpspell-dev libenchant-dev libmcrypt-dev libpng-dev libjpeg8-dev 
    sudo apt install -y libfreetype6-dev libmysqlclient-dev libreadline-dev libcurl4-openssl-dev 

    sudo apt-get install libenchant-dev
        echo -e "\nGoing into \home directory ...\n"
    cd $HOME
        echo -e "\n installing php-7.2.2.tar.gz Zend-Thread-Safe (ZTS)"

    if [[ -d "/php-src-php-7.2.2" && ! -L "php-src-php-7.2.2" ]];
        then 
            echo "php-src-php-7.2.2 : exists already"
    else
        sudo wget https://github.com/php/php-src/archive/php-7.2.2.tar.gz
        echo -e "\n Extracting downloaded file php.7.2.2.tar.gz please wait... \n"
        sudo tar --extract --gzip --file php-7.2.2.tar.gz
    fi

    cd $HOME/php-src-php-7.2.2
    sudo ./buildconf --force
    export PKG_CONFIG_PATH=/usr/local/lib/pkgconfig/
    CONFIGURE_STRING="--prefix=/etc/php7  --with-bz2 --with-zlib --enable-zip --disable-cgi \
    --enable-soap --enable-intl --with-openssl --with-readline --with-curl \
    --enable-ftp --enable-mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd \
    --enable-sockets --enable-pcntl --with-pspell --with-enchant --with-gettext \
    --with-gd --enable-exif --with-jpeg-dir --with-png-dir --with-freetype-dir --with-xsl \
    --enable-bcmath --enable-mbstring --enable-calendar --enable-simplexml --enable-json \
    --enable-hash --enable-session --enable-xml --enable-wddx --enable-opcache \
    --with-pcre-regex --with-config-file-path=/etc/php7/cli \
    --with-config-file-scan-dir=/etc/php7/etc --enable-cli --enable-maintainer-zts \
    --with-tsrm-pthreads --enable-debug --enable-fpm \
    --with-fpm-user=www-data --with-fpm-group=www-data --enable-maintainer-zts"

    sudo ./configure $CONFIGURE_STRING
    sudo make && sudo make install
    sudo chmod o+x /etc/php7/bin/phpize
    sudo chmod o+x /etc/php7/bin/php-config
    sudo git clone https://github.com/krakjoe/pthreads.git
    cd pthreads
    sudo /etc/php7/bin/phpize

    sudo ./configure \
    --prefix='/etc/php7' \
    --with-libdir='/lib/x86_64-linux-gnu' \
    --enable-pthreads=shared \
    --with-php-config='/etc/php7/bin/php-config'
    # sudo install -c ext/phar/phar.phar .
    sudo make && sudo make install

    cd $HOME/php-src-php-7.2.2

    sudo mkdir -p /etc/php7/cli/
    sudo cp php.ini-production /etc/php7/cli/php.ini
    echo "extension=pthreads.so" | sudo tee -a /etc/php7/cli/php.ini
    echo "zend_extension=opcache.so" | sudo tee -a /etc/php7/cli/php.ini
    sudo rm /usr/bin/php || sudo rm /usr/local/bin/php
    sudo ln -s /etc/php7/bin/php /usr/bin/php || sudo ln -s /etc/php7/bin/php /usr/local/bin/php

    set -x 
    echo -e "\n MultiThreading Installed successfully !!! \n you will now continue to Bail Mailer"
}





#installion of pthread for CentOS 7
initCentOS(){


    echo -e "INSTALL WEBSTATIC REPO FOR CENTOS/RED HAT 7 : "
    sudo rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
    sudo rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

    echo -e "INSTALL COMPILER PACKAGES: "
    sudo yum --nogp install -y --enablerepo=webtatic-testing gcc gcc-c++ make openssl-devel linux-headers git
    
    echo -e "INSTALL PHP WITH COMMON MODULES: "
    sudo yum --nogp install -y --enablerepo=webtatic-testing \
        php72w php72w-cli php72w-common php72w-devel \
        php72w-gd php72w-intl php72w-mbstring php72w-mcrypt \
        php72w-mysqlnd php72w-odbc php72w-opcache php72w-pdo \
        php72w-pdo_dblib php72w-pear php72w-pgsql php72w-pspell \
        php72w-soap php72w-xml php72w-xmlrpc php72w-bcmath

    echo -e "CHANGE TO A TEMP DIRECTORY:"
    cd /tmp

    echo -e "PULL DOWN the PTHREADS GIT REPO:"
    git clone https://github.com/krakjoe/pthreads.git
    cd pthreads
    zts-phpize
    ./configure --with-php-config=/usr/bin/zts-php-config
    sudo make

    echo -e "COPY EXTENSION TO PHP-ZTS MODULES FOLDER:"
    cp modules/pthreads.so /usr/lib64/php-zts/modules/.
    
    echo -e "ENABLE EXTENSION IN PHP-ZTS, BY CREATING A FILE:"
    echo "extension=pthreads.so" >> /etc/php-zts.d/pthreads.ini

    echo -e "NEXT CHECK TO SEE IF YOU GOT IT WORKING:"
    zts-php -i | grep -i thread
}

if [[ $check_pthread -eq 1  && $check_php -eq 1 ]]; then
    echo "You have already done an installation"
else

    case $check_OS in 
        [Ubuntu 18] )
            initUbuntu ;;
        [CentOS Linux 7 (Core)] )
            initCentOS ;;
        * )
        echo -e "UnSupported Operating System $check_OS"      
    esac

fi
