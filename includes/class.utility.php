<?php

Class Utility {
   public function generateString($size = 16) {
       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

       $string = null;

       for ($i=0;$i<$size;$i++) {
           $index = rand(0, strlen($characters) - 1);
           $string .= $characters[$index];
       }

       return $string;
   }
}