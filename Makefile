.PHONY: lint test

lint:
	vendor/bin/phpcs --standard=PSR12 src/ tests/

test:
	vendor/bin/phpunit --log-junit build/test-results/phpunit.xml