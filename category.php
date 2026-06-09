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

   <h3 class="title"> Fresh Fruits </h3>

   <div class="products-container">

      <div class="product" data-name="p-1">
         <img src="project_images/Pomegranate.jpg" alt="">
         <h3>Fresh Pomogranate</h3>
      </div>
      <div class="product" data-name="p-2">
         <img src="project_images/watermelon.jpg" alt="">
         <h3>Fresh Watermelon</h3>
      </div>
      <div class="product" data-name="p-3">
         <img src="project_images/kiwi.jpg" alt="">
         <h3>Fresh kiwi</h3>
      </div>

      <div class="product" data-name="p-4">
         <img src="project_images/Apple.jpg" alt="">
         <h3>Apple Royal Gala</h3>
      </div>

      <div class="product" data-name="p-5">
         <img src="project_images/Grapes.jpg" alt="">
         <h3>Fresh Grapes</h3>
      </div>

      <!-- <div class="product" data-name="p-6">
         <img src="project_images/Onion.jpg" alt="">
         <h3>Fresh Onion</h3>
         <div class="price">$2.00</div>
      </div>
      <div class="product" data-name="p-7">
        <img src="project_images/Potato.jpg" alt="">
        <h3>Fresh Potato</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-8">
      <img src="project_images/Tomato.jpg" alt="">
      <h3>Fresh Tomato</h3>
      <div class="price">$2.00</div>
   </div>
     
     <div class="product" data-name="p-9">
        <img src="project_images/Ginger.jpg" alt="">
        <h3>Ginger</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-10">
        <img src="project_images/garlic.jpg" alt="">
        <h3>Garlic</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-11">
        <img src="project_images/Lemon.jpg" alt="">
        <h3>Fresh Lemon</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-12">
        <img src="project_images/Coconut.jpg" alt="">
        <h3>Coconut</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-13">
        <img src="project_images/Green Chilli.jpg" alt="">
        <h3>Fresh Green Chilli</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-14">
        <img src="project_images/Cucumber.jpg" alt="">
        <h3>Fresh Cucumber White</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-15">
        <img src="project_images/Beetroot.jpg" alt="">
        <h3>Fresh Beetroot</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-16">
        <img src="project_images/Coriander.jpg" alt="">
        <h3>Fresh Coriander</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-17">
        <img src="project_images/Lady Finger.jpg" alt="">
        <h3>Fresh Lady Finger</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-18">
        <img src="project_images/Capsicum.jpg" alt="">
        <h3>Fresh Capsicum Green</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-19">
        <img src="project_images/Cabbage.jpg" alt="">
        <h3>Cabbage</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-20">
        <img src="project_images/Bitter Gourd.jpg" alt="">
        <h3>Bitter Gourd</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-21">
        <img src="project_images/Thums Up.jpg" alt="">
        <h3>Thums Up</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-22">
        <img src="project_images/coca-cola.jpg" alt="">
        <h3>Coca-Cola</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-23">
        <img src="project_images/maza.jpg" alt="">
        <h3>Maaza Mango Drink</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-24">
        <img src="project_images/sprite.jpg" alt="">
        <h3>Sprite</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-25">
        <img src="project_images/society.jpg" alt="">
        <h3>Society Tea</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-26">
        <img src="project_images/Wagh Bakri.jpg" alt="">
        <h3>Wagh Bakri Premium Leaf Tea Pouch</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-27">
        <img src="project_images/Red label.jpg" alt="">
        <h3>Brooke Bond Red Label Natural Care Tea</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-28">
        <img src="project_images/Taj mahal.jpg" alt="">
        <h3>Taj Mahal Tea</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-29">
        <img src="project_images/Bru instant.jpg" alt="">
        <h3>Bru Instant Coffee</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-30">
        <img src="project_images/Nescafe.jpg" alt="">
        <h3>Nescafé Classic Coffee</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-31">
        <img src="project_images/Good day.jpg" alt="">
        <h3>Britannia Good Day Cashew Cookies</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-32">
        <img src="project_images/Dark fantasy.jpg" alt="">
        <h3>Sunfeast Dark Fantasy Yumfills Cake</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-33">
        <img src="project_images/Moms magic.jpg" alt="">
        <h3>Sunfeast Mom's Magic Cashew & Almond</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-34">
        <img src="project_images/Marie Gold.jpg" alt="">
        <h3>Britannia Marie Gold Biscuits</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-35">
        <img src="project_images/Oreo.jpg" alt="">
        <h3>Cadbury Oreo Vanilla Flavour Crème Sandwich Biscuit</h3>
        <div class="price">$2.00</div>
     </div>
      -->
   </div>
</div>

<div class="products-preview">

   <div class="preview" data-target="p-1">
      <i class="fas fa-times"></i>
      <img src="project_images/Pomegranate.jpg" alt="">
      <h3>fresh Pomegranate</h3>
      <p>Enjoy the vibrant, juicy sweetness of our fresh pomegranates.</p>
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

            $category = "Fresh Fruits";
            $product = "Fresh Pomegranate";
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
         <a href="https://www.dmart.in/product/fresh-pomegranate-(anar)-pfreshfruits91xx141018?selectedProd=377504" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40120006" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Pomegranate-4-Pieces-Pack/dp/B07BG6Q18N" class="Amazon"  style="margin: 10px;">Amazon</a>
      </div>
   </div>
   
   <div class="preview" data-target="p-2">
      <i class="fas fa-times"></i>
      <img src="project_images/watermelon.jpg" alt="">
      <h3>Fresh Watermelon</h3>
      <p>Relish the juicy taste of fresh watermelon.</p>
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

            $category = "Fresh Fruits";
            $product = "Fresh Watermelon";
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
         <a href="https://www.dmart.in/product/fresh-watermelon-(tarbooj)-pfreshfruit17xx281018?selectedProd=387504" class="Dmart"  style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40103540" class="Bigbasket"  style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Water-Melon-Kiran-Pc/dp/B07BG6X1QH" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-3">
      <i class="fas fa-times"></i>
      <img src="project_images/kiwi.jpg" alt="">
      <h3>Fresh kiwi</h3>
      <p>Kiwis are rich in vitamin C, copper, and vitamin K and contain smaller portions of many other important nutrients.</p>
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

            $category = "Fresh Fruits";
            $product = "Fresh kiwi";
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
         <a href="https://www.dmart.in/product/fresh-kiwi-pfruits1xx10319?selectedProd=445501" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/20000911" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Kiwi-3-Pieces-Box/dp/B07BG63MHG" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-4">
      <i class="fas fa-times"></i>
      <img src="project_images/Apple.jpg" alt="">
      <h3>Apple Royal Gala</h3>
      <p>An Apple a day keeps the doctor away. Red Delicious crunchy juicy and sweet  Apples. </p>
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

            $category = "Fresh Fruits";
            $product = "Apple Royal Gala";
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
      <a href="https://www.dmart.in/product/apple-royal-gala-pssonfruits0fres1xx160319?selectedProd=456501" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000005" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Apple-Royal-Gala-Pieces/dp/B07BG7KKG1" class="Amazon"  style="margin: 10px;">Amazon</a>
         
      </div>
   </div>
   <div class="preview" data-target="p-5">
      <i class="fas fa-times"></i>
      <img src="project_images/Grapes.jpg" alt="">
      <h3>Fresh Grapes</h3>
      <p>Crunchy skin, fleshy pulp and a green tinge in colour. The grapes have high sweetness and taste, but these grapes not tangy.</p>
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

            $category = "Fresh Fruits";
            $product = "Fresh Grapes";
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
      <a href="https://www.dmart.in/product/fresh-grapes-pfruits09xx40618?selectedProd=314002" class="Dmart"style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/40122445" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Grapes-Sonaka-Seedless-500/dp/B07MM5S7V6" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <!-- <div class="preview" data-target="p-6">
      <i class="fas fa-times"></i>
      <img src="project_images/Onion.jpg" alt="">
      <h3>Fresh Onion</h3>
      <div class="stars">
         
         <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
         <a href="#" class="cart">add to cart</a>

      </div>
   </div>
   <div class="preview" data-target="p-7">
      <i class="fas fa-times"></i>
      <img src="project_images/Potato.jpg" alt="">
      <h3>Fresh Potato</h3>
      <div class="stars">
         
         <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
         <a href="#" class="cart">add to cart</a>

      </div>
   </div>
   <div class="preview" data-target="p-8">
      <i class="fas fa-times"></i>
      <img src="project_images/Tomato.jpg" alt="">
      <h3>Fresh Tomato</h3>
      <div class="stars">
        
         <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
         <a href="#" class="cart">add to cart</a>

      </div>
   </div>
   <div class="preview" data-target="p-9">
      <i class="fas fa-times"></i>
      <img src="project_images/Ginger.jpg" alt="">
      <h3>Ginger</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
         <a href="#" class="cart">add to cart</a>

      </div>
   </div>
   <div class="preview" data-target="p-10">
      <i class="fas fa-times"></i>
      <img src="project_images/garlic.jpg" alt="">
      <h3>Garlic</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-11">
      <i class="fas fa-times"></i>
      <img src="project_images/Lemon.jpg" alt="">
      <h3>Fresh Lemon</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-12">
      <i class="fas fa-times"></i>
      <img src="project_images/Coconut.jpg" alt="">
      <h3>Coconut</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-13">
      <i class="fas fa-times"></i>
      <img src="project_images/Green Chilli.jpg" alt="">
      <h3>Fresh Green Chilli</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-14">
      <i class="fas fa-times"></i>
      <img src="project_images/Cucumber.jpg" alt="">
      <h3>Fresh Cucumber White</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-15">
      <i class="fas fa-times"></i>
      <img src="project_images/Beetroot.jpg" alt="">
      <h3>Fresh Beetroot</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-16">
      <i class="fas fa-times"></i>
      <img src="project_images/Coriander.jpg" alt="">
      <h3>Fresh Coriander</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-17">
      <i class="fas fa-times"></i>
      <img src="project_images/Lady Finger.jpg" alt="">
      <h3>Fresh Lady Finger</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-18">
      <i class="fas fa-times"></i>
      <img src="project_images/Capsicum.jpg" alt="">
      <h3>Fresh Capsicum Green</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-19">
      <i class="fas fa-times"></i>
      <img src="project_images/Cabbage.jpg" alt="">
      <h3>Cabbage</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-20">
      <i class="fas fa-times"></i>
      <img src="project_images/Bitter Gourd.jpg" alt="">
      <h3>Bitter Gourd</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-21">
      <i class="fas fa-times"></i>
      <img src="project_images/Thums Up.jpg" alt="">
      <h3>Thums up</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-22">
      <i class="fas fa-times"></i>
      <img src="project_images/coca-cola.jpg" alt="">
      <h3>Coca-Cola</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-23">
      <i class="fas fa-times"></i>
      <img src="project_images/maza.jpg" alt="">
      <h3>Maaza Mango Drink</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-24">
      <i class="fas fa-times"></i>
      <img src="project_images/sprite.jpg" alt="">
      <h3>Sprite</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-25">
      <i class="fas fa-times"></i>
      <img src="project_images/society.jpg" alt="">
      <h3>Society Tea</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-26">
      <i class="fas fa-times"></i>
      <img src="project_images/Wagh Bakri.jpg" alt="">
      <h3>Wagh Bakri Premium Leaf Tea Pouch</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-27">
      <i class="fas fa-times"></i>
      <img src="project_images/Red label.jpg" alt="">
      <h3>Brooke Bond Red Label Natural Care Tea</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-28">
      <i class="fas fa-times"></i>
      <img src="project_images/Taj mahal.jpg" alt="">
      <h3>Taj Mahal Tea</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-29">
      <i class="fas fa-times"></i>
      <img src="project_images/Bru instant.jpg" alt="">
      <h3>Bru Instant Coffee</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-30">
      <i class="fas fa-times"></i>
      <img src="project_images/Nescafe.jpg" alt="">
      <h3>Nescafé Classic Coffee</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-31">
      <i class="fas fa-times"></i>
      <img src="project_images/Good day.jpg" alt="">
      <h3>Britannia Good Day Cashew Cookies</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-32">
      <i class="fas fa-times"></i>
      <img src="project_images/Dark fantasy.jpg" alt="">
      <h3>Sunfeast Dark Fantasy Yumfills Cake</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-33">
      <i class="fas fa-times"></i>
      <img src="project_images/Moms magic.jpg" alt="">
      <h3>Sunfeast Mom's Magic Cashew & Almond</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <var> <div class="preview" data-target="p-34">
      <i class="fas fa-times"></i>
      <img src="project_images/Marie Gold.jpg" alt="">
      <h3>Britannia Marie Gold Biscuits</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div>
   <div class="preview" data-target="p-35">
      <i class="fas fa-times"></i>
      <img src="project_images/Oreo.jpg" alt="">
      <h3>Cadbury Oreo Vanilla Flavour Crème Sandwich Biscuit</h3>
      <div class="stars">
          <span>( 250 )</span>
      </div>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, dolorem.</p>
      <div class="price">$2.00</div>
      <div class="buttons">
         <a href="#" class="buy">buy now</a>
         <a href="#" class="cart">add to cart</a>
      </div>
   </div> -->

   

</div>

</body>
</html>+

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