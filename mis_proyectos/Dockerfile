FROM docker.io/library/php:8.3.36-apache

# Instalamos la extensión mysqli para conectar PHP con MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitamos la reescritura de URLs en Apache (muy útil para proyectos PHP)
RUN a2enmod rewrite
