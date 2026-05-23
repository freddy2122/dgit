# Déploiement avec GitHub Actions

Deux workflows dans `.github/workflows/` :

| Fichier | Déclencheur | Rôle |
|---------|-------------|------|
| `ci.yml` | Push / PR sur `main` | Lance les tests PHPUnit |
| `deploy.yml` | Push sur `main` (après tests OK) | Déploie sur votre serveur via SSH |

## 1. Préparer le serveur (une fois)

Sur le VPS (Ubuntu/Debian recommandé) :

```bash
# PHP 8.2+, Composer, Node 20+, MySQL/MariaDB, Nginx ou Apache
sudo apt update
sudo apt install -y php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd git nginx mysql-server nodejs npm composer

# Utilisateur dédié (ex. deploy)
sudo adduser deploy

# Cloner le dépôt (chemin = DEPLOY_PATH)
sudo mkdir -p /var/www/dgit
sudo chown deploy:deploy /var/www/dgit
sudo -u deploy git clone https://github.com/freddy2122/dgit.git /var/www/dgit
cd /var/www/dgit

# .env production (NE PAS commiter)
cp .env.example .env
nano .env   # APP_URL, DB_*, APP_KEY, mail, etc.
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder   # optionnel

# Permissions Laravel
chmod -R 775 storage bootstrap/cache
# Nginx : racine web = /var/www/dgit/public
```

Exemple Nginx (`/etc/nginx/sites-available/dgit`) :

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/dgit/public;

    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }
}
```

## 2. Clé SSH pour GitHub Actions

Sur votre Mac :

```bash
ssh-keygen -t ed25519 -C "github-actions-dgit" -f ~/.ssh/dgit_deploy -N ""
```

Sur le serveur (`deploy` user) :

```bash
mkdir -p ~/.ssh && chmod 700 ~/.ssh
echo "CONTENU_DE_dgit_deploy.pub" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

## 3. Secrets GitHub

Dépôt → **Settings** → **Secrets and variables** → **Actions** → **New repository secret** :

| Secret | Exemple | Description |
|--------|---------|-------------|
| `SSH_HOST` | `123.45.67.89` | IP ou domaine du serveur |
| `SSH_USER` | `deploy` | Utilisateur SSH |
| `SSH_PRIVATE_KEY` | contenu de `dgit_deploy` | Clé privée (tout le fichier) |
| `SSH_PORT` | `22` | Optionnel si port SSH custom |
| `DEPLOY_PATH` | `/var/www/dgit` | Dossier du clone Git |

## 4. Déclencher un déploiement

- **Automatique** : chaque `git push` sur `main` lance les tests puis le déploiement.
- **Manuel** : onglet **Actions** → workflow **Deploy** → **Run workflow**.

## 5. Vérifier

- Actions → dernier run **Deploy** en vert.
- Sur le serveur : `cd /var/www/dgit && php artisan about`
- Site : `https://votre-domaine.com/fr`

## Dépannage

| Problème | Piste |
|----------|--------|
| `git: not found` | Installer `git` sur le serveur |
| `composer: not found` | Installer Composer globalement pour l’utilisateur `deploy` |
| `npm: not found` | Installer Node 20+ ou retirer le bloc npm du workflow si assets déjà buildés |
| Permission denied `storage` | `chown -R deploy:www-data storage bootstrap/cache` |
| 500 après deploy | `php artisan config:clear` puis revoir `.env` sur le serveur |

## Alternative sans Git sur le serveur

Si vous préférez **rsync** depuis GitHub (sans `git pull` sur le VPS), ouvrez une issue : on peut ajouter un second workflow `deploy-rsync.yml`.
