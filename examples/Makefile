PHP_BIN:=$(shell which php)

install:
	$(PHP_BIN) ../composer.phar install

server:
	$(PHP_BIN) \-S localhost:8888 -t ./web
