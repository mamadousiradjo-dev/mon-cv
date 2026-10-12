window.cvApiBase = new URL(window.CV_API_URL).origin;
window.cvPhotoUrl = (path) => {
  if (/^uploads\/[a-f0-9]{32}\.(jpg|png|webp)$/.test(path)) return `${window.cvApiBase}/api/photos/${path.slice(8)}`;
  if (/^images\/[\w/ .-]+\.(jpe?g|png|webp)$/i.test(path) && !path.includes('..')) return `/${path}`;
  return null;
};
window.cvRequest = async (path, options = {}) => {
  const response = await fetch(`${window.cvApiBase}${path}`, { credentials: 'include', ...options });
  const data = await response.json();
  if (!response.ok) throw new Error(data.error || 'Une erreur est survenue.');
  return data;
};
window.cvSession = window.cvRequest('/api/session').then((data) => {
  const user = data.user;
  if (user) {
    document.getElementById('nav-register')?.classList.add('hidden');
    document.getElementById('nav-login')?.classList.add('hidden');
    const name = document.getElementById('nav-user');
    if (name) { name.textContent = user.nom; name.classList.remove('hidden'); }
    document.getElementById('nav-logout')?.classList.remove('hidden');
    if (user.role === 'admin') {
      document.getElementById('nav-users')?.classList.remove('hidden');
      document.getElementById('photo-form')?.classList.remove('hidden');
    }
  }
  return data;
});
document.getElementById('nav-logout')?.addEventListener('click', async () => {
  try {
    const session = await window.cvSession;
    await window.cvRequest('/api/logout', { method: 'POST', headers: { 'X-CSRF-Token': session.csrf } });
    window.location.href = '/';
  } catch (error) { window.alert(error.message); }
});
