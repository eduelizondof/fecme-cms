<script setup lang="ts">
import DynamicStringList from '@/components/cms/DynamicStringList.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { computed } from 'vue';

interface Featured {
    title: string;
    items: string[];
}

interface Props {
    modelValue: Featured | null;
    label?: string;
    titlePlaceholder?: string;
    itemsLabel?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Características destacadas',
    titlePlaceholder: '¿Por qué elegirnos?',
    itemsLabel: 'Elementos',
});

const emit = defineEmits<{
    'update:modelValue': [value: Featured | null];
}>();

const featured = computed({
    get: () => props.modelValue || {
        title: '',
        items: [],
    },
    set: (value) => emit('update:modelValue', value),
});

const updateField = (field: keyof Featured, value: any) => {
    emit('update:modelValue', { ...featured.value, [field]: value });
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <div class="space-y-2">
            <Label for="featured_title" class="text-sm">Título de la sección</Label>
            <Input
                id="featured_title"
                :model-value="featured.title"
                @update:model-value="updateField('title', $event)"
                :placeholder="titlePlaceholder"
            />
        </div>

        <DynamicStringList
            :model-value="featured.items"
            @update:model-value="updateField('items', $event)"
            :label="itemsLabel"
            placeholder="Agregar característica..."
            add-button-text="Agregar"
        />
    </div>
</template>


