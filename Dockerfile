# Sử dụng image PHP 8.2 (phiên bản ổn định gần nhất tại thời điểm này)
FROM php:8.2-apache

# Cài đặt các extension PHP cần thiết. Lưu ý:
# ext-install đã được thay thế bằng docker-php-ext-install
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install redis && docker-php-ext-enable redis
# Bật rewrite module của Apache
RUN a2enmod rewrite


# Sao chép toàn bộ mã nguồn vào /var/www/html
COPY . /var/www/html/

# Đặt DocumentRoot về thư mục public
RUN sed -i "s|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g" /etc/apache2/sites-available/000-default.conf

# Copy .htaccess vào public nếu có
COPY public/.htaccess /var/www/html/public/.htaccess

# Expose cổng 80 (cổng mặc định của Apache)
EXPOSE 80