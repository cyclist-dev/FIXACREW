 CREATE DATABASE IF NOT EXISTS fixacrew CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fixacrew;


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS crews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    modalidade VARCHAR(50) NOT NULL, 
    cidade VARCHAR(100) NOT NULL,
    state CHAR(2) NOT NULL DEFAULT 'SP',
    endereco VARCHAR(255) NULL,
    lat DECIMAL(10, 8) NULL, 
    lng DECIMAL(11, 8) NULL,          
    dias VARCHAR(100) NULL,           
    destaque VARCHAR(100) NULL,       
    descricao TEXT NULL,
    instagram VARCHAR(100) NULL,
    whatsapp VARCHAR(50) NULL,
    email VARCHAR(150) NULL,
    site VARCHAR(255) NULL,
    img_perfil VARCHAR(255) NULL,     
    img_bg VARCHAR(255) NULL,         
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS rides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crew_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT NULL,
    data_hora DATETIME NOT NULL,
    ponto_encontro VARCHAR(255) NOT NULL,    
    nivel VARCHAR(50) NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rides_crew FOREIGN KEY (crew_id) REFERENCES crews(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_UNICODE_CI;



INSERT INTO crews 
    (nome, modalidade, cidade, state, endereco, lat, lng, dias, destaque, descricao, instagram, whatsapp, email, img_perfil, img_bg) 
VALUES 
    (
        'URBAN GHOSTS', 
        'Street', 
        'SANTOS', 
        'SP', 
        'Praça da Independência', 
        -23.96180000, 
        -46.33220000, 
        'TERÇAS E QUINTAS, 20H', 
        'FOCO EM VELOCIDADE', 
        'Nascidos no caos do trânsito santista, somos a resistência da roda fixa.', 
        '@urban_ghosts', 
        '13999999999', 
        'contato@urbanghosts.com',
        '', 
        ''
    ),
    (
        'NIGHT RIDERS', 
        'Track / Fixa', 
        'PRAIA GRANDE', 
        'SP', 
        'Av. Costa e Silva', 
        -24.00580000, 
        -46.40230000, 
        'SEXTA-FEIRA, 19H', 
        'TREINO TÉCNICO', 
        'Treinos focados em performance e constância noturna.', 
        '@night_riders', 
        '13988888888', 
        'contato@nightriders.com',
        '', 
        ''
    );











