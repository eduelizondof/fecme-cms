<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { computed } from 'vue';

interface Cost {
    hasCost: boolean;
    amount: number;
    currency: string;
    description: string;
}

interface Props {
    modelValue: Cost | null;
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Información de costo',
});

const emit = defineEmits<{
    'update:modelValue': [value: Cost | null];
}>();

const cost = computed({
    get: () => props.modelValue || {
        hasCost: false,
        amount: 0,
        currency: 'MXN',
        description: '',
    },
    set: (value) => emit('update:modelValue', value),
});

const updateField = (field: keyof Cost, value: any) => {
    emit('update:modelValue', { ...cost.value, [field]: value });
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <div class="flex items-center justify-between p-4 border rounded-lg bg-muted/30">
            <div>
                <Label for="has_cost" class="font-medium">¿Tiene costo?</Label>
                <p class="text-sm text-muted-foreground">Indica si este servicio/trámite tiene un costo asociado</p>
            </div>
            <div class="flex items-center gap-2">
                <input 
                    id="has_cost"
                    type="checkbox" 
                    :checked="cost.hasCost" 
                    @change="updateField('hasCost', ($event.target as HTMLInputElement).checked)"
                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                />
                <span class="text-xs text-muted-foreground">
                    {{ cost.hasCost ? 'Sí' : 'No' }}
                </span>
            </div>
        </div>

        <div v-if="cost.hasCost" class="space-y-4 p-4 border rounded-lg">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="space-y-2">
                    <Label for="amount">Monto</Label>
                    <Input
                        id="amount"
                        type="number"
                        min="0"
                        step="0.01"
                        :model-value="cost.amount"
                        @update:model-value="updateField('amount', Number($event) || 0)"
                        placeholder="0.00"
                    />
                </div>
                <div class="space-y-2">
                    <Label for="currency">Moneda</Label>
                    <Input
                        id="currency"
                        :model-value="cost.currency"
                        @update:model-value="updateField('currency', $event)"
                        placeholder="MXN"
                    />
                </div>
            </div>
        </div>

        <div class="space-y-2">
            <Label for="cost_description">Descripción del costo</Label>
            <Textarea
                id="cost_description"
                :model-value="cost.description"
                @update:model-value="updateField('description', $event)"
                :rows="2"
                placeholder="Describe qué incluye el costo (ej: Incluye registro, certificación y envío físico)"
            />
        </div>
    </div>
</template>

