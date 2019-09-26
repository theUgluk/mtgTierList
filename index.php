<!DOCTYPE html>

<html lang="en">
  <head>
    <title>MTG Tier List</title>
    <meta name="description" content="MTG Tier List">
    <meta name="author" content="theUgluk">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
      html, body {
        margin: 0;
        padding: 0;
        overflow: auto;
        position: relative;
        height: 100%;
        width: 100%;
        box-sizing: border-box;
      }

      .card-container {
        flex: 0 1 100%;
        margin: 0.5rem;
        /* padding: 0.5rem; */
        background-color: #fff;
        /* border-bottom: 4px solid #aaa; */
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0px 3px 5px rgba(0,0,0,0.5);
        transition: all, 0.5s;
      }

      .card-container img {
        width: 100%;
        height: auto;
      }

      .card-container .info {
        padding: 0.5rem;
        font-family: Arial, Helvetica, sans-serif;
      }

      table tr td:first-of-type {
        font-weight: 600;
      }

      .btn {
        padding: 0.7rem 2rem;
        background: orange;
        color: white;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 0.75em;
        letter-spacing: 0.1em;
        box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        margin: 1rem;
        transition: all 0.5s;
      }

      .btn:hover {
        cursor: pointer;
        background-color: #000;
        transition: all 0.5s;
      }

      @media screen and (min-width: 500px) {
        .card-container {
          flex: 0 0 45%;
        }
      }

      @media screen and (min-width: 800px) {
        .card-container {
          flex: 0 0 20%;
        }
      }

      @media screen and (min-width: 1500px) {
        .card-container {
          flex: 0 0 15%;
        }
      }

    </style>
  </head>

  <body>

    <?php
    if (filemtime("data.csv") < strtotime("-30 min")) {
        $url = "https://docs.google.com/spreadsheets/d/13sruU0j41C1gB-AO_kxK1tjRtyb50bYC9WmQLNwruOI/export?format=csv";
        file_put_contents("data.csv", file_get_contents($url));
    }
    $fileHandle = fopen("data.csv", "r");
    $apiUrl = "https://api.scryfall.com/";
    $image = 'large';
    ?>
    <?php
    function string_cleanr($string) {
    	$string = trim($string);
    	$string = strip_tags($string);
    	$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    	$string = str_replace("\n", "", $string);
    	$string = trim($string);
    	// if (get_magic_quotes_gpc()) $string = stripslashes($string);
    	return $string;
    }?>

    <button class="btn">Klik hier!</button>

    <div style="display: flex; max-width: 100vw; flex-wrap: wrap; background-color: #baeaf7;">


    <?php
    while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {
        if ($row[2] !== "") {
            $cardName = urlencode($row[2]);
            $img = "imgs/" . str_replace("//", "", urldecode($cardName)) . ".jpg";
            if (!file_exists($img)) {
                $cardFind = file_get_contents($apiUrl . "cards/named?format=image&version=large&exact=" . $cardName);
                file_put_contents($img, $cardFind);
            }
            ?>
            <div class="card-container">
                <img src="<?= $img ?>" />
                <div class="info">
                    <table>
                        <tr>
                            <td>
                                J's mark:
                            </td>
                            <td>
                                <?= $row[0] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                M's mark:
                            </td>
                            <td>
                                <?= $row[1] ?>
                            </td>
                        </tr>
                        <?php
                        if ($row[4] !== "") {
                            ?>
                            <tr>
                                <td>
                                    Ceiling:
                                </td>
                                <td>
                                    <?= $row[4] ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        if ($row[5] !== "") {
                            ?>
                            <tr>
                                <td>
                                    Sideboard:
                                </td>
                                <td>
                                    <?= $row[5] ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
        }
    }
    ?>

    </div>
  </body>
</html>
