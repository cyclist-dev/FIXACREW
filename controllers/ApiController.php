<?php
namespace App\Controllers;
use PDOException;

class ApiController {
    
    public function crews(): void {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $db = getDB();
            $stmt = $db->query("SELECT id, name, city, state, latitude, longitude, instagram, created_at FROM crews ORDER BY name ASC");
            $crews = $stmt->fetchAll();

            http_response_code(200);
            echo json_encode($crews, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Falha ao processar a requisição no servidor.'
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}