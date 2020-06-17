<?php
require 'utils/connect.php';
require 'utils/arrays.php';

// Set Token
$token = 'kEdAOaZzCWtapUMqxnrnKITLtjHluBOZfncHTxZC';

// Set Headers for CURL
$header = array();
$header[] = 'Authorization: Discogs token='.$token;
$header[] = 'Content-type: application/json';

// Values
$country = '';
$decade = '';
$genre = '';
$albumNumbers = 0;
$decadeDb = '';

// Arrays
$genreVals = array();


// Set DB Data from Discogs
function retrieveAlbumsDB($countryTable)
{
    global $header, $pdo, $country, $decade, $genre, 
    $albumNumbers, $decadeDB, $genreVals, $decadeTable,
    $genreTable;

    foreach ($countryTable as $countryElement)
    {
        $country = str_replace('+',' ',$countryElement);
        foreach ($decadeTable as $decadeElement)
        {
            foreach ($genreTable as $genreElement) 
            {
                if ($genreElement == 'hiphop')
                    $genreElement = 'hip+hop';
                $genrename = $genreElement;
                // JSON
                $apiCall = 'https://api.discogs.com/database/search?format=album&year='.$decadeElement.'&type=release&genre='.$genreElement.'&country='.$countryElement.'';
                usleep(1000000);
                $ch = curl_init($apiCall);
                curl_setopt($ch, CURLOPT_USERAGENT, 'datamusicmatthieuvdl/1.0');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $data = curl_exec($ch);
                curl_close($ch);
                $albumInfos = json_decode($data);
                $albumNumbers = $albumInfos->pagination->items;
                array_push($genreVals, $albumNumbers);
            }

            $decadeDb = substr($decadeElement, 0, 4);
            settype($decadeDb, 'integer');

            $prepare = $pdo->prepare('INSERT INTO albums (country, rock, jazz, pop, folk, funk, electronic, classical, latin, hiphop, reggae, blues, decade) 
            VALUES (:country, :rock, :jazz, :pop, :folk, :funk, :electronic, :classical, :latin, :hiphop, :reggae, :blues, :decade)');

            $prepare->execute(array(
            ':country' => $country,
            ':rock' => $genreVals[0],
            ':jazz' => $genreVals[1],
            ':pop' => $genreVals[2],
            ':folk' => $genreVals[3],
            ':funk' => $genreVals[4],
            ':electronic' => $genreVals[5],
            ':classical' => $genreVals[6],
            ':latin' => $genreVals[7],
            ':hiphop' => $genreVals[8],
            ':reggae' => $genreVals[9],
            ':blues' => $genreVals[10],
            ':decade' => $decadeDb)
            );
            $genreVals = array();
        }
    }
}

// Set Array Data from Discogs


// Function add old countries

// $countryFusion = 
//     array(
//         array('USSR','Russia',''),
//         array('Yugoslavia','Serbia',''),
//         array('Czechoslovakia', 'Czech+Republic', 'Slovakia')
//     );

$countryFusion =
[
['USSR','Russia',''],
['Yugoslavia','Serbia',''],
['Czechoslovakia','Czech+Republic','Slovakia']
];


function mergeCountry($table)
{
    $size = count($table) - 1;
    foreach ($table as $tableElement) 
    {
        return $tableElement[$size];

    }


}

retrieveAlbumsDB($countryList);
mergeCountry($countryFusion);