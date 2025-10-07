# 📦 Guía de Publicación en npm

## Pre-requisitos

1. Cuenta en [npmjs.com](https://www.npmjs.com/)
2. Login en npm desde la terminal:
   ```bash
   npm login
   ```

## Pasos para Publicar

### 1. Verificar el package.json

Asegúrate de que todo esté correcto:

```json
{
  "name": "@closetechnology/scaffolds",
  "version": "1.0.0",
  "description": "CLI tool to generate WordPress plugins...",
  "repository": {
    "type": "git",
    "url": "https://github.com/closemarketing/close-scaffolds.git"
  }
}
```

### 2. Probar Localmente

```bash
# Instalar dependencias
npm install

# Listar scaffolds disponibles
npm run list

# Probar el CLI (modo interactivo)
npm start

# Probar con opciones
node bin/cli.js create pluginwp --name "Test" --prefix "t" --description "Test" --author "Test" --output "/tmp"

# Verificar el resultado
ls -la /tmp/test/
head /tmp/test/plugin.php
```

### 3. Verificar qué se va a Publicar

```bash
# Ver qué archivos se incluirán
npm pack --dry-run

# Esto debería mostrar:
# - bin/
# - lib/
# - templates/
# - README.md
# - QUICKSTART.md
# - EXAMPLES.md
# - package.json
```

### 4. Actualizar la Versión

Usa semantic versioning:

```bash
# Para parches (1.0.0 -> 1.0.1)
npm version patch

# Para features (1.0.0 -> 1.1.0)
npm version minor

# Para cambios breaking (1.0.0 -> 2.0.0)
npm version major
```

### 5. Publicar en npm

#### Primera vez (scoped package público):

```bash
npm publish --access public
```

#### Actualizaciones posteriores:

```bash
npm publish
```

### 6. Verificar la Publicación

```bash
# Ver en npm
open https://www.npmjs.com/package/@closetechnology/scaffolds

# Probar la instalación
npm install -g @closetechnology/scaffolds

# Listar scaffolds
close-scaffold list

# Probar el comando
close-scaffold create pluginwp
```

## Publicación en GitHub

### 1. Crear Repositorio

```bash
cd close-scaffolds
git init
git add .
git commit -m "Initial commit: WordPress plugin scaffold"
```

### 2. Subir a GitHub

```bash
git remote add origin https://github.com/closemarketing/close-scaffolds.git
git branch -M main
git push -u origin main
```

### 3. Crear Release en GitHub

1. Ve a: https://github.com/closemarketing/close-scaffolds/releases
2. Click en "Create a new release"
3. Tag: `v1.0.0`
4. Title: `v1.0.0 - Initial Release`
5. Description:
   ```markdown
   # WordPress Plugin Scaffold v1.0.0
   
   ## Features
   - 🎯 Interactive CLI for plugin generation
   - 📝 Template variables system
   - 🔧 Customizable features selection
   - ♻️ Based on Close Marketing boilerplate
   
   ## Installation
   ```bash
   npm install -g @closetechnology/scaffolds
   ```
   
   ## Usage
   ```bash
   close-scaffold create
   ```
   ```

## Actualizaciones Futuras

### Proceso de Update

1. Hacer cambios en el código
2. Probar localmente
3. Actualizar versión:
   ```bash
   npm version patch  # o minor/major
   ```
4. Commit y push:
   ```bash
   git add .
   git commit -m "feat: descripción del cambio"
   git push
   git push --tags
   ```
5. Publicar en npm:
   ```bash
   npm publish
   ```
6. Crear release en GitHub

### Versionado Semántico

- **Patch** (1.0.X): Bug fixes, mejoras menores
- **Minor** (1.X.0): Nuevas features, no breaking changes
- **Major** (X.0.0): Breaking changes

## Troubleshooting

### Error: "You do not have permission to publish"

```bash
# Verifica que estés logueado
npm whoami

# Re-login
npm logout
npm login
```

### Error: "Package name already exists"

Cambia el nombre en `package.json`:
```json
{
  "name": "@closetechnology/scaffolds-v2"
}
```

### Error en la instalación global

```bash
# Limpia caché npm
npm cache clean --force

# Reinstala
npm install -g @closetechnology/scaffolds
```

## Checklist Pre-Publicación

- [ ] ✅ `package.json` actualizado con información correcta
- [ ] ✅ `README.md` completo y actualizado
- [ ] ✅ Probado localmente con `npm start`
- [ ] ✅ Probado la generación de plugins
- [ ] ✅ Verificado que las variables se reemplazan correctamente
- [ ] ✅ `.npmignore` configurado correctamente
- [ ] ✅ `bin/cli.js` tiene permisos de ejecución
- [ ] ✅ Todos los archivos de templates tienen variables `{{VARIABLE}}`
- [ ] ✅ Documentación completa (README, EXAMPLES, QUICKSTART)
- [ ] ✅ Sin archivos sensibles o temporales

## Promoción

Después de publicar:

1. **Anunciar en:**
   - Twitter/X
   - LinkedIn
   - Blog de Close Marketing
   - WordPress Groups

2. **Ejemplo de anuncio:**
   ```
   🚀 Nuevo paquete npm: @closetechnology/scaffolds
   
   Genera plugins de WordPress en segundos con nuestro boilerplate probado.
   
   ✨ Features:
   - CLI interactivo
   - Custom Post Types
   - Theme integration
   - WooCommerce ready
   
   npm install -g @closetechnology/scaffolds
   
   #WordPress #npm #webdev
   ```

---

**¿Listo para publicar?** 🚀

```bash
npm publish --access public
```
