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
        $status_error = ['action' => 'NOT POSSIBLE',
            'current_bucket_main' => null,
            'current_bucket_other' => null,
            'amount_wanted_z' => null];

        // the amount_wanted_z cannot be greater than the bucket_x and bucket_y
        if ($exercise['amount_wanted_z'] > $exercise['bucket_x'] && $exercise['amount_wanted_z'] > $exercise['bucket_y']) {
            return [
                'exercise' => $exercise,
                'res_y' => $status_error,
                'res_x' => $status_error
            ];
        }

        // check if amount_wanted_z is a multiple of bucket_x or bucket_y
        if ($exercise['amount_wanted_z'] % $exercise['bucket_x'] === 0 || $exercise['amount_wanted_z'] % $exercise['bucket_y'] === 0) {
            $res_x = $this->init_bucket_x(
                $exercise['bucket_x'],
                $exercise['bucket_y'],
                $exercise['amount_wanted_z']
            );

            $res_y = $this->init_bucket_y(
                $exercise['bucket_x'],
                $exercise['bucket_y'],
                $exercise['amount_wanted_z']
            );

            return [
                'exercise' => $exercise,
                'res_y' => $res_y,
                'res_x' => $res_x
            ];
        }

        return [
            'exercise' => $exercise,
            'res_y' => $status_error,
            'res_x' => $status_error
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
    private function init_bucket_x($bucket_main_limit, $bucket_other_limit, $amount_wanted_z): array {
        if ($bucket_main_limit <= $amount_wanted_z) {
            $steps = [];
            $current_step = 0;
            $current_bucket_main = 0;
            $current_bucket_other = 0;

            while (true){
                // fill bucket_main
                if ($current_bucket_main === 0) {
                    $current_step++;
                    $current_bucket_main = $bucket_main_limit;
                    $steps[] = [
                        'action' => 'Fill bucket x',
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }

                // check if bucket_other is at amount_wanted_z
                if ($current_bucket_other === $amount_wanted_z) {
                    return [
                        'steps' => $steps,
                        'step_times' => $current_step
                    ];
                }

                // transfer from bucket_main to bucket_other
                if ($current_bucket_main > 0 && $current_bucket_other <= $bucket_other_limit) {
                    $current_step++;
                    $current_bucket_other = $current_bucket_main + $current_bucket_other;
                    $current_bucket_main = 0;
                    $steps[] = [
                        'action' => 'Transfer bucket x to bucket y',
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }

                // check if bucket_other is at amount_wanted_z
                if ($current_bucket_other === $amount_wanted_z) {
                    return [
                        'steps' => $steps,
                        'step_times' => $current_step
                    ];
                }

                // emergency break
                if ($current_step > 100) {
                    return [];
                }
            }
        }

        return [];
    }

    private function init_bucket_y($bucket_main_limit, $bucket_other_limit, $amount_wanted_z){
        $steps = [];
        $current_step = 0;
        $current_bucket_main = 0;
        $current_bucket_other = 0;

        while (true) {
            // fill bucket_main
            if ($current_bucket_other === 0) {
                $current_step++;
                $current_bucket_other = $bucket_other_limit;
                $steps[] = [
                    'action' => 'Fill bucket y',
                    'current_bucket_main' => $current_bucket_main,
                    'current_bucket_other' => $current_bucket_other,
                    'amount_wanted_z' => $amount_wanted_z
                ];
            }

            // check if bucket_other is at amount_wanted_z
            if ($current_bucket_other === $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'step_times' => $current_step
                ];
            }

            // transfer from bucket_other to bucket_main
            if ($current_bucket_other > 0 && $current_bucket_main <= $bucket_main_limit) {
                $current_step++;
                $current_bucket_other = $current_bucket_other - $bucket_main_limit;
                $current_bucket_main = $bucket_main_limit;
                $steps[] = [
                    'action' => 'Transfer bucket y to bucket x',
                    'current_bucket_main' => $current_bucket_main,
                    'current_bucket_other' => $current_bucket_other,
                    'amount_wanted_z' => $amount_wanted_z
                ];
            }

            // check if bucket_other is at amount_wanted_z
            if ($current_bucket_other === $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'step_times' => $current_step
                ];
            }

            // dump bucket_main
            if ($current_bucket_main > 0) {
                $current_step++;
                $current_bucket_main = 0;
                $steps[] = [
                    'action' => 'Dump bucket x',
                    'current_bucket_main' => $current_bucket_main,
                    'current_bucket_other' => $current_bucket_other,
                    'amount_wanted_z' => $amount_wanted_z
                ];
            }
        }

    }
}