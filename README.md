# Atte（アット）
ある企業の勤怠管理システム
![image](https://github.com/user-attachments/assets/42224498-10bf-4070-a85b-b7613ce06ce1)

## 作成した目的
従業員の勤怠管理・人事評価を行うため

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
### ■Dockerビルド
##### 1．任意の場所でリポジトリをクローンする（コマンドライン）
	$ git clone git@github.com:myajima0618/atte.git

##### 2．リモートリポジトリの作成（GitHub）
##### 3．リモートリポジトリの紐付け先を変更する（コマンドライン）

	$ git remote set-url origin **作成したリポジトリのurl**
　
 リポジトリのurlについては、2で作成したリモートリポジトリのページに記載されているリンクをコピーする。  
 SSH を選択しているかどうかをしっかりチェックすること。  
 ＊実行前に現状のリンクを確認するコマンドを実行しておくと確認がスムーズになる。  
 
	$ git remote -v
 
##### 4．紐づけが成功しているかの確認（コマンドライン）
　以下コマンドを実行し、紐づけ先が自分の作成したURLになっていれば成功。  
 
	$ git remote -v
 
##### 5．現在のローカルリポジトリのデータをリモートリポジトリに反映させておく（コマンドライン）
	$ git add .
	$ git commit -m "リモートリポジトリの変更"
	$ git push origin main

##### 6．docker-compose コマンドでビルド
	$ docker compose up -d --build  
 ビルドが終了したらDocker desktopを開き、atteコンテナができているか確認する

### ■Laravelのインストール
##### 1．PHPコンテナにログイン
	$ docker compose exec php bash
##### 2．Laravelパッケージインストール 
	$ composer install
##### 3．.env.exampleファイルから.envファイルを作成
	$ cp .env.example .env
##### 4．.envファイルの環境変数を変更
　docker-compose.ymlで設定されているデータベース名、ユーザ名、パスワードを記述する
##### 5．アプリケーションキーの設定（コマンドライン）
	$ php artisan key:generate
##### 6．phpMyAdminでデータベースの存在確認（ブラウザ）
　http://localhost:8080/	にアクセスし、設定したDBが表示されていれば成功。

### ■テーブル作成（以下で作成するファイルがすでに存在している場合は作成不要）
##### 1．マイグレーションファイルの作成（コマンドライン）
	$ php artisan make:migration create_attendances_table  
	$ php artisan make:migration create_rests_table  
	_ usersテーブルについてはデフォルトのものを活用  
##### 2．カラム設定（マイグレーションファイルへの記述）  
 手順1で作成したファイルにカラムの設定を行う（参照：テーブル仕様書）  
##### 3．マイグレーションの実行（コマンドライン）  
	$ php artisan migrate
 
### ■ダミーレコードの作成（以下で作成するファイルがすでに存在している場合は作成不要）
##### 1．シーダーファイルの作成（コマンドライン）  
	$ php artisan make:seeder AttendancesTableSeeder  
	$ php artisan make:seeder UsersTableSeeder  
##### 2．ファクトリの作成（エディタ）
 
	$ php artisan make:factory AttendanceFactory
	$ php artisan make:factory RestFactory
	$ php artisan make:factory UserFactory

　definitonメソッドの中の [] のなかにデータの定義をする  
##### 3．ファクトリのシーダーへの設定（エディタ）
　AttendancesTableSeeder・UsersTableSeederファイルに設定する  
　50ユーザー、直近1ヶ月のデータ1500レコード作成  
  必要に応じて設定を変更しても問題ない。
##### 4．シーディングの実行（コマンドライン）  
	$ php artisan db:seed
 
### ■Fortifyの導入
##### 1．Fortifyのインストール（コマンドライン：PHPコンテナ内）
	$ composer require laravel/fortify  
	$ php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"  
	$ php artisan migrate  
##### 2．app.phpの修正
###### ロケールの変更
	- 'locale' => 'en',
	+ 'locale' => 'ja',

###### プロバイダーの追加
	
	'providers' => [
		// 中略
		  App\Providers\RouteServiceProvider::class,
		+ App\Providers\FortifyServiceProvider::class,
	]

##### 3．FortifyServiceProvider.phpの修正
###### 以下を削除
	public function boot()
	{
	Fortify::createUsersUsing(CreateNewUser::class);
	-         Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
	-         Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
	-         Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
	
	-         RateLimiter::for('login', function (Request $request) {
	-             $email = (string) $request->email;
	
	-             return Limit::perMinute(5)->by($email.$request->ip());
	-         });
	
	-         RateLimiter::for('two-factor', function (Request $request) {
	-             return Limit::perMinute(5)->by($request->session()->get('login.id'));
	-         });
	}
###### 以下を追加
	public function boot(): void
	{
		Fortify::createUsersUsing(CreateNewUser::class);
		        
		Fortify::registerView(function() {
		        return view('auth.register');
		});
		
		Fortify::loginView(function () {
		        return view('auth.login');
		});
		
		RateLimiter::for('login', function (Request $request) {
		        $email = (string) $request->email;
		
		        return Limit::perMinute(10)->by($email . $request->ip());
		});
	}
##### 4．RouteServiceProvider.phpの修正
###### ログイン後のリダイレクト先の変更
	- public const HOME = '/dashboard';
	+ public const HOME = '/';

##### 5．日本語ファイルのインストール
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


　
