<?php

class SomeObject {
    protected $name;

    public function __construct(string $name) { }

    public function getObjectName() { }
}

class SomeObjectsHandler {
    protected $configuration = [
        'object_1' => 'handle_object_1',
        'object_2' => 'handle_object_2',
    ];

    public function __construct() { }

    public function handleObjects(array $objects): array {
        $handlers = [];
        foreach ($objects as $object) {
            if (isset($this->configuration[$object->getObjectName()])) {
                $handlers[] = $this->configuration[$object->getObjectName()];
            }
        }

        return $handlers;
    }
}

$objects = [
    new SomeObject('object_1'),
    new SomeObject('object_2')
];

$soh = new SomeObjectsHandler();
$soh->handleObjects($objects);