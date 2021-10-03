<?php

namespace App\Http\Controllers;

use App\Repository\InvoiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'items' => 'required|integer|min:1',
            'total' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return [
                'error' => implode(",", $validator->errors()->all())
            ];
        }

        // Retrieve the validated input...
        $validated = $validator->validated();
        $invoice = $this->invoiceRepository->create($validated);
        if($invoice->exists){
            return [
                'data' => $invoice,
                'message' => 'Invoice created successfully!'
            ];
        }else{
            return [
                'data' => $invoice,
                'error' => 'Failed to create invoice. Unpaid invoice limit exeeded!'
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoiceId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $invoiceId)
    {
        $paid = $this->invoiceRepository->markPaid($invoiceId);
        if($paid){
            return [
                'data' => null,
                'message' => 'Invoice marked paid successfully!'
            ];
        }else{
            return [
                'data' => null,
                'error' => 'Failed to make invoice paid!'
            ];
        }
    }
}
