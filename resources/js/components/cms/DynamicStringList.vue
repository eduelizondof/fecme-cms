<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { GripVertical, Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    modelValue: string[];
    label?: string;
    placeholder?: string;
    addButtonText?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: '',
    placeholder: 'Agregar elemento...',
    addButtonText: 'Agregar',
});

const emit = defineEmits<{
    'update:modelValue': [value: string[]];
}>();

const items = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addItem = () => {
    items.value = [...items.value, ''];
};

const removeItem = (index: number) => {
    const newItems = [...items.value];
    newItems.splice(index, 1);
    items.value = newItems;
};

const updateItem = (index: number, value: string) => {
    const newItems = [...items.value];
    newItems[index] = value;
    items.value = newItems;
};

const moveItem = (fromIndex: number, toIndex: number) => {
    if (toIndex < 0 || toIndex >= items.value.length) return;
    const newItems = [...items.value];
    const [movedItem] = newItems.splice(fromIndex, 1);
    newItems.splice(toIndex, 0, movedItem);
    items.value = newItems;
};
</script>

<template>
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <Label v-if="label">{{ label }}</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="addItem"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                {{ addButtonText }}
            </Button>
        </div>

        <div v-if="items.length === 0" class="text-sm text-muted-foreground py-4 text-center border border-dashed rounded-lg">
            No hay elementos. Haz clic en "{{ addButtonText }}" para comenzar.
        </div>

        <div v-else class="space-y-2">
            <div
                v-for="(item, index) in items"
                :key="index"
                class="flex items-center gap-2 group"
            >
                <div class="flex flex-col gap-0.5 opacity-50 group-hover:opacity-100">
                    <button
                        type="button"
                        class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                        :disabled="index === 0"
                        @click="moveItem(index, index - 1)"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="p-0.5 hover:bg-muted rounded disabled:opacity-30"
                        :disabled="index === items.length - 1"
                        @click="moveItem(index, index + 1)"
                    >
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <span class="text-xs text-muted-foreground w-6 text-center">{{ index + 1 }}</span>

                <Input
                    :model-value="item"
                    @update:model-value="updateItem(index, $event as string)"
                    :placeholder="placeholder"
                    class="flex-1"
                />

                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    class="h-8 w-8 text-muted-foreground hover:text-destructive"
                    @click="removeItem(index)"
                >
                    <Trash2 class="h-4 w-4" />
                </Button>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ items.length }} elemento(s)
        </p>
    </div>
</template>

