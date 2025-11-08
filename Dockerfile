# Dockerfile para PHP 8.2 + Apache y PDO MySQL
FROM php:8.2-apache

# Variables de entorno para evitar warnings de locale (opcional)
ENV DEBIAN_FRONTEND=noninteractive

# Instalar utilidades y extensiones necesarias
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite de Apache si lo necesitas
RUN a2enmod rewrite

# Copiar código al directorio de Apache
COPY . /var/www/html/

# Si usas composer, instalar dependencias
# Copiar composer files y ejecutar composer install solo si existen
COPY composer.json composer.lock /var/www/html/ 2>/dev/null || true
RUN php -r "if (file_exists('composer.json')) { echo 'Composer present'; }" \
    && if [ -f /var/www/html/composer.json ]; then \
    curl -sS https://getcomposer.org/installer | php && php composer.phar install --no-dev --prefer-dist; \
    fi

# Cambiar permisos (seguro para uploads temporales)
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto (Apache usa 80)
EXPOSE 80

# Comando por defecto - iniciar Apache en foreground
CMD ["apache2-foreground"]