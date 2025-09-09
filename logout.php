<?php



session_start();


$_SESSION = array();


session_destroy();


header("Location: index.php?mensagem=" . urlencode("Sessão encerrada com sucesso.") . "&tipo=success");
exit();
?>