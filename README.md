# Farmitoo - test 🧑🏼‍💻

### lancement :

- J'ai choisit d'utiliser Docker pour le projet, il faut donc lancer : `docker-compose up --build``
- L'URL du projet est : http://localhost:8741

### Choix de conception back :

- J'ai décidé d'utiliser une l'abstraction concernant les marques des produits, cela permet de plus tard pouvoir ajouter facilement de nouvelle marque avec des règles de calcul de TVA et de frais de port précise sur la marque

- Concernant les promotions, j'ai estimé que les promotions s'appliquaient sur l'ensemble du panier.

- Concernant la TVA, si le pays n'est pas indiqué au moment de l'initialisation de marque, c'est la TVA "par défaut" qui est appliquée

### Choix de conception front :

- J'ai utilisé le Bootstrap, je l'ai installé en tant que lib mais l'utilisation d'un CDN aurait été plus judicieux

# TEST

Ceci est le repository pour le test technique de Farmitoo.

## Le cas

L'objectif est d'afficher une page "panier" sur laquelle sont visibles :

- tous les produits avec titre, prix unitaire, marque et quantité
- sous-total HT
- promotion (le cas échéant)
- frais de port HT
- total HT
- TVA
- Total TTC
- un bouton pour aller sur la page de paiement

#### Info TVA

Le business modèle de Farmitoo implique des règles de calculs de la TVA complexes.
Dans notre cas, il est simplifié et le taux de TVA dépend seulement de la marque du produit :

- Farmitoo => 20%
- Gallagher => 5%

#### Info frais de port

Les partenaires de Farmitoo ont des règles de calculs de frais de port très différentes.
Voici celles de notre cas :

- Farmitoo : 20€ par tranche de 3 produits entamée (ex: 20€ pour 3 produits et 40€ pour 4 produits)
- Gallagher : 15€ quelque soit le nombre de produits

## L'évaluation

Il faut penser ton code comme évolutif :

- ajout de 10 nouvelles marques avec des nouvelles règles de calculs de TVA et de calculs de frais de port
- prise en compte du pays dans le calcul de la TVA
- nouvelles conditions d'application des promotions (nombre de produits, date, nombre d'utilisation...)

Au niveau global, sera évalué :

- la qualité du code
- la rigueur

#### Front

- L'UX
- L'organisation du code

#### Back

- Les choix de conception
- L'organisation du code

#### Test

L'objectif n'est pas un code coverage de 100% !
Mais un choix judicieux des choses à tester.
