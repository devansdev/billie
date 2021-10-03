<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface
{
   public function all(): Collection;
   public function create($company):Model;
}