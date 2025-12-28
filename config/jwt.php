<?php

return [
    'secret' => env('JWT_SECRET', 'app_test_jwt_secret_with_some_dummy_text_to_be_long_enough_for_H256'),
    'exp' => 2 * 60 * 60
];
