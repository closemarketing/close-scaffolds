# Cómo Usar el Scaffold de Lint

Este scaffold proporciona herramientas de linting y análisis estático para plugins de WordPress.

## 🎯 Propósito

El scaffold `lint` instala y configura:

- **PHPStan**: Análisis estático de código PHP
- **PHP_CodeSniffer**: Verificación de estándares de código
- **WordPress Coding Standards**: Estándares específicos de WordPress
- **PHPCompatibility**: Verificación de compatibilidad de versiones PHP

## 📦 Instalación

### Opción 1: En un Plugin Nuevo

```bash
# Navega al directorio de plugins
cd wp-content/plugins/

# Crea un nuevo plugin con el scaffold
npx @closetechnology/scaffolds create pluginwp
# Sigue las instrucciones interactivas

# Copia la configuración de lint al plugin
cp -r close-scaffolds/templates/lint/* mi-nuevo-plugin/
cd mi-nuevo-plugin/

# Instala las dependencias
composer install
```

### Opción 2: En un Plugin Existente

```bash
# Navega a tu plugin existente
cd wp-content/plugins/mi-plugin/

# Copia los archivos de lint
cp -r ../close-scaffolds/templates/lint/* .

# Instala las dependencias
composer install
```

### Opción 3: Integración Manual

Copia cada archivo individualmente y ajusta las variables según tu plugin:

1. **composer.json** - Reemplaza `{{PLUGIN_SLUG}}`, `{{PLUGIN_NAME}}`, `{{PLUGIN_AUTHOR}}`
2. **phpcs.xml** - Actualiza `{{TEXT_DOMAIN}}`, `{{PREFIX}}`, `{{PREFIX_UPPER}}`
3. **phpstan-bootstrap.php** - Define las constantes correctas
4. **phpstan.neon** - Ajusta los paths según tu estructura
5. **lint.sh** - Actualiza el header con la info del plugin

## 🚀 Comandos Disponibles

### Ejecutar todos los linters

```bash
./lint.sh
# o
composer lint
```

### Ejecutar solo PHPCS

```bash
./lint.sh phpcs
# o
composer phpcs
```

### Ejecutar solo PHPStan

```bash
./lint.sh phpstan
# o
composer phpstan
```

### Auto-corregir problemas

```bash
./lint.sh fix
# o
composer lint:fix
```

## 🔧 Personalización

### Cambiar nivel de PHPStan

Edita `phpstan.neon`:

```yaml
parameters:
    level: 8  # 0 (menos estricto) a 9 (más estricto)
```

### Ajustar reglas de PHPCS

Edita `phpcs.xml` para incluir o excluir reglas:

```xml
<!-- Excluir una regla específica -->
<rule ref="WordPress">
    <exclude name="WordPress.Files.FileName"/>
</rule>

<!-- Incluir solo ciertas reglas -->
<rule ref="WordPress.Security"/>
<rule ref="WordPress.WP.I18n"/>
```

### Ignorar archivos/directorios

En `phpcs.xml`:

```xml
<exclude-pattern>*/mi-directorio/*</exclude-pattern>
```

En `phpstan.neon`:

```yaml
parameters:
    excludePaths:
        - mi-directorio
```

## 📋 Variables de Template

Al usar el scaffold, estas variables serán reemplazadas automáticamente:

| Variable | Descripción | Ejemplo |
|----------|-------------|---------|
| `{{PLUGIN_NAME}}` | Nombre del plugin | "Mi Plugin Genial" |
| `{{PLUGIN_SLUG}}` | Slug del plugin | "mi-plugin-genial" |
| `{{PLUGIN_AUTHOR}}` | Autor | "David Perez" |
| `{{PREFIX}}` | Prefijo en minúsculas | "mpg" |
| `{{PREFIX_UPPER}}` | Prefijo en mayúsculas | "MPG" |
| `{{TEXT_DOMAIN}}` | Dominio de texto | "miplugingenial" |
| `{{VERSION}}` | Versión | "1.0.0" |
| `{{CURRENT_YEAR}}` | Año actual | "2025" |

## 🔄 Integración con Git Hooks

### Pre-commit Hook

Crea `.git/hooks/pre-commit`:

```bash
#!/bin/bash
composer lint
if [ $? -ne 0 ]; then
    echo "Linting failed. Please fix the errors before committing."
    exit 1
fi
```

```bash
chmod +x .git/hooks/pre-commit
```

### Pre-push Hook

Crea `.git/hooks/pre-push`:

```bash
#!/bin/bash
composer phpstan
if [ $? -ne 0 ]; then
    echo "PHPStan failed. Please fix the errors before pushing."
    exit 1
fi
```

```bash
chmod +x .git/hooks/pre-push
```

## 🎯 Integración con CI/CD

### GitHub Actions

Crea `.github/workflows/lint.yml`:

```yaml
name: Lint

on:
  pull_request:
  push:
    branches: [main, develop]

jobs:
  lint:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          
      - name: Install dependencies
        run: composer install --no-dev --no-interaction
        
      - name: Run PHPCS
        run: composer phpcs
        
      - name: Run PHPStan
        run: composer phpstan
```

### GitLab CI

Crea `.gitlab-ci.yml`:

```yaml
lint:
  image: php:8.1
  before_script:
    - composer install --no-dev --no-interaction
  script:
    - composer lint
  only:
    - merge_requests
    - main
```

## 📊 Interpretando Resultados

### PHPCS Output

```
FILE: /path/to/file.php
--------------------------------------------------------------------------------
FOUND 2 ERRORS AFFECTING 2 LINES
--------------------------------------------------------------------------------
 10 | ERROR | Function name must use snake case (WordPress.NamingConventions)
 15 | ERROR | All output should be escaped (WordPress.Security.EscapeOutput)
--------------------------------------------------------------------------------
```

**Solución**: Ejecuta `composer lint:fix` para auto-corregir, o corrige manualmente.

### PHPStan Output

```
------ -------------------------------------------------------
 Line   Error
------ -------------------------------------------------------
 25     Call to an undefined function get_custom_field()
 30     Variable $post might not be defined
------ -------------------------------------------------------
```

**Solución**: Corrige los errores manualmente o añade a ignoreErrors si es un falso positivo.

## 🐛 Solución de Problemas

### "vendor directory not found"

```bash
composer install
```

### "Memory limit exceeded" en PHPStan

Edita `phpstan.neon`:

```yaml
parameters:
    memoryLimit: 4G
```

### WPCS no detectado

```bash
composer config allow-plugins.dealerdirect/phpcodesniffer-composer-installer true
composer update
```

### Permisos denegados en lint.sh

```bash
chmod +x lint.sh
```

## 📚 Recursos

- [PHPStan Docs](https://phpstan.org/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- [Close Scaffolds](https://github.com/closemarketing/close-scaffolds)

---

**¿Necesitas ayuda?** Contacta al equipo de Closemarketing.

