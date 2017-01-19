FROM sdygt/php-trusty
MAINTAINER sdygt <sdygt@users.noreply.github.com>

RUN wget -O - http://llvm.org/apt/llvm-snapshot.gpg.key|apt-key add - && \
    apt-get update && \
    apt-get -y install clang-3.3 llvm-3.3 llvm-3.3-dev llvm-3.3-runtime \
    && rm -rf /var/lib/apt/lists/* \
    && mv /usr/bin/opt-3.3 /usr/bin/opt
ADD /bin/llvm-slicing_llvm-3.3_x86-64_Ubuntu-12.04.2.tar.bz2 /usr/bin
COPY tp5/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html
RUN sed -i -e 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/public/g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]