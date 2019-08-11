<?
// sanitize input before we store it into database
function escape($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
