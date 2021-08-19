#!make
include .env
export $(shell sed 's/=.*//' .env)

# INSTALLS
update: vendor package-lock.json public/js/vendor.js
	make migrate

install: .env .env.dusk.local vendor node_modules public/js/vendor.js
	php artisan key:generate

install_db:
	echo 'CREATE DATABASE IF NOT EXISTS `$(DB_DATABASE)`' | mysql -u$(DB_USERNAME) -p$(DB_PASSWORD) -h$(DB_HOST)
	echo 'CREATE DATABASE IF NOT EXISTS `$(DB_DATABASE_TEST)`' | mysql -u$(DB_USERNAME_TEST) -p$(DB_PASSWORD_TEST) -h$(DB_HOST)
	make fresh

build_ci: .env .env.dusk.local vendor
	php artisan key:generate

# TESTS
testing:
	- make secucheck
	- ./vendor/bin/phpcs --report=summary
	- make stan

# lance un Code Sniffer
cssee:
	./vendor/bin/phpcs

# Fixe les errors + warnings du Code Sniffer
csfix:
	./vendor/bin/phpcbf -w

stan:
	./vendor/bin/phpstan analyse

psalm:
	 ./vendor/bin/psalm

metrics:
	./vendor/bin/phpmetrics --report-html=tests/quality/phpmetrics ./

secucheck:
	php security-checker.phar security:check composer.lock

# COMMANDES ARTISAN
migrate:
	php artisan migrate
	php artisan migrate --database mysql_test

rollback:
	php artisan migrate:rollback
	php artisan migrate:rollback --database mysql_test

refresh:
	php artisan migrate:refresh --seed
	php artisan migrate:refresh --database mysql_test

fresh:
	php artisan migrate:fresh --seed
	php artisan migrate:fresh --database mysql_test

# DEPENDANCES
.env:
	cp .env.example .env

.env.dusk.local:
	cp .env.example .env.dusk.local

node_modules:
	npm install

public/js/vendor.js:
	npm run dev

vendor: composer.json composer.lock
	composer install

package-lock.json:
	npm install
