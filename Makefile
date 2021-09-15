# Run Docker Compose build
build:
	@if [ ! -f .env ]; then cp .env.example .env; fi;
	docker-compose build --no-cache

# Run Docker Compose up
up:
	docker-compose up -d

# Run Laravel Setup
setup:
	@docker exec -it api-dev php artisan cache:clear
	@docker exec -it api-dev php artisan key:generate
	@docker exec -it api-dev php artisan migrate
	@docker exec -it api-dev php artisan db:seed

# Run Docker Compose up and log the output in a file
debug:
	docker-compose up > server-log.txt

# Run Laravel Test
test:
	@docker exec -it api-dev php artisan test

# Run Docker Compose down
down:
	docker-compose down

# Run Docker Bash
bash:
	@docker exec -it api-dev sh
