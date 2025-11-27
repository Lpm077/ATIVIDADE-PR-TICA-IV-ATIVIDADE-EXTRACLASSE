<?php
require __DIR__.'/../includes/db.php';
require __DIR__.'/../includes/auth.php';
require_login();
$user_id=$_SESSION['user_id'];
$stmt=$pdo->prepare('SELECT COUNT(*) FROM tarefas WHERE usuario_id=? AND concluida=0');
$stmt->execute([$user_id]);
$pendentes=$stmt->fetchColumn();
$stmt=$pdo->prepare('SELECT COUNT(*) FROM tarefas WHERE usuario_id=? AND concluida=1');
$stmt->execute([$user_id]);
$concluidas=$stmt->fetchColumn();
$stmt=$pdo->prepare('SELECT id,titulo,descricao,data_criacao FROM tarefas WHERE usuario_id=? AND concluida=0 ORDER BY data_criacao ASC');
$stmt->execute([$user_id]);
$lista=$stmt->fetchAll();
require __DIR__.'/../includes/header.php';
require __DIR__.'/../includes/nav.php';
?>
<div class="row">
<div class="col-md-6">
<h4>Resumo</h4>
<canvas id="chart"></canvas>
</div>
<div class="col-md-6">
<h4>Tarefas Pendentes</h4>
<a class="btn btn-success mb-2" href="add_task.php">Nova Tarefa</a>
<?php if(!$lista): ?><div class="alert alert-info">Nenhuma tarefa pendente</div><?php else: ?>
<ul class="list-group">
<?php foreach($lista as $t): ?>
<li class="list-group-item d-flex justify-content-between align-items-start">
<div class="ms-2 me-auto">
<div class="fw-bold"><?=htmlspecialchars($t['titulo'])?></div>
<small><?=htmlspecialchars($t['descricao'])?></small>
<br><small class="text-muted"><?=$t['data_criacao']?></small>
</div>
<div>
<form method="post" action="mark_complete.php" style="display:inline">
<input type="hidden" name="id" value="<?=$t['id']?>">
<button class="btn btn-sm btn-outline-success">Concluir</button>
</form>
<a class="btn btn-sm btn-outline-primary" href="edit_task.php?id=<?=$t['id']?>">Editar</a>
<form method="post" action="delete_task.php" style="display:inline" onsubmit="return confirm('Remover?')">
<input type="hidden" name="id" value="<?=$t['id']?>">
<button class="btn btn-sm btn-outline-danger">Remover</button>
</form>
</div>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
</div>
<script>
const data = {
labels: ['Pendentes','Concluídas'],
datasets: [{label:'Tarefas',data:[<?=json_encode($pendentes)?>,<?=json_encode($concluidas)?>],backgroundColor: ['#ff4d4d', '#4caf50']}]
};
window.addEventListener('DOMContentLoaded',()=>{const ctx=document.getElementById('chart').getContext('2d');new Chart(ctx,{type:'doughnut',data:data,options:{responsive:true}});});
</script>
<?php require __DIR__.'/../includes/footer.php'; ?>
