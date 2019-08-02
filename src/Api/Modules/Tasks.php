<?php

namespace Zoho\Crm\Api\Modules;

/**
 * Tasks module handler.
 *
 * @see https://www.zoho.com/crm/developer/docs/api/modules-fields.html#Tasks
 */
class Tasks extends AbstractRecordsModule
{
    /** @inheritdoc */
    protected static $primaryKey = 'ACTIVITYID';

    /** @inheritdoc */
    protected static $associatedEntity = \Zoho\Crm\Entities\Task::class;

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
