# API ClearBackdrop & Documentation du workflow

Voir [ClearDropAPI.md](file:///Users/thibaultmoret/Desktop/2-HEIG-VD/ProgServer/clothes-match/app/public/api/ClearDropAPI.md) pour le détail complet du flux.

- **Endpoint :** `POST /app/public/api/removeBackground.php`
- **Payload :** `multipart/form-data` (`photo`)
- **Sortie :** JSON `{"tmpFile": "img/tmp/tmp_xyz.png"}`
- **Stockage temporaire :** `app/public/img/tmp/`
- **Stockage final :** `app/public/img/uploads/user_<id>/item_<id>.<ext>`
