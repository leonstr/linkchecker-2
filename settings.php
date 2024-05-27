<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_linkchecker', get_string('pluginname', 'local_linkchecker'));

    $settings->add(new admin_setting_configtext(
        'local_linkchecker/apikey',
        get_string('apikey', 'local_linkchecker'),
        get_string('apikey_desc', 'local_linkchecker'),
        '', 
        PARAM_TEXT
    ));

    $ADMIN->add('localplugins', $settings);
}
?>
