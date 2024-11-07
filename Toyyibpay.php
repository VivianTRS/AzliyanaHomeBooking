<?php

/**
 * 
 */
class ToyyibPay_Bill
{
	private $_params = [];
	private $_info;
	private $_billCode;

	function __construct( $secretKey, $categoryCode, $name, $description, $referenceNo = null )
	{
		$this->_params[ 'userSecretKey' ] = $secretKey;
		$this->_params[ 'categoryCode' ] = $categoryCode;
		$this->_params[ 'billName' ] = $name;
		$this->_params[ 'billDescription' ] = $description;
		$this->_params[ 'billPriceSetting' ] = 0;
		$this->_params[ 'billPayorInfo' ] = 0;
		$this->_params[ 'billPaymentChannel' ] = 2;
		if ( $referenceNo ) $this->_params[ 'billExternalReferenceNo' ] = $referenceNo;
	}

	public function payer( $name, $email, $phone ) //optional
	{
	 	$this->_params[ 'billTo' ] = $name;
	 	$this->_params[ 'billEmail' ] = $email;
	 	$this->_params[ 'billPhone' ] = $phone;
	 	$this->_params[ 'billPayorInfo' ] = 1;
	 	
	 	return $this;
	}

	# $value in ringgit
	public function amount( $value ) //optional
	{
		$amount = $value*100;
		$this->_params[ 'billAmount' ] = $amount;
		$this->_params[ 'billPriceSetting' ] = 1;
		
		return $this;
	}

	# 0 - FPX
	# 1 - Credit Card
	# 2 - Both
	public function paymentChannel( $FPXOrCreditCard ) //optional (Default - Both)
	{
		$this->_params[ 'billPaymentChannel' ] = $FPXOrCreditCard;
		return $this;
	}

	# 0 - FPX Only
	# 1 - Credit Card Only
	# 2 - Both FPX & Credit Card
	public function chargeToCustomer( $option ) // Optional (default to no-charge)
	{
		$this->_params[ 'billChargeToCustomer ' ] = $option;
		return $this;
	}

	public function expiry( $totalOfDaysOrDate )
	{
		if ( is_string($totalOfDaysOrDate) ) { // string (DateTime)
			$this->_params[ 'billExpiryDate' ] = $totalOfDaysOrDate;
		} elseif ( is_integer($totalOfDaysOrDate) ) { //int (Total Of Days = between 1 to 100)
			$this->_params[ 'billExpiryDays' ] = $totalOfDaysOrDate;
		}

		return $this;
	}

	public function callbackUrl( $redirectUrl = null, $callbackUrl = null )
	{
		if ( $redirectUrl ) $this->_params[ 'billReturnUrl' ] = $redirectUrl;
		if ( $callbackUrl ) $this->_params[ 'billCallbackUrl' ] = $callbackUrl;

		return $this;
	}

	public function emailContent($content) //1000 characters only
	{
		$this->_params[ 'billContentEmail' ] = $content;
		return $this;
	}

	private function _requestCode()
	{
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_POST, 1);
		curl_setopt( $curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $this->_params );

		$result = curl_exec( $curl );
		$this->_info = curl_getinfo( $curl );
		curl_close( $curl );

		$result = json_decode( $result, true );
		if (!$result ) return $result;

		$error = isset( $result['status'] ) && $result['status'] === 'error';
		if ( $error ) {
			return $result;
		}

		return $result[ 0 ][ 'BillCode' ];
	}

	public function getCode()
	{
		if ( $this->_billCode ) return $this->_billCode;
		$billCode = $this->_requestCode();
		$this->_billCode = $billCode;

		return $billCode;
	}

	public function getUrl()
	{
		$billCode = $this->getCode();
		if ( !$billCode ) return;

		return "https://toyyibpay.com/$billCode";
	}

	public function redirectToPaymentUrl()
	{
		$url = $this->getUrl();
		if ( !$url ) return false;

		header( "Location: $url" ); exit;
	}
}

/**
 * 
 */
class ToyyibPay
{
	private $_secretKey;
	function __construct( $secretKey )
	{
		$this->_secretKey = $secretKey;
	}

	public function createCategory( $name, $description )
	{
		
	}

	public function createBill( $categoryCode, $name, $description, $referenceNo = null )
	{
		return new ToyyibPay_Bill( $this->_secretKey, $categoryCode, $name, $description, $referenceNo );
	}

	public function getCategory( $categoryCode )
	{
		
	}

	public function getBill( $billCode )
	{
		
	}

	public function deactivateBill( $billCode )
	{
		
	}
}

