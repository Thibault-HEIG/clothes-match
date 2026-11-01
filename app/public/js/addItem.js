/**
 * addItem.js — Handles eager background removal on file selection.
 *
 * When the user selects a photo:
 * 1. Shows an instant local preview.
 * 2. Calls removeBackground.php to strip the background.
 * 3. On success, displays the transparent PNG and stores its temporary path
 *    in a hidden field for form submission.
 * 4. On failure, notifies the user and falls back to uploading the raw photo.
 */

const photoInput   = document.getElementById('photo');
const previewImg   = document.getElementById('photo-preview');
const photoStatus  = document.getElementById('photo-status');
const tmpFileInput = document.getElementById('tmp_file');
const submitBtn    = document.querySelector('[type="submit"]');

photoInput.addEventListener('change', async () => {
    let file = photoInput.files[0];
    if (!file) return;

    setStatus('loading', 'Suppression du fond en cours…');
    submitBtn.disabled = true;

    try {
        file = await resizeImage(file);
        const dt = new DataTransfer();
        dt.items.add(file);
        photoInput.files = dt.files;

        // Immediate local preview for responsive UX
        previewImg.src    = URL.createObjectURL(file);
        previewImg.hidden = false;

        const formData = new FormData();
        formData.append('photo', file);

        const response = await fetch("api/removeBackground.php", {
					method: "POST",
					body: formData,
				});

        const data = await response.json();

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Erreur lors du traitement de l’image.');
        }

        // Show transparent PNG and set path for form submission
        previewImg.src      = data.tmpFile;
        tmpFileInput.value  = data.tmpFile;
        photoInput.required = false;
        setStatus('done', 'Fond supprimé ✓');

    } catch (err) {
        console.error('Erreur traitement photo:', err);
        setStatus('error', `Échec : ${err.message}`);
        // Fallback: clear temp path so form submits the raw file
        tmpFileInput.value  = '';
        photoInput.required = true;
    } finally {
        submitBtn.disabled = false;
    }
});

/**
 * Downscales an image to fit max dimensions and compresses to JPEG.
 */
async function resizeImage(file, max = 1200) {
    const bmp = await createImageBitmap(file);
    const scale = Math.min(1, max / Math.max(bmp.width, bmp.height));
    if (scale === 1 && file.size <= 2 * 1024 * 1024) return file;

    const canvas = document.createElement('canvas');
    canvas.width = Math.round(bmp.width * scale);
    canvas.height = Math.round(bmp.height * scale);
    canvas.getContext('2d').drawImage(bmp, 0, 0, canvas.width, canvas.height);
    bmp.close();

    const blob = await new Promise(r => canvas.toBlob(r, 'image/jpeg', 0.85));
    return new File([blob], file.name.replace(/\.[^.]+$/, '') + '.jpg', { type: 'image/jpeg' });
}

/**
 * Updates the status message below the file input.
 * @param {'idle'|'loading'|'done'|'error'} state
 * @param {string} message
 */
function setStatus(state, message) {
    photoStatus.textContent   = message;
    photoStatus.dataset.state = state;
}

