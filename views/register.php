<div class="container mx-auto px-4 py-12 max-w-2xl">
    <div class="text-center mb-10">
        <h1 class="font-title text-4xl mb-2">UPLOAD <span class="text-neon">CREW_DATA</span></h1>
        <p class="text-gray-500 font-bold text-sm">Preencha os dados abaixo para registrar sua equipe na rede local.</p>
    </div>

    <?php if (!empty($erros)): ?>
        <div class="border border-red-500 bg-red-950/20 text-red-400 p-4 mb-6 text-xs font-bold uppercase space-y-1">
            <?php foreach($erros as $erro): ?>
                <p>⚡ <?= htmlspecialchars($erro) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($sucesso) && $sucesso): ?>
        <div class="border border-neon bg-green-950/20 text-neon p-4 mb-6 text-xs font-bold uppercase">
            🚀 CREW REGISTRADA COM SUCESSO PROTOCOLO ATIVO.
        </div>
    <?php endif; ?>

    <form method="POST" action="?page=register" enctype="multipart/form-data" class="space-y-6 border border-gray-800 p-8 bg-gray-900/30">
        
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? ''; ?>">

        <input type="hidden" name="lat" id="geoLat">
        <input type="hidden" name="lng" id="geoLng">

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-neon mb-1 font-bold">NOME DA CREW *</label>
                <input type="text" name="nome" required class="w-full bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
            </div>
            <div>
                <label class="block text-xs text-neon mb-1 font-bold">ESTILO / MODALIDADE *</label>
                <select name="modalidade" required class="w-full bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
                    <option value="Street">Street</option>
                    <option value="Track / Velódromo">Track / Velódromo</option>
                    <option value="Social Ride">Social Ride</option>
                    <option value="Alleycat Organization">Alleycat Organization</option>
                </select>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-neon mb-1 font-bold">CIDADE ATIVA *</label>
                <input type="text" name="cidade" placeholder="Ex: SANTOS" required class="w-full bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
            </div>
            <div>
                <label class="block text-xs text-neon mb-1 font-bold">DIAS E HORÁRIOS DE ENCONTRO</label>
                <input type="text" name="dias" placeholder="Ex: TERÇAS E QUINTAS, 20H" class="w-full bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
            </div>
        </div>

        <div>
            <label class="block text-xs text-neon mb-1 font-bold">SLOGAN / Destaque Rápido</label>
            <input type="text" name="destaque" placeholder="Ex: FOCO EM VELOCIDADE" class="w-full bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
        </div>

        <div>
            <label class="block text-xs text-neon mb-1 font-bold">MANIFESTO / DESCRIÇÃO DA EQUIPE</label>
            <textarea name="descricao" rows="3" class="w-full bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase resize-none"></textarea>
        </div>

        <div>
            <label class="block text-xs text-neon mb-1 font-bold">ENDEREÇO PONTO DE ENCONTRO (PARA O RADAR)</label>
            <div class="flex gap-2">
                <input type="text" id="addressInput" name="endereco" placeholder="Rua, Número, Cidade..." class="flex-grow bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
                <button type="button" onclick="buscarCoordenadas()" class="border border-gray-600 px-4 hover:bg-gray-800 text-neon transition-colors" title="Buscar Coordenadas no Mapa">
                    <i data-lucide="map-pin"></i>
                </button>
            </div>
            <p id="geoStatus" class="text-[10px] text-gray-500 mt-1 uppercase font-bold">O sistema precisa converter o endereço em coordenadas para habilitar o marcador no mapa.</p>
        </div>

        <div class="pt-4 border-t border-gray-800">
            <label class="block text-xs text-neon mb-2 font-bold">REDES SOCIAIS & CONTATO</label>
            <div class="grid md:grid-cols-2 gap-4">
                <input type="text" name="instagram" placeholder="INSTAGRAM (@CREW...)" class="bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
                <input type="text" name="whatsapp" placeholder="WHATSAPP / TELEGRAM" class="bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
                <input type="email" name="email" placeholder="EMAIL DE CONTATO" class="bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
                <input type="text" name="site" placeholder="SITE OFICIAL / LINKTREE" class="bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
                <div class="md:col-span-2">
                    <input type="text" name="strava" placeholder="LINK DO CLUBE NO STRAVA" class="w-full bg-black border border-gray-700 p-3 text-white focus:border-neon outline-none font-bold text-sm uppercase">
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 pt-4 border-t border-gray-800">
            <div onclick="document.getElementById('file_perfil').click()" class="border-2 border-dashed border-gray-700 p-6 text-center hover:border-neon hover:bg-gray-900 cursor-pointer transition">
                <i data-lucide="image" class="w-8 h-8 mx-auto text-gray-500 mb-2"></i>
                <span class="text-xs font-bold block uppercase" id="lbl_perfil">FOTO DE PERFIL</span>
                <span class="text-[10px] text-gray-500">(MAX 2MB - SQUARE)</span>
                <input type="file" id="file_perfil" name="img_perfil" accept="image/*" class="hidden" onchange="updateLabel('file_perfil', 'lbl_perfil')">
            </div>
            <div onclick="document.getElementById('file_bg').click()" class="border-2 border-dashed border-gray-700 p-6 text-center hover:border-neon hover:bg-gray-900 cursor-pointer transition">
                <i data-lucide="aperture" class="w-8 h-8 mx-auto text-gray-500 mb-2"></i>
                <span class="text-xs font-bold block uppercase" id="lbl_bg">FOTO DE CAPA</span>
                <span class="text-[10px] text-gray-500">(MAX 2MB - WIDE)</span>
                <input type="file" id="file_bg" name="img_bg" accept="image/*" class="hidden" onchange="updateLabel('file_bg', 'lbl_bg')">
            </div>
        </div>

        <button type="submit" class="w-full bg-neon text-black font-title text-xl py-4 hover:bg-white transition-colors mt-4">
            TRANSMITIR REGISTRO
        </button>
    </form>
</div>

<script>
    function buscarCoordenadas() {
        var endereço = document.getElementById('addressInput').value;
        var statusMsg = document.getElementById('geoStatus');
        
        if (!endereço) {
            statusMsg.textContent = "Digite um endereço antes de buscar.";
            statusMsg.style.color = "#ff3333";
            return;
        }

        statusMsg.textContent = "Consultando satélites de mapeamento...";
        statusMsg.style.color = "#gray-500";

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereço)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    document.getElementById('geoLat').value = data[0].lat;
                    document.getElementById('geoLng').value = data[0].lon;
                    statusMsg.textContent = `📍 COORDENADAS CAPTURADAS COM SUCESSO (LAT: ${data[0].lat} | LNG: ${data[0].lon})`;
                    statusMsg.style.color = "#39ff14";
                } else {
                    statusMsg.textContent = "Endereço não localizado. Refine os dados ou digite uma praça principal.";
                    statusMsg.style.color = "#ff3333";
                }
            })
            .catch(() => {
                statusMsg.textContent = "Falha na comunicação com o serviço de mapas local.";
                statusMsg.style.color = "#ff3333";
            });
    }

    function updateLabel(inputId, labelId) {
        var input = document.getElementById(inputId);
        var label = document.getElementById(labelId);
        if (input.files.length > 0) {
            label.textContent = "✓ ARQUIVO CARREGADO";
            label.style.color = "#39ff14";
        }
    }
</script>