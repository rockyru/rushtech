# Installaion

- Clone repository
``
git clone https://github.com/rockyru/rushtech.git
``
- Note: Laravel 12 requires php 8.4

### Back End Setup
After cloning the repository, change directory to **backend** folder
```sh
cd backend
composer install
cp .env.example .env
php artisan key:generate
```
Update **.env** file to your database credentials and also the allowed frontend url
| .env key | value |
| ------ | ------ |
| DB_DATABASE | your_database_name |
| DB_USERNAME | your_database_username |
| DB_PASSWORD | your_database_password |
| SANCTUM_STATEFUL_DOMAINS| localhost:3000 //your front end application url here|

Run migration with seed
``
php artisan migrate --seed
``



Update config/cors.php -> allowed_origins key:
| key | value |
| ----- | ----- |
| allowed_origins | front_end_application_url |

### Default Admin Credentials
-username: admin@test.com
-password: password

#### Run the application
``
php artisan serve
``
### Front End Setup
Change directory to **frontend** folder
Assuming you are in backend folder:
```
cd ..
cd frontend
npm install
```

If you are in the root folder(rushtech):
```
cd frontend
npm install
```
Update **src/services/api.ts**, find and replace the value for **baseUrl** with the backend url(after running php artisan serve)
  **baseURL: 'http://127.0.0.1:8000/'**
 

#### Run the application
``
npm run dev
``
