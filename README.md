# Binance Pay Integration for Magento 2

## Overview

The module provides integration with the Binance Pay payment gateway, enabling Magento 2 stores to accept payments through BinancePay. This module allows customers to use the BinancePay payment method during checkout, offering a seamless and secure payment experience. Additionally, the module supports refund functionality, allowing store administrators to process refunds directly from the Magento admin panel.

## Features

- Integrates Binance Pay as a payment method in Magento 2.
![image](https://github.com/user-attachments/assets/79b22a26-2713-4a56-8e48-72f7beb4cffc)
- Secure payment transactions with webhook integration.
![image](https://github.com/user-attachments/assets/3c70024e-dd04-43f9-8cf4-4527cbbf37be)
- Handles payment success and error cases.
![image](https://github.com/user-attachments/assets/7a2ff4da-9c95-474c-8317-c3d08cb2cb44)
- Asynchronous processing using RabbitMQ for smooth payment workflows.
- Refund functionality

## Requirements

- Magento 2.4.x
- PHP 8.2 or higher
- Binance Pay merchant account
- RabbitMQ installed and configured

## Installation

1. **Clone or Download the Module**

   Download the module from the repository and place it in the Magento 2 `app/code/Internship/BinancePay` directory.

2. **Enable the Module**

   Run the following commands to enable the module:

   ```bash
   bin/magento module:enable Internship_BinancePay
   bin/magento setup:upgrade
   bin/magento setup:di:compile
   bin/magento setup:static-content:deploy -f

## Configuration

1. Go to the Magento Admin Panel: Navigate to Stores > Configuration > Sales > Payment Methods.
2. Configure BinancePay Settings: Locate the BinancePay section and configure the settings.
   ![Screenshot 2024-10-18 at 1 53 09 PM](https://github.com/user-attachments/assets/4ae8e618-1208-415e-9a16-26364c658907)

### Webhook Setup
To ensure that your Magento 2 store can handle payment notifications from Binance Pay, you need to set up a webhook in the Binance Pay developer dashboard:

Go to the Binance Pay Developer Dashboard:

Navigate to the `Binance Pay Developer Dashboard` and select the `Webhooks` section.<br/>

Add a new webhook with the following URL:
```
https://<your-magento-domain>/binancepay/checkout/webhook
```

Replace `<your-magento-domain>` with your actual Magento domain.
This URL will handle incoming payment notifications from Binance Pay.

Make sure RabbitMQ is installed and configured in your Magento 2 environment.
Start the Magento Consumer for Order Creation:

```
bin/magento queue:consumers:start binance.order.creation &
```

## Support
For support or questions, please contact the author:

Author: Andrii Tomkiv<br/>
Email: tomkivandrii18@gmail.com

## License
[LICENSE](https://github.com/tomk1v/binance-pay-module/blob/main/LICENSE.md). For more information, see the LICENSE file.
