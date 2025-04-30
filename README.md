# amoCRM PHP Integration – Test Assignment

This repository contains the implementation of the amoCRM integration task using PHP, designed as part of a test assignment.

## Completed Features

- OAuth2.0 authorization using `authorization_code` flow
- Access and refresh token storage (`token.json`)
- Webhook endpoint for:
- New deal (сделка добавлена)
- New contact (контакт добавлен)
- Updated deal (сделка изменена)
- Updated contact (контакт изменен)
-  Automatically adds a text note to the relevant contact/deal on webhook trigger

## File Structure

| File            | Description                              |
|-----------------|------------------------------------------|
| `callback.php`  | Handles authorization code and stores token |
| `webhook.php`   | Receives amoCRM webhooks and adds notes |
| `token.json`    | Stores the access/refresh token (auto-generated) |
| `log.txt`       | Logs webhook responses                   |

## Live Server URLs

- **Callback URL**: [`https://task-emfi-1.onrender.com/callback.php`](https://task-emfi-1.onrender.com/callback.php)
- **Webhook URL**: [`https://task-emfi-1.onrender.com/webhook.php`](https://task-emfi-1.onrender.com/webhook.php)

## amoCRM Test User

- **Account**: [https://khatamovnodir1301.amocrm.ru](https://khatamovnodir1301.amocrm.ru)
- **Test User**: `test@emfy.com` (Administrator rights)

## How to Test

1. Open this OAuth link in your browser:  
https://www.amocrm.ru/oauth?client_id=YOUR_CLIENT_ID&redirect_uri=https://task-emfi-1.onrender.com/callback.php&response_type=code&state=123
