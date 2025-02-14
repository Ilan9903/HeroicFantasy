# Projet Symfony - Guide de démarrage

Ce projet est configuré avec Docker pour faciliter le développement d'applications Symfony.

## Prérequis

- Docker
- Docker Compose
- Git

## Structure du projet
```
projet-squelette/
├── app/                    # Dossier de l'application Symfony
├── docker/                 # Configurations Docker
├── compose.yml            # Configuration Docker Compose
└── Dockerfile             # Configuration PHP-FPM
```

## Installation et lancement

1. Clonez le squelette :
```bash
git clone <url-du-projet>
cd <nom-du-projet>
```

2. Créez le projet Symfony dans le dossier app :
```bash
docker compose up -d
docker compose exec php composer create-project symfony/skeleton .
```

3. Installez les dépendances essentielles :
```bash
docker compose exec php composer require webapp
docker compose exec php composer require symfony/maker-bundle --dev
docker compose exec php composer require doctrine/annotations
docker compose exec php composer require twig
docker compose exec php composer require symfony/mailer
docker compose exec php composer require symfony/security-bundle
docker compose exec php composer require api
```

4. Créez la base de données :
```bash
docker compose exec php php bin/console doctrine:database:create
docker compose exec php php bin/console doctrine:schema:update --force
```

5. Accédez à l'application :
   - Application Symfony : http://localhost:8080
   - PHPMyAdmin : http://localhost:8081
     - Serveur : mysql
     - Utilisateur : user
     - Mot de passe : password

## Services disponibles

- **PHP-FPM** : Service PHP avec Composer
- **Nginx** : Serveur web (port 8080)
- **MySQL** : Base de données (port 3306)
- **PHPMyAdmin** : Interface d'administration MySQL (port 8081)

## Commandes utiles

### Docker
- Démarrer : `docker compose up -d`
- Arrêter : `docker compose down`
- Logs : `docker compose logs -f`
- Shell PHP : `docker compose exec php bash`

### Symfony (dans le conteneur PHP)
- Nouveau controller : `php bin/console make:controller`
- Nouvelle entité : `php bin/console make:entity`
- Migration : `php bin/console make:migration`
- Appliquer migrations : `php bin/console doctrine:migrations:migrate`

## Dépannage

1. **Erreur de permissions** :
   ```bash
   sudo chown -R $USER:$USER app/
   ```

2. **Ports déjà utilisés** :
   - Modifiez les ports dans `compose.yml`
   - Ports par défaut : 8080 (nginx), 3306 (mysql), 8081 (phpmyadmin)

3. **Base de données inaccessible** :
   - Vérifiez les credentials dans `.env.local`
   - Assurez-vous que le service mysql est démarré

## En cas de problème avec la base de données

Si vous rencontrez des erreurs avec la base de données, vous pouvez tout réinitialiser :

```bash
# Arrêter et supprimer les conteneurs et volumes
docker compose down -v
docker volume prune -f

# Redémarrer les conteneurs
docker compose up -d

# Recréer la base de données
docker compose exec php php bin/console doctrine:database:create
```

## Dépendances installées

### Dépendances principales
- **webapp** : Un méta-package Symfony qui inclut :
  - Twig (moteur de templates)
  - Doctrine ORM (base de données)
  - Forms & Validation
  - Security
  - Mailer
  - Profiler & Debug tools

### Dépendances de développement
- **symfony/maker-bundle** :
  - Outil en ligne de commande pour générer du code
  - Création rapide de controllers, entités, forms, etc.
  - Commandes make:controller, make:entity, etc.

### Dépendances spécifiques
- **doctrine/annotations** :
  - Permet d'utiliser les annotations PHP
  - Configuration des routes, entités, validations via annotations
  - Exemple : #[Route("/home")], #[Entity]

- **twig** :
  - Moteur de templates pour PHP
  - Permet de créer des vues HTML dynamiques
  - Héritage de templates, filtres, fonctions

### Services configurés
- **MySQL** : Base de données relationnelle
  - Accessible via PHPMyAdmin (http://localhost:8081)
  - Credentials par défaut :
    - Base : app
    - Utilisateur : user
    - Mot de passe : password

- **PHP-FPM** : Serveur PHP optimisé
  - Version : 8.2
  - Extensions : PDO, MySQL, ZIP
  - Composer installé

- **Nginx** : Serveur web
  - Port : 8080
  - Configuration optimisée pour Symfony