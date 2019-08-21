<?php

if ($query = $mysql->query("SELECT * FROM options WHERE type = 'system'")) {
    $system = [];

    if (count($query->num_rows) >= 1) {
        while ($setting = $query->fetch_assoc()) {
            $system[$setting['name']] = $setting['value'];
        }
    }
}