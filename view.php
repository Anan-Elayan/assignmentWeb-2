<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
</head>

<body>

    <?php
    require_once ('dbconfig.in.php');
    include_once ('product.php');
    $pdo = conection_database();
    my_header();
    echo "<hr>";


    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $product_id = $_GET['id'];


        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', $product_id);
        $stmt->execute();
        $product = $stmt->fetchObject('Product');
        if ($product) {
            $product_details = $product->displayProdcutPage();
            echo $product_details;

        } else {
            echo "<p>Product not found!</p>";
        }
    } else {
        echo "<p>No product ID provided!</p>";
    }
    ?>


    <?php
    echo "<hr>";
    my_footer();
    ?>

</body>

</html>