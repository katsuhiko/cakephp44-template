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


## Docker の準備

docker-compose を動かすためのファイルを用意

- ./docker-compose.yml の作成
- ./docker/ 配下の各種ファイルの作成

./docker-compose.yml に記載した環境変数のみで動くように config/app.php を変更する。


## Security Salt の生成

```
docker run --rm -it debian:10 sh -c "cat /dev/urandom | LC_CTYPE=C tr -dc '[:alnum:]' | head -c 64; echo ''; sleep 1"
```


## 基本的なライブラリの導入

```
docker exec -it alfa-app php composer.phar require robinvdvleuten/ulid
```


## mockery, phpstan の導入

```
docker exec -it alfa-app php composer.phar require --dev mockery/mockery
docker exec -it alfa-app php composer.phar require --dev phpstan/phpstan
docker exec -it alfa-app php composer.phar require --dev phpstan/phpstan-mockery
```

./phpstan.neon の編集

```
includes:
    - vendor/phpstan/phpstan-mockery/extension.neon
parameters:
    level: max
    checkMissingIterableValueType: false
    treatPhpDocTypesAsCertain: false
    paths:
        - src/
        - packages/
    excludePaths:
        - src/Console/Installer.php
```

./composer.json の script で、 check 実行時に phpstan も動くようにする。

