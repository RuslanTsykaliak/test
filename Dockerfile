# Specify the base image
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy your project files into the container
COPY . .

# Install any additional dependencies if needed
RUN apt-get update && apt-get install -y \
    mariadb-client \
    libmariadb-dev \
    && docker-php-ext-install mysqli pdo_mysql

# Set up phpMyAdmin
ARG PMA_VERSION=5.1.1
RUN apt-get install -y wget \
    && wget https://files.phpmyadmin.net/phpMyAdmin/${PMA_VERSION}/phpMyAdmin-${PMA_VERSION}-all-languages.tar.gz \
    && tar xvfz phpMyAdmin-${PMA_VERSION}-all-languages.tar.gz \
    && mv phpMyAdmin-${PMA_VERSION}-all-languages phpmyadmin \
    && rm phpMyAdmin-${PMA_VERSION}-all-languages.tar.gz

# Configure Apache for phpMyAdmin
RUN echo "Alias /phpmyadmin /var/www/html/phpmyadmin" >> /etc/apache2/apache2.conf \
    && echo "<Directory /var/www/html/phpmyadmin>" >> /etc/apache2/apache2.conf \
    && echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf \
    && echo "    AllowOverride All" >> /etc/apache2/apache2.conf \
    && echo "    Require all granted" >> /etc/apache2/apache2.conf \
    && echo "</Directory>" >> /etc/apache2/apache2.conf

# Expose port 8000 for Apache
EXPOSE 8000

# Start the Apache web server
CMD ["apache2ctl", "-D", "FOREGROUND"]
