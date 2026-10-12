const status = document.getElementById('account-message');
const form = document.getElementById('account-form');
if (form) form.addEventListener('submit', async (event) => {
  event.preventDefault();
  status.textContent = 'Veuillez patienter…';
  const fields = new FormData(form);
  const mode = form.dataset.mode;
  const password = String(fields.get('password') || '');
  if (mode === 'register' && password !== String(fields.get('confirmation') || '')) { status.textContent = 'Les mots de passe ne correspondent pas.'; return; }
  try {
    const session = await window.cvSession;
    const payload = { email: fields.get('email'), password };
    if (mode === 'register') payload.name = fields.get('name');
    await window.cvRequest(mode === 'register' ? '/api/register' : '/api/login', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': session.csrf }, body: JSON.stringify(payload) });
    window.location.href = '/';
  } catch (error) { status.textContent = error.message; }
});
const list = document.getElementById('users-list');
if (list) (async () => {
  try {
    const session = await window.cvSession;
    if (session.user?.role !== 'admin') throw new Error('Accès réservé au propriétaire.');
    const data = await window.cvRequest('/api/users');
    status.textContent = `${data.users.length} compte(s) inscrit(s).`;
    for (const user of data.users) {
      const item = document.createElement('li');
      item.className = 'rounded-lg border border-slate-200 p-3';
      item.textContent = `${user.nom} — ${user.email} (${user.role === 'admin' ? 'propriétaire' : 'utilisateur'})`;
      list.appendChild(item);
    }
  } catch (error) { status.textContent = error.message; }
})();
