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

   
<div class="container">

   <h3 class="title">Beverages </h3>

   <div class="products-container">

      <!-- <div class="product" data-name="p-1">
         <img src="project_images/Pomegranate.jpg" alt="">
         <h3>Fresh Pomogranate</h3>
         <div class="price">$2.00</div>
      </div>
      <div class="product" data-name="p-2">
         <img src="watermelon.jpg" alt="">
         <h3>Fresh Watermelon</h3>
         <div class="price">$2.00</div>
      </div>
      <div class="product" data-name="p-3">
         <img src="kiwi.jpg" alt="">
         <h3>Fresh kiwi</h3>
         <div class="price">$2.00</div>
      </div>

      <div class="product" data-name="p-4">
         <img src="Apple.jpg" alt="">
         <h3>Apple Royal Gala</h3>
         <div class="price">$2.00</div>
      </div>

      <div class="product" data-name="p-5">
         <img src="Grapes.jpg" alt="">
         <h3>Fresh Grapes</h3>
         <div class="price">$2.00</div>
      </div>

      <div class="product" data-name="p-6">
         <img src="Onion.jpg" alt="">
         <h3>Fresh Onion</h3>
         <div class="price">$2.00</div>
      </div>
      <div class="product" data-name="p-7">
        <img src="Potato.jpg" alt="">
        <h3>Fresh Potato</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-8">
      <img src="Tomato.jpg" alt="">
      <h3>Fresh Tomato</h3>
      <div class="price">$2.00</div>
   </div>
     
     <div class="product" data-name="p-9">
        <img src="Ginger.jpg" alt="">
        <h3>Ginger</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-10">
        <img src="garlic.jpg" alt="">
        <h3>Garlic</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-11">
        <img src="Lemon.jpg" alt="">
        <h3>Fresh Lemon</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-12">
        <img src="Coconut.jpg" alt="">
        <h3>Coconut</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-13">
        <img src="Green Chilli.jpg" alt="">
        <h3>Fresh Green Chilli</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-14">
        <img src="Cucumber.jpg" alt="">
        <h3>Fresh Cucumber White</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-15">
        <img src="Beetroot.jpg" alt="">
        <h3>Fresh Beetroot</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-16">
        <img src="Coriander.jpg" alt="">
        <h3>Fresh Coriander</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-17">
        <img src="Lady Finger.jpg" alt="">
        <h3>Fresh Lady Finger</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-18">
        <img src="Capsicum.jpg" alt="">
        <h3>Fresh Capsicum Green</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-19">
        <img src="Cabbage.jpg" alt="">
        <h3>Cabbage</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-20">
        <img src="Bitter Gourd.jpg" alt="">
        <h3>Bitter Gourd</h3>
        <div class="price">$2.00</div>
     </div> -->
     <div class="product" data-name="p-21">
        <img src="project_images/Thums Up.jpg" alt="">
        <h3>Thums Up</h3>
     </div>
     <div class="product" data-name="p-22">
        <img src="project_images/coca-cola.jpg" alt="">
        <h3>Coca-Cola</h3>
     </div>
     <div class="product" data-name="p-23">
        <img src="project_images/maza.jpg" alt="">
        <h3>Maaza Mango Drink</h3>
     </div>
     <div class="product" data-name="p-24">
        <img src="project_images/sprite.jpg" alt="">
        <h3>Sprite</h3>
     </div>
     <div class="product" data-name="p-25">
        <img src="project_images/society.jpg" alt="">
        <h3>Society Tea</h3>
     </div>
     <div class="product" data-name="p-26">
        <img src="project_images/Wagh Bakri.jpg" alt="">
        <h3>Wagh Bakri Premium Leaf Tea Pouch</h3>
     </div>
     <div class="product" data-name="p-27">
        <img src="project_images/Red label.jpg" alt="">
        <h3>Brooke Bond Red Label Natural Care Tea</h3>
     </div>
     <div class="product" data-name="p-28">
        <img src="project_images/Taj mahal.jpg" alt="">
        <h3>Taj Mahal Tea</h3>
     </div>
     <div class="product" data-name="p-29">
        <img src="project_images/Bru instant.jpg" alt="">
        <h3>Bru Instant Coffee</h3>
     </div>
     <div class="product" data-name="p-30">
        <img src="project_images/Nescafe.jpg" alt="">
        <h3>Nescafé Classic Coffee</h3>
     </div>
     <!-- <div class="product" data-name="p-25">
        <img src="society.jpg" alt="">
        <h3>Society Tea</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-26">
        <img src="Wagh Bakri.jpg" alt="">
        <h3>Wagh Bakri Premium Leaf Tea Pouch</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-27">
        <img src="Red label.jpg" alt="">
        <h3>Brooke Bond Red Label Natural Care Tea</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-28">
        <img src="Taj mahal.jpg" alt="">
        <h3>Taj Mahal Tea</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-29">
        <img src="Bru instant.jpg" alt="">
        <h3>Bru Instant Coffee</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-30">
        <img src="Nescafe.jpg" alt="">
        <h3>Nescafé Classic Coffee</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-31">
        <img src="Good day.jpg" alt="">
        <h3>Britannia Good Day Cashew Cookies</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-32">
        <img src="Dark fantasy.jpg" alt="">
        <h3>Sunfeast Dark Fantasy Yumfills Cake</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-33">
        <img src="Moms magic.jpg" alt="">
        <h3>Sunfeast Mom's Magic Cashew & Almond</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-34">
        <img src="Marie Gold.jpg" alt="">
        <h3>Britannia Marie Gold Biscuits</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-35">
        <img src="Oreo.jpg" alt="">
        <h3>Cadbury Oreo Vanilla Flavour Crème Sandwich Biscuit</h3>
        <div class="price">$2.00</div>
     </div> -->
     
   </div>
</div>

<div class="products-preview">

   
   <div class="preview" data-target="p-21">
      <i class="fas fa-times"></i>
      <img src="project_images/Thums Up.jpg" alt="">
      <h3>Thums up</h3>
      <p>Thums Up is one of the most popular soft drink brands from the house of Coca Cola. This fizzy drink creates a refreshing effect on a warm summer day.</p>
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

            $category = "Beverages";
            $product = "Thums up";
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
      <a href="https://www.dmart.in/product/thums-up?selectedProd=847003" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40222670" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Thums-Party-Pack-2-25-Bottle/dp/B00TTX2ABG" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-22">
      <i class="fas fa-times"></i>
      <img src="project_images/coca-cola.jpg" alt="">
      <h3>Coca-Cola</h3>
      <p>It's delicious, uplifting and refreshing since 1886. Best known soft drink in the world, in India, Coca-Cola was the leading cola drink till 1977 and then it made a comeback in 1993</p>
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

            $category = "Beverages";
            $product = "Coca-Cola";
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
      <a href="https://www.dmart.in/product/coca-cola?selectedProd=852515" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/251037" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Coca-Cola-Pet-Bottle-2-25L/dp/B01M12M26K" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-23">
      <i class="fas fa-times"></i>
      <img src="project_images/maza.jpg" alt="">
      <h3>Maaza Mango Drink</h3>
      <p>Maaza, in India, is synonymous with the very spirit of mangoes. Enjoy the deliciously thick, sweet and a delightful mango experience with a chilled glass of Maaza.</p>
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

            $category = "Beverages";
            $product = "Maaza Mango Drink";
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
      <a href="https://www.dmart.in/product/maaza-mango-drink?selectedProd=11912" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/265695" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Maaza-1-2L/dp/B00GX9TS6O" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-24">
      <i class="fas fa-times"></i>
      <img src="project_images/sprite.jpg" alt="">
      <h3>Sprite</h3>
      <p>Sprite was introduced by Coca Cola and is loved throughout the world. It is a clear lime drink truly meant to quench your thirst and refresh you since 1999.</p>
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

            $category = "Beverages";
            $product = "Sprite";
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
      <a href="https://www.dmart.in/product/sprite?selectedProd=847002" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40222671" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Sprite-Lemon-Lime-Flavoured-Refreshing-Recyclable/dp/B00TTX2700" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-25">
      <i class="fas fa-times"></i>
      <img src="project_images/society.jpg" alt="">
      <h3>Society Tea</h3>
      <p>Crushed, twisted and curled, each tea leaf carefully picked to create an amalgamation of exquisite aroma and taste.</p>
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

            $category = "Beverages";
            $product = "Society Tea";
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
      <a href="https://www.dmart.in/product/society-tea?selectedProd=12065" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/271089" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Society-Tea-Regular-Pouch-1kg/dp/B00WMNXP82" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-26">
      <i class="fas fa-times"></i>
      <img src="project_images/Wagh Bakri.jpg" alt="">
      <h3>Wagh Bakri Premium Leaf Tea Pouch</h3>
      <p>Wagh Bakri Tea is renowned for its premium quality which promises you consistency in taste, aroma and strength.</p>
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

            $category = "Beverages";
            $product = "Wagh Bakri Premium Leaf Tea Pouch";
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
      <a href="https://www.dmart.in/product/wagh-bakari-premium-leaf-tea-pouch?selectedProd=12050" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/20003982" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Wagh-Bakri-Premium-Leaf-Poly/dp/B00N8J3TZS" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-27">
      <i class="fas fa-times"></i>
      <img src="project_images/Red label.jpg" alt="">
      <h3>Brooke Bond Red Label Natural Care Tea</h3>
      <p>Red Label Natural Care Tea comes with the quality of Brooke Bond, which has been trusted by tea consumers since 1869.</p>
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

            $category = "Beverages";
            $product = "Brooke Bond Red Label Natural Care Tea";
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
      <a href="https://www.dmart.in/product/brooke-bond-red-label-natural-care-tea?selectedProd=12027" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/274791" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Red-Label-Natural-Care-Rupees/dp/B01ER4PP72" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-28">
      <i class="fas fa-times"></i>
      <img src="project_images/Taj mahal.jpg" alt="">
      <h3>Taj Mahal Tea</h3>
      <p>Plucked from the best estates of Assam, only Taj contains the precious essence of the FINEST fresh tea leaves that helps in retaining both its strong taste and great flavour, the perfect taste of a priceless cup of tea.</p>
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

            $category = "Beverages";
            $product = "Taj Mahal Tea";
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
      <a href="https://www.dmart.in/product/brooke-bond-taj-mahal-tea?selectedProd=97509" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/266564" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Taj-Mahal-Tea-South-500/dp/B017H7D1ZO" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-29">
      <i class="fas fa-times"></i>
      <img src="project_images/Bru instant.jpg" alt="">
      <h3>Bru Instant Coffee</h3>
      <p>Experience the rich aroma and bold flavor of BRU Coffee, a beloved choice for coffee enthusiasts.</p>
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

            $category = "Beverages";
            $product = "Bru Instant Coffee";
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
      <a href="https://www.dmart.in/product/bru-instant-coffee?selectedProd=11892" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/266579" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Bru-Instant-Coffee-200g/dp/B00649B4EM" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-30">
      <i class="fas fa-times"></i>
      <img src="project_images/Nescafe.jpg" alt="">
      <h3>Nescafé Classic Coffee</h3>
      <p>Indulge in the rich, smooth taste of Nescafe coffee, crafted from the finest beans to awaken your senses and fuel your day.</p>
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

            $category = "Beverages";
            $product = "Nescafé Classic Coffee";
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
      <a href="https://www.dmart.in/product/nescafe-classic-coffee?selectedProd=94006" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/249581" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Nescaf%C3%A9-Classic-Coffee-200g-Stabilo/dp/B00VJZ0OCY" class="Amazon" style="margin: 10px;">Amazon</a>
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