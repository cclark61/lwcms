<?php

// Reset Module Title
$mod_title = "Microsoft SQL Server Test (SQLSRV)";
$data_source = 'test_sqlsrv';

load_plugin('benchmark');
$cb = new code_benchmark();
$cb->start_timer();
include(dirname(__FILE__) . '/../common/controller.php');
include('tests.php');
$cb->stop_timer();
$times = $cb->get_results();
$time_elapsed = round($times['stop'] - $times['start'], 5);
$gen_message[] = "Elapsed Time: {$time_elapsed} seconds";

?>