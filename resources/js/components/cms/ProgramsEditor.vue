<script setup lang="ts">
import ImagePicker from '@/components/cms/ImagePicker.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Program {
    name: string;
    image: string;
    description: string;
    duration: string;
    price: number;
}

interface Props {
    modelValue: Program[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Programas',
});

const emit = defineEmits<{
    'update:modelValue': [value: Program[]];
}>();

const programs = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addProgram = () => {
    programs.value = [...programs.value, { 
        name: '', 
        image: '', 
        description: '', 
        duration: '', 
        price: 0 
    }];
};

const removeProgram = (index: number) => {
    const newPrograms = [...programs.value];
    newPrograms.splice(index, 1);
    programs.value = newPrograms;
};

const updateProgram = (index: number, field: keyof Program, value: any) => {
    const newPrograms = [...programs.value];
    newPrograms[index] = { ...newPrograms[index], [field]: value };
    programs.value = newPrograms;
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
                @click="addProgram"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar programa
            </Button>
        </div>

        <div v-if="programs.length === 0" class="text-sm text-muted-foreground py-6 text-center border border-dashed rounded-lg">
            <p>No hay programas registrados.</p>
            <p class="text-xs mt-1">Agrega los programas de formación o entrenamiento que ofreces.</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(program, index) in programs"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3 pb-2 border-b">
                    <span class="text-sm font-medium">Programa #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeProgram(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="space-y-4 sm:col-span-2">
                        <div class="space-y-2">
                            <Label class="text-sm">Nombre del programa</Label>
                            <Input
                                :model-value="program.name"
                                @update:model-value="updateProgram(index, 'name', $event)"
                                placeholder="Ej: Adiestramiento Básico"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label class="text-sm">Descripción</Label>
                            <Textarea
                                :model-value="program.description"
                                @update:model-value="updateProgram(index, 'description', $event)"
                                placeholder="Describe el programa..."
                                :rows="2"
                            />
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <Label class="text-sm">Duración</Label>
                                <Input
                                    :model-value="program.duration"
                                    @update:model-value="updateProgram(index, 'duration', $event)"
                                    placeholder="Ej: 8 semanas"
                                />
                            </div>
                            <div class="space-y-2">
                                <Label class="text-sm">Precio (MXN)</Label>
                                <Input
                                    type="number"
                                    min="0"
                                    :model-value="program.price"
                                    @update:model-value="updateProgram(index, 'price', Number($event) || 0)"
                                    placeholder="0"
                                />
                            </div>
                        </div>
                    </div>

                    <div>
                        <ImagePicker
                            :model-value="program.image"
                            @update:model-value="updateProgram(index, 'image', $event)"
                            label="Imagen"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ programs.length }} programa(s)
        </p>
    </div>
</template>



