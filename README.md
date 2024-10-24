# Atte（アット）
ある企業の勤怠管理システム
![image](https://github.com/user-attachments/assets/42224498-10bf-4070-a85b-b7613ce06ce1)

## 作成した目的
従業員の人事評価を行うため

## アプリケーションURL
開発環境：http://localhost/  
phpMyAdmin：http://localhost:8080/

## 機能一覧
・会員登録  
・ログイン  
・ログアウト  
・打刻ページ表示  
・勤務開始登録  
・勤務終了登録  
・休憩開始登録  
・休憩終了登録  
・日付別勤怠ページ表示  
・ページネーション  
・ユーザー一覧表示  
・ユーザー別勤怠ページ表示

## 使用技術（実行環境）
・Laravel Framework 8.83.27  
・PHP 7.4.9  
・MySQL 8.0.26  
・phpMyAdmin 5.2.1 

## テーブル設計
![image](https://github.com/user-attachments/assets/0a50fc99-af87-409f-9a44-cf11691c822b)

## ER図
![atte-er](https://github.com/user-attachments/assets/42dc327e-acb5-4f7c-a480-97e1ca8faab5)

# 環境構築
### ■セットアップ（自分で一から作成する場合）
##### 1．ディレクトリの作成
 $mkdir atte でディレクトリを作成し、以下のようなフォルダ構成にする
 ![image](https://github.com/user-attachments/assets/9944ec2b-7651-4ecb-8290-8178663301b0)  
 *data、srcはディレクトリ、Dockerfileはファイルとして作成してください  
 *ディレクトリ作成：mkdir ●●　ファイル作成：touch ●●  
##### 2．Docker-compose.yml の作成
 Githubに上がっているdocker-compose.ymlを参考にしてください
##### 3．nginx（default.conf）の作成
 Github上に上がっているdocker/nginx/default.confを参考にしてください
##### 4．PHP（Dockerfile、php.ini）の設定
 Github上に上がっているdocker/php/Dockerfile、php.iniを参考にしてください
##### 5．MySQL（my.cnf）の設定
 Github上に上がっているdocker/myaql/my.cnfを参考にしてください
##### 6．docker-compose コマンドでビルド
	$ docker compose up -d --build  
 ビルドが終了したらDocker desktopを開き、atteコンテナができているか確認する

### ■Laravelのインストール
##### 1．PHPコンテナにログイン
	$ docker compose exec php bash
##### 2．Laravelパッケージインストール 
	$ composer -v
##### 3．Laravelのプロジェクトの作成
	$ composer create-project "laravel/laravel=8.*" . --prefer-dist  
　http://localhost/	にアクセスするとLaravel のウェルカムページが表示されていれば成功。  
　Permission deniedエラーが出ている場合は、コマンドライン上で以下のコマンドを実行する  
	$ sudo chmod -R 777 src/*
 
##### 4．時間設定の編集
##### 5．.envファイルの環境変数を変更
　docker-compose.ymlで作成したデータベース名、ユーザ名、パスワードを記述する
##### 6．php artisan key:generate

### ■テーブル作成
##### 1．マイグレーションファイルの作成
	$ php artisan make:migration create_attendances_table  
	$ php artisan make:migration create_rests_table  
	_ usersテーブルについてはデフォルトのものを活用  
##### 2．カラム設定（マイグレーションファイルへの記述）  
 手順1で作成したファイルにカラムの設定を行う（参照：テーブル仕様書）  
##### 3．マイグレーションの実行  
	$ php artisan migrate
 
### ■シーディング
##### 1．シーダーファイルの作成  
	$ php artisan make:seeder AttendancesTableSeeder  
	$ php artisan make:seeder UsersTableSeeder  
##### 2．シーダーファイルの編集後、シーダーファイルの登録  
##### 3．シーディングの実行  
	$ php artisan db:seed
 
### ■Fortifyの導入
##### 1．Fortifyのインストール
	$ composer require laravel/fortify  
	$ php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"  
	$ php artisan migrate  
##### 2．app.php、FortifyServiceProvider.php、RouteServiceProvider.phpの修正
##### 3．日本語ファイルのインストール
　PHPコンテナ内で以下のコマンドを実行  
	$ composer require laravel-lang/lang:~7.0 --dev  
	$ cp -r ./vendor/laravel-lang/lang/src/ja ./resources/lang/
　
### ■メール検証用のテストサーバMailtrapの導入
##### 1．サイトへアクセスする
　https://mailtrap.io/ja/
##### 2．サインアップ
　自分の好きなアカウントでサインアップする
##### 3．ログインして設定をコピーする
　・Email Testing のMy Inboxをクリックする　
　![image](https://github.com/user-attachments/assets/dc2b9715-09f3-42c8-9449-c7cd34200456)  
　・IntegrationのCode Samplesで「PHP：Laravel7.X and 8.X」を選択し、表示されたコードをコピーする  
　![image](https://github.com/user-attachments/assets/c320fd53-0f62-48d6-afb3-addea6de91f5)  
##### 4．.envファイルに貼り付ける
　※MAIL_FROM_ADDRESSは任意のアドレスを入力する


　
