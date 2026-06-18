<section id="meuCarrossel">
    <?php if (empty($crews)): ?>
        <div class="flex items-center justify-center h-full border border-dashed border-gray-800">
            <p class="text-gray-500 text-sm">NENHUMA CREW CADASTRADA NO BANCO DE DADOS AINDA.</p>
        </div>
    <?php else: ?>
        <?php foreach ($crews as $index => $crew): 
            $activeClass = ($index === 0) ? 'slide-ativo' : '';
            // caso n tenha img salva no banco, usa um fallback de placeholder
            $bgImg = $crew['img_bg'] ? 'public/uploads/' . $crew['img_bg'] : 'https://killatgear.com/wp-content/uploads/2025/04/Cape-Town-Rat-Race-1080x675.jpg';
            $perfilImg = $crew['img_perfil'] ? 'public/uploads/' . $crew['img_perfil'] : 'https://www.shutterstock.com/image-vector/cycling-bicycle-shop-logo-fixed-260nw-489361801.jpg';
        ?>
            <div class="slide <?= $activeClass ?>">
                <div class="absolute inset-0 bg-cover bg-center opacity-50 grayscale" style="background-image: url('<?= $bgImg ?>')"></div>
                <div class="slide-overlay absolute inset-0"></div>
                
                <div class="absolute bottom-0 left-0 w-full p-8 md:p-16">
                    <div class="container mx-auto flex flex-col md:flex-row items-end gap-6">
                        <div class="relative">
                            <img src="<?= $perfilImg ?>" class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-neon object-cover">
                        </div>

                        <div class="flex-grow">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-neon text-[10px] font-bold px-2 py-0.5"><?= htmlspecialchars($crew['destaque'] ?? 'FIXED GEAR') ?></span>
                                <span class="text-gray-400 text-xs flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> <?= htmlspecialchars($crew['cidade']) ?></span>
                            </div>
                            <h2 class="font-title text-5xl md:text-7xl leading-none text-white mb-2"><?= htmlspecialchars($crew['nome']) ?></h2>
                            <div class="flex items-center gap-4 text-sm text-gray-300 font-bold">
                                <span class="flex items-center gap-2"><i data-lucide="calendar" class="w-4 h-4 text-neon"></i> <?= htmlspecialchars($crew['dias'] ?? 'A COMBINAR') ?></span>
                            </div>
                        </div>

                        <div>
                            <a href="?page=crew&id=<?= $crew['id'] ?>" class="inline-block border border-neon text-neon hover:bg-neon hover:text-black px-6 py-3 font-bold transition-colors uppercase tracking-widest text-sm">
                                Ver Perfil da Crew
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<section class="py-12 bg-gray-900/50 border-b border-gray-800">
    <div class="container mx-auto px-4 text-center">
        <h2 class="font-title text-3xl mb-4">Encontre sua <span class="text-neon">Crew</span></h2>
        <p class="text-gray-400 mb-8 max-w-xl mx-auto font-bold text-sm">
            Conecte-se com grupos locais, marque pedais e ocupe a cidade. Digite a cidade abaixo para começar.
        </p>

        <form method="GET" action="" class="max-w-xl mx-auto flex border border-gray-700 p-1 bg-black">
            <input type="hidden" name="page" value="home">
            <input type="text" name="cidade" placeholder="DIGITE SUA CIDADE..." class="flex-grow bg-transparent text-white p-3 outline-none placeholder-gray-600 font-bold">
            <button type="submit" class="bg-neon px-6 font-bold text-black hover:bg-white transition-colors"><i data-lucide="search"></i></button>
        </form>
    </div>
</section>

<section class="py-20 bg-black text-center border-t border-gray-800">
    <div class="container mx-auto px-4">
        <h2 class="font-title text-4xl mb-12">COMO ENTRAR NO <span class="text-neon">GAME</span></h2>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="border border-gray-800 p-8 hover-neon transition duration-300 group cursor-default">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 border-2 border-neon rounded-full flex items-center justify-center group-hover:bg-black group-hover:text-[#39ff14] transition-colors">
                        <i data-lucide="map-pin" class="w-8 h-8"></i>
                    </div>
                </div>
                <h3 class="font-title text-2xl mb-2">1. BUSQUE NO MAPA</h3>
                <p class="text-gray-500 group-hover:text-black text-sm">Navegue pelo radar interativo e encontre grupos ativos na sua área.</p>
            </div>

            <div class="border border-gray-800 p-8 hover-neon transition duration-300 group cursor-default">
                 <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 border-2 border-neon rounded-full flex items-center justify-center group-hover:bg-black group-hover:text-[#39ff14] transition-colors">
                        <i data-lucide="users" class="w-8 h-8"></i>
                    </div>
                </div>
                <h3 class="font-title text-2xl mb-2">2. CONHEÇA A VIBE</h3>
                <p class="text-gray-500 group-hover:text-black text-sm">Analise o perfil, estilo de pedal e regras da crew.</p>
            </div>

            <div class="border border-gray-800 p-8 hover-neon transition duration-300 group cursor-default">
                 <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 border-2 border-neon rounded-full flex items-center justify-center group-hover:bg-black group-hover:text-[#39ff14] transition-colors">
                        <i data-lucide="bike" class="w-8 h-8"></i>
                    </div>
                </div>
                <h3 class="font-title text-2xl mb-2">3. COLE NO PEDAL</h3>
                <p class="text-gray-500 group-hover:text-black text-sm">Pegue o local e horário. Sem freio, sem desculpas. Só vai.</p>
            </div>
        </div>
    </div>
</section>

<script>
    // rotação do carrossel
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    if(slides.length > 1) {
        setInterval(() => {
            slides[currentSlide].classList.remove('slide-ativo');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('slide-ativo');
        }, 7000);
    }
</script>