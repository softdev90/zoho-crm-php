<?php

namespace Zoho\Crm\Entities;

/**
 * User entity class.
 */
class User extends AbstractEntity
{
    /** @inheritdoc */
    protected static $property_aliases = [
        'id'           => 'id',
        'zuid'         => 'zuid',
        'full_name'    => 'content',
        'email'        => 'email',
        'profile'      => 'profile',
        'role'         => 'role',
        'status'       => 'status',
        'confirmed'    => 'confirm',
        'phone'        => 'phone',
        'mobile_phone' => 'mobile',
        'fax'          => 'fax',
        'website'      => 'website',
        'street'       => 'street',
        'zipcode'      => 'zip',
        'city'         => 'city',
        'state'        => 'state',
        'country'      => 'country',
        'language'     => 'language',
        'timezone'     => 'timezone',
    ];
}
