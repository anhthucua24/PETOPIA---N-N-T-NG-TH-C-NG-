-- =====================================================================
-- schema.sql – PETOPIA (MySQL / MariaDB – XAMPP)
-- Cách chạy: phpMyAdmin -> Import -> chọn file này -> Import
-- CẢNH BÁO: file này XÓA và TẠO LẠI toàn bộ bảng (mất dữ liệu cũ).
-- Sau đó import tiếp seed.sql để có dữ liệu mẫu.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS petopia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE petopia;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS post_likes, comments, posts, adoptions, pets, users;
SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- 1. Tài khoản & phân quyền
-- ---------------------------------------------------------------------
CREATE TABLE users (
  userId      VARCHAR(50)  NOT NULL PRIMARY KEY,
  username    VARCHAR(50)  NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,                 -- password_hash() – không lưu chữ thường
  email       VARCHAR(100) NOT NULL UNIQUE,
  fullName    VARCHAR(100) NULL,
  phone       VARCHAR(20)  NULL,
  avatar      VARCHAR(255) NULL,                     -- tên file trong images/avatars/
  role        ENUM('admin','staff','customer') NOT NULL DEFAULT 'customer',
  status      ENUM('active','locked')          NOT NULL DEFAULT 'active',
  created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 2. Thú cưng (có thuộc tính để lọc theo nhu cầu)
-- ---------------------------------------------------------------------
CREATE TABLE pets (
  id                 VARCHAR(50)  NOT NULL PRIMARY KEY,
  name               VARCHAR(100) NOT NULL,
  species            ENUM('dog','cat') NOT NULL,
  breed              VARCHAR(100) NULL,
  age                DECIMAL(3,1) NOT NULL DEFAULT 1,          -- năm (0.5 = 6 tháng)
  gender             ENUM('Đực','Cái') NOT NULL,
  size               ENUM('small','medium','large') NOT NULL DEFAULT 'medium',
  energy             ENUM('low','medium','high')    NOT NULL DEFAULT 'medium',
  good_with_kids     TINYINT(1) NOT NULL DEFAULT 1,
  good_with_pets     TINYINT(1) NOT NULL DEFAULT 1,
  apartment_friendly TINYINT(1) NOT NULL DEFAULT 1,
  vaccinated         TINYINT(1) NOT NULL DEFAULT 1,
  neutered           TINYINT(1) NOT NULL DEFAULT 0,
  color              VARCHAR(50)  NULL,
  weight_kg          DECIMAL(4,1) NULL,
  location           VARCHAR(100) NULL,
  photo              VARCHAR(255) NULL,                        -- tên file trong images/ (vd: pets/dog_01.jpg)
  description        TEXT NULL,
  status             ENUM('available','pending','adopted') NOT NULL DEFAULT 'available',
  featured           TINYINT(1) NOT NULL DEFAULT 0,            -- hiện ở "Nổi bật tuần này"
  created_at         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 3. Cộng đồng: bài viết – bình luận/phản hồi – lượt thích
-- ---------------------------------------------------------------------
CREATE TABLE posts (
  postId        VARCHAR(50)  NOT NULL PRIMARY KEY,
  userId        VARCHAR(50)  NULL,
  title         VARCHAR(255) NOT NULL,
  content       TEXT NOT NULL,
  image         VARCHAR(255) NULL,                             -- tên file trong images/posts/
  category      ENUM('story','tips','rescue','question') NOT NULL DEFAULT 'story',
  status        ENUM('pending','approved','rejected')    NOT NULL DEFAULT 'pending',
  reject_reason TEXT NULL,
  reviewed_by   VARCHAR(50) NULL,
  reviewed_at   DATETIME NULL,
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (userId)      REFERENCES users(userId) ON DELETE SET NULL,
  FOREIGN KEY (reviewed_by) REFERENCES users(userId) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE comments (
  commentId   VARCHAR(50) NOT NULL PRIMARY KEY,
  postId      VARCHAR(50) NOT NULL,
  userId      VARCHAR(50) NULL,
  parentId    VARCHAR(50) NULL,                                -- trả lời 1 bình luận khác
  text        TEXT NOT NULL,
  created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (postId)   REFERENCES posts(postId)       ON DELETE CASCADE,
  FOREIGN KEY (userId)   REFERENCES users(userId)       ON DELETE SET NULL,
  FOREIGN KEY (parentId) REFERENCES comments(commentId) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE post_likes (
  postId     VARCHAR(50) NOT NULL,
  userId     VARCHAR(50) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (postId, userId),
  FOREIGN KEY (postId) REFERENCES posts(postId) ON DELETE CASCADE,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- 4. Đơn đăng ký nhận nuôi
-- ---------------------------------------------------------------------
CREATE TABLE adoptions (
  requestId      VARCHAR(50)  NOT NULL PRIMARY KEY,
  userId         VARCHAR(50)  NULL,
  petId          VARCHAR(50)  NULL,
  fullName       VARCHAR(100) NOT NULL,
  phone          VARCHAR(20)  NOT NULL,
  email          VARCHAR(100) NULL,
  address        VARCHAR(255) NOT NULL,
  housing_type   ENUM('apartment','house','house_with_yard') NOT NULL DEFAULT 'apartment',
  has_children   TINYINT(1) NOT NULL DEFAULT 0,
  has_other_pets TINYINT(1) NOT NULL DEFAULT 0,
  experience     ENUM('none','some','experienced') NOT NULL DEFAULT 'none',
  hours_alone    TINYINT NULL,
  reason         TEXT NULL,
  status         ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  admin_note     TEXT NULL,
  reviewed_by    VARCHAR(50) NULL,
  reviewed_at    DATETIME NULL,
  created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (userId)      REFERENCES users(userId) ON DELETE SET NULL,
  FOREIGN KEY (petId)       REFERENCES pets(id)      ON DELETE SET NULL,
  FOREIGN KEY (reviewed_by) REFERENCES users(userId) ON DELETE SET NULL
) ENGINE=InnoDB;
