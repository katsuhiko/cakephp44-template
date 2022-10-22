# App Alfa

## インストール

```
cd ./backend/

docker-compose up -d
docker exec -it alfa-app php composer.phar install -n
docker exec -it alfa-app ./bin/cake migrations migrate
```


## サーバー起動

```
docker-compose up -d
```


## Commit / push する前に

```
docker exec -it --env XDEBUG_MODE=coverage alfa-app php composer.phar check
```


## ローカル環境の作り直し（再インストール）

```
docker-compose down -v
docker-compose up -d
docker exec -it alfa-app php composer.phar install -n
docker exec -it alfa-app ./bin/cake migrations migrate
```


## ログ確認

```
docker logs -f alfa-app
```

