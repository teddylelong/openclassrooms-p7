# OpenClassrooms - Projet 7

Créez un web service exposant une API

[![SymfonyInsight](https://insight.symfony.com/projects/1676b05a-a5ac-4404-951d-10d3bbf94c96/mini.svg)](https://insight.symfony.com/projects/1676b05a-a5ac-4404-951d-10d3bbf94c96)

Ce dépot est un projet étudiant en cours de réalisation dans le cadre de ma formation 
_Développeur d'Applications PHP/Symfony_ avec OpenClassrooms.


## Arborescence du projet

Trois dossiers se trouvent à la racine du projet :
- `php` : Lié à Docker - contient le fichier de configuration vhost, recommandé par Symfony
- `app` : Dossier racine du projet web
- `UML` : Contient l'ensemble des diagrammes UML relatifs au projet


## Comment l'installer ?

Suivez les étapes ci-dessous afin d'effectuer une installation locale de ce projet.

### Pré-requis :

- Installez [Docker](https://docs.docker.com/get-docker/)
- Installez [Composer](https://getcomposer.org/download/)

### 1. Clonez le projet

Depuis le terminal de votre ordinateur, utilisez la commande suivante afin de copier
l'intégralité des fichiers du projet dans le dossier de votre choix :

```
cd {chemin/vers/le/projet}
git clone https://github.com/teddylelong/openclassrooms-p7.git
```

### 2. Installation des dépendances

Gardez votre terminal ouvert, toujours positionné sur le dossier du projet, et lancez cette commande
afin d'installer Symfony et l'ensemble de ses dépendances :

```
cd {chemin/vers/le/projet}/openclassrooms-p7/app/
composer install
```

### 3. Initialisez les conteneurs Docker

Depuis le dossier racine du projet, lancez la commande suivante :

```
cd {chemin/vers/le/projet/}openclassrooms-p7/
docker-compose up -d
```

Afin de prévenir de potentiels problèmes de droits d'accès, exécutez juste après cette commande :
```
sudo chown -R $USER ./
```

### 4. Générez les clés JWT

L'API BileMo étant une API privée, l'authentification sera obligatoire afin de pouvoir
l'utiliser. Il faut donc désormais générer des clés publiques et privées en exécutant
les commandes suivantes :

```
cd {chemin/vers/le/projet/}openclassrooms-p7/app/
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
Votre terminal vous demandera de saisir une phrase secrète. Saisissez celle de votre choix
et prenez soin de bien l'ajouter à votre fichier `.env`, situé dans le dossier 
`/openclassrooms-p7/app/`, comme ceci :
```
JWT_PASSPHRASE=votrePhraseSecrète
```

### 5. Création de la base de données

Nous allons désormais lancer les commandes directement depuis le conteneur Docker, pour des raisons
pratiques. Exécutez donc les commandes suivantes afin d'initialiser la base de données :

```
docker exec -it bilemo_www bash
cd app/
php bin/console doctrine:database:create
php bin/console doctrine:migration:migrate
```
Validez en saisissant « y ». La base de données est à présent prête !

### 6. Mise en place des Fixtures

Une fois l'initialisation de la base de donnée terminée, toujours depuis le conteneur Docker,
lancez la commande suivante afin de charger un jeu d'enregistrements fictifs (Fixtures) :

```
php bin/console doctrine:fixtures:load
```
Validez en saisissant « y ».

### Fin de l'installation

Le projet est à présent installé !

- Vous devriez pouvoir le tester en vous rendant sur http://localhost:8000/api.
- Accédez à PHPMyAdmin via http://localhost:8080 (Nom d'utilisateur `Root` et mot de
passe vide)


## Comptes utilisateurs

Afin de pouvoir tester l'API BileMo et ses fonctionnalités, sont mis à disposition deux comptes clients
qui disposent chacun d'un rôle différent. Utilisez-les comme bon vous semble.


| Nom d'utilisateur | Mot de passe | Rôle       |
|-------------------|--------------|------------|
| admin             | admin        | ROLE_ADMIN |
| api               | api          | ROLE_USER  |
