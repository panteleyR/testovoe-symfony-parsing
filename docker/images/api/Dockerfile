FROM php:7.4-fpm-buster

RUN buildDeps="autoconf file libc-dev libtool libxml2 libxml2-dev mc net-tools libssl-dev curl automake cmake g++ git libpq-dev libmagickwand-dev libzip-dev libonig-dev librabbitmq-dev libreadline-dev libcurl4-openssl-dev libmemcached-dev zlib1g-dev libicu-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev pkg-config libmagickwand-6.q16-dev libldap2-dev wget zip unzip libaio1 ssh-client zlib1g-dev" && \
    apt-get update && \
    apt-get install -y $buildDeps --no-install-recommends && \
    pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis && \
    ln -sf /usr/lib/x86_64-linux-gnu/ImageMagick*/bin-*/MagickWand-config /usr/bin && \
    pecl install imagick && \
    echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini && \
    echo "expose_php=off" >> /usr/local/etc/php/conf.d/ext-imagick.ini && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install \
        curl \
        dom \
        mbstring \
        simplexml \
        zip \
        opcache \
        gd \
        pdo \
        pdo_mysql \
        sockets \
        intl

#RUN pecl install memcached-3.1.5 \
#    && docker-php-ext-enable memcached

#RUN echo 'start rabbit install'
#RUN git clone git://github.com/alanxz/rabbitmq-c.git \
#    && cd rabbitmq-c \
#    && mkdir build && cd build \
#    && cmake -DENABLE_SSL_SUPPORT=OFF .. \
#    && cmake --build . --target install  \
#    && pecl install amqp xdebug igbinary \
#    && rm -rf ../rabbitmq-c \
#    && docker-php-ext-enable amqp
#RUN git clone git://github.com/alanxz/rabbitmq-c.git \
#    && cd rabbitmq-c \
#    && git fetch --tags && git checkout tags/v0.5.2 \
#    && git submodule init \
#    && git config --global http.sslVerify false \
#    && git submodule update \
#    && autoreconf -i \
#    && ./configure \
#    && make \
#    && make install \
#    && pecl install amqp-1.9.3 \
#    && docker-php-ext-enable amqp \
#    && rm -rf /usr/src/php-ext \
#    && pecl install proctitle channel://pecl.php.net/proctitle-0.1.2

RUN cd ~ && curl -sS https://getcomposer.org/installer -o composer-setup.php && \
	php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
	&& chmod +x /usr/local/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - && \
    apt-get install -y nodejs

CMD ["php-fpm"]