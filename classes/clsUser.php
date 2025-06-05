<?php 
    include_once "config.php";

    class User {

        public function getAllUsers() {
            $conn = Database::connect();
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return [];
            }            

            $command = "SELECT * FROM users";
            $result = $conn->query($command);
            $users = [];
            while ($row = $result->fetch_assoc()) {
                array_push($users, $row);
            }
    
            return $users;
        }

        public function getUser($user_id) {
            if(!is_numeric($user_id)) return null;
            $conn = Database::connect();
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return null;
            }

            $command = "SELECT * FROM users WHERE id=$user_id";
            $result = $conn->query($command);
            $userInfo = $result->fetch_assoc();
    
            return $userInfo;
        }

        public function updateUser($user_id, $name) {
            if (!is_numeric($user_id)) return false;
        
            $conn = Database::connect();           
        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return false;
            }
        
            $name = htmlspecialchars($name);
        
            $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $name, $user_id);
            
            $result = $stmt->execute();        
            $stmt->close();
        
            return $result;
        }
        

        public function deleteUser($user_id) {
            if (!is_numeric($user_id)) return false;
            $conn = Database::connect();           

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return false;
            }

            $command = "DELETE FROM users WHERE id = $user_id;";
            $result = $conn->query($command);

            return $result;
        }

        public function LogUserIn($email, $password) {
            $email = trim($email);
            $password = trim($password);
        
            $conn = Database::connect();
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return false;
            }
        
            $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
                return false;
            }
        
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return false;
            }
        
            $user = $result->fetch_assoc();
            if (!password_verify($password, $user["password"])) {
                return false;
            }
        
            return $user["id"];
        }

        public function insertUser($name, $email, $password, $role) {        
            $conn = Database::connect();           
        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                return false;
            }
        
            $name = htmlspecialchars($name);
            $email = htmlspecialchars($email);
            $password = password_hash($password, PASSWORD_BCRYPT);
            $role = htmlspecialchars($role);
        
            $stmt = $conn->prepare("INSERT INTO users(name, email, password, role) VALUES(?, ? , ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password, $role);
            $result = $stmt->execute();        
            $stmt->close();
        
            return $result;
        }

    }

?>