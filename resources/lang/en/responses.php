<?php

return [
//    'errors' => [
//        'token' => [
//            'token_invalid'           => 'Invalid access token.',
//            'token_absent'            => 'Missing access token.',
//            'token_expired'           => 'Expired or blacklisted access token.',
//            'token_blacklisted'       => 'Blacklisted access token.',
//            'user_not_found'          => 'Access token user not found.',
//            'forbidden'               => 'Access denied.',
//            'not_found'               => 'Resource not found.',
//            'invalid_credentials'     => 'Invalid credentials.',
//            'could_not_create_token'  => 'The token could not be created.',
//            'could_not_refresh_token' => 'Not able to refresh token.',
//            'password_token_invalid'  => 'Password token is invalid.',
//            'password'                => 'Current password does not match.',
//            'email_update'            => 'This e-mail has already been taken.',
//        ]
//    ],
    'auth' => [
        'login'               => 'Welcome back.',
        'logout'              => 'User logged out successfully.',
        'credentials_updated' => 'Credentials changed successfully.',
        'password_token_sent' => 'Password token has been sent.',
        'errors'              => [
            'invalid_credentials'    => 'Invalid credentials.',
            'wrong_password'         => 'Wrong password.',
            'could_not_create_token' => 'Token could not be created.'
        ],
    ],

    'user' => [
        'created' => 'User created successfully.',
        'updated' => 'User updated successfully.',
        'deleted' => 'User deleted successfully.',
    ],

    'removal_request' => [
        'created'            => 'Removal request created successfully.',
        'archived'           => 'Removal request archived successfully.',
        'canceled'           => 'Removal request canceled successfully.',
        'voting_registered'  => 'Voting result registered successfully.',
        'rapporteur_changed' => 'Rapporteur changed successfully.',
    ],

    'mandate' => [
        'created' => 'New mandate created successfully.'
    ],

    'opinion' => [
        'manifested_against' => 'Manifest created successfully.',
        'deferred'           => 'Opinion deferred successfully.',
        'ct-registered'      => 'Opinion of CT registered successfully.',
        'prppg-registered'   => 'Opinion of PRPPG registered successfully.'
    ]
];