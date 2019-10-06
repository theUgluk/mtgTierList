<?php
/*
 * This is the main class of the application. This class provide all necessary
 * functionalities the app needs
 */
class App {
    private $completeCardList = array();
    private $completeReviewerList = array();
    private $activeFilters = array();
    private $filteredCardList = array();
    private $filteredReviewerList = array();
    private $cardTypes = array(
        "artifact",
        "creature",
        "enchantment",
        "instant",
        "land",
        "planeswalker",
        "sorcery"
    );


    public function addReviewerToFilter(Reviewer $reviewer){
        $this->filteredReviewerList[$reviewer->getId()] = $reviewer;
    }

    public function addCardFilter($key, $value){
        $activeFilters[$key] = $value;
    }

    public function addCard(Card $card){
        $this->completeCardList[] = $card;
    }

    private function intialize(){
        //@TODO write the actual (decent) initialize code here

    }

    private function getCardList(){
        $r1 = new Reviewer();
        $r1->setName("Justlolaman");
        $r2 = new Reviewer();
        $r2->setName("M0bieus");
        $fileHandle = fopen(dirname(__FILE__) . "./../data.csv", "r");
        while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {
            if ($row[2] !== "") {
                $clearName = str_replace("//", "", $row[2]);{
                $cardName = urlencode($row[2]);
                $img = "imgs/" . $clearName . ".jpg";
                if (!file_exists($img)) {
                    $cardFind = file_get_contents( "https://api.scryfall.com/cards/named?format=image&version=large&exact=" . $cardName);
                    file_put_contents($img, $cardFind);
                }
                $card = new Card($clearName, $img);
                $card->addRating($r1, $row[0]);
                $card->addRating($r2, $row[1]);
                $this->addCard($card);
                }
            }
        }
    }

    /*
     * Returns the html of which the header will be build off. We'll move this to an actual decent templating system sometimes
     */
    private function generateHeader(){
        return '<!DOCTYPE html>
        <html lang="en">
            <head>
                <title>MTG Tier List</title>
                <meta name="description" content="MTG Tier List">
                <meta name="author" content="theUgluk">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="styles.css" type="text/css" rel="stylesheet">
                <link href="vendor/font-awesome/css/all.css" rel="stylesheet">
            </head>
            <body class="js-body">';
    }

    private function generateMenu(){
        $menu = '
                <div class="wrapper">
                  <div class="flex-container">

                    <aside class="sidebar js-sidebar">
                      <div class="sidebar-wrapper">
                        <div class="sidebar-module">
                          <h3>Filter cards</h3>
                          <form method="get">
                              <input type="text" id="search" placeholder="Search" name="query" value="' . (isset($_GET['query']) ? $_GET['query'] : "") . '" />
                              <p><small>
                                  You can use Scryfall query\'s here
                              </small></p>
                              <input type="submit" id="searchSubmit" class="btn" value="search" />
                          </form>
                        </div>
                        <div class="sidebar-module">
                          <a href="./" class="sidebar-link">All</a>';

          foreach ($this->cardTypes as $type) {
            $menu .= '<a href="?type=' . $type . '" class="sidebar-link">' . ucfirst($type) . '</a>';
          }

        $menu .='</div></div></aside>';
        return $menu;
    }

    private function getFooter(){
        return '</body></html>';
    }

    /*
     * Basic render function, most of it would dissapear into a template engine (thank god)
     */
    public function render(){
        $this->getCardList();
        $html = $this->generateHeader();
        $html .= $this->generateMenu();
        $html .= '
        <main class="main-content">
            <span class="filters-fab js-filters-fab"><i class="fas fa-sort-amount-up"></i></span>
            <div style="display: flex; max-width: 100vw; flex-wrap: wrap; justify-content: space-evenly; ">';
        foreach($this->completeCardList as $card){
            $html .= $card->renderCard();
        }
        $html .= '</div></main></div></div><script src="main.js" type="text/javascript"></script>';
        $html .= $this->getFooter();
        echo $html;
    }
}
