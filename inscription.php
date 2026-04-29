<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Volta - Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #0a0a0a; color: #fff; min-height: 100vh; display: flex; }
        .auth-container { display: flex; width: 100%; min-height: 100vh; }
        .auth-left { width: 45%; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 60px; display: flex; flex-direction: column; justify-content: space-between; }
        .auth-brand a { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-icon { font-size: 2rem; }
        .logo-text { font-size: 1.8rem; font-weight: 700; background: linear-gradient(135deg, #e2b96f, #f5d08a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .auth-illustration h2 { font-size: 2rem; font-weight: 700; margin-bottom: 20px; line-height: 1.3; }
        .auth-illustration p { color: #aaa; margin-bottom: 30px; }
        .benefits { list-style: none; }
        .benefits li { padding: 8px 0; color: #e2b96f; font-size: 0.95rem; }
        .auth-right { width: 55%; background: #111; display: flex; align-items: center; justify-content: center; padding: 60px; }
        .auth-card { width: 100%; max-width: 500px; }
        .auth-card h1 { font-size: 2rem; font-weight: 700; margin-bottom: 8px; }
        .auth-subtitle { color: #888; margin-bottom: 30px; }
        .message { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .message.success { background: rgba(34,197,94,0.1); border: 1px solid #22c55e; color: #22c55e; }
        .message.error { background: rgba(239,68,68,0.1); border: 1px solid #ef4444; color: #ef4444; }
        .hidden { display: none; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 0.9rem; color: #ccc; }
        .form-group input { width: 100%; padding: 12px 16px; background: #1a1a1a; border: 1px solid #333; border-radius: 8px; color: #fff; font-family: 'Poppins', sans-serif; font-size: 0.95rem; transition: border-color 0.3s; }
        .form-group input:focus { outline: none; border-color: #e2b96f; }
        .submit-btn { width: 100%; padding: 14px; background: linear-gradient(135deg, #e2b96f, #f5d08a); border: none; border-radius: 8px; color: #0a0a0a; font-family: 'Poppins', sans-serif; font-size: 1rem; font-weight: 600; cursor: pointer; transition: opacity 0.3s; }
        .submit-btn:hover { opacity: 0.9; }
        .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .auth-link { text-align: center; margin-top: 20px; color: #888; font-size: 0.9rem; }
        .auth-link a { color: #e2b96f; text-decoration: none; font-weight: 600; }
        .loader { display: inline-block; width: 16px; height: 16px; border: 2px solid rgba(0,0,0,0.3); border-top-color: #000; border-radius: 50%; animation: spin 0.8s linear infinite; margin-right: 8px; vertical-align: middle; }
        @keyframes spin { to { transform: rotate(360deg); } }
        @media(max-width: 768px) { .auth-left { display: none; } .auth-right { width: 100%; padding: 30px; } .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-left">
        <div class="auth-brand">
            <a href="index.php">
                <span class="logo-icon">✈</span>
                <span class="logo-text">Nueva Volta</span>
            </a>
        </div>
        <div class="auth-illustration">
            <h2>Rejoignez des milliers de voyageurs</h2>
            <p>Créez votre compte et commencez à explorer le monde avec Nueva Volta.</p>
            <ul class="benefits">
                <li>✓ Accès à toutes les destinations</li>
                <li>✓ Gestion de vos réservations</li>
                <li>✓ Prix exclusifs membres</li>
                <li>✓ Support 24/7</li>
            </ul>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-card">
            <h1>Créer un compte</h1>
            <p class="auth-subtitle">Rejoignez Nueva Volta gratuitement</p>

            <div id="message" class="message hidden"></div>

            <form id="inscription-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" placeholder="Votre prénom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="votre@email.com" required>
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" placeholder="Minimum 6 caractères" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_naissance">Date de naissance</label>
                        <input type="date" id="date_naissance">
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" id="telephone" placeholder="+33 6 00 00 00 00">
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="submit-btn">
                    <span id="btn-loader" class="loader hidden"></span>
                    <span id="btn-text">Créer mon compte</span>
                </button>
            </form>

            <div class="auth-link">
                Déjà un compte ? <a href="connexion.php">Se connecter</a>
            </div>
        </div>
    </div>
</div>

<script>
    const SUPABASE_URL = 'https://xxpgiwiosojzjwuszmnh.supabase.co';
    const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inh4cGdpd2lvc29qemp3dXN6bW5oIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzcxOTE0NTIsImV4cCI6MjA5Mjc2NzQ1Mn0.-xzXJhx_TuYSTMYurunFbGbl7AoV6bXeWRdcZB7DPW0';

    function showMessage(msg, type) {
        const el = document.getElementById('message');
        el.textContent = msg;
        el.className = `message ${type}`;
    }

    document.getElementById('inscription-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const nom = document.getElementById('nom').value.trim();
        const prenom = document.getElementById('prenom').value.trim();
        const email = document.getElementById('email').value.trim();
        const mdp = document.getElementById('mdp').value;
        const date_naissance = document.getElementById('date_naissance').value;
        const telephone = document.getElementById('telephone').value.trim();

        document.getElementById('btn-text').classList.add('hidden');
        document.getElementById('btn-loader').classList.remove('hidden');
        document.getElementById('submit-btn').disabled = true;

        try {
            // 1. Créer le compte auth
            const authResponse = await fetch(`${SUPABASE_URL}/auth/v1/signup`, {
                method: 'POST',
                headers: {
                    'apikey': SUPABASE_KEY,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password: mdp })
            });

            const authData = await authResponse.json();
            console.log('Auth response:', authData);

            if(authData.error) {
                throw new Error(authData.error.message || authData.msg || 'Erreur création compte');
            }

            const userId = authData.user?.id;

            if(userId) {
                // 2. Créer le profil
                const profilResponse = await fetch(`${SUPABASE_URL}/rest/v1/profils`, {
                    method: 'POST',
                    headers: {
                        'apikey': SUPABASE_KEY,
                        'Authorization': `Bearer ${SUPABASE_KEY}`,
                        'Content-Type': 'application/json',
                        'Prefer': 'return=representation'
                    },
                    body: JSON.stringify({
                        id: userId,
                        nom,
                        prenom,
                        date_naissance: date_naissance || null,
                        telephone: telephone || null
                    })
                });

                const profilData = await profilResponse.json();
                console.log('Profil response:', profilData);
            }

            showMessage('✓ Compte créé avec succès ! Redirection...', 'success');
            setTimeout(() => window.location.href = 'connexion.php', 2000);

        } catch(error) {
            console.error(error);
            showMessage(error.message || 'Une erreur est survenue.', 'error');
            document.getElementById('btn-text').classList.remove('hidden');
            document.getElementById('btn-loader').classList.add('hidden');
            document.getElementById('submit-btn').disabled = false;
        }
    });
</script>

</body>
</html>
