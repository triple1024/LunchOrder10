# Lunch_Order10

## 概要
このアプリは、小規模事務所向けの昼食の注文・在庫管理システムです。ユーザーは昼食を注文し、管理者は在庫状況をリアルタイムで管理できます。

## 主な機能
- 商品の注文、注文履歴の登録
- 商品の登録・編集・削除
- 在庫管理の表示順のカスタマイズ
- ユーザーごとのアクセス管理

## 使用技術

![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10.10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![HTML](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Node.js](https://img.shields.io/badge/Node.js-18.x-339933?style=for-the-badge&logo=node.js&logoColor=white)
![Cloudinary](https://img.shields.io/badge/Cloudinary-Cloud_Service-3448C5?style=for-the-badge&logo=cloudinary&logoColor=white)
![Heroku](https://img.shields.io/badge/Heroku-Hosting-430098?style=for-the-badge&logo=heroku&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Database-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)


## 環境構築

以下の手順に従って、ローカル環境でこのアプリケーションをセットアップしてください。

### 前提条件
- **PHP 8.1** がインストールされていること
- **Composer** がインストールされていること
- **Node.js (18.x)** がインストールされていること
- **PostgreSQL** がインストールされていること

### 手順
1. リポジトリをクローン:
    git clone https://github.com/triple1024/LunchOrder10.git
    cd LunchOrder10

2. 依存関係のインストール
    composer install
    npm install
    npm run dev

3. 環境変数の設定

    .env ファイル内で、以下の項目を設定してください

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password

    Cloudinaryの設定（画像アップロード用）

    CLOUDINARY_URL=your_cloudinary_url
    CLOUDINARY_CLOUD_NAME=your_cloudinary_cloud_name
    CLOUDINARY_API_KEY=your_cloudinary_api_key


# License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
