# API ClearBackdrop & Documentation du workflow

Voir [cleardrop.com](https://clearbackdrop.com/api) pour la documentation.

---

## 1. Le flux en 4 étapes

1. **Sélection & compression client ([`addItem.js`](public/js/addItem.js)) :**  
   L'image est redimensionnée sur un Canvas (max 1200px, JPEG) pour rester sous la limite de 2 Mo de PHP, puis envoyée en tâche de fond au proxy.

2. **Détourage serveur ([`removeBackground.php`](public/api/removeBackground.php)) :**  
   Le proxy transmet l'image à ClearBackdrop API avec le token `BG_REMOVER_API`. Le PNG détouré est sauvegardé dans `app/public/img/tmp/tmp_<id>.png` et son chemin est renvoyé au navigateur.

3. **Soumission ([`addItem.php`](public/addItem.php)) :**  
   Le formulaire valide les champs ([`databaseSecurity.php`](src/databaseSecurity.php)) et insère la ligne en base ([`insert()`](src/repositories/ItemRepository.php)) pour générer l'identifiant `$itemId`.

4. **Déplacement final ([`moveToActualImgPath()`](src/repositories/ItemRepository.php)) :**  
   Le PNG détouré (ou l'image brute si l'API a échoué) est déplacé vers `app/public/img/uploads/user_<id>/item_<itemId>.png` et la DB est mise à jour. Le fichier temporaire est ensuite supprimé.

---

## 2. Spécification de l'endpoint proxy

- **URL :** `POST /app/public/api/removeBackground.php`
- **Requête :** `multipart/form-data` avec le champ `photo`
- **Réponses JSON :**
  - `200 OK` : `{"tmpFile": "img/tmp/tmp_xyz.png"}`
  - `400 Bad Request` : fichier manquant ou erreur d'upload
  - `502 Bad Gateway` : service ClearBackdrop injoignable ou clé invalide

---

## 3. Stockage

- **Temporaire :** `app/public/img/tmp/`
- **Définitif :** `app/public/img/uploads/user_<id>/item_<itemId>.png`
- **En base :** chemin relatif stocké dans la colonne `items.img_url` (ex: `img/uploads/user_1/item_42.png`)

---

## 4. Configuration

- Clé secrète `BG_REMOVER_API` dans `.env`
- Transmise au conteneur Apache via `env_file: - .env` dans [`compose.yaml`](compose.yaml#L12-L13)
