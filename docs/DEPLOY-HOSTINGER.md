# Déploiement Hostinger (mutualisé) + sous-domaine

GitHub Actions envoie le projet en **FTP/FTPS** à chaque push sur `main` (après les tests).

Dépôt : [github.com/freddy2122/dgit](https://github.com/freddy2122/dgit)

---

## Étape 1 — Créer le sous-domaine dans hPanel

1. Connectez-vous à [hPanel Hostinger](https://hpanel.hostinger.com).
2. **Domaines** → **Sous-domaines** → **Créer**.
3. Exemple : `midgt` → `midgt.votredomaine.com`.
4. Notez le dossier créé, souvent :
   - `/domains/midgt.votredomaine.com/`

---

## Étape 2 — Racine web = dossier `public` (recommandé)

1. **Domaines** → votre sous-domaine → **Paramètres du site** / **Racine du document**.
2. Définir la racine sur :
   ```
   /domains/midgt.votredomaine.com/public
   ```
3. Le workflow FTP envoie tout le projet dans `/domains/midgt.votredomaine.com/` (secret `FTP_REMOTE_DIR`).

---

## Étape 3 — Compte FTP

1. hPanel → **Fichiers** → **Comptes FTP** (ou **FTP Accounts**).
2. Créez un compte ou utilisez le compte principal.
3. Notez :
   - **Hôte** : souvent `ftp.votredomaine.com` ou l’IP indiquée
   - **Utilisateur** / **Mot de passe**
   - **Port** : `21`
   - **Protocole** : **FTPS** (FTP avec SSL)

Testez avec FileZilla avant GitHub Actions.

---

## Étape 4 — Secrets GitHub

**GitHub** → dépôt **dgit** → **Settings** → **Secrets and variables** → **Actions** :

| Secret | Exemple | Obligatoire |
|--------|---------|-------------|
| `FTP_HOST` | `ftp.votredomaine.com` | Oui |
| `FTP_USERNAME` | `u123456789` | Oui |
| `FTP_PASSWORD` | mot de passe FTP | Oui |
| `FTP_REMOTE_DIR` | `/domains/midgt.votredomaine.com` | Oui |
| `FTP_PORT` | `21` | Non |
| `FTP_PROTOCOL` | `ftps` | Non (défaut `ftps`) |

`FTP_REMOTE_DIR` : **sans** slash final, chemin exact affiché dans le gestionnaire de fichiers Hostinger.

### SSH optionnel (offres avec terminal SSH)

Si hPanel propose **SSH** (souvent port **65002**) :

| Secret | Exemple |
|--------|---------|
| `SSH_HOST` | IP ou hostname SSH Hostinger |
| `SSH_USER` | `u123456789` |
| `SSH_PASSWORD` | mot de passe SSH |
| `SSH_DEPLOY_PATH` | `/home/u123/domains/midgt.votredomaine.com` |
| `SSH_PORT` | `65002` |

Si ces secrets sont renseignés, le workflow exécute `migrate` et `optimize` après l’envoi FTP.

---

## Étape 5 — Fichier `.env` sur le serveur (une fois)

Le `.env` **n’est jamais** envoyé par GitHub (sécurité).

1. hPanel → **Gestionnaire de fichiers** → dossier du sous-domaine.
2. Copiez `.env.example` en `.env`.
3. Modifiez au minimum :

```env
APP_NAME="miDGT"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://midgt.votredomaine.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123_dgit
DB_USERNAME=u123_dgit
DB_PASSWORD=...

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

4. Base MySQL : hPanel → **Bases de données** → créer DB + utilisateur → associer.

5. Générer `APP_KEY` :
   - Terminal SSH : `php artisan key:generate`
   - Ou localement : `php artisan key:generate --show` puis coller dans `.env` sur le serveur.

6. Migrations (une fois) :
   - SSH : `cd .../domains/midgt... && php artisan migrate --force`
   - Ou import SQL via phpMyAdmin si pas de SSH.

---

## Étape 6 — Permissions (important)

Dans le gestionnaire de fichiers, dossiers en **755**, fichiers en **644**.

Écriture pour Laravel (via hPanel ou FTP) :

- `storage/` → **775** (récursif)
- `bootstrap/cache/` → **775**

---

## Étape 7 — Lancer le déploiement

- **Automatique** : `git push` sur `main`.
- **Manuel** : GitHub → **Actions** → **Deploy Hostinger** → **Run workflow**.

Vérifiez l’onglet **Actions** : job vert = fichiers envoyés.

---

## Si vous ne pouvez pas changer la racine vers `/public`

Structure alternative :

```
/domains/midgt.votredomaine.com/
    app/, vendor/, storage/, …
    public_html/          ← contenu du dossier public/ du projet
        .htaccess
        build/
        index.php         ← utiliser deploy/hostinger-public_html-index.php
```

Copiez `deploy/hostinger-public_html-index.php` vers `public_html/index.php` après le premier déploiement.

---

## Vérification

- `https://midgt.votredomaine.com/fr` — accueil
- `https://midgt.votredomaine.com/fr/login`
- `https://midgt.votredomaine.com/admin` — back-office

---

## Dépannage

| Problème | Solution |
|----------|----------|
| Erreur FTP GitHub | Vérifier FTPS, mot de passe, `FTP_REMOTE_DIR` |
| 403 / page blanche | Racine web → `/public` ; vérifier `.htaccess` |
| 500 | Permissions `storage` ; logs dans `storage/logs/laravel.log` |
| CSS/JS manquants | `npm run build` est fait dans Actions ; vérifier `public/build` sur le serveur |
| `.env` manquant | Créer `.env` manuellement sur Hostinger |

---

## PHP Hostinger

Choisissez **PHP 8.2** (ou 8.1 minimum) pour le sous-domaine dans hPanel → **PHP Configuration**.

Extensions utiles : `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `gd`, `zip`, `curl`.
