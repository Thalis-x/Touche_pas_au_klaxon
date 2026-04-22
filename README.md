# Touche pas au klaxon

Application intranet de covoiturage inter-sites permettant aux employés de partager leurs trajets entre les différentes implantations de l'entreprise.

## Prérequis

- PHP 8.1 ou supérieur (extensions `pdo`, `pdo_mysql`)
- MySQL 8+ ou MariaDB 10+
- Composer
- Node.js + npm (pour compiler Sass)

## Installation

1. Cloner le dépôt :
```bash
   git clone https://github.com/Thalis-x/Touche_pas_au_klaxon
   cd VOTRE-REPO
```

2. Installer les dépendances PHP :
```bash
   composer install
```

3. Copier et configurer la base de données :
```bash
   cp config/database.php.example config/database.php
```
   Éditer `config/database.php` avec vos identifiants MySQL.

4. Créer et peupler la base de données :
```bash
   php bin/install.php
```

5. Installer les dépendances front et compiler Sass :
```bash
   npm install
   npm run build
```

6. Lancer le serveur de développement :
```bash
   php -S localhost:8000 -t public
```

7. Ouvrir http://localhost:8000

## Comptes de test

| Rôle          | Email                         | Mot de passe |
|---------------|-------------------------------|--------------|
| Administrateur| alexandre.martin@email.fr     | password123  |
| Utilisateur   | sophie.dubois@email.fr        | password123  |

## Architecture MVC

```bash

├── public/              Racine web (DocumentRoot)
│   ├── index.php        Point d'entrée unique (Front Controller)
│   └── assets/          CSS compilé, JS
├── src/
│   ├── Core/            Mini-framework (Database, Session, View, Controller, Model)
│   ├── Controllers/     Contrôleurs (HomeController, AuthController, etc.)
│   ├── Models/          Modèles (Employe, Agence, Trajet)
│   └── routes.php       Déclaration des routes
├── views/               Templates PHP
│   ├── layouts/         Layout principal
│   ├── partials/        Header, footer, flash messages
│   ├── home/            Page d'accueil
│   ├── auth/            Formulaire de connexion
│   ├── trajet/          Création et modification de trajets
│   ├── admin/           Tableau de bord administrateur
│   └── errors/          Pages 404 et 403
├── config/              Configuration (app, BDD)
├── assets/scss/         Sources Sass
├── sql/                 Scripts de base de données
├── bin/                 Scripts utilitaires
└── tests/               Tests PHPUnit

```
## Commandes utiles

```bash
vendor\bin\phpunit          # Lancer les tests
vendor\bin\phpstan analyse  # Analyse statique du code
npm run build               # Compiler Sass
npm run watch               # Compiler Sass en mode watch
```

## Technologies

- PHP 8.4 (architecture MVC)
- MySQL / MariaDB
- Bootstrap 5 + Sass
- PHPUnit (tests unitaires)
- PHPStan (analyse statique)
- izniburak/router (routeur PHP)