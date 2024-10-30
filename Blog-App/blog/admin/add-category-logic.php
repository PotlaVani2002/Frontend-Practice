<?php
session_start(); // Ensure session is started
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate inputs
    if (!$title) {
        $_SESSION['add-category'] = "Enter title";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Enter description";
    }

    // Redirect back to add-category page if there were invalid inputs
    if (isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST; // Store form data in session for repopulation
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        // Insert category into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Couldn't add category";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "Category $title added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    }
}
?>
