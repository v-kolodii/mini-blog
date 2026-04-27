.PHONY: check-env up down restart rebuild composer permissions

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

up: check-env permissions
	docker compose up -d

down:
	docker compose down --remove-orphans

restart:
	docker compose restart

rebuild: check-env permissions
	docker compose up -d --build

composer:
	docker compose exec php composer $(filter-out $@,$(MAKECMDGOALS))

permissions:
	chmod -R 777 templates_c public/css public/uploads


