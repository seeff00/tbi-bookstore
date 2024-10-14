CREATE DATABASE IF NOT EXISTS tbi_bookstore CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

use tbi_bookstore;

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` DOUBLE(10, 2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO products
    (`name`,`code`,`price`)
VALUES
    ("Novel","NV", 12.00),
    ("Magazine","MG",5.00),
    ("Textbook","TB",25.00);