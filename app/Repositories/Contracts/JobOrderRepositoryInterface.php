<?php

namespace App\Repositories\Contracts;

use App\Models\JobOrder;

/**
 * @method JobOrder|null find(mixed $id)
 * @method JobOrder|null first()
 */
interface JobOrderRepositoryInterface extends RepositoryInterface
{
	//define set of methods that JobOrderRepositoryInterface Repository must implement
	public function filterByReferenceNumber(string $referenceNumber): static;
	public function filterByCustomerName( string $customerName ): static;
}
