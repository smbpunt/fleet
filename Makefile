.PHONY: tests

help:
	@echo "Available targets:"
	@echo ""
	@echo "Main targets (run these first):"
	@echo "  ci                    - Run complete CI pipeline (code-check + tests)"
	@echo "  code-check            - Run all code quality checks (CS, MD, Stan)"
	@echo "  tests                 - Run all tests (unit + behat)"
	@echo ""
	@echo "Modification targets (apply changes):"
	@echo "  apply-php-cs          - Apply PHP CS Fixer formatting"
	@echo ""
	@echo "Check targets (dry-run, no modifications):"
	@echo "  check-php-cs          - Check code style (dry-run)"
	@echo "  check-phpstan         - Run PHPStan static analysis"
	@echo "  check-phpmd           - Run PHP Mess Detector"
	@echo ""
	@echo "Individual test targets:"
	@echo "  behat                 - Run BDD tests with Behat"
	@echo "  unit                  - Run PHPUnit tests"
	@echo ""
	@echo "Low-level targets:"
	@echo "  php-cs-fixer          - Run PHP CS Fixer with custom arguments"
	@echo "  phpstan               - Run PHPStan with custom arguments"
	@echo "  phpmd                 - Run PHPMD with custom arguments"

#########
# CI
#########

ci:
	$(MAKE) code-check
	$(MAKE) tests

#########
# Tests
#########

behat:
	php vendor/bin/behat --strict

unit:
	php vendor/bin/phpunit

tests:
	$(MAKE) unit
	$(MAKE) behat

#########
# Quality assurance
#########

## php-cs-fixer

php-cs-fixer:
	vendor/bin/php-cs-fixer $(arguments)

apply-php-cs:
	$(MAKE) php-cs-fixer arguments="fix --using-cache=no --verbose --diff"

check-php-cs:
	$(MAKE) php-cs-fixer arguments="fix --dry-run --using-cache=no --verbose --diff"

## phpstan

phpstan:
	vendor/bin/phpstan $(arguments)

check-phpstan:
	$(MAKE) phpstan arguments="analyse --memory-limit=-1 -c .phpstan.neon"

## phpmd

phpmd:
	vendor/bin/phpmd $(arguments)

check-phpmd:
	$(MAKE) phpmd arguments="src,tests text .phpmd.xml"

code-check:
	$(MAKE) check-php-cs
	$(MAKE) check-phpmd
	$(MAKE) check-phpstan