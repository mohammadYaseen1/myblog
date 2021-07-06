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

$post_arr = array(
    'status' => false,
    'message' => 'id is empty',
    'data' => null
);

// Get Id
if (isset($_GET['id'])) {
    $post->id = $_GET['id'];

    // Get post
    if ($post->read_single()) {
        // Create array
        $post_arr = array(
            'status' => true,
            'message' => 'successfully',
            'data' => array(
                'id' => $post->id,
                'title' => $post->title,
                'body' => html_entity_decode($post->body),
                'author' => $post->author,
                'category_id' => $post->category_id,
                'category_name' => $post->category_name
            )
        );
    } else {
        $post_arr['message'] = 'id dose not exist';
    }
}
echo json_encode($post_arr);