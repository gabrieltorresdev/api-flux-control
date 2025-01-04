<?php

return [
    'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY', null),

    'load_user_from_database' => env('KEYCLOAK_LOAD_USER_FROM_DATABASE', false),

    'user_provider_credential' => env('KEYCLOAK_USER_PROVIDER_CREDENTIAL', 'username'),

    'token_principal_attribute' => env('KEYCLOAK_TOKEN_PRINCIPAL_ATTRIBUTE', 'preferred_username'),

    'append_decoded_token' => env('KEYCLOAK_APPEND_DECODED_TOKEN', true),

    'allowed_resources' => env('KEYCLOAK_ALLOWED_RESOURCES', 'api-flux-control,web-flux-control'),

    'ignore_resources_validation' => env('KEYCLOAK_IGNORE_RESOURCES_VALIDATION', false),

    'leeway' => env('KEYCLOAK_LEEWAY', 0),

    'token_encryption_algorithm' => env('KEYCLOAK_TOKEN_ENCRYPTION_ALGORITHM', 'RS256'),

    // Keycloak URL and Realm
    'base_url' => env('KEYCLOAK_URL'),
    'realm' => env('KEYCLOAK_REALM'),

    // Client settings
    'client_id' => env('KEYCLOAK_CLIENT_ID'),
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),

    // Token verification settings
    'verify_token' => env('KEYCLOAK_VERIFY_TOKEN', true),

    // User handling
    'user_provider_custom_retrieve_method' => null,
    'input_key' => env('KEYCLOAK_TOKEN_INPUT_KEY', 'access_token'),

    // Cache settings
    'cache_openid' => env('KEYCLOAK_CACHE_OPENID', false),
    'cache_ttl' => env('KEYCLOAK_CACHE_TTL', 60),
];
