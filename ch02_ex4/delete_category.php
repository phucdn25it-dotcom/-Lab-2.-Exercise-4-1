<?php
require_once('database.php');

$category_id = filter_input(
    INPUT_POST,
    'category_id',
    FILTER_VALIDATE_INT
);

if ($category_id != false) {

    $query = 'DELETE FROM categories
              WHERE categoryID = :category_id';

    $statement = $db->prepare($query);

    $statement->bindValue(
        ':category_id',
        $category_id
    );

    $statement->execute();

    $statement->closeCursor();
}

include('category_list.php');
?>