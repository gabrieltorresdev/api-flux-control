<?php

return [
    'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY', null),

    'token_encryption_algorithm' => env('KEYCLOAK_TOKEN_ENCRYPTION_ALGORITHM', 'RS256'),

    'load_user_from_database' => env('KEYCLOAK_LOAD_USER_FROM_DATABASE', true),

    'user_provider_credential' => env('KEYCLOAK_USER_PROVIDER_CREDENTIAL', 'username'),

    'token_principal_attribute' => env('KEYCLOAK_TOKEN_PRINCIPAL_ATTRIBUTE', 'preferred_username'),

    'append_decoded_token' => env('KEYCLOAK_APPEND_DECODED_TOKEN', true),

    'allowed_resources' => env('KEYCLOAK_ALLOWED_RESOURCES', 'web-flux-control'),

    'ignore_resources_validation' => env('KEYCLOAK_IGNORE_RESOURCES_VALIDATION', true),

    'leeway' => env('KEYCLOAK_LEEWAY', 0),

    'input_key' => env('KEYCLOAK_TOKEN_INPUT_KEY', 'access_token'),

    'base_url' => env('KEYCLOAK_URL'),

    'realm' => env('KEYCLOAK_REALM'),

    'client_id' => env('KEYCLOAK_CLIENT_ID'),

    'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),

    'verify_token' => true,
];
