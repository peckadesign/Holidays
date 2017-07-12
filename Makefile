.PHONY: build-staging
.PHONY: clean
.PHONY: clean-cache
.PHONY: cs


build-staging:
	- composer install --no-interaction -o -a --no-suggest


clean:
	git clean -xdf .


clean-cache:
	git clean -xdf tests/


run-tests:
	git clean -xdf tests/
	composer install --no-interaction
	- vendor/bin/tester -p php -c tests/php.ini -o tap tests > output.tap
	git clean -xdf tests/


cs:
	git clean -xdf output.cs output-strict.cs
	- vendor/bin/phpcs src/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandard/ruleset.xml --report-file=output.cs
	- vendor/bin/phpcs src/ --standard=vendor/pd/coding-standard/src/PeckaCodingStandardStrict/ruleset.xml --report-file=output-strict.cs
	- test -f output-strict.cs && cat output-strict.cs >> output.cs && rm output-strict.cs
