FROM php:5.6-apache
LABEL maintainer="Nutthaphon Suwanwong <nutthaphon@gmail.com>"

RUN a2enmod rewrite

RUN curl -fSL http://iweb.dl.sourceforge.net/project/freetype/freetype2/2.9.1/freetype-2.9.1.tar.bz2 -o freetype-2.9.1.tar.bz2 \
&& tar xvfj freetype-2.9.1.tar.bz2 \
&& cd freetype-2.9.1/ \
&& ./configure --without-png \
&& make \
&& make install

RUN set -xe \
&& apt-get update \
&& apt-get install -y subversion libpng-dev libjpeg-dev libpq-dev libxml2-dev libfreetype6-dev \
&& docker-php-ext-configure gd --with-png-dir=/usr/local/include/ --with-jpeg-dir=/usr/local/include/ --with-freetype-dir=/usr/local/include/ \
&& docker-php-ext-install gd mbstring mysql mysqli pgsql soap \
&& rm -rf /var/lib/apt/lists/*

ENV MANTIS_VER 2.17.0
ENV MANTIS_SHA1 624b0012b43e2d0dc19fafa26d23bb96e5d4514c
ENV MANTIS_URL http://jaist.dl.sourceforge.net/project/mantisbt/mantis-stable/${MANTIS_VER}/mantisbt-${MANTIS_VER}.tar.gz
ENV MANTIS_FILE mantisbt.tar.gz
ENV MANTIS_TIMEZONE Asia/Bangkok

#COPY mantisbt-2.17.0.tar.gz ${MANTIS_FILE}

RUN set -xe \
&& curl -fSL ${MANTIS_URL} -o ${MANTIS_FILE} \
&& echo "${MANTIS_SHA1} ${MANTIS_FILE}" | sha1sum -c \
&& tar -xz --strip-components=1 -f ${MANTIS_FILE} \
&& rm ${MANTIS_FILE} \
&& chown -R www-data:www-data .

#COPY source-integration/Source ./plugins
#COPY source-integration/SourceGitlab ./plugins

RUN set -xe \
&& ln -sf /usr/share/zoneinfo/${MANTIS_TIMEZONE} /etc/localtime \
&& echo 'date.timezone = "${MANTIS_TIMEZONE}"' > /usr/local/etc/php/php.ini

# Expose web & ssh
EXPOSE 443 80 22

# Define data volumes
VOLUME ["/var/www/html", "/usr/local/etc/php"]
