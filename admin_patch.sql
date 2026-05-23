-- ============================================================
-- AGGRO Admin Panel — SQL Patch
-- Jalankan ini jika tabel admins belum ada atau ingin reset
-- ============================================================

-- Pastikan tabel admins ada
CREATE TABLE IF NOT EXISTS `admins` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Default admin:
--   username : admin_kopi
--   password : password   (hash bcrypt dari 'password')
-- GANTI PASSWORD SETELAH LOGIN PERTAMA!
INSERT INTO `admins` (`username`, `password`) VALUES
('admin_kopi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE `username`=`username`;

-- Untuk ganti password, gunakan PHP:
-- echo password_hash('password_baru_kamu', PASSWORD_DEFAULT);
-- Lalu UPDATE admins SET password='hash_baru' WHERE username='admin_kopi';
