<?php /** @noinspection PhpMissingReturnTypeInspection */
defined('BASEPATH') OR exit('No direct script access allowed');

class Exercisemodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    /**
     * @param $exercise
     * @return array
     */
    public function doExercise($exercise) {
        $res_x = $this->init_bucket();

        return [
            'exercise' => $exercise,
            'res_x' => $res_x,
            'done' => TRUE
        ];
    }

    private function init_bucket(): array {
        return [];
    }
}