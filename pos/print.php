<?php
session_start();
include "../config/koneksi.php";
$query = mysqli_query($koneksi, "SELECT * FROM orders ORDER BY id DESC");
$row = mysqli_fetch_assoc($query);

$order_id = $row['id'];
$querrDetails = mysqli_query($koneksi, "SELECT p.product_name,od.* FROM order_details AS od LEFT JOIN products as p ON p.id = od.product_id WHERE order_id = '$order_id'");
$rowDetails = mysqli_fetch_all($querrDetails, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaraan</title>
    <style>
        body {
            width: 80mm;
            font-family: 'Courier New', Courier, monospace;
            margin: 0 auto;
            background-color: white;
        }

        .struck-page {
            width: 100%;
            font-size: 12px;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 16px;
        }

        .header h2 {
            font-size: 20px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
        }

        .info {
            margin: 10px 0;
            font-size: 11px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .separator {
            border-top: 1px dotted black;
        }

        .items {
            margin: 10px 0;
            font-size: 11px;
        }

        .item {
            display: flex;
            justify-content: space-between;
        }

        .item-name {
            flex: 1;
        }

        .item-qty {
            margin: 0 10px;
        }

        .item-price {
            text-align: right;
            min-width: 80px;
        }

        .totals {
            margin-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }

        .total-row.grand {
            font-weight: bold;
            font-size: 16px;
            margin: 10px 0;
        }

        .payment {
            margin-top: 10px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="struck-page">
        <div class="header">
            <h2>Struk Pembayaraan</h2>
            <p>Jl Benhil Karet Jakarta pusat</p>
            <p>08979377325</p>
        </div>
        <div class="separator"></div>
        <div class="info">
            <div class="info-row">
                <?php
                $date = date("d-m-y", strtotime($row['created_at']));
                $time = date("H:i:s", strtotime(($row['created_at'])));
                ?>
                <span><?= $date ?></span>
                <span><?= $time ?></span>
            </div>
            <div class="info-row">
                <span>Transaction</span>
                <span><?= $row['order_code'] ?></span>
            </div>
            <div class="info-row">
                <span>Casher Name</span>
                <span><?= $_SESSION['NAME'] ?></span>
            </div>
        </div>
        <div class="separator"></div>
        <div class="items">
            <?php foreach ($rowDetails as $item): ?>
                <div class="item">
                    <span class="item-name"><?= $item['product_name'] ?></span>
                    <span class="item-qty"><?= $item['qty'] ?></span>
                    <span class="item-price">Rp<?= number_format($item['order_price']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="separator"></div>
        <div class="totals">
            <div class="total-row ">
                <span>Subtotal</span>
                <span>Rp.10.000</span>
            </div>
            <div class="total-row">
                <span>Ppn(include)</span>
                <span></span>
            </div>
        </div>
        <div class="separator"></div>
        <div class="payment">
            <div class="total-row grand">
                <span>Total</span>
                <span>Rp.<?= number_format($row['order_amount'])  ?></span>
            </div>
            <!-- <div class="total-row">
        <span>Cash</span>
        <span>Rp.100.000</span>
      </div>
      <div class="total-row">
        <span>Cahnge</span>
        <span>Rp.50.000</span>
      </div> -->
        </div>
        <div class="separator"></div>
    </div>

</body>

</html>