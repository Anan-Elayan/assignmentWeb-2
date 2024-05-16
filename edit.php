<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>

<body>
    <?php
    require_once('dbconfig.in.php');
    include_once('product.php');
    my_header();
    echo "<hr>";
    $pdo = conection_database();


    $name = $category = $price = $quantity = $rating = $description = $imageName = '';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM products WHERE id = $id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $product = $stmt->fetchObject('Product');



        if ($product) {
            $name = $product->getName();
            $category = $product->getCategory();
            $price = $product->getPrice();
            $quantity = $product->getQuantity();
            $rating = $product->getRating();
            $description = $product->getDescription();
            $imageName = $product->getImageName();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];


        if (isset($_FILES['imageName']) && !empty($_FILES['imageName']['name'])) {

            $targetDir = "images/";
            $tempFile = $_FILES['imageName']['tmp_name'];
            $extension = pathinfo(basename($_FILES['imageName']['name']), PATHINFO_EXTENSION);

            $newImageName = $id . "." . $extension;

            $targetFile = $targetDir  . $newImageName;
            move_uploaded_file($tempFile, $targetFile);
        } else {
            echo "Please Upload photo";
        }


        $sql = "UPDATE products SET name=:name, 
        price=:price, 
        quantity=:quantity, 
        description=:description, 
        imageName=:imageName WHERE id=:id";

        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->bindValue(':name', $name);
        $query->bindValue(':price', $price);
        $query->bindValue(':quantity', $quantity);
        $query->bindValue(':description', $description);
        $query->bindValue(':imageName', $targetFile);
        $query->execute();
        header('Location: products.php');
        exit();
    }

    ?>

    <main>
        <article>
            <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Product Record</legend>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <p><label>Product ID : </label> <input type="text" name="id" value="<?php echo $id; ?>" disabled></p>
                    <p><label>Product Name</label> <input type="text" name="name" value="<?php echo $name; ?>"></p>
                    <p>
                        <label>Category</label>
                        <select name="category" disabled>
                            <option value="">Select Category</option>
                            <option value="Cap" <?php echo ($category === 'Cap') ? 'selected' : ''; ?>>Cap</option>
                            <option value="T-Shirt" <?php echo ($category === 'T-Shirt') ? 'selected' : ''; ?>>T-Shirt</option>
                            <option value="Shoes" <?php echo ($category === 'Shoes') ? 'selected' : ''; ?>>Shoes</option>
                        </select>
                    </p>
                    <p><label>Price <input type="text" name="price" value="<?php echo $price; ?>"></label></p>
                    <p><label>Quantity <input type="number" name="quantity" value="<?php echo $quantity; ?>"></label></p>
                    <p><label>Rating <input type="number" name="rating" value="<?php echo $rating; ?>" disabled></label></p>
                    <div>
                        <label>Description: </label><br>
                        <textarea name="description" id="description" cols="80" rows="6"><?php echo $description; ?></textarea>
                    </div>
                    <p><label>Product Photo:</label><input type="file" name="imageName"></p>
                    <p><input type="submit" name="Update" value='Update'></p>
                </fieldset>
            </form>
        </article>
    </main>

    <?php
    my_footer();
    ?>

</html>