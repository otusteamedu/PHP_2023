.PHONY: init
init:
	chmod +x calc.sh
	chmod +x getSortedCities.sh

.PHONY: calc
calc:
	@read -p "Enter value #1: " arg1; \
	read -p "Enter value #2: " arg2; \
	./calc.sh $$arg1 $$arg2


.PHONY: sort_cities
sort_cities:
	@echo "Отсортированные по популярности города представлены ниже:"; \
	./getSortedCities.sh
