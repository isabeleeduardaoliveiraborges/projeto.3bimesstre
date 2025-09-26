<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = $_GET['id'];

require 'conexao.php';

$tableExists = $pdo->query("SHOW TABLES LIKE 'produtos'")->rowCount() > 0;

if (!$tableExists) {
    header('Location: listar.php');
    exit;
}

$sql = "SELECT * FROM produtos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header('Location: listar.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $quantidade = $_POST['quantidade'] ?? 0;
    
    $sqlUpdate = "UPDATE produtos SET nome = :nome, preco = :preco, quantidade = :quantidade WHERE id = :id";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':nome', $nome);
    $stmtUpdate->bindParam(':preco', $preco);
    $stmtUpdate->bindParam(':quantidade', $quantidade);
    $stmtUpdate->bindParam(':id', $id);
    
    if ($stmtUpdate->execute()) {
        header('Location: listar.php?msg=Produto atualizado com sucesso!');
        exit;
    } else {
        $erro = "Erro ao atualizar produto.";
    }
}

include 'cabecalho.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Produto</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preço (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" value="<?php echo $produto['preco']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantidade em Estoque</label>
                        <input type="number" name="quantidade" class="form-control" value="<?php echo $produto['quantidade']; ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Atualizar Produto
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                <a href="listar.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Voltar para a lista
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>