<?php

global $users;
$users = [
    [
        'id' => 1,
        'username' => 'chris',
        'password' => 'abcd123'
    ],
    [
        'id' => 2,
        'username' => 'eden',
        'password' => 'ab123'
    ],
    [
        'id' => 3,
        'username' => 'florette',
        'password' => 'ad123'
    ],
    [
        'id' => 4,
        'username' => 'jahlife',
        'password' => 'abcd1235'
    ]
];

function find_user(string $username, string $password): ?array
{
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            return $user;
        }
    }
    return null;
}
