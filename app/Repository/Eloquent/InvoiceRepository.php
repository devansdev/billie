<?php

namespace App\Repository\Eloquent;

use App\Models\Company;
use App\Models\Invoice;
use App\Repository\InvoiceRepositoryInterface;
use Illuminate\Support\Collection;

class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{

    /**
     * InvoiceRepository constructor.
     *
     * @param User $model
     */
    public function __construct(Invoice $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create($invoice): Invoice
    {
        $existingInvoices = $this->model->where('company_id', $invoice['company_id'])->where('paid', 0)->count();
        $company = Company::find($invoice['company_id']);
        
        if($existingInvoices >= $company->unpaid_invoice_limit){
            return new Invoice;
        }
        return $this->model->create($invoice);
    }

    public function markPaid($ivoiceId){
        $invoice = $this->model->find($ivoiceId);
        $invoice->paid = 1;
        return $invoice->save();
    }
}
