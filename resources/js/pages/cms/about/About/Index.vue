<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Plus, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

interface AboutFeature {
    id?: number;
    icon: string;
    color: 'red' | 'green' | 'orange' | 'blues';
    label: string;
    display_order: number;
}

interface AboutContent {
    id: number;
    background_image: string | null;
    main_image: string | null;
    main_image_alt: string | null;
    subtitle: string | null;
    title: string | null;
    description: string | null;
    experience_from: number;
    experience_to: number;
    experience_speed: number;
    experience_initial_value: number;
    experience_label: string;
    features: AboutFeature[];
}

const props = defineProps<{
    about: AboutContent;
}>();

const form = useForm({
    background_image: props.about.background_image || '',
    main_image: props.about.main_image || '',
    main_image_alt: props.about.main_image_alt || '',
    subtitle: props.about.subtitle || '',
    title: props.about.title || '',
    description: props.about.description || '',
    experience_from: props.about.experience_from || 400,
    experience_to: props.about.experience_to || 416,
    experience_speed: props.about.experience_speed || 5000,
    experience_initial_value: props.about.experience_initial_value || 416,
    experience_label: props.about.experience_label || '+e Razas',
});

const features = ref<AboutFeature[]>([...props.about.features]);

const availableIcons = [
    'flaticon-verified',
    'flaticon-certification',
    'flaticon-worldwide',
    'flaticon-people',
    'flaticon-shield',
    'flaticon-award',
    'flaticon-star',
];

const availableColors = ['red', 'green', 'orange', 'blues'] as const;

const addFeature = () => {
    features.value.push({
        icon: 'flaticon-verified',
        color: 'orange',
        label: '',
        display_order: features.value.length,
    });
};

const removeFeature = (index: number) => {
    const feature = features.value[index];
    if (feature.id) {
        // Si tiene ID, eliminarlo del servidor
        useForm({}).delete(`/cms/about/features/${feature.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                features.value.splice(index, 1);
            },
        });
    } else {
        // Si no tiene ID, solo eliminarlo localmente
        features.value.splice(index, 1);
    }
};

const saveFeature = async (index: number) => {
    const feature = features.value[index];
    if (feature.id) {
        // Actualizar
        useForm(feature).put(`/cms/about/features/${feature.id}`, {
            preserveScroll: true,
        });
    } else {
        // Crear
        useForm(feature).post('/cms/about/features', {
            preserveScroll: true,
            onSuccess: () => {
                // Recargar la página para obtener los IDs actualizados
                window.location.reload();
            },
        });
    }
};

const submit = () => {
    form.put('/cms/about');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Nosotros', href: '/cms/about' },
];
</script>

<template>
    <Head title="Nosotros - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Contenido - Nosotros</h2>
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
                                    <Label for="subtitle">Subtítulo</Label>
                                    <Input
                                        id="subtitle"
                                        v-model="form.subtitle"
                                        placeholder="Ej: Nosotros"
                                    />
                                </div>

                                <div class="space-y-2">
                                    <Label for="title">Título</Label>
                                    <Textarea
                                        id="title"
                                        v-model="form.title"
                                        placeholder="Ej: ¿Quiénes Somos?<br />FECME gt Internacional"
                                        :rows="2"
                                    />
                                    <p class="text-xs text-muted-foreground">
                                        Puedes usar HTML como &lt;br /&gt; para saltos de línea
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="description">Descripción</Label>
                                    <Textarea
                                        id="description"
                                        v-model="form.description"
                                        placeholder="Descripción completa..."
                                        :rows="8"
                                    />
                                    <p class="text-xs text-muted-foreground">
                                        Usa saltos de línea para separar párrafos
                                    </p>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Contador de experiencia</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="experience_from">Desde</Label>
                                        <Input
                                            id="experience_from"
                                            v-model.number="form.experience_from"
                                            type="number"
                                        />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="experience_to">Hasta</Label>
                                        <Input
                                            id="experience_to"
                                            v-model.number="form.experience_to"
                                            type="number"
                                        />
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="experience_speed">Velocidad (ms)</Label>
                                        <Input
                                            id="experience_speed"
                                            v-model.number="form.experience_speed"
                                            type="number"
                                        />
                                    </div>
                                    <div class="space-y-2">
                                        <Label for="experience_initial_value">Valor inicial</Label>
                                        <Input
                                            id="experience_initial_value"
                                            v-model.number="form.experience_initial_value"
                                            type="number"
                                        />
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <Label for="experience_label">Etiqueta</Label>
                                    <Input
                                        id="experience_label"
                                        v-model="form.experience_label"
                                        placeholder="Ej: +e Razas"
                                    />
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Características</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div
                                    v-for="(feature, index) in features"
                                    :key="index"
                                    class="flex gap-4 items-start p-4 border rounded-lg"
                                >
                                    <div class="flex-1 grid gap-4 sm:grid-cols-2">
                                        <div class="space-y-2">
                                            <Label>Icono</Label>
                                            <Select
                                                :model-value="feature.icon"
                                                @update:model-value="feature.icon = $event"
                                            >
                                                <SelectTrigger>
                                                    <SelectValue />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem
                                                        v-for="icon in availableIcons"
                                                        :key="icon"
                                                        :value="icon"
                                                    >
                                                        {{ icon }}
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <div class="space-y-2">
                                            <Label>Color</Label>
                                            <Select
                                                :model-value="feature.color"
                                                @update:model-value="feature.color = $event"
                                            >
                                                <SelectTrigger>
                                                    <SelectValue />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem
                                                        v-for="color in availableColors"
                                                        :key="color"
                                                        :value="color"
                                                    >
                                                        {{ color }}
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <div class="space-y-2 sm:col-span-2">
                                            <Label>Etiqueta</Label>
                                            <Input
                                                v-model="feature.label"
                                                placeholder="Ej: Organización Legalmente Constituida"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <Button
                                            type="button"
                                            size="icon"
                                            variant="outline"
                                            @click="saveFeature(index)"
                                        >
                                            Guardar
                                        </Button>
                                        <Button
                                            type="button"
                                            size="icon"
                                            variant="destructive"
                                            @click="removeFeature(index)"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </div>
                                <Button
                                    type="button"
                                    variant="outline"
                                    class="w-full"
                                    @click="addFeature"
                                >
                                    <Plus class="mr-2 h-4 w-4" />
                                    Agregar característica
                                </Button>
                            </CardContent>
                        </Card>
                    </div>

                    <div class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Imágenes</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label>Imagen de fondo</Label>
                                    <ImagePicker
                                        v-model="form.background_image"
                                        label=""
                                    />
                                </div>
                                <div class="space-y-2">
                                    <Label>Imagen principal</Label>
                                    <ImagePicker
                                        v-model="form.main_image"
                                        label=""
                                    />
                                </div>
                                <div class="space-y-2">
                                    <Label for="main_image_alt">Texto alternativo</Label>
                                    <Input
                                        id="main_image_alt"
                                        v-model="form.main_image_alt"
                                        placeholder="Texto alternativo para la imagen"
                                    />
                                </div>
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

