<?php

// the task was not really clear; I never implemented abstractions of XMLHttpRequest in PHP code, and hardly understand business purpose of this; so, I guess my implementation is not correct, but I tried the best possible solution

class BusinessLogicService
{
    protected $service;
    protected $url;

    public function __construct(TransportLayerService $service, string $url)
    {
        $this->service = $service;
        $this->url = $url;
    }

    public function get(array $options = [])
    {
        $this->service->request($this->url, 'GET', $options);
    }

    public function post(array $data, array $options = [])
    {
        $this->service->request($this->url, 'POST', $data, $options);
    }
}
