.PHONY: check-env up down restart rebuild

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

down:
	docker compose down --remove-orphans

restart:
	docker compose restart

rebuild: check-env
	docker compose up -d --build

