# Seedbox Test Développeur

## Prerequisites

* PHP 7.2.5 or + and these PHP extensions: Ctype, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer;
* Composer


## Configuration
```bash
renommer .env.local -> .env
modifier les informations correspondante (DATABASE_URL, API_SERVER_URL)
```

## Installation
```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console app:create-fake-data
```

## Generate the SSH keys (JWT):

```bash
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
/!\ Attention n'oubliez pas de changer le JWT_PASSPHRASE dans le fichier .env

## À venir (les points que j'aurais pu ajouter)
```bash
Timestampable (created, updated) sur les Entity
UserManager - (Pour la gestion des utilisateurs (created, updated, ..))
Système de logs - (par fichier ou en bdd pour la traçabilité)
Ajout de vérification sur les données envoyer et meilleure gestion des erreurs
```

## Doc API
```bash
client-side
Toutes les urls du client-side ont besoin dun header Authorization => Bearer {token} sinon cela retourne sur erreur 401
    - /login_check - POST - {"username": string, "password": string} - retourne un token (JWT)
    - / - GET - (listes des servers)
    - /servers/{id} - GET
    - /servers - POST - {"name": string, "active": bool, "customData": string}
    - /servers/{id} - PUT - {"name": string, "active": bool, "customData": string}
    - /servers/{id} - DELETE

server-side
Toutes les urls du server-side ont besoin dune clé api (AUTH_TOKEN) sinon cela retourne une erreur 401
    - /api/servers - GET - (listes des servers)
    - /api/servers/{id} - GET
    - /api/servers - POST - {"name": string, "active": bool, "customData": string}
    - /api/servers/{id} - PUT - {"name": string, "active": bool, "customData": string}
    - /api/servers/{id} - DELETE
```


Merci d'avoir pris le temps de regarder ceci.

## License
[MIT](https://choosealicense.com/licenses/mit/)
