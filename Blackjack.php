<?php
$is_echo = true;
echo_phpcs($is_echo);
function echo_phpcs($is_echo) {
    if ($is_echo) {
        echo "ahello php_codesniffer!!\n";
    }
}