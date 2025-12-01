<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { computed } from 'vue';

interface InscriptionInfo {
    deadline: string;
    price: number;
    currency: string;
    onlineUrl?: string;
    contactEmail: string;
    contactPhone: string;
}

interface Props {
    modelValue: InscriptionInfo | null;
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Información de inscripción',
});

const emit = defineEmits<{
    'update:modelValue': [value: InscriptionInfo | null];
}>();

const info = computed({
    get: () => props.modelValue || {
        deadline: '',
        price: 0,
        currency: 'MXN',
        onlineUrl: '',
        contactEmail: '',
        contactPhone: '',
    },
    set: (value) => emit('update:modelValue', value),
});

const updateField = (field: keyof InscriptionInfo, value: any) => {
    emit('update:modelValue', { ...info.value, [field]: value });
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="space-y-2">
                <Label for="deadline" class="text-sm">Fecha límite de inscripción</Label>
                <Input
                    id="deadline"
                    type="date"
                    :model-value="info.deadline"
                    @update:model-value="updateField('deadline', $event)"
                />
            </div>
            <div class="space-y-2">
                <Label for="price" class="text-sm">Precio</Label>
                <Input
                    id="price"
                    type="number"
                    min="0"
                    :model-value="info.price"
                    @update:model-value="updateField('price', Number($event) || 0)"
                    placeholder="0"
                />
            </div>
            <div class="space-y-2">
                <Label for="currency" class="text-sm">Moneda</Label>
                <Input
                    id="currency"
                    :model-value="info.currency"
                    @update:model-value="updateField('currency', $event)"
                    placeholder="MXN"
                />
            </div>
        </div>

        <div class="space-y-2">
            <Label for="onlineUrl" class="text-sm">URL de inscripción en línea (opcional)</Label>
            <Input
                id="onlineUrl"
                :model-value="info.onlineUrl || ''"
                @update:model-value="updateField('onlineUrl', $event)"
                placeholder="https://ejemplo.com/inscripcion"
            />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="space-y-2">
                <Label for="contactEmail" class="text-sm">Email de contacto</Label>
                <Input
                    id="contactEmail"
                    type="email"
                    :model-value="info.contactEmail"
                    @update:model-value="updateField('contactEmail', $event)"
                    placeholder="inscripciones@ejemplo.com"
                />
            </div>
            <div class="space-y-2">
                <Label for="contactPhone" class="text-sm">Teléfono de contacto</Label>
                <Input
                    id="contactPhone"
                    :model-value="info.contactPhone"
                    @update:model-value="updateField('contactPhone', $event)"
                    placeholder="+52 33 1234-5678"
                />
            </div>
        </div>
    </div>
</template>


