<?php
require __DIR__ . '/vendor/autoload.php';


$client = new \Google_Client();

$client->setApplicationName('sheet google api');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);

//we need to provide our SpreadsheetID and range.
$spreadsheetlink = explode("/", "https://docs.google.com/spreadsheets/d/1JR2uAjnN67c4sRnfnyGXdzXjz535v6MNgB48pLvVI1I/edit#gid=0");
$spreadsheetID = $spreadsheetlink[5]; //It is present in your URL

$spreadSheet = $service->spreadsheets->get($spreadsheetID);
$sheets = $spreadSheet->getSheets();

$sheetArr = array();

// $sheet->properties->sheetId
foreach ($sheets as $sheet) {
    array_push($sheetArr, $sheet->properties->title);
}

echo $sheetArr[0];

$get_range = $sheetArr[0];
//Reading data from spreadsheet.
// Fetching data from your spreadsheet and storing it.
//Request to get data from spreadsheet.
$response = $service->spreadsheets_values->get($spreadsheetID, $get_range);
// var_dump($response);
$values = $response->getValues();
// var_dump($values);

if (empty($values)) {
    print "no data";
} else {
    print json_encode($values);
}
exit();
// Updating the data in your google sheet
// Set your update range like earlier
$update_range = "P2m!A5:B5";
// Store your values in an array of arrays.
$values = [["aaaaaaa", "bbbbbb"]];


// Creating a request.
$body = new Google_Service_Sheets_ValueRange([

    'values' => $values

]);

$params = [

    'valueInputOption' => 'RAW'

];

// Calling update service.

$update_sheet = $service->spreadsheets_values->update($spreadsheetId, $update_range, $body, $params);
