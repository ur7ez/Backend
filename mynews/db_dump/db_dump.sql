CREATE SCHEMA IF NOT EXISTS `mynews`
  DEFAULT CHARACTER SET utf8;

USE `mynews`;

CREATE TABLE `news` (
  `id`           BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`        VARCHAR(300)        NOT NULL,
  `content`      TEXT                         DEFAULT NULL,
  `date_created` TIMESTAMP                    DEFAULT CURRENT_TIMESTAMP,
  `author`       VARCHAR(200),
  `source_ref`   VARCHAR(200),
  `image_cap`    VARCHAR(200),
  `hits_cnt`     SMALLINT                     DEFAULT 0,
  `active`       TINYINT(1) UNSIGNED          DEFAULT 0,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

CREATE TABLE `categories` (
  `id`                 SMALLINT(5) UNSIGNED      NOT NULL          AUTO_INCREMENT,
  `title`              VARCHAR(50) UNIQUE        NOT NULL,
  `description`        TEXT                                        DEFAULT NULL,
  `header`             VARCHAR(100)                                DEFAULT NULL,
  `restricted`         TINYINT(1) UNSIGNED                         DEFAULT 0,
  `comments_moderated` TINYINT(1) UNSIGNED                         DEFAULT 0,
  `active`             TINYINT(1) UNSIGNED       NOT NULL          DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

CREATE TABLE `news_categories` (
  `id`          BIGINT(10) UNSIGNED  NOT NULL AUTO_INCREMENT,
  `news_id`     BIGINT(10) UNSIGNED  NOT NULL,
  `category_id` SMALLINT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`news_id`),
  INDEX (`category_id`),
  UNIQUE INDEX `news_categories_uid` (category_id, news_id),
  CONSTRAINT FOREIGN KEY (`news_id`) REFERENCES news (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (`category_id`) REFERENCES categories (id)
    ON DELETE NO ACTION
    ON UPDATE CASCADE
)
  ENGINE = InnoDB;

CREATE TABLE `tags` (
  `id`  SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(40) UNIQUE   NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

CREATE TABLE `news_tags` (
  `id`      BIGINT(5) UNSIGNED   NOT NULL AUTO_INCREMENT,
  `news_id` BIGINT(10) UNSIGNED  NOT NULL,
  `tag_id`  SMALLINT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `news_tags_id` (news_id, tag_id),
  INDEX (`news_id`),
  INDEX (`tag_id`),
  CONSTRAINT FOREIGN KEY (`news_id`) REFERENCES news (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (`tag_id`) REFERENCES tags (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = InnoDB;

CREATE TABLE `users` (
  `id`       INT(5) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `name`     VARCHAR(100)           NOT NULL,
  `login`    VARCHAR(45)            NOT NULL,
  `email`    VARCHAR(100)           NOT NULL,
  `role`     ENUM ('user', 'admin') NOT NULL DEFAULT 'user',
  `password` CHAR(32)               NOT NULL,
  `active`   TINYINT(1) UNSIGNED             DEFAULT '1',
  UNIQUE INDEX `users_login_email_uindex` (login, email),
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

CREATE TABLE `mynews`.`comments`
(
  `id`           BIGINT(10) UNSIGNED                 NOT NULL AUTO_INCREMENT,
  `user_id`      INT(5) UNSIGNED                     NOT NULL,
  `news_id`      BIGINT(10) UNSIGNED                 NOT NULL,
  `comment_id`   BIGINT(10) UNSIGNED                          DEFAULT NULL,
  `comment`      TEXT                                NOT NULL,
  `created`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `likes_cnt`    INT DEFAULT 0                       NOT NULL,
  `dislikes_cnt` INT DEFAULT 0                       NOT NULL,
  `needs_mod`    TINYINT DEFAULT 0                   NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  CONSTRAINT `comments_bind_fk` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  INDEX (`user_id`),
  INDEX (`news_id`)
)
  ENGINE = InnoDB;

CREATE TABLE `site_ads` (
  `id`          SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product`     VARCHAR(50)          NOT NULL,
  `description` TEXT                 NULL,
  `price`       FLOAT(2)             NOT NULL DEFAULT 0,
  `seller`      VARCHAR(100)                  DEFAULT NULL,
  `ref`         VARCHAR(200)                  DEFAULT NULL,
  `active`      TINYINT(1) UNSIGNED           DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

CREATE TABLE `url_rewrite` (
  `id`     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias`  VARCHAR(100)     NOT NULL,
  `target` VARCHAR(100)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

CREATE OR REPLACE VIEW `news_in_categories` AS
  SELECT
    c.id                 AS category_id,
    c.title              AS category_title,
    c.description        AS category_description,
    c.header             AS category_header,
    c.restricted         AS category_restricted,
    c.comments_moderated AS category_comments_moderated,
    n.id                 AS news_id,
    n.title              AS title,
    n.content            AS content,
    n.date_created       AS news_date_created,
    n.author             AS author,
    n.source_ref         AS source_ref,
    n.image_cap          AS image_cap,
    n.hits_cnt           AS hits_cnt,
    n.active             AS active
  FROM news_categories
    LEFT JOIN news n ON news_categories.news_id = n.id
    LEFT JOIN categories c ON news_categories.category_id = c.id
  WHERE c.active = 1
  ORDER BY category_id ASC, news_date_created DESC;


CREATE OR REPLACE VIEW `tags_in_news` AS
  SELECT
    news.*,
    n.tag_id,
    t.tag
  FROM news
    INNER JOIN news_tags n ON news.id = n.news_id
    LEFT JOIN tags t ON n.tag_id = t.id
  WHERE news.active = 1
  ORDER BY tag ASC, date_created DESC;

CREATE TABLE `tinyint_asc` (
  `value` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (value)
);

INSERT INTO `tinyint_asc`
VALUES (0), (1), (2), (3), (4), (5), (6), (7), (8), (9), (10), (11), (12), (13), (14), (15), (16), (17), (18), (19),
  (20), (21), (22), (23), (24), (25), (26), (27), (28), (29), (30), (31), (32), (33), (34), (35), (36), (37), (38),
  (39), (40), (41), (42), (43), (44), (45), (46), (47), (48), (49), (50), (51), (52), (53), (54), (55), (56), (57),
  (58), (59), (60), (61), (62), (63), (64), (65), (66), (67), (68), (69), (70), (71), (72), (73), (74), (75), (76),
  (77), (78), (79), (80), (81), (82), (83), (84), (85), (86), (87), (88), (89), (90), (91), (92), (93), (94), (95),
  (96), (97), (98), (99), (100), (101), (102), (103), (104), (105), (106), (107), (108), (109), (110), (111), (112),
  (113), (114), (115), (116), (117), (118), (119), (120), (121), (122), (123), (124), (125), (126), (127), (128), (129),
  (130), (131), (132), (133), (134), (135), (136), (137), (138), (139), (140), (141), (142), (143), (144), (145), (146),
  (147), (148), (149), (150), (151), (152), (153), (154), (155), (156), (157), (158), (159), (160), (161), (162), (163),
  (164), (165), (166), (167), (168), (169), (170), (171), (172), (173), (174), (175), (176), (177), (178), (179), (180),
  (181), (182), (183), (184), (185), (186), (187), (188), (189), (190), (191), (192), (193), (194), (195), (196), (197),
  (198), (199), (200), (201), (202), (203), (204), (205), (206), (207), (208), (209), (210), (211), (212), (213), (214),
  (215), (216), (217), (218), (219), (220), (221), (222), (223), (224), (225), (226), (227), (228), (229), (230), (231),
  (232), (233), (234), (235), (236), (237), (238), (239), (240), (241), (242), (243), (244), (245), (246), (247), (248),
  (249), (250), (251), (252), (253), (254), (255);