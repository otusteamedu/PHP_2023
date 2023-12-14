cli:=docker compose run --rm --no-deps php-cli

php:
	$(cli) php $(filter-out $@,$(MAKECMDGOALS))

composer:
	$(cli) composer $(filter-out $@,$(MAKECMDGOALS))

