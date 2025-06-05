<?php
    include_once "config.php";

    class Comment {
        public function getCommnetForNewsItem($id) {
            if (!is_numeric($id)) return false;
            
            $conn = Database::connect();          
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return false;
            } else if($id < 0) return false;

            $id = htmlspecialchars($id);

            $stmt = $conn->prepare("
                select c.user_name, c.comment_text, c.date_posted
                from news n inner join comments c ON n.id = c.news_id 
                where n.id = ?;
            ");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $comments = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $comments;
        }


        public function insertComment($news_id, $user_name, $comment_text) {
            if (!is_numeric($news_id)) return false;

            $user_name = htmlspecialchars(trim($user_name));
            $comment_text = htmlspecialchars(trim($comment_text));

            $conn = Database::connect();          
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return false;
            }

            $stmt = $conn->prepare("
                INSERT INTO comments(news_id, user_name, comment_text ) 
                VALUES (?, ?, ?);
            ");
            $stmt->bind_param("iss", $news_id, $user_name, $comment_text);
            $result = $stmt->execute();
            $stmt->close();

            return $result;
        }
    }
?>