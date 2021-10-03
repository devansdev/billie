<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Company;
use App\Models\Invoice;
use Tests\TestCase;

class BillieTest extends TestCase
{
    /**
     * Testing full cycle.
     *
     * @return void
     */
    public function test_all()
    {
        $company = Company::factory()->make();
        $response = $this->post('/api/company',$company->toArray());
        $response->assertJson([
            'message' => 'Company created successfully!'
        ]);

        $invoice = Invoice::factory()->make();
        $invoice->company_id = $response->original['data']->id;
        $invResponse = $this->post('/api/invoice',$invoice->toArray());

        $invResponse->assertJson([
            'message' => 'Invoice created successfully!'
        ]);
        
        $payResponse = $this->post('/api/invoice/' .  $invResponse->original['data']->id . '/paid');
        $payResponse->assertJson([
            'message' => 'Invoice marked paid successfully!'
        ]);
    }

    /**
     * Testing limit of unpaid invoices.
     *
     * @return void
     */
    public function test_unpaid_limit()
    {
        $company = Company::factory()->make();
        $response = $this->post('/api/company',$company->toArray());

        for($count=1;$count <= $response->original['data']->unpaid_invoice_limit;$count ++){
            $invoice = Invoice::factory()->make();
        
            $invoice->company_id = $response->original['data']->id;
            $invResponse = $this->post('/api/invoice',$invoice->toArray());
        }
        
        
        // this invoice should be created
        $invoice = Invoice::factory()->make();
        $invResponse = $this->post('/api/invoice',$invoice->toArray());
        $invResponse->assertJson([
            'message' => 'Invoice created successfully!'
        ]);

        //this one shuld show limit exeeding message
        $invoice = Invoice::factory()->make();
        $invoice->company_id = $response->original['data']->id;
        $failResponse = $this->post('/api/invoice',$invoice->toArray());

        $failResponse->assertJson([
            'error' => 'Failed to create invoice. Unpaid invoice limit exeeded!'
        ]);
    }
}
