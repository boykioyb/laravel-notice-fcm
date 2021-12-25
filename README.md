Laravel send notifications by fcm
=======================

> php artisan vendor:publish --force

> Select notify-configs, notify-migrations

> php artisan migrate

Edit logging config
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
> Add NOTIFICATION_FCM_API_KEY to .env