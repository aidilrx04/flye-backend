<?php

namespace App\Support\ToyyibPay;

use Illuminate\Support\Carbon;

class Bill
{
	public string $name;
	public string $description;
	public string $to;
	public string $email;
	public string $phone;
	public int $status;
	public int $payment_status;
	public string $payment_channel;
	public float $payment_amount;
	public string $payment_invoice_no;
	public null $split_payment;
	public null $split_payment_args;
	public string $payment_settlement;
	public Carbon $payment_settlement_date;
	public string $settlemnent_reference_no;
	public Carbon $payment_date;
	public int $external_reference_no;
	public string $transaction_charge;
	public string $charge_on;

	public static function fromArray(array $array): Bill
	{
		$bill = new Bill;

		$bill->name = $array['billName'];
		$bill->description = $array['billDescription'];
		$bill->to = $array['billTo'];
		$bill->email = $array['billEmail'];
		$bill->phone = $array['billPhone'];
		$bill->status = (int)$array['billStatus'];
		$bill->payment_status = (int) $array['billpaymentStatus'];
		$bill->payment_channel = $array['billpaymentChannel'];
		$bill->payment_amount = (float) $array['billpaymentAmount'];
		$bill->payment_invoice_no = $array['billpaymentInvoiceNo'];
		$bill->split_payment = $array['billSplitPayment'];
		$bill->split_payment_args = $array['billSplitPaymentArgs'];
		$bill->payment_settlement = $array['billpaymentSettlement'];
		$bill->payment_settlement_date = Carbon::parse($array['billpaymentSettlementDate']);
		$bill->settlemnent_reference_no = $array['SettlementReferenceNo'];
		$bill->payment_date = Carbon::parse($array['billPaymentDate']);
		$bill->external_reference_no = (int) $array['billExternalReferenceNo'];
		$bill->transaction_charge = $array['transactionCharge'];
		$bill->charge_on = $array['chargeOn'];

		return $bill;
	}
}
