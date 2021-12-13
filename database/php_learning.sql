

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `friend_relation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `friend_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `friend_relation` (`id`, `user_id`, `friend_id`, `friend_name`) VALUES
(3, 1, 4, 'David'),
(4, 1, 6, 'Hebe'),
(5, 1, 3, 'Candy'),
(6, 1, 5, 'Ella');



CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `gender` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `user` (`id`, `username`, `password`, `gender`, `status`) VALUES
(1, 'Bob', 'Bob', 0, 0),
(2, 'Alice', 'Alice', 1, 0),
(3, 'Candy', 'Candy', 1, 0),
(4, 'David', 'David', 0, 0),
(5, 'Ella', 'Ella', 0, 0),
(6, 'Hebe', 'Hebe', 1, 0);


ALTER TABLE `friend_relation`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `friend_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;
