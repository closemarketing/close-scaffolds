# 🔧 Añadiendo Nuevos Scaffolds

Este documento explica cómo añadir nuevos tipos de scaffolds al repositorio.

## Estructura de Scaffolds

El repositorio está diseñado para soportar múltiples scaffolds. Actualmente tenemos:

```
templates/
├── pluginwp/       # Scaffold para plugins de WordPress
│   ├── plugin.php
│   ├── readme.txt
│   └── includes/
│       ├── custom-login/
│       ├── post-types/
│       ├── theme/
│       ├── blocks/
│       ├── shortcodes/
│       └── woocommerce/
└── [future-scaffold]/  # Aquí irán otros scaffolds
```

## Variables de Plantilla Disponibles

Todos los archivos en `templates/` pueden usar estas variables que serán reemplazadas automáticamente:

| Variable | Descripción | Ejemplo |
|----------|-------------|---------|
| `{{PLUGIN_NAME}}` | Nombre del plugin/proyecto | "Mi Super Plugin" |
| `{{PLUGIN_DESCRIPTION}}` | Descripción | "Plugin para gestión" |
| `{{PLUGIN_AUTHOR}}` | Autor | "David Perez" |
| `{{PLUGIN_SLUG}}` | Slug (minúsculas con guiones) | "mi-super-plugin" |
| `{{PREFIX}}` | Prefijo para funciones | "msp" |
| `{{CONSTANT_NAME}}` | Nombre de constantes | "MI_SUPER_PLUGIN" |
| `{{CLASS_NAME}}` | Nombre de clases | "MiSuperPlugin" |
| `{{TEXT_DOMAIN}}` | Dominio de texto | "misuperplugin" |
| `{{VERSION}}` | Versión | "1.0.0" |
| `{{CURRENT_YEAR}}` | Año actual | "2025" |

## Cómo Añadir un Nuevo Scaffold

### 1. Crear la Estructura de Carpetas

```bash
cd templates/
mkdir nuevo-scaffold
cd nuevo-scaffold/
```

### 2. Añadir Archivos con Variables

Crea tus archivos de plantilla usando las variables `{{VARIABLE}}`:

**Ejemplo: `index.php`**
```php
<?php
/**
 * {{PLUGIN_NAME}}
 * 
 * @author {{PLUGIN_AUTHOR}}
 * @version {{VERSION}}
 */

define( '{{CONSTANT_NAME}}_VERSION', '{{VERSION}}' );

function {{PREFIX}}_init() {
    // Tu código aquí
}
```

**Ejemplo: `config.json`**
```json
{
  "name": "{{PLUGIN_NAME}}",
  "slug": "{{PLUGIN_SLUG}}",
  "version": "{{VERSION}}",
  "author": "{{PLUGIN_AUTHOR}}"
}
```

**Ejemplo: `README.md`**
```markdown
# {{PLUGIN_NAME}}

{{PLUGIN_DESCRIPTION}}

Author: {{PLUGIN_AUTHOR}}
```

### 3. Crear un CLI Específico (Opcional)

Si tu scaffold necesita opciones específicas, puedes crear un CLI dedicado:

```bash
cd bin/
cp cli.js cli-nuevo-scaffold.js
```

Edita `cli-nuevo-scaffold.js`:
```javascript
const ScaffoldGenerator = require('../lib/generator-nuevo-scaffold');

// Personaliza prompts y opciones específicas
```

### 4. Crear un Generador Específico (Opcional)

Si necesitas lógica personalizada:

```bash
cd lib/
cp generator.js generator-nuevo-scaffold.js
```

Edita y personaliza según necesites.

### 5. Actualizar package.json

Si añadiste un nuevo CLI, añádelo a `bin`:

```json
{
  "bin": {
    "close-scaffold": "./bin/cli.js",
    "wp-scaffold": "./bin/cli.js",
    "nuevo-scaffold": "./bin/cli-nuevo-scaffold.js"
  }
}
```

## Ejemplos de Scaffolds Futuros

### Scaffold para Temas de WordPress

```
templates/
└── themewp/
    ├── style.css (con {{PLUGIN_NAME}}, {{VERSION}}, etc.)
    ├── functions.php (con {{PREFIX}}_)
    ├── index.php
    ├── header.php
    ├── footer.php
    └── template-parts/
```

### Scaffold para Bloques de Gutenberg

```
templates/
└── gutenberg-block/
    ├── block.json (con {{PLUGIN_NAME}})
    ├── src/
    │   ├── index.js
    │   ├── edit.js
    │   └── style.scss
    └── {{PREFIX}}-block.php
```

### Scaffold para React App

```
templates/
└── react-app/
    ├── package.json (con {{PLUGIN_NAME}})
    ├── src/
    │   ├── App.js
    │   └── index.js
    └── public/
```

## Tips y Buenas Prácticas

### 1. Usa Variables en TODOS los Lugares

❌ **Incorrecto:**
```php
define( 'MY_PLUGIN_VERSION', '1.0.0' );
function my_plugin_init() {}
```

✅ **Correcto:**
```php
define( '{{CONSTANT_NAME}}_VERSION', '{{VERSION}}' );
function {{PREFIX}}_init() {}
```

### 2. Mantén la Consistencia

- Usa el mismo formato de variables: `{{VARIABLE}}`
- No uses otros delimitadores como `%VARIABLE%` o `${VARIABLE}`
- Las variables son case-sensitive

### 3. Archivos Binarios

Los archivos binarios (imágenes, fuentes, etc.) se copian sin procesamiento:
- `.svg`, `.png`, `.jpg`, `.jpeg`, `.gif`, `.ico`
- `.woff`, `.woff2`, `.ttf`, `.eot`

### 4. Documenta tu Scaffold

Crea un README específico en tu carpeta de scaffold:

```
templates/nuevo-scaffold/README.md
```

### 5. Añade Ejemplos

Incluye un directorio de ejemplos:

```
templates/nuevo-scaffold/examples/
├── basic/
└── advanced/
```

## Testear tu Scaffold

Después de crear tu scaffold:

```bash
# 1. Instala dependencias
npm install

# 2. Prueba localmente
node bin/cli.js create

# 3. Verifica los reemplazos
cd /tmp/test-plugin
grep -r "{{" .  # No debería encontrar variables sin reemplazar
```

## Variables Personalizadas

Si necesitas añadir nuevas variables, edita `lib/generator.js`:

```javascript
prepareTemplateData(options) {
  // ... código existente ...
  
  return {
    // ... variables existentes ...
    
    // Nuevas variables
    MY_CUSTOM_VAR: 'valor',
    ANOTHER_VAR: options.customField || 'default'
  };
}
```

## Contribuir

1. Crea tu scaffold en `templates/nuevo-scaffold/`
2. Prueba que funcione correctamente
3. Documenta las características específicas
4. Actualiza este archivo con tu scaffold
5. Haz commit y push

---

¿Preguntas? Contacta al equipo de desarrollo de Close Marketing.
