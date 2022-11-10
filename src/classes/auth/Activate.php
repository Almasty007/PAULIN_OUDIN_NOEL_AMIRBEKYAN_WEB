<?php

try {
    $token = bin2hex(random_bytes(32));
} catch (Exception $e) {
}

$activate_url = "?token=$token";