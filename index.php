<?php
if (filemtime("data.csv") < strtotime("-30 min")) {
    $url = "https://docs.google.com/spreadsheets/d/13sruU0j41C1gB-AO_kxK1tjRtyb50bYC9WmQLNwruOI/export?format=csv";
    file_put_contents("data.csv", file_get_contents($url));
    $fileHandle = fopen("data.csv", "r");
    convertCsv($fileHandle);
}
$apiUrl = "https://api.scryfall.com/";
$image = 'large';
?>
<?php
$fileHandle = fopen("data.csv", "r");

// function convertCsv($fh){
//     $apiUrl = "https://api.scryfall.com/";
//     $arr = array();
//     while (($row = fgetcsv($fh, 0, ",")) !== FALSE) {
//         if ($row[2] !== "") {
//             $cardName = urlencode($row[2]);
//             // $img = "imgs/" . str_replace("//", "", urldecode($cardName)) . ".jpg";
//             $cardFind = json_decode(file_get_contents($apiUrl . "cards/named?format=json&exact=" . $cardName), true);
//             $cardFind["rating"] = array(
//                 "j" => $row[0],
//                 "m" => $row[1],
//                 "ceiling" => $row[4],
//                 "sideboard" => $row[5],
//             );
//             $arr[] = $cardFind;
//         }
//     }
//     // var_dump(json_encode($arr));
//     var_dump(file_put_contents("json.json", json_encode($arr)));
// }

function string_cleanr($string) {
	$string = trim($string);
	$string = strip_tags($string);
	$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	$string = str_replace("\n", "", $string);
	$string = trim($string);
	// if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return $string;
}?>

<style>
  html, body {
    margin: 0;
    padding: 0;
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

  @media screen and (min-width: 500px) {
    .card-container {
      flex: 0 0 45%;
    }
  }

  @media screen and (min-width: 800px) {
    .card-container {
      flex: 0 0 20%;
    }

    /* .card-container:hover {
      flex: 0 0 25%;
      cursor: pointer;
      transition: all, 0.5s;
    } */
  }

  @media screen and (min-width: 1500px) {
    .card-container {
      flex: 0 0 15%;
    }

    /* .card-container:hover {
      flex: 0 0 20%;
    } */
  }

</style>

<div style="display: flex; max-width: 100vw; flex-wrap: wrap; background-color: #baeaf7;">
<a href="?sp=creature">
    <button>
        Creatures
    </button>
</a>
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
