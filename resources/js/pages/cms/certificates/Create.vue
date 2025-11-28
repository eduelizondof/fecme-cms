<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import JsonEditor from '@/components/cms/JsonEditor.vue';
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
    microchip: '',
    registration_number: '',
    name: '',
    breed: '',
    variety: '',
    sex: 'MACHO',
    color: '',
    birth_place: '',
    birth_date: '',
    image: '',
    valid: true,
    certificate_number: '',
    certificate_date: '',
    breeder: '',
    owner: '',
    co_owner: '',
    address: '',
    zip_code: '',
    neighborhood: '',
    city: '',
    phone: '',
    titles: [] as string[],
    observations: '',
    status: 'VIGENTE',
    is_active: true,
});

const submit = () => {
    form.post('/cms/certificates');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Certificados', href: '/cms/certificates' },
    { title: 'Crear', href: '/cms/certificates/create' },
];
</script>

<template>
    <Head title="Crear Certificado - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Crear Certificado</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información del ejemplar</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="microchip">Microchip *</Label>
                                        <Input id="microchip" v-model="form.microchip" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="registration_number">No. Registro *</Label>
                                        <Input id="registration_number" v-model="form.registration_number" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="name">Nombre *</Label>
                                    <Input id="name" v-model="form.name" />
                                </div>

                                <div class="grid gap-4 sm:grid-cols-3">
                                    <div class="space-y-2">
                                        <Label for="breed">Raza</Label>
                                        <Input id="breed" v-model="form.breed" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="variety">Variedad</Label>
                                        <Input id="variety" v-model="form.variety" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="sex">Sexo</Label>
                                        <Select v-model="form.sex">
                                            <SelectTrigger>
                                                <SelectValue placeholder="Seleccionar" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="MACHO">Macho</SelectItem>
                                                <SelectItem value="HEMBRA">Hembra</SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-3">
                                    <div class="space-y-2">
                                        <Label for="color">Color</Label>
                                        <Input id="color" v-model="form.color" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="birth_place">Lugar de nacimiento</Label>
                                        <Input id="birth_place" v-model="form.birth_place" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="birth_date">Fecha de nacimiento</Label>
                                        <Input id="birth_date" v-model="form.birth_date" type="date" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Información del certificado</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="certificate_number">No. Certificado</Label>
                                        <Input id="certificate_number" v-model="form.certificate_number" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="certificate_date">Fecha de certificación</Label>
                                        <Input id="certificate_date" v-model="form.certificate_date" type="date" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="breeder">Criador</Label>
                                    <Input id="breeder" v-model="form.breeder" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Información del propietario</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="owner">Propietario</Label>
                                        <Input id="owner" v-model="form.owner" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="co_owner">Co-propietario</Label>
                                        <Input id="co_owner" v-model="form.co_owner" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="address">Dirección</Label>
                                    <Input id="address" v-model="form.address" />
                                </div>

                                <div class="grid gap-4 sm:grid-cols-3">
                                    <div class="space-y-2">
                                        <Label for="neighborhood">Colonia</Label>
                                        <Input id="neighborhood" v-model="form.neighborhood" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="city">Ciudad</Label>
                                        <Input id="city" v-model="form.city" />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="zip_code">C.P.</Label>
                                        <Input id="zip_code" v-model="form.zip_code" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="phone">Teléfono</Label>
                                    <Input id="phone" v-model="form.phone" />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Títulos y observaciones</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <JsonEditor v-model="form.titles" label="Títulos" :rows="4" placeholder='["Título 1", "Título 2"]' />

                                <div class="space-y-2">
                                    <Label for="observations">Observaciones</Label>
                                    <Textarea id="observations" v-model="form.observations" :rows="3" />
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <div class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Estado</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <Label>Activo</Label>
                                    <Switch :checked="form.is_active" @update:checked="form.is_active = $event" />
                                </div>
                                <div class="flex items-center justify-between">
                                    <Label>Válido</Label>
                                    <Switch :checked="form.valid" @update:checked="form.valid = $event" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="status">Estado del certificado</Label>
                                    <Select v-model="form.status">
                                        <SelectTrigger>
                                            <SelectValue placeholder="Seleccionar" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="VIGENTE">Vigente</SelectItem>
                                            <SelectItem value="VENCIDO">Vencido</SelectItem>
                                            <SelectItem value="CANCELADO">Cancelado</SelectItem>
                                        </SelectContent>
                                    </Select>
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
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button type="button" variant="outline" @click="$inertia.visit('/cms/certificates')">
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Crear certificado' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

