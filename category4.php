<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="productpopup.css">

   <!-- custom js file link  -->
   <script src="productpopup.js" defer></script>
   

</head>
<body>

<div>
   
<div class="container">

   <h3 class="title">  Packaged Food </h3>

   <div class="products-container">
     
    
     <div class="product" data-name="p-31">
        <img src="project_images/Good day.jpg" alt="">
        <h3>Britannia Good Day Cashew Cookies</h3>
     </div>
     <div class="product" data-name="p-32">
        <img src="project_images/Dark fantasy.jpg" alt="">
        <h3>Sunfeast Dark Fantasy Yumfills Cake</h3>
     </div>
     <div class="product" data-name="p-33">
        <img src="project_images/Moms magic.jpg" alt="">
        <h3>Sunfeast Mom's Magic Cashew & Almond</h3>
     </div>
     <div class="product" data-name="p-34">
        <img src="project_images/Marie Gold.jpg" alt="">
        <h3>Britannia Marie Gold Biscuits</h3>
     </div>
     <div class="product" data-name="p-35">
        <img src="project_images/Oreo.jpg" alt="">
        <h3>Cadbury Oreo Vanilla Flavour Crème Sandwich Biscuit</h3>
     </div>
     
   </div>
</div>
</div>

<div class="products-preview">

   
      
  
   <div class="preview" data-target="p-31">
      <i class="fas fa-times"></i>
      <img src="project_images/Good day.jpg" alt="">
      <h3>Britannia Good Day Cashew Cookies</h3>
      <p>Perfect combination of crunch and flavor with made with premium ingredients, gooday cookies are the ideal snack for any time of day.</p>
      <div class="price" style="font-size:medium;">
         <form action="" method="post">
            <input type="submit" name="compare"  value="Compare">
         </form>
         <?php 

         $db_name = "mysql:host=localhost;dbname=myshop";
         $username = "root";
         $password = "";
         
         $conn_shop = new PDO($db_name, $username, $password);
         
         if(isset($_POST['compare'])){

            $category = "Packaged Food";
            $product = "Britannia Good Day Cashew Cookies";
            $compare_price = $conn_shop->prepare("SELECT Shop, MIN(Price) as min_price FROM `products` WHERE Product = ? GROUP BY Shop LIMIT 1;");
            $compare_price->execute([$product]);
            if($compare_price->rowCount() > 0){
               while($fetch_price = $compare_price->fetch(PDO::FETCH_ASSOC)){ 
         ?>
         <p>Best Price : <?= $fetch_price['min_price'] ?> from <?= $fetch_price['Shop'] ?></p>
               
         <?php 
               }
            }
         }
         ?>

      </div>

      <div class="buttons">
      <a href="https://www.dmart.in/product/britannia-good-day-cashew-cookies?selectedProd=46536" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40083744" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Britannia-Good-Cashew-Combi-600g/dp/B01M1RKTRK" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-32">
      <i class="fas fa-times"></i>
      <img src="project_images/Dark fantasy.jpg" alt="">
      <h3>Sunfeast Dark Fantasy Yumfills Cake</h3>
      <p>Indulge in decadent bliss with Dark Fantasy Yumfills cookies. With a rich, chocolatey and a luscious, creamy filling, each bite is an exquisite delight.</p>
      <div class="price" style="font-size:medium;">
         <form action="" method="post">
            <input type="submit" name="compare"  value="Compare">
         </form>
         <?php 

         $db_name = "mysql:host=localhost;dbname=myshop";
         $username = "root";
         $password = "";
         
         $conn_shop = new PDO($db_name, $username, $password);
         
         if(isset($_POST['compare'])){

            $category = "Packaged Food";
            $product = "Sunfeast Dark Fantasy Yumfills Cake";
            $compare_price = $conn_shop->prepare("SELECT Shop, MIN(Price) as min_price FROM `products` WHERE Product = ? GROUP BY Shop LIMIT 1;");
            $compare_price->execute([$product]);
            if($compare_price->rowCount() > 0){
               while($fetch_price = $compare_price->fetch(PDO::FETCH_ASSOC)){ 
         ?>
         <p>Best Price : <?= $fetch_price['min_price'] ?> from <?= $fetch_price['Shop'] ?></p>
               
         <?php 
               }
            }
         }
         ?>

      </div>
      <div class="buttons">
      <a href="https://www.dmart.in/product/sunfeast-dark-fantasy-yumfills-cake-pcookiessfst12xx18718?selectedProd=342501" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40110218" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Sunfeast-Yumfills-Whoopie-Chocolate-Chip/dp/B06WGM2HK2" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-33">
      <i class="fas fa-times"></i>
      <img src="project_images/Moms magic.jpg" alt="">
      <h3>Sunfeast Mom's Magic Cashew & Almond</h3>
      <p>Rediscover the comforting taste of home with Mom's Magic cookies. Baked with love</p>
      <div class="price" style="font-size:medium;">
         <form action="" method="post">
            <input type="submit" name="compare"  value="Compare">
         </form>
         <?php 

         $db_name = "mysql:host=localhost;dbname=myshop";
         $username = "root";
         $password = "";
         
         $conn_shop = new PDO($db_name, $username, $password);
         
         if(isset($_POST['compare'])){

            $category = "Packaged Food";
            $product = "Sunfeast Mom's Magic Cashew & Almond";
            $compare_price = $conn_shop->prepare("SELECT Shop, MIN(Price) as min_price FROM `products` WHERE Product = ? GROUP BY Shop LIMIT 1;");
            $compare_price->execute([$product]);
            if($compare_price->rowCount() > 0){
               while($fetch_price = $compare_price->fetch(PDO::FETCH_ASSOC)){ 
         ?>
         <p>Best Price : <?= $fetch_price['min_price'] ?> from <?= $fetch_price['Shop'] ?></p>
               
         <?php 
               }
            }
         }
         ?>

      </div>
      <div class="buttons">
      <a href="https://www.dmart.in/product/sunfeast-moms-magic-cashew-&-almond-cookies?selectedProd=410001" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40158266" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Sunfeast-Moms-Magic-Cashew-Almond/dp/B07Q8T3G6M" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <var> <div class="preview" data-target="p-34">
      <i class="fas fa-times"></i>
      <img src="project_images/Marie Gold.jpg" alt="">
      <h3>Britannia Marie Gold Biscuits</h3>
      <p>Crisp, light, and subtly sweet, britania marigold biscuits are perfect for any occasion.</p>
      <div class="price" style="font-size:medium;">
         <form action="" method="post">
            <input type="submit" name="compare"  value="Compare">
         </form>
         <?php 

         $db_name = "mysql:host=localhost;dbname=myshop";
         $username = "root";
         $password = "";
         
         $conn_shop = new PDO($db_name, $username, $password);
         
         if(isset($_POST['compare'])){

            $category = "Packaged Food";
            $product = "Britannia Marie Gold Biscuits";
            $compare_price = $conn_shop->prepare("SELECT Shop, MIN(Price) as min_price FROM `products` WHERE Product = ? GROUP BY Shop LIMIT 1;");
            $compare_price->execute([$product]);
            if($compare_price->rowCount() > 0){
               while($fetch_price = $compare_price->fetch(PDO::FETCH_ASSOC)){ 
         ?>
         <p>Best Price : <?= $fetch_price['min_price'] ?> from <?= $fetch_price['Shop'] ?></p>
               
         <?php 
               }
            }
         }
         ?>

      </div>
      <div class="buttons">
      <a href="https://www.dmart.in/product/britannia-marie-gold-biscuit-pbiscuits0brit3xx30519?selectedProd=512502" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40197801" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Britannia-Marie-Gold-Biscuits-1Kg/dp/B07THCVLDY" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-35">
      <i class="fas fa-times"></i>
      <img src="project_images/Oreo.jpg" alt="">
      <h3>Cadbury Oreo Vanilla Flavour Crème Sandwich Biscuit</h3>
      <p>Experience the iconic combination of crunchy chocolate cookies and smooth vanilla cream with Oreo.</p>
      <div class="price" style="font-size:medium;">
         <form action="" method="post">
            <input type="submit" name="compare"  value="Compare">
         </form>
         <?php 

         $db_name = "mysql:host=localhost;dbname=myshop";
         $username = "root";
         $password = "";
         
         $conn_shop = new PDO($db_name, $username, $password);
         
         if(isset($_POST['compare'])){

            $category = "Packaged Food";
            $product = "Cadbury Oreo Vanilla Flavour Crème Sandwich Biscuit";
            $compare_price = $conn_shop->prepare("SELECT Shop, MIN(Price) as min_price FROM `products` WHERE Product = ? GROUP BY Shop LIMIT 1;");
            $compare_price->execute([$product]);
            if($compare_price->rowCount() > 0){
               while($fetch_price = $compare_price->fetch(PDO::FETCH_ASSOC)){ 
         ?>
         <p>Best Price : <?= $fetch_price['min_price'] ?> from <?= $fetch_price['Shop'] ?></p>
               
         <?php 
               }
            }
         }
         ?>

      </div>
      <div class="buttons">
      <a href="https://www.dmart.in/product/cadbury-oreo-chocolate-sandwich-biscuits-pcreambiscuitscdbr2xx90318?selectedProd=257502" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40122466" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Cadbury-Original-Chocolatey-Sandwich-Biscuit/dp/B07B24KS8S" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>

   

</div>

</body>
</html>

</head>
<body>
   

<?php include 'header.php'; ?>
<section class="products">

   <h1 class="title">products categories</h1>

   <div class="box-container">

   <?php
      $category_name = $_GET['category'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
      $select_products->execute([$category_name]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products available!</p>';
      }
   ?>
   

   </div>

</section>







<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>