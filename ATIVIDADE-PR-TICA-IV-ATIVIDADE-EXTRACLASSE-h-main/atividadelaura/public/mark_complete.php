<?php
require __DIR__.'/../includes/db.php';
require __DIR__.'/../includes/auth.php';
require_login();
$user_id=$_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=(int)($_POST['id']??0);
    $stmt=$pdo->prepare('UPDATE tarefas SET concluida=1 WHERE id=? AND usuario_id=?');
    $stmt->execute([$id,$user_id]);
}
header('Location: '.$_SERVER['HTTP_REFERER'] ?? 'index.php');
exit;
