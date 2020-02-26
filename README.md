<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Setup
--------------
Clone the repo and run composer install to fetch composer dependencies

DB Config
--------------
Replace your Database username, password, database name in config/db.php

Redis Config
--------------
Replace/Remove password in $components['redis'] depending upon your Redis setup

Data Dependencies
--------------
Kept all the json data files under `data` directory


Endpoints
--------------
For populating data

    babychakra.test/populate-data/from-json?type=users
    babychakra.test/populate-data/from-json?type=articles
    babychakra.test/populate-data/from-json?type=posts

For searching data

    babychakra.test/search/data?entity_type=users&entity_id=20


Nginx Config
---------------------
    server {
        listen   80;
        root /var/www/babychakra/web;
        server_name babychakra.test;

        add_header Pragma public;
        add_header Cache-Control "public, must-revalidate, proxy-revalidate";
        
        client_header_buffer_size 32k;
        large_client_header_buffers 32 64K;
        client_max_body_size 5M;
        
        error_log /var/log/nginx/babychakra-error.log;
        access_log /var/log/nginx/babychakra-access.log;
        
        index index.php;
        location ~* \.(js|css|png|jpg|jpeg|gif|ico|woff|woff2|ttf)$ {
            expires 24h;
            log_not_found off;
        }
        
        location / {
            try_files $uri $uri/ /index.php?$args;
        }
        location /favicon {
            empty_gif;
        }
        location /downloads {
            try_files $uri $uri/ /api/index.php?$args;
        }
        location /api {
            try_files $uri $uri/ /api/index.php?$args;
        }
        error_page 500 502 503 504 /50x.html;
            location = /50x.html {
            root /usr/share/nginx/www;
        }
        location ~ \.php$ {
        include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
    }


