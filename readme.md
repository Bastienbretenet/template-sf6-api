# Projet Symfony 6 avec Docker

Ce projet Symfony 6 utilise Docker pour faciliter la configuration de l'environnement de développement. Le fichier Makefile fournit une série de commandes utiles pour la gestion du projet.

#### Information sur le projet

Ce projet Symfony 6 nécessite PHP version 8.1 ou supérieure et utilise [API Platform](https://api-platform.com/), un framework qui facilite la création d'API REST. 

L'application propose uniquement de créer, modifier et supprimer des utilisateurs avec les droits d'accès qui leur sont associés. Il y a aussi une série de tests fonctionnels pour vérifier le bon fonctionnement des fonctionnalités de connexion et des quatre méthodes HTTP : 'DELETE', 'POST', 'GET' et 'PUT'. Ces tests garantissent la stabilité et la conformité de l'API.

N'hésitez pas à explorer le code source du projet pour découvrir les détails de mise en œuvre des fonctionnalités et des tests fonctionnels.

## Configuration Docker

Assurez-vous d'avoir Docker et Docker Compose installés sur votre machine avant de commencer.

### Les containers

Vous pouvez modifier les containers Docker directement dans le fichier `docker-compose.yml` à la racine du projet. Pour les renommer vous pouvez modifier la variable `container_name` de chaque service.

Vous pouvez également vous connecter à n'importe quel container en utilisant son nom et la commande suivante : 

`docker exec -ti 'container_name' bash`

Pour plus d'informations sur les commandes Docker vous pouvez consulter leur [documentation](https://docs.docker.com/engine/reference/commandline/docker/).

## Installation

1. Clonez ce dépôt sur votre machine locale.
2. Assurez-vous que Docker est en cours d'exécution.
3. Exécutez la commande suivante pour démarrer l'application et lancer les conteneurs Docker :
`make start`

4. Installez les dépendances à l'aide de Composer :
`make composer-install`

5. Générez la paire de clés JWT Lexik :
`make start`

6. Accédez à l'application à l'adresse suivante : [http://127.0.0.1:8000/](http://127.0.0.1:8000/).

## Commandes utiles

- `make cache-clear` : Efface le cache de l'application.
- `make tests` : Exécute tous les tests (tests unitaires et tests fonctionnels).
- `make unit-test` : Exécute les tests unitaires.
- `make functional-test` : Exécute les tests fonctionnels.
- `make stop` : Arrête l'application (arrête les conteneurs Docker).

## Gestion de la base de données

- `make database-init` : Initialise la base de données (supprime et recrée la base de données, effectue les migrations et charge les fixtures).
- `make migration` (ou `make database-migration`) : Crée une migration.
- `make migrate` (ou `make database-migrate`) : Exécute les migrations.
- `make fixtures` (ou `make database-fixtures-load`) : Charge les fixtures.

## Accès à phpMyAdmin

Un conteneur phpMyAdmin est également configuré pour faciliter la gestion de la base de données. Vous pouvez y accéder à l'adresse suivante : http://127.0.0.1:8080/. 

## Autres commandes

- `make help` : Affiche la liste des commandes disponibles.

**Remarque :** Assurez-vous d'avoir les droits d'exécution sur le fichier Makefile. Si nécessaire, exécutez la commande suivante :
`chmod +x Makefile`
Cela permettra d'exécuter les commandes via le fichier Makefile.
