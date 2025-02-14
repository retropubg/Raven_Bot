FROM php:8.3-cli

# Establecer directorio de trabajo
WORKDIR /app

# Copiar los archivos del bot
COPY . /app

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y unzip && \
    docker-php-ext-install pdo pdo_mysql

# Instalar dependencias de Composer si existen
RUN if [ -f "composer.json" ]; then php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php && php composer.phar install --no-dev --optimize-autoloader; fi

# Exponer el puerto 8080 para Railway
EXPOSE 8080

# Comando para ejecutar el servidor PHP
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
