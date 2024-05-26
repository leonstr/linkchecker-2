<?php
namespace local_linkchecker;

class youtube_checker {
    public function check_video($videourl) {
        // Dummy check function for YouTube URLs
        return strpos($videourl, 'youtube.com') !== false;
    }

    public function get_all_videos($status = null, $search = '') {
        global $DB;

        $sql = "SELECT * FROM {local_linkchecker_videos} WHERE 1=1";
        $params = array();

        if ($status !== null) {
            $sql .= " AND status = :status";
            $params['status'] = $status;
        }

        if (!empty($search)) {
            $sql .= " AND (videotitle LIKE :search OR courseid LIKE :search)";
            $params['search'] = "%$search%";
        }

        return $DB->get_records_sql($sql, $params);
    }

    public function update_video_status($id, $status) {
        global $DB;
        $DB->update_record('local_linkchecker_videos', array('id' => $id, 'status' => $status));
    }
}
?>
