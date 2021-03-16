<?php
session_start();

require_once("php/CreateDb.php");
require_once("php/component.php");

$db = new CreateDb("Productdb", "Producttdb");

if (isset($_POST['remove'])) {
  if ($_GET['action'] == 'remove') {
    foreach ($_SESSION['cart'] as $key => $value) {
      if ($value['product_id'] == $_GET['id']) {
        unset($_SESSION['cart'][$key]);
        echo "<script>alert('Product has been Removed!')</script>";
        echo "<script>window.location = 'cart.php'</script>";
      }
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>

  <link href="style.css" rel="stylesheet">
  <!--  Bootstrap CDN-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!--  Fontawesome CDN-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
</head>

<body class="bg-light">
  <?php
  require_once('php/header.php');
  ?>

  <div class="container-fluid">
    <div class="row px-5">
      <div class="col-md-7">
        <div class="shopping-cart">
          <h6>My Cart</h6>
          <hr>
          <?php
          $total = 0;
          if (isset($_SESSION['cart'])) {
            $product_id = array_column($_SESSION['cart'], 'product_id');
            $result = $db->getData();
            while ($row = mysqli_fetch_assoc($result)) {
              foreach ($product_id as $id) {
                if ($row['id'] == $id) {
                  cartElement($row['product_image'], $row['product_name'], $row['product_price'], $row['id']);
                  $total = $total + (int)$row['product_price'];
                }
              }
            }
          } else {
            echo "<h5>Cart is Empty!</h5>";
          }
          ?>
        </div>
      </div>
      <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
        <div class="pt-4">
          <h6>Price Details</h6>
          <hr>
          <div class="row price-details">
            <div class="col-md-6">
              <?php
              if (isset($_SESSION['cart'])) {
                $count = count($_SESSION['cart']);
                echo "<h6>Price ($count items)</h6>";
              } else {
                echo "<h6>Price (0 items)</h6>";
              }
              ?>
              <h6 class="pt-1">Delivery Changes</h6>
              <hr>
              <h6>Amount Payable</h6>
            </div>
            <div class="col-md-6">
              <h6>$
                <?php
                echo "$total";

                ?>
              </h6>
              <h6 class="text-success pt-1">FREE</h6>
              <hr>
              <h6>$
                <?php
                echo $total;
                ?>
              </h6>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>

</html>