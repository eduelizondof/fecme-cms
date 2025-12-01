<script setup lang="ts">
import ContentEditor from '@/components/cms/ContentEditor.vue';
import GalleryEditor from '@/components/cms/GalleryEditor.vue';
import ImagePicker from '@/components/cms/ImagePicker.vue';
import TagsInput from '@/components/cms/TagsInput.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

interface Blog {
    id: number;
    title: string;
    slug: string;
    short_description: string;
    main_image: string;
    date: string;
    author: string;
    author_url: string;
    tags: string[];
    tags_url: string;
    excerpt: string;
    content: any[];
    related_posts: any[];
    gallery: string[];
    is_active: boolean;
    sort_order: number;
}

const props = defineProps<{
    blog: Blog;
}>();

const form = useForm({
    title: props.blog.title || '',
    slug: props.blog.slug || '',
    short_description: props.blog.short_description || '',
    main_image: props.blog.main_image || '',
    date: props.blog.date ? (props.blog.date.split('T')[0] || '') : '',
    author: props.blog.author || '',
    author_url: props.blog.author_url || '',
    tags: props.blog.tags || [],
    tags_url: props.blog.tags_url || '',
    excerpt: props.blog.excerpt || '',
    content: props.blog.content || [],
    related_posts: props.blog.related_posts || [],
    gallery: props.blog.gallery || [],
    is_active: props.blog.is_active !== undefined ? props.blog.is_active : true,
    sort_order: props.blog.sort_order || 0,
});

// Rastrear si el slug fue editado manualmente
const slugManuallyEdited = ref(false);
const originalSlug = ref(props.blog.slug || '');

// Generar slug automáticamente desde el título en tiempo real
watch(() => form.title, (newTitle) => {
    if (newTitle && !slugManuallyEdited.value) {
        form.slug = newTitle
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
    }
});

// Detectar cuando el usuario edita manualmente el slug
const onSlugInput = () => {
    slugManuallyEdited.value = true;
};

const submit = () => {
    // Asegurar que los valores se envíen correctamente
    form.slug = form.slug.trim() || null;
    form.date = form.date && form.date.trim() ? form.date : null;
    // is_active ya está en el form, se enviará automáticamente
    
    form.put(`/cms/blogs/${props.blog.id}`);
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Blog', href: '/cms/blogs' },
    { title: 'Editar', href: `/cms/blogs/${props.blog.id}/edit` },
];
</script>

<template>
    <Head :title="`Editar: ${blog.title} - CMS`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Editar Artículo</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información básica</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="title">Título *</Label>
                                    <Input
                                        id="title"
                                        v-model="form.title"
                                        placeholder="Título del artículo"
                                    />
                                    <p v-if="form.errors.title" class="text-sm text-destructive">
                                        {{ form.errors.title }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="slug">Slug</Label>
                                    <Input
                                        id="slug"
                                        v-model="form.slug"
                                        placeholder="url-amigable (se genera automáticamente desde el título)"
                                        @input="onSlugInput"
                                    />
                                    <p class="text-xs text-muted-foreground">
                                        Se regenera automáticamente desde el título mientras escribes
                                    </p>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="author">Autor</Label>
                                        <Input
                                            id="author"
                                            v-model="form.author"
                                            placeholder="Nombre del autor"
                                        />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="date">Fecha</Label>
                                        <Input
                                            id="date"
                                            v-model="form.date"
                                            type="date"
                                        />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="short_description">Descripción corta</Label>
                                    <Textarea
                                        id="short_description"
                                        v-model="form.short_description"
                                        placeholder="Breve descripción del artículo"
                                        :rows="2"
                                    />
                                </div>

                                <div class="space-y-2">
                                    <Label for="excerpt">Extracto</Label>
                                    <Textarea
                                        id="excerpt"
                                        v-model="form.excerpt"
                                        placeholder="Extracto para mostrar en listados"
                                        :rows="3"
                                    />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Contenido del artículo</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ContentEditor
                                    v-model="form.content"
                                    label=""
                                />
                            </CardContent>
                        </Card>

                    </div>

                    <div class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Publicación</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <Label for="is_active">Activo</Label>
                                    <Switch
                                        id="is_active"
                                        :checked="form.is_active"
                                        @update:checked="form.is_active = $event"
                                    />
                                </div>

                                <div class="space-y-2">
                                    <Label for="sort_order">Orden</Label>
                                    <Input
                                        id="sort_order"
                                        v-model.number="form.sort_order"
                                        type="number"
                                    />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Imagen principal</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ImagePicker
                                    v-model="form.main_image"
                                    label=""
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Etiquetas</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <TagsInput
                                    v-model="form.tags"
                                    label=""
                                    placeholder="Agregar etiqueta..."
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Galería</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <GalleryEditor
                                    v-model="form.gallery"
                                    label=""
                                    :simple-mode="true"
                                />
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button
                        type="button"
                        variant="outline"
                        @click="$inertia.visit('/cms/blogs')"
                    >
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
