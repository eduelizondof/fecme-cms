<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { computed } from 'vue';

interface Responsible {
    name: string;
    registration: string;
    certification: string;
    image?: string;
    bio: string;
}

interface Props {
    modelValue: Responsible | null;
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: 'Responsable',
});

const emit = defineEmits<{
    'update:modelValue': [value: Responsible | null];
}>();

const responsible = computed({
    get: () => props.modelValue || {
        name: '',
        registration: '',
        certification: '',
        image: '',
        bio: '',
    },
    set: (value) => emit('update:modelValue', value),
});

const updateField = (field: keyof Responsible, value: string) => {
    emit('update:modelValue', { ...responsible.value, [field]: value });
};
</script>

<template>
    <div class="space-y-4">
        <Label v-if="label" class="text-base font-medium">{{ label }}</Label>

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="space-y-4 sm:col-span-2">
                <div class="space-y-2">
                    <Label for="responsible_name" class="text-sm">Nombre completo</Label>
                    <Input
                        id="responsible_name"
                        :model-value="responsible.name"
                        @update:model-value="updateField('name', $event as string)"
                        placeholder="Ej: Lic. María González"
                    />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <Label for="responsible_registration" class="text-sm">Número de registro</Label>
                        <Input
                            id="responsible_registration"
                            :model-value="responsible.registration"
                            @update:model-value="updateField('registration', $event as string)"
                            placeholder="Ej: CPRG-2020-001"
                        />
                    </div>
                    <div class="space-y-2">
                        <Label for="responsible_certification" class="text-sm">Certificación</Label>
                        <Input
                            id="responsible_certification"
                            :model-value="responsible.certification"
                            @update:model-value="updateField('certification', $event as string)"
                            placeholder="Ej: Criador Certificado desde 2020"
                        />
                    </div>
                </div>

                <div class="space-y-2">
                    <Label for="responsible_bio" class="text-sm">Biografía</Label>
                    <Textarea
                        id="responsible_bio"
                        :model-value="responsible.bio"
                        @update:model-value="updateField('bio', $event as string)"
                        placeholder="Breve biografía o descripción del responsable..."
                        :rows="3"
                    />
                </div>
            </div>

            <div>
                <ImagePicker
                    :model-value="responsible.image || ''"
                    @update:model-value="updateField('image', $event as string)"
                    label="Foto"
                />
            </div>
        </div>
    </div>
</template>



