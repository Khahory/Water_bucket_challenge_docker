<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Exercise  extends REST_Controller  {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('exercisemodel');
    }

    /**
     * @api {post} /api/v1/exercise Exercise
     * @apiSampleRequest http://localhost:4444/backend/api/v1/exercise
     * @return void
     */
    public function index_post() {
        $exercise = $this->post('exercise');

        // validate exercise, if not valid, return error
        $is_valid = validate_exercise($exercise);
        if (!$is_valid) {
            $this->response([
                'status' => FALSE,
                'message' => 'Exercise is not valid!',
                'data' => $exercise,
                'is_valid' => FALSE
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }


        $exercise_done = $this->exercisemodel->doExercise($exercise);
        $this->response([
            'status' => TRUE,
            'message' => 'Exercise done!',
            'data' => $exercise_done,
            'is_valid' => TRUE
        ], REST_Controller::HTTP_OK);
    }

}