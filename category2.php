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


   <h3 class="title"> Fresh Vegetables </h3>

   <div class="products-container">

      <!-- <div class="product" > -->
      <!-- data-name="p-1"> 
       
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
      </div> -->

      <div class="product" data-name="p-6">
         <img src="project_images/Onion.jpg" alt="">
         <h3>Fresh Onion</h3>
      </div>
      <div class="product" data-name="p-7">
        <img src="project_images/Potato.jpg" alt="">
        <h3>Fresh Potato</h3>
     </div>
     <div class="product" data-name="p-8">
      <img src="project_images/Tomato.jpg" alt="">
      <h3>Fresh Tomato</h3>
   </div>
     
     <div class="product" data-name="p-9">
        <img src="project_images/Ginger.jpg" alt="">
        <h3>Ginger</h3>
     </div>
     <div class="product" data-name="p-10">
        <img src="project_images/garlic.jpg" alt="">
        <h3>Garlic</h3>
     </div>
     <div class="product" data-name="p-11">
        <img src="project_images/Lemon.jpg" alt="">
        <h3>Fresh Lemon</h3>
     </div>
     <div class="product" data-name="p-12">
        <img src="project_images/Coconut.jpg" alt="">
        <h3>Coconut</h3>
     </div>
     <div class="product" data-name="p-13">
        <img src="project_images/Green Chilli.jpg" alt="">
        <h3>Fresh Green Chilli</h3>
     </div>
     <div class="product" data-name="p-14">
        <img src="project_images/Cucumber.jpg" alt="">
        <h3>Fresh Cucumber White</h3>
     </div>
     <div class="product" data-name="p-15">
        <img src="project_images/Beetroot.jpg" alt="">
        <h3>Fresh Beetroot</h3>
     </div>
     <div class="product" data-name="p-16">
        <img src="project_images/Coriander.jpg" alt="">
        <h3>Fresh Coriander</h3>
     </div>
     <div class="product" data-name="p-17">
        <img src="project_images/Lady Finger.jpg" alt="">
        <h3>Fresh Lady Finger</h3>
     </div>
     <div class="product" data-name="p-18">
        <img src="project_images/Capsicum.jpg" alt="">
        <h3>Fresh Capsicum Green</h3>
     </div>
     <div class="product" data-name="p-19">
        <img src="project_images/Cabbage.jpg" alt="">
        <h3>Cabbage</h3>
     </div>
     <div class="product" data-name="p-20">
        <img src="project_images/Bitter Gourd.jpg" alt="">
        <h3>Bitter Gourd</h3>
     </div>
     <!-- <div class="product" data-name="p-21">
        <img src="Thums Up.jpg" alt="">
        <h3>Thums Up</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-22">
        <img src="coca-cola.jpg" alt="">
        <h3>Coca-Cola</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-23">
        <img src="maza.jpg" alt="">
        <h3>Maaza Mango Drink</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-24">
        <img src="sprite.jpg" alt="">
        <h3>Sprite</h3>
        <div class="price">$2.00</div>
     </div>
     <div class="product" data-name="p-25">
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

   <!-- <div class="preview" data-target="p-1">
      <i class="fas fa-times"></i>
      <img src="Pomegranate.jpg" alt="">
      <h3>fresh Pomegranate</h3>
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
   
   <div class="preview" data-target="p-2">
      <i class="fas fa-times"></i>
      <img src="watermelon.jpg" alt="">
      <h3>Fresh Watermelon</h3>
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
   <div class="preview" data-target="p-3">
      <i class="fas fa-times"></i>
      <img src="kiwi.jpg" alt="">
      <h3>Fresh kiwi</h3>
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
   <div class="preview" data-target="p-4">
      <i class="fas fa-times"></i>
      <img src="Apple.jpg" alt="">
      <h3>Apple Royal Gala</h3>
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
   <div class="preview" data-target="p-5">
      <i class="fas fa-times"></i>
      <img src="Grapes.jpg" alt="">
      <h3>Fresh Grapes</h3>
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
   <div class="preview" data-target="p-6">
      <i class="fas fa-times"></i>
      <img src="project_images/Onion.jpg" alt="">
      <h3>Fresh Onion</h3>
      <p>Onions are an excellent source of antioxidants and contain at least 17 types of flavonoids.</p>
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

            $category = "Fresh Vegetables";
            $product = "Fresh Onion";
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
      <a href="https://www.dmart.in/product/onion-ponions3129xx160817?selectedProd=174003" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000148" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Onion-1kg-Pack/dp/B07BG62MBV" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-7">
      <i class="fas fa-times"></i>
      <img src="project_images/Potato.jpg" alt="">
      <h3>Fresh Potato</h3>
      <p>A staple in Indian diets, fresh potatoes are packed with nutrients.</p>
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

            $category = "Fresh Vegetables";
            $product = "Fresh Potato";
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
      <a href="https://www.dmart.in/product/potato-ppotato3131xx160817?selectedProd=173503" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000159" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Potato-1kg-Pack/dp/B07BG5GZP2" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-8">
      <i class="fas fa-times"></i>
      <img src="project_images/Tomato.jpg" alt="">
      <h3>Fresh Tomato</h3>
      <p>The tomato (Solanum lycopersicum) is one of the most commercially important vegetable cultivated worldwide.</p>
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

            $category = "Fresh Vegetables";
            $product = "Fresh Tomato";
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
      <a href="https://www.dmart.in/product/fresh-tomato-pvegetables40xx20518?selectedProd=229001" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000203" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Tomato-Hybrid-1kg-Pack/dp/B07BG6QWJK" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-9">
      <i class="fas fa-times"></i>
      <img src="project_images/Ginger.jpg" alt="">
      <h3>Ginger</h3>
      <p>ginger a flowering plant whose rhizome is widely used as a spice and folk medicine. </p>
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

            $category = "Fresh Vegetables";
            $product = "Ginger";
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
      <a href="https://www.dmart.in/product/ginger-(-adrak-)-pothervegetable7xx160218?selectedProd=247007" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000117" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Ginger-100g-Pack/dp/B07BG7B7RF" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-10">
      <i class="fas fa-times"></i>
      <img src="project_images/garlic.jpg" alt="">
      <h3>Garlic</h3>
      <p>Garlic is a commonly used food and flavoring agent in all Indian dishes. It is highly nutritious and has very few calories.</p>
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

            $category = "Fresh Vegetables";
            $product = "Garlic";
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
      <a href="https://www.dmart.in/product/garlic-(-lahasun-)-pothervegetable8xx160218?selectedProd=247008" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000114" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Garlic-100g-Pack/dp/B07BG51Q2F" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-11">
      <i class="fas fa-times"></i>
      <img src="project_images/Lemon.jpg" alt="">
      <h3>Fresh Lemon</h3>
      <p>Lemon is a type of citrus fruit. The fruit, juice, and peel are used to make medicine.</p>
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

            $category = "Fresh Vegetables";
            $product = "Fresh Lemon";
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
      <a href="https://www.dmart.in/product/lemon(-nimboo)-pothervegetable6xx160218?selectedProd=247006" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000127" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Lemon-250-g/dp/B07NXZZ955" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-12">
      <i class="fas fa-times"></i>
      <img src="project_images/Coconut.jpg" alt="">
      <h3>Coconut</h3>
      <p>Coconut is the fruit of the coconut palm (Cocos nucifera).It is used for its water, milk, oil, and tasty meat.</p>
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

            $category = "Fresh Vegetables";
            $product = "Coconut";
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
      <a href="https://www.dmart.in/product/coconut-?selectedProd=173504" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000093" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Coconut-Medium-Pack/dp/B07BG7D7WR" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-13">
      <i class="fas fa-times"></i>
      <img src="project_images/Green Chilli.jpg" alt="">
      <h3>Fresh Green Chilli</h3>
      <p>Good source of Vitamin B6, C, Iron and Potassium.Used in curries, soups, and other dishes and can be used to make pickle</p>
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

            $category = "Fresh Vegetables";
            $product = "Fresh Green Chilli";
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
      <a href="https://www.dmart.in/product/fresh-green-chilly---mirchi-pvegetables21xx220518?selectedProd=310503" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000081" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Chilli-Green-100g-Pack/dp/B07BG7LB5B" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-14">
      <i class="fas fa-times"></i>
      <img src="project_images/Cucumber.jpg" alt="">
      <h3>Fresh Cucumber White</h3>
      <p>Cucumbers are 95 percent water Good source of Vitamin B6, C, K, Thiamin and Folate.</p>
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

            $category = "Fresh Vegetables";
            $product = "Fresh Cucumber White";
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
      <a href="https://www.dmart.in/product/cucumber-(kakdi-)-pothervegetable1xx160218?selectedProd=247001" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/30000456" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Cucumber-White-500-g/dp/B07MFZ6T54" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-15">
      <i class="fas fa-times"></i>
      <img src="project_images/Beetroot.jpg" alt="">
      <h3>Fresh Beetroot</h3>
      <p>Beetroot it is a good source of Vitamin C, Iron, Potassium, Folate and Dietary Fiber.</p>
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

            $category = "Fresh Vegetables";
            $product = "Fresh Beetroot";
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
      <a href="https://www.dmart.in/product/fresh-beetroot-(chukandar)-pbeetroot28xx170418?selectedProd=287506" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000046" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Beet-Root-500g-Pack/dp/B07BG7B7QP" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-16">
      <i class="fas fa-times"></i>
      <img src="project_images/Coriander.jpg" alt="">
      <h3>Fresh Coriander</h3>
      <p>From vegetables, to soups, to curries, coriander is a main spice, provides protein and a pleasant aroma</p>
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
            $product = "Fresh Coriander";
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
      <a href="https://www.dmart.in/product/fresh-coriander-(kothimbir)-pvegetables5xx121218?selectedProd=408002" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000097" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Coriander-100g-Pack/dp/B07BG5GJJW" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-17">
      <i class="fas fa-times"></i>
      <img src="project_images/Lady Finger.jpg" alt="">
      <h3>Fresh Lady Finger</h3>
      <p>Rich in Nutrients. It is considered as a good source of carbohydrate and proteins.</p>
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
            $product = "Fresh Lady Finger";
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
      <a href="https://www.dmart.in/product/ladies-finger(bhendi)-pothervegetable3xx160218?selectedProd=247003" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000144" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Bhendi-500g-Pack/dp/B07BG7D7HF" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-18">
      <i class="fas fa-times"></i>
      <img src="project_images/Capsicum.jpg" alt="">
      <h3>Fresh Capsicum Green</h3>
      <p>The bell pepper (also known as sweet pepper, pepper, or capsicum). 'Sweet peppers' is a term used to describe bell peppers and other peppers having a milder flavour</p>
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
            $product = "Fresh Capsicum Green";
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
      <a href="https://www.dmart.in/product/capsicum-green-(shimla-mirch)-pothervegetable4xx160218?selectedProd=247004" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000069" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Capsicum-Green-500g-Pack/dp/B07BG51WMX" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-19">
      <i class="fas fa-times"></i>
      <img src="project_images/Cabbage.jpg" alt="">
      <h3>Cabbage</h3>
      <p>Cabbage is a sweet flavored, with a smooth and dense leafy layer. It can be consumed as a vegetable curry or fried dish along with rice or rotis.</p>
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
            $product = "Cabbage";
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
      <a href="https://www.dmart.in/product/cabbage-(gobi)-pvegetablesvegetables10xx211018?selectedProd=386008" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000066" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Cabbage-1-Piece-Pack/dp/B07BG521JL" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <div class="preview" data-target="p-20">
      <i class="fas fa-times"></i>
      <img src="project_images/Bitter Gourd.jpg" alt="">
      <h3>Bitter Gourd</h3>
      <p>These compounds are responsible for the vegetable's bitter taste, but may also play a role in lowering blood sugar levels in people with diabetes.</p>
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
            $product = "Bitter Gourd";
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
      <a href="https://www.dmart.in/product/bitter-gourd-(karela)-pvegetables3xx211018?selectedProd=385501" class="Dmart" style="margin: 10px;">Dmart</a>
         <a href="https://www.bigbasket.com/pd/10000049" class="Bigbasket" style="margin: 10px;">Bigbasket</a>
         <a href="https://www.amazon.in/Fresh-Bitter-Gourd-500g-Pack/dp/B07BG77RNC" class="Amazon" style="margin: 10px;">Amazon</a>
      </div>
   </div>
   <!-- <div class="preview" data-target="p-21">
      <i class="fas fa-times"></i>
      <img src="Thums Up.jpg" alt="">
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
      <img src="coca-cola.jpg" alt="">
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
      <img src="maza.jpg" alt="">
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
      <img src="sprite.jpg" alt="">
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
      <img src="society.jpg" alt="">
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
      <img src="Wagh Bakri.jpg" alt="">
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
      <img src="Red label.jpg" alt="">
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
      <img src="Taj mahal.jpg" alt="">
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
      <img src="Bru instant.jpg" alt="">
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
      <img src="Nescafe.jpg" alt="">
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
      <img src="Good day.jpg" alt="">
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
      <img src="Dark fantasy.jpg" alt="">
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
      <img src="Moms magic.jpg" alt="">
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
      <img src="Marie Gold.jpg" alt="">
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
      <img src="Oreo.jpg" alt="">
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
</html>

</head>
<body>
   


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