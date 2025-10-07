# 🚀 Close Plugin Scaffold

Herramienta CLI para generar plugins de WordPress basados en el boilerplate de Close Marketing. Ahorra tiempo y mantén la consistencia en todos tus proyectos.

## ✨ Características

- 🎯 **Generación rápida**: Crea un plugin completo en segundos
- 🔧 **Personalizable**: Elige solo las características que necesitas
- 📝 **Variables dinámicas**: Reemplaza automáticamente nombres, prefijos y constantes
- 🎨 **Interactivo**: Modo con prompts o línea de comandos
- ♻️ **Reutilizable**: Basado en el boilerplate probado de Close Marketing

## 📦 Instalación

### Opción 1: Instalación global desde npm (Recomendado)

```bash
npm install -g @closetechnology/scaffolds
```

Ahora puedes usar `close-scaffold` o `wp-scaffold` desde cualquier directorio.

### Opción 2: Instalación desde el repositorio

```bash
git clone https://github.com/closemarketing/close-scaffolds.git
cd close-scaffolds
npm install
npm link
```

### Opción 3: Uso local sin instalación global

```bash
git clone https://github.com/closemarketing/close-scaffolds.git
cd close-scaffolds
npm install
npm start
```

## 🎮 Uso

### Ver Scaffolds Disponibles

```bash
close-scaffold list
```

Muestra todos los scaffolds disponibles:
- `pluginwp` - WordPress Plugin
- `block` - Gutenberg Block (próximamente)

### Modo Interactivo (Recomendado)

El modo interactivo te guía paso a paso:

```bash
close-scaffold create pluginwp
# o desde el repositorio
npm start
```

**Ejemplo de sesión interactiva:**
```
? Plugin name: Mi Super Plugin
? Plugin description: Plugin para gestión de contenido
? Author: Tu Nombre
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

### Modo con Opciones (Automatizado)

Para scripts o automatización:

```bash
close-scaffold create pluginwp \
  --name "Mi Plugin" \
  --prefix "mp" \
  --description "Descripción del plugin" \
  --author "Tu Nombre" \
  --output "./"
```

## Opciones Disponibles

- `--name, -n`: Nombre del plugin
- `--prefix, -p`: Prefijo para funciones (solo letras minúsculas y guiones bajos)
- `--description, -d`: Descripción del plugin
- `--author, -a`: Autor del plugin
- `--output, -o`: Directorio de salida (por defecto: `./`)

## Características Incluidas

El scaffold genera plugins con las siguientes características:

### ✅ Siempre Incluidas
- Estructura básica del plugin
- Sistema de constantes y prefijos
- Internacionalización (i18n)
- Custom Login personalizado
- Custom Post Types (Testimonios y Empresas)
- Integración con tema

### 🔧 Opcionales
- Bloques de Gutenberg
- Shortcodes
- Integración con WooCommerce

## Estructura Generada

```
mi-plugin/
├── plugin.php
├── readme.txt
└── includes/
    ├── custom-login/
    │   ├── class-ccaa-admin.php
    │   ├── logo-login.svg
    │   └── logo-mini.svg
    ├── post-types/
    │   ├── cpt-testimonios.php
    │   └── cpt-empresas.php
    ├── theme/
    │   ├── functions.php
    │   ├── style.css
    │   ├── style-editor.css
    │   └── assets/
    ├── blocks/ (opcional)
    ├── shortcodes/ (opcional)
    └── woocommerce/ (opcional)
```

## Variables de Plantilla

El scaffold reemplaza automáticamente las siguientes variables:

- `{{PLUGIN_NAME}}`: Nombre del plugin
- `{{PLUGIN_DESCRIPTION}}`: Descripción del plugin
- `{{PLUGIN_AUTHOR}}`: Autor del plugin
- `{{PLUGIN_SLUG}}`: Slug del plugin (nombre en minúsculas con guiones)
- `{{PREFIX}}`: Prefijo para funciones (minúsculas: `msp_`)
- `{{PREFIX_UPPER}}`: Prefijo para constantes (mayúsculas: `MSP_`)
- `{{CONSTANT_NAME}}`: Nombre completo del plugin en mayúsculas (`MI_SUPER_PLUGIN_`)
- `{{CLASS_NAME}}`: Nombre de clases
- `{{TEXT_DOMAIN}}`: Dominio de texto para i18n
- `{{VERSION}}`: Versión del plugin
- `{{CURRENT_YEAR}}`: Año actual

## Ejemplo de Uso

```bash
# Generar plugin interactivamente
npm start

# Respuestas del prompt:
# Plugin name: Mi Super Plugin
# Plugin description: Plugin para gestión de contenido
# Author: Mi Nombre
# Plugin prefix: msp
# Output directory: ./
# Features: [✓] Custom Post Types [✓] Custom Login [✓] Theme Integration

# Resultado: ./mi-super-plugin/
```

## 📚 Documentación Adicional

- [EXAMPLES.md](EXAMPLES.md) - Ejemplos de uso detallados
- Ver el código fuente del boilerplate en `../`

## 🎯 Ventajas sobre otros métodos

### vs. Copiar y Pegar manualmente
- ❌ Manual: Copiar carpetas, buscar/reemplazar en múltiples archivos, propenso a errores
- ✅ Scaffold: Un comando, todo automatizado, sin errores

### vs. WP-CLI scaffold
- ❌ WP-CLI: Estructura genérica, sin personalización de Close Marketing
- ✅ Scaffold: Estructura probada, incluye login customizado, post types, tema

### vs. NPX create-*
- ❌ NPX: Requiere publicar en npm, más complejo de mantener
- ✅ Scaffold: Local, fácil de modificar, control total

## 🔧 Desarrollo y Personalización

### Modificar plantillas

Las plantillas están en `templates/`:
```
templates/
├── plugin.php      # Plantilla del archivo principal
└── readme.txt      # Plantilla del readme
```

**Variables disponibles en plantillas:**
- `{{PLUGIN_NAME}}` - Nombre del plugin
- `{{PLUGIN_DESCRIPTION}}` - Descripción
- `{{PLUGIN_AUTHOR}}` - Autor
- `{{PREFIX}}` - Prefijo de funciones
- `{{CONSTANT_NAME}}` - Nombre de constantes
- `{{TEXT_DOMAIN}}` - Dominio de texto
- `{{VERSION}}` - Versión
- `{{CURRENT_YEAR}}` - Año actual

### Modificar la lógica del generador

Edita `lib/generator.js` para:
- Cambiar cómo se procesan los archivos
- Añadir nuevas características
- Modificar el sistema de reemplazo de variables

### Añadir nuevas características

1. Edita `bin/cli.js` y añade la opción en el prompt:
```javascript
{
  name: 'Mi Nueva Feature',
  value: 'mi-feature',
  checked: false
}
```

2. Edita `lib/generator.js` y añade la lógica de copia:
```javascript
if (features.includes('mi-feature')) {
  await this.copyDirectory(
    path.join(this.sourceDir, 'includes/mi-feature'),
    path.join(includesDir, 'mi-feature'),
    templateData
  );
}
```

## 🐛 Troubleshooting

### Error: "Directory already exists"
```bash
rm -rf nombre-del-plugin
npm start
```

### Error de permisos
```bash
chmod 755 /directorio/destino
```

### Dependencias desactualizadas
```bash
rm -rf node_modules package-lock.json
npm install
```

### El CLI no se ejecuta
```bash
chmod +x bin/cli.js
```

## 🤝 Contribuir

Este scaffold es para uso interno de Close Marketing, pero puedes:

1. Crear issues para reportar bugs
2. Proponer mejoras en la estructura
3. Sugerir nuevas características

## 📝 Changelog

### v1.0.0 (2025-10-07)
- ✨ Primera versión del scaffold
- 🎯 Modo interactivo con prompts
- 📝 Sistema de plantillas con variables dinámicas
- 🔧 Selección de características opcional
- 📦 Generación completa de plugins

## 📄 Licencia

GPL-2.0+ - Misma licencia que WordPress

---

**Desarrollado por [Close Marketing](https://close.marketing)** 🚀

