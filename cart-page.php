<?php
require_once 'php_action/db_connect.php';
require_once 'includes/header2.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
  body {
    background:rgb(248, 247, 247);
    font-family: 'Segoe UI', sans-serif;
  }
  .cart-container {
    max-width: 900px;
    margin: 50px auto;
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  .cart-title {
    text-align: center;
    margin-bottom: 30px;
  }
  .cart-table th, .cart-table td {
    text-align: center;
    vertical-align: middle !important;
  }
  .checkout-btn, .pay-btn {
    background: #28a745;
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 25px;
    margin: 10px 10px 0 0;
    transition: 0.3s ease;
  }
  .checkout-btn:hover, .pay-btn:hover {
    background: #218838;
  }
  .remove-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 5px;
    transition: 0.3s;
  }
  .remove-btn:hover {
    background: #c82333;
  }
</style>

<script>
  function openPaymentTab(price) {
    window.open('checkout.php?price=' + price, '_blank');
  }
</script>

<div class="cart-container">
  <h2 class="cart-title"><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h2>
  <?php
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo '<p class="text-center">Your cart is empty. <a href="client.php">Continue Shopping</a></p>';
  } else {
    echo '<table class="table table-bordered cart-table">';
    echo '<thead><tr><th>Image</th><th>Product</th><th>Rate</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead><tbody>';
    
    $grandTotal = 0;

    foreach ($_SESSION['cart'] as $id => $qty) {
      $sql = "SELECT * FROM product WHERE product_id = $id";
      $result = $connect->query($sql);
      if ($row = $result->fetch_assoc()) {
        $total = $row['rate'] * $qty;
        $grandTotal += $total;
        echo '<tr>';
        echo '<td><img src="' . $row['product_image'] . '" width="80" style="border-radius:10px;"></td>';
        echo '<td>' . $row['product_name'] . '</td>';
        echo '<td>KES ' . number_format($row['rate'], 2) . '</td>';
        echo '<td>' . $qty . '</td>';
        echo '<td><strong>KES ' . number_format($total, 2) . '</strong></td>';
        echo '<td>
                <form method="POST" action="php_action/removeFromCart.php" style="display:inline;">
                  <input type="hidden" name="product_id" value="' . $id . '">
                  <button type="submit" class="remove-btn"><i class="fas fa-trash"></i></button>
                </form>
              </td>';
        echo '</tr>';
      }
    }

    echo '</tbody></table>';
    echo '<h4 class="text-right">Grand Total: <strong>KES ' . number_format($grandTotal, 2) . '</strong></h4>';
    echo '
      <div class="text-right">
        <button type="button" class="checkout-btn" data-toggle="modal" data-target="#checkoutModal"><i class="fas fa-credit-card"></i> Checkout</button>
        <button type="button" onclick="openPaymentTab(' . $grandTotal . ')" class="pay-btn"><i class="fas fa-money-bill-wave"></i> Pay Order</button>
      </div>';
  }
  ?>
</div>

<!-- Modal Popup for Checkout -->
<div id="checkoutModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form method="POST" action="php_action/checkout.php">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-user"></i> Enter Your Details</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" required class="form-control" placeholder="John Doe">
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" required class="form-control" placeholder="123 Main St">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required class="form-control" placeholder="example@email.com">
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" required class="form-control" placeholder="0700000000">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Submit & Checkout</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Required JS for Bootstrap Modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>


<?php require_once 'includes/footer.php'; ?>

