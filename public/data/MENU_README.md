# Configuración Dinámica del Menú y Header

Este sistema permite editar dinámicamente el menú y el header del sitio web mediante un archivo JSON centralizado.

## Archivo de Configuración

### `header.json` - Configuración Completa del Header y Menú

Controla el logo, el botón CTA (Call to Action) y toda la estructura del menú.

```json
{
  "logo": {
    "src": "/img/logo-final-gt-transparente.png",
    "alt": "FECME Logo",
    "title": "Federación Canina de México",
    "height": "80px",
    "width": "80px",
    "href": "/"
  },
  "ctaButton": {
    "label": "Validar certificado",
    "href": "/validar-certificado",
    "enabled": true
  },
  "menuItems": [
    // ... configuración del menú
  ]
}
```

**Ejemplo de cambio:**
Para cambiar el botón a "Federación Gatuna" que redirija a otra página:

```json
{
  "ctaButton": {
    "label": "Federación Gatuna",
    "href": "https://federacion-gatuna.com",
    "enabled": true
  }
}
```

### Configuración del Menú (`menuItems`)

La sección `menuItems` en `header.json` controla la estructura completa del menú con soporte para diferentes tipos de acciones.

**Nota importante:** Los items "Trámites" y "Servicios" se generan automáticamente desde `services.json`. Solo necesitas incluirlos en `menuItems` con `children: []` y los servicios se añadirán automáticamente.

#### Estructura Básica

```json
{
  "menuItems": [
    {
      "label": "Nombre del Menú",
      "action": {
        "type": "link|file|download",
        "href": "/ruta-o-url",
        "target": "_self|_blank"
      },
      "isDropdown": true|false,
      "children": []
    }
  ]
}
```

**Items especiales:**

- **"Trámites"**: Los servicios de tipo `tramite` desde `services.json` se añaden automáticamente
- **"Servicios"**: Los servicios de tipo `servicio` desde `services.json` se añaden automáticamente

#### Tipos de Acciones

##### 1. **link** - Enlace normal (página interna o externa)

```json
{
  "label": "Nosotros",
  "action": {
    "type": "link",
    "href": "/about",
    "target": "_self"
  },
  "isDropdown": false
}
```

- `target: "_self"` - Abre en la misma pestaña
- `target: "_blank"` - Abre en nueva pestaña

##### 2. **file** - Abrir archivo (PDF, imagen, etc.)

```json
{
  "label": "Documentación",
  "action": {
    "type": "file",
    "href": "/menu/documentacion.pdf",
    "target": "_blank"
  }
}
```

- Los archivos deben estar en `/public/menu/`
- `target: "_blank"` - Abre en nueva pestaña (recomendado para PDFs)
- `target: "_self"` - Abre en la misma pestaña

##### 3. **download** - Descargar archivo

```json
{
  "label": "Descargar Guía",
  "action": {
    "type": "download",
    "href": "/menu/guia.pdf",
    "filename": "guia-adopcion.pdf"
  }
}
```

- `filename` (opcional) - Nombre del archivo al descargar

#### Ejemplo Completo: Menú con Submenú

```json
{
  "label": "Adopta",
  "action": {
    "type": "link",
    "href": "#",
    "target": "_self"
  },
  "isDropdown": true,
  "children": [
    {
      "label": "Documentación",
      "action": {
        "type": "file",
        "href": "/menu/documentacion.pdf",
        "target": "_blank"
      }
    },
    {
      "label": "Proceso de Adopción",
      "action": {
        "type": "link",
        "href": "/adopcion/proceso",
        "target": "_self"
      }
    },
    {
      "label": "Descargar Formulario",
      "action": {
        "type": "download",
        "href": "/menu/formulario-adopcion.pdf",
        "filename": "formulario-adopcion.pdf"
      }
    }
  ]
}
```

## Integración con Servicios

Los servicios desde `services.json` se integran automáticamente en los menús "Trámites" y "Servicios".

**Cómo funciona:**

1. En `header.json`, incluye los items "Trámites" y "Servicios" con `children: []`
2. El sistema automáticamente añade los servicios correspondientes desde `services.json`
3. Los servicios de tipo `tramite` van a "Trámites"
4. Los servicios de tipo `servicio` van a "Servicios"

**No es necesario** agregar los servicios manualmente en `header.json`.

## Ubicación de Archivos

- **Archivos del menú (PDFs, documentos)**: `/public/menu/`
- **Configuración**: `/public/data/header.json` (todo centralizado)
- **Servicios**: `/public/data/services.json` (se integran automáticamente)

## Notas Importantes

1. **Servicios automáticos**: Los servicios de tipo "tramite" se agregan automáticamente al menú "Trámites", y los de tipo "servicio" al menú "Servicios". Solo necesitas incluir estos items en `menuItems` con `children: []`.

2. **Configuración centralizada**: Todo está en un solo archivo `header.json`:
   - Logo
   - Botón CTA
   - Estructura completa del menú

3. **Rutas de archivos**:
   - Las rutas deben comenzar con `/` para archivos en `public`
   - Ejemplo: `/menu/documentacion.pdf` apunta a `public/menu/documentacion.pdf`

4. **Validación**:
   - Si el archivo JSON no se puede cargar, se usan valores por defecto
   - Los errores se registran en la consola del navegador

5. **Edición del menú**:
   - Puedes agregar, eliminar o reordenar items del menú editando `header.json`
   - Los items "Trámites" y "Servicios" siempre se completan automáticamente con los servicios correspondientes
