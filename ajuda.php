<?php
// ajuda.php - Página de suporte ao usuário

// Iniciar sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: index.php?mensagem=" . urlencode("É necessário iniciar sessão para acessar esta página."));
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA Fórum - Ajuda e Suporte</title>
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
        }

        h1 {
            color: #2c3e50;
            font-size: 32px;
            font-weight: 700;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
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

        /* Estilo para o menu de navegação */
        nav {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            z-index: 1000;
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

        /* Estilos para o submenu - CORRIGIDO */
        nav {
            position: relative;
            z-index: 9999 !important;
            overflow: visible !important; /* Importante: permitir que submenus ultrapassem os limites */
        }
        
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
            z-index: 100;
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
        
        /* Mostrar submenu ao passar o mouse - CORRIGIDO */
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

        /* Estilos para o conteúdo da página de ajuda */
        .help-content {
            margin-bottom: 40px;
        }

        .help-section {
            background-color: #f9f9f9;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .help-section h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
        }

        .help-section h2 i {
            margin-right: 12px;
            color: #3498db;
            font-size: 28px;
        }

        .help-section p {
            font-size: 16px;
            line-height: 1.6;
            color: #444;
            margin-bottom: 20px;
        }

        .help-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .help-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid #3498db;
        }

        .help-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }

        .help-card h3 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .help-card h3 i {
            margin-right: 10px;
            color: #3498db;
            font-size: 20px;
        }

        .help-card p {
            font-size: 15px;
            color: #555;
            line-height: 1.5;
        }

        /* Formulário de contato */
        .contact-form {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
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
            border: none;
            cursor: pointer;
            font-size: 16px;
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

        /* Mensagens de alerta */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        /* FAQ Section */
        .faq-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .faq-question {
            font-weight: 600;
            color: #2c3e50;
            font-size: 17px;
            margin-bottom: 10px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-question i {
            color: #3498db;
            transition: all 0.3s;
        }

        .faq-answer {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            color: #555;
            font-size: 15px;
            line-height: 1.6;
            display: none;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-item.active .faq-answer {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 14px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        /* Link de voltar */
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .back-link i {
            margin-right: 8px;
        }

        .back-link:hover {
            color: #2c3e50;
            transform: translateX(-5px);
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
            </div>
        </header>

        <!-- Menu de navegação (igual ao da homepage) -->
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
                        <i class="fas fa-question-circle"></i>
                        Fórum de Perguntas
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
                    <a href="ajuda.php" class="active">
                        <i class="fas fa-life-ring"></i>
                        Ajuda
                    </a>
                </li>
            </ul>
        </nav>

      
        <div class="help-content">
            <!-- Seção Principal de Ajuda -->
            <section class="help-section">
                <h2><i class="fas fa-life-ring"></i> Centro de Ajuda e Suporte</h2>
                <p>Bem-vindo ao Centro de Ajuda do ESA Fórum! Aqui encontrarás informações úteis sobre como utilizar o fórum da Escola Secundária de Amora. Se não encontrares resposta para a tua dúvida, utiliza o formulário de contacto abaixo para nos enviar uma mensagem.</p>
                
                <!-- Opções de Ajuda -->
                <div class="help-options">
                    <div class="help-card">
                        <h3><i class="fas fa-info-circle"></i> Sobre o ESA Fórum</h3>
                        <p>O ESA Fórum é uma plataforma de comunicação para alunos e professores da Escola Secundária de Amora, onde podes participar em discussões, fazer perguntas e partilhar ideias sobre temas escolares.</p>
                    </div>
                    
                    <div class="help-card">
                        <h3><i class="fas fa-comments"></i> Tipos de Fóruns</h3>
                        <p>Temos diferentes tipos de fóruns: Social, Ideias, Discussão Livre e fóruns específicos para cada disciplina escolar. Escolhe o mais adequado ao tema que pretendes discutir.</p>
                    </div>
                    
                    <div class="help-card">
                        <h3><i class="fas fa-shield-alt"></i> Comportamento no Fórum</h3>
                        <p>Mantém sempre um comportamento respeitoso nos fóruns. Não partilhes informações pessoais e evita linguagem ofensiva ou conteúdo inadequado.</p>
                    </div>
                </div>
            </section>

            <!-- Seção de FAQ -->
            <section class="help-section">
                <h2><i class="fas fa-question-circle"></i> Perguntas Frequentes</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Como acedo aos diferentes fóruns? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Podes aceder aos diferentes fóruns através do menu de navegação no topo da página. Temos o Fórum Social, Fórum de Ideias, Fórum de Discussão Livre e fóruns específicos para cada disciplina escolar, como Português, Matemática, Inglês, etc.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        O que posso publicar nos fóruns? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Podes encontrar amigos no Fórum Social, compartilhar ideias e projetos no Fórum de Ideias, e discutir temas variados no Fórum de Discussão Livre. Nos fóruns específicos de disciplinas, podes fazer publicações relacionadas com as respetivas áreas de estudo.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        O que devo fazer se encontrar conteúdo inadequado? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Se encontrares conteúdo que consideres inadequado ou ofensivo, por favor, envia-nos uma mensagem através do formulário de contacto nesta página, indicando o problema. A nossa equipa irá analisar a situação o mais rapidamente possível.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Como termino a minha sessão no ESA Fórum? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Para sair da tua conta, basta clicar no botão "Sair" de cor vermelha que se encontra na parte inferior de qualquer página do fórum quando estás com sessão iniciada.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Como posso consultar as notícias da escola? <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Na página inicial do ESA Fórum, podes encontrar uma secção dedicada a notícias sobre a nossa escola atualizadas regularmente.
                    </div>
                </div>
                
               
            </section>


            
            <!-- Suporte por Email Direto -->
            <section class="help-section">
                <h2><i class="fas fa-at"></i> Contacto Direto</h2>
                <p>Se preferires, podes também contactar-nos diretamente através do nosso email de suporte:</p>
                <p style="text-align: center; margin: 25px 0;">
                    <a href="mailto:ttvgu2005@gmail.com" class="btn" style="font-size: 18px;">
                        <i class="fas fa-envelope"></i> ESAforumsuporte@gmail.com
                    </a>
                </p>
                <p>Estamos disponíveis para ajudar-te com qualquer dúvida ou problema que possas ter durante a utilização do ESA Fórum.</p>
            </section>
        </div>

        <a href="logout.php" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Sair
        </a>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> ESA Fórum - Escola Secundária de Amora. Todos os direitos reservados.</p>
        </footer>
    </div>

    <!-- Script para funcionalidade de FAQ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Adicionar evento de clique para os itens do FAQ
            const faqQuestions = document.querySelectorAll('.faq-question');
            
            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    // Toggle da classe 'active' no item pai
                    const faqItem = this.parentElement;
                    faqItem.classList.toggle('active');
                });
            });
        });
    </script>
</body>
</html>