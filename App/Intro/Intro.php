<?php
namespace Intro;

class Intro {
  function __construct(){
    echo "
      Todo (before being functional):
      <ul>
        <li>
          Decide on a project structure <br />
          Probably gonna be something like this:
          <ul>
            <li>
              Have Models, Controllers and Managers
            </li>
            <li>
              Models keep a flat idea of the data with getters and setters (do force types on getters)
            </li>
            <li>
              Controllers are linked to models, they compile the data and have function to render stuff (basically containing the means to render the model in a desired form)
            </li>
            <li>
              Rendering will happen in Latte files, called by the Controller
            </li>
            <li>
              There will be several Managers, who process data where nessesary
            </li>
          </ul>
        </li>
        <li>
          Build router
        </li>
        <li>
          Work out database connection
        </li>
        <li>
          Work out class structure
        </li>
        <li>
          Actually work?
        </li>
      </ul>
    ";
  }
}
?>
