<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Award, Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Certification {
    name: string;
    status: string;
    date: string;
    icon: string;
}

interface Props {
    modelValue: Certification[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Certificaciones',
});

const emit = defineEmits<{
    'update:modelValue': [value: Certification[]];
}>();

const statusOptions = [
    { value: 'Certificado', label: 'Certificado' },
    { value: 'Certificada', label: 'Certificada' },
    { value: 'Reconocido', label: 'Reconocido' },
    { value: 'Reconocida', label: 'Reconocida' },
    { value: 'En proceso', label: 'En proceso' },
    { value: 'Pendiente', label: 'Pendiente' },
];

const iconOptions = [
    { value: 'icon-certificate', label: 'Certificado' },
    { value: 'icon-star', label: 'Estrella' },
    { value: 'icon-check', label: 'Check' },
    { value: 'icon-heart', label: 'Corazón' },
    { value: 'icon-award', label: 'Premio' },
];

const certifications = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addCertification = () => {
    certifications.value = [...certifications.value, { 
        name: '', 
        status: 'Certificado', 
        date: new Date().getFullYear().toString(), 
        icon: 'icon-certificate' 
    }];
};

const removeCertification = (index: number) => {
    const newCerts = [...certifications.value];
    newCerts.splice(index, 1);
    certifications.value = newCerts;
};

const updateCertification = (index: number, field: keyof Certification, value: string) => {
    const newCerts = [...certifications.value];
    newCerts[index] = { ...newCerts[index], [field]: value };
    certifications.value = newCerts;
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
                @click="addCertification"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar certificación
            </Button>
        </div>

        <div v-if="certifications.length === 0" class="text-sm text-muted-foreground py-6 text-center border border-dashed rounded-lg">
            <Award class="h-8 w-8 mx-auto mb-2 opacity-50" />
            <p>No hay certificaciones registradas.</p>
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="(cert, index) in certifications"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium">Certificación #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeCertification(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-2 sm:col-span-2">
                        <Label class="text-sm">Nombre de la certificación</Label>
                        <Input
                            :model-value="cert.name"
                            @update:model-value="updateCertification(index, 'name', $event as string)"
                            placeholder="Ej: CPRI - Certificación de Criadero"
                        />
                    </div>
                    
                    <div class="space-y-2">
                        <Label class="text-sm">Estado</Label>
                        <Select
                            :model-value="cert.status"
                            @update:model-value="updateCertification(index, 'status', $event as string)"
                        >
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem 
                                    v-for="status in statusOptions" 
                                    :key="status.value" 
                                    :value="status.value"
                                >
                                    {{ status.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div class="space-y-2">
                        <Label class="text-sm">Año</Label>
                        <Input
                            :model-value="cert.date"
                            @update:model-value="updateCertification(index, 'date', $event as string)"
                            placeholder="2024"
                        />
                    </div>

                    <div class="space-y-2">
                        <Label class="text-sm">Ícono</Label>
                        <Select
                            :model-value="cert.icon"
                            @update:model-value="updateCertification(index, 'icon', $event as string)"
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
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ certifications.length }} certificación(es)
        </p>
    </div>
</template>

