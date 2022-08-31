<?php

// stored in configuration file
$globalConfiguration = [
    // initialized on application initialization
    'storage' => 'file',
    'drivers' => [
        'file' => [
            'class' => FileDriver::class,
            'path' => '/secure/path',
        ],
        'database' => [
            'class' => DbDriver::class,
            'dsn' => '....',
        ],
    ],
];

interface IStorage
{
    public function getValue($key);
}

class FileDriver implements IStorage
{
    public function getValue($key)
    {
        // TODO: Implement getValue() method.
    }
}

class DbDriver implements IStorage
{
    public function getValue($key)
    {
        // TODO: Implement getValue() method.
    }
}

class Concept {
    private $client;
    private $storage;

    private const SECRET_KEY_NAME = 'secret-key-for-concept';

    public function __construct(IStorage $storage) {
        $this->client = new \GuzzleHttp\Client();
        $this->storage = $storage;
    }

    public function getUserData() {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->getSecretKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }

    private function getSecretKey()
    {
        return $this->storage->getValue(self::SECRET_KEY_NAME);
    }
}