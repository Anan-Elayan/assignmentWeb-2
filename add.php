<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
</head>

<body>
    <?php
    include_once('dbconfig.in.php');
    include_once('product.php');
    my_header();
    ?>
    <hr>
    <?php

    if (isset($_POST['insert'])) {
        if (empty($_POST['name'])) {
            echo "Please enter product name";
        } elseif (empty($_POST['price'])) {
            echo "Please enter product price";
        } elseif (empty($_POST['quantity'])) {
            echo "Please enter product quantity";
        } elseif (empty($_POST['rating'])) {
            echo "Please enter product Rating";
        } elseif (empty($_POST['description'])) {
            echo "Please enter product Description";
        } elseif ($_POST['category'] === "Select Category") {
            echo "Please select a category.";
        } else {
            try {
                $pdo = conection_database();
                $sql = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 1");
                $sql->execute();
                $lastElement = $sql->fetchObject('Product');

                if (!$lastElement) {
                    $lastId = 1;  
                } else {
                    $lastId = $lastElement->getId() + 1; 
                }





                $query = "INSERT INTO products (name,category,price,quantity,rating,description,imageName) 
                            values(:name , :category , :price , :quantity , :rating , :description , :imageName)";
                $result = $pdo->prepare($query);

                $result->bindValue(':name', $_POST['name']);
                $result->bindValue(':category', $_POST['category']);
                $result->bindValue(':price', $_POST['price']);
                $result->bindValue(':quantity', $_POST['quantity']);
                $result->bindValue(':rating', $_POST['rating']);
                $result->bindValue(':description', $_POST['description']);

                if (isset($_FILES['imageName']) && !empty($_FILES['imageName']['name'])) {
                    
                    $targetDir = "images/";
                    $tempFile = $_FILES['imageName']['tmp_name'];
                    $extension = pathinfo(basename($_FILES['imageName']['name']), PATHINFO_EXTENSION); 
                    
                    $newImageName = $lastId . "." . $extension;

                    $targetFile = $targetDir  . $newImageName;
                    if (move_uploaded_file($tempFile, $targetFile)) {
                        $result->bindValue(':imageName', $targetFile);
                        $finalResult = $result->execute();
                        header('Location:products.php');
                        exit;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Please Upload photo";
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    } else {
    ?>
        <main>
            <article>
                <form action="add.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Product Record</legend>
                        <p><label>Product Name</label> <input type="text" name="name"></p>
                        <p>
                            <label>Category</label>
                            <select name="category" id="category">
                                <option name="selectCategory">Select Category</option>
                                <option name="Cap">Cap</option>
                                <option name="T-Shirt">T-Shirt</option>
                                <option name="Shoes">Shoes</option>
                            </select>
                        </p>

                        <p>
                            <label>Price <input type="text" name="price"></label>
                        </p>

                        <p>
                            <label>Quantity <input type="number" name="quantity"></label>
                        </p>

                        <p>
                            <label>Rating <input type="number" name="rating"></label>
                        </p>

                        <div>
                            <label>Description: </label>
                            <br>
                            <textarea name="description" id="description" cols="80" rows="6"></textarea>
                        </div>

                        <p>
                            <label>
                                Product Photo:
                            </label>
                            <input type="file" name="imageName">
                        </p>
                        <p>
                            <input type="submit" name="insert" value='Insert'>
                        </p>

                    </fieldset>
                </form>
            </article>
        </main>
        <hr>
    <?php
    }
    $pdo = null;
    ?>
    <br>
    <br>
    <br>

    <?php
    my_footer();
    ?>

</body>

</html>