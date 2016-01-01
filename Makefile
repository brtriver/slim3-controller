PHP_BIN:=$(shell which php)
CURL_BIN:=$(shell which curl)

PHPUNIT:=phpunit.phar

all:test

setup: composer.phar phpunit.phar

composer.phar:
	$(PHP_BIN) -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"

phpunit.phar:
	$(CURL_BIN) -SsLO https://phar.phpunit.de/phpunit.phar

install:
	$(PHP_BIN) composer.phar install

demo:
	make -C ./examples

test:
	$(PHP_BIN) $(PHPUNIT) --colors ./tests
