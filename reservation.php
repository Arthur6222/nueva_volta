<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit;
}
$user = $_SESSION['user'];
$dest_id = isset($_GET['destination']) ? intval($_GET['destination']) : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Volta - Réservation</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/reservation.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <a href="index.php">
                <span class="logo-icon">✈</span>
                <span class="logo-text">Nueva Volta</span>
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="dashboard.php">Mon compte</a></li>
            <li><a href="deconnexion.php" class="btn-nav">Déconnexion</a></li>
        </ul>
    </div>
</nav>

<div class="reservation-container">
    <div class="reservation-grid">
        <div class="destination-preview" id="dest-preview">
            <div class="loading">Chargement...</div>
        </div>
        
        <div class="reservation-form-card">
            <h2>Finaliser votre réservation</h2>
            <div id="message" class="message hidden"></div>
            
            <form id="reservation-form">
                <div class="form-group">
                    <label>Date de départ</label>
                    <input type="date" id="date_depart" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                </div>
                
                <div class="form-group">
                    <label>Date de retour</label>
                    <input type="date" id="date_retour" required>
                </div>
                
                <div class="form-group">
                    <label>Nombre de personnes</label>
                    <select id="nb_personnes">
                        <?php for($i=1; $i<=10; $i++): ?>
                            <option value="<?=$i?>"><?=$i?> personne<?=$i>1?'s':''?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="price-summary">
                    <div class="price-row">
                        <span>Prix par personne :</span>
                        <span id="prix-unitaire">-</span>
                    </div>
                    <div class="price-row">
                        <span>Nombre de nuits :</span>
                        <span id="nb-nuits">-</span>
                    </div>
                    <div class="price-row total">
                        <span>Total :</span>
                        <span id="prix-total">-</span>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit" id="submit-btn">
                    <span id="btn-text">Confirmer la réservation</span>
                    <span id="btn-loader" class="hidden">⏳ Réservation...</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const SUPABASE_URL = 'https://xxpgiwiosojzjwuszmnh.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inh4cGdpd2lvc29qemp3dXN6bW5oIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzcxOTE0NTIsImV4cCI6MjA5Mjc2NzQ1Mn0.-xzXJhx_TuYSTMYurunFbGbl7AoV6bXeWRdcZB7DPW0';
const TOKEN = '<?= $user['token'] ?>';
const USER_ID = '<?= $user['id'] ?>';
const DEST_ID = <?= $dest_id ?>;
let destination = null;

async function loadDestination() {
    const response = await fetch(`${SUPABASE_URL}/rest/v1/destinations?id=eq.${DEST_ID}&select=*`, {
        headers: { 'apikey': SUPABASE_KEY, 'Authorization': `Bearer ${TOKEN}` }
    });
    
    const data = await response.json();
    if(!data || data.length === 0) {
        document.getElementById('dest-preview').innerHTML = '<p class="error">Destination introuvable.</p>';
        return;
    }
    
    destination = data[0];
    document.getElementById('dest-preview').innerHTML = `
        <div class="dest-image-container">
            <img src="${destination.image_url}" alt="${destination.nom}">
        </div>
        <div class="dest-details">
            <h2>${destination.nom}</h2>
            <p class="dest-country">📍 ${destination.pays}</p>
            <p class="dest-desc">${destination.description}</p>
            <p class="dest-price">À partir de <strong>${parseFloat(destination.prix_base).toFixed(2)}€</strong> / personne</p>
        </div>
    `;
    
    document.getElementById('prix-unitaire').textContent = `${parseFloat(destination.prix_base).toFixed(2)}€`;
    updatePrice();
}

function updatePrice() {
    if(!destination) return;
    
    const depart = document.getElementById('date_depart').value;
    const retour = document.getElementById('date_retour').value;
    const nb = parseInt(document.getElementById('nb_personnes').value);
    
    if(depart && retour) {
        const diff = (new Date(retour) - new Date(depart)) / (1000 * 60 * 60 * 24);
        if(diff > 0) {
            const total = destination.prix_base * nb * diff;
            document.getElementById('nb-nuits').textContent = diff + ' nuit(s)';
            document.getElementById('prix-total').textContent = total.toFixed(2) + '€';
            return;
        }
    }
    
    document.getElementById('nb-nuits').textContent = '-';
    document.getElementById('prix-total').textContent = '-';
}

document.getElementById('date_depart').addEventListener('change', updatePrice);
document.getElementById('date_retour').addEventListener('change', updatePrice);
document.getElementById('nb_personnes').addEventListener('change', updatePrice);

document.getElementById('reservation-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const date_depart = document.getElementById('date_depart').value;
    const date_retour = document.getElementById('date_retour').value;
    const nb_personnes = parseInt(document.getElementById('nb_personnes').value);
    
    if(new Date(date_retour) <= new Date(date_depart)) {
        document.getElementById('message').textContent = 'La date de retour doit être après la date de départ.';
        document.getElementById('message').className = 'message error';
        return;
    }
    
    const diff = (new Date(date_retour) - new Date(date_depart)) / (1000 * 60 * 60 * 24);
    const prix_total = (destination.prix_base * nb_personnes * diff).toFixed(2);
    
    document.getElementById('btn-text').classList.add('hidden');
    document.getElementById('btn-loader').classList.remove('hidden');
    document.getElementById('submit-btn').disabled = true;
    
    try {
        const response = await fetch(`${SUPABASE_URL}/rest/v1/reservations`, {
            method: 'POST',
            headers: {
                'apikey': SUPABASE_KEY,
                'Authorization': `Bearer ${TOKEN}`,
                'Content-Type': 'application/json',
                'Prefer': 'return=representation'
            },
            body: JSON.stringify({
                user_id: USER_ID,
                destination_id: DEST_ID,
                date_depart,
                date_retour,
                nb_personnes,
                prix_total: parseFloat(prix_total),
                statut: 'en_attente'
            })
        });
        
        const data = await response.json();
        
        if(data.error || (Array.isArray(data) && data[0]?.code)) {
            throw new Error('Erreur lors de la réservation.');
        }
        
        document.getElementById('message').textContent = '✅ Réservation confirmée ! Redirection vers votre tableau de bord...';
        document.getElementById('message').className = 'message success';
        setTimeout(() => window.location.href = 'dashboard.php', 2500);
        
    } catch(error) {
        document.getElementById('message').textContent = error.message;
        document.getElementById('message').className = 'message error';
        document.getElementById('btn-text').classList.remove('hidden');
        document.getElementById('btn-loader').classList.add('hidden');
        document.getElementById('submit-btn').disabled = false;
    }
});

loadDestination();
</script>
</body>
</html>
