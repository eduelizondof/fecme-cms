<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Award, Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface AwardItem {
    title: string;
    organization: string;
    year: string;
    image: string;
}

interface Props {
    modelValue: AwardItem[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Premios y reconocimientos',
});

const emit = defineEmits<{
    'update:modelValue': [value: AwardItem[]];
}>();

const awards = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addAward = () => {
    awards.value = [...awards.value, { 
        title: '', 
        organization: '', 
        year: new Date().getFullYear().toString(), 
        image: '' 
    }];
};

const removeAward = (index: number) => {
    const newAwards = [...awards.value];
    newAwards.splice(index, 1);
    awards.value = newAwards;
};

const updateAward = (index: number, field: keyof AwardItem, value: string) => {
    const newAwards = [...awards.value];
    newAwards[index] = { ...newAwards[index], [field]: value };
    awards.value = newAwards;
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
                @click="addAward"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar premio
            </Button>
        </div>

        <div v-if="awards.length === 0" class="text-sm text-muted-foreground py-6 text-center border border-dashed rounded-lg">
            <Award class="h-8 w-8 mx-auto mb-2 opacity-50" />
            <p>No hay premios registrados.</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(award, index) in awards"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3 pb-2 border-b">
                    <span class="text-sm font-medium">Premio #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeAward(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="space-y-4 sm:col-span-2">
                        <div class="space-y-2">
                            <Label class="text-sm">Título del premio</Label>
                            <Input
                                :model-value="award.title"
                                @update:model-value="updateAward(index, 'title', $event as string)"
                                placeholder="Ej: Mejor Criadero del Año"
                            />
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <Label class="text-sm">Organización</Label>
                                <Input
                                    :model-value="award.organization"
                                    @update:model-value="updateAward(index, 'organization', $event as string)"
                                    placeholder="Ej: FECMEgt"
                                />
                            </div>
                            <div class="space-y-2">
                                <Label class="text-sm">Año</Label>
                                <Input
                                    :model-value="award.year"
                                    @update:model-value="updateAward(index, 'year', $event as string)"
                                    placeholder="2024"
                                />
                            </div>
                        </div>
                    </div>

                    <div>
                        <ImagePicker
                            :model-value="award.image"
                            @update:model-value="updateAward(index, 'image', $event as string)"
                            label="Imagen (opcional)"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ awards.length }} premio(s)
        </p>
    </div>
</template>

