**What the flow does:**
1. When the user picks a photo, `addItem.js` sends it to a PHP proxy, which calls ClearBackdrop and saves a transparent PNG in `img/tmp/`.
2. At submit, `saveItemImage()` renames that PNG to `img/uploads/user_<id>/item_<uniqid>.png` and stores the relative path in `clothes.img_url`.
3. If the API step failed, the raw photo posted with the form is moved there instead.

**Other important issues:**
- Phone photos exceed PHP's 2 MB default and are rejected both at the proxy and at submit, and nothing resizes them.
- The photo is uploaded twice.
- `img/tmp/` is never cleaned, and each orphaned file cost an API credit.
- After a validation error the user must reselect the photo and pay for another API call.
- The proxy has no auth, MIME or size check.
- `compose.yaml` doesn't pass `BG_REMOVER_API` to the container.
