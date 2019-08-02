<?php

namespace Zoho\Crm\Api\Modules;

/**
 * Leads module handler.
 *
 * @see https://www.zoho.com/crm/developer/docs/api/modules-fields.html#Leads
 */
class Leads extends AbstractRecordsModule
{
    /** @inheritdoc */
    protected static $primaryKey = 'LEADID';

    /** @inheritdoc */
    protected static $associatedEntity = \Zoho\Crm\Entities\Lead::class;

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
