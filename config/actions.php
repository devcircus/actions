<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Namespace
    |--------------------------------------------------------------------------
    |
    | Set the namespace for the Actions.
    |
    */
    'namespace' => 'Http\\Actions',

    /*
    |--------------------------------------------------------------------------
    | Method name
    |--------------------------------------------------------------------------
    |
    | Set the method to be invoked in the actions.
    |
    */
    'method' => '__invoke',

    /*
    |--------------------------------------------------------------------------
    | Suffix
    |--------------------------------------------------------------------------
    |
    | Set the suffix for the action.
    |
    */

    'suffix' => '',

    /*
    |--------------------------------------------------------------------------
    | Duplicate Suffixes
    |--------------------------------------------------------------------------
    |
    | If you have a Action suffix set in the config and try to generate a Action that also includes the suffix,
    | the package will recognize this duplication and rename the Action to remove the extra suffix.
    | This is the default behavior. To override and allow the duplication, change to false.
    |
    */
    'override_duplicate_suffix' => true,
];
