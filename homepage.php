<?php



session_start();


if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: index.php?mensagem=" . urlencode("É necessário iniciar sessão precisa para acessar esta página."));
    exit();
}

function buscarNoticias() {
  
    return [
        [
            'titulo' => 'ESA Amora conquista 1º lugar no Concurso Nacional de Robótica',
            'descricao' => 'A equipa "TechAmora" da nossa escola destacou-se na competição nacional, trazendo o troféu para casa com um projeto inovador sobre sustentabilidade ambiental.',
            'data' => '22/05/2025'
        ],
        [
            'titulo' => 'Festival de Talentos ESA 2025 bate recordes de participação',
            'descricao' => 'Mais de 200 alunos participaram no festival anual da escola, apresentando performances de música, dança, teatro e artes visuais. O evento decorreu no pavilhão principal.',
            'data' => '20/05/2025'
        ],
        [
            'titulo' => 'Biblioteca da ESA Amora inaugura nova secção digital',
            'descricao' => 'Novos computadores e tablets estão agora disponíveis para pesquisa e estudo. A biblioteca também oferece acesso gratuito a plataformas de e-books e recursos educativos online.',
            'data' => '18/05/2025'
        ],
        [
            'titulo' => '3TGPSI leva a vitória para casa no Torneio de Futsal!',
            'descricao' => 'A turma 3TGPSI venceram por 3-1 na final e tornam-se os campeões do futsal. Os mesmos continuam invictos, sendo o segundo ano seguido a serem os vitoriosos do torneio. ',
            'data' => '15/05/2025'
        ],
        [
            'titulo' => 'Projeto "Horta Escolar" recebe prémio de sustentabilidade',
            'descricao' => 'A iniciativa dos alunos do 10º ano foi reconhecida pela Câmara Municipal de Seixal como exemplo de boas práticas ambientais. A horta já produz alimentos para a cantina.',
            'data' => '12/05/2025'
        ],
        [
            'titulo' => 'ESA Amora organiza Feira das Profissões com mais de 30 empresas',
            'descricao' => 'Estudantes do ensino secundário tiveram a oportunidade de conhecer diferentes carreiras e falar diretamente com profissionais de diversas áreas no evento realizado no ginásio.',
            'data' => '10/05/2025'
        ],
        [
            'titulo' => 'Alunos da ESA participam em intercâmbio com escola francesa',
            'descricao' => 'Quinze estudantes partiram para Lyon no âmbito do programa Erasmus+. Durante duas semanas, irão frequentar aulas e conhecer a cultura francesa, fortalecendo laços europeus.',
            'data' => '08/05/2025'
        ]
    ];
}

$noticias = buscarNoticias();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA Fórum - Área do Usuário</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: linear-gradient(135deg, #2c3e50, #3498db, #2980b9);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    min-height: 100vh;
    padding: 20px;
}

@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px;
    background-color: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
    position: relative;
    overflow: hidden;
}

.container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #3498db, #2980b9, #2c3e50);
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
    position: relative;
    z-index: 3000; /* CORRIGIDO: Z-index maior que o menu principal */
}

h1 {
    color: #2c3e50;
    font-size: 32px;
    font-weight: 700;
}

/* CORRIGIDO: Estilo para o menu de usuário com z-index alto */
.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
    cursor: pointer;
    z-index: 3001; /* CORRIGIDO: Z-index ainda maior */
}

.user-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #3498db, #2c3e50);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    z-index: 3002;
    position: relative;
}

.user-details h3 {
    margin: 0;
    color: #2c3e50;
    font-weight: 600;
}

.user-details p {
    margin: 5px 0 0;
    color: #666;
    font-size: 14px;
}

/* CORRIGIDO: Estilo para o menu dropdown do usuário com z-index muito alto */
.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 220px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
    padding: 15px;
    margin-top: 15px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 3003; /* CORRIGIDO: Z-index mais alto de todos */
}

.user-dropdown::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 20px;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid white;
}

.user-dropdown-header {
    padding-bottom: 10px;
    margin-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.user-dropdown-header h4 {
    color: #2c3e50;
    font-size: 16px;
    margin-bottom: 5px;
}

.user-dropdown-header p {
    color: #666;
    font-size: 13px;
    margin: 0;
}

.user-dropdown-menu {
    list-style: none;
}

.user-dropdown-menu li {
    margin-bottom: 5px;
}

.user-dropdown-menu li a {
    display: flex;
    align-items: center;
    padding: 10px;
    color: #333;
    text-decoration: none;
    font-size: 14px;
    border-radius: 8px;
    transition: all 0.2s;
}

.user-dropdown-menu li a:hover {
    background-color: #f5f5f5;
    color: #3498db;
}

.user-dropdown-menu li a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
    color: #3498db;
}

.user-dropdown-menu li.logout a {
    color: #e74c3c;
}

.user-dropdown-menu li.logout a:hover {
    background-color: #fdf1f0;
}

.user-dropdown-menu li.logout a i {
    color: #e74c3c;
}

/* CORRIGIDO: Mostrar o dropdown quando o usuário passa o mouse sobre user-info */
.user-info:hover .user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Adicionar efeito de hover no avatar */
.user-info:hover .user-avatar {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    transform: translateY(-2px);
}

.content {
    margin-bottom: 30px;
}

.welcome-message {
    font-size: 18px;
    color: #333;
    line-height: 1.6;
    margin-bottom: 30px;
    padding: 20px;
    background-color: #f8f9fa;
    border-left: 4px solid #3498db;
    border-radius: 0 8px 8px 0;
}

.btn {
    display: inline-block;
    background: linear-gradient(45deg, #2c3e50, #3498db);
    color: white;
    padding: 12px 25px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    background: linear-gradient(45deg, #1a252f, #2980b9);
}

.btn-danger {
    background: linear-gradient(45deg, #e74c3c, #c0392b);
}

.btn-danger:hover {
    background: linear-gradient(45deg, #c0392b, #962d22);
}

footer {
    margin-top: 40px;
    text-align: center;
    color: #666;
    font-size: 14px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

/* CORRIGIDO: Estilo para o menu de navegação com z-index menor */
nav {
    margin-bottom: 30px;
    background-color: #f8f9fa;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    overflow: visible !important;
    position: relative;
    z-index: 1000; /* CORRIGIDO: Z-index menor que o menu do usuário */
}

.menu {
    display: flex;
    flex-wrap: nowrap;
    list-style: none;
    padding: 0;
    width: 100%;
    justify-content: space-between;
}

.menu li {
    position: relative;
    list-style-type: none;
    flex: 1;
}

.menu li a {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px 20px;
    color: #2c3e50;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    text-align: center;
    flex-direction: column;
}

.menu li a:hover {
    background: linear-gradient(45deg, #f1f5f9, #e9ecef);
    color: #3498db;
}

.menu li a i {
    margin-bottom: 8px;
    font-size: 22px;
    color: #3498db;
    transition: all 0.3s;
}

.menu li a:hover i {
    transform: translateY(-3px);
    color: #2c3e50;
}

/* CORRIGIDO: Estilos para o submenu com z-index controlado */
.menu li.dropdown {
    position: relative;
    z-index: 1001;
}

.menu li.dropdown .submenu {
    display: none;
    position: absolute;
    left: 0;
    top: 100%;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    z-index: 1002; /* CORRIGIDO: Z-index menor que o menu do usuário */
    width: 250px;
    padding: 10px 0;
    overflow: hidden;
}

.submenu li {
    width: 100%;
    list-style-type: none;
    display: block;
}

.submenu li a {
    display: flex;
    padding: 15px 20px;
    color: #2c3e50;
    border-bottom: 1px solid #f5f5f5;
    transition: all 0.3s;
    justify-content: flex-start;
    flex-direction: row;
}

.submenu li a:hover {
    background: linear-gradient(45deg, #f1f5f9, #e9ecef);
    color: #3498db;
    padding-left: 25px;
}

.submenu li a i {
    margin-right: 10px;
    margin-bottom: 0;
    width: 20px;
    text-align: center;
}

/* Mostrar submenu ao passar o mouse */
.menu li.dropdown:hover .submenu {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Estilo para o indicador de dropdown */
.menu .dropdown > a::after {
    content: '\f0d7';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 12px;
    display: block;
    margin-top: 5px;
    color: #3498db;
}

/* Estilo para o carrossel de notícias */
.news-section {
    margin: 40px 0;
    padding: 30px;
    background-color: #f9f9f9;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.news-section h2 {
    color: #2c3e50;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    font-size: 24px;
    font-weight: 700;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
}

.news-section h2 i {
    margin-right: 12px;
    color: #3498db;
    font-size: 28px;
}

.news-carousel {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    height: 300px;
}

.news-slides {
    display: flex;
    transition: transform 0.5s ease;
    height: 100%;
}

.news-slide {
    min-width: 100%;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    height: 100%;
}

.news-content {
    padding: 30px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.news-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #2c3e50;
    line-height: 1.4;
}

.news-description {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 20px;
}

.news-date {
    font-size: 14px;
    color: #999;
    display: flex;
    align-items: center;
}

.news-date i {
    margin-right: 8px;
    color: #3498db;
}

.news-nav {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: 10px;
    z-index: 10;
}

.news-nav-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: rgba(52, 152, 219, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
}

.news-nav-dot.active {
    background-color: #3498db;
    transform: scale(1.2);
}

.news-prev, .news-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.9);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    opacity: 0;
    visibility: hidden;
}

.news-prev:hover, .news-next:hover {
    background-color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}

/* Mostrar as setas apenas quando o rato está sobre o carrossel */
.news-carousel:hover .news-prev,
.news-carousel:hover .news-next {
    opacity: 1;
    visibility: visible;
}

.news-prev {
    left: 20px;
}

.news-next {
    right: 20px;
}

@media (max-width: 768px) {
    .news-carousel {
        height: 250px;
    }
    
    .news-content {
        padding: 20px;
    }
    
    .news-title {
        font-size: 20px;
    }
    
    .news-description {
        font-size: 14px;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>ESA Fórum</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['nome_usuario'], 0, 1)); ?>
                </div>
                <div class="user-details">
                    <h3><?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></h3>
                    <p><?php echo htmlspecialchars($_SESSION['email_usuario']); ?></p>
                </div>
                <!-- NOVO: Menu dropdown do usuário -->
                <div class="user-dropdown">
                    
                    <ul class="user-dropdown-menu">
                        <li class="logout"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
			
                    </ul>
                </div>
            </div>
        </header>

          <nav>
            <ul class="menu">
                <li>
                    <a href="homepage.php">
                        <i class="fas fa-home"></i>
                        Página Inicial
                    </a>
                </li>
                <li>
                    <a href="forumperguntas.php">
                        <i class="fa fa-id-badge"></i>
                        Fórum Social
                    </a>
                </li>
                <li>
                    <a href="forumideias.php">
                        <i class="fas fa-lightbulb"></i>
                        Fórum de Ideias
                    </a>
                </li>
                <li>
                    <a href="forumdiscussao.php">
                        <i class="fas fa-comments"></i>
                        Fórum de Discussão Livre
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#">
                        <i class="fas fa-graduation-cap"></i>
                        Fóruns de Disciplinas
                    </a>
                    <ul class="submenu">
                        <li><a href="forumpt.php?disciplina=portugues"><i class="fas fa-book"></i> Português</a></li>
                        <li><a href="forummat.php?disciplina=matematica"><i class="fas fa-calculator"></i> Matemática</a></li>
                        <li><a href="forumingles.php?disciplina=ingles"><i class="fas fa-language"></i> Inglês</a></li>
                        <li><a href="forumciencias.php?disciplina=ciencias"><i class="fas fa-flask"></i> Ciências</a></li>
                        <li><a href="forumhistoria.php?disciplina=historia"><i class="fas fa-landmark"></i> História</a></li>
                        <li><a href="forumgeo.php?disciplina=geografia"><i class="fas fa-globe-americas"></i> Geografia</a></li>
                        <li><a href="forumef.php?disciplina=educacao-fisica"><i class="fas fa-running"></i> Educação Física</a></li>
                        <li><a href="forumartes.php?disciplina=artes"><i class="fas fa-palette"></i> Artes</a></li>
                        <li><a href="foruminformatica.php?disciplina=informatica"><i class="fas fa-laptop-code"></i> Informática</a></li>
                        <li><a href="forumfq.php?disciplina=fisico-quimica"><i class="fas fa-atom"></i> Físico-Química</a></li>
                    </ul>
                </li>
                <li>
                    <a href="ajuda.php">
                        <i class="fas fa-life-ring"></i>
                        Ajuda
                    </a>
                </li>
            </ul>
        </nav>

        <div class="content">
            <p class="welcome-message">
                <strong>Bem-vindo ao ESA Fórum!</strong> Aqui podes conectar com colegas, partilhar conhecimentos, tirar dúvidas e participar em discussões sobre temas escolares e muito mais. Explora os diferentes fóruns e participa ativamente na nossa comunidade!
            </p>
        </div>

        <!-- Nova seção de notícias com carrossel -->
        <section class="news-section">
            <h2><i class="fas fa-newspaper"></i> Notícias Sobre a Escola Secundária de Amora</h2>
            <div class="news-carousel">
                <button class="news-prev" aria-label="Anterior">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="news-next" aria-label="Próximo">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <div class="news-slides">
                    <?php foreach ($noticias as $i => $noticia): ?>
                    <div class="news-slide">
                        <div class="news-content">
                            <h3 class="news-title"><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                            <p class="news-description"><?php echo htmlspecialchars($noticia['descricao']); ?></p>
                            <div class="news-date">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo htmlspecialchars($noticia['data']); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="news-nav">
                    <?php for ($i = 0; $i < count($noticias); $i++): ?>
                    <div class="news-nav-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> ESA Fórum - Escola Secundária de Amora. Todos os direitos reservados.</p>
        </footer>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('.news-carousel');
            const slides = document.querySelector('.news-slides');
            const slideItems = document.querySelectorAll('.news-slide');
            const dots = document.querySelectorAll('.news-nav-dot');
            const prevButton = document.querySelector('.news-prev');
            const nextButton = document.querySelector('.news-next');
            
            let currentSlide = 0;
            const totalSlides = slideItems.length;
            
          
            function showSlide(index) {
                if (index < 0) {
                    currentSlide = totalSlides - 1;
                } else if (index >= totalSlides) {
                    currentSlide = 0;
                } else {
                    currentSlide = index;
                }
                
                
                slides.style.transform = `translateX(-${currentSlide * 100}%)`;
                
            
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === currentSlide);
                });
            }
            
          
            prevButton.addEventListener('click', () => {
                showSlide(currentSlide - 1);
            });
            
            nextButton.addEventListener('click', () => {
                showSlide(currentSlide + 1);
            });
            
           
            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    showSlide(i);
                });
            });
            
     
            let slideInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 5000);
            
         
            carousel.addEventListener('mouseenter', () => {
                clearInterval(slideInterval);
            });
            
            
            carousel.addEventListener('mouseleave', () => {
                slideInterval = setInterval(() => {
                    showSlide(currentSlide + 1);
                }, 5000);
            });
            
            
            showSlide(0);
        });
    </script>
</body>
</html>