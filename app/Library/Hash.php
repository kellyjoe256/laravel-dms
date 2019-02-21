<?php

namespace App\Library;

/**
 * Hash Generation Class
 * @author Mayatsa
 */
class Hash {
    
    /**
     * Makes a hashed string
     * @param String $string
     * @param String $salt Optional
     * @return String
     */
    public static function make( $string, $salt = '' ) {
        return hash( 'sha256',  $string . $salt );
    }
    
    /**
     * Makes a hashed string from the timestamp to be
     * used a salt
     * @return string
     */
    public static function salt() {
        return hash( 'md5', time() );
    }

    /**
     * Generates a unique hash to be used like for a form or email token
     * @return string
     */
    public static function unique() {
        return self::make( uniqid(time(), true) );
    }

}
