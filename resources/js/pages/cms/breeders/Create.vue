<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import JsonEditor from '@/components/cms/JsonEditor.vue';
import TagsInput from '@/components/cms/TagsInput.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    slug: '',
    logo: '',
    feature_image: '',
    breeds: [] as string[],
    location: null as any,
    member_since: '',
    rating: 0,
    total_reviews: 0,
    description: '',
    short_description: '',
    website: '',
    email: '',
    phone: '',
    whatsapp: '',
    social_links: [] as any[],
    certifications: [] as any[],
    features: [] as any[],
    responsible: null as any,
    about: null as any,
    sires: [] as any[],
    care: null as any,
    awards: [] as any[],
    gallery: [] as any[],
    reviews: [] as any[],
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post('/cms/breeders');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Criaderos', href: '/cms/breeders' },
    { title: 'Crear', href: '/cms/breeders/create' },
];
</script>

<template>
    <Head title="Crear Criadero - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Crear Criadero</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información básica</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="name">Nombre *</Label>
                                        <Input id="name" v-model="form.name" placeholder="Nombre del criadero" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="slug">Slug</Label>
                                        <Input id="slug" v-model="form.slug" placeholder="url-amigable" />
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

                                <TagsInput v-model="form.breeds" label="Razas" placeholder="Agregar raza..." />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Contacto</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="email">Email</Label>
                                        <Input id="email" v-model="form.email" type="email" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="phone">Teléfono</Label>
                                        <Input id="phone" v-model="form.phone" />
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="whatsapp">WhatsApp</Label>
                                        <Input id="whatsapp" v-model="form.whatsapp" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="website">Sitio web</Label>
                                        <Input id="website" v-model="form.website" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Ubicación</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="form.location"
                                    label=""
                                    :rows="6"
                                    placeholder='{ "city": "...", "state": "...", "country": "...", "fullAddress": "..." }'
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Acerca de</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="form.about"
                                    label=""
                                    :rows="8"
                                    placeholder='{ "title": "...", "content": ["..."] }'
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Responsable</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="form.responsible"
                                    label=""
                                    :rows="6"
                                    placeholder='{ "name": "...", "registration": "...", "certification": "...", "bio": "..." }'
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Certificaciones</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.certifications" label="" :rows="8" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Características</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.features" label="" :rows="8" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Sementales</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.sires" label="" :rows="8" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Cuidados</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.care" label="" :rows="8" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Premios</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.awards" label="" :rows="6" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Galería</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.gallery" label="" :rows="6" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Reseñas</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.reviews" label="" :rows="6" />
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
                                <div class="space-y-2">
                                    <Label for="sort_order">Orden</Label>
                                    <Input id="sort_order" v-model.number="form.sort_order" type="number" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="member_since">Miembro desde</Label>
                                    <Input id="member_since" v-model="form.member_since" placeholder="2020" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Calificación</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="rating">Rating (0-5)</Label>
                                    <Input id="rating" v-model.number="form.rating" type="number" min="0" max="5" step="0.1" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="total_reviews">Total reseñas</Label>
                                    <Input id="total_reviews" v-model.number="form.total_reviews" type="number" min="0" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Logo</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ImagePicker v-model="form.logo" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Imagen destacada</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ImagePicker v-model="form.feature_image" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Redes sociales</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor v-model="form.social_links" label="" :rows="6" />
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button type="button" variant="outline" @click="$inertia.visit('/cms/breeders')">
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Crear criadero' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

