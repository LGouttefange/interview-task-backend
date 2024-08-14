<?php

namespace App\Modules\Invoices\Domain\Entities;

use App\Modules\Invoices\Domain\ValueObjects\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * App\Modules\Invoices\Domain\Entity\Invoice
 *
 * @property string $id
 * @property string $number
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property Company $company
 * @property string $company_id
 * @property string $status
 * @property Collection<InvoiceProductLine> $product_lines
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @property string $shipping_address_name
 * @property string $shipping_address_street
 * @property string $shipping_address_city
 * @property string $shipping_address_zip
 * @property string $billing_address_name
 * @property string $billing_address_street
 * @property string $billing_address_city
 * @property string $billing_address_zip
 * @property Address $shipping_address
 * @property Address $billing_address
 * @property-read int|null $product_lines_count
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBillingAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBillingAddressName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBillingAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBillingAddressZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereShippingAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereShippingAddressName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereShippingAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereShippingAddressZip($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{

    protected $keyType = 'string';
    public $incrementing = false;

    protected $dates = [
        'date',
        'due_date',
    ];
    protected $casts = [
        'shipping_address' => Address::class,
        'billing_address' => Address::class,
    ];

    public function uuid(): UuidInterface
    {
        return Uuid::fromString($this->id);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function product_lines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class, 'invoice_id', 'id');
    }

}
