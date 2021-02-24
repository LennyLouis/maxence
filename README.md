# Symfony

## Installation

Installation du **framework** symfony

```
composer create-project symfony/website-skeleton symfony
```

Installation du **serveur** pour lancer le projet

```
composer require server --dev
```


## Lancer le serveur

Lancer le serveur php sur **<http://localhost:8000>**

```
php bin/console server:run
```


## Controller

Générer un **Controller** + template **Twig**

```
php bin/console make:controller
```

> La convention pour le nomage des **Controller** => Capitalize+CamelCase (**PascalCase**)

# Doctine

Après configuration de la **BDD** dans **.env**, il faut créer la BDD

```
php bin/console doctrine:database:create
```

## Les entity

Créer une classe **Entity** qui représente une table

```
php bin/console make:entity
```

Créer le fichier de migration grâce aux **Entity**

```
php bin/console make:migration
```

## Les migration

Exécuter les migrations sur la BDD

```
php bin/console doctrine:migrations:migrate
```


## Les fixtures

- Créer des jeux de fausses données
- Exécutable à souhait
- Réutilisable par les autres

Installer le **module de fixtures**

```
composer require orm-fixtures --dev
```

Générer une fixture

```
php bin/console make:fixtures
```

Exécuter les fixtures

```
php bin/console doctrine:fixtures:load
```

# Twig

## Les variables

Il est possbile d'afficher le contenu d'un variable avec les doubles accolades

```
{{varibale_name}}
```

## Les commandes

Il est possible d'executer de la **logique dans Twig**

```
{% if age >= 18 %}
    // Tu es majeur
{% else %}
    // TU es mineur
{% endif %}
```

# Forms (symfony/form)

## Installation

```
composer require symfony/form
```

## Les Formulaires

Générer un **formulaire** 
```
php bin/console make:form
```

# User Maker

Créer un utilisateur
````
php bin/console make:user
````

Ajouter des champs à l'**Entity**
````
php bin/console make:entity (User)
````

Créer le fichier de migration grâce aux **Entity** et sur la **BDD**

```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

# Auth

# Installation

````
php bin/console make:auth
````

# Dev

JS / CSS compilation
````
npm run watch
````




