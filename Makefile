# Run Docker Compose build
build:
	@if [ ! -f .env ]; then cp .env.example .env; fi;
	docker-compose build

# Run Docker Compose up
up:
	docker-compose up -d

# Run Laravel Setup
setup:
	@docker exec -it api-dev php artisan cache:clear
	@docker exec -it api-dev php artisan key:generate

# Run Docker Compose up and log the output in a file
debug:
	docker-compose up > server-log.txt

# Run Laravel Test
test:
	@docker exec -it api-dev php artisan test

# Run Docker Compose down
down:
	docker-compose down
