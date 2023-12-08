<?php

namespace App\Models;

use PDO;

class PostModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllPosts()
    {
        $stmt = $this->db->query('SELECT * FROM posts');
        return $stmt->fetchAll();
    }

    public function getPostById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createPost($title, $body)
    {
        $stmt = $this->db->prepare('INSERT INTO posts (title, body) VALUES (?, ?)');
        $stmt->execute([$title, $body]);
    }

    public function updatePost($id, $title, $body)
    {
        $stmt = $this->db->prepare('UPDATE posts SET title=?, body=? WHERE id=?');
        $stmt->execute([$title, $body, $id]);
    }

    public function deletePost($id)
    {
        $stmt = $this->db->prepare('DELETE FROM posts WHERE id=?');
        $stmt->execute([$id]);
    }
}
