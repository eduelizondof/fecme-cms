# Estructura de Datos de Blogs

Este documento explica cómo estructurar el archivo JSON para los posts del blog que se mostrarán en la aplicación.

## Ubicación del archivo

El archivo JSON se encuentra en: `src/data/blogs.json`

## Estructura General

El archivo JSON debe tener un objeto raíz con una propiedad `posts` que es un array de objetos de post.

```json
{
  "posts": [
    {
      // Objeto de post
    }
  ]
}
```

## Estructura de un Post

Cada objeto de post debe contener las siguientes propiedades:

### Propiedades Requeridas

#### `slug` (string, requerido)
- Identificador único para la ruta del post
- Se usa en la URL: `/blog/{slug}`
- Debe ser único entre todos los posts
- Ejemplos: `"tendencia-2025"`, `"registro-pedigree-valido"`, `"xoloitzcuintle-orgullo-mexicano"`

#### `title` (string, requerido)
- Título principal del post
- Se muestra en la página de detalle y en los listados
- Ejemplo: `"Tendencia 2025 - Crianza Responsable"`

#### `shortDescription` (string, requerido)
- Descripción breve del post
- Se muestra en las tarjetas de blog en el listado
- Ejemplo: `"El mundo canino está cambiando: más tutores responsables..."`

#### `mainImage` (string, requerido)
- URL de la imagen principal del post
- Se muestra en grande en la parte superior de la página de detalle
- Puede ser una URL externa o ruta relativa
- Ejemplo: `"https://images.unsplash.com/photo-xxx?w=1200&q=80"`

#### `date` (string, requerido)
- Fecha de publicación del post
- Se muestra en el date-box sobre la imagen principal
- Formato recomendado: `"15 Ene 2025"` o `"15 de Enero de 2025"`
- Ejemplo: `"15 Ene 2025"`

#### `author` (string, requerido)
- Nombre del autor del post
- Se muestra en la sección de meta información
- Ejemplo: `"Por FECMEgt"`

#### `authorUrl` (string, requerido)
- URL del perfil del autor (puede ser `"#"` si no aplica)
- Ejemplo: `"#"` o `"/author/fecmegt"`

#### `tags` (array, requerido)
- Array de strings con las etiquetas/categorías del post
- Se muestra en la sección de meta información
- Ejemplo: `["Tendencia", "Crianza", "Responsabilidad"]`

#### `tagsUrl` (string, requerido)
- URL base para las etiquetas (puede ser `"#"` si no aplica)
- Ejemplo: `"#"` o `"/blog/tag/"`

#### `excerpt` (string, requerido)
- Extracto o resumen del post
- Se muestra en las tarjetas de blog en el listado
- Ejemplo: `"El mundo canino está cambiando: más tutores responsables, menos criadores improvisados..."`

#### `content` (array, requerido)
- Array de objetos que representan el contenido del post
- Cada objeto puede ser un párrafo, encabezado o lista
- Ver sección "Estructura de Content" más abajo

### Propiedades Opcionales

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

#### `relatedPosts` (array, opcional)
Array de objetos con posts relacionados:

```json
[
  {
    "slug": "otro-post",
    "title": "Título del post relacionado",
    "image": "https://example.com/image.jpg",
    "date": "10 Ene 2025"
  }
]
```

- Cada objeto debe tener: `slug`, `title`, `image`, `date`
- Se muestra en el sidebar de la página de detalle
- Si no se proporciona, la sección no se mostrará

## Estructura de Content

El array `content` puede contener objetos de tres tipos:

### 1. Párrafo

```json
{
  "type": "paragraph",
  "text": "Texto del párrafo aquí..."
}
```

### 2. Encabezado

```json
{
  "type": "heading",
  "level": 2,
  "text": "Título del encabezado"
}
```

- `level`: Número del 2 al 6 (h2, h3, h4, h5, h6)
- Se recomienda usar h2 para secciones principales y h3 para subsecciones

### 3. Lista

```json
{
  "type": "list",
  "items": [
    "Item 1",
    "Item 2",
    "Item 3"
  ]
}
```

## Ejemplo Completo

```json
{
  "posts": [
    {
      "slug": "tendencia-2025",
      "title": "Tendencia 2025 - Crianza Responsable",
      "shortDescription": "El mundo canino está cambiando: más tutores responsables...",
      "mainImage": "https://images.unsplash.com/photo-xxx?w=1200&q=80",
      "date": "15 Ene 2025",
      "author": "Por FECMEgt",
      "authorUrl": "#",
      "tags": ["Tendencia", "Crianza", "Responsabilidad"],
      "tagsUrl": "#",
      "excerpt": "El mundo canino está cambiando...",
      "content": [
        {
          "type": "paragraph",
          "text": "El año 2025 marca un punto de inflexión..."
        },
        {
          "type": "heading",
          "level": 2,
          "text": "Las Nuevas Tendencias"
        },
        {
          "type": "paragraph",
          "text": "Este año vemos un aumento significativo..."
        },
        {
          "type": "list",
          "items": [
            "Mayor énfasis en la salud genética",
            "Certificaciones internacionales reconocidas",
            "Educación continua para criadores"
          ]
        }
      ],
      "relatedPosts": [
        {
          "slug": "otro-post",
          "title": "Título del post relacionado",
          "image": "https://example.com/image.jpg",
          "date": "10 Ene 2025"
        }
      ],
      "gallery": [
        "https://images.unsplash.com/photo-xxx?w=800&q=80",
        "https://images.unsplash.com/photo-xxx?w=800&q=80"
      ]
    }
  ]
}
```

## Integración con Base de Datos

Para integrar esto con una base de datos en el futuro, deberás:

1. **Crear una tabla de posts** con las siguientes columnas:
   - `id` (primary key)
   - `slug` (unique, varchar)
   - `title` (varchar)
   - `short_description` (text)
   - `main_image` (varchar/url)
   - `date` (date o varchar)
   - `author` (varchar)
   - `author_url` (varchar)
   - `excerpt` (text)
   - `created_at` (timestamp)
   - `updated_at` (timestamp)

2. **Crear tablas relacionadas**:
   - `post_tags` (relación muchos a muchos entre posts y tags)
   - `post_content` (para almacenar el contenido estructurado)
   - `post_gallery` (para las imágenes de la galería)
   - `related_posts` (para relacionar posts)

3. **Estructura de post_content**:
   - `id` (primary key)
   - `post_id` (foreign key)
   - `type` (enum: 'paragraph', 'heading', 'list')
   - `level` (int, nullable - solo para headings)
   - `text` (text, nullable - para paragraphs y headings)
   - `items` (json, nullable - solo para lists)
   - `order` (int - orden de aparición en el post)

4. **Crear un endpoint API** que devuelva los datos en el formato JSON descrito anteriormente

5. **Actualizar el componente** `BlogDetailView.vue` para consumir la API en lugar del archivo JSON estático

## Notas Importantes

- Los `slug` deben ser únicos y no deben cambiar una vez creados para mantener las URLs estables
- Las URLs de imágenes pueden ser externas (como Unsplash) o rutas relativas dentro del proyecto
- El formato de fecha es flexible, pero se recomienda un formato legible y consistente
- Los tags deben ser relevantes y descriptivos para mejorar la búsqueda y categorización
- El contenido puede mezclar párrafos, encabezados y listas en cualquier orden
- Los posts relacionados deben existir en la base de datos para que los enlaces funcionen correctamente
- Los textos deben estar en español según los requisitos del proyecto

## Validación

Antes de cargar datos desde una base de datos, asegúrate de validar:
- Que todos los campos requeridos estén presentes
- Que los slugs sean únicos
- Que las URLs de imágenes sean válidas
- Que los tipos de datos sean correctos (strings, números, arrays, objetos)
- Que los objetos de content tengan el tipo correcto y los campos necesarios
- Que los niveles de heading estén entre 2 y 6
- Que los relatedPosts tengan todos los campos requeridos (slug, title, image, date)

