# legacy-sample

このリポジトリは、以下のブログ記事の説明に使うために作られた仮想レガシープロジェクトです。

 * [ドメインを純粋に保つ (レガシープロジェクトの改善活動について)](https://blog.starbug1.com/archives/2362)
 * [ドメインを純粋に保つ (レガシープロジェクトの改善活動について) (2)](https://blog.starbug1.com/archives/2409)
 * [ドメインを純粋に保つ (レガシープロジェクトの改善活動について) (3) 完結編](https://blog.starbug1.com/archives/2426)
 * [ドメインを純粋に保つ (レガシープロジェクトの改善活動について) (4) あとがき](https://blog.starbug1.com/archives/2450)
 * [ドメインを純粋に保つ (レガシープロジェクトの改善活動について) (5) CSVダウンロード機能](https://blog.starbug1.com/archives/2492)

## Tags

 * v1.0.0 初期状態です。
 * v1.1.0 ドメインを純粋に保つ (レガシープロジェクトの改善活動について)での改善結果です。
 * v1.2.0 ドメインを純粋に保つ (レガシープロジェクトの改善活動について) (2)での改善結果です。
 * v1.3.0 ドメインを純粋に保つ (レガシープロジェクトの改善活動について) (3) 完結編での改善結果です。
 * v2.1.0 ドメインを純粋に保つ (レガシープロジェクトの改善活動について) (5) CSVダウンロード機能での改善結果です。

## Develop Environment

```
$ git clone git@github.com:smeghead/legacy-sample.git
$ docker compose up -d
$ docker compose exec app bash
# cd laravel
# composer install
```

データベースマイグレーション
```
# cp .env.example .env
# php artisan migrate:install
# php artisan migrate
```

ログファイルの権限設定
```
# chmod 666 storage/logs/laravel.log
# php artisan key:generate
```

APP_KEY生成
```
# php artisan key:generate
```

以下のURLにアクセスすると、課題一覧が表示されます。

http://localhost:8000/issue
