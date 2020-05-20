<?php
class FormSanitizer{

    //static class: don't need to create instance of the class to use it. Don't need to "new" it.
    public static function sanitizeFormString($inputText){
        $inputText = strip_tags($inputText);
        //get rid of every space in this text
        $inputText = str_replace(" ","",$inputText);
        //get rid of spaces before and after the string, but remain the spaces inside the string
        //$inputText = trim($inputText);
        //lower case each char
        $inputText = strtolower($inputText);
        //upper case the first char
        $inputText = ucfirst($inputText);
        return $inputText;
    }

    public static function sanitizeFormUsername($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText){
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText){
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        return $inputText;
    }
}
?>