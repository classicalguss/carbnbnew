<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
	'imagesFolder'   => (YII_ENV_DEV ? 'http://localhost/workspace/carbnbnew/uploads/' : 'http://178.62.110.252/uploads/'),
	'siteImagesPath' => (YII_ENV_DEV ? '/web/images' : 'http://178.62.110.252/frontend/web/images'),
	'apiDomain'=> (YII_ENV_DEV ? 'http://api.carbnb.com:8080' : 'http://api.bywai.info'),
];
