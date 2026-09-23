<?php
require_once('database.php');

$category_id = filter_input(
    INPUT_GET,
    'category_id',
    FILTER_VALIDATE_INT
);

if ($category_id == false) {
    $error = "Invalid category ID.";
    include('error.php');
    exit();
}

$query = 'SELECT *
          FROM categories
          WHERE categoryID = :category_id';

$statement = $db->prepare($query);

$statement->bindValue(
    ':category_id',
    $category_id
);

$statement->execute();

$category = $statement->fetch();

$statement->closeCursor();

if ($category == false) {
    $error = "Category not found.";
    include('error.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $category_name = filter_input(
        INPUT_POST,
        'category_name'
    );

    if ($category_name == null || trim($category_name) == '') {

        $error = "Invalid category name. Check the field and try again.";

        include('error.php');
        exit();

    }

    $category_name = trim($category_name);

    $query = 'UPDATE categories
              SET categoryName = :category_name
              WHERE categoryID = :category_id';

    $statement = $db->prepare($query);

    $statement->bindValue(
        ':category_name',
        $category_name
    );

    $statement->bindValue(
        ':category_id',
        $category_id
    );

    $statement->execute();

    $statement->closeCursor();

    include('category_list.php');

    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>

<header>
    <h1>Product Manager</h1>
</header>

<main>

    <h1>Update Category</h1>

    <form action="update_category.php"
          method="post"
          id="add_category_form">

        <input type="hidden"
               name="category_id"
               value="<?php echo $category['categoryID']; ?>">

        <label>Name:</label>

        <input type="text"
               name="category_name"
               value="<?php echo htmlspecialchars($category['categoryName']); ?>">

        <input type="submit" value="Update">

    </form>

    <p>
        <a href="category_list.php">Category List</a>
    </p>

</main>

<footer>

    <p>
        &copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.
    </p>

</footer>

</body>

</html>