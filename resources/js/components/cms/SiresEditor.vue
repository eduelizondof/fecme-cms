<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import TagsInput from '@/components/cms/TagsInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Sire {
    name: string;
    image: string;
    pedigree: string;
    achievements: string[];
}

interface Props {
    modelValue: Sire[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Sementales',
});

const emit = defineEmits<{
    'update:modelValue': [value: Sire[]];
}>();

const sires = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addSire = () => {
    sires.value = [...sires.value, { name: '', image: '', pedigree: '', achievements: [] }];
};

const removeSire = (index: number) => {
    const newSires = [...sires.value];
    newSires.splice(index, 1);
    sires.value = newSires;
};

const updateSire = (index: number, field: keyof Sire, value: any) => {
    const newSires = [...sires.value];
    newSires[index] = { ...newSires[index], [field]: value };
    sires.value = newSires;
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
                @click="addSire"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar semental
            </Button>
        </div>

        <div v-if="sires.length === 0" class="text-sm text-muted-foreground py-6 text-center border border-dashed rounded-lg">
            <p>No hay sementales registrados.</p>
            <p class="text-xs mt-1">Agrega los sementales destacados del criadero.</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(sire, index) in sires"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3 pb-2 border-b">
                    <span class="text-sm font-medium">Semental #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeSire(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="space-y-4 sm:col-span-2">
                        <div class="space-y-2">
                            <Label class="text-sm">Nombre</Label>
                            <Input
                                :model-value="sire.name"
                                @update:model-value="updateSire(index, 'name', $event)"
                                placeholder="Ej: Royal Champion Maximus"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label class="text-sm">Número de Pedigree</Label>
                            <Input
                                :model-value="sire.pedigree"
                                @update:model-value="updateSire(index, 'pedigree', $event)"
                                placeholder="Ej: FECME-2020-001"
                            />
                        </div>

                        <TagsInput
                            :model-value="sire.achievements"
                            @update:model-value="updateSire(index, 'achievements', $event)"
                            label="Logros / Títulos"
                            placeholder="Agregar logro..."
                        />
                    </div>

                    <div>
                        <ImagePicker
                            :model-value="sire.image"
                            @update:model-value="updateSire(index, 'image', $event)"
                            label="Foto"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ sires.length }} semental(es)
        </p>
    </div>
</template>



