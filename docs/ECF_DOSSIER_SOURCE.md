# DOSSIER DE CONCEPTION - PENDAFITNESS
**Titre professionnel DWWM - ECF**  
**Candidat : PENDA ESSAMA LEOPOLD EMMANUEL**

## 1. Présentation du projet
PENDAFITNESS est une application web de réservation d'activités sportives. Un visiteur peut découvrir le catalogue et filtrer les offres. Un membre crée un compte, réserve une séance, suit ses réservations, gère ses favoris et dépose un avis après participation. Un coach gère les activités, les séances, les réservations, les avis et les demandes de contact. L'administrateur pilote les comptes coach et consulte les indicateurs d'activité.

## 2. Besoin et objectifs
Le projet répond au besoin d'une structure sportive souhaitant centraliser son catalogue et ses inscriptions. Les objectifs sont : rendre les activités visibles, simplifier la réservation, contrôler les capacités, fournir un espace membre, donner aux équipes des outils métier et proposer une administration sécurisée.

## 3. Acteurs
- Visiteur : consulter, filtrer, contacter, s'inscrire, se connecter.
- Membre : profil, réservation, annulation, favoris, avis.
- Coach : CRUD activités, séances, réservations, avis, contacts.
- Administrateur : statistiques et comptes coach.

## 4. Technologies
HTML5 structure les pages, CSS3 personnalise l'identité visuelle, Bootstrap 5 assure la grille responsive, JavaScript apporte les interactions. PHP 8 implémente le serveur selon MVC. PDO et les requêtes préparées gèrent les accès SQL. MySQL sert au développement et TiDB Cloud à la production. Git/GitHub assurent le versionnement. Render héberge l'application conteneurisée.

## 5. Architecture MVC
Navigateur -> routeur (`public/index.php`) -> contrôleur -> modèle -> PDO -> base de données -> contrôleur -> vue -> navigateur.

## 6. User stories principales
| ID | En tant que | Je veux | Afin de | Critère d'acceptation |
|---|---|---|---|---|
| US01 | visiteur | filtrer les activités | trouver une séance adaptée | filtres sport/niveau/prix/recherche fonctionnels |
| US02 | visiteur | créer un compte | devenir membre | e-mail unique, mot de passe >= 8 caractères |
| US03 | membre | réserver une séance | garantir ma place | réservation refusée si capacité atteinte |
| US04 | membre | annuler | libérer ma place | seulement avant la séance |
| US05 | membre | gérer mes favoris | retrouver mes activités | ajout/retrait persistant en BDD |
| US06 | membre | donner un avis | partager mon expérience | uniquement après une séance, avis en attente |
| US07 | coach | gérer les activités | maintenir le catalogue | création, modification, activation/désactivation |
| US08 | coach | programmer les séances | ouvrir des créneaux | date, capacité, coach, salle enregistrés |
| US09 | coach | modérer les avis | contrôler la publication | accepter/refuser un avis |
| US10 | admin | gérer les coachs | contrôler les accès métier | création et activation/désactivation |
| US11 | admin | consulter des statistiques | suivre l'activité | KPI et graphique disponibles |

## 7. Charte graphique
Palette : bleu nuit #101828, orange #FF6B35, turquoise #19C3B1, jaune #FFC857, violet #7C5CFC et gris clair #F5F7FB. L'interface privilégie les grandes photographies sportives, cartes arrondies, contrastes forts et appels à l'action orange.

## 8. Modèle conceptuel de données
Entités : ROLE, UTILISATEUR, CATEGORIE_SPORT, ACTIVITE, SEANCE, RESERVATION, AVIS, FAVORI, CONTACT, HORAIRE. Un rôle possède plusieurs utilisateurs. Une catégorie regroupe plusieurs activités. Une activité possède plusieurs séances. Un membre peut avoir plusieurs réservations et une séance plusieurs réservations. FAVORI matérialise la relation N,N membre-activité. Un avis appartient à un membre et à une activité.

## 9. MLD
ROLE(id, name)  
USER(id, #role_id, firstname, lastname, email, password, phone, city, active)  
SPORT_CATEGORY(id, name, slug, icon)  
ACTIVITY(id, #category_id, title, description, level, duration_minutes, price, image_url, location, active)  
SESSION(id, #activity_id, starts_at, duration_minutes, capacity, coach_name, room)  
RESERVATION(id, #user_id, #session_id, status, created_at)  
REVIEW(id, #user_id, #activity_id, rating, comment, status)  
FAVORITE(#user_id, #activity_id)  
CONTACT(id, name, email, subject, message, status)  
OPENING_HOUR(id, day_name, open_time, close_time, closed)

## 10. Sécurité
Mots de passe avec `password_hash`/`password_verify`, requêtes PDO préparées, jeton CSRF sur les actions POST, contrôle des rôles, session régénérée à la connexion, validation serveur, échappement HTML, variables d'environnement pour les secrets et TLS pour TiDB Cloud.

## 11. Responsive et accessibilité
Bootstrap permet l'empilement des cartes et formulaires sur petits écrans. Les contrôles conservent des libellés, les contrastes sont élevés et la navigation reste disponible via le menu burger.

## 12. Tests fonctionnels
| Test | Action | Résultat attendu |
|---|---|---|
| T01 | ouvrir accueil mobile | menu burger et cartes responsive |
| T02 | inscription e-mail invalide | erreur affichée |
| T03 | connexion membre valide | session créée |
| T04 | réserver séance disponible | réservation confirmée |
| T05 | réserver séance complète | refus sans dépassement capacité |
| T06 | accès `/coach` comme membre | 403 |
| T07 | coach crée activité | activité visible dans gestion/catalogue si active |
| T08 | coach programme séance | créneau visible sur fiche activité |
| T09 | avis membre après séance | statut pending |
| T10 | coach valide avis | avis visible publiquement |
| T11 | admin crée coach | compte coach créé |
| T12 | dashboard admin | KPI et graphique affichés |

## 13. Déploiement
Le code est poussé sur GitHub. Render construit l'image à partir du Dockerfile. Les variables de connexion TiDB sont enregistrées dans l'environnement Render. Le schéma SQL est importé dans TiDB Cloud. Après déploiement, les parcours visiteur, membre, coach et administrateur sont testés en production.

## 14. Difficultés et solutions possibles
La migration MySQL/TiDB nécessite une configuration correcte du port, des identifiants et de TLS. Les erreurs de routes sont diagnostiquées via les logs Render. Les contraintes de capacité sont contrôlées dans une transaction lors de la réservation.

## 15. Conclusion
PENDAFITNESS démontre les deux dimensions du titre DWWM : une interface responsive et dynamique côté front-end, et une application serveur sécurisée, reliée à une base relationnelle et déployable côté back-end.
