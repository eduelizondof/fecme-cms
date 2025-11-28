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
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    slug: '',
    type: 'tramite',
    short_description: '',
    main_image: '',
    image: '',
    show_in_services: true,
    show_in_pricing: false,
    pricing_category: '',
    pricing_features: [] as any[],
    description: '',
    featured: null as any,
    gallery: [] as string[],
    requirements: [] as string[],
    cost: null as any,
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post('/cms/services');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Servicios', href: '/cms/services' },
    { title: 'Crear', href: '/cms/services/create' },
];
</script>

<template>
    <Head title="Crear Servicio - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Crear Servicio</h2>
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
                                        <Input id="slug" v-model="form.slug" placeholder="url-amigable" />
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
                                    <Label>Activo</Label>
                                    <Switch :checked="form.is_active" @update:checked="form.is_active = $event" />
                                </div>
                                <div class="flex items-center justify-between">
                                    <Label>Mostrar en servicios</Label>
                                    <Switch :checked="form.show_in_services" @update:checked="form.show_in_services = $event" />
                                </div>
                                <div class="flex items-center justify-between">
                                    <Label>Mostrar en precios</Label>
                                    <Switch :checked="form.show_in_pricing" @update:checked="form.show_in_pricing = $event" />
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
                        {{ form.processing ? 'Guardando...' : 'Crear servicio' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
