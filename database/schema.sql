DROP TABLE IF EXISTS `folder`;
CREATE TABLE `folder`
(
    `id`     int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`   varchar(255)     NOT NULL,
    `_left`  int(30) UNSIGNED NOT NULL,
    `_right` int(30) UNSIGNED NOT NULL,
    `_lvl`   int(30) UNSIGNED NOT NULL
) ENGINE = InnoDB;
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor`
(
    `id`   int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL
) ENGINE = InnoDB;
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `id`        int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `image_id`  int UNSIGNED DEFAULT NULL,
    `firstname` varchar(255) NOT NULL,
    `lastname`  varchar(255) NOT NULL,
    `email`     varchar(255) NOT NULL UNIQUE,
    `phone`     varchar(20)  NOT NULL UNIQUE,
    `password`  varchar(255) NOT NULL
) ENGINE = InnoDB;
DROP TABLE IF EXISTS `image`;
CREATE TABLE `image`
(
    `id`    int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `alias` varchar(255)              NOT NULL,
    `type`  set ('avatar', 'product') NOT NULL,
    `path`  text                      NOT NULL
) ENGINE = InnoDB;
DROP TABLE IF EXISTS `flag`;
CREATE TABLE flag
(
    `id`   int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL
) ENGINE = InnoDB;
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`
(
    `id`          int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`        varchar(255)   NOT NULL,
    `article`     varchar(255)   NOT NULL,
    `image_id`    int UNSIGNED            DEFAULT NULL,
    `description` text                    DEFAULT NULL,
    `price`       decimal(12, 2) NOT NULL,
    `count`       int            NOT NULL DEFAULT 0,
    `vendor_id`   int UNSIGNED            DEFAULT NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `product_param`;
CREATE TABLE `product_param`
(
    `id`   int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `product_param_value`;
CREATE TABLE `product_param_value`
(
    `id`         int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` int UNSIGNED NOT NULL,
    `param_id`   int UNSIGNED NOT NULL,
    `value`      varchar(255) NOT NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `folder_has_product`;
CREATE TABLE `folder_has_product`
(
    `folder_id`  int UNSIGNED NOT NULL,
    `product_id` int UNSIGNED NOT NULL,
    PRIMARY KEY (folder_id, product_id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `product_has_flag`;
CREATE TABLE `product_has_flag`
(
    `product_id` int UNSIGNED NOT NULL,
    `flag_id`    int UNSIGNED NOT NULL,
    PRIMARY KEY (product_id, flag_id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `product_comment`;
CREATE TABLE `product_comment`
(
    `id`         int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` int UNSIGNED           NOT NULL,
    `user_id`    int UNSIGNED           NOT NULL,
    `rating`     decimal(5, 2) UNSIGNED NOT NULL DEFAULT 0,
    `value`      text                            DEFAULT NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`
(
    `id`         int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id`    int UNSIGNED                              NOT NULL,
    `status`     set ('waiting', 'paid','done','archived') NOT NULL,
    `created_at` datetime DEFAULT NOW()
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item`
(
    `id`         int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `order_id`   int UNSIGNED NOT NULL,
    `product_id` int UNSIGNED NOT NULL,
    `count`      int UNSIGNED NOT NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`
(
    `id`   int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `template`;
CREATE TABLE `template`
(
    `id`   int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL,
    `path` varchar(255) NOT NULL
) ENGINE = InnoDB;

DROP TABLE IF EXISTS `route`;
CREATE TABLE `route`
(
    `id`          int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `real_url`    varchar(255)     NOT NULL,
    `short_url`   varchar(255)     NOT NULL,
    `_left`       int(30) UNSIGNED NOT NULL,
    `_right`      int(30) UNSIGNED NOT NULL,
    `_lvl`        int(30) UNSIGNED NOT NULL,
    `menu_id`     int UNSIGNED     NOT NULL,
    `is_hidden`   bool DEFAULT FALSE,
    `template_id` int UNSIGNED     NOT NULL
) ENGINE = InnoDB;

