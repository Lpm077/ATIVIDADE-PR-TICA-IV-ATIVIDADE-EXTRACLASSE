<?php
require __DIR__.'/../includes/db.php';
require __DIR__.'/../includes/auth.php';
require_login();
$user_id=$_SESSION['user_id'];
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $titulo=trim(filter_input(INPUT_POST,'titulo',FILTER_SANITIZE_STRING));
    $descricao=trim(filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING));
    if(!$titulo) $errors[]='Título necessário';
    if(!$errors){
        $stmt=$pdo->prepare('INSERT INTO tarefas (usuario_id,titulo,descricao) VALUES (?,?,?)');
        $stmt->execute([$user_id,$titulo,$descricao]);
        header('Location: tasks.php');
        exit;
    }
}
require __DIR__.'/../includes/header.php';
require __DIR__.'/../includes/nav.php';
?>
<div class="row justify-content-center">
<div class="col-md-8">
<h3>Nova Tarefa</h3>
<?php foreach($errors as $e): ?><div class="alert alert-danger"><?=$e?></div><?php endforeach; ?>
<form method="post" novalidate>
<div class="mb-3"><label class="form-label">Título</label><input name="titulo" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Descrição</label><textarea name="descricao" class="form-control"></textarea></div>
<button class="btn btn-primary">Salvar</button>
</form>
</div>
</div>
<?php require __DIR__.'/../includes/footer.php'; ?>