<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

interface Props {
    open: boolean;
    title?: string;
    description?: string;
    deleteUrl?: string;
}

const props = withDefaults(defineProps<Props>(), {
    title: '¿Estás seguro?',
    description: 'Esta acción no se puede deshacer. Se eliminará permanentemente este registro.',
});

const emit = defineEmits<{
    'update:open': [value: boolean];
    confirm: [];
}>();

const isDeleting = ref(false);

const form = useForm({});

const handleConfirm = () => {
    if (props.deleteUrl) {
        isDeleting.value = true;
        form.delete(props.deleteUrl, {
            onSuccess: () => {
                emit('update:open', false);
            },
            onFinish: () => {
                isDeleting.value = false;
            },
        });
    } else {
        emit('confirm');
        emit('update:open', false);
    }
};

const handleOpenChange = (value: boolean) => {
    emit('update:open', value);
};
</script>

<template>
    <Dialog :open="open" @update:open="handleOpenChange">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription>{{ description }}</DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button
                    variant="outline"
                    @click="handleOpenChange(false)"
                    :disabled="isDeleting"
                >
                    Cancelar
                </Button>
                <Button
                    variant="destructive"
                    @click="handleConfirm"
                    :disabled="isDeleting"
                >
                    {{ isDeleting ? 'Eliminando...' : 'Eliminar' }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>



