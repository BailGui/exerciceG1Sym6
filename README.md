# exerciceG1Sym6

- Créez un fork de ce projet
- Suivez les `README.md` de https://github.com/WebDevCF2m2023/EntitiesG1

A partir des `entités` et du `.env` de ce `repository`,

Créez la base de donnée, trouvez un template front et/ou un autre template back

Vouz devez pouvoir vous connecter avec un `User` (avec mot de passe crypté) au rôle `ROLE_ADMIN`

Créez une administration en back-end,

Mais surtout un site (+-) fonctionnel en front-end

## Mise à jour des versions de sécurités

    composer update

## Lancement du serveur

    symfony serve -d
ou

    symfony server:start -d

Pour le fermer 

    symfony server:stop

L'adresse est généralement de type https://127.0.0.1:8000

### Création d'un contrôleur

    symfony console make:controller

ou

    php bin/console make:controller

Le nom doit être en PascalCase terminé par Controller, mais Symfony se charge de le corriger en cas d'oubli.

    php bin/console make:controller MainController

    created: src/Controller/MainController.php
    created: templates/home/index.html.twig

## Création de notre `.env.local`

Le fichier `.env` est le fichier de configuration qui est mis sur `git` et donc `github`

C'est pour celà que nous allons le copier sous le nom de `.env.local`

    cp .env .env.local

Ouvrez `.env.local`

Changez cette ligne

    APP_ENV=dev
    APP_SECRET=c6f06c078199d1f00879e1b9c146cddf
en

    APP_ENV=dev
    APP_SECRET=une_autre_clef_secrete_sécurité

si vous retapez  `php bin/console debug:route`

Vous ne trouverez plus que les routes de production

Dans le fichier `.env.local`

Trouvez la ligne de base de données :

```bash
# ne pas oublier de remettre en dev
APP_ENV=dev

# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
```

Commentez la ligne postgresql et décommentez la ligne mysql

Passez vos paramètres de connexion dans l'ordre

driver://utilisateur:mot_de_passe@ip_serveur:port/nomdelaDB?options

```bash
DATABASE_URL="mysql://root:@127.0.0.1:3306/entitiesg1?serverVersion=8.0.31&charset=utf8mb4"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
```

## Création de la DB

Avec Doctrine, documentation :

https://symfony.com/doc/current/doctrine.html


    php bin/console doctrine:database:create
    # le mode raccourci
    php bin/console d:d:c

La base de donnée devrait être créée si mysql.exe est activé ou Wamp démarré 

## Les entitèes était déjà présente dans le fork 

doc concernant entity à voir dans le repository entitiesG1

## Migration

    php bin/console make:migration

    success :  created: migrations/Version20240911133839.php

puis

    php bin/console doctrine:migrations:migrate

### Mise en forme des formulaires et des pages avec `bootstrap`

Nous allons utiliser les assets qui se trouvent dans le dossier `assets`

Documentation :

Différence AssetMapper et Webpack Encore : https://symfony.com/doc/6.4/frontend.html#using-php-twig

### `AssetMapper`

Documentation : https://symfony.com/doc/6.4/frontend/asset_mapper.html

On va importer bootstrap

    php bin/console importmap:require bootstrap

    [OK] 3 new items (bootstrap, @popperjs/core, bootstrap/dist/css/bootstrap.min.css) added to the importmap.php!

La mise à jour a été effectuée uniquement dans `importmap.php`

Pour tester, on va d'abord trouver les templates `bootstrap` à cette adresse : https://symfony.com/doc/current/form/form_themes.html

Donc pour les formulaires `bootstrap`

```yaml
# config/packages/twig.yaml
twig:
form_themes: ['bootstrap_5_horizontal_layout.html.twig']
# ...
```

Le code `bootstrap` est généré, mais il manque le style !
