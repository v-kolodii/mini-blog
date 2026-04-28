-include .env
export

.PHONY: up down restart rebuild composer mysql migrate seed

check-env:
	@if [ ! -f .env ]; then \
		echo ""; \
		echo "✗ .env file not found"; \
		echo ""; \
		echo "  Run: cp .env.example .env"; \
		echo "  Then edit .env and set DB credentials"; \
		echo "  After that, run 'make up' again"; \
		echo ""; \
		exit 1; \
	fi

up: check-env
	docker compose up -d
	@sleep 2
	docker compose exec -u root php chmod 777 templates_c public/uploads public/css

down:
	docker compose down --remove-orphans

restart:
	docker compose restart

rebuild: check-env
	docker compose up -d --build
	@sleep 2
	docker compose exec -u root php chmod 777 templates_c public/uploads public/css

composer:
	docker compose exec php composer $(filter-out $@,$(MAKECMDGOALS))


php-shell:
	docker compose exec php sh

mysql:
	docker compose exec mysql mysql -u${DB_USER} -p${DB_PASSWORD} ${DB_NAME}

migrate:
	docker compose exec php php bin/migrate.php

seed:
	docker compose exec php php bin/seed.php

%:
	@:
