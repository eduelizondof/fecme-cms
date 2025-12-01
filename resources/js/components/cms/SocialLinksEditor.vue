<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface SocialLink {
    platform: string;
    url: string;
    icon: string;
}

interface Props {
    modelValue: SocialLink[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Redes sociales',
});

const emit = defineEmits<{
    'update:modelValue': [value: SocialLink[]];
}>();

const platforms = [
    { value: 'facebook', label: 'Facebook', icon: 'fa fa-facebook' },
    { value: 'instagram', label: 'Instagram', icon: 'fa fa-instagram' },
    { value: 'twitter', label: 'Twitter/X', icon: 'fa fa-twitter' },
    { value: 'youtube', label: 'YouTube', icon: 'fa fa-youtube' },
    { value: 'tiktok', label: 'TikTok', icon: 'fa fa-tiktok' },
    { value: 'linkedin', label: 'LinkedIn', icon: 'fa fa-linkedin' },
    { value: 'whatsapp', label: 'WhatsApp', icon: 'fa fa-whatsapp' },
    { value: 'other', label: 'Otro', icon: 'fa fa-link' },
];

const links = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addLink = () => {
    links.value = [...links.value, { platform: 'facebook', url: '', icon: 'fa fa-facebook' }];
};

const removeLink = (index: number) => {
    const newLinks = [...links.value];
    newLinks.splice(index, 1);
    links.value = newLinks;
};

const updateLink = (index: number, field: keyof SocialLink, value: string) => {
    const newLinks = [...links.value];
    newLinks[index] = { ...newLinks[index], [field]: value };
    
    // Auto-set icon when platform changes
    if (field === 'platform') {
        const platform = platforms.find(p => p.value === value);
        if (platform) {
            newLinks[index].icon = platform.icon;
        }
    }
    
    links.value = newLinks;
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
                @click="addLink"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar red social
            </Button>
        </div>

        <div v-if="links.length === 0" class="text-sm text-muted-foreground py-4 text-center border border-dashed rounded-lg">
            No hay redes sociales configuradas.
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="(link, index) in links"
                :key="index"
                class="flex items-center gap-3 p-3 border rounded-lg"
            >
                <div class="w-40">
                    <Select
                        :model-value="link.platform"
                        @update:model-value="updateLink(index, 'platform', $event as string)"
                    >
                        <SelectTrigger>
                            <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem 
                                v-for="platform in platforms" 
                                :key="platform.value" 
                                :value="platform.value"
                            >
                                {{ platform.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <Input
                    :model-value="link.url"
                    @update:model-value="updateLink(index, 'url', $event as string)"
                    placeholder="https://..."
                    class="flex-1"
                />

                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    class="h-8 w-8 text-muted-foreground hover:text-destructive"
                    @click="removeLink(index)"
                >
                    <Trash2 class="h-4 w-4" />
                </Button>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ links.length }} red(es) social(es)
        </p>
    </div>
</template>


