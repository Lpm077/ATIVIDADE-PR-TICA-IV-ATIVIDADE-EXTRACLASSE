<?php
if(session_status()===PHP_SESSION_NONE) session_start();
?><nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
<a class="navbar-brand" href="/atividade/public/index.php">Atividade</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<?php if(!empty($_SESSION['user_id'])): ?>
<li class="nav-item"><a class="nav-link" href="/atividade/public/index.php">Dashboard</a></li>
<li class="nav-item"><a class="nav-link" href="/atividade/public/tasks.php">Tarefas</a></li>
<?php endif; ?>
</ul>
<ul class="navbar-nav ms-auto">
<?php if(!empty($_SESSION['user_id'])): ?>
<li class="nav-item"><a class="nav-link" href="#">Olá, <?=htmlspecialchars($_SESSION['user_name'])?></a></li>
<li class="nav-item"><a class="nav-link" href="/atividade/public/logout.php">Sair</a></li>
<?php else: ?>
<li class="nav-item"><a class="nav-link" href="/atividade/public/login.php">Entrar</a></li>
<li class="nav-item"><a class="nav-link" href="/atividade/public/register.php">Registrar</a></li>
<?php endif; ?>
</ul>
</div>
</div>
</nav>
<div class="container my-4">
