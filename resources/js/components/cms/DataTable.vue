<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Link } from '@inertiajs/vue3';
import { Edit, Plus, Trash2 } from 'lucide-vue-next';

export interface Column {
    key: string;
    label: string;
    sortable?: boolean;
    class?: string;
}

interface Props {
    columns: Column[];
    data: any[];
    createRoute?: string;
    editRoute?: string;
    deleteRoute?: string;
    title: string;
    createLabel?: string;
}

const props = withDefaults(defineProps<Props>(), {
    createLabel: 'Crear nuevo',
});

const emit = defineEmits<{
    delete: [id: number];
}>();

const getValue = (item: any, key: string) => {
    const keys = key.split('.');
    let value = item;
    for (const k of keys) {
        value = value?.[k];
    }
    return value;
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight">{{ title }}</h2>
            <Link v-if="createRoute" :href="createRoute">
                <Button>
                    <Plus class="mr-2 h-4 w-4" />
                    {{ createLabel }}
                </Button>
            </Link>
        </div>

        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead
                            v-for="column in columns"
                            :key="column.key"
                            :class="column.class"
                        >
                            {{ column.label }}
                        </TableHead>
                        <TableHead class="w-[100px]">Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="item in data" :key="item.id">
                        <TableCell
                            v-for="column in columns"
                            :key="column.key"
                            :class="column.class"
                        >
                            <slot :name="`cell-${column.key}`" :item="item" :value="getValue(item, column.key)">
                                {{ getValue(item, column.key) }}
                            </slot>
                        </TableCell>
                        <TableCell>
                            <div class="flex items-center gap-2">
                                <Link
                                    v-if="editRoute"
                                    :href="editRoute.replace(':id', item.id)"
                                >
                                    <Button variant="ghost" size="icon">
                                        <Edit class="h-4 w-4" />
                                    </Button>
                                </Link>
                                <Button
                                    v-if="deleteRoute"
                                    variant="ghost"
                                    size="icon"
                                    class="text-destructive hover:text-destructive"
                                    @click="$emit('delete', item.id)"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </Button>
                            </div>
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="data.length === 0">
                        <TableCell :colspan="columns.length + 1" class="text-center py-8 text-muted-foreground">
                            No hay registros
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>



