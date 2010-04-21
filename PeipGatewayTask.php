<?php

include_once 'phing/Task.php';
include_once 'PEIP/PEIP.php';


class PeipGatewayTask extends Task
{

    //
    // The class's properties
    //

	protected $gateway = "";
	
	protected $configfile = "";

	protected $message = "";

       protected $context;
   
	//
	// Setter methods for each XML attribute
	//

	/**
	 * Sets the gateway name
	 */
	function setGateway($gateway)
	{
		$this->gateway = $gateway;
	}

	/**
	 * Returns the gateway name
	 */
	function getGateway()
	{
		return $this->gateway;
	}

	/**
	 * Sets the configfile
	 */
	function setConfigfile($configfile)
	{
		$this->configfile = $configfile; 
	}

	/**
	 * Returns the configfile
	 */
	function getConfigfile()
	{
		return $this->configfile;
	}

	/**
	 * Sets the message to send
	 */
	function setMessage($message)
	{
		$this->message = $message;
	}

	/**
	 * Returns the message to send
	 */
	function getMessage()
	{
		return $this->message;
	}

	//
	// The init() method
	//
	
	function init() 
	{		

	}
	
    //
    // The main() method
    //

	function main()
	{
		if(file_exists($this->getConfigfile())){
			$this->context = PEIP_XML_Context::createFromFile($this->configfile);
		}else{
			$this->log("ERROR: Could not create Context.");
			$this->log("ERROR: File '".$this->getConfigfile()."' does not exist");	
		}
		if(isset($this->context)){
			$gateway = $this->context->getGateway($this->getGateway());
			if($gateway){
				$this->log("Sending Message through Gateway: '" .$this->getGateway(). "'");
				$this->log("Message: '" .$this->getMessage(). "'");
				$gateway->send($this->message);
			}else{
				$this->log("ERROR: Could not get Gateway: ".$this->getGateway());
			}
		}else{
			$this->log("ERROR: Could not get Context.");
		}	
	}
	
}
?>
