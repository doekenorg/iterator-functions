# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Added all `_(u)diff_`, `_(u)assoc` and `_(u)intersect` methods as iterator functions.
- PSR-12 code style (with php-cs-fixer workflow)

### Fixed
- `iterator_column()` no longer returns empty values to mirror `array_column()` better.

## [1.0.0] - 2021-08-11
### Added
- Initial release

[Unreleased]: https://github.com/doekenorg/iterator-functions/compare/1.0.0...HEAD
[1.0.0]: https://github.com/doekenorg/iterator-functions/releases/tag/1.0.0
