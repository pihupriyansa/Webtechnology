<?php
session_start();

// PRODUCTS
$products = [
    "Lip Gloss" => 299,
    "Matte Lipstick" => 399,
    "Lip Oil" => 349,
    "Lip Balm" => 199,
    "Tinted Balm" => 249
];

// RESET BROKEN SESSION (important fix)
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ADD PRODUCT
if (isset($_POST['product'])) {
    $item = $_POST['product'];

    if (isset($products[$item])) {
        if (isset($_SESSION['cart'][$item])) {
            $_SESSION['cart'][$item]++;
        } else {
            $_SESSION['cart'][$item] = 1;
        }
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// INCREASE
if (isset($_GET['inc'])) {
    $item = $_GET['inc'];
    if (isset($_SESSION['cart'][$item])) {
        $_SESSION['cart'][$item]++;
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// DECREASE
if (isset($_GET['dec'])) {
    $item = $_GET['dec'];
    if (isset($_SESSION['cart'][$item])) {
        $_SESSION['cart'][$item]--;
        if ($_SESSION['cart'][$item] <= 0) {
            unset($_SESSION['cart'][$item]);
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// CLEAR CART
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// COOKIE
if (isset($_POST['username'])) {
    setcookie("user", $_POST['username'], time()+3600);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>LipBeauty Pro</title>

<style>
body {
    margin:0;
    font-family:'Segoe UI';
    background: linear-gradient(135deg,#ff9a9e,#fad0c4);
}

/* HEADER */
.header {
    background:#c71585;
    color:white;
    padding:15px;
    text-align:center;
    font-size:28px;
}

/* CONTAINER */
.container {
    width:90%;
    margin:auto;
}

/* USER */
.user-box {
    text-align:center;
    margin:20px;
}

input {
    padding:8px;
    border-radius:5px;
    border:1px solid #ccc;
}

/* BUTTON */
.btn {
    background:#c71585;
    color:white;
    padding:8px 15px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}
.btn:hover {
    background:#ff1493;
}

/* PRODUCTS */
.products {
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    justify-content:center;
}

.card {
    background:white;
    padding:20px;
    width:200px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
    text-align:center;
    transition:0.3s;
}
.card:hover {
    transform:scale(1.05);
}

/* CART */
.cart {
    background:white;
    margin-top:30px;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    padding:10px;
    text-align:center;
}

th {
    background:#ffb6c1;
}

a {
    text-decoration:none;
    color:#c71585;
    font-weight:bold;
}

.clear-btn {
    display:inline-block;
    margin-top:10px;
}
</style>

</head>

<body>

<div class="header">
💄 LipBeauty Store
</div>

<div class="container">

<!-- USER -->
<div class="user-box">
<?php
if (isset($_COOKIE['user'])) {
    echo "<h3>Welcome, ".$_COOKIE['user']." 💋</h3>";
}
?>
<form method="post">
<input type="text" name="username" placeholder="Enter your name" required>
<button class="btn">Save</button>
</form>
</div>

<h2 align="center">Products</h2>

<div class="products">
<?php foreach ($products as $name => $price) { ?>
<div class="card">
<h3><?php echo $name; ?></h3>
<p>₹<?php echo $price; ?></p>

<form method="post">
<input type="hidden" name="product" value="<?php echo $name; ?>">
<button class="btn">Add to Cart</button>
</form>

</div>
<?php } ?>
</div>

<!-- CART -->
<div class="cart">
<h2 align="center">🛒 Your Cart</h2>

<?php
$total = 0;

if (!empty($_SESSION['cart'])) {

    echo "<table border='1'>";
    echo "<tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th><th>Action</th></tr>";

    foreach ($_SESSION['cart'] as $item => $qty) {

        if (!isset($products[$item])) continue;

        $price = (int)$products[$item];
        $qty = (int)$qty;

        $sub = $price * $qty;
        $total += $sub;

        echo "<tr>";
        echo "<td>$item</td>";
        echo "<td>₹$price</td>";
        echo "<td>$qty</td>";
        echo "<td>₹$sub</td>";
        echo "<td>
        <a href='?inc=$item'>+</a> |
        <a href='?dec=$item'>-</a>
        </td>";
        echo "</tr>";
    }

    echo "<tr><td colspan='3'><b>Total</b></td><td colspan='2'><b>₹$total</b></td></tr>";
    echo "</table>";

    echo "<center><a class='btn clear-btn' href='?clear=true'>Clear Cart</a></center>";

} else {
    echo "<p align='center'>Cart is empty</p>";
}
?>

</div>

</div>

</body>
</html>