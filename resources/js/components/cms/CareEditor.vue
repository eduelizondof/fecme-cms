<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface CareSection {
    title: string;
    description: string;
    icon: string;
}

interface Care {
    title: string;
    sections: CareSection[];
}

interface Props {
    modelValue: Care | null;
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Cuidados',
});

const emit = defineEmits<{
    'update:modelValue': [value: Care | null];
}>();

const iconOptions = [
    { value: 'icon-food', label: 'Alimentación' },
    { value: 'icon-health', label: 'Salud' },
    { value: 'icon-social', label: 'Socialización' },
    { value: 'icon-home', label: 'Hogar' },
    { value: 'icon-training', label: 'Entrenamiento' },
    { value: 'icon-grooming', label: 'Aseo' },
    { value: 'icon-exercise', label: 'Ejercicio' },
];

const care = computed({
    get: () => props.modelValue || {
        title: 'Nuestros Cuidados',
        sections: [],
    },
    set: (value) => emit('update:modelValue', value),
});

const updateTitle = (value: string) => {
    emit('update:modelValue', { ...care.value, title: value });
};

const addSection = () => {
    const newSections = [...care.value.sections, { title: '', description: '', icon: 'icon-food' }];
    emit('update:modelValue', { ...care.value, sections: newSections });
};

const removeSection = (index: number) => {
    const newSections = [...care.value.sections];
    newSections.splice(index, 1);
    emit('update:modelValue', { ...care.value, sections: newSections });
};

const updateSection = (index: number, field: keyof CareSection, value: string) => {
    const newSections = [...care.value.sections];
    newSections[index] = { ...newSections[index], [field]: value };
    emit('update:modelValue', { ...care.value, sections: newSections });
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <div class="space-y-2">
            <Label for="care_title" class="text-sm">Título de la sección</Label>
            <Input
                id="care_title"
                :model-value="care.title"
                @update:model-value="updateTitle($event as string)"
                placeholder="Nuestros Cuidados"
            />
        </div>

        <div class="flex items-center justify-between">
            <Label class="text-sm">Secciones de cuidados</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="addSection"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar sección
            </Button>
        </div>

        <div v-if="care.sections.length === 0" class="text-sm text-muted-foreground py-4 text-center border border-dashed rounded-lg">
            No hay secciones de cuidados. Agrega información sobre alimentación, salud, etc.
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="(section, index) in care.sections"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium">Sección #{{ index + 1 }}</span>
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
                        <Label class="text-sm">Título</Label>
                        <Input
                            :model-value="section.title"
                            @update:model-value="updateSection(index, 'title', $event as string)"
                            placeholder="Ej: Alimentación"
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
                            placeholder="Describe los cuidados que proporcionas..."
                            :rows="2"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ care.sections.length }} sección(es) de cuidados
        </p>
    </div>
</template>


