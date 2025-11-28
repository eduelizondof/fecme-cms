<script setup lang="ts">
import AboutEditor from '@/components/cms/AboutEditor.vue';
import AwardsEditor from '@/components/cms/AwardsEditor.vue';
import CertificationsEditor from '@/components/cms/CertificationsEditor.vue';
import FacilitiesEditor from '@/components/cms/FacilitiesEditor.vue';
import FeaturesEditor from '@/components/cms/FeaturesEditor.vue';
import GalleryEditor from '@/components/cms/GalleryEditor.vue';
import ImagePicker from '@/components/cms/ImagePicker.vue';
import LocationEditor from '@/components/cms/LocationEditor.vue';
import ProgramsEditor from '@/components/cms/ProgramsEditor.vue';
import ResponsibleEditor from '@/components/cms/ResponsibleEditor.vue';
import ReviewsEditor from '@/components/cms/ReviewsEditor.vue';
import SocialLinksEditor from '@/components/cms/SocialLinksEditor.vue';
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
    programs_list: [] as string[],
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
    programs: [] as any[],
    facilities: null as any,
    awards: [] as any[],
    gallery: [] as any[],
    reviews: [] as any[],
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post('/cms/schools');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Escuelas', href: '/cms/schools' },
    { title: 'Crear', href: '/cms/schools/create' },
];
</script>

<template>
    <Head title="Crear Escuela - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Crear Escuela</h2>
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
                                        <Input id="name" v-model="form.name" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="slug">Slug</Label>
                                        <Input id="slug" v-model="form.slug" />
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <Label for="short_description">Descripción corta</Label>
                                    <Textarea id="short_description" v-model="form.short_description" :rows="2" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="description">Descripción</Label>
                                    <Textarea id="description" v-model="form.description" :rows="4" />
                                </div>
                                <TagsInput v-model="form.programs_list" label="Programas que ofrece" placeholder="Agregar programa..." />
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
                                <LocationEditor v-model="form.location" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Acerca de la escuela</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <AboutEditor v-model="form.about" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Responsable</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ResponsibleEditor v-model="form.responsible" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Programas detallados</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ProgramsEditor v-model="form.programs" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Instalaciones</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <FacilitiesEditor v-model="form.facilities" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Certificaciones</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <CertificationsEditor v-model="form.certifications" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Características</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <FeaturesEditor v-model="form.features" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Premios</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <AwardsEditor v-model="form.awards" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Galería</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <GalleryEditor v-model="form.gallery" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Reseñas</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ReviewsEditor v-model="form.reviews" label="" />
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
                                    <Input id="member_since" v-model="form.member_since" />
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
                                <SocialLinksEditor v-model="form.social_links" label="" />
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button type="button" variant="outline" @click="$inertia.visit('/cms/schools')">
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Crear escuela' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
