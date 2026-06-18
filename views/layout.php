<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixaCrew - Underground Network</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <style>
        body {
            background-color: #050505;
            color: #e5e5e5;
            font-family: 'DM Mono', monospace;
        }
        .text-neon { color: #39ff14; }
        .bg-neon { background-color: #39ff14; color: black; }
        .border-neon { border-color: #39ff14; }
        .hover-neon:hover {
            background-color: #39ff14;
            color: black;
            border-color: #39ff14;
        }
        .font-title { font-family: 'Texturina', serif; text-transform: uppercase; }
        #meuCarrossel {
            position: relative;
            width: 100%;
            height: 70vh;
            min-height: 600px;
            overflow: hidden;
            border-bottom: 2px solid #39ff14;
        }
        .slide {
            position: absolute;
            inset: 0;
            display: none;
        }
        .slide-ativo {
            display: block; 
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .slide-overlay {
            background: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(0,0,0,0.6) 50%, rgba(0,0,0,0.2) 100%);
        }
        .animate-spin-slow {
            animation: spin 10s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .leaflet-layer, .leaflet-control-zoom-in, .leaflet-control-zoom-out, .leaflet-control-attribution {
            filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
        }
        .leaflet-container {
            background: #000;
            font-family: 'DM Mono', monospace;
        }
        .leaflet-popup-content-wrapper, .leaflet-popup-tip {
            background: #000;
            color: #39ff14;
            border: 1px solid #39ff14;
            border-radius: 0;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <header class="flex justify-between items-center p-5 border-b border-gray-800 sticky top-0 bg-black/95 backdrop-blur z-50">
        <a href="?page=home" class="flex items-center gap-3 group">
            <i data-lucide="cog" class="text-neon w-8 h-8 animate-spin-slow"></i>
            <div class="leading-none">
                <h1 class="font-title text-2xl tracking-wider">Fixa<span class="text-neon">Crew</span></h1>
                <p class="text-[10px] text-gray-500 tracking-[0.3em]">UNDERGROUND NETWORK</p>
            </div>
        </a>

        <nav class="hidden md:flex gap-8 text-sm font-bold tracking-tight">
            <a href="?page=home" class="text-gray-400 hover:text-white">INÍCIO</a>
            <a href="?page=map" class="text-gray-400 hover:text-white">MAPA</a>
            <a href="?page=register" class="text-gray-400 hover:text-white">CADASTRO</a>
        </nav>
        
        <button class="md:hidden text-white"><i data-lucide="menu"></i></button>
    </header>

    <main class="flex-grow">
        <?php if (isset($viewPath) && file_exists($viewPath)) { include $viewPath; } ?>
    </main>

    <footer class="border-t border-gray-800 bg-black py-8 text-center">
        <p class="text-xs text-gray-600 font-bold tracking-widest">© 2026 FIXACREW PROTOCOL // RIDE FAST DIE LAST</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>