<?php
require_once('../../config.php');
require_login();
admin_externalpage_setup('local_linkchecker_report');

$PAGE->set_url(new moodle_url('/local/linkchecker/report.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('report', 'local_linkchecker'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('report', 'local_linkchecker'));

$link_checker = new \local_linkchecker\link_checker();
$videos = $link_checker->get_all_videos();

$table = new html_table();
$table->head = array(get_string('videourl', 'local_linkchecker'), get_string('status', 'local_linkchecker'));

foreach ($videos as $video) {
    $status = $video->status ? get_string('valid', 'local_linkchecker') : get_string('invalid', 'local_linkchecker');
    $table->data[] = array($video->videourl, $status);
}

echo html_writer::table($table);

echo $OUTPUT->footer();
?>
