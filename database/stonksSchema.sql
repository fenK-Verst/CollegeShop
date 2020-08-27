DROP TABLE IF EXISTS `stonk`;
CREATE TABLE `stonk`
(
    `id`          int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`       varchar(255) NOT NULL,
    `description` varchar(255) NOT NULL,
    `summ`        int          NOT NULL DEFAULT 0,
    `created_at`  datetime     NOT NULL DEFAULT NOW(),
    `user_id`     int UNSIGNED NOT NULL
) ENGINE = InnoDB;