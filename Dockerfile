FROM php:8.2-fpm

# Set working directory to www
WORKDIR /var/www

# Install dependencies for future use of PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    jpegoptim optipng pngquant gifsicle \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for PHP
# Need to connect with pgsql
RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add user for laravel application
# Simulate the nginx that using www-data user
# So we don't use root user
# Assign a group ID and user ID
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy application files
COPY . /var/www/
COPY .env.example /var/www/.env

# Copy composer files separately to leverage Docker cache
COPY composer.json composer.lock /var/www/

# Set correct permissions
# Set new user created previously to have permission at the project dir
RUN chown -R www:www /var/www

# Change current user
USER www

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Generate application key
RUN php artisan key:generate

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
