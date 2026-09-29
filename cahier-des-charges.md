# App de garde-robe

Une garde-robe numérique qui regroupe tous vos vêtements en photo et vous suggère des tenues harmonieuses au quotidien.

# Membres de l'équipe

- Thibault Moret
- Loana Babey

**Ordre de priorités :**

| Version | Priorité |
|-----------|-----------|
| MVP1️⃣     | Nécéssaire |
| MVP2️⃣     | Si possible |
| MVP3️⃣     | Si on a le temps |

### 1. Authentification

- 1️⃣ Inscription / connexion (email + mot de passe)
- 2️⃣ Session pour maintenir la connexion
- 1️⃣ Un utilisateur ne voit que sa propre garde-robe

### 2. Ajout d'un vêtement par photo

- 1️⃣ Upload (fichier ou caméra sur mobile)
- 1️⃣ Formulaire minimal à la prise de photo

**Détourage de l'image**

- 2️⃣ Objectif : isoler le vêtement du fond pour un rendu propre dans la garde-robe
- 2️⃣ A trouver : API externe gratuite si possible

**Remplissage des caractéristiques**

- 1️⃣ `color`: Teinte du vêtement
- 1️⃣ `season`: Saison de préférence
- 1️⃣ `cut`: Large, slim, fit
- 1️⃣ `material`: Laine, jeans, lin, synthétique
- 2️⃣ `user_rate`: Appréciation du vêtement par l’utilisateur
- 1️⃣ `category`: T-shirt, pantalon, accessoir, chaussures

### 3. Priorité d'accord (couleur, matière, saison)

- 2️⃣ Un réglage par génération qui pondère l'algorithme de génération d'outfit : privilégier l'harmonie de couleur, l'harmonie de matière, ou l'harmonie de saison
- 2️⃣ À implémenter comme un poids dans la fonction de score

### 4. Visualisation de la garde-robe avec filtres

- 1️⃣ Grille d'images (vêtements détourés)
- 2️⃣ Filtres par catégorie (haut/bas/chaussures/accessoire), et aussi par saison/couleur

### 5. Génération d'outfit

Composants d'un outfit : haut, bas, chaussures, accessoire.

Facteurs d'influence à pondérer dans l'algorithme :

- 1️⃣ Type (contrainte de compatibilité, pas score)
- 2️⃣ Couleur (analyse hexadécimale)
- 1️⃣ Saison
- 1️⃣ Coupe
- 1️⃣ Matériau
- 1️⃣ Affection utilisateur
- 2️⃣ Météo
- 3️⃣ Note (apprentissage à partir des retours sur les outfits précédents)
- 1️⃣ Aléatoire (pour éviter la répétition)

> Fonctionne comme un LLM. Prend un vêtement, puis tire le 2ème parmi les plus accordés avec des pondérations.
---

## Pages

- Login / inscription
- Ajout d'un vêtement
- Modification d'un vêtement
- Visualisation de garde-robe (avec filtres)
- Création d'outfit (accueil)
- Page ou modal de feedback sur l'outfit généré

## Dépendances externes

- Détourage intelligent (⚠️ Difficile à trouver)
- Météo de la semaine
