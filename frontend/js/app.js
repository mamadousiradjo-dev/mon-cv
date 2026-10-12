(async () => {
  try {
    const response = await fetch(window.CV_API_URL);
    if (!response.ok) return;
    const cv = await response.json();
    const setText = (id, value) => {
      const element = document.getElementById(id);
      if (element && typeof value === 'string') element.textContent = value;
    };
    const photo = window.cvPhotoUrl(cv.photo);
    if (photo) document.getElementById('profile-img').src = photo;
    if (cv.formation) {
      setText('formation-diplome', cv.formation.diplome);
      if (typeof cv.formation.etablissement === 'string' && typeof cv.formation.annee === 'string') setText('formation-detail', `${cv.formation.etablissement} • ${cv.formation.annee}`);
    }
    if (cv.experience) {
      setText('experience-titre', cv.experience.titre);
      setText('experience-entreprise', cv.experience.entreprise);
      setText('experience-periode', cv.experience.periode);
      setText('experience-description', cv.experience.description);
    }
  } catch { /* La version statique reste disponible. */ }
})();
document.getElementById('photo-form')?.addEventListener('submit', async (event) => {
  event.preventDefault();
  const form = event.currentTarget;
  const message = document.getElementById('photo-message');
  message.textContent = 'Envoi en cours…';
  try {
    const session = await window.cvSession;
    const data = await window.cvRequest('/api/photo', { method: 'POST', headers: { 'X-CSRF-Token': session.csrf }, body: new FormData(form) });
    document.getElementById('profile-img').src = window.cvPhotoUrl(data.photo);
    message.textContent = 'Photo enregistrée.';
    form.reset();
  } catch (error) { message.textContent = error.message; }
});
