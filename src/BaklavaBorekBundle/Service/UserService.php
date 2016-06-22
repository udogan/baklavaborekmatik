<?php

namespace BaklavaBorekBundle\Service;


use Circle\RestClientBundle\Services\RestClient;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    private $restClient;
    private $serviceUrl;

    public function __construct(RestClient $restClient, $serviceUrl) {
        $this->restClient = $restClient;
        $this->serviceUrl = $serviceUrl;
    }

    public function getAllUsers() {
        return $this->parseResult($this->restClient->get($this->serviceUrl));
    }

    public function getUser($userId) {
        return $this->parseResult($this->restClient->get($this->serviceUrl . "/" . $userId));
    }

    public function createUser($user) {
        return $this->parseResult($this->restClient->post($this->serviceUrl, json_encode($user)));
    }

    public function editUser($user) {
        return $this->parseResult($this->restClient->put($this->serviceUrl, json_encode($user)));
    }

    public function deleteUser($userId) {
        return $this->parseResult($this->restClient->delete($this->serviceUrl . "/" . $userId));
    }

    private function parseResult(Response $response) {
        $content = json_decode($response->getContent());
        if ($response->isSuccessful()) {
            return $content;
        }
        throw new \Exception($content->message);
    }
}