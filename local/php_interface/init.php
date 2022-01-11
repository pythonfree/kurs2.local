<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (is_readable($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/constants.php')) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/constants.php';
}

if (is_readable($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/functions.php')) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/functions.php';
}

if (is_readable($_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/agent.php')) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/local/php_interface/include/agent.php';
}