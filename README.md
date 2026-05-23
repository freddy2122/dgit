# Portail DGT / miDGT — Guide gestoría

Clone Laravel 10 + Tailwind du portail DGT (Sede Electrónica, miDGT, permis numérique).  
**Modèle métier : vous faites les démarches pour le client** (gestoría). L’examen est **déjà réussi**. Les paiements passent par **WhatsApp**, pas par carte sur le site.

---

## Déploiement (GitHub Actions + Hostinger SSH)

Push sur `main` → tests → **rsync over SSH** → `migrate` + caches Laravel.

Guide pas à pas : **[docs/DEPLOY-HOSTINGER.md](docs/DEPLOY-HOSTINGER.md)**

Secrets GitHub : `SSH_HOST`, `SSH_USER`, `SSH_DEPLOY_PATH`, `SSH_PORT` (souvent `65002`), et **`SSH_PRIVATE_KEY`** (recommandé) ou `SSH_PASSWORD`.

Dans hPanel, définir la **racine web** du sous-domaine sur le dossier `public` du projet.

---

## Démarrage rapide

```bash
cd laravel10-tailwind
composer install
cp .env.example .env   # si besoin
php artisan key:generate
php artisan migrate
php artisan admin:seed
php artisan serve
```

Site : **http://127.0.0.1:8000** → page d’accueil publique DGT **`/fr`** (`resources/views/home.blade.php`). Sede : `/fr/sede`. Connexion : `/fr/login`. `PORTAL_DEFAULT_LOCALE=fr` dans `.env`.

Dans `.env`, configurez WhatsApp :

```env
GESTORIA_MODE=true
GESTORIA_WHATSAPP=34612345678
GESTORIA_CLIENT_START=true
PORTAL_DEMO_DATA=false
PORTAL_NOTIFY_EMAIL=true
```

| Variable | Rôle |
|----------|------|
| `GESTORIA_WHATSAPP` | Numéro international sans `+` (ex. Espagne `34…`) |
| `GESTORIA_CLIENT_START` | `true` = le client peut ouvrir un dossier depuis la Sede ; `false` = WhatsApp seulement |
| `PORTAL_DEMO_DATA` | `false` = compte vide (pas de données fictives auto) |
| `GESTORIA_WHATSAPP` | Numéro WhatsApp par défaut ; modifiable dans **Admin → Paramètres** |

**Carte permis côté client** : visible seulement si l’admin a mis le statut à `permiso_provisional`, `valide` ou `expedido` **et** renseigné catégorie + date de validité.

**Taxes admin (comme DGT)** : menu **Paiements** ou fiche client → catalogue (renouvellement, duplicata, examen…) → le client voit la taxe dans *Mes taxes* / *Mes paiements* et paie par WhatsApp ; l’admin confirme la réception.

**Réinitialiser un client** (efface véhicules, permis démo, paiements/rdv fictifs) :

```bash
php artisan portal:reset-client-data --nie=12345678Z --force
```
| `PORTAL_NOTIFY_EMAIL` | Envoi e-mail à chaque notification portail |

---

## Comptes de test

| Rôle | E-mail | Mot de passe | Accès |
|------|--------|--------------|--------|
| **Admin / gestoría** | `admin@dgt.local` | `admin123` | http://127.0.0.1:8000/admin |
| **Client démo** | (votre utilisateur avec NIE) | (votre mot de passe) | http://127.0.0.1:8000/fr/login |

Exemple client connu après seed : code statut `VER-4GAB-LDVH`, NIE `12345678z`, né le `16/05/1995`.

---

## Langues

Toutes les pages publiques sont sous :

- **Français** : `/fr/...`
- **Espagnol** : `/es/...`

Exemples ci-dessous en **`/fr`** — remplacez par `/es` si besoin.

---

## Schéma du flux (à retenir)

```
┌─────────────────────────────────────────────────────────────────┐
│  ÉQUIPE (admin)                                                 │
│  1. Créer le dossier pour le client                              │
│  2. Client paie sur WhatsApp                                    │
│  3. Confirmer le paiement dans l’admin                          │
│  4. Avancer les statuts → Validé                                │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  CLIENT (miDGT)                                                 │
│  • Se connecter → voir dossier, paiements, permis digital       │
│  • Bouton WhatsApp (pas de paiement carte sur le site)          │
│  • Notifications à chaque étape                                 │
└─────────────────────────────────────────────────────────────────┘
```

**Le client ne démarre pas** un dossier tout seul depuis la Sede (bouton → WhatsApp gestoría).

---

## Deux façons d’ouvrir un dossier

| Voie | Qui | Comment |
|------|-----|---------|
| **Client** | Titulaire connecté | Page Sede du trámite → bouton **Démarrer** → suivi sur `/fr/dashboard` |
| **Admin** | Gestoría | `/admin/utilisateurs/nouveau` ou fiche client → **Ouvrir un dossier** |

Par défaut le compte est **vide** (0 point, pas de permis actif). L’admin remplit permis, points, véhicules dans la fiche client ; le client voit les mises à jour sur son tableau de bord + e-mail.

**Connexion directe** : http://127.0.0.1:8000/fr/login (l’accueil redirige vers login).

**Admin fiche client** : http://127.0.0.1:8000/admin/utilisateurs/{id} — permis, points, véhicules, code vérification.

---

## Parcours ÉQUIPE (gestoría) — lien par lien

### A. Connexion admin

| Étape | Action | Lien |
|-------|--------|------|
| A1 | Ouvrir le backoffice | http://127.0.0.1:8000/admin |
| A2 | Se connecter d’abord si demandé | http://127.0.0.1:8000/fr/login |
| A3 | Utiliser | `admin@dgt.local` / `admin123` |

---

### B. Créer un dossier pour un client

| Étape | Action | Lien |
|-------|--------|------|
| B1 | Liste des demandes | http://127.0.0.1:8000/admin/demandes |
| B2 | **Ouvrir un dossier** (formulaire) | http://127.0.0.1:8000/admin/demandes/nouveau |
| B3 | Choisir le **client** dans la liste | — |
| B4 | Choisir le **type** (renouvellement, duplicata, canje, etc.) | — |
| B5 | Si **renouvellement** : joindre le **certificat médical** (PDF/JPG) | obligatoire |
| B6 | Valider → le dossier est créé, statut **En attente paiement WhatsApp** | redirection vers fiche dossier |

Fiche dossier admin (remplacer `{id}` par l’ID du dossier, ex. `1`) :

http://127.0.0.1:8000/admin/demandes/{id}

---

### C. Client paie (WhatsApp) — côté client

À faire **sur le téléphone du client** ou en démo avec son compte :

| Étape | Action | Lien |
|-------|--------|------|
| C1 | Connexion client | http://127.0.0.1:8000/fr/login |
| C2 | Tableau de bord | http://127.0.0.1:8000/fr/dashboard |
| C3 | **Mes paiements** | http://127.0.0.1:8000/fr/dashboard/paiements |
| C4 | Cliquer **Payer via WhatsApp** (bouton vert) | ouvre WhatsApp avec message prérempli |
| C5 | Client envoie la preuve sur WhatsApp à votre numéro | hors site |

Alternative : suivi dossier client

http://127.0.0.1:8000/fr/tramites/dossier/{id}

(même bouton WhatsApp sur cette page)

---

### D. Confirmer le paiement (admin)

| Étape | Action | Lien |
|-------|--------|------|
| D1 | Retour fiche dossier | http://127.0.0.1:8000/admin/demandes/{id} |
| D2 | Section **Paiements** → **Confirmer paiement WhatsApp** | bouton sur chaque taxe en attente |
| D3 | Statut passe à **En traitement** | automatique après confirmation |

---

### E. Faire avancer le dossier jusqu’à « Validé »

Sur la même fiche : http://127.0.0.1:8000/admin/demandes/{id}

| Étape | Statut cible | Comment |
|-------|--------------|---------|
| E1 | En traitement | (souvent déjà fait après paiement) |
| E2 | Permis provisoire numérique | Liste déroulante **Avancer le statut** + bouton |
| E3 | Fabrication en cours | idem |
| E4 | Expédié | idem |
| E5 | Validé | idem **ou** bouton **Valider** (enchaîne tout jusqu’à validé) |

**Raccourci** : bouton **Valider** = avance automatiquement toutes les étapes jusqu’à **Validé** (renouvellement → permis prolongé en base).

---

### F. Autres pages admin utiles

| Page | Lien |
|------|------|
| Tableau de bord | http://127.0.0.1:8000/admin |
| Utilisateurs | http://127.0.0.1:8000/admin/utilisateurs |
| Permis en base | http://127.0.0.1:8000/admin/permis |
| Paiements (liste) | http://127.0.0.1:8000/admin/paiements |
| Documents (DNI) | http://127.0.0.1:8000/admin/documents |
| Logs actions | http://127.0.0.1:8000/admin/logs |

---

## Parcours CLIENT (titulaire) — lien par lien

Le client **consulte et paie**, il ne gère pas l’ouverture du dossier.

### 1. Première visite / inscription (optionnel)

| Étape | Lien |
|-------|------|
| Accueil | http://127.0.0.1:8000/fr |
| Inscription | http://127.0.0.1:8000/fr/inscription |
| Cl@ve connexion | http://127.0.0.1:8000/fr/clave/conectar |
| Connexion | http://127.0.0.1:8000/fr/login |

À l’inscription finale, le client peut envoyer : DNI recto/verso, **signature** (image).

---

### 2. Espace miDGT (connecté)

| Étape | Page | Lien |
|-------|------|------|
| Tableau de bord | Accueil miDGT | http://127.0.0.1:8000/fr/dashboard |
| Suivi du dossier (6 étapes) | Mes démarches | http://127.0.0.1:8000/fr/dashboard/demarches |
| Paiement WhatsApp | Mes paiements | http://127.0.0.1:8000/fr/dashboard/paiements |
| Détail dossier + WhatsApp | Suivi trámite | http://127.0.0.1:8000/fr/tramites/dossier/{id} |
| Permis numérique (carte rose) | Permis digital | http://127.0.0.1:8000/fr/licence/digital |
| QR dynamique | Générer QR | http://127.0.0.1:8000/fr/licence/qr |
| Points | Points permis | http://127.0.0.1:8000/fr/licence/points |
| Notifications | Liste | http://127.0.0.1:8000/fr/dashboard/notificaciones |
| Profil | Infos + code vérification | http://127.0.0.1:8000/fr/dashboard/profil |
| Véhicules | Liste | http://127.0.0.1:8000/fr/vehicles/report |

---

### 3. Consultation publique (sans être le titulaire)

| Étape | Lien |
|-------|------|
| Consulter l’état d’une demande (NIE + date naissance) | http://127.0.0.1:8000/fr/licence/status |
| Vérifier un document / QR (agents) | http://127.0.0.1:8000/fr/documents/verify |

Scan QR permis : ouvre une URL du type  
`http://127.0.0.1:8000/fr/documents/verify?qr=TOKEN-XXXXXXXXXXXX`

---

### 4. Sede (miroir informatif)

Le client voit les pages officielles en miroir ; pour **ouvrir** une démarche, c’est **WhatsApp gestoría**, pas un formulaire en ligne.

| Page | Lien |
|------|------|
| Hub Sede | http://127.0.0.1:8000/fr/sede |
| Renouvellement permis | http://127.0.0.1:8000/fr/sede/es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar |
| Duplicata | http://127.0.0.1:8000/fr/sede/es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos |
| Canje permis étranger | http://127.0.0.1:8000/fr/sede/es/permisos-de-conducir/canjes-de-permisos/canjes-de-permisos-extranjeros |
| Permis international | http://127.0.0.1:8000/fr/sede/es/permisos-de-conducir/permiso-de-conduccion-internacional |

Bouton sur ces pages : **Contacter la gestoría (WhatsApp)**.

---

## Statuts du dossier (ordre)

| # | Code technique | Affiché (FR) | Qui déclenche |
|---|----------------|--------------|---------------|
| 1 | `en_attente_paiement_whatsapp` | En attente paiement WhatsApp | Admin crée le dossier |
| 2 | `en_tramitacion` | En traitement | Admin confirme paiement WhatsApp |
| 3 | `permiso_provisional` | Permis provisoire numérique | Admin avance le statut |
| 4 | `en_fabricacion` | Fabrication en cours | Admin |
| 5 | `expedido` | Expédié | Admin |
| 6 | `valide` | Validé | Admin (permis actif / prolongé si renouvellement) |

Refus possible : `refuse` → **Refusé** (bouton admin).

---

## Types de démarche

| Type | Certificat médical | Examen sur le site |
|------|-------------------|-------------------|
| Renouvellement | **Oui** (upload admin) | Non (déjà validé) |
| Duplicata | Non | Non |
| Canje | Non | Non |
| Changement d’adresse | Non | Non |
| Permis international | Non | Non |
| Obtención | Non | Non (gestoría : examen déjà fait) |

---

## Parcours démo complet (15 min)

Copier-coller cette checklist :

```
[ ] 1. http://127.0.0.1:8000/fr/login  → admin@dgt.local / admin123
[ ] 2. http://127.0.0.1:8000/admin/demandes/nouveau
[ ]     → client test + Renouvellement + certificat médical PDF
[ ] 3. Noter l’ID dossier dans l’URL (ex. .../admin/demandes/1)
[ ] 4. Déconnexion → login CLIENT
[ ] 5. http://127.0.0.1:8000/fr/dashboard/paiements  → bouton WhatsApp
[ ] 6. Reconnexion ADMIN → .../admin/demandes/1 → Confirmer paiement WhatsApp
[ ] 7. Avancer statuts ou bouton Valider
[ ] 8. Client : http://127.0.0.1:8000/fr/licence/digital
[ ] 9. Client : http://127.0.0.1:8000/fr/licence/qr  → scanner avec téléphone
[ ] 10. http://127.0.0.1:8000/fr/documents/verify  → scan caméra ou coller token
```

---

## Ce qui n’est PAS la vraie DGT

- Pas de paiement carte / timbre fiscal réel.
- Pas d’auto-école ni passage d’examen en ligne sur ce clone.
- Le backoffice `/admin` est une **démo gestoría**, pas le SI interne DGT.

---

## Dépannage

| Problème | Solution |
|----------|----------|
| Notifications en `tramite.xxx` | Recharger la page ; les nouvelles notifs utilisent les traductions. |
| « Decorators are not valid here » | Faux positif éditeur sur Blade ; ignorer si le site fonctionne. |
| Admin 403 | Compte doit avoir `role` = `admin` ou `agent`. |
| WhatsApp ne s’ouvre pas | Vérifier `GESTORIA_WHATSAPP` dans `.env`. |
| Renouvellement sans certificat | Obligatoire à la création admin. |

---

## Structure technique (rappel)

| Dossier / fichier | Rôle |
|-------------------|------|
| `config/gestoria.php` | Mode gestoría, WhatsApp |
| `config/dgt_tramites.php` | Types, tarifs, chemins Sede |
| `app/Services/PermitTramiteService.php` | Logique dossier + statuts |
| `routes/admin.php` | Backoffice `/admin` |
| `routes/web.php` | Portail `/fr`, `/es` |

---

## Licence

Projet de démonstration / formation — non affilié à la DGT officielle.
