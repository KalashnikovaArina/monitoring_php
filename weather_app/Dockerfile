FROM php:8.2-apache
WORKDIR /var/www/html
COPY app/ /var/www/html/
RUN a2enmod rewrite
RUN apt-get update && apt-get install -y --no-install-recommends curl \
    && rm -rf /var/lib/apt/lists/*
HEALTHCHECK --interval=30s --timeout=5s --retries=3 \
    CMD curl -fsS http://localhost/ || exit 1