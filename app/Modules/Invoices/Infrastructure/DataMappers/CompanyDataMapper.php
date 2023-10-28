<?php
declare(strict_types=1);
namespace App\Modules\Invoices\Infrastructure\DataMappers;

use App\Modules\Invoices\Domain\Company;

class CompanyDataMapper
{
    public function mapToApiResponse(Company $company)
    {
        return [
            'Name' => $company->getName(),
            'Street Address' => $company->getStreet(),
            'City' => $company->getCity(),
            'Zip code' => $company->getZip(),
            'Phone' => $company->getPhone(),
            'email' => $company->getEmail(),
        ];
    }
}


