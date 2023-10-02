<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class JSONPlaceholderAPI
{
    private $client;
    private $baseUrl = 'https://jsonplaceholder.typicode.com';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getUsers()
    {
        $response = $this->client->get("$this->baseUrl/users");
        return json_decode($response->getBody(), true);
    }

    public function getUserPosts($userId)
    {
        $response = $this->client->get("$this->baseUrl/posts?userId=$userId");
        return json_decode($response->getBody(), true);
    }

    public function getUserTasks($userId)
    {
        $response = $this->client->get("$this->baseUrl/todos?userId=$userId");
        return json_decode($response->getBody(), true);
    }

    public function getPost($postId)
    {
        $response = $this->client->get("$this->baseUrl/posts/$postId");
        return json_decode($response->getBody(), true);
    }

    public function addPost($data)
    {
        $response = $this->client->post("$this->baseUrl/posts", [
            'json' => $data,
        ]);
        return json_decode($response->getBody(), true);
    }

    public function editPost($postId, $data)
    {
        $response = $this->client->put("$this->baseUrl/posts/$postId", [
            'json' => $data,
        ]);
        return json_decode($response->getBody(), true);
    }

    public function deletePost($postId)
    {
        $response = $this->client->delete("$this->baseUrl/posts/$postId");
        return $response->getStatusCode() === 200;
    }
}

// Example usage:
$api = new JSONPlaceholderAPI();

// Get users
$users = $api->getUsers();
print_r($users);

// Get user's posts
$userPosts = $api->getUserPosts(1);
print_r($userPosts);

// Get user's tasks
$userTasks = $api->getUserTasks(1);
print_r($userTasks);

// Add a new post
$newPostData = [
    'userId' => 1,
    'title' => 'New Post',
    'body' => 'This is a new post.',
];
$newPost = $api->addPost($newPostData);
print_r($newPost);

// Edit a post
$editedPostData = [
    'title' => 'Edited Post',
    'body' => 'This post has been edited.',
];
$editedPost = $api->editPost(1, $editedPostData);
print_r($editedPost);

// Delete a post
$deleted = $api->deletePost(1);
echo $deleted ? "Post deleted successfully." : "Failed to delete post.";

?>
