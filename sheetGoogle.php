<?php
require __DIR__ . '/vendor/autoload.php';

//Reading data from spreadsheet.

$client = new \Google_Client();

$client->setApplicationName('sheet google api');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);

//we need to provide our SpreadsheetID and range.
$spreadsheetId = '1JR2uAjnN67c4sRnfnyGXdzXjz535v6MNgB48pLvVI1I'; //It is present in your URL
$get_range = 'P2m';


// Fetching data from your spreadsheet and storing it.
//Request to get data from spreadsheet.
$response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
// var_dump($response);
$values = $response->getValues();
// var_dump($values);

if (empty($values)) {
    print "no data";
} else {
    print json_encode($values);
}

// Updating the data in your google sheet

// Set your update range like earlier
$update_range = "P2m!A4:B4";
// Store your values in an array of arrays.
$values = [["testNom", "testPrenom"]];


// Creating a request.
$body = new Google_Service_Sheets_ValueRange([

      'values' => $values

    ]);

    $params = [

      'valueInputOption' => 'RAW'

    ];

    // Calling update service.

    $update_sheet = $service->spreadsheets_values->update($spreadsheetId, $update_range, $body, $params);


    