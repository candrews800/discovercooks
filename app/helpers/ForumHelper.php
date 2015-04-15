<?php

class ForumHelper
{
    public static function convertToHtml($text){
        $text = str_replace('[b]', '<b>', $text);
        $text = str_replace('[/b]', '</b>', $text);
        $text = str_replace('[em]', '<em>', $text);
        $text = str_replace('[/em]', '</em>', $text);
        $text = str_replace('[u]', '<u>', $text);
        $text = str_replace('[/u]', '</u>', $text);
        $text = str_replace('[ul]', '<ul>', $text);
        $text = str_replace('[/ul]', '</ul>', $text);
        $text = str_replace('[li]', '<li>', $text);
        $text = str_replace('[/li]', '</li>', $text);

        $well_count = 0;
        do{
            $text = preg_replace('/\\[bq\\]/', '<div class="well">', $text, 1, $well_count);
            if($well_count){
                $text = preg_replace('/\\[\\/bq\\]/', '</div>', $text, 1, $well_count);
                if(!$well_count){
                    $text .= "</div>";
                }
            }
        } while($well_count);

        $text .= '</b></em></u>';

        return $text;
    }
}