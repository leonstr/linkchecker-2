<?php
defined('MOODLE_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'local_linkchecker\task\check_videos_task',
        'blocking' => 0,
        'minute' => '0',
        'hour' => '3',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    )
);
?>
