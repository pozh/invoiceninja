<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2019. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Transformers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Utils\Traits\MakesHash;

class PaymentTransformer extends EntityTransformer
{
    use MakesHash;

    protected $serializer;

    protected $defaultIncludes = [];

    protected $availableIncludes = [
        'client',
        'invoice',
    ];

    public function __construct($serializer = null)
    {

        $this->serializer = $serializer;

    }

    public function includeInvoice(Payment $payment)
    {
        $transformer = new InvoiceTransformer($this->serializer);

        return $this->includeItem($payment->invoice, $transformer, Invoice::class);
    }

    public function includeClient(Payment $payment)
    {
        $transformer = new ClientTransformer($this->serializer);

        return $this->includeItem($payment->client, $transformer, Client::class);
    }
//todo incomplete
    public function transform(Payment $payment)
    {
        return  [
            'id' => $this->encodePrimaryKey($payment->id),
            'amount' => (float) $payment->amount,
            /*
            'transaction_reference' => $payment->transaction_reference ?: '',
            'payment_date' => $payment->payment_date ?: '',
            'updated_at' => $this->getTimestamp($payment->updated_at),
            'archived_at' => $this->getTimestamp($payment->deleted_at),
            'is_deleted' => (bool) $payment->is_deleted,
            'payment_type_id' => (int) ($payment->payment_type_id ?: 0),
            'invoice_id' => (int) ($this->invoice ? $this->invoice->public_id : $payment->invoice->public_id),
            'invoice_number' => $this->invoice ? $this->invoice->invoice_number : $payment->invoice->invoice_number,
            'private_notes' => $payment->private_notes ?: '',
            'exchange_rate' => (float) $payment->exchange_rate,
            'exchange_currency_id' => (int) $payment->exchange_currency_id,
            'refunded' => (float) $payment->refunded,
            'payment_status_id' => (int) $payment->payment_status_id,
            */
        ];
    }
}