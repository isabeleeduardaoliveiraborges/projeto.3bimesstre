<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['produto'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    $sql = "INSERT INTO produtos (nome, preco, quantidade) VALUES (:nome, :preco, :quantidade)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':quantidade', $estoque);

    if ($stmt->execute()) {
        header("Location: listar.php?msg=Produto inserido com sucesso!");
        exit;
    } else {
        header("Location: form_cadastrar.php?msg=Erro ao inserir produto.");
        exit;
    }
}
?>
[file content end]