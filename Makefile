.DEFAULT_GOAL := help

help:
	@echo "Please choose what you want to do: \n" \
	" make dup: start docker containers \n" \
	" make ddw: stop docker containers \n" \
	" make drs: restart docker containers \n" \
	" make dci: install dependencies at app container \n" \
	" make dcu: update dependencies at app container \n" \
	" make mysql: Run interactive shell at mysql container \n" \
	" make php: run interactive shell at php container \n" \
	" make mig: manually run migrations at container \n"

build:
	cp .env.example .env;
	touch database.sqlite;
	export COMPOSE_FILE=docker-compose.yml;
	docker-compose --env-file .env up -d --build

db:
	docker exec -it php php bin/console doctrine:schema:update --force;
	docker exec -it php php bin/console doctrine:fixtures:load;

dup:
	export COMPOSE_FILE=docker-compose.yml; docker-compose up -d

ddw:
	export COMPOSE_FILE=docker-compose.yml; docker-compose down --volumes

drs:
	export COMPOSE_FILE=docker-compose.yml; docker-compose down --volumes && docker-compose up -d

dci:
	docker exec -it php composer install && sudo chown -R $(USER):$(shell id -g) vendor/

dcu:
	docker exec -it php composer update && sudo chown -R $(USER):$(shell id -g) vendor/

mysql:
	docker exec -it database bash

php:
	docker exec -it php bash

mig:
	docker exec -it php bin/console doctrine:migrations:migrate

setup: build dci db assets encore

assets:
	docker exec -it php npm install

encore:
	docker exec -it php npm run build

symfony-https:
	docker exec -it php php bin/console server:ca:install

generate-ssl:
	@mkdir -p docker/nginx/ssl
	@openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker/nginx/ssl/private_key.pem -out docker/nginx/ssl/certificate.pem


