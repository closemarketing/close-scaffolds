# Ejemplos de Uso del Close Plugin Scaffold

## Ejemplo 1: Crear un plugin básico con prompts interactivos

```bash
close-scaffold create pluginwp
```

**Respuestas de ejemplo:**
```
? Plugin name: Mi Super Plugin
? Plugin description: Plugin para gestión avanzada de contenido
? Author: David Pérez
? Plugin prefix (for functions): msp
? Output directory: ../
? Select features to include: 
  ◉ Custom Post Types
  ◉ Custom Login
  ◉ Theme Integration
  ◯ WooCommerce Integration
  ◯ Blocks
  ◯ Shortcodes
```

**Resultado:**
```
📁 ../mi-super-plugin/
├── plugin.php (con prefijo msp_)
├── readme.txt
└── includes/
    ├── custom-login/
    ├── post-types/
    └── theme/
```

---

## Ejemplo 2: Crear plugin con línea de comandos

```bash
close-scaffold create pluginwp \
  --name "E-Commerce Manager" \
  --prefix "ecm" \
  --description "Gestión avanzada de productos WooCommerce" \
  --author "Closemarketing" \
  --output "./"
```

**Resultado:**
- Plugin: `e-commerce-manager`
- Funciones con prefijo: `ecm_`
- Constantes: `E_COMMERCE_MANAGER_VERSION`
- Text domain: `ecommercemanager`

---

## Ejemplo 3: Crear plugin para cliente específico

```bash
close-scaffold create pluginwp
```

**Respuestas:**
```
? Plugin name: NMR63 Motos Custom
? Plugin description: Personalizaciones para sitio de motos
? Author: Closemarketing
? Plugin prefix: nmr63
? Output directory: ./
? Select features: 
  ◉ Custom Post Types
  ◉ Custom Login
  ◉ Theme Integration
  ◉ WooCommerce Integration
  ◯ Blocks
  ◯ Shortcodes
```

---

## Ejemplo 4: Usar el scaffold instalado globalmente

```bash
# Instalar globalmente (solo una vez)
npm install -g @closetechnology/scaffolds

# Usar desde cualquier lugar
cd ~/Proyectos/nuevo-sitio
close-scaffold create pluginwp
```

---

## Ejemplo 5: Listar scaffolds disponibles

```bash
close-scaffold list
```

**Salida:**
```
📦 Available scaffolds:

  pluginwp     - WordPress plugin with custom post types, theme integration
  themewp      - WordPress theme (coming soon)
  block        - Gutenberg block (coming soon)
  react-app    - React application (coming soon)

Usage: close-scaffold create <scaffold>
```

---

## Estructura de archivos generados

### Plugin con todas las características:

```
mi-plugin/
├── plugin.php                    # Archivo principal del plugin
├── readme.txt                    # Documentación del plugin
└── includes/
    ├── custom-login/             # Personalización del login
    │   ├── class-ccaa-admin.php
    │   ├── logo-login.svg
    │   └── logo-mini.svg
    ├── post-types/               # Custom Post Types
    │   ├── cpt-testimonios.php
    │   └── cpt-empresas.php
    ├── theme/                    # Integración con tema
    │   ├── functions.php
    │   ├── style.css
    │   ├── style-editor.css
    │   ├── assets/
    │   ├── images/
    │   └── patterns/
    ├── woocommerce/              # Integración WooCommerce
    │   ├── loader.php
    │   ├── class-cart.php
    │   ├── class-checkout.php
    │   └── ...
    ├── blocks/                   # Bloques Gutenberg
    │   ├── register/
    │   ├── news/
    │   └── ...
    └── shortcodes/               # Shortcodes
        └── shortcode-one.php
```

---

## Tips y buenas prácticas

### Prefijos recomendados

- **3-4 letras** para nombres cortos: `msp`, `ecm`, `su`
- **Acrónimos del proyecto**: `nmr63`, `cmk`
- **Sin números al inicio**: ❌ `3wp` → ✅ `wp3`
- **Solo minúsculas y guiones bajos**: ❌ `myPlugin` → ✅ `my_plugin`

### Text Domain

El text domain se genera automáticamente eliminando guiones:
- `mi-super-plugin` → `misuperplugin`
- `e-commerce-manager` → `ecommercemanager`

### Constantes

Las constantes se generan en mayúsculas:
- Plugin: `Mi Super Plugin` → `MI_SUPER_PLUGIN_VERSION`
- Plugin: `E-Commerce Manager` → `E_COMMERCE_MANAGER_VERSION`

### Después de generar el plugin

1. **Copia el plugin** a tu directorio de plugins:
   ```bash
   cp -r mi-plugin /path/to/wordpress/wp-content/plugins/
   ```

2. **Activa el plugin** en WordPress admin

3. **Personaliza** los archivos según tus necesidades:
   - Modifica Custom Post Types en `includes/post-types/`
   - Personaliza logos en `includes/custom-login/`
   - Ajusta estilos en `includes/theme/style.css`

4. **Elimina** lo que no necesites

---

## Troubleshooting

### El directorio ya existe

```bash
# Elimina el directorio anterior
rm -rf mi-plugin

# Genera de nuevo
npm start
```

### Error de permisos

```bash
# Da permisos de escritura al directorio de destino
chmod 755 /path/to/output
```

### Dependencias no instaladas

```bash
# Reinstala dependencias
cd scaffold
rm -rf node_modules package-lock.json
npm install
```

---

## Próximos pasos

Una vez generado tu plugin:

1. ✅ Personaliza los Custom Post Types
2. ✅ Cambia los logos en `includes/custom-login/`
3. ✅ Ajusta los estilos del tema
4. ✅ Añade tus propias funcionalidades
5. ✅ Actualiza el `readme.txt` con información específica

¡Disfruta desarrollando plugins de WordPress más rápido!
