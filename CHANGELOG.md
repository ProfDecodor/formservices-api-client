# Changelog

All notable changes to `profdecodor/formservices-api-client` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2024-01-19

### Added
- Initial public release
- Support for Laravel 11.x and 12.x
- Multi-client configuration support
- API versioning system (v2023)
- Complete HTTP client with GET, POST, PUT, DELETE methods
- Service Provider with Laravel auto-discovery
- Facade for easy access (`FormServicesClient`)
- Full test suite with PHPUnit

### API Resources
- **ApplicationResource** - Application management (findAll, find, findVisible, findByTag, getMetadata)
- **AuthenticationResource** - User authentication (me, update, createAccount, logout, password reset)
- **FileResource** - File/datastore management (CRUD, archive, export, statistics, workflow)
- **FileCreationResource** - Create new files (start, startInGroup)
- **AttachmentResource** - Attachment management (CRUD)
- **DocumentResource** - Document management (find, findAll)
- **ContentResource** - Studio content management (CRUD, import/export, versioning)
- **ContentAccessResource** - Access control for contents
- **ContentFileResource** - File management for contents
- **ContentRepositoryResource** - Git repository integration (pull, push, diff)
- **ContentTranslationResource** - Translation management
- **ContentSubContentResource** - Sub-content management
- **ProjectResource** - Studio project management (build, deploy, test)

### Features
- Automatic pagination handling with X-Content-Range header support
- Advanced filtering (application.id, workflowStatus, status, period, lastUpdate)
- SSL verification toggle for development environments
- Automatic error logging via Laravel Log facade
- Dependency injection support via ClientFactory
- Raw response support for XML/binary content

---

[Unreleased]: https://github.com/profdecodor/formservices-api-client/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/profdecodor/formservices-api-client/releases/tag/v1.0.0