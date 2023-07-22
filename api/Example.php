<?php
require 'JsonPlaceholderApi.php';

// Создаем объект класса JsonPlaceholderApi
$api = new JsonPlaceholderApi();

// Получение всех пользователей
$users = $api->getUsers();
// print_r($users);

// Получение постов пользователя по его ID
$userPosts = $api->getUserPosts(1);
// print_r($userPosts);

// Получение заданий (todos) пользователя по его ID
$userTodos = $api->getUserTodos(1);
// print_r($userTodos);


// Добавление нового поста
$newPostData = [
    'title' => 'Новый пост',
    'body' => 'Содержание нового поста',
    'userId' => 1
];
// $createdPost = $api->manipulatePost(101, $newPostData, 'POST');
try {
    // Call the manipulatePost method with the correct parameters
    $createdPost = $api->manipulatePost(null, $newPostData, 'POST');
    // print_r($createdPost);

    // Редактирование существующего поста (например, ID = 1)
    $updatedPostData = [
        'title' => 'Обновленный пост',
        'body' => 'Обновленное содержание поста',
    ];
    $updatedPost = $api->manipulatePost(1, $updatedPostData, 'PUT');
    print_r($updatedPost);

    // Удаление поста 
    $isDeleted = $api->manipulatePost(1, [], 'DELETE');
    echo "Пост успешно удален: " . ($isDeleted ? 'Да' : 'Нет');
} catch (GuzzleHttp\Exception\ClientException $e) {
    // Handle the API error here if needed
    echo 'Error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle other exceptions if needed
    echo 'Error: ' . $e->getMessage();
}
