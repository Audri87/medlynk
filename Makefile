.PHONY: qa cs cs-fix stan rector deptrac test

## Quality assurance — run all checks
qa: cs stan deptrac test

## Check code style (dry-run)
cs:
	vendor/bin/php-cs-fixer fix --dry-run --diff

## Fix code style
cs-fix:
	vendor/bin/php-cs-fixer fix

## Static analysis
stan:
	vendor/bin/phpstan analyse --memory-limit=512M

## Architecture constraints
deptrac:
	vendor/bin/deptrac analyse

## Automated refactoring (dry-run)
rector:
	vendor/bin/rector process --dry-run

## Apply rector
rector-fix:
	vendor/bin/rector process

## Tests
test:
	php bin/phpunit

test-domain:
	php bin/phpunit tests/Domain/

test-integration:
	php bin/phpunit tests/Integration/
