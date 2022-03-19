<?php
require_once "config.php";
include './functions.php';

$result = trim($_POST["search"]); #grab user's query

#select any column that matches user query
$sql = "SELECT * FROM products WHERE CONCAT(`descr`, `name`) LIKE ?"; 

#use % wildcard to match any number of characters 
$search = "%" . $result ."%"; 

if($stmt = mysqli_prepare($link, $sql)){

  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "s", $search);
  if(mysqli_stmt_execute($stmt)) {
    $products = $stmt->get_result();
    $total_products = $products->num_rows;

  }
}

//HTML to display all matching products to user's search query
?>
<?=template_header('Searches')?>

<div class="selectedproducts content-wrapper">
    <h2>Result</h2>
    <p><?=$total_products?> Products</p>
    <div class="products">
        <?php foreach ($products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
            <img src="imgs/<?=$product['img']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span style="padding-right:100px" class="name"><?=$product['name']?></span>
            <span class="price">
                &dollar;<?=$product['price']?>
                <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>