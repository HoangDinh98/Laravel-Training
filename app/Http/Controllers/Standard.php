<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of Standard
 *
 * @author admin
 */
class Standard {
    public static function standardize_data($data, $is_name) {
        $data = preg_replace('/\s{2,}/', ' ', $data);
        $data = trim($data);
        if($is_name == 1) {
            $data = title_case($data);
//            $data = ucwords($data);
        } else {
            $data = ucfirst($data);
        }
        
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
