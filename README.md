# Mini Blog

Simple blog application with categories and posts, written in plain PHP.

## Stack

- PHP 8.3 (FPM)
- MySQL 8.0
- Smarty 5
- Nginx
- Docker Compose
- SCSS (Dart Sass)

## First run

1. `cp .env.example .env` - set up DB credentials in the new created file
2. `make up` - start the containers (build runs automatically on the first launch)
3. `make composer install` - install PHP dependencies
4. `make migrate` - create database tables
5. `make seed` - populate database with sample data
6. Open <http://localhost:8080>

## Commands

- `make up` - start project
- `make down` - stop


If you need to restart the database from scratch (for example, after changing .env): 
- `docker compose down -v && make up`
