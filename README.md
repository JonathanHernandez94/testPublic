# Test Challenge / Laravel Docker Examples Project

## Table of Contents

- [Overview](#overview)
- [Project Structure](#project-structure)
  - [Directory Structure](#directory-structure)
  - [Development Environment](#development-environment)
  - [Production Environment](#production-environment)
- [Getting Started](#getting-started)
  - [Clone the Repository](#clone-the-repository)
  



## Overview
 Please go to the [Created](#created) and [Wishlist](#wishlist) sections to see what I just created for the challenge, the rest is just the installation instruction extended from: https://docs.docker.com/guides/frameworks/laravel/development-setup/


## Project Structure
The project is organized as a typical Laravel application, with the addition of a `docker` directory containing the Docker configurations and scripts. These are separated by environments and services. There are two main Docker Compose projects in the root directory:

- **compose.dev.yaml**: Orchestrates the development environment.
- **compose.prod.yaml**: Orchestrates the production environment.

### Directory Structure

```
project-root/ 
├── app/ # Laravel app folder
├── ...  # Other Laravel files and directories 
├── docker/ 
│   ├── common/ # Shared configurations
│   ├── development/ # Development-specific configurations 
│   ├── production/ # Production-specific configurations
├── compose.dev.yaml # Docker Compose for development 
├── compose.prod.yaml # Docker Compose for production 
└── .env.example # Example environment configuration
```
## Getting Started

Follow these steps to set up and run the Laravel Docker Examples Project:

### Prerequisites
Ensure you have Docker and Docker Compose installed. You can verify by running:

```bash
docker --version
docker compose version
```

If these commands do not return the versions, install Docker and Docker Compose using the official documentation: [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/).

### Clone the Repository

```bash
git clone https://github.com/JonathanHernandez94/testPublic.git
cd testPublic-main
```

### Setting Up the Development Environment

1. Copy the .env.example file to .env and adjust any necessary environment variables:

```bash
cp .env.example .env
```

Hint: adjust the `UID` and `GID` variables in the `.env` file to match your user ID and group ID. You can find these by running `id -u` and `id -g` in the terminal.

2. Start the Docker Compose Services:

```bash
docker compose -f compose.dev.yaml up -d
```

3. Install Laravel Dependencies:

```bash
docker compose -f compose.dev.yaml exec workspace bash
composer install
npm install
npm run dev
```

4. Run Migrations:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate --seed
```

5. Access the Application:

Open your browser and navigate to [http://localhost](http://localhost).

### Created:
1.0-) My main assumption, on which the rest of the architecture is based, was that once a user is in the system, they are within the context of the organization, which limits their access to projects within the same organization depending on their role.

### Wishlist:

1-) I would have created the notification system based on events/listeners, which is already an Observer design pattern that comes by default in the Laravel framework. For real-time notifications, I would have used WebSockets.

2-) I would have implemented pagination to maintain the required JSON standard.  

3-) I would have contributed a YAML file to provide some CI instructions in GitHub Actions when trying to merge into Develop, for example, requesting to pass all unit/integration tests and run some static code analyzers (PHPSTAN, etc.).

4-) I would have finished the remaining CRUD for TASk similar to what I did for Project.
