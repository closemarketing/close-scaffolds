# {{PLUGIN_NAME}} - Lint Configuration

This directory contains linting and static analysis tools configuration for {{PLUGIN_NAME}}.

## 🛠 Tools Included

- **PHPStan** - Static analysis tool for PHP
- **PHP_CodeSniffer (PHPCS)** - Coding standards checker
- **WordPress Coding Standards (WPCS)** - WordPress-specific coding standards
- **PHPCompatibility** - PHP version compatibility checker

## 📦 Installation

Install all dependencies using Composer:

```bash
composer install
```

## 🚀 Usage

### Quick Start

Run all linting tools:

```bash
./lint.sh
# or
composer lint
```

### Individual Tools

Run only PHP_CodeSniffer:

```bash
./lint.sh phpcs
# or
composer phpcs
```

Run only PHPStan:

```bash
./lint.sh phpstan
# or
composer phpstan
```

### Auto-Fix Issues

Automatically fix coding standard violations:

```bash
./lint.sh fix
# or
composer lint:fix
```

## ⚙️ Configuration Files

### phpcs.xml

WordPress Coding Standards configuration. Customize rules in this file:

- **Text Domain**: `{{TEXT_DOMAIN}}`
- **Prefix**: `{{PREFIX}}` / `{{PREFIX_UPPER}}`
- **PHP Version**: 7.4+
- **WordPress Version**: 6.0+

### phpstan.neon

PHPStan configuration with WordPress extensions:

- **Level**: 6 (can be increased to 9 for stricter analysis)
- **Memory Limit**: 2GB
- **WordPress Stubs**: Included via szepeviktor/phpstan-wordpress

### phpstan-bootstrap.php

Bootstrap file for PHPStan that defines WordPress and plugin constants.

## 📋 Composer Scripts

Available composer commands:

```bash
composer phpstan      # Run PHPStan static analysis
composer phpcs        # Run PHP_CodeSniffer
composer phpcbf       # Run PHP Code Beautifier and Fixer
composer lint         # Run all linting tools
composer lint:fix     # Auto-fix coding standards
```

## 🎯 What Gets Checked

### PHP_CodeSniffer (PHPCS)

- WordPress Coding Standards compliance
- Security best practices (nonces, escaping, sanitization)
- Proper text domain usage
- Function/variable naming conventions with prefix
- Yoda conditions enforcement
- PHP 7.4+ compatibility

### PHPStan

- Type safety and compatibility
- Undefined variables and functions
- Dead code detection
- WordPress function compatibility
- Logical errors

## 🚫 Excluded Paths

The following paths are excluded from linting:

- `vendor/` - Composer dependencies
- `node_modules/` - NPM dependencies
- `includes/theme/patterns/` - Block patterns
- `includes/blocks/*/build/` - Built block assets
- `*.min.js` - Minified JavaScript
- `*.asset.php` - WordPress asset files

## 📝 Integration with CI/CD

Add to your CI/CD pipeline:

```yaml
# GitHub Actions example
- name: Install dependencies
  run: composer install --no-dev

- name: Run linting
  run: composer lint
```

## 🔧 Customization

### Adjust PHPStan Level

In `phpstan.neon`, change the level (0-9):

```yaml
parameters:
    level: 8  # More strict
```

### Add Custom PHPCS Rules

In `phpcs.xml`, add or exclude rules:

```xml
<rule ref="WordPress">
    <exclude name="WordPress.Files.FileName"/>
</rule>
```

### Ignore Specific Errors

In `phpstan.neon`, add to ignoreErrors:

```yaml
ignoreErrors:
    - '#Your error pattern here#'
```

## 📚 Resources

- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- [PHP_CodeSniffer Wiki](https://github.com/squizlabs/PHP_CodeSniffer/wiki)

## 🐛 Troubleshooting

### Memory Limit Issues

If PHPStan runs out of memory, increase the limit in `phpstan.neon`:

```yaml
parameters:
    memoryLimit: 4G
```

### WPCS Not Found

If WordPress Coding Standards are not detected:

```bash
composer global require squizlabs/php_codesniffer
composer install
```

### Permission Denied on lint.sh

Make the script executable:

```bash
chmod +x lint.sh
```

---

**Author**: {{PLUGIN_AUTHOR}}  
**Version**: {{VERSION}}  
**License**: GPL-2.0+

