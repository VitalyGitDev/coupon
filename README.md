# CouponTool
Application for WebGears interview.

## Installation instructions
N.B. 
Before you will start app installation please make sure that you have php v7.1(or above), Composer and NPM installed on your system.

#### Database preparations
Please create database and user for it in your DB Engine. You will put this info to application config in later steps.

#### WebServer preparations
Cause there was a lack of time for the app development, Application created(tested) only with using NGINX webserver, so here is config which was used for it:
```text
server {
    listen 80;
    listen 443 ssl http2;
    server_name .coupon.applic;
    root "/home/vagrant/Code/InterviewTask/coupon/public";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/coupon.applic-error.log error;

    sendfile off;

    client_max_body_size 100m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        

        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
    }

    location ~ /\.ht {
        deny all;
    }

    ssl_certificate     /etc/nginx/ssl/coupon.applic.crt;
    ssl_certificate_key /etc/nginx/ssl/coupon.applic.key;
}

``` 

#### Steps to install app 
1. Clone application from repo.
2. Open your terminal and cd to project directory.
3. Open `application/config/dbConfig.php` file for edit and put there all info needed  for successful database connection. 
4. Run `composer install` which will install all needed php dependencies.
5. Run `npm install` which will install all needed javascript dependencies.
    5.1. Maybe its will be good to run `npn run prod` to recompile frontend scripts, but by default they are already compiled "in production mode". 
6. Run `composer db:migrate` which will run all needed database migrations.
7. Probably you are ready to go!