A custom module for [mineralair.com](https://mineralair.com).

## How to install
```
bin/magento maintenance:enable
composer clear-cache
composer update mage2pro/core --ignore-platform-reqs 
composer require mineralair/core --ignore-platform-reqs
bin/magento setup:upgrade
rm -rf var/di var/generation generated/code && bin/magento setup:di:compile
rm -rf pub/static/* && bin/magento setup:static-content:deploy -f en_US --area adminhtml --theme Magento/backend && bin/magento setup:static-content:deploy -f en_US --area frontend --theme Yaman/mineralair
bin/magento maintenance:disable
```

## How to upgrade
```
bin/magento maintenance:enable
composer clear-cache
composer update mineralair/core --ignore-platform-reqs
bin/magento setup:upgrade
rm -rf var/di var/generation generated/code && bin/magento setup:di:compile
rm -rf pub/static/* && bin/magento setup:static-content:deploy -f en_US --area adminhtml --theme Magento/backend && bin/magento setup:static-content:deploy -f en_US --area frontend --theme Yaman/mineralair
bin/magento maintenance:disable
```

If you have problems with these commands, please check the [detailed instruction](https://mage2.pro/t/263).
