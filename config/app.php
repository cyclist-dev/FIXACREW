<?php
define('APP_NAME', 'FixaCrew');
define('APP_URL', 'http://localhost/fixacrew');
define('UPLOAD_DIR', __DIR__ . '/../public/uploads/');
define('UPLOAD_URL', APP_URL . '/public/uploads/');
define('MAX_UPLOAD_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_MIME_TYPES', ['image/jpeg', 'image/png', 'image/webp']);