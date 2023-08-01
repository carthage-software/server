#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ] || [ "$1" = '/usr/bin/supervisord' ]; then
	# Install the project the first time PHP is started
	# After the installation, the following block can be deleted
	if [ ! -f composer.json ]; then
		CREATION=1

		rm -Rf tmp/
		composer create-project "symfony/skeleton $SYMFONY_VERSION" tmp --stability="$STABILITY" --prefer-dist --no-progress --no-interaction --no-install

		cd tmp
		composer require "php:>=$PHP_VERSION"
		composer config --json extra.symfony.docker 'true'
		cp -Rp . ..
		cd -

		rm -Rf tmp/
	fi

	if [ "$APP_ENV" != 'prod' ]; then
		composer install --prefer-dist --no-progress --no-interaction
	fi

	if grep -q ^DATABASE_URL= .env; then
		# After the installation, the following block can be deleted
		if [ "$CREATION" = "1" ]; then
			echo "To finish the installation please press Ctrl+C to stop Docker Compose and run: docker compose up --build"
			sleep infinity
		fi

		echo "Waiting for PostgreSQL to be ready..."
		ATTEMPTS_LEFT_TO_REACH_DATABASE=30
		until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(php bin/console dbal:run-sql "SELECT 1" 2>&1); do
			if [ $? -eq 255 ]; then
				# If the Doctrine command exits with 255, an unrecoverable error occurred
				ATTEMPTS_LEFT_TO_REACH_DATABASE=0
				break
			fi
			sleep 1
			ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
			echo "Still waiting for PostgreSQL to be ready... Or maybe the PostgreSQL is not reachable. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left"
		done

		if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
			echo "The database is not up or not reachable:"
			echo "$DATABASE_ERROR"
			exit 1
		else
			echo "The PostgreSQL is now ready and reachable"
		fi

		echo "Waiting for RabbitMQ to be ready..."
		ATTEMPTS_LEFT_TO_REACH_RABBITMQ=30
		until [ $ATTEMPTS_LEFT_TO_REACH_RABBITMQ -eq 0 ] || RABBITMQ_ERROR=$(php bin/console messenger:stats 2>&1); do
			sleep 1
			ATTEMPTS_LEFT_TO_REACH_RABBITMQ=$((ATTEMPTS_LEFT_TO_REACH_RABBITMQ - 1))
			echo "Still waiting for RabbitMQ to be ready... Or maybe RabbitMQ is not reachable. $ATTEMPTS_LEFT_TO_REACH_RABBITMQ attempts left"
		done

		if [ $ATTEMPTS_LEFT_TO_REACH_RABBITMQ -eq 0 ]; then
			echo "RabbitMQ is not up or not reachable:"
			echo "$RABBITMQ_ERROR"
			exit 1
		else
			echo "RabbitMQ is now ready and reachable"
		fi

		php bin/console doctrine:migrations:migrate --no-interaction
	fi

	setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var
fi

exec docker-php-entrypoint "$@"

