Laravel send notifications by fcm
=======================

> php artisan vendor:publish --force

> php artisan migrate

Edit Logging config
=======================

> open file config/logging.php

> Add new logging:
```php
<?php
return [
    'channels'=>[
        'notification' => [
            'driver' => 'daily',
            'path' => storage_path('logs/notification.log'),
            'level' => 'debug',
            'days' => 14,
        ]
    ]
]
?>
```
