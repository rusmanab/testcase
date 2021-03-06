<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class Welcome extends CI_Controller {

	public function index()
	{
		try {
			$client = new Client([
				'base_uri' => 'http://127.0.0.1:8000',
				// default timeout 5 detik
				'timeout'  => 5,
			]);
			 
			$response = $client->request('POST', '/api/product/getall', [
				'json' => [
					'api_token' => 'majoo123!@#$',
				]
			]);
			$body = $response->getBody();
			$dataProducts = json_decode($body);
			
			if (!$dataProducts->success){
				exit($dataProducts->message);
			}
			
			$data['products'] = $dataProducts->products;
			
			$this->load->view('front', $data);
		} catch (ClientException $e) {
			echo Psr7\Message::toString($e->getRequest());
			echo Psr7\Message::toString($e->getResponse());
		}
		
	}
}
