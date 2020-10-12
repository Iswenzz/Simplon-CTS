![](https://i.imgur.com/XFvRaaO.png)
# Simplon PHP TP
![](https://i.imgur.com/8bY94NU.jpg)

# Classé Top Secret
L’objectif est de créer un site internet permettant la gestion des données du KGB

## Livrables
Le dépôt Gitlab de votre site internet complet. Les schémas de BDD. Les maquettes si il y en a.
Contexte du projet

**La BDD est organisée comme cela :**
* Les agents ont un nom, un prénom, une date de naissance, un code d'identification, une nationalité, 1 ou plusieurs spécialités
* Les cibles ont un nom, un prénom, une date de naissance, un nom de code, une nationalité
* Les contacts ont un nom, un prénom, un date de naissance, un nom de code, une nationalité
* Les planques ont un code, une adresse, un pays, un type
* Les missions ont un titre, une description, un nom de code, un pays, 1 ou plusieurs agents, 1 ou plusieurs contacts, 1 ou plusieurs cible, une type de mission (Surveillance, Assassinat, Infiltration …), un statut (En preparation, en cours, terminé, echec), 0 ou plusieurs planque, 1 spécialité requise, date de debut, date de fin
* Les administrateurs ont un nom, un prénom, une adresse mail, un mot de passe, une date de création

**Règle métier :** 

_Sur une mission:_
* La ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents.
* Les contacts sont obligatoirement de la nationalité du pays de la mission.
* La planque est obligatoirement dans le même pays que la mission.
* Il faut assigné au moins 1 agent disposant de la spécialité requise.

## Modalités pédagogiques
Il vous est demandé de créer la base de données selon cette description. Tous les champs devront avoir les bons types, avec optimisation. Il faut également créer les liens entre les différentes tables. Certaines colonnes sont peut être manquantes et nécessaire à votre développement, à vous de les fournir. Aucun jeu de données n’est fourni. Il faudra présenter un schéma de conception (MCD/MLD). Il faudra créer un script de création de la base, facilement exécutable pour une création rapide.

Il vous est ensuite demandé de créer une interface front-office, accessible à tous, permettant de consulter la liste de toutes les missions, ainsi qu’une page permettant de voir le détail d’une mission.

De plus, il faudra créer une interface back-office, uniquement accessible aux utilisateurs de rôle ADMIN, qui va permettre de gérer la base de données de la bibliothèque. Ce back-office va permettre de lister, créer, modifier et supprimer chaque données des différentes tables, grâce à des formulaires et des tableaux. Il faut que ces pages ne soient pas accessibles à tout le monde ! Il faudra donc créer une page de connexion et de déconnexion (pas de page d'inscription)

Il faut réaliser le projet en programmation orienté objet, de type MVC (ResponseAPI Vue Controller). Chaque table de la base de données sera représentée par un objet PHP.

__BONUS__:
* Intégrer un système de pagination sur toutes les listes du site (front-office / back-office)
* Ajouter un système de filtres et de tri sur toutes les listes du site
* Ajouter un champ de recherche pour une mission

## Consignes techniques
* Le site sera réalisé en HTML5, CSS3, JS ES6+ et PHP 7
* Vous pouvez utiliser un framework CSS de votre choix
* Vous pouvez utiliser les librairies JS / CSS de votre choix, jQuery inclus
* Vous ne pouvez pas utiliser de librairie PHP externe.
* Vous ne pouvez pas utiliser de framework JS, de framework PHP ou node.js

**Le site est à réaliser par groupe imposés de 2 personnes. A rendre le vendredi 25/09/2020 à 17h30.**

## Build
    npm i && npm run build
  
## Groupe
<a href="https://github.com/Iswenzz"><img src="https://avatars3.githubusercontent.com/u/26555415?s=100&v=4" height=64 style="border-radius: 50%"></a>
<a href="https://github.com/ChameauCurieux"><img src="https://avatars2.githubusercontent.com/u/45144369?s=100&v=4" height=64 style="border-radius: 50%"></a>
