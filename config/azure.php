<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Azure Subscription ID
    |--------------------------------------------------------------------------
    |
    | This value is the subscription ID for Azure. This value is used when the
    | application needs to use Azure API services from Microsoft.
    |
    */

    'subscription_id' => env('AZURE_SUBSCRIPTION_ID', 'EMPTY'),

    /*
    |--------------------------------------------------------------------------
    | Azure API Base URL
    |--------------------------------------------------------------------------
    |
    | This value is the base URL in Azure. This value is used when the 
    | application needs to do manipulation of services in Azure API.
    |
    */

    'base_url' => env('AZURE_BASE_URL', 'https://management.azure.com/subscriptions'),

    /*
    |--------------------------------------------------------------------------
    | Azure Resource Group Name
    |--------------------------------------------------------------------------
    |
    | This value is the resource group name in Azure. This value, combined with 
    | subscription ID, is used when the application needs to do manipulation of 
    | services in Azure.
    |
    */

    'resource_group' => env('AZURE_RESOURCE_GROUP', 'EMPTY'),

    /*
    |--------------------------------------------------------------------------
    | Azure API Endpoints
    |--------------------------------------------------------------------------
    |
    | This value is the list of endpoints in Azure. This value are used for
    | calling specific procedures in Azure API. You can add new endpoint to
    | Azure API here. To specify a string that will be replaced, you can add
    | temporary variable with pattern "__variable__".
    | Examples of endpoints are written below. Please adapt it with your needs.
    |
    */

    'endpoints' => [

        /*
        |--------------------------------------------------------------------------
        | Azure API Endpoint: Get Specific Gallery Image Version
        |--------------------------------------------------------------------------
        |
        | This value is the endpoint in Azure. This value are used for fetch 
        | specific version of gallery images in Azure API.
        |
        */
        
        'get_specific_gallery_image_version' => '/subscriptions/__subscription-id__/resourceGroups/__resource-group__/providers/Microsoft.Compute/galleries/master_galery/images/__image-name__/versions/__image-version__',

        /*
        |--------------------------------------------------------------------------
        | Azure API Endpoint: Get Specific VM
        |--------------------------------------------------------------------------
        |
        | This value is the endpoint in Azure. This value are used for fetch 
        | specific Virtual Machine in Azure API from specific subscription ID and 
        | resource group name.
        |
        */

        'get_single_vm' => '/__subscription-id__/resourceGroups/__resource-group__/providers/Microsoft.Compute/virtualMachines/__vm-name__?api-version=__api-version__',

        /*
        |--------------------------------------------------------------------------
        | Azure API Endpoint: Get Specific Disk
        |--------------------------------------------------------------------------
        |
        | This value is the endpoint in Azure. This value are used for fetch 
        | specific disk in Azure API from specific subscription ID and resource 
        | group name.
        |
        */

        'get_single_disk' => '/__subscription-id__/resourceGroups/__resource-group__/providers/Microsoft.Compute/disks/__disk-name__?api-version=__api-version__',
    ],

];