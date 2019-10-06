<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

class Card {
    private $name;
    private $image;
    private $ratings = array();

    public function __construct($name, $image = null){
        $this->setName($name);
        if($image !== null){
            $this->setImage($image);
        }
        return $this;
    }

    public function addRating(Reviewer $reviewer, $rate){
        $this->ratings[] =  array(
            "reviewer" => $reviewer,
            "rate" => $rate
        );
    }

    public function getRatings(){
        return $this->ratings;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function getImage(){
        return $this->image;
    }

    public function renderCard(){
        $cardDiv = '<div class="card-container">
        <img src="' . $this->getImage()  . '" />
        <div class="card-info">
            <div class="card-marks">';
                foreach($this->getRatings() as $rating){
                    $cardDiv .= '<div class="card-mark">
                        <small class="mark-name">' . $rating['reviewer']->getName() . '</small>
                        <span class="mark">' . $rating['rate'] . '</span>
                    </div>';
                }
        $cardDiv .= '</div></div></div>';
        return $cardDiv;
    }

    // if ($row[3] !== "") {
    //   <div class="card-mark card-mark-lower">
    //     <small class="mark-name">Ceiling</small>
    //     <span class="mark">$row[3]</span>
    //   </div>
    //  }
    // if ($row[4] !== "") {
    //   <div class="card-mark card-mark-lower">
    //     <small class="mark-name">Sideboard</small>
    //     <span class="mark">Yes</span>
    //   </div>
    // }

}
?>
