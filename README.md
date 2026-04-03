📄 AI‑Based Personalized Food Recommendation System

This is a Laravel‑based Food Ordering and Recommendation System built with modern PHP & database features.
Follow the steps below to run this project locally.

🚀 Features

✔ User Authentication
✔ Food Recommendations
✔ Ordering System
✔ Admin Dashboard (if included)
✔ MySQL Database
✔ Uses Laravel & Vite for frontend assets

📌 Requirements

You must have these installed:

✔ PHP 8.2 or newer
✔ Composer
✔ MySQL (or MariaDB)
✔ Node.js & npm
✔ Git
✔ Local server environment (XAMPP, WAMP, Laragon, etc.)



📥 1. Clone the Repository
git clone https://github.com/KajaniKunasegaram/AI-Based-Personalized-Food-Recommendation-System.git
cd AI-Based-Personalized-Food-Recommendation-System



📦 2. Install Dependencies

Install PHP dependencies:
composer install
Install Node.js dependencies:
npm install


🛠 3. Setup Environment File
copy .env.example .env 


🗒 4. Configure Your .env

Open .env and update settings as follows:

APP_NAME="FoodOrderingApp"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_ordering_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

MAIL_MAILER=log

VITE_APP_NAME="${APP_NAME}"



🔑 5. Generate Laravel App Key
php artisan key:generate


🗃 6. Run Database Migrations
php artisan migrate


▶ 7. Start Laravel Server
php artisan serve

Open your browser and visit:
👉 http://127.0.0.1:8000
