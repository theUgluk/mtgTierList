<?php
namespace Controllers\BaseController;

use Models\BaseModel\Model;
use Views\BaseView\View;

abstract class Controller {
  private $model;
  private $view;

  /*
   * This sets a model and view for this controller
   * every Controller has to contain these
   */
  __construct(Model $model, View $view){
    $this->model = $model;
    $this->view = $view;
  }


}
