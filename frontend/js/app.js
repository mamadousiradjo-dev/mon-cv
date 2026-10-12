// Le frontend affiche son contenu statique si l'API n'est pas disponible.
(async () => {
  try {
    const response = await fetch(window.CV_API_URL);
    if (!response.ok) return;
    const cv = await response.json();

    const setText = (id, value) => {
      if (typeof value === 'string') {
        document.getElementById(id).textContent = value;
      }
    };

    if (typeof cv.photo === 'string' && /^images\/[\w/ .-]+\.(jpe?g|png|webp)$/i.test(cv.photo) && !cv.photo.includes('..')) {
      document.getElementById('profile-img').src = cv.photo;
    }

    if (cv.formation) {
      setText('formation-diplome', cv.formation.diplome);
      if (typeof cv.formation.etablissement === 'string' && typeof cv.formation.annee === 'string') {
        setText('formation-detail', `${cv.formation.etablissement} • ${cv.formation.annee}`);
      }
    }

    if (cv.experience) {
      setText('experience-titre', cv.experience.titre);
      setText('experience-entreprise', cv.experience.entreprise);
      setText('experience-periode', cv.experience.periode);
      setText('experience-description', cv.experience.description);
    }
  } catch {
    // Le CV statique reste lisible même si l'API ou MySQL est arrêté.
  }
})();
