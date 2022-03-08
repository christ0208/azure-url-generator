# Xtrics/AzureUrlGenerator

Simple library to generate Azure API URL and endpoints. The results will be used for developer's needs when doing request to Azure REST API. The development itself are based on needs in [Azure API Documentations]. This library are tested on generate virtual machines, network security groups, public IP addresses, and virtual machine disks.

[Azure API Documentations]: https://docs.microsoft.com/en-us/rest/api/azure/

## Installation

Require `xtrics/azure-url-generator` using composer.

## How to Use

### Before Using The Library
1. Please publish the config file by using following command.
```bash
php artisan vendor:publish --provider "Xtrics\AzureUrlGenerator\GeneratorServiceProvider"
```

2. Configure ```config/azure.php``` file as needed.

### Examples to Use the Library

1. Generate Azure API URL for ```get_single_vm```, registered in ```config/azure.php```.
```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Xtrics\AzureUrlGenerator\Generator;

class VirtualMachineController extends Controller
{
    public function generateUrl()
    {
        $vmName = 'test';
        $apiVersion = '2021-01-01';
        $str = Generator::generateUrl('get_single_vm', [
            'subscription-id' => config('azure.subscription_id'),
            'resource-group' => config('azure.resource_group'),
            'vm-name' => $vmName,
            'api-version' => $apiVersion
        ]);

        echo $str;
    }
}

```