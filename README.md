# FormServices API Client for Laravel

[![GitHub release](https://img.shields.io/github/v/release/profdecodor/formservices-api-client?style=flat-square)](https://github.com/profdecodor/formservices-api-client/releases)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-8892BF.svg?style=flat-square)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/laravel-11.x%20%7C%2012.x-FF2D20.svg?style=flat-square)](https://laravel.com)
[![License](https://img.shields.io/github/license/profdecodor/formservices-api-client?style=flat-square)](LICENSE)

> **Warning**
> This package is currently in early development. The API may change without notice.
> **Do not use in production environments** - or do so at your own risk.

A Laravel package for interacting with the JWay FormServices API. Supports multi-client configuration and API versioning.

## Features

- **Multi-client support** - Configure multiple API clients for different environments (dev, staging, prod)
- **API versioning** - Built-in support for API version management (currently v2023)
- **Typed resources** - Full IDE autocompletion with typed resource classes
- **Pagination handling** - Built-in support for paginated responses
- **Laravel integration** - Service Provider, Facade, and dependency injection support
- **Comprehensive coverage** - 13+ API resources with 40+ methods

## Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x
- GuzzleHTTP 7.8+

## Installation

### From GitHub (recommended)

Add the repository to your `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/profdecodor/formservices-api-client"
        }
    ],
    "require": {
        "profdecodor/formservices-api-client": "dev-main"
    }
}
```

Then run:

```bash
composer update profdecodor/formservices-api-client
```

### From Packagist (when available)

```bash
composer require profdecodor/formservices-api-client
```

### Publish Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Jway\FormServicesApiClient\FormServicesApiClientServiceProvider" --tag="config"
```

This will create `config/formservices-api-client.php`.

## Configuration

### Environment Variables

Add these variables to your `.env` file:

```env
# Default client to use
FORMSERVICES_DEFAULT_CLIENT=main

# Main client configuration
FORMSERVICES_MAIN_URL=https://your-formservices-instance.com/portal
FORMSERVICES_MAIN_LOGIN=your-username
FORMSERVICES_MAIN_KEY=your-api-key
FORMSERVICES_MAIN_TIMEOUT=30
FORMSERVICES_MAIN_VERSION=2023
FORMSERVICES_MAIN_VERIFY_SSL=true

# Secondary client (optional)
FORMSERVICES_SECONDARY_URL=https://staging.formservices-instance.com/portal
FORMSERVICES_SECONDARY_LOGIN=staging-user
FORMSERVICES_SECONDARY_KEY=staging-api-key
FORMSERVICES_SECONDARY_TIMEOUT=60
FORMSERVICES_SECONDARY_VERSION=2023
FORMSERVICES_SECONDARY_VERIFY_SSL=true
```

### Configuration Parameters

| Parameter | Description | Example |
|-----------|-------------|---------|
| `*_URL` | FormServices API base URL | `https://api.example.com/portal` |
| `*_LOGIN` | Authentication login | `api-user` |
| `*_KEY` | API key | `your-secret-key` |
| `*_TIMEOUT` | Request timeout in seconds | `30` |
| `*_VERSION` | API version | `2023` |
| `*_VERIFY_SSL` | Verify SSL certificates | `true` |

### SSL Security

> **Warning**: Always use `VERIFY_SSL=true` in production. Only disable SSL verification in development environments with self-signed certificates.

```env
# Development only - Never use in production!
FORMSERVICES_MAIN_VERIFY_SSL=false
```

## Quick Start

### Basic Usage

```php
use Jway\FormServicesApiClient\Facades\FormServicesClient;

// Get API instance (uses default client)
$api = FormServicesClient::api();

// Use a specific client
$api = FormServicesClient::api('secondary');

// Force a specific API version
$api = FormServicesClient::api('main', '2023');
```

### Available Resources

```php
$api = FormServicesClient::api();

$api->applications()  // Manage applications
$api->auth()          // Authentication
$api->files()         // Files/datastores (CRUD)
$api->start()         // Create new files
$api->attachments()   // File attachments
$api->documents()     // Generated documents
$api->contents()      // Studio - Content management
$api->projects()      // Studio - Project management
```

## API Reference

### Applications

```php
$apps = $api->applications();

// List all applications
$all = $apps->findAll();

// Find by ID
$app = $apps->find(9);

// Find visible applications
$visible = $apps->findVisible();

// Search by tag
$tagged = $apps->findByTag('category-name');

// Search by name
$byName = $apps->findByName('app-name');

// Get application metadata/datastores
$metadata = $apps->getMetadata(41);
$datastores = $apps->getDatastores(41); // Alias
```

### Files (Datastores)

```php
$files = $api->files();

// Find file by UUID
$file = $files->find('uuid-string');
$file = $files->find('uuid-string', 'access-token'); // With token

// List files with filters
$list = $files->findAll([
    'application.id' => 9,
    'workflowStatus' => 'DONE',
    'first' => 1,
    'max' => 10,
]);

// Managed files (recommended for pagination)
$managed = $files->findManaged([
    'application.id' => 9,
    'workflowStatus' => 'DONE',
    'lastUpdate' => 'm-1,*',  // Last month
    'order' => 'lastUpdate',
    'reverse' => 'true',
]);

// With headers (for pagination info)
$response = $files->findManagedWithHeaders([...]);
// $response['body'] = data
// $response['headers'] = headers (X-Content-Range, etc.)

// Get XML content
$xml = $files->data('uuid-string');

// Update XML content
$files->updateData('uuid-string', '<xml>...</xml>');

// Download archive (data + documents)
$zip = $files->archive('uuid-string');

// Delete file
$files->delete('uuid-string');

// Delete by criteria
$files->deleteByFilter([
    'application.id' => 9,
    'status' => 'ARCHIVED',
]);

// Export to CSV
$csv = $files->export(['application.id' => 9]);

// Statistics
$stats = $files->statistics(['application.id' => 9]);

// Update workflow status
$files->updateWorkflowStatus('uuid-string', 'VALIDATION');

// Validate file
$files->validate('uuid-string');
```

#### Available Filters

| Filter | Type | Description | Example |
|--------|------|-------------|---------|
| `application.id` | integer | Application ID | `9` |
| `workflowStatus` | string | Workflow status | `DONE`, `VALIDATION`, `START` |
| `status` | string | File status | `ARCHIVED`, `!ARCHIVED`, `ERROR` |
| `period` | string | Period (stepDate) | `m-1`, `y-1`, `2024-01-01,2024-12-31` |
| `lastUpdate` | string | Last update date | `m-1,*`, `d-1`, `2024-11-01,*` |
| `order` | string | Sort field | `id`, `lastUpdate`, `stepDate` |
| `reverse` | string | Descending order | `true`, `false` |
| `first` | integer | First record | `1`, `11`, `21` |
| `max` | integer | Max per page (limit: 10) | `1` to `10` |

#### Date Formats

- `y-1` : Last year
- `m-1` : Last month
- `d-1` : Yesterday
- `2024-01-01,2024-12-31` : Specific date range
- `2024-11-01,*` : From a date
- `*,2024-10-31` : Until a date

### Authentication

```php
$auth = $api->auth();

// Current user info
$user = $auth->me();

// Update account
$auth->update([
    'email' => 'new@email.com',
    'firstName' => 'John',
    'lastName' => 'Doe',
]);

// Create account
$auth->createAccount([
    'login' => 'newuser',
    'password' => 'secret',
    'email' => 'user@example.com',
]);

// Logout
$auth->logout();

// Lost password
$auth->lostPassword(['login' => 'username']);

// Reset password
$auth->resetPassword([
    'token' => 'reset-token',
    'password' => 'new-password',
]);
```

### File Creation

```php
$start = $api->start();

// List available applications
$applications = $start->findAll();

// Create new file
$newFile = $start->start(
    'application-name',
    'My file name',
    'en'  // Language: en, fr, nl, de
);

// Create in group
$newFile = $start->startInGroup(
    'application-name',
    'My file name',
    'en',
    'group-uuid'
);
```

### Attachments

```php
$attachments = $api->attachments();

// List attachments
$list = $attachments->findByFile('file-uuid');

// Create attachment
$attachments->create('file-uuid', [
    'name' => 'Important document',
    'files' => [...],
]);

// Delete attachment
$attachments->delete('file-uuid');

// Get specific file
$file = $attachments->findFile('file-uuid', 'attachment-id', 'file-id');

// Delete specific file
$attachments->deleteFile('file-uuid', 'attachment-id', 'file-id');
```

### Documents

```php
$documents = $api->documents();

// Find document
$doc = $documents->find(123);

// List documents
$list = $documents->findAll([
    'file.uuid' => 'file-uuid',
]);
```

### Studio - Contents

```php
$contents = $api->contents();

// List contents by type
$all = $contents->findAll('PROJECT');  // PROJECT, MODULE, FORM, WORKFLOW

// Find content
$content = $contents->find(123);

// Create content
$new = $contents->create([
    'name' => 'My form',
    'type' => 'FORM',
]);

// Update content
$contents->update(123, ['name' => 'New name']);

// Delete content
$contents->delete(123);

// Export to ZIP
$zip = $contents->export(123);

// Duplicate
$duplicate = $contents->duplicate(123, ['name' => 'Copy of form']);

// Prepare and finalize version
$contents->prepare(123);
$contents->finalizeVersion(123, [
    'version' => '1.0.0',
    'comment' => 'Initial release',
]);
```

#### Sub-resources

```php
// Access management
$accesses = $api->contents()->accesses();
$accesses->findAll(123);
$accesses->create(123, ['user' => 'username', 'role' => 'EDITOR']);
$accesses->delete(123, 'access-id');

// File management
$files = $api->contents()->files();
$files->findAll(123);
$files->create(123, ['filename' => 'form.xml', 'file' => $content]);
$files->delete(123, 'file-id');

// Git repositories
$repos = $api->contents()->repositories();
$repos->findAll(123);
$repos->create(123, ['url' => 'https://github.com/user/repo.git']);
$repos->pull(123, 'repo-id');
$repos->push(123, 'repo-id', 'Commit message');

// Translations
$translations = $api->contents()->translations();
$translations->create(123, ['language' => 'fr']);
$translations->updateBatch(123, ['fr' => ['key1' => 'Value 1']]);

// Sub-contents
$subContents = $api->contents()->subContents();
$subContents->create(123, ['contentId' => 456]);
$subContents->delete(123, 'link-id');
```

### Studio - Projects

```php
$projects = $api->projects();

// Prepare for build
$projects->prepareForBuild(123);

// Deploy
$projects->deploy(123);

// Test
$projects->test(123);

// Get build info
$build = $projects->findBuild(123);

// Update build
$projects->updateBuild(123, ['status' => 'SUCCESS']);
```

## Pagination

The API limits results to **10 records per page**. Use pagination for large datasets:

```php
$page = 1;
$pageSize = 10;
$allDatastores = [];

do {
    $response = $api->files()->findManagedWithHeaders([
        'application.id' => 9,
        'workflowStatus' => 'DONE',
        'first' => (($page - 1) * $pageSize) + 1,
        'max' => $pageSize,
    ]);

    $datastores = $response['body'];
    $allDatastores = array_merge($allDatastores, $datastores);

    // Parse X-Content-Range header
    $contentRange = $response['headers']['X-Content-Range'][0] ?? null;
    if ($contentRange && preg_match('/(\d+)-(\d+)\/(\d+)/', $contentRange, $matches)) {
        $rangeEnd = (int)$matches[2];
        $totalCount = (int)$matches[3];

        if ($rangeEnd >= $totalCount) {
            break;
        }
    } else {
        break;
    }

    $page++;

} while (count($datastores) === $pageSize);

echo "Total fetched: " . count($allDatastores);
```

**X-Content-Range format**: `1-10/367` (first 10 of 367 total)

## Error Handling

```php
use GuzzleHttp\Exception\GuzzleException;

try {
    $api = FormServicesClient::api();
    $files = $api->files()->findManaged(['application.id' => 9]);

} catch (GuzzleException $e) {
    // Error is automatically logged to Laravel logs

    $statusCode = $e->getCode();
    $message = $e->getMessage();

    if (method_exists($e, 'getResponse')) {
        $response = $e->getResponse();
        $body = (string) $response->getBody();
        $responseData = json_decode($body, true);
    }

    Log::error('FormServices API Error', [
        'code' => $statusCode,
        'message' => $message,
    ]);
}
```

### Common Error Codes

| Code | Meaning | Solution |
|------|---------|----------|
| 401 | Unauthorized | Check `LOGIN` and `KEY` |
| 403 | Forbidden | Check account permissions |
| 404 | Not found | Verify ID/UUID |
| 500 | Server error | Contact API support |

## Dependency Injection

```php
use Jway\FormServicesApiClient\ClientFactory;
use Jway\FormServicesApiClient\FormServicesClient;

class DatastoreController extends Controller
{
    public function __construct(
        protected ClientFactory $factory,
        protected FormServicesClient $defaultClient
    ) {}

    public function index()
    {
        $api = $this->factory->api();
        $files = $api->files()->findManaged(['application.id' => 9]);

        return view('datastores.index', compact('files'));
    }

    public function secondary()
    {
        $api = $this->factory->api('secondary');
        $files = $api->files()->findAll();

        return view('datastores.index', compact('files'));
    }
}
```

## Low-Level HTTP Client

For direct HTTP access:

```php
use Jway\FormServicesApiClient\Facades\FormServicesClient;

// GET
$data = FormServicesClient::get('rest/endpoint', ['param' => 'value']);

// GET with headers
$response = FormServicesClient::getWithHeaders('rest/endpoint', ['param' => 'value']);

// GET raw (returns raw response, e.g., XML)
$xml = FormServicesClient::getRaw('rest/file/uuid/data');

// POST
$result = FormServicesClient::post('rest/endpoint', ['key' => 'value']);

// PUT
$result = FormServicesClient::put('rest/endpoint/123', ['key' => 'new_value']);

// DELETE
$result = FormServicesClient::delete('rest/endpoint/123');

// Use specific client
$client = FormServicesClient::client('secondary');
$data = $client->get('rest/endpoint');
```

### Client Information

```php
$client = FormServicesClient::client('main');

echo $client->getBaseUrl();  // https://api.example.com/portal
echo $client->getLogin();    // api-user
echo $client->getTimeout();  // 30
```

### Available Clients

```php
// List all configured clients
$clients = FormServicesClient::getAvailableClients();
// ['main', 'secondary']

// Check if client exists
if (FormServicesClient::hasClient('main')) {
    $client = FormServicesClient::client('main');
}
```

## Testing

Run the test suite:

```bash
composer test
```

or

```bash
vendor/bin/phpunit
```

Tests use mocks to avoid real API calls. See the `tests/` directory for examples.

## Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Standards

- PSR-12 for code style
- PHPStan level 5 minimum
- Tests for new features

## License

MIT License - See the [LICENSE](LICENSE) file for details.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history.

## API Documentation

For more information about the FormServices API itself, see:
- OpenAPI specification: `jway-openapi-2023.json`
- Official documentation: Contact your FormServices provider

---

**Developed by Julian Davreux** - Laravel API Client for FormServices
