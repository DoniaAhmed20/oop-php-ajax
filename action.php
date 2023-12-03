<!-- in this page handel ajax request -->
<!-- <?php
// require_once 'db.php';
// $db = new dbConnect();

// if(isset($_POST['action']) && $_POST['action'] == "view"){
//     $output = '';
//     $data = $db->showAllUsers();
//     print_r($data);
///} -->



// To fetch data from your database using AJAX and display it on your HTML page, you'll need to create a separate PHP file that handles the database queries and returns the data in a format that can be consumed by your JavaScript code. Here's an example:

//     Create a new PHP file, let's call it fetch_users.php:


<?php

require_once 'db.php'; // Include the file where your Database class is defined

// Create an instance of your Database class
$db = new dbConnect();

// Fetch all users from the database
$users = $db->showAllUsers();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($users);