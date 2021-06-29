# symfony
Projet de réseaux social type twitter version Canard. Les utilisateurs sont des "Duck" et les posts sont des "Quack".
Les commentaires, eux, sont des "Coincoin".
Le but de ce projet est de découvrir Symfony et comment utiliser ces fonctonnaltités.

# Installation du Framework
Pour commencer, deux prérequis : PHP version 7.2.5 minimum et Composer. 
Puis il vous faut installer Symfony (5.3 ici) : 
Dans votre console :
` symfony check:requirements` afin de voir si votre ordinateur à tous les éléments requis.

Suivis de :
` symfony new my_project_name --full` pour créer une nouvelle application Symfony. Le `--full` va nous permettre d'avoir de bases certains packages tel que les Maker.
Rendez-vous au bonne endroit (cd projects/) puis faites un ` git clone le_nom_du_repository`.

Vous pouvez faire ` php bin/console about` pour vous assurez de la bonne configuration.
`symfony serve` ou ` symfony server:start` va lancer le serveur local : `http://localhost:8000/`

# Codage
Documentation de Symfony :
https://symfony.com/doc/current/index.html .

Documentation des makers : https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html .

Ducmentation de Twig : https://twig.symfony.com/doc/3.x/

#Glossaire

`php bin/console make:entity` : Création d'une entité.

`php bin/console doctrine:schema:update -f` : Mise à jour de la table sans créer de migration.

