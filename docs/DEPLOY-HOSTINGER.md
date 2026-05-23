# Déploiement Hostinger (mutualisé) + sous-domaine — **SSH**

GitHub Actions envoie le projet en **rsync over SSH** à chaque push sur `main` (après les tests), puis exécute `migrate` et les caches Laravel.

Dépôt : [github.com/freddy2122/dgit](https://github.com/freddy2122/dgit)

---

## Étape 1 — Activer SSH sur Hostinger

1. [hPanel](https://hpanel.hostinger.com) → **Avancé** → **Accès SSH** (ou **SSH Access**).
2. **Activer** l’accès SSH si ce n’est pas déjà fait.
3. Notez :
   - **Hôte** (hostname ou IP)
   - **Port** : souvent **65002** (pas 22)
   - **Utilisateur** : ex. `u123456789`
   - **Mot de passe** SSH (ou ajoutez une **clé publique** dans hPanel — recommandé)

Test depuis votre Mac :

```bash
ssh -p 65002 u123456789@votre-host.hostinger.com
```

Une fois connecté, allez dans le dossier du sous-domaine et notez le chemin absolu :

```bash
cd domains/midgt.votredomaine.com && pwd
# Exemple : /home/u123456789/domains/midgt.votredomaine.com
```

Ce chemin = secret GitHub **`SSH_DEPLOY_PATH`**.

---

## Étape 2 — Créer le sous-domaine

1. **Domaines** → **Sous-domaines** → **Créer** (ex. `midgt.votredomaine.com`).
2. **Racine du document** → pointer vers le dossier **`public`** :
   ```
   /home/u123456789/domains/midgt.votredomaine.com/public
   ```
   (le chemin exact dépend de votre compte ; utilisez `pwd` en SSH.)

---

## Étape 3 — Secrets GitHub (obligatoires)

**GitHub** → dépôt **dgit** → **Settings** → **Secrets and variables** → **Actions** :

| Secret | Description | Obligatoire |
|--------|-------------|-------------|
| `SSH_HOST` | Hostname SSH Hostinger | Oui |
| `SSH_USER` | Utilisateur SSH (ex. `u123456789`) | Oui |
| `SSH_DEPLOY_PATH` | Chemin absolu du projet (sans `/` final) | Oui |
| `SSH_PORT` | Port SSH (souvent `65002`) | Non |
| `SSH_PASSWORD` | Mot de passe SSH | Oui * |
| `SSH_PRIVATE_KEY` | Clé privée PEM (déploiement) | Oui * |

\* **Soit** mot de passe **soit** clé privée. La clé est plus sûre : générez une paire dédiée au CI, ajoutez la **publique** dans hPanel, la **privée** dans `SSH_PRIVATE_KEY`.

Le workflow **n’envoie jamais** le fichier `.env` (à créer une seule fois sur le serveur).

---

## Étape 4 — Clé SSH pour GitHub (recommandé)

Sur votre Mac :

```bash
ssh-keygen -t ed25519 -C "github-deploy-dgit" -f ~/.ssh/hostinger_dgit -N ""
```

1. Contenu de `~/.ssh/hostinger_dgit.pub` → hPanel → SSH → **Ajouter une clé SSH**.
2. Contenu de `~/.ssh/hostinger_dgit` (clé **privée**) → secret GitHub **`SSH_PRIVATE_KEY`** (tout le bloc, y compris `BEGIN` / `END`).
3. Vous pouvez laisser `SSH_PASSWORD` vide si vous n’utilisez que la clé.

Test :

```bash
ssh -i ~/.ssh/hostinger_dgit -p 65002 u123456789@votre-host.hostinger.com
```

---

## Étape 5 — `.env` et base MySQL (une fois, sur le serveur)

En SSH :

```bash
cd /home/u123456789/domains/midgt.votredomaine.com
cp .env.example .env
nano .env   # ou éditeur hPanel
```

Minimum :

```env
APP_NAME="miDGT"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://midgt.votredomaine.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

1. hPanel → **Bases de données** → créer DB + utilisateur.
2. `php artisan key:generate` (en SSH, dans le dossier du projet).
3. Première migration + compte admin (ou laisser le workflow faire `migrate`) :
   ```bash
   php artisan migrate --force
   php artisan admin:seed
   ```
   Identifiants par défaut : `admin@dgt.local` / `admin123` → `/admin` (changez le mot de passe ensuite).

Permissions :

```bash
chmod -R ug+rwx storage bootstrap/cache
```

---

## Étape 6 — Lancer le déploiement

- **Automatique** : `git push` sur `main`.
- **Manuel** : GitHub → **Actions** → **Deploy Hostinger** → **Run workflow**.

Le job :

1. Lance les tests
2. `composer install --no-dev` + `npm run build`
3. **rsync** vers `SSH_DEPLOY_PATH`
4. **SSH** : `migrate`, `config:cache`, `route:cache`, etc.

---

## Vérification

- `https://midgt.votredomaine.com/fr`
- `https://midgt.votredomaine.com/admin`

---

## Dépannage

| Problème | Solution |
|----------|----------|
| `Permission denied (publickey)` | Clé publique dans hPanel ; ou `SSH_PASSWORD` correct |
| `Connection refused` | Vérifier **port 65002** ; SSH activé dans hPanel |
| Chemin rsync incorrect | `SSH_DEPLOY_PATH` = sortie de `pwd` dans le dossier du sous-domaine |
| 500 après deploy | `storage/` et `bootstrap/cache/` en écriture ; voir `storage/logs/laravel.log` |
| `.env` manquant | Créer `.env` sur le serveur (jamais dans Git) |
| `php: command not found` en SSH | Utiliser le binaire indiqué par Hostinger, ex. `php82 artisan migrate` |

---

## PHP Hostinger

hPanel → **Configuration PHP** sur le sous-domaine → **PHP 8.2** (minimum 8.1).

Extensions : `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `gd`, `zip`, `curl`.

---

## Racine web sans `/public` (cas rare)

Si vous ne pouvez pas changer la racine vers `public/`, voir `deploy/hostinger-public_html-index.php` dans le dépôt.
