<?php
namespace App\Models;

use PDO;

class User {
    private PDO $db;

    public function __construct() {
        // usa a instância global do PDO configurada no ponto de entrada do sistema (OBRIGADA TEACHER ARLEY)
        global $pdo;
        $this->db = $pdo;
    }


    public function getByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ?: null;
    }

    // registra novo usuário se necessário no futuro
    public function register(string $name, string $email, string $password): int {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, password) VALUES (:name, :email, :password)
        ");
        $stmt->execute([
            'name'     => $name,
            'email'    => $email,
            'password' => $hash
        ]);
        return (int) $this->db->lastInsertId();
    }
}