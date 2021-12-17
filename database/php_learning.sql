

CREATE TABLE `friend_relation` (
  `id` int(11) NOT NULL,
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `friend_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `friend_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `friend_relation`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `friend_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

