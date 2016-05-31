<?php

class Review extends General{
    private $sender_name;
    private $sender_email;
    private $review_body;
    private $date_sent;
    
    private function get_all_reviews() {
        global $database;
        $query = $database->query("SELECT * FROM reviews");
        return $query;
    }
    
    public function send_review() {
        global $database;
        
        $this->sender_name  = $database->escape_string($_POST['sender_name']);
        $this->sender_email = $database->escape_string($_POST['sender_email']);
        $this->review_body  = $database->escape_string($_POST['rev_body']);
        
        $query = $database->query("INSERT INTO reviews (sender_name, sender_email, review_body)"
                . "VALUES ('{$this->sender_name}', '{$this->sender_email}', '{$this->review_body}')");
                
        return $query;
    }
    
    public function display_reviews() {
        $reviews = $this->get_all_reviews();
        while($row = $reviews->fetch_array(MYSQLI_ASSOC)):
            $this->date_sent = $this->convert_to_date($row['date_sent']);
            $time = substr($row['date_sent'], 11, 19);
echo <<<REVIEWS
        <div class="row">
            <ul>
                <li><a href=""><i class="fa fa-user"></i>{$row['sender_name']}</a></li>
                <li><a href=""><i class="fa fa-clock-o"></i>{$time}</a></li>
                <li><a href=""><i class="fa fa-calendar-o"></i>$this->date_sent</a></li>
            </ul>
            <p>{$row['review_body']}</p>
        </div><br><br>    
REVIEWS;
        endwhile;
    }
}

