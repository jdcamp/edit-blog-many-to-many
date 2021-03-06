<?php
    class Post
    {
        private $title;
        private $date;
        private $id;

        function __construct($title, $date, $id = null)
        {
            $this->title = $title;
            $this->date = $date;
            $this->id = $id;
        }
        function getTitle(){
    		return $this->title;
    	}

    	function setTitle($title){
    		$this->title = $title;
    	}

    	function getDate(){
    		return $this->date;
    	}

    	function setDate($date){
    		$this->date = $date;
    	}

    	function getId(){
    		return $this->id;
    	}

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO posts (title, date) VALUES ('{$this->getTitle()}', '{$this->getDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_posts = $GLOBALS['DB']->query("SELECT * FROM posts;");
            $posts = array();
            foreach ($returned_posts as $post) {
                $title = $post['title'];
                $date = $post['date'];
                $id = $post['id'];
                $new_post = new Post($title, $date, $id);
                array_push($posts, $new_post);
            }
            return $posts;
        }


        static function find($search_id)
        {
            $returned_posts = Post::getAll();
            foreach($returned_posts as $post) {
                if ($search_id == $post->getId()){
                    return $post;
                }
            }
            return null;
        }

        function updateTitle($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE posts SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }
        function updateDate($new_date)
        {
            $GLOBALS['DB']->exec("UPDATE posts SET date = '{$new_date}' WHERE id = {$this->getId()};");
            $this->setDate($new_date);
        }
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM posts;");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM posts WHERE id = {$this->getId()};");
        }
    }
 ?>
