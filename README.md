
<div align="center">
  <h1>TRestAPI</h1>
</div>

## Overview

Empower your applications with secure token authentication using our PHP-based RESTful API. Effortlessly manage authentication tokens, set usage limits, and ensure data security.

## Features

| Feature            | Description                                                                                     |
|--------------------|-------------------------------------------------------------------------------------------------|
| Token Creation     | Create authentication tokens with configurable limits.                                          |
| Token Validation   | Validate tokens to ensure secure access to resources.                                            |
| Usage Limit        | Set usage limits for tokens to control access.                                                    |
| Security Measures  | Implement security measures to prevent unauthorized access.                                       |
| Modular Design     | Organized code structure for easy maintenance and scalability.                                    |
| JSON Data Storage  | Store authentication keys and usage counts in JSON files for persistence.                        |

## Usage

1. **Get Authentication Keys (Tokens)**:
   - Endpoint: `/api_request.php/tokens?security=your_security_token_here`
   - Method: GET
   - Returns: JSON object containing authentication keys.

2. **Create Token**:
   - Endpoint: `/api_request.php/createtoken`
   - Method: POST
   - Parameters:
     - `token`: The token to create.
     - `limit` (optional): Usage limit for the token.
     - `security`: Security token for authorization.
   - Returns: Success message upon token creation.

3. **Validate Token**:
   - Endpoint: `/api.php?token=your_token_here`
   - Method: GET
   - Returns: Success message if token is valid, else Unauthorized error.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your_username/token-auth-api.git
   ```

2. Navigate to the project directory:
   ```bash
   cd TRestAPI
   ```

3. Configure the security token:
   - Open `api_request.php` and set the `$securityToken` variable to your desired security token value.

4. Run the PHP server:
   ```bash
   php -S localhost:5000
   ```

5. Access the API endpoints using cURL or an HTTP client.

## Contributing

Contributions are welcome! Fork the repository, make your changes, and submit a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
