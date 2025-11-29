<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import TagsInput from '@/components/cms/TagsInput.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    city: '',
    photo: '',
    license_type: '',
    categories: [] as string[],
    breeds: [] as string[],
    description: '',
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post('/cms/judges');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Jueces', href: '/cms/judges' },
    { title: 'Crear', href: '/cms/judges/create' },
];
</script>

<template>
    <Head title="Crear Juez - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Crear Juez</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader><CardTitle>Información básica</CardTitle></CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="name">Nombre *</Label>
                                    <Input id="name" v-model="form.name" />
                                </div>

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
                                        <Label for="city">Ciudad</Label>
                                        <Input id="city" v-model="form.city" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="license_type">Tipo de licencia</Label>
                                        <Input id="license_type" v-model="form.license_type" placeholder="CACIB, CACM, Agility, etc." />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="description">Descripción</Label>
                                    <Textarea id="description" v-model="form.description" :rows="4" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader><CardTitle>Categorías y Razas</CardTitle></CardHeader>
                            <CardContent class="space-y-4">
                                <TagsInput v-model="form.categories" label="Categorías" placeholder="Agregar categoría..." />
                                <TagsInput v-model="form.breeds" label="Razas (si aplica)" placeholder="Agregar raza..." />
                            </CardContent>
                        </Card>
                    </div>

                    <div class="space-y-6">
                        <Card>
                            <CardHeader><CardTitle>Publicación</CardTitle></CardHeader>
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
                            <CardHeader><CardTitle>Foto</CardTitle></CardHeader>
                            <CardContent>
                                <ImagePicker v-model="form.photo" label="" />
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button type="button" variant="outline" @click="$inertia.visit('/cms/judges')">Cancelar</Button>
                    <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Guardando...' : 'Crear juez' }}</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

