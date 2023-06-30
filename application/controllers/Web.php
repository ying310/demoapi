<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Web extends REST_Controller
{
	private $module_name;
	function __construct() {
		parent::__construct();
		$this->load->helper("format_helper");
		$this->module_name = "Web";
		$this->load->model('Web_m');
	}

	function user_get() {
		try {
			$user = [
				'name' => '吳建穎',
				'english_name' => 'Tony',
				'birthday' => '1996/09/08',
				'phone' => '0980723509',
				'birthplace' => '台灣省桃園市',
				'email' => 'h0980723509@gmail.com',
			];
			$response_message = [
				'success' => true,
				'code' => '0000',
				"data" => $user,
				"errors" => false,
			];
			$this->set_response($response_message, REST_Controller::HTTP_OK);
		} catch(Exception $e) {
			$code = $e->getCode();
			$response_message = [
				'success' => false,
				'code' => '0001',
				"data" => '',
				"errors" => $e->getMessage(),
			];
			$this->set_response($response_message, REST_Controller::HTTP_OK);
		}
	}

	function message_post() {
		try {
			$input = file_get_contents("php://input");
            //  檢查空值
            if (empty($input)) {
				throw new Exception("No data");
            }
            //  檢查 JSON 格式
            if (!isJSON($input)) {
				throw new Exception("Input data format is wrong");
            }
            $input_array = json_decode($input, true);
			if (!isset($input_array['name']) || strlen($input_array['name']) === 0) {
				throw new Exception("Input data format is wrong");
			}
			if (!isset($input_array['email']) || strlen($input_array['email']) === 0) {
				throw new Exception("Input data format is wrong");
			}
			$insert = [
				'name' => $input_array['name'],
				'email' => $input_array['email'],
				'suggest' => $input_array['suggest']
			];

			$id = $this->Web_m->addMessage($insert);
			if(!$id) {
				throw new Exception('Insert Failed');
			}
            
			$response_message = [
				'success' => true,
				'code' => '0000',
				"data" => 'success',
				"errors" => false,
			];
			$this->set_response($response_message, REST_Controller::HTTP_OK);
		} catch(Exception $e) {
			$code = $e->getCode();
			$response_message = [
				'success' => false,
				'code' => '0001',
				"data" => '',
				"errors" => $e->getMessage(),
			];
			$this->set_response($response_message, REST_Controller::HTTP_OK);
		}
	}

	function message_get() {
		try {
			$data = $this->Web_m->getMessage();
			if(!is_array($data)) {
				throw new Exception('Get data failed');
			}
            
			$response_message = [
				'success' => true,
				'code' => '0000',
				"data" => $data,
				"errors" => false,
			];
			$this->set_response($response_message, REST_Controller::HTTP_OK);
		} catch(Exception $e) {
			$code = $e->getCode();
			$response_message = [
				'success' => false,
				'code' => '0001',
				"data" => '',
				"errors" => $e->getMessage(),
			];
			$this->set_response($response_message, REST_Controller::HTTP_OK);
		}
	}
}
