<?php
defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot . '/local/linkchecker/classes/youtube_checker.php');

class local_linkchecker_youtube_checker_testcase extends advanced_testcase {
    public function test_check_video() {
        $this->resetAfterTest(true);
        $checker = new \local_linkchecker\youtube_checker();

        $valid_url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $invalid_url = 'https://www.example.com';

        $this->assertTrue($checker->check_video($valid_url));
        $this->assertFalse($checker->check_video($invalid_url));
    }

    public function test_update_video_status() {
        $this->resetAfterTest(true);
        $checker = new \local_linkchecker\youtube_checker();

        // Create a dummy video record
        global $DB;
        $video = (object) array(
            'courseid' => 1,
            'videotitle' => 'Test Video',
            'videourl' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'status' => 0
        );
        $video->id = $DB->insert_record('local_linkchecker_videos', $video);

        // Update status and verify
        $checker->update_video_status($video->id, 1);
        $updated_video = $DB->get_record('local_linkchecker_videos', array('id' => $video->id));
        $this->assertEquals(1, $updated_video->status);

        // Delete the video and verify
        $DB->delete_records('local_linkchecker_videos', array('id' => $video->id));
        $deleted_video = $DB->get_record('local_linkchecker_videos', array('id' => $video->id));
        $this->assertFalse($deleted_video);
    }
}
?>
