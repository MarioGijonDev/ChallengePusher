<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

$pusher = new Pusher\Pusher(
  "b1e46310abe9acbbad09", // Replace with 'key' from dashboard
  "0904b416d85d6d1148f3", // Replace with 'secret' from dashboard
  '1564323', // Replace with 'app_id' from dashboard
  array(
    'cluster' => "eu" // Replace with 'cluster' from dashboard
  )
);

$goalsScoredByMessi = [
  [
    'year' => "2004-2005",
    'goals' => 7
  ],
  [
    'year' => "2005-2006",
    'goals' => 8
  ],
  [
    'year' => "2006-2007",
    'goals' => 17
  ],
  [
    'year' => "2007-2008",
    'goals' => 16
  ],
  [
    'year' => "2008-2009",
    'goals' => 38
  ],
  [
    'year' => "2009-2010",
    'goals' => 47
  ],
  [
    'year' => "2010-2011",
    'goals' => 53
  ],
  [
    'year' => "2011-2012",
    'goals' => 73
  ],
  [
    'year' => "2012-2013",
    'goals' => 60
  ],
  [
    'year' => "2013-2014",
    'goals' => 41
  ],
  [
    'year' => "2014-2015",
    'goals' => 58
  ],
  [
    'year' => "2015-2016",
    'goals' => 41
  ],
  [
    'year' => "2016-2017",
    'goals' => 54
  ],
  [
    'year' => "2017-2018",
    'goals' => 45
  ],
  [
    'year' => "2018-2019",
    'goals' => 51
  ],
  [
    'year' => "2019-2020",
    'goals' => 31
  ],
  [
    'year' => "2020-2021",
    'goals' => 38
  ],
  [
    'year' => "2021-2022",
    'goals' => 11
  ],
  [
    'year' => "2022-2023",
    'goals' => 12
  ],
];

/* function renderChart($pusher, $goalsScoredByMessi){
  for ($i=0; $i < count($goalsScoredByMessi) ; $i++) {
    $pusher->trigger('price-btcusd', 'new-price', array(
      'year' => $goalsScoredByMessi[$i]['year'],
      'goals' => $goalsScoredByMessi[$i]['goals'],
    ));
    sleep(1);
  }
  exit;
} */

function renderChart($cont, $pusher, $goalsScoredByMessi){

  if($cont >= count(($goalsScoredByMessi))-1){
    $pusher->trigger('price-btcusd', 'new-price', array(
      'year' => $goalsScoredByMessi[$cont]['year'],
      'goals' => $goalsScoredByMessi[$cont]['goals'],
      'end' => true
    ));
    return true;
  }

  $pusher->trigger('price-btcusd', 'new-price', array(
    'year' => $goalsScoredByMessi[$cont]['year'],
    'goals' => $goalsScoredByMessi[$cont]['goals'],
  ));

  $cont++;

  sleep(1);

  return renderChart($cont, $pusher, $goalsScoredByMessi);

}

$postData = json_decode(trim(file_get_contents("php://input")), true);

if(!isset($postData['init']))
  die();

if($postData['init']){
  renderChart(0, $pusher, $goalsScoredByMessi);
  exit;
}

