<!-- client-page.php -->
<?php require_once 'php_action/db_connect.php'; ?>
<?php require_once 'includes/header2.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
  body {
    background:rgb(233, 227, 248);
    font-family: 'Segoe UI', sans-serif;
  }
  .product-container {
    width: 23%;
    margin: 1%;
    float: left;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s;
  }
  .product-container:hover {
    transform: scale(1.02);
  }
  .product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
  .product-details {
    padding: 15px;
  }
  .add-cart-btn {
    background: #28a745;
    border: none;
    color: #fff;
    padding: 10px;
    width: 100%;
    border-radius: 0 0 15px 15px;
    transition: background 0.3s;
  }
  .add-cart-btn:hover {
    background: #218838;
  }
  .cart-btn {
    position: fixed;
    top: 20px;
    right: 30px;
    background: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 30px;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  .cart-btn:hover {
    background: #0056b3;
  }
</style>

<div class="container">
  <div class="row">
    <h2 class="text-center" style="margin-top: 30px;">Our Products</h2>
    <hr>
    <?php
    $sql = "SELECT * FROM product WHERE status = 1";
    $result = $connect->query($sql);

    while($row = $result->fetch_assoc()) {
      echo '<div class="product-container">';
      echo '<img src="'. $row['product_image'] .'" class="product-image" />';
      echo '<div class="product-details">';
      echo '<h4>' . $row['product_name'] . '</h4>';
      echo '<p><strong>KES:</strong> ' . $row['rate'] . '</p>';
      echo '<p><strong>Quantity:</strong> ' . $row['quantity'] . '</p>';
      echo '<button class="add-cart-btn" onclick="addToCart(' . $row['product_id'] . ')"><i class="fas fa-cart-plus"></i> Add to Cart</button>';
      echo '</div></div>';
    }
    ?>
  </div>
</div>
<script>
  function showToast(message) {
    const toast = document.getElementById('toast');
    const msg = document.getElementById('toast-message');
    msg.textContent = message;
    toast.style.display = 'block';
    
    setTimeout(() => {
      toast.style.display = 'none';
    }, 2500);
  }

  function addToCart(productId) {
    fetch('php_action/addToCart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(res => res.text())
    .then(data => {
      showToast(data);
    })
    .catch(error => {
      showToast('Error adding to cart.');
      console.error(error);
    });
  }
</script>


<div id="toast"
     style="position: fixed; bottom: 30px; right: 30px; background: #28a745; color: white;
            padding: 12px 20px; border-radius: 5px; display: none; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 9999;">
  <i class="fas fa-check-circle"></i> <span id="toast-message">Item added to cart!</span>
</div>
<script>
  function addToCart(productId) {
    fetch('addToCart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(res => res.text())
    .then(data => {
      // You can replace this with a toast/snackbar for better UX
      alert(data);
    })
    .catch(error => {
      alert('Error adding to cart');
      console.error(error);
    });
  }
</script>


<?php require_once 'includes/footer.php'; ?>
