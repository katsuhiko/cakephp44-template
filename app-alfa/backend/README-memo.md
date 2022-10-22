# Rule


## モデルの作成

```
docker exec -it alfa-app bin/cake bake model Tasks
```


## コントローラーの作成

```
docker exec -it alfa-app bin/cake bake controller Task --prefix Api
```


## DBマイグレーション

```
docker exec -it alfa-app bin/cake bake migration CreateTasks
docker exec -it alfa-app bin/cake migrations migrate
docker exec -it alfa-app bin/cake migrations rollback
```

- マイグレーションファイル名のパターン
    - https://book.cakephp.org/migrations/3/en/index.html#migrations-file-name

| パターン | 説明 | 例 |
| --- | --- | --- |
| (/^(Create)(.*)/)           | テーブル作成 | CreateTasks                |
| (/^(Drop)(.*)/)             | テーブル削除 | DropTasks                  |
| (/^(Add).*(?:To)(.*)/)      | カラム追加   | AddDescriptionToTasks      |
| (/^(Remove).*(?:From)(.*)/) | カラム削除   | RemoveDescriptionFromTasks |
| (/^(Alter)(.*)/)            | テーブル変更 | AlterTasks                 |
| (/^(Alter).*(?:On)(.*)/)    | カラム変更   | AlterDescriptionOnTasks    |

- change メソッドで使えるコマンド
    - https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method

```
createTable
renameTable
addColumn
renameColumn
addIndex
addForeignKey
```


## ライブラリの最新化

## PHP

```
docker exec -it alfa-app php composer.phar update
```
