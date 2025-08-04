.PHONY: lint test

lint:
	vendor/bin/phpcs --standard=PSR12 src/ tests/

test:
	vendor/bin/phpunit --coverage-clover build/coverage/clover.xml --log-junit build/test-results/phpunit.xml
