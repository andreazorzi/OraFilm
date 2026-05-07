# ============================================
# STAGE 1: Build dependencies (Node.js + Composer)
# ============================================
FROM almalinux:10 AS build

# === REPOSITORY E SISTEMA ===
RUN dnf update -y && \
    dnf install -y epel-release && \
    dnf install -y https://rpms.remirepo.net/enterprise/remi-release-10.rpm

# === PHP MODULE ===
RUN dnf module reset php -y && \
    dnf module install -y php:remi-8.5

# === INSTALLAZIONE PACCHETTI BUILD ===
RUN dnf install -y \
    nodejs npm \
    # PHP CLI e estensioni necessarie per Composer
    php-cli php-common php-mbstring php-xml php-curl \
    php-zip php-bcmath php-intl php-soap php-gd \
    php-pgsql php-mysql php-ldap php-imap \
    --nobest --nogpgcheck && \
    dnf clean all && \
    rm -rf /var/cache/dnf

# Installazione di composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /root/docker

# Copia sorgenti
COPY . /root/docker

# Installa dipendenze e build assets
RUN composer install --optimize-autoloader --no-dev \
    && npm install \
    && npm run build

# ============================================
# STAGE 2: Production image
# ============================================
FROM almalinux:10 AS production

EXPOSE 80

# === REPOSITORY E SISTEMA ===
RUN dnf update -y && \
    dnf install -y epel-release && \
    dnf install -y https://rpms.remirepo.net/enterprise/remi-release-10.rpm && \
    dnf install -y https://dev.mysql.com/get/mysql84-community-release-el10-2.noarch.rpm

# === PHP MODULE ===
RUN dnf module reset php -y && \
    dnf module install -y php:remi-8.5

# === INSTALLAZIONE PACCHETTI RUNTIME ===
RUN dnf install -y \
    # Tools sistema
    supervisor \
    httpd httpd-tools \
    # Node.js (required at runtime by spatie/mjml-php)
    nodejs \
    # MySQL client
    mysql-community-client \
    # PHP - Database
    php-pgsql php-mysql \
    # PHP - Elaborazione
    php-gd php-zip php-bcmath php-soap php-intl php-ldap php-imap \
    # PHP - Cache e sessioni
    php-redis php-memcached php-msgpack php-igbinary \
    --nobest --nogpgcheck && \
    # Pulizia
    dnf clean all && \
    rm -rf /var/cache/dnf

# Micro editor
RUN curl https://getmic.ro | bash && mv micro /usr/bin/

# Crea directory necessarie
RUN mkdir -p /run/php-fpm/

# Configurazioni
COPY httpd.conf /etc/httpd/conf/
COPY php.ini /etc/php.ini
COPY supervisord.production.conf /etc/supervisord.conf

# Copy and setup entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copia applicazione dal build stage (inclusi vendor e assets compilati)
COPY --from=build /root/docker /var/www/html

WORKDIR /var/www/html

# Set entrypoint with absolute path
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

CMD ["supervisord"]