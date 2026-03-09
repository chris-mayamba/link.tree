# 🔗 link.tree 🌳

Bienvenue sur le dépôt de **link.tree** ! 🎉 Le parfait endroit pour vos liens, créé avec passion.

Ce projet vise à fournir une solution simple et élégante pour centraliser tous vos liens importants en un seul endroit. Que vous soyez un créateur de contenu, un professionnel ou simplement quelqu'un qui souhaite partager ses plateformes favorites, link.tree est là pour vous.

---

## 🚀 Démarrage Rapide

Découvrez notre site déjà en ligne : [https://linktree.x10.mx/](https://linktree.x10.mx/)

---

## ✨ Fonctionnalités

*   **Gestion Simplifiée des Liens :** Ajoutez, modifiez et organisez facilement tous vos liens.
*   **Personnalisation :** Adaptez l'apparence pour qu'elle corresponde à votre style.
*   **Responsive Design :** Une expérience utilisateur fluide sur tous les appareils.
*   **Authentification Utilisateur :** Créez un compte pour gérer vos liens privés.
*   **Thèmes Clair et Sombre :** Profitez d'une interface agréable, de jour comme de nuit.

---

## 🛠️ Installation

Ce projet est développé en PHP et utilise Tailwind CSS pour le style.

### Prérequis

*   PHP installé sur votre système.
*   Node.js et npm (ou pnpm) pour la gestion des dépendances et du CSS.

### Étapes d'installation

1.  **Cloner le dépôt :**
    ```bash
    git clone https://github.com/chris-mayamba/link.tree.git
    cd link.tree
    ```

2.  **Installer les dépendances Node.js :**
    Si vous utilisez npm :
    ```bash
    npm install
    ```
    Si vous utilisez pnpm :
    ```bash
    pnpm install
    ```

3.  **Compiler le CSS avec Tailwind CSS :**
    Lancez la commande suivante pour compiler `input.css` en `style.css` et surveiller les changements :
    ```bash
    npx @tailwindcss/cli -i ./src/public/input.css -o ./src/public/style.css --watch
    ```

4.  **Configuration du serveur web :**
    Pour exécuter l'application PHP, vous aurez besoin d'un serveur web (comme Apache ou Nginx) configuré pour pointer vers le répertoire racine du projet. Vous pouvez également utiliser le serveur web intégré de PHP pour un développement rapide :
    ```bash
    php -S localhost:8000 -t src/
    ```
    Accédez ensuite à `http://localhost:8000` dans votre navigateur.

---

## 💡 Utilisation

Une fois le serveur lancé et le CSS compilé, vous pouvez :

1.  **Visiter la page d'accueil :** `http://localhost:8000/` (ou l'URL de votre serveur) pour voir le rendu.
2.  **S'inscrire ou se connecter :** Utilisez les formulaires de création de compte et de connexion pour gérer vos liens.
3.  **Ajouter et gérer vos liens :** Une fois connecté, vous aurez accès à votre tableau de bord pour personnaliser votre page.

---

## 🤝 Contribution

Nous serions ravis de vous avoir parmi nous ! Si vous souhaitez contribuer à **link.tree**, n'hésitez pas à :

*   **Signaler des bugs :** Ouvrez une "Issue" sur GitHub pour nous faire part de tout problème rencontré.
*   **Proposer des améliorations :** Soumettez une "Pull Request" avec vos nouvelles fonctionnalités ou améliorations.
*   **Améliorer la documentation :** Toute aide pour rendre ce projet plus accessible est la bienvenue.

---

## ⚖️ Licence

Ce projet est sous licence [GPL-3.0](LICENSE). Vous êtes libre de l'utiliser, de le modifier et de le distribuer selon les termes de cette licence.

---

Merci de votre intérêt pour **link.tree** ! Nous espérons que vous apprécierez ce projet autant que nous avons aimé le construire. 😊

---

<p align="center">
  <a href="https://readmeforge.app?utm_source=badge">
    <img src="https://readmeforge.app/badge.svg" alt="Made with ReadmeForge" height="20">
  </a>
</p>
