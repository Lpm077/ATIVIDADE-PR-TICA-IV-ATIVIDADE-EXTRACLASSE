<?php
require __DIR__.'/../includes/db.php';
if(session_status()===PHP_SESSION_NONE) session_start();
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nome=trim(filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING));
    $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
    $senha=$_POST['senha'] ?? '';
    if(!$nome) $errors[]='Nome necessário';
    if(!$email) $errors[]='Email inválido';
    if(strlen($senha)<6) $errors[]='Senha mínima 6 caracteres';
    if(!$errors){
        $hash=password_hash($senha,PASSWORD_DEFAULT);
        $stmt=$pdo->prepare('INSERT INTO usuarios (nome,email,senha) VALUES (?,?,?)');
        try{
            $stmt->execute([$nome,$email,$hash]);
            header('Location: login.php');
            exit;
        }catch(PDOException $e){
            $errors[]='Email já cadastrado';
        }
    }
}
require __DIR__.'/../includes/header.php';
require __DIR__.'/../includes/nav.php';
?>
<div class="row justify-content-center">
<div class="col-md-6">
<h3>Registrar</h3>
<?php foreach($errors as $e): ?><div class="alert alert-danger"><?=$e?></div><?php endforeach; ?>
<form method="post" novalidate>
<div class="mb-3"><label class="form-label">Nome</label><input name="nome" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Senha</label><input name="senha" type="password" class="form-control" required></div>
<button class="btn btn-primary">Registrar</button>
</form>
</div>
</div>
<?php require __DIR__.'/../includes/footer.php'; ?>