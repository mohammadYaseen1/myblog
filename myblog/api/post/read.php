<?php

// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate(create/تجسيد) DB & conn
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$post = new Post($db);

// Blog post query
$result = $post->read();

// Get row count
$num = $result->rowCount();
// $num = 0;
$posts_arr = [];
$posts_arr['status'] = false;
$posts_arr['message'] = 'لم ينم تسجيل الدخول بنجاح';
$posts_arr['data'] = null;
// Check if any post
if ($num > 0) {
    // Post array
    $posts_arr['data'] = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // Push to "data"
        array_push($posts_arr['data'], $post_item);
        $posts_arr['status'] = true;
        $posts_arr['message'] = 'نم تسجيل الدخول';
    }

    // Turn to JSON & potput
}
echo json_encode($posts_arr);