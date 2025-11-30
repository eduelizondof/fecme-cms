<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { computed } from 'vue';

interface CtaButtonData {
    label?: string;
    href?: string;
    enabled?: boolean;
}

interface Props {
    modelValue?: CtaButtonData | null;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => ({ label: '', href: '', enabled: true }),
});

const emit = defineEmits<{
    'update:modelValue': [value: CtaButtonData];
}>();

const ctaButton = computed({
    get: () => {
        const defaultVal = { label: '', href: '', enabled: true };
        return props.modelValue || defaultVal;
    },
    set: (value) => {
        // Asegurar que nunca se emita null
        emit('update:modelValue', value || { label: '', href: '', enabled: true });
    },
});

const updateField = (field: keyof CtaButtonData, value: string | boolean) => {
    ctaButton.value = { ...ctaButton.value, [field]: value };
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center gap-2">
            <Checkbox
                id="cta-enabled"
                :checked="ctaButton.enabled"
                @update:checked="updateField('enabled', $event)"
            />
            <Label for="cta-enabled" class="cursor-pointer">Habilitar botón</Label>
        </div>

        <div class="space-y-2">
            <Label for="cta-label">Texto del botón *</Label>
            <Input
                id="cta-label"
                :model-value="ctaButton.label"
                placeholder="Validar certificado"
                @update:model-value="updateField('label', $event as string)"
            />
        </div>

        <div class="space-y-2">
            <Label for="cta-href">Enlace (href) *</Label>
            <Input
                id="cta-href"
                :model-value="ctaButton.href"
                placeholder="/validar-certificado"
                @update:model-value="updateField('href', $event as string)"
            />
        </div>
    </div>
</template>
