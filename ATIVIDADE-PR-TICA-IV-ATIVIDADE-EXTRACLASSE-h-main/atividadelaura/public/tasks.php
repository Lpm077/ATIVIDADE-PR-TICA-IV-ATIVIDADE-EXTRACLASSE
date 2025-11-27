<?php
require __DIR__.'/../includes/db.php';
require __DIR__.'/../includes/auth.php';
require_login();
$user_id=$_SESSION['user_id'];
$q=trim($_GET['q'] ?? '');
$status = isset($_GET['status']) ? ($_GET['status']==='1' ? 1 : 0) : null;
if($q!==''){
    $stmt=$pdo->prepare('SELECT id,titulo,descricao,concluida,data_criacao FROM tarefas WHERE usuario_id=? AND (titulo LIKE CONCAT("%",?,"%") OR descricao LIKE CONCAT("%",?,"%")) ORDER BY data_criacao DESC');
    $stmt->execute([$user_id,$q,$q]);
} elseif(isset($_GET['status'])) {
    $stmt=$pdo->prepare('SELECT id,titulo,descricao,concluida,data_criacao FROM tarefas WHERE usuario_id=? AND concluida=? ORDER BY data_criacao DESC');
    $stmt->execute([$user_id,$status]);
} else {
    $stmt=$pdo->prepare('SELECT id,titulo,descricao,concluida,data_criacao FROM tarefas WHERE usuario_id=? ORDER BY data_criacao DESC');
    $stmt->execute([$user_id]);
}
$lista=$stmt->fetchAll();
require __DIR__.'/../includes/header.php';
require __DIR__.'/../includes/nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
<h3>Todas as Tarefas</h3>
<div>
<form class="d-flex" method="get">
<input name="q" class="form-control me-2" placeholder="Buscar" value="<?=htmlspecialchars($q)?>">
<select name="status" class="form-select me-2">
<option value="">Todos</option>
<option value="0" <?=(isset($_GET['status']) && $_GET['status']==='0')?'selected':''?>>Pendentes</option>
<option value="1" <?=(isset($_GET['status']) && $_GET['status']==='1')?'selected':''?>>Concluídas</option>
</select>
<button class="btn btn-outline-secondary">Filtrar</button>
</form>
</div>
</div>
<a class="btn btn-success mb-3" href="add_task.php">Nova Tarefa</a>
<?php if(!$lista): ?><div class="alert alert-info">Nenhuma tarefa encontrada</div><?php else: ?>
<table class="table table-striped">
<thead><tr><th>Título</th><th>Descrição</th><th>Status</th><th>Data</th><th>Ações</th></tr></thead>
<tbody>
<?php foreach($lista as $t): ?>
<tr>
<td><?=htmlspecialchars($t['titulo'])?></td>
<td><?=htmlspecialchars($t['descricao'])?></td>
<td><?= $t['concluida'] ? 'Concluída' : 'Pendente' ?></td>
<td><?=$t['data_criacao']?></td>
<td>
<form method="post" action="mark_complete.php" style="display:inline">
<input type="hidden" name="id" value="<?=$t['id']?>">
<button class="btn btn-sm btn-outline-success">Concluir</button>
</form>
<a class="btn btn-sm btn-outline-primary" href="edit_task.php?id=<?=$t['id']?>">Editar</a>
<form method="post" action="delete_task.php" style="display:inline" onsubmit="return confirm('Remover?')">
<input type="hidden" name="id" value="<?=$t['id']?>">
<button class="btn btn-sm btn-outline-danger">Remover</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
<?php require __DIR__.'/../includes/footer.php'; ?>