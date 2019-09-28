<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MTG Tier List</title>
        <meta name="description" content="MTG Tier List">
        <meta name="author" content="theUgluk">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="styles.css" type="text/css" rel="stylesheet">

        <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>

    </head>

    <body>

        <?php
        require 'setup.php';
        require 'functions.php';

        $types = array(
            "artifact",
            "creature",
            "enchantment",
            "instant",
            "land",
            "planeswalker",
            "sorcery"
        );
        $foundNames = array();
        if (isset($_GET['query'])) {
            $foundNames = search_query($_GET['query']);
        } else {
            /*
             * We're gonna keep track of the names of the cards of the type that's
             * selected and filter them in the while. It's ugly as hell,
             * but what in this script ain't?
             */
            if (isset($_GET['type']) && in_array($_GET['type'], $types, true)) {
                $foundNames = get_type_data($_GET['type']);
            }
        }
        if (filemtime("data.csv") < strtotime("-30 min")) {
            $url = "https://docs.google.com/spreadsheets/d/13sruU0j41C1gB-AO_kxK1tjRtyb50bYC9WmQLNwruOI/export?format=csv";
            file_put_contents("data.csv", file_get_contents($url));
        }

        $fileHandle = fopen("data.csv", "r");
        $apiUrl = "https://api.scryfall.com/";
        $image = 'large';


        ?>


        <div class="wrapper">
          <div class="flex-container">
            <aside class="sidebar">
              <div class="sidebar-wrapper">
                <div class="sidebar-module">
                  <h3>Filter cards</h3>
                  <form method="get">
                      <input type="text" id="search" placeholder="Search" name="query" value="<?= isset($_GET['query']) ? $_GET['query'] : "" ?>" />
                      <small>
                          You can use Scryfall query's here
                      </small>
                      <input type="submit" id="searchSubmit" class="btn" value="search" />
                  </form>
                </div>
                <div class="sidebar-module">
                  <a href="./" class="sidebar-link">All</a>
                  <?php
                  foreach ($types as $type) {
                    echo '<a href="?type=' . $type . '" class="sidebar-link">' . ucfirst($type) . '</a>';
                  } ?>

                </div>
              </div>
            </aside>

            <main class="main-content">
              <div style="display: flex; max-width: 100vw; flex-wrap: wrap; justify-content: space-evenly; ">
                  <?php
                  while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {
                      if ($row[2] !== "") {
                          $clearName = str_replace("//", "", $row[2]);
                          if (is_array($foundNames)
                                  && (
                                  count($foundNames) === 0
                                  || in_array($clearName, $foundNames)
                                  )
                          ) {
                              $cardName = urlencode($row[2]);
                              $img = "imgs/" . $clearName . ".jpg";
                              if (!file_exists($img)) {
                                  $cardFind = file_get_contents($apiUrl . "cards/named?format=image&version=large&exact=" . $cardName);
                                  file_put_contents($img, $cardFind);
                              }
                              ?>
                              <div class="card-container">
                                  <img src="<?= $img ?>" />
                                  <div class="card-info">
                                    <div class="card-marks">
                                      <div class="card-mark">
                                        <small class="mark-name">Justlolaman</small>
                                        <span class="mark"><?= $row[0] ?></span>
                                      </div>
                                      <div class="card-mark">
                                        <small class="mark-name">M0bieus</small>
                                        <span class="mark"><?= $row[1] ?></span>
                                      </div>
                                      <?php if ($row[3] !== "") { ?>
                                        <div class="card-mark card-mark-lower">
                                          <small class="mark-name">Ceiling</small>
                                          <span class="mark"><?= $row[3] ?></span>
                                        </div>
                                      <?php } ?>
                                      <?php if ($row[4] !== "") { ?>
                                        <div class="card-mark card-mark-lower">
                                          <small class="mark-name">Sideboard</small>
                                          <span class="mark">Yes</span>
                                        </div>
                                      <?php } ?>
                                    </div>
                                  </div>
                              </div>
                              <?php
                          }
                      }
                  }
                  ?>
              </div>
            </main>

          </div>
        </div>


    </body>
</html>
