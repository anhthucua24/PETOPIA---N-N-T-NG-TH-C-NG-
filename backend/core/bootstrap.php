<?php
// =====================================================================
// [CORE] bootstrap.php – File MAIN nào cũng require file này đầu tiên
// Thứ tự: Response (CORS, JSON) -> DB -> DAO -> Auth -> Upload
// =====================================================================
require_once __DIR__ . '/Response.php';
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/PetDAO.php';
require_once __DIR__ . '/../dao/PostDAO.php';
require_once __DIR__ . '/../dao/CommentDAO.php';
require_once __DIR__ . '/../dao/LikeDAO.php';
require_once __DIR__ . '/../dao/AdoptionDAO.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/Upload.php';
