# **PlayHub API**

## Description
PlayHub API is a REST API that allows users to manage and stream their music tracks from various platforms such as Spotify and YouTube.

## Stack
- **PHP** v8.2
- **Symfony** v7.1.5
- **PostgreSQL** v13.16
- **Docker** v26.1.3
- **Docker Compose** v2.27.1
- **Swagger**: v4.11.0

## Installation
1. **Clone repository**
   ```bash
   git clone git@github.com:marnould/playhub-api.git
2. **Install dependencies**
   ```bash
   composer install
3. **Setting up .env files**
4. **Build and start Docker containers**
   ```bash
   docker-compose up -d
5. **Start Symfony server**
   ```bash
   symfony serve
   
6. **The app can be accessed at:** http://localhost:8000.

## Documentation
Documentation of api routes is done via attributes directly in the controllers.

- The api doc can be accessed at : http://localhost:8000/api/doc.
- A Makefile exists at the project root
 
## Versionning
- Git
### Workflow
- From main to new branch
- PR on dev branch

## Routing
Routing is in ``config/routes.yaml``

## Tests
PhpUnit v11.4.1

- Unit tests -> ``tests/Unit``
- Functional tests -> ``tests/Functional``

## Architecture
This project uses a hexagonal architecture with Command Query Responsibility Segregation (CQRS) and a DomainDrivenDesign (DDD) approach, but without bounded contexts.
