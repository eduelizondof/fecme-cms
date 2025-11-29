<script setup lang="ts">
import DynamicStringList from '@/components/cms/DynamicStringList.vue';
import ImagePicker from '@/components/cms/ImagePicker.vue';
import InscriptionInfoEditor from '@/components/cms/InscriptionInfoEditor.vue';
import LocationEditor from '@/components/cms/LocationEditor.vue';
import TagsInput from '@/components/cms/TagsInput.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const form = useForm({
    title: '',
    slug: '',
    type: '',
    image: '',
    start_date: '',
    end_date: '',
    start_time: '09:00',
    end_time: '18:00',
    location: null as any,
    organizer: '',
    judges: [] as string[],
    breeds: [] as string[],
    description: '',
    details: '',
    requirements: [] as string[],
    inscription_info: null as any,
    myths: [] as string[],
    is_active: true,
    sort_order: 0,
});

const generateSlug = (text: string) => {
    return text
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
};

watch(() => form.title, (newTitle) => {
    if (newTitle && !form.slug) {
        form.slug = generateSlug(newTitle);
    }
});

const submit = () => {
    form.post('/cms/events');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Eventos', href: '/cms/events' },
    { title: 'Crear', href: '/cms/events/create' },
];
</script>

<template>
    <Head title="Crear Evento - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Crear Evento</h2>
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
                                        <Label for="title">Título *</Label>
                                        <Input id="title" v-model="form.title" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="slug">Slug</Label>
                                        <Input id="slug" v-model="form.slug" placeholder="url-amigable" />
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="type">Tipo de evento</Label>
                                        <Input id="type" v-model="form.type" placeholder="Especializada, Cursos, etc." />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="organizer">Organizador</Label>
                                        <Input id="organizer" v-model="form.organizer" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="description">Descripción</Label>
                                    <Textarea id="description" v-model="form.description" :rows="3" />
                                </div>

                                <div class="space-y-2">
                                    <Label for="details">Detalles</Label>
                                    <Textarea id="details" v-model="form.details" :rows="4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Fecha y hora</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="start_date">Fecha de inicio</Label>
                                        <Input id="start_date" v-model="form.start_date" type="date" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="end_date">Fecha de fin</Label>
                                        <Input id="end_date" v-model="form.end_date" type="date" />
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="start_time">Hora de inicio</Label>
                                        <Input id="start_time" v-model="form.start_time" type="time" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="end_time">Hora de fin</Label>
                                        <Input id="end_time" v-model="form.end_time" type="time" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Ubicación</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <LocationEditor
                                    v-model="form.location"
                                    label=""
                                    :show-name="true"
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Requisitos de participación</CardTitle>
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
                                <CardTitle>Información de inscripción</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <InscriptionInfoEditor
                                    v-model="form.inscription_info"
                                    label=""
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Mitos a desmentir (opcional)</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <DynamicStringList
                                    v-model="form.myths"
                                    label=""
                                    placeholder="Agregar mito..."
                                    add-button-text="Agregar mito"
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
                                <div class="flex items-center gap-2">
                                    <input
                                        id="is_active"
                                        type="checkbox"
                                        :checked="form.is_active"
                                        @change="form.is_active = ($event.target as HTMLInputElement).checked"
                                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                    />
                                    <Label for="is_active">Activo</Label>
                                </div>
                                <div class="space-y-2">
                                    <Label for="sort_order">Orden</Label>
                                    <Input id="sort_order" v-model.number="form.sort_order" type="number" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Imagen</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ImagePicker v-model="form.image" label="" />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Jueces</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <TagsInput v-model="form.judges" label="" placeholder="Agregar juez..." />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Razas participantes</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <TagsInput v-model="form.breeds" label="" placeholder="Agregar raza..." />
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button type="button" variant="outline" @click="$inertia.visit('/cms/events')">
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Crear evento' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
