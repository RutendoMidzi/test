<?php

require 'vendor/autoload.php'; 

use GuzzleHttp\Client;

class JsonPlaceholderAPI
{
    private $baseUri;
    private $httpClient;

    public function __construct()
    {
        $this->baseUri = 'https://jsonplaceholder.typicode.com';
        $this->httpClient = new Client(['base_uri' => $this->baseUri]);
    }

    public function getUsers()
    {
        $response = $this->httpClient->get('/users');
        return json_decode($response->getBody(), true);
    }

    public function getUserPosts($userId)
    {
        $response = $this->httpClient->get("/users/{$userId}/posts");
        return json_decode($response->getBody(), true);
    }

    public function getUserTasks($userId)
    {
        $response = $this->httpClient->get("/users/{$userId}/todos");
        return json_decode($response->getBody(), true);
    }

    public function getPost($postId)
    {
        $response = $this->httpClient->get("/posts/{$postId}");
        return json_decode($response->getBody(), true);
    }

    public function addPost($userId, $title, $body)
    {
        $response = $this->httpClient->post('/posts', [
            'json' => [
                'userId' => $userId,
                'title' => $title,
                'body' => $body,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    public function editPost($postId, $title, $body)
    {
        $response = $this->httpClient->put("/posts/{$postId}", [
            'json' => [
                'title' => $title,
                'body' => $body,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    public function deletePost($postId)
    {
        $response = $this->httpClient->delete("/posts/{$postId}");
        return $response->getStatusCode() === 200;
    }
}

// Example usage
$jsonPlaceholder = new JsonPlaceholderAPI();

// Get users
$users = $jsonPlaceholder->getUsers();
print_r($users);

// Get user posts
$userPosts = $jsonPlaceholder->getUserPosts(1);
print_r($userPosts);

// Get user tasks
$userTasks = $jsonPlaceholder->getUserTasks(1);
print_r($userTasks);

// Add a new post
$newPost = $jsonPlaceholder->addPost(1, 'New Post Title', 'New Post Body');
print_r($newPost);

// Edit a post
$editedPost = $jsonPlaceholder->editPost(1, 'Edited Post Title', 'Edited Post Body');
print_r($editedPost);

// Delete a post
$deleteResult = $jsonPlaceholder->deletePost(1);
var_dump($deleteResult);
