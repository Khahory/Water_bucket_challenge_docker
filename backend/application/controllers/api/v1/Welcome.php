<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Welcome  extends REST_Controller  {

    function __construct() {
        // Construct the parent class
        parent::__construct();
    }

    /**
     * @api {get} /api/v1/welcome Welcome
     * @apiSampleRequest http://localhost:4444/backend/api/v1/welcome
     * @return void
     */
    public function index_get() {
        $this->response([
            'status' => TRUE,
            'message' => 'Welcome to the Backend API v1'
        ], REST_Controller::HTTP_OK);
    }

}