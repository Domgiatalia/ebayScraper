<?php
set_time_limit(0);
$action = $_POST['action'];

$commandStart = 'https://www.ebay.co.uk/sch/i.html?_from=R40&_nkw=';
$commandMid = '';
$commandEnd = '&_sacat=0&_ipg=25';
$commandMid = str_replace(' ', '+', $action);
$scr = $commandStart . $commandMid . $commandEnd;

$command = escapeshellcmd("C:\Users\domzt\AppData\Local\Programs\Python\Python39\python.exe script.py $scr");
$output = shell_exec($command);

$pyarray = json_decode($output);
$newArraySorted = [];
$middle = '';
$FinalArray = [];

foreach($pyarray as $item) {
  if($item[3] != 'No Sold') {
    $item[3] = str_replace(',', '', $item[3]);
    $item[3] = intval($item[3]);
  }
  array_push($FinalArray, $item);
}

$keys = array_column($FinalArray, 3);
array_multisort($keys, SORT_DESC, $FinalArray);

$html = '<table class="tg">
<thead>
  <tr>
    <th class="tg-0pky">Link</th>
    <th class="tg-0lax">Item Name</th>
    <th class="tg-0lax">Quantity</th>
    <th class="tg-0lax">Amount Sold</th>
    <th class="tg-0lax">Price</th>
    <th class="tg-0lax">Seller</th>
    <th class="tg-0lax">Feedback</th>
    <th class="tg-0lax">Condition</th>
    <th class="tg-0lax">Location</th>
    <th class="tg-0lax">Image</th>
  </tr>
</thead>
<tbody>
';

$htmlend = '</tbody></table>';

foreach($FinalArray as $item) {
    $middle = $middle . '<tr>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;"><a href="'.$item[0].'">Link to Product</a></td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[1].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[2].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[3].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[4].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[5].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[6].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[7].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;">'.$item[8].'</td>
    <td class="tg-0lax" style="border: black solid 1px;text-align: center;background: lightcyan;"><img src="'.$item[9].'"</td>
    </tr>';
}

$html = $html . $middle . $htmlend;

echo($html);

require_once('Connection.php');

$dbh = new Connection();

foreach($pyarray as $item) {
  if($item[3] != 'No Sold') {
    $sql = "INSERT INTO items (name, sold, qty,seller,link) VALUES (?,?,?,?,?)";
    $q = $dbh->getInstance()->prepare($sql);
    $q->execute([$item[1],$item[3],$item[2],$item[5],$item[0]]);
  }

}

?>