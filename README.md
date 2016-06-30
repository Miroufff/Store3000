Store
=====

Sylvain Davenel

A Symfony project created on June 23, 2016, 12:01 pm.

Store - Symfony 2.8

- ORM (generation BDD) / DAO (generation)
- WebService créer/récupérer le/les commandes (REST)
- Crud (génération des vues)
- Format des dates en iso8601 (WebService) : 2004-05-23T14:25:10.487
- Script déploiement
- Outil de d'ajout de numéro invoice, delivery, order, customer

Répertoire github contenant le projet jobeet : https://github.com/Miroufff/Store3000

Documentation contenant l'ensemble des commandes devant être jouer pour passer une installation viable

(Ne pas oublier de lancer wamp server)

Il y a deux façon d'installer l'application :

    - Manuellement

        Requierement :

            apache
            php
            mySql
            git
            composer

        Clonage du dépôt git

            cd /var/www/html
            git clone https://github.com/Miroufff/Store3000

        Accès au dépôt

            cd Store3000

        Installation des dépendance

            composer install

        Paramètres (Ces paramètres sont a modifier en fonction de l'environnement) :

            database host : 127.0.0.1
            database port : null
            database name : store
            database user : root
            database password : null
            mailer transport : smtp
            mailer host : 127.0.0.1
            mailer user : null
            mailer password : null
            secret : default value

        Création de la base de données

            php app/console doctrine:database:create

        Ajout des tables dans la base de données

            php app/console doctrine:schema:update --force

        Lancement du serveur

            php app/console server:run

        Ouvrir un navigateur et entrer l'url suivant : localhost:8000

    - Avec Capistrano

        Requierement :

            apache
            php
            mySql
            gitAccès au dépôt

            cd SylvainDavenelJobeet
            composer
            ruby > 2.0
            gems

        Sur le serveur :

            Ajouter la clef ssh de l'utilisateur qui va déployer le projet dans ~/.ssh/authorized_key

            Ajouter le dossier déploiement

            cd /var/www/html/
            mkdir store
            mkdir store/current store/releases store/shared store/repo
            mkdir store/shared/app/config

            Insérer un fichier partager

                vim store/shared/app/config/parameters.yml

                    Ce fichier doit contenir le valeurs ci dessous (à modifier selon la configuration du serveur)

                    database host : 127.0.0.1
                    database port : null
                    database name : store
                    database user : root
                    database password : null
                    mailer transport : smtp
                    mailer host : 127.0.0.1
                    mailer user : null
                    mailer password : null
                    secret : default value

        Sur la machine local :

            Clonage du dépôt git

                cd /var/www/html
                git clone https://github.com/Miroufff/Store3000

            Accès au dépôt

                cd Store3000

            Configurer capistrano (Installation des gems du Gemfile)

                bundle install

            Editer la direction du déploiement

                vim config/deploy/production.rb

                Ce fichier doit contenir le valeurs ci dessous (à modifier selon la configuration du serveur)

                set :branch, "master"
                set :application, "store"
                set :deploy_to,   "/var/www/html/store"

                server 'utilisateur@ip', :roles => [:app, :web, :db], :primary => true

            Déploiement du projet en production

                cap production deploy
