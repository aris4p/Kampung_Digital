<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
	protected $iuran;

	public function __construct($iuran)
	{
		parent::__construct();

		$this->iuran = $iuran;
	}

	public function getSnapToken()
	{
		$params = [
			/**
			 * 'order_id' => id order unik yang akan digunakan sebagai "primary key" oleh Midtrans untuk
			 * 				 membedakan order satu dengan order lain. Key ini harus unik (tidak boleh ada duplikat).
			 * 'gross_amount' => merupakan total harga yang harus dibayar customer.
			 */
			'transaction_details' => [
				'order_id' => $this->iuran->idtrx,
				'gross_amount' => $this->iuran->nominaltrx,
			],
			/**
			 * 'item_details' bisa diisi dengan detail item dalam order.
			 * Umumnya, data ini diambil dari tabel `order_items`.
			 */
			'item_details' => [
				[
					'id' => 'dd', // primary key produk
					'price' => '150000', // harga satuan produk
					'quantity' => 1, // kuantitas pembelian
					'name' => 'Flashdisk Toshiba 32GB', // nama produk
				],

			],
			'customer_details' => [
				// Key `customer_details` dapat diisi dengan data customer yang melakukan order.
				'first_name' => 'Martin Mulyo Syahidin',
				'email' => 'sadwsad@gmail.com',
				'phone' => '081234567890',
			]
		];

		$snapToken = Snap::getSnapToken($params);

		return $snapToken;
	}
}
