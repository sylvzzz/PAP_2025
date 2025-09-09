<?php



session_start();


ob_start();


require_once 'conexao.php';


function redirecionar($url, $mensagem = '', $tipo = 'error', $form = '') {
    $params = [];
    
    if (!empty($mensagem)) {
        $params['mensagem'] = urlencode($mensagem);
    }
    
    if (!empty($tipo)) {
        $params['tipo'] = $tipo;
    }
    
    if (!empty($form)) {
        $params['form'] = $form;
    }
    
    $query = !empty($params) ? '?' . http_build_query($params) : '';
    header("Location: $url$query");
    exit();
}


if (isset($_POST['acao'])) {
    
  
    if ($_POST['acao'] === 'registrar') {
       
        $nome = $conn->real_escape_string($_POST['nome']);
        $num_aluno = $conn->real_escape_string($_POST['numc']);
        $email = $conn->real_escape_string($_POST['email']);
        $senha = $_POST['password'];
        
     
        $erros = [];
        
        if (!preg_match('/^[A-Za-zÀ-ÿ\s]{3,}$/', $nome)) {
            $erros[] = "O nome deve conter apenas letras e ter pelo menos 3 caracteres.";
        }
        
        if (!preg_match('/^\d{5,}$/', $num_aluno)) {
            $erros[] = "O número do cartão deve ter pelo menos 5 dígitos numéricos.";
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@esec-amora\.pt$/', $email)) {
            $erros[] = "O email deve ser válido e terminar com @esec-amora.pt";
        }
        
        if (strlen($senha) < 6) {
            $erros[] = "A palavra-passe deve ter pelo menos 6 caracteres.";
        }
        
     
        if (!empty($erros)) {
            redirecionar('index.php', implode(" ", $erros), 'error', 'signup');
        }
        
       
        $sql = "SELECT * FROM alunos WHERE email = '$email'";
        $resultado = $conn->query($sql);
        
        if ($resultado->num_rows > 0) {
            redirecionar('index.php', 'Este email já está registado.', 'error', 'signup');
        }
        
       
        $sql = "SELECT * FROM alunos WHERE num_aluno = '$num_aluno'";
        $resultado = $conn->query($sql);
        
        if ($resultado->num_rows > 0) {
            redirecionar('index.php', 'Este número de cartão já está registado.', 'error', 'signup');
        }
        
      
        $senha_hash = md5($senha);
        
      
        $sql = "INSERT INTO alunos (num_aluno, nome, email, palavra_passe) 
                VALUES ('$num_aluno', '$nome', '$email', '$senha_hash')";
        
        if ($conn->query($sql) === TRUE) {
           
            redirecionar('index.php', 'Conta criada com sucesso! Agora podes iniciar sessão.', 'success');
        } else {
            redirecionar('index.php', 'Erro ao criar conta: ' . $conn->error, 'error', 'signup');
        }
    }
    
    
    elseif ($_POST['acao'] === 'login') {
      
        $email = $conn->real_escape_string($_POST['email']);
        $senha = $_POST['password'];
        
     
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 6) {
            redirecionar('index.php', 'Email ou palavra-passe inválidos.', 'error');
        }
        
      
        $senha_md5 = md5($senha);
        
      
        $sql = "SELECT * FROM alunos WHERE email = '$email' AND palavra_passe = '$senha_md5'";
        $resultado = $conn->query($sql);
        
        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            
         
            $_SESSION['num_aluno'] = $usuario['num_aluno'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['email_usuario'] = $usuario['email'];
            $_SESSION['logado'] = true;
            
          
            header("Location: homepage.php");
            exit();
        } else {
            redirecionar('index.php', 'Email ou palavra-passe incorretos.', 'error');
        }
    }
} else {
   
    redirecionar('index.php');
}
?>