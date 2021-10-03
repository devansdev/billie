<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Repository\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:companies',
            'unpaid_invoice_limit' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return [
                'error' => implode(",", $validator->errors()->all())
            ];
        }

        // Retrieve the validated input...
        $validated = $validator->validated();
        $dbCompany = $this->companyRepository->create($validated);
        return [
            'data' => $dbCompany,
            'message' => 'Company created successfully!'
        ];
    }
}
