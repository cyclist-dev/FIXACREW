<?php
namespace App\Models;
use PDO;
require_once __DIR__ . '/../config/database.php';

class Crew {
    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    // retorna todas as crews (com filtro opcional por cidade)
    public function getAll(string $cidade = ''): array {
        if ($cidade) {
            $stmt = $this->db->prepare("
                SELECT * FROM crews
                WHERE cidade LIKE ?
                ORDER BY nome ASC
            ");
            $stmt->execute(['%' . $cidade . '%']);
        } else {
            $stmt = $this->db->query("SELECT * FROM crews ORDER BY nome ASC");
        }
        return $stmt->fetchAll();
    }

    // retorna uma crew pelo ID
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM crews WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // retorna todas as crews com coordenadas (p/ mapa)
    public function getAllWithCoords(): array {
        $stmt = $this->db->query("
            SELECT id, nome, cidade, lat, lng, dias, destaque, img_perfil
            FROM crews
            WHERE lat IS NOT NULL AND lng IS NOT NULL
        ");
        return $stmt->fetchAll();
    }

    // Cria uma nova crew (retorna o ID inserido)
    public function create(array $dados): int {
        $stmt = $this->db->prepare("
            INSERT INTO crews
                (nome, modalidade, cidade, endereco, lat, lng, dias, destaque, descricao,
                 instagram, whatsapp, email, site, img_perfil, img_bg)
            VALUES
                (:nome, :modalidade, :cidade, :endereco, :lat, :lng, :dias, :destaque, :descricao,
                 :instagram, :whatsapp, :email, :site, :img_perfil, :img_bg)
        ");
        $stmt->execute($dados);
        return (int) $this->db->lastInsertId();
    }

    // Atualiza dados de uma crew existente
    public function update(int $id, array $dados): bool {
        $dados['id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE crews SET
                nome       = :nome,
                modalidade = :modalidade,
                cidade     = :cidade,
                endereco   = :endereco,
                dias       = :dias,
                destaque   = :destaque,
                descricao  = :descricao,
                instagram  = :instagram,
                whatsapp   = :whatsapp,
                email      = :email,
                site       = :site
            WHERE id = :id
        ");
        return $stmt->execute($dados);
    }

    // Remove uma crew
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM crews WHERE id = ?");
        return $stmt->execute([$id]);
    }
}