<?php

class Database {
    public $db;

    public function __construct(){
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=PHP_Assessment", "dckap", "Dckap2023Ecommerce");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}


class Model extends Database {

    /** Checks whether the user is admin or logged in **/
    public function registration($data) {
        try {
            $email = $data['email'];
            $password = $data['password'];
            $check = $this->db->prepare("SELECT email, password, is_admin FROM users WHERE email = :email AND password = :password");
            $check->execute(['email' => $email, 'password' => $password]);
            return $check->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function createCategory($category_name) {

        $stmt =  $this->db->prepare("INSERT INTO category (category_name, created_at, updated_at) VALUES (:name, NOW(), NOW())");
        return $stmt->execute(['name' => $category_name]);
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM category");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function categoryExists($category_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM category WHERE category_id = :category_id");
            $stmt->execute(['category_id' => $category_id]);
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            return ($count > 0);
        } catch (PDOException $e) {
            throw new Exception("Error checking category existence: " . $e->getMessage());
        }
    }
    public function createPost($category_id, $post_title, $post_content) {

        // Check if category_id exists
        $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM category WHERE category_id = :category_id");
        $stmt->execute(['category_id' => $category_id]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        if ($count > 0) {
            // Category exists, insert into posts table
            $stmt = $this->db->prepare("INSERT INTO post (category_id, title, content, created_at, updated_at) VALUES (:category_id, :title, :content, NOW(), NOW())");
            return $stmt->execute(['category_id' => $category_id, 'title' => $post_title, 'content' => $post_content]);
        } else {
            return false; // Handle case where category_id does not exist
        }
    }

    public function getTotalPosts() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM post");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    // Method to get paginated posts
    public function getPosts($page, $limit) {
        try {
            $offset = ($page - 1) * $limit;
            $stmt = $this->db->prepare("SELECT post.*, category.category_name 
                                       FROM post 
                                       INNER JOIN category ON post.category_id = category.category_id 
                                       LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching posts: " . $e->getMessage());
        }
    }
    

    // Method to get total number of search results
    public function getTotalSearchPosts($searchTerm) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM post INNER JOIN category ON post.category_id = category.category_id WHERE post.title LIKE :searchTerm OR category.category_name LIKE :searchTerm");
        $stmt->execute(['searchTerm' => "%$searchTerm%"]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    // Method to search posts by title and category
    public function searchPosts($searchTerm, $page, $limit) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT post.*, category.category_name 
                                    FROM post 
                                    INNER JOIN category ON post.category_id = category.category_id 
                                    WHERE post.title LIKE :searchTerm 
                                       OR category.category_name LIKE :searchTerm 
                                    LIMIT :limit OFFSET :offset");
        
        $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>
