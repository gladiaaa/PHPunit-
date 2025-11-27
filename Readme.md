# Exo phpUnit

Ce projet a pour but de démontrer l'utilisation de phpUnit pour tester des fonctionnalités PHP.

## Objectif

Le programme propose des exemples de fonctions PHP testées avec phpUnit. Un fichier `demo.php` permet de voir le fonctionnement des fonctions en dehors des tests.

## Lancer les tests avec phpUnit

1. Installer phpUnit (si ce n'est pas déjà fait) :
    ```bash
    composer require --dev phpunit/phpunit
    ```
2. Exécuter les tests :
    ```bash
    ./vendor/bin/phpunit tests
    ```

## Utiliser `demo.php`

Pour exécuter le fichier de démonstration :
```bash
php demo.php
```
Ce fichier affiche des exemples d'utilisation des fonctions du projet.


## Créer le coverage 

Pour créer le coverage : 
```bash
vendor/bin/phpunit --coverage-html coverage
```
## Structure du projet

- `src/` : Contient le code source PHP.
- `tests/` : Contient les fichiers de tests phpUnit.
- `demo.php` : Fichier de démonstration.
- `Coverage `: Fichier xdebugs.

## Prérequis

- PHP >= 7.4
- Composer


Annic Ryan
Dumas Jolly Axel
Mouhajer Rayane
Sakri Katia

Readme.md généré Partiellement par IA