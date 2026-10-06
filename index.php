<?php
/**
 * Root index.php proxy to public/index.php
 * Allows the project to run seamlessly whether DocumentRoot is set to root or public/
 */
require __DIR__ . '/public/index.php';
