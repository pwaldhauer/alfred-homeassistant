<?php

namespace HomeassistantAlfred;

use GuzzleHttp\Client;

class Api
{
    private $client = null;

    private function client()
    {
        if (empty($this->client)) {
            $token = getenv('token');

            $this->client = new Client([
                'connect_timeout' => 1,
                'base_uri' => getenv('url'),
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
        }

        return $this->client;
    }

    public function get($url): array
    {
        try {
            $response = $this->client()->get($url);
            return json_decode(
                $response->getBody()->getContents(),
                true
            );
        } catch (\Exception $e) {
            return [];
        }
    }

    public function post($url, $payload): array
    {
        try {
            $response = $this->client()->post($url, [
                'body' => json_encode($payload),
            ]);

            $json = json_decode($response->getBody(), true);
            if (empty($json)) {
                return [];
            }

            return $json[0];
        } catch (\Exception $e) {
            return [];
        }
    }
}
