<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repository;

use App\Modules\Invoices\Application\Mapper\CompanyMapper;
use App\Modules\Invoices\Application\Mapper\InvoiceMapper;
use App\Modules\Invoices\Application\Mapper\ProductMapper;
use App\Modules\Invoices\Domain\Entity\Company;
use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Entity\Product;
use EduardoMarques\TypedCollections\TypedCollectionImmutable;
use EduardoMarques\TypedCollections\TypedCollectionInterface;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * @throws \Exception
     */
    public function findById(UuidInterface $id): ?Invoice
    {
        $invoiceRaw = DB::table('invoices')->find(
            $id->toString(),
            [
                'id',
                'number',
                'date',
                'status',
                'due_date AS dueDate',
                'company_id AS companyId',
                'created_at AS createdAt',
                'updated_at AS updatedAt',
            ]
        );

        if (null === $invoiceRaw) {
            return null;
        }

        $invoice = InvoiceMapper::fromRawToEntity($invoiceRaw);

        $company = $this->findCompanyById($id);

        if (null !== $company) {
            $invoice->setCompany($company);
        }

        $products = $this->findProductsById($id);

        foreach ($products->toArray() as $product) {
            $invoice->addProduct($product);
        }

        return $invoice;
    }

    /**
     * @throws \Exception
     */
    public function findProductsById(UuidInterface $id): TypedCollectionInterface
    {
        $productsRaw = DB::table('invoice_product_lines')
            ->select(
                'products.id AS id',
                'name',
                'price',
                'currency',
                'quantity',
                'products.created_at AS createdAt',
                'products.updated_at AS updatedAt',
            )->join('products', 'product_id', '=', 'products.id')
            ->where('invoice_id', $id->toString())
            ->get();

        $products = TypedCollectionImmutable::create(Product::class);

        foreach ($productsRaw as $productRaw) {
            $product = ProductMapper::fromRawToEntity($productRaw);
            $products = $products->add($product);
        }

        return $products;
    }

    /**
     * @throws \Exception
     */
    public function findCompanyById(UuidInterface $id): ?Company
    {
        $companyRaw = DB::table('invoices')
            ->select(
                'companies.id AS id',
                'name',
                'street',
                'city',
                'zip',
                'phone',
                'email',
                'companies.created_at AS createdAt',
                'companies.updated_at AS updatedAt',
            )->join('companies', 'company_id', '=', 'companies.id')
            ->where('invoices.id', $id->toString())
            ->first();

        return CompanyMapper::fromRawToEntity($companyRaw);
    }

    public function update(Invoice $invoice): void
    {
        $persistenceData = InvoiceMapper::fromEntityToPersistenceArray($invoice);

        DB::table('invoices')
            ->where('id', $invoice->getId()->toString())
            ->update($persistenceData);
    }
}
