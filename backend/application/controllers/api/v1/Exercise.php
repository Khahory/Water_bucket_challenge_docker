<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Exercise  extends REST_Controller  {

    function __construct() {
        // Construct the parent class
        parent::__construct();
    }

    /**
     * @api {post} /api/v1/exercise Exercise
     * @apiSampleRequest http://localhost:4444/backend/api/v1/exercise
     * @return void
     */
    public function index_post() {
        $exercise = $this->post('exercise');
//        $bucket_x = $this->post('bucket_x');
//        $bucket_y = $this->post('bucket_y');
//        $amount_wanted_z = $this->post('amount_wanted_z');

        $this->response([
            'status' => TRUE,
            'message' => 'Exercise',
            'data' => $exercise
        ], REST_Controller::HTTP_OK);
    }

}