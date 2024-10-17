DOCKER = docker-compose

###> Docker-compose ###
dbuild:
	$(DOCKER) build --no-cache

dup:
	$(DOCKER) up -d

ddown:
	$(DOCKER) down

dlogs:
	$(DOCKER) logs -f
###< Docker-compose ###