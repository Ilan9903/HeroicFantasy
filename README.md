# HeroicFantasy-Symfony

HeroicFantasy-Symfony est une application web développée avec le framework Symfony (PHP), permettant la gestion de personnages, de quêtes et d’interactions dans un univers de jeu de rôle héroïque-fantasy.

## 🚀 Présentation

L’objectif du projet est de proposer une plateforme où chaque utilisateur peut :
- Créer et gérer jusqu’à 3 héros personnalisés (nom, classe, biographie, etc.).
- Sélectionner un héros actif, recevoir et accomplir des quêtes, gagner de l’expérience.
- Interagir avec des PNJ (personnages non joueurs) pour progresser dans l’aventure.

## 🛠️ Stack technique

- **Backend** : Symfony 6/7 (PHP 8.2)
- **Frontend** : Twig (template engine)
- **Base de données** : MySQL (administrable via PHPMyAdmin)
- **ORM** : Doctrine
- **Authentification et sécurité** : Symfony Security Bundle
- **API REST** : Contrôleurs pour les entités principales (héros, quêtes, etc.)
- **Déploiement et développement local** : Docker, Docker Compose, Nginx, PHP-FPM

## 📦 Structure du projet

```
HeroicFantasy-Symfony/
├── HeroicFantasy/
│   ├── HeroicFantasy/
│   │   ├── app/            # Code source Symfony (contrôleurs, entités, formulaires, vues)
│   │   ├── docker/         # Configs Docker
│   │   ├── compose.yml     # Docker Compose
│   │   └── Dockerfile      # Dockerfile PHP-FPM
```

## ⚙️ Installation & Lancement rapide

1. **Prérequis** :  
   - [Docker](https://www.docker.com/)  
   - [Docker Compose](https://docs.docker.com/compose/)  
   - [Git](https://git-scm.com/)

2. **Cloner le projet** :
   ```bash
   git clone https://github.com/Ilan9903/HeroicFantasy-Symfony.git
   cd HeroicFantasy-Symfony/HeroicFantasy/HeroicFantasy
   ```

3. **Démarrer l’environnement Docker** :
   ```bash
   docker compose up -d
   ```

4. **Installer les dépendances Symfony** *(si besoin)* :
   ```bash
   docker compose exec php composer install
   ```

5. **Créer la base de données & lancer les migrations** :
   ```bash
   docker compose exec php php bin/console doctrine:database:create
   docker compose exec php php bin/console doctrine:schema:update --force
   ```

6. **Accéder à l’application** :
   - Frontend Symfony : http://localhost:8080
   - PHPMyAdmin : http://localhost:8081 (user: `user` / password: `password`)

## 🧩 Fonctionnalités principales

- **Gestion des héros :**
  - Création de héros (nom, classe : Druide, Chaman, Guerrier, Voleur, Mage…)
  - Limite de 3 héros par utilisateur
  - Sélection d’un héros actif

- **Quêtes & progression :**
  - Attribution et accomplissement de quêtes
  - Calcul d’expérience, niveaux, récompenses
  - Système de PNJ pour remettre des quêtes

- **Interface utilisateur :**
  - Authentification sécurisée (Symfony Security)
  - Tableaux de bord personnalisés
  - CRUD via formulaires Symfony

- **API & intégrations :**
  - Endpoints REST pour la gestion des quêtes et héros
  - Intégration facile d’autres outils via l’API

## 🔌 Services & outils

- **PHP-FPM** (8.2) avec extensions PDO, MySQL, ZIP
- **Nginx** (port 8080)
- **MySQL** (port 3306, base: app)
- **PHPMyAdmin** (port 8081)
- **Composer** (gestionnaire de dépendance PHP)

## 👨‍💻 Commandes utiles

- Démarrer Docker : `docker compose up -d`
- Arrêter Docker : `docker compose down`
- Accéder au shell PHP : `docker compose exec php bash`
- Générer un contrôleur : `php bin/console make:controller`
- Générer une entité : `php bin/console make:entity`
- Appliquer les migrations : `php bin/console doctrine:migrations:migrate`

## 🛟 Dépannage

- **Problème de permissions** :
  ```bash
  sudo chown -R $USER:$USER app/
  ```
- **Ports déjà utilisés** : modifiez-les dans `compose.yml`
- **Réinitialiser la base** :
  ```bash
  docker compose down -v
  docker volume prune -f
  docker compose up -d
  docker compose exec php php bin/console doctrine:database:create
  ```

## 📚 Dépendances principales

- `symfony/webapp` (inclut Twig, Doctrine ORM, Security, Mailer…)
- `symfony/maker-bundle` (génération de code)
- `doctrine/annotations` (routes, validations par annotations)
- `twig` (vues dynamiques)
- `symfony/mailer` (envoi d’e-mails)
- `symfony/security-bundle` (sécurité & gestion des utilisateurs)
- `api` (support API REST)

---

**Auteur : [Ilan9903](https://github.com/Ilan9903)**  
Licence : _à compléter_  
Contributions bienvenues !
