# BackendProjArt

La base de données a été créer de tel façon qu’il soit possible pour un élève d’être inscrit au cours indépendamment des classes.
Ceci vise à permettre aux étudiants redoublants ou suivant des modules dans des classes différentes d’être incorporé facilement à la base de données. 
Puisque nous n’avions pas une vision claire dès le départ de la façon dont nous allions joindre le back-end et le front-end, 
les deux équipes respectives ont commencé à travailler chacune de leur côté sans suffisamment communiqué, 
cela a mener a beaucoup de confusion et d’ajustements au moment de lier les deux. 
Par exemple nous avons perdu beaucoup de temps en tentant d’installer vuejs « dans laravel ».
Nous avons finalement décidé de partir sur une api et avons créer une authentification avec Sanctum, 
qui créait un token lié à une table utilisateur mais qui rendait les requête du front trop compliquées au vu du temps qu’il nous restait 
(nous aurions peut-être dû essayer d’utiliser Axios) le login Sanctum est toutefois toujours prêt à être utiliser dans l’application si il s’avérait nécessaire. 
Nous sommes finalement parti sur un login avec laravel et l’utilisation des cookies mis en place automatiquement par le framework.
Malheureusement, malgré notre acharnement et bien qu’il soit possible d’insérer des données dans la bd via postman,
il est impossible pour un utilisateur d’en ajouter directement depuis l’application. Pour une raison qui semble être un problème configuration serveur,
il nous est impossible d’ajouter via postman un timestamp supérieur à la date du 31 décembre 1969 
(nous avons changé le type dans la table en biginteger pour tenter d’ajouter manuellement 50 ans sans succès).

Ceci est le repo de travail, mais vers la fin, des modifications ont du êtres apportées directement sur le serveur. Pour voir la version définitive présente sur le serveur, cliquer [ici](https://github.com/MIchelData/abeProjetArt)
