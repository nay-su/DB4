<?php

define("_RADIO_FIELD_INDEX_", 0);
define("_RADIO_OPTIONS_INDEX_", 1);
define("_RESULT_LIMIT_", 25);

require_once 'vendor/autoload.php';
require_once('formModel.lib');
require_once('inputTags.lib');

//use Exception; // In the global namespace, so this is not needed
use MongoDB\Client;
use MongoDB\Driver\ServerApi;

// This array contains all valid amenities values
$amenities = array();
$amenities[] = "24-hour check-in";
$amenities[] = "Accessible-height bed";
$amenities[] = "Accessible-height toilet";
$amenities[] = "Air conditioning";
$amenities[] = "Air purifier";
$amenities[] = "Alfresco shower";
$amenities[] = "BBQ grill";
$amenities[] = "Baby bath";
$amenities[] = "Baby monitor";
$amenities[] = "Babysitter recommendations";
$amenities[] = "Balcony";
$amenities[] = "Bath towel";
$amenities[] = "Bathroom essentials";
$amenities[] = "Bathtub";
$amenities[] = "Bathtub with bath chair";
$amenities[] = "Beach chairs";
$amenities[] = "Beach essentials";
$amenities[] = "Beach view";
$amenities[] = "Beachfront";
$amenities[] = "Bed linens";
$amenities[] = "Bedroom comforts";
$amenities[] = "Bicycle";
$amenities[] = "Bidet";
$amenities[] = "Body soap";
$amenities[] = "Boogie boards";
$amenities[] = "Breakfast";
$amenities[] = "Breakfast bar";
$amenities[] = "Breakfast table";
$amenities[] = "Building staff";
$amenities[] = "Buzzer/wireless intercom";
$amenities[] = "Cable TV";
$amenities[] = "Carbon monoxide detector";
$amenities[] = "Cat(s)";
$amenities[] = "Ceiling fan";
$amenities[] = "Central air conditioning";
$amenities[] = "Changing table";
$amenities[] = "Chef's kitchen";
$amenities[] = "Children’s books and toys";
$amenities[] = "Children’s dinnerware";
$amenities[] = "Cleaning before checkout";
$amenities[] = "Coffee maker";
$amenities[] = "Convection oven";
$amenities[] = "Cooking basics";
$amenities[] = "Crib";
$amenities[] = "DVD player";
$amenities[] = "Day bed";
$amenities[] = "Dining area";
$amenities[] = "Disabled parking spot";
$amenities[] = "Dishes and silverware";
$amenities[] = "Dishwasher";
$amenities[] = "Dog(s)";
$amenities[] = "Doorman";
$amenities[] = "Double oven";
$amenities[] = "Dryer";
$amenities[] = "EV charger";
$amenities[] = "Electric profiling bed";
$amenities[] = "Elevator";
$amenities[] = "En suite bathroom";
$amenities[] = "Espresso machine";
$amenities[] = "Essentials";
$amenities[] = "Ethernet connection";
$amenities[] = "Extra pillows and blankets";
$amenities[] = "Family/kid friendly";
$amenities[] = "Fax machine";
$amenities[] = "Fire extinguisher";
$amenities[] = "Fireplace guards";
$amenities[] = "Firm mattress";
$amenities[] = "First aid kit";
$amenities[] = "Fixed grab bars for shower";
$amenities[] = "Fixed grab bars for toilet";
$amenities[] = "Flat path to front door";
$amenities[] = "Formal dining area";
$amenities[] = "Free parking on premises";
$amenities[] = "Free street parking";
$amenities[] = "Full kitchen";
$amenities[] = "Game console";
$amenities[] = "Garden or backyard";
$amenities[] = "Gas oven";
$amenities[] = "Ground floor access";
$amenities[] = "Gym";
$amenities[] = "Hair dryer";
$amenities[] = "Handheld shower head";
$amenities[] = "Hangers";
$amenities[] = "Heated towel rack";
$amenities[] = "Heating";
$amenities[] = "High chair";
$amenities[] = "Home theater";
$amenities[] = "Host greets you";
$amenities[] = "Hot tub";
$amenities[] = "Hot water";
$amenities[] = "Hot water kettle";
$amenities[] = "Ice Machine";
$amenities[] = "Indoor fireplace";
$amenities[] = "Internet";
$amenities[] = "Iron";
$amenities[] = "Ironing Board";
$amenities[] = "Kayak";
$amenities[] = "Keypad";
$amenities[] = "Kitchen";
$amenities[] = "Kitchenette";
$amenities[] = "Lake access";
$amenities[] = "Laptop friendly workspace";
$amenities[] = "Lock on bedroom door";
$amenities[] = "Lockbox";
$amenities[] = "Long term stays allowed";
$amenities[] = "Luggage dropoff allowed";
$amenities[] = "Memory foam mattress";
$amenities[] = "Microwave";
$amenities[] = "Mini fridge";
$amenities[] = "Mountain view";
$amenities[] = "Murphy bed";
$amenities[] = "Netflix";
$amenities[] = "Other";
$amenities[] = "Other pet(s)";
$amenities[] = "Outdoor parking";
$amenities[] = "Outdoor seating";
$amenities[] = "Outlet covers";
$amenities[] = "Oven";
$amenities[] = "Pack ’n Play/travel crib";
$amenities[] = "Paid parking off premises";
$amenities[] = "Paid parking on premises";
$amenities[] = "Parking";
$amenities[] = "Patio or balcony";
$amenities[] = "Permit parking";
$amenities[] = "Pets allowed";
$amenities[] = "Pets live on this property";
$amenities[] = "Pillow-top mattress";
$amenities[] = "Pocket wifi";
$amenities[] = "Pool";
$amenities[] = "Pool with pool hoist";
$amenities[] = "Private bathroom";
$amenities[] = "Private entrance";
$amenities[] = "Private hot tub";
$amenities[] = "Private living room";
$amenities[] = "Private pool";
$amenities[] = "Rain shower";
$amenities[] = "Refrigerator";
$amenities[] = "Roll-in shower";
$amenities[] = "Room-darkening shades";
$amenities[] = "Safe";
$amenities[] = "Safety card";
$amenities[] = "Sauna";
$amenities[] = "Self check-in";
$amenities[] = "Shampoo";
$amenities[] = "Shared pool";
$amenities[] = "Shower chair";
$amenities[] = "Single level home";
$amenities[] = "Ski-in/Ski-out";
$amenities[] = "Smart TV";
$amenities[] = "Smart lock";
$amenities[] = "Smoke detector";
$amenities[] = "Smoking allowed";
$amenities[] = "Snorkeling equipment";
$amenities[] = "Sonos sound system";
$amenities[] = "Sound system";
$amenities[] = "Stair gates";
$amenities[] = "Standing valet";
$amenities[] = "Step-free access";
$amenities[] = "Stove";
$amenities[] = "Suitable for events";
$amenities[] = "Sun loungers";
$amenities[] = "Swimming pool";
$amenities[] = "TV";
$amenities[] = "Table corner guards";
$amenities[] = "Tennis court";
$amenities[] = "Terrace";
$amenities[] = "Toaster";
$amenities[] = "Toilet paper";
$amenities[] = "Walk-in shower";
$amenities[] = "Warming drawer";
$amenities[] = "Washer";
$amenities[] = "Washer / Dryer";
$amenities[] = "Waterfront";
$amenities[] = "Well-lit path to entrance";
$amenities[] = "Wheelchair accessible";
$amenities[] = "Wide clearance to bed";
$amenities[] = "Wide clearance to shower";
$amenities[] = "Wide doorway";
$amenities[] = "Wide entryway";
$amenities[] = "Wide hallway clearance";
$amenities[] = "Wifi";
$amenities[] = "Window guards";
$amenities[] = "toilet";


// Steps of aggregation pipeline
$steps = array();
$steps[] = "match";
$steps[] = "project";
$steps[] = "group";
$steps[] = "sort";


//arrays for match and sort pipelines
//text queries
$textMatchArray = array();

$textMatchArray[] = "name";
$textMatchArray[] = "description";
$textMatchArray[] = "address.street";
$textMatchArray[] = "address.suburb";
$textMatchArray[] = "transit";
$textMatchArray[] = "property_type";
//between text queries is an array of arrays because there are 3 strings per line
$betweenMatchArray = array();

$betweenMatchArray[] = array("accomodates","lowaccomodates", "hiaccomodates");
$betweenMatchArray[] = array("bedrooms", "lowbedrooms", "hibedrooms");
$betweenMatchArray[] = array("bathrooms", "lowbathrooms", "hibathrooms");
$betweenMatchArray[] = array("price", "lowprice", "hiprice");
$betweenMatchArray[] = array ("cleaning fee", "lowcleaning_fee", "hicleaning_fee");

//radio
$radioMatchArray = array();

$radioMatchArray[] = "address.country";
$radioMatchArray[] = "room_type";
$radioMatchArray[] = "bed_type";
$radioMatchArray[] = "cancellation_policy";
//$amenities[] -- checkbox


//Sort Array
$sortArray = array();
//radio
$sortArray[] = "accomodates";
$sortArray[] = "bedrooms";
$sortArray[] = "bathrooms";
$sortArray[] = "beds";
$sortArray[] = "price";
$sortArray[] = "cleaning_fee";



// Will represent a MQL query
$query = array();

?>
<CENTER>
<H1>Sky BnB</H1>
<?=buildFormStart('queryform','mongo.php')?>

<TABLE>
<?php

//create inputs for textMatchArray
foreach($textMatchArray as $match) {
	// Retrieve previously submitted query data
	$query[$match] = empty($_REQUEST[$match]) ? NULL : $_REQUEST[$match];
	echo '<TR><TD align="right">';
	echo '$'.$match;
	echo "</TD><TD>";
	echo buildText($match,empty($query[$match]) ? "" : htmlentities($query[$match]),55,2048);
	echo "</TD></TR>";
}

//create inputs for betweenMatchArray
foreach($betweenMatchArray as $match) {
	// Retrieve previously submitted query data
	$query[$match] = empty($_REQUEST[$match]) ? NULL : $_REQUEST[$match];
	echo '<TR><TD align="right">';
	echo $match.' between ';
    echo buildText($match,empty($query[$match]) ? "" : htmlentities($query[$match]),15,50);
	echo "</TD></TR>";
}

//begin adding text inputs
?>
</TABLE>

<?=buildSubmit('submit','Submit Query')?>
<?=buildFormEnd()?>
</CENTER>
<?php

// Connection string for my MongoDB database
$uri = "mongodb+srv://student:SUstudent_in_DatabaseFall2023@schrumsu.tbf3xyo.mongodb.net/?retryWrites=true&w=majority";

if(!empty($query)) {

	// Specify Stable API version 1
	$apiVersion = new ServerApi(ServerApi::V1);

	// Create a new client and connect to the server
	$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

	// Select the database and collection
	$database = $client->selectDatabase("sample_airbnb");
	$collection = $database->selectCollection("listingsAndReviews");

	// Contains all queries within the aggregation pipeline
	$pipeline = array();

	foreach($steps as $step) {

		if(!empty($query[$step])) {
			// The user has to enter validly formatted JSON queries for the decode to work
			$decoded = json_decode($query[$step], true);
			echo '<BR><BR>$'.$step.':<BR>';
			var_dump($decoded); // For debugging
			$pipeline[] = ['$'.$step => $decoded];
		}
	}

	echo '<BR><BR>Full Pipeline</BR>';
	var_dump($pipeline); // For debugging

	if(!empty($pipeline)) {
		// Send query to MongoDB
		$queryResult = $collection->aggregate($pipeline);

		$divNum = 0;
		// Display the results
		foreach ($queryResult as $document) {
			// The JavaScript code neatly displays the JSON objects using the renderjson.js library
?>

	<div id="test<?= $divNum ?>"></div>
	<HR>
	<script type="text/javascript" src="renderjson.js"></script>
	<script>
	var example = <?= json_encode($document) ?>;

	renderjson.set_show_to_level(1);
	document.getElementById("<?= "test".$divNum ?>").appendChild(renderjson(example));
	</script>

<?php
			$divNum++;
		}
	}
}
?>

