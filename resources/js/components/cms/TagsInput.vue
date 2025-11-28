<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { X } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    modelValue?: string[];
    label?: string;
    placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    placeholder: 'Agregar etiqueta...',
});

const emit = defineEmits<{
    'update:modelValue': [value: string[]];
}>();

const inputValue = ref('');

const addTag = () => {
    const value = inputValue.value.trim();
    if (value && !props.modelValue.includes(value)) {
        emit('update:modelValue', [...props.modelValue, value]);
        inputValue.value = '';
    }
};

const removeTag = (tag: string) => {
    emit('update:modelValue', props.modelValue.filter(t => t !== tag));
};

const handleKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Enter') {
        event.preventDefault();
        addTag();
    }
};
</script>

<template>
    <div class="space-y-2">
        <Label v-if="label">{{ label }}</Label>
        <div class="flex flex-wrap gap-2 mb-2">
            <Badge
                v-for="tag in modelValue"
                :key="tag"
                variant="secondary"
                class="pr-1"
            >
                {{ tag }}
                <Button
                    variant="ghost"
                    size="icon"
                    class="h-4 w-4 ml-1 hover:bg-transparent"
                    @click="removeTag(tag)"
                >
                    <X class="h-3 w-3" />
                </Button>
            </Badge>
        </div>
        <div class="flex gap-2">
            <Input
                v-model="inputValue"
                :placeholder="placeholder"
                @keydown="handleKeydown"
            />
            <Button type="button" variant="outline" @click="addTag">
                Agregar
            </Button>
        </div>
    </div>
</template>

