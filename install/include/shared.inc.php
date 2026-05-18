<?php

//--------------------------------------------------------------------------
// *** remote file inclusion, check for strange characters in $_GET keys
// *** all keys with "/", "\", ":" or "%-0-0" are blocked, so it becomes virtually impossible
// *** to inject other pages or websites
foreach ($_GET as $get_key => $get_value) {
    if (is_string($get_value) && (preg_match("/\//", $get_value) || preg_match("/\[\\\]/", $get_value) || preg_match("/:/", $get_value) || preg_match("/%00/", $get_value))) {
        if (isset($_GET[$get_key])) unset($_GET[$get_key]);
        die("A hacking attempt has been detected. For security reasons, we're blocking any code execution.");
    }
}

// *** check token for POST requests
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $token_post = isset($_POST['token']) ? $_POST['token'] : 'post';
    $token_session = isset($_SESSION['token']) ? $_SESSION['token'] : 'session';

    if ($token_session != $token_post) {
        unset($_POST['task']);
    }
}
// *** check and set token
$_SESSION['token'] = md5(uniqid(rand(), true));

// 2024
/*
// *** disabling magic quotes at runtime
if(get_magic_quotes_gpc()){
    function stripslashes_gpc(&$value) {
		$value = stripslashes($value);	
	}
    array_walk_recursive($_GET, 'stripslashes_gpc');
    array_walk_recursive($_POST, 'stripslashes_gpc');
    array_walk_recursive($_COOKIE, 'stripslashes_gpc');
    if(is_array($_REQUEST)) array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}
*/

// Função para sanitizar as entradas
function sanitize_input($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Sanitizando entradas de $_GET, $_POST e $_COOKIE
foreach (['_GET', '_POST', '_COOKIE'] as $global) {
    foreach ($$global as $key => $value) {
        if (is_array($value)) {
            // Se for um array, sanitize recursivamente
            array_walk_recursive($value, function (&$item) {
                $item = sanitize_input($item);
            });
            $$global[$key] = $value; // Atualiza o valor sanitizado
        } else {
            $$global[$key] = sanitize_input($value);
        }
    }
}

// Para $_REQUEST
foreach ($_REQUEST as $key => $value) {
    $_REQUEST[$key] = sanitize_input($value);
}
