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

Téléchargement d'une Template bootstrap à ajouter au dossier datas

On s'en servira pour créer les différents twig

## Ajout de `template.front.html.twig` 

séparation en block de la template bootstrap :

`_menu.html.twig`
`footer.html.twig`
`header.html.twig`
`main.html.twig`

## Modification de `base.html.twig`

ajout du head, des links et du script dans le fichier `base.html.twig`.

## Création d'une page de connexion

    php bin/console make:security:form-login

```bash
php bin/console make:security:form-login

 Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
 >

 Do you want to generate a '/logout' URL? (yes/no) [yes]:
 >

 Do you want to generate PHPUnit tests? [Experimental] (yes/no) [no]:
 >

 created: src/Controller/SecurityController.php
 created: templates/security/login.html.twig
 updated: config/packages/security.yaml


  Success!


 Next: Review and adapt the login template: security/login.html.twig to suit your needs.

 On va remplir la table `user`

Avec le contenu suivant :

- username
  1) Admin
  2) Redac
  3) User
- roles ! json
  1) ["ROLE_ADMIN","ROLE_REDAC","ROLE_USER"]
  2) ["ROLE_REDAC","ROLE_USER"]
  3) []
- password : Il va falloir crypter les mots de passes avec
  
  php bin/console security:hash-password

1) ******
2) *****
3) ********

- user_mail
ici, vous choisissez
- user_real_name
  ici vous choisissez
- user_active
 true
```

### Ajoutez login/logout au menu

```twig
{# templates/main/menu.html.twig #}
<nav>
    {# si nous sommes connectés #}
                {% if is_granted('IS_AUTHENTICATED') %}
               <li class="nav-item"><a class="nav-link" href="{{ path('app_logout') }}">Déconnexion</a></li>
                    {% if is_granted('ROLE_ADMIN') %}
                <li class="nav-item"><a class="nav-link" href="{{ path('app_admin') }}">Administration</a></li>
                    {% endif %}
                {% else %}
                <li class="nav-item"><a class="nav-link" href="{{ path('app_login') }}">Connexion</a></li>
                {% endif %}
</nav>
```

### Créer un contrôleur d'administration

  php bin/console make:controller AdminController
  
Une route vers un dossier `admin` a été créée, on va vérifier si un rôle lui est attribué dans le fichier `config/packages/security.yaml`

```yaml
    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        # - { path: ^/profile, roles: ROLE_USER }
```

Dorénavant, ce dossier (et sous-dossiers sont accessibles que par les `ROLE_ADMIN`)

https://symfony.com/doc/current/security.html#roles

## Création d'un contrôleur pour Admin

    php bin/console make:controller AdminController

On modifie le fichier pour passer certaines variables :

`src/Controller/AdminController.php`
```php
# ...
#[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'title' => 'Administration',
            'homepage_text' => "Bienvenue {$this->getUser()->getUsername()}",
        ]);
    }
# ...
```

On duplique `templates/template.front.html.twig` en `templates/template.back.html.twig`. On modifiera ce template suivant les besoins.

On modifie `templates/admin/index.html.twig` pour le faire correspondre aux variables du contrôleur

## Création du CRUD pour `Section`

```bash
php bin/console make:crud

 The class name of the entity to create CRUD (e.g. AgreeableChef):
 > Section
Section

 Choose a name for your controller class (e.g. SectionController) [SectionController]:
 > AdminSectionController

 Do you want to generate PHPUnit tests? [Experimental] (yes/no) [no]:
 >

 created: src/Controller/AdminSectionController.php
 created: src/Form/SectionType.php
 created: templates/admin_section/_delete_form.html.twig
 created: templates/admin_section/_form.html.twig
 created: templates/admin_section/edit.html.twig
 created: templates/admin_section/index.html.twig
 created: templates/admin_section/new.html.twig
 created: templates/admin_section/show.html.twig


  Success!


 Next: Check your new CRUD by going to /admin/section/
```

On crée les liens dans la page d'accueil et le menu de l'admin vers 

    <a href="{{ path('app_admin_section_index') }}">Crud Section</a>

Ne pas oublier de mettre en commentaire une partie du formulaire `src/Form/SectionType.php`





