<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface FacilitySection {
    title: string;
    description: string;
    icon: string;
}

interface Facilities {
    title: string;
    sections: FacilitySection[];
}

interface Props {
    modelValue: Facilities | null;
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Instalaciones',
});

const emit = defineEmits<{
    'update:modelValue': [value: Facilities | null];
}>();

const iconOptions = [
    { value: 'icon-training', label: 'Entrenamiento' },
    { value: 'icon-social', label: 'Socialización' },
    { value: 'icon-health', label: 'Salud' },
    { value: 'icon-parking', label: 'Estacionamiento' },
    { value: 'icon-pool', label: 'Piscina' },
    { value: 'icon-playground', label: 'Área de juegos' },
    { value: 'icon-shop', label: 'Tienda' },
    { value: 'icon-cafe', label: 'Cafetería' },
];

const facilities = computed({
    get: () => props.modelValue || {
        title: 'Nuestras Instalaciones',
        sections: [],
    },
    set: (value) => emit('update:modelValue', value),
});

const updateTitle = (value: string) => {
    emit('update:modelValue', { ...facilities.value, title: value });
};

const addSection = () => {
    const newSections = [...facilities.value.sections, { title: '', description: '', icon: 'icon-training' }];
    emit('update:modelValue', { ...facilities.value, sections: newSections });
};

const removeSection = (index: number) => {
    const newSections = [...facilities.value.sections];
    newSections.splice(index, 1);
    emit('update:modelValue', { ...facilities.value, sections: newSections });
};

const updateSection = (index: number, field: keyof FacilitySection, value: string) => {
    const newSections = [...facilities.value.sections];
    newSections[index] = { ...newSections[index], [field]: value };
    emit('update:modelValue', { ...facilities.value, sections: newSections });
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <div class="space-y-2">
            <Label for="facilities_title" class="text-sm">Título de la sección</Label>
            <Input
                id="facilities_title"
                :model-value="facilities.title"
                @update:model-value="updateTitle($event as string)"
                placeholder="Nuestras Instalaciones"
            />
        </div>

        <div class="flex items-center justify-between">
            <Label class="text-sm">Áreas / Instalaciones</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="addSection"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar área
            </Button>
        </div>

        <div v-if="facilities.sections.length === 0" class="text-sm text-muted-foreground py-4 text-center border border-dashed rounded-lg">
            No hay áreas registradas. Describe las instalaciones que ofreces.
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="(section, index) in facilities.sections"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium">Área #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeSection(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-4">
                    <div class="space-y-2 sm:col-span-3">
                        <Label class="text-sm">Nombre del área</Label>
                        <Input
                            :model-value="section.title"
                            @update:model-value="updateSection(index, 'title', $event as string)"
                            placeholder="Ej: Canchas de Entrenamiento"
                        />
                    </div>
                    
                    <div class="space-y-2">
                        <Label class="text-sm">Ícono</Label>
                        <Select
                            :model-value="section.icon"
                            @update:model-value="updateSection(index, 'icon', $event as string)"
                        >
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem 
                                    v-for="icon in iconOptions" 
                                    :key="icon.value" 
                                    :value="icon.value"
                                >
                                    {{ icon.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div class="space-y-2 sm:col-span-4">
                        <Label class="text-sm">Descripción</Label>
                        <Textarea
                            :model-value="section.description"
                            @update:model-value="updateSection(index, 'description', $event as string)"
                            placeholder="Describe esta área o instalación..."
                            :rows="2"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ facilities.sections.length }} área(s)
        </p>
    </div>
</template>



