<?php
/*
 * This is the main class of the application. This class provide all necessary
 * functionalities the app needs
 */
class App {
    private completeCardList = array();
    private completeReviewerList = array();
    private activeFilters = array();
    private filteredCardList = array();
    private filteredReviewerList = array();

    public function addReviewerToFilter(Reviewer $reviewer){
        $this->filteredReviewerList[$reviewer->getId()] = $reviewer;
    }

    public function addCardFilter($key, $value){
        $activeFilters[$key] = $value;
    }

    public function render(){
        echo "render";
    }
}
