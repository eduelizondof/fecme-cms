<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface PricingFeature {
    text: string;
    active: boolean;
}

interface Props {
    modelValue: PricingFeature[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Características del precio',
});

const emit = defineEmits<{
    'update:modelValue': [value: PricingFeature[]];
}>();

const features = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addFeature = () => {
    features.value = [...features.value, { text: '', active: true }];
};

const removeFeature = (index: number) => {
    const newFeatures = [...features.value];
    newFeatures.splice(index, 1);
    features.value = newFeatures;
};

const updateFeature = (index: number, field: keyof PricingFeature, value: any) => {
    const newFeatures = [...features.value];
    newFeatures[index] = { ...newFeatures[index], [field]: value };
    features.value = newFeatures;
};

const moveFeature = (fromIndex: number, toIndex: number) => {
    if (toIndex < 0 || toIndex >= features.value.length) return;
    const newFeatures = [...features.value];
    const [movedFeature] = newFeatures.splice(fromIndex, 1);
    newFeatures.splice(toIndex, 0, movedFeature);
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
                Agregar
            </Button>
        </div>

        <p class="text-sm text-muted-foreground">
            Las características activas se mostrarán con un check, las inactivas con una X.
        </p>

        <div v-if="features.length === 0" class="text-sm text-muted-foreground py-4 text-center border border-dashed rounded-lg">
            No hay características. Haz clic en "Agregar" para comenzar.
        </div>

        <div v-else class="space-y-2">
            <div
                v-for="(feature, index) in features"
                :key="index"
                class="flex items-center gap-3 p-3 border rounded-lg group"
                :class="feature.active ? 'bg-green-50 dark:bg-green-950/20 border-green-200 dark:border-green-900' : 'bg-red-50 dark:bg-red-950/20 border-red-200 dark:border-red-900'"
            >
                <div class="flex flex-col gap-0.5 opacity-50 group-hover:opacity-100">
                    <button
                        type="button"
                        class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                        :disabled="index === 0"
                        @click="moveFeature(index, index - 1)"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                        :disabled="index === features.length - 1"
                        @click="moveFeature(index, index + 1)"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <input 
                        type="checkbox" 
                        :checked="feature.active" 
                        @change="updateFeature(index, 'active', ($event.target as HTMLInputElement).checked)"
                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                    />
                    <span class="text-xs" :class="feature.active ? 'text-green-600' : 'text-red-600'">
                        {{ feature.active ? 'Incluido' : 'No incluido' }}
                    </span>
                </div>

                <Input
                    :model-value="feature.text"
                    @update:model-value="updateFeature(index, 'text', $event)"
                    placeholder="Describe la característica..."
                    class="flex-1"
                />

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
        </div>

        <p class="text-xs text-muted-foreground">
            {{ features.length }} característica(s)
        </p>
    </div>
</template>

