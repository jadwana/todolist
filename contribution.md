# Contribute to the project

## Preamble
You can intervene on the project at any time to offer new functionalities, report a bug or
why not new implementations which would serve to make the code evolve in a relevant way.

Before starting to work on a change, see if someone is already on it by checking if there is not already an issue or pull request.

## Install project on your machine:

Make a fork of the project Github directory

Follow the [README](./README.md) and after come back here

## Path to follow :
Before creating your issue there are a set of rules to respect: 
- Use the issue title to clearly describe the problem 
- Use the bug or feature label for your issue 
- Give as many details as possible about your environment (OS, version of PHP, extensions ...) 
- Describe the steps to reproduce the bug or the details and usefulness of the new feature
- Suggest your issue 
- Create a new branch, so you can work on it 
- Start implementing your code
- Commit it
- Create a new pull-request and suggest it to us

If the code is suitable and functional you will be able to merge your new functionality

## Some rules :

- Respect PSR 
- Your code must be clear and readable
- Written with a PHP version identical to the project
- And above all your code must be reusable
- For the quality of the code, use the CODACY or/and codeclimate tool and phpcodesniffer

## Quality process :

### Tests

For safety reasons, it is preferable to use a test database.


* Modify the .env.test file by copying the DATABASE_URL from the .env.local file
  
* Create the database and play the migrations

```bash
symfony console doctrine:database:create --env=test
```
```bash
symfony console doctrine:migrations:migrate -n --env=test
```
* Load test data for test environment/database:
```bash
symfony console doctrine:fixtures:load --env=test
```
* Tests can be run :
  
Either by passing the path of their class as an argument, for example:
```bash
symfony php bin/phpunittests/Controller/UserControllerTest.php
```
Or by filtering a particular test, for example:
```bash
vendor/bin/phpunit --filter=testhomepage
```
Or all at the same time by not putting a filter

You must run the tests after each modification, or create new ones if necessary

### Code coverage:

```bash
vendor/bin/phpunit --coverage-html public/test-coverage
```
The report is available in html format at the address below
http://127.0.0.1:5500/public/test-coverage/index.html
