<div class="relative w-full bg-gray-900 flex-grow overflow-hidden" style="height: calc(100vh - 85px);">

    <div id="map" class="w-full h-full z-0"></div>

    <input type="hidden" id="dadosCrews" value='<?= json_encode($crews); ?>'>

    <div class="absolute top-4 left-4 z-[401] bg-black/90 border border-neon p-4 w-64 shadow-2xl pointer-events-auto">
        <h3 class="font-title text-xl mb-4 border-b border-gray-800 pb-2">RADAR <span class="text-neon">ATIVO</span></h3>
        <input type="text" id="filterInput" placeholder="FILTRAR POR CIDADE..." class="w-full bg-gray-900 border border-gray-700 p-2 text-xs mb-4 text-white outline-none focus:border-neon font-bold">

        <div class="space-y-2 max-h-60 overflow-y-auto" id="crewsList">
            <?php if (empty($crews)): ?>
                <p class="text-gray-600 text-xs font-bold uppercase">Nenhuma crew com coordenadas.</p>
            <?php else: ?>
                <?php foreach ($crews as $crew): ?>
                    <div class="flex items-center justify-between text-xs text-gray-400 hover:text-white cursor-pointer group p-1 hover:bg-gray-900 transition-colors"
                        onclick="focusOnMap(<?= $crew['lat'] ?>, <?= $crew['lng'] ?>)">
                        <span class="font-bold uppercase"><?= htmlspecialchars($crew['nome']) ?></span>
                        <i data-lucide="map-pin" class="w-3 h-3 group-hover:text-neon"></i>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="absolute bottom-8 right-8 flex flex-col gap-2 z-[401]">
        <button onclick="zoomIn()" class="bg-black border border-gray-700 text-white p-2 hover:border-neon hover:text-neon transition-colors"><i data-lucide="plus"></i></button>
        <button onclick="zoomOut()" class="bg-black border border-gray-700 text-white p-2 hover:border-neon hover:text-neon transition-colors"><i data-lucide="minus"></i></button>
    </div>
</div>

<script>
    // starta o mapa centralizado na Baixada Santista, q o local foco inicial do projeto
    var map = L.map('map', {
        zoomControl: false
    }).setView([-23.97, -46.35], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var crews = JSON.parse(document.getElementById('dadosCrews').value || '[]');

  
    var neonIcon = L.divIcon({
        className: 'custom-div-icon',
        html: "<div style='color: #39ff14; filter: drop-shadow(0 0 5px #39ff14); display: flex; justify-content: center; align-items: center;'><svg width='32' height='32' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z'></path><circle cx='12' cy='10' r='3'></circle></svg></div>",
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    // mapeia e plota os marcadores no mapa bem bonitin
    crews.forEach(function(crew) {
        if (crew.lat && crew.lng) {
            var marker = L.marker([parseFloat(crew.lat), parseFloat(crew.lng)], {
                icon: neonIcon
            }).addTo(map);

            var perfilImg = crew.img_perfil ? 'uploads/' + crew.img_perfil : 'https://www.shutterstock.com/image-vector/cycling-bicycle-shop-logo-fixed-260nw-489361801.jpg';

            var popupContent = `
                <div style="text-align:center; color: #39ff14; min-width: 130px;">
                    <h3 style="margin:0 0 4px 0; font-family:'Texturina', serif; text-transform:uppercase; font-size:14px; border-bottom: 1px solid #333; padding-bottom: 4px;">\${crew.nome}</h3>
                    <p style="margin:5px 0; font-size:10px; color:#ccc; font-family: 'DM Mono', monospace;">\${crew.cidade}</p>
                    <a href="?page=crew&id=\${crew.id}" style="display:inline-block; background:#39ff14; color:black; padding:4px 8px; text-decoration:none; font-weight:bold; font-size:10px; margin-top:5px; font-family: 'DM Mono', monospace; text-transform: uppercase;">VER PERFIL</a>
                </div>
            `;
            marker.bindPopup(popupContent);
        }
    });

    function focusOnMap(lat, lng) {
        map.flyTo([lat, lng], 15, {
            animate: true,
            duration: 1.5
        });
    }

    function zoomIn() {
        map.zoomIn();
    }
    document.getElementById('filterInput').addEventListener('input', function(e) {
        var text = e.target.value.toLowerCase();
        var items = document.querySelectorAll('#crewsList > div');
        items.forEach(function(item) {
            var cityName = item.textContent.toLowerCase();
            item.style.display = cityName.includes(text) ? 'flex' : 'none';
        });
    });

    setTimeout(() => {
        lucide.createIcons();
    }, 100);
</script>