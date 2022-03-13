<?php

namespace Kingofhardware;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 *
 */
class ShopwareAuthentication
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var
     */
    private $shop_url;

    /**
     * @var string
     */
    private string $oauth_endpoint = '/api/oauth/token';

    /**
     * @var array|false|string
     */
    private $grant_type = 'client_credentials';

    /**
     * @var array|false|string
     */
    private $client_id;

    /**
     * @var array|false|string
     */
    private $client_secret;

    /**
     * The token type
     * in shopware was bearer
     * @var string
     */
    private string $token_type;

    /**
     * @var string
     */
    private string $token;

    /**
     * Store the time
     * how the token expires
     * @var int
     */
    private int $expires_in;


    /**
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client();

        if (isset($config['shop_url'])) {
            $this->shop_url = $config['shop_url'];
        }

        if (isset($config['client_id'])) {
            $this->client_id = $config['client_id'];
        }

        if (isset($config['client_secret'])) {
            $this->client_secret = $config['client_secret'];
        }
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getShopUrl()
    {
        return $this->shop_url;
    }

    /**
     * @param mixed $shop_url
     */
    public function setShopUrl($shop_url): void
    {
        $this->shop_url = $shop_url;
    }

    /**
     * @return string
     */
    public function getOauthEndpoint(): string
    {
        return $this->oauth_endpoint;
    }

    /**
     * @param string $oauth_endpoint
     */
    public function setOauthEndpoint(string $oauth_endpoint): void
    {
        $this->oauth_endpoint = $oauth_endpoint;
    }

    /**
     * @return array|false|string
     */
    public function getGrantType()
    {
        return $this->grant_type;
    }

    /**
     * @param array|false|string $grant_type
     */
    public function setGrantType($grant_type): void
    {
        $this->grant_type = $grant_type;
    }

    /**
     * @return array|false|string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param array|false|string $client_id
     */
    public function setClientId($client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return array|false|string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * @param array|false|string $client_secret
     */
    public function setClientSecret($client_secret): void
    {
        $this->client_secret = $client_secret;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->token_type;
    }

    /**
     * @param string $token_type
     */
    public function setTokenType(string $token_type): void
    {
        $this->token_type = $token_type;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expires_in;
    }

    /**
     * @param int $expires_in
     */
    public function setExpiresIn(int $expires_in): void
    {
        $this->expires_in = $expires_in;
    }


    /**
     * @throws GuzzleException
     * @throws Exception
     * @version 1.0.0
     */
    public function buildToken(): ShopwareAuthentication
    {
        $payload = [
            "grant_type"    => $this->getGrantType(),
            "client_id"     => $this->getClientId(),
            "client_secret" => $this->getClientSecret(),
        ];

        $payload = json_encode($payload);

        // query new token
        $response = $this->client->request('POST', 'https://'.$this->getShopUrl().$this->getOauthEndpoint(), [
            'headers' => [
                'Authorization' => '',
                'Content-Type'  => 'application/json',
            ],
            'body'    => $payload,
        ]);

        // response handle errors
        if ($response->getStatusCode() != 200) {
            throw new Exception('Error cant load new token from shopware api', 'danger');
        }

        $token_data = json_decode($response->getBody(), true);

        // return token and save
        if (!isset($token_data['access_token'])) {
            throw new Exception('Token error');
        }

        $this->setToken($token_data['access_token']);
        $this->setTokenType($token_data['token_type']);
        $this->setExpiresIn(time() + $token_data['expires_in']);

        return $this;
    }

}