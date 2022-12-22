#!/bin/bash

mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "ALTER USER ${MYSQL_USER}@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_PASSWORD}';"

# create table work_types
mysql -u root -p${MYSQL_ROOT_PASSWORD} <<EOF
  use ${MYSQL_DATABASE};
  DROP TABLE IF EXISTS `work_types`;
  CREATE TABLE `work_types` (
    `work_types_id` int(11) NOT NULL,
    `work_types_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    `work_types_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  INSERT INTO `work_types` (`work_types_id`, `work_types_title`, `work_types_description`) VALUES
  (1325, 'website', 'Сайты'),
  (1326, 'mobile', 'Мобильные приложения');

  ALTER TABLE `work_types`
    ADD PRIMARY KEY (`work_types_id`);

  ALTER TABLE `work_types`
    MODIFY `work_types_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1362;
  COMMIT;
EOF