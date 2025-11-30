<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { computed, watch } from 'vue';

interface LogoData {
    src?: string;
    alt?: string;
    title?: string;
    href?: string;
    width?: string;
    height?: string;
}

interface Props {
    modelValue?: LogoData | null;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => ({ src: '', alt: '', title: '', href: '/', width: '', height: '' }),
});

const emit = defineEmits<{
    'update:modelValue': [value: LogoData];
}>();

const logo = computed({
    get: () => {
        const defaultVal = { src: '', alt: '', title: '', href: '/', width: '', height: '' };
        return props.modelValue || defaultVal;
    },
    set: (value) => {
        // Asegurar que nunca se emita null
        emit('update:modelValue', value || { src: '', alt: '', title: '', href: '/', width: '', height: '' });
    },
});

const updateField = (field: keyof LogoData, value: string) => {
    logo.value = { ...logo.value, [field]: value };
};

watch(() => logo.value.src, (newSrc) => {
    if (newSrc && !logo.value.alt) {
        updateField('alt', 'Logo');
    }
});
</script>

<template>
    <div class="space-y-4">
        <div class="space-y-2">
            <Label>Imagen del logo *</Label>
            <ImagePicker
                :model-value="logo.src || ''"
                label=""
                placeholder="URL de la imagen del logo"
                @update:model-value="updateField('src', $event || '')"
            />
            <p v-if="logo.src" class="text-xs text-muted-foreground">
                {{ logo.src }}
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="space-y-2">
                <Label for="logo-alt">Texto alternativo (alt)</Label>
                <Input
                    id="logo-alt"
                    :model-value="logo.alt"
                    placeholder="Texto alternativo"
                    @update:model-value="updateField('alt', $event as string)"
                />
            </div>

            <div class="space-y-2">
                <Label for="logo-title">Título</Label>
                <Input
                    id="logo-title"
                    :model-value="logo.title"
                    placeholder="Título del logo"
                    @update:model-value="updateField('title', $event as string)"
                />
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="space-y-2">
                <Label for="logo-href">Enlace (href)</Label>
                <Input
                    id="logo-href"
                    :model-value="logo.href"
                    placeholder="/"
                    @update:model-value="updateField('href', $event as string)"
                />
            </div>

            <div class="space-y-2">
                <Label for="logo-width">Ancho (width)</Label>
                <Input
                    id="logo-width"
                    :model-value="logo.width"
                    placeholder="150"
                    @update:model-value="updateField('width', $event as string)"
                />
            </div>

            <div class="space-y-2">
                <Label for="logo-height">Alto (height)</Label>
                <Input
                    id="logo-height"
                    :model-value="logo.height"
                    placeholder="150"
                    @update:model-value="updateField('height', $event as string)"
                />
            </div>
        </div>
    </div>
</template>
