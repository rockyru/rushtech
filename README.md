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
```
php artisan serve
127.0.0.1:8000 (default url)
```
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
```
npm run dev
visit: localhost:3000 (default url)
```

### API-based access
To test via api, you may test it  via postman
- Make a post request at **http://127.0.0.1:8000/api/login**
- Body -> raw 
```
{
    email: "admin@test.com",
    password: "password"
}
```
The backend will return token. copy paste the token and use it in every request via **Authorization: Bearer +token**

### API Routes for Admin Role
|verb |  route | description |
| ---- | ---- | ---- |
| GET | api/admin/users | Get all users |
| POST | api/admin/users | Create new user |
| POST  | api/admin/users/bulk-delete | Bulk or Multiple user delete |
| PUT or PATCH | api/admin/users/{user} | Update uswer |
| DELETE | api/admin/users/{user} | Delete single user |
| POST | api/logout | Logout |
### API Routes for User Role
|verb |  route | description |
| ---- | ---- | ---- |
| GET | api/user/profile | Get logged in user profile |
| POST | api/logout | Logout |
