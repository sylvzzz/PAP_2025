<?php

session_start();
 

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: index.php?mensagem=" . urlencode("É necessário iniciar sessão para acessar o fórum."));
    exit();
}
 

require_once 'conexao.php';
 

function formatarData($data) {
    $timestamp = strtotime($data);
    return date('d/m/Y H:i', $timestamp);
}
 

function limparDados($dados) {
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(trim($dados)));
}
 

if (isset($_POST['enviar_mensagem'])) {
    $titulo = limparDados($_POST['titulo']);
    $mensagem = limparDados($_POST['mensagem']);
    $num_aluno = $_SESSION['num_aluno'];
    $nome_autor = $_SESSION['nome_usuario'];
    $parent_id = isset($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
   
   
    if (empty($titulo) || empty($mensagem)) {
        $erro = "Preencha todos os campos obrigatórios.";
    } else {
       
        $parent_value = $parent_id ? "'$parent_id'" : "NULL";
        $sql = "INSERT INTO forumef (num_aluno, nome_autor, titulo, mensagem, parent_id)
                VALUES ('$num_aluno', '$nome_autor', '$titulo', '$mensagem', $parent_value)";
       
        if ($conn->query($sql) === TRUE) {
          
            header("Location: forumef.php?sucesso=" . urlencode("Mensagem publicada com sucesso!"));
            exit();
        } else {
            $erro = "Erro ao publicar mensagem: " . $conn->error;
        }
    }
}
 

if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    $num_aluno = $_SESSION['num_aluno'];
   
   
    $sql = "SELECT * FROM forumef WHERE id = $id AND num_aluno = '$num_aluno'";
    $resultado = $conn->query($sql);
   
    if ($resultado->num_rows === 1) {
      
        $sql = "DELETE FROM forumef WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: forumef.php?sucesso=" . urlencode("Mensagem excluída com sucesso!"));
            exit();
        } else {
            $erro = "Erro ao excluir mensagem: " . $conn->error;
        }
    } else {
        $erro = "Você não tem permissão para excluir esta mensagem.";
    }
}

if (isset($_POST['editar_mensagem'])) {
    $id = (int)$_POST['id_mensagem'];
    $titulo = limparDados($_POST['titulo']);
    $mensagem = limparDados($_POST['mensagem']);
    $num_aluno = $_SESSION['num_aluno'];
    
   
    $sql = "SELECT * FROM forumef WHERE id = $id AND num_aluno = '$num_aluno'";
    $resultado = $conn->query($sql);
    
    if ($resultado->num_rows === 1) {
      
        $sql = "UPDATE forumef SET titulo = '$titulo', mensagem = '$mensagem' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: forumef.php?sucesso=" . urlencode("Mensagem atualizada com sucesso!"));
            exit();
        } else {
            $erro = "Erro ao atualizar mensagem: " . $conn->error;
        }
    } else {
        $erro = "Você não tem permissão para editar esta mensagem.";
    }
}


$editar_id = null;
$editar_titulo = '';
$editar_mensagem = '';
if (isset($_GET['editar'])) {
    $id = (int)$_GET['editar'];
    $num_aluno = $_SESSION['num_aluno'];
    
    
    $sql = "SELECT * FROM forumef WHERE id = $id AND num_aluno = '$num_aluno'";
    $resultado = $conn->query($sql);
    
    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();
        $editar_id = $row['id'];
        $editar_titulo = $row['titulo'];
        $editar_mensagem = $row['mensagem'];
    } else {
        $erro = "Você não tem permissão para editar esta mensagem.";
    }
}

$termo_pesquisa = '';
$where_clause = "parent_id IS NULL";

if (isset($_GET['pesquisar']) && isset($_GET['termo'])) {
    $termo_pesquisa = limparDados($_GET['termo']);
    if (!empty($termo_pesquisa)) {
        
        $where_clause = "parent_id IS NULL AND titulo LIKE '%$termo_pesquisa%'";
    }
}
 

$sql = "SELECT * FROM forumef WHERE $where_clause ORDER BY data_criacao DESC";
$mensagens_principais = $conn->query($sql);
 

function buscarRespostas($conn, $parent_id) {
    $sql = "SELECT * FROM forumef WHERE parent_id = $parent_id ORDER BY data_criacao ASC";
    return $conn->query($sql);
}
?>
 
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum - Sistema Escolar</title>
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

.action-buttons {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    align-items: center;
}

.search-container {
    flex-grow: 1;
    margin: 0 15px;
    max-width: 400px;
}

.search-wrapper {
    display: flex;
    gap: 10px;
}

.search-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
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
}

.btn-small {
    padding: 8px 15px;
    font-size: 14px;
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

.message-alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.message-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.message-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.forum-message {
    background-color: #f9f9f9;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid #eee;
}

.forum-message:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.forum-message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.author-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3498db, #2c3e50);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

.message-content {
    line-height: 1.6;
    margin-top: 10px;
    color: #333;
}

.message-title {
    font-size: 20px;
    color: #2c3e50;
    margin-bottom: 5px;
    font-weight: 600;
}

.message-meta {
    font-size: 14px;
    color: #666;
}

.message-actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.forum-form {
    background-color: #f9f9f9;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    display: none;
    border: 1px solid #eee;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #2c3e50;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
}

textarea.form-control {
    min-height: 150px;
    resize: vertical;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.reply-form {
    margin-left: 50px;
    margin-top: 10px;
    display: none;
}

.forum-replies {
    margin-left: 50px;
    margin-top: 20px;
}

.no-messages {
    padding: 30px;
    text-align: center;
    color: #666;
    font-style: italic;
    background-color: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.no-results {
    padding: 20px;
    text-align: center;
    background-color: #f9f9f9;
    border-radius: 12px;
    color: #666;
    font-style: italic;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

footer {
    margin-top: 40px;
    text-align: center;
    color: #666;
    font-size: 14px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

/* Formulário fixo na parte inferior */
.fixed-form-container {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.95);
    padding: 15px 20px;
    box-shadow: 0 -3px 20px rgba(0, 0, 0, 0.15);
    z-index: 999;
    border-top: 1px solid #e0e0e0;
}

.fixed-form {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 15px;
}

.fixed-form-input {
    flex: 1;
    display: flex;
    align-items: center;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 30px;
    padding: 0 15px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.fixed-form-input input {
    border: none;
    padding: 10px 15px;
    font-size: 15px;
    width: 30%;
    background: transparent;
    outline: none;
    border-right: 1px solid #eee;
}

.fixed-form-input textarea {
    flex: 1;
    border: none;
    resize: none;
    padding: 10px 15px;
    font-size: 15px;
    height: 45px;
    background: transparent;
    outline: none;
}

.fixed-form-btn {
    background: linear-gradient(45deg, #2c3e50, #3498db);
    color: white;
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.fixed-form-btn:hover {
    transform: scale(1.05) translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    background: linear-gradient(45deg, #1a252f, #2980b9);
}

/* Estilo para o formulário de edição */
.edit-form-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.edit-form-container {
    background-color: white;
    border-radius: 12px;
    padding: 30px;
    width: 90%;
    max-width: 800px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
}

.edit-form-container h3 {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.edit-form-container h3 i {
    color: #3498db;
}

.edit-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

@media (max-width: 768px) {
    .container {
        padding: 20px;
        margin-bottom: 80px;
    }

    .forum-replies {
        margin-left: 20px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 15px;
    }

    .search-container {
        margin: 15px 0;
        max-width: 100%;
    }

    .btn {
        width: 100%;
        text-align: center;
    }

    .fixed-form-input {
        flex-direction: column;
        align-items: stretch;
    }
    
    .fixed-form-input input {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid #eee;
    }

    .edit-form-container {
        width: 95%;
        padding: 20px;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Fórum de Educação Física</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['nome_usuario'],0,1)); ?>
                </div>
                <div class="user-details">
                    <h3><?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></h3>
                    <p><?php echo htmlspecialchars($_SESSION['email_usuario']); ?></p>
                </div>
            </div>
        </header>
 
        <div class="action-buttons">
            <a href="homepage.php" class="btn">
                <i class="fas fa-arrow-left"></i> Voltar à Página Principal
            </a>
            
            <!-- Campo de pesquisa -->
            <div class="search-container">
                <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="search-wrapper">
                        <input type="text" name="termo" placeholder="Pesquisar por título..." class="search-input" value="<?php echo htmlspecialchars($termo_pesquisa); ?>">
                        <button type="submit" name="pesquisar" class="btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
 
        <?php if (isset($erro)): ?>
            <div class="message-alert message-error">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>
 
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="message-alert message-success">
                <?php echo htmlspecialchars($_GET['sucesso']); ?>
            </div>
        <?php endif; ?>
 
        <!-- Lista de mensagens do fórum -->
        <div id="listagemMensagens">
            <?php if ($mensagens_principais->num_rows > 0): ?>
                <?php while ($mensagem = $mensagens_principais->fetch_assoc()): ?>
                    <div class="forum-message">
                        <div class="forum-message-header">
                            <div class="author-info">
                                <div class="author-avatar">
                                    <?php echo strtoupper(substr($mensagem['nome_autor'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h3 class="message-title"><?php echo htmlspecialchars($mensagem['titulo']); ?></h3>
                                    <p class="message-meta">
                                        Por <strong><?php echo htmlspecialchars($mensagem['nome_autor']); ?></strong> em
                                        <?php echo formatarData($mensagem['data_criacao']); ?>
                                    </p>
                                </div>
                            </div>
                            <?php if ($mensagem['num_aluno'] == $_SESSION['num_aluno']): ?>
    <div>
        <a href="forumef.php?editar=<?php echo $mensagem['id']; ?>"
           class="btn btn-small">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="forumef.php?excluir=<?php echo $mensagem['id']; ?>"
           class="btn btn-danger btn-small"
           onclick="return confirm('Tem certeza que deseja excluir esta mensagem?');">
            <i class="fas fa-trash"></i> Excluir
        </a>
    </div>
<?php endif; ?>
                        </div>
                        <div class="message-content">
                            <?php echo nl2br(htmlspecialchars($mensagem['mensagem'])); ?>
                        </div>
                        <div class="message-actions">
                            <button class="btn btn-small btn-responder"
                                    data-id="<?php echo $mensagem['id']; ?>"
                                    data-titulo="<?php echo htmlspecialchars($mensagem['titulo']); ?>">
                                <i class="fas fa-reply"></i> Responder
                            </button>
                        </div>
 
                        <!-- Formulário de resposta (inicialmente oculto) -->
                        <div id="formResposta-<?php echo $mensagem['id']; ?>" class="reply-form">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <input type="hidden" name="parent_id" value="<?php echo $mensagem['id']; ?>">
                                <div class="form-group">
                                    <label for="titulo-resposta-<?php echo $mensagem['id']; ?>">Título:</label>
                                    <input type="text" name="titulo" id="titulo-resposta-<?php echo $mensagem['id']; ?>"
                                           class="form-control" value="RE: <?php echo htmlspecialchars($mensagem['titulo']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mensagem-resposta-<?php echo $mensagem['id']; ?>">Resposta:</label>
                                    <textarea name="mensagem" id="mensagem-resposta-<?php echo $mensagem['id']; ?>"
                                              class="form-control" required></textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-danger btn-cancelar-resposta">Cancelar</button>
                                    <button type="submit" name="enviar_mensagem" class="btn">Responder</button>
                                </div>
                            </form>
                        </div>
 
                        <!-- Respostas para esta mensagem -->
                        <?php
                        $respostas = buscarRespostas($conn, $mensagem['id']);
                        if ($respostas->num_rows > 0):
                        ?>
                            <div class="forum-replies">
                                <?php while ($resposta = $respostas->fetch_assoc()): ?>
                                    <div class="forum-message">
                                        <div class="forum-message-header">
                                            <div class="author-info">
                                                <div class="author-avatar">
                                                    <?php echo strtoupper(substr($resposta['nome_autor'], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <h3 class="message-title"><?php echo htmlspecialchars($resposta['titulo']); ?></h3>
                                                    <p class="message-meta">
                                                        Por <strong><?php echo htmlspecialchars($resposta['nome_autor']); ?></strong> em
                                                        <?php echo formatarData($resposta['data_criacao']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php if ($resposta['num_aluno'] == $_SESSION['num_aluno']): ?>
    <div>
        <a href="forumef.php?editar=<?php echo $resposta['id']; ?>"
           class="btn btn-small">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="forumef.php?excluir=<?php echo $resposta['id']; ?>"
           class="btn btn-danger btn-small"
           onclick="return confirm('Tem certeza que deseja excluir esta resposta?');">
            <i class="fas fa-trash"></i> Excluir
        </a>
    </div>
<?php endif; ?>
                                        </div>
                                        <div class="message-content">
                                            <?php echo nl2br(htmlspecialchars($resposta['mensagem'])); ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php elseif (isset($_GET['pesquisar']) && !empty($termo_pesquisa)): ?>
                <div class="no-results">
                    <p>Nenhuma mensagem encontrada para o termo "<?php echo htmlspecialchars($termo_pesquisa); ?>". Tente uma nova pesquisa.</p>
                </div>
            <?php else: ?>
                <div class="no-messages">
                    <p>Ainda não há mensagens no fórum. Seja o primeiro a publicar!</p>
                </div>
            <?php endif; ?>
        </div>
 
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Fórum Escolar. Todos os direitos reservados.</p>
        </footer>
    </div>
<!-- Formulário de edição (aparece somente quando estiver editando) -->
<?php if ($editar_id): ?>
<div class="edit-form-overlay">
    <div class="edit-form-container">
        <h3><i class="fas fa-edit"></i> Editar Mensagem</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="edit-form">
            <input type="hidden" name="id_mensagem" value="<?php echo $editar_id; ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo-edit" class="form-control" value="<?php echo htmlspecialchars($editar_titulo); ?>" required>
            </div>
            <div class="form-group">
                <label for="mensagem">Mensagem:</label>
                <textarea name="mensagem" id="mensagem-edit" class="form-control" required><?php echo htmlspecialchars($editar_mensagem); ?></textarea>
            </div>
            <div class="form-actions">
                <a href="forumef.php" class="btn btn-danger">Cancelar</a>
                <button type="submit" name="editar_mensagem" class="btn">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
 
    <!-- Formulário fixo na parte inferior (estilo Discord) -->
    <div class="fixed-form-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="fixed-form" id="formMensagem">
            <div class="fixed-form-input">
                <input type="text" name="titulo" id="titulo" required placeholder="Título..." title="Título da publicação">
                <textarea name="mensagem" id="mensagem" required placeholder="Escreva a sua mensagem aqui..." title="Conteúdo da mensagem"></textarea>
            </div>
            <button type="submit" name="enviar_mensagem" class="fixed-form-btn" title="Enviar mensagem">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
 
<script>
    document.addEventListener('DOMContentLoaded', function() {
       
        const botoesResponder = document.querySelectorAll('.btn-responder');
        const botoesCancelarResposta = document.querySelectorAll('.btn-cancelar-resposta');
        
        botoesResponder.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const msgId = this.getAttribute('data-id');
                const formResposta = document.getElementById(`formResposta-${msgId}`);
                formResposta.style.display = 'block';
                this.style.display = 'none';
            });
        });
        
        botoesCancelarResposta.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const formResposta = this.closest('.reply-form');
                formResposta.style.display = 'none';
                
            
                const msgId = formResposta.querySelector('input[name="parent_id"]').value;
                const btnResponder = document.querySelector(`.btn-responder[data-id="${msgId}"]`);
                btnResponder.style.display = 'inline-block';
            });
        });
        
      
        const formMensagem = document.getElementById('formMensagem');
        
        if (formMensagem) {
            formMensagem.addEventListener('submit', function(e) {
                const titulo = document.getElementById('titulo').value.trim();
                const mensagem = document.getElementById('mensagem').value.trim();
                
                if (titulo === '' || mensagem === '') {
                    e.preventDefault();
                    alert('Por favor, preencha todos os campos obrigatórios.');
                }
            });
        }
        
      
        const formEdicao = document.querySelector('.edit-form');
        
        if (formEdicao) {
            formEdicao.addEventListener('submit', function(e) {
                const titulo = document.getElementById('titulo-edit').value.trim();
                const mensagem = document.getElementById('mensagem-edit').value.trim();
                
                if (titulo === '' || mensagem === '') {
                    e.preventDefault();
                    alert('Por favor, preencha todos os campos obrigatórios.');
                }
            });
        }
        
      
        const editFormContainer = document.querySelector('.edit-form-container');
        
        if (editFormContainer) {
            editFormContainer.style.opacity = '0';
            editFormContainer.style.transform = 'translateY(-20px)';
            
            setTimeout(function() {
                editFormContainer.style.transition = 'all 0.3s ease';
                editFormContainer.style.opacity = '1';
                editFormContainer.style.transform = 'translateY(0)';
            }, 10);
        }
        
     
        const alertas = document.querySelectorAll('.message-alert');
        if (alertas.length > 0) {
            setTimeout(function() {
                alertas.forEach(function(alerta) {
                    alerta.style.display = 'none';
                });
            }, 5000);
        }
    });
</script>
</body>
</html>