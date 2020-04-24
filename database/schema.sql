DROP TABLE IF EXISTS `folder`;
CREATE TABLE folder
(
    `id`     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`   VARCHAR(255) NOT NULL,
    `_left`  int(30) UNSIGNED DEFAULT NULL,
    `_right` int(30) UNSIGNED DEFAULT NULL,
    `_lvl`   int(30) UNSIGNED DEFAULT NULL,
    `url`    VARCHAR(255)     DEFAULT NULL
)ENGINE=InnoDB;
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE vendor
(
    `id`   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
)ENGINE=InnoDB;
DROP TABLE IF EXISTS `user`;
CREATE TABLE user
(
    `id`        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `image_id` INT unsigned DEFAULT NULL,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname`  VARCHAR(255) NOT NULL,
    `email`     VARCHAR(255) NOT NULL UNIQUE,
    `phone`     VARCHAR(20)  NOT NULL unique,
    `password` VARCHAR(255) NOT NULL
)ENGINE=InnoDB;
DROP TABLE IF EXISTS `image`;
CREATE TABLE image
(
    `id`    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `alias` VARCHAR(255) NOT NULL,
    `path`  TEXT         NOT NULL
)ENGINE=InnoDB;
DROP TABLE IF EXISTS `flag`;
CREATE TABLE flag
(
    `id`   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
)ENGINE=InnoDB;
DROP TABLE IF EXISTS `product`;
CREATE TABLE product
(
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(255)   NOT NULL,
    `article`     VARCHAR(255)   NOT NULL,
    `image_id`    INT UNSIGNED DEFAULT NULL,
    `description` TEXT         DEFAULT NULL,
    `price`       DECIMAL(12, 2) NOT NULL,
    `vendor_id`   INT UNSIGNED DEFAULT NULL
)ENGINE=InnoDB;

DROP TABLE IF EXISTS `folder_has_product`;
CREATE TABLE folder_has_product
(
    `folder_id`  INT UNSIGNED NOT NULL,
    `product_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (folder_id, product_id)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS `product_has_flag`;
CREATE TABLE product_has_flag
(
    `product_id` INT UNSIGNED NOT NULL,
    `flag_id`    INT UNSIGNED NOT NULL,
    PRIMARY KEY (product_id, flag_id)
)ENGINE=InnoDB;