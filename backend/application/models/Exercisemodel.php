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
            'is_done' => false,
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

        // the amount_wanted_z and buckets need to be 0
        if ($exercise['amount_wanted_z'] % $exercise['bucket_x'] !== 0 && $exercise['amount_wanted_z'] % $exercise['bucket_y'] !== 0){
            return [
                'exercise' => $exercise,
                'res_y' => $status_error,
                'res_x' => $status_error
            ];
        }

        // check if amount_wanted_z is a multiple of bucket_x or bucket_y
        if ($exercise['amount_wanted_z'] % $exercise['bucket_x'] === 0 || $exercise['amount_wanted_z'] % $exercise['bucket_y'] === 0) {
            // we have to separate the logic of filling, emptying and transferring
            // we must do a process for each bucket
            // fill, empty and transfer for X
            if ($exercise['bucket_x'] < $exercise['bucket_y'] && $exercise['amount_wanted_z'] % $exercise['bucket_x'] === 0) {
                $res_x = $this->init_bucket_x(
                    $exercise['bucket_x'],
                    $exercise['bucket_y'],
                    $exercise['amount_wanted_z'],
                    'x',
                    'y'
                );

                $res_y = $this->init_bucket_y(
                    $exercise['bucket_x'],
                    $exercise['bucket_y'],
                    $exercise['amount_wanted_z'],
                    'x',
                    'y'
                );
            }

            // fill, empty and transfer Y
            if ($exercise['bucket_x'] > $exercise['bucket_y'] && $exercise['amount_wanted_z'] % $exercise['bucket_y'] === 0) {
                $res_x = $this->init_bucket_x(
                    $exercise['bucket_y'],
                    $exercise['bucket_x'],
                    $exercise['amount_wanted_z'],
                    'y',
                    'x',
                    true
                );

                $res_y = $this->init_bucket_y(
                    $exercise['bucket_y'],
                    $exercise['bucket_x'],
                    $exercise['amount_wanted_z'],
                    'y',
                    'x',
                    true
                );
            }


            return [
                'exercise' => $exercise,
                'res_x' => $res_x ?? [],
                'res_y' => $res_y ?? []
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
     * @param $main_label
     * @param $other_label
     * @param bool $is_iverted
     * @return array
     */
    private function init_bucket_x($bucket_main_limit, $bucket_other_limit, $amount_wanted_z,
                                   $main_label, $other_label, $is_iverted = false): array {
        $steps = [];
        $current_step_emergency = 0;
        $current_step = 0;
        $current_bucket_main = 0;
        $current_bucket_other = 0;

        while (true) {
            $current_step_emergency++;
            // fill bucket_main
            if ($current_bucket_main === 0) {
                $current_step++;
                $current_bucket_main = $bucket_main_limit;
                if ($is_iverted) {
                    $steps[] = [
                        'action' => "Fill bucket $main_label",
                        'current_bucket_main' => $current_bucket_other,
                        'current_bucket_other' => $current_bucket_main,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                } else {
                    $steps[] = [
                        'action' => "Fill bucket $main_label",
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }

            }

            // current_bucket_main cannot be greater than amount_wanted_z
            if ($current_bucket_other > $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'is_done' => false,
                    'step_times' => $current_step
                ];
            }

            // check if bucket_other is at amount_wanted_z
            if ($current_bucket_main === $amount_wanted_z || $current_bucket_other === $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'is_done' => true,
                    'step_times' => $current_step
                ];
            }

            // transfer from bucket_main to bucket_other
            if ($current_bucket_main > 0 && $current_bucket_other <= $bucket_other_limit) {
                $current_step++;
                $current_bucket_other = $current_bucket_main + $current_bucket_other;
                $current_bucket_main = 0;
                if ($is_iverted) {
                    $steps[] = [
                        'action' => "Transfer bucket $main_label to bucket $other_label",
                        'current_bucket_main' => $current_bucket_other,
                        'current_bucket_other' => $current_bucket_main,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                } else {
                    $steps[] = [
                        'action' => "Transfer bucket $main_label to bucket $other_label",
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }
            }

            // check if bucket_other is at amount_wanted_z
            if ($current_bucket_main === $amount_wanted_z || $current_bucket_other === $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'is_done' => true,
                    'step_times' => $current_step
                ];
            }

            // emergency break
//            if ($current_step_emergency > 100)
//                return [
//                    'ERROR *WHILE*',
//                    $steps
//                ];
        }
    }

    /**
     * @param $bucket_main_limit
     * @param $bucket_other_limit
     * @param $amount_wanted_z
     * @param $main_label
     * @param $other_label
     * @param bool $is_iverted
     * @return array
     */
    private function init_bucket_y($bucket_main_limit, $bucket_other_limit, $amount_wanted_z,
                                   $main_label, $other_label, $is_iverted = false){
        $steps = [];
        $current_step_emergency = 0;
        $current_step = 0;
        $current_bucket_main = 0;
        $current_bucket_other = 0;

        while (true) {
            $current_step_emergency++;
            // fill bucket_main
            if ($current_bucket_other === 0) {
                $current_step++;
                $current_bucket_other = $bucket_other_limit;
                if ($is_iverted) {
                    $steps[] = [
                        'action' => "Fill bucket $other_label",
                        'current_bucket_main' => $current_bucket_other,
                        'current_bucket_other' => $current_bucket_main,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                } else {
                    $steps[] = [
                        'action' => "Fill bucket $other_label",
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }
            }

            // current_bucket_main cannot be less than amount_wanted_z
            if ($current_bucket_other < $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'is_done' => false,
                    'step_times' => $current_step
                ];
            }

            // check if bucket_other is at amount_wanted_z
            if ($current_bucket_main === $amount_wanted_z || $current_bucket_other === $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'is_done' => true,
                    'step_times' => $current_step
                ];
            }

            // transfer from bucket_other to bucket_main
            if ($current_bucket_other > 0 && $current_bucket_main <= $bucket_main_limit) {
                $current_step++;
                $current_bucket_other = $current_bucket_other - $bucket_main_limit;
                $current_bucket_main = $bucket_main_limit;
                if ($is_iverted) {
                    $steps[] = [
                        'action' => "Transfer bucket $other_label to bucket $main_label",
                        'current_bucket_main' => $current_bucket_other,
                        'current_bucket_other' => $current_bucket_main,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                } else {
                    $steps[] = [
                        'action' => "Transfer bucket $other_label to bucket $main_label",
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }


            }

            // check if bucket_other is at amount_wanted_z
            if ($current_bucket_main === $amount_wanted_z || $current_bucket_other === $amount_wanted_z) {
                return [
                    'steps' => $steps,
                    'is_done' => true,
                    'step_times' => $current_step
                ];
            }

            // dump bucket_main
            if ($current_bucket_main > 0) {
                $current_step++;
                $current_bucket_main = 0;
                if ($is_iverted) {
                    $steps[] = [
                        'action' => "Dump bucket $main_label",
                        'current_bucket_main' => $current_bucket_other,
                        'current_bucket_other' => $current_bucket_main,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                } else {
                    $steps[] = [
                        'action' => "Dump bucket $main_label",
                        'current_bucket_main' => $current_bucket_main,
                        'current_bucket_other' => $current_bucket_other,
                        'amount_wanted_z' => $amount_wanted_z
                    ];
                }

            }

            // emergency break
//            if ($current_step_emergency > 100)
//                return [
//                    'ERROR *WHILE*',
//                    $steps
//                ];
        }
    }
}