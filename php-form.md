# PHP : les formulaires

Vous allez aujourd'hui créer un formulaire simple permettant, par exemple, de recueillir des informations sur de potentiels clients visitant le site internet de votre entreprise. Afin de limiter les messages de robots ou les messages malintentionnés, vous devrez valider les données soumises par  l'Utilisateur-rice.

Tout au long des exercices vous respecterez les bonnes pratiques liées aux langages utilisés. 
**L'intégralité des exercices devront être réalisés sur le même projet et sans Chat GPT.**


## Exercice 1 : les bases

En HTML, sur une page, vous créerez un formulaire avec les balises et attributs adaptés.
Ce formulaire devra contenir les champs suivants :

 - Nom (obligatoire)
 - Prénom (obligatoire)
 - Email (obligatoire)
 - Téléphone
 - Sujet
 - Message (obligatoire)
 - Inscription à la *newsletter*

> **Conseil** : maintenant que vous connaissez les rudiments du PHP, il est vivement conseillé d'utiliser des fichiers PHP (en .php) plutôt que des fichiers HTML (en .html). 

Une fois votre structure HTML établie, vous rendrez votre formulaire plus esthétique grâce à des règles CSS.
Vous veillerez notamment que son design soit *responsive*.

## Exercice 2 : validation des données

En PHP, vous validerez l'intégralité des données envoyées via le formulaire.
Vous afficherez, en dessous du formulaire, un récapitulatif des données envoyées en précisant si chaque donnée est considérée comme étant valide ou invalide.

## Exercice 3 : gestion des erreurs

Afin de guider l'Utilisateur-rice utilisant votre formulaire, vous rendrez visuel, après soumission d'un message, le fait qu'une donnée soit valide ou non.
Dans un second temps, si une donnée est considérée comme invalide, vous afficherez en dessous du champ invalide un message informant l'Utilisateur-rice de la nature de l'erreur.

***

### Bonus 1
Votre entreprise fonctionne bien et il est maintenant être pertinent pour vous d'agrandir votre équipe.
Le formulaire de contact peut être un excellent moyen de récupérer passivement des candidatures.

Pour ce faire, vous ajouterez un champ permettant à l'Utilisateur-rice de vous envoyer un fichier.
Vous validerez également les données concernant ce nouveau champ selon les règles suivantes :
- Les formats de fichier acceptés sont : `.doc`, `.docx`, `.pdf`, `.txt`, `.jpg` et `.png`
- Le poids du fichier ne doit pas être supérieur à 2 Mo

Les fichiers considérés comme valides seront stockés dans un dossier.

### Bonus 2
Votre entreprise connait dorénavant un succès mérité. Le problème : vous n'avez plus le temps de lire les messages envoyés via le formulaire lorsqu'ils arrivent dans votre boîte de réception. Il vous faudra donc stocker les soumissions émises par votre formulaire afin que vous puissiez les visualiser à loisir.

Après la soumission d'un message et si toutes les données sont valides, vous enregistrerez les données dans un fichier CSV. Vous ajouterez aux données de chaque soumission la date d'envoi de cette dernière.


