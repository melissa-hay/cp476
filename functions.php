<?php
function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'shoppingcart';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}

function template_header($title) {
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    //if user isn't signed in, display login/register message 
    //and link to register / login
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        $user_welcom = 'Please log in';
        $loginurl = "register.html?page=register";
        $loginWord = "Login/Register";
        
    }
    //if user is logged in, display 'welcome <username>' message 
    //and link to logout
    else {
        $user_welcom = "Welcome " . htmlspecialchars($_SESSION["username"]); 
        $loginurl = "logout.php";
        $loginWord = "Logout";
    }

    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <link rel="shortcut icon" href="imgs/logo-small.png">
        </head>
        <body>
            <header>
                <div class="content-wrapper">
                    <img style="width: 8%;height: 8%" src="imgs/logo.png">
                    <div class="search-container">
                        <form action="search.php", method="post">
                            <input type="text" placeholder="Search" name="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <h1 style="color: white; justify-content: center; margin-right: 3%;">$user_welcom</h1>
                    <nav>
                        <a href="index.php">Home</a>
                        <a href="index.php?page=products">Products</a>
                        <a href=$loginurl>$loginWord</a>
                        
                    </nav>
                    <div class="link-icons">
                        <a href="index.php?page=cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span>$num_items_in_cart</span>
                        </a>
                    </div>
                </div>
            </header>
            <main>
    EOT;
    // Get the amount of items in the shopping cart, this will be displayed in the header.

}
// Template footer
function template_footer() {
$year = date('Y');
echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; $year, Shopping Cart System</p>
            </div>
        </footer>
        <script src="script.js"></script>
    </body>
</html>
EOT;
}
?>