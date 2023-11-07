<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
class OrderTest extends TestCase
{
    private $apiKey = 'oYumx8u1uvisaEFjfC2PiU9WyzIn+UE4pkTKqQW4Klo';
    private $accessToken = '9|yXe6sNqPmkq8edHWJBUjZkYvIHlAA5WDTF02CrUt';
    private $productCode = 'ZH9R6GDL8S';
    private $phone = '0000000000';
    private $qty = 1;

    private $deliveryAddress = 'delivery_address';

    private $billingAddress = 'billing_address';
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_order()
    {
        $this->withHeaders([
            'Authorization' => "Bearer " . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [
            'product_code' => $this->productCode,
            'phone' => $this->phone,
            'qty' => $this->qty,
            'delivery_address' => $this->deliveryAddress,
            'billing_address' => $this->billingAddress
        ])
            ->assertStatus(200);
    }

    public function test_create_order_without_apikey()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->json('POST', 'api/order', [

        ])
            ->assertStatus(401);
    }

    public function test_create_order_without_auth()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [

        ])
            ->assertStatus(401);
    }

    public function test_create_order_without_body()
    {
        $this->withHeaders([
            'Authorization' => "Bearer " . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [

        ])
            ->assertStatus(400);
    }

    public function test_create_order_product_empty()
    {
        $this->withHeaders([
            'Authorization' => "Bearer " . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [
            'qty' => $this->qty,
            'phone' => $this->phone,
            'delivery_address' => $this->deliveryAddress,
            'billing_address' => $this->billingAddress,
        ])
            ->assertStatus(400);
    }

    public function test_create_order_phone_empty()
    {
        $this->withHeaders([
            'Authorization' => "Bearer " . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [
            'product_code' => $this->productCode,
            'qty' => $this->qty,
            'delivery_address' => $this->deliveryAddress,
            'billing_address' => $this->billingAddress,
        ])
            ->assertStatus(400);
    }

    public function test_create_order_qty_empty()
    {
        $this->withHeaders([
            'Authorization' => "Bearer " . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [
            'product_code' => $this->productCode,
            'phone' => $this->phone,
            'delivery_address' => $this->deliveryAddress,
            'billing_address' => $this->billingAddress,
        ])
            ->assertStatus(400);
    }

    public function test_create_order_delivery_address_empty()
    {
        $this->withHeaders([
            'Authorization' => "Bearer " . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [
            'product_code' => $this->productCode,
            'phone' => $this->phone,
            'qty' => $this->qty,
            'delivery_address' => $this->deliveryAddress
        ])
            ->assertStatus(400);
    }

    public function test_create_order_billing_address_empty()
    {
        $this->withHeaders([
            'Authorization' => "Bearer " . $this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-API-KEY' => $this->apiKey
        ])->json('POST', 'api/order', [
            'product_code' => $this->productCode,
            'phone' => $this->phone,
            'qty' => $this->qty,
            'delivery_address' => $this->deliveryAddress
        ])
            ->assertStatus(400);
    }
}
