<?php
require __DIR__.'/../includes/db.php';
require __DIR__.'/../includes/auth.php';
if(session_status()===PHP_SESSION_NONE) session_start();
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
    $senha=$_POST['senha'] ?? '';
    if(!$email) $errors[]='Email inválido';
    if(!$senha) $errors[]='Senha necessária';
    if(!$errors){
        $stmt=$pdo->prepare('SELECT id,nome,senha FROM usuarios WHERE email=? LIMIT 1');
        $stmt->execute([$email]);
        $u=$stmt->fetch();
        if($u && password_verify($senha,$u['senha'])){
            login_user($u['id'],$u['nome']);
            header('Location: index.php');
            exit;
        } else $errors[]='Credenciais inválidas';
    }
}
require __DIR__.'/../includes/header.php';
require __DIR__.'/../includes/nav.php';
?>
<div class="row justify-content-center">
<div class="col-md-6">
<h3>Entrar</h3>
<?php foreach($errors as $e): ?><div class="alert alert-danger"><?=$e?></div><?php endforeach; ?>
<form method="post" novalidate>
<div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Senha</label><input name="senha" type="password" class="form-control" required></div>
<button class="btn btn-primary">Entrar</button>
</form>
</div>
</div>
<?php require __DIR__.'/../includes/footer.php'; ?>