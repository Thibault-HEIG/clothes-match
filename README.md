# HEIG-VD ProgServ2 Course PHP Template

Ce modèle de projet est conçu pour les étudiant.es du cours
[_"Programmation Serveur 2 (ProgServ2)"_](https://github.com/heig-vd-progserv-course/heig-vd-progserv2-course)
à la [HEIG-VD](https://heig-vd.ch).

Il fournit une structure de base pour les projets PHP avec les éléments suivants
:

- Un serveur [Apache](https://httpd.apache.org/) avec
  [PHP 8.5](https://www.php.net/) et les extensions nécessaires pour se
  connecter à une base de données [MariaDB](https://mariadb.org/).
- Une base de données [MariaDB](https://mariadb.org/) préconfigurée avec un
  utilisateur et un mot de passe par défaut. Dans vos scripts PHP, utilisez le
  nom d'hôte `mariadb` et les identifiants définis dans le fichier
  `compose.yaml`.
- Une interface web [phpMyAdmin](https://www.phpmyadmin.net/) pour gérer la base
  de données MariaDB en utilisant les mêmes identifiants que ceux définis dans
  le fichier `compose.yaml`.
- Un serveur SMTP [Mailpit](https://mailpit.axllent.org/) pour tester l'envoi
  d'e-mails depuis votre application PHP.
- Des configurations recommandées pour l'éditeur de code
  [Visual Studio Code](https://code.visualstudio.com/), y compris des extensions
  utiles pour le développement PHP et la gestion de bases de données
  ([PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client),
  [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode),
  [SQLite Viewer](https://marketplace.visualstudio.com/items?itemName=qwtel.sqlite-viewer)).

Tous ses éléments sont configurés pour fonctionner avec
[Docker Compose](https://docs.docker.com/compose/), ce qui permet de créer un
environnement de développement isolé et reproductible.

N'hésitez pas à personnaliser ce modèle et ce document pour ajouter des
instructions spécifiques à votre projet ou des détails supplémentaires sur la
configuration et l'utilisation du projet.

## Utiliser ce modèle pour votre projet

1. Cliquez sur le bouton "Use this template" (Utiliser ce modèle) sur la page
   GitHub de ce dépôt.
2. Donnez un nom à votre nouveau dépôt et configurez les options selon vos
   préférences.
3. Invitez les membres de votre équipe à collaborer sur le projet en leur
   donnant accès au dépôt (si applicable).
4. Chaque membre de l'équipe doit cloner le nouveau dépôt sur sa machine locale
   pour commencer à travailler sur le projet.
5. Utilisez le workflow GitHub étudié en cours pour gérer les branches, les
   commits et les pull requests afin de collaborer efficacement sur le projet.

## Structure du projet

- `.devcontainer/`: Contient la configuration pour le développement dans un
  conteneur Debian (Trixie) avec Visual Studio Code.
- `.vscode/`: Contient les paramètres recommandés pour Visual Studio Code.
- `.gitignore`: Fichier de configuration pour Git, spécifiant les fichiers et
  dossiers à ignorer.
- `compose.yaml`: Fichier de configuration pour Docker Compose, définissant les
  services nécessaires pour le projet, avec :
  - [Apache](https://httpd.apache.org/) : Serveur web pour exécuter les fichiers
    PHP.
  - [MariaDB](https://mariadb.org/) : Base de données relationnelle.
  - [phpMyAdmin](https://www.phpmyadmin.net/) : Interface web pour gérer la base
    de données MariaDB.
  - [Mailpit](https://mailpit.axllent.org/) : Serveur SMTP pour tester l'envoi
    d'e-mails.
- `index.php`: Fichier PHP principal du projet.
- `script.sql`: Fichier SQL pour créer la table `my_table` dans la base de
  données.
- `README.md`: Ce fichier de documentation.

## Ouvrir le projet localement

> [!NOTE]
>
> Il est important d'ouvrir le dossier du projet directement et non un dossier
> parent.
>
> Pensez à bien ouvrir le dossier du projet lui-même (celui qui contient ce
> fichier README.md) et non un dossier parent. Ouvrir un dossier parent peut
> entraîner des problèmes de configuration et de fonctionnement de Visual Studio
> Code.

1. Clonez ce dépôt sur votre machine locale.
2. Ouvrez ce dossier dans Visual Studio Code.

## Ouvrir le projet dans un conteneur de développement

Si vous avez l'extension
[Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers)
installée, Visual Studio Code vous proposera d'ouvrir le projet dans un
conteneur Docker.

Acceptez cette proposition pour bénéficier d'un environnement de développement
préconfiguré.

Si aucune notification n'apparaît, vous pouvez ouvrir manuellement le conteneur
en utilisant la commande _"Dev Containers: Reopen in Container"_ dans la palette
de commandes (<kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>P</kbd> sur Windows/Linux ou
<kbd>Cmd</kbd>+<kbd>Shift</kbd>+<kbd>P</kbd> sur macOS).

## Démarrer les services Docker

Pour démarrer les services Docker nécessaires à développer des applications PHP,
ouvrez un terminal intégré dans Visual Studio Code et exécutez la commande
suivante :

```bash
# Démarre tous les services définis dans le fichier compose.yaml
docker compose up
```

Ceci va démarrer les services suivants dans des conteneurs Docker :

- Apache (port 8080) : Serveur web pour exécuter les fichiers PHP.
- MariaDB (port 3306) : Base de données relationnelle.
- phpMyAdmin (port 9090) : Interface web pour gérer la base de données MariaDB.
- Mailpit (ports 1025 et 8025) : Serveur SMTP pour tester l'envoi d'e-mails.

## Se connecter à la base de données MariaDB avec phpMyAdmin

La configuration Docker Compose inclut également phpMyAdmin, un outil web pour
gérer les bases de données MariaDB.

Pour accéder à phpMyAdmin, ouvrez votre navigateur et rendez-vous à l'adresse
suivante : <http://localhost:9090>.

Vous pourrez alors vous connecter à la base de données en utilisant les
identifiants décrits dans le fichier `compose.yaml` (par défaut, l'utilisateur
est `username` et le mot de passe est `password`).

## Exécuter des requêtes SQL sur la base de données MariaDB

Une fois connecté à la base de données MariaDB via phpMyAdmin, vous pouvez
exécuter des requêtes SQL pour créer des tables, insérer des données ou
effectuer d'autres opérations sur la base de données.

1. Ouvrez/créez un fichier SQL dans Visual Studio Code (par exemple,
   `script.sql`).
2. Écrivez votre requête SQL dans ce fichier (par exemple, une requête pour
   créer une table ou insérer des données).
3. Dans l'onglet "SQL" de phpMyAdmin, vous pouvez copier et coller votre requête
   SQL depuis le fichier `script.sql` et l'exécuter pour appliquer les
   modifications à la base de données.

## Voir les données de la table `my_table`

Une fois le ou les scripts SQL exécutés, vous pouvez vérifier que les données
ont été correctement insérées dans la table `my_table` dans le menu latéral
gauche de phpMyAdmin. Cliquez sur le nom de la base de données, puis sur le nom
de la table pour voir les données.

## Exécuter vos scripts PHP

La configuration Docker Compose inclut un serveur web Apache avec PHP, ce qui
vous permet d'exécuter vos scripts PHP directement dans le conteneur.

Le serveur sera accessible à l'adresse <http://localhost:8080> dans votre
navigateur.

La liste des fichiers PHP disponibles sera affichée, et vous pourrez cliquer sur
un fichier pour l'exécuter.

Les scripts PHP peuvent se connecter à la base de données MariaDB en utilisant
le nom d'hôte `mariadb` et les identifiants définis dans le fichier
`compose.yaml`.

En accédant à l'adresse <http://localhost:8080/public/index.php>, vous pourrez
exécuter le script PHP principal du projet.

La page d'accueil de démonstration affiche un message de bienvenue et utilise la
base de données MariaDB pour afficher les données de la table `my_table`.

## Visualiser les e-mails envoyés par votre application PHP

Le serveur SMTP Mailpit est inclus dans la configuration Docker Compose pour
vous permettre de tester l'envoi d'e-mails depuis votre application PHP.

Pour accéder à l'interface web de Mailpit, ouvrez votre navigateur et
rendez-vous à l'adresse suivante : <http://localhost:8025>.

Vous y verrez la liste des e-mails envoyés par votre application PHP, ainsi que
leur contenu et les détails de l'envoi.

Si vous fermez/redémarrez Mailpit, les e-mails précédemment envoyés seront
perdus, car ils ne sont pas stockés de manière persistante.

## Arrêter les services Docker

Si vous avez exécuté la commande `docker compose up` pour démarrer les services
Docker, vous pouvez les arrêter avec le raccourci clavier
<kbd>Ctrl</kbd>+<kbd>C</kbd> dans le terminal où la commande a été exécutée.
Cela arrêtera les services et libérera les ressources utilisées par les
conteneurs Docker.

Sinon, vous pouvez également arrêter les services Docker en ouvrant un terminal
intégré dans Visual Studio Code et en exécutant la commande suivante :

```bash
# Arrête tous les services définis dans le fichier compose.yaml
docker compose down
```

Lorsque vous fermez Visual Studio Code, les conteneurs Docker seront
automatiquement arrêtés. Dès que vous rouvrez Visual Studio Code et que vous
exécutez à nouveau la commande `docker compose up`, les services Docker seront
redémarrés.
