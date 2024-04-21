### Project
PHP application using Domain-Driven Design (DDD), Command Query Responsibility Segregation (CQRS) and Hexagonal Architecture pattern with Symfony framework and Doctrine ORM.

### Setup
1. Install Docker
2. Clone the repo ```git clone https://github.com/mikebase/healtho.git```
3. Go to the project ```cd healtho```
4. Run Docker containers ```docker-compose up -d```
5. Install dependencies ```docker exec healtho composer install```
6. Build the database:
```
docker exec healtho php bin/console doctrine:database:create --if-not-exists
docker exec healtho php bin/console doctrine:migration:migrate --no-interaction
```

### Testing
You can run all th tests with ```docker exec healtho composer run-script tests```

or run them separately

ECS ```docker exec healtho ./vendor/bin/ecs check```

PHPSTAN ```docker exec healtho ./vendor/bin/phpstan analyse```

PHPUNIT ```docker exec healtho ./vendor/bin/phpunit```

### Run the app
```http://localhost:8060/```