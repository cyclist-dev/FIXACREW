# FIXACREW // UNDERGROUND NETWORK

**FixaCrew** is a decentralized platform connecting fixed gear cyclists, track bike enthusiasts, and urban riders. Designed with a brutalist, underground aesthetic (neon green on black), it serves as a digital hub for finding local crews, checking ride schedules, and exploring the urban cycling map. It acts not just as a directory, but as a manifesto for the "no brakes" culture, prioritizing raw data and visual impact over traditional corporate web design.

---

## 1. Refatoração e Arquitetura Técnico-Estrutural (MVC)

O sistema foi completamente reengenheirado, deixando de ser um script único (Spaghetti Code) para adotar padrões modernos de desenvolvimento backend e padrões de projeto de mercado:

* Arquitetura MVC Nativa: Separação rígida de responsabilidades. Os Models gerenciam a persistência e as regras de negócio; as Views isolam a camada de apresentação HTML/Tailwind; e os Controllers interceptam as requisições e orquestram o fluxo de dados.
* Autoloading & PSR-4: Implementação do gerenciador de dependências Composer. Toda a carga manual de arquivos via require ou include foi eliminada da estrutura de desenvolvimento. As classes são resolvidas e carregadas na memória automaticamente sob demanda.
* Ponto de Entrada Protegido (/public): Isolamento do núcleo da aplicação. O servidor web (Apache/XAMPP) aponta para a pasta public/index.php. Arquivos de configuração do sistema, credenciais de banco de dados e arquivos de lógica backend ficam ocultos e inacessíveis via URL direta, eliminando brechas de exposição de código.
* Rotas Dinâmicas: Centralização do fluxo de requisições. O arquivo index.php atua como um roteador central (Front Controller), processando os parâmetros de requisição e despachando para o controlador correto sem expor scripts internos.

---

## 2. Protocolos de Segurança Implementados

A aplicação foi blindada contra as vulnerabilidades mais comuns da web (OWASP Top 10):

* Proteção Anti-CSRF (Cross-Site Request Forgery): Geração de tokens criptográficos únicos de 32 bytes por sessão. O backend exige e valida a assinatura do token em cada requisição do tipo POST, bloqueando tentativas de falsificação de requisições externas.
* Sanitização contra XSS (Cross-Site Scripting): Todas as strings enviadas por formulários passam por filtragem estrita via htmlspecialchars(..., ENT_QUOTES, 'UTF-8') antes de serem armazenadas ou ecoadas, impedindo a execução de scripts maliciosos injetados.
* Prevenção contra SQL Injection: Utilização exclusiva de Prepared Statements com placeholders declarativos (via driver PDO do MySQL). Os parâmetros enviados pelo usuário são tratados estritamente como dados, impossibilitando a injeção de instruções SQL espúrias.
* Upload de Arquivos Blindado: O motor de upload não confia na extensão declarada pelo arquivo. O backend analisa a assinatura binária real do arquivo no storage local através da classe nativa \finfo. O sistema limita o tamanho dos uploads a 2MB, valida os tipos MIME permitidos (image/jpeg, image/png, image/webp) e renomeia os binários com hashes criptográficas aleatórias para evitar exploits locais ou sobrescritas de arquivos.

---

## 3. Tech Stack

* Backend: PHP 8.x (Programação Orientada a Objetos, Padrão MVC Nativo)
* Gerenciador de Dependências: Composer (Autoloading padrão PSR-4)
* Banco de Dados: MySQL / MariaDB (Persistência estruturada via PDO)
* Styling: Tailwind CSS via CDN (Design Responsivo e Brutalista)
* Map Engine: Leaflet.js + OpenStreetMap (Radar Interativo modificado via filtros CSS para inversão de matriz e Dark Mode)
* Icons & Fonts: Lucide Icons / Google Fonts (Texturina & DM Mono)

---

## 4. Como Executar o Projeto Localmente

### Pré-requisitos
* Servidor local Apache com suporte a PHP 8.x e MySQL instalado (XAMPP, Laragon ou WampServer).
* Composer instalado globalmente no sistema operacional.

### Passo a Passo

1. Clonar o Repositório:
   git clone https://github.com/seu-usuario/fixacrew.git
   cd fixacrew

2. Instalar Dependências (Gerar o Autoloader):
   composer install

3. Configurar o Banco de Dados:
   * Abra o seu gerenciador de banco (HeidiSQL, phpMyAdmin ou DBeaver).
   * Crie um banco de dados chamado fixacrew.
   * Certifique-se de que as tabelas crews e users estejam criadas com os campos estruturados de acordo com o modelo de dados do projeto.

4. Configurar o Ambiente Local:
   * Certifique-se de que a pasta do projeto esteja dentro do diretório de documentos do seu servidor local (ex: C:\xampp\htdocs\fixacrew).

5. Executar no Navegador:
   * Acesse a URL: http://localhost/fixacrew/public/

---

## 5. Próximos Passos do Roadmap

* [ ] View do Perfil Detalhado (views/crew.php): Implementar a interface individual para renderização completa de cada equipe e listagem de seus pedais agendados (rides).
* [ ] Autenticação de Usuários: Ativar a lógica do AuthController acoplada à visualização do painel administrativo (views/admin.php) para restringir acessos.
* [ ] Gerenciamento de Donos de Crew: Criar chave estrangeira ligando equipes a usuários para que apenas o criador de uma crew possa alterar ou excluir seus dados.

RIDE FAST // DIE LAST // PROTOCOL SECURITY ACTIVE // 2026