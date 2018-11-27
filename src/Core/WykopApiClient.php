<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 19:23
 */

namespace App\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class WykopApiClient
{
    const API_URL = 'https://a2.wykop.pl/%s/appkey/%s/userkey/%s';
    const API_POST = 'post';
    const API_GET = 'get';

    private $client;
    private $appkey;
    private $secret;
    private $userKey;
    private $userName;
    private $accountKey;

    public function __construct(string $appkey, string $secret, string $userName, string $accountKey)
    {
        $this->client = new Client();
        $this->appkey = $appkey;
        $this->secret = $secret;
        $this->userName = $userName;
        $this->accountKey = $accountKey;
        $this->logIn();
    }

    public static function createFromConfig(array $config): self
    {
        return new self(
            $config['wykopApi']['appkey'],
            $config['wykopApi']['secret'],
            $config['wykopApi']['username'],
            $config['wykopApi']['accountkey']
        );
    }

    private function logIn()
    {
        $url = sprintf('https://a2.wykop.pl/%s/appkey/%s','login/index', $this->appkey);
        $body = [
            'login' => $this->userName,
            'accountkey' => $this->accountKey
        ];
        /** @var Response $response */
        $response = $this->client->post($url, [
            'form_params' => $body,
            'headers' => [
                'apisign' => $this->getApiSign($url, $body),
            ]
        ]);
        $this->userKey = json_decode($response->getBody(), true)['data']['userkey'];
    }

    public function post(string $resource, array $body = [])
    {
        return $this->doRequest($resource, self::API_POST, $body);
    }

    public function get(string $resource)
    {
        return $this->doRequest($resource, self::API_GET);
    }

    private function doRequest(string $resource, string $method, array $body = []): array
    {
        $url = sprintf(self::API_URL, $resource, $this->appkey, $this->userKey);

        $response = $this->client->$method($url, [
            'form_params' => $body,
            'headers' => [
                'apisign' => $this->getApiSign($url, $body),
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    private function getApiSign(string $url, ?array $body = null): string
    {
        if (null !== $body) {
            return md5($this->secret . $url . implode(',', $body));
        }

        return md5($this->secret . $url);
    }
}
