# Gestion École Primaire ANA
## Description
Ce projet est une application complète de gestion pour l'école primaire ANA, conçue pour automatiser les tâches administratives et centraliser les données scolaires au sein d'une interface unique.
## Contexte
Le projet est né d'un constat terrain : au sein de cette école dont ma mère a été la directrice, la quasi-totalité des processus administratifs et pédagogiques était effectuée manuellement, sans aucun système informatique en place à l'exception du logiciel Microsoft Excel. L'objectif est donc de moderniser l'établissement en facilitant la transition numérique à travers un outil sur mesure et intuitif.
## Technologies utilisées
Pour répondre à ces besoins, l'application s'appuie sur une pile technologique polyvalente :
* **MySQL** : Gestion, structuration et stockage sécurisé de la base de données.
* **Python** : Logique applicative, traitement des données et scripts d'automatisation.
* **PHP** : Développement du backend et communication dynamique avec la base de données.
* **HTML5 / CSS3** : Structuration de l'interface utilisateur et mise en page.
* **Bootstrap** : Framework CSS utilisé pour garantir un design moderne, épuré et entièrement responsive.
## Base de données
La base de données est structurée autour de plusieurs tables clés pour modéliser le fonctionnement de l'établissement :
* **ENSEIGNANT** : Permet de stocker et de retrouver facilement les informations des enseignants, ainsi que de suivre leur affectation (un enseignant appartenant exclusivement à une seule classe).
* **MATIERE** : Centralise la gestion des matières enseignées de façon automatique afin de simplifier leur recherche.
* **COMPOSITION** : Assure le suivi et l'archivage des compositions scolaires organisées au cours d'un trimestre défini.
* **ELEVE** : Gère l'historique complet des élèves. Elle permet de retrouver le dossier d'un élève à tout moment, qu'il soit actif, exclu, redoublant ou promu.
* **INSCRIPTION** : Fait le lien avec la table ELEVE pour assurer le suivi dynamique des parcours scolaires (réinscriptions, changements de statut).
* **ANNEE_SCOLAIRE** : Historise et segmente les données par période académique.
* **CLASSE** : Répertorie les différents niveaux et sections de l'école primaire.
* **EVALUATION** : Enregistre les notes et les performances des élèves tout au long de l'année.
## Statut
**En cours de développement.** Ce projet est actif et me sert également de cas pratique concret dans le cadre de mon apprentissage et du perfectionnement de mes compétences techniques.
## Auteur
**Toure Abdoul Aziz Mohamed** — Étudiant en Licence 2 Informatique Appliquée à la Gestion des Entreprises
