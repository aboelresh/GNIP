# ─── Base Stage ───────────────────────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS base

RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    mysql-client \
    oniguruma-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ─── Development Stage ────────────────────────────────────────────────────────
FROM base AS development

RUN apk add --no-cache nodejs npm

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts
COPY package*.json ./
RUN npm install

COPY . .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

EXPOSE 9000 5173

CMD ["php-fpm"]

# ─── Production Stage ─────────────────────────────────────────────────────────
FROM base AS production

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-autoloader \
    --no-scripts \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize

RUN apk add --no-cache nodejs npm \
    && npm install \
    && npm run build \
    && apk del nodejs npm \
    && rm -rf node_modules

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]