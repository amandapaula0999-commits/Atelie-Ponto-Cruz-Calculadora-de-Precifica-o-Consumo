<?php
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root";
$pass = ""; // No XAMPP o padrão é senha vazia
$db   = "atelie_bordado";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]);
    exit;
}

$acao = $_GET['acao'] ?? '';
$dados = json_decode(file_get_contents("php://input"), true);

if ($acao === 'listar') {
    $resOrc = $conn->query("SELECT * FROM orcamentos ORDER BY id DESC");
    $orcamentos = $resOrc->fetch_all(MYSQLI_ASSOC);

    $resPreco = $conn->query("SELECT * FROM configuracoes_precos WHERE id = 1");
    $precos = $resPreco->fetch_assoc();

    echo json_encode(["orcamentos" => $orcamentos, "precos" => $precos]);
}

elseif ($acao === 'salvar_orcamento' && $dados) {
    $stmt = $conn->prepare("INSERT INTO orcamentos 
        (nome_peca, etamine_largura, etamine_altura, acabamento_largura, acabamento_altura, qtd_cores, qtd_chaveiros, metros_linha, ml_cola, custo_materiais, preco_final) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sddddiidddd",
        $dados['nome_peca'],
        $dados['etamine_largura'],
        $dados['etamine_altura'],
        $dados['acabamento_largura'],
        $dados['acabamento_altura'],
        $dados['qtd_cores'],
        $dados['qtd_chaveiros'],
        $dados['metros_linha'],
        $dados['ml_cola'],
        $dados['custo_materiais'],
        $dados['preco_final']
    );
    $stmt->execute();
    echo json_encode(["sucesso" => true, "id" => $stmt->insert_id]);
}

elseif ($acao === 'salvar_precos' && $dados) {
    $stmt = $conn->prepare("UPDATE configuracoes_precos SET 
        preco_meada = ?, preco_cola = ?, preco_etamine = ?, preco_acabamento = ?, preco_pacote_chaveiro = ? 
        WHERE id = 1");
    
    $stmt->bind_param("ddddd",
        $dados['preco_meada'],
        $dados['preco_cola'],
        $dados['preco_etamine'],
        $dados['preco_acabamento'],
        $dados['preco_pacote_chaveiro']
    );
    $stmt->execute();
    echo json_encode(["sucesso" => true]);
}

elseif ($acao === 'excluir' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM orcamentos WHERE id = $id");
    echo json_encode(["sucesso" => true]);
}

$conn->close();
?>