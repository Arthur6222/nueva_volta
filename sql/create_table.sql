-- Table profils (liée à auth.users de Supabase)
CREATE TABLE profils (
    id UUID REFERENCES auth.users(id) PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    date_naissance DATE,
    telephone VARCHAR(20),
    created_at TIMESTAMP DEFAULT NOW()
);

-- Table destinations
CREATE TABLE destinations (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    description TEXT,
    image_url TEXT,
    prix_base DECIMAL(10,2) NOT NULL,
    disponible BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT NOW()
);

-- Table reservations
CREATE TABLE reservations (
    id SERIAL PRIMARY KEY,
    user_id UUID REFERENCES auth.users(id),
    destination_id INTEGER REFERENCES destinations(id),
    date_depart DATE NOT NULL,
    date_retour DATE NOT NULL,
    nb_personnes INTEGER DEFAULT 1,
    prix_total DECIMAL(10,2),
    statut VARCHAR(20) DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT NOW()
);

-- Données de test destinations
INSERT INTO destinations (nom, pays, description, image_url, prix_base) VALUES
('Paris', 'France', 'La ville lumière vous attend avec ses musées et sa gastronomie.', 'https://images.unsplash.com/photo-1502602898536-47ad22581b52?w=800', 299.99),
('Barcelone', 'Espagne', 'Architecture de Gaudí, plages et vie nocturne animée.', 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=800', 349.99),
('Rome', 'Italie', 'Histoire millénaire, cuisine authentique et monuments légendaires.', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800', 399.99),
('Amsterdam', 'Pays-Bas', 'Canaux pittoresques, musées de classe mondiale et vélos partout.', 'https://images.unsplash.com/photo-1534351590666-13e3e96b5017?w=800', 279.99),
('Lisbonne', 'Portugal', 'Tramways colorés, pastéis de nata et couchers de soleil magiques.', 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?w=800', 259.99),
('Prague', 'République Tchèque', 'Architecture médiévale préservée et bière artisanale réputée.', 'https://images.unsplash.com/photo-1541849546-216549ae216d?w=800', 229.99);

-- RLS Policies
ALTER TABLE profils ENABLE ROW LEVEL SECURITY;
ALTER TABLE reservations ENABLE ROW LEVEL SECURITY;

CREATE POLICY "Users can view own profile" ON profils FOR SELECT USING (auth.uid() = id);
CREATE POLICY "Users can update own profile" ON profils FOR UPDATE USING (auth.uid() = id);
CREATE POLICY "Users can insert own profile" ON profils FOR INSERT WITH CHECK (auth.uid() = id);

CREATE POLICY "Users can view own reservations" ON reservations FOR SELECT USING (auth.uid() = user_id);
CREATE POLICY "Users can insert own reservations" ON reservations FOR INSERT WITH CHECK (auth.uid() = user_id);

CREATE POLICY "Anyone can view destinations" ON destinations FOR SELECT USING (true);
ALTER TABLE destinations ENABLE ROW LEVEL SECURITY;
