# todolist
This project is a part of my training with Openclassrooms : Application's developper - PHP/Symfony.

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
1 Update DATABASE_URL .env file with your database configuration. ex : DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
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

* Create a user account with sign up form
* Modify the user role in the database is you want an admin account

### Congratulations, the Todolist project is now accessible at: localhost:8000

## Contribution

[Lisez ceci avant de contribuer](https://github.com/jadwana/todolist/contribution.md)

Utiliser une base de données de test

Avant de pouvoir lancer les tests, nous devons "initialiser" la base de données test
modifiez le fichier .env.test en copiant la DATABASE_URL du fichier .env.local
créez la base de données et jouez les migrations
symfony console doctrine:database:create --env=test
symfony console doctrine:migrations:migrate -n --env=test

Chargez les données de test pour l'environnement/la base de données de test :
symfony console doctrine:fixtures:load --env=test

les tests peuvent etre lancés 
soit en passant le chemin de leur classe en argument par ex :
symfony php bin/phpunit tests/Controller/UserControllerTest.php

soit en filtrant un test particulier par ex :
vendor/bin/phpunit --filter=testhomepage

soit tous à la fois en ne mettant pas de filtre

couverture de code :
vendor/bin/phpunit --coverage-html public/test-coverage

le rapport est accessible au format html à l'adresse ci-dessous
http://127.0.0.1:5500/public/test-coverage/index.html