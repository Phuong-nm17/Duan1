<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit();
}

$user_id = $_SESSION['id'];

// Lấy đơn hàng mới nhất
$order_sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($order_sql);
$stmt->execute([$user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
  echo "Không tìm thấy đơn hàng.";
  exit();
}

// Xử lý khi xác nhận đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $shipping_method = $_POST['shipping_method'];
  $payment_method = $_POST['payment_method'];
  $note = $_POST['note'];

  $update_sql = "UPDATE orders SET fullname = ?, email = ?, phone = ?, address = ?,  payment_method = ?, note = ? WHERE id = ?";
  $stmt = $conn->prepare($update_sql);
  $stmt->execute([$fullname, $email, $phone, $address, $payment_method, $note, $order['id']]);

  echo "<div style='text-align:center; margin-top:20px; font-size:20px; color:green;'>🎉 Đặt hàng thành công! Đang chuyển hướng...</div>";
  header("Refresh: 2; URL=index.php?act=home");
  exit();
}

// Lấy chi tiết sản phẩm trong đơn hàng
$details_sql = "SELECT od.*, p.title AS product_title, p.thumbnail, s.name AS size_name, c.name AS color_name 
                FROM order_details od
                JOIN product p ON od.product_id = p.id
                JOIN size s ON od.size_id = s.id
                JOIN color c ON od.color_id = c.id
                WHERE od.order_id = ?";
$stmt = $conn->prepare($details_sql);
$stmt->execute([$order['id']]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Order Confirmation</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
      padding: 30px;
    }

    .checkout-container {
      max-width: 800px;
      margin: auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    h2 {
      text-align: center;
      color: #28a745;
      margin-bottom: 20px;
    }

    fieldset {
      border: none;
      margin-bottom: 25px;
    }

    legend {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }

    label {
      display: block;
      margin: 8px 0 4px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table th,
    table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }

    table th {
      background-color: #f1f1f1;
    }

    .total {
      text-align: right;
      font-size: 18px;
      font-weight: bold;
      margin-top: 10px;
      color: #333;
    }

    .submit-btn {
      display: block;
      width: 100%;
      padding: 15px;
      background-color: #28a745;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #218838;
    }

    @media (max-width: 600px) {
      .checkout-container {
        padding: 20px;
      }

      table th,
      table td {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>

  <div class="checkout-container">
    <form action="" method="POST">
      <h2>ORDER CONFIRMATION</h2>

      <fieldset>
        <legend>1. Recipient Information</legend>
        <label>Full Name:</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($order['fullname']) ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($order['email']) ?>">

        <label>Phone Number:</label>
        <input type="tel" name="phone" value="<?= htmlspecialchars($order['phone']) ?>">

        <label>Shipping Address:</label>
        <textarea name="address"><?= htmlspecialchars($order['address']) ?></textarea>
      </fieldset>

      <fieldset>
        <legend>2. Shipping & Payment</legend>
        <label>Shipping Method:</label>
        <select name="shipping_method" required>
          <option value="normal">Standard Shipping (3-5 days)</option>
          <option value="fast">Express Shipping (1-2 days)</option>
        </select>

        <label>Payment Method:</label>
        <select name="payment_method" required>
          <option value="cod" <?= $order['payment_method'] === 'cod' ? 'selected' : '' ?>>Cash on Delivery (COD)</option>
          <option value="bank" <?= $order['payment_method'] === 'bank' ? 'selected' : '' ?>>Bank Transfer</option>
          <option value="momo" <?= $order['payment_method'] === 'momo' ? 'selected' : '' ?>>MoMo E-Wallet</option>
        </select>
      </fieldset>

      <fieldset>
        <legend>3. Order Note</legend>
        <textarea name="note" rows="3" placeholder="Any additional notes for your order..."></textarea>
      </fieldset>

      <fieldset>
        <legend>4. Cart Items</legend>
        <table>
          <thead>
            <tr>
              <th>Thumbnail</th>
              <th>Product</th>
              <th>Size</th>
              <th>Color</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total = 0;
            if (empty($order_items)) {
              echo '<tr><td colspan="7" style="color: red;">⚠️ No products found in this order.</td></tr>';
            } else {
              foreach ($order_items as $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                  <td><img src="<?= $item['thumbnail'] ?>" style="width: 50px;"></td>
                  <td><?= $item['product_title'] ?></td>
                  <td><?= $item['size_name'] ?></td>
                  <td><?= $item['color_name'] ?></td>
                  <td>$<?= number_format($item['price'], 0, ',', '.') ?></td>
                  <td><?= $item['quantity'] ?></td>
                  <td>$<?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach;
            }
            ?>
          </tbody>
        </table>
        <div class="total">Total:$<?= number_format($subtotal + 10, 2) ?></div>
      </fieldset>

      <button type="submit" name="confirm_order" class="submit-btn">Confirm Order</button>
    </form>
  </div>

</body>

</html>