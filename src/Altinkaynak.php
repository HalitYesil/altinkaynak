<?php
/**
 * MIT License
 * Copyright (c) 2020 HalitYesil
 *  
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Altinkaynak;

use Altinkaynak\Request\Request;
use Altinkaynak\Response\GetCurrencyResponse;
use Altinkaynak\Response\Currency;

class Altinkaynak{
	
	private $service_address 	= 'http://data.altinkaynak.com/DataService.asmx?WSDL';
	private $service_username 	= 'AltinkaynakWebServis';
	private $service_password	= 'AltinkaynakWebServis';
	private $service_namespace 	= 'http://data.altinkaynak.com/';
	
	/**
	 * 
	 * @var \SoapClient
	 */
	private $Service = null;
		
	/**
	 * 
	 * @param string|null $username
	 * @param string|null $password
	 * @param string|null $url
	 */
	public function __construct($username = null, $password = null, $url = null){
		if(!empty($username)){ $this->setUsername($username); }
		if(!empty($password)){ $this->setPassword($password); }
		if(!empty($url)){ $this->setServiceURL($url); }
	}
	
	/**
	 * Get Currency
	 * Instant exchange rate information 
	 * 
	 * @return \Altinkaynak\Response\Currency[]
	 */
	public function GetCurrency(){
		$SoapResponse = $this->ServiceCall('GetCurrency');
		
		$Response = new \SimpleXMLElement($SoapResponse->GetCurrencyResult);
		
		$GetCurrencyResponse = new GetCurrencyResponse(null);
	
		$GetCurrencyResponse->Currencies = [];
		
		if(isset($Response->Kur) && !empty($Response->Kur)){
			foreach ($Response->Kur as $Kur) {
				$Currency = new Currency(null);
				$Currency->code			= $Kur->Kod->__toString();
				$Currency->desc			= $Kur->Aciklama->__toString();
				$Currency->buying		= floatval($Kur->Alis->__toString());
				$Currency->selling		= floatval($Kur->Satis->__toString());
				$Currency->update_time	= $Kur->GuncellenmeZamani->__toString();
				array_push($GetCurrencyResponse->Currencies, $Currency);
			}
		}
		
		return $GetCurrencyResponse->Currencies;
	}
	
	/**
	 * Get Gold
	 * Instant gold rate information
	 *
	 * @return \Altinkaynak\Response\Currency[]
	 */
	public function GetGold(){
		$SoapResponse = $this->ServiceCall('GetGold');
		
		$Response = new \SimpleXMLElement($SoapResponse->GetGoldResult);
		
		$GetCurrencyResponse = new GetCurrencyResponse(null);
		
		$GetCurrencyResponse->Currencies = [];
		
		if(isset($Response->Kur) && !empty($Response->Kur)){
			foreach ($Response->Kur as $Kur) {
				$Currency = new Currency(null);
				$Currency->code			= $Kur->Kod->__toString();
				$Currency->desc			= $Kur->Aciklama->__toString();
				$Currency->buying		= floatval($Kur->Alis->__toString());
				$Currency->selling		= floatval($Kur->Satis->__toString());
				$Currency->update_time	= $Kur->GuncellenmeZamani->__toString();
				array_push($GetCurrencyResponse->Currencies, $Currency);
			}
		}
				
		return $GetCurrencyResponse->Currencies;
	}
	
	/**
	 * Get Main 
	 * Instantly selected exchange rate, gold rate and parity information
	 *
	 * @return \Altinkaynak\Response\Currency[]
	 */
	public function GetMain(){
		$SoapResponse = $this->ServiceCall('GetMain');
		
		$Response = new \SimpleXMLElement($SoapResponse->GetMainResult);
		
		$GetCurrencyResponse = new GetCurrencyResponse(null);
		
		$GetCurrencyResponse->Currencies = [];
		
		if(isset($Response->Kur) && !empty($Response->Kur)){
			foreach ($Response->Kur as $Kur) {
				$Currency = new Currency(null);
				$Currency->code			= $Kur->Kod->__toString();
				$Currency->desc			= $Kur->Aciklama->__toString();
				$Currency->buying		= floatval($Kur->Alis->__toString());
				$Currency->selling		= floatval($Kur->Satis->__toString());
				$Currency->update_time	= $Kur->GuncellenmeZamani->__toString();
				array_push($GetCurrencyResponse->Currencies, $Currency);
			}
		}
		
		return $GetCurrencyResponse->Currencies;
	}
	
	/**
	 * 
	 * @param string $method
	 * @param Request $Request
	 * @return mixed
	 */
	private function ServiceCall($method, $Request = null){
		
		if($Request === null){
			$Request = new Request();
		}
		
		return $this->getService()->__soapCall($method, [$method=>$Request]);
	}
	
	/**
	 * 
	 * @return \SoapClient
	 */
	private function getService(){
		if($this->Service === null){
			$this->Service = new \SoapClient($this->getServiceURL(), [
				"trace" 	=> 1,
				"exception" => 1
			]);
			
			$AuthHeader = new \stdClass();
			$AuthHeader->Username	= $this->getUsername();
			$AuthHeader->Password	= $this->getPassword();
			
			$Header = new \SoapHeader($this->service_namespace, 'AuthHeader', $AuthHeader, false);
			
			$this->Service->__setSoapHeaders($Header);
		}
		return $this->Service;
	}
	
	/**
	 * Set Webservice Username
	 * 
	 * @param string $username
	 */
	public function setUsername($username){
		$this->service_username = $username;
		$this->Service = null;
	}
	
	/**
	 * Set Webservice Password
	 * 
	 * @param string $password
	 */
	public function setPassword($password){
		$this->service_password = $password;
		$this->Service = null;
	}
	
	/**
	 * Set Webservice Address
	 * 
	 * @param string $url
	 */
	public function setServiceURL($url){
		$this->service_address = $url;
		$this->Service = null;
	}
	
	/**
	 * Get Current Webservice Username
	 * 
	 * @return string
	 */
	public function getUsername(){
		return $this->service_username;
	}
	
	/**
	 * Get Current Webservice Password
	 * 
	 * @return string
	 */
	public function getPassword(){
		return $this->service_password;
	}
	
	/**
	 * Get Current Webserice Address
	 * 
	 * @return string
	 */
	public function getServiceURL(){
		return $this->service_address;
	}
}