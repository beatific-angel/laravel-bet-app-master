# Bet App

## Requirements

- Laravel 5.8
- Mysql >= 5.7

## Installation du projet

To install, simply run :

`make install`

Set your databases credentials inside .env file, then run : 

`make install_db`

Project is installed and ready to use !


## Update

To update project, for example when you switch branches, run :

`make update`

## Quality

Some quality packages are installed on project :

- **phpcs**  
  Code quality, syntax  
  [Github repository](https://github.com/squizlabs/PHP_CodeSniffer)  
  *Run* : `make cssee` or `./vendor/bin/phpcs`  
  *Fix* : `make csfix` or `./vendor/bin/phpcbf -w`  
  *Configuration file* : `/phpcs.xml`  

- **phpstan** (via Larastan)  
  Static analysis  
  [Github repository](https://github.com/nunomaduro/larastan)  
  *Run* : `make stan` or `php artisan code:analyse`  
  *Configuration* : `/phpstan.neon`  
  
- **SensioLabs Security Checker**  
  Composer dependencies security analysis  
  [Github repository](https://github.com/sensiolabs/security-checker)  
  *Run* : `./vendor/bin/security-checker security:check`  
  
- **Phpunit**  
  Unit and functionnal testing  
  [Laravel testing Documentation](https://laravel.com/docs/5.7/testing)  
  [Laravel http testing Documentation](https://laravel.com/docs/5.7/http-tests)  
  *Run* : `phpunit [--filter <filename>]`  
  *Configuration* : `phpunit.xml`   

## Commands

- `make testing` : run all tests
- `make migrate` : run migrate --seed on dev DB and migrate on testing DB
- `make refresh` : run migrate:refresh --seed on dev DB and migrate:refresh on testing DB
- `make fresh` : run migrate:fresh --seed on dev DB and migrate:fresh on testing DB