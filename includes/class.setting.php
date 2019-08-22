<?php

Class Setting {
    /**
     * @description Updates the application settings
     * @access public
     *
     * @param array $data settings
     * @param string $type settings type to update
     *
     * @return boolean
     */
    public function update($data = [], $type = 'system') {
        global $mysql;

        foreach ($data AS $key => $value) {
            if ($query = $mysql->prepare("UPDATE `options` SET `value` = ? WHERE `name` = ? AND `type` = ?")) {
                if ($query->bind_param("sss", $value, $key, $type)) {
                    if ($query->execute()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @description Fetches and returns the settings from the database
     * @access public
     *
     * @param string $type settings type to retrun
     *
     * @return array | boolean
     */
    public function fetch($type = 'system') {
        global $mysql;

        if ($query = $mysql->prepare("SELECT * FROM options WHERE type = ?")) {
            if ($query->bind_param("s", $type)) {
                if ($query->execute()) {
                    if ($result = $query->get_result()) {
                        if ($result->num_rows >= 1) {
                            $settings = [];

                            while ($setting = $result->fetch_assoc()) {
                                $settings[$setting['name']] = $setting['value'];
                            }

                            return $settings;
                        }
                    }
                }
            }
        }

        return false;
    }
}