<?php
require_once 'php_action/db_connect.php';
require_once 'includes/header.php';

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['action'])) {
    $order_id = (int)$_POST['order_id'];
    $action = $_POST['action'];

    if ($action === 'accept') {
        $connect->query("UPDATE orders2 SET status = 'completed' WHERE id = $order_id");
    } elseif ($action === 'reject') {
        $connect->query("UPDATE orders2 SET status = 'rejected' WHERE id = $order_id");
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
  body {
    background: rgb(96, 171, 214);
    font-family: 'Segoe UI', sans-serif;
  }
  .navbar-default {
    background-color: #245580 !important;
    color: white;
  }
  .navbar-default .navbar-brand,
  .navbar-default .navbar-nav > li > a {
    color: white !important;
  }
  .orders-container {
    max-width: 1000px;
    margin: 50px auto;
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  .orders-title {
    text-align: center;
    margin-bottom: 30px;
    color: #245580;
  }
  .action-btn {
    margin: 5px 0;
    border-radius: 20px;
    padding: 6px 12px;
    font-size: 14px;
    transition: 0.3s;
  }
  .accept-btn {
    background-color: #28a745;
    color: white;
  }
  .accept-btn:hover {
    background-color: #218838;
  }
  .reject-btn {
    background-color: #dc3545;
    color: white;
  }
  .reject-btn:hover {
    background-color: #c82333;
  }
  .status-label {
    font-weight: bold;
    padding: 5px 12px;
    border-radius: 20px;
  }
  .label-completed {
    background-color: #28a745;
    color: white;
  }
  .label-rejected {
    background-color: #dc3545;
    color: white;
  }
  .table thead {
    background-color: #245580;
    color: white;
  }
</style>
<div class="orders-container">
  <h2 class="orders-title"><i class="fas fa-box-open"></i> Customer Orders</h2>

  <table class="table table-bordered table-hover">
    <thead class="bg-primary text-white">
      <tr>
        <th>#</th>
        <th>Client Name</th>
        <th>Contact</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Total</th>
        <th>Status / Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM orders2 ORDER BY id DESC";
      $result = $connect->query($sql);
      $count = 1;

      while ($row = $result->fetch_assoc()) {
          echo "<tr>
                <td>{$count}</td>
                <td>{$row['name']}</td>
                <td>
                  <i class='fas fa-phone-alt'></i> {$row['phone']}<br>
                  <i class='fas fa-envelope'></i> {$row['email']}<br>
                  <i class='fas fa-map-marker-alt'></i> {$row['address']}
                </td>
                <td>{$row['product']}</td>
                <td>{$row['quantity']}</td>
                <td>KES " . number_format($row['rate'], 2) . "</td>
                <td><strong>KES " . number_format($row['total'], 2) . "</strong></td>
                <td>";

          // If status is empty, show buttons
          if ($row['status'] === '' || $row['status'] === null) {
              echo "<form method='POST' style='display:inline-block;'>
                      <input type='hidden' name='order_id' value='{$row['id']}'>
                      <input type='hidden' name='action' value='accept'>
                      <button type='submit' class='btn accept-btn action-btn'><i class='fas fa-check'></i> Accept</button>
                    </form>
                    <form method='POST' style='display:inline-block;'>
                      <input type='hidden' name='order_id' value='{$row['id']}'>
                      <input type='hidden' name='action' value='reject'>
                      <button type='submit' class='btn reject-btn action-btn'><i class='fas fa-times'></i> Reject</button>
                    </form>";
          } else {
              $status = $row['status'];
              $labelClass = $status === 'completed' ? 'label-completed' : ($status === 'rejected' ? 'label-rejected' : 'label-pending');
              echo "<span class='status-label $labelClass'>" . ucfirst($status) . "</span>";
          }

          echo "</td></tr>";
          $count++;
      }
      ?>
    </tbody>
  </table>
</div>

<?php require_once 'includes/footer.php'; ?>
