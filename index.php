<?php
require_once('../../config.php');
require_login();
admin_externalpage_setup('local_linkchecker');

$PAGE->set_url(new moodle_url('/local/linkchecker/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pluginname', 'local_linkchecker'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'local_linkchecker'));

$link_checker = new \local_linkchecker\link_checker();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['videourl']) && !empty($_POST['courseid'])) {
    $videourl = required_param('videourl', PARAM_URL);
    $courseid = required_param('courseid', PARAM_INT);
    $link_checker->add_video($courseid, $videourl);
    echo $OUTPUT->notification(get_string('videoadded', 'local_linkchecker'), 'notifysuccess');
}

$videos = $link_checker->get_all_videos();

echo '<form method="post">';
echo '<div>';
echo '<label for="courseid">' . get_string('courseid', 'local_linkchecker') . '</label>';
echo '<input type="number" name="courseid" id="courseid" required>';
echo '</div>';
echo '<div>';
echo '<label for="videourl">' . get_string('videourl', 'local_linkchecker') . '</label>';
echo '<input type="url" name="videourl" id="videourl" required>';
echo '</div>';
echo '<div>';
echo '<button type="submit">' . get_string('addvideo', 'local_linkchecker') . '</button>';
echo '</div>';
echo '</form>';

$table = new html_table();
$table->head = array(get_string('videourl', 'local_linkchecker'), get_string('status', 'local_linkchecker'));

foreach ($videos as $video) {
    $status = $video->status ? get_string('valid', 'local_linkchecker') : get_string('invalid', 'local_linkchecker');
    $table->data[] = array($video->videourl, $status);
}

echo html_writer::table($table);

echo $OUTPUT->footer();
?>
