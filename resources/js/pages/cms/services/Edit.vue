<script setup lang="ts">
import CostEditor from '@/components/cms/CostEditor.vue';
import DynamicStringList from '@/components/cms/DynamicStringList.vue';
import FeaturedEditor from '@/components/cms/FeaturedEditor.vue';
import GalleryEditor from '@/components/cms/GalleryEditor.vue';
import ImagePicker from '@/components/cms/ImagePicker.vue';
import PricingFeaturesEditor from '@/components/cms/PricingFeaturesEditor.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps<{ service: any }>();

// Función helper para parsear valores que pueden venir como string JSON
const parseValue = (value: any) => {
    if (typeof value === 'string' && (value.startsWith('{') || value.startsWith('['))) {
        try {
            return JSON.parse(value);
        } catch {
            return value;
        }
    }
    return value;
};

// Función helper para convertir a booleano
const toBoolean = (value: any): boolean => {
    if (value === true || value === 1 || value === '1') return true;
    if (value === false || value === 0 || value === '0') return false;
    return Boolean(value);
};

const form = useForm({
    title: props.service.title || '',
    slug: props.service.slug || '',
    type: props.service.type || 'tramite',
    short_description: props.service.short_description || '',
    main_image: props.service.main_image || '',
    image: props.service.image || '',
    show_in_services: toBoolean(props.service.show_in_services),
    show_in_pricing: toBoolean(props.service.show_in_pricing),
    pricing_category: props.service.pricing_category || '',
    pricing_features: parseValue(props.service.pricing_features) || [],
    description: props.service.description || '',
    featured: parseValue(props.service.featured) || null,
    gallery: parseValue(props.service.gallery) || [],
    requirements: parseValue(props.service.requirements) || [],
    cost: parseValue(props.service.cost) || null,
    is_active: toBoolean(props.service.is_active),
    sort_order: props.service.sort_order || 0,
});

// Rastrear si el slug fue editado manualmente
const slugManuallyEdited = ref(false);
const originalSlug = ref(props.service.slug || '');

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
    // Asegurar que los valores booleanos se envíen correctamente
    form.show_in_services = !!form.show_in_services;
    form.show_in_pricing = !!form.show_in_pricing;
    form.is_active = !!form.is_active;
    
    form.put(`/cms/services/${props.service.id}`);
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Servicios', href: '/cms/services' },
    { title: 'Editar', href: `/cms/services/${props.service.id}/edit` },
];
</script>

<template>
    <Head :title="`Editar: ${service.title} - CMS`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Editar Servicio</h2>
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
                                    <Input id="title" v-model="form.title" placeholder="Nombre del servicio" />
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
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
                                    <div class="space-y-2">
                                        <Label for="type">Tipo</Label>
                                        <Select v-model="form.type">
                                            <SelectTrigger>
                                                <SelectValue placeholder="Seleccionar tipo" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="tramite">Trámite</SelectItem>
                                                <SelectItem value="servicio">Servicio</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="short_description">Descripción corta</Label>
                                    <Textarea id="short_description" v-model="form.short_description" :rows="2" />
                                </div>

                                <div class="space-y-2">
                                    <Label for="description">Descripción completa</Label>
                                    <Textarea id="description" v-model="form.description" :rows="4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Características destacadas</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <FeaturedEditor
                                    v-model="form.featured"
                                    label=""
                                    title-placeholder="¿Por qué elegir este servicio?"
                                    items-label="Beneficios / Características"
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Requisitos</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <DynamicStringList
                                    v-model="form.requirements"
                                    label=""
                                    placeholder="Agregar requisito..."
                                    add-button-text="Agregar requisito"
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Costos</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <CostEditor
                                    v-model="form.cost"
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
                                    <div class="flex items-center gap-2">
                                        <input 
                                            id="is_active"
                                            type="checkbox" 
                                            :checked="form.is_active" 
                                            @change="form.is_active = ($event.target as HTMLInputElement).checked"
                                            class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                        />
                                        <span class="text-xs text-muted-foreground">
                                            {{ form.is_active ? 'Sí' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <Label for="show_in_services">Mostrar en servicios</Label>
                                    <div class="flex items-center gap-2">
                                        <input 
                                            id="show_in_services"
                                            type="checkbox" 
                                            :checked="form.show_in_services" 
                                            @change="form.show_in_services = ($event.target as HTMLInputElement).checked"
                                            class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                        />
                                        <span class="text-xs text-muted-foreground">
                                            {{ form.show_in_services ? 'Sí' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <Label for="show_in_pricing">Mostrar en precios</Label>
                                    <div class="flex items-center gap-2">
                                        <input 
                                            id="show_in_pricing"
                                            type="checkbox" 
                                            :checked="form.show_in_pricing" 
                                            @change="form.show_in_pricing = ($event.target as HTMLInputElement).checked"
                                            class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                        />
                                        <span class="text-xs text-muted-foreground">
                                            {{ form.show_in_pricing ? 'Sí' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <Label for="sort_order">Orden</Label>
                                    <Input id="sort_order" v-model.number="form.sort_order" type="number" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Imagen principal</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ImagePicker v-model="form.main_image" label="" />
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

                        <Card v-if="form.show_in_pricing">
                            <CardHeader>
                                <CardTitle>Configuración de precios</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="pricing_category">Categoría de precio</Label>
                                    <Input id="pricing_category" v-model="form.pricing_category" placeholder="Ej: Certificado" />
                                </div>
                                <PricingFeaturesEditor
                                    v-model="form.pricing_features"
                                    label=""
                                />
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button type="button" variant="outline" @click="$inertia.visit('/cms/services')">
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
