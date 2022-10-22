# New Backend Project

## CakePHP プロジェクトの作成

```
cd .
docker run --rm -it -v "$(pwd):/home/app" -w /home/app katsuhikonagashima/php-fpm-base:8.1-bullseys /bin/bash
```

```
curl -sS https://getcomposer.org/installer | php

php composer.phar create-project --prefer-dist cakephp/app:4.* backend
mv composer.phar ./backend/
exit
```
