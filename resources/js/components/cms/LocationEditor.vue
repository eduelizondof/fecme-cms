<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { computed } from 'vue';

interface Location {
    name?: string;
    city?: string;
    state?: string;
    country?: string;
    fullAddress?: string;
    address?: string;
    mapUrl?: string;
}

interface Props {
    modelValue: Location | null;
    label?: string;
    showName?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Ubicación',
    showName: false,
});

const emit = defineEmits<{
    'update:modelValue': [value: Location | null];
}>();

const location = computed({
    get: () => props.modelValue || {
        name: '',
        city: '',
        state: '',
        country: 'México',
        fullAddress: '',
        address: '',
        mapUrl: '',
    },
    set: (value) => emit('update:modelValue', value),
});

const updateField = (field: keyof Location, value: string) => {
    const newLocation = { ...location.value, [field]: value };
    
    // Auto-generate fullAddress if individual fields are filled
    if (['city', 'state', 'country'].includes(field)) {
        const parts = [newLocation.city, newLocation.state, newLocation.country].filter(Boolean);
        newLocation.fullAddress = parts.join(', ');
    }
    
    emit('update:modelValue', newLocation);
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <!-- Nombre del lugar (opcional) -->
        <div v-if="showName" class="space-y-2">
            <Label for="location_name" class="text-sm">Nombre del lugar</Label>
            <Input
                id="location_name"
                :model-value="location.name || ''"
                @update:model-value="updateField('name', $event as string)"
                placeholder="Ej: Campo FECMEgt, Centro de Convenciones..."
            />
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="space-y-2">
                <Label for="city" class="text-sm">Ciudad</Label>
                <Input
                    id="city"
                    :model-value="location.city || ''"
                    @update:model-value="updateField('city', $event as string)"
                    placeholder="Ciudad de México"
                />
            </div>
            <div class="space-y-2">
                <Label for="state" class="text-sm">Estado</Label>
                <Input
                    id="state"
                    :model-value="location.state || ''"
                    @update:model-value="updateField('state', $event as string)"
                    placeholder="CDMX"
                />
            </div>
            <div class="space-y-2">
                <Label for="country" class="text-sm">País</Label>
                <Input
                    id="country"
                    :model-value="location.country || 'México'"
                    @update:model-value="updateField('country', $event as string)"
                    placeholder="México"
                />
            </div>
        </div>

        <div class="space-y-2">
            <Label for="address" class="text-sm">Dirección completa</Label>
            <Input
                id="address"
                :model-value="location.address || location.fullAddress || ''"
                @update:model-value="updateField('fullAddress', $event as string); updateField('address', $event as string)"
                placeholder="Dirección completa del lugar"
            />
            <p class="text-xs text-muted-foreground">
                Se genera automáticamente: {{ location.fullAddress || 'Ciudad, Estado, País' }}
            </p>
        </div>

        <div class="space-y-2">
            <Label for="mapUrl" class="text-sm">URL del mapa (Google Maps embed)</Label>
            <Textarea
                id="mapUrl"
                :model-value="location.mapUrl || ''"
                @update:model-value="updateField('mapUrl', $event as string)"
                placeholder="https://www.google.com/maps/embed?pb=..."
                :rows="2"
                class="font-mono text-xs"
            />
            <p class="text-xs text-muted-foreground">
                Puedes obtener este enlace desde Google Maps → Compartir → Insertar un mapa
            </p>
        </div>
    </div>
</template>



