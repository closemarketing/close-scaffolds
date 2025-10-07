# 🚀 Quick Start - Close Plugin Scaffold

## Inicio Rápido (2 pasos)

### 1. Instalar globalmente
```bash
npm install -g @closetechnology/scaffolds
```

### 2. Ejecutar
```bash
close-scaffold create pluginwp
```

### 3. Responder las preguntas
```
? Plugin name: Mi Plugin
? Plugin description: Descripción
? Author: Tu Nombre
? Plugin prefix: mp
? Output directory: ../
? Select features: [selecciona con espacio, Enter para continuar]
```

**¡Listo!** Tu plugin está en `../mi-plugin/`

---

## Comandos Útiles

```bash
# Ver scaffolds disponibles
close-scaffold list

# Modo interactivo
close-scaffold create pluginwp

# Modo rápido (todas las opciones por CLI)
close-scaffold create pluginwp \
  --name "Mi Plugin" \
  --prefix "mp" \
  --description "Mi descripción" \
  --author "Nombre" \
  --output "./"

# Ver ayuda
close-scaffold create --help
close-scaffold --help

# Desde el repositorio
npm start
npm run list
```

---

## ¿Qué hace el scaffold?

1. ✅ Crea estructura completa del plugin
2. ✅ Reemplaza todos los nombres y prefijos
3. ✅ Copia solo las características que selecciones
4. ✅ Genera archivos listos para usar

---

## Estructura generada

```
mi-plugin/
├── plugin.php          ← Archivo principal
├── readme.txt          ← Documentación
└── includes/
    ├── custom-login/   ← Login personalizado
    ├── post-types/     ← CPT Testimonios, Empresas
    └── theme/          ← Estilos y funciones
```

---

## Después de generar

1. Copia a WordPress plugins:
   ```bash
   cp -r mi-plugin /path/to/wp-content/plugins/
   ```

2. Activa en WordPress Admin

3. Personaliza según necesites

---

## Necesitas ayuda?

- 📖 Lee [README.md](README.md) completo
- 💡 Ve [EXAMPLES.md](EXAMPLES.md) para más ejemplos
- 🐛 Reporta problemas al equipo

---

**Close Marketing** - Desarrollo WordPress optimizado 🚀
