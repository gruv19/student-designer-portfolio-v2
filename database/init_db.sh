#!/bin/bash

mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "ALTER USER ${MYSQL_USER}@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_PASSWORD}';"

# create table work_types
mysql -u root -p${MYSQL_ROOT_PASSWORD} <<EOF
  use ${MYSQL_DATABASE};
  DROP TABLE IF EXISTS work_types;
  CREATE TABLE work_types (
    work_types_id int(11) NOT NULL,
    work_types_title varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    work_types_description varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  INSERT INTO work_types (work_types_id, work_types_title, work_types_description) VALUES
    (1325, 'website', 'Сайты'),
    (1326, 'mobile', 'Мобильные приложения');

  ALTER TABLE work_types
    ADD PRIMARY KEY (work_types_id);

  ALTER TABLE work_types
    MODIFY work_types_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1362;
  COMMIT;
EOF

# create table works
mysql -u root -p${MYSQL_ROOT_PASSWORD} <<EOF
  use ${MYSQL_DATABASE};
  DROP TABLE IF EXISTS works;
  CREATE TABLE works (
    works_id int NOT NULL,
    works_type varchar(50) NOT NULL,
    works_main_image varchar(255) NOT NULL,
    works_title varchar(100) NOT NULL,
    works_subtitle varchar(200) NOT NULL,
    works_task text NOT NULL,
    works_images text NOT NULL,
    works_link varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  INSERT INTO works (works_id, works_type, works_main_image, works_title, works_subtitle, works_task, works_images, works_link) VALUES
    (1103, 'website', '/work_images/smile.jpg', 'Smile', 'Курс \"Дизайн сайтов\"', 'Задача: создание сайта, адаптированного под мобильные устройства, и еще че-то там', '[\"/work_images/1103/work1103_01.jpg\", \"/work_images/1103/work1103_02.jpg\", \"/work_images/1103/work1103_03.jpg\", \"/work_images/1103/work1103_04.jpg\", \"/work_images/1103/work1103_05.jpg\", \"/work_images/1103/work1103_06.jpg\", \"/work_images/1103/work1103_07.jpg\", \"/work_images/1103/work1103_08.jpg\", \"/work_images/1103/work1103_09.jpg\", \"/work_images/1103/work1103_09.jpg\", \"/work_images/1103/work1103_10.jpg\", \"/work_images/1103/work1103_11.jpg\", \"/work_images/1103/work1103_12.jpg\", \"/work_images/1103/work1103_13.jpg\", \"/work_images/1103/work1103_14.jpg\", \"/work_images/1103/work1103_15.jpg\", \"/work_images/1103/work1103_16.jpg\", \"/work_images/1103/work1103_17.jpg\"]', ''),
    (1106, 'website', '/work_images/ocean-family.jpg', 'Ocean Family', 'Курс \"Tilda\"', 'Задача: создание продажного лендинга для услуги. Весь сайт должен быть заполнен контентом. Мобильная версия должна быть адаптирована', '[\"/work_images/1106/work1106_01.jpg\", \"/work_images/1106/work1106_02.jpg\", \"/work_images/1106/work1106_03.jpg\", \"/work_images/1106/work1106_04.jpg\", \"/work_images/1106/work1106_05.jpg\", \"/work_images/1106/work1106_06.jpg\", \"/work_images/1106/work1106_07.jpg\", \"/work_images/1106/work1106_08.jpg\", \"/work_images/1106/work1106_09.jpg\", \"/work_images/1105/work1105_09.jpg\"]', 'http://zhenyagru.tilda.ws/oceanfamily'),
    (1114, 'mobile', '/work_images/lets-read.jpg', 'Почитаем', 'Курс \"Мобильные приложения Base\"', 'Задача: Разработка дизайна мобильного приложения для чтения книг.', '[\"/work_images/1114/work1114_01.jpg\", \"/work_images/1114/work1114_02.jpg\", \"/work_images/1114/work1114_03.jpg\", \"/work_images/1114/work1114_04.jpg\", \"/work_images/1114/work1114_05.jpg\", \"/work_images/1114/work1114_06.jpg\", \"/work_images/1114/work1114_07.jpg\", \"/work_images/1114/work1114_08.jpg\", \"/work_images/1114/work1114_09.jpg\", \"/work_images/1114/work1114_09.jpg\", \"/work_images/1114/work1114_10.jpg\", \"/work_images/1114/work1114_11.jpg\", \"/work_images/1114/work1114_12.jpg\", \"/work_images/1114/work1114_13.jpg\", \"/work_images/1114/work1114_14.jpg\"]', ''),
    (1115, 'mobile', '/work_images/place-for-pet.jpg', 'PLACE FOR a pet', 'Курс \"Мобильные приложения Pro\"', 'Задача: создание мобильного приложения с учетом потребностей пользователей. Пошаговая реализация собственной идеи: от выявления потребностей и выдвижения гипотез, до тестирования и реализации приложения.', '[\"/work_images/1115/work1115_01.jpg\", \"/work_images/1115/work1115_02.jpg\", \"/work_images/1115/work1115_03.jpg\", \"/work_images/1115/work1115_04.jpg\", \"/work_images/1115/work1115_05.jpg\", \"/work_images/1115/work1115_06.jpg\", \"/work_images/1115/work1115_07.jpg\", \"/work_images/1115/work1115_08.jpg\", \"/work_images/1115/work1115_09.jpg\", \"/work_images/1115/work1115_09.jpg\", \"/work_images/1115/work1115_10.jpg\", \"/work_images/1115/work1115_11.jpg\", \"/work_images/1115/work1115_12.jpg\", \"/work_images/1115/work1115_13.jpg\", \"/work_images/1115/work1115_14.jpg\", \"/work_images/1115/work1115_15.jpg\"]', ''),
    (1116, 'website', '/work_images/slonium.jpg', 'Slonum', 'Тестовое задание', 'Задача: Landing page для участия в олимпиаде по математике, учитывая ТЗ', '[\"/work_images/1116/work1116_01.jpg\", \"/work_images/1116/work1116_02.jpg\", \"/work_images/1116/work1116_03.jpg\", \"/work_images/1116/work1116_04.jpg\", \"/work_images/1116/work1116_05.jpg\", \"/work_images/1116/work1116_06.jpg\", \"/work_images/1116/work1116_07.jpg\"]', ''),
    (1117, 'website', '/work_images/foody.jpg', 'FOODY', 'Тестовое задание', 'Задача: Landing page для доставки питания на каждый день, учитывая ТЗ. Обязательные требования:\r\n1) Фотографии (изображения) брать исключительно с сайта – https://unsplash.com (допустимо изменение, цветокоррекция и т.п., например, в Adobe Photoshop)\r\n2) Landing page должен корректно отображаться на desktop и mobile устройствах. \r\n3) Использовать логически подходящий текст, не Lorem Ipsum.', '[\"/work_images/1117/work1117_01.jpg\", \"/work_images/1117/work1117_02.jpg\", \"/work_images/1117/work1117_03.jpg\", \"/work_images/1117/work1117_04.jpg\", \"/work_images/1117/work1117_05.jpg\", \"/work_images/1117/work1117_06.jpg\", \"/work_images/1117/work1117_07.jpg\", \"/work_images/1117/work1117_08.jpg\", \"/work_images/1117/work1117_09.jpg\", \"/work_images/1117/work1117_09.jpg\", \"/work_images/1117/work1117_10.jpg\", \"/work_images/1117/work1117_11.jpg\", \"/work_images/1117/work1117_12.jpg\", \"/work_images/1117/work1117_13.jpg\", \"/work_images/1117/work1117_14.jpg\", \"/work_images/1117/work1117_15.jpg\", \"/work_images/1117/work1117_16.jpg\", \"/work_images/1117/work1117_17.jpg\"]', 'https://foody.bitrix24.site/'),
    (1118, 'website', '/work_images/helix.jpg', 'HELIX', 'Курс \"Арт-дирекшн\"', 'Задача: разработка интерфейса, работая в команде', '[\"/work_images/1118/work1118_01.jpg\", \"/work_images/1118/work1118_02.jpg\", \"/work_images/1118/work1118_03.jpg\", \"/work_images/1118/work1118_04.jpg\", \"/work_images/1118/work1118_05.jpg\", \"/work_images/1118/work1118_06.jpg\", \"/work_images/1118/work1118_07.jpg\", \"/work_images/1118/work1118_08.jpg\", \"/work_images/1118/work1118_09.jpg\", \"/work_images/1118/work1118_09.jpg\", \"/work_images/1118/work1118_10.jpg\", \"/work_images/1118/work1118_11.jpg\", \"/work_images/1118/work1118_12.jpg\", \"/work_images/1118/work1118_13.jpg\", \"/work_images/1118/work1118_14.jpg\", \"/work_images/1118/work1118_15.jpg\", \"/work_images/1118/work1118_16.jpg\", \"/work_images/1118/work1118_17.jpg\", \"/work_images/1118/work1118_18.jpg\", \"/work_images/1118/work1118_19.jpg\", \"/work_images/1118/work1118_20.jpg\", \"/work_images/1118/work1118_21.jpg\"]', ''),
    (1131, 'website', '/work_images/3963747a3762fb8149c3f58ad94edd1a.jpg', 'dfdfghgjhjkkl232323', 'assdfgdhfjgkl./klasdasdads', 'sdfghjkhkljkl\r\nfghfghfgh', '[\"/work_images/3963747a3762fb8149c3f58ad94edd1a/3963747a3762fb8149c3f58ad94edd1a1.jpg\",\"/work_images/3963747a3762fb8149c3f58ad94edd1a/3963747a3762fb8149c3f58ad94edd1a2.jpg\",\"/work_images/3963747a3762fb8149c3f58ad94edd1a/3963747a3762fb8149c3f58ad94edd1a3.jpg\",\"/work_images/3963747a3762fb8149c3f58ad94edd1a/3963747a3762fb8149c3f58ad94edd1a4.jpg\",\"/work_images/3963747a3762fb8149c3f58ad94edd1a/3963747a3762fb8149c3f58ad94edd1a5.jpg\",\"/work_images/3963747a3762fb8149c3f58ad94edd1a/3963747a3762fb8149c3f58ad94edd1a6.jpg\"]', 'fdfdfdsfsdf');

  ALTER TABLE works
    ADD PRIMARY KEY (works_id);

  ALTER TABLE works
    MODIFY works_id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1132;
  
  COMMIT;
EOF

# create table contacts
mysql -u root -p${MYSQL_ROOT_PASSWORD} <<EOF
  use ${MYSQL_DATABASE};
  DROP TABLE IF EXISTS contacts;
  CREATE TABLE contacts (
    contacts_id int NOT NULL,
    contacts_title varchar(255) NOT NULL,
    contacts_link varchar(255) NOT NULL,
    contacts_show tinyint(1) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  INSERT INTO contacts (contacts_id, contacts_title, contacts_link, contacts_show) VALUES
    (1, 'Telegram', '', 1),
    (2, 'Instagram', '', 0),
    (3, 'E-mail', '', 1),
    (4, 'Вконтакте', '', 1),
    (5, 'Facebook', '', 0);

  ALTER TABLE contacts
    ADD PRIMARY KEY (contacts_id);

  ALTER TABLE contacts
    MODIFY contacts_id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
  
  COMMIT;
EOF

# create table users
mysql -u root -p${MYSQL_ROOT_PASSWORD} <<EOF
  use ${MYSQL_DATABASE};
  DROP TABLE IF EXISTS users;
  CREATE TABLE users (
    users_id int NOT NULL,
    users_email varchar(100) NOT NULL,
    users_password varchar(20) NOT NULL,
    users_token varchar(255) DEFAULT NULL,
    users_token_expire_date timestamp NULL DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  INSERT INTO users (users_id, users_email, users_password, users_token, users_token_expire_date) VALUES
    (424, 'grv1992@yandex.ru', 'dsjR3eVHOGm2A', '5dd8d032aed47686', '2022-09-17 16:47:57');

  ALTER TABLE users
    ADD PRIMARY KEY (users_id);

  ALTER TABLE users
    MODIFY users_id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

  COMMIT;
EOF