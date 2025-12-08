<?php
header('Content-Type: application/json; charset=utf-8');
// warnings notices 
error_reporting(E_ERROR | E_PARSE);

$products = [];

try {

    $pdo = new PDO('mysql:host=localhost;dbname=simplepharmacy', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);

    $stmt = $pdo->query("SELECT * FROM stock ORDER BY id ASC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $products[] = [
            'id' => $row['id'] ?? null,
            'barcode' => $row['bar_code'] ?? null,
            'name' => $row['medicine_name'] ?? 'Produit inconnu',
            'company' => $row['company'] ?? 'none',
            'sellingPrice' => $row['selling_price'] ?? 0,
            'category' => $row['category'] ?? 'Autre',
            'remainingQuantity' => $row['remain_quantity'] ?? 0,
            'registeredDate' => $row['register_date'] ?? null,
        ];
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

echo json_encode($products);
exit;
