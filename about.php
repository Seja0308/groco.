<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/about-img-1.png" alt="">
         <h3>why choose us?</h3>
         <p>Welcome to Groco, your go-to destination for effortless price comparison across Amazon, BigBasket, and DMart. At Groco, we understand that finding the best deals on your favorite products can be time-consuming and overwhelming. That's why we've created a user-friendly platform that brings you the most up-to-date prices from these leading online and offline retailers, all in one place.
</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

      <div class="box">
         <img src="images/about-img-2.png" alt="">
         <h3>what we provide?</h3>
         <p>Our mission is simple: to help you save time and money by making informed shopping decisions with ease. Whether you're looking for groceries, household essentials, electronics, or more, Groco ensures you never miss out on the best deals and discounts available.</p>
         <a href="shop.php" class="btn">our shop</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">clients reivews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>"I've used this price comparison website several times now, and it consistently helps me find the best deals. The interface is clean and easy to use, and I appreciate the detailed product descriptions and reviews. "</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Aryan Gandhi</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>I love how I can quickly compare prices from multiple stores and see user reviews for each product. The filtering options are very helpful, allowing me to narrow down to exactly what I need. </p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Shreya Sawant</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>"Saved me a lot of money! Easy to use and very reliable."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Omkar Aher</h3>
      </div>

      <div class="box">
         <img src="images/pic-4.png" alt="">
         <p>"Excellent tool for finding the best deals quickly. Highly recommend!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Disha Takavale</h3>
      </div>

      <div class="box">
         <img src="images/pic-5.png" alt="">
         <p>"Mostly accurate and saves time. Some minor issues with product availability."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Sarthak Joshi</h3>
      </div>

      <div class="box">
         <img src="images/pic-6.png" alt="">
         <p>"Great site, very reliable and user-friendly. Found the best deals here!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ana Cristopher</h3>
      </div>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>