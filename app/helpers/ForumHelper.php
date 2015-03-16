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
        $text = str_replace('[bq]', '<blockquote>', $text);
        $text = str_replace('[/bq]', '</blockquote>', $text);
        $text .= '</b></em></u></blockquote>';

        return $text;
    }
}