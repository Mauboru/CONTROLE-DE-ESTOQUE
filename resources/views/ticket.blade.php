<html>

<head>
    <title>Ticket</title>
</head>

<body>
    <h3>Ticket de Produto</h3>
    <p>Produto: {{ $produto->nome }}</p>
    <p>Preço: R$ {{ $produto->valor_unitario }}</p>
    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" />
</body>

</html>
