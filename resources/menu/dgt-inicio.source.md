# Menu d’accueil (référence DGT)

Ce fichier décrit la **même arborescence** que la page officielle [dgt.es/inicio](https://www.dgt.es/inicio/) et le découpage `inicio-0.md`.

## Fichier à modifier dans le projet

- **Données exploitées par Laravel :** `resources/data/dgt-inicio-menu.php`  
  Chaque entrée peut avoir :
  - `label` : libellé espagnol (référence DGT)
  - `label_fr` : libellé français affiché sur le site (voir méga-menu)
  - `url` : chemin **sans domaine** — `nuestros-servicios/…` → lien externe www.dgt.es ; `es/…` → Sede locale (`/sede/es/…`)
  - `children` : sous-menu (jusqu’à 3 niveaux pour le méga-menu)

Après modification, videz le cache de config si besoin : `php artisan config:clear`.

## Structure (aperçu)

1. **Nos services** — trámites, multas, permisos, vehículos…
2. **Déplacez-vous avec confiance**
3. **Conditions de circulation**
4. **Découvrez la DGT**
5. **Communication**

Les textes détaillés des sous-pages peuvent être alignés sur le document `inicio-0.md` fourni.
