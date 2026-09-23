<?php
require_once('database.php');

$category_name = filter_input(INPUT_POST, 'category_name');

if ($category_name == null || trim($category_name) == '') {

    $error = "Invalid category name. Check the field and try again.";

    include('error.php');

} else {

    $category_name = trim($category_name);

    $query = 'INSERT INTO categories
              (categoryName)
              VALUES
              (:category_name)';

    $statement = $db->prepare($query);

    $statement->bindValue(':category_name', $category_name);

    $statement->execute();

    $statement->closeCursor();

    include('category_list.php');
}
?>