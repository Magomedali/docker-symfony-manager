prod-up:
	docker run -d --name manager-apache -p 8080:80 manager-apache

prod-down:
	docker stop manager-apache
	docker rm manager-apache

prod-build:
	docker build --pull --file=manager/docker/production/php-fpm.docker --tag ${REGISTRY_ADDRESS}/manager-php-fpm:${IMAGE_TAG} manager
	docker build --pull --file=manager/docker/production/nginx.docker   --tag ${REGISTRY_ADDRESS}/manager-nginx:${IMAGE_TAG} manager
	docker build --pull --file=manager/docker/production/php-cli.docker --tag ${REGISTRY_ADDRESS}/manager-php-cli:${IMAGE_TAG} manager
	docker build --pull --file=manager/docker/production/apache.docker  --tag ${REGISTRY_ADDRESS}/manager-apache:${IMAGE_TAG}  manager

prod-push:
	docker push ${REGISTRY_ADDRESS}/manager-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}/manager-nginx:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}/manager-php-cli:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}/manager-apache:${IMAGE_TAG}

prod-cli:
	docker run --rm manager-php-cli php bin/app.php

dev-up:
	docker network create app
	docker run -d --name manager-php-fpm -v ${PWD}/manager:/app --network=app manager-php-fpm
	docker run -d --name manager-nginx -v ${PWD}/manager:/app  -p 8000:8000 --network=app manager-nginx
	docker run -d --name manager-apache -v ${PWD}/manager:/app -p 8080:80 --network=app manager-apache

dev-compose-up:
	docker-compose up -d

dev-down:
	docker stop manager-nginx
	docker stop manager-php-fpm
	docker stop manager-apache
	docker rm manager-nginx
	docker rm manager-php-fpm
	docker rm manager-apache
	docker network remove app

dev-compose-down:
	docker-compose down --remove-orphans

dev-build:
	docker build --file=manager/docker/development/php-fpm.docker --tag manager-php-fpm manager/docker/development
	docker build --file=manager/docker/development/nginx.docker   --tag manager-nginx   manager/docker/development
	docker build --file=manager/docker/development/php-cli.docker --tag manager-php-cli manager/docker/development
	docker build --file=manager/docker/development/apache.docker --tag manager-apache manager/docker/development

dev-compose-build:
	docker-compose build

dev-compose-pull:
	docker-compose pull

dev-cli:
	docker run --rm -v ${PWD}/manager:/app manager-php-cli php bin/app.php

dev-compose-cli:
	docker-compose run --rm manager-php-cli php bin/app.php


manager-composer-install:
	docker-compose run --rm manager-php-cli composer install

manager-test:
	docker-compose run --rm manager-php-cli php bin/phpunit

manager-wait-db:
	until docker-compose exec -T manager-postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done


manager-migrations:
	docker-compose run --rm manager-php-cli php bin/console doctrine:migrations:migrate --no-interaction

manager-fixtures:
	docker-compose run --rm manager-php-cli php bin/console doctrine:fixtures:load --no-interaction

manager-init: manager-composer-install manager-wait-db manager-migrations manager-fixtures

down: dev-compose-down
test: manager-test
init: dev-compose-down dev-compose-pull dev-compose-build dev-compose-up manager-init
up: dev-compose-up
