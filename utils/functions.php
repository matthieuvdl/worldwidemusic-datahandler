<?php
require 'connect2.php';
require 'arrays.php';

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
    $albumNumbers, $decadeDb, $genreVals, $decadeTable,
    $genreTable;

    foreach ($countryTable as $countryElement)
    {
        if($countryElement == 'Congo%2C+Republic+of+the')
            $country = 'Republic of Congo';
        else if ($countryElement == 'Congo%2C+Democratic+Republic+of+the')
            $country = 'Democratic Republic of Congo';
        else if ($countryElement == 'Moldova%2C+Republic+of')
            $country = 'Moldova';
        else if ($countryElement == 'Man%2C+Isle+of')
            $country = 'Isle of Man';
        else if ($countryElement == 'Gambia%2C+The')
            $country = 'Gambia';
        else if ($countryElement == 'Micronesia%2C+Federated+States+of')
            $country = 'Federated States of Micronesia';
        else
        {
            $country = str_replace('+',' ',$countryElement);
            $country = str_replace('%26','and',$country);
            $country = str_replace('%2C',',',$country);
        }
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

// Generate an array with Discogs Data
function retrieveAlbumsArray($countryElement)
{
    global $header, $country, $albumNumbers, $decadeTable, $genreTable;
    $countryDatas = [];
    $country = str_replace('+', ' ', $countryElement);
    $tableTest = []; 
    foreach ($decadeTable as $decadeElement)
    {
        $tableTest = [];
        array_push($tableTest, $country);
        foreach ($genreTable as $genreElement)
        {
            if ($genreElement == 'hiphop')
                $genreElement = 'hip+hop';
            // JSON
            $apiCall = 'https://api.discogs.com/database/search?format=album&year=' . $decadeElement . '&type=release&genre=' . $genreElement . '&country=' . $countryElement . '';
            usleep(1000000);
            $ch = curl_init($apiCall);
            curl_setopt($ch, CURLOPT_USERAGENT, 'datamusicmatthieuvdl/1.0');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            $albumInfos = json_decode($data);
            $albumNumbers = $albumInfos->pagination->items;
            array_push($tableTest, $albumNumbers);
        }
        array_push($tableTest, substr($decadeElement, 0, 4));
        array_push($countryDatas, $tableTest);
    }
    return $countryDatas;
}

// Function: Apply (+) to 2 different arrays with the same size
function mergeArrays($array1, $array2)
{
    for ($i=0; $i < count($array1); $i++)
    { 
        if ($i == 0 || $i == count($array1) - 1)
            $array1[$i] = $array1[$i];
        else
            $array1[$i] = $array1[$i] + $array2[$i];
    }
    return $array1;
}

// Merge Multi-dimensionnal arrays
function mergeMultiArrays($arr1, $arr2)
{
    $result = [];
    for ($i=0; $i < count($arr1); $i++)
    {
        array_push($result, mergeArrays($arr1[$i], $arr2[$i]));
    }
    return $result;
}

// Function: Merge old with new countries
function mergeCountry($table)
{
    global $decadeTable, $pdo;
    for($z=0; $z < count($table); $z++)
    {
        $arr0 = retrieveAlbumsArray($table[$z][0]);
        $arr1 = retrieveAlbumsArray($table[$z][1]);
        $arr2 = mergeMultiArrays($arr0, $arr1);
        for ($i=0; $i < count($decadeTable) ; $i++) 
        {
            $prepare = $pdo->prepare('INSERT INTO albums (country, rock, jazz, pop, folk, funk, electronic, classical, latin, hiphop, reggae, blues, decade) 
            VALUES (:country, :rock, :jazz, :pop, :folk, :funk, :electronic, :classical, :latin, :hiphop, :reggae, :blues, :decade)');
            $prepare->execute(array(
            ':country' => $arr2[$i][0],
            ':rock' => $arr2[$i][1],
            ':jazz' => $arr2[$i][2],
            ':pop' => $arr2[$i][3],
            ':folk' => $arr2[$i][4],
            ':funk' => $arr2[$i][5],
            ':electronic' => $arr2[$i][6],
            ':classical' => $arr2[$i][7],
            ':latin' => $arr2[$i][8],
            ':hiphop' => $arr2[$i][9],
            ':reggae' => $arr2[$i][10],
            ':blues' => $arr2[$i][11],
            ':decade' => $arr2[$i][12])
            );
        }
    }
}

// Launch Functions
mergeCountry($countryFusion);

retrieveAlbumsDb($unaddedCountries);

// TESTS
// $testArray1 = 'France';
// $testArray2 = 'USSR';
// print_r(retrieveAlbumsArray($testArray1));
// print_r(retrieveAlbumsArray($testArray2));
// print_r(mergeCountry($countryFusion));
// print_r($countryFusion[0][1]);

