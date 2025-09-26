<?php
include 'cabecalho.php';

require 'conexao.php';

$msg = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <?php if ($msg): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($msg) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-list me-2"></i>Listagem de Produtos</h3>
            </div>
            <div class="card-body">
                <?php if (count($produtos) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">NOME</th>
                                    <th scope="col">PREÇO (R$)</th>
                                    <th scope="col">QUANTIDADE</th>
                                    <th scope="col">OPÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $produto): ?>
                                    <tr>
                                        <td><?= $produto['id'] ?></td>
                                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                        <td><?= $produto['quantidade'] ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="atualizar.php?id=<?= $produto['id'] ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit me-1"></i>Editar
                                                </a>
                                                <a href="apagar.php?id=<?= $produto['id'] ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                                    <i class="fas fa-trash me-1"></i>Excluir
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>Nenhum produto cadastrado ainda.
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer text-muted">
                <a href="form_cadastrar.php" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Adicionar Novo Produto
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include 'pontape.php';
?>