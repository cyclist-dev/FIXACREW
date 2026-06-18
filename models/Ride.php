<?php
namespace App\Models;
use PDO;
require_once __DIR__ . '/../config/database.php';

class Ride {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    // pedais por vir
    public function getUpcomingByCrew(int $crewId): array {
        $stmt = $this->db->prepare("
            SELECT * FROM rides
            WHERE crew_id = ? AND data_hora >= NOW()
            ORDER BY data_hora ASC
            LIMIT 5
        ");
        $stmt->execute([$crewId]);
        return $stmt->fetchAll();
    }

    // cria um pedal
    public function create(array $dados): int {
        $stmt = $this->db->prepare("
            INSERT INTO rides (crew_id, titulo, descricao, data_hora, ponto_encontro, nivel)
            VALUES (:crew_id, :titulo, :descricao, :data_hora, :ponto_encontro, :nivel)
        ");
        $stmt->execute($dados);
        return (int) $this->db->lastInsertId();
    }
}