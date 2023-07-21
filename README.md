# todolist
This project is a part of my training with Openclassrooms : Application's developper - PHP/Symfony.

[![Maintainability](https://api.codeclimate.com/v1/badges/1c717b0f9404a6163203/maintainability)](https://codeclimate.com/github/jadwana/todolist/maintainability)

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/f037ea5119a34907b4a73936a21af030)](https://app.codacy.com/gh/jadwana/todolist/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
### Specs
*	PHP 8
*	Bootstrap 5
*	Symfony 6

#### Required UML diagrams
*	Use case diagrams
*	Class diagram
*	Sequence diagrams

### Requirements

*	You need to have composer on your computer
*	Your server needs PHP version 8.0
*	MySQL or MariaDB
*	Apache or Nginx

## Set up your environment
If you would like to install this project on your computer, you will first need to clone or download the repo of this project in a folder of your local server.


### Database configuration and access
1 Update DATABASE_URL .env file with your database configuration. 
ex : DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

2 Create database :
```bash
 symfony console doctrine:database:create
```

3 Create database structure : 
```bash
symfony console doctrine:migration:migrate
```
4 Insert fictive data : 
```bash
symfony console doctrine:fixtures:load
```
## Usage
If you use fictive data, you can login with following accounts :
admin account:
* username : admin
* paswword : admin

user account:
* username : user
* paswword : user

If you did not use fictive data:

* Create a user in the database
* Modify the user role in the database is you want an admin account

If you want to use test please install a test base (refer to the contribution section below)

### Congratulations, the Todolist project is now accessible at: localhost:8000

## Contribution

[Read this before contributing](https://github.com/jadwana/todolist/contribution.md)
