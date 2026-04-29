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
    <title>Nueva Volta - Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #0a0a0a; color: #fff; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-container { display: flex; width: 100%; max-width: 900px; min-height: 600px; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.5); }
        .auth-left { width: 45%; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 60px; display: flex; flex-direction: column; justify-content: center; }
        .auth-brand a { display: flex; align-items: center; gap: 12px; text-decoration: none; margin-bottom: 40px; }
        .logo-icon { font-size: 2rem; }
        .logo-text { font-size: 1.8rem; font-weight: 700; background: linear-gradient(135deg, #e2b96f, #f5d08a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .auth-left h2 { font-size: 1.8rem; font-weight: 700; margin-bottom: 16px; }
        .auth-left p { color: #aaa; line-height: 1.7; }
        .auth-right { width: 55%; background: #111; padding: 60px; display: flex; align-items: center; justify-content: center; }
        .auth-card { width: 100%; }
        .auth-card h1 { font-size: 2rem; font-weight: 700; margin-bottom: 8px; }
        .auth-subtitle { color: #888; margin-bottom: 30px; }
        .message { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .message.success { background: rgba(34,197,94,0.1); border: 1px solid #22c55e; color: #22c55e; }
        .message.error { background: rgba(239,68,68,0.1); border: 1px solid #ef4444; color: #ef4444; }
        .hidden { display: none; }
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
        @media(max-width: 768px) { .auth-left { display: none; } .auth-right { width: 100%; } }
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
        <h2>Bon retour parmi nous !</h2>
        <p>Connectez-vous pour accéder à vos réservations et découvrir nos nouvelles destinations.</p>
    </div>

    <div class="auth-right">
        <div class="auth-card">
            <h1>Se connecter</h1>
            <p class="auth-subtitle">Accédez à votre espace voyageur</p>

            <div id="message" class="message hidden"></div>

            <form id="connexion-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="votre@email.com" required>
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" placeholder="Votre mot de passe" required>
                </div>

                <button type="submit" class="submit-btn" id="submit-btn">
                    <span id="btn-loader" class="loader hidden"></span>
                    <span id="btn-text">Se connecter</span>
                </button>
            </form>

            <div class="auth-link">
                Pas encore de compte ? <a href="inscription.php">S'inscrire</a>
            </div>
        </div>
    </div>
