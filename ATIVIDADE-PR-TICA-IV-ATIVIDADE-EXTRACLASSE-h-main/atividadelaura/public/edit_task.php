<?php
require __DIR__.'/../includes/db.php';
require __DIR__.'/../includes/auth.php';
require_login();
$user_id=$_SESSION['user_id'];
$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare('SELECT id,titulo,descricao FROM tarefas WHERE id=? AND usuario_id=?');
$stmt->execute([$id,$user_id]);
$task=$stmt->fetch();
if(!$task) { header('Location: tasks.php'); exit; }
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $titulo=trim(filter_input(INPUT_POST,'titulo',FILTER_SANITIZE_STRING));
    $descricao=trim(filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING));
    if(!$titulo) $errors[]='Título necessário';
    if(!$errors){
        $stmt=$pdo->prepare('UPDATE tarefas SET titulo=?,descricao=? WHERE id=? AND usuario_id=?');
        $stmt->execute([$titulo,$descricao,$id,$user_id]);
        header('Location: tasks.php');
        exit;
    }
}
require __DIR__.'/../includes/header.php';
require __DIR__.'/../includes/nav.php';
?>
<div class="row justify-content-center">
<div class="col-md-8">
<h3>Edit Tarefa</h3>
<?php foreach($errors as $e): ?><div class="alert alert-danger"><?=$e?></div><?php endforeach; ?>
<form method="post" novalidate>
<div class="mb-3"><label class="form-label">Título</label><input name="titulo" class="form-control" value="<?=htmlspecialchars($task['titulo'])?>" required></div>
<div class="mb-3"><label class="form-label">Descrição</label><textarea name="descricao" class="form-control"><?=htmlspecialchars($task['descricao'])?></textarea></div>
<button class="btn btn-primary">Save</button>
</form>
</div>
</div>
<?php require __DIR__.'/../includes/footer.php'; ?>
