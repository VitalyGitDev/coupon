<?php
ob_start();
include_once __DIR__ . '/../templates/head.php';
$head = ob_get_clean();

include_once __DIR__ . '/../templates/' . $this->template;
$template = ob_get_clean();

return "<HTML><HEAD>$head</HEAD><BODY>$template</BODY></HTML>";
