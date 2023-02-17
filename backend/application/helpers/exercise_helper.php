<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *   importarlo en la vista con:
 *   Importar helper: application/config/autoload.php -> $autoload['helper'] = array('exercise');
 *
 */

if (!function_exists('validate_exercise')) {
    function validate_exercise($exercise): bool {
        // validate exercise is not empty
        if (empty($exercise))
            return false;

        // validate exercise is not empty
        if (
            // validate exercise is not empty
            empty($exercise['bucket_x']) ||
            empty($exercise['bucket_y']) ||
            empty($exercise['amount_wanted_z'])
        )
            return false;

        try {
            // remove non-numeric characters
            $exercise['bucket_x'] = preg_replace("/\D+/", "", $exercise['bucket_x']);
            $exercise['bucket_y'] = preg_replace("/\D+/", "", $exercise['bucket_y']);
            $exercise['amount_wanted_z'] = preg_replace("/\D+/", "", $exercise['amount_wanted_z']);

            //string to int
            $exercise['bucket_x'] = (int)$exercise['bucket_x'];
            $exercise['bucket_y'] = (int)$exercise['bucket_y'];
            $exercise['amount_wanted_z'] = (int)$exercise['amount_wanted_z'];

            // validate exercise is positive numbers
            if (
                $exercise['bucket_x'] > 0 &&
                $exercise['bucket_y'] > 0 &&
                $exercise['amount_wanted_z'] > 0
            )
                return true;
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

}