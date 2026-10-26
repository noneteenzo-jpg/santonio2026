<?php
// Valores dos planos: altere aqui caso o preço seja atualizado.
$planos = [
    'basico' => ['nome' => 'Básico', 'preco' => 89.90, 'descricao' => 'Musculação'],
    'plus' => ['nome' => 'Plus', 'preco' => 129.90, 'descricao' => 'Musculação e aulas coletivas'],
    'premium' => ['nome' => 'Premium', 'preco' => 179.90, 'descricao' => 'Todas as modalidades']
];

function escapar($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
function dinheiro($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}
function voltarComErro($mensagem) {
    http_response_code(400);
    ?>
    <!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Verifique os dados | Kemel Fitness</title><link rel="stylesheet" href="style.css"></head>
    <body><header class="topbar"><a class="brand" href="index.html"><span class="brand-mark">K</span><span>KEMEL <strong>FITNESS</strong><small>MANAGER</small></span></a></header><main class="container result-container"><section class="result-card error-card"><div class="result-symbol">!</div><p class="eyebrow">NÃO FOI POSSÍVEL CONCLUIR</p><h1>Verifique os <span>dados.</span></h1><p><?= escapar($mensagem) ?></p><a class="button button-primary" href="cadastro.html">← Voltar ao formulário</a></section></main></body></html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro.html');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$idadeTexto = trim($_POST['idade'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$dataMatricula = trim($_POST['data_matricula'] ?? '');
$planoEscolhido = $_POST['plano'] ?? '';
$pagamento = $_POST['pagamento'] ?? '';

if ($nome === '' || $idadeTexto === '' || $telefone === '' || $email === '' || $dataMatricula === '' || $planoEscolhido === '' || $pagamento === '') {
    voltarComErro('Preencha todos os campos antes de continuar.');
}
if (mb_strlen($nome) < 3 || mb_strlen($nome) > 120 || !preg_match("/^[\p{L}\p{M} .'-]+$/u", $nome)) {
    voltarComErro('Informe um nome completo válido.');
}
if (!filter_var($idadeTexto, FILTER_VALIDATE_INT) || (int)$idadeTexto < 18 || (int)$idadeTexto > 120) {
    voltarComErro('A matrícula é permitida somente para pessoas com idade entre 18 e 120 anos.');
}
if (strlen($telefone) < 8 || strlen($telefone) > 20 || !preg_match('/^[0-9()+.\s-]+$/', $telefone)) {
    voltarComErro('Informe um telefone válido.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
    voltarComErro('Informe um endereço de e-mail válido.');
}
$dataObj = DateTime::createFromFormat('!Y-m-d', $dataMatricula);
$errosData = DateTime::getLastErrors();
if (!$dataObj || ($errosData !== false && ($errosData['warning_count'] > 0 || $errosData['error_count'] > 0)) || $dataObj->format('Y-m-d') !== $dataMatricula || $dataMatricula > date('Y-m-d')) {
    voltarComErro('Informe uma data de matrícula válida, que não seja futura.');
}
if (!array_key_exists($planoEscolhido, $planos)) {
    voltarComErro('Selecione um dos planos disponíveis.');
}
if (!in_array($pagamento, ['pix', 'cartao'], true)) {
    voltarComErro('Selecione uma forma de pagamento válida.');
}

$idade = (int)$idadeTexto;
$plano = $planos[$planoEscolhido];
$valorOriginal = $plano['preco'];
$percentual = 0;
$motivoDesconto = 'Sem desconto';

// Aplica somente o maior desconto, sem somar as condições.
if ($idade >= 60) {
    $percentual = 15;
    $motivoDesconto = 'Desconto para aluno com 60 anos ou mais';
} elseif ($pagamento === 'pix') {
    $percentual = 10;
    $motivoDesconto = 'Desconto para pagamento via PIX';
}
$valorDesconto = round($valorOriginal * ($percentual / 100), 2);
$valorFinal = round($valorOriginal - $valorDesconto, 2);
$pagamentoNome = $pagamento === 'pix' ? 'PIX' : 'Cartão';
$dataFormatada = $dataObj->format('d/m/Y');
$numeroComprovante = 'KFM-' . date('Ymd') . '-' . strtoupper(substr(hash('sha256', $nome . $email . $dataMatricula), 0, 6));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Comprovante de matrícula | Kemel Fitness</title><link rel="stylesheet" href="style.css"></head>
<body>
<header class="topbar"><a class="brand" href="index.html"><span class="brand-mark">K</span><span>KEMEL <strong>FITNESS</strong><small>MANAGER</small></span></a><span class="admin-tag"><span class="status-dot"></span> COMPROVANTE</span></header>
<main class="container result-container">
  <section class="result-card">
    <div class="success-icon">✓</div><p class="eyebrow">MATRÍCULA PROCESSADA</p><h1>Cadastro <span>concluído.</span></h1><p class="muted">Confira os dados e os valores calculados abaixo.</p>
    <div class="receipt-head"><div><span class="muted small">COMPROVANTE</span><strong><?= escapar($numeroComprovante) ?></strong></div><div class="receipt-status">Processado</div></div>
    <div class="receipt-section"><h2>Dados do aluno</h2><div class="receipt-grid"><div><span>Nome completo</span><strong><?= escapar($nome) ?></strong></div><div><span>Idade</span><strong><?= escapar($idade) ?> anos</strong></div><div><span>Telefone</span><strong><?= escapar($telefone) ?></strong></div><div><span>E-mail</span><strong><?= escapar($email) ?></strong></div><div><span>Data da matrícula</span><strong><?= escapar($dataFormatada) ?></strong></div></div></div>
    <div class="receipt-section"><h2>Plano e pagamento</h2><div class="receipt-grid"><div><span>Plano selecionado</span><strong><?= escapar($plano['nome']) ?></strong><small><?= escapar($plano['descricao']) ?></small></div><div><span>Forma de pagamento</span><strong><?= escapar($pagamentoNome) ?></strong></div></div></div>
    <div class="price-breakdown"><div><span>Valor original</span><strong><?= dinheiro($valorOriginal) ?></strong></div><div><span>Desconto aplicado (<?= $percentual ?>%)</span><strong class="discount-value">− <?= dinheiro($valorDesconto) ?></strong></div><p class="discount-reason"><?= escapar($motivoDesconto) ?><?= $idade >= 60 && $pagamento === 'pix' ? ' (maior desconto; não acumulado com o PIX)' : '' ?></p><div class="total-line"><span>VALOR FINAL</span><strong><?= dinheiro($valorFinal) ?></strong></div></div>
    <div class="notice"><span>ⓘ</span><p>Este comprovante é gerado para demonstração. Conforme o escopo do projeto, os dados não são gravados em banco de dados e não representam confirmação de pagamento real.</p></div>
    <div class="form-actions"><a class="button button-secondary" href="cadastro.html">＋ Nova matrícula</a><button class="button button-primary" type="button" onclick="window.print()">Imprimir comprovante ↗</button></div>
  </section>
  <a class="back-link centered-link" href="index.html">← Voltar ao painel administrativo</a>
</main>
<footer class="footer"><span>© 2026 Kemel Fitness Manager</span><span>Sistema interno de gestão de matrículas</span></footer>
</body></html>
