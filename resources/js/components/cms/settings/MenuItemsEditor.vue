<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Plus, Trash2, ChevronDown, ChevronRight } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface MenuAction {
    href: string;
    type: 'link' | 'file';
    target: '_self' | '_blank';
}

interface MenuItem {
    label: string;
    action: MenuAction;
    children?: MenuItem[];
    isDropdown: boolean;
    showOnFooter: boolean;
}

interface Props {
    modelValue?: MenuItem[];
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
});

const emit = defineEmits<{
    'update:modelValue': [value: MenuItem[]];
}>();

const menuItems = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const expandedItems = ref<Set<number>>(new Set());

const toggleExpand = (index: number) => {
    if (expandedItems.value.has(index)) {
        expandedItems.value.delete(index);
    } else {
        expandedItems.value.add(index);
    }
};

const addMenuItem = () => {
    menuItems.value = [
        ...menuItems.value,
        {
            label: '',
            action: { href: '#', type: 'link', target: '_self' },
            children: [],
            isDropdown: false,
            showOnFooter: false,
        },
    ];
};

const removeMenuItem = (index: number) => {
    menuItems.value = menuItems.value.filter((_, i) => i !== index);
};

const addChildItem = (parentIndex: number) => {
    const updated = [...menuItems.value];
    if (!updated[parentIndex].children) {
        updated[parentIndex].children = [];
    }
    updated[parentIndex].children!.push({
        label: '',
        action: { href: '#', type: 'link', target: '_self' },
        isDropdown: false,
        showOnFooter: false,
    });
    menuItems.value = updated;
};

const removeChildItem = (parentIndex: number, childIndex: number) => {
    const updated = [...menuItems.value];
    if (updated[parentIndex].children) {
        updated[parentIndex].children = updated[parentIndex].children!.filter((_, i) => i !== childIndex);
        if (updated[parentIndex].children.length === 0) {
            updated[parentIndex].isDropdown = false;
        }
    }
    menuItems.value = updated;
};

const updateMenuItem = (index: number, field: keyof MenuItem, value: any) => {
    const updated = [...menuItems.value];
    updated[index] = { ...updated[index], [field]: value };
    
    // Si se desactiva el dropdown, limpiar children
    if (field === 'isDropdown' && !value) {
        updated[index].children = [];
    }
    
    // Si hay children, forzar isDropdown a true
    if (updated[index].children && updated[index].children.length > 0) {
        updated[index].isDropdown = true;
    }
    
    menuItems.value = updated;
};

const updateMenuAction = (index: number, field: keyof MenuAction, value: string) => {
    const updated = [...menuItems.value];
    updated[index].action = { ...updated[index].action, [field]: value };
    menuItems.value = updated;
};

const updateChildItem = (parentIndex: number, childIndex: number, field: keyof MenuItem, value: any) => {
    const updated = [...menuItems.value];
    if (updated[parentIndex].children) {
        updated[parentIndex].children![childIndex] = {
            ...updated[parentIndex].children![childIndex],
            [field]: value,
        };
        menuItems.value = updated;
    }
};

const updateChildAction = (parentIndex: number, childIndex: number, field: keyof MenuAction, value: string) => {
    const updated = [...menuItems.value];
    if (updated[parentIndex].children) {
        updated[parentIndex].children![childIndex].action = {
            ...updated[parentIndex].children![childIndex].action,
            [field]: value,
        };
        menuItems.value = updated;
    }
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label>Elementos del menú</Label>
            <Button type="button" variant="outline" size="sm" @click="addMenuItem">
                <Plus class="mr-2 h-4 w-4" />
                Agregar elemento
            </Button>
        </div>

        <div v-if="menuItems.length === 0" class="text-sm text-muted-foreground py-4 text-center">
            No hay elementos en el menú. Haz clic en "Agregar elemento" para comenzar.
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(item, index) in menuItems"
                :key="index"
                class="rounded-lg border p-4 space-y-4"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Button
                            v-if="item.isDropdown || (item.children && item.children.length > 0)"
                            type="button"
                            variant="ghost"
                            size="icon"
                            @click="toggleExpand(index)"
                        >
                            <ChevronDown v-if="expandedItems.has(index)" class="h-4 w-4" />
                            <ChevronRight v-else class="h-4 w-4" />
                        </Button>
                        <Label class="text-base">Elemento {{ index + 1 }}</Label>
                    </div>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        @click="removeMenuItem(index)"
                    >
                        <Trash2 class="h-4 w-4 text-destructive" />
                    </Button>
                </div>

                <div class="space-y-4 pl-6">
                    <div class="space-y-2">
                        <Label>Etiqueta (Label) *</Label>
                        <Input
                            :model-value="item.label"
                            placeholder="Nosotros"
                            @update:model-value="updateMenuItem(index, 'label', $event as string)"
                        />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-2">
                            <Label>Enlace (href) *</Label>
                            <Input
                                :model-value="item.action.href"
                                placeholder="/about"
                                @update:model-value="updateMenuAction(index, 'href', $event as string)"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label>Tipo</Label>
                            <select
                                :value="item.action.type"
                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                                @change="updateMenuAction(index, 'type', ($event.target as HTMLSelectElement).value as 'link' | 'file')"
                            >
                                <option value="link">Enlace</option>
                                <option value="file">Archivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label>Target</Label>
                        <select
                            :value="item.action.target"
                            class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                            @change="updateMenuAction(index, 'target', ($event.target as HTMLSelectElement).value as '_self' | '_blank')"
                        >
                            <option value="_self">Misma ventana</option>
                            <option value="_blank">Nueva ventana</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox
                            :checked="item.isDropdown"
                            :disabled="item.children && item.children.length > 0"
                            @update:checked="updateMenuItem(index, 'isDropdown', $event)"
                        />
                        <Label class="cursor-pointer">Menú desplegable (dropdown)</Label>
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox
                            :checked="item.showOnFooter"
                            @update:checked="updateMenuItem(index, 'showOnFooter', $event)"
                        />
                        <Label class="cursor-pointer">Mostrar en footer</Label>
                    </div>

                    <!-- Children -->
                    <div v-if="item.isDropdown || (item.children && item.children.length > 0)" class="space-y-4">
                        <div class="flex items-center justify-between">
                            <Label class="text-sm font-medium">Submenú</Label>
                            <Button type="button" variant="outline" size="sm" @click="addChildItem(index)">
                                <Plus class="mr-2 h-4 w-4" />
                                Agregar subelemento
                            </Button>
                        </div>

                        <div
                            v-if="expandedItems.has(index) && item.children && item.children.length > 0"
                            class="space-y-3 pl-4 border-l-2"
                        >
                            <div
                                v-for="(child, childIndex) in item.children"
                                :key="childIndex"
                                class="rounded border p-3 space-y-3"
                            >
                                <div class="flex items-center justify-between">
                                    <Label class="text-sm">Subelemento {{ childIndex + 1 }}</Label>
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="icon"
                                        @click="removeChildItem(index, childIndex)"
                                    >
                                        <Trash2 class="h-3 w-3 text-destructive" />
                                    </Button>
                                </div>

                                <div class="space-y-2">
                                    <Label class="text-xs">Etiqueta *</Label>
                                    <Input
                                        :model-value="child.label"
                                        placeholder="Subelemento"
                                        class="text-sm"
                                        @update:model-value="updateChildItem(index, childIndex, 'label', $event as string)"
                                    />
                                </div>

                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label class="text-xs">Enlace *</Label>
                                        <Input
                                            :model-value="child.action.href"
                                            placeholder="/subpagina"
                                            class="text-sm"
                                            @update:model-value="updateChildAction(index, childIndex, 'href', $event as string)"
                                        />
                                    </div>

                                    <div class="space-y-2">
                                        <Label class="text-xs">Tipo</Label>
                                        <select
                                            :value="child.action.type"
                                            class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-xs shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                                            @change="updateChildAction(index, childIndex, 'type', ($event.target as HTMLSelectElement).value as 'link' | 'file')"
                                        >
                                            <option value="link">Enlace</option>
                                            <option value="file">Archivo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label class="text-xs">Target</Label>
                                        <select
                                            :value="child.action.target"
                                            class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-xs shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                                            @change="updateChildAction(index, childIndex, 'target', ($event.target as HTMLSelectElement).value as '_self' | '_blank')"
                                        >
                                            <option value="_self">Misma ventana</option>
                                            <option value="_blank">Nueva ventana</option>
                                        </select>
                                    </div>

                                    <div class="flex items-center gap-2 pt-6">
                                        <Checkbox
                                            :checked="child.showOnFooter"
                                            @update:checked="updateChildItem(index, childIndex, 'showOnFooter', $event)"
                                        />
                                        <Label class="text-xs cursor-pointer">Mostrar en footer</Label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
