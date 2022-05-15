## How to use this base code

Source of knowledge:
[Jetstream/Fortify Multi-Auth: Roles, Permissions and Guards](https://www.youtube.com/watch?v=NiQSNjWKLfU)  by Laravel Daily, with customisation for our project.

## Notes
- uses PHP 8.x (get this up in your machine first)
- uses Laravel 9.x
- uses Laravel Jetstream
- the cloned project is ready for use; no need to do anything else
- no need for Guards; just use Roles and Permissions 
- avoid joining tables
- each Role has a Controller
- 1 middleware will group all routes
- for debugging, you need to set up the IDE that you are using yourself
- use the Users table to store all users of different roles by adding a column named 'role_id'
- 1 new table 'Roles' is created
- all Roles share the same dashboard route; only in other areas then each Role has its own /Role/route

## Steps

Let's get started. You should follow these steps to get it up and running in your local dev.

- GitHub clone this project
- php artisan migrate
- php artisan db:seed --class=RoleSeeder ▶️ this will seed the Roles table. You need this data before you can create new accounts as app/Actions/Fortify/CreateNewUser.php will look up this table 

## Useful commands
- php artisan make:model Role -m ▶️ this will generate \Database\Migrations\XXXXX_create_roles_table.php
- php artisan make:seeder RoleSeeder ▶️ this will generate \Database\Seeders\RoleSeeder.php
- php artisan make:migration add_roles_fields_to_users_table ▶️ this will generate \Database\Migrations\XXXXX_add_roles_to_users_table.php
