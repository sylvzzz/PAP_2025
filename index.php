<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESA Fórum - Sistema de Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #2c3e50, #3498db, #2980b9);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .main-container {
            display: flex;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-height: 95vh;
            overflow: hidden;
            position: relative;
            margin: 40px 0;
        }

        .main-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #3498db, #2980b9, #2c3e50);
        }

        .intro-section {
            flex: 1.2;
            background: linear-gradient(135deg, #2c3e50, #2980b9);
            color: white;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            height: 100%;
        }

        .intro-section::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='rgba(255,255,255,.07)' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.8;
        }

        .intro-content {
            max-width: 500px;
            position: relative;
            z-index: 1;
        }

        .intro-title {
            font-size: 42px;
            margin-bottom: 15px;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            letter-spacing: 1px;
        }

        .intro-subtitle {
            font-size: 22px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .intro-text {
            font-size: 17px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-list {
            margin: 20px 0;
            padding-left: 10px;
        }

        .feature-list li {
            margin-bottom: 12px;
            position: relative;
            padding-left: 25px;
            list-style-type: none;
            font-size: 16px;
            line-height: 1.5;
        }

        .feature-list li::before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #3498db;
        }

        .forum-benefits {
            display: flex;
            justify-content: space-between;
            margin: 25px 0;
            text-align: center;
        }

        .benefit-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            width: 30%;
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .benefit-icon {
            font-size: 28px;
            margin-bottom: 10px;
            color: #3498db;
        }

        .benefit-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .benefit-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
        }

        .catchphrase {
            font-size: 20px;
            font-style: italic;
            margin: 25px 0;
            font-weight: 500;
            border-left: 4px solid #3498db;
            padding-left: 15px;
            line-height: 1.4;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 14px 35px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 25px;
            text-align: center;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 15px rgba(0, 0, 0, 0.3);
            background: linear-gradient(to right, #2980b9, #2c3e50);
        }

        .form-section {
            flex: 0.8;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #f9f9f9;
            height: 100%;
        }

        .container {
            width: 100%;
            text-align: center;
        }

        .form-title {
            font-size: 30px;
            margin-bottom: 30px;
            color: #2c3e50;
            position: relative;
            padding-bottom: 12px;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #2c3e50, #3498db);
            border-radius: 2px;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group i {
            position: absolute;
            top: 16px;
            left: 12px;
            color: #3498db;
            font-size: 16px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 40px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: white;
        }

        .input-group input:focus {
            border-color: #2c3e50;
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.1);
        }

        .input-group label {
            position: absolute;
            top: -8px;
            left: 12px;
            background-color: white;
            padding: 0 6px;
            font-size: 13px;
            color: #666;
            border-radius: 4px;
        }

        .btn {
            background: linear-gradient(45deg, #2c3e50, #3498db);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 16px 0;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            background: linear-gradient(45deg, #1a252f, #2980b9);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .links {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .links p {
            color: #666;
            font-size: 15px;
        }

        .links button {
            background: none;
            border: none;
            color: #2c3e50;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .links button:hover {
            color: #3498db;
            text-decoration: underline;
        }

        #signUpButton:hover, #signInButton:hover {
            color: #3498db;
            text-decoration: underline;
        }

        #signUpButton:active, #signInButton:active {
            transform: scale(0.95);
        }

        .message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Responsividade */
        @media screen and (max-width: 1200px) {
            .main-container {
                width: 95%;
            }
        }
        
        @media screen and (max-width: 900px) {
            .main-container {
                flex-direction: column;
                height: auto;
                min-height: 95vh;
                overflow-y: auto;
            }
            
            .intro-section {
                padding: 35px 25px;
            }
            
            .intro-content {
                max-width: 100%;
            }
            
            .form-section {
                padding: 35px 25px;
            }
            
            .forum-benefits {
                flex-direction: row;
                gap: 10px;
            }
            
            body {
                overflow-y: auto;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Seção de introdução (lado esquerdo) -->
        <div class="intro-section">
            <div class="intro-content">
                <h1 class="intro-title">ESA Fórum</h1>
                <h2 class="intro-subtitle">A voz dos alunos da Escola Secundária de Amora</h2>
                
                <p class="intro-text">
                    Bem-vindo à plataforma de discussão exclusiva para alunos da ESA. 
                    Aqui podes partilhar ideias, tirar dúvidas e debater temas escolares num ambiente colaborativo e amigável.
                </p>
                
                <ul class="feature-list">
                    <li>Grupos de discussão por disciplinas</li>
                    <li>Partilha de ideias</li>
                    <li>Notícias de Educação</li>
                    <li>Espaço para discutir temas variados</li>
                </ul>
                
                <div class="forum-benefits">
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-users"></i></div>
                        <div class="benefit-title">Comunidade</div>
                        <div class="benefit-desc">Conecta-te com colegas e fortalece laços</div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-book"></i></div>
                        <div class="benefit-title">Conhecimento</div>
                        <div class="benefit-desc">Partilha e adquire sabedoria coletiva</div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="benefit-title">Sucesso</div>
                        <div class="benefit-desc">Melhora o teu desempenho escolar</div>
                    </div>
                </div>
                
                <div class="catchphrase">
                    "Conecta, Partilha, Evolui - A tua comunidade académica digital está aqui."
                </div>
            </div>
        </div>
        
        <!-- Seção do formulário (lado direito) -->
        <div class="form-section">
            <div class="container" id="signup" style="display:none;">
                <h1 class="form-title">Criar Conta</h1>
                <form method="post" action="processamento.php" id="signupForm">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nome" id="nome" placeholder="Nome" required>
                        <label for="nome">Nome Completo</label>
                    </div>
                    <div class="input-group">
                        <i class="fa-solid fa-address-card"></i>
                        <input type="text" name="numc" id="numc" placeholder="Número Cartão" required>
                        <label for="numc">Nº Cartão da Escola</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Palavra-passe" required>
                        <label for="password">Palavra-Passe</label>
                    </div>
                    <input type="hidden" name="acao" value="registrar">
                    <input type="submit" class="btn" value="Criar Conta" name="signUp">
                </form>
                <div class="links">
                    <p>Já tens uma conta?</p>
                    <button id="signInButton">Iniciar Sessão</button>
                </div>
                <div id="mensagem-signup"></div>
            </div>

            <div class="container" id="signIn">
                <h1 class="form-title">Iniciar Sessão</h1>
                <form method="post" action="processamento.php" id="signinForm">
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="loginEmail" placeholder="Email" required>
                        <label for="loginEmail">Email</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="loginPassword" placeholder="Palavra-passe" required>
                        <label for="loginPassword">Palavra-Passe</label>
                    </div>
                    <input type="hidden" name="acao" value="login">
                    <input type="submit" class="btn" value="Iniciar Sessão" name="signIn">
                </form>
                
                <div class="links">
                    <p>Ainda não tens conta?</p>
                    <button id="signUpButton">Cria agora</button>
                </div>
               
                <div id="mensagem-signin"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const signUpButton = document.getElementById('signUpButton');
            const signInButton = document.getElementById('signInButton');
            const introCTAButton = document.getElementById('introCTAButton');
            const signInForm = document.getElementById('signIn');
            const signUpForm = document.getElementById('signup');
            const signupFormElement = document.getElementById("signupForm");
            const signinFormElement = document.getElementById("signinForm");
            
           
            const urlParams = new URLSearchParams(window.location.search);
            const mensagem = urlParams.get('mensagem');
            const tipo = urlParams.get('tipo');
            const formType = urlParams.get('form');
            
            if (mensagem) {
               
                if (formType === 'signup') {
                    const mensagemDiv = document.getElementById('mensagem-signup');
                    mensagemDiv.textContent = decodeURIComponent(mensagem).replace(/\+/g, ' ');
                    mensagemDiv.className = `message ${tipo || 'error'}`;
                    
                 
                    signInForm.style.display = "none";
                    signUpForm.style.display = "block";
                } else {
                    const mensagemDiv = document.getElementById('mensagem-signin');
                    mensagemDiv.textContent = decodeURIComponent(mensagem).replace(/\+/g, ' ');
                    mensagemDiv.className = `message ${tipo || 'error'}`;
                    
                
                    signInForm.style.display = "block";
                    signUpForm.style.display = "none";
                }
            } else if (formType === 'signup') {
                               signInForm.style.display = "none";
                signUpForm.style.display = "block";
            }

          
            signUpButton.addEventListener('click', function(){
                signInForm.style.display = "none";
                signUpForm.style.display = "block";
               
                document.getElementById('mensagem-signin').textContent = '';
                document.getElementById('mensagem-signin').className = '';
            });
            
            signInButton.addEventListener('click', function(){
                signInForm.style.display = "block";
                signUpForm.style.display = "none";
            
                document.getElementById('mensagem-signup').textContent = '';
                document.getElementById('mensagem-signup').className = '';
            });
            
        
            signupFormElement.addEventListener("submit", function (e) {
                e.preventDefault(); 
                
                let nome = document.getElementById("nome");
                let numc = document.getElementById("numc");
                let email = document.getElementById("email");
                let password = document.getElementById("password");
                
                let erros = [];
                
                if (!/^[A-Za-zÀ-ÿ\s]{3,}$/.test(nome.value.trim())) {
                    erros.push("O nome deve conter apenas letras e ter pelo menos 3 caracteres.");
                }
                
                if (!/^\d{5,}$/.test(numc.value)) {
                    erros.push("O número do cartão deve ter pelo menos 5 dígitos numéricos.");
                }
                
                if (!/^[^\s@]+@esec-amora\.pt$/.test(email.value)) {
                    erros.push("O email deve terminar com @esec-amora.pt");
                }
                
                if (password.value.length < 6) {
                    erros.push("A palavra-passe deve ter pelo menos 6 caracteres.");
                }
                
                if (erros.length > 0) {
                    alert(erros.join("\n"));
                } else {
                    this.submit();
                }
            });
            
      
            signinFormElement.addEventListener("submit", function (e) {
                e.preventDefault(); 
                
                let email = document.getElementById("loginEmail");
                let password = document.getElementById("loginPassword");
                
                let erros = [];
                
                if (!/^[^\s@]+@esec-amora\.pt$/.test(email.value)) {
                    erros.push("Insira um email válido.");
                }
                
                if (password.value.length < 6) {
                    erros.push("A palavra-passe deve ter pelo menos 6 caracteres.");
                }
                
                if (erros.length > 0) {
                    alert(erros.join("\n"));
                } else {
                    this.submit(); 
                }
            });
        });
    </script>
</body>
</html>