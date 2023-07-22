<?php
require '../vendor/autoload.php';


use GuzzleHttp\Client;

class JsonPlaceholderApi
{

    private $baseUri = "https://jsonplaceholder.typicode.com";

    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->baseUri]);
    }

    // Метод для получения пользователей
    public function getUsers()
    {
        $response = $this->client->get('/users');
        return json_decode($response->getBody(), true);
    }

    // Метод для получения постов пользователя по его ID
    public function getUserPosts($userId)
    {
        $response = $this->client->get("/users/$userId/posts");
        return json_decode($response->getBody(), true);
    }


    // Метод для получения заданий (todos) пользователя по его ID
    public function getUserTodos($userId)
    {
        $response = $this->client->get("/users/$userId/todos");
        return json_decode($response->getBody(), true);
    }

    // Метод для работы с конкретным постом (добавление / редактирование / удаление)
    public function manipulatePost($postId, $data = [], $method = 'GET')
    {
        $supportedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
        if (!in_array($method, $supportedMethods)) {
            //  throw new Exception('Unsupported HTTP method.');
        }
        
        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            if (empty($data)) {
                throw new Exception('Data is required for POST, PUT, and PATCH methods.');
            }
    
            // Additional validation for POST or PUT data can be added here
            if (!isset($data['title']) || !isset($data['body']) || !isset($data['userId'])) {
                throw new Exception('POST or PUT data must contain title, body, and userId fields.');
            }
        }

        $options = [];
        if ($method !== 'GET') {
            $options['json'] = $data;
        }

        $response = $this->client->request($method, "/posts/{$postId}", $options);

        if ($method === 'DELETE') {
            return true; // Если удаление успешно, вернем true
        }

        return json_decode($response->getBody(), true);
    }
}