FROM node:8 AS fe-build
LABEL maintainer="sdygt <sdygt@users.noreply.github.com>"

COPY /frontend/ /home/frontend/
WORKDIR /home/frontend/
RUN yarn && yarn build

######
FROM sdygt/php-trusty AS prod

ENV DEBIAN_FRONTEND noninteractive

ADD /bin/llvm-slicing_llvm-3.3_x86-64_Ubuntu-12.04.2.tar.bz2 /usr/bin
COPY php/ /var/www/html/
COPY --from=fe-build /home/frontend/dist/index.html /var/www/html/application/index/view/index/
COPY --from=fe-build /home/frontend/dist/static/ /var/www/html/public/static/
COPY apache2.conf /etc/apache2/

RUN chown -R www-data:www-data /var/www/html && \
    sed -i -e 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g' /etc/apache2/sites-available/000-default.conf && \
    sed -i -e 's#ErrorLog ${APACHE_LOG_DIR}/error.log#ErrorLog /dev/stderr#g' /etc/apache2/sites-available/000-default.conf && \
    sed -i -e 's#CustomLog ${APACHE_LOG_DIR}/access.log combined#CustomLog /dev/stdout common#g' /etc/apache2/sites-available/000-default.conf && \
    a2enmod rewrite

RUN wget -O - http://llvm.org/apt/llvm-snapshot.gpg.key|apt-key add - && \
    apt-get update && \
    apt-get -y install clang-3.3 llvm-3.3 llvm-3.3-dev llvm-3.3-runtime graphviz && \
    rm -rf /var/lib/apt/lists/* && \
    mv /usr/bin/opt-3.3 /usr/bin/opt

WORKDIR /var/www/html
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]