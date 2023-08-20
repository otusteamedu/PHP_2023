test:
	bash ./test_cases.sh

test-curl-arg:
	curl http://localhost:8181/ -d string='()'

test-curl-post-json-arg-string:
	curl -X POST -H "Content-Type: application/json" -d '{"string": "()()()"}' http://0.0.0.0:8181/

test-curl-post-arg-serialize-string:
	curl -X POST -d '{"string": "()()()"}' http://0.0.0.0:8181/

test-curl-post-arg-string:
	curl -X POST -d string="()()()" http://0.0.0.0:8181/

test-curl-post-empty-all:
	curl -X POST http://0.0.0.0:8181/

test-curl-post-arg-url:
	curl -X POST  http://0.0.0.0:8181/\?str\=\(\)

test-curl-all:
	make test-curl-arg
	@echo ''
	make test-curl-post-json-arg-string
	@echo ''
	make test-curl-post-arg-serialize-string
	@echo ''
	make test-curl-post-arg-string
	@echo ''
	make test-curl-post-empty-all
	@echo ''
	make test-curl-post-arg-url
	@echo ''

test-php-clint-ok:
	php php_client_send_json/index.php 'http://0.0.0.0:8181' '()()'

test-php-clint-error:
	php php_client_send_json/index.php 'http://0.0.0.0:8181' '())()'

