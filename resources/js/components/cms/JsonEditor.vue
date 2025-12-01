<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { AlertCircle, Check } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

interface Props {
    modelValue?: any;
    label?: string;
    rows?: number;
    placeholder?: string;
}

const props = withDefaults(defineProps<Props>(), {
    rows: 6,
    placeholder: '{}',
});

const emit = defineEmits<{
    'update:modelValue': [value: any];
}>();

const textValue = ref('');
const jsonError = ref<string | null>(null);
const isValid = ref(true);

// Convert value to JSON string for display
const updateTextFromValue = () => {
    try {
        textValue.value = props.modelValue 
            ? JSON.stringify(props.modelValue, null, 2) 
            : '';
        jsonError.value = null;
        isValid.value = true;
    } catch (e) {
        textValue.value = String(props.modelValue || '');
    }
};

watch(() => props.modelValue, updateTextFromValue, { immediate: true });

const handleInput = (event: Event) => {
    const value = (event.target as HTMLTextAreaElement).value;
    textValue.value = value;
    
    if (!value.trim()) {
        emit('update:modelValue', null);
        jsonError.value = null;
        isValid.value = true;
        return;
    }

    try {
        const parsed = JSON.parse(value);
        emit('update:modelValue', parsed);
        jsonError.value = null;
        isValid.value = true;
    } catch (e: any) {
        jsonError.value = e.message;
        isValid.value = false;
    }
};

const formatJson = () => {
    if (!textValue.value.trim()) return;
    try {
        const parsed = JSON.parse(textValue.value);
        textValue.value = JSON.stringify(parsed, null, 2);
        emit('update:modelValue', parsed);
        jsonError.value = null;
        isValid.value = true;
    } catch (e) {
        // Keep error state
    }
};
</script>

<template>
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <Label v-if="label">{{ label }}</Label>
            <div class="flex items-center gap-2">
                <span 
                    v-if="textValue.trim()"
                    class="flex items-center gap-1 text-xs"
                    :class="isValid ? 'text-green-600' : 'text-destructive'"
                >
                    <Check v-if="isValid" class="h-3 w-3" />
                    <AlertCircle v-else class="h-3 w-3" />
                    {{ isValid ? 'JSON válido' : 'JSON inválido' }}
                </span>
                <Button 
                    type="button"
                    variant="ghost" 
                    size="sm"
                    @click="formatJson"
                    :disabled="!isValid"
                >
                    Formatear
                </Button>
            </div>
        </div>
        <Textarea
            :value="textValue"
            @input="handleInput"
            :rows="rows"
            :placeholder="placeholder"
            class="font-mono text-sm"
            :class="{ 'border-destructive': !isValid }"
        />
        <p v-if="jsonError" class="text-xs text-destructive">
            {{ jsonError }}
        </p>
    </div>
</template>


