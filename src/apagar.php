<?php
require 'conexao.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: listar.php?msg=Produto excluído com sucesso!");
            exit;
        } else {
            header("Location: listar.php?msg=Erro ao excluir produto.");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: listar.php?msg=Erro ao excluir produto: " . $e->getMessage());
        exit;
    }
} else {
    header("Location: listar.php?msg=ID inválido.");
    exit;
}
?>