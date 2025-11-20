<?php
session_start();
require_once __DIR__ . '/config.php';

// helper: check login role
function require_role($role) {
    if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        header('Location: /frontend/index.html');
        exit;
    }
}
