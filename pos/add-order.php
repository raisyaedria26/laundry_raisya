<?php
include '../config/config.php';

$queryServices = mysqli_query($config, "SELECT * FROM services");
$rowServices = mysqli_fetch_all($queryServices, MYSQLI_ASSOC);

$queryCustomers = mysqli_query($config, "SELECT * FROM customers");
$rowCustomers = mysqli_fetch_all($queryCustomers, MYSQLI_ASSOC);

$querytax = mysqli_query($config, "SELECT * FROM taxs WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
$rowtax = mysqli_fetch_assoc($querytax);
// query Product
// $queryProducts = mysqli_query($config, "SELECT s.name, p.* FROM products p LEFT JOIN categories c ON c.id = p.category_id");
// $fetchProducts = mysqli_fetch_all($queryProducts, MYSQLI_ASSOC);

if (isset($_GET['payment'])) {
    mysqli_begin_transaction($config);
    $data = json_decode(file_get_contents('php://input'), true);

    $cart = $data["cart"];

    $tax = $data['tax'];
    $orderAmount = $data['grandTotal'];
    $orderCode = $data['order_code'];
    $end_date = $data["end_date"];
    $customer_id = $data["customer_id"];
    $orderChange = $data["order_change"];
    $orderPay = $data["order_pay"];
    $orderStatus = 1;
    $subtotal = $data['subtotal'];

    try {
        $insertOrder = mysqli_query($config, "INSERT INTO trans_orders (order_code ,order_end_date, order_total, order_pay, order_change, order_tax, order_status, customer_id) VALUES ('$orderCode','$end_date','$orderAmount','$orderPay','$orderChange','$tax','$orderStatus', '$customer_id')");
        if (!$insertOrder) {
            throw new Exception("Insert failed to error to table orders", mysqli_error($config));
        }
        $idOrder = mysqli_insert_id($config);

        foreach ($cart as $v) {
            $service_id = $v['id'];
            $qty = $v['qty'];
            $order_price = $v['price'];
            $subtotal = $qty * $order_price;

            $insertOrderDetails = mysqli_query($config, "INSERT INTO trans_order_details (order_id, service_id, qty, price, subtotal) VALUES ('$idOrder', '$service_id', '$qty', '$order_price', '$subtotal')");
            if (!$insertOrderDetails) {
                throw new Exception("Insert failed to error table trans_orders", mysqli_error($config));
            }
        }
        mysqli_commit($config);
        $response = [
            'status' => 'success',
            'message' => 'transaction success',
            'order_id' => $idOrder,
            'order_code' => $orderCode,
        ];
        echo json_encode($response, 201);
        die;
    } catch (\Throwable $th) {
        mysqli_rollback($config);
        $respone = ['status' => 'error', 'massage' => $th->getMessage()];
        echo json_encode($respone);
        die;
    }
}

$orderNumbers = mysqli_query($config, "SELECT id FROM trans_orders ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($orderNumbers);
$nextId = $row ? $row['id'] + 1 : 1;
$order_code = "ODR-" . date('dmy') . str_pad($nextId, 4, "0", STR_PAD_LEFT);


// if ($row) {
//     $nexId = $row['id'] + 1;
// } else {
//     $nextId = 1;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point Of Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/css/aldo.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
</head>

<body>

    <!-- Container-fluid -->
    <div class="container-fluid container-pos">
        <div class="row h-100">
            <div class="col-md-7 product-section">
                <div class="card shadow-sm mb-3">
                    <div class="card-header">
                        Customer
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="" class="form-label">Customer Name</label>
                                <select name="customer_id" id="customer_id" class="form-control" onchange="selectCustomers()">
                                    <option value="">Select One</option>
                                    <?php foreach ($rowCustomers as $customer): ?>
                                        <option data-phone="<?php echo $customer['phone'] ?>" value="<?php echo $customer['id'] ?>"><?php echo $customer['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Phone Number" id="phone" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mb-3">
                    <div class="card-header">
                        Laundry Service
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <?php foreach ($rowServices as $service): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card service-card p-2" style="cursor:pointer;" onclick='openModal(<?php echo htmlspecialchars(json_encode($service)) ?>)' data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <h6><?php echo $service['name'] ?></h6>
                                        <small class="text-muted">Rp. <?php echo $service['price'] ?>/kg</small>
                                    </div><br>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="modal_id">
                                <input type="hidden" id="modal_price">
                                <input type="hidden" id="modal_type">

                                <div class="mb-3">
                                    <label for="" class="form-label">Service Name</label>
                                    <input type="text" id="modal_name" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Weight</label>
                                    <input type="number" id="modal_qty" class="form-control" placeholder="Weight" step="0,1" min="0">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 cart-section">
                <div class="cart-header">
                    <h4>cart</h4>
                    <small>Order # <span class="orderNumber"><?php echo $order_code ?></span></small>
                </div>
                <div class="cart-items" id="cartItems">
                    <div class="text-center text-muted mt-5">
                        <i class="bi bi-cart mb-3"></i>
                        <p>Cart Empty</p>
                    </div>
                </div>


                <div class="cart-footer">
                    <div class="total-section">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal :</span>
                            <span id="subtotal">Rp. 0.0</span>
                            <input type="hidden" id="subtotal_value">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak (<?php echo $rowtax['percent'] ?>%) :</span>
                            <span id="tax">Rp. 0.0</span>
                            <input type="hidden" id="tax_value">
                            <input type="hidden" class="tax" value="<?php echo $rowtax['percent'] ?>">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total :</span>
                            <span id="total">Rp. 0.0</span>
                            <input type="hidden" id="total_value">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pay :</span>
                            <input type="number" id="pay" class="form-control w-50" placeholder="Enter payment amount" oninput="calculateChange()">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Change :</span>
                            <input type="number" id="change" class="form-control w-50" readonly>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <button class="btn btn-clear-cart btn-outline-danger w-100" id="clearCart">
                                <i class="bi bi-trash"> Clear Cart</i>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-checkout btn-success w-100" onclick="processPayment()">
                                <i class="bi bi-cash"> Process Payment</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <!-- <script>
        // new bootstrap.Modal('#exampleModal').show();
    </script> -->

    <script src="../assets/js/raisya.js"></script>

</body>

</html>