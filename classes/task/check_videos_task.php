<?php
namespace local_linkchecker;

class link_checker {
    public function get_all_videos() {
        global $DB;
        return $DB->get_records('local_linkchecker_videos');
    }

    public function add_video($courseid, $videourl) {
        global $DB;
        $video = new \stdClass();
        $video->courseid = $courseid;
        $video->videourl = $videourl;
        $video->status = 0; // Initial status as unchecked
        return $DB->insert_record('local_linkchecker_videos', $video);
    }

    public function check_video($url) {
        $apiKey = get_config('local_linkchecker', 'apikey');
        preg_match('/v=([^&]+)/', $url, $matches);
        if (empty($matches[1])) {
            return false;
        }
        $videoId = $matches[1];
        $apiUrl = "https://www.googleapis.com/youtube/v3/videos?id={$videoId}&key={$apiKey}&part=status";
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
        return !empty($data['items']);
    }

    public function update_video_status($id, $status) {
        global $DB;
        $DB->update_record('local_linkchecker_videos', (object) ['id' => $id, 'status' => $status]);
    }
}
?>

