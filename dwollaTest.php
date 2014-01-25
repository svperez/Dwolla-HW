<?php
// Include the Dwolla REST Client. May need to be change and place under lib
require 'dwolla.php';
// Include any required keys. Needs to be in the same directoy as this file
require 'keys.php';

/*
 * Simple class to view account information, balance and send money
 */
class User
{
	//A client object
	public $Dwolla;
	//HOlds information of cLient
	public $me;
	//Holds balance of client
	public $balance;
 	
	public $pin;

public function __construct($apiKey,$apiSecret,$token,$pin)
{

	// Instantiate a new Dwolla REST Client
	$this->Dwolla = new DwollaRestClient($apiKey, $apiSecret);
	//Set token
	$this->Dwolla->setToken($token);
	//Set info and balance
	$this->me = $this->Dwolla->me();
	$this->balance = $this->Dwolla->balance();
	//set pin
	$this->pin = $pin;
}

/*
 * Displays account information
 */
public function accountInfo()
{
        echo "Name: ".$this->me["Name"]."<br>";
	echo "Id: ".$this->me["Id"]."<br>";
	echo "Type: ".$this->me["Type"]."<br>";
	echo "City: ".$this->me["City"]."<br>";
	echo "State: ".$this->me["State"]."<br>";
}

/*
 * Displays current balance
 */
public function balance()
{
	echo "Current Balance: $".$this->balance."<br>";
}

/*
 * What the function does
 *
 * @param double $amount    Amount to be sent
 * @param String $ID    Id of person recieving the money

 */
public function send($ID,$amount)
{
	$transactionId = $this->Dwolla->send($this->pin, $ID, $amount);
	if(!$transactionId) { echo "Error: {$this->Dwolla->getError()} \n"; } // Check for errors
	else { echo "Send transaction ID: {$transactionId} \n"; } // Print Transaction ID
}
}


//Example of how to use the program

$user = new User($apiKey,$apiSecret,$token,$pin);
$user->accountInfo();
$user->balance();
//$user->send('812-713-9234',1.00);


?>
