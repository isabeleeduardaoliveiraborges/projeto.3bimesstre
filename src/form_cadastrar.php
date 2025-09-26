<?php
require 'conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $quantidade = $_POST['quantidade'] ?? 0;

    $sql = "INSERT INTO produtos (nome, preco, quantidade) VALUES (:nome, :preco, :quantidade)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':quantidade', $quantidade);

    if ($stmt->execute()) {
        header("Location: listar.php?msg=Produto inserido com sucesso!");
        exit;
    } else {
        $erro = "Erro ao inserir produto.";
    }
}

include 'cabecalho.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-plus-circle me-2"></i>Cadastrar Novo Produto</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" placeholder="Digite o nome do produto" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preço (R$)</label>
                        <input type="number" step="0.01" min="0" name="preco" class="form-control" placeholder="Digite o preço" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantidade em Estoque</label>
                        <input type="number" name="quantidade" min="0" class="form-control" placeholder="Digite a quantidade" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Cadastrar Produto
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