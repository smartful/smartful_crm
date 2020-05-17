# SMARTFUL CRM

SMARTFUL CRM est un démontrateur technologique.
Son but n'est pas d'être un CRM, mais de mettre en application le _framework_ ou _orm_ qui permet d'abstraire la communication vis à vis de la base de données.

## Environnement technique

PHP 7.2
MySQL 5.7
Apache 2.4

## Instruction d'installation

Créez la base de données **crm** grâce au script *smartful_crm_bdd*.
En local j'utilise le logiciel **Laragon**.
Mettre la base de code dans de répertoire *www/*.

## Documentation

Une documentation des méthodes des différentes classe de base est disponible dans le fichier *docs.php* à la racine du projet.

## À savoir

### Désactivation des warnings en mode développement
La classe BaseManager est la classe mère de tous les managers.
Cette classe implémente les méthodes :
```php
public function add(Base $object): int
public function update(Base $object) : void
public function delete(Base $object) : void
```

Si on prend une classe héritant de BaseManager, on surcharge les méthodes :
```php
class CompanyManager extends BaseManager
{
    ...

    public function add(Company $company) : int
    {
        $id = parent::add($company);
        return $id;
    }

    public function update(Company $company) : void
    {
        parent::update($company);
    }

    public function delete(Company $company) : void
    {
        parent::delete($company);
    }
    
    ...
}
```

Cette surcharge provoque des warnings. 
Or dans les configurations de développement, le php.ini est configuré pour renvoyer des erreurs.
Il vous sera donc nécessaire de configurer votre php.ini ainsi pour que le projet fonctionne correctement sur votre environnement :

```
error_reporting = E_ALL & ~E_WARNING
```

### En prod, pensez à .gitignore PDOFactory.php

Si vous utilisez ce projet en production (et que vous utiliser le gestionnaire de version Git), il vous sera nécessaire de créer à la racine un .gitignore pour protéger le identifiant et le mot de passe de votre base de données.

```
lib/factory/PDOFactory.php
```

Dans le projet, PDOFactory.php n'est pas dans le .gitignore car les identifiants utilisés sont des identifiants par défauts. 

### Cryptage de mot de passe

Le projet SMARTFUL CRM est un démonstrateur technologique.
La technologie pour crypter le mot de passe est md5.
Cette technologie a été utilisé car elle est facilement réversible, ce qui est pratique pour le débugage, mais une mauvaise pratique pour un usage en production.

Si vous utilisez SMARTFUL CRM pour un projet en production, il vous sera nécessaire d'utiliser une technologie de cryptage plus robuste.

### Les données sur les villes

La table sur les villes a été récupérée sur internet.
Les données n'ont pas été vérifiée, il n'est donc pas impossible que certaines données soient érronnées. 