# 🚀 Close Plugin Scaffold

CLI tool for generating WordPress plugins based on Close Marketing's boilerplate. Save time and maintain consistency across all your projects.

## ✨ Features

- 🎯 **Fast generation**: Create a complete plugin in seconds
- 🔧 **Customizable**: Choose only the features you need
- 📝 **Dynamic variables**: Automatically replace names, prefixes and constants
- 🎨 **Interactive**: Prompt mode or command line
- ♻️ **Reusable**: Based on Close Marketing's proven boilerplate

## 📦 Installation

### Option 1: Global installation from npm (Recommended)

```bash
npm install -g @closetechnology/scaffolds
```

Now you can use `close-scaffold` or `wp-scaffold` from any directory.

### Option 2: Installation from repository

```bash
git clone https://github.com/closemarketing/close-scaffolds.git
cd close-scaffolds
npm install
npm link
```

### Option 3: Local use without global installation

```bash
git clone https://github.com/closemarketing/close-scaffolds.git
cd close-scaffolds
npm install
npm start
```

## 🎮 Usage

### View Available Scaffolds

```bash
close-scaffold list
```

Shows all available scaffolds:
- `pluginwp` - WordPress Plugin
- `lint` - PHPStan and WordPress Coding Standards
- `block` - Gutenberg Block (coming soon)

### Interactive Mode (Recommended)

Interactive mode guides you step by step:

```bash
close-scaffold create pluginwp
# or from the repository
npm start
```

**Example interactive session:**
```
? Plugin name: My Super Plugin
? Plugin description: Plugin for content management
? Author: Your Name
? Plugin prefix (for functions): msp
? Output directory: ./
? Select features to include: 
  ◉ Custom Post Types
  ◉ Custom Login
  ◉ Theme Integration
  ◯ WooCommerce Integration
  ◯ Blocks
  ◯ Shortcodes
```

### Options Mode (Automated)

For scripts or automation:

```bash
close-scaffold create pluginwp \
  --name "My Plugin" \
  --prefix "mp" \
  --description "Plugin description" \
  --author "Your Name" \
  --output "./"
```

## Available Options

- `--name, -n`: Plugin name
- `--prefix, -p`: Function prefix (lowercase letters and underscores only)
- `--description, -d`: Plugin description
- `--author, -a`: Plugin author
- `--output, -o`: Output directory (default: `./`)

## Included Features

The scaffold generates plugins with the following features:

### ✅ Always Included
- Basic plugin structure
- Constants and prefixes system
- Internationalization (i18n)
- Custom login
- Custom Post Types (Testimonials and Companies)
- Theme integration

### 🔧 Optional
- Gutenberg blocks
- Shortcodes
- WooCommerce integration

## Generated Structure

```
my-plugin/
├── plugin.php
├── readme.txt
└── includes/
    ├── custom-login/
    │   ├── class-ccaa-admin.php
    │   ├── logo-login.svg
    │   └── logo-mini.svg
    ├── post-types/
    │   ├── cpt-testimonials.php
    │   └── cpt-companies.php
    ├── theme/
    │   ├── functions.php
    │   ├── style.css
    │   ├── style-editor.css
    │   └── assets/
    ├── blocks/ (optional)
    ├── shortcodes/ (optional)
    └── woocommerce/ (optional)
```

## Template Variables

The scaffold automatically replaces the following variables:

- `{{PLUGIN_NAME}}`: Plugin name
- `{{PLUGIN_DESCRIPTION}}`: Plugin description
- `{{PLUGIN_AUTHOR}}`: Plugin author
- `{{PLUGIN_SLUG}}`: Plugin slug (lowercase name with hyphens)
- `{{PREFIX}}`: Function prefix (lowercase: `msp_`)
- `{{PREFIX_UPPER}}`: Constants prefix (uppercase: `MSP_`)
- `{{CONSTANT_NAME}}`: Full plugin name in uppercase (`MY_SUPER_PLUGIN_`)
- `{{CLASS_NAME}}`: Class names
- `{{TEXT_DOMAIN}}`: Text domain for i18n
- `{{VERSION}}`: Plugin version
- `{{CURRENT_YEAR}}`: Current year

## Usage Example

```bash
# Generate plugin interactively
npm start

# Prompt responses:
# Plugin name: My Super Plugin
# Plugin description: Plugin for content management
# Author: My Name
# Plugin prefix: msp
# Output directory: ./
# Features: [✓] Custom Post Types [✓] Custom Login [✓] Theme Integration

# Result: ./my-super-plugin/
```

## 🔍 Linting Scaffold

The `lint` scaffold provides PHPStan and WordPress Coding Standards configuration for your plugin:

```bash
# Copy lint configuration to your plugin
cd wp-content/plugins/my-plugin
cp -r ../close-scaffolds/templates/lint/* .

# Install dependencies
composer install

# Run linting
./lint.sh

# Auto-fix errors
./lint.sh fix
```

**Includes:**
- ✅ PHPStan with WordPress extensions
- ✅ PHP_CodeSniffer with WordPress Coding Standards
- ✅ PHPCompatibility to check PHP compatibility
- ✅ Automated linting scripts
- ✅ Pre-configured and customizable setup

See [templates/lint/README.md](templates/lint/README.md) for more details.

## 📚 Additional Documentation

- [EXAMPLES.md](EXAMPLES.md) - Detailed usage examples
- [ADDING_SCAFFOLDS.md](ADDING_SCAFFOLDS.md) - How to add new scaffolds
- [templates/lint/USAGE.md](templates/lint/USAGE.md) - Lint scaffold usage guide
- See the boilerplate source code in `../`

## 🎯 Advantages over other methods

### vs. Manual Copy and Paste
- ❌ Manual: Copy folders, search/replace in multiple files, error-prone
- ✅ Scaffold: One command, everything automated, error-free

### vs. WP-CLI scaffold
- ❌ WP-CLI: Generic structure, no Close Marketing customization
- ✅ Scaffold: Proven structure, includes custom login, post types, theme

### vs. NPX create-*
- ❌ NPX: Requires publishing to npm, more complex to maintain
- ✅ Scaffold: Local, easy to modify, full control

## 🔧 Development and Customization

### Modify templates

Templates are located in `templates/`:
```
templates/
├── plugin.php      # Main file template
└── readme.txt      # Readme template
```

**Available variables in templates:**
- `{{PLUGIN_NAME}}` - Plugin name
- `{{PLUGIN_DESCRIPTION}}` - Description
- `{{PLUGIN_AUTHOR}}` - Author
- `{{PREFIX}}` - Function prefix
- `{{CONSTANT_NAME}}` - Constants name
- `{{TEXT_DOMAIN}}` - Text domain
- `{{VERSION}}` - Version
- `{{CURRENT_YEAR}}` - Current year

### Modify generator logic

Edit `lib/generator.js` to:
- Change how files are processed
- Add new features
- Modify variable replacement system

### Add new features

1. Edit `bin/cli.js` and add the option in the prompt:
```javascript
{
  name: 'My New Feature',
  value: 'my-feature',
  checked: false
}
```

2. Edit `lib/generator.js` and add the copy logic:
```javascript
if (features.includes('my-feature')) {
  await this.copyDirectory(
    path.join(this.sourceDir, 'includes/my-feature'),
    path.join(includesDir, 'my-feature'),
    templateData
  );
}
```

## 🐛 Troubleshooting

### Error: "Directory already exists"
```bash
rm -rf plugin-name
npm start
```

### Permission error
```bash
chmod 755 /destination/directory
```

### Outdated dependencies
```bash
rm -rf node_modules package-lock.json
npm install
```

### CLI won't execute
```bash
chmod +x bin/cli.js
```

## 🤝 Contributing

This scaffold is for Close Marketing's internal use, but you can:

1. Create issues to report bugs
2. Propose improvements to the structure
3. Suggest new features

## 📝 Changelog

### v1.0.0 (2025-10-07)
- ✨ First version of the scaffold
- 🎯 Interactive mode with prompts
- 📝 Template system with dynamic variables
- 🔧 Optional feature selection
- 📦 Complete plugin generation

## 📄 License

GPL-2.0+ - Same license as WordPress

---

**Developed by [Close Marketing](https://close.marketing)** 🚀

