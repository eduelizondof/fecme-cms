# Estructura de Datos de Servicios

Este documento explica cómo estructurar el archivo JSON para los servicios que se mostrarán en la aplicación.

## Ubicación del archivo

El archivo JSON se encuentra en: `src/data/services.json`

## Estructura General

El archivo JSON debe tener un objeto raíz con una propiedad `services` que es un array de objetos de servicio.

```json
{
  "services": [
    {
      // Objeto de servicio
    }
  ]
}
```

## Estructura de un Servicio

Cada objeto de servicio debe contener las siguientes propiedades:

### Propiedades Requeridas

#### `slug` (string, requerido)
- Identificador único para la ruta del servicio
- Se usa en la URL: `/servicio/{slug}`
- Debe ser único entre todos los servicios
- Ejemplos: `"pedigree"`, `"cpri"`, `"cursos"`

#### `title` (string, requerido)
- Título principal del servicio
- Se muestra en la página de detalle y en los listados
- Ejemplo: `"Registro y Emisión de Pedigree Oficial"`

#### `shortDescription` (string, requerido)
- Descripción breve del servicio
- Se muestra en las tarjetas de servicio en el listado
- Ejemplo: `"Documentación oficial que respalda la genealogía..."`

#### `mainImage` (string, requerido)
- URL de la imagen principal del servicio
- Se muestra en grande en la parte superior de la página de detalle
- Puede ser una URL externa o ruta relativa
- Ejemplo: `"https://images.unsplash.com/photo-xxx?w=1200&q=80"`

#### `description` (string, requerido)
- Descripción completa y detallada del servicio
- Se muestra en la sección principal de la página de detalle
- Puede contener múltiples párrafos si es necesario
- Ejemplo: `"El pedigree oficial es el documento que certifica..."`

### Propiedades Opcionales

#### `featured` (object, opcional)
Objeto que contiene información destacada del servicio:

```json
{
  "title": "Título de la sección destacada",
  "items": [
    "Beneficio o característica 1",
    "Beneficio o característica 2",
    "Beneficio o característica 3"
  ]
}
```

- `title`: Título de la sección (string)
- `items`: Array de strings con los puntos destacados

#### `gallery` (array, opcional)
Array de URLs de imágenes para la galería:

```json
[
  "https://example.com/image1.jpg",
  "https://example.com/image2.jpg",
  "https://example.com/image3.jpg"
]
```

- Cada elemento debe ser una URL válida de una imagen
- Si no se proporciona o está vacío, la sección de galería no se mostrará

#### `requirements` (array, requerido)
Array de strings con los requisitos necesarios para el servicio:

```json
[
  "Certificado de nacimiento del ejemplar",
  "Documentación de los padres",
  "Formulario completo"
]
```

- Cada elemento es un requisito que se mostrará en la lista
- Se muestra en el sidebar de la página de detalle

#### `cost` (object, requerido)
Objeto que contiene información sobre el costo del servicio:

**Con costo:**
```json
{
  "hasCost": true,
  "amount": 1500,
  "currency": "MXN",
  "description": "Descripción del costo y qué incluye"
}
```

**Sin costo:**
```json
{
  "hasCost": false,
  "description": "Los costos varían según el servicio. Contacta para más información."
}
```

- `hasCost`: Boolean que indica si el servicio tiene un costo fijo
- `amount`: Número del monto (solo si `hasCost` es `true`)
- `currency`: Código de moneda (solo si `hasCost` es `true`), ejemplo: `"MXN"`, `"USD"`
- `description`: String con descripción del costo o información adicional

## Ejemplo Completo

```json
{
  "services": [
    {
      "slug": "pedigree",
      "title": "Registro y Emisión de Pedigree Oficial",
      "shortDescription": "Documentación oficial que respalda la genealogía y pureza de tus ejemplares.",
      "mainImage": "https://images.unsplash.com/photo-xxx?w=1200&q=80",
      "description": "El pedigree oficial es el documento que certifica la genealogía completa de tu ejemplar canino o felino. Este documento no solo respalda la pureza y origen de tus animales, sino que también otorga un valor agregado significativo a tu labor como criador responsable.",
      "featured": {
        "title": "¿Por qué elegir nuestro Pedigree?",
        "items": [
          "Reconocimiento internacional por FECAM y WKU",
          "Documentación oficial y verificable",
          "Proceso rápido y eficiente"
        ]
      },
      "gallery": [
        "https://images.unsplash.com/photo-xxx?w=800&q=80",
        "https://images.unsplash.com/photo-xxx?w=800&q=80"
      ],
      "requirements": [
        "Certificado de nacimiento del ejemplar",
        "Documentación de los padres con pedigrees válidos",
        "Fotografías recientes del ejemplar"
      ],
      "cost": {
        "hasCost": true,
        "amount": 1500,
        "currency": "MXN",
        "description": "El costo incluye el registro, emisión del documento oficial y envío físico del pedigree."
      }
    }
  ]
}
```

## Integración con Base de Datos

Para integrar esto con una base de datos en el futuro, deberás:

1. **Crear una tabla de servicios** con las siguientes columnas:
   - `id` (primary key)
   - `slug` (unique, varchar)
   - `title` (varchar)
   - `short_description` (text)
   - `main_image` (varchar/url)
   - `description` (text)
   - `featured_title` (varchar, nullable)
   - `cost_amount` (decimal, nullable)
   - `cost_currency` (varchar, nullable)
   - `cost_description` (text)
   - `created_at` (timestamp)
   - `updated_at` (timestamp)

2. **Crear tablas relacionadas**:
   - `service_featured_items` (para los items destacados)
   - `service_gallery` (para las imágenes de la galería)
   - `service_requirements` (para los requisitos)

3. **Crear un endpoint API** que devuelva los datos en el formato JSON descrito anteriormente

4. **Actualizar el componente** `ServiceDetailView.vue` para consumir la API en lugar del archivo JSON estático

## Notas Importantes

- Los `slug` deben ser únicos y no deben cambiar una vez creados para mantener las URLs estables
- Las URLs de imágenes pueden ser externas (como Unsplash) o rutas relativas dentro del proyecto
- El formato de moneda debe seguir códigos ISO 4217 (MXN, USD, EUR, etc.)
- Los textos deben estar en español según los requisitos del proyecto
- La descripción puede contener saltos de línea que se respetarán en el renderizado

## Validación

Antes de cargar datos desde una base de datos, asegúrate de validar:
- Que todos los campos requeridos estén presentes
- Que los slugs sean únicos
- Que las URLs de imágenes sean válidas
- Que los tipos de datos sean correctos (strings, números, arrays, objetos)
- Que `hasCost` sea un boolean y que si es `true`, `amount` y `currency` estén presentes

