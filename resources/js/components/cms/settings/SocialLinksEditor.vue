<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface SocialLink {
    href: string;
    icon: string;
    name: string;
    showOnFooter: boolean;
}

interface Props {
    modelValue?: SocialLink[];
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
});

const emit = defineEmits<{
    'update:modelValue': [value: SocialLink[]];
}>();

const socialLinks = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addSocialLink = () => {
    socialLinks.value = [
        ...socialLinks.value,
        {
            href: '',
            icon: 'fa-facebook-square',
            name: '',
            showOnFooter: true,
        },
    ];
};

const removeSocialLink = (index: number) => {
    socialLinks.value = socialLinks.value.filter((_, i) => i !== index);
};

const updateSocialLink = (index: number, field: keyof SocialLink, value: string | boolean) => {
    const updated = [...socialLinks.value];
    updated[index] = { ...updated[index], [field]: value };
    socialLinks.value = updated;
};

const iconOptions = [
    { value: 'fa-facebook-square', label: 'Facebook' },
    { value: 'fa-x-twitter', label: 'Twitter/X' },
    { value: 'fa-instagram', label: 'Instagram' },
    { value: 'fa-youtube', label: 'YouTube' },
    { value: 'fa-linkedin', label: 'LinkedIn' },
    { value: 'fa-whatsapp', label: 'WhatsApp' },
    { value: 'fa-telegram', label: 'Telegram' },
    { value: 'fa-tiktok', label: 'TikTok' },
];
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label>Redes sociales</Label>
            <Button type="button" variant="outline" size="sm" @click="addSocialLink">
                <Plus class="mr-2 h-4 w-4" />
                Agregar red social
            </Button>
        </div>

        <div v-if="socialLinks.length === 0" class="text-sm text-muted-foreground py-4 text-center">
            No hay redes sociales configuradas. Haz clic en "Agregar red social" para comenzar.
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(link, index) in socialLinks"
                :key="index"
                class="rounded-lg border p-4 space-y-4"
            >
                <div class="flex items-center justify-between">
                    <Label class="text-base">Red social {{ index + 1 }}</Label>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        @click="removeSocialLink(index)"
                    >
                        <Trash2 class="h-4 w-4 text-destructive" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <Label>Nombre *</Label>
                        <Input
                            :model-value="link.name"
                            placeholder="Facebook"
                            @update:model-value="updateSocialLink(index, 'name', $event as string)"
                        />
                    </div>

                    <div class="space-y-2">
                        <Label>Icono (FontAwesome) *</Label>
                        <select
                            :value="link.icon"
                            class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                            @change="updateSocialLink(index, 'icon', ($event.target as HTMLSelectElement).value)"
                        >
                            <option v-for="icon in iconOptions" :key="icon.value" :value="icon.value">
                                {{ icon.label }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <Label>URL *</Label>
                    <Input
                        :model-value="link.href"
                        placeholder="https://www.facebook.com/pagina"
                        @update:model-value="updateSocialLink(index, 'href', $event as string)"
                    />
                </div>

                <div class="flex items-center gap-2">
                    <Checkbox
                        :checked="link.showOnFooter"
                        @update:checked="updateSocialLink(index, 'showOnFooter', $event)"
                    />
                    <Label class="cursor-pointer">Mostrar en footer</Label>
                </div>
            </div>
        </div>
    </div>
</template>
