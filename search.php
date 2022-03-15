<?php
require_once "config.php";
include './functions.php';

$result = trim($_POST["search"]);


$sql = "SELECT * FROM products WHERE CONCAT(`desc`, `name`) LIKE ?"; #select any column that matches user query

$search = "%" . $result ."%";

// $stmt = $link->prepare('SELECT id, password FROM accounts WHERE username = ?')
if($stmt = mysqli_prepare($link, $sql)){
  // Bind variables to the prepared statement as parameters

  mysqli_stmt_bind_param($stmt, "s", $search);
  if(mysqli_stmt_execute($stmt)) {
    $products = $stmt->get_result();
    $total_products = $products->num_rows;

  }
}


?>
<?=template_header('Searches')?>

<div class="searchresult content-wrapper">
    <h1>Result</h1>
    <p><?=$total_products?> Products</p>
    <div class="search-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
            <img src="imgs/<?=$product['img']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
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