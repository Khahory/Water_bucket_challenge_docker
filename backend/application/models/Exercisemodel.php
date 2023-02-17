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
        $res_x = $this->init_bucket(
            $exercise['bucket_x'],
            $exercise['bucket_y'],
            $exercise['amount_wanted_z']
        );

        return [
            'exercise' => $exercise,
            'res_x' => $res_x,
            'done' => TRUE
        ];
    }

    /**
     * @clues:
     * if bucket_main <= amount_wanted_z then add (fill)
     * if bucket_main >= amount_wanted_z then subtract (dump)
     * @param $bucket_main_limit
     * @param $bucket_other_limit
     * @param $amount_wanted_z
     * @return array
     */
    private function init_bucket($bucket_main_limit, $bucket_other_limit, $amount_wanted_z): array {
        if ($bucket_main_limit <= $amount_wanted_z) {
            $steps = [];
            $current_step = 0;
            $current_bucket_main = 0;
            $current_bucket_other = 0;

            while (true){
                $current_step++;
                // fill bucket_main
                if ($current_bucket_main === 0) {
                    $current_bucket_main = $bucket_main_limit;
                    $steps[] = [
                        'action' => 'fill',
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }

                // transfer from bucket_main to bucket_other
                if ($current_bucket_main > 0 && $current_bucket_other <= $bucket_other_limit) {
                    $current_bucket_other = $current_bucket_main + $current_bucket_other;
                    $current_bucket_main = 0;
                    $steps[] = [
                        'action' => 'transfer',
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }

                // check if bucket_other is at amount_wanted_z
                if ($current_bucket_other === $amount_wanted_z) {
                    return $steps;
                }

                // emergency break
                if ($current_step > 100) {
                    return [];
                }
            }
        }

        return [];
    }
}