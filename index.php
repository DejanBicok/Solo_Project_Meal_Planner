<?php
session_start();

require_once 'components/db_connect.php';

// $userinfo = mysqli_query($connect, "SELECT * FROM users WHERE user_id = {$_SESSION['USER']}");
// $info = mysqli_fetch_array($userinfo, MYSQLI_ASSOC);

// if ($info['user_block'] == 'blocked') {
//     header('Location: block.php');
//     exit;
// }

if (isset($_SESSION['USER'])) {
  header('Location: user/home_user.php');
  exit;
}
if (isset($_SESSION['ADMIN'])) {
  header('Location: admin/index_admin.php');
  exit;
}

// $query = "SELECT * FROM users WHERE user_id={$_SESSION['USER']}"; //////// ??????????? da li ili izbrisati?

$sqlplanner = "SELECT * FROM meal_planner";
$resultplanner = mysqli_query($connect, $sqlplanner);
$tbody2 = '';
if (mysqli_num_rows($resultplanner) > 0) {
    while ($row2 =mysqli_fetch_array($resultplanner, MYSQLI_ASSOC)) {

      $tbody2 .="
      
          <span>
            " . $row2['availability'] . "
          </span>
      </div>
      ";
    }
}

$sql = "SELECT * FROM recipes";
$result = mysqli_query($connect, $sql);
$tbody = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        
    $tbody .="

   <div class='card-product'>

    <div class='card-head-product'><a href='details.php?id=" . $row['recipe_id'] . "'>
      <img src='images/" . $row['picture'] . "' class='product-img-product' alt='" . $row['name'] . "'>
      
      <div class='back-text-product'>
      " . $row['food_type'] . "
      </div>

      <div class='product-detail-product'>
      
      
        <h2>" . $row['name'] . "</h2> 
        
        <span class='cook-time-img'>
        &nbsp; &nbsp; &nbsp; &nbsp;
        Min:&nbsp;
        <span class='cooktime'>" . $row['cooking_prep_time'] . "</span>

        <span class='cook-kcal-img'>
        &nbsp; &nbsp; &nbsp; &nbsp;
        Kcal:&nbsp;
        <span class='kcal'>" . $row['calories'] . "</span>

        </span>
       
      </div>
      
    </div>
      
  </div>";
 
 
};
} else {
    $tbody = "<tr><td colspan='9'><center>No Data Available </center></td></tr>";
            
}
    mysqli_close($connect);
// da li dodati posle ELSE  isti sadrzaj od gore?
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <?php require_once 'components/boot.php'?>
    <?php require_once 'navbar/nav.php'?>
    <?php require_once 'navbar/main_footer.php'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Tasty Food</title>
</head>
<body class="bg-light">



  <div class="container">

    <br>
    <h1 class="h1"> All Recipes </h1>
    <br>
    
    
<main>
<div class="manageProduct w-100 mt-1" style="margin-bottom: -6.5em !important;">
      <div class="row w-200">
        <div class="container-product d-flex flex-wrap mb-5 w-200 m-auto">
        
<aside>
    <div id="buttons">
    <ul class="f-categ">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="user/index_user.php" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Food Categories </a>
      <ul class="dropdown-menu" id="food_cat_dropdown">
        <li><a class="dropdown-item" href="food_type.php?food_type='Breakfast'">Breakfast</a></li>
        <li><a class="dropdown-item" href="food_type.php?food_type='Lunch'">Lunch</a></li>
        <li><a class="dropdown-item" href="food_type.php?food_type='Dinner'">Dinner</a></li>
        <li><a class="dropdown-item" href="food_type.php?food_type='Vegan'">Vegan</a></li>
        <li><a class="dropdown-item" href="food_type.php?food_type='Vegeterian'">Vegeterian</a></li>
    </ul>
  </li>
</ul>
</div>
</aside>

          <?= $tbody; ?>
        
        </div>
          
      </div>
    </div>
</main>

<button id="BackToTop" class="Button WhiteButton Indicator" type="button">
  <a href=""> 
    Back to Top </a>
</button>

    <script>
        function SearchRecipes() {
          let xhttp = new XMLHttpRequest();
          let recipevalue = document.getElementById("searchRec").value;
          console.log(recipevalue);
          xhttp.open("GET", "search.php?search=" + recipevalue);
          xhttp.onload = function() {
            if (this.status == 200) {
              document.getElementById('container').innerHTML = this.responseText;
            }
          }
          xhttp.send();
        }
        document.getElementById('searchRec').addEventListener("input", SearchRecipes);
    </script>
  </div>
<?php require_once "navbar/bottom_footer.php";?>

</body>

</html>

