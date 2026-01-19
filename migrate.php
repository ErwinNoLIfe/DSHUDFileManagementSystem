<?php
include_once 'connection.php';

echo "<pre>";

/* ===========================
   USER TABLE
=========================== */
$userSql = "
CREATE TABLE IF NOT EXISTS `user` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fname` VARCHAR(40) NOT NULL,
    `lname` VARCHAR(40) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

mysqli_query($con, $userSql)
    ? print("✔ User table created successfully.\n")
    : print("✖ User table error: " . mysqli_error($con) . "\n");


/* ===========================
   FOLDER TABLE
=========================== */
$folderSql = "
CREATE TABLE IF NOT EXISTS `folder` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `user_id` INT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_folder_user`
        FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

mysqli_query($con, $folderSql)
    ? print("✔ Folder table created successfully.\n")
    : print("✖ Folder table error: " . mysqli_error($con) . "\n");


echo "\nMigration complete.\n</pre>";

mysqli_close($con);
?>
