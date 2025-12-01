<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Feature {
    title: string;
    description: string;
    icon: string;
}

interface Props {
    modelValue: Feature[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Características',
});

const emit = defineEmits<{
    'update:modelValue': [value: Feature[]];
}>();

const iconOptions = [
    { value: 'icon-check', label: 'Check' },
    { value: 'icon-trace', label: 'Trazabilidad' },
    { value: 'icon-book', label: 'Libro/Educación' },
    { value: 'icon-heart', label: 'Corazón' },
    { value: 'icon-star', label: 'Estrella' },
    { value: 'icon-certificate', label: 'Certificado' },
    { value: 'icon-shield', label: 'Escudo' },
    { value: 'icon-users', label: 'Usuarios' },
];

const features = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addFeature = () => {
    features.value = [...features.value, { title: '', description: '', icon: 'icon-check' }];
};

const removeFeature = (index: number) => {
    const newFeatures = [...features.value];
    newFeatures.splice(index, 1);
    features.value = newFeatures;
};

const updateFeature = (index: number, field: keyof Feature, value: string) => {
    const newFeatures = [...features.value];
    newFeatures[index] = { ...newFeatures[index], [field]: value };
    features.value = newFeatures;
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label v-if="label" class="text-base font-medium">{{ label }}</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="addFeature"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar característica
            </Button>
        </div>

        <div v-if="features.length === 0" class="text-sm text-muted-foreground py-6 text-center border border-dashed rounded-lg">
            <p>No hay características registradas.</p>
            <p class="text-xs mt-1">Agrega las características o beneficios que ofreces.</p>
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="(feature, index) in features"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium">Característica #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeFeature(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-4">
                    <div class="space-y-2 sm:col-span-3">
                        <Label class="text-sm">Título</Label>
                        <Input
                            :model-value="feature.title"
                            @update:model-value="updateFeature(index, 'title', $event as string)"
                            placeholder="Ej: Cumplimiento de Normas Internacionales"
                        />
                    </div>
                    
                    <div class="space-y-2">
                        <Label class="text-sm">Ícono</Label>
                        <Select
                            :model-value="feature.icon"
                            @update:model-value="updateFeature(index, 'icon', $event as string)"
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
                            :model-value="feature.description"
                            @update:model-value="updateFeature(index, 'description', $event as string)"
                            placeholder="Describe esta característica o beneficio..."
                            :rows="2"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ features.length }} característica(s)
        </p>
    </div>
</template>



