# 🏥 E-Pharma – Online Medicine Sales Platform with AI Chatbot

E-Pharma est une application e-Business complète permettant la vente en ligne de médicaments avec gestion intelligente des stocks, un tableau de bord administrateur, et un chatbot basé sur IA pour l’assistance en temps réel des clients.

---

## 🚀 Fonctionnalités principales

### 🎯 **Côté Client (Front Office)**
- Consultation du **catalogue de produits** (médicaments).
- Recherche et filtrage des produits.
- Ajout de produits au **panier**.
- Gestion du panier (modification, suppression).
- Vérification des stocks en temps réel.
- Assistance instantanée via **chatbot AI**.
- Téléchargement et impression de la facture.

### 🛠️ **Côté Administrateur (Back Office)**
- Tableau de bord avec indicateurs clés.
- **Gestion des produits** :
  - Ajout, modification, suppression.
  - Contrôle des stocks.
  - Gestion des dates d’expiration.
  - Notification des médicaments en rupture.
- **Gestion des ventes** :
  - Visualisation des ventes journalières/mensuelles.
  - Filtre avancé pour les rapports.
  - Génération de rapports.
- **Gestion des commandes** :
  - Suivi en temps réel.
  - Mise à jour des statuts.
- Impression et téléchargement des factures.
- Sauvegarde de la base de données.

---

## 📦 Technologies utilisées

### **Frontend**
- HTML5 / CSS3 / Bootstrap
- JavaScript
- AJAX / Fetch API

### **Backend**
- PHP (Procedural or Laravel → specify if needed)
- API interne pour communication réactive
- MySQL / MariaDB

### **Outils et Librairies**
- Chatbot IA (API intégrée)
- DataTables
- Chart.js pour les statistiques
- Git / GitHub

---

## 🗂️ Structure du projet

/e-pharma
│── /admin → tableau de bord, gestion produits/ventes
│── /client → pages client, panier, catalogue
│── /api → API backend (produits, commandes, chatbot)
│── /assets → CSS, JS, images
│── /database → scripts SQL, backups
│── index.php → page d’accueil client
│── README.md → documentation


---

## 🛢️ Base de données

Tables principales :

- **stock** (id, name, category, price, stock, expiration_date)
- **sales** (id, product_id, qty, total_amount, date)
- **orders** (id, customer_id, status, created_at)
- **users** (id, username, password, role)
- **backup_logs**

---

## 🤖 Chatbot IA

Le chatbot intégré permet :

- Assistance sur les produits.
- Conseils d'utilisation (génériques et non médicaux).
- Recherche rapide d’un médicament.
- Navigation guidée dans la plateforme.

⚠️ **Note** : Le chatbot ne remplace pas un médecin.  
Il fournit uniquement une assistance technique et générale.

---

## 🏗️ Installation

### 1. Cloner le projet
```bash
git clone https://github.com/muhemedi-placide/PlacidePharamacie_avec_ChatBot_integre.git
2. Configurer la base de données

Importer le fichier database/epharma.sql

Configurer le fichier config.php :

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'tourname';

3. Démarrer le serveur

Laragon / XAMPP / WAMP :

http://localhost/placidepharmancie
