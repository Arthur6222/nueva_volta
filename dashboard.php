<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Volta - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #0a0a0a; color: #fff; min-height: 100vh; }
        .navbar { background: #111; border-bottom: 1px solid #222; padding: 16px 40px; display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon { font-size: 1.5rem; }
        .logo-text { font-size: 1.4rem; font-weight: 700; background: linear-gradient(135deg, #e2b96f, #f5d08a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-user { display: flex; align-items: center; gap: 16px; }
        .nav-user span { color: #ccc; font-size: 0.9rem; }
        .btn-logout { padding: 8px 20px; background: transparent; border: 1px solid #e2b96f; border-radius: 6px; color: #e2b96f; cursor: pointer; font-family: 'Poppins', sans-serif; font-size: 0.85rem; transition: all 0.3s; }
        .btn-logout:hover { background: #e2b96f; color: #000; }
        .main { padding: 60px 40px; max-width: 1200px; margin: 0 auto; }
        .welcome { margin-bottom: 40px; }
        .welcome h1 { font-size: 2rem; font-weight: 700; }
        .welcome h1 span { background: linear-gradient(135deg, #e2b96f, #f5d08a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .welcome p { color: #888; margin-top: 8px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: #111; border: 1px solid #222; border-radius: 12px; padding: 24px; }
        .stat-icon { font-size: 2rem; margin-bottom: 12px; }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #e2b96f; }
        .stat-label { color: #888; font-size: 0.85rem; margin-top: 4px; }
        .section-title { font-size: 1.3rem; font-weight: 600; margin-bottom: 20px; }
        .destinations-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .destination-card { background: #111; border: 1px solid #222; border-radius: 12px; overflow: hidden; cursor: pointer; transition: transform 0.3s, border-color 0.3s; }
        .destination-card:hover { transform: translateY(-4px); border-color: #e2b96f; }
        .dest-img { height: 160px; display: flex; align-items: center; justify-content: center; font-size: 4rem; }
        .dest-body { padding: 20px; }
        .dest-name { font-size: 1.1rem; font-weight: 600; margin-bottom: 4px; }
        .dest-country { color: #888; font-size: 0.85rem; margin-bottom: 12px; }
        .dest-price { font-size: 1.3rem; font-weight: 700; color: #e2b96f; }
        .dest-price span { font-size: 0.8rem; color: #888; font-weight: 400; }
        .btn-reserver { display: block; width: 100%; padding: 10px; background: linear-gradient(135deg, #e2b96f, #f5d08a); border: none; border-radius: 6px; color: #000; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; margin-top: 12px; transition: opacity 0.3s; }
        .btn-reserver:hover { opacity: 0.9; }
        #auth-check { display: none; }
        @media(max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .destinations-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div id="auth-check"></div>

<nav class="navbar">
    <a href="index.php" class="logo">
        <span class="logo-icon">✈</span>
        <span class="logo-text">Nueva Volta</span>
    </a>
    <div class="nav-user">
        <span id="user-email">Chargement...</span>
        <button class="btn-logout" onclick="logout()">Déconnexion</button>
    </div>
</nav>

<main class="main">
    <div class="welcome">
        <h1>Bonjour, <span id="user-name">Voyageur</span> 👋</h1>
        <p>Où voulez-vous aller aujourd'hui ?</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">🗺️</div>
            <div class="stat-value" id="nb-reservations">0</div>
            <div class="stat-label">Réservations</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✈️</div>
            <div class="stat-value">12</div>
            <div class="stat-label">Destinations disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-value">4.9</div>
            <div class="stat-label">Note moyenne</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎁</div>
            <div class="stat-value">3</div>
            <div class="stat-label">Offres spéciales</div>
        </div>
    </div>

    <h2 class="section-title">Destinations populaires</h2>
    <div class="destinations-grid">
        <div class="destination-card">
            <div class="dest-img" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">🗼</div>
            <div class="dest-body">
                <div class="dest-name">Paris</div>
                <div class="dest-country">🇫🇷 France</div>
                <div class="dest-price">299€ <span>/ personne</span></div>
                <button class="btn-reserver">Réserver</button>
            </div>
        </div>
        <div class="destination-card">
            <div class="dest-img" style="background: linear-gradient(135deg, #0f3460, #533483);">🏛️</div>
            <div class="dest-body">
                <div class="dest-name">Rome</div>
                <div class="dest-country">🇮🇹 Italie</div>
                <div class="dest-price">349€ <span>/ personne</span></div>
                <button class="btn-reserver">Réserver</button>
            </div>
        </div>
        <div class="destination-card">
            <div class="dest-img" style="background: linear-gradient(135deg, #16213e, #e2b96f33);">🏖️</div>
            <div class="dest-body">
                <div class="dest-name">Barcelone</div>
                <div class="dest-country">🇪🇸 Espagne</div>
                <div class="dest-price">279€ <span>/ personne</span></div>
                <button class="btn-reserver">Réserver</button>
            </div>
        </div>
    </div>
</main>

<script>
    const SUPABASE_URL = 'https://xxpgiwiosojzjwuszmnh.supabase.co';
    const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inh4cGdpd2lvc29qemp3dXN6bW5oIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzcxOTE0NTIsImV4cCI6MjA5Mjc2NzQ1Mn0.-xzXJhx_TuYSTMYurunFbGbl7AoV6bXeWRdcZB7DPW0';

    // Vérifier l'auth
    const token = localStorage.getItem('supabase_token');
    const user = JSON.parse(localStorage.getItem('supabase_user') || 'null');

    if(!token || !user) {
        window.location.href = 'connexion.php';
    } else {
        document.getElementById('user-email').textContent = user.email;

        // Charger le profil
        fetch(`${SUPABASE_URL}/rest/v1/profils?id=eq.${user.id}&select=*`, {
            headers: {
                'apikey': SUPABASE_KEY,
                'Authorization': `Bearer ${token}`
            }
        })
        .then(r => r.json())
        .then(data => {
            if(data && data[0]) {
                document.getElementById('user-name').textContent = data[0].prenom || data[0].nom || 'Voyageur';
            }
        })
        .catch(console.error);
    }

    function logout() {
        localStorage.removeItem('supabase_token');
        localStorage.removeItem('supabase_user');
        window.location.href = 'connexion.php';
    }
</script>

</body>
</html>
