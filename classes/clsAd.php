<?php
    include_once "config.php";

    class Ad {
        public function getAd() {
            $conn = Database::connect();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $command1 = "select count(id) from ads";
            $result = $conn->query($command1);
            $count = $result->fetch_array()[0];

            $id = rand(1, $count);
            $command2 = "select ad_image_path from ads where id = $id";
            $result = $conn->query($command2);
            $ad = $result->fetch_assoc();

            return $ad;
        }
    }

?>