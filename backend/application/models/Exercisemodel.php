<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Exercisemodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function doExercise($exercise) {
        return $exercise;
    }
}