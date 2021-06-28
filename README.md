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

Enfin ` composer create-project symfony/website-skeleton my_project_name` et rendez-vous au bonne endroit (cd projects/) puis faites un ` git clone le_nom_du_repository`.

Vous pouvez faire ` php bin/console about` pour vous assurez de la bonne configuration.
`symfony serve` ou ` symfony server:start` va lancer le serveur local : `http://localhost:8000/`