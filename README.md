# SMMS-PHP-SDK

| Name | PHP | Version| Update |
| ------- | -------- | ----- | -------- |
|smms-sdk| >5.5 | 1.0.1 | 2020-06-03 |

#### sm.ms PHP-SDK  (api_v2)
- Support return-type change
- Support image upload
- Support for all functions by api-v2
- PHP version must > 5.5

#### License
GNU General Public License v3.0

#### Usage

For details, please refer to `test.php` and example `img_rand.php`.

```php
require("smms.class.php");
// Init, your authorization gets from dashboard (https://sm.ms/home/apitoken)
$sdk = new sdk\smms('Your Authorization');
$profile = $sdk->User_Profile('json'); // Return type
print_r($profile);
```

Return type: `json` or `xml`, the default value is `json`.