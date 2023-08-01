.DEFAULT_GOAL := help

DC = docker compose
EXEC = $(DC) exec php
COMPOSER = $(EXEC) composer

ifndef CI_JOB_ID
	RED	:= $(shell tput -Txterm setaf 1)
	GREEN  := $(shell tput -Txterm setaf 2)
	YELLOW := $(shell tput -Txterm setaf 3)
	RESET  := $(shell tput -Txterm sgr0)
	TARGET_MAX_CHAR_NUM=30
endif

help:
	@echo "Carthage ${GREEN}Server${RESET}"
	@awk '/^[a-zA-Z\-_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")-1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "  ${GREEN}%-$(TARGET_MAX_CHAR_NUM)s${RESET} %s\n", helpCommand, helpMessage; \
		} \
		isTopic = match(lastLine, /^###/); \
	    if (isTopic) { \
			topic = substr($$1, 0, index($$1, ":")-1); \
			printf "\n${YELLOW}%s${RESET}\n", topic; \
		} \
	} { lastLine = $$0 }' $(MAKEFILE_LIST)

#################################
Project:

## Enter the application container
php:
	@$(EXEC) sh

## Enter the consumer container
consumer:
	@$(DC) exec consumer sh

## Enter the database container
database:
	@$(DC) exec database psql -Uapp app

## Install the whole dev environment
install:
	@$(DC) build
	@$(MAKE) start -s
	@$(MAKE) vendor -s
	@$(MAKE) db-reset -s

## Install composer dependencies
vendor:
	@$(COMPOSER) install --optimize-autoloader

## Start the project
start:
	@$(DC) up -d --remove-orphans --no-recreate

## Stop the project
stop:
	@$(DC) stop
	@$(DC) rm -v --force

.PHONY: php database install vendor start stop

#################################
Database:

## Create/Recreate the database
db-create:
	@$(EXEC) php bin/console doctrine:database:drop --force --if-exists -nq
	@$(EXEC) php bin/console doctrine:database:create -nq

## Migrate the database
db-migrate:
	@$(EXEC) php bin/console doctrine:migrations:migrate -n

## Load fixtures
db-fixtures:
	@$(EXEC) php bin/console doctrine:fixtures:load -n

## Reset database
db-reset: db-create db-migrate

.PHONY: db-create db-update db-reset

#################################
Tests:

## Run code style check
php-cs-fixer:
	@$(EXEC) php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --dry-run --diff -vvv

## Run psalm static analysis
psalm:
	@$(EXEC) php vendor/bin/psalm -c psalm.xml --no-cache
	@$(EXEC) php vendor/bin/psalm -c psalm.xml --taint-analysis --no-cache

## Run Unit test suite
test-unit:
	@$(EXEC) php vendor/bin/phpunit -c phpunit.xml.dist --testsuite=Unit

## Run Functional test suite
test-functional:
	@$(EXEC) php bin/console doctrine:database:drop --if-exists -f -n --env=test
	@$(EXEC) php bin/console doctrine:database:create -n --env=test
	@$(EXEC) php bin/console doctrine:migrations:migrate -n --env=test
	# @$(EXEC) php bin/console doctrine:fixtures:load -n --env=test
	@$(EXEC) php -dmemory_limit=-1 vendor/bin/phpunit -c phpunit.xml.dist --testsuite=Functional

## Run All test suites
test:
	@$(EXEC) php bin/console doctrine:database:drop --if-exists -f -n --env=test
	@$(EXEC) php bin/console doctrine:database:create -n --env=test
	@$(EXEC) php bin/console doctrine:migrations:migrate -n --env=test
	# @$(EXEC) php bin/console doctrine:fixtures:load -n --env=test
	@$(DC) exec -e XDEBUG_MODE=coverage php php -dmemory_limit=-1 vendor/bin/phpunit -c phpunit.xml.dist --coverage-text --colors=always --stop-on-failure --disable-coverage-ignore

## Run static analysis and all test suites
ci: php-cs-fixer psalm test

.PHONY: php-cs-fixer psalm test-unit test-functional test ci

#################################
Tools:

## Fix PHP files to be compliant with coding standards
fix-cs:
	@$(EXEC) php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --diff -vvv

.PHONY: fix-cs
