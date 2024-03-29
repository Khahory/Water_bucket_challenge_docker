<?php defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

/** @noinspection PhpUnused */
class Exercise  extends REST_Controller  {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('exercisemodel');
    }

    /**
     * @noinspection PhpUnused
     * @api {post} /api/v1/exercise Exercise
     * @apiSampleRequest http://localhost:4444/backend/api/v1/exercise
     * @return void
     */
    public function index_post() {
        $exercise = $this->request->body;
        // json to array
        $exercise = json_decode($exercise[0], true);

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


        // prepare exercise
        $input_exercise = [
            'bucket_x' => (int) $exercise['bucket_x'],
            'bucket_y' => (int) $exercise['bucket_y'],
            'amount_wanted_z' => (int) $exercise['amount_wanted_z']
        ];

        // do exercise
        $exercise_done = $this->exercisemodel->doExercise($input_exercise);
        $this->response([
            'status' => TRUE,
            'message' => 'Exercise done!',
            'data' => $exercise_done,
            'is_valid' => TRUE
        ], REST_Controller::HTTP_OK);
    }
}