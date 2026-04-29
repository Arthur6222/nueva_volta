<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Volta - Réservation en ligne</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <span class="logo-icon">✈</span>
            <span class="logo-text">Nueva Volta</span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Accueil</a></li>
            <li><a href="#destinations">Destinations</a></li>
            <?php if(isset($_SESSION['user'])): ?>
                <li><a href="dashboard.php">Mon compte</a></li>
                <li><a href="deconnexion.php" class="btn-nav">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php" class="btn-nav">S'inscrire</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <h1>Explorez le monde avec <span>Nueva Volta</span></h1>
        <p>Réservez vos voyages de rêve en quelques clics. Des destinations uniques vous attendent.</p>
        <div class="hero-buttons">
            <a href="#destinations" class="btn-primary">Voir les destinations</a>
            <?php if(!isset($_SESSION['user'])): ?>
                <a href="inscription.php" class="btn-secondary">Commencer gratuitement</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn-secondary">Mes réservations</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="hero-overlay"></div>
</section>

<section class="features">
    <div class="container">
        <div class="feature-card">
            <span class="feature-icon">🌍</span>
            <h3>Destinations mondiales</h3>
            <p>Des centaines de destinations à travers le monde à portée de main.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">💳</span>
            <h3>Paiement sécurisé</h3>
            <p>Vos transactions sont protégées par les meilleurs standards de sécurité.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">📱</span>
            <h3>Réservation facile</h3>
            <p>Interface intuitive pour réserver en quelques minutes seulement.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🎯</span>
            <h3>Meilleurs prix</h3>
            <p>Garantie du meilleur prix sur toutes nos offres de voyage.</p>
        </div>
    </div>
</section>

<section class="destinations-section" id="destinations">
    <div class="container">
        <h2 class="section-title">Nos destinations populaires</h2>
        <p class="section-subtitle">Choisissez parmi nos destinations les plus appréciées</p>
        
        <div class="destinations-grid" id="destinations-grid">
            <div class="loading">Chargement des destinations...</div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <span class="logo-icon">✈</span>
                <span class="logo-text">Nueva Volta</span>
                <p>Votre partenaire de voyage de confiance.</p>
            </div>
            <div class="footer-links">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#destinations">Destinations</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Nueva Volta. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<script>
const SUPABASE_URL = 'https://xxpgiwiosojzjwuszmnh.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inh4cGdpd2lvc29qemp3dXN6bW5oIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzcxOTE0NTIsImV4cCI6MjA5Mjc2NzQ1Mn0.-xzXJhx_TuYSTMYurunFbGbl7AoV6bXeWRdcZB7DPW0';

async function loadDestinations() {
    try {
        const response = await fetch(`${SUPABASE_URL}/rest/v1/destinations?select=*&disponible=eq.true`, {
            headers: {
                'apikey': SUPABASE_KEY,
                'Authorization': `Bearer ${SUPABASE_KEY}`
            }
        });
        
        const destinations = await response.json();
        const grid = document.getElementById('destinations-grid');
        
        if (destinations.length === 0) {
            grid.innerHTML = '<p class="no-data">Aucune destination disponible pour le moment.</p>';
            return;
        }
        
        grid.innerHTML = destinations.map(dest => `
            <div class="destination-card">
                <div class="card-image">
                    <img src="${dest.image_url}" alt="${dest.nom}" onerror="this.src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800'">
                    <div class="card-badge">${dest.pays}</div>
                </div>
                <div class="card-body">
                    <h3>${dest.nom}</h3>
                    <p>${dest.description}</p>
                    <div class="card-footer">
                        <div class="price">
                            <span class="price-from">À partir de</span>
                            <span class="price-amount">${parseFloat(dest.prix_base).toFixed(2)}€</span>
                        </div>
                        <a href="<?php echo isset($_SESSION['user']) ? '' : 'connexion.php'; ?>" 
                           onclick="reserverDestination(${dest.id}, '${dest.nom}')" 
                           class="btn-reserve">
                            Réserver
                        </a>
                    </div>
                </div>
            </div>
        `).join('');
        
    } catch(error) {
        document.getElementById('destinations-grid').innerHTML = 
            '<p class="error">Erreur de chargement des destinations.</p>';
    }
}

function reserverDestination(id, nom) {
    <?php if(isset($_SESSION['user'])): ?>
        window.location.href = `reservation.php?destination=${id}`;
        return false;
    <?php else: ?>
        window.location.href = 'connexion.php';
        return false;
    <?php endif; ?>
}

loadDestinations();
</script>

</body>
</html>
