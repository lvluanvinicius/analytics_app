# Usando a imagem base do PHP com FPM
FROM php:8.2-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-dev

# Instalar Node.js e pnpm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g pnpm

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql zip gd

# Copiar os arquivos da aplicação
WORKDIR /var/www/html
COPY . /var/www/html

# Instalar dependências do Laravel com Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Gerar chave do Laravel e definir permissões
# RUN php artisan key:generate && \
#     php artisan config:cache

# Instalar as dependências do pnpm e executar o build
RUN pnpm install
RUN pnpm build

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html

# Expôr a porta do PHP-FPM
EXPOSE 9000

# Comando de inicialização do PHP-FPM
CMD ["php-fpm"]
