# App de garde-robe

### 1. Authentification

- Inscription / connexion (email + mot de passe)
- Session pour maintenir la connexion
- Un utilisateur ne voit que sa propre garde-robe

### 2. Ajout d'un vêtement par photo

- Upload (fichier ou caméra sur mobile)
- Formulaire minimal à la prise de photo, complété ensuite par les étapes 3-4

**Détourage de l'image**

- Objectif : isoler le vêtement du fond pour un rendu propre dans la garde-robe
- A trouver : API externe gratuite si possible

**Remplissage des caractéristiques**

- `color`: Teinte du vêtement
- `season`: Saison de préférence
- `cut`: Large, slim, fit
- `material`: Laine, jeans, lin, synthétique
- `user_rate`: Appréciation du vêtement par l’utilisateur

### 5. Priorité d'accord (couleur / matière)

- Un réglage par génération qui pondère l'algorithme de génération d'outfit : privilégier l'harmonie de couleur ou l'harmonie de matière
- À implémenter comme un poids dans la fonction de score

### 6. Visualisation de la garde-robe avec filtres

- Grille d'images (vêtements détourés)
- Filtres par catégorie (haut/bas/chaussures/accessoire), et aussi par saison/couleur

### 7. Génération d'outfit

Composants d'un outfit : haut, bas, chaussures, accessoire.

Facteurs d'influence à pondérer dans l'algorithme :

- Type (contrainte de compatibilité, pas score)
- Couleur
- Saison
- Coupe
- Matériau
- Affection utilisateur
- Météo (⚠️ nécessite une API météo)
- Note (apprentissage à partir des retours sur les outfits précédents)
- Aléatoire (pour éviter la répétition)

---

## Pages

- Login / inscription
- Ajout d'un vêtement
- Modification d'un vêtement
- Visualisation de garde-robe (avec filtres)
- Création d'outfit (accueil)
- Page ou modal de feedback sur l'outfit généré

## Dépendances externes

- Détourage intelligent
- Météo de la semaine

## Si le temps le permet

- Classification automatique du type de vêtement via modèle entraîné
- Classification des vêtement (multi-catégories) -> avec Jev?
