<?php

    //start session
    session_start();

    require_once('./php/CreateDb.php');
    require_once('./php/component.php');

    // create instance of Createdb class

    $database = new CreateDb("Productdb", "Producttdb");

    if (isset($_POST['add'])) {
        // print_r($_POST['product_id']);
        if (isset($_SESSION['cart'])) {
            $item_array_id = array_column($_SESSION['cart'], "product_id");

            if (in_array($_POST['product_id'], $item_array_id)) {
                echo "<script>alert('This item already added in the cart!');</script>";
                echo "<script>window.location = 'index.php'</script>";
            } else {
                $count = count($_SESSION['cart']);
                $item_array = [
                    'product_id' => $_POST['product_id'],
                ];
                $_SESSION['cart'][$count] = $item_array;
//                print_r($_SESSION['cart']);
            }

        } else {
            $item_array = [
                'product_id' => $_POST['product_id'],
            ];

            //create new session variable
            $_SESSION['cart'][0] = $item_array;
//            print_r($_SESSION['cart']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>

  <link href="style.css" rel="stylesheet">
  <!--  Bootstrap CDN-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!--  Fontawesome CDN-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous"/>
</head>
<body>
<?php
    require_once("./php/header.php")
?>
<div class="container">
  <div class="row text-center py-5">
      <?php
          $result = $database->getData();
          while ($row = mysqli_fetch_assoc($result)) {
              component($row['product_name'], $row['product_price'], $row['product_image'], $row['id']);
          }

      ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"
          integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi"
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
          integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG"
          crossorigin="anonymous"></script>
</body>
</html>