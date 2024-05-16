<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A+ Products</title>
</head>

<body>
    <?php
    require_once('dbconfig.in.php');
    include_once('product.php');

    $pdo = conection_database();
    $query = 'SELECT * FROM products';
    $dbresult = $pdo->query($query);
    my_header();

    // Initialize variables
    $searchText = "";
    $category = "";


    if (isset($_POST['filter'])) {
        $searchText = isset($_POST['searchText']) ? $_POST['searchText'] : "";
        $category = isset($_POST['filter_category']) ? $_POST['filter_category'] : "";

        // Check if a category is selected from the dropdown
        if (!empty($category)) {

            // Check if the "Name" radio button is selected
            if (isset($_POST['radio']) && $_POST['radio'] == 'name' && !empty($searchText)) {
                $query = "SELECT * FROM products WHERE category = '$category' and name LIKE '%$searchText%'";
            }

            // Check if the "Price" radio button is selected and a value is entered
            else if (isset($_POST['radio']) && $_POST['radio'] == 'price' && !empty($searchText)) {
                $query = "SELECT * FROM products WHERE category = '$category' and price >= '$searchText'";
            } else {
                $query = "SELECT * FROM products WHERE category = '$category'";
            }
        } else {

            // Check if the "Name" radio button is selected
            if (isset($_POST['radio']) && $_POST['radio'] == 'name' && !empty($searchText)) {
                $query = "SELECT * FROM products WHERE  name LIKE '%$searchText%'";
            }

            // Check if the "Price" radio button is selected and a value is entered
            if (isset($_POST['radio']) && $_POST['radio'] == 'price' && !empty($searchText)) {
                $query = "SELECT * FROM products WHERE  price >= '$searchText'";
            }

            // Check if the "Category" radio button is selected
            if (isset($_POST['radio']) && $_POST['radio'] == 'category' && !empty($searchText)) {
                $query = "SELECT * FROM products WHERE  category = '$searchText'";
            }
        }

        $dbresult = $pdo->query($query);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>A+ Products</title>
    </head>

    <body>
        <hr>
        <main>
            <h4>To Add a new Product click on the following link <a href="add.php">Add Product.</a></h4>
            <section>
                <h5>Or use the actions below to edit or delete a Product's record.</h5>

                <form method="POST" action="products.php">
                    <fieldset>
                        <legend>Advanced Product Search</legend>
                        <div>

                            <input type="text" name="searchText" placeholder="Search product" value="<?php echo $searchText; ?>">
                            <input type="radio" name='radio' value='name'>Name
                            <input type="radio" name='radio' value='price'>Price
                            <input type="radio" name='radio' value='category'>Category
                            <select name="filter_category" id="filter_category">
                                <option value="">Select Category</option>
                                <option value="Cap">Cap</option>
                                <option value="T-Shirt">T-Shirt</option>
                                <option value="Shoes">Shoes</option>
                            </select>
                            <input type="submit" name="filter" value='Filter'>

                        </div>
                        <br>
                        <table border=\"0\">
                            <caption>A Plus Products</caption>
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($product = $dbresult->fetchObject('Product')) {
                                    echo $product->displayInTable();
                                }
                                ?>
                            </tbody>
                        </table>
                    </fieldset>
                </form>
            </section>
        </main>
        <hr>
        <?php
        my_footer();
        ?>
    </body>

    </html>