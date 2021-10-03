<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface InvoiceRepositoryInterface
{
   public function all(): Collection;
   public function create($invoice):Model;
   public function markPaid($ivoiceId);
}