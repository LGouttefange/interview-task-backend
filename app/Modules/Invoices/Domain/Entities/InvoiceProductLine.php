<?php

namespace App\Modules\Invoices\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Money\Currency;
use Money\Money;

/**
 * App\Modules\Invoices\Api\Domain\Entity\ProductLine
 *
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine query()
 * @property int $id
 * @property string $invoice_id
 * @property Product $product
 * @property string $product_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceProductLine whereUpdatedAt($value)
 * @property-read \App\Modules\Invoices\Domain\Entities\Invoice $invoice
 * @mixin \Eloquent
 */
class InvoiceProductLine extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalPrice(): Money
    {
        return (new Money($this->product->price, new Currency($this->product->currency)))->multiply($this->quantity);
    }
}
