<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:48:12
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

try {


    $prefix = DB_PREFIX;
    $table_name = $prefix . "sbb_visitorslog";

    $query = "SELECT * FROM " . $table_name . "
    WHERE `bot` = '0'";

    $result = $conn->query($query);

    if (!$result) {
        echo 'Error: Query failed. ' . $conn->error;
        return;
    }

    $quantos_humanos = $result->num_rows;

    // $quantos_humanos = 1;

    $query = "SELECT * FROM " . $table_name . "
    WHERE `bot` = '1'";

    $result = $conn->query($query);

   // var_dump($result);
    //var_dump($query);
   // die();


    if (!$result) {
        echo 'Error: Query failed. ' . $conn->error;
        return;
    }

    $quantos_bots = $result->num_rows;

    if ($quantos_bots < 1 or $quantos_humanos < 1) {
        echo 'Sorry, no info available. Please, try again tomorrow.';
        return;
    }
    $total = $quantos_bots +  $quantos_humanos;

    if ($total <= 1) {
        echo 'Sorry, no info available. Please, try again tomorrow.';
        return;
    }

    $stopbadbots_results10[0]['Bots'] = $quantos_bots / $total;
    $stopbadbots_results10[0]['Humans'] = $quantos_humanos / $total;

} catch (Exception $e) {
    // Captura erros e os exibe
    echo 'An error occurred: ' . $e->getMessage();
    return;

}

  