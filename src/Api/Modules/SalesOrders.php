<?php

namespace Zoho\Crm\Api\Modules;

/**
 * SalesOrders module handler.
 *
 * @see https://www.zoho.com/crm/developer/docs/api/modules-fields.html#Sales_Order
 */
class SalesOrders extends AbstractRecordsModule
{
    /** @inheritdoc */
    protected static $associatedEntity = \Zoho\Crm\Entities\Records\SaleOrder::class;

    /** @inheritdoc */
    protected static $supportedMethods = [
        'getFields',
        'getRecordById',
        'getRecords',
        'getMyRecords',
        'searchRecords',
        'insertRecords',
        'updateRecords',
        'deleteRecords',
        'getDeletedRecordIds',
        'getRelatedRecords',
        'getSearchRecordsByPDC',
        'deleteFile',
    ];
}
