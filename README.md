# UTECH — Système de Gestion des Commandes IT

Application web développée dans le cadre du **Projet de Fin d'Études (PFE)** pour la gestion des services informatiques : commandes, factures, tickets de support et produits IT.

---

## 🛠️ Stack Technique

- **Framework** : Laravel 10.5.1
- **Langage** : PHP 8.2.12
- **Base de données** : MySQL (via Eloquent ORM)
- **Frontend** : Blade Templates + CSS personnalisé
- **Authentification** : Double garde Laravel (Admin / Utilisateur)

---

## ⚙️ Installation & Lancement

```bash
# 1. Cloner le projet
git clone <repo-url>
cd "pfe 2"

# 2. Installer les dépendances
composer install

# 3. Copier le fichier d'environnement
cp .env.example .env

# 4. Générer la clé d'application
php artisan key:generate

# 5. Configurer la base de données dans .env
DB_DATABASE=utech
DB_USERNAME=root
DB_PASSWORD=

# 6. Exécuter les migrations
php artisan migrate

# 7. (Optionnel) Remplir la base avec des données de test
php artisan db:seed

# 8. Lancer le serveur
php artisan serve
