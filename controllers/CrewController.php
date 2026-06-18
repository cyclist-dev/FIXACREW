<?php
namespace App\Controllers;

use App\Models\Crew;
use App\Models\Ride;

class CrewController {
    private Crew $crewModel;

    public function __construct() {
        $this->crewModel = new Crew();
    }

    // GET /?page=home
    public function index(): void {
        $cidade = trim($_GET['cidade'] ?? '');
        $crews  = $this->crewModel->getAll($cidade);
        
        $viewPath = __DIR__ . '/../views/home.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    // GET /?page=crew&id=1
    public function show(): void {
        $id   = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $crew = $id ? $this->crewModel->getById($id) : null;

        if (!$crew) {
            http_response_code(404);
            require_once __DIR__ . '/../views/404.php';
            return;
        }

        $rideModel = new Ride();
        $rides     = $rideModel->getUpcomingByCrew($id);

        $viewPath = __DIR__ . '/../views/crew.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    // GET /?page=map
    public function map(): void {
        $crews = $this->crewModel->getAll();
        
        $viewPath = __DIR__ . '/../views/map.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    // GET /?page=register  |  POST /?page=register
    public function create(): void {
        $erros   = [];
        $sucesso = false;

        // inicializa o token CSRF na sessão se ele n existe
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // VALIDAÇÃO CSRF (Trava contra requisições forjadas externas)
            $tokenPost = $_POST['csrf_token'] ?? '';
            if (!hash_equals($_SESSION['csrf_token'], $tokenPost)) {
                http_response_code(403);
                die('Erro de validação de segurança (CSRF Token Inválido).');
            }

            // trata e limpa strings contra ataques XSS
            $nome       = htmlspecialchars(trim($_POST['nome'] ?? ''), ENT_QUOTES, 'UTF-8');
            $cidade     = htmlspecialchars(trim($_POST['cidade'] ?? ''), ENT_QUOTES, 'UTF-8');
            $modalidade = htmlspecialchars(trim($_POST['modalidade'] ?? ''), ENT_QUOTES, 'UTF-8');
            $dias       = htmlspecialchars(trim($_POST['dias'] ?? ''), ENT_QUOTES, 'UTF-8');
            $descricao  = htmlspecialchars(trim($_POST['descricao'] ?? ''), ENT_QUOTES, 'UTF-8');
            $instagram  = htmlspecialchars(trim($_POST['instagram'] ?? ''), ENT_QUOTES, 'UTF-8');
            $whatsapp   = htmlspecialchars(trim($_POST['whatsapp'] ?? ''), ENT_QUOTES, 'UTF-8');
            $email      = trim($_POST['email'] ?? '');

            if (strlen($nome) < 3)    $erros[] = 'Nome da crew deve ter ao menos 3 caracteres.';
            if (empty($cidade))       $erros[] = 'Informe a cidade.';
            if (empty($modalidade))   $erros[] = 'Selecione uma modalidade.';

            
            $img_perfil = null;
            if (!empty($_FILES['img_perfil']['tmp_name'])) {
                $img_perfil = $this->handleUpload($_FILES['img_perfil'], $erros);
            }

            $img_bg = null;
            if (!empty($_FILES['img_bg']['tmp_name'])) {
                $img_bg = $this->handleUpload($_FILES['img_bg'], $erros);
            }

            if (empty($erros)) {
                $this->crewModel->create([
                    'nome'       => $nome,
                    'modalidade' => $modalidade,
                    'cidade'     => $cidade,
                    'endereco'   => htmlspecialchars(trim($_POST['endereco'] ?? ''), ENT_QUOTES, 'UTF-8'),
                    'lat'        => filter_input(INPUT_POST, 'lat', FILTER_VALIDATE_FLOAT) ?: null,
                    'lng'        => filter_input(INPUT_POST, 'lng', FILTER_VALIDATE_FLOAT) ?: null,
                    'dias'       => $dias,
                    'destaque'   => htmlspecialchars(trim($_POST['destaque'] ?? ''), ENT_QUOTES, 'UTF-8'),
                    'descricao'  => $descricao,
                    'instagram'  => $instagram,
                    'whatsapp'   => $whatsapp,
                    'email'      => filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null,
                    'site'       => filter_input(INPUT_POST, 'site', FILTER_VALIDATE_URL) ?: null,
                    'img_perfil' => $img_perfil,
                    'img_bg'     => $img_bg,
                ]);
                $sucesso = true;
                
                // força a rotação do token após o envio do formulário
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
        }

        $viewPath = __DIR__ . '/../views/register.php';
        require_once __DIR__ . '/../views/layout.php';
    }

    private function handleUpload(array $file, array &$erros): ?string {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $erros[] = "Falha no recebimento do arquivo.";
            return null;
        }

        if ($file['size'] > MAX_UPLOAD_SIZE) {
            $erros[] = "Arquivo {$file['name']} excede o limite permitido.";
            return null;
        }

        // verifica a assinatura real do binário (impede scripts disfarçados de imagem)
        $finfo    = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, ALLOWED_MIME_TYPES)) {
            $erros[] = "Formato de arquivo inválido. Apenas JPG, PNG ou WEBP reais.";
            return null;
        }

        // valida a extensão do arquivo
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
            $erros[] = "Extensão de arquivo não permitida.";
            return null;
        }

        $novoNome  = bin2hex(random_bytes(16)) . '.' . $extensao;
        $destino   = UPLOAD_DIR . $novoNome;

        if (!move_uploaded_file($file['tmp_name'], $destino)) {
            $erros[] = "Erro ao salvar o arquivo no storage local.";
            return null;
        }

        return $novoNome;
    }
}