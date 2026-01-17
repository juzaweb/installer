# Contributing to Juzaweb CMS Installer

Thank you for considering contributing to the Juzaweb CMS Installer package!

## Development Setup

1. Clone the repository:
```bash
git clone https://github.com/juzaweb/installer.git
cd installer
```

2. Install dependencies:
```bash
composer install
```

3. Run tests to ensure everything is working:
```bash
composer test
```

## Development Workflow

### Making Changes

1. Create a new branch for your feature or bugfix:
```bash
git checkout -b feature/your-feature-name
```

2. Make your changes following the coding standards below

3. Write tests for your changes

4. Run the test suite:
```bash
composer test
```

5. Format your code:
```bash
composer format
```

6. Commit your changes with a descriptive message:
```bash
git commit -m "Add feature: your feature description"
```

7. Push to your fork and submit a pull request

## Coding Standards

This package follows PSR-2 coding standards and uses Laravel conventions.

### Code Style

- Use Laravel Pint for code formatting
- Run `composer format` before committing
- Follow PSR-2 coding standards
- Use type hints for method parameters and return types
- Write descriptive variable and method names

### Testing

- Write tests for all new features
- Ensure all tests pass before submitting a pull request
- Aim for high test coverage
- Use descriptive test method names

### Documentation

- Update README.md if you change functionality
- Add PHPDoc blocks for all methods
- Include code examples for new features
- Keep documentation clear and concise

## Pull Request Guidelines

1. **One feature per PR**: Keep pull requests focused on a single feature or bugfix

2. **Update tests**: Include tests for any new functionality

3. **Update documentation**: Update README.md and other docs as needed

4. **Follow conventions**: Match the existing code style and patterns

5. **Descriptive commits**: Write clear commit messages explaining what and why

6. **Pass CI**: Ensure all GitHub Actions checks pass

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run specific test file
vendor/bin/phpunit tests/Feature/InstallerRoutesTest.php

# Run with coverage
composer test-coverage
```

### Writing Tests

Tests are located in the `tests/` directory:
- `tests/Feature/` - Feature tests (testing routes, controllers, etc.)
- `tests/Unit/` - Unit tests (testing individual methods, helpers, etc.)

Example test:

```php
<?php

namespace Juzaweb\Installer\Tests\Feature;

use Juzaweb\Installer\Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_does_something(): void
    {
        $response = $this->get('/some-route');

        $response->assertStatus(200);
    }
}
```

## Reporting Issues

When reporting issues, please include:

1. **Description**: Clear description of the issue
2. **Steps to reproduce**: Detailed steps to reproduce the problem
3. **Expected behavior**: What you expected to happen
4. **Actual behavior**: What actually happened
5. **Environment**: PHP version, Laravel version, OS, etc.
6. **Screenshots**: If applicable

## Code of Conduct

- Be respectful and inclusive
- Welcome newcomers and help them learn
- Focus on constructive feedback
- Assume good intentions

## Questions?

If you have questions about contributing, feel free to:
- Open an issue for discussion
- Check existing issues and pull requests
- Visit our documentation at https://docs.juzaweb.com

Thank you for contributing! 🎉
