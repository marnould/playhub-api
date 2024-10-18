###> ANSI color codes
GREEN := \033[0;32m
RED := \033[0;31m
YELLOW := \033[0;33m
RESET := \033[0m
BOLD := \033[1m
###< ANSI color codes

###> Globals
DOCKER = docker-compose
PHPUNIT = ./vendor/bin/phpunit
MAKEINFO = $(MAKE) info
###< Globals

###> Internal
info:
	@echo "$(GREEN)$(BOLD)$(info)$(RESET)"
warning:
	@echo "$(YELLOW)$(BOLD)$(warning)$(RESET)"
###< Internal

###> Docker-compose ###
dbuild:
	$(MAKEINFO) info="Docker build"
	$(DOCKER) build --no-cache

dup:
	$(MAKEINFO) info="Docker up"
	$(DOCKER) up -d

ddown:
	$(MAKEINFO) info="Docker down"
	$(DOCKER) down

dlogs:
	$(MAKEINFO) info="Unit Tests"
	$(DOCKER) logs -f

dbuildup: dbuild dup
###< Docker-compose ###

###> PhpUnit ###
testu:
	$(MAKEINFO) info="Unit Tests"
	$(PHPUNIT) --testsuite "unit"

testf:
	$(MAKEINFO) info="Functional Tests"
	$(PHPUNIT) --testsuite "functional"

test: testu testf
###< PhpUnit ###
