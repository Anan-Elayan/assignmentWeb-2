<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete product</title>
</head>

<body>
    <?php
    require_once('dbconfig.in.php');
    require_once('product.php');
    my_header();
    echo '<hr>';

    try {
        $pdo = conection_database();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];


            $query = "SELECT * FROM products WHERE id=:id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $product = $statement->fetchObject('Product');


            $query = "DELETE FROM products WHERE id=:id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':id', $id);
            $result = $statement->execute();


            $imageName = $product->getImageName();
            if ($imageName) {
                $imagePath =  $imageName;
                echo "Image Path: $imagePath<br>";
                if (file_exists($imagePath)) {
                    if (unlink($imagePath)) {
                        echo "Image file deleted successfully.";
                    } else {
                        echo "Failed to delete image file.";
                    }
                } else {
                    echo "Image file not found.";
                }
            }

            header('Location:products.php');
        }
    } catch (PDOException $e) {
        echo "Error is ==> " . $e->getMessage();
    }
    ?>

    <?php
    echo '<hr>';
    my_footer();
    ?>
</body>

</html>