<?php 

    include_once "config.php";

    class Category {

        public function getAll() {
            $conn = Database::connect();
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return -1;
            }

            $command = "SELECT * FROM categories;";
            $result = $conn->query($command);
            $categories = $result->fetch_all(MYSQLI_ASSOC);

            return $categories;
        }

        public function getCategoryName($id) {
            $categories = $this->getAll();
            foreach($categories as $category) {
                if($category["id"] == $id) {
                    return $category["name"];
                }
            }
        }

    }

?>