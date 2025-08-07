lint:
	./vendor/bin/phpcs --standard=PSR12 src tests
test:
	./vendor/bin/phpunit --colors=always