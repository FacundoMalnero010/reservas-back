ARG APACHE_VERSION=""

FROM httpd:${APACHE_VERSION:+${APACHE_VERSION}-}alpine

RUN apk update; \
    apk upgrade;

# Copy apache vhost file to proxy php requests to php-fpm container
COPY app.apache.conf /usr/local/apache2/conf/app.apache.conf

#RUN echo "Define BACKEND_INDEX_DIRECTORY frontend" >> /usr/local/apache2/conf/httpd.conf

#RUN echo "Define FRONTEND_INDEX_DIRECTORY laravel-9-starter-kit" >> /usr/local/apache2/conf/httpd.conf

RUN echo "Include /usr/local/apache2/conf/app.apache.conf" >> /usr/local/apache2/conf/httpd.conf
