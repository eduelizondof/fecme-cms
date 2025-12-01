<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Plus, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

interface WorkingSchedule {
    id?: number;
    day: string;
    hours: string;
    is_holiday: boolean;
    display_order: number;
    is_active: boolean;
}

interface ContactInfo {
    id?: number;
    icon_class: string;
    title: string;
    description: string;
    link: string | null;
    is_external: boolean;
    display_order: number;
    is_active: boolean;
}

interface FeaturesAreaContent {
    id: number;
    working_hours_background: string | null;
    working_hours_title: string;
    working_hours_description: string | null;
    is_open_now: boolean;
    subtitle: string;
    title: string;
    description: string | null;
    slogan: string | null;
    schedules: WorkingSchedule[];
    contact_info: ContactInfo[];
}

const props = defineProps<{
    featuresArea: FeaturesAreaContent;
}>();

const form = useForm({
    working_hours_background: props.featuresArea.working_hours_background || '',
    working_hours_title: props.featuresArea.working_hours_title || 'Horario',
    working_hours_description: props.featuresArea.working_hours_description || '',
    is_open_now: props.featuresArea.is_open_now !== undefined ? props.featuresArea.is_open_now : true,
    subtitle: props.featuresArea.subtitle || 'Contacto',
    title: props.featuresArea.title || 'Información de Contacto',
    description: props.featuresArea.description || '',
    slogan: props.featuresArea.slogan || '',
});

const schedules = ref<WorkingSchedule[]>([...props.featuresArea.schedules]);
const contactInfo = ref<ContactInfo[]>([...props.featuresArea.contact_info]);

const daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

const availableIconClasses = [
    'icon-placeholder',
    'icon-phone-call',
    'icon-envelope',
    'fa fa-instagram',
    'fa fa-facebook',
    'fa fa-twitter',
    'fa fa-youtube',
    'fa fa-linkedin',
    'fa fa-whatsapp',
    'fa fa-telegram',
];

const addSchedule = () => {
    schedules.value.push({
        day: 'Lunes',
        hours: '',
        is_holiday: false,
        display_order: schedules.value.length,
        is_active: true,
    });
};

const removeSchedule = (index: number) => {
    const schedule = schedules.value[index];
    if (schedule.id) {
        useForm({}).delete(`/cms/features-area/schedules/${schedule.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                schedules.value.splice(index, 1);
            },
        });
    } else {
        schedules.value.splice(index, 1);
    }
};

const saveSchedule = async (index: number) => {
    const schedule = schedules.value[index];
    if (schedule.id) {
        useForm(schedule).put(`/cms/features-area/schedules/${schedule.id}`, {
            preserveScroll: true,
        });
    } else {
        useForm(schedule).post('/cms/features-area/schedules', {
            preserveScroll: true,
            onSuccess: () => {
                window.location.reload();
            },
        });
    }
};

const addContactInfo = () => {
    contactInfo.value.push({
        icon_class: 'icon-placeholder',
        title: '',
        description: '',
        link: null,
        is_external: false,
        display_order: contactInfo.value.length,
        is_active: true,
    });
};

const removeContactInfo = (index: number) => {
    const contact = contactInfo.value[index];
    if (contact.id) {
        useForm({}).delete(`/cms/features-area/contact-info/${contact.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                contactInfo.value.splice(index, 1);
            },
        });
    } else {
        contactInfo.value.splice(index, 1);
    }
};

const saveContactInfo = async (index: number) => {
    const contact = contactInfo.value[index];
    if (contact.id) {
        useForm(contact).put(`/cms/features-area/contact-info/${contact.id}`, {
            preserveScroll: true,
        });
    } else {
        useForm(contact).post('/cms/features-area/contact-info', {
            preserveScroll: true,
            onSuccess: () => {
                window.location.reload();
            },
        });
    }
};

const submit = () => {
    form.put('/cms/features-area');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Nosotros', href: '/cms/about' },
    { title: 'Área de características', href: '/cms/features-area' },
];
</script>

<template>
    <Head title="Área de Características - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Área de Características</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información general</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="subtitle">Subtítulo</Label>
                                    <Input
                                        id="subtitle"
                                        v-model="form.subtitle"
                                        placeholder="Ej: Contacto"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <Label for="title">Título</Label>
                                    <Input
                                        id="title"
                                        v-model="form.title"
                                        placeholder="Ej: Información de Contacto"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <Label for="description">Descripción</Label>
                                    <Textarea
                                        id="description"
                                        v-model="form.description"
                                        placeholder="Descripción..."
                                        :rows="4"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <Label for="slogan">Eslogan</Label>
                                    <Input
                                        id="slogan"
                                        v-model="form.slogan"
                                        placeholder="Ej: VAMOS MÉXICO!!!"
                                    />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Horarios de trabajo</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="working_hours_title">Título del horario</Label>
                                    <Input
                                        id="working_hours_title"
                                        v-model="form.working_hours_title"
                                        placeholder="Ej: Horario"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <Label for="working_hours_description">Descripción del horario</Label>
                                    <Input
                                        id="working_hours_description"
                                        v-model="form.working_hours_description"
                                        placeholder="Ej: Consulta nuestros horarios de atención"
                                    />
                                </div>
                                <div class="flex items-center justify-between">
                                    <Label for="is_open_now">Abierto ahora</Label>
                                    <Switch
                                        id="is_open_now"
                                        :checked="form.is_open_now"
                                        @update:checked="form.is_open_now = $event"
                                    />
                                </div>

                                <div class="space-y-4">
                                    <div
                                        v-for="(schedule, index) in schedules"
                                        :key="index"
                                        class="flex gap-4 items-start p-4 border rounded-lg"
                                    >
                                        <div class="flex-1 grid gap-4 sm:grid-cols-2">
                                            <div class="space-y-2">
                                                <Label>Día</Label>
                                                <Select
                                                    :model-value="schedule.day"
                                                    @update:model-value="schedule.day = $event"
                                                >
                                                    <SelectTrigger>
                                                        <SelectValue />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        <SelectItem
                                                            v-for="day in daysOfWeek"
                                                            :key="day"
                                                            :value="day"
                                                        >
                                                            {{ day }}
                                                        </SelectItem>
                                                    </SelectContent>
                                                </Select>
                                            </div>
                                            <div class="space-y-2">
                                                <Label>Horas</Label>
                                                <Input
                                                    v-model="schedule.hours"
                                                    placeholder="Ej: 10:00 a. m. - 6:00 p. m."
                                                />
                                            </div>
                                            <div class="flex items-center gap-4 sm:col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <Switch
                                                        :checked="schedule.is_holiday"
                                                        @update:checked="schedule.is_holiday = $event"
                                                    />
                                                    <Label>Es día festivo</Label>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <Switch
                                                        :checked="schedule.is_active"
                                                        @update:checked="schedule.is_active = $event"
                                                    />
                                                    <Label>Activo</Label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <Button
                                                type="button"
                                                size="icon"
                                                variant="outline"
                                                @click="saveSchedule(index)"
                                            >
                                                Guardar
                                            </Button>
                                            <Button
                                                type="button"
                                                size="icon"
                                                variant="destructive"
                                                @click="removeSchedule(index)"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        class="w-full"
                                        @click="addSchedule"
                                    >
                                        <Plus class="mr-2 h-4 w-4" />
                                        Agregar horario
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Información de contacto</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div
                                    v-for="(contact, index) in contactInfo"
                                    :key="index"
                                    class="flex gap-4 items-start p-4 border rounded-lg"
                                >
                                    <div class="flex-1 grid gap-4 sm:grid-cols-2">
                                        <div class="space-y-2">
                                            <Label>Icono</Label>
                                            <Select
                                                :model-value="contact.icon_class"
                                                @update:model-value="contact.icon_class = $event"
                                            >
                                                <SelectTrigger>
                                                    <SelectValue />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem
                                                        v-for="icon in availableIconClasses"
                                                        :key="icon"
                                                        :value="icon"
                                                    >
                                                        {{ icon }}
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <div class="space-y-2">
                                            <Label>Título</Label>
                                            <Input
                                                v-model="contact.title"
                                                placeholder="Ej: Dirección"
                                            />
                                        </div>
                                        <div class="space-y-2 sm:col-span-2">
                                            <Label>Descripción</Label>
                                            <Input
                                                v-model="contact.description"
                                                placeholder="Ej: Colonia Ladron de Gevara., Guadalajara, Mexico"
                                            />
                                        </div>
                                        <div class="space-y-2 sm:col-span-2">
                                            <Label>Enlace (opcional)</Label>
                                            <Input
                                                v-model="contact.link"
                                                type="url"
                                                placeholder="https://..."
                                            />
                                        </div>
                                        <div class="flex items-center gap-4 sm:col-span-2">
                                            <div class="flex items-center gap-2">
                                                <Switch
                                                    :checked="contact.is_external"
                                                    @update:checked="contact.is_external = $event"
                                                />
                                                <Label>Enlace externo</Label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <Switch
                                                    :checked="contact.is_active"
                                                    @update:checked="contact.is_active = $event"
                                                />
                                                <Label>Activo</Label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <Button
                                            type="button"
                                            size="icon"
                                            variant="outline"
                                            @click="saveContactInfo(index)"
                                        >
                                            Guardar
                                        </Button>
                                        <Button
                                            type="button"
                                            size="icon"
                                            variant="destructive"
                                            @click="removeContactInfo(index)"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </div>
                                <Button
                                    type="button"
                                    variant="outline"
                                    class="w-full"
                                    @click="addContactInfo"
                                >
                                    <Plus class="mr-2 h-4 w-4" />
                                    Agregar contacto
                                </Button>
                            </CardContent>
                        </Card>
                    </div>

                    <div class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Imagen de fondo</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ImagePicker
                                    v-model="form.working_hours_background"
                                    label=""
                                />
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

