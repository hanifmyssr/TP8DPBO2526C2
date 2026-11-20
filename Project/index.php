<?php
// Front Controller & Router untuk aplikasi MVC
session_start();

require_once __DIR__ . '/controllers/LecturerController.php';
require_once __DIR__ . '/controllers/CourseController.php';
require_once __DIR__ . '/controllers/AssignmentController.php';

// Menentukan controller dan action berdasarkan query parameter ?page=...&action=...
$page   = $_GET['page'] ?? 'lecturers';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'courses':
        $controller = new CourseController();
        break;
    case 'assignments':
        $controller = new AssignmentController();
        break;
    case 'lecturers':
    default:
        $page = 'lecturers';
        $controller = new LecturerController();
        break;
}

// Memanggil method action pada controller jika tersedia
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    // Default fallback ke action index
    $controller->index();
}
